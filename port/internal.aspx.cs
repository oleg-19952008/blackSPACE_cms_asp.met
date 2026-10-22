using System;
using System.Web.UI;
using System.Web.UI.HtmlControls;

namespace DarkSpace
{
    /// <summary>
    /// Port of indexInternal.es.php (step 3) — the post-login internal page.
    /// The legacy flow: checkSession() -> if not logged in, back to /; otherwise render
    /// the INTERNAL template shell which boots the Flash client with the session id.
    /// </summary>
    public partial class Internal : Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            var users = new Users();
            long userId = users.CheckSession(Session); // Class.Users.php::checkSession()

            if (userId == 0)
            {
                Response.Redirect("/", true);
                return;
            }

            litError.Text = SessionManager.ErrorData(Session);
            SessionManager.ClearError(Session);

            // Minimal internal-start shell: enough for smoke-testing the auth chain.
            var info = new HtmlGenericControl("div");
            info.Attributes["class"] = "login";
            info.InnerHtml = "<h2>Dark Space — internal</h2>" +
                             "<p>User ID: " + HttpUtility.HtmlEncode(userId.ToString()) + "</p>" +
                             "<p><a href=\"/GameAPI.ashx\">Game API</a> | <a href=\"/\">Logout page</a></p>";
            phContent.Controls.Add(info);
        }
    }
}
