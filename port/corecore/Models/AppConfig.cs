using System;
using Microsoft.Extensions.Configuration;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Server.Config.php + the URL/host resolution block of Init.php.
    /// Exposes the PHP constants SERVER, HOST, sSERVER, FILES, GLOBALS, DynHost as statics.
    /// ASP.NET Core rewrite: ConfigurationManager.AppSettings -> IConfiguration["App:*"].
    /// </summary>
    public static class AppConfig
    {
        public static TimeZoneInfo TimeZone = TimeZoneInfo.Utc;

        private static IConfiguration _configuration;

        /// <summary>Вызывается из Program.cs (builder.Configuration) — замена web.config appSettings.</summary>
        public static void Initialize(IConfiguration configuration)
        {
            _configuration = configuration;
        }

        // define("HOST"...) / define("SERVER"...) / define("sSERVER"...) in Init.php
        public static string Host = "";
        public static string Server = "";    // http://...
        public static string SServer = "";   // https-aware
        public static string Lang = "en_US";

        public static string Get(string key, string fallback = "")
        {
            string v = _configuration != null ? _configuration["App:" + key] : null;
            return string.IsNullOrEmpty(v) ? fallback : v;
        }

        public static bool GetBool(string key, bool fallback = false)
        {
            string v = _configuration != null ? _configuration["App:" + key] : null;
            bool r;
            return bool.TryParse(v, out r) ? r : fallback;
        }

        /// <summary>$maintenance == TRUE branch from Init.php.</summary>
        public static bool Maintenance
        {
            get { return GetBool("Maintenance.Enabled", false); }
        }

        /// <summary>$regist flag from index.php.</summary>
        public static bool RegistrationEnabled
        {
            get { return GetBool("Registration.Enabled", true); }
        }

        /// <summary>
        /// Mirrors the if/elseif chain over $Config['URL'] in Init.php:
        /// devPrivateServer -> Other[host] -> Default.
        /// ASP.NET Core: serverName comes from HttpContext.Request.Host (was ServerVariables["SERVER_NAME"]).
        /// </summary>
        public static void ResolveHostNames(string serverName)
        {
            if (string.IsNullOrEmpty(serverName))
                serverName = Environment.MachineName;

            string devPrivate = Get("URL.DevPrivateServer");
            bool requireWww = GetBool("URL.Default.RequireWww");
            bool ssl = GetBool("URL.Default.SslEnabled");
            string defaultServer = Get("URL.Default.Server", "127.0.0.1");

            if (!string.IsNullOrEmpty(serverName) && !string.IsNullOrEmpty(devPrivate) && devPrivate == serverName)
            {
                Lang = Get("URL.Default.Lang", "en_US");
                Host = serverName;
                Server = "http://" + serverName;
                SServer = "http://" + serverName;
            }
            else if (!string.IsNullOrEmpty(defaultServer))
            {
                Lang = Get("URL.Default.Lang", "en_US");
                Host = requireWww ? "www." + defaultServer : defaultServer;
                Server = (requireWww ? "http://www." : "http://") + defaultServer;
                SServer = (ssl ? "https://" : "http://") + Host;
            }
            else
            {
                // PHP: echo "You don't have access."; exit;
                throw new InvalidOperationException("No matching server configuration.");
            }
        }

        /// <summary>DEFINE('DynHost', '127.0.0.1')</summary>
        public static string DynHost
        {
            get { return Get("DynHost", "127.0.0.1"); }
        }

        /// <summary>Encryption key used by Init.php: new Encryption("5eqD0fpzf9JzaKWP")</summary>
        public static string EncryptionKey
        {
            get { return Get("Encryption.Key", "5eqD0fpzf9JzaKWP"); }
        }
    }
}
