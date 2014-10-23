using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BicycleStation
{
    class NetworkData
    {
        public string action;
        public int booking_id;
        public int start_station;
        public int password;
        public int start_time;
        


        public NetworkData(){}
        public NetworkData(string _action, int _booking_id)
        {
            action = _action;
            booking_id = _booking_id;
        }
        public NetworkData(string _action, int _booking_id, int _start_station, int _password, int _start_time)
        {
            action = _action;
            booking_id = _booking_id;
            start_station = _start_station;
            password = _password;
            start_time = _start_time;
        }

        public void performAction()
        {
            

            DatabaseConnection DB = new DatabaseConnection();
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
                //lockDock(b, DB);
                
            }
            else if (action == "unbooking")
            {
                booking toRemove = (from b in DB.booking
                                   where b.booking_id == booking_id
                                   select b).Single();
                DB.booking.Remove(toRemove);
                DB.SaveChanges();

            }
            else
                return;
        }

        //no longer needed
        /*
        public void lockDock(booking b, DatabaseConnection DB)
        {
            int bookingStation = b.start_station;
            dock toLock = (from d in DB.dock
                           join s in DB.station on d.station_id equals s.station_id
                           where s.station_id == bookingStation && d.is_locked == false && d.holds_bicycle > 0
                           select d).First();
            if (toLock != null)
                toLock.is_locked = true;
            //maybe need something to handle when there is no dock to lock
            DB.SaveChanges();
            
        }*/



    }
}
