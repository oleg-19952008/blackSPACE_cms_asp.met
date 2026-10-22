using System.Web;

namespace DarkSpace
{
    /// <summary>
    /// Direct port of GameAPI.php:
    ///   ?action=portal.redirectToBoard -> redirect to forum host,
    ///   any other action (or none)     -> empty exit.
    /// </summary>
    public class GameAPI : IHttpHandler
    {
        public bool IsReusable { get { return false; } }

        public void ProcessRequest(HttpContext context)
        {
            string action = context.Request.QueryString["action"];

            if (!string.IsNullOrEmpty(action))
            {
                if (action == "portal.redirectToBoard")
                {
                    // header('Location: http://forum.127.0.0.1')
                    context.Response.Redirect("http://forum." + AppConfig.DynHost);
                    context.Response.End();
                    return;
                }

                // else { exit; }
                context.Response.StatusCode = 200;
                context.Response.End();
            }
        }
    }
}
