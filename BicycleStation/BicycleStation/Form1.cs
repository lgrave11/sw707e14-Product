﻿using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Web.Helpers;
using System.Threading;
using System.Net;

namespace BicycleStation
{
    public partial class Form1 : Form
    {
        //Timer duration
        const int MAXTIME = 10;

        //Time before a booking the bike can be unlocked
        const int TIMEBEFORE = 3600;

        //Slidebar values
        const int LOCKED = 0;
        const int UNLOCKED = 1;
        const int NOBICYCLE = 2;

        //number of bicycles in the system
        const int NUMBEROFBICYCLES = 178;

        List<UnlockedBooking> lastUnlocked = new List<UnlockedBooking>();

        int _maxTime = MAXTIME;

        public Form1()
        {
            InitializeComponent();
            DatabaseConnection DB = new DatabaseConnection();

            //loads stations from Database into component
            string[] stations = (from c in DB.station
                                  select c.name).ToArray();
            StationNameDropDown.Items.AddRange(stations);
            StationNameDropDown.SelectedItem = stations[0];

            //Creates service thread
            //Reports data changes to global database
            Thread reporter = new Thread(new ThreadStart(ServiceThreads.reportActions));
            reporter.Start();

            foreach (station s in DB.station.Select(x => x).ToList())
            {
                int[] bicycles = DB.dock.Where(x => x.station_id == s.station_id && x.holds_bicycle > 0).Select(x => x.holds_bicycle).ToArray();
                int numFree = DB.dock.Where(x => x.station_id == s.station_id && x.holds_bicycle == 0).Count();
                GlobalVariable.ActionQueue.Enqueue(() => ServiceThreads.syncDockStatus(bicycles, numFree, s.station_id));
            }
        }

        //Timer for booking unlock window, invisible to users
        private void lockTimer_Tick(object sender, EventArgs e)
        {
            if (_maxTime == 0)
            {
                lockTimer.Stop();
                _maxTime = MAXTIME;

                TakeItPanel.Visible = false;
                TakeItPanel.SendToBack();

                passwordTB.Text = "Password";
                EnterPwPanel.BringToFront();
                EnterPwPanel.Visible = true;

                //updates UI to reflect changes caused during unlock
                updateLabels();
                UpdateDockValues();
            }
            else
            {
                _maxTime--;
            }
        }

        //Station selector event handler
        private void StationNameDropDown_SelectedIndexChanged(object sender, EventArgs e)
        {
            //Update locked/available labels
            updateLabels();

            //Updates slide bar through another event handler
            UpdateDockValues();
        }

        //Password input field
        private void passwordTB_Click(object sender, EventArgs e)
        {
            //removes default value if that is currently in the field
            if (passwordTB.Text == "Password")
            {
                passwordTB.Clear();
            }
        }

        
        private void UnlockBtn_Click(object sender, EventArgs e)
        {
            try
            {
                CheckPassword();
            }
            catch (FormatException){
                IncorrectPWinput.Text = "Password";
                pwPan.SendToBack();
                IncorrectPWpan.BringToFront();
            }
        }

        private void CheckPassword()
        {
            DatabaseConnection DB = new DatabaseConnection();

            //Extracts information from UI
            int pwText = Convert.ToInt32(passwordTB.Text.ToString());
            string stationName = StationNameDropDown.SelectedItem.ToString();

            List<booking> findBookings = (from b in DB.booking
                                          join s in DB.station on b.start_station equals s.station_id
                                          where b.password == pwText && s.name == stationName
                                          select b).ToList();

            //Code accepted if atleast one booking matches. Should always be only 1 if any
            if (findBookings.Count() > 0)
            {
                //Current time in Unix format
                Int32 currentTime = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
                if (findBookings.First().start_time < currentTime + TIMEBEFORE)
                {
                    //Hides the Password input panel
                    EnterPwPanel.Visible = false;
                    EnterPwPanel.SendToBack();

                    //Presents the tale ot panel
                    TakeItPanel.BringToFront();
                    TakeItPanel.Visible = true;

                    lockTimer.Start();

                    booking unlockedBooking = findBookings[0];

                    FindAvailableDock(stationName, unlockedBooking, DB);
                }
                else
                {
                    IncorrectPWinput.Text = "Password";
                    pwPan.SendToBack();
                    IncorrectPWpan.BringToFront();
                }
            }
            else
            {
                IncorrectPWinput.Text = "Password";
                pwPan.SendToBack();
                IncorrectPWpan.BringToFront();
            }
        }

        private void FindAvailableDock(string stationName, booking unlockedBooking, DatabaseConnection DB)
        {


            List<dock> docks = (from d in DB.dock
                                join s in DB.station on d.station_id equals s.station_id
                                where s.name == stationName
                                select d).ToList();
            //Start value -1 as 0 is an index in the dock list, thus a potential result
            int availableDock = -1;
            int i = 0;

            //loop breaks when either no more docks at station or available dock has been found
            while (availableDock < 0 && i < docks.Count)
            {
                //dock is available if it is locked
                if (docks[i].is_locked)
                    availableDock = i;
                i++;
            }
            //Unlocks availble dock if any
            if (availableDock >= 0)
            {
                //Outputs available dock to user
                TakeAtDockLbl.Text = "Take your bicycle at dock " + (availableDock + 1);
                TakeAtDockLbl.Location = new Point((TakeItPanel.Size.Width / 2) - (TakeAtDockLbl.Size.Width / 2), TakeAtDockLbl.Location.Y);
                //Unlocks available dock
                docks[availableDock].is_locked = false;
                DB.SaveChanges();

                //changes dock being displayed in UI and updates values
                DockIdUpDown.Value = availableDock + 1;
                UpdateDockValues();

                Int32 currentTime = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
                lastUnlocked.Add(new UnlockedBooking(unlockedBooking.start_station, docks[availableDock].dock_id, unlockedBooking.booking_id, docks[availableDock].holds_bicycle, currentTime));

                //reports unlock to Global Database interface
                GlobalVariable.ActionQueue.Enqueue(() => ServiceThreads.unlockWithBooking(unlockedBooking.start_station, unlockedBooking.booking_id, docks[availableDock].holds_bicycle));

                DB.booking.Remove(unlockedBooking);
                DB.SaveChanges();
            }
            else
            {
                //should always be a dock available for a booking
                TakeAtDockLbl.Text = "Error with booking";
            }
        }

        private void UnlockMoreBtn_Click(object sender, EventArgs e)
        {
            lockTimer.Stop();
            _maxTime = MAXTIME;
            TimeLbl.Text = "";
            TakeItPanel.Visible = false;
            TakeItPanel.SendToBack();

            passwordTB.Text = "Password";
            EnterPwPanel.BringToFront();
            EnterPwPanel.Visible = true;

            //updates UI to reflect changes caused during unlock
            updateLabels();
            UpdateDockValues();
        }

        //Event handler for change in dock selector
        private void DockIdUpDown_ValueChanged(object sender, EventArgs e)
        {
            UpdateDockValues(); 
        }

        //Created to prevent calling eventhandler from other methods
        private void UpdateDockValues()
        {
            DatabaseConnection DB = new DatabaseConnection();

            //gets name of current station
            string stationName = StationNameDropDown.SelectedItem.ToString();

            //Finds the docks of the currently selected station
            int[] getDocks = (from d in DB.dock
                              join s in DB.station on d.station_id equals s.station_id
                              where s.name == stationName
                              select d.dock_id).ToArray();

            //Id of selected dock
            int docID = getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1];

            //Get the dock object of the selected dock
            dock getDock = (from d in DB.dock
                            where d.dock_id == docID
                            select d).FirstOrDefault();

            UpdateSlideBar(getDock);
        }

        //Updates slide bar to match a dock objects state
        //Also enables/disables buttons appropriately
        private void UpdateSlideBar(dock getDock)
        {
            if (getDock.holds_bicycle == 0)
            {
                DockStateBar.Value = NOBICYCLE;
                TakeBicycleBtn.Enabled = false;
                ReturnBicycleBtn.Enabled = true;
            }
            else if (!(getDock.is_locked))
            {
                DockStateBar.Value = UNLOCKED;
                TakeBicycleBtn.Enabled = true;
                ReturnBicycleBtn.Enabled = false;
            }
            else
            {
                DockStateBar.Value = LOCKED;
                TakeBicycleBtn.Enabled = false;
                ReturnBicycleBtn.Enabled = false;
            }
        }      

        //Sends message to DB interface that a bicycle has been removed from a dock
        //Only Happens on unlocked docks
        private void bicycleTaken(dock Dock, int bicycleId)
        {
            int bookingID = 0;
            Int32 currentTime = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            for (int i = 0; i < lastUnlocked.Count; )
            {
                if (lastUnlocked[i].unlockTime + 300 < currentTime)
                {
                    lastUnlocked.RemoveAt(i);
                }
                else if (lastUnlocked[i].bicycleID == Dock.holds_bicycle)
                {
                    bookingID = lastUnlocked[i].bookingID;
                    lastUnlocked.RemoveAt(i);
                    break;
                }
                else
                    i++;
                
            }
            MessageBox.Show(String.Format("Bicycle {0} taken", bicycleId));
            GlobalVariable.ActionQueue.Enqueue(() => ServiceThreads.bicycleTakenReport(Dock.station_id, bicycleId, bookingID));
        }

        //Sends message to DB interface that a bicycle has been returned to a dock
        private void bicycleReturn(dock Dock)
        {
            GlobalVariable.ActionQueue.Enqueue(() => ServiceThreads.bicycleReturnedReport(Dock.holds_bicycle, Dock.station_id));
        }


        private void TakeBicycleBtn_Click(object sender, EventArgs e)
        {
            DatabaseConnection DB = new DatabaseConnection();
            string stationName = StationNameDropDown.SelectedItem.ToString();

            List<dock> getDocks = (from d in DB.dock
                                   join s in DB.station on d.station_id equals s.station_id
                                   where s.name == stationName
                                   select d).ToList();

            bicycleTaken(getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1], getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1].holds_bicycle);

            //removes bicycle from dock in database
            getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1].holds_bicycle = 0;
            DB.SaveChanges();

            DockStateBar.Value = 2;
            ReturnBicycleBtn.Enabled = true;
            TakeBicycleBtn.Enabled = false;
            updateLabels();
        }


        private void ReturnBicycleBtn_Click(object sender, EventArgs e)
        {
            string stationName = StationNameDropDown.SelectedItem.ToString();
            DatabaseConnection DB = new DatabaseConnection();

            List<dock> getDocks = (from d in DB.dock
                                   join s in DB.station on d.station_id equals s.station_id
                                   where s.name == stationName
                                   select d).ToList();

            //returns bicycle to a dock in database
            //returned bicycle has random ID in simulation
            int returnedBicycle;
            if (!(idTB.Text == String.Empty) && int.TryParse(idTB.Text, out returnedBicycle))
            {
                List<int> usedIDs = (from d in DB.dock
                                     where d.holds_bicycle > 0
                                     select d.holds_bicycle).ToList();
                if (usedIDs.Contains(returnedBicycle))
                {
                    returnedBicycle = getRandomBicycleID(DB);
                    MessageBox.Show("Specified ID in use, using random ID: " + returnedBicycle);
                }
            }
            else returnedBicycle = getRandomBicycleID(DB);

            getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1].holds_bicycle = returnedBicycle;
            DB.SaveChanges();
            bicycleReturn(getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1]);

            DockStateBar.Value = 1;
            TakeBicycleBtn.Enabled = true;
            ReturnBicycleBtn.Enabled = false;
            updateLabels();
        }

        //Generates random bicycle ID not currently in use
        private int getRandomBicycleID(DatabaseConnection DB)
        {
            List<int> availableIDs = new List<int>();

            //Fill list with all possible IDs
            for(int i = 1; i <= NUMBEROFBICYCLES; i++)
                availableIDs.Add(i);

            //Query to find all IDs currently in use
            List<int> usedIDs = (from d in DB.dock
                                where d.holds_bicycle > 0
                                select d.holds_bicycle).ToList();
            //Removes all IDs in use from available list
            foreach(int i in usedIDs)
                availableIDs.Remove(i);

            //Returns random element of the available IDs
            return availableIDs[(new Random()).Next(0, availableIDs.Count())];
        }

        
        private void updateLabels()
        {
            DatabaseConnection DB = new DatabaseConnection();
            string stationName = StationNameDropDown.SelectedItem.ToString();

            List<dock> getDocks = (from d in DB.dock
                                   join s in DB.station on d.station_id equals s.station_id
                                   where s.name == stationName
                                   select d).ToList();
            DockIdUpDown.Maximum = getDocks.Count();
            int locked = 0;
            int unlocked = 0;
            foreach (dock d in getDocks)
            {
                if (d.is_locked)
                    locked++;
                else if (d.holds_bicycle > 0)
                    unlocked++;
            }
            LockednumberLbl.Text = locked.ToString();
            UnlockedNumberLbl.Text = unlocked.ToString();
        }

        //method invoked from threads to update UI
        public void updateUI()
        {
            updateLabels();
            UpdateDockValues();
        }

        //Closes all running threads when UI window is closed
        private void Form1_FormClosing(object sender, FormClosingEventArgs e)
        {
            GlobalVariable.running = false;
        }

        private void btnAdd_Click(object sender, EventArgs e)
        {
            DatabaseConnection DB = new DatabaseConnection();
            dock d = new dock();
            string stationName = StationNameDropDown.SelectedItem.ToString();
            int stationId = DB.station.Where(x => x.name == stationName).Select(x => x.station_id).FirstOrDefault();
            d.is_locked = false;
            d.station_id = stationId;
            d.holds_bicycle = 0;
            DB.dock.Add(d);
            DB.SaveChanges();
            
            int[] bicycleIds = DB.dock.Where(x => x.station_id == stationId && x.holds_bicycle > 0).Select(x => x.holds_bicycle).ToArray();
            int numFree = DB.dock.Where(x => x.station_id == stationId && x.holds_bicycle == 0).Count();
            DB.Dispose();

            GlobalVariable.ActionQueue.Enqueue(() => ServiceThreads.syncDockStatus(bicycleIds, numFree, stationId));
        }

        private void btnRemove_Click(object sender, EventArgs e)
        {
            DatabaseConnection DB = new DatabaseConnection();
            string stationName = StationNameDropDown.SelectedItem.ToString();
            int stationId = DB.station.Where(x => x.name == stationName).Select(x => x.station_id).FirstOrDefault();
            dock d = DB.dock.Where(x => x.station_id == stationId).OrderBy(x => x.dock_id).Skip((int)(DockIdUpDown.Value - 1)).FirstOrDefault();
            DB.dock.Remove(d);
            DB.SaveChanges();

            int[] bicycleIds = DB.dock.Where(x => x.station_id == stationId && x.holds_bicycle > 0).Select(x => x.holds_bicycle).ToArray();
            int numFree = DB.dock.Where(x => x.station_id == stationId && x.holds_bicycle == 0).Count();
            DB.Dispose();
            
            GlobalVariable.ActionQueue.Enqueue(() => ServiceThreads.syncDockStatus(bicycleIds, numFree, stationId));
        }

        /* We cannot run GUI updates in these threads before it has finished loading (shown) */
        private void Form1_Shown(object sender, EventArgs e)
        {
            //Creates a Tcp Listener to run in a different threat
            //Listener listens for messages from the DB connection interface
            MyTcpListener myTcpListener = new MyTcpListener(this);
            Thread tcpListener = new Thread(new ThreadStart(myTcpListener.Listen));
            tcpListener.Start();

            //Creates lockManager thread
            //Locs or unlocks docks based on time of bookings
            LockManager lockManager = new LockManager(this);
            Thread manager = new Thread(new ThreadStart(lockManager.manage));
            manager.Start();
        }

        private void IncorrectPWbtn_Click(object sender, EventArgs e)
        {
            IncorrectPWpan.SendToBack();
            pwPan.BringToFront();
            passwordTB.Text = IncorrectPWlabel.Text;
            IncorrectPWinput.Text = "Password";
            try
            {
                CheckPassword();
            }
            catch (FormatException)
            {
                IncorrectPWinput.Text = "Password";
                pwPan.SendToBack();
                IncorrectPWpan.BringToFront();
            }
        }

        private void IncorrectPWreturnBtn_Click(object sender, EventArgs e)
        {
            IncorrectPWpan.SendToBack();
            IncorrectPWinput.Text = "Password";
            pwPan.BringToFront();
            passwordTB.Text = "Password";
        }

        private void IncorrectPWinput_TextChanged(object sender, EventArgs e)
        {
            if (IncorrectPWinput.Text == "Password")
                IncorrectPWinput.Clear();
        }

    }
}
