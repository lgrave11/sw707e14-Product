using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Drawing;
using System.Threading;
namespace GPSUpdatus
{
    public class Route:ICloneable
    {
        private int _index = 0;
        private string _name = "defaultRouteName";
        private List<PointF> _myRoute = null;
        public Route(string name, List<PointF> routeLst)
        {
            if(routeLst.Count == 0)
            {
                throw new ArgumentException("Size of route must be greater than 0");
            }
            _name = name;
            _myRoute = routeLst;
        }

        public override string ToString()
        {
            return _name;
        }

        private PointF GetNextPosition()
        {
            PointF result = _myRoute[_index];
            _index = (_index + 1) % _myRoute.Count;
            return result;
        }
        int bicycleid = 1;
        public void AssignBicycle(int id)
        {
            bicycleid = id;
        }
        public void TraverseList()
        {
            while(true)
            {
                PointF point = GetNextPosition();
                (new gpsservice.GPS_Service()).RegisterGPS(bicycleid, point.X, point.Y);
                Thread.Sleep(1000);//1 sekunder
            }
        }


        public object Clone()
        {
            return new Route(_name, _myRoute);
        }
    }
}
