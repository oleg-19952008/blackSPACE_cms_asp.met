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
                    <img src="/text?t=OK&w=3&s=12&color=white&h=13&b=grey" />
                </div>
            </div>
        </div>
    </div>


    <div id="busy_layer"></div>


    <!-- seitenabdecker -->

    <style type="text/css" media="screen">    @import "http://<?php echo DynHost; ?>/css/cdn/includeInfoLayer.css";</style>
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
<?php if (isset($type) && isset($log_message) && !empty($type)): 
    echo "showInfoLayer('info', 0, infoText);";
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

                <div class="bodyContainer">
                    <div class="frameTop"></div>
                    <div class="frameLeft_top"></div>
                    <div class="frameRight_top"></div>
                    <div class="contentFrame">
                        <div class="realContainer">

                            <div id="paymentFrame" class="evoucher">
                                <div id="navigationFrame">

                                    <link rel="stylesheet" href="./css/cdn/navigation.css" />
                                    <link rel="stylesheet" href="./css/cdn/internalPayment.css" />
                                    <!-- start internal uridum -->


                                    <div id="navigation">
                                        <!-- Banking -->
                                        <div class="button ">
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
                                            <a href="#" class="open_external" target="_blank" title="Manage subscriptions">
                                                <img src="./text?t=SUBSCRIPTIONS&w=16&s=9.2&color=white&font=1&b=grey"/>
                                            </a>
                                        </div>

                                        <!-- Vouchers -->
                                        <div class="button active">
                                            <a href="indexInternal.es?action=internalEvoucher" title="VOUCHERS">
                                                <img src="text?t=VOUCHERS&w=16&s=9.2&color=black&b=lightestBlue"/>
                                            </a>
                                        </div>


                                        <!-- internalPaymentPartnerPromotion -->


                                    </div>

                                    <!-- end internal uridium -->


                                    <div id="wrapper" style="background-image: url(/do_img/global/eVoucher/bg_evoucher_box2.png?__cv=1ca56297ce0d05e7bc22282c5821e900) !important;">

                                        <div class="header">
                                            <img src="./text?t=VOUCHER CODE&w=29&h=22&s=25&color=darkblue&b=grey"/>
                                        </div>

                                        <script type="text/javascript">
                                            var captchaLang = 'us';

                                            var RecaptchaOptions = {
                                                theme: 'blackglass',
                                                lang: captchaLang

                                            };

                                        </script>


                                        <form action="indexInternal.es?action=internalEvoucher" method="POST"><input type="hidden" name="reloadToken" value="93828923e27c436332fdff9985b5e3d7">

                                            <div class="infotext">
                                                Please enter your voucher code here to redeem it:
                                            </div>

                                            <div class="eVoucher_form">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td><div class="voucher_arrow"></div></td>
                                                            <td><input class="evoucherInputField fliess11px-grey" type="text" name="evoucher" value="Enter voucher code here" size="31" onfocus="Evoucher();" /></td>
                                                            <td><div class="statusIcon"></div></td>
                                                        </tr>
                                                    </tbody>
                                                </table>











                                            </div>


                                            <div id="footer">
                                                <input id="cashCodeButton" class="cashcodeButton_active cashCodeButton" type="submit" name="redeem" value="Redeem" title="Redeem the voucher code that has been entered." />
                                                <input id="cashLogButton" class="cashcodeButton_active cashLogButton" type="submit" name="logbook" value="Logbook" href="indexInternal.es?action=internalEvoucher&tpl=internalEvoucherLog" />
                                            </div>
                                        </form>

                                    </div> <!-- end div#wrapper -->
                                </div>
                            </div>
                        </div><!-- END contentFrame -->
                    </div><!-- END realContainer -->

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
                            </div><!-- End footerContainer -->
                </div><!-- End bodyContainer -->
            </div><!-- End outerContainer -->
        </div><!-- End overallContainer -->
    </div>



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

    <!-- LayertoolService JavaScript Injection end -->


</body>
</html>