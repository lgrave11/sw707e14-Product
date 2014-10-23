using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BicycleStation
{
    class NetworkData
    {
        //Assigned through Json decode of remote database messages
        public string action { get; set; }
        public int booking_id { get; set; }
        public int start_station { get; set; }
        public int password { get; set; }
        public int start_time { get; set; }

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
                DB.booking.Remove(toRemove);
                DB.SaveChanges();
            }
            else
                return;
        }
    }
}
