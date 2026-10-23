using System.Collections.Generic;
using System.Globalization;
using System.Text;

namespace DarkSpace
{
    /// <summary>
    /// Builder for the xajax 0.5 XML response format ("xjx" document), matching
    /// what the legacy /xajaxAPI.php emitted and what js/xajax_core.js parses:
    ///   &lt;xjx&gt;&lt;cmd cmd="..." id="..." prop="..."&gt;&lt;![CDATA[S...]]&gt;&lt;/cmd&gt;
    ///   &lt;cmd cmd="jc" func="f"&gt;&lt;xjxobj&gt;&lt;e&gt;&lt;k&gt;..&lt;/k&gt;&lt;v&gt;..&lt;/v&gt;&lt;/e&gt;&lt;/xjxobj&gt;&lt;/cmd&gt;
    /// Values are prefixed with "S" (raw string type) exactly like the PHP original.
    /// </summary>
    public class XajaxResponse
    {
        private readonly List<string> _cmds = new List<string>();

        /// <summary>&lt;cmd cmd="as" id=.. prop=..&gt; — assign property / innerHTML on the client.</summary>
        public XajaxResponse Assign(string id, string prop, string value)
        {
            _cmds.Add("<cmd cmd=\"as\" id=\"" + (id ?? "") + "\" prop=\"" + (prop ?? "") + "\"><![CDATA[S" + value + "]]></cmd>");
            return this;
        }

        /// <summary>&lt;cmd cmd="js"&gt; — execute raw JS on the client.</summary>
        public XajaxResponse Js(string code)
        {
            _cmds.Add("<cmd cmd=\"js\"><![CDATA[S" + code + "]]></cmd>");
            return this;
        }

        /// <summary>&lt;cmd cmd="jc" func=..&gt; with an xjxobj argument list (k/v pairs).</summary>
        public XajaxResponse CallClientFunc(string func, IEnumerable<KeyValuePair<string, string>> args)
        {
            var sb = new StringBuilder();
            sb.Append("<cmd cmd=\"jc\" func=\"").Append(func ?? "").Append("\"><xjxobj>");
            if (args != null)
                foreach (var kv in args)
                    sb.Append("<e><k>").Append(kv.Key).Append("</k><v>").Append(kv.Value).Append("</v></e>");
            sb.Append("</xjxobj></cmd>");
            _cmds.Add(sb.ToString());
            return this;
        }

        /// <summary>Full XML document ("&lt;?xml ...?&gt;&lt;xjx&gt;...&lt;/xjx&gt;").</summary>
        public string ToXml()
        {
            var sb = new StringBuilder();
            sb.Append("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\n<xjx>");
            foreach (var c in _cmds) sb.Append(c);
            sb.Append("</xjx>");
            return sb.ToString();
        }
    }

    /// <summary>PHP-compatible numeric formatting helpers used by the ajax endpoints.</summary>
    internal static class PhpFormat
    {
        /// <summary>PHP number_format($x, 0, '.', ',') — thousands separator, truncates toward zero.</summary>
        public static string NumberFormat(double x)
        {
            long l = (long)x; // number_format truncates toward zero
            return l.ToString("#,##0", CultureInfo.InvariantCulture);
        }

        /// <summary>PHP round() — half away from zero.</summary>
        public static long Round(double x)
        {
            return (long)System.Math.Round(x, System.MidpointRounding.AwayFromZero);
        }
    }
}
