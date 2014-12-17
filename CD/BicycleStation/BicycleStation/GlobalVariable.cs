using System;
using System.Collections.Concurrent;
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

        public static ConcurrentQueue<Action> ActionQueue = new ConcurrentQueue<Action>();
    }
}
