using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Threading;
using System.Net;

namespace BicycleStation
{
    class UnlockWithBookingThread
    {
        int _startStation;
        int _bookingID;
        int _bicycleID;

        public UnlockWithBookingThread(int startStation, int bookingID, int bicycleID)
        {
            this._startStation = startStation;
            this._bookingID = bookingID;
            this._bicycleID = bicycleID;
        }

        public void unlockWithBooking()
        {
            bool b = true;
            while (GlobalVariable.running && b)
            {
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleWithBookingUnlocked(_startStation, _bookingID, _bicycleID);
                    b = false;
                }
                catch (WebException) { }
            }
        }
    }
}
