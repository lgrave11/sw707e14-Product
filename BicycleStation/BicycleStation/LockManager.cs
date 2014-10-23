using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Threading;

namespace BicycleStation
{
    class LockManager
    {
        const int TIMEBEFORE = 3600;
        const int TIMEAFTER = 3600;
        List<booking> prevousBookings = new List<booking>();
        StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();

        Form1 GUI;
        public delegate void InvokeDelegate();
        DatabaseConnection DB = new DatabaseConnection();

        public LockManager(Form1 form)
        {
            this.GUI = form;
        }

        public void manage()
        {

            while (true)
            {
                
                Int32 currentTime = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;

                List<booking> oldBookings = (from b in DB.booking
                                             where b.start_time < currentTime - TIMEAFTER
                                             select b).ToList();
                foreach (booking b in oldBookings)
                    unlockDock(b);



                List<booking> bookings = (from b in DB.booking
                                          where b.start_time < currentTime + TIMEBEFORE
                                          select b).ToList();
                foreach (booking b in bookings)
                    if (!prevousBookings.Contains(b))
                        if (!lockDock(b))
                            bookings.Remove(b);

                prevousBookings = bookings;
                GUI.BeginInvoke(new InvokeDelegate(GUI.updateLabels));
                Thread.Sleep(60000);
            }
        }

        //located in 2 files
        public bool lockDock(booking b)
        {
            bool returnval = false;
            int bookingStation = b.start_station;
            dock toLock = null;
            try
            {
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
            //maybe need something to handle when there is no dock to lock
            DB.SaveChanges();
            return returnval;

        }

        public void unlockDock(booking b)
        {
            int bookingStation = b.start_station;
            dock toUnlock = null;

            try
            {
                toUnlock = (from d in DB.dock
                            where d.station_id == bookingStation && d.is_locked == true
                            select d).First();
            }
            catch (Exception) { }

            if (toUnlock != null)
                toUnlock.is_locked = false;
            //maybe need something to handle when there is no dock to lock
            service.BicycleWithBookingUnlocked(b.start_station, b.booking_id);
            DB.booking.Remove(b);
            DB.SaveChanges();
        }

    }
}
