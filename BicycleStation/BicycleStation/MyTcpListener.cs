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

        //tcp listener code from http://msdn.microsoft.com/en-us/library/system.net.sockets.tcplistener(v=vs.110).aspx
        // with minor modifications
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

                // Buffer for reading data
                Byte[] bytes = new Byte[256];
                String data = null;

                // Enter the listening loop. 
                while (true)
                {
                    // Perform a blocking call to accept requests. 
                    // You could also user server.AcceptSocket() here.
                    TcpClient client = server.AcceptTcpClient();
                    
                    data = null;

                    // Get a stream object for reading and writing
                    NetworkStream stream = client.GetStream();

                    int i;

                    // Loop to receive all the data sent by the client. 
                    while ((i = stream.Read(bytes, 0, bytes.Length)) != 0)
                    {
                        // Translate data bytes to a ASCII string.
                        data = System.Text.Encoding.ASCII.GetString(bytes, 0, i);

                        // Process the data sent by the client.
                        data = data.ToUpper();

                        byte[] msg = System.Text.Encoding.ASCII.GetBytes(data);

                        // Send back a response.
                        stream.Write(msg, 0, msg.Length);
                        
                        //interpret msg here and update DB (UI?)
                        string test = msg.ToString();
                        NetworkData networkdata = Json.Decode(data, typeof(NetworkData));
                        networkdata.performAction();
                    }

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
