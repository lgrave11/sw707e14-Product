using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Web.Helpers;
using System.Threading;
using System.Net;

namespace BicycleStation
{
    static class Program
    {
        /// <summary>
        /// The main entry point for the application.
        /// </summary>
        [STAThread]
        static void Main()
        {
            ResetDocks();
            RefreshBookings();

            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new Form1());
        }

        //Resets the locked state of the docks
        private static void ResetDocks()
        {
            DatabaseConnection db = new DatabaseConnection();
            List<dock> Docks = (from d in db.dock
                                select d).ToList();

            foreach (dock d in Docks)
                d.is_locked = false;

            db.SaveChanges();
        }

        //Refresh bookings in local database, as they are likely outdated
        private static void RefreshBookings()
        {
            try
            {
                StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
                DatabaseConnection db = new DatabaseConnection();

                //finds all bookings in database, then removes them
                List<booking> old = (from b in db.booking
                                     select b).ToList();
                foreach (booking b in old)
                    db.booking.Remove(b);
                db.SaveChanges();

                //Checks the number of stations in the database
                int stations = (from s in db.station
                                select s).Count();
                //Gets all the bookings for each station in the Global database and stores them locally
                for (int i = 1; i <= stations; i++)
                {
                    string[] bookings = service.GetAllBookingsForStation(i);
                    if (bookings.Count() > 0)
                    {
                        foreach (string s in bookings)
                        {
                            try
                            {
                                db.booking.Add(Json.Decode(s, typeof(booking)));
                                db.SaveChanges();
                            }
                            catch (Exception) { }
                        }
                    }
                }
            }
            catch (WebException) { RefreshBookings(); }
        }
    }
}
