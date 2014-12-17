using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BicycleStation
{
    class UnlockedBooking
    {
        public int stationID;
        public int dockID;
        public int bookingID;
        public int bicycleID;
        public int unlockTime;

        public UnlockedBooking(int station, int dock, int booking, int bicycle, int time)
        {
            stationID = station;
            dockID = dock;
            bookingID = booking;
            bicycleID = bicycle;
            unlockTime = time;
        }
    }
}
