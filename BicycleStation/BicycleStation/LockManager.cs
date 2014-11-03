using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Threading;
using System.Net;

namespace BicycleStation
{
    class LockManager
    {
        //Timeframe in seconds that a booked bicycle is loocked
        const int TIMEBEFORE = 3600;
        const int TIMEAFTER = 3600;

        List<booking> prevousBookings = new List<booking>();
        DatabaseConnection DB = new DatabaseConnection();
        
        //Used for GUI updates in main thread
        Form1 GUI;
        public delegate void InvokeDelegate();
        
        public LockManager(Form1 form)
        {
            this.GUI = form;
        }

        public void manage()
        {
            //Infinite thread loop
            while (GlobalVariable.running)
            {
                //Current time in Unix format
                Int32 currentTime = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;

                //Bookings that should have started 1 hour ago
                List<booking> oldBookings = (from b in DB.booking
                                             where b.start_time < currentTime - TIMEAFTER
                                             select b).ToList();
                foreach (booking b in oldBookings)
                    unlockDock(b);


                //Bookings that start in less than an hour
                List<booking> bookings = (from b in DB.booking
                                          where b.start_time < currentTime + TIMEBEFORE
                                          select b).ToList();
                List<booking> notUnlocked = new List<booking>();

                foreach (booking b in bookings)
                    if (!prevousBookings.Contains(b))
                        if (!lockDock(b))
                            notUnlocked.Add(b);

                foreach (booking b in notUnlocked)
                    bookings.Remove(b);


                //Bookings used this iteration are stored to avoid locking docks for them at each iteration
                prevousBookings = bookings;

                //Updates UI in main thread
                GUI.BeginInvoke(new InvokeDelegate(GUI.updateUI));

                //Sleeps as process does not require constant iteration
                Thread.Sleep(GlobalVariable.SLEEPTIME);
            }
        }

        //Locks the first available dock at a station for a booking
        //Attempted again in next iteration if it fails
        public bool lockDock(booking b)
        {
            bool returnval = false;
            int bookingStation = b.start_station;
            dock toLock = null;
            //Query might be empty
            try
            {
                //Selects first available dock
                toLock = (from d in DB.dock
                          where d.station_id == bookingStation && d.is_locked == false && d.holds_bicycle > 0
                          select d).First();
            }
            catch (Exception) { }

            if (toLock != null)
            {
                toLock.is_locked = true;
                returnval = true;
            }
            //Something to handle when there is no dock to lock

            DB.SaveChanges();
            return returnval;

        }

        //Unlocks the first locked dock at a station when a booking expires
        public void unlockDock(booking b)
        {
            int bookingStation = b.start_station;
            dock toUnlock = null;
            //Query might be empty
            try
            {
                //Selects first locked dock
                toUnlock = (from d in DB.dock
                            where d.station_id == bookingStation && d.is_locked == true
                            select d).First();
            }
            catch (Exception) { }

            if (toUnlock != null)
                toUnlock.is_locked = false;

            //Something to handle when there is no dock to lock

            removeGlobal(b);

            //Removes expired booking from local database
            DB.booking.Remove(b);
            DB.SaveChanges();
        }

        //Deactivates expired booking in global database
        private static void removeGlobal(booking b)
        {
            GlobalVariable.ActionQueue.Enqueue(() => ServiceThreads.unlockWithBooking(b.start_station, b.booking_id, 0));
        }

    }
}
