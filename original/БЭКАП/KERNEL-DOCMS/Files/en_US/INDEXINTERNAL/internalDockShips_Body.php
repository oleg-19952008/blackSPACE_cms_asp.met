</head>
<body class="internalDockShop_ship" onLoad="" >
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
                    <img src="../do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey" />
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
                            '../do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey'
                         );">
                    </div>
                </div>
                <div class="popup_shop_abort_button">
                    <div class="popup_shop_abort_text"
                         style="background-image: url(
                            '../do_img/global/text_tf.esg?l=us&s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey'
                         );"
                         onclick="closeInfoLayer();">
                    </div>
                </div>
            </div>

            <div id="infoLayerInfo">
                <div class="popup_shop_close_button">
                    <div class="popup_shop_close_text"
                         style='background-image: url("../do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey");'
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

        <div id="subNavShip" class="subNavButtonShip subNavButtonActive" onmouseover="subNavRollover('subNavShip')" onmouseout="subNavRollover('subNavShip')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockShips"><div class="subNavTextActiveShip"></div></a>
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
        <div id="subNavPetGears" class="subNavButtonPetGears subNavButtonInactive" onmouseover="subNavRollover('subNavPetGears')" onmouseout="subNavRollover('subNavPetGears')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockPetGear"><div class="subNavTextInactivePetGears"></div></a>
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

        <ul>
            <li title="Naves"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockShips" style="background-image: url(https://int4.darkorbit.bigpoint.com/do_img/global/hangar/subnav_button_405x33.png?__cv=585dbec7500b7493d5c6ed734dd57000);background-position: -268px 0px;"><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_ships&f=eurostyle_clan"></a></li>
            <li title="Vehículos aéreos no tripulados"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_drones&f=eurostyle_clan"></a></li>
            <li title="Armas"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockLasers" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_weapons&f=eurostyle_clan"></a></li>
            <li title="Munición"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockAmmo" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_ammunition&f=eurostyle_clan"></a></li>
            <li title="Generators"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_generators&f=eurostyle_clan"></a></li>
            <li title="Extras"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockSpecials" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_extras&f=eurostyle_clan"></a></li>
            <li title="Potenciador"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockBooster" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_boosters&f=eurostyle_clan"></a></li>
            <li title="Diseños"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockShipModel" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_designs&f=eurostyle_clan"></a></li>
            <li title="P.E.T./MÓDULOS"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockPetGear" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_pet_gear&f=eurostyle_clan"></a></li>
            <li title="PROTOCOLOS IA"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockPetProtocols" ><img src="https://int4.darkorbit.bigpoint.com/do_img/global/nav_left.esg?s=10&locale=en&lang=en&t=nav_sub1_hangar_pet_protocols&f=eurostyle_clan"></a></li>
        </ul>
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/hangar/slot_100x100.png?__cv=4103cd5f4ead22d15ffa746e06a99300);">
                            <a id="hangar_slot" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>50.000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/phoenix_100x100.png?__cv=c8fdab3ed091595e5a4d122ef33eee00);">
                            <a id="1" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>0 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/leonov_100x100.png?__cv=514e12b1ca5c27a22b6ef646fb9b8a00);">
                            <a id="3" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15.000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/liberator_100x100.png?__cv=12811c57da5f73380b089c37aebde700);">
                            <a id="5" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>40.000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/piranha_100x100.png?__cv=dafebc613914a8d39de7740bf987f800);">
                            <a id="6" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>125.000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/vengeance_100x100.png?__cv=0c54de458c43424b804b155068265600);">
                            <a id="8" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>30.000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/bigboy_100x100.png?__cv=47451983296c2b3216aa523e944ced00);">
                            <a id="9" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>200.000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/goliath_100x100.png?__cv=5fcdb83e69b401d92cc1ae6abb172300);">
                            <a id="10" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>80.000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/citadel-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=d43662ca1a65a25f5f9ce73f10e44000);">
                            <a id="11" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>300.000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/aegis-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=89907c440812462e67ad63192d91b700);">
                            <a id="12" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>250.000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ship/spearhead-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=12de6f44a46e0c64accde5398ba25f00);">
                            <a id="13" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>45.000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/package/s-trinity-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=0058552692b26643098082e055975100);">
                            <a id="packages" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>Pago</strong>
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
                <div class="label">Nivel:</div>
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
                <div class="label">Cantidad</div>
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
                <label for="itemName">Nombre de P.E.T.</label>
                <input type="text" id="itemName" name="itemName" value="" maxlength="16" />
            </div>

            <div id="discount"></div>

            <div id="buy_price">
                <input type="hidden" id="itemPrice" name="itemPrice" value="">
                <input type="text" id="sellPrice" name="sellPrice" readonly="readonly" value="">
            </div>
            <div id="buy_button" class="purchase">
                <div id="buy_button_text" style='background-image: url("./do_img/global/text_tf.esg?l=us&s=14&t=shop_buy&f=eurostyle_thea&color=white&bgcolor=grey");'></div>
            </div>
            
            <div id="subscription_button" class="purchase">
                <div id="start" style="background-image:url(./do_img/global/text_tf.esg?l=us&s=14&t=booster_subscribe&f=eurostyle_thea&color=white&bgcolor=grey);"></div>
                <div id="stop" style="background-image:url(./do_img/global/text_tf.esg?l=us&s=14&t=booster_subscription_cancel&f=eurostyle_thea&color=white&bgcolor=grey&auto_br=1&auto_br_size=11);"></div>
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
    <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>Building Vertigo - Polaris<br>2-4 rue Eugène Ruppert<br>L-2453 Luxemburg<br><br><b>Nuestro portal de negocios</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Datos comerciales</b><br>Gerente: Bigpoint S.à.r.l.<br>Jeronimo Folgueira<br>Registro comercial: R.C.S. Luxemburg<br>Número de registro: B 167809<br>Número de identificación a efectos del impuesto sobre el valor añadido (IVA): LU 25331016<br><br><b>Aviso de responsabilidad</b><br>A pesar del cuidadoso control sobre el contenido, no tomamos ninguna responsabilidad sobre enlaces externos. Del contenido de estos enlaces son responsables sus propietarios.<br><br><b>Contacto</b><br>Teléfono <b>(Ningún soporte)</b>: +352 261 911 3515<br>Fax : +352 49 48 48 6606<br><br><b>En caso de preguntas y problemas - nuestro soporte</b><br>Email: <a class="gl_imprint_support_link" href="/index.es?action=support">Al formulario de soporte</a><br>Internet: http://www.bigpoint.com<br><br><b>EnCargodo de protección de menores</b><br>Abogado Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>Email: jugendschutzbeauftragter@bigpoint.com<br><br><b>EnCargodo de protección de datos</b><br>Email: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Declaración sobre protección de datos</a></div>
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
                Aviso legal</a> |
                <a href="javascript:void(0);" onclick="showFooterLayer('teamCreditsBox')">Créditos</a> |
        <a href="/GameAPI.php?action=portal.redirectToBoard" target="_blank">Foro</a>
    </div>


    


    
        <a href="http://www.facebook.com/darkorbit" target="_blank">
           
        </a>
        
            <div class="twitter"></div>
        </a>
        <a href="http://www.youtube.com/user/darkorbithq" target="_blank">
            <div class="youtube"></div>
        </a>

        <div class="left"></div>
        <div class="content">
            <div>SÍGUENOS EN</div>
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
        category        : 'ship',
        paymentLink     : 'indexInternal.es?action=internalPayment',
        itemRows        : [],
        itemData        : {"hangar_slot":{"category":"hangar","name":"HH-X","nameShort":"HANGAR EXPANSION","description":"With a hangar hall, you can quickly switch ships while at homebase or even when logged out. <li>You may expand your hangar to include up to <b>10 HH-X<\/b>.<\/li>","price":50000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=items_hangar_slot_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"HH-X","item_caption":"HANGAR+EXPANSION","item_prefix":"hangar","item_id":999,"item_cv":"6a223b5a5ffe8ad1bb7798e0e085c100","price_plain":"50,000 U.","event_item_enabled":0,"loot_id":"hangar_slot"}},"itemListImageUrl":"\/do_img\/global\/items\/hangar\/slot_100x100.png?__cv=4103cd5f4ead22d15ffa746e06a99300","cost":"50,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isHangar":true},"1":{"category":"ship","name":"Phoenix","nameShort":"STARJET","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"\" class=\"odd\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"even\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t320\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"odd\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t100\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"even\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t1\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"odd\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t1\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"even\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t2,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"odd\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t4,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"even\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t100\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t1\n        <\/td>\n            <\/tr>\n<\/table>","price":0,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_1_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"PHOENIX","item_caption":"STARJET","item_prefix":"ship","item_id":1,"item_cv":"e5af3fecf3774c43b0305388597b1e00","price_plain":"0 C.","event_item_enabled":0,"loot_id":"ship_phoenix","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/phoenix_100x100.png?__cv=c8fdab3ed091595e5a4d122ef33eee00","cost":"0 C.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"3":{"category":"ship","name":"Leonov","nameShort":"STARJET","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = 'Comprises all maps except the home maps.';\nheader_ttips['leonov_shop_homemaps']  = 'Comprises maps 3-1 to 3-4';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            Standard\n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        Home maps\n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"odd\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t360\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t380\n\t        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"even\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t500\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t1,000\n\t        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"odd\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t6\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t6\n\t        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"even\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t6\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t6\n\t        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"odd\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t6,000\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t6,000\n\t        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"even\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t64,000\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t160,000\n\t        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"odd\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t300\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t300\n\t        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t1\n        <\/td>\n        \t        <td class=\"secondColumn\">\n\t        \t1\n\t        <\/td>\n            <\/tr>\n<\/table>","price":15000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_3_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"LEONOV","item_caption":"STARJET","item_prefix":"ship","item_id":3,"item_cv":"a98106a09c00aec081980629e197d700","price_plain":"15,000 U.","event_item_enabled":0,"loot_id":"ship_leonov"}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/leonov_100x100.png?__cv=514e12b1ca5c27a22b6ef646fb9b8a00","cost":"15,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"5":{"category":"ship","name":"Liberator","nameShort":"STARFIGHTER","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"even\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t300\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"odd\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t400\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"even\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t4\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"odd\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t6\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"even\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t10,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"odd\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t16,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"even\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t500\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t2\n        <\/td>\n            <\/tr>\n<\/table>","price":40000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_5_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"LIBERATOR","item_caption":"STARFIGHTER","item_prefix":"ship","item_id":5,"item_cv":"7e4e9588a88f7760ac921f975a585e00","price_plain":"40,000 C.","event_item_enabled":0,"loot_id":"ship_liberator","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/liberator_100x100.png?__cv=12811c57da5f73380b089c37aebde700","cost":"40,000 C.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"6":{"category":"ship","name":"Piranha","nameShort":"STARFIGHTER","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"odd\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t360\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"even\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t600\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"odd\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t6\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"even\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t8\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"odd\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t14,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"even\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t64,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"odd\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t700\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t2\n        <\/td>\n            <\/tr>\n<\/table>","price":100000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_6_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"PIRANHA","item_caption":"STARFIGHTER","item_prefix":"ship","item_id":6,"item_cv":"e4c4f3aa661d8bd0bc812f2e97398e00","price_plain":"100,000 C.","event_item_enabled":0,"loot_id":"ship_piranha","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/piranha_100x100.png?__cv=85ddcda1cc2881c3280990d393276900","cost":"100,000 C.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"7":{"category":"ship","name":"Nostromo","nameShort":"STARFIGHTER","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"even\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t340\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"odd\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t700\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"even\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t7\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"odd\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t10\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"even\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t16,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"odd\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t120,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"even\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t800\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t3\n        <\/td>\n            <\/tr>\n<\/table>","price":195000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_7_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"NOSTROMO","item_caption":"STARFIGHTER","item_prefix":"ship","item_id":7,"item_cv":"9e1c9d7271b27cdaa9f51acc03ca8d00","price_plain":"195,000 C.","event_item_enabled":0,"loot_id":"ship_nostromo","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/nostromo_100x100.png?__cv=c32fd5c4ba7687cabdfd8e592f6e6800","cost":"195,000 C.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"8":{"category":"ship","name":"Vengeance","nameShort":"STARFIGHTER","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"odd\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t380\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"even\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t1,000\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"odd\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t10\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"even\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t10\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"odd\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t16,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"even\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t180,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"odd\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t800\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t2\n        <\/td>\n            <\/tr>\n<\/table>","price":30000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_8_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"VENGEANCE","item_caption":"STARFIGHTER","item_prefix":"ship","item_id":8,"item_cv":"2e224af24fe98c952b2d2bdd7693c300","price_plain":"30,000 U.","event_item_enabled":0,"loot_id":"ship_vengeance","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/vengeance_100x100.png?__cv=0c54de458c43424b804b155068265600","cost":"30,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"9":{"category":"ship","name":"Bigboy","nameShort":"BATTLECRUISER","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"even\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t260\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"odd\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t800\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"even\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t8\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"odd\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t15\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"even\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t18,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"odd\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t160,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"even\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t900\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t3\n        <\/td>\n            <\/tr>\n<\/table>","price":285000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_9_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"BIGBOY","item_caption":"BATTLECRUISER","item_prefix":"ship","item_id":9,"item_cv":"3e22dcac54e466da95ab41ba1c31aa00","price_plain":"285,000 C.","event_item_enabled":0,"loot_id":"ship_bigboy","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/bigboy_100x100.png?__cv=83a1972757221718f8051aa2dcbd3a00","cost":"285,000 C.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"10":{"category":"ship","name":"Goliath","nameShort":"BATTLECRUISER","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n\n    <tr id=\"speed\" class=\"odd\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t300\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"even\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t1,500\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"odd\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t15\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"even\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t15\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"odd\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t32,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"even\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t256,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"odd\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t1,600\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t3\n        <\/td>\n            <\/tr>\n<\/table>","price":80000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_10_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"GOLIATH","item_caption":"BATTLECRUISER","item_prefix":"ship","item_id":10,"item_cv":"b478c5653d98a43a9604243bdf829500","price_plain":"80,000 U.","event_item_enabled":0,"loot_id":"ship_goliath","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/goliath_100x100.png?__cv=5fcdb83e69b401d92cc1ae6abb172300","cost":"80,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"12":{"category":"ship","name":"Aegis","nameShort":"ENGINEERING VESSEL","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n    <strong>Aegis<\/strong><br \/>\n    The Aegis, also known as the must-have for every battle, is a medium-duty engineering ship featuring the following abilities:\n\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_healing_beam_32x35.png?__cv=f362034055e23378c621303ad6725000);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">HP Repair<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">HP repair allows you to gradually restore the HP of allied ships.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_shield_recharge_32x35.png?__cv=95ddd104846643240ce0d733dcebc200);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Shield Repair<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This ability allows you to send new shield energy to a selected allied ship.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_healing_pod_32x35.png?__cv=070a2f785dc9a7e8c31a26c307483700);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Repair Pod<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This ability makes the Aegis ship drop a repair pod to gradually repair all allied ships in the vicinity.<\/div>\n    <\/div>\n    <br \/>\n\n    <tr id=\"speed\" class=\"even\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t300\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"odd\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t2,000\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"even\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t10\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"odd\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t15\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"even\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t15,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"odd\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t275,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"even\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t3,000\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t3\n        <\/td>\n            <\/tr>\n<\/table>","price":250000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_12_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"AEGIS","item_caption":"ENGINEERING+VESSEL","item_prefix":"ship","item_id":12,"item_cv":"c2c1625e2329d0621561b307399c2500","price_plain":"250,000 U.","event_item_enabled":0,"loot_id":"ship_aegis","factionID":"<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/aegis-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=70e9502d54588a2a852e70846adb3f00","cost":"250,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"11":{"category":"ship","name":"Citadel","nameShort":"HEAVY BATTLECRUISER","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n    <strong>Citadel<\/strong><br \/>\n    The Citadel, also known as the group's \"tank\", is a heavy-duty cruiser with two slots for rocket-launchers and the following abilities:\n\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_draw_fire_32x35.png?__cv=d68814d30de5592b467f15e1432bdd00);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Draw Fire<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This ability allows you to temporarily redirect nearby enemy fire towards your ship.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_travel_mode_32x35.png?__cv=6e378495edd9d9775a01e0c3a5a41900);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Travel<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This ability briefly increases your ship's speed, so you can quickly travel long distances.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_protect_32x35.png?__cv=038d8d948c1e31a5e423ad6396d77b00);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Protection<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This ability deploys a protective shield around your ship and redirects a portion of the damage inflicted on all nearby group members to your ship.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_fortify_32x35.png?__cv=1e5df504b5ad98e2e842e8b5c58f5500);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Fortify<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This skill fortifies your ship with protective armor and increases its resistance to damage; however, it will immobilize your ship.<\/div>\n    <\/div>\n    <br \/>\n\n    <tr id=\"speed\" class=\"odd\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t240\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"even\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t4,000\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"odd\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t7\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"even\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t20\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"odd\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t20,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"even\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t550,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"odd\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t2,000\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"even\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t5\n        <\/td>\n            <\/tr>\n<\/table>","price":300000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_11_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"CITADEL","item_caption":"HEAVY+BATTLECRUISER","item_prefix":"ship","item_id":11,"item_cv":"5610cae64e1021ec390b1171d7731700","price_plain":"300,000 U.","event_item_enabled":0,"loot_id":"ship_citadel","factionID":"<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/citadel-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=a6766e253885443ce104850894317700","cost":"300,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"13":{"category":"ship","name":"Spearhead","nameShort":"RECON SHIP","description":"<script type=\"text\/javascript\">\nvar header_ttips = new Object;\nheader_ttips['leonov_shop_standard']  = '';\nheader_ttips['leonov_shop_homemaps']  = '';\n<\/script>\n\n<table id=\"shipDetails\">\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\"><\/td>\n        <td id=\"firstColumn_leonov\" class=\"firstColumn\">\n            \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#firstColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_standard,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n        <td id=\"secondColumn_leonov\" class=\"secondColumn\">\n\t        \n            \n                <script type='text\/javascript'>\n                    jQuery(\"#secondColumn_leonov\").qtip({\n                        content: header_ttips.leonov_shop_homemaps,\n                        style:'dohdr',\n                        position:{target:'mouse'}\n                    });\n                <\/script>\n            \n        <\/td>\n    <\/tr>\n    <strong>Spearhead<\/strong><br \/>\n    The Spearhead, also known as the group's scout, is a light-duty recon ship boasting the following abilities:\n\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_ultimate_cloaking_32x35.png?__cv=0d4928bfad6c2e3b526acc1a4e875d00);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Ultimate Cloaking <\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This skill cloaks you, removes you from the minimap and prevents you from being targeted by other players.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_ultimate_emp_32x35.png?__cv=c43b72d8dcb1864e7248928a22452c00);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">JAMX<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This ability emits an interference field which paralyzes enemy ships' functions. All effects which they are currently using will be compromised.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_mark_target_32x35.png?__cv=e97b83b19759381184641ed636af6500);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Target Marker<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This ability marks targets for your group and increases the damage caused by all outfit members.<\/div>\n    <\/div>\n        <div class=\"shipDescrSkill\">\n        <div class=\"shipDescriptionSkillHeadline\" style=\"background-image: url(http:\/\/darkorbit-22.level3.bpcdn.net\/do_img\/global\/skills\/skill_icon_double_minimap_32x35.png?__cv=720c8dc4a68742e652f8a9652195c500);\">\n            <div class=\"shipDescriptionSkillHeadlineText\">Recon<\/div>\n        <\/div>\n        <div class=\"shipDescriptionSkillText\">This skill doubles your recon range on the mini map.<\/div>\n    <\/div>\n    <br \/>\n\n    <tr id=\"speed\" class=\"even\">\n        <td class=\"label\">Speed<\/td>\n        <td class=\"firstColumn\">\n        \t370\n        <\/td>\n            <\/tr>\n    <tr id=\"load\" class=\"odd\">\n        <td class=\"label\">Cargo<\/td>\n        <td class=\"firstColumn\">\n        \t500\n        <\/td>\n            <\/tr>\n    <tr id=\"laser\" class=\"even\">\n        <td class=\"label\">Lasers<\/td>\n        <td class=\"firstColumn\">\n        \t5\n        <\/td>\n            <\/tr>\n    <tr id=\"generatoren\" class=\"odd\">\n        <td class=\"label\">Generators<\/td>\n        <td class=\"firstColumn\">\n        \t12\n        <\/td>\n            <\/tr>\n    <tr id=\"batteries\" class=\"even\">\n        <td class=\"label\">Batteries<\/td>\n        <td class=\"firstColumn\">\n        \t5,000\n        <\/td>\n            <\/tr>\n    <tr id=\"hitpoints\" class=\"odd\">\n        <td class=\"label\">Hit points<\/td>\n        <td class=\"firstColumn\">\n        \t100,000\n        <\/td>\n            <\/tr>\n    <tr id=\"rockets\" class=\"even\">\n        <td class=\"label\">Rockets<\/td>\n        <td class=\"firstColumn\">\n        \t500\n        <\/td>\n            <\/tr>\n    <tr id=\"specials\" class=\"odd\">\n        <td class=\"label\">Extras<\/td>\n        <td class=\"firstColumn\">\n        \t2\n        <\/td>\n            <\/tr>\n<\/table>","price":45000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_13_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SPEARHEAD","item_caption":"RECON+SHIP","item_prefix":"ship","item_id":13,"item_cv":"9ea3002a31832af288733d9e9b000500","price_plain":"45,000 U.","event_item_enabled":0,"loot_id":"ship_spearhead","factionID":"<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>","inuse":0,"in_use_plain":""}},"itemListImageUrl":"\/do_img\/global\/items\/ship\/spearhead-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=a5c5e904c1c330b838a7b37f6dbbd500","cost":"45,000 U.","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false,"isShip":true},"packages":{"category":"ship","name":"S-TRINITY","nameShort":"PACKAGE","description":"<strong>S-TRINITY<\/strong><br>- Aegis<br>- Citadel<br>- Spearhead","price":0,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=ship_998_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/<?php echo DynHost; ?>\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"S-TRINITY","item_caption":"PACKAGE","item_prefix":"ship","item_id":"12-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>","item_cv":"c2c1625e2329d0621561b307399c2500","price_plain":"Payment","event_item_enabled":0,"loot_id":"package_s-trinity-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>"}},"itemListImageUrl":"\/do_img\/global\/items\/package\/s-trinity-<?php echo $base->currentCompany($Users->DataRow['factionId']); ?>_100x100.png?__cv=f81ff1d8603d72beb2596feb198dbd00","cost":"Payment","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":true,"paymentUrl":"\/?action=internalPaymentProxy&req=33ff9fd93085043e8c0a646699f6308c490f198a5fd6b46da390bc5d100cfc10c7e7fd98c7cd5e3cb751bc04835bae3d1910cd9cc0dfe133&v=d4f9fe0a3ea4aa4f"}},
        numItems        : 13,
        startupItemId   : '<?php echo $base->shipnum; ?>',
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