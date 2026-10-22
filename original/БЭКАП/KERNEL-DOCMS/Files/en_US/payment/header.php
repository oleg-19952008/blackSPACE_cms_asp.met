<!DOCTYPE html>
<!-- saved from url=(0025)http://www.eveonline.com/ -->
<html class="en  js canvas webgl no-touch hashchange history rgba multiplebgs borderradius boxshadow textshadow opacity cssanimations cssgradients csstransitions fontface generatedcontent video localstorage cors fullscreen" lang="en">
    <!--<![endif]-->
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" async="" src="./js/inpage_linkid.js" id="undefined"></script>
       <script type="text/javascript" async="" src="./js/analytics.js"></script>
    <script type="text/javascript" async="" src="./js/conversion_async.js"></script>
    <script type="text/javascript" async="" src="./js/dc.js"></script>
    <script id="twitter-wjs" src="./js/widgets.js"></script>
    <script src="./js/plusone.js" async="" gapi_processed="true"></script>
    <script src="./js/all.js" async="" id="facebook-jssdk"></script>
    <script src="./js/widgets.js" async=""></script>
    <script async="" src="./js/gtm.js"></script>
    <script type="text/javascript">
    window.NREUM || (NREUM = {});
    NREUM.info = {"beacon": "beacon-4.newrelic.com", "errorBeacon": "bam.nr-data.net", "licenseKey": "4519cc3c6b", "applicationID": "3098484", "transactionName": "b1xaYEADDEoHBxVRX1YWbUZbTSRLCQoVSFFfXBdmXQ0W", "queueTime": 1, "applicationTime": 42, "ttGuid": "6CDFF0AE24DB6873", "agent": "js-agent.newrelic.com/nr-411.min.js"}</script><script type="text/javascript">(window.NREUM || (NREUM = {})).loader_config = {xpid: "VwIAV1FQGwAAXVlWDwU="};
        window.NREUM || (NREUM = {}), __nr_require = function(t, e, n) {
            function r(n) {
                if (!e[n]) {
                    var o = e[n] = {exports: {}};
                    t[n][0].call(o.exports, function(e) {
                        var o = t[n][1][e];
                        return r(o ? o : e)
                    }, o, o.exports)
                }
                return e[n].exports
            }
            if ("function" == typeof __nr_require)
                return __nr_require;
            for (var o = 0; o < n.length; o++)
                r(n[o]);
            return r
        }({1: [function(t, e) {
                    function n(t, e, n) {
                        n || (n = {});
                        for (var r = o[t], a = r && r.length || 0, s = n[i] || (n[i] = {}), u = 0; a > u; u++)
                            r[u].apply(s, e);
                        return s
                    }
                    function r(t, e) {
                        var n = o[t] || (o[t] = []);
                        n.push(e)
                    }
                    var o = {}, i = "nr@context";
                    e.exports = {on: r, emit: n}
                }, {}], 2: [function(t) {
                    function e(t, e, n, i, s) {
                        return u ? u -= 1 : r("err", [s || new UncaughtException(t, e, n)]), "function" == typeof a ? a.apply(this, o(arguments)) : !1
                    }
                    function UncaughtException(t, e, n) {
                        this.message = t || "Uncaught error with no additional information", this.sourceURL = e, this.line = n
                    }
                    function n(t) {
                        r("err", [t, (new Date).getTime()])
                    }
                    var r = t("handle"), o = t(6), i = t(5), a = window.onerror, s = !1, u = 0;
                    t("loader").features.push("err"), window.onerror = e, NREUM.noticeError = n;
                    try {
                        throw new Error
                    } catch (d) {
                        "stack"in d && (t(1), t(2), "addEventListener"in window && t(3), window.XMLHttpRequest && XMLHttpRequest.prototype && XMLHttpRequest.prototype.addEventListener && t(4), s = !0)
                    }
                    i.on("fn-start", function() {
                        s && (u += 1)
                    }), i.on("fn-err", function(t, e, r) {
                        s && (this.thrown = !0, n(r))
                    }), i.on("fn-end", function() {
                        s && !this.thrown && u > 0 && (u -= 1)
                    }), i.on("internal-error", function(t) {
                        r("ierr", [t, (new Date).getTime(), !0])
                    })
                }, {1: 5, 2: 4, 3: 3, 4: 6, 5: 1, 6: 14, handle: "D5DuLP", loader: "G9z0Bl"}], 3: [function(t) {
                    function e(t) {
                        r.inPlace(t, ["addEventListener", "removeEventListener"], "-", n)
                    }
                    function n(t) {
                        return t[1]
                    }
                    var r = t(1), o = (t(3), t(2));
                    if (e(window), "getPrototypeOf"in Object) {
                        for (var i = document; i && !i.hasOwnProperty("addEventListener"); )
                            i = Object.getPrototypeOf(i);
                        i && e(i);
                        for (var a = XMLHttpRequest.prototype; a && !a.hasOwnProperty("addEventListener"); )
                            a = Object.getPrototypeOf(a);
                        a && e(a)
                    } else
                        XMLHttpRequest.prototype.hasOwnProperty("addEventListener") && e(XMLHttpRequest.prototype);
                    o.on("addEventListener-start", function(t) {
                        if (t[1]) {
                            var e = t[1];
                            "function" == typeof e ? this.wrapped = e["nr@wrapped"] ? t[1] = e["nr@wrapped"] : e["nr@wrapped"] = t[1] = r(e, "fn-") : "function" == typeof e.handleEvent && r.inPlace(e, ["handleEvent"], "fn-")
                        }
                    }), o.on("removeEventListener-start", function(t) {
                        var e = this.wrapped;
                        e && (t[1] = e)
                    })
                }, {1: 15, 2: 1, 3: 14}], 4: [function(t) {
                    var e = (t(3), t(1)), n = t(2);
                    e.inPlace(window, ["requestAnimationFrame", "mozRequestAnimationFrame", "webkitRequestAnimationFrame", "msRequestAnimationFrame"], "raf-"), n.on("raf-start", function(t) {
                        t[0] = e(t[0], "fn-")
                    })
                }, {1: 15, 2: 1, 3: 14}], 5: [function(t) {
                    function e(t) {
                        var e = t[0];
                        "string" == typeof e && (e = new Function(e)), t[0] = n(e, "fn-")
                    }
                    var n = (t(3), t(1)), r = t(2);
                    n.inPlace(window, ["setTimeout", "setInterval", "setImmediate"], "setTimer-"), r.on("setTimer-start", e)
                }, {1: 15, 2: 1, 3: 14}], 6: [function(t) {
                    function e() {
                        o.inPlace(this, s, "fn-")
                    }
                    function n(t, e) {
                        o.inPlace(e, ["onreadystatechange"], "fn-")
                    }
                    function r(t, e) {
                        return e
                    }
                    var o = t(1), i = t(2), a = window.XMLHttpRequest, s = ["onload", "onerror", "onabort", "onloadstart", "onloadend", "onprogress", "ontimeout"];
                    window.XMLHttpRequest = function(t) {
                        var n = new a(t);
                        try {
                            i.emit("new-xhr", [], n), o.inPlace(n, ["addEventListener", "removeEventListener"], "-", function(t, e) {
                                return e
                            }), n.addEventListener("readystatechange", e, !1)
                        } catch (r) {
                            try {
                                i.emit("internal-error", r)
                            } catch (s) {
                            }
                        }
                        return n
                    }, window.XMLHttpRequest.prototype = a.prototype, o.inPlace(XMLHttpRequest.prototype, ["open", "send"], "-xhr-", r), i.on("send-xhr-start", n), i.on("open-xhr-start", n)
                }, {1: 15, 2: 1}], 7: [function(t) {
                    function e() {
                        function e(t) {
                            if ("string" == typeof t && t.length)
                                return t.length;
                            if ("object" != typeof t)
                                return void 0;
                            if ("undefined" != typeof ArrayBuffer && t instanceof ArrayBuffer && t.byteLength)
                                return t.byteLength;
                            if ("undefined" != typeof Blob && t instanceof Blob && t.size)
                                return t.size;
                            if ("undefined" != typeof FormData && t instanceof FormData)
                                return void 0;
                            try {
                                return JSON.stringify(t).length
                            } catch (e) {
                                return void 0
                            }
                        }
                        function n(t) {
                            var n = this.params, r = this.metrics;
                            if (!this.ended) {
                                this.ended = !0;
                                for (var i = 0; u > i; i++)
                                    t.removeEventListener(s[i], this.listener, !1);
                                if (!n.aborted) {
                                    if (r.duration = (new Date).getTime() - this.startTime, 4 === t.readyState) {
                                        n.status = t.status;
                                        var a = t.responseType, d = "arraybuffer" === a || "blob" === a || "json" === a ? t.response : t.responseText, f = e(d);
                                        if (f && (r.rxSize = f), this.sameOrigin) {
                                            var c = t.getResponseHeader("X-NewRelic-App-Data");
                                            c && (n.cat = c.split(", ").pop())
                                        }
                                    } else
                                        n.status = 0;
                                    r.cbTime = this.cbTime, o("xhr", [n, r])
                                }
                            }
                        }
                        function r(t, e) {
                            var n = i(e), r = t.params;
                            r.host = n.hostname + ":" + n.port, r.pathname = n.pathname, t.sameOrigin = n.sameOrigin
                        }
                        t("loader").features.push("xhr");
                        var o = t("handle"), i = t(1), a = t(5), s = ["load", "error", "abort", "timeout"], u = s.length, d = t(2);
                        t(3), t(4), a.on("new-xhr", function() {
                            this.totalCbs = 0, this.called = 0, this.cbTime = 0, this.end = n, this.ended = !1, this.xhrGuids = {}
                        }), a.on("open-xhr-start", function(t) {
                            this.params = {method: t[0]}, r(this, t[1]), this.metrics = {}
                        }), a.on("open-xhr-end", function(t, e) {
                            "loader_config"in NREUM && "xpid"in NREUM.loader_config && this.sameOrigin && e.setRequestHeader("X-NewRelic-ID", NREUM.loader_config.xpid)
                        }), a.on("send-xhr-start", function(t, n) {
                            var r = this.metrics, o = t[0], i = this;
                            if (r && o) {
                                var d = e(o);
                                d && (r.txSize = d)
                            }
                            this.startTime = (new Date).getTime(), this.listener = function(t) {
                                try {
                                    "abort" === t.type && (i.params.aborted = !0), ("load" !== t.type || i.called === i.totalCbs && (i.onloadCalled || "function" != typeof n.onload)) && i.end(n)
                                } catch (e) {
                                    try {
                                        a.emit("internal-error", e)
                                    } catch (r) {
                                    }
                                }
                            };
                            for (var f = 0; u > f; f++)
                                n.addEventListener(s[f], this.listener, !1)
                        }), a.on("xhr-cb-time", function(t, e, n) {
                            this.cbTime += t, e ? this.onloadCalled = !0 : this.called += 1, this.called !== this.totalCbs || !this.onloadCalled && "function" == typeof n.onload || this.end(n)
                        }), a.on("xhr-load-added", function(t, e) {
                            var n = "" + d(t) + !!e;
                            this.xhrGuids && !this.xhrGuids[n] && (this.xhrGuids[n] = !0, this.totalCbs += 1)
                        }), a.on("xhr-load-removed", function(t, e) {
                            var n = "" + d(t) + !!e;
                            this.xhrGuids && this.xhrGuids[n] && (delete this.xhrGuids[n], this.totalCbs -= 1)
                        }), a.on("addEventListener-end", function(t, e) {
                            e instanceof XMLHttpRequest && "load" === t[0] && a.emit("xhr-load-added", [t[1], t[2]], e)
                        }), a.on("removeEventListener-end", function(t, e) {
                            e instanceof XMLHttpRequest && "load" === t[0] && a.emit("xhr-load-removed", [t[1], t[2]], e)
                        }), a.on("fn-start", function(t, e, n) {
                            e instanceof XMLHttpRequest && ("onload" === n && (this.onload = !0), ("load" === (t[0] && t[0].type) || this.onload) && (this.xhrCbStart = (new Date).getTime()))
                        }), a.on("fn-end", function(t, e) {
                            this.xhrCbStart && a.emit("xhr-cb-time", [(new Date).getTime() - this.xhrCbStart, this.onload, e], e)
                        })
                    }
                    window.XMLHttpRequest && XMLHttpRequest.prototype && XMLHttpRequest.prototype.addEventListener && !/CriOS/.test(navigator.userAgent) && e()
                }, {1: 8, 2: 11, 3: 3, 4: 6, 5: 1, handle: "D5DuLP", loader: "G9z0Bl"}], 8: [function(t, e) {
                    e.exports = function(t) {
                        var e = document.createElement("a"), n = window.location, r = {};
                        e.href = t, r.port = e.port;
                        var o = e.href.split("://");
                        return!r.port && o[1] && (r.port = o[1].split("/")[0].split(":")[1]), r.port && "0" !== r.port || (r.port = "https" === o[0] ? "443" : "80"), r.hostname = e.hostname || n.hostname, r.pathname = e.pathname, "/" !== r.pathname.charAt(0) && (r.pathname = "/" + r.pathname), r.sameOrigin = !e.hostname || e.hostname === document.domain && e.port === n.port && e.protocol === n.protocol, r
                    }
                }, {}], handle: [function(t, e) {
                    e.exports = t("D5DuLP")
                }, {}], D5DuLP: [function(t, e) {
                    function n(t, e) {
                        var n = r[t];
                        return n ? n.apply(this, e) : (o[t] || (o[t] = []), void o[t].push(e))
                    }
                    var r = {}, o = {};
                    e.exports = n, n.queues = o, n.handlers = r
                }, {}], 11: [function(t, e) {
                    function n(t) {
                        if (!t || "object" != typeof t && "function" != typeof t)
                            return-1;
                        if (t === window)
                            return 0;
                        if (o.call(t, "__nr"))
                            return t.__nr;
                        try {
                            return Object.defineProperty(t, "__nr", {value: r, writable: !0, enumerable: !1}), r
                        } catch (e) {
                            return t.__nr = r, r
                        } finally {
                            r += 1
                        }
                    }
                    var r = 1, o = Object.prototype.hasOwnProperty;
                    e.exports = n
                }, {}], loader: [function(t, e) {
                    e.exports = t("G9z0Bl")
                }, {}], G9z0Bl: [function(t, e) {
                    function n() {
                        var t = p.info = NREUM.info;
                        if (t && t.agent && t.licenseKey && t.applicationID && u && u.body) {
                            p.proto = "https" === c.split(":")[0] || t.sslForHttp ? "https://" : "http://", a("mark", ["onload", i()]);
                            var e = u.createElement("script");
                            e.src = p.proto + t.agent, u.body.appendChild(e)
                        }
                    }
                    function r() {
                        "complete" === u.readyState && o()
                    }
                    function o() {
                        a("mark", ["domContent", i()])
                    }
                    function i() {
                        return(new Date).getTime()
                    }
                    var a = t("handle"), s = window, u = s.document, d = "addEventListener", f = "attachEvent", c = ("" + location).split("?")[0], p = e.exports = {offset: i(), origin: c, features: []};
                    u[d] ? (u[d]("DOMContentLoaded", o, !1), s[d]("load", n, !1)) : (u[f]("onreadystatechange", r), s[f]("onload", n)), a("mark", ["firstbyte", i()])
                }, {handle: "D5DuLP"}], 14: [function(t, e) {
                    function n(t, e, n) {
                        e || (e = 0), "undefined" == typeof n && (n = t ? t.length : 0);
                        for (var r = -1, o = n - e || 0, i = Array(0 > o ? 0 : o); ++r < o; )
                            i[r] = t[e + r];
                        return i
                    }
                    e.exports = n
                }, {}], 15: [function(t, e) {
                    function n(t, e, r, s) {
                        function nrWrapper() {
                            try {
                                var n, a = u(arguments), d = this, f = r && r(a, d) || {}
                            } catch (c) {
                                i([c, "", [a, d, s], f])
                            }
                            o(e + "start", [a, d, s], f);
                            try {
                                return n = t.apply(d, a)
                            } catch (p) {
                                throw o(e + "err", [a, d, p], f), p
                            } finally {
                                o(e + "end", [a, d, n], f)
                            }
                        }
                        return a(t) ? t : (e || (e = ""), nrWrapper[n.flag] = !0, nrWrapper)
                    }
                    function r(t, e, r, o) {
                        r || (r = "");
                        var i, s, u, d = "-" === r.charAt(0);
                        for (u = 0; u < e.length; u++)
                            s = e[u], i = t[s], a(i) || (t[s] = n(i, d ? s + r : r, o, s, t))
                    }
                    function o(t, e, n) {
                        try {
                            s.emit(t, e, n)
                        } catch (r) {
                            i([r, t, e, n])
                        }
                    }
                    function i(t) {
                        try {
                            s.emit("internal-error", t)
                        } catch (e) {
                        }
                    }
                    function a(t) {
                        return!(t && "function" == typeof t && t.apply && !t[n.flag])
                    }
                    var s = t(1), u = t(2);
                    e.exports = n, n.inPlace = r, n.flag = "nr@wrapper"
                }, {1: 1, 2: 14}]}, {}, ["G9z0Bl", 2, 7]);</script>
    <meta charset="utf-8">

    <title>Payments - Dark Space</title>

    <meta name="author" content="Medianet.us">
    <meta name="viewport" content="width=device-width">



    <meta name="description" content="Dark Space is a massive multiplayer online game that offers limitless potential to discover, explore and conquer an amazing science fiction universe where you pilot spaceships, fight, trade, and form corporations and alliances with other players.">
    <!-- Google +1 data -->
    <meta itemprop="name" content="Dark Space">



    <meta property="og:url" content="http://<?php echo DynHost?>/">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="Dark Space">
    <meta property="fb:admins" content="336200018,1245262884">

    <link rel="stylesheet" href="./css/cdn/styles-140523113238.css">

    <script src="./js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="/ccp/js/libs/jquery-1.8.min.js"><\/script>')</script>

    <script src="./js/modernizr.custom.js"></script>
    <script src="./js/amplify-1.1.0.min.js"></script>


    <style type="text/css"></style>
    <style type="text/css">
        .fb_hidden{position:absolute;top:-10000px;z-index:10001}.fb_invisible{display:none}.fb_reset{background:none;border:0;border-spacing:0;color:#000;cursor:auto;direction:ltr;font-family:"lucida grande", tahoma, verdana, arial, sans-serif;font-size:11px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;line-height:1;margin:0;overflow:visible;padding:0;text-align:left;text-decoration:none;text-indent:0;text-shadow:none;text-transform:none;visibility:visible;white-space:normal;word-spacing:normal}.fb_reset>div{overflow:hidden}.fb_link img{border:none}
        .fb_dialog{background:rgba(82, 82, 82, .7);position:absolute;top:-10000px;z-index:10001}.fb_reset .fb_dialog_legacy{overflow:visible}.fb_dialog_advanced{padding:10px;-moz-border-radius:8px;-webkit-border-radius:8px;border-radius:8px}.fb_dialog_content{background:#fff;color:#333}.fb_dialog_close_icon{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 0 transparent;_background-image:url(http://static.ak.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif);cursor:pointer;display:block;height:15px;position:absolute;right:18px;top:17px;width:15px}.fb_dialog_mobile .fb_dialog_close_icon{top:5px;left:5px;right:auto}.fb_dialog_padding{background-color:transparent;position:absolute;width:1px;z-index:-1}.fb_dialog_close_icon:hover{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -15px transparent;_background-image:url(http://static.ak.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif)}.fb_dialog_close_icon:active{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -30px transparent;_background-image:url(http://static.ak.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif)}.fb_dialog_loader{background-color:#f2f2f2;border:1px solid #606060;font-size:24px;padding:20px}.fb_dialog_top_left,.fb_dialog_top_right,.fb_dialog_bottom_left,.fb_dialog_bottom_right{height:10px;width:10px;overflow:hidden;position:absolute}.fb_dialog_top_left{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 0;left:-10px;top:-10px}.fb_dialog_top_right{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -10px;right:-10px;top:-10px}.fb_dialog_bottom_left{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -20px;bottom:-10px;left:-10px}.fb_dialog_bottom_right{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -30px;right:-10px;bottom:-10px}.fb_dialog_vert_left,.fb_dialog_vert_right,.fb_dialog_horiz_top,.fb_dialog_horiz_bottom{position:absolute;background:#525252;filter:alpha(opacity=70);opacity:.7}.fb_dialog_vert_left,.fb_dialog_vert_right{width:10px;height:100%}.fb_dialog_vert_left{margin-left:-10px}.fb_dialog_vert_right{right:0;margin-right:-10px}.fb_dialog_horiz_top,.fb_dialog_horiz_bottom{width:100%;height:10px}.fb_dialog_horiz_top{margin-top:-10px}.fb_dialog_horiz_bottom{bottom:0;margin-bottom:-10px}.fb_dialog_iframe{line-height:0}.fb_dialog_content .dialog_title{background:#6d84b4;border:1px solid #3b5998;color:#fff;font-size:14px;font-weight:bold;margin:0}.fb_dialog_content .dialog_title>span{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/yd/r/Cou7n-nqK52.gif) no-repeat 5px 50%;float:left;padding:5px 0 7px 26px}body.fb_hidden{-webkit-transform:none;height:100%;margin:0;overflow:visible;position:absolute;top:-10000px;left:0;width:100%}.fb_dialog.fb_dialog_mobile.loading{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/ya/r/3rhSv5V8j3o.gif) white no-repeat 50% 50%;min-height:100%;min-width:100%;overflow:hidden;position:absolute;top:0;z-index:10001}.fb_dialog.fb_dialog_mobile.loading.centered{max-height:590px;min-height:590px;max-width:500px;min-width:500px}#fb-root #fb_dialog_ipad_overlay{background:rgba(0, 0, 0, .45);position:absolute;left:0;top:0;width:100%;min-height:100%;z-index:10000}#fb-root #fb_dialog_ipad_overlay.hidden{display:none}.fb_dialog.fb_dialog_mobile.loading iframe{visibility:hidden}.fb_dialog_content .dialog_header{-webkit-box-shadow:white 0 1px 1px -1px inset;background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#738ABA), to(#2C4987));border-bottom:1px solid;border-color:#1d4088;color:#fff;font:14px Helvetica, sans-serif;font-weight:bold;text-overflow:ellipsis;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0;vertical-align:middle;white-space:nowrap}.fb_dialog_content .dialog_header table{-webkit-font-smoothing:subpixel-antialiased;height:43px;width:100%}.fb_dialog_content .dialog_header td.header_left{font-size:12px;padding-left:5px;vertical-align:middle;width:60px}.fb_dialog_content .dialog_header td.header_right{font-size:12px;padding-right:5px;vertical-align:middle;width:60px}.fb_dialog_content .touchable_button{background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#4966A6), color-stop(.5, #355492), to(#2A4887));border:1px solid #29447e;-webkit-background-clip:padding-box;-webkit-border-radius:3px;-webkit-box-shadow:rgba(0, 0, 0, .117188) 0 1px 1px inset, rgba(255, 255, 255, .167969) 0 1px 0;display:inline-block;margin-top:3px;max-width:85px;line-height:18px;padding:4px 12px;position:relative}.fb_dialog_content .dialog_header .touchable_button input{border:none;background:none;color:#fff;font:12px Helvetica, sans-serif;font-weight:bold;margin:2px -12px;padding:2px 6px 3px 6px;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog_content .dialog_header .header_center{color:#fff;font-size:16px;font-weight:bold;line-height:18px;text-align:center;vertical-align:middle}.fb_dialog_content .dialog_content{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/y9/r/jKEcVPZFk-2.gif) no-repeat 50% 50%;border:1px solid #555;border-bottom:0;border-top:0;height:150px}.fb_dialog_content .dialog_footer{background:#f2f2f2;border:1px solid #555;border-top-color:#ccc;height:40px}#fb_dialog_loader_close{float:left}.fb_dialog.fb_dialog_mobile .fb_dialog_close_button{text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog.fb_dialog_mobile .fb_dialog_close_icon{visibility:hidden}
        .fb_iframe_widget{display:inline-block;position:relative}.fb_iframe_widget span{display:inline-block;position:relative;text-align:justify}.fb_iframe_widget iframe{position:absolute}.fb_iframe_widget_lift{z-index:1}.fb_hide_iframes iframe{position:relative;left:-10000px}.fb_iframe_widget_loader{position:relative;display:inline-block}.fb_iframe_widget_fluid{display:inline}.fb_iframe_widget_fluid span{width:100%}.fb_iframe_widget_loader iframe{min-height:32px;z-index:2;zoom:1}.fb_iframe_widget_loader .FB_Loader{background:url(http://static.ak.fbcdn.net/rsrc.php/v2/y9/r/jKEcVPZFk-2.gif) no-repeat;height:32px;width:32px;margin-left:-16px;position:absolute;left:50%;z-index:4}
        .fb_connect_bar_container div,.fb_connect_bar_container span,.fb_connect_bar_container a,.fb_connect_bar_container img,.fb_connect_bar_container strong{background:none;border-spacing:0;border:0;direction:ltr;font-style:normal;font-variant:normal;letter-spacing:normal;line-height:1;margin:0;overflow:visible;padding:0;text-align:left;text-decoration:none;text-indent:0;text-shadow:none;text-transform:none;visibility:visible;white-space:normal;word-spacing:normal;vertical-align:baseline}.fb_connect_bar_container{position:fixed;left:0 !important;right:0 !important;height:42px !important;padding:0 25px !important;margin:0 !important;vertical-align:middle !important;border-bottom:1px solid #333 !important;background:#3b5998 !important;z-index:99999999 !important;overflow:hidden !important}.fb_connect_bar_container_ie6{position:absolute;top:expression(document.compatMode=="CSS1Compat"? document.documentElement.scrollTop+"px":body.scrollTop+"px")}.fb_connect_bar{position:relative;margin:auto;height:100%;width:100%;padding:6px 0 0 0 !important;background:none;color:#fff !important;font-family:"lucida grande", tahoma, verdana, arial, sans-serif !important;font-size:13px !important;font-style:normal !important;font-variant:normal !important;font-weight:normal !important;letter-spacing:normal !important;line-height:1 !important;text-decoration:none !important;text-indent:0 !important;text-shadow:none !important;text-transform:none !important;white-space:normal !important;word-spacing:normal !important}.fb_connect_bar a:hover{color:#fff}.fb_connect_bar .fb_profile img{height:30px;width:30px;vertical-align:middle;margin:0 6px 5px 0}.fb_connect_bar div a,.fb_connect_bar span,.fb_connect_bar span a{color:#bac6da;font-size:11px;text-decoration:none}.fb_connect_bar .fb_buttons{float:right;margin-top:7px}
        .fbpluginrecommendationsbarleft,.fbpluginrecommendationsbarright{position:fixed !important;bottom:0;z-index:999}.fbpluginrecommendationsbarleft{left:10px}.fbpluginrecommendationsbarright{right:10px}</style>

    </head>
