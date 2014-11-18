using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BicycleStation
{
    class NetworkData
    {
        const int TIMEBEFORE = 3600;

        //Assigned through Json decode of remote database messages
        public string action { get; set; }
        public int booking_id { get; set; }
        public int start_station { get; set; }
        public int password { get; set; }
        public int start_time { get; set; }
        public int dock_id { get; set; }
        public int station_id { get; set; }

        DatabaseConnection DB = new DatabaseConnection();

        public void performAction()
        {
            if (action == "booking")
            {
                booking b = new booking()
                {
                    booking_id = booking_id,
                    password = password,
                    start_station = start_station,
                    start_time = start_time
                };

                DB.booking.Add(b);
                DB.SaveChanges();
            }
            else if (action == "unbooking")
            {
                booking toRemove = (from b in DB.booking
                                   where b.booking_id == booking_id
                                   select b).Single();

                //Current time in Unix format
                Int32 currentTime = (Int32)(DateTime.UtcNow.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
                if (!(toRemove.start_time < currentTime + TIMEBEFORE))
                {
                    dock toUnlock = (from d in DB.dock
                                     where d.is_locked && d.station_id == toRemove.start_station
                                     select d).First();
                    toUnlock.is_locked = false;
                }

                DB.booking.Remove(toRemove);
                DB.SaveChanges();
            }
            else if (action == "addDock") 
            {
                dock d = new dock()
                {
                    station_id = this.station_id
                };

                DB.dock.Add(d);
                DB.SaveChanges();
            }
            else if (action == "removeDock")
            {
                dock toRemove = (from d in DB.dock
                                 where d.dock_id == dock_id
                                 orderby d.dock_id
                                 select d).ToList().Last();

                DB.dock.Remove(toRemove);
                DB.SaveChanges();
            }
            else
                return;
        }
    }
}
