using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading;
using DarkorbitChat.Core;
using DarkorbitChat.Game;

namespace DarkorbitChat
{
    class Program
    {
        private static Connection @Connection { get; set; }
        public static Dictionary<Int32, User> Users{get;set;}
        public static Dictionary<Int32, Chatroom> Chatrooms { get; set; }
        public static List<CustomChatRoom> PrivateChats { get; set; }
        public static MySQLManager MySql;

        static void Main()
        {
            Console.Title = "Darkorbit Chatserver by Waka Toa";
            Connection = new Connection();
            Chatrooms = new Dictionary<int, Chatroom>();
            PrivateChats = new List<CustomChatRoom>();
            MySql = new MySQLManager("root", "", "chatserver");
            if (MySql.Connect() == 0)
            {
                Console.WriteLine("Error, can not connect to mysql!");
                Console.ReadLine();
                return;
            }
            Console.WriteLine("Successfully connected to mysql!");
            Users = new Dictionary<int, User>();
            var sql = "SELECT * FROM `chatrooms`";
            var ds = MySql.Query(sql);
            foreach (DataRow row in ds.Rows)
            {
                var chat = new Chatroom
                {
                    Index = Convert.ToInt32(row[0]),
                    Name = row[1].ToString(),
                    Id = Convert.ToInt32(row[2])
                };
                Chatrooms.Add(chat.Id,chat);
            }
            Console.WriteLine("Successfully loaded " + Chatrooms.Count + " chatrooms!");    
            var t = new Thread(@Connection.Start) {IsBackground = true};
            t.Start();
            Console.WriteLine("Successfully launched server on port 9338!");
            Console.WriteLine("Type in 'close' to close the chatserver!");
            while (Console.ReadLine() != "close")
            {
                Console.WriteLine("Type in 'close' to close the chatserver!");
            }
            t.Abort();
            t = null;
            Environment.Exit(0);
        }

        public static bool IsUserBanned(String username)
        {
            try
            {
                var sql = "SELECT * FROM `bannedusers` WHERE `username` LIKE '" + username + "';";

                var ds = MySql.Query(sql);

                return ds.Rows.Count != 0;
            }
            catch { return false; }
        }

        public static bool IsIpBanned(String ip)
        {
            try
            {
                var sql = "SELECT * FROM `bannedips` WHERE `ip` LIKE '" + ip + "';";

                var ds = MySql.Query(sql);

                return ds.Rows.Count != 0;
            }
            catch { return false; }
        }

        public static void BanUser(String username)
        {
            try
            {
                var sql = "INSERT INTO `bannedusers` (`Username`) VALUES ('"  + username + "');";

                MySql.ExecuteNonQuery(sql);
            }
            catch {  }
        }

        public static void UnbanUser(String username)
        {
            try
            {
                var sql =" DELETE FROM `bannedusers` WHERE `username` LIKE '" + username + "';";

                MySql.ExecuteNonQuery(sql);
            }
            catch { }
        }

        public static void BanIp(String ip)
        {
            try
            {
                var sql = "INSERT INTO `bannedips` (`Ip`) VALUES ('" + ip + "');";

                MySql.ExecuteNonQuery(sql);
            }
            catch { }
        }

        public static void UnbanIp(String ip)
        {
            try
            {
                var sql = " DELETE FROM `bannedips` WHERE `Ip` LIKE '" + ip + "';";

                MySql.ExecuteNonQuery(sql);
            }
            catch { }
        }

        public static bool IsUserAdministrator(String username)
        {
            try
            {
                var sql = "SELECT * FROM `administrators` WHERE `username` LIKE '" + username + "';";

                var ds = MySql.Query(sql);

                return ds.Rows.Count != 0;
            }
            catch { return false; }
        }

        public static void AddLog(string from, string to, string message)
        {
            var unixTimestamp = (DateTime.Now.Subtract(new DateTime(1970, 1, 1))).TotalSeconds;
            var sql =
                "INSERT INTO .`log` (`Timestamp`, `From`, `To`, `Message`) VALUES ('" + unixTimestamp + "', '" + from + "', '" + to +"', '" +message + "');";

            MySql.ExecuteNonQuery(sql);
        }
    }
}
