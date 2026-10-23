using System;
using Microsoft.AspNetCore.Http;

namespace DarkSpace
{
    /// <summary>
    /// Port of the $_SESSION['server1']['user'] structure used across index.php,
    /// Class.Users.php (checkSession) and Init.php ($Users->checkSession(); $nID = ...).
    /// Also ports the "AntiHTML & SQL Injection" input sanitisation applied to
    /// $_POST / $_GET at the end of Init.php.
    /// ASP.NET Core rewrite: HttpSessionState -> ISession (string-based API).
    /// </summary>
    public static class SessionManager
    {
        private const string KeySessionId = "server1_user_sessionId";
        private const string KeyEmail = "server1_user_email";
        private const string KeyVerified = "server1_user_verified";
        private const string KeyErrorData = "errorData";

        public static string SessionId(ISession s) { return s == null ? "" : (s.GetString(KeySessionId) ?? ""); }
        public static string Email(ISession s) { return s == null ? "" : (s.GetString(KeyEmail) ?? ""); }
        public static bool IsLoggedIn(ISession s)
        {
            if (s == null) return false;
            long tmp;
            return !string.IsNullOrEmpty(SessionId(s)) && !string.IsNullOrEmpty(Email(s))
                   && long.TryParse(SessionId(s), out tmp); // PHP: is_numeric($_SESSION[...]['sessionId'])
        }

        public static void SetLogin(ISession s, string sessionId, string email, bool verified)
        {
            s.SetString(KeySessionId, sessionId);
            s.SetString(KeyEmail, email);
            s.SetString(KeyVerified, verified ? "1" : "0");
        }

        public static bool Verified(ISession s)
        {
            return s != null && s.GetString(KeyVerified) == "1";
        }

        /// <summary>$_SESSION['errorData'] .= ... pattern.</summary>
        public static void AppendError(ISession s, string html)
        {
            s.SetString(KeyErrorData, (s.GetString(KeyErrorData) ?? "") + html);
        }

        public static string ErrorData(ISession s)
        {
            return s == null ? "" : (s.GetString(KeyErrorData) ?? "");
        }

        public static void ClearError(ISession s)
        {
            s.SetString(KeyErrorData, "");
        }

        /// <summary>
        /// $_SESSION['Upgradeings'][$itemID]['success'] — written by base::upgradeItem(),
        /// read back by the upgrade UI on the next request. Stored as a serialized map.
        /// </summary>
        private const string KeyUpgradeings = "Upgradeings";

        public static void SetUpgradeSuccess(ISession s, string itemId, int success)
        {
            var map = GetUpgradeings(s);
            map[itemId] = success;
            s.SetString(KeyUpgradeings, Newtonsoft.Json.JsonConvert.SerializeObject(map));
        }

        public static System.Collections.Generic.Dictionary<string, int> GetUpgradeings(ISession s)
        {
            string json = s == null ? null : s.GetString(KeyUpgradeings);
            if (string.IsNullOrEmpty(json))
                return new System.Collections.Generic.Dictionary<string, int>();
            try
            {
                return Newtonsoft.Json.JsonConvert.DeserializeObject<System.Collections.Generic.Dictionary<string, int>>(json)
                       ?? new System.Collections.Generic.Dictionary<string, int>();
            }
            catch (Newtonsoft.Json.JsonException)
            {
                return new System.Collections.Generic.Dictionary<string, int>();
            }
        }

        /// <summary>
        /// Init.php: str_replace(['<','>',"'","\u2018","'",'\\'], ['&lt;','&gt;','&quot;','&#39;','&#92;'], $arr)
        /// Applied to every POST/GET value before business logic runs.
        /// </summary>
        public static string SanitizeInput(string value)
        {
            if (value == null) return null;
            var sb = new System.Text.StringBuilder(value.Length);
            foreach (char ch in value)
            {
                switch (ch)
                {
                    case '<': sb.Append("&lt;"); break;
                    case '>': sb.Append("&gt;"); break;
                    case '"': sb.Append("&quot;"); break;
                    case '\'': sb.Append("&#39;"); break;
                    case '‘': sb.Append("&#39;"); break;
                    case '\\': sb.Append("&#92;"); break;
                    default: sb.Append(ch); break;
                }
            }
            return sb.ToString();
        }
    }
}
