using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Xml.XPath;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.factory.php (NanoTech Factory).
    /// Slot value format in server_1_player_nanotech.slot_* is "buff|qty|producing"
    /// ("none" when empty) — same as the PHP original.
    /// </summary>
    public class Factory
    {
        private MySqlConnection _con;
        private long _uid;
        private long _pid;
        private long _uridium;
        private long _credits;

        public Factory()
        {
            _con = DB.GetInstance();
        }

        /// <summary>factory::setId($uid, $pid) — also ensures a nanotech row exists and refreshes money.</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
            CheckMakeDbRow();
            Money();
        }

        /// <summary>
        /// factory::getPrices($argC) — PHP used variable variables ($$argC); here a lookup table.
        /// Returns an empty dictionary for unknown keys (PHP returned "").
        /// </summary>
        public Dictionary<string, string> GetPrices(string argC)
        {
            switch (argC)
            {
                case "SELA": return Price("SELA", 1000000, 500, 5, 6500, "43200", 2500);
                case "SECI": return Price("SECI", 500000, 200, 1, 1800, "21600", 900);
                case "SRPM": return Price("SRPM", 20000, 0, 0, 500, "7200", 250);
                case "SSBU": return Price("SSBU", 500000, 250, 2, 2800, "43200", 1400);
                case "SBRB": return Price("SBRB", 500000, 250, 2, 2800, "43200", 1400);
                default: return new Dictionary<string, string>();
            }
        }

        private static Dictionary<string, string> Price(string name, long c, long seprom, long logdisk,
                                                       long buyn, string producetime, long instant)
        {
            return new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase)
            {
                { "c", c.ToString(CultureInfo.InvariantCulture) },
                { "seprom", seprom.ToString(CultureInfo.InvariantCulture) },
                { "logdisk", logdisk.ToString(CultureInfo.InvariantCulture) },
                { "buyn", buyn.ToString(CultureInfo.InvariantCulture) },
                { "producetime", producetime },
                { "instant", instant.ToString(CultureInfo.InvariantCulture) },
                { "name", name },
            };
        }

        private void Money()
        {
            using (var cmd = new MySqlCommand(
                "SELECT uri, credits FROM server_1_players WHERE userID=@uid AND playerID=@pid", _con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (rdr.Read())
                    {
                        _uridium = PlayerLog.ToLong(rdr.GetValue(0));
                        _credits = PlayerLog.ToLong(rdr.GetValue(1));
                    }
                }
            }
        }

        private void CheckMakeDbRow()
        {
            using (var cmd = new MySqlCommand(
                "SELECT autoID FROM server_1_player_nanotech WHERE playerID=@pid", _con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                object o = cmd.ExecuteScalar();
                if (o == null || o == DBNull.Value) MakeRow();
            }
        }

        private void MakeRow()
        {
            using (var cmd = new MySqlCommand(
                "INSERT INTO `server_1_player_nanotech`(`playerID`) VALUES (@pid)", _con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.ExecuteNonQuery();
            }
        }

        /// <summary>
        /// factory::cPT($timestamp) — NOTE: the PHP original returns TRUE when time() has
        /// PASSED the timestamp (inverted vs unity::cPT). Kept identical for parity:
        /// updateStatus relies on it to detect finished production.
        /// </summary>
        public static bool CptFinished(string timestamp)
        {
            DateTime ts;
            if (!DateTime.TryParse(timestamp, CultureInfo.InvariantCulture, DateTimeStyles.None, out ts))
                return false;
            return DateTime.Now > ts;
        }

        /// <summary>factory::deleteTech($slot).</summary>
        public bool DeleteTech(int slot)
        {
            var dic = SlotNames(slot);
            if (dic == null) return false;
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_player_nanotech SET " + dic + "='none' WHERE playerID=@pid", _con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        /// <summary>factory::updateStatus($pid, $slot) — called by ajax/nanoTechfactory/techShop.ashx.</summary>
        public bool UpdateStatus(long pid, int slot)
        {
            _pid = pid;
            var peri = GetTimes();
            if (peri == null) return false;
            string slotName = SlotNames(slot);
            if (slotName == null || !peri.ContainsKey(slotName)) return false;

            string[] s = Split((peri[slotName] ?? "").Split('|'));
            if (s == null) return false;
            // PHP: $status = self::cPT($peri[$s[0]]) — s[0] is the finish-date column name? No:
            // In PHP $peri[$slot] holds "buff|qty|producing"; explode gives $s[0]=buff.
            // The PHP code then does $peri[$s[0]] which reads the DATE column named after the buff
            // (updateDatesINtech writes SET $W='$Wvalue' where W=buff). Same layout here:
            string dateStripe = peri.ContainsKey(s[0]) ? peri[s[0]] : "";
            if (!CptFinished(dateStripe)) return false;

            s[2] = "0";
            long qty;
            long.TryParse(s[1], out qty);
            s[1] = (qty + 1).ToString(CultureInfo.InvariantCulture);
            string x = string.Join("|", s);

            using (var cmd = new MySqlCommand(
                "UPDATE server_1_player_nanotech SET " + slotName + "=@x WHERE autoID=@autoID AND playerID=@pid", _con))
            {
                cmd.Parameters.AddWithValue("@x", x);
                cmd.Parameters.AddWithValue("@autoID", peri.ContainsKey("autoID") ? peri["autoID"] : "0");
                cmd.Parameters.AddWithValue("@pid", pid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        /// <summary>factory::getSeconds($datestripe).</summary>
        public static long GetSeconds(string datestripe)
        {
            DateTime ts;
            if (!DateTime.TryParse(datestripe, CultureInfo.InvariantCulture, DateTimeStyles.None, out ts))
                return 0;
            return (long)(ts - DateTime.Now).TotalSeconds;
        }

        /// <summary>factory::cancelProduction($buff, $slot).</summary>
        public Dictionary<string, string> CancelProduction(string buff, int slot)
        {
            var halls = GetTimes();
            string slotset = SlotNames(slot);
            if (halls == null || slotset == null) return Msg("Do not cheat!", "error");
            long cNow = NowUnix();

            string cur = halls.ContainsKey(slotset) ? halls[slotset] : "none";
            if (cur == "none")
                return Msg("Do not cheat!", "error");

            var s = (cur ?? "").Split('|');
            if (s.Length < 3) s = PadParts(s);

            long qty; long.TryParse(s[1], out qty);
            if (qty == 0)
            {
                UpdateDatesInTech(buff, cNow.ToString(CultureInfo.InvariantCulture), slotset, "none");
                return Msg("Procution on " + L(buff + "name") + " has stopped", "success");
            }
            s[2] = "0";
            string x = string.Join("|", s);
            UpdateDatesInTech(buff, cNow.ToString(CultureInfo.InvariantCulture), slotset, x);
            return Msg("Procution on " + L(buff + "name") + " has stopped", "success");
        }

        /// <summary>factory::buyNow($buff).</summary>
        public Dictionary<string, string> BuyNow(string buff)
        {
            var halls = GetTimes();
            var args = GetPrices(buff);
            long buyn; long.TryParse(GetOr(args, "buyn"), out buyn);
            if (_uridium < buyn)
                return Msg("You have not enough Uridum for that!", "error");

            if (PullUri(buyn))
            {
                string slot = FirstSlotFor(halls, buff);
                if (slot == null) return Msg("You does not have space for that!", "error");
                return ExecuteBuyNow(slot, buff, halls);
            }
            return Msg("Do not cheat!", "error");
        }

        private Dictionary<string, string> ExecuteBuyNow(string slot, string buff, Dictionary<string, string> halls)
        {
            string c = halls != null && halls.ContainsKey(buff) ? halls[buff] : "";
            string cur = halls != null && halls.ContainsKey(slot) ? halls[slot] : "none";
            if (cur == "none")
            {
                string cs = buff + "|1|0";
                UpdateDatesInTech(buff, c, slot, cs);
            }
            else
            {
                var s = (cur ?? "").Split('|');
                if (s.Length < 3) s = PadParts(s);
                long qty; long.TryParse(s[1], out qty);
                s[1] = (qty + 1).ToString(CultureInfo.InvariantCulture);
                UpdateDatesInTech(buff, c, slot, string.Join("|", s));
            }
            return Msg("You bought 1 " + L(buff + "name"), "success");
        }

        /// <summary>factory::getTimes() — assoc row of server_1_player_nanotech for this player.</summary>
        public Dictionary<string, string> GetTimes()
        {
            using (var cmd = new MySqlCommand(
                "SELECT * FROM server_1_player_nanotech WHERE playerID=@pid", _con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (rdr.Read()) return Unity.RowToDict(rdr);
                }
            }
            return null;
        }

        /// <summary>factory::convertSeconds($seconds).</summary>
        public static string ConvertSeconds(long seconds)
        {
            long hours = seconds / 3600;
            seconds %= 3600;
            long minutes = seconds / 60;
            return hours + " hr. " + minutes + " min.";
        }

        /// <summary>factory::getDroneParts($lootid) — capped at 45.</summary>
        public long GetDroneParts(string lootid)
        {
            long q = GetItemsRequired(lootid);
            return q > 45 ? 45 : q;
        }

        private bool PullUri(long uri)
        {
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_players SET uri = (uri-@uri) WHERE playerID=@pid AND userID=@uid", _con))
            {
                cmd.Parameters.AddWithValue("@uri", uri);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.Parameters.AddWithValue("@uid", _uid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        private bool PullCre(long cre)
        {
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_players SET credits = (credits-@cre) WHERE playerID=@pid AND userID=@uid", _con))
            {
                cmd.Parameters.AddWithValue("@cre", cre);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.Parameters.AddWithValue("@uid", _uid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        private bool UpdateSeprom(long am, long cm)
        {
            long sm = cm - am;
            if (sm < 0) return false;
            return UpdateItemQty("resource_ore_seprom", sm);
        }

        private bool UpdateLogfiles(long am, long cm)
        {
            long sm = cm - am;
            if (sm < 0) return false;
            return UpdateItemQty("resource_logfile", sm);
        }

        private bool UpdateItemQty(string lootid, long qty)
        {
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_player_all_items SET Q = @rm WHERE playerID=@pid AND lootid=@loot", _con))
            {
                cmd.Parameters.AddWithValue("@rm", qty);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.Parameters.AddWithValue("@loot", lootid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        private bool UpdateDatesInTech(string w, string wValue, string slot, string slotValue)
        {
            // Identifiers come from a fixed price-table / slot dictionary, values are parameterized.
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_player_nanotech SET " + w + "=@wv, " + slot + "=@sv WHERE playerID=@pid", _con))
            {
                cmd.Parameters.AddWithValue("@wv", wValue);
                cmd.Parameters.AddWithValue("@sv", slotValue);
                cmd.Parameters.AddWithValue("@pid", _pid);
                return cmd.ExecuteNonQuery() >= 0;
            }
        }

        private Dictionary<string, string> StartProducing(string slot, string buff, Dictionary<string, string> args, bool instant)
        {
            long cTime = NowUnix();
            string c;
            var halls = GetTimes();

            if (instant)
            {
                long instCost; long.TryParse(GetOr(args, "instant"), out instCost);
                if (_uridium < instCost)
                    return Msg("You have not enough Uridum for that!", "error");
                PullUri(instCost);
                c = halls != null && halls.ContainsKey(buff) ? halls[buff] : "";
                string cur = halls != null && halls.ContainsKey(slot) ? halls[slot] : "none";
                if (cur == "none")
                {
                    UpdateDatesInTech(buff, c, slot, buff + "|1|0");
                }
                else
                {
                    var s = (cur ?? "").Split('|');
                    if (s.Length < 3) s = PadParts(s);
                    long qty; long.TryParse(s[1], out qty);
                    s[1] = (qty + 1).ToString(CultureInfo.InvariantCulture);
                    UpdateDatesInTech(buff, c, slot, string.Join("|", s));
                }
                return Msg("You started bought 1 " + L(buff + "name"), "success");
            }

            long produceTime; long.TryParse(GetOr(args, "producetime"), out produceTime);
            c = DateTimeOffset.FromUnixTimeSeconds(cTime + produceTime)
                 .LocalDateTime.ToString("yyyy-MM-dd HH:mm:ss", CultureInfo.InvariantCulture);

            string cur2 = halls != null && halls.ContainsKey(slot) ? halls[slot] : "none";
            if (cur2 == "none")
            {
                UpdateDatesInTech(buff, c, slot, buff + "|0|1");
                return Msg("You started producing 1 " + L(buff + "name"), "success");
            }
            var p = (cur2 ?? "").Split('|');
            if (p.Length < 3) p = PadParts(p);
            if (p[2] == "1")
                return Msg("You are already producing this tech!", "error");
            p[2] = "1";
            UpdateDatesInTech(buff, c, slot, string.Join("|", p));
            return Msg("You started producing 1 " + L(buff + "name"), "success");
        }

        /// <summary>factory::produceStart($args, $buff, $instant=null).</summary>
        public Dictionary<string, string> ProduceStart(Dictionary<string, string> args, string buff, bool? instant = null)
        {
            if (string.IsNullOrEmpty(buff)) return Msg("Do not cheat!!", "error");
            if (args == null || args.Count == 0) return Msg("Do not cheat!!", "error");

            long myLogfiles = GetItemsRequired("resource_logfile");
            long mySeprom = GetItemsRequired("resource_ore_seprom");
            long needC, needSeprom, needLog, needCre;
            long.TryParse(GetOr(args, "c"), out needCre);
            long.TryParse(GetOr(args, "seprom"), out needSeprom);
            long.TryParse(GetOr(args, "logdisk"), out needLog);

            if (needLog <= myLogfiles && needCre <= _credits && needSeprom <= mySeprom)
            {
                if (!UpdateSeprom(needSeprom, mySeprom)) return Msg("Do not cheat!!", "error");
                if (!UpdateLogfiles(needLog, myLogfiles)) return Msg("Do not cheat!!", "error");
                if (!PullCre(needCre)) return Msg("Do not cheat!!", "error");

                var halls = GetTimes();
                string slot = FirstSlotFor(halls, buff);
                if (slot == null) return Msg("You does not have space for that!", "error");
                return StartProducing(slot, buff, args, instant ?? false);
            }
            return Msg("You have not enough resources for that!", "error");
        }

        /// <summary>factory::expandHall($facilityID).</summary>
        public Dictionary<string, string> ExpandHall(int facilityId)
        {
            const string slotTwo = "slot_two";
            const string slotThree = "slot_three";

            if (facilityId == 2 || facilityId == 3)
            {
                long cost = facilityId == 2 ? 50000 : 100000;
                string col = facilityId == 2 ? slotTwo : slotThree;
                if (_uridium >= cost)
                {
                    if (PullUri(cost))
                    {
                        using (var cmd = new MySqlCommand(
                            "UPDATE server_1_player_nanotech SET " + col + "='none' WHERE playerID=@pid", _con))
                        {
                            cmd.Parameters.AddWithValue("@pid", _pid);
                            if (cmd.ExecuteNonQuery() >= 0)
                            {
                                DB.SetLog(_pid, "You used " + cost.ToString("#,##0", CultureInfo.InvariantCulture) +
                                                " Uridium on 1 tech slot.");
                                return Msg("You expanded your tech slots by 1.", "success");
                            }
                            return Msg("Do not cheat!!", "error");
                        }
                    }
                    return Msg("Do not cheat!!", "error");
                }
                return Msg("You have not enough Uridum for that!", "error");
            }
            return Msg("Do not cheat!!", "error");
        }

        /// <summary>factory::getItemsRequired($lootid).</summary>
        public long GetItemsRequired(string lootid)
        {
            using (var cmd = new MySqlCommand(
                "SELECT Q FROM server_1_player_all_items WHERE lootid=@loot AND playerID=@pid", _con))
            {
                cmd.Parameters.AddWithValue("@loot", lootid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                object o = cmd.ExecuteScalar();
                return o == null || o == DBNull.Value ? 0 : PlayerLog.ToLong(o);
            }
        }

        /// <summary>factory::l($s) — translation lookup from ajax/nanoTechfactory/en.xml.</summary>
        public string L(string key)
        {
            try
            {
                string path = Path.Combine(AppDomain.CurrentDomain.BaseDirectory,
                                           "ajax", "nanoTechfactory", "en.xml");
                if (!File.Exists(path)) return key;
                var nav = new XPathDocument(path).CreateNavigator();
                var sel = nav.Select("//translation/sentence[@id='" + key.Replace("'", "") + "']");
                foreach (XPathNavigator n in sel) return n.Value;
            }
            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine(e.Message);
            }
            return key;
        }

        // -------------------------------------------------------------- helpers

        /// <summary>PHP slot dictionary: 0..3 => zero/one/two/three; anything else = invalid (null).</summary>
        internal static string SlotNames(int slot)
        {
            switch (slot)
            {
                case 0: return "slot_zero";
                case 1: return "slot_one";
                case 2: return "slot_two";
                case 3: return "slot_three";
                default: return null;
            }
        }

        /// <summary>Replicates PHP's nested slot search: first slot containing buff, else first free slot.</summary>
        private static string FirstSlotFor(Dictionary<string, string> halls, string buff)
        {
            if (halls == null) return "slot_one";
            string one = GetOr(halls, "slot_one");
            if (one != "none")
            {
                if (one.IndexOf(buff, StringComparison.Ordinal) >= 0) return "slot_one";
                string two = GetOr(halls, "slot_two");
                if (two != "none")
                {
                    if (two.IndexOf(buff, StringComparison.Ordinal) >= 0) return "slot_two";
                    string three = GetOr(halls, "slot_three");
                    if (three != "none")
                    {
                        if (three.IndexOf(buff, StringComparison.Ordinal) >= 0) return "slot_three";
                        return null; // "You does not have space for that!"
                    }
                    return "slot_three";
                }
                return "slot_two";
            }
            return "slot_one";
        }

        private static string[] Split(string[] parts)
        {
            return parts != null && parts.Length >= 3 ? parts : null;
        }

        private static string[] PadParts(string[] s)
        {
            var r = new string[] { "0", "0", "0" };
            for (int i = 0; i < s.Length && i < 3; i++) r[i] = s[i];
            return r;
        }

        private static long NowUnix()
        {
            return ((DateTimeOffset)DateTime.Now).ToUnixTimeSeconds();
        }

        private static string GetOr(IDictionary<string, string> d, string k)
        {
            string v;
            return d != null && d.TryGetValue(k, out v) ? (v ?? "") : "";
        }

        private static Dictionary<string, string> Msg(string logMessage, string type)
        {
            return new Dictionary<string, string> { { "log_message", logMessage }, { "type", type } };
        }
    }
}
