using System;
using System.Collections.Generic;
using System.Globalization;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.voucher.php (class `voucher`).
    /// Redeem voucher keys from server_1_voucher; grants uridium/credits/jackpot
    /// or item bundles encoded base64(JSON) in the vpro column.
    /// </summary>
    public class Voucher
    {
        private long _uid;
        private long _pid;

        public long Uridium { get; private set; }
        public long Credits { get; private set; }
        public long Jackpot { get; private set; }

        /// <summary>voucher::setId($uid,$pid) — refreshes balances via money().</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
            Money();
        }

        /// <summary>voucher::money().</summary>
        public void Money()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT uri, credits, jackpot FROM server_1_players WHERE userID=@uid AND playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (rdr.Read())
                    {
                        Uridium = PlayerLog.ToLong(rdr["uri"]);
                        Credits = PlayerLog.ToLong(rdr["credits"]);
                        Jackpot = PlayerLog.ToLong(rdr["jackpot"]);
                    }
                }
            }
        }

        private bool CheckExistence(string lootid, long pid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT id FROM server_1_player_all_items WHERE playerID = @pid AND lootid = @loot", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.Parameters.AddWithValue("@loot", lootid);
                object o = cmd.ExecuteScalar();
                return o != null && o != DBNull.Value;
            }
        }

        private long GetUserIdFromPid(long pid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT userID FROM server_1_players WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                return PlayerLog.ToLong(cmd.ExecuteScalar());
            }
        }

        /// <summary>voucher::giveVoucherItems($itemsJson) — base64(JSON){key:{a,i,e}}.</summary>
        private Dictionary<string, string> GiveVoucherItems(string itemsJson)
        {
            Dictionary<string, dynamic> vItem;
            try
            {
                string json = System.Text.Encoding.UTF8.GetString(Convert.FromBase64String(itemsJson));
                vItem = Newtonsoft.Json.JsonConvert.DeserializeObject<Dictionary<string, dynamic>>(json);
            }
            catch (Exception)
            {
                return Msg("Something went wrong, contact support", "error");
            }
            if (vItem == null) return Msg("Something went wrong, contact support", "error");

            foreach (var kv in vItem)
            {
                string key = kv.Key;
                var value = (IDictionary<string, object>)kv.Value;
                long am = PlayerLog.ToLong(GetStr(value, "a"));

                if (key == "uridium")
                {
                    UpdatePlayerBalance("uri", am);
                }
                else if (key == "credits")
                {
                    UpdatePlayerBalance("credits", am);
                }
                else if (key == "jackpot")
                {
                    UpdatePlayerBalance("jackpot", am);
                }
                else
                {
                    long interactive = PlayerLog.ToLong(GetStr(value, "i"));
                    long e = PlayerLog.ToLong(value.ContainsKey("e") ? GetStr(value, "e") : null);

                    if (interactive == 1)
                    {
                        if (!CheckExistence(key, _pid))
                            InsertItem(key, am, interactive);
                    }
                    else if (e == 1)
                    {
                        // PHP inserted Q=1 rows in a loop for "each"-style vouchers
                        for (int i = 0; i < am; i++)
                            InsertItem(key, 1, interactive);
                    }
                    else
                    {
                        if (CheckExistence(key, _pid))
                        {
                            using (var con = DB.GetInstance())
                            using (var cmd = new MySqlCommand("UPDATE `server_1_player_all_items` SET Q = Q + @am WHERE playerID=@pid AND lootid=@loot", con))
                            {
                                cmd.Parameters.AddWithValue("@am", am);
                                cmd.Parameters.AddWithValue("@pid", _pid);
                                cmd.Parameters.AddWithValue("@loot", key);
                                cmd.ExecuteNonQuery();
                            }
                        }
                        else
                        {
                            InsertItem(key, am, interactive);
                        }
                    }
                }
            }
            return Msg("You used your voucher!", "success");
        }

        private void UpdatePlayerBalance(string column, long am)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET " + column + " = " + column + " + @am WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@am", am);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.ExecuteNonQuery();
            }
        }

        private void InsertItem(string lootid, long q, long interactive)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (@loot, @q, @inter, @pid, @uid)", con))
            {
                cmd.Parameters.AddWithValue("@loot", lootid);
                cmd.Parameters.AddWithValue("@q", q);
                cmd.Parameters.AddWithValue("@inter", interactive);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>voucher::updateVoucherUsed($args,$key) — appends pid to pipe-list vuser, bumps vused.</summary>
        private bool UpdateVoucherUsed(List<string> args, string key)
        {
            args.Add(_pid.ToString(CultureInfo.InvariantCulture));
            string ar = string.Join("|", args);
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE `server_1_voucher` SET vuser = @vuser, vused = vused+1 WHERE vkey=@vkey", con))
            {
                cmd.Parameters.AddWithValue("@vuser", ar);
                cmd.Parameters.AddWithValue("@vkey", key);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        /// <summary>voucher::redeemVoucher($key).</summary>
        public Dictionary<string, string> RedeemVoucher(string key)
        {
            Dictionary<string, string> row;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT * FROM server_1_voucher WHERE vkey = @key", con))
            {
                cmd.Parameters.AddWithValue("@key", key);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (!rdr.Read())
                        return Msg("The Voucher does not exits", "error");
                    row = Unity.RowToDict(rdr);
                }
            }

            if (PlayerLog.ToLong(row.ContainsKey("active") ? row["active"] : "0") != 1)
                return Msg("The Voucher does not exits", "error");

            long vused = PlayerLog.ToLong(row.ContainsKey("vused") ? row["vused"] : "0");
            long vavi = PlayerLog.ToLong(row.ContainsKey("vavi") ? row["vavi"] : "0");
            if (vused >= vavi)
                return Msg("The Voucher does not exits", "error");

            var vUs = new List<string>((row.ContainsKey("vuser") ? row["vuser"] : "").Split('|'));
            string pidStr = _pid.ToString(CultureInfo.InvariantCulture);
            if (vUs.Contains(pidStr))
                return Msg("You have already used this Voucher", "error");

            if (UpdateVoucherUsed(vUs, key))
                return GiveVoucherItems(row.ContainsKey("vpro") ? row["vpro"] : "");

            return Msg("Something went wrong, contact support", "error");
        }

        private static Dictionary<string, string> Msg(string logMessage, string type)
        {
            return new Dictionary<string, string> { { "log_message", logMessage }, { "type", type } };
        }

        private static string GetStr(IDictionary<string, object> d, string key)
        {
            object o;
            if (!d.TryGetValue(key, out o) || o == null) return null;
            return Convert.ToString(o, System.Globalization.CultureInfo.InvariantCulture);
        }
    }
}
