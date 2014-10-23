using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
using System.Net;
using System.Net.Sockets;
using System.Web.Helpers;

namespace BicycleStation
{
    class MyTcpListener
    {
        Form1  GUI;
        public delegate void InvokeDelegate();

        //tcp listener code from http://msdn.microsoft.com/en-us/library/system.net.sockets.tcplistener(v=vs.110).aspx
        // with modifications to match system needs
        public MyTcpListener(Form1 form)
        {
            this.GUI = form;
        }


        public void Listen()
        {
            TcpListener server = null;
            try
            {
                // Set the TcpListener on port 10000.
                Int32 port = 10000;
                IPAddress localAddr = IPAddress.Parse("127.0.0.1");

                // TcpListener server = new TcpListener(port);
                server = new TcpListener(localAddr, port);

                // Start listening for client requests.
                server.Start();

                // Enter the listening loop. 
                while (true)
                {
                    // Perform a blocking call to accept requests. 
                    // You could also user server.AcceptSocket() here.
                    TcpClient client = server.AcceptTcpClient();

                    // Get a stream object for reading and writing
                    NetworkStream stream = client.GetStream();
                    Byte[] bytes = new Byte[client.ReceiveBufferSize];
                    int length = stream.Read(bytes, 0, bytes.Length);
                    string received = Encoding.ASCII.GetString(bytes, 0, length);
                    byte[] msg = System.Text.Encoding.ASCII.GetBytes(received.ToUpper());
                    // Send back a response.
                    stream.Write(msg, 0, msg.Length);

                    //Decode date and create networkdata object
                    NetworkData networkdata = Json.Decode(received, typeof(NetworkData));
                    networkdata.performAction();
                    GUI.BeginInvoke(new InvokeDelegate(GUI.updateLabels));

                    // Shutdown and end connection
                    client.Close();
                }
            }
            catch (SocketException)
            {
                
            }
            finally
            {
                // Stop listening for new clients.
                server.Stop();
            }
        }
    }
}
