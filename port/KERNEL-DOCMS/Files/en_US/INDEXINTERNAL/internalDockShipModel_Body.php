</head>
<body class="internalDockShop_model" onLoad="" >
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
            <div class="subNavEventIcon"></div>        </div>
      
        <div  id="subNavDesigns" class="subNavButtonDesigns subNavButtonActive" onmouseover="subNavRollover('subNavDesigns')" onmouseout="subNavRollover('subNavDesigns')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockShipModel"><div class="subNavTextActiveDesigns"></div></a>
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/bigboy/design/solemn_100x100.png?__cv=483fd686eb35a54b94b5896f1158a700);">
                            <a id="ship_bigboy_design_solemn" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>150,000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/vengeance/design/adept_100x100.png?__cv=70e087e02264296ae8a18b13c9421100);">
                            <a id="ship_vengeance_design_adept" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/vengeance/design/avenger_100x100.png?__cv=5525de2911fbb31c1b7d6ade089f0f00);">
                            <a id="ship_vengeance_design_avenger" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/vengeance/design/corsair_100x100.png?__cv=fdb5d76fec778ab933511af5c45a8e00);">
                            <a id="ship_vengeance_design_corsair" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/vengeance/design/revenge_100x100.png?__cv=e9a8ca46debcaaa99c533ac3a6728900);">
                            <a id="ship_vengeance_design_revenge" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/vengeance/design/lightning_100x100.png?__cv=a8f63bb998c50d36cfa4c4e03b1c4d00);">
                            <a id="ship_vengeance_design_lightning" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/package/d-har_100x100.gif?__cv=6ba6bea987a91dfcb4cbeece6bc28000);">
                            <a id="package_d-har" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>Payment</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/amber_100x100.png?__cv=012a14d507f20dfab1d65f33eff38900);">
                            <a id="ship_goliath_design_amber" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>40,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/crimson_100x100.png?__cv=2e949eba817453a0f3c1ce72de781000);">
                            <a id="ship_goliath_design_crimson" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>40,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/jade_100x100.png?__cv=818e123d12a61938bfeebebd65bc3600);">
                            <a id="ship_goliath_design_jade" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>40,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/sapphire_100x100.png?__cv=0ca01b887ffa464f1c21c731d99f9e00);">
                            <a id="ship_goliath_design_sapphire" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>40,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/bastion_100x100.png?__cv=e934df028791f9eac43b2e3b60de3100);">
                            <a id="ship_goliath_design_bastion" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/enforcer_100x100.png?__cv=8b447eee59e1500e4367eba7578b0300);">
                            <a id="ship_goliath_design_enforcer" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/exalted_100x100.png?__cv=88044e52b74d1062a9a38e596e465400);">
                            <a id="ship_goliath_design_exalted" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/veteran_100x100.png?__cv=81a16a8cd2cddfdc3c82af51990d8700);">
                            <a id="ship_goliath_design_veteran" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/diminisher_100x100.png?__cv=f981e84575292b34e18f0a03df235000);">
                            <a id="ship_goliath_design_diminisher" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/sentinel_100x100.png?__cv=f34f8253592a74a52c37bf4962a3d100);">
                            <a id="ship_goliath_design_sentinel" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/solace_100x100.png?__cv=1f2e50beede5485d5852a2fb64d3df00);">
                            <a id="ship_goliath_design_solace" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/spectrum_100x100.png?__cv=35f4bb3311c6b4aa47a16fd180008900);">
                            <a id="ship_goliath_design_spectrum" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/venom_100x100.png?__cv=2d89b696366df9a1559dc8d702d08f00);">
                            <a id="ship_goliath_design_venom" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250,000 U.</strong>
                        </div>
                    </div>

                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath/design/g-champion-turkey_100x100.png?__cv=2d89b6965436df9a1559dc8d702d08f00);">
                            <a id="ship_goliath_design_turkey" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250,000 U.</strong>
                        </div>
                    </div>

                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/package/sd-all_100x100.gif?__cv=ad245593aad013c7c8fd93add4527700);">
                            <a id="package_sd-all" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>Payment</strong>
                        </div>
                    </div>
                                    <!-- <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/spearhead/design/spearhead-elite-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=7d44479dfa2a8696210e59472302e100);">
                            <a id="ship_spearhead_design_spearhead-elite" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/spearhead/design/spearhead-superelite-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=df1f46315a90a503e85a01b22c633600);">
                            <a id="ship_spearhead_design_spearhead-superelite" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>200,000 U.</strong>
                        </div>
                    </div> 
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/aegis/design/aegis-elite-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=787ee558f50206a973e4d4f29f816200);">
                            <a id="ship_aegis_design_aegis-elite" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/aegis/design/aegis-superelite-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=82383eed9ec66d6d3e35bd49ecc47900);">
                            <a id="ship_aegis_design_aegis-superelite" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>200,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/citadel/design/citadel-elite-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=3eee100229ba0cf7f35bde774888cd00);">
                            <a id="ship_citadel_design_citadel-elite" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>100,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/citadel/design/citadel-superelite-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=beed6fa6d6bf195d7579738cf3fecc00);">
                            <a id="ship_citadel_design_citadel-superelite" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>200,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/package/cd-all-el-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.gif?__cv=b7e12ebcbdd1ea2c3c8dda34f3aace00);">
                            <a id="package_cd-all-el-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>Payment</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/package/cd-all-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.gif?__cv=d4c5c215908e9eced03d1b317fff5200);">
                            <a id="package_cd-all-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>Payment</strong>
                        </div> 

                    </div>-->
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
                <div id="buy_button_text" style='background-image: url("/do_img/global/text_tf.esg?l=en&s=14&t=shop_buy&f=eurostyle_thea&color=white&bgcolor=grey");'></div>
            </div>
            
            <div id="subscription_button" class="purchase">
                <div id="start" style="background-image:url(/do_img/global/text_tf.esg?l=en&s=14&t=booster_subscribe&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
                <div id="stop" style="background-image:url(/do_img/global/text_tf.esg?l=en&s=14&t=booster_subscription_cancel&f=eurostyle_thea&color=white&bgcolor=grey&auto_br=1&auto_br_size=11);"></div>
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
    <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>EBBC D <br>6 D route de Trèves<br>L-2633 Senningerberg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jochen Siegert<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 26337827<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 263 4651<br>Fax: +352 26 34 6590<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support" target="_blank">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
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


    


    
     
           
        </a>
        
            <div class="twitter"></div>
        </a>
        <a href="http://www.youtube.com/user/darkorbithq" target="_blank">
            <div class="youtube"></div>
        </a>

        <div class="left"></div>
        <div class="content">
            <div>FOLLOW US ON</div>
        </div>
        <div class="right"></div>
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
        category        : 'model',
        paymentLink     : 'indexInternal.es?action=internalPayment',
        itemRows        : [],
        itemData        : {"ship_bigboy_design_solemn":{"category":"model","name":"Solemn","nameShort":"DESIGN","description":"The Solemn Design for the Bigboy gives you a 10% bonus on all experience points gained!","price":150000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_126_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"D-SO-01","item_caption":"DESIGN","item_prefix":"model","item_id":126,"item_cv":"970b1998b15887d6073513b2d3bc2100","price_plain":"150,000 C.","event_item_enabled":0,"loot_id":"ship_bigboy_design_solemn"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/bigboy\/design\/solemn_100x100.png?__cv=483fd686eb35a54b94b5896f1158a700","cost":"150,000 C.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_bigboy","isPackage":false},"ship_vengeance_design_adept":{"category":"model","name":"Adept","nameShort":"DESIGN","description":"Looking for more experience points? Then get the new Adept design. It'll give you a 10% bonus on all experience points gained in the game!<br><br>Fly around in this slick design and watch your enemies die with envy!","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_16_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-AD-01","item_caption":"DESIGN","item_prefix":"model","item_id":16,"item_cv":"bb76eef5dd195a3d7536f92834dba500","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_vengeance_design_adept"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/vengeance\/design\/adept_100x100.png?__cv=70e087e02264296ae8a18b13c9421100","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_vengeance","isPackage":false},"ship_vengeance_design_avenger":{"category":"model","name":"Avenger","nameShort":"DESIGN","description":"The Avenger design's 10% extra shield power makes it a must-have in every space battle.","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_60_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-AV-01","item_caption":"DESIGN","item_prefix":"model","item_id":60,"item_cv":"e9c00bed74eb837b2767f38a62217600","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_vengeance_design_avenger"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/vengeance\/design\/avenger_100x100.png?__cv=5525de2911fbb31c1b7d6ade089f0f00","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_vengeance","isPackage":false},"ship_vengeance_design_corsair":{"category":"model","name":"Corsair","nameShort":"DESIGN","description":"Honor to whom honor is due! The impressive Corsair design awards you with an extra 10% honor points earned in the game.<br><br>Earn your just reward for your heroism and get this design.","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_17_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-CO-01","item_caption":"DESIGN","item_prefix":"model","item_id":17,"item_cv":"70cbc5205de2774754e2f374a63fb000","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_vengeance_design_corsair"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/vengeance\/design\/corsair_100x100.png?__cv=fdb5d76fec778ab933511af5c45a8e00","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_vengeance","isPackage":false},"ship_vengeance_design_revenge":{"category":"model","name":"Revenge","nameShort":"DESIGN","description":"Thanks to its 5% damage bonus, you can count on the Revenge Vengeance design to deal the death blow in any encounter - the kind of advantage that can truly make a difference. This is your best bet for counterattacks on enemy clans or quick alien kills.","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_58_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-RE-01","item_caption":"DESIGN","item_prefix":"model","item_id":58,"item_cv":"bdfaf78bf9e316d18064fe7d01c88200","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_vengeance_design_revenge"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/vengeance\/design\/revenge_100x100.png?__cv=e9a8ca46debcaaa99c533ac3a6728900","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_vengeance","isPackage":false},"ship_vengeance_design_lightning":{"category":"model","name":"Lightning","nameShort":"SKILL DESIGN","description":"This design will let you dish out 5% more damage and completely change the look of your Vengeance Starfighter. It will also give you the unique \"Afterburner\" ability which you can use to boost your ship's speed by 30% for a period of five seconds!<br><br>","price":250000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_18_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SD-LI-01","item_caption":"SKILL+DESIGN","item_prefix":"model","item_id":18,"item_cv":"5a258142f1bcd6514b10751b868f5800","price_plain":"250,000 U.","event_item_enabled":0,"loot_id":"ship_vengeance_design_lightning"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/vengeance\/design\/lightning_100x100.png?__cv=a8f63bb998c50d36cfa4c4e03b1c4d00","cost":"250,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_vengeance","isPackage":false},"package_d-har":{"category":"design","name":"D-HAR","nameShort":"D-HAR","description":"<strong>Harvest Design Pack<\/strong><br><br>This pack will get you the following designs for your Vengeance:<br><br>1 Adept (10% XP bonus)<br><br>1 Corsair (10% honor bonus)","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=items_ship_designpackage_D-HAR&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-HAR","item_caption":"DESIGN","item_prefix":"model","item_id":16,"item_cv":"bb76eef5dd195a3d7536f92834dba500","price_plain":"Payment","event_item_enabled":0,"loot_id":"ship_vengeance_design_adept"}},"itemListImageUrl":"\/do_img\/global\/items\/package\/d-har_100x100.gif?__cv=6ba6bea987a91dfcb4cbeece6bc28000","cost":"Payment","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":true,"affiliation":"ship_vengeance","paymentUrl":"\/?action=internalPaymentProxy&req=f9518ec324a2f9f12ad1b97ffed83c85d525e4a670dad4173628bbc3cf0badb5f0114f8fb94d11449977ea576a67620f585e72d82cf1f7ad&v=f2aba7e39ff54305","type":"package_d-har","isPackage":true},"ship_goliath_design_amber":{"category":"model","name":"Amber","nameShort":"DESIGN","description":"A special design for the Goliath. You can only use it if you already own a Goliath. ","price":40000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_52_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-AM-01","item_caption":"DESIGN","item_prefix":"model","item_id":52,"item_cv":"1ad2d9509e45b7b29c81c7ba663bc400","price_plain":"40,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_amber"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/amber_100x100.png?__cv=012a14d507f20dfab1d65f33eff38900","cost":"40,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_crimson":{"category":"model","name":"Crimson","nameShort":"DESIGN","description":"A special design for the Goliath. You can only use it if you already own a Goliath.","price":40000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_53_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-CR-01","item_caption":"DESIGN","item_prefix":"model","item_id":53,"item_cv":"151e87450e0f4bd125ce245803be2700","price_plain":"40,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_crimson"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/crimson_100x100.png?__cv=2e949eba817453a0f3c1ce72de781000","cost":"40,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_jade":{"category":"model","name":"Jade","nameShort":"DESIGN","description":"A special design for the Goliath. You can only use it if you already own a Goliath.","price":40000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_19_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-JA-01","item_caption":"DESIGN","item_prefix":"model","item_id":19,"item_cv":"b8e4acfae8242011a5380a39b5562400","price_plain":"40,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_jade"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/jade_100x100.png?__cv=818e123d12a61938bfeebebd65bc3600","cost":"40,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_sapphire":{"category":"model","name":"Sapphire","nameShort":"DESIGN","description":"A special design for the Goliath. You can only use it if you already own a Goliath.","price":40000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_54_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-SA-01","item_caption":"DESIGN","item_prefix":"model","item_id":54,"item_cv":"0752707429320a108503b63b48437000","price_plain":"40,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_sapphire"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/sapphire_100x100.png?__cv=0ca01b887ffa464f1c21c731d99f9e00","cost":"40,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_bastion":{"category":"model","name":"Bastion","nameShort":"DESIGN","description":"Thanks to its 10% shield strength bonus, the Bastion design is the perfect defense in every combat situation. Even the most powerful enemies and aliens will have a hard time taking you down.","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_59_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-BA-01","item_caption":"DESIGN","item_prefix":"model","item_id":59,"item_cv":"a88446eb29904707f11e7874c534a700","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_bastion"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/bastion_100x100.png?__cv=e934df028791f9eac43b2e3b60de3100","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_enforcer":{"category":"model","name":"Enforcer","nameShort":"DESIGN","description":"A 5% damage bonus makes the Enforcer Goliath design a force to be reckoned with and a must for every clan. Its destructive power is revolutionizing the art of warfare - it'll strike terror into the hearts of enemy clans and aliens.","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_56_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-EF-01","item_caption":"DESIGN","item_prefix":"model","item_id":56,"item_cv":"7d394a717d68d108ee9550c632444100","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_enforcer"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/enforcer_100x100.png?__cv=8b447eee59e1500e4367eba7578b0300","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_exalted":{"category":"model","name":"Exalted","nameShort":"DESIGN","description":"This new red design will win you 10% more honor points while striking fear into the hearts of your enemies.","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_62_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-EX-01","item_caption":"DESIGN","item_prefix":"model","item_id":62,"item_cv":"5fc51ad6b6373cd8069ee1b6c48bb600","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_exalted"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/exalted_100x100.png?__cv=88044e52b74d1062a9a38e596e465400","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_veteran":{"category":"model","name":"Veteran","nameShort":"DESIGN","description":"A sleek and glossy white design. It'll grant you a 10% bonus on all the experience points you collect!","price":100000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_61_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"D-VE-01","item_caption":"DESIGN","item_prefix":"model","item_id":61,"item_cv":"626251e80d97a4be26107c4b7957e400","price_plain":"100,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_veteran"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/veteran_100x100.png?__cv=81a16a8cd2cddfdc3c82af51990d8700","cost":"100,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_diminisher":{"category":"model","name":"Diminisher","nameShort":"SKILL DESIGN","description":"This design will transform your Goliath Battlecruiser: its \"weaken shield\" reduces your enemies' defensive capabilities, and you will inflict an extra 5% damage.","price":250000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_64_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SD-DI-01","item_caption":"SKILL+DESIGN","item_prefix":"model","item_id":64,"item_cv":"0f15061249c55faf165df753d984a300","price_plain":"250,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_diminisher"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/diminisher_100x100.png?__cv=f981e84575292b34e18f0a03df235000","cost":"250,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_sentinel":{"category":"model","name":"Sentinel","nameShort":"SKILL DESIGN","description":"Give your Goliath Battlecruiser a futuristic new look with the Sentinel design. Its \"fortress\" capability will give your shields a massive power boost, and you'll also benefit from a 10% shield bonus.","price":250000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_66_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SD-SE-01","item_caption":"SKILL+DESIGN","item_prefix":"model","item_id":66,"item_cv":"9e4d8af69c3deacb5b710b59b502c900","price_plain":"250,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_sentinel"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/sentinel_100x100.png?__cv=f34f8253592a74a52c37bf4962a3d100","cost":"250,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_solace":{"category":"model","name":"Solace","nameShort":"SKILL DESIGN","description":"This design not only gives your Goliath Battlecruiser a completely new look but it also lets you repair your ship hull and the hulls of group members immediately with the \"Nano-Cluster Repairer\". It also increases your shield power by 10%.","price":250000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_63_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SD-SO-01","item_caption":"SKILL+DESIGN","item_prefix":"model","item_id":63,"item_cv":"5caefbca3e4559c5102de69b759ca500","price_plain":"250,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_solace"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/solace_100x100.png?__cv=1f2e50beede5485d5852a2fb64d3df00","cost":"250,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},"ship_goliath_design_spectrum":{"category":"model","name":"Spectrum","nameShort":"SKILL DESIGN","description":"Change the look of your Goliath Battlecruiser and render enemy laser attacks almost useless with this design's \"prismatic shielding\" capability. It'll also temporarily weaken your own lasers, but give you 10% more shield power in return.","price":250000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_65_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SD-SP-01","item_caption":"SKILL+DESIGN","item_prefix":"model","item_id":65,"item_cv":"95ff1a7b251ed0e501194f6acce57f00","price_plain":"250,000 U.","event_item_enabled":0,"loot_id":"ship_goliath_design_spectrum"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/spectrum_100x100.png?__cv=35f4bb3311c6b4aa47a16fd180008900","cost":"250,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"type":"ship_goliath","isPackage":false},
        
        "ship_goliath_design_venom":{
"category":"model",
"name":"Venom",
"nameShort":"SKILL DESIGN",
"description":"Breathe life into your Goliath Battlecruiser with this brand-new design. It'll give your ship a 5% damage bonus and its singularity function will give you a massive damage boost temporarily.",
"price":250000,
"currency":"real",
"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=model_67_code&f=eurostyle_thea&color=white&bgcolor=grey",
"flash":{
"parameters":{
"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800",
"version":[
10,
0
],
"id":"shopdetails",
"width":"253",
"height":"206",
"wmode":"transparent",
"bgColor":"schwarz",
"allowScriptAccess":"always"
},
"variables":{
"cdn":"http:\/\/<?php echo DynHost; ?>\/",
"elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00",
"background_cv":"5a3549d51b64b3301a596e7197760500",
"limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200",
"limited_std_icon_cv":"506294ad55b3114581a227681644e200",
"elite":1,
"item_name":"SD-VE-01",
"item_caption":"SKILL+DESIGN",
"item_prefix":"model",
"item_id":67,
"item_cv":"8837686ff4f772b999803fb3fdf71100",
"price_plain":"250,000 U.",
"event_item_enabled":0,
"loot_id":"ship_goliath_design_venom"
}
},
"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath\/design\/venom_100x100.png?__cv=2d89b696366df9a1559dc8d702d08f00",
"cost":"250,000 U.",
"isAmountSetable":false,
"amountsSelectable":[
"ten",
"hundred",
"thousand",
"max"
],
"maxAmount":1,
"isConsumingCargoSpace":false,
"isActiveEventItem":false,
"requiresShipInActiveHangar":false,
"discountPercent":null,
"discountTooltipText":null,
"isPaymentItem":false,
"type":"ship_goliath",
"isPackage":false
},

        "ship_goliath_design_turkey":{
"category":"model",
"name":"Turkey",
"nameShort":"Turkey-design",
"description":"<strong>Turkey G-Champion<\/strong><br><br>Bir şampiyonun kalbine sahipsin! İnsanlığın heyecan verici geçmişinden duyduğun gururu göster ve Goliath'ını atalarımızdan ilham alan parlak bir tasarımla süsle! Yaşasın Türkiye!",
"price":250000,
"currency":"real",
"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=items_ship_designpackage_D-ALL&f=eurostyle_thea&color=white&bgcolor=grey",
"flash":{
"parameters":{
"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800",
"version":[
10,
0
],
"id":"shopdetails",
"width":"253",
"height":"206",
"wmode":"transparent",
"bgColor":"schwarz",
"allowScriptAccess":"always"
},
"variables":{
"cdn":"http:\/\/<?php echo DynHost; ?>\/",
"elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00",
"background_cv":"5a3549d51b64b3301a596e7197760500",
"limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200",
"limited_std_icon_cv":"506294ad55b3114581a227681644e200",
"elite":1,
"item_name":"TURKEY",
"item_caption":"DESIGN",
"item_prefix":"model",
"item_id":120,
"item_cv":"5fc51ad6b6373cd8069ee1b6c48bb600",
"price_plain":"250,000 U.",
"event_item_enabled":1,
"loot_id":"ship_goliath_design_turkey"
}
},
"itemListImageUrl":"\/do_img\/global\/items\/package\/d-all_100x100.gif?__cv=ca75b23a9a9ffdde2d11d7a265a54e00",
"cost":"Payment",
"isAmountSetable":false,
"amountsSelectable":[
"ten",
"hundred",
"thousand",
"max"
],
"maxAmount":1,
"isConsumingCargoSpace":false,
"isActiveEventItem":false,
"requiresShipInActiveHangar":false,
"discountPercent":null,
"discountTooltipText":null,
"isPaymentItem":false,
"type":"ship_goliath",
"isPackage":false
}

        ,"package_sd-all":{"category":"design","name":"SD-ALL","nameShort":"SD-ALL","description":"<strong>Special Design Pack<\/strong><br><br>Buy this pack and get the following Skill Designs for your Goliath:<br><br>1 Solace (immediate ship hull repairs and 10% shield power bonus)<br><br>1 Diminisher (weakens enemy shields and boosts damage by 5%)<br><br>1 Spectrum (weakens all laser attacks and provides 10% shield power bonus)<br><br>1 Sentinel (increases shield strength and boosts shield power by 10%)<br><br>1 Venom (increases damage dealt and 5% extra damage bonus)","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=items_ship_designpackage_SD-ALL&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SD-ALL","item_caption":"SKILL+DESIGN","item_prefix":"model","item_id":66,"item_cv":"9e4d8af69c3deacb5b710b59b502c900","price_plain":"Payment","event_item_enabled":0,"loot_id":"ship_goliath_design_sentinel"}},"itemListImageUrl":"\/do_img\/global\/items\/package\/sd-all_100x100.gif?__cv=ad245593aad013c7c8fd93add4527700","cost":"Payment","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":true,"affiliation":"ship_goliath","paymentUrl":"\/?action=internalPaymentProxy&req=a53e3415906e6b77526bf55107754d5294ac1ac67267420e0248f9f40c6b43452ebde238bf512bf792d016623c4af92614326f3f46d6b679&v=9766cd6d34fbe523","type":"package_sd-all","isPackage":true}},
        numItems        : 22,
        startupItemId   : 'ship_bigboy_design_solemn',
        userDroneAmount : <?php echo $base->currentDrones($Users->DataRow['ID'], $Users->DataRow['playerID']); ?>,
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

