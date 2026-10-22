using System;
using System.Web.SessionState;

namespace DarkSpace
{
    /// <summary>
    /// Port of the $_SESSION['server1']['user'] structure used across index.php,
    /// Class.Users.php (checkSession) and Init.php ($Users->checkSession(); $nID = ...).
    /// Also ports the "AntiHTML & SQL Injection" input sanitisation applied to
    /// $_POST / $_GET at the end of Init.php.
    /// </summary>
    public static class SessionManager
    {
        private const string KeySessionId = "server1_user_sessionId";
        private const string KeyEmail = "server1_user_email";
        private const string KeyVerified = "server1_user_verified";
        private const string KeyErrorData = "errorData";

        public static string SessionId(HttpSessionState s) { return s[KeySessionId] as string ?? ""; }
        public static string Email(HttpSessionState s) { return s[KeyEmail] as string ?? ""; }
        public static bool IsLoggedIn(HttpSessionState s)
        {
            long tmp;
            return !string.IsNullOrEmpty(SessionId(s)) && !string.IsNullOrEmpty(Email(s))
                   && long.TryParse(SessionId(s), out tmp); // PHP: is_numeric($_SESSION[...]['sessionId'])
        }

        public static void SetLogin(HttpSessionState s, string sessionId, string email, bool verified)
        {
            s[KeySessionId] = sessionId;
            s[KeyEmail] = email;
            s[KeyVerified] = verified;
        }

        public static bool Verified(HttpSessionState s)
        {
            object o = s[KeyVerified];
            return o != null && (bool)o;
        }

        /// <summary>$_SESSION['errorData'] .= ... pattern.</summary>
        public static void AppendError(HttpSessionState s, string html)
        {
            s[KeyErrorData] = (s[KeyErrorData] as string ?? "") + html;
        }

        public static string ErrorData(HttpSessionState s)
        {
            return s[KeyErrorData] as string ?? "";
        }

        public static void ClearError(HttpSessionState s)
        {
            s[KeyErrorData] = "";
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
