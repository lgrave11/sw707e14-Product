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
        public static void reportActions()
        {
            while (GlobalVariable.running)
            {
                if (GlobalVariable.ActionQueue.Count() > 0)
                {
                    Action current = null;
                    while (!GlobalVariable.ActionQueue.TryDequeue(out current)) { Thread.Sleep(GlobalVariable.SLEEPTIME); }
                    
                    current.Invoke();
                }
                else
                    Thread.Sleep(GlobalVariable.SLEEPTIME);

            }
        }

        public static void unlockWithBooking(int startStation, int bookingID, int bicycleID)
        {
            bool b = true;
            while (GlobalVariable.running && b)
            {
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleWithBookingUnlocked(startStation, bookingID, bicycleID);
                    b = false;
                }
                catch (WebException)
                {
                    Thread.Sleep(GlobalVariable.SLEEPTIME);
                }
            }
        }

        public static void bicycleReturnedReport(int bicycleID, int stationID)
        {
            bool b = true;
            while (GlobalVariable.running && b)
            {
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleReturnedToDockAtStation(bicycleID, stationID);
                    b = false;
                }
                catch (WebException) 
                {
                    Thread.Sleep(GlobalVariable.SLEEPTIME);
                }

            }

        }

        public static void bicycleTakenReport(int stationID, int bicycleID, int bookingID)
        {
            bool b = true;
            while (GlobalVariable.running && b)
            {
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.BicycleTaken(stationID, bicycleID, bookingID);
                    b = false;
                }
                catch (WebException)
                {
                    Thread.Sleep(GlobalVariable.SLEEPTIME);
                }
            }
        }

        public static void syncDockStatus(int[] bicycleIds, int numFree, int stationId)
        {
            bool b = true;
            while (GlobalVariable.running && b)
            {
                try
                {
                    StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                    service.SyncDockStatus(System.Web.Helpers.Json.Encode(bicycleIds), numFree, stationId);
                    
                    b = false;
                }
                catch (WebException)
                {
                    Thread.Sleep(GlobalVariable.SLEEPTIME);
                }
            }
        }

    }
}
