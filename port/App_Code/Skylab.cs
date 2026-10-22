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
                ? Math.Floor(RessourceGeneration("raw", _collectorPrometium.Level) / 3600.0) : 0;
            double enduriumPerSec = _collectorEndurium.Status == 1
                ? Math.Floor(RessourceGeneration("raw", _collectorEndurium.Level) / 3600.0) : 0;
            double terbiumPerSec = _collectorTerbium.Status == 1
                ? Math.Floor(RessourceGeneration("raw", _collectorTerbium.Level) / 3600.0) : 0;

            double prometidPerSec = 0, duraniumPerSec = 0, promeriumPerSec = 0, sepromPerSec = 0, xenoPerSec = 0;
            double? prometiumUsage = null, enduriumUsage1 = null, enduriumUsage2 = null,
                   terbiumUsage = null, prometidUsage = null, duraniumUsage = null, promeriumUsage = null;

            if (_refinePrometid.Status == 1)
            {
                prometidPerSec = Math.Floor(RessourceGeneration("refined", _refinePrometid.Level) / 3600.0);
                prometiumUsage = prometidPerSec * 20;
                enduriumUsage1 = prometidPerSec * 10;
            }

            if (_refineDuranium.Status == 1)
            {
                duraniumPerSec = Math.Floor(RessourceGeneration("refined", _refineDuranium.Level) / 3600.0);
                terbiumUsage = duraniumPerSec * 20;
                enduriumUsage2 = duraniumPerSec * 10;
            }

            if (_refinePromerium.Status == 1)
            {
                promeriumPerSec = Math.Floor(RessourceGeneration("proxeno", _refinePromerium.Level) / 3600.0);
                prometidUsage = promeriumPerSec * 10;
                duraniumUsage = promeriumPerSec * 10;
            }

            if (_refineSeprom.Status == 1)
            {
                sepromPerSec = Math.Floor(RessourceGeneration("seprom", _refineSeprom.Level) / 3600.0);
                promeriumUsage = sepromPerSec * 10;
            }

            if (_generatorXeno.Status == 1)
                xenoPerSec = Math.Floor(RessourceGeneration("proxeno", _generatorXeno.Level) / 3600.0);

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
        // Формулы из A2.6, подтянуты сюда, потому что ressupdate их вызывает.
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
            long v;
            return _ressourcesArray != null && _ressourcesArray.TryGetValue(key, out v) ? v : 0;
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

        /// <summary>private ressource_generation($type,$level) — ед/час на уровень.</summary>
        private double RessourceGeneration(string type, long level)
        {
            long[] t;
            if (!GenerationTable.TryGetValue(type, out t)) return 0;
            // PHP-паритет: $gen[$type][$level] при level за пределами массива -> notice + null (0)
            if (level < 0 || level >= t.Length) return 0;
            return t[(int)level];
        }

        /// <summary>private storage($type,$level) — максимальный запас на уровень мода хранилища.</summary>
        private long Storage(string type, long level)
        {
            long[] t;
            if (!StorageTable.TryGetValue(type, out t)) return 0;
            // PHP-паритет: $storage[$type][$level] вне диапазона -> null (0).
            // В оригинале proxeno-массив storage() содержит 20 значений (индексы 0..19),
            // т.е. на 20 уровне хранилище proxeno = 0 — сохранено как есть.
            if (level < 0 || level >= t.Length) return 0;
            return t[(int)level];
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
