using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Threading;
using System.Net;

namespace BicycleStation
{
    class ServiceThreads
    {
        int _startStation;
        int _bookingID;

        public ServiceThreads(int startStation, int bookingID)
        {
            this._startStation = startStation;
            this._bookingID = bookingID;
        }

        public void unlockWithBooking()
        {
            bool b = true;
            while (b)
            {
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleWithBookingUnlocked(_startStation, _bookingID);
                    b = false;
                }
                catch (WebException) { }
            }
        }
    }
}
