using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;

namespace DarkSpace
{
    /// <summary>
    /// ASP.NET Core rewrite of GameAPI.ashx.cs (direct port of GameAPI.php):
    ///   ?action=portal.redirectToBoard -> redirect to forum host,
    ///   any other action (or none)     -> empty exit.
    /// Mapped in Program.cs at /GameAPI and /GameAPI.ashx.
    /// </summary>
    public static class GameAPIEndpoint
    {
        public static Task Handle(HttpContext ctx)
        {
            string action = ctx.Request.Query["action"];

            if (!string.IsNullOrEmpty(action))
            {
                if (action == "portal.redirectToBoard")
                {
                    // header('Location: http://forum.127.0.0.1')
                    ctx.Response.Redirect("http://forum." + AppConfig.DynHost);
                    return Task.CompletedTask;
                }

                // else { exit; }
                ctx.Response.StatusCode = 200;
            }

            return Task.CompletedTask;
        }
    }
}
