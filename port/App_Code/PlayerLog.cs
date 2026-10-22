using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.log.php (class `log`).
    /// Named PlayerLog because System.Diagnostics.Log-adjacent naming and to avoid
    /// clashing with the DB.SetLog helper. Same API: setId(), money(), getLog().
    /// </summary>
    public class PlayerLog
    {
        private long _uid;
        private long _pid;

        public long Uridium { get; private set; }
        public long Credits { get; private set; }

        /// <summary>log::setId($uid,$pid) — also refreshes balances via money().</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
            Money();
        }

        /// <summary>log::money() — SELECT uri, credits FROM server_1_players.</summary>
        public void Money()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT uri, credits FROM server_1_players WHERE userID=@uid AND playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (rdr.Read())
                    {
                        Uridium = ToLong(rdr["uri"]);
                        Credits = ToLong(rdr["credits"]);
                    }
                }
            }
        }

        /// <summary>log::getLog() — all rows of server_1_log for the player (FETCH_ASSOC parity).</summary>
        public List<Dictionary<string, string>> GetLog()
        {
            var result = new List<Dictionary<string, string>>();
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT * FROM server_1_log WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    while (rdr.Read())
                    {
                        var row = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase);
                        for (int i = 0; i < rdr.FieldCount; i++)
                            row[rdr.GetName(i)] = rdr.IsDBNull(i) ? "" : Convert.ToString(rdr.GetValue(i), System.Globalization.CultureInfo.InvariantCulture);
                        result.Add(row);
                    }
                }
            }
            return result;
        }

        internal static long ToLong(object v)
        {
            if (v == null || v == DBNull.Value) return 0;
            try { return Convert.ToInt64(v, System.Globalization.CultureInfo.InvariantCulture); }
            catch { return 0; } // PHP (int)'abc' === 0
        }

        internal static double ToDouble(object v)
        {
            if (v == null || v == DBNull.Value) return 0;
            try { return Convert.ToDouble(v, System.Globalization.CultureInfo.InvariantCulture); }
            catch { return 0; }
        }
    }
}
