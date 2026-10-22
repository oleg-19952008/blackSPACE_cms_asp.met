using System;
using System.Text.RegularExpressions;
using System.Web;
using System.Web.UI;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of the root index.php:
    ///  * input sanitisation (Init.php AntiHTML block) is applied via SessionManager
    ///  * the "recoverTrue" (Unity::PasswordRecovery) and "loginForm_default_*" POST
    ///    branches are ported; the signup branch lives in Signup.cs (partial class)
    ///  * template rendering (FILES INDEX/header.php + body.php) via TemplateManager
    /// </summary>
    public partial class _Default : Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            // Init.php: $_POST/$_GET sanitisation — emulate for the fields we read.
            string recoverTrue = SessionManager.SanitizeInput(Request.Form["recoverTrue"]);
            string recoverPw = SessionManager.SanitizeInput(Request.Form["recoverPw"]);

            // if(isset($_POST['recoverTrue']) && !empty($_POST['recoverTrue']))
            if (!string.IsNullOrEmpty(recoverTrue))
            {
                // $unity->passwordRecovery($_POST['recoverPw']) — Class.unity.php port.
                var unity = new Unity();
                SessionManager.AppendError(Session, unity.PasswordRecovery(recoverPw ?? ""));
            }

            // loginForm_default_* branch
            string user = SessionManager.SanitizeInput(Request.Form["loginForm_default_username"]);
            string pass = Request.Form["loginForm_default_password"]; // keep raw: compared after decrypt
            string submit = Request.Form["loginForm_default_login_submit"];

            if (user != null && pass != null && submit == "Login")
            {
                SessionManager.ClearError(Session);

                // PHP validation: no '|', pw length 6..20, must contain digit, pw != '******',
                // username length 2..40
                if (user.Contains("|") || pass.Length < 6 || pass.Length > 20 ||
                    !Regex.IsMatch(pass, "[0-9]") || pass == "******" ||
                    user.Length < 2 || user.Length > 40)
                {
                    SessionManager.AppendError(Session, UnknownComboHtml);
                }
                else
                {
                    DoLogin(user, pass);
                }
            }

            // require FILES . 'INDEX/header.php'; require FILES . 'INDEX/body.php';
            // Template output is handled by TemplateManager (migration step 4):
            // the legacy FILES/en_US/INDEX/{header,body}.php are streamed verbatim with
            // {{SERVER}}/{{ERRORDATA}}/{{MODALSCRIPT}}/{{BANBOX}} token substitution.
            // NOTE: errorData is consumed once inside the body template, exactly like PHP.
            TemplateManager.RenderHeader(Context);
            TemplateManager.RenderBody(Context);
        }

        private const string UnknownComboHtml =
            "<div class=\"singup_errorMessage signup_errorMessage\">Данная комбинация логина и пароля неизвестна." +
            "<br />Пожалуйста проверьте данные и попробуйте снова.</div>";

        /// <summary>
        /// SELECT pwHash/ID/Email/verified/banned/banned_until + server_1_players.rank,
        /// then AES-decrypt compare, sessionId regeneration and redirect — same order as index.php.
        /// </summary>
        private void DoLogin(string name, string password)
        {
            using (var mysql = DB.GetMySQLi())
            using (var cmd = new MySqlCommand(
                "SELECT users.pwHash, users.ID, users.Email, users.verified, users.banned, " +
                "users.banned_until, users.IP, server_1_players.rank " +
                "FROM users INNER JOIN server_1_players ON users.ID=server_1_players.userID " +
                "WHERE users.Name = @name", mysql))
            {
                cmd.Parameters.AddWithValue("@name", name);
                using (var reader = cmd.ExecuteReader())
                {
                    if (!reader.Read())
                    {
                        SessionManager.AppendError(Session, UnknownComboHtml);
                        return;
                    }

                    var row = new DbColumnRow(reader);
                    long banned = row.ToInt64("banned");
                    string bannedUntil = row.ToStr("banned_until");

                    if (banned != 0)
                    {
                        Response.Redirect("http://" + AppConfig.Host + "/?calmdown=99&until=Banned%20Permanent", true);
                    }

                    // $unity->cPT($row['banned_until']) — temporary-ban time check.
                    if (Unity.Cpt(bannedUntil))
                    {
                        Response.Redirect("http://" + AppConfig.Host + "/?calmdown=99&until=" + HttpUtility.UrlEncode(bannedUntil), true);
                    }

                    var encryption = new Encryption(AppConfig.EncryptionKey);
                    string decrypted;
                    try { decrypted = encryption.Decrypt(row.ToStr("pwHash")); }
                    catch { decrypted = null; }

                    if (decrypted == password)
                    {
                        string sessionId = Core.GenerateRandom(18, true, false);
                        string ip = DB.GetUserIp();

                        using (var upd = new MySqlCommand(
                            "UPDATE users SET sessionId = @sid, IP = @ip WHERE ID = @id", mysql))
                        {
                            upd.Parameters.AddWithValue("@sid", sessionId);
                            upd.Parameters.AddWithValue("@ip", ip);
                            upd.Parameters.AddWithValue("@id", row.ToInt64("ID"));
                            upd.ExecuteNonQuery();
                        }

                        SessionManager.SetLogin(Session, sessionId, row.ToStr("Email"),
                            row.ToInt64("verified") != 0);

                        // DB::pmc($row['ID'], "User logged in from ip: ...", "logins")
                        DB.Pmc(row.ToInt64("ID"), "User logged in from ip: " + ip, "logins");

                        // header('Location: /indexInternal.es.php?action=internalStart')
                        Response.Redirect("/indexInternal.es.php?action=internalStart", true);
                    }
                    else
                    {
                        SessionManager.AppendError(Session,
                            "<div>Данная комбинация логина и пароля неизвестна." +
                            "<br />Пожалуйста проверьте данные и попробуйте снова.</div>");
                    }
                }
            }
        }

    }
}
