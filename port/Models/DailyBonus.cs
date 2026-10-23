using System;
using System.Collections.Generic;
using System.Globalization;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.dailybonus.php (class `dailybonus`).
    /// 5-day login streak stored in server_1_players.dbonus as "level|timestamp".
    /// </summary>
    public class DailyBonus
    {
        private long _uid;
        private string _reward = "";
        private int _rewardLevel;

        public Dictionary<string, string> Data { get; private set; }
        /// <summary>$layer — "yes" when a bonus is claimable, "no" otherwise.</summary>
        public string Layer { get; private set; }

        public void SetId(long uid)
        {
            _uid = uid;
        }

        public Dictionary<string, string> GetData() { return Data; }
        public string GetState() { return Layer; }

        /// <summary>dailybonus::getBonus($day) — day ∈ one..five.</summary>
        private static Dictionary<string, string[]> GetBonus(string day)
        {
            var bonus = new Dictionary<string, Dictionary<string, string[]>>
            {
                { "one",   new Dictionary<string, string[]> { { "loot",   new[] { "credits", "plt2026", "ggspin" } },
                                                              { "count",  new[] { "50000", "100", "5" } } } },
                { "two",   new Dictionary<string, string[]> { { "loot",   new[] { "mcb25", "credits", "ggspin" } },
                                                              { "count",  new[] { "750", "85000", "5" } } } },
                { "three", new Dictionary<string, string[]> { { "loot",   new[] { "plt2021", "jumpvoucher", "ggspin" } },
                                                              { "count",  new[] { "150", "3", "5" } } } },
                { "four",  new Dictionary<string, string[]> { { "loot",   new[] { "resource_lgf", "uridium", "ggspin" } },
                                                              { "count",  new[] { "5", "250", "5" } } } },
                { "five",  new Dictionary<string, string[]> { { "loot",   new[] { "mcb50", "repairvoucher", "wizx" } },
                                                              { "count",  new[] { "1000", "3", "5" } } } },
            };
            Dictionary<string, string[]> d;
            return bonus.TryGetValue(day, out d) ? d : null;
        }

        /// <summary>dailybonus::init() — decide whether today's streak box is claimable.</summary>
        private bool Init()
        {
            string dbonus;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT dbonus FROM server_1_players WHERE userID=@uid", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                object o = cmd.ExecuteScalar();
                if (o == null || o == DBNull.Value) return false; // rowCount()==0 parity
                dbonus = Convert.ToString(o);
            }

            string[] arr = (dbonus ?? "").Split('|');
            int level = arr.Length > 0 ? ParseInt(arr[0]) : 0;
            long timestamp = arr.Length > 1 ? ParseLong(arr[1]) : 0;

            long time = DateTimeOffset.Now.ToUnixTimeSeconds();

            // ($b['timestamp'] + 86400) <= $time && $time <= ($b['timestamp'] + 192800) || $b['timestamp'] == 0
            if ((timestamp + 86400 <= time && time <= timestamp + 192800) || timestamp == 0)
            {
                switch (level)
                {
                    case 1: _reward = "one"; break;
                    case 2: _reward = "two"; break;
                    case 3: _reward = "three"; break;
                    case 4: _reward = "four"; break;
                    case 5: _reward = "five"; break;
                    default:
                        if (level > 5) return false;
                        return false; // no reward mapped for level 0 etc.
                }
                _rewardLevel = level;
                Layer = "yes";
                return true;
            }
            else if (time >= timestamp + 192800 && timestamp != 0)
            {
                _rewardLevel = 1;
                _reward = "one";
                Layer = "yes";
                return true;
            }
            Layer = "no";
            return false;
        }

        /// <summary>dailybonus::executeb() — requires logged-in session (PHP checked $_SESSION inline).</summary>
        public void ExecuteB(Microsoft.AspNetCore.Http.ISession session)
        {
            if (!SessionManager.IsLoggedIn(session)) return;
            if (!Init()) return;

            var btype = GetBonus(_reward);
            if (btype == null) return;
            string[] loot = btype["loot"];
            string[] count = btype["count"];

            for (int i = 0; i < 3; i++)
            {
                string item = loot[i];
                long cnt = ParseLong(count[i]);
                switch (item)
                {
                    case "credits":
                        UpdatePlayerColumn("credits", cnt);
                        break;
                    case "uridium":
                        UpdatePlayerColumn("uri", cnt);
                        break;
                    case "ggspin":
                        UpdatePlayerColumn("GGspins", cnt);
                        break;
                    case "jumpvoucher":
                        UpdatePlayerColumn("jumpvouchers", cnt);
                        break;
                    case "repairvoucher":
                        UpdatePlayerColumn("repairvouchers", cnt);
                        break;
                    default:
                        GiveAmmoOrItem(item, cnt);
                        break;
                }
            }

            var bdata = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase);
            bdata["headline"] = (_rewardLevel != 5)
                ? "You logged in today and get the following bonus. Login tomorrow to get the next bonus."
                : "You get the last bonus. Login tomorrow to get this bonus again.";

            string sampleActive = "active", sampleComming = "comming", sampleReceived = "received";
            string iconDiv = "<div class=\"dl_bonus_received_icon\"><img src=\"do_img/global/pilotSheet/dailyLogin/icon_received.png?__cv=b8d2514ac1824664d197db0587498800\" width=\"21\" height=\"22\"></div>";
            string noiconDiv = " ";

            Func<int, string> boxstate = n => (_rewardLevel == n) ? sampleActive : ((_rewardLevel > n) ? sampleReceived : sampleComming);
            bdata["boxstate_1"] = boxstate(1);
            bdata["boxstate_2"] = boxstate(2);
            bdata["boxstate_3"] = boxstate(3);
            bdata["boxstate_4"] = boxstate(4);
            bdata["boxstate_5"] = boxstate(5);

            bdata["boxstate_1_icon"] = (_rewardLevel == 1) ? noiconDiv : iconDiv;
            bdata["boxstate_2_icon"] = (_rewardLevel < 3) ? noiconDiv : iconDiv;
            bdata["boxstate_3_icon"] = (_rewardLevel < 4) ? noiconDiv : iconDiv;
            bdata["boxstate_4_icon"] = (_rewardLevel < 5) ? noiconDiv : iconDiv;
            bdata["boxstate_5_icon"] = (_rewardLevel != 5) ? noiconDiv : iconDiv;

            bdata["progressbar"] = _rewardLevel.ToString(CultureInfo.InvariantCulture);

            int next = (_rewardLevel != 5) ? _rewardLevel + 1 : _rewardLevel;
            string dbdata = next + "|" + DateTimeOffset.Now.ToUnixTimeSeconds().ToString(CultureInfo.InvariantCulture);
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET dbonus = @level WHERE userID = @uid", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@level", dbdata);
                cmd.ExecuteNonQuery();
            }

            Data = bdata;
        }

        private void UpdatePlayerColumn(string column, long cnt)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET " + column + " = " + column + " + @count WHERE userID = @uid", con))
            {
                cmd.Parameters.AddWithValue("@count", cnt);
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>Ammo-column path (server_1_player_ammunation) with fallback to all_items insert.</summary>
        private void GiveAmmoOrItem(string lootid, long cnt)
        {
            using (var con = DB.GetInstance())
            {
                object exists;
                using (var cmd = new MySqlCommand("SELECT playerID FROM server_1_player_ammunation WHERE playerID = @uid", con))
                {
                    cmd.Parameters.AddWithValue("@uid", _uid);
                    exists = cmd.ExecuteScalar();
                }
                if (exists != null && exists != DBNull.Value)
                {
                    // PHP interpolated the loot key straight into the SQL; whitelist it first.
                    if (!IsSafeIdentifier(lootid)) return;
                    using (var cmd = new MySqlCommand("UPDATE server_1_player_ammunation SET " + lootid + " = " + lootid + " + @count WHERE playerID = @uid", con))
                    {
                        cmd.Parameters.AddWithValue("@count", cnt);
                        cmd.Parameters.AddWithValue("@uid", _uid);
                        cmd.ExecuteNonQuery();
                    }
                }
                else
                {
                    using (var cmd = new MySqlCommand(
                        "INSERT INTO server_1_player_all_items (`lootid`, `Q`, `properties`, `interactive`, `playerID`, `userID`) VALUES (@type, @count, '0', 0, @uid, @uid2)", con))
                    {
                        cmd.Parameters.AddWithValue("@type", lootid);
                        cmd.Parameters.AddWithValue("@count", cnt);
                        cmd.Parameters.AddWithValue("@uid", _uid);
                        cmd.Parameters.AddWithValue("@uid2", _uid);
                        cmd.ExecuteNonQuery();
                    }
                }
            }
        }

        private static bool IsSafeIdentifier(string s)
        {
            if (string.IsNullOrEmpty(s)) return false;
            foreach (char c in s)
                if (!(char.IsLetterOrDigit(c) || c == '_')) return false;
            return true;
        }

        private static int ParseInt(string s)
        {
            int v; return int.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        private static long ParseLong(string s)
        {
            long v; return long.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }
    }
}
