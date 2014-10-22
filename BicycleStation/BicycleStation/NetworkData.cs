using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BicycleStation
{
    class NetworkData
    {
        private string _action;
        private int _booking_id;
        private int _start_station;
        private int _password;
        private int _start_time;

        public NetworkData(){}
        public NetworkData(string action, int booking_id)
        {
            _action = action;
            _booking_id = booking_id;
        }
        public NetworkData(string action, int booking_id, int start_station, int password, int start_time)
        {
            _action = action;
            _booking_id = booking_id;
            _start_station = start_station;
            _password = password;
            _start_time = start_time;
        }

        public void performAction()
        {
            DatabaseConnection DB = new DatabaseConnection();
            if (_action == "booking")
            {
                DB.booking.Add(new booking(){booking_id = _booking_id,
                                             password = _password,
                                             start_station = _start_time,
                                             start_time = _start_time });
                DB.SaveChanges();
            }
            else if (_action == "unbooking")
            {
                booking toRemove = (from b in DB.booking
                                   where b.booking_id == _booking_id
                                   select b).Single();
                DB.booking.Remove(toRemove);
                DB.SaveChanges();

            }
            else
                return;
        }

    }
}
