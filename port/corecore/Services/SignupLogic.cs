using System;
using System.Collections.Generic;
using System.Globalization;
using System.Text.RegularExpressions;
using Microsoft.AspNetCore.Html;
using Microsoft.AspNetCore.Http;
using MySql.Data.MySqlClient;

namespace DarkSpace
{
    /// <summary>
    /// Port of the index.php signup branch (elseif(isset($_POST['signup_winnings'], ...))) —
    /// previously a "partial class _Default : Page" in App_Code/Signup.cs of the WebForms port.
    /// ASP.NET Core rewrite: no Page inheritance; pure logic working on HttpContext/ISession,
    /// returns either a raw-text error result (PHP: print "Error!"; die;) or a redirect URL.
    /// The reCAPTCHA block was already disabled in PHP ("КАПЧА ОТКЛЮЧЕНА") — not ported.
    /// Validation order, error texts and side effects (unitymailer confirm-email letter,
    /// unity registerNewAccount/updateAccount/regAmmo, reg SuperReg, raw-PHPMailer welcome
    /// letter, session bootstrap, redirect to internalCompanyChoose) are preserved.
    /// </summary>
    public static class SignupLogic
    {
        // preg_match('/[\'\/`!@#$%&*()_\-+={}\[\]|;"<>,.?\\]/', ...) from index.php username check
        private static readonly Regex SignupBadChars = new Regex(
            @"['/`!@#$%&*()_\-+={}\[\]|;" + "\"" + @",.?\\]");

        // preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", ...)
        private static readonly Regex SignupEmailRx = new Regex(
            @"^[a-z0-9_\.\-]+@([a-z0-9]+(\-+[a-z0-9]+)*\.)+[a-z]{2,7}$",
            RegexOptions.IgnoreCase);

        public class Result
        {
            /// <summary>Не null -> отдать клиенту raw HTML как в PHP (print "Error!: "...; die;).</summary>
            public IHtmlContent RawOutput;
            /// <summary>Не null -> редирект после успешной регистрации.</summary>
            public string RedirectUrl;
            public bool Handled { get { return RawOutput != null || RedirectUrl != null; } }
        }

        /// <summary>True when the POST carries the signup form (PHP isset($_POST['signup_submit']) gate).</summary>
        public static bool IsSignupPost(IFormCollection form)
        {
            return form != null && form.ContainsKey("signup_submit");
        }

        /// <summary>Handles POSTs carrying signup_submit (was _Default.OnInit/HandleSignup).</summary>
        public static Result Handle(HttpContext ctx, IFormCollection f)
        {
            var res = new Result();

            // PHP outer isset(...) list: every field must be present for the branch to run.
            string[] required =
            {
                "signup_winnings", "signup_username", "signup_submit", "signup_province",
                "signup_passwordRepeat", "signup_password", "signup_newsletter", "signup_instance",
                "signup_email", "signup_country", "signup_birthdayYear", "signup_birthdayMonth",
                "signup_birthdayDay"
            };
            foreach (string k in required)
                if (!f.ContainsKey(k)) return res;

            if (f["signup_submit"] != "Register") return res;

            var session = ctx.Session;
            SessionManager.ClearError(session);
            string pass = f["signup_password"];

            if (pass.Length < 6)
                SessionManager.AppendError(session, "<div>Пароль слишком короткий. Пожалуйста, введите пароль от 6 до 30 символов.</div>");
            else if (pass.Length > 30)
                SessionManager.AppendError(session, "<div>Пароль слишком длинный. Пожалуйста, введите пароль от 6 до 30 символов.</div>");
            else if (!Regex.IsMatch(pass, "[0-9]"))
                SessionManager.AppendError(session, "<div>The password must include numbers.</div>");

            // $regist flag -> appsettings "Registration.Enabled"
            if (!AppConfig.RegistrationEnabled)
                SessionManager.AppendError(session,
                    "<div style=\"color:red;background: #ccc;\"><b>Регистрация временно отключена!<br>" +
                    "Вся информация в группе <a href=\"https://vk.com/club87391028\"> VK </a>и " +
                    "<a href=\"https://discord.gg/ZmKNyFM\">DISCORD</a></b></div>");

            string login = f["signup_username"];
            if (login.Length < 3)
                SessionManager.AppendError(session, "<div>Логин слишком короткий. Пожалуйста, введите логин от 3 до 15 символов.</div>");
            else if (login.Length > 15)
                SessionManager.AppendError(session, "<div>Логин слишком длинный. Пожалуйста, введите логин от 3 до 15 символов.</div>");
            else if (SignupBadChars.IsMatch(login))
                SessionManager.AppendError(session, "<div>Данный логин уже используется.</div>");

            string email = f["signup_email"];
            if (string.IsNullOrEmpty(email) || email.Length > 50 || !SignupEmailRx.IsMatch(email))
                SessionManager.AppendError(session, "<div>Вы ввели неверный e-mail адрес.</div>");

            if (f["signup_termsAndCondition"] != "1")
                SessionManager.AppendError(session,
                    "<div>Please confirm that you have accepted our Terms &amp; Conditions. " +
                    "Afterwards, you may continue with your registration.</div>");

            string name = (login ?? "").Trim();
            if (SessionManager.ErrorData(session) != "") return res;

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
                    SessionManager.AppendError(session,
                        "<div>This username or email already exists. Please select another username.</div>");
                    return res;
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
                        res.RawOutput = new HtmlString("Error!: " + System.Net.WebUtility.HtmlEncode(ex.Message) + "<br/>");
                        return res;
                    }
                    pid = ins.LastInsertedId;
                }

                // verification code: urlencode(encrypt({"userid":pid,"email":"..."}))
                string verifyCode = System.Net.WebUtility.UrlEncode(encryption.Encrypt(
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

                SessionManager.SetLogin(session, sessionId, email, false);

                // Raw PHPMailer welcome letter (result handling was commented out in PHP — keep fire-and-forget).
                PhpMailer.Send(email, "Dark Space [Private server]",
                    PhpMailer.BuildWelcomeBody(name, pass));

                res.RedirectUrl = "/Internal?action=internalCompanyChoose";
                return res;
            }
        }
    }
}
