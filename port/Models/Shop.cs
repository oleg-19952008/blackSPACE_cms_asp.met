using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS Class.shop.php (class shop, 779 стр.) — покупка
    /// юнитов/оружия/боеприпасов/дронов/петов в techShop.
    /// Замечания по паритету:
    ///  - Все JSON-ответы собираются конкатенацией, как в PHP (в т.ч. баги:
    ///    $name/$id в updateAmmo не определены → пустые строки; $id в блоке
    ///    priceCal не определён → ""; $what в else-ветке drone() не определена).
    ///  - round() в PHP возвращает float; здесь Math.Round(..., MidpointRounding.AwayFromZero)
    ///    с приведением к long для целых сумм (денег хватает до double-точности).
    ///  - time()/strtotime(premium): premium — дата 'Y-m-d H:i:s' из users-строки.
    /// </summary>
    public class Shop
    {
        private const string Copyright = "BY Seven & NavigatoR - MEDIANET IVS"; // no-op guard оригинала
        private long _uid;
        private long _pid;
        public string Uridium = "";   // public $uridium (null до Money())
        public string Credits = "";   // public $credits
        private string _hid = "";     // private $hid
        public string TotalAmount = "";// public $totalAmmount
        public string Premium = "";   // public $premium (из $_SESSION['premium'])
        private Dictionary<string, object> _itemInformation; // private $itemInformation
        private List<Dictionary<string, string>> _cuId;      // private $cuId (result[0]->id используется при add==0)
        private string _newID = "";

        /* Constructor does everything that needs to be done at every load */
        public Shop()
        {
            GC.KeepAlive(Copyright); // if ($this->copyright != "...") die(...) — всегда ложно
        }

        /// <summary>public setId($uid, $pid, $premium=null) — premium приходит из $_SESSION['premium'] (см. internal).</summary>
        public void SetId(long uid, long pid, string premium = null)
        {
            _uid = uid;
            _pid = pid;
            Premium = premium ?? ""; // PHP: $_SESSION['premium'] (может быть null)
            Money();
        }

        /// <summary>private checkExistence($lootid) — есть ли предмет у игрока; кэш cuId.</summary>
        private bool CheckExistence(string lootid)
        {
            var result = Query("SELECT id FROM server_1_player_all_items WHERE userID = @p1 && playerID = @p2 && lootid = @p3",
                               Kv("@p1", _uid), Kv("@p2", _pid), Kv("@p3", lootid));
            if (result.Count > 0)
            {
                _cuId = result;
                return true;
            }
            return false;
        }

        /// <summary>public HangarId() — первый hangarID игрока в _hid.</summary>
        public void HangarId()
        {
            var result = Query("SELECT hangarID FROM server_1_hangar WHERE userID=@userID && playerID=@playerID LIMIT 1",
                               Kv("@userID", _uid), Kv("@playerID", _pid));
            if (result.Count > 0) _hid = GetStr(result[0], "hangarID");
        }

        /* mXac : Max Ammo Calculator — сколько боеприпасов максимум можно купить */
        public double MXac(string lootid, string w, string x)
        {
            CountAllAmmoLaser(w); // $tAmmo — вычисляется и перезаписывается ниже (как в PHP)
            HangarId();
            var result = Query(@"SELECT * FROM server_1_player_all_items
                                 INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId
                                 WHERE server_1_player_all_items.userID=@userID && server_1_player_all_items.playerID=@playerID
                                   && server_1_player_all_items.lootid=@lootid LIMIT 1",
                               Kv("@userID", _uid), Kv("@playerID", _pid), Kv("@lootid", lootid));
            var ammoArg = GetAmmoPrice(lootid);
            double buy = ParseDouble(AmmoField(ammoArg, "buy"));
            string ucd = AmmoField(ammoArg, "ucd");
            if (result.Count > 0)
            {
                if (lootid == "ammunition_laser_rsb-75")
                {
                    // В оригинале if/elseif перезаписываются безусловным uridium-делителем — сохранено.
                    return Math.Round(ParseDouble(Uridium) / buy, MidpointRounding.AwayFromZero);
                }
                else
                {
                    double tAmmo = CountAllAmmoLaser(w);
                    double cShip = ParseDouble(CurrentShip(x));
                    double totalAmmount = cShip - tAmmo;
                    TotalAmount = totalAmmount.ToString(CultureInfo.InvariantCulture);
                    double totalFU = ucd == "c" ? ParseDouble(Credits) / buy : ParseDouble(Uridium) / buy;
                    if (totalAmmount < 0) return 0;
                    return Math.Round(totalAmmount < totalFU ? totalFU : totalAmmount, MidpointRounding.AwayFromZero);
                }
            }
            else
            {
                if (lootid == "ammunition_laser_rsb-75")
                {
                    return Math.Round(ParseDouble(Uridium) / buy, MidpointRounding.AwayFromZero);
                }
                else
                {
                    double tAmmo = CountAllAmmoLaser(w);
                    double cShip = ParseDouble(CurrentShip(x));
                    double totalAmmount = cShip - tAmmo;
                    TotalAmount = totalAmmount.ToString(CultureInfo.InvariantCulture);
                    double reTo = ucd == "c" ? ParseDouble(Credits) / buy : ParseDouble(Uridium) / buy;
                    if (totalAmmount < 0) return 0;
                    return Math.Round(totalAmmount > reTo ? reTo : totalAmmount, MidpointRounding.AwayFromZero);
                }
            }
        }

        /// <summary>public spaceleft($w) — свободное место под боезапас на корабле.</summary>
        public double SpaceLeft(string w)
        {
            double space = ParseDouble(CurrentShip(w));
            double tAmmo = w == "Rockets" ? CountAllAmmoLaser("ammunition_rocket") : CountAllAmmoLaser("ammunition_laser_");
            if (tAmmo < 0) return 0;
            return space - tAmmo;
        }

        /// <summary>public currentShip($w) — колонка w текущего selected-корабля ('' если нет строки).</summary>
        public string CurrentShip(string w)
        {
            HangarId();
            var result = Query(@"SELECT * FROM server_1_player_hangar_general_ship
                                 INNER JOIN ships ON server_1_player_hangar_general_ship.ship_selected_model=ships.type
                                 WHERE server_1_player_hangar_general_ship.hangarID=@hangarID
                                   && server_1_player_hangar_general_ship.playerID=@playerID LIMIT 1",
                               Kv("@hangarID", _hid), Kv("@playerID", _pid));
            if (result.Count == 0) return ""; // PHP notice → null
            return GetStr(result[0], w);
        }

        /// <summary>private countAllAmmoLaser($lookup) — сумма Q предметов lootid LIKE %lookup% (кроме rsb-75).</summary>
        private double CountAllAmmoLaser(string lookup)
        {
            string term = "%" + lookup + "%";
            const string nr = "ammunition_laser_rsb-75";
            var result = Query("SELECT * FROM server_1_player_all_items WHERE lootid LIKE @sr && lootid!=@nr && playerID=@playerID",
                               Kv("@sr", term), Kv("@nr", nr), Kv("@playerID", _pid));
            double total = 0;
            foreach (var v in result) total += ParseDouble(GetStr(v, "Q"));
            return total;
        }

        /// <summary>private GetAmmoPrice($lootid) — строка товара из server_shop_items.</summary>
        private List<Dictionary<string, string>> GetAmmoPrice(string lootid)
        {
            return Query("SELECT * FROM server_shop_items WHERE lootId=@lootid LIMIT 1", Kv("@lootid", lootid));
        }

        private static string AmmoField(List<Dictionary<string, string>> rows, string col)
        {
            return rows != null && rows.Count > 0 ? GetStr(rows[0], col) : ""; // PHP $ammoArg[0][...] на пустом → notice→null
        }

        // ------------------------------------------------------------------
        // Покупки (A4.2/A4.3): все методы возвращают JSON-строку ответа.
        // ------------------------------------------------------------------

        /// <summary>public ship($id) — покупка корабля по ships.Id.</summary>
        public string Ship(string id)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.I.E.L.D. does not allow this.", id, "ship");
            var result = Query("SELECT Name, type FROM ships WHERE Id = @shipid", Kv("@shipid", id));
            if (result.Count == 0) return null; // PHP $result[0] на пустом → fatal; сохраняем null
            string type = GetStr(result[0], "type");
            if (CheckExistence(type))
                return ErrMessage("You already have this type of ship in your inventory.<br /> To be able to purchase another one of these ships, move the ship from your inventory to the hangar hall.", id, "ship");
            if (PriceCal(type, 1))
                return ItemReg(id, "ship", type, GetStr(result[0], "Name"), 1, 1, 0, 1);
            return ErrMessage("You have not money enough!", id, "ship");
        }

        /// <summary>public model($am, $id) — покупка модели корабля (lootid).</summary>
        public string Model(string am, string id)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            long a = ParseLong(DigitsOnly(am));
            var exploded = id.Split('_');
            string name = exploded.Length > 0 ? exploded[exploded.Length - 1] : "";
            if (PriceCal(id, a)) return ItemReg(id, "model", id, name, a, 1, 0, 1);
            return ErrMessage("You have not money enough!", id, "ship");
        }

        /// <summary>public dronePrice($type) — цена следующего дрона по числу уже купленных.</summary>
        public string DronePrice(string type)
        {
            var drones = new Dictionary<string, string[]>
            {
                { "iris", new[] { "15000", "24000", "42000", "60000", "84000", "96000", "126000", "200000" } },
                { "flax", new[] { "100000", "200000", "400000", "800000", "1600000", "3200000", "6400000", "12800000" } },
                { "apis", new[] { "1250000", "-0", "-0", "-0", "-0", "-0", "-0", "-0" } },
                { "zeus", new[] { "1500000", "-0", "-0", "-0", "-0", "-0", "-0", "-0" } },
            };
            string lootid = "drone_" + type;
            long i = Count("SELECT * FROM server_1_player_all_items WHERE lootid=@lootid && playerID=@playerID && userID=@userID",
                           Kv("@lootid", lootid), Kv("@playerID", _pid), Kv("@userID", _uid));
            if (i != 8)
            {
                var arr = drones.ContainsKey(type) ? drones[type] : null;
                if (arr == null || i < 0 || i >= arr.Length) return ""; // PHP undefined index → notice→null
                return arr[(int)i];
            }
            return "0";
        }

        /// <summary>public cPT() — активен ли премиум (time() &lt; strtotime($premium)).</summary>
        public bool CPT()
        {
            DateTime? t = PhpStrtotime(Premium);
            if (t == null) return false; // PHP: strtotime(null/false) === false → time() < false → false
            return UnixNow() < ((long)(t.Value - new DateTime(1970, 1, 1, 0, 0, 0, DateTimeKind.Utc)).TotalSeconds);
        }

        /// <summary>private priceCal($lootId, $c) — проверка+списание денег; TRUE если хватило.</summary>
        private bool PriceCal(string lootId, long c)
        {
            if (BlockIDs(lootId))
            {
                // В оригинале результат присваивается $message и НЕ возвращается (метод boolean) —
                // код мёртв, но проверка blockIDs остаётся: продолжаем как usual path.
                GC.KeepAlive(ErrMessage("S.H.E.I.L.D. does not allow this.", "", "ship"));
            }
            if (c < 0) return false;
            long q = ParseLong(DigitsOnly(c.ToString(CultureInfo.InvariantCulture)));
            Money();
            var result = Query("SELECT * FROM server_shop_items WHERE lootId = @lid LIMIT 1", Kv("@lid", lootId));
            if (result.Count == 0) return false; // PHP $result[0] → fatal; трактуем как нет товара
            _itemInformation = result[0].ToDictionary(kv => kv.Key, kv => (object)kv.Value, StringComparer.OrdinalIgnoreCase);
            string price;
            switch (lootId)
            {
                case "drone_iris": price = DronePrice("iris"); break;
                case "drone_flax": price = DronePrice("flax"); break;
                case "drone_apis": price = DronePrice("apis"); break;
                case "drone_zeus": price = DronePrice("zeus"); break;
                default: price = (ParseDouble(GetStr(result[0], "buy")) * q).ToString(CultureInfo.InvariantCulture); break;
            }
            double priceD = ParseDouble(price);
            string ucd = GetStr(result[0], "ucd");
            if (ucd == "c") return SpendCredits(q, priceD);
            if (ucd == "u") return SpendUridium(q, priceD);
            return false; // "x" и прочее
        }

        private bool SpendCredits(long q, double price)
        {
            if (ParseDouble(Credits) - price < 0) return false;
            double eprice;
            if (CPT())
            {
                eprice = price / 100 * 95;
                GC.KeepAlive((ParseDouble(Credits) - eprice) + "-5%"); // $after в PHP только ради side-note, не используется
            }
            else eprice = price;
            return Execute("UPDATE server_1_players SET credits = (credits-" + Fmt(eprice) + ") WHERE playerID=@playerID",
                           Kv("@playerID", _pid)) >= 0;
        }

        private bool SpendUridium(long q, double price)
        {
            if (ParseDouble(Uridium) - price < 0) return false;
            double eprice;
            if (CPT())
            {
                eprice = price / 100 * 95;
                GC.KeepAlive((ParseDouble(Uridium) - eprice) + "-5%");
            }
            else eprice = price;
            return Execute("UPDATE server_1_players SET uri = (uri-" + Fmt(eprice) + ") WHERE playerID=@playerID",
                           Kv("@playerID", _pid)) >= 0;
        }

        /// <summary>public guns($amw, $id) — покупка оружия.</summary>
        public string Guns(string amw, string id)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            string am = DigitsOnly(amw);
            if (!IsDigit(am)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            long a = ParseLong(am);
            var exploded = id.Split('_');
            string name = exploded.Length > 0 ? exploded[exploded.Length - 1] : "";
            if (PriceCal(id, a)) return ItemReg(id, "weapon", id, name, a, 0, 1, 1);
            return ErrMessage("You have not money enough!", id, "ship");
        }

        /// <summary>private blockIDs($id) — чёрный список S.H.E.I.L.D.</summary>
        private static bool BlockIDs(string id)
        {
            var blocked = new[] { "equipment_weapon_laser_lf-5", "police_ship" };
            return blocked.Contains(id);
        }

        /// <summary>private updateAmmo($am, $full) — недостижим в оригинале (вызов закомментирован); портирован 1:1 с багами $name/$id.</summary>
        private string UpdateAmmo(long am, string full)
        {
            // $full — имя колонки из белого списка ammoClassing; интерполяция безопасна после whitelist
            if (Execute("UPDATE server_1_player_ammunation SET " + full + " = (" + full + "+" + am + ") WHERE playerID=@pid",
                        Kv("@pid", _pid)) < 0)
            {
                return ErrMessage("S.H.E.I.L.D. found a bug on your account, contact staff.", "", "ship");
            }
            // PHP: $name/$id не определены → ''; execute() true → success-сообщение
            return "{\"result\":\"success\",\"message\":\"" + am + "x ammunition: \\\"\\\" purchased.<br \\/><br \\/>\",\"showEquipOption\":false,\"userBalance\":{\"uridium\":" + Uridium + ",\"credits\":" + Credits + "},\"userShip\":{\"laserAmmunitionSpace\":100000000,\"rocketSpace\":100000000},\"isShipDumpEmpty\":false,\"itemId\":\"\",\"category\":\"ammunition\"}";
        }

        /// <summary>public battery($amw, $id) — покупка боеприпасов.</summary>
        public string Battery(string amw, string id)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            var ammoClassing = new Dictionary<string, string>
            {
                { "ammunition_laser_lcb-10", "lcb10" }, { "ammunition_laser_mcb-25", "mcb25" },
                { "ammunition_laser_mcb-50", "mcb50" }, { "ammunition_laser_ucb-100", "ucb100" },
                { "ammunition_laser_sab-50", "sab50" }, { "ammunition_laser_rsb-75", "rsb75" },
                { "ammunition_rocket_r-310", "r310" }, { "ammunition_rocket_plt-2026", "plt2026" },
                { "ammunition_rocket_plt-2021", "plt2021" }, { "ammunition_rocket_plt-3030", "plt3030" },
                { "ammunition_specialammo_pld-8", "pld8" }, { "ammunition_specialammo_dcr-250", "dcr250" },
                { "ammunition_specialammo_wiz-x", "wizx" }, { "ammunition_rocketlauncher_hstrm-01", "hstrm01" },
                { "ammunition_rocketlauncher_ubr-100", "ubr100" }, { "ammunition_rocketlauncher_eco-10", "eco10" },
                { "ammunition_mine_acm-01", "acm01" }, { "ammunition_mine_empm-01", "empm01" },
                { "ammunition_mine_sabm-01", "sabm01" }, { "ammunition_mine_ddm-01", "ddm01" },
                { "ammunition_specialammo_smb01", "smb01" }, { "ammunition_specialammo_ish01", "ish01" },
                { "ammunition_specialammo_emp-01", "emp01" }, { "ammunition_firework_fwx-s", "fwxs" },
                { "ammunition_firework_fwx-m", "fwxm" }, { "ammunition_firework_fwx-l", "fwxl" },
            };
            GC.KeepAlive(ammoClassing); // map из оригинала (updateAmmo вызов закомментирован)
            string am = DigitsOnly(amw);
            if (!IsDigit(am)) return null; // PHP: внешний else относится к ctype_digit — при нецифрах метод молча завершается null
            long a = ParseLong(am);
            var exploded = id.Split('_');
            string name = exploded.Length > 0 ? exploded[exploded.Length - 1] : "";
            if (id == "ammunition_laser_mcb-25" && a % 2 != 0)
                return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            if (PriceCal(id, a))
            {
                if (CheckExistence(id)) return ItemReg(id, "ammo", id, name, a, 0, 0, 0);
                return ItemReg(id, "ammo", id, name, a, 0, 0, 1);
            }
            return ErrMessage("You have not money enough!", id, "ship");
        }

        /// <summary>public petPet($amw,$id,$name) — PET отключён в оригинале ранним return; недостижимый код опущен, заглушка сохранена.</summary>
        public string PetPet(string amw, string id, string name)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            return ErrMessage("S.H.E.I.L.D. has disabled PET. ", id, "ship");
            // Далее в оригинале недостижимый блок покупки пета (regPet/CreatePet/CreateConfigPet/my_pet_id) —
            // портирован ниже как private-методы для полноты, вызываться не может.
        }

        private string RegPet(string lootid, string name)
        {
            var result = Query("SELECT id FROM server_1_player_all_items WHERE lootid=@lootid && playerID=@playerID && userID=@userID ORDER BY id DESC LIMIT 1",
                               Kv("@lootid", lootid), Kv("@playerID", _pid), Kv("@userID", _uid));
            if (result.Count == 0) return null;
            return CreatePet(GetStr(result[0], "id"), name, lootid);
        }

        private string CreateConfigPet(string petId, string lootid)
        {
            for (long i = 1; i <= 2; i++)
                Execute("INSERT INTO server_1_hangar_config_pet10 (`hangarID`, `petID`, `playerID`, `userID`, `configNum`) VALUES (@a, @b, @c, @d, @e)",
                        Kv("@a", _hid), Kv("@b", petId), Kv("@c", _pid), Kv("@d", _uid), Kv("@e", i));
            return "{\"result\":\"success\",\"message\":\"You bought 1 pet<br \\/><br \\/>\",\"showEquipOption\":false,\"userBalance\":{\"uridium\":" + Uridium + ",\"credits\":" + Credits + "},\"userShip\":{\"laserAmmunitionSpace\":100000000,\"rocketSpace\":100000000},\"isShipDumpEmpty\":false,\"itemId\":\"" + lootid + "\",\"category\":\"drone\"}";
        }

        private string MyPetId(string itemId)
        {
            var result = Query("SELECT pet_id FROM server_1_player_pet10 WHERE userID = @p1 && playerID = @p2 && item_id = @p3",
                               Kv("@p1", _uid), Kv("@p2", _pid), Kv("@p3", itemId));
            return result.Count > 0 ? GetStr(result[0], "pet_id") : ""; // PHP $result[0] на пустом → notice→null
        }

        private string CreatePet(string id, string name, string lootid)
        {
            const string co = "4|8|3|4";
            int n = Execute("INSERT INTO server_1_player_pet10 (`pet_name`, `lockedSlots`, `item_id`, `userID`, `playerID`) VALUES (@a, @b, @c, @d, @e)",
                            Kv("@a", name), Kv("@b", co), Kv("@c", id), Kv("@d", _uid), Kv("@e", _pid));
            if (n >= 0) return CreateConfigPet(MyPetId(id), lootid);
            return null;
        }

        /// <summary>public special($amw, $id) — покупка спец-предметов.</summary>
        public string Special(string amw, string id)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            string am = DigitsOnly(amw);
            if (!IsDigit(am)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            long a = ParseLong(am);
            var exploded = id.Split('_');
            string name = exploded.Length > 0 ? exploded[exploded.Length - 1] : "";
            if (PriceCal(id, a))
            {
                if (id == "resource_booty-key" || id == "resource_logfile")
                {
                    if (CheckExistence(id)) return ItemReg(id, "special", id, name, a, 0, 0, 0);
                    return ItemReg(id, "special", id, name, a, 0, 1, 1);
                }
                return ItemReg(id, "special", id, name, a, 0, 1, 1);
            }
            return ErrMessage("You have not money enough!", id, "ship");
        }

        /// <summary>public generator($amw, $id) — покупка генераторов.</summary>
        public string Generator(string amw, string id)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            string am = DigitsOnly(amw);
            if (!IsDigit(am)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            long a = ParseLong(am);
            var exploded = id.Split('_');
            string name = exploded.Length > 0 ? exploded[exploded.Length - 1] : "";
            if (PriceCal(id, a)) return ItemReg(id, "generator", id, name, a, 0, 1, 1);
            return ErrMessage("You have not money enough!", id, "ship");
        }

        private string DroneReg(string lootid)
        {
            CreateConfig(_newID);
            if (lootid == "drone_flax") return CreateDrone(_newID, "credits", lootid);
            return CreateDrone(_newID, "uridium", lootid);
        }

        private void CreateConfig(string id)
        {
            // Оригинальный баг: userID биндится на $this->pid (не uid) — сохранено.
            Execute("INSERT INTO `server_1_hangar_config_drones` (`playerID`, `userID`, `hangarID`, `item_id`) VALUES (@a, @b, @c, @d)",
                    Kv("@a", _pid), Kv("@b", _pid), Kv("@c", _hid), Kv("@d", _newID));
            GC.KeepAlive(id);
        }

        private string CreateDrone(string id, string currency, string lootid)
        {
            int n = Execute("INSERT INTO server_1_player_drones (`item_sale_id`, `drone_currency`, `userID`, `playerID`, `drone_kind`, `drone_design`) VALUES (@a, @b, @c, @d, @e, '')",
                            Kv("@a", _newID), Kv("@b", currency), Kv("@c", _uid), Kv("@d", _pid), Kv("@e", lootid));
            if (n >= 0)
            {
                var names = lootid.Split('_');
                string name = names.Length > 1 ? names[1] : "";
                return "{\"result\":\"success\",\"message\":\"You bought 1x " + name + " <br \\/><br \\/>\",\"showEquipOption\":false,\"userBalance\":{\"uridium\":" + Uridium + ",\"credits\":" + Credits + "},\"userShip\":{\"laserAmmunitionSpace\":100000000,\"rocketSpace\":100000000},\"isShipDumpEmpty\":false,\"itemId\":\"" + lootid + "\",\"category\":\"drone\"}";
            }
            return null;
        }

        /// <summary>public drone($id) — покупка дрона (1..4 = flax/iris/apis/zeus, иначе lootid).</summary>
        public string Drone(string id)
        {
            if (BlockIDs(id)) return ErrMessage("S.H.E.I.L.D. does not allow this.", id, "ship");
            switch (id)
            {
                case "1":
                    if (PriceCal("drone_flax", 1)) { ItemReg("drone_flax", "drone", "drone_flax", "Flax", 1, 1, 0, 1); return DroneReg("drone_flax"); }
                    return ErrMessage("You have not money enough!", id, "ship");
                case "2":
                    if (PriceCal("drone_iris", 1)) { ItemReg("drone_iris", "drone", "drone_iris", "Iris", 1, 1, 0, 1); return DroneReg("drone_iris"); }
                    return ErrMessage("You have not money enough!", id, "ship");
                case "3":
                    if (PriceCal("drone_apis", 1)) { ItemReg("drone_apis", "drone", "drone_apis", "apis", 1, 1, 0, 1); return DroneReg("drone_apis"); }
                    return ErrMessage("You have not money enough!", id, "ship");
                case "4":
                    if (PriceCal("drone_zeus", 1)) { ItemReg("drone_zeus", "drone", "drone_zeus", "zeus", 1, 1, 0, 1); return DroneReg("drone_zeus"); }
                    return ErrMessage("You have not money enough!", id, "ship");
                default:
                {
                    var exploded = id.Split('_');
                    string name = exploded.Length > 0 ? exploded[exploded.Length - 1] : "";
                    if (CheckExistence(id))
                    {
                        // PHP: $what не определена → '' в category — сохранено.
                        return "{\"result\":\"success\",\"message\":\"You already own this item. <br \\/><br \\/>\",\"showEquipOption\":false,\"userBalance\":{\"uridium\":" + Uridium + ",\"credits\":" + Credits + "},\"userShip\":{\"laserAmmunitionSpace\":100000000,\"rocketSpace\":100000000},\"isShipDumpEmpty\":false,\"itemId\":\"" + id + "\",\"category\":\"\"}";
                    }
                    if (PriceCal(id, 1))
                    {
                        ItemReg(id, "drone", id, name, 1, 1, 0, 1);
                        return DroneReg("drone_iris"); // оригинал: всегда drone_iris — сохранено
                    }
                    return ErrMessage("You have not money enough!", id, "ship");
                }
            }
        }

        /// <summary>public money() — перечитать uri/credits.</summary>
        public void Money()
        {
            var result = Query("SELECT uri, credits FROM server_1_players WHERE userID=@userID && playerID=@playerID",
                               Kv("@userID", _uid), Kv("@playerID", _pid));
            if (result.Count > 0)
            {
                Uridium = GetStr(result[0], "uri");
                Credits = GetStr(result[0], "credits");
            }
        }

        /// <summary>private itemReg(...) — регистрация покупки в инвентаре (+pmc-лог).</summary>
        private string ItemReg(string id, string what, string lootId, string name, long am, long inter, long count, long add)
        {
            Money();
            var ch = new Dictionary<string, long>
            {
                { "equipment_extra_cpu_cl04k-m", 10 }, { "equipment_extra_cpu_cl04k-xl", 50 },
                { "equipment_extra_cpu_jp-02", 20 }, { "equipment_extra_cpu_jp-01", 10 },
            };
            long Q = count != 0 ? 1 : am;
            long inp = inter;
            // PHP ($id!="resource_booty-key" || $id!="resource_logfile") всегда true — ветка bindParam(2,$am) недостижима.
            if (add != 0)
            {
                bool hasCharge = ch.ContainsKey(lootId);
                string sql = hasCharge
                    ? "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`, `charge`) VALUES (@a, @b, @c, @d, @e, @f)"
                    : "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (@a, @b, @c, @d, @e)";
                if (count != 0)
                {
                    for (long i = 1; i <= am; i++)
                    {
                        var ps = new List<KeyValuePair<string, object>>
                        {
                            Kv("@a", lootId), Kv("@b", Q), Kv("@c", inp), Kv("@d", _pid), Kv("@e", _uid),
                        };
                        if (hasCharge) ps.Add(Kv("@f", ch[lootId]));
                        Execute(sql, ps.ToArray());
                        _newID = LastInsertId();
                        PmcItemLog(Q);
                    }
                    return OkMessage(am, what, name, id);
                }
                else
                {
                    var ps = new List<KeyValuePair<string, object>>
                    {
                        Kv("@a", lootId), Kv("@b", Q), Kv("@c", inp), Kv("@d", _pid), Kv("@e", _uid),
                    };
                    if (hasCharge) ps.Add(Kv("@f", ch[lootId]));
                    if (Execute(sql, ps.ToArray()) >= 0)
                    {
                        _newID = LastInsertId();
                        PmcItemLog(1);
                        return OkMessage(am, what, name, id);
                    }
                    return null; // PHP print_r(errorInfo)+exit — в веб-контексте пишем в лог и возвращаем null
                }
            }
            else
            {
                int n = Execute("UPDATE `server_1_player_all_items` SET Q = Q + " + Q + " WHERE playerID=@p1 && lootid=@p2",
                                Kv("@p1", _pid), Kv("@p2", lootId));
                if (n >= 0)
                {
                    string cuItemId = _cuId != null && _cuId.Count > 0 ? GetStr(_cuId[0], "id") : "";
                    PmcLog(Q, cuItemId);
                    return OkMessage(am, what, name, id);
                }
                return null;
            }
        }

        private void PmcItemLog(long perRowQ)
        {
            string buy = ItemField("buy"), ucd = ItemField("ucd");
            string list = ucd == "c"
                ? "11|0|" + buy + "|" + _newID + "|" + perRowQ
                : "12|0|" + buy + "|" + _newID + "|" + perRowQ;
            DB.Pmc(_pid, list, ucd == "c" ? "credits" : "uridium");
        }

        private void PmcLog(long q, string cuItemId)
        {
            string buy = ItemField("buy"), ucd = ItemField("ucd");
            double total = ParseDouble(buy) * q;
            string list = ucd == "c"
                ? "11|0|" + Fmt(total) + "|" + cuItemId + "|" + q
                : "12|0|" + Fmt(total) + "|" + cuItemId + "|" + q;
            DB.Pmc(_pid, list, ucd == "c" ? "credits" : "uridium");
        }

        private string ItemField(string col)
        {
            if (_itemInformation == null) return "";
            object o;
            return _itemInformation.TryGetValue(col, out o) ? Str(o) : "";
        }

        private string OkMessage(long am, string what, string name, string id)
        {
            return "{\"result\":\"success\",\"message\":\"" + am + "x " + what + ": \\\"" + name + "\\\" purchased.<br \\/><br \\/>\",\"showEquipOption\":false,\"userBalance\":{\"uridium\":" + Uridium + ",\"credits\":" + Credits + "},\"userShip\":{\"laserAmmunitionSpace\":100000000,\"rocketSpace\":100000000},\"isShipDumpEmpty\":false,\"itemId\":\"" + id + "\",\"category\":\"" + what + "\"}";
        }

        private string ErrMessage(string message, string id, string category)
        {
            return "{\"result\":\"error\",\"message\":\"" + message + "\",\"userBalance\":{\"uridium\":" + Uridium + ",\"credits\":" + Credits + "},\"userShip\":{\"laserAmmunitionSpace\":0,\"rocketSpace\":0},\"isShipDumpEmpty\":false,\"itemId\":\"" + id + "\",\"category\":\"" + category + "\"}";
        }

        // ------------------------------------------------------------------
        // Helpers (те же соглашения, что Inventory/Skylab)
        // ------------------------------------------------------------------

        private static KeyValuePair<string, object> Kv(string k, object v)
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

        private static long Count(string sql, params KeyValuePair<string, object>[] ps)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(sql, con))
            {
                foreach (var p in ps) cmd.Parameters.AddWithValue(p.Key, p.Value);
                using (var rdr = cmd.ExecuteReader())
                {
                    long n = 0;
                    while (rdr.Read()) n++;
                    return n;
                }
            }
        }

        protected static int Execute(string sql, params KeyValuePair<string, object>[] ps)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(sql, con))
            {
                foreach (var p in ps) cmd.Parameters.AddWithValue(p.Key, p.Value);
                try { return cmd.ExecuteNonQuery(); }
                catch (Exception) { return -1; }
            }
        }

        private static string LastInsertId()
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT LAST_INSERT_ID()", con))
            {
                var o = cmd.ExecuteScalar();
                return o == null || o is DBNull ? "" : Convert.ToString(o, CultureInfo.InvariantCulture);
            }
        }

        protected static string GetStr(IDictionary<string, string> d, string key)
        {
            string v;
            return d != null && d.TryGetValue(key, out v) ? v : "";
        }

        private static string Str(object o)
        {
            return o == null ? "" : Convert.ToString(o, CultureInfo.InvariantCulture);
        }

        private static long ParseLong(string s)
        {
            long r;
            s = (s ?? "").Trim();
            var m = System.Text.RegularExpressions.Regex.Match(s, @"^[+-]?\d+");
            return m.Success && long.TryParse(m.Value, NumberStyles.AllowLeadingSign, CultureInfo.InvariantCulture, out r) ? r : 0;
        }

        private static double ParseDouble(string s)
        {
            double r;
            s = (s ?? "").Trim();
            var m = System.Text.RegularExpressions.Regex.Match(s, @"^[+-]?(\d+(\.\d*)?|\.\d+)");
            return m.Success && double.TryParse(m.Value, NumberStyles.Float, CultureInfo.InvariantCulture, out r) ? r : 0;
        }

        /// <summary>PHP round() для display-строк: целые без хвоста .0.</summary>
        private static string Fmt(double d)
        {
            if (d == Math.Floor(d) && !double.IsInfinity(d))
                return ((long)d).ToString(CultureInfo.InvariantCulture);
            return d.ToString(CultureInfo.InvariantCulture);
        }

        private static string DigitsOnly(string s)
        {
            if (string.IsNullOrEmpty(s)) return "";
            return new string(s.Where(char.IsDigit).ToArray());
        }

        /// <summary>PHP ctype_digit: непустая строка только из ASCII-цифр.</summary>
        private static bool IsDigit(string s)
        {
            if (string.IsNullOrEmpty(s)) return false;
            return s.All(c => c >= '0' && c <= '9');
        }

        private static long UnixNow()
        {
            return (long)(DateTime.UtcNow - new DateTime(1970, 1, 1, 0, 0, 0, DateTimeKind.Utc)).TotalSeconds;
        }

        /// <summary>PHP strtotime() для типовых форматов дат БД ('Y-m-d H:i:s', 'Y-m-d'); null при false.</summary>
        private static DateTime? PhpStrtotime(string s)
        {
            s = (s ?? "").Trim();
            if (s == "") return null;
            DateTime dt;
            if (DateTime.TryParseExact(s, new[] { "yyyy-MM-dd HH:mm:ss", "yyyy-MM-dd", "yyyy-M-d H:m:s", "yyyy-M-d" },
                                       CultureInfo.InvariantCulture, DateTimeStyles.None, out dt))
                return dt;
            if (DateTime.TryParse(s, CultureInfo.InvariantCulture, DateTimeStyles.None, out dt))
                return dt;
            return null;
        }
    }
}
