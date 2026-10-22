using System;
using System.Collections.Generic;
using System.Globalization;
using System.Text;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.base.php (class `base`).
    /// Hangar/dock helpers: company, drones, balances, ship swap, ranks,
    /// upgrade price table & upgradeItem() RNG flow.
    /// </summary>
    public class Base
    {
        private long _uid;
        private long _pid;
        private long _hid;
        private List<string> _ships = new List<string>();

        public int Numbs { get; private set; }
        public string MyShip { get; private set; }
        public string ShipShow { get; private set; }
        public object Shipnum { get; private set; }
        public object Shipn { get; private set; }
        public long RankNum { get; private set; }

        private string _fac = "";

        private long _uridium;
        private long _credits;

        /// <summary>base::setId($uid,$pid) — refreshes balances via money().</summary>
        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
            Money();
        }

        /// <summary>base::currentCompany($com).</summary>
        public static string CurrentCompany(int com)
        {
            if (com == 1) return "mmo";
            if (com == 2) return "eic";
            return "vru";
        }

        /// <summary>base::currentDrones().</summary>
        public int CurrentDrones()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT COUNT(*) FROM server_1_player_drones WHERE userID=@uid AND playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                return (int)PlayerLog.ToLong(cmd.ExecuteScalar());
            }
        }

        /// <summary>base::money() (private in PHP, exposed for parity with voucher/log).</summary>
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
                        _uridium = PlayerLog.ToLong(rdr["uri"]);
                        _credits = PlayerLog.ToLong(rdr["credits"]);
                    }
                }
            }
        }

        /// <summary>base::HangarId().</summary>
        public object HangarId()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT hangarID FROM server_1_hangar WHERE userID=@uid AND playerID=@pid LIMIT 1", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                object o = cmd.ExecuteScalar();
                if (o == null || o == DBNull.Value) return false;
                _hid = PlayerLog.ToLong(o);
                return _hid;
            }
        }

        /// <summary>base::Wipe() + wipeDrone() — clears both ship configs and drone slots.</summary>
        private void Wipe()
        {
            using (var con = DB.GetInstance())
            {
                for (int i = 1; i <= 2; i++)
                {
                    using (var cmd = new MySqlCommand(
                        @"UPDATE server_1_hangar_config_ship AS s
                          SET s.lasers = '', s.generators = '', s.heavy_guns = '', s.extras = ''
                          WHERE s.playerID=@pid AND s.userID=@uid AND s.configNum=@cn AND s.hangarID=@hid", con))
                    {
                        cmd.Parameters.AddWithValue("@pid", _pid);
                        cmd.Parameters.AddWithValue("@uid", _uid);
                        cmd.Parameters.AddWithValue("@cn", i);
                        cmd.Parameters.AddWithValue("@hid", _hid);
                        cmd.ExecuteNonQuery();
                    }
                    string drone = (i == 1) ? "EQ" : "EQ2";
                    using (var cmd = new MySqlCommand(
                        "UPDATE server_1_hangar_config_drones SET " + drone + " = '', design = '' WHERE playerID=@pid AND userID=@uid AND hangarID=@hid", con))
                    {
                        cmd.Parameters.AddWithValue("@pid", _pid);
                        cmd.Parameters.AddWithValue("@uid", _uid);
                        cmd.Parameters.AddWithValue("@hid", _hid);
                        cmd.ExecuteNonQuery();
                    }
                }
            }
        }

        /// <summary>base::postShip() — renders the ship-dump forms for docked extras.</summary>
        public string PostShip()
        {
            if (_ships == null || _ships.Count == 0) return null;
            var baseSb = new StringBuilder();
            int i = 1;
            foreach (var value in _ships)
            {
                int s = i - 1;
                string cls = (s == 0) ? "shipDumpViewActual shipyard" : "shipDumpViewNext shipyard";
                baseSb.Append("<form class=\"shipDumpForm\" id=\"shipDumpForm_" + i + "\" acton=\"indexInternal.es.php\" method=\"post\"><input type=\"hidden\" name=\"reloadToken\" value=\"\">\n")
                      .Append("                            <input type=\"hidden\" name=\"action\" value=\"internalDock\">\n")
                      .Append("                            <input type=\"hidden\" name=\"subAction\" value=\"addShipToHangar\">\n")
                      .Append("                            <input type=\"hidden\" id=\"hangarId\" name=\"hangarId\" value=\"" + _hid + "\">\n")
                      .Append("                            <input type=\"hidden\" id=\"inventoryId\" name=\"inventoryId\" value=\"" + value + "\">\n")
                      .Append("                                    <div id=\"shipDump_" + i + "\" class=\"" + cls + "\">\n")
                      .Append("                                <div id=\"ship_" + s + "\" class=\"shipyard_image ship_" + value + "\" title=\"\"></div>\n")
                      .Append("                            </div>\n")
                      .Append("                        </form>");
                i++;
            }
            return baseSb.ToString();
        }

        /// <summary>base::currentShip().</summary>
        private void CurrentShip()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT ship_selected_model FROM server_1_player_hangar_general_ship WHERE playerID=@pid LIMIT 1", con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                object o = cmd.ExecuteScalar();
                MyShip = o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }
        }

        private string ShipById(string id)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT Name FROM ships WHERE Id=@id", con))
            {
                cmd.Parameters.AddWithValue("@id", id);
                object o = cmd.ExecuteScalar();
                return o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }
        }

        /// <summary>base::modelID($shipExo,$shipLoot).</summary>
        private void ModelId(string[] shipExo, string shipLoot)
        {
            using (var con = DB.GetInstance())
            {
                if (shipExo.Length != 2)
                {
                    long id; string name;
                    using (var cmd = new MySqlCommand("SELECT Id, ShipId, Name FROM ships_designs WHERE type=@type", con))
                    {
                        cmd.Parameters.AddWithValue("@type", MyShip);
                        using (var rdr = cmd.ExecuteReader())
                        {
                            if (!rdr.Read()) return;
                            id = PlayerLog.ToLong(rdr["Id"]);
                            name = Convert.ToString(rdr["Name"]);
                        }
                    }
                    ApplyModel(id, name, fromDesigns: true);
                }
                else
                {
                    long id; string name;
                    using (var cmd = new MySqlCommand("SELECT Id, Name FROM ships WHERE type=@type", con))
                    {
                        cmd.Parameters.AddWithValue("@type", shipLoot);
                        using (var rdr = cmd.ExecuteReader())
                        {
                            if (!rdr.Read()) return;
                            id = PlayerLog.ToLong(rdr["Id"]);
                            name = Convert.ToString(rdr["Name"]);
                        }
                    }
                    ApplyModel(id, name, fromDesigns: false);
                }
            }
        }

        private void ApplyModel(long id, string name, bool fromDesigns)
        {
            if (id == 49)
            {
                ShipShow = "aegis-" + _fac; Shipnum = 12; Shipn = "49-" + _fac;
            }
            else if (id == 69)
            {
                ShipShow = "citadel-" + _fac; Shipnum = 11; Shipn = "69-" + _fac;
            }
            else if (id == 70)
            {
                ShipShow = "spearhead-" + _fac; Shipnum = 13; Shipn = "70-" + _fac;
            }
            else
            {
                ShipShow = fromDesigns ? ShipById(id.ToString(CultureInfo.InvariantCulture)) : name;
                Shipnum = id; Shipn = id;
            }
        }

        /// <summary>base::GetRank($uid,$pid) — players row joined with rank.</summary>
        public Dictionary<string, string> GetRank(long uid, long pid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                @"SELECT * FROM server_1_players INNER JOIN rank ON server_1_players.rank=rank.id
                  WHERE server_1_players.userID=@uid AND server_1_players.playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@uid", uid);
                cmd.Parameters.AddWithValue("@pid", pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    if (rdr.Read()) return Unity.RowToDict(rdr);
                }
            }
            return null;
        }

        /// <summary>base::GetRankByRNK($num).</summary>
        public string GetRankByRnk(long num)
        {
            if (num == 21) return "General";
            if (num == 0) return "Basic Space Pilot";
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT name FROM rank WHERE id=@num", con))
            {
                cmd.Parameters.AddWithValue("@num", num);
                object o = cmd.ExecuteScalar();
                return o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }
        }

        /// <summary>base::GetDateReg($uid).</summary>
        public string GetDateReg(long uid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT regDate FROM users WHERE ID=@uid", con))
            {
                cmd.Parameters.AddWithValue("@uid", uid);
                object o = cmd.ExecuteScalar();
                return o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }
        }

        /// <summary>base::getNameBypid($pid).</summary>
        public string GetNameByPid(long? pid = null)
        {
            if (pid == null || pid.Value == 0) return "-";
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                @"SELECT server_1_players.playerID, users.Name FROM server_1_players
                  INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", pid.Value);
                object o = cmd.ExecuteScalar();
                return o == null || o == DBNull.Value ? "" : Convert.ToString(o);
            }
        }

        /// <summary>base::getShips() — needs $_SESSION['fact'] passed in (PHP read it directly).</summary>
        public void GetShips(int fact)
        {
            _fac = CurrentCompany(fact);
            CurrentShip();

            var array = new List<string>();
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "SELECT lootid FROM server_1_player_all_items WHERE lootid LIKE 'ship%' AND userID=@uid AND playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@uid", _uid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    while (rdr.Read())
                    {
                        string lootid = Convert.ToString(rdr["lootid"]);
                        string[] pie = lootid.Split('_');
                        string prefix = pie.Length >= 2 ? pie[0] + "_" + pie[1] : lootid;
                        if (!array.Contains(prefix) && pie.Length <= 2)
                            array.Add(prefix);
                    }
                }
            }

            string[] shipExo = (MyShip ?? "").Split('_');
            string shipLoot = shipExo.Length >= 2 ? shipExo[0] + "_" + shipExo[1] : MyShip;
            if (array.Contains(shipLoot))
                array.Remove(shipLoot);

            ModelId(shipExo, shipLoot);
            Numbs = array.Count;
            _ships = array;
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

        private long ShipId(string lootid)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT Id FROM ships WHERE type = @loot", con))
            {
                cmd.Parameters.AddWithValue("@loot", lootid);
                object o = cmd.ExecuteScalar();
                if (o == null || o == DBNull.Value) return 1;
                return PlayerLog.ToLong(o);
            }
        }

        /// <summary>base::changeShip($hangarId,$inventoryId).</summary>
        public bool ChangeShip(long hangarId, string inventoryId)
        {
            if (!CheckExistence(inventoryId, _pid))
                return false;

            long modelnumber = ShipId(inventoryId);
            HangarId(); // PHP relied on $this->hid being set earlier; refresh to be safe
            Wipe();
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "UPDATE `server_1_player_hangar_general_ship` SET ship_selected_model = @model, ship_internal_id = @num WHERE hangarID=@hid AND playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@model", inventoryId);
                cmd.Parameters.AddWithValue("@num", modelnumber);
                cmd.Parameters.AddWithValue("@hid", _hid);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.ExecuteNonQuery();
            }
            return true;
        }

        /// <summary>base::getItemUpgrade() — items grouped by server_shop_items.type.</summary>
        public Dictionary<string, List<Dictionary<string, string>>> GetItemUpgrade()
        {
            var sorted = new Dictionary<string, List<Dictionary<string, string>>>(StringComparer.OrdinalIgnoreCase);
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                @"SELECT * FROM server_1_player_all_items
                  INNER JOIN server_shop_items ON server_shop_items.lootId=server_1_player_all_items.lootid
                  WHERE server_1_player_all_items.playerID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                using (var rdr = cmd.ExecuteReader())
                {
                    while (rdr.Read())
                    {
                        var val = Unity.RowToDict(rdr);
                        string type = val.ContainsKey("type") ? val["type"] : "";
                        if (!sorted.ContainsKey(type)) sorted[type] = new List<Dictionary<string, string>>();
                        sorted[type].Add(val);
                    }
                }
            }
            return sorted;
        }

        /// <summary>base::upListPercent($lv).</summary>
        public static string UpListPercent(int lv)
        {
            string[] array = { "0.2", "0.4", "0.8", "1.2", "1.6", "2.0", "2.4", "2.8", "3.2", "3.6", "4.0", "4.4", "4.8", "5.2", "5.6", "6.0" };
            return array[lv];
        }

        /// <summary>
        /// base::checkBan() — NOTE: PHP queried users.ID with $this->pid (playerID).
        /// That is almost certainly a bug (should be userID), but we keep behavioural
        /// parity and flag it here; callers wanting user-level ban must use Users.IsBanned(uid).
        /// </summary>
        public bool CheckBan()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT banned FROM users WHERE ID=@pid", con))
            {
                cmd.Parameters.AddWithValue("@pid", _pid);
                object o = cmd.ExecuteScalar();
                return PlayerLog.ToLong(o) != 0;
            }
        }

        /// <summary>base::priceCalUpgrade($cu,$pricelist,$per).</summary>
        private bool PriceCalUpgrade(string cu, UpgradePrices priceList, int per)
        {
            Money();
            if (cu == "C.")
            {
                long price = priceList.Credits(per);
                if (_credits - price < 0) return false;
                return UpdateBalance("credits", price);
            }
            else
            {
                long price = priceList.Uridium(per);
                if (_uridium - price < 0) return false;
                return UpdateBalance("uri", price);
            }
        }

        private bool UpdateBalance(string column, long price)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(
                "UPDATE server_1_players SET " + column + " = (" + column + "-@price) WHERE playerID=@pid AND userID=@uid", con))
            {
                cmd.Parameters.AddWithValue("@price", price);
                cmd.Parameters.AddWithValue("@pid", _pid);
                cmd.Parameters.AddWithValue("@uid", _uid);
                return cmd.ExecuteNonQuery() > 0;
            }
        }

        private static readonly Random Rng = new Random();

        /// <summary>
        /// base::upgradeItem($args) — $args = ['itemUpgradePercent' => '15%', 'itemID' => '123'].
        /// Success/failure lands in $_SESSION['Upgradeings'][$itemID]['success']; we write the
        /// same shape into SessionManager's Upgradeings dictionary. Returns FALSE when the
        /// balance check fails, TRUE otherwise (win or lose).
        /// </summary>
        public bool UpgradeItem(IDictionary<string, string> args, System.Web.SessionState.HttpSessionState session)
        {
            var priceList = UpgradePrices.Default;
            int percent;
            int.TryParse((args.ContainsKey("itemUpgradePercent") ? args["itemUpgradePercent"] : "").Trim('%'), out percent);

            if (PriceCalUpgrade(args.ContainsKey("itemID") ? args["itemID"] : "", priceList, percent))
            {
                int rdm = Rng.Next(1, 101); // rand(1,100)
                string itemId = args.ContainsKey("itemID") ? args["itemID"] : "";
                if (rdm <= percent)
                {
                    SessionManager.SetUpgradeSuccess(session, itemId, 1);
                    using (var con = DB.GetInstance())
                    using (var cmd = new MySqlCommand("UPDATE `server_1_player_all_items` SET LV = LV + 1 WHERE playerID=@pid AND id=@id", con))
                    {
                        cmd.Parameters.AddWithValue("@pid", _pid);
                        cmd.Parameters.AddWithValue("@id", itemId);
                        cmd.ExecuteNonQuery();
                    }
                    return true;
                }
                SessionManager.SetUpgradeSuccess(session, itemId, 0);
                return true;
            }
            return false;
        }
    }

    /// <summary>The hard-coded JSON price table from base::upgradeItem().</summary>
    public class UpgradePrices
    {
        private static readonly Dictionary<int, long> CreditsTable = new Dictionary<int, long>
        {
            {5,125000},{10,225000},{15,325000},{20,425000},{25,525000},{30,625000},{35,725000},{40,825000},{45,925000},{50,1025000},
            {55,1125000},{60,1225000},{65,1325000},{70,1425000},{75,1525000},{80,1625000},{85,1725000},{90,1825000},{95,1925000},{100,2025000}
        };
        private static readonly Dictionary<int, long> UridiumTable = new Dictionary<int, long>
        {
            {5,200},{10,260},{15,335},{20,425},{25,530},{30,650},{35,785},{40,935},{45,1100},{50,1280},
            {55,1475},{60,1685},{65,1910},{70,2150},{75,2405},{80,2675},{85,2960},{90,3260},{95,3575},{100,3905}
        };

        public static readonly UpgradePrices Default = new UpgradePrices();

        public long Credits(int per)
        {
            long v; return CreditsTable.TryGetValue(per, out v) ? v : 0;
        }

        public long Uridium(int per)
        {
            long v; return UridiumTable.TryGetValue(per, out v) ? v : 0;
        }
    }
}
