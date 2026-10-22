using System;
using System.Collections;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Text;
using System.Xml;

namespace DarkSpace
{
    /// <summary>
    /// Minimal XML-RPC server (IXR_Server equivalent from libs/IXR_Library.php) —
    /// enough to serve the api.oce endpoint used by the payment partner.
    /// Only scalar types, arrays and structs are supported on both sides.
    /// </summary>
    public class IxrServer
    {
        private readonly Dictionary<string, Func<object[], object>> _callMap =
            new Dictionary<string, Func<object[], object>>(StringComparer.Ordinal);

        /// <summary>IXR_Server($callmap): registers method-name -> delegate.</summary>
        public void Register(IList<KeyValuePair<string, Func<object[], object>>> callMap)
        {
            foreach (var kv in callMap) _callMap[kv.Key] = kv.Value;
        }

        /// <summary>Reads the raw POST envelope, dispatches, and writes the XML response.</summary>
        public void ServeRequest(System.Web.HttpContext ctx)
        {
            string raw;
            using (var sr = new StreamReader(ctx.Request.InputStream, Encoding.UTF8))
                raw = sr.ReadToEnd();

            ctx.Response.ContentType = "text/xml";

            object[] paramsList;
            string methodName;
            if (!ParseRequest(raw, out methodName, out paramsList))
            {
                ctx.Response.Write(EncodeFault(-32700, "Parse error"));
                return;
            }

            Func<object[], object> handler;
            if (!_callMap.TryGetValue(methodName, out handler))
            {
                ctx.Response.Write(EncodeFault(-32601, "Invalid method name: " + methodName));
                return;
            }

            object result;
            try { result = handler(paramsList); }
            catch (Exception e)
            {
                ctx.Response.Write(EncodeFault(-32603, e.Message));
                return;
            }
            ctx.Response.Write(EncodeResponse(result));
        }

        // ------------------------------------------------------------- parsing

        private static bool ParseRequest(string raw, out string methodName, out object[] prms)
        {
            methodName = null;
            prms = new object[0];
            try
            {
                var doc = new XmlDocument();
                doc.LoadXml(raw);
                var method = doc.SelectSingleNode("//methodName");
                if (method == null) return false;
                methodName = method.InnerText;

                var paramNodes = doc.SelectNodes("//params/param/value/*");
                var list = new List<object>();
                if (paramNodes != null)
                    foreach (XmlNode n in paramNodes) list.Add(DecodeNode(n));
                prms = list.ToArray();
                return true;
            }
            catch (XmlException)
            {
                return false;
            }
        }

        private static object DecodeNode(XmlNode node)
        {
            switch (node.Name)
            {
                case "i4":
                case "int": return int.Parse(node.InnerText, CultureInfo.InvariantCulture);
                case "boolean": return node.InnerText.Trim() == "1";
                case "double":
                    double d;
                    double.TryParse(node.InnerText, NumberStyles.Float, CultureInfo.InvariantCulture, out d);
                    return d;
                case "string": return node.InnerText;
                case "array":
                    var arr = new List<object>();
                    var data = node.SelectSingleNode("data");
                    if (data != null)
                        foreach (XmlNode v in data.ChildNodes)
                            if (v.NodeType == XmlNodeType.Element) arr.Add(DecodeNode(v));
                    return arr;
                case "struct":
                    var st = new Dictionary<string, object>();
                    foreach (XmlNode member in node.ChildNodes)
                    {
                        if (member.Name != "member") continue;
                        string name = member.SelectSingleNode("name") != null
                            ? member.SelectSingleNode("name").InnerText : "";
                        var val = member.SelectSingleNode("value/*");
                        st[name] = val != null ? DecodeNode(val) : null;
                    }
                    return st;
                default: // nil / unknown
                    return null;
            }
        }

        // ------------------------------------------------------------ encoding

        private static string EncodeValue(object v)
        {
            if (v == null) return "<nil/>";
            if (v is bool) return "<boolean>" + (((bool)v) ? "1" : "0") + "</boolean>";
            if (v is int || v is long) return "<int>" + Convert.ToInt64(v, CultureInfo.InvariantCulture) + "</int>";
            if (v is double || v is float || v is decimal)
                return "<double>" + Convert.ToDouble(v, CultureInfo.InvariantCulture).ToString("R", CultureInfo.InvariantCulture) + "</double>";

            var list = v as IList;
            if (list != null && !(v is string))
            {
                var sb = new StringBuilder("<array><data>");
                foreach (var item in list) sb.Append("<value>").Append(EncodeValue(item)).Append("</value>");
                sb.Append("</data></array>");
                return sb.ToString();
            }

            var dict = v as IDictionary<string, object>;
            if (dict != null)
            {
                var sb = new StringBuilder("<struct>");
                foreach (var kv in dict)
                    sb.Append("<member><name>").Append(Escape(kv.Key)).Append("</name><value>")
                      .Append(EncodeValue(kv.Value)).Append("</value></member>");
                sb.Append("</struct>");
                return sb.ToString();
            }

            return "<string>" + Escape(Convert.ToString(v, CultureInfo.InvariantCulture)) + "</string>";
        }

        private static string Escape(string s)
        {
            return System.Security.SecurityElement.Escape(s ?? "");
        }

        public static string EncodeResponse(object result)
        {
            return "<?xml version=\"1.0\"?>" +
                   "<methodResponse><params><param><value>" + EncodeValue(result) +
                   "</value></param></params></methodResponse>";
        }

        public static string EncodeFault(int code, string message)
        {
            return "<?xml version=\"1.0\"?><methodResponse><fault><value><struct>" +
                   "<member><name>faultCode</name><value><int>" + code + "</int></value></member>" +
                   "<member><name>faultString</name><value><string>" + Escape(message) + "</string></value></member>" +
                   "</struct></value></fault></methodResponse>";
        }
    }
}
