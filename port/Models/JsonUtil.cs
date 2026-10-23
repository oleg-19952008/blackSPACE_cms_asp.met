using System;
using System.Collections.Generic;

namespace DarkSpace
{
    /// <summary>
    /// Small JSON helpers used by the page layer (Part 3).
    /// Newtonsoft.Json is referenced via packages.config.
    /// </summary>
    public static class JsonUtil
    {
        /// <summary>PHP json_decode($s) as assoc array; null on failure.</summary>
        public static Dictionary<string, object> DecodeObject(string json)
        {
            if (string.IsNullOrEmpty(json)) return null;
            try
            {
                return Newtonsoft.Json.JsonConvert.DeserializeObject<Dictionary<string, object>>(json);
            }
            catch (Exception)
            {
                return null;
            }
        }

        /// <summary>Safe string getter for assoc rows (works for both &lt;string,string&gt; and &lt;string,object&gt; dictionaries).</summary>
        public static string Str(IDictionary<string, string> d, string key)
        {
            string o;
            return d != null && d.TryGetValue(key, out o) && o != null ? o : "";
        }

        /// <summary>PHP json_encode(array('status'=>..,'message'=>..)) for AJAX error replies.</summary>
        public static string StatusMessage(string status, string message)
        {
            return Newtonsoft.Json.JsonConvert.SerializeObject(
                new Dictionary<string, string> { { "status", status }, { "message", message } });
        }

        public static long ToLong(object o)
        {
            if (o == null) return 0;
            try { return Convert.ToInt64(o); }
            catch { long v; return long.TryParse(Convert.ToString(o), out v) ? v : 0; }
        }

        public static string Str(Dictionary<string, object> d, string key)
        {
            object o;
            return d != null && d.TryGetValue(key, out o) && o != null ? Convert.ToString(o) : "";
        }
    }
}
