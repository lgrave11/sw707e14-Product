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

namespace BicycleStation
{
    public partial class Form1 : Form
    {
        const int MAXTIME = 120;
        const int LOCKED = 0;
        const int UNLOCKED = 1;
        const int NOBICYCLE = 2;
        int _maxTime = MAXTIME;
        

        public Form1()
        {
            InitializeComponent();
            DatabaseConnection DB = new DatabaseConnection();
            string[] query = (from c in DB.station
                                  select c.name).ToArray();
            StationNameDropDown.Items.AddRange(query);
            StationNameDropDown.SelectedItem = query[0];
         
        }

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

        private void StationNameDropDown_SelectedIndexChanged(object sender, EventArgs e)
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

            DockIdUpDown_ValueChanged(sender, e);
        }

        private void passwordTB_Click(object sender, EventArgs e)
        {
            if (passwordTB.Text == "Key")
            {
                passwordTB.Clear();
            }
        }

        private void UnlockBtn_Click(object sender, EventArgs e)
        {
            int pwText = 0;

            DatabaseConnection DB = new DatabaseConnection();
            try
            {
                pwText = Convert.ToInt32(passwordTB.Text.ToString());
                string stationName = StationNameDropDown.SelectedItem.ToString();

                List<booking> findBookings = (from b in DB.booking
                                             join s in DB.station on b.start_station equals s.station_id
                                             where b.password == pwText && s.name == stationName
                                             select b).ToList();

                if (findBookings.Count() > 0)
                {
                    EnterPwPanel.Visible = false;
                    EnterPwPanel.SendToBack();

                    TakeItPanel.BringToFront();
                    TakeItPanel.Visible = true;

                    lockTimer.Start();

                    List<dock> docks = (from d in DB.dock
                                        join s in DB.station on d.station_id equals s.station_id
                                        where s.name == stationName
                                        select d).ToList();
                    int availableDock = -1;
                    int i = 0;
                    while (availableDock < 0 && i < docks.Count)
                    {
                        if (docks[i].is_locked)
                            availableDock = i;
                        i++;
                    }
                    if (availableDock >= 0)
                    {
                        TakeAtDockLbl.Text = "Take your bicycle at dock " + (availableDock + 1);
                        docks[availableDock].is_locked = false;
                        DB.SaveChanges();
                        DockIdUpDown.Value = availableDock + 1;
                        DockIdUpDown_ValueChanged(sender, e);

                        StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                        service.BicycleWithBookingUnlocked(findBookings[0].start_station, findBookings[0].booking_id);
                    }
                    else
                        TakeAtDockLbl.Text = "Error with booking";

                }
                else
                {
                    MessageBox.Show("Incorrect Key");
                }
            }
            catch (FormatException){
                MessageBox.Show("Incorrect Key");
            }


        }

        private void UnlockMoreBtn_Click(object sender, EventArgs e)
        {
            lockTimer.Stop();
            _maxTime = MAXTIME;
            TimeLbl.Text = "";
            TakeItPanel.Visible = false;
            TakeItPanel.SendToBack();

            passwordTB.Text = "Key";
            EnterPwPanel.BringToFront();
            EnterPwPanel.Visible = true;

            StationNameDropDown_SelectedIndexChanged(sender, e);
        }

        private void DockIdUpDown_ValueChanged(object sender, EventArgs e)
        {
            DatabaseConnection DB = new DatabaseConnection();
            string stationName = StationNameDropDown.SelectedItem.ToString();

            int[] getDocks = (from d in DB.dock
                              join s in DB.station on d.station_id equals s.station_id
                              where s.name == stationName
                              select d.dock_id).ToArray();

            int docID = getDocks[Convert.ToInt32(DockIdUpDown.Value)-1];

            dock getDock = (from d in DB.dock
                           where d.dock_id == docID
                           select d).FirstOrDefault();

            if (getDock.holds_bicycle == 0)
            {
                DockStateBar.Value = NOBICYCLE;
                TakeBicycleBtn.Enabled = false;
                ReturnBicycleBtn.Enabled = true;
            }
            else if (!getDock.is_locked)
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


        private void bicycleTaken(dock Dock)
        {
            StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
            service.BicycleTaken(Dock.station_id, Dock.holds_bicycle);
        }

        private void bicycleReturn(dock Dock)
        {
            StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
            service.BicycleReturnedToDockAtStation(Dock.holds_bicycle, Dock.station_id, Dock.dock_id);
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
            getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1].holds_bicycle = 0;
            DB.SaveChanges();

            DockStateBar.Value = 2;
            ReturnBicycleBtn.Enabled = true;
            TakeBicycleBtn.Enabled = false;
        }

        private void ReturnBicycleBtn_Click(object sender, EventArgs e)
        {
            DatabaseConnection DB = new DatabaseConnection();

            string stationName = StationNameDropDown.SelectedItem.ToString();

            List<dock> getDocks = (from d in DB.dock
                                   join s in DB.station on d.station_id equals s.station_id
                                   where s.name == stationName
                                   select d).ToList();

            getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1].holds_bicycle = getRandomBicycleID();
            DB.SaveChanges();
            bicycleReturn(getDocks[Convert.ToInt32(DockIdUpDown.Value) - 1]);
            DockStateBar.Value = 1;
            TakeBicycleBtn.Enabled = true;
            ReturnBicycleBtn.Enabled = false;
        }

        private int getRandomBicycleID()
        {
            DatabaseConnection DB = new DatabaseConnection();

            List<int> availableIDs = new List<int>();
            for(int i = 1; i <= 178; i++)
                availableIDs.Add(i);
            List<int> usedIDs = (from d in DB.dock
                                where d.holds_bicycle > 0
                                select d.holds_bicycle).ToList();
            foreach(int i in usedIDs)
                availableIDs.Remove(i);

            return availableIDs[(new Random()).Next(1, availableIDs.Count())];
        }


        //develop later after DB communication is done
 /*       private bool recurringAttemptsToService(Func<bool> call, int attempts)
        {
            int attempt = 0;
            while (!call() && attempt <= attempts)
            {
                
            }
        }*/

    }
}
