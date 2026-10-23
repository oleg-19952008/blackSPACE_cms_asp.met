using System;
using System.Collections.Generic;
using System.Globalization;
using System.IO;
using System.Linq;
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
                    Shell("internalStart_Body", "/css/cdn/internalStart.css");
                    return;
                case "internalGalaxyGates":
                    // В оригинале ветка продублирована (78–89 и 116–126) — поведение идентично.
                    Shell("internalGalaxyGates_Body", "/css/cdn/internalGalaxyGates.css");
                    return;
                case "internalJPA":
                    Shell("internalJPA_Body", "/css/cdn/internalGalaxyGates.css");
                    return;
                case "internalJPA-list":
                    Shell("internalJPA-list_Body", "/css/cdn/internalGalaxyGates.css");
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
                Shell("internalClanList_Body", "/css/cdn/internalClan.css");
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
                Shell("internalPilotSheet_Body", "/css/cdn/internalPilotSheet.css");
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
                Shell("externalLogout_Body", "/css/cdn/logout.css");
                return;
            }
            if (action == "internalHistory")
            {
                Shell("internalHistory_Body", "/css/cdn/internalHistory.css");
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
