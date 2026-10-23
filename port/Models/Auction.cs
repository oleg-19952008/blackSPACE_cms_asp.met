using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Text;
using System.Text.RegularExpressions;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.auction.php (class `auction`).
    /// Hourly & daily auctions: bidding (setHourBid/setDayBid), cron settlement
    /// (applyCronJobHour/applyCronJobDaily), countdown helpers, XML item images.
    /// NOTE: the live KERNEL copy calls getHourITEMScron() which is only defined in
    /// cron/hourly/hourly/Class.auction.php — we port the cron variant here as well.
    /// </summary>
    public class Auction
    {
        private long _uid;
        private long _pid;

        public long Uridium { get; private set; }
        public long Credits { get; private set; }

        /// <summary>auction::setId($uid,$pid) — refreshes balances via money().</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
            Money();
        }

        /// <summary>auction::money().</summary>
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
                        Uridium = PlayerLog.ToLong(rdr["uri"]);
                        Credits = PlayerLog.ToLong(rdr["credits"]);
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

        /// <summary>auction::currentDrones($pid) — count rows in server_1_player_drones.</summary>
        public long CurrentDrones(long pid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT COUNT(*) FROM server_1_player_drones WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                return PlayerLog.ToLong(cmd.ExecuteScalar());
            }
        }

        /// <summary>auction::currentDronesSET().</summary>
        public long CurrentDronesSet()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT COUNT(*) FROM server_1_player_drones WHERE userID=@uid AND playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                return PlayerLog.ToLong(cmd.ExecuteScalar());
            }
        }

        /// <summary>auction::Logs($pid,$lootid,$am).</summary>
        private static void Logs(long pid, string lootid, object am)
        {
            DB.SetLog(pid, "You won " + am + " Unit(s) of " + lootid + " on the auction");
        }

        // ------------------------------------------------------------- cron jobs

        /// <summary>auction::getHourITEMScron() (defined in the cron/hourly variant).</summary>
        public List<Dictionary<string, string>> GetHourItemsCron()
        {
            return QueryRows(
                @"SELECT server_1_auction_hour.ItemName, server_1_auction_hour.amount, server_1_auction_hour.apply,
                         server_1_auction_hour.HBidder, server_1_auction_hour.cBud, server_shop_items.name
                  FROM server_1_auction_hour
                  INNER JOIN server_shop_items ON server_1_auction_hour.ItemName=server_shop_items.lootId
                  ORDER BY server_1_auction_hour.autoID ASC");
        }

        /// <summary>
        /// auction::applyCronJobHour() — snapshot to ./logs/hourly/auctionLoging_m-d-Y-H_.php,
        /// clear hour board, hand items to winners (iris drones also register in drone table).
        /// </summary>
        public void ApplyCronJobHour()
        {
            var all = GetHourItemsCron();
            string time = CopenhagenNow().ToString("MM-dd-yyyy-HH", CultureInfo.InvariantCulture);
            string myFile = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "logs", "hourly", "auctionLoging_" + time + "_.php");
            try
            {
                Directory.CreateDirectory(Path.GetDirectoryName(myFile));
                string json = Newtonsoft.Json.JsonConvert.SerializeObject(all);
                File.WriteAllText(myFile, "<?php $json='" + json + "'; echo $json; ?>", Encoding.UTF8);
            }
            catch (IOException e)
            {
                // PHP die('Cannot open file: '.$my_file)
                throw new InvalidOperationException("Cannot open file: " + myFile, e);
            }

            ClearCronJobHour();
            foreach (var v in all)
            {
                long hBidder = PlayerLog.ToLong(v.ContainsKey("HBidder") ? v["HBidder"] : "0");
                if (hBidder == 0) continue;
                long uid = GetUserIdFromPid(hBidder);
                string itemName = v.ContainsKey("ItemName") ? v["ItemName"] : "";
                object amount = v.ContainsKey("amount") ? v["amount"] : "0";
                object apply = v.ContainsKey("apply") ? v["apply"] : "0";
                object cBud = v.ContainsKey("cBud") ? v["cBud"] : "0";
                string name = v.ContainsKey("name") ? v["name"] : "";

                if (itemName == "drone_iris" && CurrentDrones(hBidder) < 8)
                {
                    GiverCronJob(itemName, amount, apply, hBidder, hBidder, cBud, name);
                    DroneReg("drone_iris", hBidder, uid);
                }
                else
                {
                    GiverCronJob(itemName, amount, apply, hBidder, hBidder, cBud, name);
                }
            }
        }

        /// <summary>auction::applyCronJobDaily() (KERNEL variant — uses getDailyAuctionItems()).</summary>
        public void ApplyCronJobDaily()
        {
            var all = GetDailyAuctionItems();
            foreach (var v in all)
            {
                long hBidder = PlayerLog.ToLong(v.ContainsKey("HBidder") ? v["HBidder"] : "0");
                if (hBidder == 0) continue;
                long uid = GetUserIdFromPid(hBidder);
                string itemName = v.ContainsKey("ItemName") ? v["ItemName"] : "";
                GiverCronJob(itemName, v.ContainsKey("amount") ? v["amount"] : "0", v.ContainsKey("apply") ? v["apply"] : "0",
                             hBidder, uid, v.ContainsKey("cBud") ? v["cBud"] : "0");
                ClearCronJobDaily(itemName);
                Logs(hBidder, v.ContainsKey("name") ? v["name"] : "", v.ContainsKey("amount") ? v["amount"] : "0");
            }
        }

        /// <summary>auction::getDailyAuctionItems().</summary>
        public List<Dictionary<string, string>> GetDailyAuctionItems()
        {
            return QueryRows(
                @"SELECT * FROM server_1_auction_daily
                  INNER JOIN server_shop_items ON server_1_auction_daily.ItemName=server_shop_items.lootId
                  ORDER BY server_1_auction_daily.autoID ASC");
        }

        /// <summary>auction::getHourAuctionItems().</summary>
        public List<Dictionary<string, string>> GetHourAuctionItems()
        {
            return QueryRows(
                @"SELECT * FROM server_1_auction_hour
                  INNER JOIN server_shop_items ON server_1_auction_hour.ItemName=server_shop_items.lootId
                  ORDER BY server_1_auction_hour.autoID ASC");
        }

        /// <summary>auction::giverCronJob(...) — 7-arg variant from the cron copy; 6-arg KERNEL variant delegates with name="".</summary>
        private void GiverCronJob(string lootid, object am, object in_, long pid, long uid, object cbud, string name = null)
        {
            DB.Pmc(uid, lootid + " was won at auction for " + cbud + " Credits", "auction");
            using (var con = DB.GetInstance())
            {
                if (CheckExistence(lootid, pid))
                {
                    if (lootid == "drone_iris")
                    {
                        InsertItem(con, lootid, am, in_, pid, uid);
                    }
                    else if (Convert.ToString(in_) != "1")
                    {
                        using (var cmd = new MySqlCommand("UPDATE `server_1_player_all_items` SET Q = Q + @am WHERE playerID=@pid AND lootid=@loot", con))
                        {
                            cmd.Parameters.AddWithValue("@am", am);
                            cmd.Parameters.AddWithValue("@pid", pid);
                            cmd.Parameters.AddWithValue("@loot", lootid);
                            cmd.ExecuteNonQuery();
                        }
                    }
                    else
                    {
                        int ins = lootid.IndexOf("ship", StringComparison.Ordinal) >= 0 ? 1 : 0;
                        InsertItem(con, lootid, am, ins, pid, uid);
                    }
                }
                else
                {
                    int ins = lootid.IndexOf("ship", StringComparison.Ordinal) >= 0 ? 1 : 0;
                    InsertItem(con, lootid, am, ins, pid, uid);
                }
            }
            if (name != null) Logs(pid, name, am);
        }

        private static void InsertItem(MySqlConnection con, string lootid, object q, object interactive, long pid, long uid)
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

        private void ClearCronJobHour()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_auction_hour SET HBidder=0, cBud=0", con))
            {
                cmd.ExecuteNonQuery();
            }
        }

        private void ClearCronJobHour(string lootid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_auction_hour SET HBidder=0, cBud=0 WHERE ItemName=@lootid", con))
            {
                cmd.Parameters.AddWithValue("@lootid", lootid);
                cmd.ExecuteNonQuery();
            }
        }

        private void ClearCronJobDaily(string lootid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_auction_daily SET HBidder=0, cBud=0 WHERE ItemName=@lootid", con))
            {
                cmd.Parameters.AddWithValue("@lootid", lootid);
                cmd.ExecuteNonQuery();
            }
        }

        // ---------------------------------------------------------------- bidding

        private Dictionary<string, string> GetBiddedOnItem(string lootid)
        {
            var rows = QueryRows(
                @"SELECT * FROM server_1_auction_hour
                  INNER JOIN server_shop_items ON server_1_auction_hour.ItemName=server_shop_items.lootId
                  WHERE server_1_auction_hour.ItemName=@lootid ORDER BY server_1_auction_hour.autoID ASC",
                Tuple.Create<string, object>("@lootid", lootid));
            return rows.Count > 0 ? rows[0] : null;
        }

        private Dictionary<string, string> GetBiddedDayOnItem(string lootid)
        {
            var rows = QueryRows(
                @"SELECT * FROM server_1_auction_daily
                  INNER JOIN server_shop_items ON server_1_auction_daily.ItemName=server_shop_items.lootId
                  WHERE server_1_auction_daily.ItemName=@lootid ORDER BY server_1_auction_daily.autoID ASC",
                Tuple.Create<string, object>("@lootid", lootid));
            return rows.Count > 0 ? rows[0] : null;
        }

        private Dictionary<string, string> SetBiddedOnItem(string lootid, long bid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_auction_hour SET HBidder=@HBidder, cBud=@cBud WHERE ItemName=@lootid", con))
            {
                cmd.Parameters.AddWithValue("@HBidder", _pid);
                cmd.Parameters.AddWithValue("@cBud", bid);
                cmd.Parameters.AddWithValue("@lootid", lootid);
                cmd.ExecuteNonQuery();
            }
            return Msg("Bid is submited", "success");
        }

        /// <summary>auction::pullCredits($cre,$loot).</summary>
        private bool PullCredits(long cre, string loot)
        {
            long after = Credits - cre;
            DB.Pmc(_pid, "-" + cre + " Before: " + Credits + " after: " + after + " from Auction on: " + loot, "credits");
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET credits = (credits-@cre) WHERE playerID=@pid AND userID=@uid", con))
            {
                cmd.Parameters.AddWithValue("@cre", cre);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.Parameters.AddWithValue("@uid", _uid);
                return cmd.ExecuteNonQuery() > 0;
            }
        }

        /// <summary>auction::pushCredits($am,$pid,$loot).</summary>
        private bool PushCredits(object am, long pid, string loot)
        {
            if (pid == 0) return false; // PHP pushed to HBidder=0 too; harmless but skip noise
            DB.Pmc(pid, "+" + am + " credits, user was overbidded at auction: " + loot + "!", "credits");
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET credits = (credits+@am) WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@am", am);
                cmd.Parameters.AddWithValue("@pid", pid);
                if (cmd.ExecuteNonQuery() > 0)
                {
                    long amt = PlayerLog.ToLong(Convert.ToString(am));
                    DB.SetLog(pid, "You were overbidded, you receive " + amt.ToString("#,0", CultureInfo.InvariantCulture) + " credits.");
                    return true;
                }
                return false;
            }
        }

        /// <summary>auction::setHourBid($args) — $args = ['lootId','credits'].</summary>
        public Dictionary<string, string> SetHourBid(IDictionary<string, string> args)
        {
            string lootId = args.ContainsKey("lootId") ? args["lootId"] : "";
            var info = GetBiddedOnItem(lootId);
            if (info == null)
                return Msg("S.H.E.I.L.D. does not allow that value!", "error");

            if (lootId.IndexOf("drones", StringComparison.Ordinal) >= 0)
            {
                if (CurrentDronesSet() >= 8)
                    return Msg("S.H.E.I.L.D. does not allow that value!", "error");
            }

            string creStr = Regex.Replace(args.ContainsKey("credits") ? args["credits"] : "", "[^0-9]", "");
            long cre;
            if (!long.TryParse(creStr, out cre) || creStr.Length == 0)
                return Msg("S.H.E.I.L.D. does not allow that value!", "error");

            if (Credits - cre > 0)
            {
                try
                {
                    long comp = cre - 9999;
                    int affected;
                    using (var con = DB.GetInstance())
                    using (var cmd = new MySqlCommand(
                        @"UPDATE server_1_auction_hour
                          SET HBidder = CASE WHEN @comp > cBud THEN @HBidder ELSE HBidder END,
                              cBud    = CASE WHEN @comp > cBud THEN @cBud ELSE cBud END
                          WHERE ItemName=@lootid", con))
                    {
                        cmd.Parameters.AddWithValue("@HBidder", _pid);
                        cmd.Parameters.AddWithValue("@cBud", cre);
                        cmd.Parameters.AddWithValue("@lootid", lootId);
                        cmd.Parameters.AddWithValue("@comp", comp);
                        affected = cmd.ExecuteNonQuery();
                    }
                    if (affected > 0)
                    {
                        PullCredits(cre, lootId);
                        PushCredits(info.ContainsKey("cBud") ? info["cBud"] : "0",
                                    PlayerLog.ToLong(info.ContainsKey("HBidder") ? info["HBidder"] : "0"), lootId);
                        return Msg("Bid is submited", "success");
                    }
                    return Msg("You need to big atleast 10,000 credits over last bid.", "error");
                }
                catch (MySqlException e)
                {
                    return new Dictionary<string, string> { { "message", e.Message } };
                }
            }
            return Msg("You don't have enough Credits to bid on this item.", "error");
        }

        /// <summary>auction::setDayBid($args).</summary>
        public Dictionary<string, string> SetDayBid(IDictionary<string, string> args)
        {
            string lootId = args.ContainsKey("lootId") ? args["lootId"] : "";
            var info = GetBiddedDayOnItem(lootId);
            if (info == null)
                return Msg("S.H.E.I.L.D. does not allow that value!", "error");

            string creStr = Regex.Replace(args.ContainsKey("credits") ? args["credits"] : "", "[^0-9]", "");
            long cre;
            if (!long.TryParse(creStr, NumberStyles.None, CultureInfo.InvariantCulture, out cre) || creStr.Length == 0)
                return Msg("S.H.E.I.L.D. does not allow that value!", "error");

            if (Credits - cre > 0)
            {
                try
                {
                    long comp = cre - 9999;
                    int affected;
                    using (var con = DB.GetInstance())
                    using (var cmd = new MySqlCommand(
                        @"UPDATE server_1_auction_daily
                          SET HBidder = CASE WHEN @comp > cBud THEN @HBidder ELSE HBidder END,
                              cBud    = CASE WHEN @comp > cBud THEN @cBud ELSE cBud END
                          WHERE ItemName=@lootid", con))
                    {
                        cmd.Parameters.AddWithValue("@HBidder", _pid);
                        cmd.Parameters.AddWithValue("@cBud", cre);
                        cmd.Parameters.AddWithValue("@lootid", lootId);
                        cmd.Parameters.AddWithValue("@comp", comp);
                        affected = cmd.ExecuteNonQuery();
                    }
                    if (affected > 0)
                    {
                        PullCredits(cre, lootId);
                        PushCredits(info.ContainsKey("cBud") ? info["cBud"] : "0",
                                    PlayerLog.ToLong(info.ContainsKey("HBidder") ? info["HBidder"] : "0"), lootId);
                        return Msg("Bid is submited", "success");
                    }
                    return Msg("You need to big atleast 10,000 credits over last bid.", "error");
                }
                catch (MySqlException e)
                {
                    return new Dictionary<string, string> { { "message", e.Message } };
                }
            }
            return Msg("You don't have enough Credits to bid on this item.", "error");
        }

        // ------------------------------------------------------------ drone reg

        private void DroneReg(string lootid, long pid, long uid)
        {
            long itemId;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "SELECT id FROM server_1_player_all_items WHERE lootid=@lootid AND playerID=@pid AND userID=@uid ORDER BY id DESC LIMIT 1", con))
            {
                cmd.Parameters.AddWithValue("@lootid", lootid);
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.Parameters.AddWithValue("@uid", uid);
                itemId = PlayerLog.ToLong(cmd.ExecuteScalar());
            }

            object hid = HangarId(pid, uid);
            using (var con = DB.GetInstance())
            {
                CreateDrone(con, itemId, "uridium", lootid, pid, uid);
                if (hid != null && !Convert.ToBoolean(hid))
                    CreateConfig(con, itemId, pid, uid, Convert.ToInt64(hid));
            }
        }

        /// <summary>auction::HangarId($pid,$uid) — returns hangarID or false.</summary>
        public object HangarId(long pid, long uid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT hangarID FROM server_1_hangar WHERE userID=@uid AND playerID=@pid LIMIT 1", con))
            {
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.Parameters.AddWithValue("@pid", pid);
                object o = cmd.ExecuteScalar();
                if (o == null || o == DBNull.Value) return false;
                return PlayerLog.ToLong(o);
            }
        }

        private static void CreateConfig(MySqlConnection con, long id, long pid, long uid, long hid)
        {
            using (var cmd = new MySqlCommand(
                "INSERT INTO `server_1_hangar_config_drones` (`playerID`, `userID`, `hangarID`, `item_id`) VALUES (@pid, @uid, @hid, @id)", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.Parameters.AddWithValue("@hid", hid);
                cmd.Parameters.AddWithValue("@id", id);
                cmd.ExecuteNonQuery();
            }
        }

        private static void CreateDrone(MySqlConnection con, long id, string currency, string lootid, long pid, long uid)
        {
            using (var cmd = new MySqlCommand(
                "INSERT INTO `server_1_player_drones` (`item_sale_id`, `drone_currency`, `userID`, `playerID`, `drone_kind`) VALUES (@id, @cur, @uid, @pid, @kind)", con))
            {
                cmd.Parameters.AddWithValue("@id", id);
                cmd.Parameters.AddWithValue("@cur", currency);
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.Parameters.AddWithValue("@kind", lootid);
                cmd.ExecuteNonQuery();
            }
        }

        // -------------------------------------------------------- countdowns

        private static TimeZoneInfo CopenhagenTz = GetTz("Romance Standard Time", "Europe/Copenhagen");
        private static TimeZoneInfo GetTz(string windowsId, string ianaFallback)
        {
            try { return TimeZoneInfo.FindSystemTimeZoneById(windowsId); }
            catch (TimeZoneNotFoundException) { return TimeZoneInfo.Utc; }
        }

        private static DateTime CopenhagenNow()
        {
            return TimeZoneInfo.ConvertTimeFromUtc(DateTime.UtcNow, CopenhagenTz);
        }

        /// <summary>auction::nextCloseTimeHOUR().</summary>
        public Dictionary<string, int> NextCloseTimeHour()
        {
            DateTime d = CopenhagenNow();
            int minsLeft = (d.Minute == 59) ? 0 : 60 - d.Minute - 1;
            int secsLeft = 60 - d.Second;
            return new Dictionary<string, int> { { "min", minsLeft }, { "sec", secsLeft } };
        }

        /// <summary>auction::nextCloseTimeDAY().</summary>
        public Dictionary<string, int> NextCloseTimeDay()
        {
            DateTime d = CopenhagenNow();
            int minsLeft = (d.Minute == 59) ? 0 : 60 - d.Minute - 1;
            int secsLeft = 60 - d.Second;
            int hourLeft = 23 - d.Hour;
            return new Dictionary<string, int> { { "hour", hourLeft }, { "min", minsLeft }, { "sec", secsLeft } };
        }

        /// <summary>auction::hourToNextDay().</summary>
        public int HourToNextDay()
        {
            return 23 - CopenhagenNow().Hour;
        }

        /// <summary>auction::nextMonday() — whole days remaining until next Monday minus one.</summary>
        public int NextMonday()
        {
            DateTime today = CopenhagenNow().Date;
            int delta = ((int)today.DayOfWeek - (int)DayOfWeek.Monday + 7) % 7;
            DateTime nextM = delta == 0 ? today.AddDays(7) : today.AddDays(7 - delta);
            double datediff = (nextM - today).TotalSeconds;
            return (int)Math.Floor(datediff / (60 * 60 * 24)) - 1;
        }

        /// <summary>auction::blackMarketTime() — fixed historical event end (2014) => "closed".</summary>
        public string[] BlackMarketTime()
        {
            return new[] { "closed", "second: 0, minute: 0, hour:   0, day:    0" };
        }

        /// <summary>auction::minToNextHour().</summary>
        public string MinToNextHour()
        {
            DateTime d = CopenhagenNow();
            int minsLeft = (d.Minute == 59) ? 0 : 60 - d.Minute - 1;
            int secsLeft = 60 - d.Second;
            return "second: " + secsLeft + ", minute: " + minsLeft;
        }

        // ----------------------------------------------------------- xml images

        /// <summary>
        /// auction::getXmlImages($hash) — look up resource_items_auction.xml by hash,
        /// build "/loc/_parts/id.type" URL from location/id/type attributes.
        /// </summary>
        public string GetXmlImages(string hash)
        {
            string source = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "do_img", "global", "xml", "resource_items_auction.xml");
            if (!File.Exists(source)) return null;
            var doc = new System.Xml.XmlDocument();
            doc.Load(source);
            foreach (System.Xml.XmlNode file in doc.DocumentElement.ChildNodes)
            {
                foreach (System.Xml.XmlNode val in file.ChildNodes)
                {
                    var attrs = val.Attributes;
                    if (attrs != null && attrs["hash"] != null && attrs["hash"].Value == hash)
                    {
                        string location = AttrVal(attrs, "location");
                        string id = AttrVal(attrs, "id");
                        string type = AttrVal(attrs, "type");
                        var sb = new StringBuilder("/");
                        foreach (string loc in (location ?? "").Split('_'))
                            sb.Append(loc).Append('/');
                        sb.Append(id).Append('.').Append(type);
                        return sb.ToString();
                    }
                }
            }
            return null;
        }

        private static string AttrVal(System.Xml.XmlAttributeCollection a, string n)
        {
            return a != null && a[n] != null ? a[n].Value : "";
        }

        // -------------------------------------------------------------- helpers

        private static Dictionary<string, string> Msg(string logMessage, string type)
        {
            return new Dictionary<string, string> { { "log_message", logMessage }, { "type", type } };
        }

        internal static List<Dictionary<string, string>> QueryRows(string sql, params Tuple<string, object>[] ps)
        {
            var result = new List<Dictionary<string, string>>();
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(sql, con))
            {
                if (ps != null)
                    foreach (var p in ps) cmd.Parameters.AddWithValue(p.Item1, p.Item2);
                using (var rdr = cmd.ExecuteReader())
                {
                    while (rdr.Read())
                        result.Add(Unity.RowToDict(rdr));
                }
            }
            return result;
        }
    }
}
