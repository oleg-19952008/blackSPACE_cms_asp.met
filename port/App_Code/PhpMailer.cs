using System;
using System.Collections.Generic;
using System.Configuration;
using System.Net;
using System.Net.Mail;
using System.Text;

namespace DarkSpace
{
    /// <summary>
    /// Minimal parity wrapper over the legacy /PHPMailer/ library used by index.php
    /// signup branch ($mail = new PHPMailer; $mail->isSMTP(); ... $mail->send()).
    /// All settings come from Web.config appSettings keys Mail.* instead of the
    /// hard-coded SMTP credentials that lived in index.php (see MIGRATION.md).
    /// </summary>
    public static class PhpMailer
    {
        public static string Host     { get { return AppConfig.Get("Mail.Host", "smtp.yandex.ru"); } }
        public static int    Port     { get { int p; return int.TryParse(AppConfig.Get("Mail.Port", "587"), out p) ? p : 587; } }
        public static string Username { get { return AppConfig.Get("Mail.Username", ""); } }
        public static string Password { get { return AppConfig.Get("Mail.Password", ""); } }
        public static bool   UseTls   { get { return AppConfig.GetBool("Mail.UseTls", true); } }
        public static string From     { get { return AppConfig.Get("Mail.From", "noreply@" + AppConfig.Get("Mail.DefaultDomain", "127.0.0.1")); } }
        public static string FromName { get { return AppConfig.Get("Mail.FromName", "Dark Space [Private server]"); } }

        /// <summary>
        /// index.php signup branch: the bilingual "welcome" HTML letter that was built
        /// as an inline PHP heredoc and sent through raw PHPMailer after registration.
        /// </summary>
        public static string BuildWelcomeBody(string username, string password)
        {
            var sb = new StringBuilder();
            sb.Append("\n<center>DarkSpace </center>\n");
            sb.Append("  Добро пожаловать, ").Append(username).Append("<br>\n");
            sb.Append("  DarkSpace - приватный сервер игры DarkOrbit<br><br>\n\n");
            sb.Append("  Ваш логин: ").Append(username).Append("<br>\n");
            sb.Append("  Ваш пароль:").Append(password).Append("\n");
            sb.Append("<br><br><br>\n\n");
            sb.Append("Welcome, ").Append(username).Append(" <br>\n");
            sb.Append("DarkSpace - The private server of the game Dark Orbit <br> <br>\n\n");
            sb.Append("Your login: ").Append(username).Append(" <br>\n");
            sb.Append("Your password: ").Append(password).Append("\n");
            return sb.ToString();
        }

        /// <summary>
        /// Sends one HTML UTF-8 message. Returns null on success or the error text
        /// (PHP: $mail->ErrorInfo) on failure — callers decide whether to surface it
        /// (the original index.php had the send() result handling commented out).
        /// </summary>
        public static string Send(string toEmail, string subject, string htmlBody)
        {
            try
            {
                var msg = new MailMessage
                {
                    From = new MailAddress(From, FromName, Encoding.UTF8),
                    Subject = subject ?? "",
                    Body = htmlBody ?? "",
                    IsBodyHtml = true,
                    BodyEncoding = Encoding.UTF8,
                };
                msg.To.Add(new MailAddress(toEmail)); // caller must pre-validate

                using (var smtp = new SmtpClient(Host, Port))
                {
                    smtp.EnableSsl = UseTls;
                    if (!string.IsNullOrEmpty(Username))
                        smtp.Credentials = new NetworkCredential(Username, Password);
                    smtp.Send(msg);
                }
                return null;
            }
            catch (Exception ex)
            {
                return "SMTP Error: " + ex.Message;
            }
        }
    }
}
