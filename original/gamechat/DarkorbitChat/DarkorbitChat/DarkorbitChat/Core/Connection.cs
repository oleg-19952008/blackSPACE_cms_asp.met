using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;

namespace DarkorbitChat.Core
{
    public class ExtendedSocket
    {
        public Socket Socket { get; set; }
        public int BufferSize { get; set; }
        public byte[] Buffer { get; set; }

        public ExtendedSocket(Socket socket)
        {
            Socket = socket;
            BufferSize = 1024;
            Buffer = new byte[BufferSize];
        }

        public ExtendedSocket()
        {
            BufferSize = 1024;
            Buffer = new byte[BufferSize];
        }
    }

    class Connection
    {
        private readonly ManualResetEvent _done = new ManualResetEvent(false);
        private const int Port = 9338;

        public void Start()
        {

            var localEndPoint = new IPEndPoint(IPAddress.Any, Port);

            var listener = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);


            try
            {
                listener.Bind(localEndPoint);
                listener.Listen(100);

                while (true)
                {
                    _done.Reset();

                    listener.BeginAccept(AcceptCallback, listener);

                    _done.WaitOne();
                }
            }
            catch{}
        }

        private void AcceptCallback(IAsyncResult result)
        {
            _done.Set();

            var listener = (Socket)result.AsyncState;
            var handler = listener.EndAccept(result);
            if (!Program.IsIpBanned(handler.RemoteEndPoint.ToString().Split(':')[0]))
            {
                new Game.User(handler);
            }
            
        }
    }
}
