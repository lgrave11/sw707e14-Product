using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BicycleStation
{
    static class GlobalVariable
    {
        public static bool running = true;

        //Time thread sleeps after every iteration
        public const int SLEEPTIME = 1000;

        public static Queue<Action> ActionQueue = new Queue<Action>();
    }
}
