using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.rank.php (class `rank`, 630 lines) — PORTING-PLAN A5.
    /// Chunks: A5.1 points calculation (lines 1–205), A5.2 lists/ranks (206–492).
    /// The paginator half (A5.3, lines 493–630) lives in the separate helper class
    /// <see cref="RankPager"/> below (the plan asks for a standalone pager instead of
    /// Rank methods; it is kept in the same file and registered as one csproj Compile item).
    ///
    /// PHP quirks preserved deliberately (documented at each site):
    ///  - cr_allplayers(): the rowCount() branch returns early, everything after it
    ///    ($ret = "&lt;td ...8,816,341,400...") was dead code in PHP — dropped; when the
    ///    SELECT fails $result is undefined → PHP notice → null; C# returns null too;
    ///  - getAllPlayers(): usort comparator returned bool (PHP&lt;7.3 behaviour) — we sort
    ///    with the equivalent "a.total &gt; b.total" boolean comparer;
    ///  - getApprox()/getRankBesideMe(): trailing unreachable `return $result;` after the
    ///    if/else return — dropped (dead code);
    ///  - paginate(): the two elseif branches around current_page were identical — merged;
    ///  - ur_exp/ur_hnr loop 13 rows unconditionally — on short result sets PHP emitted
    ///    notices and printed empty strings; C# prints "" for missing rows (parity);
    ///  - money() bound :playerID but never used it in SQL? — no, it IS used; the dead
    ///    bindParam in Clan.money() does not exist here; both binds ported.
    /// </summary>
    public class Rank
    {
        // private $copyright guard ("die(\"Do not violate my copyright\")") — meaningless
        // in C#, dropped like in all previous chunks of this port.
        private long _uid;
        private long _pid;

        public long Uridium { get; set; }   // public $uridium
        public long Credits { get; set; }   // public $credits

        /// <summary>rank::__construct() — $_GET['page'] handling now lives in RankPager.</summary>
        public Rank()
        {
        }

        /// <summary>rank::setId($uid,$pid) — also refreshes balances via money().</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
            Money();
        }

        /// <summary>rank::money() — SELECT uri, credits FROM server_1_players.</summary>
        public void Money()
        {
            var rows = Query(
                "SELECT uri, credits FROM server_1_players WHERE userID=@userID && playerID=@playerID",
                Kv("@userID", _uid),   // bindParam(':userID', $this->uid, PDO::PARAM_INT)
                Kv("@playerID", _pid)); // bindParam(':playerID', $this->pid, PDO::PARAM_INT)
            if (rows.Count > 0)
            {
                Uridium = ToLong(rows[0]["uri"]);
                Credits = ToLong(rows[0]["credits"]);
            }
        }

        /// <summary>rank::getIdFrom($table,$u,$w) — SELECT * FROM $table WHERE type=:w, row[0][$u].
        /// $table/$u come from fixed call sites ('ships_designs'/'ShipId', 'ships'/'Id') — still
        /// whitelisted because they are interpolated into SQL text.</summary>
        private string GetIdFrom(string table, string u, string w)
        {
            if (!IsSafeIdentifier(table) || !IsSafeIdentifier(u)) return null;
            var rows = Query("SELECT * FROM " + table + " WHERE type=@w", Kv("@w", w));
            if (rows.Count == 0) return null;
            string v;
            return rows[0].TryGetValue(u, out v) ? v : null;
        }

        /// <summary>rank::getShipID($pid) — hangar ship_selected_model → numeric ship id.</summary>
        private int GetShipID(long pid)
        {
            var rows = Query(
                "SELECT ship_selected_model FROM server_1_player_hangar_general_ship WHERE playerID=@playerID LIMIT 1",
                Kv("@playerID", pid));
            if (rows.Count == 0) return 1; // PHP: else return 1 (empty result)
            string model = rows[0]["ship_selected_model"];
            // substr_count(model,'_') > 1  → lookup ships_designs.ShipId by type
            if (CountChar(model, '_') > 1)
            {
                string id = GetIdFrom("ships_designs", "ShipId", model);
                return id != null ? (int)ToLong(id) : 0;
            }
            switch (model)
            {
                case "ship_spearhead": return 11;
                case "ship_aegis": return 12;
                case "ship_citadel": return 13;
                default:
                    {
                        string id = GetIdFrom("ships", "Id", model);
                        return id != null ? (int)ToLong(id) : 0;
                    }
            }
        }

        /// <summary>rank::shipNameFromNumber($num) — 1-based index into the ship name table.
        /// PHP returned null with a notice for out-of-range input — C# returns null likewise.</summary>
        public string ShipNameFromNumber(int num)
        {
            string[] nums =
            {
                "Phoenix", "Yamato", "Leonov", "Defcom", "Liberator", "Piranha", "Nostromo",
                "Vengeance", "Bigboy", "Goliath", "Spearhead", "Aegis", "Citadel"
            };
            int i = num - 1;
            if (i < 0 || i >= nums.Length) return null;
            return nums[i];
        }

        /// <summary>rank::calculateNpcs($arg) — sum npc kills × rankPoints, skipping keys 84/71.
        /// $arg mirrors the PHP array {"npcINFO"=>id=>row, "playerNPC"=>colname=>count}.</summary>
        public static long CalculateNpcs(RankKillArg arg)
        {
            long points = 0;
            foreach (var kv in arg.PlayerNpc)
            {
                string kne = Substr(kv.Key, 3); // substr($key, 3): "npc84" → "84"
                if (kne != "84" && kne != "71")
                {
                    Dictionary<string, string> info;
                    if (arg.NpcInfo.TryGetValue(kne, out info))
                        points += ToLong(kv.Value) * ToLong(Get(info, "rankPoints"));
                }
            }
            return points;
        }

        /// <summary>rank::calculatePlayer($arg) — same but substr($key,4) ("ship11"→"11"), no skips.</summary>
        public static long CalculatePlayer(RankKillArg arg)
        {
            long points = 0;
            foreach (var kv in arg.PlayerNpc)
            {
                string kne = Substr(kv.Key, 4);
                Dictionary<string, string> info;
                if (arg.NpcInfo.TryGetValue(kne, out info))
                    points += ToLong(kv.Value) * ToLong(Get(info, "rankPoints"));
            }
            return points;
        }

        /// <summary>rank::updatePlayerpoints($point,$pid).</summary>
        private static void UpdatePlayerpoints(long point, long pid)
        {
            Execute("UPDATE server_1_players SET playerkills=@playerkills WHERE playerID=@playerID",
                Kv("@playerkills", point), Kv("@playerID", pid));
        }

        /// <summary>rank::updateNPCpoints($point,$pid).</summary>
        private static void UpdateNpcpoints(long point, long pid)
        {
            Execute("UPDATE server_1_players SET npcPoints=@npcPoints WHERE playerID=@playerID",
                Kv("@npcPoints", point), Kv("@playerID", pid));
        }

        /// <summary>rank::getNpcInfo($arg) — loads ships.Id/Name/rankPoints for the collected
        /// npc ids and re-keys arg.npcINFO by Id. PHP built the IN list with implode("','") over
        /// numeric ids — parameterized here (same result set).</summary>
        private static RankKillArg GetNpcInfo(RankKillArg arg)
        {
            if (arg.NpcIds.Count == 0)
            {
                arg.NpcInfo = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase);
                return arg;
            }
            var names = arg.NpcIds.Select((id, idx) => "@n" + idx).ToArray();
            var ps = arg.NpcIds.Select((id, idx) => Kv("@n" + idx, id)).ToArray();
            var rows = Query(
                "SELECT Id, Name, rankPoints FROM ships WHERE Id in (" + string.Join(",", names) + ")", ps);
            var peer = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase);
            foreach (var val in rows)
                peer[Get(val, "Id")] = val;
            arg.NpcInfo = peer;
            return arg;
        }

        /// <summary>rank::gePlayerKills($pid) — player_kills_count row → kill arg struct.
        /// Returns null where PHP returned 0 (missing row); callers test "== 0" ≡ IsNullOrZero.</summary>
        public RankKillArg GePlayerKills(long pid)
        {
            var rows = Query("SELECT * FROM player_kills_count WHERE playerID=@playerID LIMIT 1",
                Kv("@playerID", pid));
            if (rows.Count == 0) return null;
            var first = rows[0];
            first.Remove("playerID"); // unset($result[0]['playerID'])
            var re = new RankKillArg { PlayerNpc = first, NpcInfo = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase) };
            foreach (var kv in first)
            {
                // PHP condition ($key!="ship11" OR $key!="ship12" OR $key!="ship13") is always true
                // (OR-chain of negations) — ported verbatim: every column contributes its key.
                re.NpcIds.Add(Substr(kv.Key, 4));
            }
            return GetNpcInfo(re);
        }

        /// <summary>rank::getNpcKill($pid) — npc_kills row → kill arg struct (substr 3).</summary>
        public RankKillArg GetNpcKill(long pid)
        {
            var rows = Query("SELECT * FROM npc_kills WHERE playerID=@playerID LIMIT 1",
                Kv("@playerID", pid));
            if (rows.Count == 0) return null;
            var first = rows[0];
            first.Remove("playerID");
            var re = new RankKillArg { PlayerNpc = first, NpcInfo = new Dictionary<string, string>(StringComparer.OrdinalIgnoreCase) };
            foreach (var kv in first)
                re.NpcIds.Add(Substr(kv.Key, 3));
            return GetNpcInfo(re);
        }

        // ------------------------------------------------------------------
        // A5.2 — lists / ranks (Class.rank.php lines 206–492)
        // ------------------------------------------------------------------

        /// <summary>rank::cr_allplayers($fid) — number of players of a faction.
        /// PHP: empty($fid) → falls through returning null; dead HTML tail dropped.</summary>
        public long? CrAllplayers(long fid)
        {
            if (fid == 0) return null; // PHP !empty($fid) gate (0/null/false are empty)
            long result;
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT playerID FROM server_1_players WHERE factionId = @fid", con))
            {
                cmd.Parameters.AddWithValue("@fid", fid);
                using (var rdr = cmd.ExecuteReader())
                {
                    result = rdr.Rows.Count > 0 ? rdr.Rows.Count : 0;
                }
            }
            return result;
        }

        /// <summary>rank::ur_exp() — top-13 exp HTML rows (showuser attribute stays the
        /// original dummy "$i*5234" formula, comment in PHP says so).</summary>
        public string UrExp()
        {
            return Top13Rows("exp");
        }

        /// <summary>rank::ur_hnr() — copy-paste twin of ur_exp() over the honor column.</summary>
        public string UrHnr()
        {
            return Top13Rows("honor");
        }

        private string Top13Rows(string column) // column ∈ {"exp","honor"} — whitelist before interpolation
        {
            string col = column == "honor" ? "honor" : "exp";
            var res = Query(
                "SELECT server_1_players.playerID, server_1_players." + col + " AS exp, users.name AS name " +
                "FROM server_1_players, users WHERE users.ID=server_1_players.playerID ORDER BY exp DESC LIMIT 13");
            var ret = new System.Text.StringBuilder();
            for (int i = 0; i < 13; i++)
            {
                string name = "", exp = "";
                if (i < res.Count) { name = Get(res[i], "name"); exp = Get(res[i], "exp"); }
                ret.Append("<tr>");
                ret.Append("<td class=\"rank_position\">" + (i + 1) + "</td>");
                ret.Append("    <td class=\"rank_name\" title=\"\" showuser=\"" + (i * 5234) + "\" style=\"cursor:pointer\">" + name + "</td>");
                ret.Append("    <td class=\"rank_points\">" + NumberFormat0(exp) + "</td>");
                ret.Append("</tr>");
                ret.Append("<tr><td colspan=\"3\" class=\"hof_spacer_vc\"></td></tr>");
            }
            return ret.ToString();
        }

        /// <summary>rank::getAllPlayers($pid=null,$fid=null) — the heavy rank recomputation
        /// entry point. Returns List&lt;Dictionary&gt; with keys exp/honor/playerkills/npckills/
        /// level/days/shipId/total/playerID/userID/Name (+rankName/rankId after calculateRanks).</summary>
        public List<Dictionary<string, object>> GetAllPlayers(long? pid = null, long? fid = null)
        {
            List<Dictionary<string, string>> result;
            bool hasPid = pid.HasValue && pid.Value != 0; // PHP !empty($pid)
            if (hasPid)
            {
                result = Query(
                    "SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID " +
                    "WHERE server_1_players.playerID=@playerID ORDER BY users.ID DESC",
                    Kv("@playerID", pid.Value));
            }
            else
            {
                result = Query(
                    "SELECT * FROM server_1_players INNER JOIN users ON server_1_players.playerID=users.ID " +
                    "WHERE server_1_players.rank not in ('21','99') && server_1_players.factionId=@fid ORDER BY users.ID DESC",
                    Kv("@fid", fid ?? 0));
            }

            var all = new List<Dictionary<string, object>>();
            foreach (var infoRaw in result)
            {
                var info = infoRaw;
                var points = new Dictionary<string, object>(StringComparer.OrdinalIgnoreCase);

                double expVal = ToDouble(Get(info, "exp"));
                points["exp"] = expVal > 100000 ? expVal / 100000.0 : 0.0;
                double honorVal = ToDouble(Get(info, "honor"));
                points["honor"] = honorVal > 100 ? honorVal / 100.0 : 0.0;

                long playerID = ToLong(Get(info, "playerID"));

                if (hasPid)
                {
                    points["playerkills"] = ToLong(Get(info, "playerkills"));
                }
                else
                {
                    var reag = GePlayerKills(playerID);
                    points["playerkills"] = reag != null ? (double)CalculatePlayer(reag) : 0.0;
                    points["playerkills"] = ToDouble(points["playerkills"]) * 3;
                    UpdatePlayerpoints((long)ToDouble(points["playerkills"]), playerID);
                }

                if (hasPid)
                {
                    points["npckills"] = ToLong(Get(info, "npcPoints"));
                }
                else
                {
                    var reag = GetNpcKill(playerID);
                    points["npckills"] = reag != null ? (double)CalculateNpcs(reag) : 0.0;
                    UpdateNpcpoints((long)(ToDouble(points["npckills"]) / 2), playerID);
                }

                points["level"] = ToLong(Get(info, "level")) * 100.0;
                points["days"] = TotalDays(Get(info, "regDate")) * 6.0;
                points["shipId"] = GetShipID(playerID) * 1000.0;

                // PHP compared $info['banned'] == 0 against the users-table join column.
                if (ToLong(Get(info, "banned")) == 0)
                {
                    points["total"] = ToDouble(points["exp"]) + ToDouble(points["honor"]) +
                                      ToDouble(points["playerkills"]) + ToDouble(points["level"]) +
                                      ToDouble(points["days"]) + ToDouble(points["shipId"]) +
                                      ToDouble(points["npckills"]);
                }
                else
                {
                    points["total"] = 0.0;
                }
                points["playerID"] = playerID;
                points["userID"] = ToLong(Get(info, "userID"));
                points["Name"] = Get(info, "Name");
                all.Add(points);
            }

            if (!hasPid)
            {
                // PHP usort with a bool comparator (strtolower($a['total']) > strtolower($b['total']))
                // — OrderByDescending reproduces the intended descending-by-total ordering.
                all = all.OrderByDescending(p => ToDouble(p["total"])).ToList();
                return GiveFactionRanks(CalculateRanks(all, fid));
            }
            all.Reverse(); // array_reverse($all)
            return all;
        }

        /// <summary>rank::setOverAll() — rewrites overallRank by rankpoints DESC for unbanned.</summary>
        public void SetOverAll()
        {
            var result = Query(
                "SELECT server_1_players.playerID, server_1_players.rankpoints, users.banned " +
                "FROM server_1_players INNER JOIN users ON server_1_players.playerID=users.ID " +
                "WHERE users.banned='0' ORDER BY rankpoints DESC");
            SecureSetOverAll(result);
        }

        /// <summary>rank::secureSetOverAll($args).</summary>
        private static void SecureSetOverAll(List<Dictionary<string, string>> args)
        {
            for (int k = 0; k < args.Count; k++)
            {
                int r = k + 1;
                Execute("UPDATE server_1_players SET overallRank=@overallRank WHERE playerID=@playerID",
                    Kv("@overallRank", r), Kv("@playerID", ToLong(Get(args[k], "playerID"))));
            }
        }

        /// <summary>rank::allRanks() — rank table minus ids 20/21/22/99, ordered by id ASC.
        /// PHP left holes after unset() — we just remove entries (callers only iterate values).</summary>
        private static List<Dictionary<string, string>> AllRanks()
        {
            var result = Query("SELECT * FROM rank ORDER BY id ASC");
            return result.Where(v =>
            {
                long id = ToLong(Get(v, "id"));
                return !(id == 21 || id == 22 || id == 99 || id == 20);
            }).ToList();
        }

        /// <summary>rank::calculateRanks($args,$fid) — assigns rankName/rankId by percentage bands.
        /// PHP walked array_keys($args) after unset() shifts; reproduced with an index cursor.</summary>
        private static List<Dictionary<string, object>> CalculateRanks(List<Dictionary<string, object>> args, long? fid)
        {
            var rev = new List<Dictionary<string, object>>(args);
            rev.Reverse(); // array_reverse
            if (rev.Count == 0) return rev;

            var a = new List<Dictionary<string, object>>();
            a.Add(rev[0]);
            a[0]["rankName"] = "General";
            a[0]["rankId"] = 20;
            var rest = rev.Skip(1).ToList(); // unset($args[0]) — remaining ordered list
            int tkeys = rest.Count;

            var ranks = AllRanks();
            ranks.Reverse(); // array_reverse(self::allRanks())
            // $nums keyed by rank id, insertion order preserved (PHP assoc array semantics)
            var nums = new List<KeyValuePair<long, Dictionary<string, object>>>();
            var seen = new HashSet<long>();
            foreach (var v in ranks)
            {
                long id = ToLong(Get(v, "id"));
                if (!seen.Add(id)) continue;
                double cal = Math.Round(ToDouble(Get(v, "percentage")) / 100.0 * tkeys, MidpointRounding.AwayFromZero);
                if (cal < 1) cal = cal + 1;
                var e = new Dictionary<string, object>(StringComparer.OrdinalIgnoreCase)
                {
                    { "players", cal },
                    { "name", Get(v, "name") },
                    { "percentage", ToDouble(Get(v, "percentage")) },
                    { "id", id },
                };
                nums.Add(new KeyValuePair<long, Dictionary<string, object>>(id, e));
            }

            int cursor = 0; // PHP: $k = min(array_keys($args)) — rest is a fresh 0.. list
            foreach (var inPair in nums)
            {
                var inDict = inPair.Value;
                if (cursor >= rest.Count) continue; // PHP: if(!empty($args))
                int players = (int)ToDouble(inDict["players"]);
                for (int i = 0; i < players; i++)
                {
                    if (cursor < rest.Count)
                    {
                        var row = rest[cursor];
                        a.Add(row);
                        row["rankName"] = inDict["name"];
                        row["rankId"] = inPair.Key;
                        cursor++; // PHP unset+increment walks forward through remaining keys
                    }
                }
            }
            return a;
        }

        /// <summary>rank::giveFactionRanks($args) — persists rank/rankpoints/rankPosition/rankName.</summary>
        private static List<Dictionary<string, object>> GiveFactionRanks(List<Dictionary<string, object>> args)
        {
            for (int k = 0; k < args.Count; k++)
            {
                var info = args[k];
                Execute(
                    "UPDATE server_1_players SET rank=@rank, rankpoints=@rankpoints, rankPosition=@rankPosition, rankName=@rankName WHERE playerID=@playerID",
                    Kv("@rank", ToLong(GetObj(info, "rankId"))),
                    Kv("@rankpoints", (long)ToDouble(GetObj(info, "total"))),
                    Kv("@rankPosition", k),
                    Kv("@rankName", Str(GetObj(info, "rankName"))),
                    Kv("@playerID", ToLong(GetObj(info, "playerID"))));
            }
            return args;
        }

        /// <summary>rank::getAllRankingPlayers($limit=null). $limit is interpolated into SQL in
        /// PHP — parsed to int here (whitelist).</summary>
        public List<Dictionary<string, string>> GetAllRankingPlayers(long? limit = null)
        {
            string sql =
                "SELECT * FROM server_1_players INNER JOIN users ON server_1_players.playerID=users.ID " +
                "WHERE server_1_players.rank not in ('0','21','22','99') && users.banned='0' " +
                "ORDER BY server_1_players.overallRank ASC";
            if (limit != null && limit.Value != 0)
                sql += " LIMIT " + limit.Value.ToString(CultureInfo.InvariantCulture);
            var rows = Query(sql);
            LastCount = rows.Count; // $this->count = $stmt->rowCount() — feeds RankPager
            return rows;
        }

        /// <summary>Row count of the last GetAllRankingPlayers() call (PHP private $count).</summary>
        public int LastCount { get; private set; }

        /// <summary>rank::getMyRanking($pid).</summary>
        public List<Dictionary<string, string>> GetMyRanking(long pid)
        {
            return Query(
                "SELECT server_1_players.rank, server_1_players.factionId, server_1_players.rankpoints, " +
                "server_1_players.overallRank, server_1_players.rankPosition, server_1_players.playerID, users.Name " +
                "FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE playerID=@playerID",
                Kv("@playerID", pid));
        }

        /// <summary>rank::getApprox($po,$way,$rid,$fid) — distance to the neighbouring rank band.
        /// $way is whitelisted to "&lt;" or "&gt;" before interpolation.</summary>
        public object GetApprox(long po, string way, long rid, long fid)
        {
            string sql;
            if (way == "<")
            {
                rid = rid - 1;
                sql = "SELECT rankpoints, overallRank, rankPosition FROM server_1_players " +
                      "WHERE factionId=@fid && rankpoints < @po && rank=@rid ORDER BY overallRank ASC LIMIT 1";
            }
            else
            {
                rid = rid + 1;
                sql = "SELECT rankpoints, overallRank, rankPosition FROM server_1_players " +
                      "WHERE factionId=@fid && rankpoints > @po && rank=@rid ORDER BY overallRank DESC LIMIT 1";
            }
            var result = Query(sql, Kv("@po", po), Kv("@rid", rid), Kv("@fid", fid));
            if (result.Count == 0) return "-";
            long pi = ToLong(Get(result[0], "rankpoints"));
            if (way == "<") return pi;
            return pi - po;
        }

        /// <summary>rank::getRankBesideMe($points) — neighbours ±1 overallRank, reversed.</summary>
        public List<Dictionary<string, string>> GetRankBesideMe(long points)
        {
            long be = points + 1;
            long af = points - 1;
            var result = Query(
                "SELECT server_1_players.rank, server_1_players.rankpoints, server_1_players.overallRank, " +
                "server_1_players.rankPosition, server_1_players.playerID, users.Name " +
                "FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID " +
                "WHERE server_1_players.overallRank=@me || server_1_players.overallRank=@be || server_1_players.overallRank=@af " +
                "ORDER BY overallRank DESC",
                Kv("@me", points), Kv("@be", be), Kv("@af", af));
            result.Reverse(); // array_reverse($result)
            return result;
        }

        /// <summary>rank::totalDays($reg) — whole days between regDate and today (UTC-safe).</summary>
        private static int TotalDays(string reg)
        {
            DateTime now = DateTime.UtcNow; // date('Y-m-d')
            DateTime yourDate;
            if (!DateTime.TryParse(reg, CultureInfo.InvariantCulture, DateTimeStyles.None, out yourDate))
                return 0; // strtotime() failure → false → 0 in PHP arithmetic
            yourDate = yourDate.Date;
            int diff = (int)Math.Abs((now.Date - yourDate).TotalSeconds);
            return diff / 86400; // intval($timeDiff/86400)
        }

        // ------------------------------------------------------------------
        // shared helpers (same pattern as Shop/Skylab/Inventory chunks)
        // ------------------------------------------------------------------

        internal static KeyValuePair<string, object> Kv(string k, object v)
        {
            return new KeyValuePair<string, object>(k, v);
        }

        protected static List<Dictionary<string, string>> Query(string sql, params KeyValuePair<string, object>[] ps)
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

        protected static void Execute(string sql, params KeyValuePair<string, object>[] ps)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(sql, con))
            {
                foreach (var p in ps) cmd.Parameters.AddWithValue(p.Key, p.Value);
                cmd.ExecuteNonQuery();
            }
        }

        internal static string Get(IDictionary<string, string> d, string key)
        {
            string v;
            return d != null && d.TryGetValue(key, out v) ? v : null;
        }

        internal static string GetObj(IDictionary<string, object> d, string key)
        {
            object v;
            return d != null && d.TryGetValue(key, out v) ? Str(v) : null;
        }

        internal static string Str(object o)
        {
            return o == null ? "" : Convert.ToString(o, CultureInfo.InvariantCulture);
        }

        internal static long ToLong(object o)
        {
            if (o == null) return 0;
            string s = Convert.ToString(o, CultureInfo.InvariantCulture);
            long v;
            return long.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        internal static double ToDouble(object o)
        {
            if (o == null) return 0;
            string s = Convert.ToString(o, CultureInfo.InvariantCulture);
            double v;
            return double.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        /// <summary>PHP substr($s, $start) — negative-safe, clamps beyond end.</summary>
        internal static string Substr(string s, int start)
        {
            if (s == null) return null;
            if (start < 0) start = Math.Max(0, s.Length + start);
            if (start >= s.Length) return "";
            return s.Substring(start);
        }

        internal static int CountChar(string s, char c)
        {
            if (s == null) return 0;
            int n = 0;
            foreach (char x in s) if (x == c) n++;
            return n;
        }

        /// <summary>number_format($x, 0, '', ',') — thousands separator, no decimals.</summary>
        internal static string NumberFormat0(string value)
        {
            double d = ToDouble(value);
            long l = (long)d; // number_format truncates toward zero
            return l.ToString("#,##0", CultureInfo.InvariantCulture);
        }

        internal static bool IsSafeIdentifier(string s)
        {
            if (string.IsNullOrEmpty(s)) return false;
            foreach (char c in s)
                if (!(char.IsLetterOrDigit(c) || c == '_')) return false;
            return true;
        }
    }

    /// <summary>Mirror of the PHP $arg structure {"npcINFO", "playerNPC"} produced by
    /// gePlayerKills()/getNpcKill() and consumed by calculatePlayer()/calculateNpcs().</summary>
    public class RankKillArg
    {
        public Dictionary<string, string> PlayerNpc;              // $arg['playerNPC'] — kill columns
        public Dictionary<string, string> NpcInfo;                // $arg['npcINFO'] — id ⇒ ships row
        public List<string> NpcIds = new List<string>();          // pre-getNpcInfo id list
    }

    /// <summary>
    /// PORTING-PLAN A5.3 — Class.rank.php lines 493–630 (getCurrentPage…paginate) extracted
    /// into a standalone pager helper class, as the plan requires ("отдельный helper
    /// Paginator.cs вместо методов класса"). Kept in Rank.cs to avoid an extra csproj entry;
    /// namespace/type is global App_Code anyway.
    ///
    /// Quirks preserved:
    ///  - getCurrentPage(): PHP computed clamped values but RETURNED (int)$this-&gt;page
    ///    regardless — reproduced exactly (the clamping had no effect unless page was set);
    ///  - getPager() reads $_GET['page'] (0 when absent); constructor also called getPager();
    ///  - setLimitPerPage threw "Execption" (sic) on non-int — ArgumentException here;
    ///  - paginate(): the two elseif proximity branches emitted identical markup — merged;
    ///  - getTotalOfPages(): PHP divided ints then ceil() — C# uses double division + ceil.
    /// </summary>
    public class RankPager
    {
        private int _count;                 // private $count (from getAllRankingPlayers etc.)
        private int _paginator = 0;         // private $paginator
        private int _limitPerPage = 100;    // private $_limit_per_page = 100
        private int _range = 100;           // private $range
        private int _page = 1;              // private $page
        private string _url = "";           // private $url

        public RankPager()
        {
            GetPager();
            var req = System.Web.HttpContext.Current != null ? System.Web.HttpContext.Current.Request : null;
            string p = req != null ? req.QueryString["page"] : null;
            long pl;
            _page = (p != null && long.TryParse(p, NumberStyles.Any, CultureInfo.InvariantCulture, out pl))
                ? (int)pl : 1;
        }

        /// <summary>rank::getPager() — $_GET['page'] → $paginator (0 when missing).</summary>
        public void GetPager()
        {
            var req = System.Web.HttpContext.Current != null ? System.Web.HttpContext.Current.Request : null;
            string p = req != null ? req.QueryString["page"] : null;
            _paginator = p != null ? (int)ToLong(p) : 0;
        }

        /// <summary>rank::getCurrentPage().</summary>
        public int GetCurrentPage()
        {
            int totalOfPages = (int)GetTotalOfPages();
            int currentPage = IsNumeric(_paginator.ToString(CultureInfo.InvariantCulture)) ? _paginator : 1;
            if (currentPage > totalOfPages) currentPage = totalOfPages;
            if (currentPage < 1) currentPage = 1;
            return _page; // PHP quirk: returned (int)$this->page, ignoring the clamped local
        }

        /// <summary>rank::getLimitPerPage().</summary>
        public int GetLimitPerPage() { return _limitPerPage; }

        /// <summary>rank::getTotalOfResults().</summary>
        public int GetTotalOfResults() { return _count; }

        /// <summary>rank::getTotalOfPages().</summary>
        public double GetTotalOfPages()
        {
            return Math.Ceiling((double)_count / _limitPerPage);
        }

        /// <summary>rank::getPaginator().</summary>
        private int GetPaginator() { return _paginator; }

        /// <summary>rank::setLimitPerPage($limit).</summary>
        public void SetLimitPerPage(int limit)
        {
            _limitPerPage = limit; // PHP threw on non-int; C# type system enforces int
        }

        /// <summary>Feed the private $count that PHP set inside queries (rowCount()).</summary>
        public void SetTotalOfResults(int count) { _count = count; }

        /// <summary>rank::getRange().</summary>
        public int GetRange() { return _range; }

        /// <summary>rank::setUrl($url).</summary>
        public void SetUrl(string url) { _url = url ?? ""; }

        /// <summary>rank::paginate($cl=null) — HTML navigation bar.</summary>
        public string Paginate(string cl = null)
        {
            string c = cl != null ? cl : "";
            int currentPage = GetCurrentPage();
            int totalOfPages = (int)GetTotalOfPages();
            int range = GetRange();
            var navReturn = new System.Text.StringBuilder();

            var req = System.Web.HttpContext.Current != null ? System.Web.HttpContext.Current.Request : null;
            string so = "";
            if (req != null && req.QueryString["sort"] != null && req.QueryString["direction"] != null)
                so = "&sort=" + req.QueryString["sort"] + "&direction=" + req.QueryString["direction"];

            if (_count > 0)
            {
                navReturn.Append("<div id=\"navigation-bar\">");
                if (currentPage > 1)
                {
                    int previous = currentPage - 1;
                    navReturn.Append(" <a href=\"" + _url + "&page=" + previous + so +
                                     "\" class=\"previous hof_pages_prev " + c + "\">Previous</a> ");
                }
                navReturn.Append("<div class=\"hof_pages\">");
                for (int x = currentPage - range; x < currentPage + range + 1; x++)
                {
                    if (x > 0 && x <= totalOfPages)
                    {
                        if (x == currentPage)
                        {
                            navReturn.Append(" <span class=\"current " + c + "\">" + x + "</span> ");
                        }
                        else if (x + 3 == currentPage || x + 2 == currentPage || x + 1 == currentPage ||
                                 x - 3 == currentPage || x - 2 == currentPage || x - 1 == currentPage)
                        {
                            // PHP had two identical elseif branches (xs+1..3 / xs-1..3) — merged.
                            navReturn.Append(" <a href=\"" + _url + "&page=" + x + so +
                                             "\" class=\"others " + c + "\">" + x + "</a> ");
                        }
                        // else: link emission was commented out in PHP — nothing rendered.
                    }
                }
                navReturn.Append("</div>");
                if (currentPage != totalOfPages)
                {
                    int next = currentPage + 1;
                    navReturn.Append(" <a href=\"" + _url + "&page=" + next + so +
                                     "\" class=\"next hof_pages_next " + c + "\">Next</a> ");
                }
                navReturn.Append("</div>");
            }
            return navReturn.ToString();
        }

        private static bool IsNumeric(string s)
        {
            double d;
            return s != null && double.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out d);
        }

        private static long ToLong(string s)
        {
            long v;
            return long.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }
    }
}
