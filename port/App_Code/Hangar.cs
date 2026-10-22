using System;
using System.Collections.Generic;
using System.Data;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.Hangar.php (class `Hangar`).
    /// Same API: setId($uid), repairship(), getHData().
    /// </summary>
    public class Hangar
    {
        private long _uid;

        /// <summary>Hangar::setId($uid).</summary>
        public void SetId(long uid)
        {
            _uid = uid;
        }

        /// <summary>
        /// Hangar::repairship() — free full repair for premium players, otherwise
        /// consumes a repair voucher, then uridium (uri&lt;500 -> zero out, else -500).
        /// PHP die()s on invalid state; we throw so callers can surface the message.
        /// </summary>
        public void RepairShip()
        {
            using (var con = DB.GetInstance())
            {
                object health, premium, uri, vouchers;
                using (var cmd = new MySqlCommand("SELECT premium, uri, health, repairvouchers FROM server_1_players WHERE userID=@u", con))
                {
                    cmd.Parameters.AddWithValue("@u", _uid);
                    using (var rdr = cmd.ExecuteReader())
                    {
                        if (!rdr.Read())
                            throw new InvalidOperationException("Something went wrong!"); // die("Something went wrong!")
                        premium = rdr["premium"];
                        uri = rdr["uri"];
                        health = rdr["health"];
                        vouchers = rdr["repairvouchers"];
                    }
                }

                if (PlayerLog.ToLong(health) != 0)
                    throw new InvalidOperationException("What are you trying?"); // die("What are you trying?")

                // strtotime($res[0]['premium']) vs time()
                DateTime premTs;
                string premStr = Convert.ToString(premium);
                bool premOk = DateTime.TryParse(premStr, System.Globalization.CultureInfo.InvariantCulture,
                    System.Globalization.DateTimeStyles.None, out premTs);
                long premTimestamp = premOk ? new DateTimeOffset(premTs.ToUniversalTime()).ToUnixTimeSeconds() : 0;
                long now = DateTimeOffset.UtcNow.ToUnixTimeSeconds();

                string sql;
                if (now < premTimestamp)
                {
                    sql = "UPDATE server_1_players SET health = 1000 WHERE userID = @u";
                }
                else if (PlayerLog.ToLong(vouchers) > 0)
                {
                    sql = "UPDATE server_1_players SET health = 1000, repairvouchers = repairvouchers-1 WHERE userID = @u";
                }
                else if (PlayerLog.ToLong(uri) < 500)
                {
                    sql = "UPDATE server_1_players SET uri = 0, health = 1000 WHERE userID = @u";
                }
                else
                {
                    sql = "UPDATE server_1_players SET uri = uri-500, health = 1000 WHERE userID = @u";
                }

                using (var cmd = new MySqlCommand(sql, con))
                {
                    cmd.Parameters.AddWithValue("@u", _uid);
                    cmd.ExecuteNonQuery();
                }
            }
        }

        /// <summary>
        /// Hangar::getHData() — returns the $HRow associative array (PHP returned nothing
        /// when the session check failed; here: null in that case).
        /// </summary>
        public Dictionary<string, object> GetHData(System.Web.SessionState.HttpSessionState session)
        {
            // isset($_SESSION['server1']['user']['sessionId'],['email']) && is_numeric(sessionId)
            if (!SessionManager.IsLoggedIn(session)) return null;

            var hrow = new Dictionary<string, object>(StringComparer.OrdinalIgnoreCase);
            using (var con = DB.GetInstance())
            {
                long shipId = 0;
                using (var cmd = new MySqlCommand(
                    @"SELECT server_1_players.health AS hp, server_1_players.Nanohull, server_1_players.MaxNanohull,
                             server_1_players.repairvouchers, server_1_players.jumpvouchers,
                             server_1_player_hangar_general_ship.ship_internal_id AS shipId, server_1_hangar.hangarID
                      FROM server_1_players, server_1_player_hangar_general_ship, server_1_hangar
                      WHERE server_1_players.userID = @u
                        AND server_1_player_hangar_general_ship.hangarID = server_1_hangar.hangarID
                        AND server_1_hangar.userID = @u", con))
                {
                    cmd.Parameters.AddWithValue("@u", _uid);
                    using (var rdr = cmd.ExecuteReader())
                    {
                        if (rdr.Read())
                        {
                            shipId = PlayerLog.ToLong(rdr["shipId"]);
                            hrow["hp"] = rdr["hp"];
                            hrow["Nanohull"] = rdr["Nanohull"];
                            hrow["MaxNanohull"] = rdr["MaxNanohull"];
                            hrow["repairvouchers"] = rdr["repairvouchers"];
                            hrow["jumpvouchers"] = rdr["jumpvouchers"];
                        }
                    }
                }

                using (var cmd = new MySqlCommand(
                    "SELECT ships.HP AS maxhp, ships.shieldAbsorb AS sratio, ships.Speed AS BSpeed, ships.Generators AS Gens FROM ships WHERE ships.Id=@shipId", con))
                {
                    cmd.Parameters.AddWithValue("@shipId", shipId);
                    using (var rdr = cmd.ExecuteReader())
                    {
                        if (rdr.Read())
                        {
                            long maxhp = PlayerLog.ToLong(rdr["maxhp"]);
                            long sratio = PlayerLog.ToLong(rdr["sratio"]);
                            long bspeed = PlayerLog.ToLong(rdr["BSpeed"]);
                            long gens = PlayerLog.ToLong(rdr["Gens"]);
                            hrow["maxhp"] = maxhp;
                            long ratio = 100 - sratio;
                            hrow["ratio"] = sratio + "/" + ratio;
                            hrow["MaxSpeed"] = bspeed + (gens * 10);
                        }
                    }
                }

                using (var cmd = new MySqlCommand(
                    @"SELECT count(*) AS rnd
                            ,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like '%weapon_laser%' AND userID=@u) AS Lasercnt
                            ,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid like 'ammunition_laser%' AND userID=@u) AS Ammocnt
                            ,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid like 'ammunition_rocket%' AND userID=@u) AS Rocketcnt
                            ,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like '%generator_speed%' AND userID=@u) AS Speedgens
                            ,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like '%generator_shield%' AND userID=@u) AS Shieldgens
                            ,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_i%' AND userID=@u) AS Uridrones
                            ,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_f%' AND userID=@u) AS Credrones
                            ,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_a%' AND userID=@u) AS Apis
                            ,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_z%' AND userID=@u) AS Zeus
                            ,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid = 'resource_booty-key' AND userID=@u) AS GreenBKeys
                            ,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid = 'resource_booty-key-red' AND userID=@u) AS RedBKeys
                            ,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid = 'resource_booty-key-blue' AND userID=@u) AS BlueBKeys
                      FROM server_1_player_all_items WHERE userID=@u", con))
                {
                    cmd.Parameters.AddWithValue("@u", _uid);
                    using (var rdr = cmd.ExecuteReader())
                    {
                        if (rdr.Read())
                        {
                            hrow["Lasercnt"] = rdr["Lasercnt"];
                            hrow["Ammocnt"] = rdr["Ammocnt"];
                            hrow["Rocketcnt"] = rdr["Rocketcnt"];
                            hrow["Speedgens"] = rdr["Speedgens"];
                            hrow["Shieldgens"] = rdr["Shieldgens"];
                            hrow["Irescnt"] = rdr["Uridrones"];
                            hrow["Flaxcnt"] = rdr["Credrones"];
                            hrow["Apis"] = rdr["Apis"];
                            hrow["Zeus"] = rdr["Zeus"];

                            long green = PlayerLog.ToLong(rdr["GreenBKeys"]); if (green < 1) green = 0;
                            long red = PlayerLog.ToLong(rdr["RedBKeys"]); if (red < 1) red = 0;
                            long blue = PlayerLog.ToLong(rdr["BlueBKeys"]); if (blue < 1) blue = 0;

                            hrow["BKeys"] = "<span title=\"" + green + " Green Booty Keys\" style=\"color: #00FF00\">" + green + "</span> | " +
                                            "<span title=\"" + red + " Red Booty Keys\" style=\"color: #FF0000\">" + red + "</span> | " +
                                            "<span title=\"" + blue + " Blue Booty Keys\" style=\"color: #0055FF\">" + blue + "</span>";
                        }
                    }
                }
            }
            return hrow;
        }
    }
}
