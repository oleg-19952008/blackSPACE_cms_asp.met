using System.Globalization;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;

namespace DarkSpace
{
    /// <summary>
    /// ASP.NET Core rewrite of ajax/nanoTechfactory/techShop.ashx.cs (port of
    /// ajax/nanoTechfactory/techShop.php):
    ///   if(isset($_GET['secureLoader'])) { IS_AJAX check; $factory->updateStatus($userid, $slot); }
    /// Mapped in Program.cs at /ajax/nanoTechfactory/techShop.php and /Ajax/TechShop.
    /// </summary>
    public static class TechShopEndpoint
    {
        public static Task Handle(HttpContext ctx)
        {
            string secureLoader = ctx.Request.Query["secureLoader"];
            if (string.IsNullOrEmpty(secureLoader)) return Task.CompletedTask;

            // define('IS_AJAX', ...HTTP_X_REQUESTED_WITH == 'xmlhttprequest'); if(!IS_AJAX) die('Restricted');
            string xrw = ctx.Request.Headers["X-Requested-With"];
            if (xrw == null || xrw.ToLowerInvariant() != "xmlhttprequest")
            {
                ctx.Response.WriteAsync("Restricted");
                return Task.CompletedTask;
            }

            long userid;
            long slot;
            long.TryParse(ctx.Request.Query["userid"].ToString() ?? "", NumberStyles.Any,
                          CultureInfo.InvariantCulture, out userid);
            long.TryParse(ctx.Request.Query["Slot"].ToString() ?? "", NumberStyles.Any,
                          CultureInfo.InvariantCulture, out slot);

            var factory = new Factory();
            factory.UpdateStatus(userid, (int)slot);
            // PHP echoed nothing on success.
            return Task.CompletedTask;
        }
    }
}
