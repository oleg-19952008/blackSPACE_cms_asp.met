using System;
using System.Collections.Generic;
using System.Globalization;
using Microsoft.AspNetCore.Http;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// ASP.NET Core rewrite of api.ashx.cs (port of api/index.php) — XML-RPC endpoint
    /// (IXR_Server) exposing "api.oce" ("orderComplete"). The payment partner POSTs
    /// [cryptKey, base64(json)] and the handler grants premium/uridium/kit donations.
    /// Legacy URL: /api/ -> mapped in Program.cs to the same minimal-API endpoint.
    /// </summary>
    public static class ApiEndpoints
    {
        // args[0] secret from api/index.php orderComplete()
        private const string CryptKey = "cryptKeyingc25vd3lhZG1pbg0K";

        /// <summary>ApiHandler.ProcessRequest: build IXR server, register api.oce, serve.</summary>
        public static System.Threading.Tasks.Task ServeAsync(HttpContext ctx)
        {
            var server = new IxrServer();
            server.Register(new List<KeyValuePair<string, Func<object[], object>>>
            {
                new KeyValuePair<string, Func<object[], object>>("api.oce", OrderComplete),
            });
            return server.ServeRequest(ctx);
        }

        /// <summary>api::orderComplete($args).</summary>
        public static object OrderComplete(object[] args)
        {
            if (args != null && args.Length > 0 && Convert.ToString(args[0], CultureInfo.InvariantCulture) == CryptKey)
            {
                Gdi(args);
                return true; // IXR serialises PHP TRUE
            }
            return false;
        }

        /// <summary>api::gDI($args) — give Donation Items.</summary>
        private static void Gdi(object[] args)
        {
            const bool mhh = false; // parity with the $mhh flag in the PHP original
            if (args == null || args.Length < 2) return;

            string b64 = Convert.ToString(args[1], CultureInfo.InvariantCulture);
            var stdJson = JsonUtil.DecodeObject(EncodingHelper.Base64DecodeUtf8(b64));
            if (stdJson == null) return;

            long playerID = JsonUtil.ToLong(Get(stdJson, "playerID"));
            string package = JsonUtil.Str(stdJson, "package");
            string currency = JsonUtil.Str(stdJson, "currency");
            string price = JsonUtil.Str(stdJson, "price");
            string gross = JsonUtil.Str(stdJson, "gross");
            long error = JsonUtil.ToLong(Get(stdJson, "error"));

            if (error == 0)
            {
                if (package == "premium")
                {
                    long period = JsonUtil.ToLong(Get(stdJson, "period"));
                    string loglist = "9|" + playerID + "|" + price + "|0|" + currency + "|" + gross;
                    DB.Pmc(playerID, loglist, "donations");
                    var unity = new Unity();
                    if (unity.Apt(playerID, (int)period))
                        DB.SetLog(playerID, "You bought " + period + " days of " + package);
                    else
                        DB.SetLog(playerID, "Something went wrong with your purchase of " + period +
                                            " days of " + package + ", please contact support!");
                }
                else if (package == "uridium")
                {
                    long atype = JsonUtil.ToLong(Get(stdJson, "a"));
                    if (mhh) atype = atype * 3;
                    string loglist = "10|" + playerID + "|" + price + "|" + atype + "|0|" + currency + "|" + gross;
                    DB.Pmc(playerID, loglist, "donations");
                    using (var con = DB.GetInstance())
                    using (var cmd = new MySqlCommand(
                        "UPDATE server_1_players SET uri = uri + @a WHERE playerID=@pid", con))
                    {
                        cmd.Parameters.AddWithValue("@a", atype);
                        cmd.Parameters.AddWithValue("@pid", playerID);
                        if (cmd.ExecuteNonQuery() >= 0)
                            DB.SetLog(playerID, "You bought " +
                                atype.ToString("#,##0", CultureInfo.InvariantCulture) + " units of " + package);
                        else
                            DB.SetLog(playerID, "Something went wrong with your purchase of " + package +
                                                ", please contact support!");
                    }
                }
                else if (package == "kit")
                {
                    DB.SetLog(playerID, "Please contact support about you game Kit!");
                }
            }
            else
            {
                string loglist = null;
                if (package == "premium")
                    loglist = "9|" + playerID + "|" + price + "|1|" + currency + "|" + gross;
                else if (package == "uridium")
                    loglist = "10|" + playerID + "|" + price + "|" + package + "|1|" + currency + "|" + gross;

                if (loglist != null) DB.Pmc(playerID, loglist, "donations");
            }
        }

        private static object Get(IDictionary<string, object> d, string key)
        {
            object o;
            return d != null && d.TryGetValue(key, out o) ? o : null;
        }
    }

    /// <summary>Base64 helpers matching PHP base64_decode semantics (strict off).</summary>
    internal static class EncodingHelper
    {
        public static string Base64DecodeUtf8(string s)
        {
            if (string.IsNullOrEmpty(s)) return "";
            try { return System.Text.Encoding.UTF8.GetString(Convert.FromBase64String(s)); }
            catch (FormatException) { return ""; }
        }
    }
}
