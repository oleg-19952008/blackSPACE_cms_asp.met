using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.inventory.php (1736 строк).
    /// Chunk A3.1 (PORTING-PLAN.md): каркас/транзакции — __construct, setId, init,
    /// CompleteTrans, errorTrans, checkMinus, геттеры (getItemInfo, getItemsList,
    /// getLootIds, getJson, submitParams, droneEquip) (original lines 1–177);
    /// плюс публичные read-only геттеры из A3.6 (getTypes, getMoney, getMainInfo,
    /// getFacInfo), от которых зависит init().
    ///
    /// PHP-замечания, сохранённые при переносе:
    ///  - $copyright-check в __construct/setId — no-op guard («Do not violate my
    ///    copyright»), портирован как есть (в C# недостижим, оставлен комментарием).
    ///  - errorTrans(): в оригинале строка сообщения подставляется в json_decode
    ///    напрямую (инъекция кавычек возможна); здесь сообщение экранируется через
    ///    структуру и Newtonsoft-сериализацию.
    ///  - money() в PHP — stdClass с полями uridium/credits, заполняется в
    ///    getMainInfo(); до вызова GetMainInfo() поля null -> в JSON "" (сохранено).
    ///  - number_format($x) по умолчанию = разделитель тысяч ','.
    ///  - checkMinus(): PDO execute() на DELETE возвращает true даже при 0 затронутых
    ///    строк — ExecuteNonQuery() >= 0 эквивалентно.
    ///  - getTypes()/hangarGeneral() и др. при ошибке запроса в PHP возвращают null —
    ///    здесь пустые коллекции/null соответственно.
    /// </summary>
    public class Inventory
    {
        /* Everything the script needs to keep track */
        private readonly string _copyright = "BY Seven & NavigatoR - MEDIANET IVS"; // no-op guard в оригинале
        private long _uid;
        private long _pid;
        private List<string> _lootids = new List<string>();
        private List<Dictionary<string, object>> _itemInfo = new List<Dictionary<string, object>>();
        private List<Dictionary<string, object>> _items = new List<Dictionary<string, object>>();
        private object _sm;                          // private $SM (не используется в этом классе)
        private Dictionary<string, object> _money;   // uridium/credits (см. замечания)
        private List<Dictionary<string, object>> _hangars = new List<Dictionary<string, object>>();
        private int _hasPet;                         // 0/1 (в PHP не инициализирован -> null/false)
        private object _params;                      // результат json_decode(submitParams)
        private Dictionary<string, object> _json;    // результат init()
        private object _equipment;
        private int _totalSlots;
        private object _pie;
        private bool _droneEquip = false;
        private object _cpuslot;
        private bool _cpuFilled = false;
        private object _s;
        private object _cuCpu = null;

        /* Constructor does everything that needs to be done at every load */
        public Inventory()
        {
            // if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") die(...)
            // — в C# поле readonly и равно константе, guard тривиально выполнен.
            GC.KeepAlive(_copyright);
            // $this->con = $GLOBALS['DB']; — соединения берутся через DB.GetInstance(),
            // глобальный PDO-объект не нужен.
        }

        public void SetId(long uid, long pid)
        {
            _uid = uid;
            _pid = pid;
        }

        public void DroneEquip(bool i) { _droneEquip = i; }

        public List<Dictionary<string, object>> GetItemInfo() { return _itemInfo; }
        public List<Dictionary<string, object>> GetItemsList() { return _items; }
        public List<string> GetLootIds() { return _lootids; }
        public Dictionary<string, object> GetJson() { return _json; }

        /// <summary>submitParams($params) — json_decode($params) (assoc).</summary>
        public void SubmitParams(string params_)
        {
            _params = JsonUtil.DecodeObject(params_);
        }

        /// <summary>
        /// public init() — полная загрузка инвентаря: фильтры, деньги, ангары,
        /// предметы, itemInfo, types, lootIds. Возвращает структуру json;
        /// сериализуется в base64(JSON) методом CompleteInit (см. ниже).
        /// </summary>
        public Dictionary<string, object> Init()
        {
            var mainInfo = GetMainInfo();
            var retDict = new Dictionary<string, object>();
            var mapDict = new Dictionary<string, object>();
            var json = new Dictionary<string, object>
            {
                { "isError", 0 },
                { "data", new Dictionary<string, object>
                    {
                        { "ret", retDict },
                        { "money", new Dictionary<string, object>() },
                        { "map", mapDict },
                    }
                },
            };

            /* FILTERS */
            var filters = new Dictionary<string, object>
            {
                /* WEAPONS */
                { "weapons", new long[] { 0, 1, 2 } },
                /* GENERATORS */
                { "generators", new long[] { 3, 4, 5 } },
                /* EXTRAS */
                { "extras", new long[] { 6, 7, 8, 9, 10, 11 } },
                /* AMMUNITION */
                { "ammunition", new long[] { 12, 13, 14 } },
                /* RESOURCES */
                { "resources", new long[] { 15 } },
                /* DRONE RELATED */
                { "drone_related", new long[] { 16, 17 } },
                /* MODUELS (орфография оригинала) */
                { "modules", new long[] { 18 } },
                /* PET RELATED */
                { "pet_related", new long[] { 19, 20 } },
            };
            retDict["filters"] = filters;

            ((Dictionary<string, object>)json["data"])["money"] = GetMoney();
            /* ITEM RELATED */
            retDict["hangars"] = HangarGenerator();       // A3.6
            ItemLootIdGenerator();                        // A3.6
            retDict["items"] = GetItemsList();
            retDict["itemInfo"] = GetItemInfo();
            retDict["userinfo"] = new Dictionary<string, object> { { "factionRelated", mainInfo } };

            mapDict["types"] = GetTypes();                // A3.6
            mapDict["lootIds"] = GetLootIds();

            _json = json;
            return _json;
        }

        /// <summary>init() + base64(json_encode(...)) — формат ответа internal inventory.</summary>
        public string CompleteInit()
        {
            Init();
            return Encode(_json);
        }

        /// <summary>base64_encode(json_encode($obj)).</summary>
        protected static string Encode(object o)
        {
            return Convert.ToBase64String(
                System.Text.Encoding.UTF8.GetBytes(Serialize(o)));
        }

        protected static string Serialize(object o)
        {
            return Newtonsoft.Json.JsonConvert.SerializeObject(o);
        }

        /// <summary>
        /// private CompleteTrans($m, $ret, $update = null) — сборка ответа транзакции.
        /// $ret==2 → {"isError":0,"data":{"ret":[...$m]}}; $ret==1 → ret:1; иначе ret:0.
        /// При $update != null добавляется data.update.slotCpuMove = values($m).
        /// </summary>
        protected string CompleteTrans(IEnumerable<Dictionary<string, object>> m, int ret, object update = null)
        {
            var data = new Dictionary<string, object>();
            var jsn = new Dictionary<string, object>
            {
                { "isError", 0 },
                { "data", data },
            };
            if (ret == 2)
            {
                data["ret"] = new List<Dictionary<string, object>>(m);
            }
            else if (ret == 1)
            {
                data["ret"] = 1;
            }
            else
            {
                data["ret"] = 0;
            }
            data["money"] = _money;
            if (update != null)
            {
                data["update"] = new Dictionary<string, object>
                {
                    { "slotCpuMove", new List<Dictionary<string, object>>(m) },
                };
            }
            return Encode(jsn);
        }

        /// <summary>
        /// public errorTrans($message) — {"isError":1,"data":{"ret":0,
        /// "money":{"uridium":"","credits":""}},"error":{"message":...}},
        /// затем money-&gt;uridium/credits перезаписываются текущими значениями
        /// ($this-&gt;money может быть null до GetMainInfo() — тогда "").
        /// </summary>
        public string ErrorTrans(string message)
        {
            var money = new Dictionary<string, object>
            {
                { "uridium", _money != null ? GetOrEmpty(_money, "uridium") : "" },
                { "credits", _money != null ? GetOrEmpty(_money, "credits") : "" },
            };
            var jsn = new Dictionary<string, object>
            {
                { "isError", 1 },
                { "data", new Dictionary<string, object> { { "ret", 0 }, { "money", money } } },
                { "error", new Dictionary<string, object> { { "message", message ?? "" } } },
            };
            return Encode(jsn);
        }

        /// <summary>
        /// private checkMinus($id, $tran = NULL) — чистит записи с Q &lt; 1 и отдаёт
        /// ответ об удалении. tran==2 → вариант без обёртки "update" (money вложенным
        /// объектом сразу в data). В обоих случаях в конце money = $this-&gt;money.
        /// </summary>
        protected string CheckMinus(string id, int? tran = null)
        {
            int affected = Execute("DELETE FROM server_1_player_all_items WHERE Q < 1 && id=@id",
                                   Kv("@id", id));
            if (affected >= 0) // PDO execute() успешен даже при 0 строк
            {
                var data = new Dictionary<string, object>();
                var jsn = new Dictionary<string, object> { { "isError", 0 }, { "data", data } };
                if (tran == 2)
                {
                    data["slotCpuMove"] = new Dictionary<string, object>
                    {
                        { "1", new List<object>() }, { "2", new List<object>() },
                    };
                    data["ret"] = 1;
                    data["money"] = new Dictionary<string, object>
                    {
                        { "uridium", _money != null ? GetOrEmpty(_money, "uridium") : "" },
                        { "credits", _money != null ? GetOrEmpty(_money, "credits") : "" },
                    };
                }
                else
                {
                    data["ret"] = 1;
                    data["update"] = new Dictionary<string, object>
                    {
                        { "deleted", new List<object> { id } },
                        { "slotCpuMove", new Dictionary<string, object>
                            { { "1", new List<object>() }, { "2", new List<object>() } } },
                    };
                }
                data["money"] = _money; // финальная перезапись как в PHP
                return Encode(jsn);
            }
            return ErrorTrans("Something went wrong!");
        }

        // ------------------------------------------------------------------
        // Публичные read-only геттеры (A3.6, строки 1268–1311) — нужны init().
        // Остальные методы A3.6 (hangarGenerator, itemLootIdGenerator, конфиги)
        // подключаются следующим куском.
        // ------------------------------------------------------------------

        /// <summary>public getMoney() — возвращает $this-&gt;money (null до GetMainInfo()).</summary>
        public Dictionary<string, object> GetMoney() { return _money; }

        /// <summary>public getTypes() — SELECT item_type_name FROM server_item_types.</summary>
        public List<string> GetTypes()
        {
            var result = Query("SELECT item_type_name FROM server_item_types ");
            var array = new List<string>();
            foreach (var row in result) array.Add(GetStr(row, "item_type_name"));
            return array;
        }

        /// <summary>
        /// public getMainInfo() — uri/credits/factionId игрока; заполняет money
        /// (number_format с разделителем тысяч) и возвращает 'mmo'|'eic'|'vru'.
        /// </summary>
        public string GetMainInfo()
        {
            var result = Query("SELECT uri, credits, factionId FROM server_1_players WHERE playerID=@playerID",
                               Kv("@playerID", _pid));
            if (result.Count == 0) return null; // PHP: нет строк/ошибка execute() — null
            _money = new Dictionary<string, object>();
            var row = result[0];
            _money["uridium"] = PhpNumberFormat(ParseLong(row["uri"]));
            _money["credits"] = PhpNumberFormat(ParseLong(row["credits"]));
            long factionId = ParseLong(row["factionId"]);
            if (factionId == 1) return "mmo";
            if (factionId == 2) return "eic";
            return "vru";
        }

        /// <summary>public getFacInfo() — factionId игрока (int).</summary>
        public long GetFacInfo()
        {
            var result = Query("SELECT uri, credits, factionId FROM server_1_players WHERE playerID=@playerID",
                               Kv("@playerID", _pid));
            if (result.Count == 0) return 0;
            _money = new Dictionary<string, object>(); // в PHP тоже пересоздаётся (пустой)
            return ParseLong(result[0]["factionId"]);
        }

        // ------------------------------------------------------------------
        // helpers (те же, что в Skylab.cs; переедут в общий утилитный класс
        // при рефакторинге после фазы A)
        // ------------------------------------------------------------------

        /// <summary>PHP number_format($x) по умолчанию: разделитель тысяч ','.</summary>
        protected static string PhpNumberFormat(double x)
        {
            return x.ToString("#,##0", CultureInfo.InvariantCulture);
        }

        protected static string GetOrEmpty(Dictionary<string, object> d, string key)
        {
            object o;
            return d != null && d.TryGetValue(key, out o) && o != null
                ? Convert.ToString(o, CultureInfo.InvariantCulture) : "";
        }

        protected static string GetStr(IDictionary<string, string> d, string key)
        {
            string o;
            return d != null && d.TryGetValue(key, out o) && o != null ? o : "";
        }

        protected static KeyValuePair<string, object> Kv(string name, object value)
        {
            return new KeyValuePair<string, object>(name, value);
        }

        protected static int Execute(string sql, params KeyValuePair<string, object>[] ps)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(sql, con))
            {
                foreach (var p in ps) cmd.Parameters.AddWithValue(p.Key, p.Value);
                return cmd.ExecuteNonQuery();
            }
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

        protected static long ParseLong(string s)
        {
            long v;
            return long.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        // ------------------------------------------------------------------
        // A3.2 Продажа (Class.inventory.php, строки 178–372): renamePet/setName,
        // cashOut, checkDB, sell, checkItemsOwnerShip, DelDrone/sellDrone,
        // wipeDrone/wipeConfigs, changeShipModel.
        //
        // PHP-замечания, сохранённые при переносе:
        //  - renamePet(): условие «if ($left > 0)» в оригинале инвертировано — при
        //    ДОСТАТОЧНЫХ средствах пишется «Renaming pet failed» и возвращается
        //    ошибка; при НЕдостаточных — списание 3000 uri. Дефект сохранён 1:1.
        //  - cashOut(): ветка scd=='u' обновляет колонку credits значением
        //    (uri+$price) («SET credits = (uri+$price)») — баг оригинала сохранён.
        //  - sell(): !empty($tran) OR $tran != NULL для int эквивалентно $tran != null.
        //  - wipeDrone()/wipeConfigs()/changeShipModel() обращаются к
        //    params->params->hi (вложенный объект); при отсутствии — PHP notice →
        //    null → bindParam(0). Здесь PLong(PP("hi")) даёт 0 — эквивалентно.
        // ------------------------------------------------------------------

        /// <summary>public renamePet() — переименование пета за 3000 уридия.</summary>
        public string RenamePet()
        {
            var newName = PS("name");
            long left = PLong(GetOrEmpty(_money, "uridium")) - 3000;
            if (left > 0) // инвертированный дефект оригинала — см. замечания
            {
                DB.Pmc(_pid, "Renaming pet failed", "error");
                return ErrorTrans("You do not have uridium enough!");
            }
            else
            {
                if (Execute("UPDATE server_1_players SET uri = (uri-3000) WHERE playerID=@playerID",
                            Kv("@playerID", _pid)) >= 0)
                {
                    DB.Pmc(_pid, "-3000 uridium | pet renamed", "uridium");
                    return SetName(newName);
                }
                return ErrorTrans("Something went wrong");
            }
        }

        /// <summary>private setName($name) — UPDATE pet_name у пета игрока.</summary>
        private string SetName(string name)
        {
            if (Execute("UPDATE server_1_player_pet10 SET pet_name = @name WHERE playerID=@playerID",
                        Kv("@name", name), Kv("@playerID", _pid)) >= 0)
            {
                DB.Pmc(_pid, "Pet name changed to: " + name, "equipment");
                return CompleteTrans(null, 1);
            }
            return ErrorTrans("Something went wrong");
        }

        /// <summary>
        /// private cashOut($itemId, $q) — зачисление денег от продажи.
        /// Возвращает true/false как PHP.
        /// </summary>
        private bool CashOut(object itemId, object q)
        {
            var result = Query(@"SELECT * FROM server_1_player_all_items
                                 INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootid
                                 WHERE server_1_player_all_items.id = @id",
                               Kv("@id", itemId));
            var row = result.Count > 0 ? result[0] : new Dictionary<string, string>();
            double price = ParseDouble(GetStr(row, "sell")) * ParseDouble(Convert.ToString(q, CultureInfo.InvariantCulture));
            string priceS = TrimNum(price); // PHP "$price" из int*int всегда целое
            string scd = GetStr(row, "scd");
            if (scd == "c")
            {
                DB.Pmc(_pid, "+" + priceS + " credits | sold " + q + " x " + itemId, "credits");
                return Execute("UPDATE server_1_players SET credits = (credits+" + priceS + ") WHERE playerID=@playerID",
                               Kv("@playerID", _pid)) >= 0;
            }
            else if (scd == "u")
            {
                DB.Pmc(_pid, "+" + priceS + " uridium | sold " + q + " x " + itemId, "uridium");
                // баг оригинала: SET credits = (uri+$price)
                return Execute("UPDATE server_1_players SET credits = (uri+" + priceS + ") WHERE playerID=@playerID",
                               Kv("@playerID", _pid)) >= 0;
            }
            else
            {
                DB.Pmc(_pid, "+" + priceS + " credits | sold " + q + " x " + itemId, "credits");
                return Execute("UPDATE server_1_players SET credits = (credits+" + priceS + ") WHERE playerID=@playerID",
                               Kv("@playerID", _pid)) >= 0;
            }
        }

        /// <summary>private checkDB($id) — количество Q предмета у игрока.</summary>
        private long CheckDb(object id)
        {
            var result = Query("SELECT Q FROM server_1_player_all_items WHERE playerID=@playerID && id=@id",
                               Kv("@playerID", _pid), Kv("@id", id));
            return result.Count > 0 ? ParseLong(GetStr(result[0], "Q")) : 0;
        }

        /// <summary>public sell($tran = NULL) — продажа предмета (с проверкой владельца).</summary>
        public string Sell(int? tran = null)
        {
            var itemID = PGet("itemId");
            if (CheckItemsOwnerShip(itemID))
            {
                var q = PGet("quantity");
                if (!IsNumeric(q))
                {
                    return ErrorTrans("Something went wrong!");
                }
                else
                {
                    long pq = CheckDb(itemID);
                    long ql = ParseLong(Convert.ToString(q, CultureInfo.InvariantCulture));
                    if (ql > pq) ql = pq;
                    string qs = Convert.ToString(ql, CultureInfo.InvariantCulture);
                    if (Execute("UPDATE server_1_player_all_items SET Q = (Q -" + qs + ") WHERE id = @id",
                                Kv("@id", itemID)) >= 0)
                    {
                        CashOut(itemID, ql);
                        if (tran != null)
                            return CheckMinus(Convert.ToString(itemID, CultureInfo.InvariantCulture), tran);
                        return CheckMinus(Convert.ToString(itemID, CultureInfo.InvariantCulture));
                    }
                    return ErrorTrans("Something went wrong!");
                }
            }
            return ErrorTrans("Cheating is no allowed!"); // орфография оригинала
        }

        /// <summary>private checkItemsOwnerShip($itemID) — предмет принадлежит игроку?</summary>
        private bool CheckItemsOwnerShip(object itemID)
        {
            var result = Query("SELECT id FROM server_1_player_all_items WHERE id=@id && playerID=@playerID",
                               Kv("@id", itemID), Kv("@playerID", _pid));
            return result.Count > 0;
        }

        /// <summary>private DelDrone($itemID) — удаление дрона из всех конфигов.</summary>
        private void DelDrone(object itemID)
        {
            Execute("DELETE FROM server_1_hangar_config_drones WHERE item_id = @id", Kv("@id", itemID));
        }

        /// <summary>public sellDrone() — продажа дрона: чистит статы/конфиги, затем sell(2).</summary>
        public string SellDrone()
        {
            var itemID = PGet("itemId");
            if (CheckItemsOwnerShip(itemID))
            {
                Execute("DELETE FROM server_1_player_drones WHERE item_sale_id = @id", Kv("@id", itemID));
                DelDrone(itemID);
                return Sell(2);
            }
            return ErrorTrans("Cheating is no allowed!");
        }

        /// <summary>private wipeDrone($drone) — очистка колонки EQ/EQ2+design конфига дронов.</summary>
        private string WipeDrone(string drone)
        {
            // $drone — внутреннее имя колонки из whitelist ('EQ'|'EQ2')
            string sqli = "UPDATE server_1_hangar_config_drones SET " + drone + " = '', design = '' WHERE ";
            sqli += "playerID=@playerID && hangarID=@hangarID";
            if (Execute(sqli, Kv("@playerID", _pid), Kv("@hangarID", PLong(PP("hi")))) >= 0)
            {
                return CompleteTrans(null, 1);
            }
            return ErrorTrans("Something went wrong!");
        }

        /// <summary>public wipeConfigs() — сброс ship-конфига и drone-конфига выбранной раскладки.</summary>
        public string WipeConfigs()
        {
            string drone = PLong(PGet("configID")) == 1 ? "EQ" : "EQ2";
            string sqli = "UPDATE server_1_hangar_config_ship AS s SET s.lasers = '', s.generators = '', s.heavy_guns = '', s.extras = '' WHERE ";
            sqli += " s.playerID=@playerID && s.configNum=@configNum && s.hangarID=@hangarID";
            if (Execute(sqli, Kv("@playerID", _pid), Kv("@configNum", PGet("configID")),
                        Kv("@hangarID", PLong(PP("hi")))) >= 0)
            {
                return WipeDrone(drone);
            }
            return ErrorTrans("Something went wrong!");
        }

        /// <summary>public changeShipModel() — смена выбранной модели корабля в ангаре.</summary>
        public string ChangeShipModel()
        {
            if (Execute("UPDATE server_1_player_hangar_general_ship SET ship_selected_model=@shipmodel WHERE playerID=@playerID && hangarID=@hangarID",
                        Kv("@shipmodel", PS("lootId")), Kv("@playerID", _pid),
                        Kv("@hangarID", PLong(PP("hi")))) >= 0)
            {
                return CompleteTrans(null, 1);
            }
            return ErrorTrans("Something went wrong!");
        }

        // ------------------------------------------------------------------
        // helpers доступа к params (json_decode-структура submitParams)
        // ------------------------------------------------------------------

        protected static bool IsNumeric(object o)
        {
            if (o == null) return false;
            double d;
            return double.TryParse(Convert.ToString(o, CultureInfo.InvariantCulture),
                                   NumberStyles.Any, CultureInfo.InvariantCulture, out d);
        }

        /// <summary>PHP-совместимый парсинг double ('' / мусор -> 0).</summary>
        protected static double ParseDouble(string s)
        {
            double d;
            return double.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out d) ? d : 0;
        }

        /// <summary>Целочисленное представление числа для конкатенации в SQL/строки (PHP (string)int).</summary>
        protected static string TrimNum(double d)
        {
            return d.ToString("0", CultureInfo.InvariantCulture);
        }

        private object PGet(string key)
        {
            var d = _params as IDictionary<string, object>;
            object o;
            return d != null && d.TryGetValue(key, out o) ? o : null;
        }

        private string PS(string key)
        {
            object o = PGet(key);
            return o == null ? "" : Convert.ToString(o, CultureInfo.InvariantCulture);
        }

        private long PLong(object o)
        {
            return o == null ? 0 : ParseLong(Convert.ToString(o, CultureInfo.InvariantCulture));
        }

        /// <summary>params-&gt;params-&gt;$key (вложенный объект).</summary>
        private object PP(string key)
        {
            var inner = PGet("params") as IDictionary<string, object>;
            object o;
            return inner != null && inner.TryGetValue(key, out o) ? o : null;
        }

        // ------------------------------------------------------------------
        // Заглушки методов, подключаемых следующими кусками A3.3–A3.6, чтобы
        // init() компилировался уже сейчас. Каждый следующий коммит заменяет
        // реализацию портом из Class.inventory.php.
        // ------------------------------------------------------------------
        private List<Dictionary<string, object>> HangarGenerator()
        {
            throw new NotImplementedException("A3.6: hangarGenerator (Class.inventory.php:1619)");
        }

        private void ItemLootIdGenerator()
        {
            throw new NotImplementedException("A3.6: itemLootIdGenerator (Class.inventory.php:1659)");
        }
    }
}
