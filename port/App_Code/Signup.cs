using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.Globalization;
using System.Text.RegularExpressions;
using System.Web;
using System.Web.UI;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of the index.php signup branch (elseif(isset($_POST['signup_winnings'], ...))).
    /// The reCAPTCHA block was already disabled in PHP ("КАПЧА ОТКЛЮЧЕНА") — not ported.
    /// Validation order, error texts and side effects (mailer->mailSystem confirm-email
    /// letter, unity registerNewAccount/updateAccount/regAmmo, reg SuperReg, raw-PHPMailer
    /// welcome letter, session bootstrap, redirect to internalCompanyChoose) are preserved.
    /// </summary>
    public partial class _Default : Page
    {
        // preg_match('/[\'\/`!@#$%&*()_\-+={}[\]|;"<>,.?\\]/', ...) from index.php username check
        private static readonly Regex SignupBadChars = new Regex(
            @"['/`!@#$%&*()_\-+={}\[\]|;""<>,.?\\]");

        // preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", ...)
        private static readonly Regex SignupEmailRx = new Regex(
            @"^[a-z0-9_\.\-]+@([a-z0-9]+(\-+[a-z0-9]+)*\.)+[a-z]{2,7}$",
            RegexOptions.IgnoreCase);

        /// <summary>Handles POSTs carrying signup_submit (WebForms keeps GET as page method).</summary>
        protected override void OnInit(EventArgs e)
        {
            base.OnInit(e);
            if (Request.HttpMethod == "POST" && Request.Form["signup_submit"] != null)
            {
                HandleSignup();
            }
        }

        private void HandleSignup()
        {
            NameValueCollection f = Request.Form;

            // PHP outer isset(...) list: every field must be present for the branch to run.
            string[] required =
            {
                "signup_winnings", "signup_username", "signup_submit", "signup_province",
                "signup_passwordRepeat", "signup_password", "signup_newsletter", "signup_instance",
                "signup_email", "signup_country", "signup_birthdayYear", "signup_birthdayMonth",
                "signup_birthdayDay"
            };
            foreach (string k in required)
                if (f[k] == null) return;

            if (f["signup_submit"] != "Register") return;

            SessionManager.ClearError(Session);
            string pass = f["signup_password"];

            if (pass.Length < 6)
                SessionManager.AppendError(Session, "<div>Пароль слишком короткий. Пожалуйста, введите пароль от 6 до 30 символов.</div>");
            else if (pass.Length > 30)
                SessionManager.AppendError(Session, "<div>Пароль слишком длинный. Пожалуйста, введите пароль от 6 до 30 символов.</div>");
            else if (!Regex.IsMatch(pass, "[0-9]"))
                SessionManager.AppendError(Session, "<div>The password must include numbers.</div>");

            // $regist flag -> Web.config Registration.Enabled
            if (!AppConfig.RegistrationEnabled)
                SessionManager.AppendError(Session,
                    "<div style=\"color:red;background: #ccc;\"><b>Регистрация временно отключена!<br>" +
                    "Вся информация в группе <a href=\"https://vk.com/club87391028\"> VK </a>и " +
                    "<a href=\"https://discord.gg/ZmKNyFM\">DISCORD</a></b></div>");

            string login = f["signup_username"];
            if (login.Length < 3)
                SessionManager.AppendError(Session, "<div>Логин слишком короткий. Пожалуйста, введите логин от 3 до 15 символов.</div>");
            else if (login.Length > 15)
                SessionManager.AppendError(Session, "<div>Логин слишком длинный. Пожалуйста, введите логин от 3 до 15 символов.</div>");
            else if (SignupBadChars.IsMatch(login))
                SessionManager.AppendError(Session, "<div>Данный логин уже используется.</div>");

            string email = f["signup_email"];
            if (string.IsNullOrEmpty(email) || email.Length > 50 || !SignupEmailRx.IsMatch(email))
                SessionManager.AppendError(Session, "<div>Вы ввели неверный e-mail адрес.</div>");

            if (f["signup_termsAndCondition"] != "1")
                SessionManager.AppendError(Session,
                    "<div>Please confirm that you have accepted our Terms &amp; Conditions. " +
                    "Afterwards, you may continue with your registration.</div>");

            string name = (login ?? "").Trim();
            if (SessionManager.ErrorData(Session) != "") return;

            using (var con = DB.GetInstance())
            {
                // SELECT null FROM users WHERE Name=:name || Email=:email
                bool taken;
                using (var cmd = new MySqlCommand(
                    "SELECT ID FROM users WHERE Name=@name OR Email=@email LIMIT 1", con))
                {
                    cmd.Parameters.AddWithValue("@name", name);
                    cmd.Parameters.AddWithValue("@email", email);
                    object o = cmd.ExecuteScalar();
                    taken = o != null && o != DBNull.Value;
                }

                if (taken)
                {
                    SessionManager.AppendError(Session,
                        "<div>This username or email already exists. Please select another username.</div>");
                    return;
                }

                string sessionId = Core.GenerateRandom(18, true, false);
                var encryption = new Encryption(AppConfig.EncryptionKey);
                string hashpw = encryption.Encrypt(pass);

                long pid;
                using (var ins = new MySqlCommand(
                    "INSERT INTO `users` (Email, Name, pwHash, Servers, sessionId, accountnote) " +
                    "VALUES (@email, @name, @pw, '', @sid, '')", con))
                {
                    ins.Parameters.AddWithValue("@email", email);
                    ins.Parameters.AddWithValue("@name", name);
                    ins.Parameters.AddWithValue("@pw", hashpw);
                    ins.Parameters.AddWithValue("@sid", sessionId);
                    try
                    {
                        ins.ExecuteNonQuery();
                    }
                    catch (MySqlException ex)
                    {
                        // PHP: print "Error!: " . $e->getMessage(); die();
                        Response.Write("Error!: " + HttpUtility.HtmlEncode(ex.Message) + "<br/>");
                        Response.End();
                        return;
                    }
                    pid = ins.LastInsertedId;
                }

                // verification code: urlencode(encrypt({"userid":pid,"email":"..."}))
                string verifyCode = HttpUtility.UrlEncode(encryption.Encrypt(
                    "{\"userid\":" + pid.ToString(CultureInfo.InvariantCulture) +
                    ",\"email\":\"" + email + "\"}"));

                UnityMailer.MailSystem(
                    header: new Dictionary<string, string>
                    {
                        { "mailfrom", "no-reply@127.0.0.1" },
                        { "template", "confirmemail" },
                        { "subject", "Dark Space Email Confirmation" }
                    },
                    content: new Dictionary<string, string>
                    {
                        { "username", name },
                        { "link", AppConfig.Server + "/emailconfirmation/?s=" + verifyCode },
                        { "reasonforemail", "Email Verification" },
                        { "author", "Best Regards <br /> Dark Space Staff Team" },
                        { "year", DateTime.Now.Year.ToString(CultureInfo.InvariantCulture) }
                    },
                    recivers: new List<string> { email });

                var unity = new Unity();
                unity.RegisterNewAccount(pid);
                unity.UpdateAccount(pid);
                unity.RegAmmo(pid);
                Register.SuperReg(pid);

                SessionManager.SetLogin(Session, sessionId, email, false);

                // Raw PHPMailer welcome letter (result handling was commented out in PHP — keep fire-and-forget).
                PhpMailer.Send(email, "Dark Space [Private server]",
                    PhpMailer.BuildWelcomeBody(name, pass));

                Response.Redirect("/indexInternal.es.php?action=internalCompanyChoose", true);
            }
        }
    }
}
