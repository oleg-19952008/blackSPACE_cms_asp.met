using System;
using System.Collections.Generic;
using System.Configuration;
using System.Globalization;
using System.IO;
using System.Net.Mail;
using System.Text;

namespace DarkSpace
{
    /// <summary>
    /// Port of KERNEL-DOCMS/Class.unitymailer.php.
    /// PHP version POSTed the mail payload to an external XML-RPC endpoint
    /// (IXR_Client('darkorbit.tv','/DarkSpace/mail/index.php',80)) which no longer exists.
    /// This port renders the same {{placeholders}} from ./mailtemplates/&lt;template&gt;.tpl
    /// and sends through SmtpClient using &lt;system.net&gt; settings from Web.config.
    /// SMTP credentials must live in configuration, never in code (see MIGRATION.md).
    /// </summary>
    public static class UnityMailer
    {
        /// <summary>
        /// unitymailer::mailSystem($content) — $content had header/content/recivers arrays.
        /// Returns "Mail_error" on failure, "With_template_success"/"Without_template_success"
        /// mirroring unity::sendMail() outcomes.
        /// </summary>
        public static string MailSystem(
            Dictionary<string, string> header,
            Dictionary<string, string> content,
            IList<string> recivers)
        {
            string mailfrom = Get(header, "mailfrom");
            if (string.IsNullOrEmpty(mailfrom))
                mailfrom = "no-reply@" + AppConfig.Get("Mail.DefaultDomain", "DarkSpace.net");

            string subject = Get(header, "subject");
            string template = Get(header, "template");

            // Recipient validation parity with unity::mailer(): first invalid address aborts.
            var to = new List<MailAddress>();
            foreach (var email in recivers ?? new List<string>())
            {
                if (Unity.IsValidEmail(email))
                    to.Add(new MailAddress(email));
                else
                    return "Error_this_is_not_an_email: " + email;
            }

            // Template handling parity with unity::templateUse().
            string body;
            bool usedTemplate = false;
            string tplPath = null;
            if (!string.IsNullOrEmpty(template))
            {
                tplPath = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "mailtemplates", template + ".tpl");
                if (File.Exists(tplPath))
                {
                    body = File.ReadAllText(tplPath, Encoding.UTF8);
                    foreach (var kv in content ?? new Dictionary<string, string>())
                        body = body.Replace("{{" + kv.Key + "}}", kv.Value ?? "");
                    usedTemplate = true;
                }
                else
                {
                    return "template_does_not_exist";
                }
            }
            else
            {
                var sb = new StringBuilder();
                foreach (var kv in content ?? new Dictionary<string, string>())
                    sb.Append(kv.Value);
                body = sb.ToString();
            }

            try
            {
                using (var msg = new MailMessage())
                {
                    msg.From = new MailAddress(mailfrom);
                    foreach (var a in to) msg.To.Add(a);
                    msg.Subject = subject ?? "";
                    msg.Body = body ?? "";
                    msg.IsBodyHtml = true;
                    using (var smtp = new SmtpClient())
                    {
                        smtp.Send(msg);
                    }
                }
                return usedTemplate ? "With_template_success" : "Without_template_success";
            }
            catch (Exception e)
            {
                System.Diagnostics.Debug.WriteLine("UnityMailer: " + e.Message);
                return "Mail_error";
            }
        }

        private static string Get(Dictionary<string, string> d, string k)
        {
            string v;
            return d != null && d.TryGetValue(k, out v) ? v : null;
        }
    }
}
