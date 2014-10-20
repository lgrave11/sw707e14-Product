using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Web.Helpers;

namespace BicycleStation
{
    class ServiceParser
    {
        public void parse(string input)
        {
            
        }

        public void insertBooking(string input)
        {
            (new DatabaseConnection()).booking.Add(Json.Decode(input));
        }

    }
}
