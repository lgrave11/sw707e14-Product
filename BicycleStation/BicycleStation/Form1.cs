using System;
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
        const int MAXTIME = 120;

        //Time before a booking the bike can be unlocked
        const int TIMEBEFORE = 3600;

        //Slidebar values
        const int LOCKED = 0;
        const int UNLOCKED = 1;
        const int NOBICYCLE = 2;

        //number of bicycles in the system
        const int NUMBEROFBICYCLES = 178;

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

        //Timer for booking unlock window, invisible to users
        private void lockTimer_Tick(object sender, EventArgs e)
        {
            if (_maxTime == 0)
            {
                lockTimer.Stop();
                _maxTime = MAXTIME;
            }
            else
            {
                _maxTime--;
                TimeSpan timespan = TimeSpan.FromSeconds(_maxTime);
                TimeLbl.Text = timespan.ToString(@"mm\:ss");
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
                MessageBox.Show("Incorrect Password");
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
                    MessageBox.Show("Booking not yet available");
                }
            }
            else
            {
                MessageBox.Show("Incorrect Password");
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
                //Unlocks available dock
                docks[availableDock].is_locked = false;
                DB.SaveChanges();

                //changes dock being displayed in UI and updates values
                DockIdUpDown.Value = availableDock + 1;
                UpdateDockValues();

                //reports unlock to Global Database interface
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleWithBookingUnlocked(unlockedBooking.start_station, unlockedBooking.booking_id, docks[availableDock].holds_bicycle);
                }
                catch (WebException) 
                {
                    UnlockWithBookingThread serviceThread = new UnlockWithBookingThread(unlockedBooking.start_station, unlockedBooking.booking_id, docks[availableDock].holds_bicycle);
                    Thread unlockWithBookingReporter = new Thread(new ThreadStart(serviceThread.unlockWithBooking));
                    unlockWithBookingReporter.Start();
                }
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
        private void bicycleTaken(dock Dock)
        {
            try
            {
                StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                service.BicycleTaken(Dock.station_id, Dock.holds_bicycle);
            }
            catch (WebException)
            {
                BicycleTakenThread BTT = new BicycleTakenThread(Dock.station_id, Dock.holds_bicycle);
                Thread BTTReporter = new Thread(new ThreadStart(BTT.bicycleTakenReport));
                BTTReporter.Start();
            }
        }

        //Sends message to DB interface that a bicycle has been returned to a dock
        private void bicycleReturn(dock Dock)
        {
            try
            {
                StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                service.BicycleReturnedToDockAtStation(Dock.holds_bicycle, Dock.station_id, Dock.dock_id);
            }
            catch (WebException)
            {
                BicycleReturnedThread BRT = new BicycleReturnedThread(Dock.holds_bicycle, Dock.station_id, Dock.dock_id);
                Thread BRTReporter = new Thread(new ThreadStart(BRT.bicycleReturnedReport));
                BRTReporter.Start();
            }


        }


        private void TakeBicycleBtn_Click(object sender, EventArgs e)
        {
            DatabaseConnection DB = new DatabaseConnection();
            string stationName = StationNameDropDown.SelectedItem.ToString();

            List<dock> getDocks = (from d in DB.dock
                                   join s in DB.station on d.station_id equals s.station_id
                                   where s.name == stationName
                                   select d).ToList();

            bicycleTaken(getDocks[Convert.ToInt32(DockIdUpDown.Value)-1]);

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
            getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1].holds_bicycle = getRandomBicycleID(DB);
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
            return availableIDs[(new Random()).Next(1, availableIDs.Count())];
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

    }
}
