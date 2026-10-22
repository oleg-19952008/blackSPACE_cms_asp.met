using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Web.SessionState;
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
        private object _equipment;      // Eq-обёртка (см. class Eq) либо null
        private bool _equipmentIsEmpty = true;
        private int _totalSlots;
        private object _pie;
        private bool _droneEquip = false;
        private object _cpuslot;
        private bool _cpuFilled = false;
        private long _s;
        private long SCount { get { return _s; } } // PHP: null → 0 при сравнении/цикле (в C# поле long, default 0)
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
        protected string CompleteTrans(IEnumerable<object> m, int ret, object update = null)
        {
            var data = new Dictionary<string, object>();
            var jsn = new Dictionary<string, object>
            {
                { "isError", 0 },
                { "data", data },
            };
            if (ret == 2)
            {
                data["ret"] = m == null ? new List<object>() : new List<object>(m);
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
                    { "slotCpuMove", m == null ? new List<object>() : new List<object>(m) },
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
        // A3.3 БД-оперы/валидация (Class.inventory.php, строки 373–515):
        // addToDB, delFromDb, checkInput, extrasExits.
        //
        // PHP-замечания, сохранённые при переносе:
        //  - array_unique(array_map('serialize',...)) — дедупликация массива id с
        //    сохранением первых ключей; реализовано DistinctKeepKeys.
        //  - $target/$what интерполируются в имя таблицы/колонки — в вызывающем
        //    коде (A3.4/A3.5) это всегда значения из белого списка
        //    (ship/drones/pet10; lasers/generators/heavy_guns/extras/EQ/EQ2/design);
        //    здесь добавлена runtime-проверка whitelist.
        //  - delFromDb() при неудачном execute() возвращает NULL (не false).
        //  - checkInput(): ветка heavy_guns пишет allowed['heavy_guns'] (фиктивный
        //    ключ вместо $key) — баг оригинала сохранён; ветка extras пишет
        //    allowed[lootId] вместо allowed[$key]; default-ветка возвращает
        //    items как disallowed без ключей-порядка ('allowed' остаётся пустым).
        //  - extrasExits(): «KAN IKKE HUSKE HVAD JEG GIK IGANG MED HER!» — метод
        //    ничего не возвращает (собирает $extras и бросает); портирован как no-op
        //    с сохранением побочного init().
        // ------------------------------------------------------------------

        /// <summary>private addToDB($arrays, $target, $what, $drone_id = NULL).</summary>
        private string AddToDb(List<object> arrays, string target, string what, object droneId = null)
        {
            var array = DistinctKeepKeys(arrays);
            foreach (var vln in array)
            {
                if (!CheckItemsOwnerShip(vln))
                {
                    return ErrorTrans("Do NOT cheat!");
                }
            }

            string imp = what == "design"
                ? Convert.ToString(array.Count > 0 ? array[0] : "", CultureInfo.InvariantCulture)
                : string.Join("|", array.Select(x => Convert.ToString(x, CultureInfo.InvariantCulture)));

            bool toDrone = PT("to", "target") == "drone";
            AssertColumn(target, AllowedTargets, "target");
            AssertColumn(what, AllowedWhatColumns, "what");

            string sql = toDrone
                ? "UPDATE server_1_hangar_config_" + target + " SET " + what + "=@imp WHERE playerID=@playerID && hangarID=@hangarID && item_id=@item_id"
                : "UPDATE server_1_hangar_config_" + target + " SET " + what + "=@imp WHERE playerID=@playerID && hangarID=@hangarID && configNum=@configNum";

            int affected;
            if (toDrone)
            {
                object itemId = (droneId != null && !IsEmpty(droneId))
                    ? droneId
                    : PGetNested("to", "droneId");
                affected = Execute(sql, Kv("@imp", imp), Kv("@playerID", _pid),
                                   Kv("@hangarID", PLong(PP("hi"))), Kv("@item_id", itemId));
            }
            else
            {
                affected = Execute(sql, Kv("@imp", imp), Kv("@playerID", _pid),
                                   Kv("@hangarID", PLong(PP("hi"))),
                                   Kv("@configNum", PGetNested("to", "configId")));
            }
            if (affected >= 0) return CompleteTrans(null, 1);
            return ErrorTrans("Something went wrong!");
        }

        /// <summary>private delFromDb($array, $target, $what) — true при успехе, иначе null.</summary>
        private bool? DelFromDb(List<object> array, string target, string what)
        {
            string imp = string.Join("|", array.Select(x => Convert.ToString(x, CultureInfo.InvariantCulture)));

            bool fromDrone = PT("from", "target") == "drone";
            AssertColumn(target, AllowedTargets, "target");
            AssertColumn(what, AllowedWhatColumns, "what");

            string sql = fromDrone
                ? "UPDATE server_1_hangar_config_" + target + " SET " + what + "=@imp WHERE playerID=@playerID && hangarID=@hangarID && item_id=@item_id"
                : "UPDATE server_1_hangar_config_" + target + " SET " + what + "=@imp WHERE playerID=@playerID && hangarID=@hangarID && configNum=@configNum";

            int affected;
            if (fromDrone)
            {
                affected = Execute(sql, Kv("@imp", imp), Kv("@playerID", _pid),
                                   Kv("@hangarID", PLong(PP("hi"))),
                                   Kv("@item_id", PGetNested("from", "droneId")));
            }
            else
            {
                affected = Execute(sql, Kv("@imp", imp), Kv("@playerID", _pid),
                                   Kv("@hangarID", PLong(PP("hi"))),
                                   Kv("@configNum", PGetNested("from", "configId")));
            }
            if (affected >= 0) return true;
            return null; // PHP: нет return в else -> NULL
        }

        private static readonly HashSet<string> AllowedTargets =
            new HashSet<string> { "ship", "drones", "pet10" };
        private static readonly HashSet<string> AllowedWhatColumns =
            new HashSet<string> { "lasers", "generators", "heavy_guns", "extras", "protocols", "EQ", "EQ2", "design" };

        private static void AssertColumn(string value, HashSet<string> whitelist, string name)
        {
            if (value == null || !whitelist.Contains(value))
                throw new ArgumentException("Illegal inventory config column: " + name);
        }

        /// <summary>array_unique по строковому представлению, первые позиции/ключи сохраняются.</summary>
        private static List<object> DistinctKeepKeys(List<object> arr)
        {
            var seen = new HashSet<string>();
            var res = new List<object>();
            foreach (var v in arr)
            {
                string s = Convert.ToString(v, CultureInfo.InvariantCulture);
                if (seen.Add(s)) res.Add(v);
            }
            return res;
        }

        /// <summary>PHP empty() для scalar-значений из json (null/""/0/"0"/false).</summary>
        protected static bool IsEmpty(object o)
        {
            if (o == null) return true;
            if (o is bool) return !(bool)o;
            string s = Convert.ToString(o, CultureInfo.InvariantCulture);
            return s == "" || s == "0" || s == "false";
        }

        /// <summary>
        /// private checkInput($what) — валидация предметов по типу сервер_shop_items.
        /// Возвращает {"allowed":{...}, "disallowed":{...}} (ключи — как в PHP, см.
        /// замечания про фиктивные ключи heavy_guns/extras).
        /// </summary>
        private Dictionary<string, Dictionary<string, object>> CheckInput(string what)
        {
            var re = new Dictionary<string, Dictionary<string, object>>
            {
                { "disallowed", new Dictionary<string, object>() },
                { "allowed", new Dictionary<string, object>() },
            };
            var items = PItems(); // params->from->items
            if (what == "heavy_guns")
            {
                foreach (var kv in items)
                {
                    var result = Query(@"SELECT * FROM server_1_player_all_items
                                         INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId
                                         WHERE server_shop_items.type=1 && server_1_player_all_items.id = @id",
                                       Kv("@id", kv.Value));
                    if (result.Count > 0) re["allowed"]["heavy_guns"] = kv.Value; // баг оригинала: фиктивный ключ
                    else re["disallowed"][kv.Key] = kv.Value;
                }
            }
            else if (what == "lasers")
            {
                foreach (var kv in items)
                {
                    var result = Query(@"SELECT * FROM server_1_player_all_items
                                         INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId
                                         WHERE server_shop_items.type=0 && server_1_player_all_items.id = @id",
                                       Kv("@id", kv.Value));
                    if (result.Count > 0) re["allowed"][kv.Key] = kv.Value;
                    else re["disallowed"][kv.Key] = kv.Value;
                }
            }
            else if (what == "generators")
            {
                foreach (var kv in items)
                {
                    var result = Query(@"SELECT * FROM server_1_player_all_items
                                         INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId
                                         WHERE server_1_player_all_items.id = @id AND (server_shop_items.type=3 OR server_shop_items.type=4)",
                                       Kv("@id", kv.Value));
                    if (result.Count > 0) re["allowed"][kv.Key] = kv.Value;
                    else re["disallowed"][kv.Key] = kv.Value;
                }
            }
            else if (what == "extras")
            {
                foreach (var kv in items)
                {
                    var result = Query(@"SELECT * FROM server_1_player_all_items
                                         INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId
                                         WHERE server_1_player_all_items.id = @id AND (server_shop_items.type=7 OR server_shop_items.type=8 OR server_shop_items.type=9 OR server_shop_items.type=10 OR server_shop_items.type=11)",
                                       Kv("@id", kv.Value));
                    if (result.Count > 0) re["allowed"][GetStr(result[0], "lootId")] = kv.Value;
                    else re["disallowed"][kv.Key] = kv.Value;
                }
            }
            else
            {
                foreach (var kv in items) re["disallowed"][kv.Key] = kv.Value;
            }
            return re;
        }

        /// <summary>params-&gt;from-&gt;items как упорядоченные пары (ключ=>значение).</summary>
        private List<KeyValuePair<string, object>> PItems()
        {
            var res = new List<KeyValuePair<string, object>>();
            var from = PGet("from") as IDictionary<string, object>;
            object itemsObj;
            if (from == null || !from.TryGetValue("items", out itemsObj) || itemsObj == null) return res;
            var dict = itemsObj as IDictionary<string, object>;
            if (dict != null)
            {
                foreach (var kv in dict) res.Add(new KeyValuePair<string, object>(kv.Key, kv.Value));
                return res;
            }
            var list = itemsObj as System.Collections.IEnumerable;
            if (list != null)
            {
                int i = 0;
                foreach (var v in list) res.Add(new KeyValuePair<string, object>(i.ToString(CultureInfo.InvariantCulture), v));
            }
            return res;
        }

        /// <summary>
        /// private extrasExits() — незавершённый метод оригинала («KAN IKKE HUSKE...»):
        /// перезагружает init(), собирает lootIds экипированных предметов и ничего не
        /// возвращает. Портирован как no-op с сохранением побочного эффекта init().
        /// </summary>
        private void ExtrasExits()
        {
            // PHP: $this->equipment = self::init(); — там init() возвращает массив, а
            // последующие $this->equipment->... в незавершённом методе оригинала всё равно
            // не используются (мёртвый код после цикла). Здесь сохраняем только побочный
            // эффект перезагрузки _json.
            Init();
            // conf/hi/extras в оригинале вычисляются и выбрасываются — сохранено как комментарий:
            // var conf = PT("to", "configId"); var hi = PP("hi");
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

        /// <summary>params-&gt;$key1-&gt;$key2 (вложенный объект) как строка ('' если нет).</summary>
        private string PT(string key1, string key2)
        {
            var inner = PGet(key1) as IDictionary<string, object>;
            object o;
            return inner != null && inner.TryGetValue(key2, out o) && o != null
                ? Convert.ToString(o, CultureInfo.InvariantCulture) : "";
        }

        /// <summary>params-&gt;$key1-&gt;$key2 (вложенный объект) как raw value.</summary>
        private object PGetNested(string key1, string key2)
        {
            var inner = PGet(key1) as IDictionary<string, object>;
            object o;
            return inner != null && inner.TryGetValue(key2, out o) ? o : null;
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
        // A3.4 CPU-слоты/полнота проверки (Class.inventory.php, строки 516–1014) —
        // ядро equip-логики Dock: cpuSlots, fullSystemCheck, shipspace,
        // NotEmptyDrone, EmptyDrone, NotEmptyShip, EmptyShip, checkExtrasService.
        //
        // Структуры данных: PHP работает с объектами из $_SESSION['EQ']
        // (result of init(), json_decode без assoc). Здесь _equipment —
        // Dictionary<string,object>-дерево EqJson(Init()); доступ — классом Eq
        // (dyn == null ⇔ PHP null; отсутствующий ключ == undefined property:
        // null/'', foreach по null — пустой цикл как в PHP).
        //
        // PHP-замечания, сохранённые при переносе:
        //  - cpuSlots(): возвращает 2/4/6/10 только если первый найденный extras-id
        //    ∈ cpu-карты; иначе 0 (в т.ч. неявный null когда слот не найден → null,
        //    но вызывается только после != null).
        //  - fullSystemCheck(): $s вычисляется и не используется в drone-ветке;
        //    extrasExits() вызывается ради побочного эффекта (результат null, if(!..)
        //    проглатывается — return закомментирован в оригинале); в ship-ветке при
        //    execute()-ошибке возвращается FALSE до проверок extras.
        //  - shipspace(): переменные $L/$lo/$totalSlots в PHP не инициализированы —
        //    при отсутствии совпадений notice + null; здесь default 0/null.
        //  - NotEmptyDrone()/NotEmptyShip()/EmptyShip(): «if ($k >= $e): ... elseif
        //    ($k < $e):» — синтаксис альтернативного if; при ложном обоих условий
        //    функция возвращает null (editDB отдаёт его наружу). Сохранено (null).
        //  - array_diff($pos, $pie) — по ЗНАЧЕНИЯМ; реализовано ArrayDiffValues
        //    (строковое представление, как PHP-конвертация int|string).
        //  - in_array($x, $rules['allowed']) — by-value против assoc-массива
        //    allowed (значения id); AllowedContains сохраняет это (включая баг
        //    heavy_guns с фиктивным ключом 'heavy_guns' из checkInput).
        //  - $this->s (неинициализированное поле в CPU-ветке editDB) → 0 в C# так же,
        //    как unset → null → 0 в арифметике PHP.
        // ------------------------------------------------------------------

        /// <summary>private cpuSlots($equipment, $target) — ёмкость CPU-слотов (2/4/6/10/0).</summary>
        private long CpuSlots(Eq eq, string target)
        {
            var cpu = new Dictionary<string, string>(); // itemId => lootId (cpu_sle)
            foreach (var vr in eq.Ret("items"))
            {
                string lid = eq.LootId(vr);
                if (lid != null && lid.Contains("equipment_extra_cpu_sle-0"))
                {
                    cpu[Str(vr["I"])] = lid;
                }
            }
            foreach (var hangs in eq.Ret("hangars"))
            {
                if (Str(hangs["hangarID"]) == Str(PP("hi")))
                {
                    var extras = hangs.Path("config", PT("to", "configId"), "ship", "EQ", "extras");
                    if (extras != null && extras.Count > 0)
                    {
                        foreach (var vp in extras.Items)
                        {
                            string s = Str(vp);
                            string c;
                            if (cpu.TryGetValue(s, out c))
                            {
                                if (c == "equipment_extra_cpu_sle-01") return 2;
                                else if (c == "equipment_extra_cpu_sle-02") return 4;
                                else if (c == "equipment_extra_cpu_sle-03") return 6;
                                else if (c == "equipment_extra_cpu_sle-04") return 10;
                                else return 0;
                            }
                        }
                    }
                }
            }
            return 0; // PHP: неявный null; вызывается только когда результат != null
        }

        /// <summary>private fullSystemCheck($what, $target, $equipment) — хватает ли места в целевом слотсете.</summary>
        private bool FullSystemCheck(string what, string target, Eq eq)
        {
            _s = ShipSpace(what, target, eq, null); // $s — вычисляется и не используется (как в PHP)
            if (target == "drones")
            {
                object id;
                var from = PGet("from") as IDictionary<string, object>;
                object droneItems;
                if (from != null && from.TryGetValue("droneItems", out droneItems) && !IsEmpty(droneItems))
                {
                    id = FirstKeyOf(droneItems); // key(get_object_vars(...))
                }
                else
                {
                    id = PGetNested("to", "droneId");
                }
                AssertColumn(target, AllowedTargets, "target");
                AssertColumn(what, AllowedWhatColumnsExt, "what");
                var result = Query("SELECT " + what + " FROM server_1_hangar_config_" + target +
                                  " WHERE playerID=@playerID && hangarID=@hangarID && item_id=@item_id",
                                  Kv("@playerID", _pid), Kv("@hangarID", PLong(PP("hi"))), Kv("@item_id", id));
                if (result.Count == 0) return false; // PHP: !empty($result[0][$what]) на пустом select → error
                string val = GetStr(result[0], what);
                if (val != "")
                {
                    if (val.Contains("|")) return false;
                    if (what == "design" || what == "design2") return false;
                    return true;
                }
                return true;
            }
            else
            {
                AssertColumn(target, AllowedTargets, "target");
                AssertColumn(what, AllowedWhatColumnsExt, "what");
                var result = Query("SELECT " + what + " FROM server_1_hangar_config_" + target +
                                   " WHERE playerID=@playerID && hangarID=@hangarID && configNum=@configNum",
                                   Kv("@playerID", _pid), Kv("@hangarID", PLong(PP("hi"))),
                                   Kv("@configNum", PGetNested("to", "configId")));
                if (result.Count == 0) return false;
                long o;
                string val = GetStr(result[0], what);
                if (val != "")
                {
                    if (val.Contains("|")) o = val.Split('|').Length;
                    else o = 1;
                }
                else return true;

                if (what == "extras")
                {
                    ExtrasExits(); // if (!self::extrasExits()) {} — return закомментирован в оригинале
                }
                long s = _s = ShipSpace(what, target, eq, null);
                if (o < s)
                {
                    if (what == "extras")
                    {
                        foreach (var ve in eq.Ret("items"))
                        {
                            foreach (var iy in PFromItems())
                            {
                                if (Str(ve["I"]) == Str(iy.Value))
                                {
                                    string lid = eq.LootId(ve);
                                    if (lid == "equipment_extra_cpu_sle-04" || lid == "equipment_extra_cpu_sle-03" ||
                                        lid == "equipment_extra_cpu_sle-02" || lid == "equipment_extra_cpu_sle-01")
                                    {
                                        return false;
                                    }
                                    return true;
                                }
                            }
                        }
                        return false; // PHP: циклы не прошли ни разу → неявный null → falsy
                    }
                    return true;
                }
                return false;
            }
        }

        private static readonly HashSet<string> AllowedWhatColumnsExt =
            new HashSet<string>(AllowedWhatColumns.Concat(new[] { "default", "SM" }));

        /// <summary>private shipspace($what, $target, $equipment, $drone_id = NULL) — вместимость слотсета.</summary>
        private long ShipSpace(string what, string target, Eq eq, object droneId)
        {
            if (target == "drones")
            {
                object id;
                if (droneId == null || !IsEmpty(droneId))
                {
                    var from = PGet("from") as IDictionary<string, object>;
                    object droneItems;
                    if (from != null && from.TryGetValue("droneItems", out droneItems) && !IsEmpty(droneItems))
                    {
                        id = FirstKeyOf(droneItems);
                    }
                    else
                    {
                        id = PGetNested("to", "droneId");
                    }
                }
                else
                {
                    id = droneId;
                }
                object lo = null;
                var hay = eq.General(target); // hangars[0]->general->{$target}
                if (hay != null)
                {
                    foreach (var va in hay.Items)
                    {
                        if (Str(va["I"]) == Str(id)) lo = va["L"];
                    }
                }
                var where = eq.Ret("itemInfo");
                long totalSlots = 0;
                string j = what == "design" ? what : "default";
                foreach (var va in where)
                {
                    if (Str(va["L"]) == Str(lo))
                    {
                        totalSlots = ParseLong(Str(va.Path("levels", "0", "slotsets", j, "Q")));
                    }
                }
                return totalSlots;
            }
            else if (target == "pet10")
            {
                var pet = eq.General("pet"); // hangars[0]->general->pet
                object L = pet != null ? pet["L"] : null;
                long lv = ParseLong(Str(pet != null ? pet["LV"] : null));
                long lc = ParseLong(Str(pet != null ? pet.Path("lockedSlots", what) : null));
                var where = eq.Ret("itemInfo");
                long totalSlots = 0;
                foreach (var va in where)
                {
                    if (Str(va["L"]) == Str(L))
                    {
                        totalSlots = ParseLong(Str(va.Path("levels", lv.ToString(CultureInfo.InvariantCulture), "slotsets", what, "Q")));
                    }
                }
                return totalSlots - lc;
            }
            else
            {
                var gen = eq.General(target); // hangars[0]->general->{$target}
                string sm = Str(gen != null ? gen["SM"] : null);
                object lo = null;
                var lids = eq.MapLootIds(); // map.lootIds (php-ассoc массив)
                if (lids != null)
                {
                    foreach (var kv in lids.D)
                        if (Str(kv.Value) == sm) { lo = kv.Key; break; } // array_keys(...)[0]
                }
                var where = eq.Ret("itemInfo");
                long totalSlots = 0;
                foreach (var va in where)
                {
                    if (Str(va["L"]) == Str(lo))
                    {
                        totalSlots = ParseLong(Str(va.Path("levels", "0", "slotsets", what, "Q")));
                    }
                }
                if (what == "extras")
                {
                    return totalSlots + CpuSlots(eq, target);
                }
                return totalSlots;
            }
        }

        /// <summary>private NotEmptyDrone(...) — дроновый слотсет уже занят.</summary>
        private string NotEmptyDrone(List<Dictionary<string, string>> result, string what, string target, Eq eq)
        {
            long s = _s = ShipSpace(what, target, eq, null);
            var pos = PFromItemsValues();
            string cur = result.Count > 0 ? GetStr(result[0], what) : "";
            if (cur.Contains("|"))
            {
                return ErrorTrans("Do NOT cheat!"); // второй return в оригинале недостижим
            }
            var pie = SplitPipe(cur);
            long k = pos.Count;
            long r = s - 1;
            if (k >= r)
            {
                for (long i = 0; i < r; i++) pie.Add(GetByIndex(PFromItems(), i));
                AddToDb(pie, target, what, null);
                var ms = ArrayDiffValues(pos, pie);
                return CompleteTrans(ms, k == 1 ? 1 : 2);
            }
            else if (k < r)
            {
                for (long i = 0; i < k; i++) pie.Add(GetByIndex(PFromItems(), i));
                AddToDb(pie, target, what, null);
                var ms = ArrayDiffValues(pos, pie);
                return CompleteTrans(ms, 1);
            }
            return null; // PHP: оба условия ложны → неявный null
        }

        /// <summary>private EmptyDrone(...) — свободный дроновый слотсет.</summary>
        private string EmptyDrone(string what, string target, Eq eq)
        {
            var pos = PFromItemsValues();
            long s = _s = ShipSpace(what, target, eq, null);
            var pie = new List<object>();
            long k = pos.Count;
            if (k >= s)
            {
                for (long i = 0; i < s; i++) pie.Add(GetByIndex(PFromItems(), i));
                AddToDb(pie, target, what, null);
                return CompleteTrans(ArrayDiffValues(pos, pie), 2);
            }
            else if (k < s)
            {
                for (long i = 0; i < k; i++) pie.Add(GetByIndex(PFromItems(), i));
                AddToDb(pie, target, what, null);
                return CompleteTrans(ArrayDiffValues(pos, pie), 1);
            }
            return null;
        }

        /// <summary>private NotEmptyShip(...) — заполненный ship/pet слотсет (главная equip-логика).</summary>
        private string NotEmptyShip(List<Dictionary<string, string>> result, string what, string target, Eq eq)
        {
            Dictionary<string, Dictionary<string, object>> rules;
            List<object> pos;
            long k;
            if (what == "extras")
            {
                rules = CheckInput(what);
                pos = CheckExtrasService();
                k = pos.Count;
            }
            else
            {
                rules = CheckInput(what);
                pos = PFromItemsValues();
                k = pos.Count;
            }
            long s = _s = ShipSpace(what, target, eq, null);
            var items = PFromItems();
            string cur = result.Count > 0 ? GetStr(result[0], what) : "";
            if (cur.Contains("|"))
            {
                var pie = SplitPipe(cur);
                long c = pie.Count;
                long e = s - c;
                k = items.Count;
                if (k >= e)
                {
                    for (long i = 0; i < e; i++) PushIfAllowed(pie, what, rules, pos, items, i);
                    AddToDb(pie, target, what, null);
                    var ms = DiffFor(what, items, pie);
                    return CompleteTrans(ms, k == 1 ? 1 : 2);
                }
                else if (k < e)
                {
                    for (long i = 0; i < k; i++) PushIfAllowed(pie, what, rules, pos, items, i);
                    AddToDb(pie, target, what, null);
                    return CompleteTrans(DiffFor(what, items, pie), 1);
                }
                return null;
            }
            else
            {
                var pie = SplitPipe(cur);
                k = items.Count;
                long r = s - 1;
                if (k >= r)
                {
                    for (long i = 0; i < r; i++) PushIfAllowed(pie, what, rules, pos, items, i);
                    AddToDb(pie, target, what, null);
                    if (k == 1)
                    {
                        return CompleteTrans(DiffFor(what, items, pie), 1);
                    }
                    else if (what == "heavy_guns")
                    {
                        return CompleteTrans(pie, 1);
                    }
                    // PHP: ветка без return → неявный null
                    return null;
                }
                else if (k < r)
                {
                    for (long i = 0; i < k; i++) PushIfAllowed(pie, what, rules, pos, items, i);
                    AddToDb(pie, target, what, null);
                    if (what == "extras")
                    {
                        return CompleteTrans(ArrayDiffValues(items.Select(x => x.Value).ToList(), pie), 2);
                    }
                    return CompleteTrans(ArrayDiffValues(pos, pie), 1);
                }
                return null;
            }
        }

        /// <summary>private EmptyShip(...) — свободный ship/pet слотсет.</summary>
        private string EmptyShip(string what, string target, Eq eq)
        {
            Dictionary<string, Dictionary<string, object>> rules;
            List<object> pos;
            long k;
            if (what == "extras")
            {
                rules = CheckInput(what);
                pos = CheckExtrasService();
                k = pos.Count;
            }
            else
            {
                rules = CheckInput(what);
                pos = PFromItemsValues();
                k = pos.Count;
            }
            long s = _s = ShipSpace(what, target, eq, null);
            var pie = new List<object>();
            var items = PFromItems();
            if (k >= s)
            {
                for (long i = 0; i < s; i++) PushIfAllowed(pie, what, rules, pos, items, i);
                AddToDb(pie, target, what, null);
                if (what == "heavy_guns")
                {
                    return CompleteTrans(ArrayDiffValues(pos, pie), 1);
                }
                if (what == "extras")
                {
                    return CompleteTrans(ArrayDiffValues(items.Select(x => x.Value).ToList(), pie), 2);
                }
                return CompleteTrans(ArrayDiffValues(pos, pie), 2);
            }
            else if (k < s)
            {
                for (long i = 0; i < k; i++) PushIfAllowed(pie, what, rules, pos, items, i);
                AddToDb(pie, target, what, null);
                if (what == "extras")
                {
                    return CompleteTrans(ArrayDiffValues(items.Select(x => x.Value).ToList(), pie), 2);
                }
                return CompleteTrans(ArrayDiffValues(pos, pie), 1);
            }
            return null;
        }

        /// <summary>private checkExtrasService() — дедупликация from-items по lootid (первые wins).</summary>
        private List<object> CheckExtrasService()
        {
            var argsAll = new Dictionary<string, object>(); // lootid => itemId
            foreach (var kv in PFromItems())
            {
                var result = Query("SELECT * FROM server_1_player_all_items WHERE playerID=@playerID && id=@id",
                                   Kv("@playerID", _pid), Kv("@id", kv.Value));
                if (result.Count > 0)
                {
                    string lootid = GetStr(result[0], "lootid");
                    if (!argsAll.ContainsKey(lootid)) argsAll[lootid] = kv.Value;
                }
            }
            return argsAll.Values.ToList();
        }

        // helpers A3.4 ------------------------------------------------------------

        /// <summary>params-&gt;from-&gt;items как упорядоченные пары (ключ=>значение).</summary>
        private List<KeyValuePair<string, object>> PFromItems()
        {
            var res = new List<KeyValuePair<string, object>>();
            var from = PGet("from") as IDictionary<string, object>;
            object itemsObj;
            if (from == null || !from.TryGetValue("items", out itemsObj) || itemsObj == null) return res;
            var dict = itemsObj as IDictionary<string, object>;
            if (dict != null)
            {
                foreach (var kv in dict) res.Add(new KeyValuePair<string, object>(kv.Key, kv.Value));
                return res;
            }
            var list = itemsObj as System.Collections.IEnumerable;
            if (list != null)
            {
                int i = 0;
                foreach (var v in list) res.Add(new KeyValuePair<string, object>(i.ToString(CultureInfo.InvariantCulture), v));
            }
            return res;
        }

        private List<object> PFromItemsValues()
        {
            return PFromItems().Select(x => x.Value).ToList();
        }

        /// <summary>$this-&gt;params-&gt;from-&gt;items[$i] (по числовому индексу как в PHP).</summary>
        private object GetByIndex(List<KeyValuePair<string, object>> items, long i)
        {
            string key = i.ToString(CultureInfo.InvariantCulture);
            foreach (var kv in items) if (kv.Key == key) return kv.Value;
            return null; // PHP: undefined index → notice + null
        }

        /// <summary>array_diff по значениям (строковое представление, PHP int|string-конверсии).</summary>
        private static List<object> ArrayDiffValues(List<object> a, List<object> b)
        {
            var setB = new HashSet<string>(b.Select(Str));
            return a.Where(x => !setB.Contains(Str(x))).ToList();
        }

        /// <summary>explode("|", $x): '' → [""] как в PHP.</summary>
        private static List<object> SplitPipe(string x)
        {
            var l = new List<object>();
            foreach (var p in (x ?? "").Split('|')) l.Add(p);
            return l;
        }

        /// <summary>in_array($v, $rules['allowed']) — by-value против значений assoc-массива.</summary>
        private static bool AllowedContains(Dictionary<string, object> allowed, object v)
        {
            string s = Str(v);
            return allowed != null && allowed.Values.Any(x => Str(x) == s);
        }

        /// <summary>Тело «for»-пуша из NotEmptyShip/EmptyShip (сохранены баги heavy_guns/extras).</summary>
        private void PushIfAllowed(List<object> pie, string what,
            Dictionary<string, Dictionary<string, object>> rules, List<object> pos,
            List<KeyValuePair<string, object>> items, long i)
        {
            if (what == "extras")
            {
                var p = GetByIndex(items.Select(x => new KeyValuePair<string, object>(x.Key, x.Value)).ToList(), i);
                // $pos[$i] — позиционный доступ к списку checkExtrasService
                object pi = i < pos.Count ? pos[(int)i] : null;
                if (AllowedContains(rules["allowed"], pi)) pie.Add(pi);
            }
            else if (what == "heavy_guns")
            {
                object hg;
                if (rules["allowed"].TryGetValue("heavy_guns", out hg)) pie.Add(hg); // фиктивный ключ из checkInput
            }
            else
            {
                var it = GetByIndex(items, i);
                if (AllowedContains(rules["allowed"], it)) pie.Add(it);
            }
        }

        /// <summary>$ms для CompleteTrans: extras сравнивает from-items, остальное — $pos.</summary>
        private List<object> DiffFor(string what, List<KeyValuePair<string, object>> items, List<object> pie)
        {
            // для both branches identical when pos == items values
            return ArrayDiffValues(items.Select(x => x.Value).ToList(), pie);
        }

        /// <summary>PHP array-коэрция: значение → List&lt;object&gt; (JSON-массив из _submitParams).</summary>
        private static List<object> ToObjectList(object o)
        {
            var r = new List<object>();
            if (o == null) return r;
            var lst = o as List<object>;
            if (lst != null) return lst;
            var dict = o as IDictionary<string, object>;
            if (dict != null) { foreach (var v in dict.Values) r.Add(v); return r; }
            var en = o as System.Collections.IEnumerable;
            if (en != null && !(o is string)) { foreach (var v in en) r.Add(v); return r; }
            r.Add(o);
            return r;
        }

        private static string Str(object o)
        {
            return o == null ? "" : Convert.ToString(o, CultureInfo.InvariantCulture);
        }

        /// <summary>key(get_object_vars($obj)) — первый ключ словаря/списка.</summary>
        private static object FirstKeyOf(object o)
        {
            var d = o as IDictionary<string, object>;
            if (d != null)
            {
                foreach (var k in d.Keys) return k;
                return null;
            }
            return "0"; // JSON-массив: get_object_vars даёт {"0":...}
        }

        // ------------------------------------------------------------------
        // A3.5 Конфиги (Class.inventory.php, строки 1015–1534): editDB, editJson,
        // checkInConfig, ifExistsPet/ifExistsDrone/GetPet, shipconfigsGenerator,
        // droneconfigsGenerator, petconfigsGenerator.
        // ------------------------------------------------------------------

        /// <summary>private editDB($equipment) — главный обработчик drag&amp;drop-экипировки Dock.</summary>
        private string EditDb(Eq eq)
        {
            if (_droneEquip)
            {
                string target = PT("to", "target") + "s";
                string what;
                if (PT("to", "configId") == "1")
                    what = PT("to", "slotset") == "design" ? "design" : "EQ";
                else
                    what = PT("to", "slotset") == "design" ? "design2" : "EQ2";

                var repeat = PGetNested("from", "droneItems") as IDictionary<string, object>;
                var unique = new List<KeyValuePair<string, List<object>>>();
                var seen = new HashSet<string>();
                if (repeat != null)
                {
                    foreach (var kv in repeat)
                    {
                        var lst = ToObjectList(kv.Value);
                        string sig = string.Join("\u0001", lst.Select(Str));
                        if (seen.Add(sig)) unique.Add(new KeyValuePair<string, List<object>>(kv.Key, lst));
                    }
                }
                foreach (var entry in unique)
                {
                    _s = ShipSpace(what, target, eq, entry.Key); // $this->s в оригинале присваивается ($s = self::shipspace(...))
                    AssertColumn(target, AllowedTargets, "target");
                    AssertColumn(what, AllowedWhatColumnsExt, "what");
                    var result = Query("SELECT " + what + " FROM server_1_hangar_config_" + target +
                                       " WHERE playerID=@playerID && hangarID=@hangarID && item_id=@item_id",
                                       Kv("@playerID", _pid), Kv("@hangarID", PLong(PP("hi"))),
                                       Kv("@item_id", entry.Key));
                    if (result.Count == 0) return ErrorTrans("Something went wrong!");
                    var value = entry.Value;
                    string cur = GetStr(result[0], what);
                    if (cur != "") value.Add(cur);
                    AddToDb(value, target, what, entry.Key);
                }
                return CompleteTrans(null, 1);
            }
            else
            {
                // $moved = array(); — в оригинале не используется
                if (PT("from", "target") == "inventory")
                {
                    string target, what, mode; // mode: "item_id" | "configNum"
                    if (PT("to", "target") == "pet")
                    {
                        target = PT("to", "target") + "10";
                        what = PT("to", "slotset");
                        mode = "configNum";
                    }
                    else if (PT("to", "target") == "drone")
                    {
                        target = PT("to", "target") + "s";
                        if (PT("to", "configId") == "1")
                            what = PT("to", "slotset") == "design" ? "design" : "EQ";
                        else
                            what = PT("to", "slotset") == "design" ? "design2" : "EQ2";
                        mode = "item_id";
                    }
                    else
                    {
                        target = PT("to", "target");
                        what = PT("to", "slotset");
                        mode = "configNum";
                    }
                    AssertColumn(target, AllowedTargets, "target");
                    AssertColumn(what, AllowedWhatColumnsExt, "what");
                    string sqli = "SELECT " + what + " FROM server_1_hangar_config_" + target +
                                  " WHERE playerID=@playerID && hangarID=@hangarID && " +
                                  (mode == "item_id" ? "item_id=@sel" : "configNum=@sel");
                    object selVal = mode == "item_id" ? PGetNested("to", "droneId") : PGetNested("to", "configId");

                    if (what == "") // PHP: $what == null (slotset отсутствует в json)
                        return ErrorTrans("You are not able to fit it into that " + target + "");

                    if (!FullSystemCheck(what, target, eq))
                        return ErrorTrans("You are not able to fit it into that " + target + "");

                    var result = Query(sqli, Kv("@playerID", _pid), Kv("@hangarID", PLong(PP("hi"))), Kv("@sel", selVal));
                    bool nonEmpty = result.Count > 0 && GetStr(result[0], what) != "";
                    if (target == "drones")
                    {
                        if (nonEmpty) return NotEmptyDrone(result, what, target, eq);
                        return EmptyDrone(what, target, eq);
                        // PHP: «fit into that slot» ниже — недостижимо
                    }
                    else
                    {
                        if (nonEmpty) return NotEmptyShip(result, what, target, eq);
                        return EmptyShip(what, target, eq);
                    }
                }
                else
                {
                    // Снятие предмета (from = ship/drone/pet). В PHP при провале всех
                    // внутренних условий функция завершается с неянным null.
                    string target, what, mode;
                    if (PT("from", "target") == "pet")
                    {
                        target = PT("from", "target") + "10";
                        what = PT("from", "slotset");
                        mode = "configNum";
                    }
                    else if (PT("from", "target") == "drone")
                    {
                        target = PT("from", "target") + "s";
                        if (PT("from", "configId") == "1")
                            what = PT("from", "slotset") == "design" ? "design" : "EQ";
                        else
                            what = PT("from", "slotset") == "design" ? "design2" : "EQ2";
                        mode = "item_id";
                    }
                    else
                    {
                        target = PT("from", "target");
                        what = PT("from", "slotset");
                        mode = "configNum";
                    }
                    AssertColumn(target, AllowedTargets, "target");
                    AssertColumn(what, AllowedWhatColumnsExt, "what");
                    string sqli = "SELECT " + what + " FROM server_1_hangar_config_" + target +
                                  " WHERE playerID=@playerID && hangarID=@hangarID && " +
                                  (mode == "item_id" ? "item_id=@sel" : "configNum=@sel");
                    object selVal = mode == "item_id" ? PGetNested("from", "droneId") : PGetNested("from", "configId");

                    var result = Query(sqli, Kv("@playerID", _pid), Kv("@hangarID", PLong(PP("hi"))), Kv("@sel", selVal));
                    if (result.Count > 0)
                    {
                        string cur = GetStr(result[0], what);
                        if (cur != "")
                        {
                            var items = PFromItems();
                            if (cur.Contains("|"))
                            {
                                var pie = SplitPipe(cur);
                                foreach (var l in items.Select(x => x.Value))
                                    pie = ArrayDiffValues(pie, new List<object> { l });
                                foreach (var ve in eq.Ret("items"))
                                {
                                    foreach (var iy in items)
                                    {
                                        if (Str(ve["I"]) == Str(iy.Value))
                                        {
                                            string lid = eq.LootId(ve);
                                            if (lid == "equipment_extra_cpu_sle-04" || lid == "equipment_extra_cpu_sle-03" ||
                                                lid == "equipment_extra_cpu_sle-02" || lid == "equipment_extra_cpu_sle-01")
                                            {
                                                // $this->s не инициализировано (PHP: null → 0)
                                                var left = new List<object>();
                                                for (long n = 0; n < SCount; n++)
                                                    left.Add(PieAt(pie, n)); // undefined index → null
                                                pie = ArrayDiffValues(pie, left);
                                                pie.Add(iy.Value);
                                                _cpuFilled = false;
                                                DelFromDb(left, target, what);
                                                return CompleteTrans(pie, 1, 1);
                                            }
                                            else
                                            {
                                                DelFromDb(pie, target, what);
                                                return CompleteTrans(null, 1);
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                var pie = new List<object> { "" };
                                foreach (var ve in eq.Ret("items"))
                                {
                                    foreach (var iy in items)
                                    {
                                        if (Str(ve["I"]) == Str(iy.Value))
                                        {
                                            string lid = eq.LootId(ve);
                                            if (lid == "equipment_extra_cpu_sle-04" || lid == "equipment_extra_cpu_sle-03" ||
                                                lid == "equipment_extra_cpu_sle-02" || lid == "equipment_extra_cpu_sle-01")
                                            {
                                                _cpuFilled = false;
                                                DelFromDb(pie, target, what);
                                                return CompleteTrans(new List<object> { iy.Value }, 1, 1);
                                            }
                                            else
                                            {
                                                DelFromDb(pie, target, what);
                                                return CompleteTrans(null, 1);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    return null; // PHP: неявное завервление метода → null
                }
            }
        }

        private object PieAt(List<object> pie, long n)
        {
            string key = n.ToString(CultureInfo.InvariantCulture);
            for (int i = 0; i < pie.Count; i++)
                if (((long)i).ToString(CultureInfo.InvariantCulture) == key) return pie[i];
            return null;
        }

        /// <summary>public editJson() — точка входа equip-транзакции (экипировка берётся из сессии).</summary>
        public string EditJson(HttpSessionState session)
        {
            GC.KeepAlive(_copyright); // no-op guard оригинала
            // PHP: if (isset($this->equipment) && !empty($this->equipment)) {} else { $this->equipment = $_SESSION['EQ']; }
            // В реальном рантайме flashAPI/inventory.php на action=move НЕ вызывает init(),
            // поэтому _equipment всегда пуст → берём base64(JSON) из $_SESSION['EQ'].
            var eqWrap = _equipment as Eq;
            if (eqWrap == null || eqWrap.Dyn == null)
            {
                var sessionEq = session != null ? session["EQ"] as string : null;
                eqWrap = sessionEq != null ? Eq.FromBase64Json(sessionEq) : new Eq(null);
                _equipment = eqWrap;
            }
            return CheckInConfig(eqWrap);
        }

        /// <summary>private checkInConfig() — запрет экипировки предмета, уже стоящего в целевой раскладке.</summary>
        private string CheckInConfig(Eq eq)
        {
            if (PT("from", "target") == "inventory")
            {
                var droneItems = PGetNested("from", "droneItems");
                if (droneItems != null && !IsEmpty(droneItems))
                {
                    return EditDb(eq);
                }
                string target, what;
                if (PT("to", "target") == "drone") { target = PT("to", "target") + "s"; what = "default"; }
                else if (PT("to", "target") == "ship") { target = PT("to", "target"); what = PT("to", "slotset"); }
                else { target = PT("to", "target"); what = PT("to", "slotset"); }

                var needle = PFromItemsValues();
                string conf = PT("to", "configId");
                var args = eq.HangarArgs(conf, target); // hangars[0]->config->{$conf}->{$target}
                if (args != null)
                {
                    foreach (var val in args.Items)
                    {
                        var eqList = val.Path("EQ", what);
                        if (eqList != null && eqList.Count > 0)
                        {
                            var inter = eqList.Items
                                .Select(x => Str(x))
                                .Intersect(needle.Select(Str))
                                .ToList();
                            if (inter.Count > 0) return ErrorTrans("You can not equip that!");
                        }
                    }
                }
                return EditDb(eq);
            }
            return EditDb(eq);
        }

        /// <summary>private ifExistsPet($pet) — {id, lootid} предмета-пета у игрока, иначе null.</summary>
        private Dictionary<string, string> IfExistsPet(string pet)
        {
            var rows = Query("SELECT `id`, `lootid` FROM `server_1_player_all_items` WHERE `lootid`=@lootid && `playerID`= @playerID",
                             Kv("@playerID", _pid), Kv("@lootid", pet));
            return rows.Count > 0 ? rows[0] : null;
        }

        /// <summary>private ifExistsDrone() — все дроны игрока (4 известных lootid), иначе null.</summary>
        private List<Dictionary<string, string>> IfExistsDrone()
        {
            var rows = Query("SELECT `id`, `lootid` FROM `server_1_player_all_items` WHERE `lootid`=@lootid1 OR `lootid`=@lootid2 OR `lootid`=@lootid3 OR `lootid`=@lootid4 && `playerID`= @playerID",
                             Kv("@playerID", _pid), Kv("@lootid1", "drone_iris"), Kv("@lootid2", "drone_flax"),
                             Kv("@lootid3", "drone_apis"), Kv("@lootid4", "drone_zeus"));
            return rows.Count > 0 ? rows : null;
        }

        /// <summary>private GetPet($petId) — состояние пета (hp/lv/name/loot-level/lockedSlots).</summary>
        private Eq GetPetRow(Dictionary<string, string> petId)
        {
            var result = Query("SELECT * FROM `server_1_player_pet10` WHERE `playerID`= @playerID && `item_id`=@itemid",
                               Kv("@playerID", _pid), Kv("@itemid", petId["id"]));
            if (result.Count == 0) return null;
            var row = result[0];
            _lootids.Add(petId["lootid"]);
            long keying = _lootids.Count - 1; // max(array_keys(lootids)) — php-ассоциативные ключи 0..n-1
            var pet = new Dictionary<string, object>
            {
                { "I", petId["id"] },
                { "HP", GetStr(row, "pet_hp") },
                { "LV", ParseLong(GetStr(row, "pet_level")) },
                { "PN", GetStr(row, "pet_name") },
                { "L", keying },
                { "lockedSlots", new Dictionary<string, object>
                    {
                        { "lasers", ParseLong(Slot(row, "lockedSlots", 0)) },
                        { "generators", ParseLong(Slot(row, "lockedSlots", 1)) },
                        { "gears", ParseLong(Slot(row, "lockedSlots", 2)) },
                        { "protocols", ParseLong(Slot(row, "lockedSlots", 3)) },
                    }
                },
            };
            return new Eq(pet);
        }

        private static string Slot(Dictionary<string, string> row, string col, int i)
        {
            var a = (GetStr(row, col)).Split('|');
            return i < a.Length ? a[i] : "";
        }

        /// <summary>private shipconfigsGenerator($hid, $conf) — EQ корабля раскладки (lasers/generators/heavy_guns/extras).</summary>
        private Eq ShipConfigsGenerator(object hid, object conf)
        {
            var result = Query("SELECT * FROM `server_1_hangar_config_ship` WHERE `playerID`= @playerID && `hangarID`=@hangarID && `configNum`=@configNum",
                               Kv("@playerID", _pid), Kv("@hangarID", hid), Kv("@configNum", conf));
            var eqDict = new Dictionary<string, object>();
            var ship = new Dictionary<string, object> { { "EQ", eqDict } };
            foreach (var value in result)
            {
                SplitCol(value, "lasers", eqDict);
                SplitCol(value, "generators", eqDict);
                SplitCol(value, "heavy_guns", eqDict);
                SplitCol(value, "extras", eqDict);
            }
            return new Eq(ship);
        }

        private static void SplitCol(Dictionary<string, string> row, string col, Dictionary<string, object> into)
        {
            string v = GetStr(row, col);
            if (v == "") return; // PHP !empty()
            if (v.Contains("|")) into[col] = v.Split('|').Cast<object>().ToList();
            else into[col] = new List<object> { v };
        }

        // ------------------------------------------------------------------
        // Eq — тонкая обёртка над json-деревом init() (PHP-стиль доступа к
        // объектам из $_SESSION['EQ']): отсутствующий ключ/индекс == null,
        // итерация по null == пустой цикл.
        // ------------------------------------------------------------------
        private sealed class Eq
        {
            public readonly object Dyn;
            public Eq(object dyn) { Dyn = dyn; }

            public static Eq FromBase64Json(string b64)
            {
                try
                {
                    var json = System.Text.Encoding.UTF8.GetString(Convert.FromBase64String(b64));
                    return new Eq(JsonUtil.DecodeObject(json));
                }
                catch (Exception) { return new Eq(null); }
            }

            public Eq this[string key]
            {
                get
                {
                    var d = Dyn as IDictionary<string, object>;
                    object o;
                    return d != null && d.TryGetValue(key, out o) ? new Eq(o) : new Eq(null);
                }
            }

            public Eq Path(params string[] keys)
            {
                var cur = this;
                foreach (var k in keys) cur = cur[k];
                return cur;
            }

            /// <summary>data.ret.$name как список объектов (пусто если null).</summary>
            public List<Eq> Ret(string name)
            {
                var l = ItemsOf(this["data"]["ret"][name]);
                return l;
            }

            public Eq MapLootIds() { return this["data"]["map"]["lootIds"]; }

            /// <summary>PHP-ассоциативное представление узла (пустой словарь если не dict).</summary>
            public IDictionary<string, object> D
            {
                get
                {
                    var d = Dyn as IDictionary<string, object>;
                    return d ?? new Dictionary<string, object>();
                }
            }

            public List<Eq> Items
            {
                get { return ItemsOf(this); }
            }

            /// <summary>hangars[0]-&gt;general-&gt;$target (null если нет).</summary>
            public Eq General(string target)
            {
                var hangs = Ret("hangars");
                if (hangs.Count == 0) return new Eq(null);
                return hangs[0]["general"][target];
            }

            /// <summary>hangars[0]-&gt;config-&gt;$conf-&gt;$target (для checkInConfig).</summary>
            public Eq HangarArgs(string conf, string target)
            {
                var hangs = Ret("hangars");
                if (hangs.Count == 0) return new Eq(null);
                return hangs[0]["config"][conf][target];
            }

            /// <summary>data.map.lootIds[$vr-&gt;L] — PHP $lids[$ve-&gt;L].</summary>
            public string LootId(Eq vr)
            {
                var ids = this["data"]["map"]["lootIds"];
                var d = ids.Dyn as IDictionary<string, object>;
                if (d != null)
                {
                    object o;
                    if (d.TryGetValue(Str(vr["L"].Dyn), out o))
                        return Convert.ToString(o, CultureInfo.InvariantCulture);
                    return null; // PHP undefined index → null
                }
                var l = ids.Dyn as Newtonsoft.Json.Linq.JArray;
                if (l != null)
                {
                    long idx;
                    if (long.TryParse(Str(vr["L"].Dyn), out idx) && idx >= 0 && idx < l.Count)
                        return Convert.ToString((object)l[(int)idx], CultureInfo.InvariantCulture);
                }
                return null;
            }

            private static List<Eq> ItemsOf(Eq e)
            {
                var res = new List<Eq>();
                if (e == null || e.Dyn == null) return res;
                var d = e.Dyn as IDictionary<string, object>;
                if (d != null)
                {
                    foreach (var kv in d) res.Add(new Eq(kv.Value));
                    return res;
                }
                var arr = e.Dyn as Newtonsoft.Json.Linq.JArray;
                if (arr != null)
                {
                    foreach (var t in arr) res.Add(new Eq(t));
                }
                return res;
            }

            public int Count
            {
                get
                {
                    var d = Dyn as IDictionary<string, object>;
                    if (d != null) return d.Count;
                    var arr = Dyn as Newtonsoft.Json.Linq.JArray;
                    if (arr != null) return arr.Count;
                    return 0;
                }
            }
        }

        // ------------------------------------------------------------------
        // Заглушки методов, подключаемых следующими кусками A3.6, чтобы
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
