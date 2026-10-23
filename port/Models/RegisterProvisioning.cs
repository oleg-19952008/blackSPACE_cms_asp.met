using System;
using System.Data;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.reg.php (class `register`).
    /// SuperReg($userId) provisions all per-player rows after account creation:
    /// premium stamp, settings row, hangar + general ship, kill/npc lists, starter items.
    /// </summary>
    public static class Register
    {
        /// <summary>register::SuperReg($id) — returns TRUE once hangar provisioning completed.</summary>
        public static bool SuperReg(long id)
        {
            long pid;
            using (var con = DB.GetInstance())
            {
                using (var cmd = new MySqlCommand("SELECT playerID FROM server_1_players WHERE userID=@uid", con))
                {
                    cmd.Parameters.AddWithValue("@uid", id);
                    object o = cmd.ExecuteScalar();
                    if (o == null || o == DBNull.Value) return false; // PHP: no result rows -> NULL
                    pid = PlayerLog.ToLong(o);
                }

                PremiumSet(con, pid);
                MakeSettings(con, id, pid);
                HangarReg(con, id, pid);
            }
            return true;
        }

        /// <summary>register::premiumSet().</summary>
        private static void PremiumSet(MySqlConnection con, long pid)
        {
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET premium=CURRENT_TIMESTAMP WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>register::hangarID() — SELECT hangarID for the fresh user/player.</summary>
        private static long HangarId(MySqlConnection con, long uid, long pid)
        {
            using (var cmd = new MySqlCommand("SELECT hangarID FROM server_1_hangar WHERE userID=@uid AND playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.Parameters.AddWithValue("@pid", pid);
                object o = cmd.ExecuteScalar();
                return PlayerLog.ToLong(o);
            }
        }

        /// <summary>register::makeSettings().</summary>
        private static void MakeSettings(MySqlConnection con, long uid, long pid)
        {
            using (var cmd = new MySqlCommand("INSERT INTO `server_1_player_settings` (`userID`, `playerID`) VALUES (@uid, @pid)", con))
            {
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>register::hangarReg().</summary>
        private static void HangarReg(MySqlConnection con, long uid, long pid)
        {
            RankingList(con, pid);

            long hid;
            using (var cmd = new MySqlCommand(
                "INSERT INTO `server_1_hangar` (`hangar_is_active`, `hangar_is_selected`, `name`, `userID`, `playerID`) VALUES (1, 1, 'Hangar 1', @uid, @pid)", con))
            {
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.ExecuteNonQuery();
            }

            hid = HangarId(con, uid, pid);
            HangarGeneral(con, hid, pid);
        }

        /// <summary>register::rankingList() (+ npcList).</summary>
        private static void RankingList(MySqlConnection con, long pid)
        {
            using (var cmd = new MySqlCommand("INSERT INTO `player_kills_count` (`playerID`) VALUES (@pid)", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.ExecuteNonQuery();
            }
            NpcList(con, pid);
        }

        private static void NpcList(MySqlConnection con, long pid)
        {
            using (var cmd = new MySqlCommand("INSERT INTO `npc_kills` (`playerID`) VALUES (@pid)", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>register::HangarGeneral() — phoenix, ship_internal_id=1, hp=4000.</summary>
        private static void HangarGeneral(MySqlConnection con, long hid, long pid)
        {
            using (var cmd = new MySqlCommand(
                "INSERT INTO `server_1_player_hangar_general_ship` (`hangarID`, `playerID`, `ship_internal_id`, `ship_hp`, `ship_selected_model`) VALUES (@hid, @pid, 1, 4000, 'ship_phoenix')", con))
            {
                cmd.Parameters.AddWithValue("@hid", hid);
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.ExecuteNonQuery();
            }
            ShipConfig(con, hid, pid);
            ShipItem(con, hid, pid);
        }

        /// <summary>register::shipConfig() — two config rows (configNum 1..2).</summary>
        private static void ShipConfig(MySqlConnection con, long hid, long pid)
        {
            // resolve userID from playerID like PHP $this->uid did at insert time
            long uid;
            using (var cmd = new MySqlCommand("SELECT userID FROM server_1_players WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                uid = PlayerLog.ToLong(cmd.ExecuteScalar());
            }
            for (int count = 1; count <= 2; count++)
            {
                using (var cmd = new MySqlCommand(
                    "INSERT INTO `server_1_hangar_config_ship` (`hangarID`, `playerID`, `userID`, `configNum`) VALUES (@hid, @pid, @uid, @cn)", con))
                {
                    cmd.Parameters.AddWithValue("@hid", hid);
                    cmd.Parameters.AddWithValue("@pid", pid);
                    cmd.Parameters.AddWithValue("@uid", uid);
                    cmd.Parameters.AddWithValue("@cn", count);
                    cmd.ExecuteNonQuery();
                }
            }
        }

        /// <summary>register::ShipItem() — logfile + repbot + phoenix item rows.</summary>
        private static void ShipItem(MySqlConnection con, long hid, long pid)
        {
            long uid;
            using (var cmd = new MySqlCommand("SELECT userID FROM server_1_players WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                uid = PlayerLog.ToLong(cmd.ExecuteScalar());
            }
            InsertItem(con, "resource_logfile", 1, 0, pid, uid);          // logitem()
            InsertItem(con, "equipment_extra_repbot_rep-4", 1, 0, pid, uid); // repBot()
            InsertItem(con, "ship_phoenix", 1, 1, pid, uid);              // ShipItem()
        }

        private static void InsertItem(MySqlConnection con, string lootid, int q, int interactive, long pid, long uid)
        {
            using (var cmd = new MySqlCommand(
                "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (@loot, @q, @inter, @pid, @uid)", con))
            {
                cmd.Parameters.AddWithValue("@loot", lootid);
                cmd.Parameters.AddWithValue("@q", q);
                cmd.Parameters.AddWithValue("@inter", interactive);
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.ExecuteNonQuery();
            }
        }
    }
}
