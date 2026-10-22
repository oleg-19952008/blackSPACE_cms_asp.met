using System;
using System.Globalization;
using System.IO;
using System.Text.RegularExpressions;
using System.Web;
using System.Web.Caching;

namespace DarkSpace
{
    /// <summary>
    /// Migration step 4: the legacy templates (KERNEL-DOCMS/Files/&lt;Lang&gt;/INDEX/header.php
    /// and body.php, included at the end of index.php) are served as static markup instead
    /// of being re-parsed. The few PHP snippets inside them were replaced by server-side
    /// tokens that this helper fills in per request:
    ///   {{SERVER}}      -> AppConfig.Server   (was &lt;?php echo SERVER; ?&gt;)
    ///   {{ERRORDATA}}   -> Session errorData, consumed once (body.php echoed
    ///                      $_SESSION['errorData'] then unset it)
    /// Everything else (analytics/newrelic script blobs, modal markup, forms) is kept verbatim.
    /// </summary>
    public static class TemplateManager
    {
        private const string CacheKeyPrefix = "ds.template.";
        private static readonly Regex TokenRx = new Regex(@"\{\{(\w+)\}\}");

        /// <summary>FILES . 'INDEX/header.php' — head/meta block.</summary>
        public static void RenderHeader(HttpContext ctx)
            => Render(ctx, Path.Combine(TemplateRoot, "header.php"));

        /// <summary>FILES . 'INDEX/body.php' — body markup (login/register/modals).</summary>
        public static void RenderBody(HttpContext ctx)
            => Render(ctx, Path.Combine(TemplateRoot, "body.php"));

        private static string TemplateRoot
        {
            get
            {
                // mirrors Init.php: FILES = KERNEL . 'Files/' . Lang . '/'
                return HttpContext.Current != null
                    ? HttpContext.Current.Server.MapPath(
                        "~/KERNEL-DOCMS/Files/" + AppConfig.Lang + "/INDEX")
                    : null;
            }
        }

        private static void Render(HttpContext ctx, string physicalPath)
        {
            string raw = LoadCached(physicalPath);
            string html = TokenRx.Replace(raw, m => ResolveToken(ctx, m.Groups[1].Value));
            ctx.Response.Write(html);
        }

        private static string LoadCached(string physicalPath)
        {
            if (!File.Exists(physicalPath))
                throw new FileNotFoundException("Legacy template not found", physicalPath);

            string key = CacheKeyPrefix + physicalPath;
            var cache = HttpRuntime.Cache;
            var text = cache[key] as string;
            if (text == null)
            {
                text = File.ReadAllText(physicalPath);
                cache.Insert(key, text, new CacheDependency(physicalPath)); // auto-reload on edit
            }
            return text;
        }

        private static string ResolveToken(HttpContext ctx, string name)
        {
            switch (name)
            {
                case "SERVER":
                    return HttpUtility.HtmlAttributeEncode(AppConfig.Server);
                case "HOST":
                    return HttpUtility.HtmlAttributeEncode(AppConfig.Host);
                case "ERRORDATA":
                    {
                        // body.php: echo $_SESSION['errorData']; unset($_SESSION['errorData']);
                        string data = SessionManager.ErrorData(ctx.Session);
                        if (!string.IsNullOrEmpty(data))
                            SessionManager.ClearError(ctx.Session);
                        return data; // raw HTML, same as PHP
                    }
                case "MODALSCRIPT":
                    // body.php opened busy_layer/errorBox when ?calmdown was set
                    // or when session errorData was non-empty.
                    bool showModal = ctx.Request.QueryString["calmdown"] != null
                                     || !string.IsNullOrEmpty(SessionManager.ErrorData(ctx.Session));
                    return showModal ? ErrorBoxOpenJs : string.Empty;
                case "BANBOX":
                    // <?php if(isset($_GET['calmdown']) ... banned.gif + 'Banned until: date(...)' ?>
                    // NB: the legacy condition used '=' instead of '==', i.e. any
                    // ?calmdown value triggered the box — preserved for parity.
                    if (ctx.Request.QueryString["calmdown"] == null) return string.Empty;
                    string until = ctx.Request.QueryString["until"];
                    string untilText = string.Empty;
                    if (!string.IsNullOrEmpty(until))
                    {
                        DateTime parsed;
                        if (DateTime.TryParse(until.Replace('-', '/'), out parsed))
                            untilText = "Banned until: " + parsed.ToString("MMM dd, yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                        else
                            untilText = "Banned until: " + HttpUtility.HtmlEncode(until);
                    }
                    return "<div id=\"busy_layer\" style=\"visibility: visible; display: block;\"></div>\n" +
                           "<div id=\"errorBox\" style=\"display: block; width: 500px;\">\n" +
                           "    <div id=\"errorBox_close\">\n" +
                           "        <a href=\"javascript:void(0);\" onclick=\"errorBoxClose();\"><img src=\"./do_img/global/clan/close.jpg?\"></a>\n" +
                           "    </div><br />\n" +
                           "    <img src=\"./acp/css/images/banned.gif\">\n" +
                           "    " + untilText + "\n" +
                           "</div>";
                default:
                    return string.Empty;
            }
        }

        private const string ErrorBoxOpenJs = @"
                jQuery(document).ready(function() {
                    document.getElementById('busy_layer').style.display = 'block';
                    document.getElementById('errorBox').style.display = 'block';
                }); 
                function errorBoxClose() {
                    document.getElementById('busy_layer').style.display = 'none';
                    document.getElementById('errorBox').style.display = 'none';
                }";
    }
}
