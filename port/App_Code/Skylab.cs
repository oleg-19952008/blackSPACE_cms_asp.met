using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.Skylab.php.
    /// Chunk A2.1 (PORTING-PLAN.md): каркас + init — __construct, getSiteData,
    /// getOutput, setId, money, initSkylab (original lines 1–358).
    /// Последующие куски: A2.2 ressupdate, A2.3 displayBuild/setStatus,
    /// A2.4 req_ress/showModule, A2.5 getAllData, A2.6 формулы.
    ///
    /// PHP-замечания, сохранённые при переносе:
    ///  - в money() bindParam(':playerID', $this->pid) ссылается на несуществующее
    ///    поле класса ($pid не объявлено) и на неиспользуемый плейсхолдер — в PDO это
    ///    no-op; в C# просто опущено.
    ///  - в initSkylab() INSERT использует :uID дважды (LabID и UserID) — MySql
    ///    допускает повторное использование именованного параметра, эквивалентно.
    ///  - «transports» (todo finish transports here) в оригинале не реализованы.
    /// </summary>
    public class Skylab
    {
        // basic stuff
        private int _uid;

        // player table
        private long _uridium;
        private long _credits;

        // skylab_ressources table
        private Dictionary<string, long> _ressourcesArray;

        // skylab table — level|status|upgrade_finished
        public class ModuleState
        {
            public long Level;
            public long Status;           // 0 = не построен, 1 = активен, 2 = апгрейдится
            public long UpgradeFinished;  // unix-timestamp окончания апгрейда (0 = нет)

            public ModuleState(long level = 0, long status = 0, long upgradeFinished = 0)
            {
                Level = level;
                Status = status;
                UpgradeFinished = upgradeFinished;
            }

            /// <summary>implode("|", $mod) для колонок skylab.</summary>
            public string ToDbString()
            {
                return string.Format(CultureInfo.InvariantCulture, "{0}|{1}|{2}", Level, Status, UpgradeFinished);
            }

            /// <summary>explode("|", $row['col']) — level|status|finished.</summary>
            public static ModuleState FromDbString(string value)
            {
                var a = (value ?? "").Split('|');
                return new ModuleState(
                    a.Length > 0 ? ParseLong(a[0]) : 0,
                    a.Length > 1 ? ParseLong(a[1]) : 0,
                    a.Length > 2 ? ParseLong(a[2]) : 0);
            }

            private static long ParseLong(string s)
            {
                long v;
                return long.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
            }
        }

        private ModuleState _modBasic = new ModuleState();
        private ModuleState _modStore = new ModuleState();
        private ModuleState _modSolar = new ModuleState();
        private ModuleState _collectorPrometium = new ModuleState();
        private ModuleState _collectorEndurium = new ModuleState();
        private ModuleState _collectorTerbium = new ModuleState();
        private ModuleState _refinePrometid = new ModuleState();
        private ModuleState _refineDuranium = new ModuleState();
        private ModuleState _refinePromerium = new ModuleState();
        private ModuleState _refineSeprom = new ModuleState();
        private ModuleState _generatorXeno = new ModuleState();

        public string Output = "";

        // PHP: public $output — в initSkylab() строка, в ressupdate("out") используется
        // как массив ($this->output['prometium'] = ...). В C# разведено на два члена.
        public Dictionary<string, long> OutputRates = new Dictionary<string, long>(StringComparer.OrdinalIgnoreCase);

        // generated data
        public Dictionary<string, object> SiteData;

        // имя колонки skylab <-> состояние модуля (порядок обхода апгрейдов
        // совпадает с оригиналом initSkylab)
        private List<KeyValuePair<string, ModuleState>> Modules()
        {
            return new List<KeyValuePair<string, ModuleState>>
            {
                Mod("basicmod",      _modBasic),
                Mod("storagemod",    _modStore),
                Mod("solarmod",      _modSolar),
                Mod("prometiumcol",  _collectorPrometium),
                Mod("enduriumcol",   _collectorEndurium),
                Mod("terbiumcol",    _collectorTerbium),
                Mod("prometidref",   _refinePrometid),
                Mod("duraniumref",   _refineDuranium),
                Mod("promeriumref",  _refinePromerium),
                Mod("sepromref",     _refineSeprom),
                Mod("xenogen",       _generatorXeno),
            };
        }

        private static KeyValuePair<string, ModuleState> Mod(string column, ModuleState state)
        {
            return new KeyValuePair<string, ModuleState>(column, state);
        }

        public Skylab()
        {
            // PHP: $this->con = $GLOBALS['DB']; в порте соединения берутся
            // через DB.GetInstance() на запрос (см. Clan.cs).
        }

        public Dictionary<string, object> GetSiteData()
        {
            return SiteData;
        }

        public string GetOutput()
        {
            return Output;
        }

        public void SetId(int uid)
        {
            _uid = uid;
        }

        /// <summary>private money() — SELECT uri, credits FROM server_1_players.</summary>
        private void Money()
        {
            var rows = Query("SELECT uri, credits FROM server_1_players WHERE userID=@uID",
                             Kv("@uID", _uid));
            if (rows.Count > 0)
            {
                _uridium = ParseLong(rows[0]["uri"]);
                _credits = ParseLong(rows[0]["credits"]);
            }
        }

        /// <summary>
        /// public initSkylab() — загрузка/создание лаборатории игрока, доведение
        /// завершённых апгрейдов, возврат true если запись существовала.
        /// </summary>
        public bool InitSkylab()
        {
            var result = Query("SELECT * FROM skylab WHERE UserID = @uID", Kv("@uID", _uid));

            long time = UnixNow();

            if (result.Count != 0)
            {
                var row = result[0];

                //todo finish transports here (в оригинале не реализовано)

                _modBasic             = ModuleState.FromDbString(row["basicmod"]);
                _modStore             = ModuleState.FromDbString(row["storagemod"]);
                _modSolar             = ModuleState.FromDbString(row["solarmod"]);
                _collectorPrometium   = ModuleState.FromDbString(row["prometiumcol"]);
                _collectorEndurium    = ModuleState.FromDbString(row["enduriumcol"]);
                _collectorTerbium     = ModuleState.FromDbString(row["terbiumcol"]);
                _refinePrometid       = ModuleState.FromDbString(row["prometidref"]);
                _refineDuranium       = ModuleState.FromDbString(row["duraniumref"]);
                _refinePromerium      = ModuleState.FromDbString(row["promeriumref"]);
                _refineSeprom         = ModuleState.FromDbString(row["sepromref"]);
                _generatorXeno        = ModuleState.FromDbString(row["xenogen"]);

                var ress = Query("SELECT * FROM skylab_ressources WHERE LabID = @uID", Kv("@uID", _uid));
                if (ress.Count > 0)
                {
                    var r = ress[0];
                    _ressourcesArray = new Dictionary<string, long>(StringComparer.OrdinalIgnoreCase)
                    {
                        { "prometium", ParseLong(r["prometium"]) },
                        { "endurium",  ParseLong(r["endurium"])  },
                        { "terbium",   ParseLong(r["terbium"])   },
                        { "prometid",  ParseLong(r["prometid"])  },
                        { "duranium",  ParseLong(r["duranium"])  },
                        { "xenomit",   ParseLong(r["xenomit"])   },
                        { "promerium", ParseLong(r["promerium"]) },
                        { "seprom",    ParseLong(r["seprom"])    },
                    };
                }

                // update ressources here (A2.2 ressupdate подключается отдельным куском)

                // check the upgrades after update ressources
                foreach (var m in Modules())
                {
                    var mod = m.Value;
                    if (mod.Status == 2 && mod.UpgradeFinished != 0 && time >= mod.UpgradeFinished)
                    {
                        mod.Level += 1;
                        mod.Status = 1;
                        mod.UpgradeFinished = 0;
                        // колонки из внутреннего белого списка — интерполяция безопасна
                        Execute("UPDATE skylab SET " + m.Key + " = @data WHERE UserID = @uID",
                                Kv("@data", mod.ToDbString()), Kv("@uID", _uid));
                    }
                }
                return true;
            }
            else
            {
                // level|status|finished-timestamp
                Execute(@"INSERT INTO `skylab`
                          (`LabID`, `UserID`, `lastvisit`, `basicmod`, `solarmod`, `storagemod`,
                           `prometiumcol`, `enduriumcol`, `terbiumcol`, `prometidref`, `duraniumref`,
                           `promeriumref`, `xenogen`, `sepromref`)
                          VALUES
                          (@uID, @uID, @lv, '1|1|0', '1|1|0', '1|1|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0')",
                        Kv("@uID", _uid), Kv("@lv", time));
                Execute(@"INSERT INTO `skylab_ressources`
                          (`LabID`, `prometium`, `endurium`, `terbium`, `prometid`, `duranium`, `xenomit`, `promerium`, `seprom`)
                          VALUES
                          (@uID, 50000, 50000, 50000, 0, 0, 0, 0, 0)",
                        Kv("@uID", _uid));
                InitSkylab();
            }
            return false;
        }

        /// <summary>
        /// public ressupdate($mode = "out") — A2.2: пересчёт ресурсов лаборатории за
        /// время с последнего визита; "out" заполняет OutputRates (ед/час),
        /// "update" пишет накопленное в skylab_ressources и обновляет lastvisit.
        /// </summary>
        public void RessUpdate(string mode = "out")
        {
            var arr = Query("SELECT lastvisit FROM Skylab WHERE UserID = @uID", Kv("@uID", _uid));
            long lv = arr.Count > 0 ? ParseLong(arr[0]["lastvisit"]) : 0;

            long time = UnixNow();
            long multi = time - lv;

            double prometiumPerSec = _collectorPrometium.Status == 1
                ? Math.Floor(GenNum("raw", _collectorPrometium.Level) / 3600.0) : 0;
            double enduriumPerSec = _collectorEndurium.Status == 1
                ? Math.Floor(GenNum("raw", _collectorEndurium.Level) / 3600.0) : 0;
            double terbiumPerSec = _collectorTerbium.Status == 1
                ? Math.Floor(GenNum("raw", _collectorTerbium.Level) / 3600.0) : 0;

            double prometidPerSec = 0, duraniumPerSec = 0, promeriumPerSec = 0, sepromPerSec = 0, xenoPerSec = 0;
            double? prometiumUsage = null, enduriumUsage1 = null, enduriumUsage2 = null,
                   terbiumUsage = null, prometidUsage = null, duraniumUsage = null, promeriumUsage = null;

            if (_refinePrometid.Status == 1)
            {
                prometidPerSec = Math.Floor(GenNum("refined", _refinePrometid.Level) / 3600.0);
                prometiumUsage = prometidPerSec * 20;
                enduriumUsage1 = prometidPerSec * 10;
            }

            if (_refineDuranium.Status == 1)
            {
                duraniumPerSec = Math.Floor(GenNum("refined", _refineDuranium.Level) / 3600.0);
                terbiumUsage = duraniumPerSec * 20;
                enduriumUsage2 = duraniumPerSec * 10;
            }

            if (_refinePromerium.Status == 1)
            {
                promeriumPerSec = Math.Floor(GenNum("proxeno", _refinePromerium.Level) / 3600.0);
                prometidUsage = promeriumPerSec * 10;
                duraniumUsage = promeriumPerSec * 10;
            }

            if (_refineSeprom.Status == 1)
            {
                sepromPerSec = Math.Floor(GenNum("seprom", _refineSeprom.Level) / 3600.0);
                promeriumUsage = sepromPerSec * 10;
            }

            if (_generatorXeno.Status == 1)
                xenoPerSec = Math.Floor(GenNum("proxeno", _generatorXeno.Level) / 3600.0);

            // PHP isset()-цепочки: usage применяется только если соответствующий
            // модуль-потребитель активен
            if (prometiumUsage.HasValue) prometiumPerSec -= prometiumUsage.Value;
            if (enduriumUsage1.HasValue && enduriumUsage2.HasValue)
                enduriumPerSec -= enduriumUsage1.Value + enduriumUsage2.Value;
            else if (enduriumUsage1.HasValue) enduriumPerSec -= enduriumUsage1.Value;
            else if (enduriumUsage2.HasValue) enduriumPerSec -= enduriumUsage2.Value;
            if (terbiumUsage.HasValue) terbiumPerSec -= terbiumUsage.Value;
            if (prometidUsage.HasValue) prometidPerSec -= prometidUsage.Value;
            if (duraniumUsage.HasValue) duraniumPerSec -= duraniumUsage.Value;
            if (promeriumUsage.HasValue) promeriumPerSec -= promeriumUsage.Value;



            long rawMax = Storage("raw", _modStore.Level);
            long refMax = Storage("refined", _modStore.Level);
            long proMax = Storage("proxeno", _modStore.Level);
            long sepMax = Storage("seprom", _modStore.Level);

            long v01 = Clamp(prometiumPerSec, Ress("prometium"), rawMax, multi);
            long v02 = Clamp(enduriumPerSec,  Ress("endurium"),  rawMax, multi);
            long v03 = Clamp(terbiumPerSec,   Ress("terbium"),   rawMax, multi);
            long v04 = Clamp(prometidPerSec,  Ress("prometid"),  refMax, multi);
            long v05 = Clamp(duraniumPerSec,  Ress("duranium"),  refMax, multi);
            long v06 = Clamp(xenoPerSec,      Ress("xenomit"),   proMax, multi);
            long v07 = Clamp(promeriumPerSec, Ress("promerium"), proMax, multi);
            long v08 = Clamp(sepromPerSec,    Ress("seprom"),    sepMax, multi);

            if (mode == "out")
            {
                OutputRates["prometium"] = (long)Math.Round(prometiumPerSec * 3600);
                OutputRates["endurium"]  = (long)Math.Round(enduriumPerSec * 3600);
                OutputRates["terbium"]   = (long)Math.Round(terbiumPerSec * 3600);
                OutputRates["prometid"]  = (long)Math.Round(prometidPerSec * 3600);
                OutputRates["duranium"]  = (long)Math.Round(duraniumPerSec * 3600);
                OutputRates["xenomit"]   = (long)Math.Round(xenoPerSec * 3600);
                OutputRates["promerium"] = (long)Math.Round(promeriumPerSec * 3600);
                OutputRates["seprom"]    = (long)Math.Round(sepromPerSec * 3600);
            }
            else if (mode == "update")
            {
                Execute(@"UPDATE skylab, skylab_ressources
                          SET skylab.lastvisit = @ts,
                              skylab_ressources.prometium = skylab_ressources.prometium + @v01,
                              skylab_ressources.endurium = skylab_ressources.endurium + @v02,
                              skylab_ressources.terbium = skylab_ressources.terbium + @v03,
                              skylab_ressources.prometid = skylab_ressources.prometid + @v04,
                              skylab_ressources.duranium = skylab_ressources.duranium + @v05,
                              skylab_ressources.xenomit = skylab_ressources.xenomit + @v06,
                              skylab_ressources.promerium = skylab_ressources.promerium + @v07,
                              skylab_ressources.seprom = skylab_ressources.seprom + @v08
                          WHERE skylab.UserID = @uID AND skylab_ressources.LabID = skylab.UserID",
                        Kv("@uID", _uid), Kv("@ts", time),
                        Kv("@v01", v01), Kv("@v02", v02), Kv("@v03", v03), Kv("@v04", v04),
                        Kv("@v05", v05), Kv("@v06", v06), Kv("@v07", v07), Kv("@v08", v08));
            }
        }

        // ------------------------------------------------------------------
        // A2.3: displayBuild + setStatus (Class.Skylab.php, строки 521–852)
        // ------------------------------------------------------------------

        /// <summary>public displayBuild() — HTML-оверлей строящихся модулей.</summary>
        public string DisplayBuild()
        {
            // виджет id -> состояние модуля (порядок обхода совпадает с оригиналом)
            var widgets = new KeyValuePair<string, ModuleState>[]
            {
                KvpT("PrometiumCollector", _collectorPrometium),
                KvpT("EnduriumCollector",  _collectorEndurium),
                KvpT("TerbiumCollector",   _collectorTerbium),
                KvpT("PrometidRefinery",   _refinePrometid),
                KvpT("DuraniumRefinery",   _refineDuranium),
                KvpT("PromeriumRefinery",  _refinePromerium),
                KvpT("SepromRefinery",     _refineSeprom),
                KvpT("XenoModule",         _generatorXeno),
            };

            string ret = "<div id=\"skylab_shadow\"></div>";
            foreach (var w in widgets)
            {
                if (w.Value.Level != 0)
                {
                    ret += "<div id=\"background" + w.Key + "\"></div>";
                    ret += "<div id=\"uplink" + w.Key + "\"></div>";
                }
            }
            return ret;
        }

        /// <summary>Публичное поле status соответствующего модуля (для UpdateStatus).</summary>
        private ModuleState StateByColumn(string column)
        {
            switch (column)
            {
                case "basicmod":     return _modBasic;
                case "storagemod":   return _modStore;
                case "solarmod":     return _modSolar;
                case "prometiumcol": return _collectorPrometium;
                case "enduriumcol":  return _collectorEndurium;
                case "terbiumcol":   return _collectorTerbium;
                case "prometidref":  return _refinePrometid;
                case "duraniumref":  return _refineDuranium;
                case "promeriumref": return _refinePromerium;
                case "sepromref":    return _refineSeprom;
                case "xenogen":      return _generatorXeno;
                default:             return null;
            }
        }

        /// <summary>
        /// public setStatus($module, $nst, $act) — переключение активности ("status"),
        /// запуск апгрейда ("upthis") и мгновенная постройка ("instaup" — в оригинале пустая ветка).
        /// </summary>
        public void SetStatus(string module, long nst, string act)
        {
            // имя модуля (как в запросе) -> (колонка skylab, состояние, категория upgrade_time)
            var map = new Dictionary<string, Tuple<string, ModuleState, string>>
            {
                { "xenoModule",        Tuple.Create("xenogen",      _generatorXeno,       "refine") },
                { "prometiumCollector",Tuple.Create("prometiumcol", _collectorPrometium,  "collectors") },
                { "enduriumCollector", Tuple.Create("enduriumcol",  _collectorEndurium,   "collectors") },
                { "terbiumCollector",  Tuple.Create("terbiumcol",   _collectorTerbium,    "collectors") },
                { "prometidRefinery",  Tuple.Create("prometidref",  _refinePrometid,      "refine") },
                { "duraniumRefinery",  Tuple.Create("duraniumref",  _refineDuranium,      "refine") },
                { "promeriumRefinery", Tuple.Create("promeriumref", _refinePromerium,     "refine") },
                { "sepromRefinery",    Tuple.Create("sepromref",    _refineSeprom,        "seprom") },
                { "storageModule",     Tuple.Create("storagemod",   _modStore,            "basic") },
                { "solarModule",       Tuple.Create("solarmod",     _modSolar,            "basic") },
                { "baseModule",        Tuple.Create("basicmod",     _modBasic,            "basic") },
            };

            Tuple<string, ModuleState, string> m;
            if (!map.TryGetValue(module, out m)) return;
            string type = m.Item1;
            ModuleState state = m.Item2;

            if (act == "status")
            {
                string data = state.Level + "|" + nst + "|0";
                Execute("UPDATE skylab SET " + type + " = @data WHERE UserID = @uID",
                        Kv("@uID", _uid), Kv("@data", data));
                state.Status = nst;
            }
            else if (act == "upthis")
            {
                long time = UnixNow() + (long)UpgradeTime(m.Item3, state.Level + 1);
                string data = state.Level + "|" + nst + "|" + time;
                Execute("UPDATE skylab SET " + type + " = @data WHERE UserID = @uID",
                        Kv("@uID", _uid), Kv("@data", data));
                state.Status = nst;
            }
            //elseif ($act == "instaup") {} — в оригинале пустая ветка
        }

        // ------------------------------------------------------------------
        // A2.4: req_ress + showModule (Class.Skylab.php, строки 684–1202)
        // ------------------------------------------------------------------

        /// <summary>
        /// private req_ress($type, $level, $instant = 'no') — в PHP 5.4+ это синтаксическая
        /// ошибка (в теле только объявления $up_cost_*), метод никогда не исполнялся.
        /// Портирован как заглушка для сохранения сигнатуры.
        /// </summary>
        private long[] ReqRess(string type, long level, string instant = "no")
        {
            return new long[0];
        }

        /// <summary>Данные модуля для showModule (таблица name/req/type/refinery-параметров).</summary>
        internal class ModuleInfo
        {
            public string Req;               // JS-имя модуля
            public string Name;              // отображаемое имя
            public string Type = "other";    // "other" | "refinery"
            public ModuleState State;
            public bool HasEnergyUsage = true;          // solarModule не считает energy_usage
            public bool UseAllUsageForSolar = false;    // solarModule: eusage = energy_all_usage
            // параметры нефтепереработки (rd*)
            public bool IsRefineryDetails = false;
            public string RdType, RdUseOne, RdUseTwo, RdGens;
            public double RdOneFactor = 1, RdTwoFactor = 1;
            public string RdGenKind = "refined";        // тип ressource_generation для rdgens
            public bool RdUseTwoEmptyWhenIdle = false;  // seprom: "" вместо "0"
            // инъекции для parity-теста (в бою null -> используются реальные поля)
            public string AllUsage;
            public long? StoreFtsFromBasic;
            public string Module;   // имя модуля (для веток, отличающихся по имени)
        }

        private ModuleInfo GetModuleInfo(string module)
        {
            switch (module)
            {
                case "xenoModule":
                    return new ModuleInfo { Req = "xenoModule", Name = "Xeno Module", State = _generatorXeno };
                case "prometiumCollector":
                    return new ModuleInfo { Req = "prometiumCollector", Name = "Prometium collector", State = _collectorPrometium };
                case "enduriumCollector":
                    return new ModuleInfo { Req = "enduriumCollector", Name = "Endurium collector", State = _collectorEndurium };
                case "terbiumCollector":
                    return new ModuleInfo { Req = "terbiumCollector", Name = "Terbium collector", State = _collectorTerbium };
                case "prometidRefinery":
                    return new ModuleInfo
                    {
                        Req = "prometidRefinery", Name = "Prometid refinery", State = _refinePrometid,
                        Type = "refinery", IsRefineryDetails = true, RdType = "3",
                        RdUseOne = "prometium", RdUseTwo = "endurium", RdGens = "prometid",
                        RdOneFactor = 20, RdTwoFactor = 10, RdGenKind = "refined"
                    };
                case "duraniumRefinery":
                    return new ModuleInfo
                    {
                        Req = "duraniumRefinery", Name = "Duranium refinery", State = _refineDuranium,
                        Type = "refinery", IsRefineryDetails = true, RdType = "3",
                        RdUseOne = "endurium", RdUseTwo = "terbium", RdGens = "duranium",
                        RdOneFactor = 10, RdTwoFactor = 20, RdGenKind = "refined"
                    };
                case "promeriumRefinery":
                    return new ModuleInfo
                    {
                        Req = "promeriumRefinery", Name = "Promerium refinery", State = _refinePromerium,
                        Type = "refinery", IsRefineryDetails = true, RdType = "3",
                        RdUseOne = "prometid", RdUseTwo = "duranium", RdGens = "promerium",
                        RdOneFactor = 10, RdTwoFactor = 10, RdGenKind = "proxeno"
                    };
                case "sepromRefinery":
                    return new ModuleInfo
                    {
                        Req = "sepromRefinery", Name = "Seprom refinery", State = _refineSeprom,
                        Type = "refinery", IsRefineryDetails = true, RdType = "2",
                        RdUseOne = "promerium", RdUseTwo = "", RdGens = "seprom",
                        RdOneFactor = 10, RdTwoFactor = 0, RdGenKind = "seprom",
                        RdUseTwoEmptyWhenIdle = true
                    };
                case "storageModule":
                    return new ModuleInfo { Req = "storageModule", Name = "Storage module", State = _modStore };
                case "solarModule":
                    return new ModuleInfo { Req = "solarModule", Name = "Solar module", State = _modSolar, HasEnergyUsage = false, UseAllUsageForSolar = true };
                case "baseModule":
                    return new ModuleInfo { Req = "baseModule", Name = "Basic module", State = _modBasic };
                default:
                    return null;
            }
        }

        /// <summary>Категория upgrade_cost для модуля.</summary>
        private static string CostCategory(string module)
        {
            switch (module)
            {
                case "xenoModule":         return "generator";
                case "prometiumCollector":
                case "enduriumCollector":
                case "terbiumCollector":   return "collectors";
                case "prometidRefinery":
                case "duraniumRefinery":
                case "promeriumRefinery":  return "refine";
                case "sepromRefinery":     return "refine_sep";
                case "storageModule":      return "store";
                case "solarModule":        return "solar";
                case "baseModule":         return "basic";
                default:                   return "basic";
            }
        }

        /// <summary>Категория upgrade_time для модуля (в xenoModule/refine_sep расхождения сохранены).</summary>
        private static string TimeCategory(string module)
        {
            switch (module)
            {
                case "xenoModule":         return "refine";   // в оригинале 'refine' для генератора
                case "prometiumCollector":
                case "enduriumCollector":
                case "terbiumCollector":   return "collectors";
                case "prometidRefinery":
                case "duraniumRefinery":
                case "promeriumRefinery":  return "refine";
                case "sepromRefinery":     return "seprom";
                case "storageModule":
                case "solarModule":
                case "baseModule":         return "basic";
                default:                   return "basic";
            }
        }

        /// <summary>
        /// public showModule($module, $srq) — рендер одного блока Skylab UI
        /// (smallbox / refineryDetails / collectorDetails / upthis / footer).
        /// Неинициализированные переменные в PHP-ветках сохранены как "" (notice->null->"").
        /// </summary>
        public string ShowModule(string module, string srq)
        {
            var mi = GetModuleInfo(module);
            if (mi != null) mi.Module = module;
            return ShowModule(mi, srq);
        }

        /// <summary>Внутренний оверлей: состояние передаётся явно — для parity-теста с мок-данными.</summary>
        internal string ShowModule(ModuleInfo mi, string srq)
        {
            if (mi == null) return "";

            var st = mi.State;
            long level = st.Level;
            long status = st.Status;
            string eusage = mi.HasEnergyUsage ? EnergyUsage(level) : "0";
            string prod = "";
            string cdgensCnt = "";
            string rduseOneCon = "", rduseTwoCon = "", rdgensCnt = "";
            long upCostRaw = 0, upCostCre = 0, upCostUri = 0, upTime = 0;
            long fts = 0;

            if (level < 20)
            {
                upCostRaw = UpgradeCost(CostCategory(mi.Module), "cost_raw", level + 1);
                upCostCre = UpgradeCost(CostCategory(mi.Module), "cost_cre", level + 1);
                upCostUri = UpgradeCost(CostCategory(mi.Module), "cost_uri", level + 1);
                upTime = (long)UpgradeTime(TimeCategory(mi.Module), level + 1);
            }

            if (mi.UseAllUsageForSolar)
            {
                // solarModule: eusage = energy_all_usage(), prod = energy_production(level)
                eusage = mi.AllUsage != null ? mi.AllUsage : EnergyAllUsage();
                prod = EnergyProduction(level);
            }

            if (mi.IsRefineryDetails)
            {
                if (status == 0 || status == 2)
                {
                    rduseOneCon = "0";
                    rduseTwoCon = mi.RdUseTwoEmptyWhenIdle ? "" : "0";
                    rdgensCnt = "0";
                }
                else
                {
                    rdgensCnt = RessourceGeneration(mi.RdGenKind, level);
                    rduseOneCon = PhpMul(rdgensCnt, mi.RdOneFactor);
                    rduseTwoCon = mi.RdUseTwoEmptyWhenIdle ? "" : PhpMul(rdgensCnt, mi.RdTwoFactor);
                }
            }
            else if (mi.Module == "xenoModule")
            {
                if (status == 2) fts = st.UpgradeFinished;
            }
            else if (mi.Module == "prometiumCollector" || mi.Module == "enduriumCollector" || mi.Module == "terbiumCollector")
            {
                cdgensCnt = (status == 0 || status == 2) ? "0" : RessourceGeneration("raw", level);
            }

            if (mi.Module == "storageModule")
            {
                // дефект оригинала: fts берётся из mod_basic, а не mod_store
                if (status == 2) fts = mi.StoreFtsFromBasic ?? _modBasic.UpgradeFinished;
            }
            else if (status == 2 && !mi.IsRefineryDetails && mi.Module != "xenoModule"
                     && mi.Module != "prometiumCollector" && mi.Module != "enduriumCollector" && mi.Module != "terbiumCollector")
            {
                fts = st.UpgradeFinished;
            }

            // общая пост-обработка (строки 1100–1108 оригинала)
            if (mi.Module != "solarModule" && mi.Module != "baseModule" && mi.Module != "storageModule")
                if (status == 0 || status == 2) eusage = "0";

            string cornerStatus = (status == 0 || status == 2) ? "inactive" : "active";
            string nameStatus = (status > 0) ? "" : "_inactive";
            string levelIconStatus = (status == 2) ? "level_icon_upgrade" : ((status == 0) ? "level_icon_inactive" : "level_icon");
            string fontLevelStatus = (status == 0) ? "level skylab_font_level_inactive" : "level skylab_font_level";
            string efficiency = (status == 0 || status == 2) ? "0" : "100";

            string ret = "";

            if (srq == "smallbox")
            {
                ret = "<div id=\"module_" + mi.Req + "_small\" class=\"module module_small\" onclick=\"Skylab.showModule('" + mi.Req + "');\">";
                ret += "    <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
                ret += "        <tr>";
                ret += "            <td id=\"corner_small_top_left_" + cornerStatus + "\">";
                ret += "                <div class=\"name" + nameStatus + "\">" + mi.Name + "</div>";
                ret += "            </td>";
                ret += "            <td id=\"corner_small_top_right_" + cornerStatus + "\"></td>";
                ret += "        </tr>";
                ret += "        <tr>";
                ret += "            <td id=\"corner_small_bottom_left_" + cornerStatus + "\">";
                if (level > 0)
                {
                    ret += "           <table cellpadding=\"0\" cellspacing=\"0\">";
                    ret += "            <tr>";
                    ret += "                <td>";
                    ret += "                    <div class=\"" + levelIconStatus + "\"></div>";
                    ret += "                    <div class=\"" + fontLevelStatus + "\">" + level + "</div>";
                    ret += "                </td>";
                    ret += "                <td class=\"cellview\">";
                    ret += "                    <div class=\"power_icon\"></div>";
                    if (mi.Req != "solarModule")
                        ret += "                   <div class=\"power skylab_font_power\">" + eusage + "</div>";
                    else
                        ret += "                   <div class=\"power skylab_font_power\">" + eusage + " / " + prod + "</div>";
                    ret += "                </td>";
                    if (mi.Type == "refinery")
                    {
                        ret += "            <td class=\"cellview\">";
                        ret += "                 <div class=\"efficiency_icon\"></div>";
                        ret += "                 <div class=\"efficiency skylab_font_efficiency\">" + efficiency + "%</div>";
                        ret += "            </td>";
                    }
                    ret += "                <td><br /></td>";
                    ret += "            </tr>";
                    ret += "        </table>";
                }
                ret += "    </td>";
                ret += "    <td id=\"corner_small_bottom_right_" + cornerStatus + "\"></td>";
                ret += "</tr>";
                ret += "</table>";
                ret += "</div>";
            }
            else if (srq == "refineryDetails")
            {
                ret = "<div id=\"module_infobox_" + mi.Req + "_overview_large\" class=\"tabContent skylab_standard\">";
                ret += "    <div style=\"height:135px;background-image: url(./do_img/global/pilotSheet/skylab/bg_refinery_" + mi.RdType + ".png?__cv=8a7c8d311f248f5e62d247296cbdc300); background-repeat:no-repeat;background-position: center 25px\">";
                ret += "               <div style=\"position:absolute;left:75px;top:90px;\" class=\"ore_" + mi.RdUseOne + "\"><strong>" + mi.RdUseOne + "<br />" + rduseOneCon + "</strong></div>";
                if (mi.Req != "sepromRefinery")
                {
                    ret += "        <div style=\"position:absolute;left:235px;top:90px;text-align:right;\" class=\"ore_" + mi.RdUseTwo + "\"><strong>" + mi.RdUseTwo + "<br />" + rduseTwoCon + "</strong></div>";
                }
                ret += "        <div style=\"position:absolute;left:100px;top:150px;\">" + efficiency + "%</div>";
                ret += "        <div style=\"position:absolute;left:155px;top:185px;\" class=\"ore_" + mi.RdGens + "\"><strong>" + mi.RdGens + "<br />" + rdgensCnt + "</strong></div>";
                ret += "        <div class=\"icon_efficiency icon_efficiency_" + efficiency + "\"></div>";
                if (efficiency == "0")
                {
                    ret += "        <div class=\"icon_attention\"></div>";
                }
                ret += "    </div>";
                ret += "</div>";
            }
            else if (srq == "collectorDetails")
            {
                ret = "<div class=\"collector_info collector_info_" + mi.Req + "\"> Level: 1 - Production: " + cdgensCnt + "</div>";
            }
            else if (srq == "upthis")
            {
                if (status != 2 && level < 20)
                {
                    ret = "<div id=\"module_infobox_" + mi.Req + "_upgrade_large\" class=\"tabContent skylab_standard\" style=\"display: none;\"><table class=\"module_infobox_upgrade\" cellpadding=\"0\" cellspacing=\"0\"><tr><td class=\"firstRow\"><br /></td><td class=\"secondRow\">Instant</td><td class=\"thirdRow skylab_price_normal\" style=\"width:1px;\"><div style=\"position:absolute;width:1px;height:124px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_vertical.jpg?__cv=0f3388b877b7ef4dd20df64be8699800);\"></div><br /></td><td>Normal</td></tr><tr><td colspan=\"4\" style=\"height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;background-position: 65px;\"></td></tr><tr><td class=\"firstRow\">Uridium</td><td class=\"secondRow\">" + upCostUri + "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">0</td></tr><tr><td colspan=\"4\" style=\"height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;background-position: 65px;\"></td></tr><tr><td class=\"firstRow\">Credits</td><td class=\"secondRow\">" + upCostCre + "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" + upCostCre + "</td></tr><tr><td class=\"firstRow\">Time</td><td class=\"secondRow\">instant</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" + PhpDiv(upTime, 3600) + "h</td></tr><tr><td class=\"firstRow\">Prometium</td><td class=\"secondRow\">" + upCostRaw + "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" + upCostRaw + "</td></tr><tr><td class=\"firstRow\">Endurium</td><td class=\"secondRow\">" + upCostRaw + "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" + upCostRaw + "</td></tr><tr><td class=\"firstRow\">Terbium</td><td class=\"secondRow\">" + upCostRaw + "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" + upCostRaw + "</td></tr><tr><td colspan=\"4\" style=\"height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;background-position: 65px;\"></td></tr><tr><td colspan=\"2\" style=\"padding:8px 3px\"><div class=\"button_standard\" style=\"float:right;\"><a style=\"display:block;\" onfocus=\"this.blur()\" onclick=\"setConfirmButtonText('confirmText', 'OK'); setCancelButtonText('cancelText', 'Cancel'); openConfirm('indexInternal.es?action=internalSkylab&amp;subaction=instantUpgrade&amp;construction=" + mi.Req + "&amp;reloadToken=1e1064a8fdf038ee6e4c99e2beab4d29', 'Confirm upgrade?')\">Instant build</a></div></td><td colspan=\"2\" style=\"padding:8px 5px\"><div class=\"button_standard\"><a style=\"display:block\" onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalSkylab&amp;subaction=upgrade&amp;construction=" + mi.Req + "&amp;reloadToken=1e1064a8fdf038ee6e4c99e2beab4d29\">Build</a></div></td></tr></table></div>";
                }
                else if (level >= 20)
                {
                    ret = "<div id=\"module_infobox_" + mi.Req + "_upgrade_large\" class=\"tabContent skylab_standard\" style=\"\"><div class=\"upgrade_container_max\">Maximum upgrade level attained</div></div>";
                }
                else if (status == 2)
                {
                    string rdy = PhpDate(fts);
                    ret = "<div id=\"module_infobox_" + mi.Req + "_upgrade_large\" class=\"tabContent skylab_standard\" style=\"\"><div class=\"upgrade_container_max\">Upgrade until: " + rdy + "</div></div>";
                }
            }
            else if (srq == "footer")
            {
                ret = "<div id=\"module_infobox_" + mi.Req + "_footer\" class=\"skylab_module_footer\">";
                ret += "<div class=\"module_info_active_state module_infobox_info\">";
                if ((mi.Module != "baseModule" && mi.Module != "solarModule" && mi.Module != "storageModule") && status == 1)
                {
                    ret += "<img src=\"./do_img/global/pilotSheet/skylab/power_on.png?__cv=4eeda785991deb1830052b0d935d3d00\" width=\"14\" height=\"14\" onclick=\"javascript: do_redirect('indexInternal.es?action=internalSkylab&subaction=setInactive&construction=" + mi.Req + "&reloadToken=1e1064a8fdf038ee6e4c99e2beab4d29');\" style=\"cursor: pointer\" />";
                }
                else if (mi.Module == "baseModule" || mi.Module == "solarModule" || mi.Module == "storageModule")
                {
                    ret += "<img src=\"./do_img/global/pilotSheet/skylab/power_on.png?__cv=b0a4878430feb41ac03c5a6d796fda00\" width=\"14\" height=\"14\" />";
                }
                else if (level == 0)
                {
                    ret += "<img src=\"./do_img/global/pilotSheet/skylab/power_disabled.png?__cv=b0a4878430feb41ac03c5a6d796fda00\" width=\"14\" height=\"14\" />";
                }
                else
                {
                    ret += "<img src=\"./do_img/global/pilotSheet/skylab/power_off.png?__cv=58f1b6a316567d6b736c56c2e314ab00\" width=\"14\" height=\"14\" onclick=\"javascript: do_redirect('indexInternal.es?action=internalSkylab&amp;subaction=setActive&amp;construction=" + mi.Req + "&amp;reloadToken=4de85a941fcd833dd7709715da051258');\" style=\"cursor: pointer\">";
                }
                ret += "</div>";
                ret += "<div class=\"module_info_level module_infobox_info\">";
                ret += " <div class=\"level_icon\">" + level + "</div>";
                ret += "</div>";
                if (mi.Req == "solarModule")
                    ret += "<div class=\"module_info_power_usage module_infobox_info\">" + prod + "</div>";
                else
                    ret += "<div class=\"module_info_power_usage module_infobox_info\">" + eusage + "</div>";
                if (mi.Type == "refinery")
                {
                    ret += "  <div class=\"module_info_efficiency module_infobox_info\">" + efficiency + " %</div>";
                }
                ret += "</div>";
            }

            return ret;
        }

        /// <summary>PHP date("m-d-Y h:i a", $ts).</summary>
        private static string PhpDate(long ts)
        {
            var dt = new DateTime(1970, 1, 1, 0, 0, 0, DateTimeKind.Utc).AddSeconds(ts);
            return dt.ToString("MM-dd-yyyy hh:mm tt", CultureInfo.InvariantCulture).ToLowerInvariant();
        }

        /// <summary>PHP "$a*$b" c приведением строк к числам.</summary>
        private static string PhpMul(string a, double b)
        {
            double av;
            if (!double.TryParse(a, NumberStyles.Any, CultureInfo.InvariantCulture, out av)) av = 0;
            return Convert.ToString(av * b, CultureInfo.InvariantCulture);
        }

        /// <summary>PHP "$a/$b" (деление на 0 в PHP 5.x даёт warning + false -> "").</summary>
        private static string PhpDiv(long a, long b)
        {
            if (b == 0) return "";
            return Convert.ToString((double)a / b, CultureInfo.InvariantCulture);
        }

        // ------------------------------------------------------------------
        // A2.5: getAllData (Class.Skylab.php, строки 1203–1404)
        // ------------------------------------------------------------------

        /// <summary>
        /// public getAllData() — заполняет SiteData массивом для шаблона.
        /// Проверка сессии в оригинале есть, но на результат не влияет (структура та же) — опущена.
        /// </summary>
        public void GetAllData()
        {
            SiteData = BuildAllData(_modBasic, _modStore, _modSolar,
                                    _collectorPrometium, _collectorEndurium, _collectorTerbium,
                                    _refinePrometid, _refineDuranium, _refinePromerium, _refineSeprom,
                                    _generatorXeno, k => Ress(k));
        }

        /// <summary>Внутренний билдер getAllData с инъекцией состояния и ресурсов — для parity-теста.</summary>
        internal static Dictionary<string, object> BuildAllData(
            ModuleState modBasic, ModuleState modStore, ModuleState modSolar,
            ModuleState collectorPrometium, ModuleState collectorEndurium, ModuleState collectorTerbium,
            ModuleState refinePrometid, ModuleState refineDuranium, ModuleState refinePromerium,
            ModuleState refineSeprom, ModuleState generatorXeno, Func<string, long> ressFn)
        {
            var sd = new Dictionary<string, object>();

            // --- ressources -------------------------------------------------
            var ress = new Dictionary<string, object>();
            var resKinds = new KeyValuePair<string, string>[]
            {
                KvpT("prometium", "raw"), KvpT("endurium", "raw"), KvpT("terbium", "raw"),
                KvpT("prometid", "refined"), KvpT("duranium", "refined"),
                KvpT("xenomit", "proxeno"), KvpT("promerium", "proxeno"),
                KvpT("seprom", "seprom"),
            };
            foreach (var rk in resKinds)
            {
                long count = ressFn(rk.Key);
                long maxStorage = Storage(rk.Value, modStore.Level);
                // number_format(100*count/max, 0, '', ''): деление на 0 в PHP 5 -> warning + false -> "0"
                string perc = maxStorage == 0 ? "0"
                    : Math.Round(100.0 * count / maxStorage, MidpointRounding.AwayFromZero).ToString("0", CultureInfo.InvariantCulture);
                ress[rk.Key] = new Dictionary<string, object>
                {
                    { "count", count }, { "max_storage", maxStorage }, { "perc", perc }
                };
            }
            sd["ressources"] = ress;

            // --- modules ----------------------------------------------------
            var mods = new Dictionary<string, object>();
            var modDefs = new KeyValuePair<string, Tuple<string, ModuleState, string, bool>>[]
            {
                KvpT("mod_basic",           Tuple.Create("Basic module",        modBasic,          "basic",      true)),
                KvpT("mod_store",           Tuple.Create("Storage module",      modStore,          "store",      true)),
                KvpT("mod_solar",           Tuple.Create("Solar module",        modSolar,          "solar",      false)),
                KvpT("collector_prometium", Tuple.Create("Prometium collector", collectorPrometium,"collectors", true)),
                KvpT("collector_endurium",  Tuple.Create("Endurium collector",  collectorEndurium, "collectors", true)),
                KvpT("collector_terbium",   Tuple.Create("Terbium collector",   collectorTerbium,  "collectors", true)),
                KvpT("refine_prometid",     Tuple.Create("Prometid refinery",   refinePrometid,    "refine",     true)),
                KvpT("refine_duranium",     Tuple.Create("Duranium refinery",   refineDuranium,    "refine",     true)),
                KvpT("refine_promerium",    Tuple.Create("Promerium refinery",  refinePromerium,   "refine",     true)),
                KvpT("refine_seprom",       Tuple.Create("Seprom refinery",     refineSeprom,      "refine_sep", true)),
                KvpT("generator_xeno",      Tuple.Create("Xeno module",         generatorXeno,     "generator",  true)),
            };
            foreach (var md in modDefs)
            {
                var def = md.Value;
                var state = def.Item2;
                var entry = new Dictionary<string, object>
                {
                    { "name", def.Item1 },
                    { "progressbar", 3 * state.Level },
                    { "level", state.Level },
                    { "energyusage", EnergyUsage(state.Level) },
                    { "cost_raw", UpgradeCost(def.Item3, "cost_raw", state.Level) },
                    { "cost_cre", UpgradeCost(def.Item3, "cost_cre", state.Level) },
                    { "cost_uri", UpgradeCost(def.Item3, "cost_uri", state.Level) },
                };
                if (def.Item3 == "solar")
                {
                    // mod_solar: без solarinfo, вместо energyusage — два поля энергии
                    entry.Remove("energyusage");
                    entry["sd_status"] = state.Level > 0 ? "ACTIVE" : "INACTIVE";
                    entry["energy_all_usage"] = EnergyAllUsage(modBasic, modStore, collectorPrometium,
                        collectorEndurium, collectorTerbium, refinePrometid, refineDuranium,
                        refinePromerium, refineSeprom, generatorXeno);
                    entry["energy_production"] = EnergyProduction(state.Level);
                }
                else
                {
                    entry["sd_status"] = state.Level > 0 ? "ACTIVE" : "INACTIVE";
                    entry["solarinfo"] = state.Level > 0 ? "" : "inactive";
                }
                mods[md.Key] = entry;
            }
            sd["modules"] = mods;

            return sd;
        }

        // ------------------------------------------------------------------
        // A2.6: формулы (Class.Skylab.php, строки 1405–2212)
        // Таблицы уровня 0..20 (значения выше 20 в оригинале не определены).
        // ------------------------------------------------------------------

        private static readonly Dictionary<string, long[]> GenerationTable =
            new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
            {
                { "raw", new long[] {
                    0, 2200, 7400, 15045, 24890, 36782, 50604, 66274, 83720, 102884, 123715,
                    146171, 170212, 195805, 222919, 251526, 281600, 313118, 346059, 380401, 416216 } },
                { "refined", new long[] {
                    0, 110, 370, 752, 1245, 1839, 2530, 3314, 4186, 5144, 6186,
                    7309, 8511, 9790, 11146, 12013, 14080, 15656, 17303, 19020, 20806 } },
                { "proxeno", new long[] {
                    0, 11, 37, 75, 124, 184, 253, 331, 419, 514, 619,
                    731, 851, 979, 1115, 1258, 1408, 1566, 1730, 1902, 2081 } },
                { "seprom", new long[] {
                    0, 1, 3, 7, 11, 17, 23, 30, 38, 47, 56,
                    66, 77, 89, 101, 114, 128, 142, 157, 173, 189 } },
            };

        private static readonly Dictionary<string, long[]> StorageTable =
            new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
            {
                { "raw", new long[] {
                    0, 105600, 355195, 722148, 1194728, 1765474, 2429006, 3181160, 4018569, 4938423, 5938324,
                    7016186, 8170170, 9398635, 10700104, 12073234, 13516800, 15029673, 16610810, 18259241, 19974063 } },
                { "refined", new long[] {
                    0, 5280, 17760, 36107, 59736, 88274, 121450, 159058, 200928, 246921, 296916,
                    350809, 408509, 469932, 535005, 603662, 675840, 751484, 830540, 912962, 998703 } },
                { "proxeno", new long[] {
                    0, 1776, 3611, 5974, 8827, 12145, 15906, 20093, 24692, 29692, 35081,
                    40851, 46993, 53501, 60366, 67584, 75148, 83054, 91296, 99870 } },
                { "seprom", new long[] {
                    0, 48, 161, 328, 543, 802, 1104, 1446, 1827, 2245, 2699,
                    3189, 3714, 4272, 4864, 5488, 6144, 6832, 7550, 8300, 9079 } },
            };

        /// <summary>Доступ к $this->ressources_array с защитой от null (PHP вернул бы notice+null).</summary>
        private long Ress(string key)
        {
            return RessOf(_ressourcesArray, key);
        }

        internal static long RessOf(Dictionary<string, long> arr, string key)
        {
            long v;
            return arr != null && arr.TryGetValue(key, out v) ? v : 0;
        }

        /// <summary>round($per_sec*$multi), ограничен сверху свободным местом в хранилище.</summary>
        // PHP round() — banker's rounding, тот же алгоритм у Math.Round без MidpointRounding
        private static long Clamp(double perSec, long cur, long max, long multi)
        {
            long v = (long)Math.Round(perSec * multi);
            long free = max - cur;
            if (v > free) v = free;
            return v;
        }

        /// <summary>Числовой доступ к ressource_generation (для арифметики ressupdate).</summary>
        private double GenNum(string type, long level)
        {
            double v;
            return double.TryParse(RessourceGeneration(type, level), NumberStyles.Any,
                                   CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        /// <summary>private ressource_generation($type,$level) — ед/час на уровень.</summary>
        private string RessourceGeneration(string type, long level)
        {
            long[] t;
            if (!GenerationTable.TryGetValue(type, out t)) return "";
            // PHP-паритет: $gen[$type][$level] при level за пределами массива -> notice + null ("")
            if (level < 0 || level >= t.Length) return "";
            return t[(int)level].ToString();
        }

        /// <summary>private storage($type,$level) — максимальный запас на уровень мода хранилища.</summary>
        internal static long Storage(string type, long level)
        {
            long[] t;
            if (!StorageTable.TryGetValue(type, out t)) return 0;
            // PHP-паритет: $storage[$type][$level] вне диапазона -> null (0).
            // В оригинале proxeno-массив storage() содержит 20 значений (индексы 0..19),
            // т.е. на 20 уровне хранилище proxeno = 0 — сохранено как есть.
            if (level < 0 || level >= t.Length) return 0;
            return t[(int)level];
        }


        private static readonly string[] EnergyProductionTable = {
            "0", "270", "310", "370", "450", "550", "670", "810", "970", "1150", "1350", "1570", "1810", "2070", "2350", "2650", "2970", "3310", "3670", "4050", "4450"
        };

        /// <summary>private energy_production($level) — строка таблицы (PHP-паритет: вне диапазона -> "").</summary>
        private static string EnergyProduction(long level)
        {
            if (level < 0 || level >= EnergyProductionTable.Length) return "";
            return EnergyProductionTable[(int)level];
        }

        private static readonly long[] EnergyUsageTable = {
            0, 16, 19, 24, 31, 40, 51, 64, 79, 96, 115, 136, 159, 184, 211, 240, 271, 304, 339, 376,
            415
        };

        /// <summary>private energy_usage($level) — строка таблицы.</summary>
        private static string EnergyUsage(long level)
        {
            if (level < 0 || level >= EnergyUsageTable.Length) return "";
            return EnergyUsageTable[(int)level].ToString();
        }

        /// <summary>private energy_all_usage() — сумма потребления активных модулей + 16 (транспортный модуль).</summary>
        private string EnergyAllUsage()
        {
            return EnergyAllUsage(_modBasic, _modStore, _collectorPrometium, _collectorEndurium,
                                  _collectorTerbium, _refinePrometid, _refineDuranium, _refinePromerium,
                                  _refineSeprom, _generatorXeno);
        }

        internal static string EnergyAllUsage(
            ModuleState modBasic, ModuleState modStore,
            ModuleState collectorPrometium, ModuleState collectorEndurium, ModuleState collectorTerbium,
            ModuleState refinePrometid, ModuleState refineDuranium, ModuleState refinePromerium,
            ModuleState refineSeprom, ModuleState generatorXeno)
        {
            long v = ParseLong(EnergyUsage(modBasic.Level))
                   + ParseLong(EnergyUsage(modStore.Level));
            var actives = new[] { collectorPrometium, collectorEndurium, collectorTerbium,
                                  refinePrometid, refineDuranium, refinePromerium,
                                  refineSeprom, generatorXeno };
            foreach (var a in actives)
                if (a.Status == 1) v += ParseLong(EnergyUsage(a.Level));
            return (v + 16).ToString();   // +16 for transport module
        }

        private static readonly Dictionary<string, long[]> UpgradeTimeTable =
            new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
            {

                { "basic", new long[] { 0, 3600, 14400, 28800, 43200, 57600, 72000, 86400, 100800, 115200, 129600, 144000,
                158400, 172800, 187200, 201600, 216000, 230400, 244800, 259200, 273600 } },

                { "collectors", new long[] { 0, 3600, 14400, 28800, 43200, 57600, 72000, 86400, 100800, 115200, 129600, 144000,
                158400, 172800, 187200, 201600, 216000, 230400, 244800, 259200, 273600 } },

                { "refine", new long[] { 0, 3600, 18000, 36000, 54000, 72000, 90000, 108000, 126000, 144000, 180000, 198000,
                216000, 234000, 252000, 270000, 288000, 306000, 324000, 342000, 360000 } },

                { "seprom", new long[] { 0, 3600, 21600, 43200, 64800, 86400, 108000, 129600, 151200, 172800, 194400, 216000,
                237600, 259200, 280800, 302400, 324000, 345600, 367200, 388800, 410400 } }

            };

        /// <summary>private upgrade_time($type,$level) — длительность апгрейда в секундах.</summary>
        private static double UpgradeTime(string type, long level)
        {
            long[] t;
            if (!UpgradeTimeTable.TryGetValue(type, out t)) return 0;
            if (level < 0 || level >= t.Length) return 0;
            return t[(int)level];
        }


        private static readonly Dictionary<string, Dictionary<string, long[]>> UpgradeCostTable =
            new Dictionary<string, Dictionary<string, long[]>>(StringComparer.OrdinalIgnoreCase)
            {
                { "basic", new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
                  { { "cost_raw", new long[] { 
                    0, 707, 2923, 8000, 17469, 33068, 56718, 90510, 136688, 197642, 275902, 374123, 495087, 641694, 816957, 1024000, 1266051, 1546443, 1868605, 2236068, 3236068 } }, { "cost_cre", new long[] { 
                    0, 16352, 27144, 38891, 51403, 64560, 78279, 92499, 107171, 122257, 137725, 153550, 169708, 186180, 202949, 220000, 237320, 254896, 272719, 290777, 300000 } }, { "cost_uri", new long[] { 
                    0, 1487, 2468, 3536, 4673, 5869, 7116, 8409, 9743, 11114, 12520, 13959, 15428, 16925, 18450, 20000, 21575, 23172, 24793, 26434, 30000 } } } },
                { "store", new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
                  { { "cost_raw", new long[] { 
                    0, 707, 2923, 8000, 17469, 33068, 56718, 90510, 136688, 197642, 275902, 374123, 495087, 641694, 816957, 1024000, 1266051, 1546443, 1868605, 2236068, 3000000 } }, { "cost_cre", new long[] { 
                    0, 16352, 27144, 38891, 51403, 64560, 78279, 92499, 107171, 122257, 137725, 153550, 169708, 186180, 202949, 220000, 237320, 254896, 272719, 290777, 300000 } }, { "cost_uri", new long[] { 
                    0, 1487, 2468, 3536, 4673, 5869, 7116, 8409, 9743, 11114, 12520, 13959, 15428, 16925, 18450, 20000, 21575, 23172, 24793, 26434, 30000 } } } },
                { "solar", new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
                  { { "cost_raw", new long[] { 
                    0, 707, 2923, 8000, 17469, 33068, 56718, 90510, 136688, 197642, 275902, 374123, 495087, 641694, 816957, 1024000, 1266051, 1546443, 1868605, 2236068, 2400000 } }, { "cost_cre", new long[] { 
                    0, 16352, 27144, 38891, 51403, 64560, 78279, 92499, 107171, 122257, 137725, 153550, 169708, 186180, 202949, 220000, 237320, 254896, 272719, 290777, 300000 } }, { "cost_uri", new long[] { 
                    0, 1487, 2468, 3536, 4673, 5869, 7116, 8409, 9743, 11114, 12520, 13959, 15428, 16925, 18450, 20000, 21575, 23172, 24793, 26434, 30000 } } } },
                { "collectors", new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
                  { { "cost_raw", new long[] { 
                    0, 50, 566, 2338, 6400, 13975, 26454, 45375, 72408, 109350, 158114, 220721, 299298, 396070, 513355, 653566, 819200, 1012841, 1237154, 1494884, 1788854 } }, { "cost_cre", new long[] { 
                    0, 5500, 13081, 21715, 31113, 41122, 51648, 62623, 73999, 85737, 97805, 110180, 122840, 135766, 148944, 162359, 176000, 189856, 203917, 218175, 232622 } }, { "cost_uri", new long[] { 
                    0, 500, 1189, 1974, 2828, 3738, 4695, 5693, 6727, 7794, 8891, 10016, 11167, 12342, 13540, 14760, 16000, 17260, 18538, 19834, 21147 } } } },
                { "refine", new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
                  { { "cost_raw", new long[] { 
                    0, 75, 849, 3507, 9600, 20963, 39682, 68062, 108612, 164025, 237171, 331082, 448948, 594205, 770033, 980349, 1228800, 1519261, 1855731, 2242327, 2683282 } }, { "cost_cre", new long[] { 
                    0, 8250, 19622, 32573, 46669, 61683, 77472, 93935, 110998, 128605, 146708, 165270, 184260, 203649, 223416, 243539, 264000, 284784, 305875, 327262, 348933 } }, { "cost_uri", new long[] { 
                    0, 750, 1784, 2961, 4243, 5608, 7043, 8540, 10091, 11691, 13337, 15025, 16751, 18514, 20311, 22140, 24000, 25889, 27807, 29751, 31721 } } } },
                { "refine_sep", new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
                  { { "cost_raw", new long[] { 
                    0, 250, 2828, 11691, 32000, 69877, 132271, 226873, 362039, 546750, 790569, 1103607, 1496492, 1980349, 2566777, 3267830, 4096000, 5064204, 6185770, 7474422, 8944272 } }, { "cost_cre", new long[] { 
                    0, 27500, 65406, 108576, 155563, 205610, 258239, 313116, 369994, 428683, 489027, 550901, 614199, 678831, 744720, 811796, 880000, 949279, 1019585, 1090874, 1163108 } }, { "cost_uri", new long[] { 
                    0, 2500, 5946, 9871, 14142, 18692, 23476, 28465, 33636, 38971, 44457, 50082, 55836, 61712, 67702, 73800, 80000, 86298, 92690, 99170, 105737 } } } },
                { "generator", new Dictionary<string, long[]>(StringComparer.OrdinalIgnoreCase)
                  { { "cost_raw", new long[] { 
                    0, 75, 849, 3507, 9600, 20963, 39682, 68062, 108612, 164025, 237171, 331082, 448948, 594205, 770033, 980349, 1228800, 1519261, 1855731, 2242327, 2683282 } }, { "cost_cre", new long[] { 
                    0, 8250, 19622, 32573, 46669, 61683, 77472, 93935, 110998, 128605, 146708, 165270, 184260, 203649, 223416, 243539, 264000, 284784, 305875, 327262, 348933 } }, { "cost_uri", new long[] { 
                    0, 750, 1784, 2961, 4243, 5608, 7043, 8540, 10091, 11691, 13337, 15025, 16751, 18514, 20311, 22140, 24000, 25889, 27807, 29751, 31721 } } } }
            };


        /// <summary>private upgrade_cost($type,$costtype,$level).</summary>
        private static long UpgradeCost(string type, string costType, long level)
        {
            Dictionary<string, long[]> t;
            if (!UpgradeCostTable.TryGetValue(type, out t)) return 0;
            long[] arrT;
            if (!t.TryGetValue(costType, out arrT)) return 0;
            if (level < 0 || level >= arrT.Length) return 0;
            return arrT[(int)level];
        }

        // ------------------------------------------------------------------
        // helpers (те же, что в Clan.cs; переедут в общий утилитный класс
        // при рефакторинге после фазы A)
        // ------------------------------------------------------------------

        protected static long UnixNow()
        {
            return (long)(DateTime.UtcNow - new DateTime(1970, 1, 1, 0, 0, 0, DateTimeKind.Utc))
                       .TotalSeconds;
        }

        protected static long ParseLong(string s)
        {
            long v;
            return long.TryParse(s, NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        protected static KeyValuePair<string, object> Kv(string name, object value)
        {
            return new KeyValuePair<string, object>(name, value);
        }

        /// <summary>Типизированный вариант Kv для foreach-массивов.</summary>
        protected static KeyValuePair<string, object> Kvp(string name, object value)
        {
            return new KeyValuePair<string, object>(name, value);
        }

        /// <summary>Строго типизированный Kv (для массивов с единым значением типа).</summary>
        protected static KeyValuePair<string, T> KvpT<T>(string name, T value)
        {
            return new KeyValuePair<string, T>(name, value);
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
    }
}
