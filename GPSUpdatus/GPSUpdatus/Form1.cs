using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;
using System.Net;
using System.IO;

namespace GPSUpdatus
{
    public partial class Form1 : Form
    {
        Dictionary<int, Thread> threadDic = new Dictionary<int, Thread>();

        public Form1()
        {
            InitializeComponent();
            AddRoute("LasseHjem.txt", "Lasse er for tyk til at cykle hjem");
            AddRoute("ErikTilUni.txt", "Eriks rejse til uni");
            AddRoute("WindeTilLars.txt", "Winde rejser hen til Lars");
            AddRoute("DennisTilErik.txt", "Dennis rejser hen og bliver syg ved Erik");
        }

        public void AddRoute(string filepath, string name)
        {            
            string[] content = File.ReadAllLines(filepath);
            List<PointF> points = new List<PointF>();
            foreach (string s in content) 
            {
                var x =  s.Trim().Split(';');
                points.Add(new PointF((float)Convert.ToDouble(x[0]), (float)Convert.ToDouble(x[1])));
            }
            lstRoutes.Items.Add(new Route(name, points));
        }

        ~Form1()
        {
            foreach(Thread t in threadDic.Values)
            {
                t.Abort();
                t.Join();
            }
        }

        private void btnStartStopRoute_Click(object sender, EventArgs e)
        {
            int bicycle_id = (int)numUpDownBicycle.Value;
            Route currentRoute = (Route)((Route)lstRoutes.SelectedItem).Clone();

            if(threadDic.ContainsKey(bicycle_id))
            {
                threadDic[bicycle_id].Abort();
                threadDic[bicycle_id].Join();
            }

            currentRoute.AssignBicycle(bicycle_id);
            threadDic[bicycle_id] = new Thread(new ThreadStart(currentRoute.TraverseList));
            threadDic[bicycle_id].IsBackground = true;
            threadDic[bicycle_id].Start();
        }

    }
}
