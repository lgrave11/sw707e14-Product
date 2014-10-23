using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Web.Helpers;
using System.Threading;

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

            StationDBService.StationToDB_Service service = new StationDBService.StationToDB_Service();
            DatabaseConnection db = new DatabaseConnection();
            List<booking> old = (from b in db.booking
                                select b).ToList();
            foreach (booking b in old)
                db.booking.Remove(b);
            db.SaveChanges();

            int stations = (from s in db.station
                            select s).Count();
            for(int i = 1; i <= stations; i++){
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
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new Form1());
        }
    }
}
