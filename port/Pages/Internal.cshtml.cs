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

            var unity = new Unity();
            if (unity.CheckIpBan(Unity.GetClientIp()))
            {
                // header('Location: http://127.0.0.1/?calmdown=99') — в порте редирект на тот же путь локально
                return Flush(Redirect("/?calmdown=99"));
            }

            var @base = new Base();
            @base.SetId(PlayerLog.ToLong(users.DataRow["ID"]), PlayerLog.ToLong(users.DataRow["playerID"])); // $base->setId(...)
            if (@base.CheckBan())
            {
                return Flush(Redirect("/?calmdown=99"));
            }
            unity.ApplyRankList(PlayerLog.ToLong(users.DataRow["playerID"]));    // $unity->applyRankList(...)
            unity.ApplyRankListNpc(PlayerLog.ToLong(users.DataRow["playerID"])); // $unity->applyRankListNpc(...)

            // Minimal internal-start shell: enough for smoke-testing the auth chain.
            Write("<div class=\"login\"><h2>Dark Space — internal</h2>" +
                  "<p>User ID: " + HtmlEncode(userId.ToString()) + "</p>" +
                  "<p><a href=\"/GameAPI.ashx\">Game API</a> | <a href=\"/\">Logout page</a></p></div>");

            // Action dispatch (port of indexInternal.es.php dispatcher, phase B).
            HandleAction(users, request);

            return Flush(null);
        }

        /// <summary>
        /// Диспетчер по action/subaction как в indexInternal.es.php.
        /// Пока портированы ветки internalCompanyChoose (B-кусок 1, строки 36–64),
        /// internalSkylab (кусок A2.8) и заглушки фазы B для остальных действий;
        /// прочие действия добавляются кусками фазы B по PORTING-PLAN.md.
        /// </summary>
        private void HandleAction(Users users, HttpRequest request)
        {
            // PHP: if (isset($_POST['action'])) $_GET['action'] = $_POST['action'];
            string action = request.Query["action"];
            if (string.IsNullOrEmpty(action) && request.HasFormContentType)
                action = request.Form["action"];
            if (string.IsNullOrEmpty(action)) return;

            // Порядок if/elseif оригинала: internalCompanyChoose проверяется первым и
            // отдельно от factionId-gate (строки 36–65).
            if (action == "internalCompanyChoose")
            {
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

            switch (action)
            {
                case "internalSkylab":
                    HandleInternalSkylab(users, request);
                    break;

                // ---- B3 (PORTING-PLAN.md): indexInternal.es.php lines 66–160 ----
                case "internalStart":
                    RenderInternalPage("internalStart", "/css/cdn/internalStart.css");
                    break;
                case "internalGalaxyGates":
                    // В оригинале ветка internalGalaxyGates продублирована (строки 78–89 и
                    // 116–126) — недостижимый второй copy-port не нужен: поведение идентично.
                    RenderInternalPage("internalGalaxyGates", "/css/cdn/internalGalaxyGates.css");
                    break;
                case "internalJPA":
                    RenderInternalPage("internalJPA", "/css/cdn/internalGalaxyGates.css");
                    break;
                case "internalJPA-list":
                    RenderInternalPage("internalJPA-list", "/css/cdn/internalGalaxyGates.css");
                    break;
                case "internalPayment":
                    RenderInternalPage("internalPayment", "/css/cdn/internalPayment.css");
                    break;
                case "internalHallofFame":
                    HandleInternalHallofFame(users, request);
                    break;

                // TODO (фаза B): internalBalance (B4), internalHistory (B5),
                // internalDock* (B6/B10), internalAuction (B7), internalBoard/Messaging (B8),
                // internalUserDataChange (B9), Shop/inventory (B10).
            }
        }

        /// <summary>Цель редиректа, выставленная вместо Response.Redirect(url, true).</summary>
        public string PendingRedirect { get; private set; }

        /// <summary>Каркас страницы INTERNAL как в require GLOBALS 'internalDoc.php' + css-link +
        /// sajax/xajax/headerEndJS/internalMenu/internalHeader + FILES 'INDEXINTERNAL/&lt;body&gt;_Body.php'.
        /// Шаблоны GLOBALS/INDEXINTERNAL — фаза C (PORTING-PLAN): здесь отдаём статический
        /// HTML-каркас из templates/INDEXINTERNAL/&lt;body&gt;.html (если есть) либо
        /// минимальную оболочку с заголовком действия.</summary>
        private void RenderInternalPage(string bodyName, string cssHref)
        {
            Write("<link rel=\"stylesheet\" media=\"all\" href=\"" + HtmlAttr(cssHref) + "\" />");
            string html = LoadTemplate(bodyName);
            if (html != null)
            {
                Write(html);
                return;
            }
            Write("<div id=\"" + bodyName + "Panel\"><h3>" + HtmlEncode(bodyName) + "</h3>" +
                  "<p>Template pending phase C (templates/INDEXINTERNAL/" + HtmlEncode(bodyName) + ".html).</p></div>");
        }

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
