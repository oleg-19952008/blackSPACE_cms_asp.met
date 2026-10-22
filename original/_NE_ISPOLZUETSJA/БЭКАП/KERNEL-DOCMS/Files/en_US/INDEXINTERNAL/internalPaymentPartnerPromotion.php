<?php

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

				<!-- use  Dark Orbit javascript tools -->

<script type="text/javascript">

    var remainCapsules          =   0;
    var ticketsLotteryPartner   =   0;
    var ticketsLotteryItems     =   0;
    var countryForbidden        =   0;

    var aKeys = {
        "popupNoCapsules"           : "You don\'t have any capsules to exchange. Click on <a class=\'open_external\' onclick=\'javascript:openExternal(\"/?action=internalPaymentProxy&req=a4051c610ae5e1b7a8abcdcbffa0e3a97d244a807025dfac0ae20de9e962929b25d90d591ce9b82bf1f21ff23dd45062ac6ce1043a824e7225584fd1f7f617feb2729b3b6b8adaafd5d967115afcc2637a35ae0a21437ec9f6204692d11cafa21c7ab29ad3bb9c6112b53b10b60c56eff2b0991d073e1765df24113076d82e7b8a5e2deb7df8d4492078307a438b701f34e9a371497f911939c316b88c2884ea9d93de608294d1b387e34c26ff90caa9ff36e6ae5114f75030d8bbeaf5a0b1fd&v=7159c3a683aadf780d1261e251f7f268\",\"no\")\' type=\'button\' target=\'_blank\' style=\'cursor:pointer\'>Buy More Capsules</a> in Payment to restock your supplies!",
        "popupCountryNoAllowed"     : "Lotteries that give away material prizes are not allowed in your country.",
        "popupSunConverterText"     : "You\'ve successfully redeemed your capsule(s) in the sun converter.",
        "popupMoonConverterText"    : "You\'ve successfully redeemed your capsule(s) in the moon converter."
    }

    var callBackLotteryDialogBox        =   '';


</script>

<script type="text/javascript" src="http://do-test.a.bpcdn.net/resources/js/internalPartnerPromotion.js?__cv=6a37959c8281534ac2daf1f7b9ded400"></script>

<script type="text/javascript">

        jQuery(document).ready(function () {
            Tools.ErrorHandler.Initialize();
            Tools.Popup.Initialize();
            internalPartnerPromotion.Initialize(remainCapsules,
                    ticketsLotteryPartner, ticketsLotteryItems,
                    countryForbidden, aKeys, callBackLotteryDialogBox);
        });

    

</script>
                    <!-- start clanlist template -->

                    <link rel="stylesheet" href="/css/cdn/navigation.css?__cv=027602d6f1863686ece0574190059400" />

                    <script type="text/javascript" src="/js/page/clan/internalNewClanIndexDomReady.js?__cv=2dc5d4f0df5f490bb84b9ada5fab8a00"></script>

                    <div class="frameTop"><!--  --></div>
                    <div class="frameLeft_top"><!--  --></div>
                    <div class="frameRight_top"><!--  --></div>
                    <div class="contentFrame">
                        <div id="partnerPromotionFrame">
        <div id="navigationFrame">

<link rel="stylesheet" href="./css/cdn/navigation.css" />
<link rel="stylesheet" href="./css/cdn/internalPaymentPromotion.css" />
<!-- start internal uridum -->


<div id="navigation">
    <!-- Banking -->
     <!-- Banking -->
    <div class="button">
        <a href="indexInternal.es?action=internalPayment" title="Banking">
           <img src="./text?t=BANKING&w=16&s=9.2&color=white&font=1&b=grey"/>
        </a>
    </div>

    <!-- Balance -->
    <div class="button ">
        <a href="indexInternal.es?action=internalBalance" title="Balance">
            <img src="./text?t=BALANCE&w=16&s=9.2&color=white&font=1&b=grey"/>
        </a>
    </div>


    <!-- Subscriptions -->
    <div class="button">
        <a href="#" title="Manage subscriptions">
            <img src="./text?t=SUBSCRIPTIONS&w=16&s=9.2&color=white&font=1&b=grey"/>
        </a>
    </div>

    <!-- Vouchers -->
    <div class="button ">
        <a href="indexInternal.es?action=internalEvoucher" title="VOUCHERS">
            <img src="./text?t=VOUCHERS&w=16&s=9.2&color=white&font=1&b=grey"/>
        </a>
    </div>


    <!-- internalPaymentPartnerPromotion -->
      <!-- internal event switch only enable if the event is enable -->
    <div class="button active">
        <a href="indexInternal.es?action=internalPaymentPartnerPromotion" title="LOTTERY">
            <img src="text?t=LOTTERT&w=16&s=9.2&color=black&b=lightestBlue"/>
        </a>
    </div>
    
    <!-- internalPaymentPartnerVoucher -->
    

</div>

<!-- end internal uridium -->

            <div id="wrapper">

                <!-- layer prizes template -->
                <div id="prizeTemplateLayer">
                    <h4>Lottery Prizes</h4>
                    <span id="closePrizeLayer" class="closeTag"></span>
                    <div style="clear:both"></div>
                    <div id="contentPrize" class="scroll-pane" style="overflow: hidden; padding: 0px; width: 567px;"><div class="jspContainer" style="width: 567px; height: 424px;"><div class="jspPane" style="padding: 0px 10px 0px 0px; top: 0px; width: 557px;">
                        <div class="content"><b>Win incredible prizes with the Sun Converter!</b><br><br>
When you redeem your capsules for lottery tickets in the Sun Converter, you have a chance of winning valuable coupons for some of the internet's largest online stores:<br><br>
<ul>
<li>1x coupon worth €1,500</li>
<li>3x coupons worth €350 each</li>
<li>11x coupons worth €150 each</li>
</ul>
<br><br>
<b>Please note:</b> the above lottery's winners will be drawn from the entirety of DarkOrbit, and not per server. (Illustrations may differ slightly from prizes).<br><br><br>
<b>Win fantastic prizes with the Moon Converter!</b><br><br>
When you redeem your capsules for lottery tickets in the Moon Converter, you have a chance of winning incredible in-game prizes! Each of the following can be won on each separate server:<br><br>
<ul>
		<li>1 x 1 million Uridium</li>
		<li>1 x 30 Fully-upgraded LF4 Lasers</li>
		<li>2 x 10 Fully-upgraded LF4 Lasers</li>
		<li>5 x 5 Fully-upgraded LF4 Lasers</li>
		<li>1 x 30 Fully-upgraded SG3N-B02 Shield Generators</li>
		<li>2 x 10 Fully-upgraded SG3N-B02 Shield Generators</li>
		<li>5 x 5 Fully-upgraded SG3N-B02 Shield Generators</li>
		<li>5 x 50,000 Rounds of UCB-100 Laser Ammo</li>
		<li>20 x 100,000 Uridium</li>
	</ul></div>
                        <p class="disclaimer">Conditions of participation:
Persons employed by Bigpoint, as well as any partners or their relatives, are not eligible to participate. In case of violation of these Terms of Participation, Bigpoint reserves the right to disqualify/ban offenders from the contest. Persons who use illegal methods or manipulate the game in any way or form in order to gain an advantage shall also be disqualified. In this case, cash prizes shall be declared invalid and recalled.
We'd also like to inform you that users from Italy and Brazil are not permitted to participate in drawings for material prizes.<br> Players in Russia need an import license in order to claim material lottery prizes.</p>
                    </div></div></div>
                </div>
                <!-- end layer template -->

                <!-- info module -->
                <div id="infoModule">
                    <h5>CAPSULE LOTTERY</h5>
                    <a id="btnPrizeLayer" href="#" class="btnLayer"></a>
                    <div style="width: 603px;padding: 6px 0 3px 5px;">
                        <div class="information scroll-pane" style="overflow: hidden; padding: 0px;"><div class="jspContainer" style="width: 603px; height: 71px;"><div class="jspPane" style="padding: 5px 0px 0px; top: 0px; width: 603px;">
                        There are three different ways you can get capsules: Destroy the HITAC 2.0 mother ship or its Minions and collect letters to spell the word puzzle.  You can also buy brand new capsules in PAYMENT. On the Uridium page you can put your capsules into the sun or moon converter. All you have to do is click the button under the converter. Increase the number of capsules in the menu if you'd like to transform more than one.
                        </div></div></div>
                    </div>
                </div>

                <!-- payment module -->
                <div id="paymentModule">
                    <p id="capsulesInStockText"> Remaining capsules<span id="capsulesInStockAmount">0</span></p>
                                            <a id="btnPayment" class="button open_external" type="button" href="/?action=internalPaymentProxy&amp;req=79b017609ea633638f3d87b5094ca3784070ba09ed40f2dbb98a9c5ab561e9ae8cd063cc836fee54e5a81f0076af4a106ffa5937c1c6786765ad1026aec379d4834de8d84a1cede0cbbf4069bd31d486413142a1df34762c8963cc893799984d48aad0df2adf2a46f792bae9fd80208fa944b0229a30051d1d1c1ce42713097eb63c25bc806f08048c0b1141d33b104bf94c4e694facc100ad9b30190b6dbde7e9f348a0f852127ceb30d2aff7811dbd43d60149fcf5243f316365ae73fc6bb1&amp;v=003340eab6f169b8be7dc30f8ff1e9ce" target="_blank">Buy more capsules</a>
                                    </div>

                <!-- converters module -->
                <div id="convertersModule">

                    <!-- moon converter -->
                    <div id="moonConverter" title="Use the Moon Converter to transform capsules into lottery tickets for the chance to win excellent in-game prizes, like 1 million Uridium or a fully-upgraded LF4 Laser.">
                       <p id="titleMoonConverter">
                           <img src="do_img/global/payment/partnerPromotion/mc.gif">
                        </p>
                       <span id="amountMoonConverter">
                            0
                       </span>
                        <form id="form_Lottery_Items" method="post" action="indexInternal.es?action=internalPaymentPartnerPromotion&amp;subAction=Lottery_Items"><input type="hidden" name="reloadToken" value="6d8a8f2ebd9ceecc2d43455399f8241d">
                            <input type="hidden" name="quantity" id="capsule_quantity_items" value="1">
                            <a id="moonSelector">1</a>
                            <a id="moonSelectorConverter" class="grayed">Transform</a>

                            <!-- absolute positioning element ul -->
                            <ul id="amountMoonSelectorList">
                                                                <li class="last"><a rel="last" class="setAmountMoonConverter">MAXIMUM</a></li>
                            </ul>
                        </form>
                    </div>

                    <!-- sun converter -->
                    <div id="sunConverter" title="Take your capsules to the Sun Converter to trade them in for lottery tickets!">
                       <p id="titleSunConverter">
                           <img src="do_img/global/payment/partnerPromotion/sc.gif">
                        </p>
                       <span id="amountSunConverter">
                       0
                       </span>
                        <form id="form_Lottery_Partner" method="post" action="indexInternal.es?action=internalPaymentPartnerPromotion&amp;subAction=Lottery_Partner"><input type="hidden" name="reloadToken" value="6d8a8f2ebd9ceecc2d43455399f8241d">
                            <input type="hidden" name="quantity" id="capsule_quantity_partner" value="1">
                            <a id="sunSelector">1</a>
                            <a id="sunSelectorConverter" class="grayed">Transform</a>
                            <!-- absolute positioning element ul -->
                            <ul id="amountSunSelectorList">
                                                                <li class="last"><a rel="last" class="setAmountSunConverter">MAXIMUM</a></li>
                            </ul>
                        </form>

                    </div>
                </div>
                <div id="loggingModule">
                    <div id="loggingHeader">
                        <h2>Immediate rewards log</h2>

                    </div>
                    <div id="loggingContent" class="scroll-pane" style="overflow: hidden; padding: 0px; width: 230px;"><div class="jspContainer" style="width: 230px; height: 188px;"><div class="jspPane" style="padding: 0px; top: 0px; width: 230px;">
                        <ul class="mainList">
                                                 </ul>
                    </div></div></div>
                </div>
            </div>

            <div style="clear:both;"><!--  --></div>

        </div>

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
        cssLink.href = './application/fancybox/jquery.fancybox-1.3.4.css';
        document.getElementsByTagName('head')[0].appendChild(cssLink);
        //]]>
    </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <script type="text/javascript" src="./application/fancybox/jquery.fancybox-1.3.4.js"></script>
    <script type="text/javascript" src="./application/client/client.js"></script>
    <script type="text/javascript" src="./application/cookie/jquery.cookie.js"></script>
    <script type="text/javascript">var jQueryLts = jQuery.noConflict(true);</script>
 
    <!-- LayertoolService JavaScript Injection end -->


</body>
</html>