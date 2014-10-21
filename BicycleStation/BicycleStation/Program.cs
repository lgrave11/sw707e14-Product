using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Web.Helpers;

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
            for(int i = 1; i <= 21; i++){
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
