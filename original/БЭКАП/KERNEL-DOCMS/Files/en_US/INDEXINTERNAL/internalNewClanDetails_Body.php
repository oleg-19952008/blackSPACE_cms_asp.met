<?php
$clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
if(isset($_GET['subaction']) && $_GET['subaction']=="joinClan"){
    $clan->join($_POST);
}
if(isset($_GET['clanId']) && !empty($_GET['clanId'])){
    $cla = $clan->getClan($_GET['clanId']);
    $p = $clan->getPending($_GET['clanId']);
    if($cla[0]['recruiting']==1):
        if($p==true):
            $re="Pending";
            else:
            $re = "recruiting";
        endif;
        $ro = "Recruiting";
    elseif($cla[0]['recruiting']==0):
         $re = "notRecruiting";
         $ro = "Closed";
    elseif($cla[0]['recruiting']==2):
         if($p==true):
            $re="Pending";
            else:
            $re = "recruiting";
        endif;
         $ro = "Fully elite";
    else:
      if($p==true):
            $re="Pending";
            else:
            $re = "recruiting";
        endif;
      $ro = "";
    endif;
}else
?>
</head>
<body onLoad="" >
    <script type="text/javascript" src="/js/jQuery/jquery.jscrollpane.min.js"></script>
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
            <img src="http://127.0.0.1/do_img/global/popups/general/success_icon.png?__cv=7ea7548d2cb4149555faab27c783e500" id="general_popup_success" class="success" />
            <img src="http://127.0.0.1/do_img/global/popups/general/error_icon.png?__cv=abbabc79fb0ffe608c13a681aa9db900" id="general_popup_error" class="error" />
            <p id="general_popup_question_text">this text will be replace on xajax call</p>
        </div>
        <div class="popup_contentcontainer">
            <div class="popup_footcontainer">
                <div id="general_popup_close_button" class="popup_close_button">
                    <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey" />
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
    <script type="text/javascript" src="http://127.0.0.1/js/infoLayer.js?__cv=f873586616939bcb06c5d95a7ef73200"></script>

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
                             'http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey'
                             );">
                        </div>
                    </div>
                    <div class="popup_shop_abort_button">
                        <div class="popup_shop_abort_text"
                             style="background-image: url(
                             'http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey'
                             );"
                             onclick="closeInfoLayer();">
                        </div>
                    </div>
                </div>

                <div id="infoLayerInfo">
                    <div class="popup_shop_close_button">
                        <div class="popup_shop_close_text"
                             style='background-image: url("http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey");'
                             onclick="closeInfoLayer();"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    </script>
    <?php require GLOBALS . 'internalHelpLayer.php';
    require GLOBALS . 'internalNews.php'; ?>
    <div class="backgroundImageContainer">
        <div class="overallContainer">

            <div class="outerContainer fliess11px-gelb">

<?php require GLOBALS . 'internalHeaderIntern.php'; ?>


                <div class="bodyContainer">
                    <?php
                    if (isset($_GET['clanId']) && !empty($_GET['clanId'])) {
                        ?>
                        <link rel="stylesheet" href="http://do-test.a.bpcdn.net/css/cdn/navigation.css">
                        <link rel="stylesheet" href="http://do-test.a.bpcdn.net/css/cdn/internalNewClan.css">
                        <script type="text/javascript" src="http://<?php echo DynHost; ?>/js/page/clan/internalNewClanDetailsIndexDomReady.js"></script>
                        <script type="text/javascript" src="http://<?php echo DynHost; ?>/resources/js/user.js"></script>
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
                                            <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_clan_join&f=eurostyle_tregcon&color=black&bgcolor=grey1"/>
                                        </a>
                                    </div>

                                    <div class="button ">
                                        <a href="indexInternal.es?action=internalNewClanDetails&subaction=foundClan" title="Found">
                                            <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_clan_found&f=eurostyle_tregcon&color=white&bgcolor=grey"/>
                                        </a>
                                    </div>


                                    <!-- Company Change -->
                                    <div class="button ">
                                        <a href="indexInternal.es?action=internalClan&tpl=internalClanChangeFirm" title="Company">
                                            <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_misc_company&f=eurostyle_tregcon&color=white&bgcolor=grey"/>
                                        </a>
                                    </div>
                                </div>

                                    <!-- end internal clan2 -->
                                    <div id="wrapper" class="clanDetails" style="height:404px;">

                                        <div class="header">
                                            <div class="headline">Clan page</div>
                                            <div class="back">
                                                <a href="indexInternal.es?action=internalNewClan" title="back to clan list"><!-- --></a>
                                            </div>
                                            <div style="clear:both;"><!-- --></div>
                                        </div>

                                        <div class="teaser">
                                            <div class="clanlogo">
                                                <div class="decor">
                                                    <div class="image">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="claninformation">
                                                <div class="js-scroll-pane jspScrollable" style="height: 100px; overflow: hidden; padding: 0px; width: 526px;" tabindex="0">
                                                    <div class="jspContainer" style="width: 526px; height: 100px;">    
                                                        <div class="jspPane" style="padding: 0px; width: 506px; top: 0px;">
                                                            <ul class="clan_items">
                                                                <li class="clan_item even">
                                                                    <span class="label">Name</span>
                                                                    <span class="info"><?php echo $cla[0]['clanName']; ?></span>
                                                                </li>
                                                                <li class="clan_item">
                                                                    <span class="label">Tag</span>
                                                                    <span class="info"><?php echo $cla[0]['tagName']; ?></span>
                                                                </li>
                                                                <li class="clan_item even">
                                                                    <span class="label">Clan-Leader</span>
                                                                    <span class="info"><?php echo $clan->GetClanLeader($cla[0]['leader']); ?></span>
                                                                </li>
                                                                <li class="clan_item">
                                                                    <span class="label">Number of members</span>
                                                                    <span class="info"><?php echo $cla[0]['memberCount']; ?></span>
                                                                </li>
                                                                <li class="clan_item even">
                                                                    <span class="label">Clan rank</span>
                                                                    <span class="info"><?php echo $cla[0]['rank']; ?></span>
                                                                </li>
                                                                <li class="clan_item ">
                                                                    <span class="label">Company</span>
                                                                    <span class="info"><?php echo strtoupper($cla[0]['company']); ?></span>
                                                                </li>
                                                                <li class="clan_item even">
                                                                    <span class="label">Status</span>
                                                                    <span class="info"><?php echo $ro; ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="jspVerticalBar"><div class="jspCap jspCapTop"></div><a class="jspArrow jspArrowUp jspDisabled"></a><div class="jspTrack" style="height: 68px;"><div class="jspDrag" style="height: 34px;"><div class="jspDragTop"></div><div class="jspDragBottom"></div></div></div><a class="jspArrow jspArrowDown"></a><div class="jspCap jspCapBottom"></div></div>
                                                    </div></div>
                                            </div>
                                            <div style="clear:both;"><!-- --></div>
                                        </div>

                                        <div class="body">
                                            <div class="clandescription js-scroll-pane" style="overflow: hidden; padding: 0px; width: 373px;"><div class="jspContainer" style="width: 373px; height: 230px;"><div class="jspPane" style="padding: 10px; top: 0px; width: 353px;">
                                                        <?php echo $cla[0]['clandescription']?>
                                                    </div></div></div>

                                            <div class="clanjoin">
                                                <input type="hidden" id="clanApplicationOk" value="Your application to this Clan is pending.">
                                                <form id="clanApplicationForm" action="indexInternal.es?action=internalNewClanDetails&subaction=joinClan" method="post" target="_blank" style="display: inline;"><input type="hidden" name="reloadToken" value="555b2cb177ec80ad93fa28f8c59471ce">
                                                    <input type="hidden" name="clanId" value="<?php echo $cla[0]['clanID']; ?>">

                                                    <input type="hidden" name="language" value="en">
                                                     <?php
                                                    if($re=="notRecruiting"):
                                                        echo '<textarea id="applicationText" name="applicationText" title="Closed for recruiting. "></textarea>';
                                                    elseif($re=="Pending"):
                                                        echo '<textarea id="applicationText" name="applicationText" title="Your application to this Clan is pending."></textarea>';
                                                    else:
                                                        echo '<textarea id="applicationText" name="applicationText" title="Enter in your application text."></textarea>';
                                                    endif;
                                                        ?>
                                                    <div class="costs">
                                                        <div class="left"></div>
                                                        <div class="center">0 C.</div>
                                                        <div class="right"></div>
                                                        <div style="clear:both;"><!-- --></div>
                                                    </div>
                                                    <?php
                                                    if($re=="notRecruiting" || $re=="Pending"):
                                                        ?>
                                                    <button name="submit" type="submit" class="clanInactive" disabled="disabled">
                                                         <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=en&amp;s=12&amp;t=clan_button_send&amp;f=eurostyle_thea&amp;color=white&amp;bgcolor=grey" alt="send">
                                                    </button>
                                                    <?php
                                                        else:
                                                    ?>
                                                    <button name="submit" type="submit" class="clanSubmit">
                                                        <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=en&amp;s=12&amp;t=clan_button_send&amp;f=eurostyle_thea&amp;color=white&amp;bgcolor=grey" alt="send">
                                                    </button>
                                                    <?php
                                                    endif;
                                                    ?>
                                                    

                                                    <span class="message_success">Your application was sent to the clan leader.</span>
                                                    <span class="message_error">An error occurred. Please try again later.</span>
                                                </form>
                                            </div>
                                            <div style="clear:both;"><!-- --></div>
                                        </div>

                                    </div><!-- end div#wrapper -->

                                    <div style="clear:both;"><!--  --></div>

                                </div><!-- end div#navigationWrapper -->

                            </div>
                        </div>
                        <?php
                    } else {
                        
                        ?>
                    
                    <!-- start clan found template -->

                    <link rel="stylesheet" href="http://127.0.0.1/css/cdn/navigation.css?__cv=027602d6f1863686ece0574190059400" />
                    <link rel="stylesheet" href="http://127.0.0.1/css/cdn/internalNewClan.css?__cv=b067289aca88e7bdf4c5386619af2000" />

                    <script type="text/javascript" src="http://127.0.0.1/js/page/clan/internalNewClanIndexDomReady.js?__cv=2dc5d4f0df5f490bb84b9ada5fab8a00"></script>
                    <script type="text/javascript" src="http://127.0.0.1/resources/js/user.js?__cv=b79aef5e50246af886bf99f0a7678400"></script>

                    <div class="frameTop"><!--  --></div>
                    <div class="frameLeft_top"><!--  --></div>
                    <div class="frameRight_top"><!--  --></div>
                        <div class="contentFrame">
                            <div class="borderFrame">
                                <div id="navigationFrame">

                                    <!-- start internal clan2 -->

                                    <div id="navigation">
                                        <!-- Join -->
                                        <div class="button ">
                                            <a href="indexInternal.es?action=internalNewClan" title="Join">
                                                <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_clan_join&f=eurostyle_tregcon&color=white&bgcolor=grey"/>
                                            </a>
                                        </div>

                                        <div class="button active">
                                            <a href="indexInternal.es?action=internalNewClanDetails&subaction=foundClan" title="Found">
                                                <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_clan_found&f=eurostyle_tregcon&color=black&bgcolor=grey1"/>
                                            </a>
                                        </div>


                                        <!-- Company Change -->
                                        <div class="button ">
                                            <a href="indexInternal.es?action=internalClan&tpl=internalClanChangeFirm" title="Company">
                                                <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_misc_company&f=eurostyle_tregcon&color=white&bgcolor=grey"/>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- end internal clan2 -->
                                    <div id="wrapper" class="clanFound"  style="height:404px;">

                                        <div class="headline">Found clan</div>

                                        <div class="description">

                                            Founding a clan will cost you a total of 300.000 Credits. After founding your clan, you can upload a logo, raise taxes, manage members and much more under Clan Info in the management section.
                                            <br/><br/>

                                            <span class="grey">To found a clan, please enter in the following information.</span><br/>
                                            <br/>
                                            <span class="bluegrey">
                                                Name: (min. 1 character, max: 50 characters)<br/>
                                                Tag: (min. 1 character, max: 4 characters)<br/>
                                                Description: (max: ~16,000 characters)<br/>
                                            </span>

                                            <br/>

                                            <span class="grey">Confirm your entries with the "Found" button.</span>
                                        </div>
                                        <div class="formular">

                                            <form id="clanFoundForm" action="indexInternal.es?action=internalNewClanDetails&subaction=foundClan" method="POST" onsubmit="cleanClanFoundForm()"><input type="hidden" name="reloadToken" value="d3fcf6d9ebcf9803fd732ab0405b940e">

                                                <input type="hidden" name="language" value="us"/>

                                                <input type="text" name="clanName" value="" maxlength="50" title="Name"/><br/>
                                                <input type="text" name="clanTag" value="" maxlength="4" title="Tag"/><br/>

                                                <textarea name="clanDescription" title="Enter in a clan description."></textarea>

                                                <div class="costs">
                                                    <div class="left"></div>
                                                    <div class="center">300.000 C.</div>
                                                    <div class="right"></div>
                                                    <div style="clear:both;"><!-- --></div>
                                                </div>

                                                <button name="submit" type="submit" class="clanSubmit">
                                                    <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=12&t=clan_button_send&f=eurostyle_thea&color=white&bgcolor=grey" alt="send"/>
                                                </button>

                                            </form>

                                        </div>

                                        <div style="clear:both;"><!--  --></div>
                                    </div><!-- end div#wrapper -->

                                    <div style="clear:both;"><!--  --></div>

                                </div><!-- end div#navigationWrapper -->

                            </div>
                        </div>

<?php } ?>
                    <!-- end clan found template -->


                    <div class="footerContainer">
                        <div class="frameLeft_bottom"></div>
                        <div class="frameRight_bottom"></div>
                        <div class="frameBottom"></div>

                        <div id="alertBox" class="fliesstext"></div>
                        <div id="imprint" style="width:523px;height:600px;" class="fliesstext">
                            <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="http://127.0.0.1/do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt="" /></a></div>
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





                        <div id="banner-bottom" align="center">
                            <!-- affiliateBanner: banner enabled --><script type="text/javascript" src="http://adin-www.bigpoint.net/adxx.php?pid=4&source=country%3DIT%26areaID%3D%26aid%3D332%26acm%3D%26acr%3D579%26aip%3D%26gameID%3D579%26uid%3D98026209%26locale%3Dus&sign=VjGmYK9RKa5CTbUOXs6IxSAlprypD6gf8VJPYh68"></script>    </div>
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
    <script type="text/javascript" language="JavaScript" src="https://akimu.bigpoint.com/trk?rt=1&ti=3547&cs=8377&aid=332&aip=&pid=579&ppid=22&language=en&country=IT&ctype=0&ts=1370448038&mid=151430678&jsopenclose=false"></script>
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
                                        res = '<scr' + 'ipt type="text/javascript" src="http://akimu.bigpoint.com/trk?rt=1&ti=3549&cs=5764&aid=332&aip=&pid=579&ppid=22&language=en&country=IT&ctype=0&ts=1370448038&searchQuery=' + s;
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
        });</script><script language="javascript" src="//assets.bpsecure.com/bpid/bpid.js?ts=380680" defer="defer"></script><!-- /BPID --><script type="text/javascript">var _gaq = _gaq || [];
        _gaq.push(['_gat._anonymizeIp']);
        _gaq.push(['_setDomainName', 'none']);
        _gaq.push(['_setAllowLinker', true]);
        _gaq.push(['_setAllowHash', false]);
        _gaq.push(['_setCustomVar', 1, 'aid', '332', 2]);
        _gaq.push(['_setCustomVar', 2, 'aip', '', 2]);
        _gaq.push(['_setCustomVar', 3, 'ait', 'keyword', 2]);
        _gaq.push(['_setCustomVar', 4, 'areaID', '', 2]);
        _gaq.push(['_setAccount', 'UA-1848713-1']);
        _gaq.push(['_trackPageview', '/indexInternal.es?action=internalNewClanDetails&subaction=foundClan&areaID=']);
        _gaq.push(['_trackPageLoadTime']);
        _gaq.push(['_setAccount', 'UA-17685913-1']);
        _gaq.push(['_trackPageview', '/indexInternal.es?action=internalNewClanDetails&subaction=foundClan&areaID=']);
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
    <link rel="stylesheet" type="text/css" href="http://127.0.0.1/resources/css/popup.css?__cv=4e58da2dec4df33ee5f4c239848dda00" />
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
                <div class="text" style="background-image: url(/do_img/global/text_tf.esg?s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
            </div>
            <div class="button button-blue">
                <div class="text" style="background-image: url(/do_img/global/text_tf.esg?s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
            </div>
        </div>
    </div>
    <div id="popup-modalBackground"></div>
    <img id="popup-loading" alt="Loading..." src="http://127.0.0.1/do_img/global/pilotSheet/profilePage/loadingAnimation.gif" />

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
                var paymentURL = 'https://ssl.bigpoint.net/billing/?req=YToxMjp7czo2OiJ1c2VySUQiO3M6ODoiOTgwMjYyMDkiO3M6ODoidXNlcm5hbWUiO3M6ODoiemlvcGlvNzAiO3M6ODoibWVtYmVySUQiO3M6OToiMTUxNDMwNjc4IjtzOjQ6ImJwaWQiO3M6MzI6IjUxYWU5Zjc1Z282c04wbVUzbm0xSmNGaVNJMUVxSWhCIjtzOjc6InVzZXJBZ2UiO2k6NDM7czoxNDoiZmJfYXBwbGljYXRpb24iO2I6MDtzOjk6InByb2plY3RJRCI7czozOiI1NzkiO3M6MzoiYWlkIjtpOjMzMjtzOjM6ImFpcCI7czowOiIiO3M6NDoibGFuZyI7czoyOiJlbiI7czozOiJkZXYiO2I6MDtzOjQ6InRpbWUiO2k6MTM3MDQ0ODAzNzt9&aid=332&aip=&hash=9a60f0a3f3d1aadb2120f60b9b797605';
                BPLayertool2.Helper.setPaymentLink(paymentURL);
                BPLayertool2.Helper.setUserId(98026209);
                BPLayertool2.Helper.setRequestTime(1370448037);
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