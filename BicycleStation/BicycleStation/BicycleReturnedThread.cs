using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Threading;
using System.Net;

namespace BicycleStation
{
    class BicycleReturnedThread
    {
        int _stationID;
        int _dockID;
        int _bicycleID;

        public BicycleReturnedThread(int bicycleID, int stationID, int dockID)
        {
            this._stationID = stationID;
            this._dockID = dockID;
            this._bicycleID = bicycleID;
        }

        public void bicycleReturnedReport()
        {
            bool b = true;
            while (GlobalVariable.running && b)
            {
                Thread.Sleep(GlobalVariable.SLEEPTIME);

                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleReturnedToDockAtStation(_bicycleID, _stationID, _dockID);
                    b = false;
                }
                catch (WebException) { }

            }
            
        }
    }
}
