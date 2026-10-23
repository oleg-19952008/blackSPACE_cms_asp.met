using System;
using System.Collections.Generic;
using System.Data;
using System.Globalization;
using System.Net.Mail;
using System.Text;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.unity.php (class `unity`) — account-level operations:
    /// rank lists, level correction, name/password change & recovery, IP bans,
    /// premium time (cPT/aPT/sPT), donation items (gDI), email verify, register helpers.
    /// </summary>
    public class Unity
    {
        private long _uid;
        private long _pid;

        /// <summary>$this->crypto — the users-row loaded by checkNamechange()/checkPwRecover().</summary>
        private Dictionary<string, string> _crypto = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase);

        public long Uridium { get; private set; }
        public long Credits { get; private set; }

        // ---------------------------------------------------------------- basics

        /// <summary>unity::setId($uid,$pid).</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
        }

        /// <summary>unity::get_client_ip() — env-based chain, 'UNKNOWN' fallback.</summary>
        public static string GetClientIp()
        {
            var env = AppEnvironment.Current;
            if (env == null || env.Context == null) return "UNKNOWN";
            string[] keys = { "HTTP_CLIENT_IP", "HTTP_X_FORWARDED_FOR", "HTTP_X_FORWARDED",
                              "HTTP_FORWARDED_FOR", "HTTP_FORWARDED", "REMOTE_ADDR" };
            foreach (var k in keys)
            {
                string v = env.GetServerVariable(k);
                if (!string.IsNullOrEmpty(v)) return v;
            }
            return "UNKNOWN";
        }

        /// <summary>unity::applyRankList($pid) — ensure player_kills_count row exists.</summary>
        public void ApplyRankList(long pid)
        {
            using (var con = DB.GetInstance())
            {
                object o;
                using (var cmd = new MySqlCommand("SELECT playerID FROM player_kills_count WHERE playerID=@pid", con))
                {
                    cmd.Parameters.AddWithValue("@pid", pid);
                    o = cmd.ExecuteScalar();
                }
                if (o == null || o == DBNull.Value)
                {
                    using (var cmd = new MySqlCommand("INSERT INTO `player_kills_count` (`playerID`) VALUES (@pid)", con))
                    {
                        cmd.Parameters.AddWithValue("@pid", pid);
                        cmd.ExecuteNonQuery();
                    }
                }
            }
        }

        /// <summary>unity::applyRankListNpc($pid) — ensure npc_kills row exists.</summary>
        public void ApplyRankListNpc(long pid)
        {
            using (var con = DB.GetInstance())
            {
                object o;
                using (var cmd = new MySqlCommand("SELECT playerID FROM npc_kills WHERE playerID=@pid", con))
                {
                    cmd.Parameters.AddWithValue("@pid", pid);
                    o = cmd.ExecuteScalar();
                }
                if (o == null || o == DBNull.Value)
                {
                    using (var cmd = new MySqlCommand("INSERT INTO `npc_kills` (`playerID`) VALUES (@pid)", con))
                    {
                        cmd.Parameters.AddWithValue("@pid", pid);
                        cmd.ExecuteNonQuery();
                    }
                }
            }
        }

        private bool UpdateLevel(int level)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET level = @level WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@level", level);
                cmd.Parameters.AddWithValue("@pid", _pid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        /// <summary>
        /// unity::levelCorrection() — recompute level from exp against the 0..40 threshold table.
        /// Returns the new level, or -1 when no rows (PHP returned NULL implicitly).
        /// </summary>
        public int LevelCorrection()
        {
            double exp;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT exp FROM server_1_players WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (!rdr.Read()) return -1;
                    exp = PlayerLog.ToDouble(rdr["exp"]);
                }
            }

            // array slutter med level 40
            double[] levels = {
                0, 10000, 20000, 40000, 80000, 160000, 320000, 640000, 1280000, 2560000,
                5120000, 10240000, 20480000, 40960000, 81920000, 163840000, 327680000, 655360000, 1310720000,
                2621440000, 5242880000, 10485760000, 20971520000, 41943040000, 83886080000, 167772160000, 335544320000,
                671088640000, 1342177280000, 2684354560000, 5368709120000, 10737418240000, 21474836480000,
                42949672960000, 85899345920000, 171798691840000, 343597383680000, 687194767360000, 1374389534720000, 2748779069440000
            };
            for (int key = 0; key < levels.Length; key++)
            {
                if (exp < levels[key])
                {
                    UpdateLevel(key);
                    return key;
                }
            }
            return -1;
        }

        /// <summary>unity::getResolution($id).</summary>
        public string GetResolution(long id)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT res FROM server_1_player_settings WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", id);
                object o = cmd.ExecuteScalar();
                return o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }
        }

        /// <summary>unity::everisign($id) — users.verified flag.</summary>
        public string Everisign(long id)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT verified FROM users WHERE ID=@id", con))
            {
                cmd.Parameters.AddWithValue("@id", id);
                object o = cmd.ExecuteScalar();
                return o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }
        }

        private Dictionary<string, string> GetUserInfo(long uid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT * FROM users WHERE ID=@id", con))
            {
                cmd.Parameters.AddWithValue("@id", uid);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (rdr.Read()) return RowToDict(rdr);
                }
            }
            return null;
        }

        internal static Dictionary<string, string> RowToDict(MySqlDataReader rdr)
        {
            var row = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase);
            for (int i = 0; i < rdr.FieldCount; i++)
                row[rdr.GetName(i)] = rdr.IsDBNull(i) ? "" : Convert.ToString(rdr.GetValue(i), CultureInfo.InvariantCulture);
            return row;
        }

        internal string CryptoGet(string key, string fallback = "")
        {
            string v;
            return _crypto.TryGetValue(key, out v) ? v : fallback;
        }

        // ------------------------------------------------------- name change

        private string UpdateName(string newName)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE users SET Name =@Name, change_username='0' WHERE ID=@id", con))
            {
                cmd.Parameters.AddWithValue("@Name", newName);
                cmd.Parameters.AddWithValue("@id", PlayerLog.ToLong(CryptoGet("ID")));
                if (cmd.ExecuteNonQuery() >= 0)
                    return "Your username has changed to " + newName;
                return "Something went wrong, contact support!";
            }
        }

        /// <summary>unity::checkNamechange($scode) — consumed by emailconfirmation/nameChange.php (part 3).</summary>
        public object CheckNamechange(string scode)
        {
            Dictionary<string, string> row;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT * FROM users WHERE change_username=@scode LIMIT 1", con))
            {
                cmd.Parameters.AddWithValue("@scode", scode);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (!rdr.Read()) return false;
                    row = RowToDict(rdr);
                }
            }
            string cu = row.ContainsKey("change_username") ? row["change_username"] : "0";
            if (cu != "0") // PHP: ($cu!="0" OR $cu!=0) — loose comparison collapses to a single string check here
            {
                _crypto = row;
                // mysqli_real_escape_string(trim(base64_decode($scode))) — parameterised instead.
                string newName;
                try { newName = Encoding.UTF8.GetString(Convert.FromBase64String(scode)).Trim(); }
                catch (FormatException) { newName = ""; }
                return UpdateName(newName);
            }
            return false;
        }

        private string SetNewNameAcceptance(string new_)
        {
            var info = GetUserInfo(_uid);
            string newNm = Convert.ToBase64String(Encoding.UTF8.GetBytes(new_));
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE users SET change_username =@nm WHERE ID=@id", con))
            {
                cmd.Parameters.AddWithValue("@nm", newNm);
                cmd.Parameters.AddWithValue("@id", _uid);
                if (cmd.ExecuteNonQuery() >= 0)
                {
                    UnityMailer.MailSystem(
                        header: new Dictionary<string, string> {
                            { "mailfrom", "no-reply@DarkSpace.net" },
                            { "template", "changename" },
                            { "subject", "Dark Space Confirm Name Change" }
                        },
                        content: new Dictionary<string, string> {
                            { "newname", new_ },
                            { "username", info != null && info.ContainsKey("Name") ? info["Name"] : "" },
                            { "link", "http://DarkSpace.net/emailconfirmation/nameChange.php?s=" + Uri.EscapeDataString(newNm) },
                            { "reasonforemail", "Name Change" },
                            { "author", "Best Regards <br /> Dark Space Staff Team" },
                            { "year", DateTime.Now.Year.ToString(CultureInfo.InvariantCulture) }
                        },
                        recivers: new List<string> { info != null && info.ContainsKey("Email") ? info["Email"] : "" });
                    return "{\"status\":\"OK\",\"message\":\"Confirmation email was sent.\"}";
                }
            }
            return null;
        }

        /// <summary>unity::changeName($newName).</summary>
        public string ChangeName(string newName)
        {
            if (newName.Length < 3)
                return "{\"status\":\"ERROR\",\"message\":\"Username must be longer than 3 character\"}";
            if (newName.Length > 40)
                return "{\"status\":\"ERROR\",\"message\":\"Username must be less than 40 character\"}";

            using (var con = DB.GetInstance())
            {
                object dup;
                using (var cmd = new MySqlCommand("SELECT ID FROM users WHERE Name=@Name", con))
                {
                    cmd.Parameters.AddWithValue("@Name", newName);
                    dup = cmd.ExecuteScalar();
                }
                if (dup == null || dup == DBNull.Value)
                    return SetNewNameAcceptance(newName);
                return "{\"status\":\"ERROR\",\"message\":\"This Pilot name is already in use.\"}";
            }
        }

        // ---------------------------------------------------- password recovery

        /// <summary>unity::saveNewPassword($pw,$cpw) — requires prior CheckPwRecover($scode).</summary>
        public string SaveNewPassword(string pw, string cpw)
        {
            if (pw != cpw)
                return "The passwords does NOT match!";

            string banned = CryptoGet("banned", "0");
            if (banned != "0")
                return "You has been banned!";

            var enc = new Encryption(AppConfig.EncryptionKey);
            string newPw = enc.Encrypt(pw);
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE users SET pwHash =@pwhash, change_password='0' WHERE ID=@id", con))
            {
                cmd.Parameters.AddWithValue("@pwhash", newPw);
                cmd.Parameters.AddWithValue("@id", PlayerLog.ToLong(CryptoGet("ID")));
                if (cmd.ExecuteNonQuery() >= 0)
                    return "Your Password has been changed";
                return "Something went wrong, contact support!";
            }
        }

        /// <summary>unity::checkPwRecover($scode).</summary>
        public bool CheckPwRecover(string scode)
        {
            Dictionary<string, string> row;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT * FROM users WHERE change_password=@scode LIMIT 1", con))
            {
                cmd.Parameters.AddWithValue("@scode", scode);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (!rdr.Read()) return false;
                    row = RowToDict(rdr);
                }
            }
            string cp = row.ContainsKey("change_password") ? row["change_password"] : "0";
            if (cp != "0")
            {
                _crypto = row;
                return true;
            }
            return false;
        }

        private string SetPwRecoverAcceptance(Dictionary<string, string> args)
        {
            string num = Core.GenerateRandom(25);
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE users SET `change_password`=@num WHERE ID=@id", con))
            {
                cmd.Parameters.AddWithValue("@num", num);
                cmd.Parameters.AddWithValue("@id", PlayerLog.ToLong(args["ID"]));
                if (cmd.ExecuteNonQuery() >= 0)
                {
                    UnityMailer.MailSystem(
                        header: new Dictionary<string, string> {
                            { "mailfrom", "no-reply@DarkSpace.net" },
                            { "template", "pwRecover" },
                            { "subject", "Dark Space Password Recovery" }
                        },
                        content: new Dictionary<string, string> {
                            { "username", args.ContainsKey("Name") ? args["Name"] : "" },
                            { "link", "http://DarkSpace.net/emailconfirmation/pwRecover.php?s=" + num },
                            { "reasonforemail", "Password Recovery" },
                            { "author", "Best Regards <br /> Dark Space Staff Team" },
                            { "year", DateTime.Now.Year.ToString(CultureInfo.InvariantCulture) }
                        },
                        recivers: new List<string> { args.ContainsKey("Email") ? args["Email"] : "" });
                    return "<div>Password Recovery email was sent to you!</div>";
                }
            }
            return null;
        }

        /// <summary>unity::passwordRecovery($email).</summary>
        public string PasswordRecovery(string email)
        {
            if (IsValidEmail(email))
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand("SELECT * FROM users WHERE Email=@Email", con))
                {
                    cmd.Parameters.AddWithValue("@Email", email);
                    using (var rdr = cmd.ExecuteReader())
                    {
                        if (rdr.Read())
                            return SetPwRecoverAcceptance(RowToDict(rdr));
                        return "<div>Email Does not exist!</div>";
                    }
                }
            }
            return "<div>Invalid email!</div>";
        }

        // ------------------------------------------------------------ ip bans

        /// <summary>unity::checkIpBan($ip).</summary>
        public bool CheckIpBan(string ip)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT period FROM ip_bans WHERE IP=@ip", con))
            {
                cmd.Parameters.AddWithValue("@ip", ip);
                object o = cmd.ExecuteScalar();
                if (o == null || o == DBNull.Value) return false;
                return Cpt(Convert.ToString(o));
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

        // ------------------------------------------------------ registration

        /// <summary>unity::registerNewAccount($pid) — INSERT INTO server_1_players.</summary>
        public bool RegisterNewAccount(long pid)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand(
                    "INSERT INTO server_1_players (playerID, overallRank, userId, settings) VALUES (@pid, @pid2, @pid3, '')", con))
                {
                    cmd.Parameters.AddWithValue("@pid", pid);
                    cmd.Parameters.AddWithValue("@pid2", pid);
                    cmd.Parameters.AddWithValue("@pid3", pid);
                    return cmd.ExecuteNonQuery() > 0;
                }
            }
            catch (MySqlException e)
            {
                throw new ApplicationException("Error!: " + e.Message, e); // PHP printed & die()d
            }
        }

        /// <summary>unity::updateAccount($pid) — users.Servers = '[{1:pid}]'.</summary>
        public bool UpdateAccount(long pid)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand("UPDATE users SET Servers = @srv WHERE ID = @id", con))
                {
                    cmd.Parameters.AddWithValue("@srv", "[{1:" + pid + "}]");
                    cmd.Parameters.AddWithValue("@id", pid);
                    return cmd.ExecuteNonQuery() >= 0;
                }
            }
            catch (MySqlException e)
            {
                throw new ApplicationException("Error!: " + e.Message, e);
            }
        }

        /// <summary>unity::regAmmo($pid) — create the ammunition row.</summary>
        public bool RegAmmo(long pid)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand("INSERT INTO server_1_player_ammunation (playerID) VALUES (@pid)", con))
                {
                    cmd.Parameters.AddWithValue("@pid", pid);
                    return cmd.ExecuteNonQuery() > 0;
                }
            }
            catch (MySqlException e)
            {
                throw new ApplicationException("Error!: " + e.Message, e);
            }
        }

        // ----------------------------------------------------- premium / gDI

        /// <summary>unity::cPT($timestamp) — time() &lt; strtotime($timestamp) (server local tz like PHP).</summary>
        public static bool Cpt(string timestamp)
        {
            DateTime ts;
            if (!DateTime.TryParse(timestamp, CultureInfo.InvariantCulture, DateTimeStyles.None, out ts))
                return false; // strtotime failure => false in the comparison
            return DateTimeOffset.Now.LocalDateTime < ts;
        }

        /// <summary>unity::aPT($pid,$period) — add $period days to premium (extends, never overrides).</summary>
        public bool Apt(long pid, int period)
        {
            string pTime;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT premium FROM server_1_players WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                object o = cmd.ExecuteScalar();
                pTime = o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }

            DateTime cur = DateTime.Now; // date('Y-m-d H:i:s', time())
            DateTime baseTs;
            if (!DateTime.TryParse(pTime, CultureInfo.InvariantCulture, DateTimeStyles.None, out baseTs))
                baseTs = cur;

            DateTime target = cur < baseTs ? baseTs : cur;
            DateTime added = target.AddDays(period);
            return SetPremiumTime(pid, added.ToString("yyyy-MM-dd HH:mm:ss", CultureInfo.InvariantCulture));
        }

        /// <summary>unity::sPT($pid,$times).</summary>
        private bool SetPremiumTime(long pid, string times)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET premium = @premium WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@premium", times);
                cmd.Parameters.AddWithValue("@pid", pid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        /// <summary>
        /// unity::gDI($args) — donation callback: args[0] must be "cryptKeying",
        /// args[1] is base64(JSON){error,package,playerID,price,period,a}.
        /// </summary>
        public bool Gdi(IList<string> args)
        {
            if (args == null || args.Count < 2 || args[0] != "cryptKeying")
                return false;

            dynamic stdJson;
            try
            {
                string json = Encoding.UTF8.GetString(Convert.FromBase64String(args[1]));
                stdJson = Newtonsoft.Json.JsonConvert.DeserializeObject<dynamic>(json);
            }
            catch (Exception)
            {
                return false;
            }

            long pid = PlayerLog.ToLong((object)stdJson.playerID);
            string package = (string)stdJson.package ?? "";
            string price = (string)((object)stdJson.price ?? "");
            string period = (string)((object)stdJson.period ?? "");

            int errorVal;
            int.TryParse(Convert.ToString((object)stdJson.error ?? "0"), out errorVal);

            if (errorVal == 0)
            {
                if (package == "premium")
                {
                    DB.Pmc(pid, "User:" + pid + " donated " + price + " for " + package + " with success.", "donations");
                    if (Apt(pid, ParseInt(period)))
                        DB.SetLog(pid, "You bought " + period + " days of " + package);
                    else
                        DB.SetLog(pid, "Something went wrong with your purchase of " + period + " days of " + package + ", please contact support!");
                }
                else if (package == "uridium")
                {
                    DB.Pmc(pid, "User:" + pid + " donated " + price + " for " + package + " of " + period + " with success.", "donations");
                    long amount = ParseLong(Convert.ToString((object)stdJson.a));
                    using (var con = DB.GetInstance())
                    using (var cmd = new MySqlCommand("UPDATE server_1_players SET uri = uri + @am WHERE playerID=@pid", con))
                    {
                        cmd.Parameters.AddWithValue("@am", amount);
                        cmd.Parameters.AddWithValue("@pid", pid);
                        if (cmd.ExecuteNonQuery() > 0)
                            DB.SetLog(pid, "You bought " + amount.ToString("#,0", CultureInfo.InvariantCulture) + " units of " + package);
                        else
                            DB.SetLog(pid, "Something went wrong with your purchase of " + period + package + ", please contact support!");
                    }
                }
                else if (package == "kit")
                {
                    DB.SetLog(pid, "Please contact support about you game Kit!");
                }
                else
                {
                    return false;
                }
                return true;
            }
            else
            {
                DB.Pmc(pid, "User:" + pid + " donated " + price + " for " + package + " was not succesfull.", "donations");
                return false;
            }
        }

        // -------------------------------------------------------- email verify

        private void GiveVeriUri(long id)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET uri = uri + 2000 WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", id);
                cmd.ExecuteNonQuery();
            }
        }

        private long GetPlayerid(long id)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT playerID FROM server_1_players WHERE userID = @uid", con))
            {
                cmd.Parameters.AddWithValue("@uid", id);
                return PlayerLog.ToLong(cmd.ExecuteScalar());
            }
        }

        private bool CheckIfVeri(long id)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT verified FROM users WHERE ID = @uid", con))
            {
                cmd.Parameters.AddWithValue("@uid", id);
                object o = cmd.ExecuteScalar();
                return PlayerLog.ToLong(o) != 0;
            }
        }

        /// <summary>unity::emailVerify($args) — $args is stdClass{userid,email}; here: (long userid, string email).</summary>
        public string EmailVerify(long userid, string email)
        {
            long playerid = GetPlayerid(userid);
            if (CheckIfVeri(userid))
                return "Your email is already verified!";

            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE users SET verified = 1 WHERE ID=@id AND Email=@Email", con))
            {
                cmd.Parameters.AddWithValue("@id", userid);
                cmd.Parameters.AddWithValue("@Email", email);
                if (cmd.ExecuteNonQuery() >= 0)
                {
                    DB.SetLog(playerid, "Your email is verified, you received 2,000 Uridium");
                    GiveVeriUri(playerid);
                    return "Your email is now verified!";
                }
            }
            return null;
        }

        // ------------------------------------------------------------ misc

        /// <summary>unity::getMapID($playerID).</summary>
        public long GetMapId(long playerID)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT mapId FROM server_1_players WHERE playerID = @pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", playerID);
                object o = cmd.ExecuteScalar();
                if (o == null || o == DBNull.Value) return 1;
                return PlayerLog.ToLong(o);
            }
        }

        // ---------------------------------------------------------- helpers

        internal static bool IsValidEmail(string email)
        {
            if (string.IsNullOrEmpty(email)) return false;
            try
            {
                var m = new MailAddress(email);
                return m.Address == email;
            }
            catch (ArgumentException)
            {
                return false;
            }
        }

        private static int ParseInt(string s)
        {
            int v; return int.TryParse(s, out v) ? v : 0;
        }

        private static long ParseLong(string s)
        {
            long v; return long.TryParse(s, out v) ? v : 0;
        }
    }
}
