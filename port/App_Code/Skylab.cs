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
