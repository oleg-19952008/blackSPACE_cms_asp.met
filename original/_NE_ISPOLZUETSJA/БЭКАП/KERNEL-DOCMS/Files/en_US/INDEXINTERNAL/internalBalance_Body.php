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

<style type="text/css" media="screen">    @import "http://<?php echo DynHost; ?>/css/cdn/includeInfoLayer.css";</style>
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

 <?php require GLOBALS . 'internalHelpLayer.php';
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
                
    <script type="text/javascript" src="./js/page/payment/internalBalanceDomReady.js?__cv=20d4650c0d655207f2652ddbfce7e900"></script>

        <div id="paymentFrame" class="balancePageBG">
            <div id="navigationFrame">

                <link rel="stylesheet" href="./css/cdn/navigation.css?__cv=027602d6f1863686ece0574190059400" />
<link rel="stylesheet" href="./css/cdn/internalPayment.css?__cv=1d1933c876ea67c24373da314e0e7200" />
<!-- start internal uridum -->


<div id="navigation">
    <!-- Banking -->
    <div class="button">
        <a href="indexInternal.es?action=internalPayment" title="Banking">
            <img src="./text?t=BANKING&w=16&s=9.2&color=white&font=1&b=grey"/>
        </a>
    </div>

    <!-- Balance -->
    <div class="button active">
        <a href="indexInternal.es?action=internalBalance" title="Balance">
            <img src="./text?t=BALANCE&w=16&s=9.2&color=black&b=lightestBlue"/>
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
    

</div>

<!-- end internal uridium -->
                <div id="wrapper" class="balancePage" style="height:391px">

                    <div class="headline">Balance</div>

                    <ul class="balance_items" style="margin:1px 0 3px 0;">
                        <li class="balance_item">
                            <span class="date">Date</span>
                            <span class="description">Action</span>
                            <span class="amount">Amount</span>
                       </li>
                    </ul>

                    <div style="width: 626px;">
                        <div id="balanceListContainer" style="height: 264px; overflow: auto; ">
                            <ul class="balance_items">
                                                                <li class="balance_item">
                                    <span class="date">05.06. 11:26</span>
                                    <span class="description">5+day login bonus received</span>
                                    <span class="amount">+ 200 U.</span>
                                </li>
                                                                <li class="balance_item">
                                    <span class="date">04.06. 10:58</span>
                                    <span class="description">5-day login bonus received</span>
                                    <span class="amount">+ 200 U.</span>
                                </li>
                                                                <li class="balance_item">
                                    <span class="date">01.06. 21:10</span>
                                    <span class="description">2-day login bonus received</span>
                                    <span class="amount">+ 25,000 C.</span>
                                </li>
                                                                <li class="balance_item">
                                    <span class="date">31.05. 19:03</span>
                                    <span class="description">1-day login bonus received</span>
                                    <span class="amount">+ 10,000 C.</span>
                                </li>
                                                                <li class="balance_item">
                                    <span class="date">23.05. 11:42</span>
                                    <span class="description">2-day login bonus received</span>
                                    <span class="amount">+ 25,000 C.</span>
                                </li>
                                                                <li class="balance_item">
                                    <span class="date">22.05. 13:30</span>
                                    <span class="description">1-day login bonus received</span>
                                    <span class="amount">+ 10,000 C.</span>
                                </li>
                                                            </ul>
                        </div>
                    </div>


                    <div class="pagination"></div>
                </div> <!-- end: #wrapper -->

                <div style="clear:both"><!--  --></div>

            </div> <!-- end: #navigationFrame -->
        </div> <!-- end: #paymentFrame -->
    

</div><!-- END contentFrame -->
</div><!-- END realContainer -->

<div class="footerContainer">
    <div class="frameLeft_bottom"></div>
    <div class="frameRight_bottom"></div>
    <div class="frameBottom"></div>

<div id="alertBox" class="fliesstext"></div>
<div id="imprint" style="width:523px;height:600px;" class="fliesstext">
    <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="./do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt="" /></a></div>
    <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>EBBC D <br>6 D route de Trèves<br>L-2633 Senningerberg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jeronimo Folgueira, Jochen Siegert<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 25331016<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 261 911 3515<br>Fax: +352 49 48 48 6606<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
</div>
<?php require GLOBALS . 'credits.php';?>

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
    var cssLink  = document.createElement('link');
    cssLink.type = 'text/css';
    cssLink.rel  = 'stylesheet';
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