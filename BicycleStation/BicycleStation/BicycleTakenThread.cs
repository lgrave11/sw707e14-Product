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

        public BicycleTakenThread(int stationID, int bicycleID)
        {
            this._stationID = stationID;
            this._bicycleID = bicycleID;
        }

        public void bicycleTakenReport()
        {
            bool b = true;
            while (b)
            {
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleTaken(_stationID, _bicycleID);
                    b = false;
                }
                catch (WebException) { }
            }
        }
    }
}
