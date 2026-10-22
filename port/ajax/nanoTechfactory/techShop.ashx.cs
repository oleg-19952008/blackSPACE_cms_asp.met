using System.Globalization;
using System.Web;

namespace DarkSpace
{
    /// <summary>
    /// Port of ajax/nanoTechfactory/techShop.php:
    ///   if(isset($_GET['secureLoader'])) { IS_AJAX check; $factory->updateStatus($userid, $slot); }
    /// </summary>
    public class TechShopHandler : IHttpHandler
    {
        public bool IsReusable { get { return false; } }

        public void ProcessRequest(HttpContext context)
        {
            string secureLoader = context.Request.QueryString["secureLoader"];
            if (string.IsNullOrEmpty(secureLoader)) return;

            // define('IS_AJAX', ...HTTP_X_REQUESTED_WITH == 'xmlhttprequest'); if(!IS_AJAX) die('Restricted');
            string xrw = context.Request.Headers["X-Requested-With"];
            if (xrw == null || xrw.ToLowerInvariant() != "xmlhttprequest")
            {
                context.Response.Write("Restricted");
                context.Response.End();
                return;
            }

            long userid;
            long slot;
            long.TryParse(context.Request.QueryString["userid"] ?? "", NumberStyles.Any,
                          CultureInfo.InvariantCulture, out userid);
            long.TryParse(context.Request.QueryString["Slot"] ?? "", NumberStyles.Any,
                          CultureInfo.InvariantCulture, out slot);

            var factory = new Factory();
            factory.UpdateStatus(userid, (int)slot);
            // PHP echoed nothing on success.
        }
    }
}
