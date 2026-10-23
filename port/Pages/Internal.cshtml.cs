using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Primitives;
using MySql.Data.MySqlClient;

namespace DarkSpace.Pages
{
    /// <summary>
    /// ASP.NET Core (Razor Pages) rewrite of internal.aspx.cs — port of
    /// indexInternal.es.php (the post-login internal page).
    /// The legacy flow: checkSession() -> if not logged in, back to /; otherwise render
    /// the INTERNAL template shell which boots the Flash client with the session id.
    /// WebForms Page -> PageModel: litError/phContent server controls -> OutputHtml buffer,
    /// Response.Write/End -> buffered string + early-return flag, Session -> ISession.
    /// </summary>
    public class InternalModel : Microsoft.AspNetCore.Mvc.RazorPages.PageModel
    {
        private readonly StringWriter _out = new StringWriter();
        private bool _ended; // PHP exit/die after Response.End()

        public string OutputHtml { get; private set; } = "";

        public IActionResult OnGet() { return Process(); }
        public IActionResult OnPost() { return Process(); }

        private IActionResult Process()
        {
            var request = Request;
            var session = HttpContext.Session;

            // indexInternal.es.php lines 6–8: if (isset($_GET['dontShow']) && $_GET['dontShow'] === '1') exit;
            if (request.Query["dontShow"] == "1") { return Flush(null); }

            var users = new Users();
            long userId = users.CheckSession(session); // Class.Users.php::checkSession()

            if (userId == 0)
            {
                return RedirectToPage("/Index");
            }

            Write(SessionManager.ErrorData(session));
            SessionManager.ClearError(session);

            // indexInternal.es.php bootstrap (lines 14–33), ported:
            //   $_SESSION['fact'] / $_SESSION['premium'] = DataRow['factionId'/'premium'];
            long factionId = users.DataRow != null ? PlayerLog.ToLong(users.DataRow["factionId"]) : 0;
            session.SetString("fact", factionId.ToString(CultureInfo.InvariantCulture));
            session.SetString("premium", users.DataRow != null
                ? PlayerLog.ToLong(users.DataRow["premium"]).ToString(CultureInfo.InvariantCulture) : "0");

            // B2 plumbing: PhpTemplateRenderer.RenderShell берёт $_SESSION['server1']['user']['sessionId']
            // и DataRow текущего пользователя из статических хуков — выставляем перед диспетчером.
            PhpTemplateRenderer.CurrentSession = session;
            _users = users;

            var unity = new Unity();
            if (unity.CheckIpBan(Unity.GetClientIp()))
            {
                // header('Location: http://127.0.0.1/?calmdown=99') — в порте редирект на тот же путь локально
                return Flush(Redirect("/?calmdown=99"));
            }

            var @base = new Base();
            @base.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"])); // $base->setId(...)
            if (@base.CheckBan())   // indexInternal.es.php строки 30–32
            {
                return Flush(Redirect("/?calmdown=99"));
            }
            unity.ApplyRankList(PlayerLog.ToLong(users.DataRow["playerID"]));    // $unity->applyRankList(...)
            unity.ApplyRankListNpc(PlayerLog.ToLong(users.DataRow["playerID"])); // $unity->applyRankListNpc(...)

            // Action dispatch (port of indexInternal.es.php dispatcher, phase B).
            HandleAction(users, request);
            if (!_ended) HandleTailBranches(users, request); // ветки 561–732 после else-блока auction

            return Flush(null);
        }

        /// <summary>
        /// Диспетчер по action/subaction/tpl как в indexInternal.es.php (строки 34–732).
        /// Порядок if/elseif оригинала сохранён; каждая ветка = require-цепочка GLOBALS
        /// + Body-шаблон через PhpTemplateRenderer.RenderShell (фаза B2).
        /// </summary>
        private void HandleAction(Users users, HttpRequest request)
        {
            // PHP: if (isset($_POST['action'])) $_GET['action'] = $_POST['action'];
            string action = FirstNonEmpty(Query(request, "action"), Form(request, "action"));
            if (string.IsNullOrEmpty(action)) return;

            string tpl = request.Query["tpl"];

            // Порядок оригинала: сначала action-ветки (внутренний switch), затем elseif-цепочка
            // 'internalHandelClosed'/'internalDock'/'internalMapRevolution'/'burnme', идущая
            // после else-блока internalAuction (см. строки 561–732).
            switch (action)
            {
                // ---- B1: internalCompanyChoose (строки 36–65) — отдельно от factionId-gate ----
                case "internalCompanyChoose":
                    HandleInternalCompanyChoose(users, request);
                    return;
            }

            // PHP: elseif ($Users->DataRow['factionId'] === '0') → редирект на выбор фракции
            // для ВСЕХ прочих действий (строки 64–65).
            if (users.DataRow != null && PlayerLog.ToLong(users.DataRow["factionId"]) == 0)
            {
                _ended = true;
                PendingRedirect = "/Internal?action=internalCompanyChoose";
                return;
            }

            // ---- B3: строки 66–160 ----
            switch (action)
            {
                case "internalStart":
                    HandleInternalStart(users, request);   // фаза C1: порт преамбулы internalStart_Body.php
                    return;
                case "internalGalaxyGates":
                    // В оригинале ветка продублирована (78–89 и 116–126) — поведение идентично.
                    Shell("internalGalaxyGates_Body", "/css/cdn/internalGalaxyGates.css");
                    return;
                case "internalJPA":
                    HandleJpaVars(users);   // фаза C: mysqli-преамбула internalJPA_Body.php
                    return;
                case "internalJPA-list":
                    HandleJpaListVars();    // фаза C: SELECT * FROM jpa из internalJPA-list_Body.php
                    return;
                case "internalPayment":
                    Shell("internalPayment_Body", "/css/cdn/internalPayment.css");
                    return;
                case "internalHallofFame":
                    HandleInternalHallofFame(users, request);
                    return;
            }

            // ---- B4: Balance/Evoucher (161–188) ----
            if (action == "internalBalance")
            {
                Shell("internalBalance_Body", "/css/cdn/internalBalance.css");
                return;
            }
            if (action == "internalEvoucher")
            {
                string logMessage = null, logType = null;
                string redeem = Form(request, "redeem"), evoucher = Form(request, "evoucher");
                if (!string.IsNullOrEmpty(redeem) && !string.IsNullOrEmpty(evoucher))
                {
                    var vouch = new Voucher();
                    vouch.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
                    var re = vouch.RedeemVoucher(evoucher);
                    logMessage = GetOr(re, "log_message");   // $log_message = $re['log_message']
                    logType = GetOr(re, "type");
                }
                Shell("internalEvoucher_Body", "/css/cdn/internalEvoucher.css", logMessage: logMessage, logType: logType);
                return;
            }

            // ---- B5: Clan-группа (189–297) ----
            if (action == "internalNewClanDetails")
            {
                var clan = new Clan();
                clan.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
                long clanid = clan.GetMyClan(PlayerLog.ToLong(users.DataRow["playerID"]));
                if (clanid != 0) { RedirectInternal("internalClan"); return; }
                string clanName = Form(request, "clanName"), clanTag = Form(request, "clanTag");
                if (clanName != null && clanTag != null)
                {
                    // foundClan возвращает строку ошибки либо null при успехе (PHP echo-quirk сохранён в A1)
                    Write(clan.FoundClan(FormDict(request, "clanName", "clanTag", "clanDesc", "clanMotto"),
                                        Str(users, "factionId")));
                }
                Shell("internalNewClanDetails_Body", "http://127.0.0.1/css/cdn/internalNewClanDetails.css");
                return;
            }
            if (action == "internalNewClan")
            {
                var clan = new Clan();
                clan.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
                long clanid = clan.GetMyClan(PlayerLog.ToLong(users.DataRow["playerID"]));
                if (clanid != 0) { RedirectInternal("internalClan"); return; }
                Shell("internalNewClan_Body", "/css/cdn/internalNewClan.css");
                return;
            }
            if (tpl == "internalClanChangeFirm" && action != "internalClan")
            {
                // Оригинальный elseif проверяет ТОЛЬКО $_GET['tpl'] (строки 211–227): срабатывает
                // для любого запроса с tpl=internalClanChangeFirm, кроме занятых action выше.
                string changefirm = request.Query["changefirm"];
                string logMessage = null, logType = null;
                if (!string.IsNullOrEmpty(changefirm) && (changefirm == "1" || changefirm == "2" || changefirm == "3"))
                {
                    var clan = new Clan();
                    clan.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
                    var re = clan.ChangeFirm(changefirm);
                    logMessage = GetOr(re, "log_message");
                    logType = GetOr(re, "type");
                }
                Shell("internalClanChangeFirm_Body", "/css/cdn/internalClan.css", logMessage: logMessage, logType: logType);
                return;
            }
            if (action == "internalClan")
            {
                HandleInternalClan(users, request, tpl);
                return;
            }
            if (action == "internalClanList")
            {
                HandleClanListVars(users, request);   // фаза C: PHP-преамбула internalClanList_Body.php
                return;
            }

            // ---- B6: Messaging/PilotSheet/UserDataChange/ItemUpgradeSystem (298–362) ----
            if (action == "internalMessaging")
            {
                Shell("internalMessaging_Body", "/css/cdn/internalMessaging.css");
                return;
            }
            if (action == "internalPilotSheet")
            {
                if (HandlePilotSheetChangeUsername(users, request)) return; // PHP exit внутри ветки
                HandlePilotSheetVars(users);   // фаза C: порт PHP-преамбулы internalPilotSheet_Body.php
                return;
            }
            if (action == "internalUserDataChange")
            {
                Shell("internalUserDataChange_Body", "/css/cdn/darkorbit.css");
                return;
            }
            if (action == "internalItemUpgradeSystem")
            {
                Shell("internalItemUpgradeSystem_Body", "/css/cdn/internalItemUpgradeSystem.css");
                return;
            }

            // ---- B7: Skylab / Board / NanoTechFactory (363–454) ----
            if (action == "internalSkylab")
            {
                HandleInternalSkylab(users, request);
                return;
            }
            if (action == "internalBoard")
            {
                // subaction-блок оригинала пуст (строки 400–402) — nothing to port.
                Shell("internalBoard", "/css/cdn/internalAuction.css"); // require .../internalBoard.php (без _Body)
                return;
            }
            if (action == "internalNanoTechFactory")
            {
                HandleInternalNanoTechFactory(users, request);
                return;
            }

            // ---- B8: External/History/Promo/Logout (455–502) ----
            if (action == "externalPassword")
            {
                Shell("externalPassword_Body", "/css/cdn/do_password.css");
                return;
            }
            if (action == "internalPaymentProxy")
            {
                // Строки 466–469: $jos собирается, header() закомментирован — никакого вывода
                // и ads.php в этой ветке нет. Порт сохранён без side-effect'ов.
                return;
            }
            if (action == "externalLogout")
            {
                // session_destroy() из преамбулы externalLogout_Body.php — полная очистка сессии
                HttpContext.Session.Clear();
                Write("<html>\n<script type=\"text/javascript\">\nwindow.location.href = \"http://127.0.0.1/\";\nalert(\"Вы Вышли из игры !\");</script>\n</html>");
                return;
            }
            if (action == "internalHistory")
            {
                HandleHistoryVars(users);   // фаза C: $log->setId + getLog из преамбулы шаблона
                return;
            }
            if (action == "internalPaymentPartnerPromotion")
            {
                Shell("internalPaymentPartnerPromotion", "/css/cdn/darkorbit.css"); // файл без суффикса _Body
                return;
            }

            // ---- B9: Auction (503–571) ----
            if (action == "internalAuction")
            {
                HandleInternalAuction(users, request);
                return;
            }
        }

        /// <summary>Ветки после else-блока auction (561–732): проверются только если action не совпал выше.</summary>
        private bool HandleTailBranches(Users users, HttpRequest request)
        {
            string action = FirstNonEmpty(Query(request, "action"), Form(request, "action"));
            string tpl = request.Query["tpl"];
            if (!string.IsNullOrEmpty(action)) return false; // одна из action-веток уже отработана выше

            if (tpl == "internalHandelClosed")
            {
                // НЕ портировать: internalHandelClosed_Body.php помечен мёртвым (C-исключения).
                Shell("internalHandelClosed_Body", "/css/cdn/internalHandel.css");
                return true;
            }
            if (action == "internalDock")
            {
                HandleInternalDock(tpl);
                return true;
            }
            if (action == "internalMapRevolution")
            {
                HandleInternalMapRevolution(users);
                return true;
            }
            if (action == "burnme")
            {
                // require FILES . 'INDEXINTERNAL/burnme.php' — серверный скрипт, не HTML-оболочка.
                Write(PhpTemplateRenderer.RenderBody(users, "burnme", null));
                return true;
            }
            return false;
        }

        /// <summary>indexInternal.es.php строки 241–286 (action=internalClan, включая tpl-подветки).</summary>
        private void HandleInternalClan(Users users, HttpRequest request, string tpl)
        {
            var clan = new Clan();
            clan.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
            long clanid = clan.GetMyClan(PlayerLog.ToLong(users.DataRow["playerID"]));
            if (clanid == 0) { RedirectInternal("internalNewClan"); return; }

            // shell рендерится ДО внутреннего tpl-require в PHP (menu/header идут раньше body)
            string logMessage = null, logType = null;
            if (tpl == "internalClanMember")
            {
                long pid = PlayerLog.ToLong(users.DataRow["playerID"]);
                clan.SetId(PlayerLog.ToLong(users.DataRow["ID"]), pid);
                var clanInfo = clan.GetClan(clanid);
                string subAction = Form(request, "subAction");
                if (subAction == "applyAccept")
                {
                    long applyID; long.TryParse(Form(request, "applyID"), out applyID);
                    clan.ApplyMember(clanid, applyID);
                }
                else if (subAction == "deleteMember")
                {
                    long removeUserID; long.TryParse(Form(request, "removeUserID"), out removeUserID);
                    if (clanInfo.Count > 0 && pid == PlayerLog.ToLong(Rank.Get(clanInfo[0], "leader")))
                        clan.DeleteMember(clanid, removeUserID);
                    else if (pid == removeUserID)
                        clan.DeleteMember(clanid, pid);
                    // пустая else-ветка оригинала — ничего не делает
                }
                else if (subAction == "deleteClan")
                {
                    clan.DeleteClan(clanid);
                }
                var applicants = clan.GetApplicants(clanInfo.Count > 0 ? PlayerLog.ToLong(Rank.Get(clanInfo[0], "clanID")) : clanid);
                var members = clan.GetMembers(clanInfo.Count > 0 ? Rank.Get(clanInfo[0], "members") : "");
                GC.KeepAlive(applicants); GC.KeepAlive(members); // переменные уходят в Body-шаблон (фаза C)
                if (clan.GetMyClan(pid) == 0) { RedirectInternal("internalNewClan"); return; }
                Shell("internalClanMember_Body", "/css/cdn/internalClan.css", logMessage: logMessage, logType: logType);
                return;
            }
            if (tpl == "internalClanDiplomacy")
            {
                Shell("internalClanDiplomacy_Body", "/css/cdn/internalClan.css", logMessage: logMessage, logType: logType);
                return;
            }
            if (tpl == "internalClanAdministrate")
            {
                Shell("internalClanAdministrate_Body", "/css/cdn/internalClan.css", logMessage: logMessage, logType: logType);
                return;
            }
            Shell("internalClan_Body", "/css/cdn/internalClan.css", logMessage: logMessage, logType: logType);
        }

        /// <summary>
        /// indexInternal.es.php строки 407–454 (action=internalNanoTechFactory): subaction'ы
        /// обрабатываются ДО require-цепочки; результаты уходят шаблонам как $log_message/$type.
        /// </summary>
        private void HandleInternalNanoTechFactory(Users users, HttpRequest request)
        {
            string logMessage = null, logType = null;
            string subaction = request.Query["subaction"];
            long uid = PlayerLog.ToLong(users.DataRow["ID"]);
            long pid = PlayerLog.ToLong(users.DataRow["playerID"]);

            if (subaction == "deleteAllBuffs")
            {
                var factory = new Factory();
                factory.SetId(uid, pid);
                int slot; int.TryParse(request.Query["slot"], out slot);
                factory.DeleteTech(slot);
            }
            else if (subaction == "expandHall")
            {
                var factory = new Factory();
                factory.SetId(uid, pid);
                int facilityID; int.TryParse(request.Query["facilityID"], out facilityID);
                var re = factory.ExpandHall(facilityID);
                logMessage = GetOr(re, "log_message"); logType = GetOr(re, "type");
            }
            else if (subaction == "buildBuff")
            {
                var factory = new Factory();
                factory.SetId(uid, pid);
                string buff = request.Query["buff"];
                if (!string.IsNullOrEmpty(buff))
                {
                    bool? instant = string.IsNullOrEmpty(request.Query["instant"]) ? (bool?)null : true;
                    var re = factory.ProduceStart(factory.GetPrices(buff), buff, instant);
                    logMessage = GetOr(re, "log_message"); logType = GetOr(re, "type");
                }
            }
            else if (subaction == "cancelProductin")
            {
                var factory = new Factory();
                factory.SetId(uid, pid);
                string buff = request.Query["buff"];
                if (!string.IsNullOrEmpty(buff))
                {
                    int slot; int.TryParse(request.Query["slot"], out slot);
                    var re = factory.CancelProduction(buff, slot);
                    logMessage = GetOr(re, "log_message"); logType = GetOr(re, "type");
                }
            }
            else if (subaction == "buynow")
            {
                var factory = new Factory();
                factory.SetId(uid, pid);
                string buff = request.Query["buff"];
                if (!string.IsNullOrEmpty(buff))
                {
                    var re = factory.BuyNow(buff);
                    logMessage = GetOr(re, "log_message"); logType = GetOr(re, "type");
                }
            }
            Shell("internalNanoTechFactory_Body", "/css/cdn/internalNanoTechFactory.css",
                  logMessage: logMessage, logType: logType);
        }

        /// <summary>
        /// indexInternal.es.php строки 309–340: AJAX-ish JSON-ответы changeUsername с выходом
        /// до оболочки (PHP exit). Возвращает true, если ветка обработана (response завершён).
        /// </summary>
        private bool HandlePilotSheetChangeUsername(Users users, HttpRequest request)
        {
            string subAction = Form(request, "subAction");
            if (subAction != "changeUsername") return false;

            string userName = Form(request, "userName");
            string current = Str(users, "Name");
            if (userName != null && userName != current)
            {
                if (userName.Length < 3)
                    return JsonExit("{\"status\":\"ERROR\",\"message\":\"This Pilot name most be at-least 3 Characters\"}");
                if (userName.Length > 40)
                    return JsonExit("{\"status\":\"ERROR\",\"message\":\"This Pilot name may not be over 40 character.\"}");
                if (Regex.IsMatch(userName, @"[/`!@#$%&*()_\-+=\{\}\[\]|;:" + "\"" + @"<>,\.?\\" + "']"))
                    return JsonExit("{\"status\":\"ERROR\",\"message\":\"This Pilot name can not be used.\"}");

                var unity = new Unity();
                unity.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
                // mysqli_real_escape_string + trim -> параметризованный запрос в Unity.ChangeName
                string name = userName.Trim();
                return JsonExit(unity.ChangeName(name));
            }
            return JsonExit("{\"status\":\"ERROR\",\"message\":\"This Pilot name is already in use.\"}");
        }

        /// <summary>echo $json; exit;</summary>
        private bool JsonExit(string json)
        {
            Response.ContentType = "application/json";
            Write(json);
            _ended = true;
            return true;
        }

        /// <summary>indexInternal.es.php строки 503–571 (action=internalAuction).</summary>
        private void HandleInternalAuction(Users users, HttpRequest request)
        {
            long uid = PlayerLog.ToLong(users.DataRow["ID"]);
            long pid = PlayerLog.ToLong(users.DataRow["playerID"]);
            var unity = new Unity();
            unity.SetId(uid, pid);

            if (PlayerLog.ToLong(unity.Everisign(uid)) == 1 || Str(users, "rank") == "21")
            {
                string logMessage = null, logType = null;
                string subAction = Form(request, "subAction");
                if (subAction == "bid")
                {
                    string pause = HttpContext.Session.GetString("pauseAuction");
                    if (!string.IsNullOrEmpty(pause) && !Unity.Cpt(pause))
                    {
                        logMessage = "You are not allowed to bid that many times in a row.";
                        logType = "error";
                    }
                    else if (Form(request, "auctionType") == "hour")
                    {
                        // $_SESSION['pauseAuction'] = time() + 10
                        HttpContext.Session.SetString("pauseAuction",
                            ((long)(DateTime.UtcNow - new DateTime(1970, 1, 1)).TotalSeconds + 10)
                            .ToString(CultureInfo.InvariantCulture));
                        string itemId = Form(request, "itemId") ?? "";
                        string[] sl = itemId.Split('_');
                        long sl2; long.TryParse(sl.Length > 2 ? sl[2] : "", out sl2);
                        string credits = Form(request, "credits") ?? "";
                        bool badBid = IsNegativeOrNonReal(credits);
                        if (sl2 > 100 && sl2 < 200)
                        {
                            if (badBid) { logMessage = "Bid can only contain real bids"; logType = "error"; }
                            else
                            {
                                var auc = new Auction();
                                var arg = auc.NextCloseTimeDay();
                                int hour = GetInt(arg, "hour"), min = GetInt(arg, "min"), sec = GetInt(arg, "sec");
                                if (hour == 0 && min == 0 && sec < 10)
                                { logMessage = "I am sorry the auction is disabled for the first 10 seconds."; logType = "error"; }
                                else if (hour == 23 && min == 59 && sec > 50)
                                { logMessage = "I am sorry the auction is disabled for the last 10 seconds."; logType = "error"; }
                                else
                                {
                                    auc.SetId(uid, pid);
                                    var re = auc.SetDayBid(FormDict(request, "itemId", "credits", "auctionType"));
                                    logMessage = GetOr(re, "log_message"); logType = GetOr(re, "type");
                                }
                            }
                        }
                        else
                        {
                            if (badBid) { logMessage = "Bid can only contain real bids"; logType = "error"; }
                            else
                            {
                                var auc = new Auction();
                                auc.SetId(uid, pid);
                                var re = auc.SetHourBid(FormDict(request, "itemId", "credits", "auctionType"));
                                logMessage = GetOr(re, "log_message"); logType = GetOr(re, "type");
                            }
                        }
                    }
                }
                Shell("internalAuction_Body", "/css/cdn/internalAuction.css",
                      logMessage: logMessage, logType: logType);
                return;
            }

            // else: письмо подтверждения e-mail + редирект (как в PHP, включая '.net'-quirk ссылки)
            var enc = new Encryption(AppConfig.Get("EncryptionKey", ""));
            string jos = "{\"userid\":" + uid.ToString(CultureInfo.InvariantCulture)
                         + ",\"email\":\"" + Str(users, "Email") + "\"}";
            string verificationcaode = Uri.EscapeDataString(enc.Encrypt(jos));
            UnityMailer.MailSystem(
                new Dictionary<string, string> {
                    { "mailfrom", "no-reply@DarkSpace.net" },
                    { "template", "confirmemail" },
                    { "subject", "Dark Space Email Confirmation" } },
                new Dictionary<string, string> {
                    { "username", Str(users, "Name") },
                    { "link", "http://127.0.0.1.net/emailconfirmation/?s=" + verificationcaode },
                    { "reasonforemail", "Email Verification" },
                    { "author", "Best Regards <br /> Dark Space Staff Team" },
                    { "year", DateTime.Now.Year.ToString(CultureInfo.InvariantCulture) } },
                new List<string> { Str(users, "Email") });
            _ended = true;
            PendingRedirect = AppConfig.Server + "/emailconfirmation/?calmdown=21";
        }

        /// <summary>PHP: $credits &lt; 0 || strpos('-') !== FALSE || strpos('.') !== FALSE</summary>
        private static bool IsNegativeOrNonReal(string credits)
        {
            double d;
            bool numeric = double.TryParse(credits, NumberStyles.Any, CultureInfo.InvariantCulture, out d);
            if (numeric && d < 0) return true;
            return credits.Contains("-") || credits.Contains(".");
        }

        /// <summary>indexInternal.es.php строки 572–717: все tpl-подветки Dock используют один css.</summary>
        private void HandleInternalDock(string tpl)
        {
            const string css = "/css/cdn/internalDock.css";
            switch (tpl)
            {
                case "internalDockEquipment": Shell("internalDockEquipment_Body", css); return;
                case "internalDockShips": Shell("internalDockShips_Body", css); return;
                case "internalDockLaser": Shell("internalDockLaser_Body", css); return;      // дубль ветки 668–678 недостижим
                case "internalDockPetProtocols": Shell("internalDockPetProtocols_Body", css); return;
                case "internalDockAmmo": Shell("internalDockAmmo_Body", css); return;
                case "internalDockBooster": Shell("internalDockBooster_Body", css); return;
                case "internalDockDrones": Shell("internalDockDrones_Body", css); return;
                case "internalDockGenerator": Shell("internalDockGenerator_Body", css); return;
                case "internalDockShipModel": Shell("internalDockShipModel_Body", css); return;
                case "internalDockPetGear": Shell("internalDockPetGear_Body", css); return;
                case "internalDockSpecials": Shell("internalDockSpecials_Body", css); return; // в оригинале ads.php после specials пропущен
                default: Shell("internalDock_Body", css); return;                              // else-ветка без ads.php
            }
        }

        /// <summary>indexInternal.es.php строки 718–726 (action=internalMapRevolution).</summary>
        private void HandleInternalMapRevolution(Users users)
        {
            long uid = PlayerLog.ToLong(users.DataRow["ID"]);
            long pid = PlayerLog.ToLong(users.DataRow["playerID"]);
            var unity = new Unity();
            unity.SetId(uid, pid);
            if (PlayerLog.ToLong(unity.Everisign(uid)) == 1)
            {
                // partial <html><head><body> + jquery + screen.js, sleep(2), then the map template
                Write("<html> <head> <body><script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js\"></script>"
                      + "   <script type=\"text/javascript\" src=\"js/screen.js\"></script>");
                System.Threading.Thread.Sleep(2000); // PHP sleep(2)
                Write(PhpTemplateRenderer.RenderBody(users, "internalMapRevolution", null));
            }
            else
            {
                var enc = new Encryption(AppConfig.Get("EncryptionKey", ""));
                string jos = "{\"userid\":" + uid.ToString(CultureInfo.InvariantCulture)
                             + ",\"email\":\"" + Str(users, "Email") + "\"}";
                string verificationcaode = Uri.EscapeDataString(enc.Encrypt(jos));
                UnityMailer.MailSystem(
                    new Dictionary<string, string> {
                        { "mailfrom", "no-reply@DarkSpace.net" },
                        { "template", "confirmemail" },
                        { "subject", "Dark Space Email Confirmation" } },
                    new Dictionary<string, string> {
                        { "username", Str(users, "Name") },
                        { "link", "http://127.0.0.1/emailconfirmation/?s=" + verificationcaode },
                        { "reasonforemail", "Email Verification" },
                        { "author", "Best Regards <br /> Dark Space Staff Team" },
                        { "year", DateTime.Now.Year.ToString(CultureInfo.InvariantCulture) } },
                    new List<string> { Str(users, "Email") });
                _ended = true;
                PendingRedirect = AppConfig.Server + "/emailconfirmation/?calmdown=21";
            }
        }

        // -------------------------------------------------- shell / plumbing

        /// <summary>require-цепочка GLOBALS + Body + ads.php (B2) — тонкая обёртка над PhpTemplateRenderer.</summary>
        private void Shell(string bodyTemplate, string cssHref,
                           IDictionary<string, string> vars = null,
                           string logMessage = null, string logType = null)
        {
            Write(PhpTemplateRenderer.RenderShell(_users, bodyTemplate, cssHref, vars, logMessage, logType));
        }

        /// <summary>
        /// C2: порт PHP-преамбулы internalClanList_Body.php (строки 1–15 шаблона):
        /// setId/getClans/getRange/getCurrentPage/getTotalOfResults/getTotalOfPages + cust_sort,
        /// плюс echo-блок строк списка кланов.
        /// </summary>
        private void HandleClanListVars(Users users, HttpRequest request)
        {
            var clan = new Clan();
            clan.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
            var clans = clan.GetClans(null, "?action=internalClanList&tpl=internalClanList");
            int range = clan.GetRange();
            int cuPage = clan.GetCurrentPage();
            int total = clan.GetTotalOfResults();
            int tPage = (int)clan.GetTotalOfPages();

            // if (isset($_GET['sort'])) usort($clans, 'cust_sort') — strtolower-компаратор оригинала
            string sort = request.Query["sort"];
            if (!string.IsNullOrEmpty(sort))
            {
                clans = clans.OrderBy(c =>
                {
                    string v; return c.TryGetValue(sort, out v) ? (v ?? "").ToLowerInvariant() : "";
                }).ToList();
            }

            // for ($i = $start; $i < $end; $i++) из шаблона
            int start, end;
            if (total != 0)
            {
                if (cuPage == 1)
                {
                    start = 0;
                    end = total < range ? total : range;
                }
                else
                {
                    start = (cuPage - 1) * range;
                    end = cuPage != tPage ? cuPage * range : total;
                }
            }
            else { start = 0; end = 0; }

            var sb = new StringBuilder();
            for (int i = start; i < end && i < clans.Count; i++)
            {
                var c = clans[i];
                string Get(string k) { string v; return c.TryGetValue(k, out v) ? (v ?? "") : ""; }
                // $re/$ro в оригинале вычисляются, но в echo не попадают — опущены как dead code.
                // strpos($clans[$i]['members'],'|') / $aff — тоже вычисляются и не используются в echo.
                sb.Append("<tr>\n")
                  .Append("        <td><a href=\"javascript:void(0);\" onclick=\"getClaninfo(11033)\">[")
                  .Append(HtmlEncode(Get("tagName"))).Append("]</a></td>\n")
                  .Append("        <td><a href=\"javascript:void(0);\" onclick=\"getClaninfo(11033)\">")
                  .Append(HtmlEncode(Get("clanName"))).Append("</a></td>\n")
                  .Append("      </tr>");
            }
            if (total == 0)
                sb.Append("<tr>\n        <td><a href=\"javascript:void(0);\" onclick=\"getClaninfo(11033)\"></a></td>\n        <td><a href=\"javascript:void(0);\" onclick=\"getClaninfo(11033)\">There are no clans on the list</a></td>\n      </tr>");

            Shell("internalClanList_Body", "/css/cdn/internalClan.css", new Dictionary<string, string>(StringComparer.Ordinal)
            {
                { "PAGINATE", clan.Paginate("clanlist_navi") },   // <?php echo $clan->paginate('clanlist_navi'); ?>
                { "CLAN_ROWS", sb.ToString() },
            });
        }

        /// <summary>C2: порт преамбулы internalHistory_Body.php ($log->setId + $log->getLog + foreach).</summary>
        private void HandleHistoryVars(Users users)
        {
            var log = new PlayerLog();
            log.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));
            var history = log.GetLog();
            var sb = new StringBuilder();
            foreach (var v in history)
            {
                // echo '<tr>...$v['addDate']...trenner.gif...$v['descrip']...</tr><tr>...trennerw...</tr>'
                sb.Append("<tr>\n")
                  .Append("                        <td>").Append(v.ContainsKey("addDate") ? v["addDate"] : "").Append("</td>\n")
                  .Append("                        <td style=\"background-image:url(./do_img/global/payment/trenner.gif)\"><img src=\"./do_img/global/s.gif\" width=\"2\" height=\"2\"></td>\n")
                  .Append("                        <td>").Append(v.ContainsKey("descrip") ? v["descrip"] : "").Append("</td>\n")
                  .Append("                    </tr>\n")
                  .Append("                    <tr>\n")
                  .Append("                        <td colspan=\"3\"><img src=\"./do_img/global/payment/trennerw.gif\" width=\"446\" height=\"2\"></td>\n")
                  .Append("                    </tr>");
            }
            Shell("internalHistory_Body", "/css/cdn/internalHistory.css", new Dictionary<string, string>(StringComparer.Ordinal)
            {
                { "HISTORY_ROWS", sb.ToString() },
            });
        }

        /// <summary>
        /// C2: порт mysqli-преамбулы internalJPA_Body.php (строки 141–191): jackpot-баланс
        /// и условные поля формы по id/war из таблицы jpa. Запросы параметризованы вместо
        /// интерполяции '$pid' (иначе SQL-injection паритетом с оригиналом).
        /// </summary>
        private void HandleJpaVars(Users users)
        {
            long pid = PlayerLog.ToLong(users.DataRow["playerID"]);
            double jackpot = 0; bool hasJackpotRow = false;
            long uid = 0, uidw = 0;
            using (var con = DB.GetInstance())
            {
                using (var cmd = new MySqlCommand("SELECT `jackpot` FROM `server_1_players` WHERE `userID` = @pid", con))
                {
                    cmd.Parameters.AddWithValue("@pid", pid);
                    using (var rd = cmd.ExecuteReader())
                        while (rd.Read()) { hasJackpotRow = true; jackpot = Convert.ToDouble(rd[0]); }
                }
                FirstCell(con, "SELECT `id` FROM `jpa` WHERE `user_id` = @pid", pid, v => uid = PlayerLog.ToLong(v));
                FirstCell(con, "SELECT `war` FROM `jpa` WHERE `user_id` = @pid", pid, v => uidw = PlayerLog.ToLong(v));
            }

            var bal = new StringBuilder();
            if (hasJackpotRow)
            {
                bal.Append("У вас: ").Append(jackpot.ToString(CultureInfo.InvariantCulture)).Append(" EUR <br>");
                bal.Append("Для участия необходимо 2000.00 EUR <br><br>");
                if (jackpot < 2000.00)
                    bal.Append("<span class='red'>Для участия не хватает: ")
                       .Append((2000.00 - jackpot).ToString(CultureInfo.InvariantCulture)).Append(" EUR</span>");
                else
                    bal.Append("<span class='green'>Вы можете принять участие!</span>\n                                                        ");
            }

            string formFields = uid != 0
                ? "<input type=\"text\" name=\"clanName\" value=\"\" maxlength=\"50\" title=\"Ваш уникальный ID: " + uid + "\" disabled=\"\"/><br/>\n"
                  + "                                                <input type=\"text\" name=\"clanTag\" value=\"\" maxlength=\"7\" title=\"Ваш соперник: ID " + uidw + "\" disabled=\"\"/><br/>"
                : "<input type=\"text\" name=\"clanName\" value=\"\" maxlength=\"50\" title=\"Вы не зарегистрированы\" disabled=\"\"/><br/>\n"
                  + "                                                <input type=\"text\" name=\"clanTag\" value=\"\" maxlength=\"7\" title=\"Вы не зарегистрированы\" disabled=\"\"/><br/>";

            Shell("internalJPA_Body", "/css/cdn/internalGalaxyGates.css", new Dictionary<string, string>(StringComparer.Ordinal)
            {
                { "JPA_BALANCE", bal.ToString() },
                { "JPA_FORM_FIELDS", formFields },
            });
        }

        /// <summary>C2: порт mysqli-блока internalJPA-list_Body.php (SELECT * FROM jpa → &lt;li&gt;-элементы).</summary>
        private void HandleJpaListVars()
        {
            var sb = new StringBuilder();
            using (var con = DB.GetInstance())
            {
                using (var cmd = new MySqlCommand("SELECT * FROM `jpa`", con))
                using (var rd = cmd.ExecuteReader())
                {
                    var cols = Enumerable.Range(0, rd.FieldCount).Select(rd.GetName).ToArray();
                    while (rd.Read())
                    {
                        string Cell(string name)
                        {
                            int ix = Array.IndexOf(cols, name);
                            return ix < 0 || rd.IsDBNull(ix) ? "" : Convert.ToString(rd.GetValue(ix), CultureInfo.InvariantCulture);
                        }
                        sb.Append("<li class=\"clan_item\">\n")
                          .Append("                                                    <span class=\"clanname\">").Append(Cell("id")).Append("</span>\n")
                          .Append("                                                    <span class=\"ranking\"></span>\n")
                          .Append("                                                    <span class=\"members\">").Append(Cell("war")).Append("</span>\n")
                          .Append("                                                    <span class=\"ranking\"></span>\n")
                          .Append("                                                    <span class=\"affiliation\">").Append(Cell("time")).Append("</span>\n")
                          .Append("                                                    <span class=\"status \"></span>\n")
                          .Append("                                                </li>");
                    }
                }
            }
            Shell("internalJPA-list_Body", "/css/cdn/internalGalaxyGates.css", new Dictionary<string, string>(StringComparer.Ordinal)
            {
                { "JPA_LIST_ITEMS", sb.ToString() },
            });
        }

        /// <summary>fetch_assoc()['col'] — первая строка/колонка или null (PHP warning-паритет: 0).</summary>
        private static void FirstCell(MySqlConnection con, string sql, long pid, Action<string> assign)
        {
            using (var cmd = new MySqlCommand(sql, con))
            {
                cmd.Parameters.AddWithValue("@pid", pid);
                object o = cmd.ExecuteScalar();
                if (o != null && o != DBNull.Value) assign(Convert.ToString(o, CultureInfo.InvariantCulture));
            }
        }

        /// <summary>
        /// C1: порт PHP-преамбула internalStart_Body.php (строки 8–16 шаблона + daily bonus +
        /// positionальные require internalHelpLayer/internalNews/internalHeaderIntern).
        /// </summary>
        private void HandleInternalStart(Users users, HttpRequest request)
        {
            long uid = PlayerLog.ToLong(users.DataRow["ID"]);
            long pid = PlayerLog.ToLong(users.DataRow["playerID"]);

            var @base = new Base(); @base.SetId(uid, pid);                    // $base->setId (в Process() уже делался — повторяем как в оригинале для headerIntern)
            var clan = new Clan(); clan.SetId(uid, pid);                      // $clan->setId(...)
            long clanid = clan.GetMyClan(pid);                                // $clanid = $clan->getMyClan($pid)
            var rnk = new Rank();
            var top10 = rnk.GetAllRankingPlayers(9);                          // $rnk->getAllRankingPlayers(9)
            var mRy = rnk.GetMyRanking(pid);                                  // $rnk->getMyRanking($pid)
            var myRanking = mRy.Count > 0 ? mRy[0] : new Dictionary<string, string>();
            var newsC = new News(); newsC.Init();                             // $newsC = new news(); $newsC->init();
            var rank = @base.GetRank(uid, pid);                               // $rank = $base->GetRank(...)

            // Daily-Login-Box: if(!isset($_GET['acceptDailyLoginBonus'])) $_GET[...]=0;
            string acceptRaw = Query(request, "acceptDailyLoginBonus");
            long accept = 0; long.TryParse(acceptRaw ?? "0", out accept);
            var dailyBonus = new DailyBonus();
            dailyBonus.SetId(uid);
            dailyBonus.ExecuteB(HttpContext.Session);
            var bd = dailyBonus.GetData();

            // internalHeaderIntern.php преамбула: $hid=$base->HangarId(); $base->getShips();
            // $unity->setId+levelCorrection(); $rank=$base->GetRank(...) — результат уже в @base/rank.
            object shipnObj = @base.Shipn;
            string shipn = shipnObj == null ? "" : Convert.ToString(shipnObj, CultureInfo.InvariantCulture);

            string FactionCls(string fidStr) { return fidStr == "1" ? "mmo" : (fidStr == "2" ? "eic" : "vru"); }
            string userFaction = users.DataRow != null ? Str(users, "factionId") : "";

            string RankVal(string key)
            {
                string v; return rank != null && rank.TryGetValue(key, out v) ? v : "";
            }

            // $top10 foreach ($Odd = array(1,3,5,7,9); in_array($k,$Odd) → rankingOdd else non)
            var odd = new HashSet<int> { 1, 3, 5, 7, 9 };
            var rows = new StringBuilder();
            for (int k = 0; k < top10.Count; k++)
            {
                var v = top10[k];
                string cls = odd.Contains(k) ? "rankingOdd" : "non";
                string name = HtmlEncode(Rank.Get(v, "Name"));
                string fac = FactionCls(Rank.Get(v, "factionId"));
                rows.Append("<tr class=\"").Append(cls).Append("\">\n")
                    .Append("                                                    <td showuser=\"1uQwW\" title=\"").Append(name)
                    .Append(" - click for details\" style=\"cursor: pointer\">\n        ").Append(name)
                    .Append("\n                                                    </td>\n")
                    .Append("                                                    <td>\n                                                        <img src=\"./do_img/global/logos/logo_")
                    .Append(fac).Append("_mini.png?__cv=e8c00bbe2bd8bf9c0480374ca09f8800\" alt=\"vru\" width=\"7\" height=\"8\">\n                                                    </td>\n")
                    .Append("                                                    <td title=\"").Append(k + 1).Append("\" style=\"cursor: pointer\">").Append(k + 1).Append("</td>\n")
                    .Append("                                                    <td>").Append(HtmlEncode(Rank.Get(v, "rankpoints"))).Append("</td>\n")
                    .Append("                                                </tr>\n");
            }

            // top clans: mysqli_query("SELECT * FROM server_1_clan ORDER BY rankpoints DESC LIMIT 10"), parity is_int($r/2)→none else rankingOdd
            var clans = TopClansQuery();
            var crows = new StringBuilder();
            int r = 1;
            foreach (var cr in clans)
            {
                string cls = (r % 2 == 0) ? "none" : "rankingOdd";
                crows.Append("<tr class=\"").Append(cls).Append("\">\n")
                     .Append("                                            <td class=\"clan_name_qtip\" title=\"").Append(HtmlAttr(Rank.Get(cr, "clanName"))).Append("\">\n")
                     .Append("                                                <a href=\"/indexInternal.es?action=internalNewClanDetails&amp;clanId=").Append(HtmlEncode(Rank.Get(cr, "clanID"))).Append("\">\n")
                     .Append("                                                    [").Append(HtmlEncode(Rank.Get(cr, "tagName"))).Append("]\n")
                     .Append("                                                </a>\n")
                     .Append("                                            </td>\n")
                     .Append("                                            <td>").Append(r).Append("</td>\n")
                     .Append("                                            <td>").Append(HtmlEncode(Rank.Get(cr, "rankpoints"))).Append("</td>\n")
                     .Append("                                        </tr>\n");
                r++;
            }

            // daily bonus layer (if($_GET['acceptDailyLoginBonus'] != 1 && $dailyBonus->getState() == "yes"))
            string dailyLayer = "";
            if (accept != 1 && dailyBonus.GetState() == "yes")
                dailyLayer = BuildDailyBonusLayer(bd);

            // internalHeaderIntern.php токены
            string clanBtn = clanid == 0
                ? "<a class=\"header_std_btn header_lft_std\" id=\"clan_btn\" href=\"/indexInternal.es.php?action=internalNewClan\">\n                    <img src=\"/text?t=КЛАН&w=4&s=10&color=lightestBlue&b=darkblue\" alt=\"\" />\n                </a>"
                : "<a class=\"header_std_btn header_lft_std\" id=\"clan_btn\" href=\"/indexInternal.es.php?action=internalClan\">\n                    <img src=\"/text?t=КЛАН&w=4&s=10&color=lightestBlue&b=darkblue\" alt=\"\" />\n                </a>";
            bool premium = Unity.Cpt(users.DataRow != null ? Str(users, "premium") : null);
            string premiumDiv = premium
                ? "<div id=\"header_is_premium\"></div>"
                : "<div id=\"ip_placeholder\"></div>";

            var vars = new Dictionary<string, string>(StringComparer.Ordinal)
            {
                { "NAME", HtmlEncode(Str(users, "Name")) },
                { "PLAYERID", pid.ToString(CultureInfo.InvariantCulture) },
                { "UID", uid.ToString(CultureInfo.InvariantCulture) },
                { "LEVEL", HtmlEncode(Str(users, "level")) },
                { "HONOR", NumFmtStr(Str(users, "honor")) },
                { "EXP", NumFmtStr(Str(users, "exp")) },
                { "CREDITS", NumFmtStr(Str(users, "credits")) },
                { "URI", NumFmtStr(Str(users, "uri")) },
                { "FACTIONCLS", FactionCls(userFaction) },
                { "FACTIONLABEL", userFaction == "1" ? "MMO" : (userFaction == "2" ? "EIC" : "VRU") },
                { "CLAN_NAME", clanid == 0 ? "---" : HtmlEncode(clan.GetClanName(clanid)) },
                { "RANK_NUM", HtmlEncode(RankVal("rank")) },
                { "RANK_NAME", HtmlEncode(RankVal("name")) },
                { "ADMIN_LINK", RankVal("rank") == "21"
                    ? "<a id=\"userButtonLeft\" class=\"userHomeButton\" href=\"/administratorpanel_for\" target=\"_blank\">\n                                                Админка\n                                            </a>"
                    : "" },
                { "SERVER_TIME", DateTime.Now.ToString("h:mm", CultureInfo.InvariantCulture) },   // date('h:i')
                { "SERVER_DATE", DateTime.Now.ToString("dd-MM-yyyy", CultureInfo.InvariantCulture) }, // date('d-m-Y')
                { "TOP10_ROWS", rows.ToString() },
                { "MYRANK_POS", HtmlEncode(GetOr(myRanking, "overallRank")) },
                { "MYRANK_POINTS", HtmlEncode(GetOr(myRanking, "rankpoints")) },
                { "MYRANK_FACTION", FactionCls(GetOr(myRanking, "factionId")) },
                { "TOP_CLANS_ROWS", crows.ToString() },
                { "NEWS_JSARRAY", newsC.Get("jsarray") },
                { "NEWS_JSARRAY2", newsC.Get("jsarray2") },
                { "NEWS_IMAGES", newsC.Get("images") },
                { "NEWS_ICONS", newsC.Get("icons") },
                { "NEWS_TEXTS", newsC.Get("news") },
                { "DAILY_BONUS_LAYER", dailyLayer },
                { "SHIPN", HtmlEncode(shipn) },
                { "CLAN_BTN", clanBtn },
                { "PREMIUM_DIV", premiumDiv },
            };

            // positionальные require из шаблона (см. {{HELP_NEWS_INCLUDE}} / {{HEADER_INTERN_INCLUDE}})
            vars["HELP_NEWS_INCLUDE"] = FillFragment("internalHelpLayer", vars) + FillFragment("internalNews", vars);
            vars["HEADER_INTERN_INCLUDE"] = FillFragment("internalHeaderIntern", vars);

            Shell("internalStart_Body", "/css/cdn/internalStart.css", vars);
        }

        /// <summary>
        /// C: порт PHP-преамбулы internalPilotSheet_Body.php (строки 1–5): GetRank, getMyRanking[0],
        /// clan setId/getMyClan; плюс токены шаблона (STATION — строгое === как в оригинале).
        /// </summary>
        private void HandlePilotSheetVars(Users users)
        {
            long uid = PlayerLog.ToLong(users.DataRow["ID"]);
            long pid = PlayerLog.ToLong(users.DataRow["playerID"]);

            var @base = new Base();
            var rank = @base.GetRank(uid, pid);                      // $rank = $base->GetRank(...)
            var rnk = new Rank();
            var mRy = rnk.GetMyRanking(pid);                         // $mRy = $rnk->getMyRanking(...)
            var myRanking = mRy.Count > 0 ? mRy[0] : new Dictionary<string, string>();
            var clan = new Clan(); clan.SetId(uid, pid);
            long clanid = clan.GetMyClan(pid);                       // $clanid = $clan->getMyClan(...)

            string RankVal(string key)
            {
                string v; return rank != null && rank.TryGetValue(key, out v) ? v : "";
            }

            var vars = new Dictionary<string, string>(StringComparer.Ordinal)
            {
                { "NAME", HtmlEncode(Str(users, "Name")) },
                { "EMAIL", HtmlEncode(Str(users, "Email")) },
                { "RANK_NUM", HtmlEncode(RankVal("rank")) },
                { "RANK_NAME", HtmlEncode(RankVal("name")) },
                { "MYRANKING", NumFmtStr(GetOr(myRanking, "overallRank")) },   // number_format(...)
                { "CLAN_NAME", clanid == 0 ? "Not available" : HtmlEncode(clan.GetClanName(clanid)) },
                // ($factionId === '1') ? 'Mars' : (($factionId === '2') ? 'Earth' : 'Venus') — строковое ===
                { "STATION", Str(users, "factionId") == "1" ? "Mars" : (Str(users, "factionId") == "2" ? "Earth" : "Venus") },
            };

            // общие токены headerIntern (SHIPN/LEVEL/HONOR/... заполняет RenderShell/vars частично;
            // для PilotSheet преамбула headerIntern не портирована полностью — минимальный набор как в C1)
            object shipnObj = @base.Shipn;
            vars["SHIPN"] = shipnObj == null ? "" : Convert.ToString(shipnObj, CultureInfo.InvariantCulture);
            vars["PLAYERID"] = pid.ToString(CultureInfo.InvariantCulture);
            vars["UID"] = uid.ToString(CultureInfo.InvariantCulture);
            vars["LEVEL"] = HtmlEncode(Str(users, "level"));
            vars["HONOR"] = NumFmtStr(Str(users, "honor"));
            vars["EXP"] = NumFmtStr(Str(users, "exp"));
            vars["CREDITS"] = NumFmtStr(Str(users, "credits"));
            vars["URI"] = NumFmtStr(Str(users, "uri"));
            vars["FACTIONCLS"] = Str(users, "factionId") == "1" ? "mmo" : (Str(users, "factionId") == "2" ? "eic" : "vru");
            vars["CLAN_BTN"] = "<a class=\"header_std_btn header_lft_std\" id=\"clan_btn\" href=\"/indexInternal.es.php?action="
                               + (clanid == 0 ? "internalNewClan" : "internalClan") + "\">\n                    "
                               + "<img src=\"/text?t=КЛАН&w=4&s=10&color=lightestBlue&b=darkblue\" alt=\"\" />\n                </a>";
            bool premium = Unity.Cpt(Str(users, "premium"));
            vars["PREMIUM_DIV"] = premium ? "<div id=\"header_is_premium\"></div>" : "<div id=\"ip_placeholder\"></div>";

            vars["HELP_NEWS_INCLUDE"] = FillFragment("internalHelpLayer", vars) + FillFragment("internalNews", vars);
            vars["HEADER_INTERN_INCLUDE"] = FillFragment("internalHeaderIntern", vars);

            Shell("internalPilotSheet_Body", "/css/cdn/internalPilotSheet.css", vars);
        }

        /// <summary>require GLOBALS.&lt;name&gt;.php с подстановкой тех же vars, что и Body-шаблон.</summary>
        private static string FillFragment(string name, IDictionary<string, string> vars)
        {
            string raw = PhpTemplateRenderer.LoadRaw(PhpTemplateRenderer.GlobalsRoot, name);
            return raw == null ? "" : PhpTemplateRenderer.Fill(raw, vars);
        }

        /// <summary>$clanc = "SELECT * FROM server_1_clan ORDER BY rankpoints DESC LIMIT 10" (straight mysqli_query в шаблоне).</summary>
        private static List<Dictionary<string, string>> TopClansQuery()
        {
            var result = new List<Dictionary<string, string>>();
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand("SELECT * FROM server_1_clan ORDER BY rankpoints DESC LIMIT 10", con))
            using (var rdr = cmd.ExecuteReader())
            {
                while (rdr.Read()) result.Add(Unity.RowToDict(rdr));
            }
            return result;
        }

        /// <summary>HTML дневного бонуса из internalStart_Body.php (слой #dailyLogin), echo $dailyBonusd[...] → значения ExecuteB().</summary>
        private static string BuildDailyBonusLayer(Dictionary<string, string> bd)
        {
            Func<string, string> B = k => { string v; return bd != null && bd.TryGetValue(k, out v) ? v : ""; };
            return @"        <style type=""text/css"" media=""screen"">    @import ""./css/cdn/layer_dailyLogin.css</style>
        <div id=""dailyLogin"" style=""top: 35px; left: 359.5px;"">
                <div id=""dl_headline""><strong>Дневной бонус</strong></div>
                <div id=""dl_infoBox"">
                        <div id=""dl_infoBox_headline""><strong>С возвращением, пилот!</strong></div>
                        <div id=""dl_infoBox_content"">" + HtmlEncode(B("headline")) + @"</div>
                </div>
                <div id=""dl_boni"">
                        <div id=""dl_progressbar_bonus_" + B("progressbar") + @"""></div>
                        <div id=""dl_boniBox"" onclick=""do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockAmmo&amp;hdl=1', false)"">
                                <div class=""dl_boniState_" + B("boxstate_1") + @""">
                                        <div class=""dl_boni_1"">
                                                <div class=""dl_boni_headline"">День 1</div>
                                                " + B("boxstate_1_icon") + @"
                                                <div class=""dl_boni_content dl_boni_content_1"">50,000 кредитов<br>100 ракет PLT-2026<br>5 доп. зарядов энергии</div>
                                        </div>
                                </div>
                        </div>
            <div id=""dl_boniBox"" onclick=""do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockAmmo&amp;hdl=1', false)"">
                                <div class=""dl_boniState_" + B("boxstate_2") + @""">
                                        <div class=""dl_boni_2"">
                                                <div class=""dl_boni_headline"">День 2</div>
                                                " + B("boxstate_2_icon") + @"
                                                <div class=""dl_boni_content dl_boni_content_2"">750 боеприпасов  MCB-25<br>85,000 кредитов<br>5 доп. зарядов энергии</div>
                                        </div>
                                </div>
                        </div>
                        <div id=""dl_boniBox"" onclick=""do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockSpecials&amp;hdl=1', false)"">
                                <div class=""dl_boniState_" + B("boxstate_3") + @""">
                                        <div class=""dl_boni_3"">
                                                <div class=""dl_boni_headline"">День 3</div>
                                                " + B("boxstate_3_icon") + @"
                                                <div class=""dl_boni_content dl_boni_content_3"">150 ракет PLT-2021<br>3 купона на телепортацию<br>5 доп. зарядов энергии</div>
                                        </div>
                                </div>
                        </div>
                        <div id=""dl_boniBox"" onclick=""do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockAmmo&amp;hdl=1', false)"">
                                <div class=""dl_boniState_" + B("boxstate_4") + @""">
                                        <div class=""dl_boni_5"">
                                                <div class=""dl_boni_headline"">День 4</div>
                                                " + B("boxstate_4_icon") + @"
                                                <div class=""dl_boni_content dl_boni_content_4"">5 логдисков<br>250 уридиума<br>5 доп. зарядов энергии</div>
                                        </div>
                                </div>
                        </div>
                        <div id=""dl_boniBox"" onclick=""do_redirect('indexInternal.es?action=internalPilotSheet&amp;tpl=skilltree&amp;hdl=1', false)"">
                                <div class=""dl_boniState_" + B("boxstate_5") + @""">
                                        <div class=""dl_boni_4"">
                                                <div class=""dl_boni_headline"">День 5</div>
                                                " + B("boxstate_5_icon") + @"
                                                <div class=""dl_boni_content dl_boni_content_5"">1000 боеприпасов MCB-50<br>3 купона на ремонт<br>5 ракет WIZ-X</div>
                                        </div>
                                </div>
                        </div>
                        <div id=""dl_accept"">
                                <div id=""dl_bt_accept""><a href=""/indexInternal.es?action=internalStart&amp;acceptDailyLoginBonus=1"">OK</a></div>
                        </div>
                </div>
        </div>
";
        }

        /// <summary>header('Location: /indexInternal.es.php?action=X') в терминах порта.</summary>
        private void RedirectInternal(string action)
        {
            _ended = true;
            PendingRedirect = "/Internal?action=" + Uri.EscapeDataString(action);
        }

        private Users _users; // для Shell(): DataRow текущего пользователя (выставляется в Process())

        private static string Query(HttpRequest r, string key) { return r.Query[key]; }

        private static string Form(HttpRequest r, string key)
        {
            if (!r.HasFormContentType) return null;
            StringValues v;
            return r.Form.TryGetValue(key, out v) ? v.ToString() : null;
        }

        private static string FirstNonEmpty(params string[] xs)
        {
            foreach (var x in xs) if (!string.IsNullOrEmpty(x)) return x;
            return null;
        }

        private static Dictionary<string, string> FormDict(HttpRequest r, params string[] keys)
        {
            var d = new Dictionary<string, string>();
            foreach (var k in keys) { var v = Form(r, k); if (v != null) d[k] = v; }
            return d;
        }

        private static string GetOr(IDictionary<string, string> d, string k)
        {
            string v; return d != null && d.TryGetValue(k, out v) ? v : null;
        }

        private static int GetInt(IDictionary<string, int> d, string k)
        {
            int v; return d != null && d.TryGetValue(k, out v) ? v : 0;
        }

        private static string Str(Users users, string col)
        {
            if (users == null || users.DataRow == null) return "";
            object o;
            return users.DataRow.TryGetValue(col, out o) ? Convert.ToString(o, CultureInfo.InvariantCulture) ?? "" : "";
        }


        /// <summary>Цель редиректа, выставленная вместо Response.Redirect(url, true).</summary>
        public string PendingRedirect { get; private set; }

        /// <summary>Каркас legacy-рендера заменён на PhpTemplateRenderer.RenderShell (фаза B2);
        /// LoadTemplate остался для оверлейных шаблоновHallofFame (см. HandleInternalHallofFame).</summary>

        private static string LoadTemplate(string bodyName)
        {
            // whitelist имени файла от path traversal (имена задаются только кодом выше)
            if (!Regex.IsMatch(bodyName, "^[A-Za-z0-9_-]+$")) return null;
            string path = Path.Combine(AppDomain.CurrentDomain.BaseDirectory,
                "wwwroot", "templates", "INDEXINTERNAL", bodyName + ".html");
            if (!System.IO.File.Exists(path))
            {
                // fallback: исходники лежат рядом с проектом (port/templates)
                path = Path.Combine(AppDomain.CurrentDomain.BaseDirectory, "..", "..", "..", "..",
                    "templates", "INDEXINTERNAL", bodyName + ".html");
            }
            return System.IO.File.Exists(path) ? System.IO.File.ReadAllText(path) : null;
        }

        /// <summary>
        /// Port of indexInternal.es.php lines 138–160 (action=internalHallofFame) plus the
        /// PHP preambles of the six view templates (Files/en_US/INDEXINTERNAL/internalHallofFame*_Body.php).
        /// Uses ready Rank (A5) and Base.GetRank/GetRankByRNK. HTML-шаблоны body-файлов —
        /// фаза C; здесь портирована серверная логика выборки рангов и smoke-рендер таблиц.
        /// </summary>
        private void HandleInternalHallofFame(Users users, HttpRequest request)
        {
            long uid = PlayerLog.ToLong(users.DataRow["ID"]);
            long pid = PlayerLog.ToLong(users.DataRow["playerID"]);
            long fid = PlayerLog.ToLong(users.DataRow["factionId"]);

            var @base = new Base();
            @base.SetId(uid, pid);
            var rnk = new Rank();

            Write("<link rel=\"stylesheet\" media=\"all\" href=\"/css/cdn/internalHallofFame.css\" />");

            string view = request.Query["view"];
            var sb = new System.Text.StringBuilder();

            if (view == "dailyRank")
            {
                // internalHallofFame_dailyRank_Body.php preamble (lines 1–10)
                var rank = @base.GetRank(uid, pid);                       // $rank = $base->GetRank(...)
                var mRy = rnk.GetMyRanking(pid);                          // $mRy = $rnk->getMyRanking(...)
                var pwn = rnk.GetAllPlayers(pid);                         // $pwn = $rnk->getAllPlayers(...)
                var npc = rnk.GetNpcKill(pid);                            // $npc = $rnk->getNpcKill(...)
                var player = rnk.GePlayerKills(pid);                      // $player = $rnk->gePlayerKills(...)

                long rankNum = rank != null ? PlayerLog.ToLong(Rank.Get(rank, "rank")) : 0;

                sb.Append("<h3>YOUR RANK</h3>");
                sb.Append("<div>You are a <strong>" + HtmlEncode(@base.GetRankByRnk(rankNum)) + "</strong>.</div>");
                var p0 = pwn.Count > 0 ? pwn[0] : null;
                sb.Append("<div>Ranking points: " + NumFmt(D(p0, "total")) + "</div>");
                sb.Append("<ul>");
                sb.Append("<li>Experience points: " + NumFmt(D(p0, "exp") * 100000) + " / 100,000</li>");
                sb.Append("<li>Honor points: " + NumFmt(D(p0, "honor") * 100) + " / 100</li>");
                sb.Append("<li>Player shot points: " + NumFmt(D(p0, "playerkills") / 3) + " x 3</li>");
                sb.Append("<li>Your level: " + NumFmt(D(p0, "level") / 100) + " x 100</li>");
                sb.Append("<li>Days since registration: " + NumFmt(D(p0, "days") / 6) + " x 6</li>");
                sb.Append("<li>NPC shot points: " + NumFmt(D(p0, "npckills") * 2) + " / 2</li>");
                sb.Append("<li>Your ship type (" + HtmlEncode(rnk.ShipNameFromNumber((int)(D(p0, "shipId") / 1000))) + "): "
                          + NumFmt(D(p0, "shipId") / 1000) + " x 1,000</li>");
                sb.Append("</ul>");

                // PHP: if($rank['rank']>=20) ... else getApprox('>') ... ; затем getApprox('<')
                if (rankNum >= 20)
                {
                    sb.Append("<p>You have the highest rank possible: <strong>" + HtmlEncode(@base.GetRankByRnk(rankNum))
                              + "</strong> or <strong>Administrator</strong></p>");
                }
                else
                {
                    object approxUp = rnk.GetApprox((long)D(p0, "total"), ">", rankNum, fid);
                    sb.Append("<p>You need approx. " + HtmlEncode(Convert.ToString(approxUp, CultureInfo.InvariantCulture))
                              + " rank points to reach the next rank of <strong>"
                              + HtmlEncode(@base.GetRankByRnk(rankNum + 1)) + "</strong>.</p>");
                }
                object approxDown = rnk.GetApprox((long)D(p0, "total"), "<", rankNum, fid);
                sb.Append("<p>The rank directly below yours is that of <strong>"
                          + HtmlEncode(@base.GetRankByRnk(rankNum - 1)) + "</strong>. Pilots with this rank have approx. "
                          + HtmlEncode(Convert.ToString(approxDown, CultureInfo.InvariantCulture)) + " rank points.</p>");

                // Таблица NPC-убийств: foreach ($npc['playerNPC'] as $key => $am) { $kne = substr($key,3); ... }
                sb.Append(RenderKillTable(npc, 3, skipShipKeys: false));
                // Таблица PvP: пропуск ключей ship11/ship12/ship13 как в оригинале, substr($key,4)
                sb.Append(RenderKillTable(player, 4, skipShipKeys: true));
            }
            else if (view == "User" || view == "Faction" || view == "home_exp" || view == "home_honor")
            {
                // Общие преамбулы этих шаблонов (строки 1–8 каждого файла):
                var rank = @base.GetRank(uid, pid);          // unused in exp/honor bodies but queried in PHP
                var top = rnk.GetAllRankingPlayers();        // $top = $rnk->getAllRankingPlayers();
                var pager = new RankPager();                 // paginate()/getRange()/... живут в RankPager (A5.3)
                pager.SetTotalOfResults(rnk.LastCount);      // PHP $this->count feeds the private pager
                pager.SetUrl("?action=internalHallofFame&view=User"); // во всех шаблонах — один и тот же URL (quirk)
                int cuPage = pager.GetCurrentPage();
                int range = pager.GetRange();
                int total = pager.GetTotalOfResults();
                int tPage = (int)pager.GetTotalOfPages();

                if (view == "home_exp")
                {
                    sb.Append("<h3>TOP EXPERIENCE HOME</h3><table class=\"hof_ranking_table\"><tbody>")
                      .Append(rnk.UrExp()).Append("</tbody></table>");
                }
                else if (view == "home_honor")
                {
                    sb.Append("<h3>TOP HONOR HOME</h3><table class=\"hof_ranking_table\"><tbody>")
                      .Append(rnk.UrHnr()).Append("</tbody></table>");
                }
                else if (view == "Faction")
                {
                    sb.Append("<h3>COMPANIES</h3><table id=\"hof_faction_table\" class=\"hof_ranking_table\"><tr>")
                      .Append("<td class=\"rank_name\">Members</td>")
                      .Append("<td class=\"rank_points\">" + CrOrDash(rnk, 1) + "</td>")
                      .Append("<td class=\"rank_points\">" + CrOrDash(rnk, 2) + "</td>")
                      .Append("<td class=\"rank_points\">" + CrOrDash(rnk, 3) + "</td></tr></table>");
                    // Статические строки Ranking/Experience/Honor/Players/Aliens destroyed из
                    // internalHallofFame_Faction_Body.php (захардкожены в оригинале) — фаза C.
                    // переменные преамбулы ($rank/$range/$cuPage/$total/$tPage) в этом view не используются — GC-подсказка:
                    GC.KeepAlive(rank); GC.KeepAlive(range); GC.KeepAlive(cuPage); GC.KeepAlive(total); GC.KeepAlive(tPage);
                }
                else // view == "User" — листинг топ-игроков с пагинацией (quirks сохранены)
                {
                    sb.Append("<h3>TOP USER</h3><table class=\"hof_ranking_table\"><tbody>");
                    if (total != 0)
                    {
                        int start, end;
                        if (cuPage == 1)
                        {
                            start = 0;
                            end = total < range ? total : range;
                        }
                        else
                        {
                            start = (cuPage - 1) * range;
                            end = cuPage != tPage ? cuPage * range : total;
                        }
                        for (int i = start; i < end; i++)
                        {
                            var row = top[i];
                            sb.Append("<tr>")
                              .Append("<td class=\"rank_position_font\">" + HtmlEncode(Rank.Get(row, "overallRank")) + "</td>")
                              .Append("<td class=\"rank_name_font\" title=\"" + HtmlAttr(Rank.Get(row, "Name")) + "\">"
                                      + HtmlEncode(Rank.Get(row, "Name")) + "</td>")
                              .Append("<td class=\"rank_name_font\">" + HtmlEncode(@base.GetRankByRnk(PlayerLog.ToLong(Rank.Get(row, "rank")))) + "</td>")
                              .Append("<td class=\"rank_points_font\">" + NumFmtStr(Rank.Get(row, "rankpoints")) + "</td>")
                              .Append("</tr>");
                        }
                    }
                    else
                    {
                        sb.Append("<li class=\"no_items even\">This search produced no results.</li>");
                    }
                    sb.Append("</tbody></table>");
                    sb.Append("<div id=\"hof_pagination\">" + pager.Paginate() + "</div>");
                }
            }
            else
            {
                // internalHallofFame_Body.php preamble (default view, lines 1–7)
                var rank = @base.GetRank(uid, pid);
                var top5 = rnk.GetAllRankingPlayers(5);   // вызывается дважды, как в PHP ($top1 и $top5)
                var mRy = rnk.GetMyRanking(pid);
                var myRanking = mRy.Count > 0 ? mRy[0] : null;
                long overallRank = myRanking != null ? PlayerLog.ToLong(Rank.Get(myRanking, "overallRank")) : 0;
                var be = rnk.GetRankBesideMe(overallRank);

                sb.Append("<h3>HALL OF FAME</h3>");
                sb.Append("<table class=\"hof_ranking_table\"><tbody>");
                foreach (var v in top5)
                {
                    sb.Append("<tr><td class=\"rank_position\">" + HtmlEncode(Rank.Get(v, "overallRank")) + ".</td>")
                      .Append("<td class=\"rank_name\">" + HtmlEncode(Rank.Get(v, "Name")) + "</td>")
                      .Append("<td class=\"rank_points\">" + NumFmtStr(Rank.Get(v, "rankpoints")) + "</td></tr>");
                }
                sb.Append("</tbody></table>");
                sb.Append("<table class=\"hof_ranking_table\"><tbody>");
                foreach (var v in be)
                {
                    string cls = PlayerLog.ToLong(Rank.Get(v, "playerID")) == pid ? " class=\"rank_myRank\"" : "";
                    sb.Append("<tr" + cls + "><td class=\"rank_position\">" + NumFmtStr(Rank.Get(v, "overallRank")) + "</td>")
                      .Append("<td class=\"rank_name\">" + HtmlEncode(Rank.Get(v, "Name")) + "</td>")
                      .Append("<td class=\"rank_points\">" + NumFmtStr(Rank.Get(v, "rankpoints")) + "</td></tr>");
                }
                sb.Append("</tbody></table>");
                GC.KeepAlive(rank); // $rank запрашивается в преамбуле шаблона, но в markup default-view не используется
            }

            string tpl = LoadTemplate("internalHallofFame_" + (string.IsNullOrEmpty(view) ? "main" : view));
            sb.Insert(0, ""); // panel wrapper ниже
            Write("<div id=\"hallOfFame\">" + (tpl ?? sb.ToString()) + "</div>");
        }

        /// <summary>Таблица убийств dailyRank: kill-таблицы rank::getNpcKill/gePlayerKills →
        /// $arg['playerNPC'] × $arg['npcINFO'][substr($key,$n)]['rankPoints']. Чётность строк и
        /// порядок подсветки различаются для npc/player таблиц — как в оригинале.</summary>
        private static string RenderKillTable(RankKillArg arg, int substrFrom, bool skipShipKeys)
        {
            var sb = new System.Text.StringBuilder();
            sb.Append("<table class=\"hof_shooting_table\"><tbody>");
            if (arg == null || arg.PlayerNpc == null) { sb.Append("</tbody></table>"); return sb.ToString(); }
            int io = 1;
            foreach (var kv in arg.PlayerNpc)
            {
                if (skipShipKeys && (kv.Key == "ship11" || kv.Key == "ship12" || kv.Key == "ship13"))
                    continue; // пустая ветка if в original
                string kne = kv.Key.Length > substrFrom ? kv.Key.Substring(substrFrom) : "";
                string cl = skipShipKeys
                    ? (io % 2 == 0 ? "none" : "hof_highlighted")     // player-таблица: оригинал инвертирует чётность
                    : (io % 2 == 0 ? "hof_highlighted" : "none");    // npc-таблица
                Dictionary<string, string> info;
                string name = "", rankPoints = "";
                if (arg.NpcInfo != null && arg.NpcInfo.TryGetValue(kne, out info))
                {
                    name = Rank.Get(info, "Name");
                    rankPoints = Rank.Get(info, "rankPoints");
                }
                double am = PlayerLog.ToDouble(kv.Value);
                double points = am * PlayerLog.ToDouble(rankPoints);
                sb.Append("<tr class=\"" + cl + "\">")
                  .Append("<td class=\"rank_name_font\">" + HtmlEncode(name) + "</td>")
                  .Append("<td class=\"rank_points_font\">" + HtmlEncode(rankPoints) + "</td>")
                  .Append("<td class=\"rank_points_font\">" + HtmlEncode(kv.Value) + "</td>")
                  .Append("<td class=\"rank_points_font\">" + NumFmt(points) + "</td></tr>");
                io++;
            }
            if (skipShipKeys)
            {
                // Финальная строка PvP-таблицы («Kills according to most recent calculation»)
                sb.Append("<tr class=\"hof_highlighted\"><td class=\"rank_name_font\">Kills according to most recent calculation</td>"
                          + "<td class=\"rank_points_font\">1</td><td class=\"rank_points_font\">0</td><td class=\"rank_points_font\">0</td></tr>");
            }
            sb.Append("</tbody></table>");
            return sb.ToString();
        }

        // PHP-паритет: $row[$key] при отсутствии/NULL -> 0 (isset-семантика)
        private static double D(IDictionary<string, object> row, string key)
        {
            object o; return row != null && row.TryGetValue(key, out o) ? PlayerLog.ToDouble(o) : 0.0;
        }

        private static string CrOrDash(Rank rnk, long fid)
        {
            long? n = rnk.CrAllplayers(fid);
            return n.HasValue ? NumFmt(n.Value) : ""; // PHP echo null → пусто
        }

        /// <summary>PHP number_format($x) — group by thousands, 0 decimals (round half away from 0).</summary>
        private static string NumFmt(double x)
        {
            return Math.Round(x, MidpointRounding.AwayFromZero).ToString("#,##0", CultureInfo.InvariantCulture);
        }

        private static string NumFmtStr(string value)
        {
            double d;
            return double.TryParse(value, NumberStyles.Any, CultureInfo.InvariantCulture, out d) ? NumFmt(d) : value;
        }

        /// <summary>
        /// Port of indexInternal.es.php lines 36–64 (action=internalCompanyChoose).
        /// subaction=factionChoose persists faction/map/coords and echoes the redirect URL;
        /// otherwise the CompanyChoose header/body would be rendered (фаза C — шаблоны),
        /// here a minimal HTML form shell is emitted instead.
        /// </summary>
        private void HandleInternalCompanyChoose(Users users, HttpRequest request)
        {
            // PHP gate: && $Users->DataRow['factionId'] === '0' — при выбранной фракции
            // original falls through to the second branch (redirect back to internalCompanyChoose),
            // effectively rendering nothing extra for factionId!=0 on this action.
            if (PlayerLog.ToLong(users.DataRow["factionId"]) != 0)
            {
                PendingRedirect = "/Internal?action=internalCompanyChoose";
                _ended = true;
                return;
            }

            var factory = new Factory();
            factory.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"]));

            string subaction = request.Query["subaction"];
            string factionIdStr = request.Query["factionID"];
            long fid;
            // isset(subaction, factionID) && subaction==='factionChoose' && factionID>0 && factionID<4
            if (subaction == "factionChoose" && !string.IsNullOrEmpty(factionIdStr)
                && long.TryParse(factionIdStr, NumberStyles.Any, CultureInfo.InvariantCulture, out fid)
                && fid > 0 && fid < 4)
            {
                long mapId, x, y;
                if (fid == 1) { mapId = 1; x = 1000; y = 1000; }
                else if (fid == 2) { mapId = 5; x = 19800; y = 1000; }
                else { mapId = 9; x = 19600; y = 11900; }
                Execute(
                    "UPDATE server_1_players SET factionId = @fid, mapId = @mapId, x = @x, y = @y WHERE playerID = @pid",
                    Kv("@fid", fid), Kv("@mapId", mapId), Kv("@x", x), Kv("@y", y),
                    Kv("@pid", PlayerLog.ToLong(users.DataRow["playerID"])));
                // echo 'indexInternal.es.php?action=internalStart'; exit;
                Write("indexInternal.es.php?action=internalStart");
                _ended = true;
                return;
            }

            // require CompanyChoose_Header.php / xajax.php / internalHeader.php / CompanyChoose_Body.php
            // TODO (фаза C): шаблон CompanyChoose_Body через TemplateManager. Smoke-оболочка:
            Write("<div id=\"companyChoosePanel\">" +
                  "<h3>Choose your company</h3>" +
                  "<ul>" +
                  "<li><a href=\"/Internal?action=internalCompanyChoose&amp;subaction=factionChoose&amp;factionID=1\">MMO</a></li>" +
                  "<li><a href=\"/Internal?action=internalCompanyChoose&amp;subaction=factionChoose&amp;factionID=2\">EIC</a></li>" +
                  "<li><a href=\"/Internal?action=internalCompanyChoose&amp;subaction=factionChoose&amp;factionID=3\">VRU</a></li>" +
                  "</ul></div>");
        }

        /// <summary>One-shot parameterized UPDATE (factionChoose writes server_1_players).</summary>
        private static void Execute(string sql, params KeyValuePair<string, object>[] ps)
        {
            using (var con = DB.GetInstance())
            using (var cmd = new MySqlCommand(sql, con))
            {
                foreach (var p in ps) cmd.Parameters.AddWithValue(p.Key, p.Value);
                cmd.ExecuteNonQuery();
            }
        }

        private static KeyValuePair<string, object> Kv(string name, object value)
        {
            return new KeyValuePair<string, object>(name, value);
        }

        /// <summary>
        /// Port of indexInternal.es.php lines 363–390 (elseif ($_GET['action'] === 'internalSkylab')).
        /// Порядок оригинала сохранён: setId -> initSkylab -> getAllData (включает повторный
        /// initSkylab и доведение завершённых апгрейдов), затем обработка subaction'ов,
        /// после чего Body вызывает ressupdate("update") и getSiteData().
        /// В PHP subaction читается из $_GET независимо от метода запроса — здесь так же.
        /// </summary>
        private void HandleInternalSkylab(Users users, HttpRequest request)
        {
            var skylab = new Skylab();
            skylab.SetId((int)(long)users.DataRow["ID"]);   // $Skylab->setId($Users->DataRow['ID'])
            skylab.InitSkylab();                            // $Skylab->initSkylab()
            skylab.GetAllData();                            // $Skylab->getAllData(); // including initSkylab

            string subaction = request.Query["subaction"];
            string construction = request.Query["construction"];

            if (!string.IsNullOrEmpty(subaction))
            {
                if (subaction == "setInactive" && !string.IsNullOrEmpty(construction))
                {
                    // $Skylab->setStatus($_GET['construction'], "0", "status");
                    skylab.SetStatus(construction, 0, "status");
                }
                else if (subaction == "upgrade")
                {
                    // $Skylab->setStatus($_GET['construction'], "2", "upthis");
                    // В оригинале нет проверки isset($_GET['construction']) — при пустом
                    // имени setStatus просто не находит модуль и ничего не делает.
                    skylab.SetStatus(construction, 2, "upthis");
                }
                else if (subaction == "setActive")
                {
                    // $Skylab->setStatus($_GET['construction'], "1", "status");
                    skylab.SetStatus(construction, 1, "status");
                }
                else if (subaction == "instantUpgrade")
                {
                    // $Skylab->setStatus($_GET['construction'], "1", "instaup");
                    // Ветка "instaup" в Class.Skylab.php пуста (см. A2.7): вызываем
                    // SetStatus для сигнатурного паритета и дополнительно InstantUpgrade
                    // (no-op, пока InstantUpgradeChargesUridium == false).
                    skylab.SetStatus(construction, 1, "instaup");
                    if (!string.IsNullOrEmpty(construction))
                        skylab.InstantUpgrade(construction);
                }
            }

            // require FILES . 'INDEXINTERNAL/internalSkylab_Body.php':
            // $Skylab->ressupdate("update"); $Lab = $Skylab->getSiteData();
            skylab.RessUpdate("update");
            var lab = skylab.GetSiteData();

            // TODO (фаза C): рендер шаблона internalSkylab_Body через TemplateManager.
            // Для smoke-теста отдаём сводку по лаборатории.
            var sb = new System.Text.StringBuilder();
            sb.Append("<div id=\"skylabPanel\"><h3>Skylab</h3><pre>");
            foreach (var kv in lab)
                sb.Append(HtmlEncode(kv.Key + " = " + RenderDataValue(kv.Value))).Append('\n');
            sb.Append("</pre></div>");
            Write(sb.ToString());
        }

        private static string RenderDataValue(object v)
        {
            var d = v as IDictionary<string, object>;
            if (d != null)
                return "{" + string.Join(", ", d.Select(p => p.Key + ": " + RenderDataValue(p.Value))) + "}";
            var l = v as IList<object>;
            if (l != null)
                return "[" + string.Join(", ", l.Select(RenderDataValue)) + "]";
            return Convert.ToString(v, CultureInfo.InvariantCulture) ?? "";
        }

        // -------------------------------------------------- plumbing helpers

        private void Write(string s) { if (!_ended && s != null) _out.Write(s); }

        /// <summary>Finalizes the response: pending redirect wins over buffered HTML.</summary>
        private IActionResult Flush(IActionResult early = null)
        {
            OutputHtml = _out.ToString();
            if (PendingRedirect != null) return Redirect(PendingRedirect);
            if (early != null) return early;
            Response.ContentType = "text/html; charset=utf-8";
            return Page();
        }

        private static string HtmlEncode(string s)
        {
            return System.Net.WebUtility.HtmlEncode(s ?? "");
        }

        private static string HtmlAttr(string s)
        {
            return System.Net.WebUtility.HtmlEncode(s ?? "");
        }
    }
}
