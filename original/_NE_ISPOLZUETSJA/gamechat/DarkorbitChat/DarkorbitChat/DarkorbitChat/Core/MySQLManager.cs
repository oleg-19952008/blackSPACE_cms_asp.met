using System;
using System.Data;
using MySql.Data.MySqlClient;

namespace DarkorbitChat.Core
{
    class MySQLManager
    {
        public string Username { get; private set; }
        public string Password { get; private set; }
        public string DBName { get; private set; }
        public MySqlConnection Connection { get; private set; }
        public bool Connected { get; private set; }
        private readonly string ConnectionString;

        public MySQLManager(string username, string password, string dbName)
        {
            this.Username = username;
            this.Password = password;
            this.DBName = dbName;
            this.ConnectionString = String.Format("server=localhost;user={0};database={1};port=3306;password={2};", username, dbName, password);
            this.Connection = new MySqlConnection(this.ConnectionString);
        }
 
        public int Connect()
        {
            try
            {
                 this.Connection.Open();
                this.Connected = true;
                return 1;
            }
            catch (AggregateException)
            {
                this.Connected = false;
                return 0;
            }
        }

        public void CloseConnection()
        {
            try
            {
                this.Connection.Close();
            }
            finally
            {
                this.Connection = null;
                this.DBName = null;
                this.Password = null;
                this.Username = null;
            }
        }
 
        private static DataTable query_Internal(MySqlCommand cmd)
        {
                var table = new DataTable();
                using (var adapter = new MySqlDataAdapter(cmd))
                    adapter.Fill(table);
                return table;
         
        }

        public DataTable ExecuteNonQueryQuery(string query)
        {
            //var dataReader = await CreateCommand(query).ExecuteReaderAsync();
           
            using (var cmd = CreateCommand(query))
                return  query_Internal(cmd);
        }

        public  DataTable Query(string query, string[] parameterNames, object[] values)
        {
            using (var cmd = CreateCommand(query, parameterNames, values))
                return query_Internal(cmd);
        }

        public DataTable Query(string query)
        {
            using (var cmd = CreateCommand(query))
                return query_Internal(cmd);
        }
 
        public Boolean  ExecuteNonQuery(string command)
        {
            try
            {
                MySqlCommand cmd = CreateCommand(command);
                var resultSet = cmd.ExecuteNonQuery();

                if (!resultSet.Equals(0))
                    return true;
                return false;
            }
            catch
            { return false;}
            
        }

        public void  ExecuteNonQuery(string command, string[] parameterNames, object[] values)
        {
            using (var cmd = CreateCommand(command))
            {
                for (int i = 0; i < parameterNames.Length; i++)
                    cmd.Parameters.AddWithValue(parameterNames[i], values[i]);
                 cmd.ExecuteNonQuery();
            }
        }

        public object ExecuteLinear(string cmd)
        {
            return CreateCommand(cmd).ExecuteScalar();
        }
 
        private MySqlCommand CreateCommand(string q)
        {
            return new MySqlCommand(q, this.Connection);
        }

        public MySqlCommand CreateCommand(string q, string[] names, object[] values)
        {
            if ((names == null || values == null) || (names.Length != values.Length) || names.Length <= 0) throw new ArgumentException();
 
            MySqlCommand command = CreateCommand (q);
            for (int i = 0; i < names.Length; i++)
                command.Parameters.AddWithValue(names[i], values[i]);
            return command;
        }
    }
}
