using System;
using System.Globalization;
using System.IO;
using System.Text.Encodings.Web;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Html;
using Microsoft.AspNetCore.Http;

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
    /// ASP.NET Core rewrite: HttpContext.Response.Write + HttpRuntime.Cache ->
    /// IHtmlContent produced for Razor output; templates are copied into the publish
    /// folder (wwwroot-relative "templates/legacy") and cached with IMemoryCache file
    /// dependency (see Program.cs).
    /// </summary>
    public static class TemplateManager
    {
        private static readonly Regex TokenRx = new Regex(@"\{\{(\w+)\}\}");
        private static string _rootOverride;

        /// <summary>Тестовый хук: явный корень шаблонов вместо MapPath.</summary>
        public static void SetRootForTests(string path) { _rootOverride = path; }

        /// <summary>FILES . 'INDEX/header.php' — head/meta block.</summary>
        public static IHtmlContent RenderHeader(HttpContext ctx)
            => Render(ctx, Path.Combine(TemplateRoot, "header.php"));

        /// <summary>FILES . 'INDEX/body.php' — body markup (login/register/modals).</summary>
        public static IHtmlContent RenderBody(HttpContext ctx)
            => Render(ctx, Path.Combine(TemplateRoot, "body.php"));

        private static string TemplateRoot
        {
            get
            {
                if (_rootOverride != null) return _rootOverride;
                // mirrors Init.php: FILES = KERNEL . 'Files/' . Lang . '/'
                var env = AppEnvironment.Current;
                return env != null
                    ? env.MapPath("templates/legacy/" + AppConfig.Lang + "/INDEX")
                    : Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "templates", "legacy", AppConfig.Lang, "INDEX");
            }
        }

        private static IHtmlContent Render(HttpContext ctx, string physicalPath)
        {
            string raw = Load(physicalPath);
            string html = TokenRx.Replace(raw, m => ResolveToken(ctx, m.Groups[1].Value));
            return new HtmlString(html);
        }

        private static string Load(string physicalPath)
        {
            if (!File.Exists(physicalPath))
                throw new FileNotFoundException("Legacy template not found", physicalPath);
            // In ASP.NET Core Razor Pages re-reads the .cshtml on change automatically;
            // for these legacy token-templates we read per request (small files, dev parity).
            return File.ReadAllText(physicalPath);
        }

        private static string ResolveToken(HttpContext ctx, string name)
        {
            switch (name)
            {
                case "SERVER":
                    return HtmlEncoder.Default.Encode(AppConfig.Server);
                case "HOST":
                    return HtmlEncoder.Default.Encode(AppConfig.Host);
                case "ERRORDATA":
                    {
                        // body.php: echo $_SESSION['errorData']; unset($_SESSION['errorData']);
                        var session = ctx?.Session;
                        string data = SessionManager.ErrorData(session);
                        if (!string.IsNullOrEmpty(data))
                            SessionManager.ClearError(session);
                        return data; // raw HTML, same as PHP
                    }
                case "MODALSCRIPT":
                    // body.php opened busy_layer/errorBox when ?calmdown was set
                    // or when session errorData was non-empty.
                    bool showModal = ctx != null && ctx.Request.Query.ContainsKey("calmdown")
                                     || !string.IsNullOrEmpty(SessionManager.ErrorData(ctx?.Session));
                    return showModal ? ErrorBoxOpenJs : string.Empty;
                case "BANBOX":
                    // <?php if(isset($_GET['calmdown']) ... banned.gif + 'Banned until: date(...)' ?>
                    // NB: the legacy condition used '=' instead of '==', i.e. any
                    // ?calmdown value triggered the box — preserved for parity.
                    if (ctx == null || !ctx.Request.Query.ContainsKey("calmdown")) return string.Empty;
                    string until = ctx.Request.Query["until"].ToString();
                    string untilText = string.Empty;
                    if (!string.IsNullOrEmpty(until))
                    {
                        DateTime parsed;
                        if (DateTime.TryParse(until.Replace('-', '/'), out parsed))
                            untilText = "Banned until: " + parsed.ToString("MMM dd, yyyy HH:mm:ss", CultureInfo.InvariantCulture);
                        else
                            untilText = "Banned until: " + System.Net.WebUtility.HtmlEncode(until);
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
