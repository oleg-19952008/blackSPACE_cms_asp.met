</head>
<body class="internalDockShop_petGear" onLoad="" >
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

<?php require GLOBALS . 'internalHelpLayer.php'; require GLOBALS . 'internalNews.php'; ?>            

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
                <div id="dock_content">

    <div id="dock_container" class="fliess10px-weiss">
        <div id="navigation" style="float: left;">
            <style type="text/css" media="screen">    @import "./css/cdn/subnav.css?__cv=7014599eddf59246c3b41c90d0475200"; </style>

    <div id="subNavTop">
                <style>
            .subNavTextInactiveShip {background-image: url(text?t=SHIPS&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveShip {background-image: url(text?t=SHIPS&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactiveDrone {background-image: url(text?t=DRONES&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveDrone {background-image: url(text?t=DRONES&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactiveWeapons {background-image: url(text?t=WEAPONS&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveWeapons {background-image: url(text?t=WEAPONS&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactiveAmmo {background-image: url(text?t=AMMO&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveAmmo {background-image: url(text?t=AMMO&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactiveGenerators {background-image: url(text?t=GENERATORS&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveGenerators {background-image: url(text?t=GENERATORS&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactiveExtras {background-image: url(text?t=EXTRAS&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveExtras {background-image: url(text?t=EXTRAS&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactiveBoosters {background-image: url(text?t=BOOSTERS&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveBoosters {background-image: url(text?t=BOOSTERS&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactiveDesigns {background-image: url(text?t=DESIGNS&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActiveDesigns {background-image: url(text?t=DESIGNS&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactivePetGears {background-image: url(text?t=PET/GEAR&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActivePetGears {background-image: url(text?t=PET/GEAR&w=16&s=9.2&color=black&b=lightestBlue);}
            .subNavTextInactivePetProtocols {background-image: url(text?t=AI%20PROTOCOLS&w=16&s=9.2&color=white&font=1&b=grey);}
            .subNavTextActivePetProtocols {background-image: url(text?t=AI%20PROTOCOLS&w=16&s=9.2&color=black&b=lightestBlue);}
        </style>
        <script>
            
            function subNavRollover(name) {
                if (jQuery('#' + name).hasClass('subNavButtonActive') == false) {
                    if (jQuery('#' + name).hasClass('subNavButtonInactive')) {
                        jQuery('#' + name).removeClass('subNavButtonInactive');
                        jQuery('#' + name).addClass('subNavButtonRollover');
                    } else {
                        jQuery('#' + name).removeClass('subNavButtonRollover');
                        jQuery('#' + name).addClass('subNavButtonInactive');
                    }
                }
            }
            
        </script>

        <div id="subNavShip" class="subNavButtonShip subNavButtonInactive" onmouseover="subNavRollover('subNavShip')" onmouseout="subNavRollover('subNavShip')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockShips"><div class="subNavTextInactiveShip"></div></a>
        </div>
        <div id="subNavDrone" class="subNavButtonDrone subNavButtonInactive" onmouseover="subNavRollover('subNavDrone')" onmouseout="subNavRollover('subNavDrone')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockDrones"><div class="subNavTextInactiveDrone"></div></a>
                    </div>
        <div id="subNavWeapons" class="subNavButtonWeapons subNavButtonInactive" onmouseover="subNavRollover('subNavWeapons')" onmouseout="subNavRollover('subNavWeapons')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockLaser"><div class="subNavTextInactiveWeapons"></div></a>
        </div>
        <div id="subNavAmmo" class="subNavButtonAmmo subNavButtonInactive" onmouseover="subNavRollover('subNavAmmo')" onmouseout="subNavRollover('subNavAmmo')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockAmmo"><div class="subNavTextInactiveAmmo"></div></a>
                    </div>
        <div id="subNavGenerators" class="subNavButtonGenerators subNavButtonInactive" onmouseover="subNavRollover('subNavGenerators')" onmouseout="subNavRollover('subNavGenerators')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockGenerator"><div class="subNavTextInactiveGenerators"></div></a>
        </div>
        <div id="subNavExtras" class="subNavButtonExtras subNavButtonInactive" onmouseover="subNavRollover('subNavExtras')" onmouseout="subNavRollover('subNavExtras')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockSpecials"><div class="subNavTextInactiveExtras"></div></a>
                    </div>
        <div id="subNavPetGears" class="subNavButtonPetGears subNavButtonActive" onmouseover="subNavRollover('subNavPetGears')" onmouseout="subNavRollover('subNavPetGears')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockPetGear"><div class="subNavTextActivePetGears"></div></a>
                    </div>
        <div id="subNavPetProtocols" class="subNavButtonPetProtocols subNavButtonInactive" onmouseover="subNavRollover('subNavPetProtocols')" onmouseout="subNavRollover('subNavPetProtocols')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockPetProtocols"><div class="subNavTextInactivePetProtocols"></div></a>
        </div>
        <div id="subNavBoosters" class="subNavButtonBoosters subNavButtonInactive" onmouseover="subNavRollover('subNavBoosters')" onmouseout="subNavRollover('subNavBoosters')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockBooster"><div class="subNavTextInactiveBoosters"></div></a>
                    </div>
        <div  id="subNavDesigns" class="subNavButtonDesigns subNavButtonInactive" onmouseover="subNavRollover('subNavDesigns')" onmouseout="subNavRollover('subNavDesigns')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockShipModel"><div class="subNavTextInactiveDesigns"></div></a>
                    </div>

            </div>


        </div>

        <!-- ITEM CONTAINER START -->
        <div id="item_container" name="item_container">
            <div id="item_container_overlay"></div>
            <div id="item_scroll_up" name="item_scroll_up"></div>
            <div id="item_scroll_top" name="item_scroll_top"></div>
            <div id="item_scroller">
                <div id="item_list">
	    		                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/pet/pet10_100x100.png?__cv=e8bbd8e957933caf10200c8ae422b400);">
                            <a id="pet_pet10" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>50,000 U.</strong>
                        </div>
                    </div>
                                </div>
            </div>
            <div id="item_scroll_down"></div>
            <div id="item_scroll_bottom"></div>
        </div>
        <!-- ITEM CONTAINER END -->

        <!-- PREVIEW CONTAINER START -->
        <div id="preview_container">
            <div id="preview">
                <div id="previewMovie">
                    <div></div>
                </div>
            </div>
            <div id="info">
                <div id="name" class="info_other_value"></div>
                <div id="scroll-content" class="info_other_value"></div>
            </div>
        </div>
        <!-- PREVIEW CONTAINER END -->

        <!-- BUY FRAME START -->
        <div id="buy_container">
            <div id="buy_itemName"></div>

            <div id="levelSelector">
                <div class="label">Level:</div>
                <div id="levelScrollUp" class="scrollArrow"></div>
                <div id="levelScrollContainer">
                    <div id="levelList">
                        <div class="level enabled" id="level1"></div>
                        <div class="level enabled" id="level2"></div>
                        <div class="level enabled" id="level3"></div>
                        <div class="level" id="level4"></div>
                        <div class="level" id="level5"></div>
                        <div class="level" id="level6"></div>
                        <div class="level" id="level7"></div>
                        <div class="level" id="level8"></div>
                        <div class="level" id="level9"></div>
                        <div class="level" id="level10"></div>
                    </div>
                </div>
                <div id="levelScrollDown" class="scrollArrow"></div>
            </div>

            <div id="amountSelector">
                <div class="label">Quantity</div>
                <div class="amountPreset" id="five"></div>
                <div class="amountPreset" id="ten"></div>
                <div class="amountPreset" id="twenty"></div>
                <div class="amountPreset" id="hundred"></div>
                <div class="amountPreset" id="thousand"></div>
                <div class="amountPreset" id="max"></div>
                <div id="arrow"></div>
                <div id="stepper">
                    <div class="control" id="minus"></div>
                    <input type="text" id="selectedAmount" value="1" />
                    <div class="control" id="plus"></div>

                </div>
            </div>
            
            <div id="nameSelector">
                <label for="itemName">P.E.T. name</label>
                <input type="text" id="itemName" name="itemName" value="" maxlength="16" />
            </div>

            <div id="discount"></div>

            <div id="buy_price">
                <input type="hidden" id="itemPrice" name="itemPrice" value="">
                <input type="text" id="sellPrice" name="sellPrice" readonly="readonly" value="">
            </div>
            <div id="buy_button" class="purchase">
                <div id="buy_button_text" style='background-image: url("/do_img/global/text_tf.esg?l=us&s=14&t=shop_buy&f=eurostyle_thea&color=white&bgcolor=grey");'></div>
            </div>
            
            <div id="subscription_button" class="purchase">
                <div id="start" style="background-image:url(/do_img/global/text_tf.esg?l=us&s=14&t=booster_subscribe&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
                <div id="stop" style="background-image:url(/do_img/global/text_tf.esg?l=us&s=14&t=booster_subscription_cancel&f=eurostyle_thea&color=white&bgcolor=grey&auto_br=1&auto_br_size=11);"></div>
            </div>
        </div>
        <!-- BUY FRAME END -->
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
    <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="./do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt="" /></a></div>
    <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>Building Vertigo - Polaris<br>2-4 rue Eugène Ruppert<br>L-2453 Luxemburg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jeronimo Folgueira<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 25331016<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 261 911 3515<br>Fax: +352 49 48 48 6606<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
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
<script type="text/javascript" src="resources/js/tools.js"></script>
<script type="text/javascript" src="resources/js/tools/text.js"></script>
<script type="text/javascript" src="resources/js/tools/popup.js"></script>
<script type="text/javascript" src="resources/js/tools/errorHandler.js"></script>
<script type="text/javascript" src="resources/js/tools/repeatCaller.js"></script>
<script type="text/javascript" src="resources/js/library.js"></script>
<script type="text/javascript" src="resources/js/user.js"></script>
<script type="text/javascript" src="resources/js/user/ship.js"></script>
<script type="text/javascript" src="resources/js/user/pet.js?"></script>
<script type="text/javascript" src="resources/js/shop.js"></script>
<script type="text/javascript" src="resources/js/shop/item.js"></script>
<script type="text/javascript" src="resources/js/shop/itemlist.js"></script>
<script type="text/javascript" src="resources/js/shop/amountSelector.js"></script>
<script type="text/javascript" src="resources/js/shop/nameSelector.js"></script>
<script type="text/javascript" src="resources/js/shop/levelSelector.js"></script>
<script type="text/javascript">

    jQuery.noConflict();
    jQuery(document).ready(function(){
        /**
         * Initialize DarkOrbit shop
         */
        Shop.Initialize();
    });

    function expressInstallCallback(info) {
        // possible values for info: loadTimeOut|Cancelled|Failed
        jQuery("#previewMovie").html("You need version 10.0 to view this content");
    }

    /**
     * Parameters for object.
     * Used as an interface with the action.
     */
    Shop.Parameters = {
        category        : 'petGear',
        paymentLink     : 'indexInternal.es?action=internalPayment',
        itemRows        : [],
        itemData        : {"pet_pet10":{"category":"pet","name":"P.E.T. 10","nameShort":"P.E.T. 10","description":"The P.E.T. will accompany your spaceship throughout the expanses of space, helping you out where it can. You can equip it with gear and AI protocols to upgrade it. It also collects experience and can level up.","price":50000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"PET-10","item_caption":"P.E.T.+10","item_prefix":"petGear","item_id":"PET","item_cv":"7a64ea498ba08e9da648438125388c00","price_plain":"50,000 U.","event_item_enabled":0,"loot_id":"pet_pet10"}},"itemListImageUrl":"\/do_img\/global\/items\/pet\/pet10_100x100.png?__cv=e8bbd8e957933caf10200c8ae422b400","cost":"50,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isNameSetable":true},"equipment_petgear_csr-02":{"category":"petGear","name":"Combo Repair Gear","nameShort":"Combo Ship Repair Gear","description":"Repairs your ship during flight. Uses extra fuel for each repair.<br \/><br \/>Protects your pet from attacks.","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_8_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"C-SR2","item_caption":"Combo+Ship+Repair+Gear","item_prefix":"petGear","item_id":8,"item_cv":"a996167cfe23867a4d834e9676f43300","price_plain":"20,000 U.","event_item_enabled":0,"loot_id":"equipment_petgear_csr-02"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/csr-02_100x100.png?__cv=960c611231888aaffb9da730a1a72200","cost":"20,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Effect: Repairs 10000 HP per second.<br \/>Duration: 5 seconds<br \/>Deflection chance: 65%<br \/>Consumption: 200 Fuel<br \/><br \/>Repairs your ship during flight. Uses extra fuel for each repair.<br \/><br \/>Protects your pet from attacks.","price":20000,"currency":"real","cost":"20,000 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Effect: Repairs 15000 HP per second.<br \/>Duration: 5 seconds<br \/>Deflection chance: 75%<br \/>Consumption: 400 Fuel<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>Repairs your ship during flight. Uses extra fuel for each repair.<br \/><br \/>Protects your pet from attacks.","price":30000,"currency":"real","cost":"30,000 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Effect: Repairs 25000 HP per second.<br \/>Duration: 5 seconds<br \/>Deflection chance: 85%<br \/>Consumption: 750 Fuel<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>Repairs your ship during flight. Uses extra fuel for each repair.<br \/><br \/>Protects your pet from attacks.","price":55000,"currency":"real","cost":"55,000 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":1,"isBuyable":true},"equipment_petgear_cgm-02":{"category":"petGear","name":"Combo Guard Mode Gear","nameShort":"Combo Guard Mode Gear","description":"Connects the Guard Mode to the new Insta Shield. Uses 35% more fuel when it's been activated.<br \/><br \/>Guard mode with an extra shield for the P.E.T.","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_9_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"C-GM2","item_caption":"Combo+Guard+Mode+Gear","item_prefix":"petGear","item_id":9,"item_cv":"afabad4d1249b4deafb0ad109a165f00","price_plain":"20,000 U.","event_item_enabled":0,"loot_id":"equipment_petgear_cgm-02"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/cgm-02_100x100.png?__cv=c072755cbb15d3922a0762d0189a5b00","cost":"20,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Deflection chance: 65%<br \/>Additional consumption: 35% Extra-Fuel<br \/><br \/>Connects the Guard Mode to the new Insta Shield. Uses 35% more fuel when it's been activated.<br \/><br \/>Guard mode with an extra shield for the P.E.T.","price":20000,"currency":"real","cost":"20,000 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Deflection chance: 75%<br \/>Additional consumption: 35% Extra-Fuel<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>Connects the Guard Mode to the new Insta Shield. Uses 35% more fuel when it's been activated.<br \/><br \/>Guard mode with an extra shield for the P.E.T.","price":30000,"currency":"real","cost":"30,000 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Deflection chance: 85%<br \/>Additional consumption: 35% Extra-Fuel<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>Connects the Guard Mode to the new Insta Shield. Uses 35% more fuel when it's been activated.<br \/><br \/>Guard mode with an extra shield for the P.E.T.","price":55000,"currency":"real","cost":"55,000 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":2,"isBuyable":true},"equipment_petgear_g-al1":{"category":"petGear","name":"Auto-looter","nameShort":"Auto-looter","description":"Once you activate this P.E.T gear, it will automatically collect bonus boxes and cargo boxes within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while it is collecting loot. Aliens cannot attack it.","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_1_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"G-AL1","item_caption":"Auto-looter","item_prefix":"petGear","item_id":1,"item_cv":"a5f6bebcf263026a986bc626c841db00","price_plain":"7,500 U.","event_item_enabled":0,"loot_id":"equipment_petgear_g-al1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/g-al1_100x100.png?__cv=3a6fe2c1d7e793fec4d697b90721f700","cost":"7,500 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Range: 700<br \/><br \/>Once you activate this P.E.T gear, it will automatically collect bonus boxes and cargo boxes within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while it is collecting loot. Aliens cannot attack it.","price":7500,"currency":"real","cost":"7,500 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Range: 1500<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>Once you activate this P.E.T gear, it will automatically collect bonus boxes and cargo boxes within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while it is collecting loot. Aliens cannot attack it.","price":17500,"currency":"real","cost":"17,500 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Range: 2500<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>Once you activate this P.E.T gear, it will automatically collect bonus boxes and cargo boxes within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while it is collecting loot. Aliens cannot attack it.","price":37500,"currency":"real","cost":"37,500 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":3,"isBuyable":true},"equipment_petgear_g-ar1":{"category":"petGear","name":"Auto-resource collector","nameShort":"Auto-resource collector","description":"Once you activate this P.E.T. gear, your P.E.T will automatically collect resources within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while collecting loot. Aliens cannot attack it.","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_2_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"G-AR1","item_caption":"Auto-resource+collector","item_prefix":"petGear","item_id":2,"item_cv":"64d3bbf244225e7246542c6180931800","price_plain":"2,500 U.","event_item_enabled":0,"loot_id":"equipment_petgear_g-ar1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/g-ar1_100x100.png?__cv=8a45f18eb3d3af23fdf234bb80807b00","cost":"2,500 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Range: 700<br \/><br \/>Once you activate this P.E.T. gear, your P.E.T will automatically collect resources within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while collecting loot. Aliens cannot attack it.","price":2500,"currency":"real","cost":"2,500 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Range: 1500<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>Once you activate this P.E.T. gear, your P.E.T will automatically collect resources within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while collecting loot. Aliens cannot attack it.","price":6000,"currency":"real","cost":"6,000 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Range: 3000<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>Once you activate this P.E.T. gear, your P.E.T will automatically collect resources within close range.<br \/><br \/>Your P.E.T can only be attacked by other players while collecting loot. Aliens cannot attack it.","price":17500,"currency":"real","cost":"17,500 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":4,"isBuyable":true},"equipment_petgear_g-el1":{"category":"petGear","name":"Enemy locator","nameShort":"Enemy locator","description":"Outfit your P.E.T with this gear and it'll automatically pinpoint every alien in the current star system.<br \/><br \/>","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_3_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"G-EL1","item_caption":"Enemy+locator","item_prefix":"petGear","item_id":3,"item_cv":"df19658eafde33ef1014b2d0d1447500","price_plain":"6,000 U.","event_item_enabled":0,"loot_id":"equipment_petgear_g-el1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/g-el1_100x100.png?__cv=fa541d3a91aabc670fb9b48223a3c000","cost":"6,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Range: 2000<br \/><br \/>Outfit your P.E.T with this gear and it'll automatically pinpoint every alien in the current star system.<br \/><br \/>","price":6000,"currency":"real","cost":"6,000 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Range: 3000<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>Outfit your P.E.T with this gear and it'll automatically pinpoint every alien in the current star system.<br \/><br \/>","price":12500,"currency":"real","cost":"12,500 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Range: 5000<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>Outfit your P.E.T with this gear and it'll automatically pinpoint every alien in the current star system.<br \/><br \/>","price":37500,"currency":"real","cost":"37,500 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":5,"isBuyable":true},"equipment_petgear_g-rl1":{"category":"petGear","name":"Resource locator","nameShort":"Resource locator","description":"With this gear on board your P.E.T., it will be able to track down nearby resources in the current star system.<br \/><br \/>","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_4_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"G-RL1","item_caption":"Resource+locator","item_prefix":"petGear","item_id":4,"item_cv":"6615457313d5031e7eebf7f4d60d2200","price_plain":"2,500 U.","event_item_enabled":0,"loot_id":"equipment_petgear_g-rl1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/g-rl1_100x100.png?__cv=d884c83b62690cd03d8f1f0fd6c6e000","cost":"2,500 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Range: 2000<br \/><br \/>With this gear on board your P.E.T., it will be able to track down nearby resources in the current star system.<br \/><br \/>","price":2500,"currency":"real","cost":"2,500 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Range: 3000<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>With this gear on board your P.E.T., it will be able to track down nearby resources in the current star system.<br \/><br \/>","price":6000,"currency":"real","cost":"6,000 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Range: 5000<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>With this gear on board your P.E.T., it will be able to track down nearby resources in the current star system.<br \/><br \/>","price":17500,"currency":"real","cost":"17,500 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":6,"isBuyable":true},"equipment_petgear_g-tra1":{"category":"petGear","name":"Cargo trader","nameShort":"Cargo trader","description":"The cargo trader makes it possible for your P.E.T. to trade cargo from anywhere in the galaxy at anytime.<br \/><br \/>","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_5_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"G-TRA1","item_caption":"Cargo+trader","item_prefix":"petGear","item_id":5,"item_cv":"b753c4b4fa6e8e9a90223ce9022b6900","price_plain":"6,000 U.","event_item_enabled":0,"loot_id":"equipment_petgear_g-tra1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/g-tra1_100x100.png?__cv=971fa24c7f7da534d8280f558c08f600","cost":"6,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Trade bonus: +5%<br \/><br \/>The cargo trader makes it possible for your P.E.T. to trade cargo from anywhere in the galaxy at anytime.<br \/><br \/>","price":6000,"currency":"real","cost":"6,000 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Trade bonus: +15%<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>The cargo trader makes it possible for your P.E.T. to trade cargo from anywhere in the galaxy at anytime.<br \/><br \/>","price":12500,"currency":"real","cost":"12,500 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Trade bonus: +30%<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>The cargo trader makes it possible for your P.E.T. to trade cargo from anywhere in the galaxy at anytime.<br \/><br \/>","price":37500,"currency":"real","cost":"37,500 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":7,"isBuyable":true},"equipment_petgear_g-rep1":{"category":"petGear","name":"P.E.T. repairer","nameShort":"P.E.T. repairer","description":"The P.E.T. repairer will fix your P.E.T.<br \/><br \/>Not made for use in combat.","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_6_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"G-REP1","item_caption":"P.E.T.+repairer","item_prefix":"petGear","item_id":6,"item_cv":"a2cbf6c5fbefbd2585dde18e94bdbd00","price_plain":"2,500 U.","event_item_enabled":0,"loot_id":"equipment_petgear_g-rep1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/g-rep1_100x100.png?__cv=574370c2191e3afe9f73d59fe45b6c00","cost":"2,500 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Effect: Repairs 2000 HP per second.<br \/>Duration: 120 seconds<br \/><br \/>The P.E.T. repairer will fix your P.E.T.<br \/><br \/>Not made for use in combat.","price":2500,"currency":"real","cost":"2,500 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Effect: Repairs 6000 HP per second.<br \/>Duration: 45 seconds<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>The P.E.T. repairer will fix your P.E.T.<br \/><br \/>Not made for use in combat.","price":6000,"currency":"real","cost":"6,000 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Effect: Repairs 12000 HP per second.<br \/>Duration: 30 seconds<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>The P.E.T. repairer will fix your P.E.T.<br \/><br \/>Not made for use in combat.","price":12500,"currency":"real","cost":"12,500 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":8,"isBuyable":true},"equipment_petgear_g-kk1":{"category":"petGear","name":"Kamikaze detonator","nameShort":"Kamikaze detonator ","description":"When your P.E.T. or ship is close to being destroyed, the Kamikaze detonator will start the self-destruct sequence and explode, thereby taking out all enemies in the immediate vicinity.<br \/><br \/>After the detonator has gone off, your P.E.T. will be massively damaged and have to be repaired.","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=pet_gear_7_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"G-KK1","item_caption":"Kamikaze+detonator+","item_prefix":"petGear","item_id":7,"item_cv":"00d02201f258c0b58c48fd76630a5300","price_plain":"7,500 U.","event_item_enabled":0,"loot_id":"equipment_petgear_g-kk1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/petgear\/g-kk1_100x100.png?__cv=ea7e148224933dbbfc36ddee26f79600","cost":"7,500 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isLevelSetable":true,"levelGrades":[1,2,3],"maxLevel":1,"levelItemShopData":{"1":{"isPetGearLevel":true,"description":"Effect: Causes 25000 splash damage upon exploding.<br \/>Radius: 250<br \/><br \/>When your P.E.T. or ship is close to being destroyed, the Kamikaze detonator will start the self-destruct sequence and explode, thereby taking out all enemies in the immediate vicinity.<br \/><br \/>After the detonator has gone off, your P.E.T. will be massively damaged and have to be repaired.","price":7500,"currency":"real","cost":"7,500 U.","isPaymentItem":false,"isElite":true},"2":{"isPetGearLevel":true,"description":"Effect: Causes 45000 splash damage upon exploding.<br \/>Radius: 350<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 4<\/span><br \/><br \/>When your P.E.T. or ship is close to being destroyed, the Kamikaze detonator will start the self-destruct sequence and explode, thereby taking out all enemies in the immediate vicinity.<br \/><br \/>After the detonator has gone off, your P.E.T. will be massively damaged and have to be repaired.","price":17500,"currency":"real","cost":"17,500 U.","isPaymentItem":false,"isElite":true},"3":{"isPetGearLevel":true,"description":"Effect: Causes 75000 splash damage upon exploding.<br \/>Radius: 450<br \/><span class=\"shop_missing_requirement\">Required: P.E.T. Level 8<\/span><br \/><br \/>When your P.E.T. or ship is close to being destroyed, the Kamikaze detonator will start the self-destruct sequence and explode, thereby taking out all enemies in the immediate vicinity.<br \/><br \/>After the detonator has gone off, your P.E.T. will be massively damaged and have to be repaired.","price":50000,"currency":"real","cost":"50,000 U.","isPaymentItem":false,"isElite":true}},"isPetGear":true,"sortPriority":9,"isBuyable":true}},
        numItems        : 10,
        startupItemId   : 'pet_pet10',
        userDroneAmount : 0,
        maxDroneAmount  : 8,
        language        : 'en'
    };

     User.Parameters = {"balance":{"uridium":<?php echo $Users->DataRow['uri']; ?>,"credits":<?php echo $Users->DataRow['credits']; ?>},"discountFactor":1,"language":"en","ship":{"laserAmmunitionSpace":3420,"rocketSpace":100},"isActiveHangarEmpty":true,"isShipDumpEmpty":true,"pet":{"hasPet":true,"level":1,"fuel":0,"maxFuel":0}};

    //add texts
    var textResources = {"items_shop_buy_confirm_s":"Do you really want to buy <b>%ITEMNAME%<\/b> for <b>%ITEMPRICE%<\/b>?","items_shop_buy_confirm_p":"Do you really want to buy %AMOUNT%x of <b>%ITEMNAME%<\/b> for <b>%ITEMPRICE%<\/b>?","items_shop_abo_confirm":"Do you really want to subscribe to <b>%itemName%<\/b>?","booster_subscription_cancel_confirmation":"Do you really want to end your \"%BOOSTERNAME%\" subscription?","drone_have_max":"Too many drones; you can't buy any more.","thousands_separator":",","decimal_separator":".","pricetag_credits_compact":"%VALUE% C.","pricetag_uridium_compact":"%VALUE% U.","items_currency_realcurrency_credits":"Credits","items_booster_subscription_cancel_confirmation":"Do you really want to end your \"%BOOSTERNAME%\" booster subscription?","booster_subscription_running":"Booster subscription active","booster_countdown":"Remaining time: %DAYS% days %HOURS% hours %MINUTES% min.","error_pet_name_char":"Invalid characters used in the P.E.T. name. Please only use letters and digits.","error_pet_name_length":"The P.E.T. name must be between 1 and 24 characters long.","shop_itemNameWithLevel":"%ITEMNAME% (Level: %LEVEL%)","shop_techfactory_long":"You may construct the item in the tech factory.","shop_techfactory":"Tech Factory","tf_message_not_enough_uridium":"Not enough Uridium available","tf_message_not_enough_credits":"Not enough Credits available","buy_toManyBATTERY":"You already have the max. amount of laser ammo on board!","buy_toManyROCKET":"You already have the max. number of rockets on board!","pet_gear_requirement":"Required: P.E.T. Level %level%","current_in_use":"In use","buy_pet_invalidFuelAmount":"Your P.E.T. cannot hold that much fuel.","active_hangar_empty":"Purchase unsuccessful.<br>The hangar that is currently activated is empty.","active_hangar_empty_equip":"You must first place a ship in the hangar.","active_hangar_empty_buy":"You must first acquire a ship and then place it in this hangar. ","hint_go_to_payment":"Need more Uridium? Click here to add some more Uridium!"};
    jQuery.each(textResources, function(i, n){
        Tools.Text.setResource(i,n)
    });

    Tools.Popup.Parameters = {"showOnLoad":false,"type":"success","content":""};

    if('') {
        jQuery("#discount").qtip({
            content: '',
            style:'dohdr',
            width: 50,
            position:{target:'mouse'}
        });
    }


</script>
