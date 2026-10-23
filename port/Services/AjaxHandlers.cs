using System;
using System.Collections.Generic;
using System.Globalization;
using System.Text;
using System.Threading.Tasks;
using System.Linq;
using Microsoft.AspNetCore.Http;
using Microsoft.Extensions.Primitives;

namespace DarkSpace
{
    /// <summary>
    /// PORTING-PLAN A7.3 — xajax/sajax API endpoints.
    ///
    /// Server-side rewrite of the legacy pair:
    ///  - GLOBAL/xajax.php (client bootstrap) + /xajaxAPI.php  -> POST /xajaxAPI.php, /Ajax/xajax
    ///  - GLOBAL/sajax.php (client bootstrap) + /sajaxAPI.php  -> POST /sajaxAPI.php, /Ajax/sajax
    ///
    /// Wire protocol kept byte-compatible with the shipped js/xajax_core.js and the
    /// inline sajax library in GLOBAL/internalDocEnd.php:
    ///  - xajax: form fields xjxfun + xjxargs[]; response "text/xml" &lt;xjx&gt;&lt;cmd ...&gt; document
    ///    (see XajaxResponse).
    ///  - sajax: form fields rs + rst + rsargs[]; response "+:&lt;js expression&gt;" / "-:error".
    ///
    /// Registered in Program.cs next to the other minimal-API endpoints.
    /// </summary>
    public static class AjaxHandlers
    {
        // ------------------------------------------------------------------ xajax

        /// <summary>
        /// xajax request router (was /xajaxAPI.php). Requires a logged-in session
        /// ($Users-&gt;checkSession()); unknown/no-longer-implemented functions answer
        /// an empty &lt;xjx/&gt; document like the PHP fall-through branch did.
        /// </summary>
        public static async Task HandleXajax(HttpContext ctx)
        {
            if (!HttpMethods.IsPost(ctx.Request.Method))
            {
                // PHP read only $_POST; a GET simply fell through to the empty else.
                await WriteXml(ctx, "<xjx></xjx>");
                return;
            }

            var form = await ctx.Request.ReadFormAsync();
            string fun = form["xjxfun"];
            List<string> args = ReadRepeated(form, "xjxargs");
            if (args.Count == 0) args = ReadRepeated(form, "xjxargs[]");

            var users = new Users();
            users.CheckSession(ctx.Session);

            XajaxResponse x = null;
            switch (fun)
            {
                case "nanoTechFactoryShowApis":
                    x = NanoTechFactoryShowApis(users, Arg(args, 0));
                    break;
                case "nanoTechFactoryShowBuff":
                    x = NanoTechFactoryShowBuff(users, Arg(args, 0), Arg(args, 2));
                    break;
                case "pilotSheet":
                case "achievement":
                    // Original handlers (_NE_ISPOLZUETSJA/xajaxAPI.php lines 11..2158) are ~1750
                    // lines of static profile/achievement HTML markup with almost no live data.
                    // Deferred: port together with Phase B pilot-sheet actions (B6/B9).
                    x = EmptyResponse();
                    break;
                default:
                    // disableTradeLayer / saveTempResolution / clientResolutionChanged /
                    // loadUserInfo / switchHangar / feedbackForm / signupArena / ... —
                    // their server-side implementations do not exist in the surviving PHP
                    // source (only the client wrappers in GLOBAL/xajax.php). No-op parity.
                    x = EmptyResponse();
                    break;
            }

            await WriteXml(ctx, x.ToXml());
        }

        private static XajaxResponse EmptyResponse() { return new XajaxResponse(); }

        // ------------------------------------------------ nanoTechFactoryShowApis

        /// <summary>
        /// xajaxAPI.php branch "nanoTechFactoryShowApis" (lines 2159-2233): renders the
        /// Zeus ("N4") or Apis drone-construction panel into #buffcontainer plus the
        /// progress bar. $total=45 parts, $he=235px bar height.
        /// </summary>
        private static XajaxResponse NanoTechFactoryShowApis(Users users, string arg0)
        {
            bool zeus = arg0 != null && arg0.Contains("N4");
            string lootId = zeus ? "resource_blueprint_zeus-part" : "resource_blueprint_apis-part";
            string partKey = zeus ? "zeusPart" : "apisPart";
            long total = 45;
            const int he = 235;
            long tPrice = zeus ? 1500000 : 1100000;
            string droneName = zeus ? "Zeus" : "Apis";

            var factory = new Factory();
            factory.SetId(Lng(users, "ID"), Lng(users, "playerID"));
            long parts = factory.GetDroneParts(lootId);
            long leftPrice = tPrice - ((tPrice / total) * parts);
            long cl = PhpFormat.Round((10.0 / total) * parts);

            long uri = Lng(users, "uri");
            bool uridiumFail = leftPrice > uri;
            bool partsFail = parts < total;

            var sb = new StringBuilder();
            sb.Append("\n                <style  type=\"text/css\">\n                    #ntf_drone_name {\n                        background-repeat: no-repeat;\n                        height: 15px;\n                        width: 250px;\n                    }\n                </style>\n\n");
            sb.Append("                <div id=\"ntf_center_factory\">\n");
            sb.Append("                    <div id=\"ntf_drone_name\">\n");
            sb.Append("                        <center><img src=\"./text?t=Drone Construction&w=17&s=12&color=yellow&b=grey\" /></center>\n");
            sb.Append("                    </div>\n");
            sb.Append(zeus
                ? "                    <div id=\"ntf_factory_scroll\">Occasionally you can find sections of the Zeus drone blueprints in the pirate booty. Once you have all the sections, you can build the drone. You can also build the drone instantly but this requires Uridium. Each piece of the blueprints that you find reduces the price of instantly building the drone.</div>\n"
                : "                    <div id=\"ntf_factory_scroll\">Every now and then you can find sections of the Apis drone blueprints in pirate booty. Once you have all the sections, you can build the drone. You can also build the drone instantly but this requires Uridium. Each part of the blueprints you find reduces the price of instantly building the drone.</div>\n");
            sb.Append("                    <div id=\"ntf_drone_parts_" + partKey + "_" + cl + "\" class=\"ntf_drone_parts\"></div>\n");
            sb.Append("                    <div id=\"ntf_drone_build_instant\"><div id=\"" + (uridiumFail ? "button_build_instant_inactive" : "button_build_instant") + "\">"
                     + "<a class=\"but_build_instant_a\" onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalPayment\">"
                     + "<span class=\"" + (uridiumFail ? "buildlink_inactive" : "buildlink") + "\">PRODUCE INSTANTLY</span><br />"
                     + "<span class=\"fliess10px font_info buildlink_inactive\">" + PhpFormat.NumberFormat(leftPrice) + " Uridium</span></a></div></div>\n");
            sb.Append("                    <div id=\"ntf_drone_build\"><div id=\"" + (partsFail ? "button_build_inactive" : "button_build") + "\">"
                     + "<strong class=\"" + (partsFail ? "buildlink_inactive" : "buildlink") + "\">PRODUCE</strong></div></div>\n");
            sb.Append("                </div>\n");
            if (uridiumFail)
                sb.Append("<div id=\"errorMessage\"><div id=\"errorMessageDroneAlreadyInUse\"><div id=\"errorText\">You do not have enough Uridium or parts to construct the "
                          + droneName + " drone.</div><br /></div></div>");

            double hPct = (100.0 / total) * parts;
            double topPx = he - ((he / (double)total) * parts);
            var x = new XajaxResponse();
            x.Assign("buffcontainer", "innerHTML", sb.ToString());
            x.Assign("factory_progress_main", "innerHTML",
                "<div id=\"factory_progress_bar\" style=\"height:" + Fmt(hPct) + "%; top:" + Fmt(topPx) + "px;\"></div>");
            x.Assign("factory_progress_count", "style.backgroundImage",
                "url(../do_img/global/text.esg?l=de&s=9&t=0&f=eurostyle_thea&color=white&bgcolor=grey)");
            x.Assign("ntf_right_factory", "style.display", "block");
            return x;
        }

        // ------------------------------------------------ nanoTechFactoryShowBuff

        /// <summary>
        /// xajaxAPI.php branch "nanoTechFactoryShowBuff" (lines 2234-2349): buff detail
        /// panel (name/description/cost/availability/effect) with PRODUCE / PRODUCE
        /// INSTANTLY / BUY NOW buttons and, when a slot char is passed, delete/cancel UI.
        /// </summary>
        private static XajaxResponse NanoTechFactoryShowBuff(Users users, string s, string slotArg)
        {
            var factory = new Factory();
            factory.SetId(Lng(users, "ID"), Lng(users, "playerID"));

            var halls = factory.GetTimes();
            bool progress = halls != null && Unity.Cpt(GetOr(halls, s));

            var reso = factory.GetPrices(s);
            long logdisk = ParseLong(GetOr(reso, "logdisk"));
            long seprom = ParseLong(GetOr(reso, "seprom"));
            long c = ParseLong(GetOr(reso, "c"));
            long buyn = ParseLong(GetOr(reso, "buyn"));
            long instant = ParseLong(GetOr(reso, "instant"));

            long myLogfiles = factory.GetItemsRequired("resource_logfile");
            long mySeprom = factory.GetItemsRequired("resource_ore_seprom");
            long credits = Lng(users, "credits");
            long uri = Lng(users, "uri");

            string inCLS = (logdisk <= myLogfiles && c <= credits && seprom <= mySeprom) ? "" : "_inactive";
            string inCLS2;
            if (uri > buyn) { inCLS2 = ""; }
            else { inCLS2 = "_inactive"; }

            string del;
            string charLast = null;
            if (slotArg != null)
            {
                charLast = slotArg.Length > 0 ? slotArg.Substring(slotArg.Length - 1) : "";
                del = "<![CDATA[SindexInternal.es?action=internalNanoTechFactory&subaction=deleteAllBuffs&slot="
                      + charLast + "&reloadToken=a3fc7a4e41c47c74f3808840b7314307]]>";
            }
            else
            {
                del = "*";
            }

            var sb = new StringBuilder();
            sb.Append("<div id=\"ntf_center\">\n");
            sb.Append("                <div id=\"ntf_buff_scroll\">\n");
            sb.Append("                    <div id=\"ntf_buff_name\">Name: <span id=\"ntf_singleBuff_name\">" + Esc(factory.L(s + "name")) + "</span></div>\n");
            sb.Append("                    <div class=\"ntf_seperator\"></div>\n");
            sb.Append("                    <div id=\"ntf_buff_descr\">" + Esc(factory.L(s + "info")) + "</div>\n");
            sb.Append("                    <div class=\"ntf_seperator\"></div>\n");
            sb.Append("                    <div id=\"ntf_buff_cost\">\n");
            sb.Append("                        <table id=\"ntf_table_cost\">\n");
            sb.Append("                            <tr>\n");
            sb.Append("                                <td><strong>Cost:</strong></td>\n");
            sb.Append("                                <td class=\"ntf_center\"><strong>" + PhpFormat.NumberFormat(c) + "</strong></td>\n");
            sb.Append("                                <td class=\"ntf_center\"><strong>" + seprom + "</strong></td>\n");
            sb.Append("                                <td class=\"ntf_center\"><strong>" + logdisk + "</strong></td>\n");
            sb.Append("                            </tr>\n");
            sb.Append("                            <tr>\n");
            sb.Append("                                <td></td>\n");
            sb.Append("                                <td class=\"ntf_center\">Credits</td>\n");
            sb.Append("                                <td class=\"ntf_center\">Seprom</td>\n");
            sb.Append("                                <td class=\"ntf_center\">Log-disks</td>\n");
            sb.Append("                            </tr>\n");
            sb.Append("                            <tr>\n");
            sb.Append("                                <td><strong>Available:</strong></td>\n");
            sb.Append("                                <td class=\"ntf_center\"><strong>" + ResSpan(c > credits, "Not enough Credits available", PhpFormat.NumberFormat(credits)) + "</strong></td>\n");
            sb.Append("                                <td class=\"ntf_center\"><strong>" + ResSpan(seprom > mySeprom, "Not enough Seprom available", mySeprom.ToString(CultureInfo.InvariantCulture)) + "</strong></td>\n");
            sb.Append("                                <td class=\"ntf_center\"><strong>" + ResSpan(logdisk > myLogfiles, "Not enough Log-Disks available", myLogfiles.ToString(CultureInfo.InvariantCulture)) + "</strong></td>\n");
            sb.Append("                            </tr>\n");
            sb.Append("                        </table>\n");
            sb.Append("                    </div>\n");
            sb.Append("                    <div class=\"ntf_seperator\"></div>\n");
            sb.Append("                    <div id=\"ntf_buff_info\"><table id=\"ntf_table_info\"><tr><td>Effect:</td><td>" + Esc(factory.L(s + "effect")) + "</td></tr><tr><td>Duration:</td><td>" + Esc(factory.L(s + "duration")) + "</td></tr><tr><td>Cooldown:</td><td>" + Esc(factory.L(s + "cooldown")) + "</td></tr></tr></table><br />\n");
            sb.Append("                    </div>\n");
            sb.Append("                </div>\n");
            sb.Append("                <div id=\"ntf_buff_build_instant\"><div id=\"button_build_instant" + inCLS + "\">");
            if (inCLS != "_inactive")
                sb.Append("<a class=\"but_build_instant_a\" onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalNanoTechFactory&subaction=buildBuff&buff=" + s + "&instant=1\"> ");
            sb.Append("<strong class=\"buildlink" + inCLS + "\">PRODUCE INSTANTLY</strong>");
            if (inCLS != "_inactive")
                sb.Append("<br/><span class=\"fliess10px font_info\">" + PhpFormat.NumberFormat(instant) + " Uridium</span> ");
            if (inCLS != "_inactive") sb.Append("</a>");
            sb.Append("</div></div>\n");

            if (slotArg != null)
            {
                if (progress)
                    sb.Append("                        <div id=\"ntf_buff_build\"><div id=\"button_build\"><a class=\"but_build_instant_a\" onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalNanoTechFactory&subaction=cancelProductin&buff=" + s + "&slot=" + charLast + "\">Cancel<br>production<br></a></div></div>\n");
                else
                    sb.Append("                        <div id=\"ntf_buff_build\"><div id=\"button_build\"><a class=\"but_build_instant_a\" id=\"deleteTechs\">Delete tech items<br /></a></div></div>\n");
            }
            else
            {
                sb.Append("                    <div id=\"ntf_buff_build\">\n");
                sb.Append("                    <div id=\"button_build" + inCLS + "\">\n");
                if (inCLS2 != "_inactive")
                    sb.Append("                        <a class=\"but_build_instant_a\" onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalNanoTechFactory&subaction=buildBuff&buff=" + s + "\">\n");
                sb.Append("                            <strong class=\"buildlink" + inCLS + "\">PRODUCE</strong><br />\n");
                sb.Append("                            " + Factory.ConvertSeconds(ParseLong(GetOr(reso, "producetime"))) + "\n");
                if (inCLS2 != "_inactive") sb.Append("                        </a>\n");
                sb.Append("                    </div>\n</div>\n");
            }

            sb.Append("                <div id=\"ntf_buff_buy\">\n");
            sb.Append("                <div id=\"button_buy" + inCLS2 + "\">\n");
            if (inCLS2 != "_inactive")
                sb.Append("                    <a class=\"but_build_instant_a\" onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalNanoTechFactory&subaction=buynow&buff=" + s + "\">\n");
            sb.Append("                        <strong class=\"buildlink" + inCLS + "\">BUY NOW</strong>\n");
            if (inCLS2 != "_inactive")
                sb.Append("                        <br />\n                        <span class=\"fliess10px font_info\">\n                        " + PhpFormat.NumberFormat(buyn) + " Uridium</span>\n");
            if (inCLS != "_inactive") sb.Append("                    </a>\n");
            sb.Append("                </div>\n                </div>\n            </div>");

            var resp = new XajaxResponse();
            resp.Assign("buffcontainer", "innerHTML", sb.ToString());
            resp.Js("jQuery('#ntf_buff_scroll').jScrollPane({showArrows: true, autoReinitialise: true})");
            resp.CallClientFunc("updateConfirm", new[]
            {
                new KeyValuePair<string, string>("N0", del)
            });
            return resp;
        }

        // ------------------------------------------------------------------ sajax

        /// <summary>
        /// sajax request router (was /sajaxAPI.php). Response protocol: first char '+'
        /// (ok, payload from index 2) or '-' (error). Only "searchUser" had a server
        /// implementation in the surviving PHP source; the remaining wrappers
        /// (getInstances/updateAutoUpdate/changeBookmarkStatus/closeNewsUpdate/
        /// closeGuestLayer/changeCash_UK) had no handler at all — they silently hit the
        /// empty else branch, so we reproduce that with an empty body.
        /// </summary>
        public static async Task HandleSajax(HttpContext ctx)
        {
            Dictionary<string, string> form;
            List<string> repeatedArgs;
            if (ctx.Request.Method == HttpMethods.Post)
            {
                var f = await ctx.Request.ReadFormAsync();
                form = f.ToDictionary(k => k.Key, k => k.Value.ToString(), StringComparer.OrdinalIgnoreCase);
                repeatedArgs = ReadRepeated(f, "rsargs");
            }
            else
            {
                var q = ctx.Request.Query;
                form = q.ToDictionary(k => k.Key, k => k.Value.ToString(), StringComparer.OrdinalIgnoreCase);
                repeatedArgs = ReadRepeated(q, "rsargs");
            }

            form.TryGetValue("rs", out string rs);
            if (rs == "searchUser")
            {
                List<string> args = repeatedArgs;
                if (args.Count == 0) args = ReadRepeated(ctx.Request.Query, "rsargs[]");
                var clan = new Clan();
                string json = clan.ClanVoid(Arg(args, 0) ?? "");
                await WritePlain(ctx, "+:var res = " + json + "; res;");
                return;
            }

            // PHP: }else{ } — empty 200 body.
            await WritePlain(ctx, "");
        }

        // ---------------------------------------------------------------- helpers

        private static async Task WriteXml(HttpContext ctx, string xml)
        {
            ctx.Response.ContentType = "text/xml";
            await ctx.Response.WriteAsync(xml);
        }

        private static async Task WritePlain(HttpContext ctx, string text)
        {
            await ctx.Response.WriteAsync(text);
        }

        private static List<string> ReadRepeated(IQueryCollection form, string key)
        {
            var list = new List<string>();
            StringValues values;
            if (form.TryGetValue(key, out values))
                foreach (var v in values) list.Add(v);
            return list;
        }

        private static List<string> ReadRepeated(IFormCollection form, string key)
        {
            var list = new List<string>();
            StringValues values;
            if (form.TryGetValue(key, out values))
                foreach (var v in values) list.Add(v);
            return list;
        }

        private static string Arg(List<string> args, int i)
        {
            return i < args.Count ? args[i] : null;
        }

        private static long Lng(Users users, string col)
        {
            object o;
            if (users.DataRow == null || !users.DataRow.TryGetValue(col, out o)) return 0;
            return PlayerLog.ToLong(o);
        }

        private static long ParseLong(string s)
        {
            long v;
            return long.TryParse((s ?? "").Trim(), NumberStyles.Any, CultureInfo.InvariantCulture, out v) ? v : 0;
        }

        private static string GetOr(Dictionary<string, string> d, string k)
        {
            if (d == null) return null;
            string v;
            return d.TryGetValue(k, out v) ? v : null;
        }

        /// <summary>PHP echo of a float computed by division (matches "100/45*parts" output style).</summary>
        private static string Fmt(double d)
        {
            return d.ToString("0.#############################", CultureInfo.InvariantCulture);
        }

        private static string ResSpan(bool fail, string title, string value)
        {
            return fail
                ? "<span class=\"ntf_resource_fail\" title=\"" + title + "\">" + value + "</span>"
                : "<span class=\"ntf_resource_ok\" title=\"\">" + value + "</span>";
        }

        private static string Esc(string s)
        {
            return s ?? "";
        }
    }
}
