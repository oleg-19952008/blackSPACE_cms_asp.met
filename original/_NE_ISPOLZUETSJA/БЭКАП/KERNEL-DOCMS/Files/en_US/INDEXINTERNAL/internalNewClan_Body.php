<?php
$clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
if (isset($_GET['subaction']) && $_GET['subaction'] == "searchClanList") {
    $clans = $clan->getClans("'%" . $_POST['lookup'] . "%'", '?action=internalNewClan');
} else {
    $clans = $clan->getClans(null, '?action=internalNewClan');
}
$range = $clan->getRange();
$cuPage = $clan->getCurrentPage();
$total = $clan->getTotalOfResults();
$tPage = $clan->getTotalOfPages();
if (isset($_GET['sort'])) {
    
    function cust_sort($a, $b) {
        return strtolower($a[$_GET['sort']]) > strtolower($b[$_GET['sort']]);
    }
    usort($clans, 'cust_sort');
}
?>
</head>
<body onLoad="" >
    <!-- affiliateStartTag -->



    <!.. user context info layer -->
    <div id="userInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
    <!-- hangar context info layer -->
    <div id="hangarInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
    <!-- clan info layer -->
    <div id="clanInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
    <!-- seitenabdecker -->



    <div id="generalInfoPopup" class="fliess13px-grey">
        <div class="popup_headcontainer">
            <a id="general_popup_close" class="popup_close" href="#" ></a>
        </div>
        <div id="general_popup_question" class="question">
            <img src="./do_img/global/popups/general/success_icon.png?__cv=7ea7548d2cb4149555faab27c783e500" id="general_popup_success" class="success" />
            <img src="./do_img/global/popups/general/error_icon.png?__cv=abbabc79fb0ffe608c13a681aa9db900" id="general_popup_error" class="error" />
            <p id="general_popup_question_text">this text will be replace on xajax call</p>
        </div>
        <div class="popup_contentcontainer">
            <div class="popup_footcontainer">
                <div id="general_popup_close_button" class="popup_close_button">
                    <img src="./do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey" />
                </div>
            </div>
        </div>
    </div>


    <div id="busy_layer"></div>


    <!-- seitenabdecker -->

    <style type="text/css" media="screen">    @import "http://<?php echo DynHost; ?>/css/cdn/includeInfoLayer.css?__cv=6f32d2604f47c348e721414f1418ee00";</style>
    <script type="text/javascript">
        infoText = '';
        icon = '';
    </script>
    <script type="text/javascript" src="./js/infoLayer.js?__cv=f873586616939bcb06c5d95a7ef73200"></script>

    <div id="infoLayer" class="confirmInfoLayer fliess13px-grey">
        <div class="popup_shop_headcontainer">
            <a class="popup_shop_close" href="javascript: void(0);" onclick="closeInfoLayer()"></a>
        </div>
        <div class="popup_shop_contentcontainer">
            <br>
            <div class="question"></div>
            <div class="popup_shop_footcontainer">
                <div id="infoLayerConfirm">
                    <div class="popup_shop_confirm_button">
                        <div id="infoLayer_link_confirm"
                             class="popup_shop_confirm_text"
                             style="background-image: url(
                             './do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey'
                             );">
                        </div>
                    </div>
                    <div class="popup_shop_abort_button">
                        <div class="popup_shop_abort_text"
                             style="background-image: url(
                             './do_img/global/text_tf.esg?l=us&s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey'
                             );"
                             onclick="closeInfoLayer();">
                        </div>
                    </div>
                </div>

                <div id="infoLayerInfo">
                    <div class="popup_shop_close_button">
                        <div class="popup_shop_close_text"
                             style='background-image: url("./do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey");'
                             onclick="closeInfoLayer();"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    </script>

    <?php
    require GLOBALS . 'internalHelpLayer.php';
    require GLOBALS . 'internalNews.php';
    ?>
    <div class="backgroundImageContainer">
        <div class="overallContainer">

            <div class="outerContainer fliess11px-gelb">

<?php require GLOBALS . 'internalHeaderIntern.php'; ?>

                <div class="bodyContainer">

                    <!-- start clanlist template -->

                    <link rel="stylesheet" href="/css/cdn/navigation.css?__cv=027602d6f1863686ece0574190059400" />

                    <script type="text/javascript" src="/js/page/clan/internalNewClanIndexDomReady.js?__cv=2dc5d4f0df5f490bb84b9ada5fab8a00"></script>

                    <div class="frameTop"><!--  --></div>
                    <div class="frameLeft_top"><!--  --></div>
                    <div class="frameRight_top"><!--  --></div>
                    <div class="contentFrame">
                        <div class="borderFrame">
                            <div id="navigationFrame">

                                <!-- start internal clan2 -->

                                <div id="navigation">
                                    <!-- Join -->
                                    <div class="button active">
                                        <a href="indexInternal.es?action=internalNewClan" title="Join">
                                            <img src="./text?t=JOIN&w=16&s=9.2&color=black&b=lightestBlue"/>
                                        </a>
                                    </div>

                                    <div class="button ">
                                        <a href="indexInternal.es?action=internalNewClanDetails&subaction=foundClan" title="Found">
                                            <img src="./text?t=FOUND&w=16&s=9.2&color=white&font=1&b=grey"/>
                                        </a>
                                    </div>


                                    <!-- Company Change -->
                                    <div class="button ">
                                        <a href="indexInternal.es?action=internalClan&tpl=internalClanChangeFirm" title="Company">
                                            <img src="./text?t=COMPANY&w=16&s=9.2&color=white&font=1&b=grey"/>
                                        </a>
                                    </div>
                                </div>

                                <!-- end internal clan2 -->
                                <div id="wrapper" class="clanList" style="height:404px;">

                                    <div class="header">
                                        <div class="headline">Clan list</div>
                                        <div class="controlls">

                                            <form id="searchClanList" name="search" action="indexInternal.es?action=internalNewClan&subaction=searchClanList" method="POST"><input type="hidden" name="reloadToken" value="a6c30bc1ed6c587ba01524c823130e5f">
                                                <input type="hidden" name="filterMembers" value="all" />
                                                <input type="hidden" name="filterRank" value="all" />
                                                <input type="hidden" name="filterFaction" value="all" />
                                                <input type="hidden" name="filterStatus" value="all" />

                                                <div class="searchArea">

                                                    <div class="searchFieldWrapper">
                                                        <input type="text" class="searchField" name="lookup" class="" value="" title="Search..." />
                                                        <input class="searchButton" name="submit" type="submit" class="" title="Search" />
                                                    </div>
                                                    <input type="button" name="activateFilter" id="activateFilter" value="Advanced search" onclick="showFilterLayer();">
                                                </div>
                                            </form>
                                        </div>
                                        <div style="clear:both;"><!--  --></div>
                                    </div>

                                    <ul class="clan_items" style="margin:1px 0 3px 0;">
                                        <li class="clan_item">
                                            <span class="clanname">
                                                <a href="indexInternal.es?action=internalNewClan&page=<?php echo $cuPage; ?>&sort=clanName&direction=desc" class="sortable " title="click to sort by this column">
                                                    Name
                                                </a>

                                            </span>
                                            <span class="ranking">
                                                <a href="indexInternal.es?action=internalNewClan&page=<?php echo $cuPage; ?>&sort=tagName&direction=desc" class="sortable " title="click to sort by this column">
                                                    Tag
                                                </a>
                                            </span>
                                            <span class="members">
                                                <a href="indexInternal.es?action=internalNewClan&page=<?php echo $cuPage; ?>&sort=memberCount&direction=desc" class="sortable" title="click to sort by this column">
                                                    Members
                                                </a>
                                            </span>
                                            <span class="ranking">
                                                <a href="indexInternal.es?action=internalNewClan&page=<?php echo $cuPage; ?>&sort=clanName&direction=desc" class="sortable " title="click to sort by this column">
                                                    Rank
                                                </a>
                                            </span>
                                            <span class="affiliation">
                                                <a href="indexInternal.es?action=internalNewClan&page=<?php echo $cuPage; ?>&sort=company&direction=desc" class="sortable " title="click to sort by this column">
                                                    Company
                                                </a>
                                            </span>
                                            <span class="status">
                                                <a href="indexInternal.es?action=internalNewClan&page=<?php echo $cuPage; ?>&sort=recruiting&direction=desc" class="sortable " title="click to sort by this column">
                                                    Status
                                                </a>
                                            </span>
                                        </li>
                                    </ul>


                                    <div style="width: 623px; height: 275px;">
                                        <div class="js-scroll-pane" style="height: 264px; overflow: auto; ">
                                            <ul class="clan_items">
                                                <?php
                                                if ($total != 0) {
                                                    if ($cuPage == 1) {
                                                        $start = 0;
                                                        if($total<$range):
                                                            $end = $total;
                                                            else:                                                            
                                                            $end = $range;
                                                        endif;
                                                    } else {
                                                        $start = ($cuPage - 1) * $range;
                                                        if ($cuPage != $tPage) {
                                                            $end = $cuPage * $range;
                                                        } else {
                                                            $end = $total;
                                                        }
                                                    }
                                                    for ($i = $start; $i < $end; $i++) {
                                                        if($clans[$i]['recruiting']==1):
                                                                $re = "recruiting";
                                                                $ro = "Recruiting";
                                                            elseif($clans[$i]['recruiting']==0):
                                                                 $re = "notRecruiting";
                                                                 $ro = "Closed";
                                                            elseif($clans[$i]['recruiting']==2):
                                                                 $re = "recruiting";
                                                                 $ro = "Fully elite";
                                                            else:
                                                              $re = "recruiting";
                                                              $ro = "";
                                                        endif;
                                                        if (strpos($clans[$i]['members'], '|') !== false) {
                                                            $v = explode("|", $clans[$i]['members']);
                                                            $num = count($v);
                                                        } else {
                                                            $num = 1;
                                                        }

                                                        $aff = strtoupper($clans[$i]['company']);
                                                        echo '<li class="clan_item">
                                                    <span class="clanname">
                                                        <a href="indexInternal.es?action=internalNewClanDetails&clanId=' . $clans[$i]['clanID'] . '" class="clanlink" title="' . $clans[$i]['clanName'] . '">
                                                            ' . $clans[$i]['clanName'] . '
                                                        </a>
                                                    </span>
                                                    <span class="ranking">' . $clans[$i]['tagName'] . '</span>
                                                    <span class="members">' . $num . '</span>
                                                    <span class="ranking">' . $clans[$i]['rank'] . '</span>
                                                    <span class="affiliation">' . $aff . '</span>
                                                    <span class="status '.$re.'">
                                                        '.$ro.'
                                                    </span>
                                                </li>';
                                                    }
                                                } else {
                                                    echo '<li class="no_items even">This search produced no results.</li>';
                                                }
                                                ?>

                                            </ul>
                                        </div>
                                    </div>

                                    <div style="text-align:center; margin-top: 13px;">
                                    <?php echo $clan->paginate(); ?>
                                        <!--<font class='navi_black'><b>[1] </b></font><a class="navi_normal" href="indexInternal.es?action=internalNewClan&sort=members&direction=desc&page=2">2</a> <a class="navi_normal" href="indexInternal.es?action=internalNewClan&sort=members&direction=desc&page=3">3</a> <a class="navi_normal" href="indexInternal.es?action=internalNewClan&sort=members&direction=desc&page=4">4</a> <a class="navi_normal" href="indexInternal.es?action=internalNewClan&sort=members&direction=desc&page=5">5</a> <a class="navi_normal" href="indexInternal.es?action=internalNewClan&sort=members&direction=desc&page=2">Next </a>  ...<a class="navi_normal" href="indexInternal.es?action=internalNewClan&sort=members&direction=desc&page=171">171</a>--> 
                                    </div>

                                </div><!-- end div#wrapper -->

                                <div style="clear:both;"><!--  --></div>

                            </div><!-- end div#navigationWrapper -->

                        </div>
                    </div>

                    <!-- end clanlist template -->

                    <div id="clanSearchAdvancedLayer" style="display: none;">
                        <div id="filterLayerHead">Advanced search</div>

                        <div id="filterLayerBody">
                            <div class="filterCriteria">
                                <div class="filterCriteriaHead">
                                    Select one or more filters
                                </div>

                                <div class="filterCriteriaBox">
                                    <div class="filterCritLabel">Members</div>
                                    <div class="filterCritSelect" id="filterByMembers">
                                        All
                                    </div>
                                    <div class="filterCritSelectLayer hidden" id="filterByMembersLayer">
                                        <div id="filterByMembers_all">All</div>
                                        <div id="filterByMembers_6">6 - 10</div>
                                        <div id="filterByMembers_11">11 - 20</div>
                                        <div id="filterByMembers_21">21 - 30</div>
                                        <div id="filterByMembers_31">31 - 40</div>
                                        <div id="filterByMembers_41">41 - 50</div>
                                    </div>

                                    <div class="filterCritLabel">Rank</div>
                                    <div class="filterCritSelect" id="filterByRank">
                                        All
                                    </div>
                                    <div class="filterCritSelectLayer hidden" id="filterByRankLayer">
                                        <div id="filterByRank_all">All</div>
                                        <div id="filterByRank_-10">0 - 10</div>
                                        <div id="filterByRank_-50">0 - 50</div>
                                        <div id="filterByRank_-100">0 - 100</div>
                                        <div id="filterByRank_100+">100 - 200</div>
                                        <div id="filterByRank_200+">201 - 300</div>
                                    </div>

                                    <div class="filterCritLabel">Company</div>
                                    <div class="filterCritSelect" id="filterByFaction">
                                        All
                                    </div>
                                    <div class="filterCritSelectLayer hidden" id="filterByFactionLayer">
                                        <div id="filterByFaction_all">All</div>
                                        <div id="filterByFaction_1">MMO</div>
                                        <div id="filterByFaction_2">EIC</div>
                                        <div id="filterByFaction_3">VRU</div>
                                    </div>

                                    <div class="filterCritLabel">Recruiting</div>
                                    <div class="filterCritSelect" id="filterByStatus">
                                        All
                                    </div>
                                    <div class="filterCritSelectLayer hidden" id="filterByStatusLayer">
                                        <div id="filterByStatus_all">All</div>
                                        <div id="filterByStatus_1">Level 10+</div>
                                        <div id="filterByStatus_2">Level 16+</div>
                                        <div id="filterByStatus_3">Fully elite</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="footerContainer">
                        <div class="frameLeft_bottom"></div>
                        <div class="frameRight_bottom"></div>
                        <div class="frameBottom"></div>

                        <div id="alertBox" class="fliesstext"></div>
                        <div id="imprint" style="width:523px;height:600px;" class="fliesstext">
                            <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="./do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt="" /></a></div>
                            <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>EBBC D <br>6 D route de Trèves<br>L-2633 Senningerberg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jeronimo Folgueira, Jochen Siegert<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 25331016<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 261 911 3515<br>Fax: +352 49 48 48 6606<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
                        </div>
                        <?php require GLOBALS . 'credits.php'; ?>
                        <script type="text/javascript" id="sourcecode">

                            jQuery(function()
                            {
                                jQuery('#teamCredits_text').jScrollPane({autoReinitialise: true, showArrows: true});
                            });

                        </script>

                        <div id="imprint_ingame" class="fliesstext"
                             style="position:absolute; left:40px; top:24px; height:15px;">
                            <a href="javascript:void(0);" onclick="showFooterLayer('imprint');">
                               
                            <a href="javascript:void(0);" onclick="showFooterLayer('teamCreditsBox')">Credits</a> |
                            <a href="/GameAPI.php?action=portal.redirectToBoard" target="_blank">Forum</a>
                        </div>





                      </div><!-- End footerContainer -->
                </div><!-- End bodyContainer -->
            </div><!-- End outerContainer -->
        </div><!-- End overallContainer -->
    </div>




    <!-- affiliateEndTag -->
    <!-- SEMGOOGLE RTPixel START --><!-- Google Code for DO All Visitors Remarketing List -->
    <script type="text/javascript">
                                /* <![CDATA[ */
                                var google_conversion_id = 987297406;
                                var google_conversion_language = "en";
                                var google_conversion_format = "3";
                                var google_conversion_color = "666666";
                                var google_conversion_label = "jcNlCILztAIQ_uzj1gM";
                                var google_conversion_value = 0;
                                /* ]]> */
    </script>
    <script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/987297406/?label=jcNlCILztAIQ_uzj1gM&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>
    <!-- SEMGOOGLE RTPixel END --><!-- SensorT-Bigpoint - Page View - START -->
    <script type="text/javascript" language="JavaScript" src="https://akimu.bigpoint.com/trk?rt=1&ti=3547&cs=8377&aid=332&aip=&pid=579&ppid=22&language=en&country=IT&ctype=0&ts=1370447960&mid=151430678&jsopenclose=false"></script>
    <!-- SensorT-Bigpoint - Page View - END -->

    <!-- SensorT-Bigpoint - SEA-SEO Pageview - START -->
    <script type="text/javascript">
                                (function() {
                                    var s = null, sp = null, se = null, st = null, r = document.referrer, res = null;
                                    if (!r)
                                        return;
                                    if (r.indexOf("google") >= 0) {
                                        se = "google";
                                        sp = "q";
                                    } else if (r.indexOf("bing") >= 0) {
                                        se = "bing";
                                        sp = "q";
                                    } else if (r.indexOf("yahoo") >= 0) {
                                        se = "yahoo";
                                        sp = "p";
                                    } else {
                                        return;
                                    }
                                    var idx = r.indexOf("?") + 1;
                                    if (idx > 0) {
                                        var p = r.substr(idx).split("&");
                                        for (var i = 0; i < p.length; i++) {
                                            var kv = p[i].split("=");
                                            if (kv[0] == sp) {
                                                s = kv[1];
                                            } else if (se == "google" && kv[0] == "url") {
                                                st = "seo";
                                            } else if (se == "google" && kv[0] == "adurl") {
                                                st = "sea";
                                            }
                                            if (s && st) {
                                                break;
                                            }
                                        }
                                    }
                                    if (s) {
                                        res = '<scr' + 'ipt type="text/javascript" src="http://akimu.bigpoint.com/trk?rt=1&ti=3549&cs=5764&aid=332&aip=&pid=579&ppid=22&language=en&country=IT&ctype=0&ts=1370447960&searchQuery=' + s;
                                    }
                                    if (res && st) {
                                        res = res + "&searchType=" + st;
                                    }
                                    if (res) {
                                        res = res + "&ts=" + new Date().getTime() + '"></scr' + "ipt>";
                                        document.write(res);

                                    }
                                })();
    </script>
    <!-- SensorT-Bigpoint - SEA-SEO Pageview - END --><!-- BPID --><script language="javascript">window.bpid = window.bpid || {};
        window.bpid.callbacks = window.bpid.callbacks || [];
        window.bpid.callbacks.push(function(bpid) {
            document.cookie = "__bpid=" + bpid + ";path=/;expires=Fri, 03 Jun 2022 13:59:24 GMT;";
            if (bpid != "51ae9f75go6sN0mU3nm1JcFiSI1EqIhB") {
                try {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "\/GameAPI.php?action=core.bpid&bpid=" + bpid, true);
                    xhr.send(null);
                } catch (e) {
                }
            }
        });</script><script language="javascript" src="//assets.bpsecure.com/bpid/bpid.js?ts=380679" defer="defer"></script><!-- /BPID --><script type="text/javascript">var _gaq = _gaq || [];
        _gaq.push(['_gat._anonymizeIp']);
        _gaq.push(['_setDomainName', 'none']);
        _gaq.push(['_setAllowLinker', true]);
        _gaq.push(['_setAllowHash', false]);
        _gaq.push(['_setCustomVar', 1, 'aid', '332', 2]);
        _gaq.push(['_setCustomVar', 2, 'aip', '', 2]);
        _gaq.push(['_setCustomVar', 3, 'ait', 'keyword', 2]);
        _gaq.push(['_setCustomVar', 4, 'areaID', '', 2]);
        _gaq.push(['_setAccount', 'UA-1848713-1']);
        _gaq.push(['_trackPageview', '/indexInternal.es?action=internalNewClan&areaID=']);
        _gaq.push(['_trackPageLoadTime']);
        _gaq.push(['_setAccount', 'UA-17685913-1']);
        _gaq.push(['_trackPageview', '/indexInternal.es?action=internalNewClan&areaID=']);
        _gaq.push(['_trackPageLoadTime']);
        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = 'http://www.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();</script>

    <!-- SZM VERSION="1.5" -->
    <script type="text/javascript">
        <!--
    var IVW = "http://bigpoint.ivwbox.de/cgi-bin/ivw/CP/5201gamecont;/spiele/darkorbit";
        document.write("<img src=\"" + IVW + "?r=" + escape(document.referrer) + "&d=" + (Math.random() * 100000) + "\"width=\"1\" height=\"1\" alt=\"\" />");
        //-->
    </script>
    <noscript>
    <img src="http://bigpoint.ivwbox.de/cgi-bin/ivw/CP/5201gamecont;/spiele/darkorbit";
         width="1" height="1" alt="" />
    </noscript>
    <!-- /SZM -->




    <script type="text/javascript">

        if (jQuery('#toolbar').length > 0) {
            jQuery('#toolbar').css('float', 'none');
            jQuery('body').css('background-position', 'center 30px');
        }

    </script>
    <link rel="stylesheet" type="text/css" href="./resources/css/popup.css?__cv=4e58da2dec4df33ee5f4c239848dda00" />
    <div id="popup">
        <div class="header">
            <div class="button-close"></div>
        </div>
        <div class="body">
            <div class="icon icon-question"></div>
            <div class="icon icon-error"></div>
            <div class="icon icon-success"></div>
            <div class="content fliess13px-grey"></div>
        </div>
        <div class="footer single-button">
            <div class="button button-green">
                <div class="text" style="background-image: url(./do_img/global/text_tf.esg?s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
            </div>
            <div class="button button-blue">
                <div class="text" style="background-image: url(./do_img/global/text_tf.esg?s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
            </div>
        </div>
    </div>
    <div id="popup-modalBackground"></div>
    <img id="popup-loading" alt="Loading..." src="./do_img/global/pilotSheet/profilePage/loadingAnimation.gif" />

    <!-- LayertoolService JavaScript Injection start -->
    <script type="text/javascript">
        //<![CDATA[
        // add fancybox css to the head
        var cssLink = document.createElement('link');
        cssLink.type = 'text/css';
        cssLink.rel = 'stylesheet';
        cssLink.href = 'http://lts-920.ah.bpcdn.net/application/fancybox/jquery.fancybox-1.3.4.css';
        document.getElementsByTagName('head')[0].appendChild(cssLink);
        //]]>
    </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script type="text/javascript" src="http://lts-920.ah.bpcdn.net/application/fancybox/jquery.fancybox-1.3.4.js"></script>
    <script type="text/javascript" src="http://lts-920.ah.bpcdn.net/application/client/client.js"></script>
    <script type="text/javascript" src="http://lts-920.ah.bpcdn.net/application/cookie/jquery.cookie.js"></script>
    <script type="text/javascript">var jQueryLts = jQuery.noConflict(true);</script>
    <script type="text/javascript">
        //<![CDATA[
        jQueryLts('document').ready(function() {
            try {
                var serviceLinks = ['http://lts-920.ah.bpcdn.net/579/us/IT/-14400/332', 'http://lts-920.ah.bpcdn.net/email/579/us'];
                var paymentURL = 'https://ssl.bigpoint.net/billing/?req=YToxMjp7czo2OiJ1c2VySUQiO3M6ODoiOTgwMjYyMDkiO3M6ODoidXNlcm5hbWUiO3M6ODoiemlvcGlvNzAiO3M6ODoibWVtYmVySUQiO3M6OToiMTUxNDMwNjc4IjtzOjQ6ImJwaWQiO3M6MzI6IjUxYWU5Zjc1Z282c04wbVUzbm0xSmNGaVNJMUVxSWhCIjtzOjc6InVzZXJBZ2UiO2k6NDM7czoxNDoiZmJfYXBwbGljYXRpb24iO2I6MDtzOjk6InByb2plY3RJRCI7czozOiI1NzkiO3M6MzoiYWlkIjtpOjMzMjtzOjM6ImFpcCI7czowOiIiO3M6NDoibGFuZyI7czoyOiJlbiI7czozOiJkZXYiO2I6MDtzOjQ6InRpbWUiO2k6MTM3MDQ0Nzk1ODt9&aid=332&aip=&hash=caad871dca7b7feae621352896b08267';
                BPLayertool2.Helper.setPaymentLink(paymentURL);
                BPLayertool2.Helper.setUserId(98026209);
                BPLayertool2.Helper.setRequestTime(1370447958);
                BPLayertool2.Helper.setServices(serviceLinks);
                BPLayertool2.JSONPRequest.setRequestURL(serviceLinks[0]);
                BPLayertool2.JSONPRequest.doRequest(BPLayertool2.LayerView.prepareView);
            } catch (Exception) {
                if (true === Boolean(console.log)) {
                    console.log(Exception);
                } else {
                    throw Exception;
                }
                ;
            }
        });
        //]]>
    </script>
    <!-- LayertoolService JavaScript Injection end -->


</body>
</html>