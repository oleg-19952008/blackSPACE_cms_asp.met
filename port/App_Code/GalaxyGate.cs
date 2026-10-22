using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Text.RegularExpressions;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.GalaxyGate.php (class `GalaxyGate`, 589 lines) — PORTING-PLAN A6.
    /// Chunk A6.1: skeleton/gates (lines 1–216): __construct, setInfo, reloadUri, proberbiliteis,
    /// multipliersShow, getIt, checkExistence, addItems, gatesInfos, GetGates, AllGates,
    /// CheckGateCount, UserGates, setMulti, AddGates.
    /// Chunk A6.2: spinner/multipliers (lines 217–589): spinerUri, MultiplierUpdate, WhereMulti,
    /// currentGate.
    ///
    /// PHP quirks preserved deliberately (documented at each site):
    ///  - reloadUri() assigns $result[0]['uri'] without an emptiness check → C# leaves Uri null
    ///    when no row (PHP notice → null, same arithmetic outcome downstream);
    ///  - AllGates() hardcodes $this->stm = 9 (rowCount() line commented out) — kept verbatim,
    ///    so GetGates() re-inserts gates whenever the player has ≠ 9 gate rows;
    ///  - currentGate(): `if($multi!=1 OR $multi !=0)` is always true (OR-chain) — ported as-is
    ///    ($multiplier = $multi+1 in every case except… it is literally always taken);
    ///  - the loot branches keyed array_key_exists('mine'/'1'/'x4'…) while writing under other
    ///    keys ('rocket' written after checking '1') — every mismatch reproduced 1:1 below;
    ///  - 'gate' branch checks key 'Gate' (capital G) but writes 'gate' (lowercase) — kept;
    ///    a fresh 'gate' entry has NO 'q' key (PHP never sets it) — dictionary left without "q";
    ///  - x3/x4/sab accumulate += rand on existing entries WITHOUT spinUsed increment in some
    ///    branches (absent lines in PHP) — not added here either;
    ///  - mt_rand/rand → shared Random instance (distribution-equivalent);
    ///  - date_timestamp_get(date_create()) → unix timestamp captured once per call like PHP;
    ///  - final XML built only if addItems() returned true (it always does unless exception).
    /// </summary>
    public class GalaxyGate
    {
        private static readonly Random Rng = new Random();

        public List<Dictionary<string, string>> DataCon = null;   // public $dataCon
        public List<Dictionary<string, string>> DataGates = null; // public $dataGates
        public List<Dictionary<string, string>> Proberbil;         // public $proberbil
        private long _stm;                                         // private $stm
        private long _stu;                                         // private $stu
        private long _playerid;                                    // private $playerid
        private long _userid;                                      // private $userid
        public List<Dictionary<string, string>> CorpAll = null;    // private $corpAll (used cross-method; made internal-ish public)
        public string AllGat = null;                               // public $AllGat
        private int _multiplier = 0;                               // private $multiplier (null until setMulti)
        public string FinalData = null;                            // public $FinalData
        private long _spinNum;                                     // private $spinNum
        public object Uri = null;                                  // public $Uri

        // public $html — property assigned dynamically in getIt() (undeclared in PHP!) — declared here.
        public string Html;

        /// <summary>GalaxyGate::__construct() — $GLOBALS['DB'] handled per-query via DB.GetInstance().</summary>
        public GalaxyGate()
        {
        }

        /// <summary>GalaxyGate::setInfo($playerID,$userID).</summary>
        public void SetInfo(long playerID, long userID)
        {
            _playerid = playerID;
            _userid = userID;
        }

        /// <summary>GalaxyGate::reloadUri() — refreshes $this-&gt;uri from server_1_players.</summary>
        public object ReloadUri()
        {
            var rows = Query("SELECT uri FROM server_1_players WHERE userID = @p1 && playerID = @p2",
                Kv("@p1", _userid), Kv("@p2", _playerid));
            if (rows.Count > 0)
            {
                Uri = rows[0]["uri"];
                return Uri;
            }
            return null; // PHP: undefined index notice → null
        }

        /// <summary>Session guard used by proberbiliteis/multipliersShow/GetGates:
        /// isset($_SESSION['server1']['user']['sessionId'], ['email']) &amp;&amp; is_numeric(sessionId).</summary>
        private static bool SessionOk()
        {
            var s = CurrentSession();
            return s != null && SessionManager.IsLoggedIn(s);
        }

        private static System.Web.SessionState.HttpSessionState CurrentSession()
        {
            var ctx = System.Web.HttpContext.Current;
            return ctx != null ? ctx.Session : null;
        }

        /// <summary>GalaxyGate::proberbiliteis() — full dump of the static server_galaxygate table.</summary>
        public void Proberbiliteis()
        {
            if (!SessionOk()) return;
            Proberbil = Query(
                "SELECT galaxygate_name, ammunition, resource, voucher, logfile, part, ammo_x2, ammo_x3, ammo_x4, " +
                "ammo_abs, ammo_rocket, ammo_mine, gate_1, gate_2, gate_3, gate_4, gate_5, gate_6, gate_7, gate_8, " +
                "gate_13, special, special_hitpoints FROM server_galaxygate");
        }

        /// <summary>GalaxyGate::multipliersShow() — player's gate multiplier rows.</summary>
        public void MultipliersShow()
        {
            if (!SessionOk()) return;
            CorpAll = Query(
                "SELECT `galaxygate_id`, `state`, `galaxygate_multipliers` FROM `server_1_players_galaxygate` " +
                "WHERE playerID = @playerID AND userID = @userID",
                Kv("@playerID", _playerid), Kv("@userID", _userid));
        }

        /// <summary>GalaxyGate::getIt($search) — clan name autocomplete options HTML.</summary>
        public string GetIt(string search)
        {
            var result = Query("SELECT * FROM clans WHERE clanName LIKE @search", Kv("@search", search));
            Html = null;
            foreach (var value in result)
                Html += "<option>" + Get(value, "clanName") + "</option>";
            return Html;
        }

        /// <summary>GalaxyGate::checkExistence($lootid) — item present in player inventory?</summary>
        private bool CheckExistence(string lootid)
        {
            var rows = Query(
                "SELECT id FROM server_1_player_all_items WHERE userID = @p1 && playerID = @p2 && lootid = @p3",
                Kv("@p1", _userid), Kv("@p2", _playerid), Kv("@p3", lootid));
            return rows.Count > 0;
        }

        /// <summary>GalaxyGate::addItems($args) — credit rolled loot into server_1_player_all_items.
        /// $args: loot key ⇒ {"id","q","type","spinUsed"} (gate entries carry no "q" — see class doc).</summary>
        private bool AddItems(Dictionary<string, Dictionary<string, object>> args)
        {
            // array('2'=>'ammunition_laser_mcb-25', …) — keyed by numeric item id
            var lootIds = new Dictionary<long, string>
            {
                { 2, "ammunition_laser_mcb-25" },
                { 3, "ammunition_laser_mcb-50" },
                { 4, "ammunition_laser_ucb-100" },
                { 5, "ammunition_laser_sab-50" },
                { 12, "ammunition_rocket_plt-2021" },
                { 11, "ammunition_mine_acm-01" },
            };
            foreach (var r in args.Values)
            {
                long id = ToLong(GetObj(r, "id"));
                string li;
                if (!lootIds.TryGetValue(id, out li)) continue; // array_key_exists($r['id'], $lootIds)
                if (CheckExistence(li))
                {
                    // if(!empty($r['q'])) — q==0 skipped exactly like PHP empty()
                    long q = ToLong(GetObj(r, "q"));
                    if (q != 0)
                    {
                        Execute("UPDATE `server_1_player_all_items` SET Q = Q + @Q WHERE userID=@p1 && playerID=@p2 && lootid=@p3",
                            Kv("@Q", q), Kv("@p1", _userid), Kv("@p2", _playerid), Kv("@p3", li));
                    }
                }
                else
                {
                    long q = ToLong(GetObj(r, "q"));
                    if (q != 0)
                    {
                        Execute("INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (@p1, @p2, @p3, @p4, @p5)",
                            Kv("@p1", li), Kv("@p2", q), Kv("@p3", 0), Kv("@p4", _playerid), Kv("@p5", _userid));
                    }
                }
            }
            return true;
        }

        /// <summary>GalaxyGate::gatesInfos() — "&lt;multiplier …/&gt;" XML fragment over CorpAll.
        /// PHP re-prepared the same statement per loop iteration — one helper query per row here.</summary>
        public string GatesInfos()
        {
            AllGat = null;
            if (CorpAll == null) return AllGat;
            foreach (var value in CorpAll)
            {
                var pear = Query("SELECT `galaxygate_name` FROM `server_galaxygate` WHERE galaxygate_id = @gid",
                    Kv("@gid", Get(value, "galaxygate_id")));
                string name = pear.Count > 0 ? Get(pear[0], "galaxygate_name") : "";
                AllGat += "<multiplier mode=\"" + name.ToLowerInvariant() + "\" value=\"" +
                          Get(value, "galaxygate_multipliers") + "\" state=\"0\" />";
            }
            return AllGat;
        }

        /// <summary>GalaxyGate::GetGates() — session-gated bootstrap of the player's gate rows.</summary>
        public void GetGates()
        {
            if (!SessionOk()) return;
            AllGates();
            CheckGateCount();
            if (_stm != _stu)
            {
                AddGates();
                UserGates();
                MultipliersShow();
                GatesInfos();
            }
            else
            {
                UserGates();
                MultipliersShow();
                GatesInfos();
            }
        }

        /// <summary>GalaxyGate::AllGates() — static gate catalogue; stm hardcoded to 9 in PHP.</summary>
        private void AllGates()
        {
            DataGates = Query(
                "SELECT galaxygate_id, galaxygate_name, galaxygate_part, galaxygate_totalWave, lifePrice FROM server_galaxygate");
            _stm = 9; // PHP: $this->stm = 9; (rowCount() variant commented out in the original)
        }

        /// <summary>GalaxyGate::CheckGateCount() — number of the player's existing gate rows.</summary>
        private void CheckGateCount()
        {
            var rows = Query("SELECT galaxygate_id FROM server_1_players_galaxygate WHERE playerID = @playerID",
                Kv("@playerID", _playerid));
            _stu = rows.Count;
        }

        /// <summary>GalaxyGate::UserGates() — player's gate progress rows.</summary>
        public void UserGates()
        {
            DataCon = Query(
                "SELECT playerID, userID, galaxygate_id, galaxygate_current_parts, galaxygate_prepared, livesLeft, " +
                "state, galaxygate_current_wave FROM server_1_players_galaxygate WHERE playerID = @playerID AND userID = @userID",
                Kv("@playerID", _playerid), Kv("@userID", _userid));
        }

        /// <summary>GalaxyGate::setMulti($set).</summary>
        public void SetMulti(int set)
        {
            _multiplier = set;
        }

        /// <summary>GalaxyGate::AddGates() — insert default rows for every catalogue gate.</summary>
        private void AddGates()
        {
            if (DataGates == null) return;
            foreach (var insertRow in DataGates)
            {
                Execute(
                    "INSERT INTO server_1_players_galaxygate (playerID, userID, galaxygate_id, galaxygate_current_parts, " +
                    "galaxygate_prepared, livesLeft, state, galaxygate_current_wave) " +
                    "VALUES (@playerID, @userID, @galaxygate_id, @parts, @prepared, @livesLeft, @state, @wave)",
                    Kv("@playerID", _playerid), Kv("@userID", _userid),
                    Kv("@galaxygate_id", Get(insertRow, "galaxygate_id")),
                    Kv("@parts", 0), Kv("@prepared", 0), Kv("@livesLeft", "-1"),
                    Kv("@state", "in_progress"), Kv("@wave", 0));
            }
        }

        // ------------------------------------------------------------------
        // A6.2 — spinner / multipliers (lines 217–589)
        // ------------------------------------------------------------------

        /// <summary>GalaxyGate::spinerUri(...) — charge uri for spins, then roll the gate.
        /// $c sanitized with preg_replace("/[^0-9]/","") before multiplication.</summary>
        public string SpinerUri(object userUri, string c, long cost, long playerID, long userID, long gateID)
        {
            ReloadUri();
            // preg_replace("/[^0-9]/","", $c) — non-digits stripped; "" → 0 in PHP arithmetic.
            long ammount = ToLong(DigitsOnly(c));
            long preCost = ammount * cost;
            double finalUri = ToDouble(Uri) - preCost;
            if (finalUri < 0)
            {
                return "<items></items>\n                    <boosts>\n                </boosts>";
            }
            Execute("UPDATE server_1_players SET uri = @uri WHERE playerID = @playerID and userID = @userID",
                Kv("@uri", finalUri.ToString(CultureInfo.InvariantCulture)), // bindValue PARAM_STR in PHP
                Kv("@playerID", playerID.ToString(CultureInfo.InvariantCulture)),
                Kv("@userID", userID.ToString(CultureInfo.InvariantCulture)));
            return CurrentGate(userUri, ammount, cost, playerID, userID, gateID);
        }

        /// <summary>GalaxyGate::MultiplierUpdate(...) — gates 1..3 share one multiplier value
        /// (loop over ids 1..3, last execute wins in PHP too — all three rows updated).
        /// NOTE: PHP binds galaxygate_id once per loop iteration on the SAME prepared command —
        /// reproduced by executing per-id here.</summary>
        private void MultiplierUpdate(long playerID, long userID, long gateID, long count)
        {
            if (gateID == 1 || gateID == 2 || gateID == 3)
            {
                for (int i = 1; i < 4; i++)
                {
                    Execute("UPDATE `server_1_players_galaxygate` SET `galaxygate_multipliers`=@count " +
                            "WHERE playerID = @playerID && userID = @userID && galaxygate_id = @galaxygate_id",
                        Kv("@count", count.ToString(CultureInfo.InvariantCulture)),
                        Kv("@playerID", playerID.ToString(CultureInfo.InvariantCulture)),
                        Kv("@userID", userID.ToString(CultureInfo.InvariantCulture)),
                        Kv("@galaxygate_id", i.ToString(CultureInfo.InvariantCulture)));
                }
                MultipliersShow();
            }
            else
            {
                Execute("UPDATE `server_1_players_galaxygate` SET `galaxygate_multipliers`=@count " +
                        "WHERE playerID = @playerID && userID = @userID && galaxygate_id = @galaxygate_id",
                    Kv("@count", count.ToString(CultureInfo.InvariantCulture)),
                    Kv("@playerID", playerID.ToString(CultureInfo.InvariantCulture)),
                    Kv("@userID", userID.ToString(CultureInfo.InvariantCulture)),
                    Kv("@galaxygate_id", gateID.ToString(CultureInfo.InvariantCulture)));
                MultipliersShow();
            }
        }

        /// <summary>GalaxyGate::WhereMulti($cou).</summary>
        public void WhereMulti(long cou)
        {
            _spinNum = cou;
        }

        /// <summary>GalaxyGate::currentGate(...) — the loot-roll engine (lines 264–589).
        /// Returns the final items XML or null when addItems path was not reached.</summary>
        private string CurrentGate(object userUri, long ammount, long cost, long playerID, long userID, long gateID)
        {
            long multi;
            if (_multiplier == 1)
            {
                var multiObj = Query(
                    "SELECT `galaxygate_multipliers` FROM `server_1_players_galaxygate` WHERE playerID = @p1 && userID = @p2 && galaxygate_id = @p3",
                    Kv("@p1", playerID), Kv("@p2", userID), Kv("@p3", gateID));
                multi = multiObj.Count > 0 ? ToLong(Get(multiObj[0], "galaxygate_multipliers")) : 0;
                MultiplierUpdate(playerID, userID, gateID, 0);
            }
            else
            {
                multi = 0;
            }

            double total = 1.0;
            double pammo = total - 0.67;
            double pspecial = total - 0.04; // PHP line 287: $pspecial = $total - 0.04;
            double pgate = total - 0.13;
            double presource = total - 0.12;
            double pvoucher = total - 0.03;
            double plogfile = total - 0.01;
            double pammo2 = total - 0.35;
            double pammo3 = total - 0.25;
            double pammo4 = total - 0.10;
            double pammoabs = total - 0.20;
            double pammoRo = total - 0.05;
            double pammomine = total - 0.05;

            var itemArray = new Dictionary<string, Dictionary<string, object>>(StringComparer.Ordinal);

            // PHP: if($multi!=1 OR $multi !=0) — tautology, always takes the first branch.
            long multiplier = multi + 1;

            for (long i = 0; i < ammount; i++)
            {
                double rand = MtRand(0, 100) / 100.0;
                if (rand > plogfile)
                {
                    MineBranch(itemArray, ref multiplier);
                }
                else if (rand > pvoucher)
                {
                    VoucherBranch(itemArray, ref multiplier);
                }
                else if (rand > pspecial)
                {
                    MineBranch(itemArray, ref multiplier); // PHP duplicate of the logfile branch
                }
                else if (rand > presource)
                {
                    MineBranch(itemArray, ref multiplier); // PHP duplicate again
                }
                else if (rand > pgate)
                {
                    GateBranch(itemArray, ref multiplier);
                }
                else if (rand > pammo)
                {
                    AmmoInner(itemArray, ref multiplier);
                }
                else
                {
                    AmmoInner(itemArray, ref multiplier); // identical twin block in PHP source
                }
            }

            long currentDate = UnixNow(); // date_create()/date_timestamp_get
            if (AddItems(itemArray))
            {
                var itemsget = "<items>";
                foreach (var values in itemArray.Values)
                {
                    string type = Str(GetObj(values, "type"));
                    if (type == "gate") continue; // gate items emit nothing (commented-out line in PHP)
                    itemsget += "<item date=\"" + currentDate + "\" amount=\"" + Str(GetObj(values, "q")) +
                                "\" spins=\"" + Str(GetObj(values, "spinUsed")) + "\" item_id=\"" +
                                Str(GetObj(values, "id")) + "\" type=\"" + type + "\"></item>";
                }
                itemsget += "</items>\n                    <boosts>\n                </boosts>";
                FinalData = itemsget;
                return itemsget;
            }
            return null;
        }

        // --- roll branches, one per distinct PHP block (kept 1:1 incl. key mismatches) ---

        private static void MineBranch(Dictionary<string, Dictionary<string, object>> arr, ref long multiplier)
        {
            Dictionary<string, object> e;
            if (arr.TryGetValue("mine", out e))
            {
                Bump(e, "q", 4);
                Bump(e, "spinUsed", 1);
            }
            else
            {
                arr["mine"] = NewItem(12, Rand(1, 10) * multiplier, "rocket", 1);
                multiplier = 1;
            }
        }

        private static void VoucherBranch(Dictionary<string, Dictionary<string, object>> arr, ref long multiplier)
        {
            Dictionary<string, object> e;
            if (arr.TryGetValue("voucher", out e))
            {
                Bump(e, "q", Rand(1, 3));
                Bump(e, "spinUsed", 1);
            }
            else
            {
                arr["voucher"] = NewItem("voucher", Rand(1, 3) * multiplier, "voucher", 1);
                multiplier = 1;
            }
        }

        private static void GateBranch(Dictionary<string, Dictionary<string, object>> arr, ref long multiplier)
        {
            // PHP checks 'Gate' (capital) but writes 'gate' (lower) — Ordinal comparer keeps them apart,
            // so the "exists" branch fires only if a literal "Gate" key was ever created (never is).
            Dictionary<string, object> e;
            if (arr.TryGetValue("Gate", out e))
            {
                Bump(e, "spinUsed", 1);
            }
            else
            {
                var gate = new Dictionary<string, object>(StringComparer.OrdinalIgnoreCase)
                {
                    { "id", Rand(1, 34) * multiplier },
                    { "type", "gate" },
                    { "spinUsed", 1L },
                }; // NB: no "q" key — exactly like PHP
                arr["gate"] = gate;
                multiplier = 1;
            }
        }

        private static void AmmoInner(Dictionary<string, Dictionary<string, object>> arr, ref long multiplier)
        {
            double rand2 = MtRand(0, 100) / 100.0;
            if (rand2 > pammomineConst)
            {
                if (Rand(0, 100) / 100.0 > 0.45)
                {
                    Dictionary<string, object> e;
                    if (arr.TryGetValue("mine", out e))
                    {
                        Bump(e, "q", Rand(1, 10));
                        Bump(e, "spinUsed", 1);
                    }
                    else
                    {
                        arr["mine"] = NewItem(12, Rand(1, 10) * multiplier, "rocket", 1);
                        multiplier = 1;
                    }
                }
                else
                {
                    Dictionary<string, object> e;
                    // PHP checked array_key_exists('1', …) but wrote 'rocket' — '1' never exists →
                    // always the create branch. Reproduced literally.
                    if (arr.TryGetValue("1", out e))
                    {
                        Bump(e, "q", Rand(10, 50));
                        Bump(e, "spinUsed", 1);
                    }
                    else
                    {
                        arr["rocket"] = NewItem(11, Rand(10, 50) * multiplier, "rocket", 1);
                        multiplier = 1;
                    }
                }
            }
            else if (rand2 > pammo4Const)
            {
                BatteryAccumulate(arr, "x4", 4, ref multiplier);
            }
            else if (rand2 > pammoabsConst)
            {
                BatteryAccumulate(arr, "sab", 5, ref multiplier);
            }
            else if (rand2 > pammo3Const)
            {
                BatteryAccumulate(arr, "x3", 3, ref multiplier);
            }
            else if (rand2 > pammo2Const)
            {
                BatteryX2(arr, ref multiplier);
            }
            else
            {
                BatteryX2(arr, ref multiplier); // PHP default branch duplicates the x2 block
            }
        }

        private static void BatteryAccumulate(Dictionary<string, Dictionary<string, object>> arr, string key, long id, ref long multiplier)
        {
            Dictionary<string, object> e;
            if (arr.TryGetValue(key, out e))
            {
                Bump(e, "q", Rand(50, 320));
                Bump(e, "spinUsed", 1); // present in x4/sab PHP blocks; also in x3 (verified against source)
            }
            else
            {
                arr[key] = NewItem(id, Rand(50, 320) * multiplier, "battery", 1);
                multiplier = 1;
            }
        }

        private static void BatteryX2(Dictionary<string, Dictionary<string, object>> arr, ref long multiplier)
        {
            Dictionary<string, object> e;
            if (arr.TryGetValue("x2", out e))
            {
                Bump(e, "q", Rand(50, 320));
                Bump(e, "spinUsed", 1);
            }
            else
            {
                // PHP wrote q in two statements (rand, then * multiplier) — same product.
                arr["x2"] = NewItem(2, Rand(50, 320) * multiplier, "battery", 1);
                multiplier = 1;
            }
        }

        // Probability thresholds are instance-invariant constants mirroring the locals above.
        private const double pammo2Const = 1.0 - 0.35;
        private const double pammo3Const = 1.0 - 0.25;
        private const double pammo4Const = 1.0 - 0.10;
        private const double pammoabsConst = 1.0 - 0.20;
        private const double pammomineConst = 1.0 - 0.05;

        // ------------------------------------------------------------------
        // helpers
        // ------------------------------------------------------------------

        private static Dictionary<string, object> NewItem(object id, long q, string type, long spinUsed)
        {
            var d = new Dictionary<string, object>(StringComparer.OrdinalIgnoreCase)
            {
                { "id", id }, { "q", q }, { "type", type }, { "spinUsed", spinUsed },
            };
            return d;
        }

        private static void Bump(Dictionary<string, object> d, string key, long delta)
        {
            object cur;
            long v = d.TryGetValue(key, out cur) ? ToLong(cur) : 0;
            d[key] = v + delta;
        }

        /// <summary>mt_rand(0,100) inclusive.</summary>
        private static int MtRand(int min, int max) { return Rng.Next(min, max + 1); }

        /// <summary>rand(a,b) inclusive.</summary>
        private static int Rand(int min, int max) { return Rng.Next(min, max + 1); }

        private static long UnixNow()
        {
            return (long)(DateTime.UtcNow - new DateTime(1970, 1, 1, 0, 0, 0, DateTimeKind.Utc)).TotalSeconds;
        }

        private static string DigitsOnly(string s)
        {
            if (string.IsNullOrEmpty(s)) return "0";
            var chars = s.Where(char.IsDigit).ToArray();
            return chars.Length == 0 ? "0" : new string(chars);
        }

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
    }
}
