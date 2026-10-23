using System;
using System.Collections.Generic;
using System.Globalization;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.Ships.php (class `ShipsNpc`, 15 lines) — PORTING-PLAN A7.1.
    /// Tiny session-bootstrap helper used by the NPC/game-facing pages: if a server1 session
    /// exists and its sessionId is numeric, loads the joined users+server_1_players row into
    /// <see cref="DataRow"/>.
    ///
    /// PHP quirks preserved:
    ///  - guard is isset(sessionId, email) && is_numeric(sessionId) — SessionManager.IsLoggedIn
    ///    implements exactly that (email presence + numeric sessionId);
    ///  - DataRow only assigned when num_rows === 1 — multi-row result leaves it null (as in PHP);
    ///  - original interpolated $_SESSION values straight into SQL (injection) — parameterized here,
    ///    same as Users.CheckSession() did for its identical query.
    /// </summary>
    public class ShipsNpc
    {
        public DbColumnRow DataRow = null; // public $DataRow

        /// <summary>ShipsNpc::checkSession() — global $MySQLi → DB.GetMySQLi().</summary>
        public void CheckSession()
        {
            var session = AppEnvironment.Current != null ? AppEnvironment.Current.Session : null;
            if (session == null || !SessionManager.IsLoggedIn(session)) return;

            using (var mysql = DB.GetMySQLi())
            using (var cmd = new MySqlCommand(
                "SELECT users.ID, users.Email, users.Name, server_1_players.playerID, " +
                "server_1_players.shipId, server_1_players.factionId, server_1_players.credits, " +
                "server_1_players.uri, server_1_players.level, server_1_players.exp, " +
                "server_1_players.honor, server_1_players.maxHealth, server_1_players.Health " +
                "FROM users, server_1_players " +
                "WHERE users.sessionId = @sid AND users.Email = @email " +
                "AND server_1_players.userID = users.ID", mysql))
            {
                cmd.Parameters.AddWithValue("@sid", SessionManager.SessionId(session));
                cmd.Parameters.AddWithValue("@email", SessionManager.Email(session));
                using (var reader = cmd.ExecuteReader())
                {
                    // $userRow->num_rows === 1 — fetch_assoc only on exactly one row
                    if (reader.Read() && !reader.NextResult())
                    {
                        DataRow = new DbColumnRow(reader);
                    }
                }
            }
        }
    }
}
