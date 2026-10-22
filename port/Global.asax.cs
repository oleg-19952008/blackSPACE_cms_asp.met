using System;
using System.Web;

namespace DarkSpace
{
    /// <summary>
    /// ASP.NET counterpart of KERNEL-DOCMS/Init.php (bootstrap part):
    /// timezone, maintenance switch and global constants (SERVER / HOST / sSERVER / URI).
    /// </summary>
    public class Global : HttpApplication
    {
        protected void Application_Start(object sender, EventArgs e)
        {
            // date_default_timezone_set("Europe/Moscow") from Init.php
            try
            {
                TimeZoneInfo tz = TimeZoneInfo.FindSystemTimeZoneById(AppConfig.Get("TimeZone", "Russian Standard Time"));
                System.Threading.Thread.CurrentThread.CurrentCulture =
                    System.Globalization.CultureInfo.GetCultureInfo(AppConfig.Get("URL.Default.Lang", "en-US").Replace("_", "-"));
                AppConfig.TimeZone = tz;
            }
            catch
            {
                AppConfig.TimeZone = TimeZoneInfo.Utc;
            }

            // Constants SERVER / HOST / sSERVER (Init.php URL resolution block)
            AppConfig.ResolveHostNames();
        }

        protected void Application_BeginRequest(object sender, EventArgs e)
        {
            // $maintenance == TRUE branch from Init.php
            if (AppConfig.Maintenance)
            {
                HttpContext.Current.Response.StatusCode = 503;
                HttpContext.Current.Response.End();
            }
        }

        protected void Session_Start(object sender, EventArgs e)
        {
            // PHP did @session_start() here; ASP.NET manages session lifetime itself.
        }

        protected void Application_Error(object sender, EventArgs e)
        {
            // PHP had display_errors off: swallow and show a neutral page.
            Exception ex = Server.GetLastError();
            if (ex != null)
            {
                Server.ClearError();
                Response.TrySkipIisCustomErrors = true;
                Response.StatusCode = 500;
                Response.Write("An error occurred.");
                Response.End();
            }
        }
    }

}
