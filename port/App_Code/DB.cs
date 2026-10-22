using System;
using System.Configuration;
using System.Data;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.db.php.
    /// PHP had two connection channels:
    ///  - PDO singleton ($GLOBALS['DB']) built from hard-coded db_info, ERRMODE_SILENT
    ///  - mysqli ($MySQLi) built from $Config['MySQL']
    /// In .NET both are represented by MySqlConnection created on demand
    /// (the driver keeps the same wire protocol; connections are pooled).
    /// </summary>
    public static class DB
    {
        // --- getInstance(): PDO singleton parameters ("DB.Instance.*" appSettings) ---
        public static string InstanceConnectionString
        {
            get
            {
                return string.Format(
                    "server={0};port={1};uid={2};pwd={3};database={4};charset=utf8;",
                    AppConfig.Get("DB.Instance.Host", "127.0.0.1"),
                    AppConfig.Get("DB.Instance.Port", "3306"),
                    AppConfig.Get("DB.Instance.User", "root"),
                    AppConfig.Get("DB.Instance.Pass", ""),
                    AppConfig.Get("DB.Instance.DbName", "darkorbit"));
            }
        }

        // --- $MySQLi channel from Server.Config.php ("MySQL.*" appSettings) ---
        public static string ConfigConnectionString
        {
            get
            {
                return string.Format(
                    "server={0};uid={1};pwd={2};database={3};charset=utf8;",
                    AppConfig.Get("MySQL.Host", "localhost"),
                    AppConfig.Get("MySQL.User", "root"),
                    AppConfig.Get("MySQL.Pass", ""),
                    AppConfig.Get("MySQL.DbName", "darkorbit"));
            }
        }

        /// <summary>Equivalent of $db::getInstance() / $GLOBALS['DB'].</summary>
        public static MySqlConnection GetInstance()
        {
            var conn = new MySqlConnection(InstanceConnectionString);
            try
            {
                conn.Open();
                using (var cmd = new MySqlCommand("SET CHARACTER SET utf8", conn))
                {
                    cmd.ExecuteNonQuery();
                }
            }
            catch (Exception e)
            {
                // PDO branch echoed the message and continued; keep parity but log-free.
                System.Diagnostics.Debug.WriteLine(e.Message);
            }
            return conn;
        }

        /// <summary>Equivalent of `new mysqli($Config['MySQL'...])` with connect-error die().</summary>
        public static MySqlConnection GetMySQLi()
        {
            var conn = new MySqlConnection(ConfigConnectionString);
            try
            {
                conn.Open();
            }
            catch (Exception e)
            {
                throw new ApplicationException("Error de Conexion MySQL (" + e.GetType().Name + ") " + e.Message, e);
            }
            return conn;
        }

        /// <summary>DB::setLog($pid, $des) — INSERT INTO server_1_log.</summary>
        public static void SetLog(long pid, string des)
        {
            if (pid == 0) return;
            using (var con = GetInstance())
            using (var cmd = new MySqlCommand("INSERT INTO server_1_log (playerID, descrip) VALUES (@pid, @des)", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.Parameters.AddWithValue("@des", des);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>DB::pmc($pid, $des, $location) — INSERT INTO pmc_log.</summary>
        public static void Pmc(long pid, string des, string location)
        {
            if (pid == 0) return;
            using (var con = GetInstance())
            using (var cmd = new MySqlCommand("INSERT INTO pmc_log (playerID, descrip, location) VALUES (@pid, @des, @loc)", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.Parameters.AddWithValue("@des", des);
                cmd.Parameters.AddWithValue("@loc", location);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>
        /// DB::safe($s) — was mysqli_real_escape_string. Do NOT use for new code:
        /// all queries in this port use parameterized commands instead.
        /// Kept only for behavioural parity during migration.
        /// </summary>
        public static string Safe(string s)
        {
            if (string.IsNullOrEmpty(s)) return s ?? "";
            using (var con = GetInstance())
            {
                return MySqlCommand.EscapeString(s);
            }
        }

        /// <summary>DB::getUserIP() — HTTP_CLIENT_IP / X_FORWARDED_FOR / REMOTE_ADDR.</summary>
        public static string GetUserIp()
        {
            var req = System.Web.HttpContext.Current != null ? System.Web.HttpContext.Current.Request : null;
            if (req == null) return "127.0.0.1";

            string client = req.ServerVariables["HTTP_CLIENT_IP"];
            string forward = req.ServerVariables["HTTP_X_FORWARDED_FOR"];
            string remote = req.ServerVariables["REMOTE_ADDR"];

            if (IsValidIp(client)) return client;
            if (IsValidIp(forward)) return forward;
            return remote ?? "";
        }

        private static bool IsValidIp(string value)
        {
            if (string.IsNullOrWhiteSpace(value)) return false;
            // filter_var(..., FILTER_VALIDATE_IP) parity: strict IPv4/IPv6 parse of first entry
            string candidate = value.Split(',')[0].Trim();
            System.Net.IPAddress addr;
            return System.Net.IPAddress.TryParse(candidate, out addr);
        }
    }
}
