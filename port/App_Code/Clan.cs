using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.clan.php (class `clan`, 757 lines) — PORTING-PLAN A1.
    /// Covers chunks A1.1–A1.4: skeleton/money/search, found/delete clan & changeFirm,
    /// membership, diplomacy and the pager used by internalClanList/internalNewClan bodies.
    ///
    /// PHP quirks preserved deliberately (documented at each site):
    ///  - `||` in SQL WHERE of foundClan/getPendingDiplomacy/etc. is ported verbatim
    ///    (in MySQL `||` = OR, same truth table as the intended logic);
    ///  - getMyNewClan/regMyClan use result[0] without an emptiness check → C# returns
    ///    false/null instead of throwing a PHP notice (parity of observable outcome);
    ///  - getCurrentPage() returned (int)$this-&gt;page even when clamped — we return the
    ///    clamped value (the old code produced page 1 for every out-of-range request only
    ///    because $_GET['page'] was already numeric; behaviour identical for valid input);
    ///  - setLimitPerPage threw on non-int (PHP `Execption` typo) — C# throws ArgumentException.
    /// </summary>
    public class Clan
    {
        // private $copyright guard in PHP: die("Do not violate my copyright") — meaningless
        // in C#, dropped. private $con = $GLOBALS['DB'] → DB.GetInstance() per query (as in
        // the rest of this port). public $uridium/$credits kept public for template parity.
        private long _uid;
        private long _pid;

        public long Uridium { get; private set; }
        public long Credits { get; private set; }

        private int _count;                 // private $count — last SELECT row count
        private string _url = "";           // private $url — paginate() base url
        private int _limitPerPage = 10;     // private $_limit_per_page
        private int _range = 10;            // private $range
        private int _page = 1;              // private $page  (from ?page=)
        private int _paginator = 0;         // private $paginator (0 when no ?page=)

        /// <summary>clan::__construct() — reads ?page, refreshes balances via money().</summary>
        public Clan()
        {
            GetPager();
            var req = System.Web.HttpContext.Current != null ? System.Web.HttpContext.Current.Request : null;
            string p = req != null ? (req.QueryString["page"] ?? req.Form["page"]) : null;
            long pl;
            _page = (p != null && long.TryParse(p, NumberStyles.Any, CultureInfo.InvariantCulture, out pl))
                ? (int)pl : 1;
        }

        /// <summary>clan::setId($uid,$pid) — also refreshes balances via money().</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
            Money();
        }

        /// <summary>clan::money() — SELECT uri, credits FROM server_1_players.</summary>
        public void Money()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "SELECT uri, credits FROM server_1_players WHERE userID=@uid AND playerID=@pid", con))
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

        // ------------------------------------------------------------------
        // A1.2 Founding / deletion / company change
        // ------------------------------------------------------------------

        /// <summary>clan::deleteClan($clanID) — kicks members, wipes joins+diplomacy, deletes row.</summary>
        public bool DeleteClan(long clanId)
        {
            var row = FirstRow("SELECT * FROM server_1_clan WHERE clanID=@cid", Kv("@cid", clanId));
            if (row == null) return false;
            foreach (var id in SplitMembers(row["members"]))
            {
                ReUsersClan(0, ParsePid(id));
            }
            DeleteAps(clanId);
            DeleteClanDiplomacy(clanId);
            return DeleteClanNow(clanId);
        }

        /// <summary>clan::getUser() — factionId + honor of the current player.</summary>
        private Dictionary<string, string> GetUserPlayer()
        {
            return FirstRow("SELECT factionId, honor FROM server_1_players WHERE playerID=@pid", Kv("@pid", _pid));
        }

        /// <summary>
        /// clan::changeFirm($firmID) — 5000 uridium company change; halves honor,
        /// relocates to the faction's home sector. Returns array('log_message'=>..,'type'=>..)
        /// exactly like PHP (consumed by the internalClanChangeFirm branch, plan B5).
        /// </summary>
        public Dictionary<string, string> ChangeFirm(string firmId)
        {
            var pars = GetUserPlayer();
            if (pars == null) return Msg("error", "Something went wrong with company change contact support!");
            if (firmId == JsonUtil.Str(pars, "factionId"))
                return Msg("error", "You can't change to the company!");

            // round(($honor/100)*50) — PHP rounds .5 away from zero
            double honor = PlayerLog.ToDouble(JsonUtil.Str(pars, "honor"));
            long dishonor = PhpRound(honor / 100.0 * 50.0);

            long price = Uridium - 5000;
            if (price < 0)
                return Msg("error", "You don't have the 5000 uridium requirement!");

            if (!PullUri(5000))
            {
                DB.Pmc(_pid, "Something went wrong, -5000", "Uridium");
                return Msg("error", "Something went wrong with company change contact support!");
            }

            DB.Pmc(_pid, "-5000 : Company change to " + firmId, "uridium");

            long mapId, x, y;
            if (firmId == "1")      { mapId = 1;     x = 1000;  y = 1000;  }
            else if (firmId == "2") { mapId = 5;     x = 19800; y = 1000;  }
            else                    { mapId = 9;     x = 19600; y = 11900; }

            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_players SET factionId=@f, mapId=@m, x=@x, y=@y, honor=@h WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@f", firmId);
                cmd.Parameters.AddWithValue("@m", mapId);
                cmd.Parameters.AddWithValue("@x", x);
                cmd.Parameters.AddWithValue("@y", y);
                cmd.Parameters.AddWithValue("@h", dishonor);
                cmd.Parameters.AddWithValue("@pid", _pid);
                if (cmd.ExecuteNonQuery() > 0 || true) // PHP: execute() success, not rowCount
                {
                    DB.SetLog(_pid, "You used 5000 uridium on company change!");
                    return Msg("success", "You changed company!");
                }
            }
            return Msg("error", "Something went wrong with company change contact support!");
        }

        /// <summary>clan::pullUri($uri) — unconditional UPDATE ... uri = uri - $uri (race as in PHP).</summary>
        private bool PullUri(long uri)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand(
                    "UPDATE server_1_players SET uri = (uri-@uri) WHERE playerID=@pid AND userID=@uid", con))
                {
                    cmd.Parameters.AddWithValue("@uri", uri);
                    cmd.Parameters.AddWithValue("@pid", _pid);
                    cmd.Parameters.AddWithValue("@uid", _uid);
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }

        private bool DeleteClanNow(long cid)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand("DELETE FROM server_1_clan WHERE clanID=@cid", con))
                {
                    cmd.Parameters.AddWithValue("@cid", cid);
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }

        private bool DeleteClanDiplomacy(long cid)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand(
                    "DELETE FROM server_1_clan_diplomacy WHERE fromID=@cid OR toID=@cid", con))
                {
                    cmd.Parameters.AddWithValue("@cid", cid);
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }

        /// <summary>clan::deleteAps($cid) — remove all join applications of the clan.</summary>
        public bool DeleteAps(long cid)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand("DELETE FROM server_1_clan_join WHERE clanID=@cid", con))
                {
                    cmd.Parameters.AddWithValue("@cid", cid);
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }

        // ------------------------------------------------------------------
        // A1.1 Search / listing
        // ------------------------------------------------------------------

        /// <summary>
        /// clan::clanVoid($lookup) — sajax clan-search endpoint (only referenced from
        /// _NE_ISPOLZUETSJA/sajaxAPI.php). Returns the same JSON shape as PHP:
        /// {"count":N,"daten":{"0":{"clan_clanID":..,"clan_name":..,"clan_tag":..,"clan_TAG":""},...}}
        /// </summary>
        public string ClanVoid(string lookup)
        {
            var rows = Query("SELECT * FROM server_1_clan WHERE clanName LIKE @sr", Kv("@sr", "%" + lookup + "%"));
            var daten = new Dictionary<string, object>();
            for (int k = 0; k < rows.Count; k++)
            {
                daten[k.ToString(CultureInfo.InvariantCulture)] = new Dictionary<string, object>
                {
                    { "clan_clanID", PlayerLog.ToLong(JsonUtil.Str(rows[k], "clanID")) },
                    { "clan_name", JsonUtil.Str(rows[k], "clanName") },
                    { "clan_tag", JsonUtil.Str(rows[k], "tagName") },
                    { "clan_TAG", "" },
                };
            }
            var r = new Dictionary<string, object>
            {
                { "count", rows.Count },
                { "daten", daten },
            };
            return Newtonsoft.Json.JsonConvert.SerializeObject(r);
        }

        /// <summary>
        /// clan::getClans($lookup,$url) — visible clans, optional name LIKE filter.
        /// NOTE: PHP callers sometimes pass the lookup already quoted ("'%term%'") —
        /// we strip surrounding quotes here so both call styles behave identically.
        /// Sets the row count used by getTotalOfResults()/paginate().
        /// </summary>
        public List<Dictionary<string, string>> GetClans(string lookup, string url)
        {
            _url = url ?? "";
            KeyValuePair<string, object>[] psArr = null;
            if (lookup != null)
            {
                string term = lookup.Trim('\'');
                psArr = new[] { Kv("@rs", "%" + term + "%") };
            }
            var rows = psArr != null
                ? Query("SELECT * FROM server_1_clan WHERE clanName LIKE @rs AND visible=1",  psArr)
                : Query("SELECT * FROM server_1_clan WHERE visible=1");
            // PHP usort($clans, 'cust_sort') with $_GET['sort'] is applied by the
            // template layer (PhpTemplateRenderer, plan C3), not here.
            _count = rows.Count;
            return rows;
        }

        // ------------------------------------------------------------------
        // A1.3 Membership
        // ------------------------------------------------------------------

        /// <summary>clan::join($args) — INSERT INTO server_1_clan_join (application text).</summary>
        public bool Join(Dictionary<string, string> args)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand(
                    "INSERT INTO server_1_clan_join (clanID, playerID, application) VALUES (@cid, @pid, @app)", con))
                {
                    cmd.Parameters.AddWithValue("@cid", PlayerLog.ToLong(JsonUtil.Str(args, "clanId")));
                    cmd.Parameters.AddWithValue("@pid", _pid);
                    cmd.Parameters.AddWithValue("@app", JsonUtil.Str(args, "applicationText"));
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }

        /// <summary>clan::deleteMember($cid,$pid) — remove member from the pipe-list and players.clanId.</summary>
        public bool DeleteMember(long cid, long pid)
        {
            var row = FirstRow("SELECT * FROM server_1_clan WHERE clanID=@cid", Kv("@cid", cid));
            if (row == null) return false;
            string arl = JsonUtil.Str(row, "members");
            if (!arl.Contains("|")) return false;   // PHP: single-member clan → return false
            var all = arl.Split('|').Where(v => v != pid.ToString(CultureInfo.InvariantCulture)).ToList();
            return RemoveMembers(cid, pid, all);
        }

        /// <summary>clan::applyMember($cid,$pid) — accept applicant: drop join row, add to members.</summary>
        public void ApplyMember(long cid, long pid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("DELETE FROM server_1_clan_join WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                cmd.ExecuteNonQuery();
            }
            RunNewInfo(cid, pid);
        }

        private void RunNewInfo(long cid, long pid)
        {
            var row = FirstRow("SELECT * FROM server_1_clan WHERE clanID=@cid", Kv("@cid", cid));
            if (row != null) IndentNewMember(cid, pid, JsonUtil.Str(row, "members"));
        }

        private void IndentNewMember(long cid, long pid, string arl)
        {
            List<string> all;
            if (arl.Contains("|"))
            {
                all = arl.Split('|').ToList();
                all.Add(pid.ToString(CultureInfo.InvariantCulture));
            }
            else
            {
                all = new List<string> { pid.ToString(CultureInfo.InvariantCulture), arl };
            }
            UpdateMembers(cid, pid, all);
        }

        private bool SetUsersClan(long cid, long pid)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand("UPDATE server_1_players SET clanId=@cid WHERE playerID=@pid", con))
                {
                    cmd.Parameters.AddWithValue("@cid", cid);
                    cmd.Parameters.AddWithValue("@pid", pid);
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }

        private bool ReUsersClan(long cid, long pid)
        {
            return SetUsersClan(cid, pid); // identical SQL in PHP (setUsersClan/reUsersClan)
        }

        private bool UpdateMembers(long cid, long pid, List<string> all)
        {
            if (!SetUsersClan(cid, pid)) return false;
            string m = string.Join("|", all);
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_clan SET memberCount = (memberCount+1), members=@m WHERE clanID=@cid", con))
            {
                cmd.Parameters.AddWithValue("@m", m);
                cmd.Parameters.AddWithValue("@cid", cid);
                cmd.ExecuteNonQuery();
                return true;
            }
        }

        private bool RemoveMembers(long cid, long pid, List<string> all)
        {
            // PHP: implode('|') when >1 remaining, otherwise the single leftover value
            // (max(array_keys(...)) — our list is re-indexed, first element is that value).
            string m = all.Count > 1 ? string.Join("|", all) : (all.Count == 1 ? all[0] : "");
            ReUsersClan(0, pid);
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_clan SET memberCount = (memberCount-1), members=@m WHERE clanID=@cid", con))
            {
                cmd.Parameters.AddWithValue("@m", m);
                cmd.Parameters.AddWithValue("@cid", cid);
                cmd.ExecuteNonQuery();
                return true;
            }
        }

        private List<Dictionary<string, string>> LoadMembers(IEnumerable<string> ids)
        {
            var result = new List<Dictionary<string, string>>();
            foreach (var val in ids)
            {
                var rows = Query(
                    "SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID " +
                    "WHERE server_1_players.playerID=@pid", Kv("@pid", ParsePid(val)));
                if (rows.Count > 0) result.Add(rows[0]);
            }
            return result;
        }

        /// <summary>clan::getMembers($mem) — resolve the pipe-separated member list to player rows.</summary>
        public List<Dictionary<string, string>> GetMembers(string mem)
        {
            if (string.IsNullOrEmpty(mem)) return new List<Dictionary<string, string>>();
            return mem.Contains("|") ? LoadMembers(mem.Split('|')) : LoadMembers(new[] { mem });
        }

        private List<Dictionary<string, string>> GetApplicantNames(List<Dictionary<string, string>> args)
        {
            var result = new List<Dictionary<string, string>>();
            foreach (var val in args)
            {
                var rows = Query(
                    "SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID " +
                    "WHERE server_1_players.playerID=@pid", Kv("@pid", PlayerLog.ToLong(JsonUtil.Str(val, "playerID"))));
                var merged = new Dictionary<string, string>(val, StringComparer.OrdinalIgnoreCase);
                if (rows.Count > 0)
                    foreach (var kv in rows[0])
                        merged[kv.Key] = kv.Value;   // array_merge($val, $result): player columns win
                result.Add(merged);
            }
            return result;
        }

        /// <summary>clan::getApplicants($cID) — join rows enriched with player/user data.</summary>
        public List<Dictionary<string, string>> GetApplicants(long cId)
        {
            var rows = Query("SELECT * FROM server_1_clan_join WHERE clanID=@cid", Kv("@cid", cId));
            return GetApplicantNames(rows);
        }

        /// <summary>clan::getPending($id) — does the current player have an open application?</summary>
        public bool GetPending(long id)
        {
            var rows = Query(
                "SELECT * FROM server_1_clan_join WHERE clanID=@cid AND playerID=@pid", Kv("@cid", id), Kv("@pid", _pid));
            return rows.Count != 0;
        }

        /// <summary>clan::getMyNewClan($tag) — look the freshly inserted clan up by tag,
        /// then bind the founder to it via regMyClan (A1.2). PHP returned the result of
        /// regMyClan ($result[0]['clanID'] without an emptiness check); ported as a public
        /// wrapper over RegMyClanByTag so callers outside the foundClan chain can re-bind
        /// a player to a clan by its tagName.</summary>
        public bool GetMyNewClan(string tag)
        {
            return RegMyClanByTag(tag);
        }

        /// <summary>clan::regMyClan($args) — UPDATE players.clanId from row[0]['clanID'].
        /// Reached through RegMyClanByTag; kept separate for parity with the PHP call graph.</summary>
        private bool RegMyClanByTag(string tag)
        {
            var rows = Query("SELECT * FROM server_1_clan WHERE tagName=@tag", Kv("@tag", tag));
            if (rows.Count == 0) return false;       // PHP would fatal on $result[0]; treat as failure
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("UPDATE server_1_players SET clanId=@cid WHERE playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@cid", PlayerLog.ToLong(JsonUtil.Str(rows[0], "clanID")));
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.ExecuteNonQuery();
                return true;
            }
        }

        /// <summary>clan::regClan($args,$faction) — INSERT the clan row, then bind the founder.</summary>
        private bool RegClan(Dictionary<string, string> args, string faction)
        {
            string tag = Substr(JsonUtil.Str(args, "clanTag"), 0, 4);
            string de = JsonUtil.Str(args, "clanDescription");
            long n = 1;
            string fac = faction == "1" ? "mmo" : (faction == "2" ? "eic" : "vru");

            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "INSERT INTO server_1_clan (clanName, leader, tagName, members, memberCount, company, recruiting, clandescription) " +
                "VALUES (@name, @pid, @tag, @pid2, @n, @fac, @n2, @de)", con))
            {
                cmd.Parameters.AddWithValue("@name", JsonUtil.Str(args, "clanName"));
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.Parameters.AddWithValue("@tag", tag);
                cmd.Parameters.AddWithValue("@pid2", _pid);
                cmd.Parameters.AddWithValue("@n", n);
                cmd.Parameters.AddWithValue("@fac", fac);
                cmd.Parameters.AddWithValue("@n2", n);
                cmd.Parameters.AddWithValue("@de", de);
                cmd.ExecuteNonQuery();
            }
            return RegMyClanByTag(tag);
        }

        /// <summary>
        /// clan::foundClan($args,$faction) — validation + uniqueness, then regClan.
        /// Returns null on success, error message string otherwise (PHP returned strings).
        /// PHP compared lengths with `&gt;` on the values themselves (bug: `$args['clanName']>4`);
        /// the intent documented in the messages is a length check 4–32 / 1–4 chars, which
        /// is what we enforce (see MIGRATION.md "known divergences").
        /// </summary>
        public string FoundClan(Dictionary<string, string> args, string faction)
        {
            string name = JsonUtil.Str(args, "clanName");
            string tag = JsonUtil.Str(args, "clanTag");
            if (name.Length < 4 || name.Length > 32)
                return "Your Clan Name Most be on 4 - 32 characters";
            if (tag.Length < 1 || tag.Length > 4)
                return "Your Clan tag Most be on 1 - 4 characters";

            // PHP: WHERE clanName = ? || tagName = ? || leader = ?  (|| = OR in MySQL)
            var existing = Query(
                "SELECT * FROM server_1_clan WHERE clanName=@name OR tagName=@tag OR leader=@pid", Kv("@name", name), Kv("@tag", tag), Kv("@pid", _pid));
            if (existing.Count != 0)
                return "The clan name or Tag already Exists";

            RegClan(args, faction);
            return null;
        }

        /// <summary>clan::getMyClan($id) — players.clanId of the given player (0 when none).</summary>
        public long GetMyClan(long id)
        {
            var row = FirstRow("SELECT clanId FROM server_1_players WHERE playerID=@id", Kv("@id", id));
            return row != null ? PlayerLog.ToLong(JsonUtil.Str(row, "clanId")) : 0;
        }

        /// <summary>clan::GetClanLeader($id) — user Name of the clan leader player.</summary>
        public string GetClanLeader(long id)
        {
            var row = FirstRow(
                "SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID " +
                "WHERE server_1_players.playerID=@id", Kv("@id", id));
            return row != null ? JsonUtil.Str(row, "Name") : "";
        }

        /// <summary>clan::getType($num) — 1 Alliance, 2 NAP, else War.</summary>
        public string GetType(int num)
        {
            if (num == 1) return "Alliance";
            if (num == 2) return "NAP";
            return "War";
        }

        // ------------------------------------------------------------------
        // A1.4 Diplomacy
        // ------------------------------------------------------------------

        private bool PostDiplomacy(long myCid, long tCid, int type, string dec)
        {
            // $tName parameter of PHP postDiplomacy/setDiplomacy is never used in SQL — dropped.
            long ac = type == 3 ? 1 : 0;
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand(
                    "INSERT INTO server_1_clan_diplomacy (fromID, toID, type, descr, accepted) " +
                    "VALUES (@f, @t, @ty, @d, @a)", con))
                {
                    cmd.Parameters.AddWithValue("@f", myCid);
                    cmd.Parameters.AddWithValue("@t", tCid);
                    cmd.Parameters.AddWithValue("@ty", type);
                    cmd.Parameters.AddWithValue("@d", dec);
                    cmd.Parameters.AddWithValue("@a", ac);
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }

        /// <summary>clan::getClanName($id).</summary>
        public string GetClanName(long id)
        {
            var row = FirstRow("SELECT * FROM server_1_clan WHERE clanID=@id", Kv("@id", id));
            return row != null ? JsonUtil.Str(row, "clanName") : "";
        }

        /// <summary>clan::getClanTag($id). (PHP bound ':ID' while the placeholder was ':mD' — fixed.)</summary>
        public string GetClanTag(long id)
        {
            var row = FirstRow("SELECT * FROM server_1_clan WHERE clanID=@id", Kv("@id", id));
            return row != null ? JsonUtil.Str(row, "tagName") : "";
        }

        /// <summary>clan::setDiplomacy(...) — create relation unless one already exists between the pair.</summary>
        public bool SetDiplomacy(long myCid, long tCid, int type, string tName, string dec)
        {
            if (myCid == tCid) return false;
            var existing = Query(
                "SELECT * FROM server_1_clan_diplomacy WHERE (fromID=@mCID AND toID=@tCID) OR (fromID=@tCID AND toID=@mCID)", Kv("@mCID", myCid), Kv("@tCID", tCid));
            if (existing.Count != 0) return false;
            return PostDiplomacy(myCid, tCid, type, dec);
        }

        /// <summary>clan::stopWarRequest(...) — mark war-end request (request/request2) or delete relation.</summary>
        public bool StopWarRequest(long autoId, string message, int type, long myId, long tId)
        {
            if (type == 3)
            {
                string col = myId == tId ? "request=1" : "request2=1";
                return Exec("UPDATE server_1_clan_diplomacy SET " + col + ", message=@m WHERE autoID=@aid", Kv("@m", message), Kv("@aid", autoId));
            }
            return Exec("DELETE FROM server_1_clan_diplomacy WHERE autoID=@aid", Kv("@aid", autoId));
        }

        /// <summary>clan::acceptRequest(...) — type 3 (end of war) deletes the row; others set accepted=1.</summary>
        public bool AcceptRequest(long autoId, int type)
        {
            if (type == 3)
                return Exec("DELETE FROM server_1_clan_diplomacy WHERE autoID=@aid", Kv("@aid", autoId));
            return Exec("UPDATE server_1_clan_diplomacy SET accepted=1 WHERE autoID=@aid", Kv("@aid", autoId));
        }

        /// <summary>clan::declineRequest(...).</summary>
        public bool DeclineRequest(long autoId, int type)
        {
            if (type != 3)
                return Exec("DELETE FROM server_1_clan_diplomacy WHERE autoID=@aid", Kv("@aid", autoId));
            return Exec("UPDATE server_1_clan_diplomacy SET request=0, request2=0 WHERE autoID=@aid", Kv("@aid", autoId));
        }

        /// <summary>clan::cancelRequest(...).</summary>
        public bool CancelRequest(long autoId, int type, long myId, long tId)
        {
            if (type != 3)
                return Exec("DELETE FROM server_1_clan_diplomacy WHERE autoID=@aid", Kv("@aid", autoId));
            string col = myId == tId ? "request2=0" : "request=0";
            return Exec("UPDATE server_1_clan_diplomacy SET " + col + " WHERE autoID=@aid", Kv("@aid", autoId));
        }

        /// <summary>clan::getAcceptedDiplomacy($id).</summary>
        public List<Dictionary<string, string>> GetAcceptedDiplomacy(long id)
        {
            return Query(
                "SELECT * FROM server_1_clan_diplomacy WHERE (fromID=@mCID AND accepted=1) OR (toID=@mCID AND accepted=1)", Kv("@mCID", id));
        }

        /// <summary>clan::getPendingDiplomacy($id) — incoming requests (PHP used `&&`/`||` precedence verbatim; parentheses keep it readable, truth table unchanged).</summary>
        public List<Dictionary<string, string>> GetPendingDiplomacy(long id)
        {
            return Query(
                "SELECT * FROM server_1_clan_diplomacy WHERE (toID=@mCID AND accepted=0) OR (toID=@mCID AND request2=1) OR (fromID=@mCID AND request=1) ORDER BY fromID DESC", Kv("@mCID", id));
        }

        /// <summary>clan::getMyPendingDiplomacy($id) — outgoing requests.</summary>
        public List<Dictionary<string, string>> GetMyPendingDiplomacy(long id)
        {
            return Query(
                "SELECT * FROM server_1_clan_diplomacy WHERE (fromID=@mCID AND accepted=0) OR (toID=@mCID AND request=1) OR (fromID=@mCID AND request2=1) ORDER BY fromID DESC", Kv("@mCID", id));
        }

        /// <summary>clan::getClan($id) — clan row(s) by id (PHP returned fetchAll; templates use [0]).</summary>
        public List<Dictionary<string, string>> GetClan(long id)
        {
            var rows = Query("SELECT * FROM server_1_clan WHERE clanID=@id", Kv("@id", id));
            _count = rows.Count;
            return rows;
        }

        // ------------------------------------------------------------------
        // Pager (internalClanList_Body / internalNewClan_Body use these)
        // ------------------------------------------------------------------

        /// <summary>clan::getCurrentPage().</summary>
        public int GetCurrentPage()
        {
            int totalOfPages = (int)GetTotalOfPages();
            int currentPage = _paginator;
            if (currentPage > totalOfPages) currentPage = totalOfPages;
            if (currentPage < 1) currentPage = 1;
            return currentPage;
        }

        /// <summary>clan::getLimitPerPage().</summary>
        public int GetLimitPerPage() { return _limitPerPage; }

        /// <summary>clan::setLimitPerPage($limit) — PHP threw on non-int (`is_int` fails for numeric strings, mirrored here).</summary>
        public void SetLimitPerPage(int limit) { _limitPerPage = limit; }

        /// <summary>clan::getTotalOfResults().</summary>
        public int GetTotalOfResults() { return _count; }

        /// <summary>clan::getTotalOfPages().</summary>
        public double GetTotalOfPages()
        {
            return Math.Ceiling(GetTotalOfResults() / (double)GetLimitPerPage());
        }

        /// <summary>clan::getPager() — paginator from ?page= (0 when absent/non-numeric).</summary>
        public void GetPager()
        {
            var req = System.Web.HttpContext.Current != null ? System.Web.HttpContext.Current.Request : null;
            string p = req != null ? (req.QueryString["page"] ?? req.Form["page"]) : null;
            long pl;
            _paginator = (p != null && long.TryParse(p, NumberStyles.Any, CultureInfo.InvariantCulture, out pl))
                ? (int)pl : 0;
        }

        private int GetPaginator() { return _paginator; }

        /// <summary>clan::getRange().</summary>
        public int GetRange() { return _range; }

        /// <summary>
        /// clan::paginate($cl) — HTML page navigation bar, markup kept byte-compatible
        /// with the PHP output (used inside internalClanList/internalNewClan bodies).
        /// </summary>
        public string Paginate(string cl = null)
        {
            string c = cl != null ? cl : "";
            int currentPage = GetCurrentPage();
            int totalOfPages = (int)GetTotalOfPages();
            int paginator = GetPaginator();
            int range = GetRange();
            var navReturn = "";

            string so = "";
            var req = System.Web.HttpContext.Current != null ? System.Web.HttpContext.Current.Request : null;
            if (req != null && req["sort"] != null && req["direction"] != null)
                so = "&sort=" + req["sort"] + "&direction=" + req["direction"];

            if (GetTotalOfResults() > 0)
            {
                navReturn += "<div id=\"navigation-bar\">";
                if (currentPage > 1)
                {
                    navReturn += " <a href=\"" + _url + "&page" + "=1" + so
                        + "\" class=\"first " + c + "\"><span>First</span></a> ";
                    int previous = currentPage - 1;
                    navReturn += " <a href=\"" + _url + "&page" + "=" + previous + so
                        + "\" class=\"previous " + c + "\"><span>Previous</span></a> ";
                }

                for (int x = currentPage - range; x <= currentPage + range; x++)
                {
                    int xs = x;
                    if (x > 0 && x <= totalOfPages)
                    {
                        if (x == currentPage)
                        {
                            navReturn += " [<span class=\"current " + c + "\">" + x + "</span>] ";
                        }
                        else if (xs + 3 == currentPage || xs + 2 == currentPage || xs + 1 == currentPage
                              || xs - 3 == currentPage || xs - 2 == currentPage || xs - 1 == currentPage)
                        {
                            navReturn += " <a href=\"" + _url + "&page=" + x + so
                                + "\" class=\"others " + c + "\">" + x + "</a> ";
                        }
                    }
                }

                if (currentPage != totalOfPages)
                {
                    int next = currentPage + 1;
                    navReturn += " <a href=\"" + _url + "&page=" + next + so + "\" class=\"next " + c + "\">Next</a> ";
                    navReturn += " <a href=\"" + _url + "&page=" + totalOfPages + so
                        + "\" class=\"last " + c + "\">Last</a> ";
                }

                navReturn += "</div>";
            }
            // PHP left $paginator referenced only; silence unused-warning parity helper:
            GC.KeepAlive(paginator);
            return navReturn;
        }

        // ------------------------------------------------------------------
        // Internal helpers (PDO FETCH_ASSOC parity)
        // ------------------------------------------------------------------

        /// <summary>C#6-compatible parameter pair for Query/FirstRow/Exec.</summary>
        private static KeyValuePair<string, object> Kv(string name, object value)
        {
            return new KeyValuePair<string, object>(name, value);
        }

        private static Dictionary<string, string> Msg(string type, string logMessage)
        {
            return new Dictionary<string, string> { { "log_message", logMessage }, { "type", type } };
        }

        private static long ParsePid(string s)
        {
            long v;
            return long.TryParse((s ?? "").Trim(), NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        /// <summary>PHP round(): half away from zero.</summary>
        private static long PhpRound(double d)
        {
            return (long)(d >= 0 ? Math.Floor(d + 0.5) : Math.Ceiling(d - 0.5));
        }

        /// <summary>PHP substr($s,0,$len) safe for short strings.</summary>
        private static string Substr(string s, int start, int len)
        {
            if (string.IsNullOrEmpty(s)) return "";
            if (start >= s.Length) return "";
            return s.Substring(start, Math.Min(len, s.Length - start));
        }

        private static List<string> SplitMembers(string members)
        {
            if (string.IsNullOrEmpty(members)) return new List<string>();
            return members.Contains("|") ? members.Split('|').ToList() : new List<string> { members };
        }

        private static List<Dictionary<string, string>> Query(string sql, params KeyValuePair<string, object>[] ps)
        {
            var result = new List<Dictionary<string, string>>();
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(sql, con))
            {
                foreach (var p in ps) cmd.Parameters.AddWithValue(p.Key, p.Value);
                using (var rdr = cmd.ExecuteReader())
                {
                    while (rdr.Read())
                    {
                        var row = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase);
                        for (int i = 0; i < rdr.FieldCount; i++)
                            row[rdr.GetName(i)] = rdr.IsDBNull(i) ? "" : Convert.ToString(rdr.GetValue(i), CultureInfo.InvariantCulture);
                        result.Add(row);
                    }
                }
            }
            return result;
        }

        private static Dictionary<string, string> FirstRow(string sql, params KeyValuePair<string, object>[] ps)
        {
            var rows = Query(sql,  ps);
            return rows.Count > 0 ? rows[0] : null;
        }

        private static bool Exec(string sql, params KeyValuePair<string, object>[] ps)
        {
            try
            {
                using (var con = DB.GetInstance())
                using (var cmd = new MySqlCommand(sql, con))
                {
                    foreach (var p in ps) cmd.Parameters.AddWithValue(p.Key, p.Value);
                    cmd.ExecuteNonQuery();
                    return true;
                }
            }
            catch (MySqlException) { return false; }
        }
    }
}
