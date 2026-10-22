</head>
<body onLoad="" >
    <!-- affiliateStartTag -->



    <script type="text/javascript" src="/js/jQuery/jquery-1.4.4.min.js"></script>


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
                infoText = '<?php if (isset($log_message)): echo $log_message;
endif; ?>';
                icon = '<?php if (isset($type)): echo $type;
endif; ?>';    </script>

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
                             '/text?t=OK&w=3&s=12&color=white&h=13&b=grey'
                             );">
                        </div>
                    </div>
                    <div class="popup_shop_abort_button">
                        <div class="popup_shop_abort_text"
                             style="background-image: url(
                             '/text?t=Cancel&w=6&s=12&color=white&h=13&b=grey'
                             );"
                             onclick="closeInfoLayer();">
                        </div>
                    </div>
                </div>

                <div id="infoLayerInfo">
                    <div class="popup_shop_close_button">
                        <div class="popup_shop_close_text"
                             style='background-image: url("/text?t=OK&w=3&s=12&color=white&h=13&b=grey");'
                             onclick="closeInfoLayer();"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
<?php if (isset($type) && isset($log_message) && !empty($type)): echo "showInfoLayer('info', 0, infoText);";
endif; ?>

    </script>


    <?php
    require GLOBALS . 'internalHelpLayer.php';
    require GLOBALS . 'internalNews.php';
    ?>
    <div class="backgroundImageContainer">
        <div class="overallContainer">

            <div class="outerContainer fliess11px-gelb">

<?php require GLOBALS . 'internalHeaderIntern.php'; ?>
                <link rel="stylesheet" href="./css/cdn/navigation.css" />
                <script type="text/javascript" src="./js/page/clan/internalNewClanIndexDomReady.js"></script>

                <div class="bodyContainer">


                    <script type="text/javascript">
        rid = 'ddb2d8b3509d19028d00c15a64442186';

        function changeFaction(id, factionName) {
            showBusyLayer();
            $('factionName').innerHTML = factionName;
            $('changeFaction').onclick = new Function("sendChangeFaction('indexInternal.es.php?action=internalClan&subAction=changeFirm&tpl=internalClanChangeFirm&newFirm=" + id + "&reloadToken=" + rid + "')");
            //    width_x = document.body.offsetWidth;
            //    container_x = $("change").getWidth();
            //    $("change").style.left = ((width_x/2) - (container_x*1.2))+"px";
            //    $("change").style.top = "50px";
            $("change").style.display = "block";
        }

        function sendChangeFaction(target) {
            document.location.href = target;
        }
        function changeFactionImg(wich) {
            var image = $(wich).src;
            //var endung = (image.substr(image.length-3,3));
            if ((image.substr(image.length - 5, 1)) == 0) {
                var teil = 1;
                var endung = 'gif';
            } else {
                var teil = 0;
                var endung = 'jpg';
            }
            var newImage = (image.substring(0, image.length - 5)) + teil + "." + endung;
            $(wich).src = newImage;
        }

                    </script>
                    <!--- popup change -->

                    <div class="frameTop"><!--  --></div>
                    <div class="frameLeft_top"><!--  --></div>
                    <div class="frameRight_top"><!--  --></div>
                    <div class="contentFrame">
                        <div class="borderFrame">
                            <div id="navigationFrame" style="margin-left: 14px; margin-top: -4px;">

                                <!-- start internal clan2 -->

                                <div id="navigation">
                                    <!-- Join -->
                                    <?php
                                    $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
                                    $clanid = $clan->getMyClan($Users->DataRow['playerID']);
                                    if ($clanid == 0):
                                        ?>
                                        <div class="button">
                                            <a href="indexInternal.es?action=internalNewClan" title="Join">
                                                <img src="./text?t=JOIN&w=16&s=9.2&color=white&font=1&b=grey"/>
                                            </a>
                                        </div>

                                        <div class="button ">
                                            <a href="indexInternal.es?action=internalNewClanDetails&subaction=foundClan" title="Found">
                                                <img src="./text?t=FOUND&w=16&s=9.2&color=white&font=1&b=grey"/>
                                            </a>
                                        </div>
                                        <?php
                                    else:
                                        ?>
                                     <div class="button">
                                        <a href="indexInternal.es?action=internalClan" title="Join">
                                            <img src="./text?t=INFORMATION&w=16&s=9.2&color=white&font=1&b=grey"/>
                                        </a>
                                    </div>
                                    <div class="button">
                                        <a href="indexInternal.es?action=internalClan&tpl=internalClanMember" title="Join">
                                            <img src="./text?t=MEMBERS&w=16&s=9.2&color=white&font=1&b=grey"/>
                                        </a>
                                    </div>
                                    <div class="button">
                                        <a href="indexInternal.es?action=internalClan&tpl=internalClanDiplomacy" title="Join">
                                            <img src="./text?t=DIPLOMACY&w=16&s=9.2&color=white&font=1&b=grey"/>
                                        </a>
                                    </div>
                                    <?php
                                    endif;
                                    ?>
                                   
                                    <!-- Company Change -->
                                    <div class="button active">
                                        <a href="indexInternal.es?action=internalClan&tpl=internalClanChangeFirm" title="Company">
                                            <img src="./text?t=COMPANY&w=16&s=9.2&color=black&b=lightestBlue"/>
                                        </a>
                                    </div>
                                </div>

                                <!-- end internal clan2 -->
                                <div id="wrapper" class="changFirm" style="height:404px;">
                                    <div class="header">
                                        <div class="headline">Change Company</div>

                                        <div style="clear:both;"><!--  --></div>
                                    </div>

                                    <div id="" class="fliess11px-gelb">

                                        <div id="inner-cont" class="fliess13px-grey">

                                            <div id="companySelection">

                                                <!-- header section -->

                                                <!-- content section -->
                                                <div id="content" style="<?php if ($clanid == 0): echo "margin-top: -40px !important;"; endif;?>">

                                                    <div class="faction_outer" data-id="1">
                                                        
                                                        <div id="faction_charactar" class="faction_charactar faction_mmo clickable" data-id="1"><!--  --></div>
                                                        
                                                        <div class="faction_charactar_logo faction_mmo"><!--  --></div>
                                                        <div class="faction_charactar_shade"><!--  --></div>

                                                        <div class="faction_outer_highlight"><!--  --></div>
                                                        <div class="faction_hover faction-hover clickable" index="0">
                                                            <a href="#" factionId="1">
                                                                <img src="./do_img/en/companyChoose/Click-to-confirm.png?__cv=ba5a92c81746f6290b77d886335a3200" width="140" alt="Click-to-confirm"/>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="faction_outer" data-id="2">

                                                        <div id="faction_charactar" class="faction_charactar faction_eic clickable" data-id="2"><!--  --></div>

                                                        <div class="faction_charactar_logo faction_eic"><!--  --></div>
                                                        <div class="faction_charactar_shade"><!--  --></div>

                                                        <div class="faction_outer_highlight"><!--  --></div>

                                                        <div class="faction_hover faction-hover clickable" index="1">
                                                            <a href="#" factionId="2">
                                                                <img src="./do_img/en/companyChoose/Click-to-confirm.png?__cv=ba5a92c81746f6290b77d886335a3200" width="140" alt="Click-to-confirm"/>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="faction_outer" data-id="3">

                                                        <div id="faction_charactar" class="faction_charactar faction_vru clickable" ><!--  --></div>

                                                        <div class="faction_charactar_logo faction_vru"><!--  --></div>

                                                        <div class="faction_charactar_shade"><!--  --></div>

                                                        <div class="faction_outer_highlight"><!--  --></div>

                                                        <div class="faction_hover faction-hover clickable" index="2">
                                                            <a href="#" factionId="3">
                                                                <img src="./do_img/en/companyChoose/Click-to-confirm.png?__cv=ba5a92c81746f6290b77d886335a3200" width="140" alt="Click-to-confirm"/>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"><!-- --></div>


                                                </div>

                                            </div>

                                            <script type="text/javascript" src="/js/jQuery/jquery-1.4.4.min.js"></script>


                                            <script type="text/javascript">

    jQuery('.faction_outer').click(function() {
       var id = $(this).attr("data-id");
       location.href = 'indexInternal.es?action=internalClan&tpl=internalClanChangeFirm&changefirm='+id;

   });
        var factions = [];
        var animateDefaultHeadline = null;

        factions.push({
            identifier: 'mmo',
            charactarBackgroundPosition: {normal: '0px 0px', zoom: '-70px 0px'},
            charactarBackgroundSize: {normal: '115%', zoom: '220%'},
            headerHeadlineBackgroundPosition: 'center top'
        });

        factions.push({
            identifier: 'eic',
            charactarBackgroundPosition: {normal: '0px 0px', zoom: '-77px 0px'},
            charactarBackgroundSize: {normal: '135%', zoom: '220%'},
            headerHeadlineBackgroundPosition: 'center center'
        });

        factions.push({
            identifier: 'vru',
            charactarBackgroundPosition: {normal: '0x 0px', zoom: '0px 0px'},
            charactarBackgroundSize: {normal: '115%', zoom: '150%'},
            headerHeadlineBackgroundPosition: 'center bottom'
        });

        var showDefaultHeadlines = function() {
            var headerDefaultHeadline = jQuery('#header .default');
            var description = jQuery('#factionDescription');
            var descriptionDefaulftHeadline = description.find('.default');
            var factionDescription = description.find('.mmo, .eic, .vru');
            var visible = false;

            // checking one of the faction description is visible if not the default headline will fade in again.
            factionDescription.each(function(index, value) {
                if (false === jQuery(value).is(':hidden')) {
                    visible = true;
                }
                ;
            });

            if (false === visible) {
                headerDefaultHeadline.fadeIn(200, 'linear', function() {
                    descriptionDefaulftHeadline.fadeIn(200);
                });
            }
            ;
        };






        jQuery(document).ready(function() {

            var ieLower9 = (true === jQuery.browser.msie && 9 > jQuery.browser.version) ? true : false;

            jQuery('.faction-hover').bind('mouseenter', function(evt) {
                evt.preventDefault();

                var element = jQuery(this);
                var parent = element.parent();
                var charactar = parent.find('.faction_charactar');
                var highlight = parent.find('.faction_outer_highlight');
                var logo = parent.find('.faction_charactar_logo');
                var index = element.attr('index');
                var description = jQuery('#factionDescription');
                var confirm = parent.find('.confirm');
                var factionDescription = description.find('.' + factions[index].identifier);
                var defaulftHeadline = description.find('.default');
                var headerHeadline = jQuery('#header').find('.default');
                var headerHeadlines = jQuery('#header').find('.mmo, .eic, .vru');
                var headerFactionHeadline = jQuery('#header').find('.' + factions[index].identifier);
                var charactarArrow = jQuery('#speach_arrows .' + factions[index].identifier);

                if (false === ieLower9) {
                    logo.animate({
                        backgroundSize: '100%',
                        width: '50px',
                        height: '60px',
                        marginTop: '200px',
                        marginLeft: '80px'
                    },
                    75
                            );
                } else {
                    logo.hide();
                }
                ;

                confirm.show();
                highlight.show();
                defaulftHeadline.hide();
                factionDescription.show();
                charactarArrow.show();

                headerHeadline.hide();
                headerHeadlines.hide();
                headerFactionHeadline.show();

                if (false === ieLower9) {
                    charactar.animate(
                            {
                                backgroundSize: factions[index].charactarBackgroundSize.zoom,
                                backgroundPosition: factions[index].charactarBackgroundPosition.zoom
                            },
                    250
                            );
                }
                ;
            });

            jQuery('.faction-hover').bind('mouseleave', function(evt) {
                evt.preventDefault();

                var element = jQuery(this);
                var parent = element.parent();
                var charactar = parent.find('.faction_charactar');
                var highlight = parent.find('.faction_outer_highlight');
                var logo = parent.find('.faction_charactar_logo');
                var index = element.attr('index');
                var description = jQuery('#factionDescription');
                var factionDescription = description.find('.mmo, .eic, .vru');
                var headerHeadlines = jQuery('#header').find('.mmo, .eic, .vru');
                var confirm = parent.find('.confirm');
                var charactarArrow = jQuery('#speach_arrows .arrow');

                highlight.hide();
                confirm.hide();
                factionDescription.hide();
                headerHeadlines.hide();
                charactarArrow.hide();

                animateDefaultHeadline = setTimeout('showDefaultHeadlines()', 1500);

                if (false === ieLower9) {
                    charactar.animate(
                            {
                                backgroundSize: factions[index].charactarBackgroundSize.normal,
                                backgroundPosition: factions[index].charactarBackgroundPosition.normal
                            },
                    125
                            );

                    logo.animate(
                            {
                                marginTop: '200px',
                                backgroundSize: '100%',
                                width: '50px',
                                height: '60px',
                                marginLeft: '135px'
                            },
                    75
                            );
                } else {
                    logo.show();
                }
                ;
            });

        });


                                            </script>
                                        </div>

                                    </div>


                                </div><!-- end div#wrapper -->

                                <div style="clear:both;"><!--  --></div>

                            </div><!-- end div#navigationWrapper -->

                        </div>
                    </div>


                    <<div class="footerContainer">
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
                <div class="text" style="background-image: url(/do_img/global/text_tf.esg?s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
            </div>
            <div class="button button-blue">
                <div class="text" style="background-image: url(/do_img/global/text_tf.esg?s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
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


</body>
</html>