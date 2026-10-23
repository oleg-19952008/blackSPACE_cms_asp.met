using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Text;
using System.Text.RegularExpressions;

namespace DarkSpace
{
    /// <summary>
    /// Port of the repeated require-chain inside indexInternal.es.php (фаза B2):
    ///   internalDoc.php -> &lt;css link&gt; -> internalDocEnd.php -> sajax.php -> xajax.php
    ///   -> headerEndJS.php -> internalMenu.php -> internalHeader.php -> &lt;Body-шаблон&gt;
    ///   -> ads.php
    /// The GLOBALS fragments were copied verbatim into
    /// templates/legacy/&lt;Lang&gt;/GLOBAL/*.php with their few inline PHP echoes replaced
    /// by {{TOKEN}} placeholders (see ResolveToken). Body templates live in
    /// templates/legacy/&lt;Lang&gt;/INDEXINTERNAL/&lt;name&gt;.html and may reference further
    /// tokens supplied per branch via vars.
    /// </summary>
    public static class PhpTemplateRenderer
    {
        private static readonly Regex TokenRx = new Regex(@"\{\{(\w+)\}\}");
        private static readonly Dictionary<string, string> Cache = new Dictionary<string, string>(StringComparer.Ordinal);
        private static readonly object CacheLock = new object();

        /// <summary>Тестовый хук: явный корень шаблонов вместо BaseDirectory.</summary>
        public static string RootOverride;

        /// <summary>
        /// Доп. GLOBALS-фрагменты, вставляемые между internalHeader.php и Body-шаблоном
        /// (в оригинале это require FILES.'GLOBAL/internalHelpLayer.php' и т.п. внутри
        /// веток диспетчера). Задаётся веткой диспетчера перед RenderShell, очищается после.
        /// </summary>
        public static List<string> ExtraHeaderFragments = new List<string>();

        /// <summary>Корень GLOBALS-фрагментов (FILES/Lang/GLOBAL в терминах Init.php).</summary>
        public static string GlobalsRoot
        {
            get
            {
                if (RootOverride != null) return Path.Combine(RootOverride, AppConfig.Lang, "GLOBALS");
                var env = AppEnvironment.Current;
                return env != null
                    ? env.MapPath("templates/legacy/" + AppConfig.Lang + "/GLOBALS")
                    : Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "templates", "legacy", AppConfig.Lang, "GLOBALS");
            }
        }

        /// <summary>Корень Body-шаблонов (FILES/Lang/INDEXINTERNAL).</summary>
        public static string IndexInternalRoot
        {
            get
            {
                if (RootOverride != null) return Path.Combine(RootOverride, AppConfig.Lang, "INDEXINTERNAL");
                var env = AppEnvironment.Current;
                return env != null
                    ? env.MapPath("templates/legacy/" + AppConfig.Lang + "/INDEXINTERNAL")
                    : Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "templates", "legacy", AppConfig.Lang, "INDEXINTERNAL");
            }
        }

        /// <summary>
        /// Единый рендер оболочки для одной ветки диспетчера. bodyTemplate — имя файла
        /// Body-шаблона без расширения (может отсутствовать до фазы C: тогда отдаётся
        /// заглушка-панель). cssHref — echo '&lt;link ... href=CSS /&gt;' между internalDoc
        /// и internalDocEnd, как во всех ветках оригинала. logMessage/logType — переменные
        /// $log_message/$type, которые классы-обработчики возвращают шаблонам.
        /// </summary>
        public static string RenderShell(Users users, string bodyTemplate, string cssHref,
                                         IDictionary<string, string> vars = null,
                                         string logMessage = null, string logType = null)
        {
            return RenderShell(users, bodyTemplate, cssHref, beforeBody: null,
                               vars: vars, logMessage: logMessage, logType: logType);
        }

        /// <summary>
        /// Overload с preambulo-колбэком: выполняется ПОСЛЕ require GLOBALS (menu/header),
        /// ПЕРЕД Body-рендером — точно в позиции positionального require/echo внутри
        /// Body-шаблона оригинала (например internalClan_Body.php строки 1–40).
        /// Колбэк возвращает доп. ctx-токены (могут быть null — тогда только побочный вывод).
        /// </summary>
        public static string RenderShell(Users users, string bodyTemplate, string cssHref,
                                         Func<IDictionary<string, string>, IDictionary<string, string>> beforeBody,
                                         IDictionary<string, string> vars = null,
                                         string logMessage = null, string logType = null)
        {
            var ctx = new Dictionary<string, string>(StringComparer.Ordinal);
            long pid = users != null && users.DataRow != null ? PlayerLog.ToLong(users.DataRow["playerID"]) : 0;
            long fid = users != null && users.DataRow != null ? PlayerLog.ToLong(users.DataRow["factionId"]) : 0;
            ctx["PLAYERID"] = pid.ToString(CultureInfo.InvariantCulture);
            ctx["FACTIONNAME"] = fid == 1 ? "mmo" : (fid == 2 ? "eic" : "vru");
            // $_SESSION['server1']['user']['sessionId'] — ключ ISession из SessionManager;
            // CurrentSession выставляется InternalModel.Process() перед диспетчером.
            ctx["SESSIONID"] = CurrentSession != null ? SessionManager.SessionId(CurrentSession) ?? "" : "";
            ctx["RND_SID"] = Convert.ToBase64String(Encoding.UTF8.GetBytes(
                new Random().Next(10000, 100000000).ToString(CultureInfo.InvariantCulture)));
            ctx["TIME"] = UnixNow().ToString(CultureInfo.InvariantCulture);
            ctx["DYNHOST"] = AppConfig.DynHost;
            ctx["SERVER"] = AppConfig.Server;
            ctx["HOST"] = AppConfig.Host;
            // Phase C: positionальные require GLOBALS внутри Body-шаблонов переносятся в
            // токены {{HELP_NEWS_INCLUDE}} / {{HEADER_INTERN_INCLUDE}} / {{CREDITS_INCLUDE}}.
            // По умолчанию задаются здесь, чтобы любой Shell()-рендер был полным; ветки с
            // собственными PHP-преамбулами (internalStart/PilotSheet) перезаписывают их своими vars.
            if (vars == null || !vars.ContainsKey("HELP_NEWS_INCLUDE"))
                ctx["HELP_NEWS_INCLUDE"] = FillFragment("internalHelpLayer", ctx) + FillFragment("internalNews", ctx);
            if (vars == null || !vars.ContainsKey("HEADER_INTERN_INCLUDE"))
                ctx["HEADER_INTERN_INCLUDE"] = FillFragment("internalHeaderIntern", ctx);
            if (vars == null || !vars.ContainsKey("CREDITS_INCLUDE"))
                ctx["CREDITS_INCLUDE"] = FillFragment("credits", ctx);
            if (vars != null) foreach (var kv in vars) ctx[kv.Key] = kv.Value ?? "";
            if (logMessage != null) { ctx["LOG_MESSAGE"] = logMessage; ctx["LOG_TYPE"] = logType ?? ""; }

            var sb = new StringBuilder();
            AppendFragment(sb, "internalDoc.php", ctx);
            // echo '<link rel="stylesheet" media="all" href="..." />';
            sb.Append("<link rel=\"stylesheet\" media=\"all\" href=\"")
              .Append(System.Net.WebUtility.HtmlEncode(cssHref ?? "")).Append("\" />\n");
            AppendFragment(sb, "internalDocEnd.php", ctx);
            AppendFragment(sb, "sajax.php", ctx);
            AppendFragment(sb, "xajax.php", ctx);
            AppendFragment(sb, "headerEndJS.php", ctx);
            AppendFragment(sb, "internalMenu.php", ctx);
            AppendFragment(sb, "internalHeader.php", ctx);
            foreach (var frag in ExtraHeaderFragments)
                AppendFragment(sb, frag, ctx);
            if (beforeBody != null)
            {
                var extra = beforeBody(ctx);
                if (extra != null) foreach (var kv in extra) ctx[kv.Key] = kv.Value ?? "";
            }
            sb.Append(RenderBody(users, bodyTemplate, ctx));
            AppendFragment(sb, "ads.php", ctx);   // ads.php пустой в оригинале — no-op
            return sb.ToString();
        }

        /// <summary>require FILES . 'INDEXINTERNAL/&lt;tpl&gt;.php' — шаблон или smoke-заглушка.</summary>
        public static string RenderBody(Users users, string bodyTemplate, IDictionary<string, string> ctx)
        {
            string raw = LoadRaw(IndexInternalRoot, bodyTemplate);
            if (raw == null)
            {
                return "<div id=\"" + SafeName(bodyTemplate) + "Panel\"><h3>"
                       + System.Net.WebUtility.HtmlEncode(bodyTemplate)
                       + "</h3><p>Template pending phase C (templates/INDEXINTERNAL/"
                       + System.Net.WebUtility.HtmlEncode(bodyTemplate) + ".html).</p></div>";
            }
            // Phase C: positionальные require GLOBALS внутри Body-шаблонов. Если ветка не
            // задала токены явно (internalStart/PilotSheet задают своими vars), подставляем
            // дефолты из ctx — тот же механизм, что в RenderShell.
            if (ctx != null)
            {
                if (!ctx.ContainsKey("HELP_NEWS_INCLUDE"))
                    ctx["HELP_NEWS_INCLUDE"] = FillFragment("internalHelpLayer", ctx) + FillFragment("internalNews", ctx);
                if (!ctx.ContainsKey("HEADER_INTERN_INCLUDE"))
                    ctx["HEADER_INTERN_INCLUDE"] = FillFragment("internalHeaderIntern", ctx);
                if (!ctx.ContainsKey("CREDITS_INCLUDE"))
                    ctx["CREDITS_INCLUDE"] = FillFragment("credits", ctx);
            }
            return Fill(raw, ctx);
        }

        /// <summary>Подстановка токенов из ctx; неизвестные токены снимаются (как unset-echo в PHP).</summary>
        public static string Fill(string raw, IDictionary<string, string> ctx)
        {
            if (ctx == null) return raw;
            return TokenRx.Replace(raw, m =>
            {
                string v;
                return ctx.TryGetValue(m.Groups[1].Value, out v) ? (v ?? "") : "";
            });
        }

        private static void AppendFragment(StringBuilder sb, string fileName, Dictionary<string, string> ctx)
        {
            string raw = LoadRaw(GlobalsRoot, Path.GetFileNameWithoutExtension(fileName));
            if (raw == null) return; // отсутствие фрагмента = пустой require (warning-free parity)
            sb.Append(Fill(raw, ctx));
        }

        /// <summary>Fill GLOBALS-фрагмента теми же vars, что и Body-шаблон (phase C includes).</summary>
        public static string FillFragment(string name, IDictionary<string, string> vars)
        {
            string raw = LoadRaw(GlobalsRoot, name);
            return raw == null ? "" : Fill(raw, vars);
        }

        public static string LoadRaw(string root, string safeName)
        {
            if (!Regex.IsMatch(safeName ?? "", @"^[A-Za-z0-9_-]+$")) return null; // path-traversal guard
            string key = root + "|" + safeName;
            lock (CacheLock)
            {
                string cached;
                if (Cache.TryGetValue(key, out cached)) return cached;
            }
            string path = Path.Combine(root, safeName + ".php");
            if (!File.Exists(path))
                path = Path.Combine(root, safeName + ".html");
            string content = File.Exists(path) ? File.ReadAllText(path) : null;
            lock (CacheLock) { Cache[key] = content; }
            return content;
        }

        private static string SafeName(string s)
        {
            return Regex.IsMatch(s ?? "", @"^[A-Za-z0-9_-]+$") ? s : "body";
        }

        private static long UnixNow()
        {
            return (long)(DateTime.UtcNow - new DateTime(1970, 1, 1, 0, 0, 0, DateTimeKind.Utc))
                .TotalSeconds;
        }

        /// <summary>Текущий ISession (выставляется InternalModel перед рендером).</summary>
        public static Microsoft.AspNetCore.Http.ISession CurrentSession { get; set; }
    }
}
