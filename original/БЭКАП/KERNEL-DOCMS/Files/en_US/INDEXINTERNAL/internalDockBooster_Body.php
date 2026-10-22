</head>
<body class="internalDockShop_booster" onLoad="" >
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
        <div id="subNavPetGears" class="subNavButtonPetGears subNavButtonInactive" onmouseover="subNavRollover('subNavPetGears')" onmouseout="subNavRollover('subNavPetGears')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockPetGear"><div class="subNavTextInactivePetGears"></div></a>
                    </div>
        <div id="subNavPetProtocols" class="subNavButtonPetProtocols subNavButtonInactive" onmouseover="subNavRollover('subNavPetProtocols')" onmouseout="subNavRollover('subNavPetProtocols')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockPetProtocols"><div class="subNavTextInactivePetProtocols"></div></a>
        </div>
        <div id="subNavBoosters" class="subNavButtonBoosters subNavButtonActive" onmouseover="subNavRollover('subNavBoosters')" onmouseout="subNavRollover('subNavBoosters')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockBooster"><div class="subNavTextActiveBoosters"></div></a>
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/ep-b01_100x100.png?__cv=73a676e5f07c511c1cac6eb8cab1d700);">
                            <a id="1" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/hon-b01_100x100.png?__cv=afec998665bc16f87d4974d82dc82400);">
                            <a id="2" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/dmg-b01_100x100.png?__cv=8b189d52f44817a3d8d162770c30d900);">
                            <a id="3" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/shd-b01_100x100.png?__cv=46e4c9c3c367091cb0a4106b673a6000);">
                            <a id="4" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/rep-b01_100x100.png?__cv=b6c8987effa8dc76aebbd189363b2c00);">
                            <a id="5" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/sreg-b01_100x100.png?__cv=c35ebd4e97ee5e41d68a4cb7cd8ca400);">
                            <a id="6" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/res-b01_100x100.png?__cv=577f2d441bcc710387f87c74237a9700);">
                            <a id="7" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/hp-b01_100x100.png?__cv=8a7bb216cbff9eab0963433590d1e400);">
                            <a id="8" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/booster/cd-b01_100x100.png?__cv=c7216aa63a1f0271b90174f66a5c4700);">
                            <a id="21" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 U.</strong>
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
<script type="text/javascript" src="resources/js/shop/levelSelector.js"></script>s
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
        category        : 'booster',
        paymentLink     : 'indexInternal.es?action=internalPayment',
        itemRows        : [],
        itemData        : {"11":{"category":"booster","name":"Shared EP Booster","nameShort":"Pro experience booster","description":"+10% EP; 5% of this EP bonus can be shared with friendly ships nearby<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 50% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_11_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"XP-B02","item_caption":"Pro+experience+booster","item_prefix":"booster","item_id":11,"item_cv":"3586908168e2973852c496280c999300","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_ep-b02","useDeviceFonts":0,"booster_icon_cv":"d6fea6ec839af66761f1dbe4bf666800"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/ep-b02_100x100.png?__cv=4e837365e6d6cc8716772d0d77847200","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"12":{"category":"booster","name":"Shared honor booster","nameShort":"Honor booster pro","description":"+10% HP; 5% bonus HP can be shared with friendly ships nearby<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 50% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_12_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"HON-B02","item_caption":"Honor+booster+pro","item_prefix":"booster","item_id":12,"item_cv":"eeb791c11974d5e195244f7c10458900","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_hon-b02","useDeviceFonts":0,"booster_icon_cv":"250a28bfaa3b7e5666a9574710ec7100"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/hon-b02_100x100.png?__cv=f44c7692a0880871d9449919e235d600","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"13":{"category":"booster","name":"Shared damage booster","nameShort":"Pro damage booster","description":"+10% damage for damage inflicted. 5% of bonus damage can be shared with friendly ships nearby<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 50% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_13_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"DMG-B02","item_caption":"Pro+damage+booster","item_prefix":"booster","item_id":13,"item_cv":"43ed10259a7c6cb2ff0297a055fdab00","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_dmg-b02","useDeviceFonts":0,"booster_icon_cv":"aa785b357e5c1a5fea2616fc3b5c7f00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/dmg-b02_100x100.png?__cv=7476a8dfc78fb115dca50581932beb00","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"14":{"category":"booster","name":"Shared shield power booster","nameShort":"Shield power pro","description":"Increases ship's maximum shield power by 25% and allows you to share 10% of this bonus with friendly ships nearby.<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 100% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_14_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SHD-B02","item_caption":"Shield+power+pro","item_prefix":"booster","item_id":14,"item_cv":"285d800f5060cbe4678f88bdc2d65300","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_shd-b02","useDeviceFonts":0,"booster_icon_cv":"cf06c73174fc99035c5a45b464412f00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/shd-b02_100x100.png?__cv=8f0b81cc566695b236c6d206fe98f500","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"15":{"category":"booster","name":"Shared repair booster","nameShort":"Pro repair booster","description":"+10% repair speed; 5% of this bonus can be shared with friendly ships nearby<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 50% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_15_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"REP-B02","item_caption":"Pro+repair+booster","item_prefix":"booster","item_id":15,"item_cv":"b951d0c39fd59a927a665c3255600300","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_rep-b02","useDeviceFonts":0,"booster_icon_cv":"fc5be00b7e4c389586a0fbeb14f01100"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/rep-b02_100x100.png?__cv=1d5c97b1b866d233d0e064cb65364b00","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"16":{"category":"booster","name":"Shared shield recharger booster","nameShort":"Shield recharge pro","description":"Increases the shield's regeneration speed by 25% and allows you to share 10% of this bonus with friendly ships nearby.<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 100% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_16_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SREG+B02","item_caption":"Shield+recharge+pro","item_prefix":"booster","item_id":16,"item_cv":"5fc3dddcbd5e0061ca960536aaed7100","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_sreg-b02","useDeviceFonts":0,"booster_icon_cv":"ebb98aa99913e72f63932beffdea3b00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/sreg-b02_100x100.png?__cv=2c18bcff3eee30f4c973116ab316f800","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"17":{"category":"booster","name":"Shared resource booster","nameShort":"Pro resource booster","description":"The resource booster increases the number of resources from collected NPC cargo boxes by 25% and provides a 10 % of this bonus for friendly ships in the vicinity.<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 100% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_17_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"RES-B02","item_caption":"Pro+resource+booster","item_prefix":"booster","item_id":17,"item_cv":"0d72f34a0e6054645edb043213879f00","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_res-b02","useDeviceFonts":0,"booster_icon_cv":"c7b49bf713681eadb31abfdb37060700"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/res-b02_100x100.png?__cv=3a4cb9141ef6bec35854f7c8b7070a00","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"18":{"category":"booster","name":"Shared hit points booster","nameShort":"Pro hit points booster","description":"Increases ship's maximum HP by 10% and allows you to share 5% of this bonus with friendly ships nearby<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 50% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_18_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"HP-B02","item_caption":"Pro+hit+points+booster","item_prefix":"booster","item_id":18,"item_cv":"76d569b131a3db8c023dac7ec91a3100","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_hp-b02","useDeviceFonts":0,"booster_icon_cv":"027095c2bd377d4c9534f112f4bf8300"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/hp-b02_100x100.png?__cv=8742e9f899c493713e40d94a7f59e300","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"22":{"category":"booster","name":"Cooldown Booster","nameShort":"Cooldown Booster","description":"30% quicker cooldown times for all ship and design skills. Booster is active for 10 hours of game time after purchase.<br \/><br \/>Booster is active for 10 hours from the time of purchase. It has a 50% maximum boost level.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_22_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"CD-B02","item_caption":"Cooldown+Booster","item_prefix":"booster","item_id":22,"item_cv":"8a0effb1aa216a745138264319f16900","price_plain":"10,000 U.","event_item_enabled":1,"loot_id":"booster_cd-b02","useDeviceFonts":0,"booster_icon_cv":"bff6423e16cf20bb1a6ab375f7182a00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/cd-b02_100x100.png?__cv=99c0ed15655fda3859921a4a9709c200","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":false,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":true,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"1":{"category":"booster","name":"Experience booster","nameShort":"Experience booster","description":"Gives you a 10% EP bonus. Booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_1_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"XP-B01","item_caption":"Experience+booster","item_prefix":"booster","item_id":1,"item_cv":"92393b5cfa0373318d3dd793150bf800","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_ep-b01","useDeviceFonts":0,"booster_icon_cv":"d6fea6ec839af66761f1dbe4bf666800"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/ep-b01_100x100.png?__cv=73a676e5f07c511c1cac6eb8cab1d700","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"2":{"category":"booster","name":"Honor booster","nameShort":"Honor booster","description":"+10% honor; This booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_2_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"HON-B01","item_caption":"Honor+booster","item_prefix":"booster","item_id":2,"item_cv":"ab0495b3b1bf21baae2587d1969ed300","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_hon-b01","useDeviceFonts":0,"booster_icon_cv":"250a28bfaa3b7e5666a9574710ec7100"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/hon-b01_100x100.png?__cv=afec998665bc16f87d4974d82dc82400","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"3":{"category":"booster","name":"Damage booster","nameShort":"Damage booster","description":"+10% damage for all damage inflicted. Booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_3_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"DMG-B01","item_caption":"Damage+booster","item_prefix":"booster","item_id":3,"item_cv":"d5e7e1b5df5c119778febdd345781200","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_dmg-b01","useDeviceFonts":0,"booster_icon_cv":"aa785b357e5c1a5fea2616fc3b5c7f00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/dmg-b01_100x100.png?__cv=8b189d52f44817a3d8d162770c30d900","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"Remaining time: 0 days 9 hours 45 min.","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":true,"isOnlyForShow":false,"isLevelSetable":false},"4":{"category":"booster","name":"Shield booster","nameShort":"Shield power booster","description":"+25% shield power; This booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_4_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SHD-B01","item_caption":"Shield+power+booster","item_prefix":"booster","item_id":4,"item_cv":"be3d8ab828d86115818c06e42fd02000","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_shd-b01","useDeviceFonts":0,"booster_icon_cv":"cf06c73174fc99035c5a45b464412f00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/shd-b01_100x100.png?__cv=46e4c9c3c367091cb0a4106b673a6000","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"5":{"category":"booster","name":"Repair booster","nameShort":"Repair booster","description":"+10% faster ship repairs; This booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_5_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"REP-B01","item_caption":"Repair+booster","item_prefix":"booster","item_id":5,"item_cv":"1ce31d241378f97d246cf6e8a1aa1300","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_rep-b01","useDeviceFonts":0,"booster_icon_cv":"fc5be00b7e4c389586a0fbeb14f01100"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/rep-b01_100x100.png?__cv=b6c8987effa8dc76aebbd189363b2c00","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"6":{"category":"booster","name":"Shield recharger booster","nameShort":"Shield recharge booster","description":"+25% shield regeneration speed; This booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_6_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SREG+B01","item_caption":"Shield+recharge+booster","item_prefix":"booster","item_id":6,"item_cv":"5fc3dddcbd5e0061ca960536aaed7100","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_sreg-b01","useDeviceFonts":0,"booster_icon_cv":"ebb98aa99913e72f63932beffdea3b00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/sreg-b01_100x100.png?__cv=c35ebd4e97ee5e41d68a4cb7cd8ca400","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"7":{"category":"booster","name":"Resource booster","nameShort":"Resource booster","description":"The resource booster increases the number of resources from collected NPC cargo boxes by 25%. Booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_7_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"RES-B01","item_caption":"Resource+booster","item_prefix":"booster","item_id":7,"item_cv":"c047d9fd3e8a8f04330429aaf7b3b700","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_res-b01","useDeviceFonts":0,"booster_icon_cv":"c7b49bf713681eadb31abfdb37060700"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/res-b01_100x100.png?__cv=577f2d441bcc710387f87c74237a9700","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"8":{"category":"booster","name":"Hit point booster","nameShort":"Hit point booster","description":"+10% ship HP; This booster is active for 10 hours from the time of purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_8_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"HP-B01","item_caption":"Hit+point+booster","item_prefix":"booster","item_id":8,"item_cv":"f84a0b97e692c97f5cd21020550c3c00","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_hp-b01","useDeviceFonts":0,"booster_icon_cv":"027095c2bd377d4c9534f112f4bf8300"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/hp-b01_100x100.png?__cv=8a7bb216cbff9eab0963433590d1e400","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false},"21":{"category":"booster","name":"Cooldown Booster","nameShort":"Cooldown Booster","description":"20% quicker cooldown times for all ship and design skills. Booster is active for 10 hours of game time after purchase.","price":9500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=booster_21_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"CD-B01","item_caption":"Cooldown+Booster","item_prefix":"booster","item_id":21,"item_cv":"2b82295c98e1ce15f0f7e698e194e900","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"booster_cd-b01","useDeviceFonts":0,"booster_icon_cv":"2430fba4640ebffd8e820a092f31dd00"}},"itemListImageUrl":"\/do_img\/global\/items\/booster\/cd-b01_100x100.png?__cv=c7216aa63a1f0271b90174f66a5c4700","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","ten","twenty","max"],"maxAmount":30,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":"-5%","discountTooltipText":null,"isPaymentItem":false,"canBeSubscribedTo":true,"isSubscriptionRunning":false,"isSubscriptionPaused":false,"nextBooking":"","countdown":"","isMultiboosterPackage":false,"isEventBooster":false,"userHasBoosterPackage":false,"isOnlyForShow":false,"isLevelSetable":false}},
        numItems        : 9,
        startupItemId   : '1',
        userDroneAmount : 0,
        maxDroneAmount  : 10,
        language        : 'en'
    };

     User.Parameters = {"balance":{"uridium":<?php echo $Users->DataRow['uri']; ?>,"credits":<?php echo $Users->DataRow['credits']; ?>},"discountFactor":1,"language":"en","ship":{"laserAmmunitionSpace":3420,"rocketSpace":100},"isActiveHangarEmpty":false,"isShipDumpEmpty":true,"pet":{"hasPet":false,"level":0,"fuel":0,"maxFuel":0}};

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
