using System;
using System.Data.Common;
using System.Web;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.Users.php (checkSession part) — the skeleton
    /// user repository. Extended in later migration steps with changeUsername etc.
    /// </summary>
    public class Users
    {
        /// <summary>$this->DataRow (assoc array in PHP => Dictionary here). Null when not logged in.</summary>
        public DbColumnRow DataRow { get; private set; }

        /// <summary>
        /// Users->checkSession(): SELECT users + server_1_players by sessionId & email.
        /// Parameterized (PHP used raw string interpolation).
        /// </summary>
        public void CheckSession(HttpSessionState session)
        {
            DataRow = null;
            if (!SessionManager.IsLoggedIn(session)) return;

            using (var mysql = DB.GetMySQLi())
            using (var cmd = new MySqlCommand(
                "SELECT users.ID, users.Email, users.Name, users.regDate, " +
                "server_1_players.playerID, server_1_players.userID, server_1_players.shipId, " +
                "server_1_players.premium, server_1_players.factionId, server_1_players.GGspins, " +
                "server_1_players.credits, server_1_players.uri, server_1_players.level, " +
                "server_1_players.exp, server_1_players.honor " +
                "FROM users, server_1_players " +
                "WHERE users.sessionId = @sid AND users.Email = @email " +
                "AND server_1_players.userID = users.ID", mysql))
            {
                cmd.Parameters.AddWithValue("@sid", SessionManager.SessionId(session));
                cmd.Parameters.AddWithValue("@email", SessionManager.Email(session));
                using (var reader = cmd.ExecuteReader())
                {
                    if (reader.Read() && !reader.NextResult()) // num_rows === 1 semantics approximated
                    {
                        DataRow = new DbColumnRow(reader);
                    }
                }
            }
        }
    }

    /// <summary>Tiny assoc-array wrapper mirroring fetch_assoc().</summary>
    public class DbColumnRow
    {
        private readonly System.Collections.Generic.Dictionary<string, object> _values =
            new System.Collections.Generic.Dictionary<string, object>(StringComparer.OrdinalIgnoreCase);

        public DbColumnRow(IDataReader reader)
        {
            for (int i = 0; i < reader.FieldCount; i++)
            {
                _values[reader.GetName(i)] = reader.IsDBNull(i) ? null : reader.GetValue(i);
            }
        }

        public object this[string key]
        {
            get { object v; return _values.TryGetValue(key, out v) ? v : null; }
        }

        public long ToInt64(string key)
        {
            object v = this[key];
            if (v == null) return 0;
            try { return Convert.ToInt64(v); } catch { return 0; }
        }

        public string ToStr(string key)
        {
            object v = this[key];
            return v == null ? "" : v.ToString();
        }
    }
}
