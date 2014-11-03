using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Threading;
using System.Net;

namespace BicycleStation
{
    class BicycleTakenThread
    {
        int _stationID;
        int _bicycleID;
        int _bookingID;

        public BicycleTakenThread(int stationID, int bicycleID, int bookingID)
        {
            this._stationID = stationID;
            this._bicycleID = bicycleID;
            this._bookingID = bookingID;
        }

        public void bicycleTakenReport()
        {
            bool b = true;
            while (GlobalVariable.running && b)
            {
                Thread.Sleep(GlobalVariable.SLEEPTIME);

                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleTaken(_stationID, _bicycleID, _bookingID);
                    b = false;
                }
                catch (WebException) { }
            }
        }
    }
}
