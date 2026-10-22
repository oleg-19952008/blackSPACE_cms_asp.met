</head>
<body class="internalDockShop_special" onLoad="" >
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
        <div id="subNavExtras" class="subNavButtonExtras subNavButtonActive" onmouseover="subNavRollover('subNavExtras')" onmouseout="subNavRollover('subNavExtras')">
            <a href="indexInternal.es?action=internalDock&tpl=internalDockSpecials"><div class="subNavTextActiveExtras"></div></a>
                    </div>
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/resource/logfile_100x100.png?__cv=69a613d0e4cd72e90afd6cdc68fcfb00);">
                            <a id="resource_logfile" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>300 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/resource/booty-key_100x100.png?__cv=ef618aff20a6e2bcc88d806284cfcb00);">
                            <a id="resource_booty-key" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>2,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/ajp-01_100x100.png?__cv=d4c05b61300e6f836963dd6d27bb6600);">
                            <a id="equipment_extra_cpu_ajp-01" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>75,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/repbot/rep-1_100x100.png?__cv=40bf974da2bd1ca828036a84bebf3900);">
                            <a id="equipment_extra_repbot_rep-1" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>10,000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/repbot/rep-2_100x100.png?__cv=90cbd18d53f4340e7a28254367338800);">
                            <a id="equipment_extra_repbot_rep-2" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>2,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/repbot/rep-3_100x100.png?__cv=3417fb53c3493f1d8baf68c70e8da400);">
                            <a id="equipment_extra_repbot_rep-3" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>5,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/repbot/rep-4_100x100.png?__cv=f319657ad942b61c8863b6492de48e00);">
                            <a id="equipment_extra_repbot_rep-4" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>20,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/rok-t01_100x100.png?__cv=92eb30597b6a0e5e739c25ca824c4100);">
                            <a id="equipment_extra_cpu_rok-t01" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/min-t01_100x100.png?__cv=400dcee2a5b91e04547080457ffa8900);">
                            <a id="equipment_extra_cpu_min-t01" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>5,000,000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/min-t02_100x100.png?__cv=e29b05eeb8152c061a02f425c66a7400);">
                            <a id="equipment_extra_cpu_min-t02" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>25,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/nc-rrb-x_100x100.png?__cv=862d24f30519c5e53a13f4d3ec995500);">
                            <a id="equipment_extra_cpu_nc-rrb-x" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/cl04k-xs_100x100.png?__cv=5579d611e2f505fd3317a4ee4e70ee00);">
                            <a id="equipment_extra_cpu_cl04k-xs" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>500 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/arol-x_100x100.png?__cv=30df149638e4298594447363931c9a00);">
                            <a id="equipment_extra_cpu_arol-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>25,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/cl04k-m_100x100.png?__cv=44ceb70cb4a7cfd94ec4b75708208a00);">
                            <a id="equipment_extra_cpu_cl04k-m" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>5,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/cl04k-xl_100x100.png?__cv=5378f0fbbdf4e36ee572672a89967e00);">
                            <a id="equipment_extra_cpu_cl04k-xl" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>22,500 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/nc-awb-x_100x100.png?__cv=b4df32b610682314306316c06eed2600);">
                            <a id="equipment_extra_cpu_nc-awb-x" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/nc-awr-x_100x100.png?__cv=dd4d95f1e348e27ba53a6edf5f0ae000);">
                            <a id="equipment_extra_cpu_nc-awr-x" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/nc-awl-x_100x100.png?__cv=6fdf3acc1f31b4df0c353bbcd470f400);">
                            <a id="equipment_extra_cpu_nc-awl-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/g3x-crgo-x_100x100.png?__cv=52722009436318d043bee1373878f500);">
                            <a id="equipment_extra_cpu_g3x-crgo-x" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/g3x-amry-s_100x100.png?__cv=f1f5786b7dad796b927debefcad24800);">
                            <a id="equipment_extra_cpu_g3x-amry-s" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>5,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/g3x-amry-m_100x100.png?__cv=b3287b51cb87d9da908c44fb22bc5000);">
                            <a id="equipment_extra_cpu_g3x-amry-m" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/g3x-amry-l_100x100.png?__cv=70e1d6e1de75b7db34bb8859382a2600);">
                            <a id="equipment_extra_cpu_g3x-amry-l" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>20,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/sle-01_100x100.png?__cv=99ea1c9b0f2945903e1940e185656000);">
                            <a id="equipment_extra_cpu_sle-01" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>600,000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/sle-02_100x100.png?__cv=9220f90c1874ed7d71b696d38d12e600);">
                            <a id="equipment_extra_cpu_sle-02" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>75,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/sle-03_100x100.png?__cv=4676fbf3832998139092e35c0b6e8000);">
                            <a id="equipment_extra_cpu_sle-03" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>150,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/sle-04_100x100.png?__cv=688a792d359998af68958acb7fbce500);">
                            <a id="equipment_extra_cpu_sle-04" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/dr-01_100x100.png?__cv=ac134270b2d6c46d48ff94bfbacfa300);">
                            <a id="equipment_extra_cpu_dr-01" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/dr-02_100x100.png?__cv=2cd2ee99cfa7e803424786d9db551900);">
                            <a id="equipment_extra_cpu_dr-02" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/rd-x_100x100.png?__cv=597c2f3075c6a0453bae7dd1902dda00);">
                            <a id="equipment_extra_cpu_rd-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/jp-01_100x100.png?__cv=5632c2889dd72df6178de4f1f579e100);">
                            <a id="equipment_extra_cpu_jp-01" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/jp-02_100x100.png?__cv=4c714d0033db967ba3a2720032ae8800);">
                            <a id="equipment_extra_cpu_jp-02" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/fb-x_100x100.png?__cv=e06d39c29ea36fb5e9327bd606e95200);">
                            <a id="equipment_extra_cpu_fb-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>5,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/alb-x_100x100.png?__cv=21e336721d12e791fb7e7c6414d86300);">
                            <a id="equipment_extra_cpu_alb-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/rb-x_100x100.png?__cv=0a0c408176a8fa5c7dd6f6a004164a00);">
                            <a id="equipment_extra_cpu_rb-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/smb-01_100x100.png?__cv=ad7e7ff45f564293dcac06b878e57b00);">
                            <a id="equipment_extra_cpu_smb-01" href="javascript:void(0);">
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
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/ish-01_100x100.png?__cv=ba929c263af782b8fb64046ee2b94d00);">
                            <a id="equipment_extra_cpu_ish-01" href="javascript:void(0);">
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
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/nc-agb-x_100x100.png?__cv=0a6203985f4baacdba419e68daef9700);">
                            <a id="equipment_extra_cpu_nc-agb-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>15,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/aim-01_100x100.png?__cv=9b5cb30e69d3871b077b2c9a16138600);">
                            <a id="equipment_extra_cpu_aim-01" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>20,000,000 C.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/aim-02_100x100.png?__cv=b8d5a02cf8bd3f5080007615048d0d00);">
                            <a id="equipment_extra_cpu_aim-02" href="javascript:void(0);">
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
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/cpu/rllb-x_100x100.png?__cv=c02ef79c7fb09afb18efa7bacb68e300);">
                            <a id="equipment_extra_cpu_rllb-x" href="javascript:void(0);">
                                <div class="item_borders">
                                    <div class="item_hover"></div>
                                    <div class="item_active"></div>
                                </div>
                            </a>
                        </div>
                        <div class="itemList_singlePrice fliess11px-weiss">
                            <strong>25,000 U.</strong>
                        </div>
                    </div>
                                    <div class="item">
                        <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/equipment/extra/hmd-07_100x100.png?__cv=13dee6dcb1f39fc812db55e2db0ec800);">
                            <a id="equipment_extra_hmd-07" href="javascript:void(0);">
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
        category        : 'special',
        paymentLink     : 'indexInternal.es?action=internalPayment',
        itemRows        : [],
        itemData        : {"deal_logfile":{"category":"special","name":"Log-disk deal","nameShort":"Log-disk deal","description":"The log-disk deal: Available now for a limited time only. Act now and rake in up to 160% savings with this unbelievable offer!","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_998_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"DEAL","item_caption":"Log-disk+deal","item_prefix":"special","item_id":998,"item_cv":"db7ec415dba087c01f684670dfa4a300","price_plain":"Payment","event_item_enabled":1,"loot_id":"deal_logfile"}},"itemListImageUrl":"\/do_img\/global\/items\/deal\/logfile_100x100.png?__cv=442d63f845b88b340554e42e1fa56200","cost":"Payment","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":true,"paymentUrl":"\/?action=internalPaymentProxy&req=ff4c8419a9bf703b9d264d7432b0f99152a1fbaa01e0478eee71f915416f53a4a5b27f60cec8bff749de353b41cc7a4d2492d58989c2ee155e51fa8bc4c75992a244feaee6117d188e28b9cb6aa42666eae7b549740e239566b9704fe5d880db4b37a525d703bbb14b7b36564f65a1e39e56ca4d412a29cbd5803624f255854d5735507062168c11144fa348f95aeac95967b138b1854eb9d187fa35ea3c07ace4d5adaadd98e8149e1e175fced3e20a5fc05ba07eb11fe3&v=71d2c08b653f852b"},"deal_booty-key":{"category":"special","name":"Booty key deal","nameShort":"Booty key deal","description":"The booty key deal: Available now and only for a limited time. Act now and rake in up to 160% savings with this unbelievable offer!","price":null,"currency":null,"nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_999_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"DEAL","item_caption":"Booty+key+deal","item_prefix":"special","item_id":999,"item_cv":"7184e1a0b92909ede70d7a0be198d100","price_plain":"Payment","event_item_enabled":1,"loot_id":"deal_booty-key"}},"itemListImageUrl":"\/do_img\/global\/items\/deal\/booty-key_100x100.png?__cv=d49dea6e0addc231421e4fbdabc17700","cost":"Payment","isAmountSetable":false,"amountsSelectable":["ten","hundred","thousand","max"],"maxAmount":1,"isConsumingCargoSpace":false,"isActiveEventItem":true,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":true,"paymentUrl":"\/?action=internalPaymentProxy&req=ccd798beeabf8995348e34a0da358ad58761c1dcd233c38a19f59afa67e009def335384ad9352ada914dd7ef80fb7d89cfe26d9b2cc369a87af56deb69f2d9483405d44a16cd069aa6342efe4a7b73cc1b1a0ff1a942323c29af7b8136c23b7da6c46c9f632443b8eb12e3ff8fb4a43d20aaa4914c30331f30d0d0028939bef60a24c73b6a3bbd5d1ed36130bcaa9ef2f8148b117fe8829dafffbf3849924f40e0a4c877f07db314922a84b19ee21eb530e491d69ec6b97a&v=45f5fc9ab51f940b"},"resource_logfile":{"category":"special","name":"Log-disks","nameShort":"LOG-DISKS","description":"Log-disks can be exchanged for pilot points.","price":300,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_181_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"L-D","item_caption":"LOG-DISKS","item_prefix":"special","item_id":181,"item_cv":"fc187ed232b3bde6da6f12919a2f4a00","price_plain":"300 U.","event_item_enabled":0,"loot_id":"resource_logfile"}},"itemListImageUrl":"\/do_img\/global\/items\/resource\/logfile_100x100.png?__cv=69a613d0e4cd72e90afd6cdc68fcfb00","cost":"300 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"resource_booty-key":{"category":"special","name":"Green Booty Key","nameShort":"BOOTY KEY","description":"Used to open pirate booty and collect the valuable treasure contained within.","price":2000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_183_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"BK-100","item_caption":"BOOTY+KEY","item_prefix":"special","item_id":183,"item_cv":"04b03093f3befc2435b437a0fc10f800","price_plain":"5000 U.","event_item_enabled":0,"loot_id":"resource_booty-key"}},"itemListImageUrl":"\/do_img\/global\/items\/resource\/booty-key_100x100.png?__cv=ef618aff20a6e2bcc88d806284cfcb00","cost":"2,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_ajp-01":{"category":"special","name":"Advanced Jump CPU 1","nameShort":"ADVANCED JUMP CPU","description":"Allows you to jump to any of the valid target maps. May not be used during battle.<br \/><br \/>Only one of these items is allowed per configuration.","price":75000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_201_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"AJP01+CPU","item_caption":"ADVANCED+JUMP+CPU","item_prefix":"special","item_id":201,"item_cv":"4a4e0ea77e2340e663eef19439877800","price_plain":"75,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_ajp-01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/ajp-01_100x100.png?__cv=d4c05b61300e6f836963dd6d27bb6600","cost":"75,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_repbot_rep-1":{"category":"special","name":"Repair Robot 1","nameShort":"Repair bot","description":"This repair bot recovers your ship's hull in 165 seconds<br \/><br \/>Only one of these items is allowed per configuration.","price":10000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_21_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"REP-1","item_caption":"Repair+bot","item_prefix":"special","item_id":21,"item_cv":"e8b966f1b2ac7454d294172838b2c900","price_plain":"10,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_repbot_rep-1"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/repbot\/rep-1_100x100.png?__cv=40bf974da2bd1ca828036a84bebf3900","cost":"10,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_repbot_rep-2":{"category":"special","name":"Repair Robot 2","nameShort":"Repair bot","description":"This repair bot recovers your ship's hull in 120 seconds<br \/><br \/>Only one of these items is allowed per configuration.","price":2000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_22_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"REP-2","item_caption":"Repair+bot","item_prefix":"special","item_id":22,"item_cv":"9f50c78c70fff2844e97eb1d58941e00","price_plain":"2,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_repbot_rep-2"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/repbot\/rep-2_100x100.png?__cv=90cbd18d53f4340e7a28254367338800","cost":"2,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_repbot_rep-3":{"category":"special","name":"Repair Robot 3","nameShort":"Repair bot","description":"This repair bot recovers your ship's hull in 105 seconds.<br \/><br \/>Only one of these items is allowed per configuration.","price":5000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_23_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"REP-3","item_caption":"Repair+bot","item_prefix":"special","item_id":23,"item_cv":"22a269c7414a5f0d53a8b9bf6daa2d00","price_plain":"5,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_repbot_rep-3"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/repbot\/rep-3_100x100.png?__cv=3417fb53c3493f1d8baf68c70e8da400","cost":"5,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_repbot_rep-4":{"category":"special","name":"Repair robot 4","nameShort":"Repair bot","description":"This repair bot recovers your ship's hull in 90 seconds.<br \/><br \/>Only one of these items is allowed per configuration.","price":20000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_24_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"REP-4","item_caption":"Repair+bot","item_prefix":"special","item_id":24,"item_cv":"29a9036012059ea5b7e43e9e75da8400","price_plain":"20,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_repbot_rep-4"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/repbot\/rep-4_100x100.png?__cv=f319657ad942b61c8863b6492de48e00","cost":"20,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_rok-t01":{"category":"special","name":"Rocket Turbo","nameShort":"Rocket Turbo","description":"Doubles rocket firing speed<br \/><br \/>Only one of these items is allowed per configuration.","price":10000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_31_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"ROK-T01","item_caption":"Rocket+Turbo","item_prefix":"special","item_id":31,"item_cv":"a0eb287c68f234440b5bdeeb1387f000","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_rok-t01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/rok-t01_100x100.png?__cv=92eb30597b6a0e5e739c25ca824c4100","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_min-t01":{"category":"special","name":"Turbo Mine CPU 1","nameShort":"TURBO MINE","description":"25% less cool-down time for mines and items made from mines<br \/><br \/>Only one of these items is allowed per configuration.","price":5000000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_32_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"MINT01+CPU","item_caption":"TURBO+MINE","item_prefix":"special","item_id":32,"item_cv":"14e030c96b083d209e9e08a30fd55b00","price_plain":"5,000,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_min-t01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/min-t01_100x100.png?__cv=400dcee2a5b91e04547080457ffa8900","cost":"5,000,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_min-t02":{"category":"special","name":"Turbo Mine CPU 2","nameShort":"TURBO MINE CPU","description":"50% less cool-down time for mines and items made from mines<br \/><br \/>Only one of these items is allowed per configuration.","price":25000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_33_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"MINT02+CPU","item_caption":"TURBO+MINE+CPU","item_prefix":"special","item_id":33,"item_cv":"bcd35dd0597330a489b1251b4a302000","price_plain":"25,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_min-t02"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/min-t02_100x100.png?__cv=e29b05eeb8152c061a02f425c66a7400","cost":"25,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_nc-rrb-x":{"category":"special","name":"Repair-bot Auto CPU","nameShort":"Repair-bot Auto CPU","description":"Auto-activates a repair robot available<br \/><br \/>Only one of these items is allowed per configuration.","price":10000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_41_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"NC-RRB+CPU","item_caption":"Repair-bot+Auto+CPU","item_prefix":"special","item_id":41,"item_cv":"af34b34686ffa4bf575d4b5bc3c94600","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_nc-rrb-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/nc-rrb-x_100x100.png?__cv=862d24f30519c5e53a13f4d3ec995500","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_cl04k-xs":{"category":"special","name":"Cloaking Device Type A","nameShort":"Cloaking device","description":"Ship stays cloaked until your first attack<br \/><br \/>WARNING: Enemies can still see cloaked ships on the mini map.<br \/><br \/>Only one of these items is allowed per configuration.","price":500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_51_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"CL04K-MOD","item_caption":"Cloaking+device","item_prefix":"special","item_id":51,"item_cv":"f84979f3973105c68ea58d5786687b00","price_plain":"500 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_cl04k-xs"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/cl04k-xs_100x100.png?__cv=5579d611e2f505fd3317a4ee4e70ee00","cost":"500 U.","isAmountSetable":false,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_arol-x":{"category":"special","name":"Auto Rocket CPU","nameShort":"AUTO ROCKET CPU","description":"Automatic rocket rapid-fire in laser attacks you start<br \/><br \/>After installation is completed, the AROL-X CPU must be activated on the space map in \"CPUs\".<br \/><br \/>Only one of these items is allowed per configuration.","price":25000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_42_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"AROL-X","item_caption":"AUTO+ROCKET+CPU","item_prefix":"special","item_id":42,"item_cv":"1e649e022d0a50524ca7d8059b24f700","price_plain":"25,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_arol-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/arol-x_100x100.png?__cv=30df149638e4298594447363931c9a00","cost":"25,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_cl04k-m":{"category":"special","name":"Cloaking CPU","nameShort":"Cloaking CPU","description":"10 ship cloakings (active until your first attack)<br \/><br \/>WARNING: Enemies can still see cloaked ships on the mini map.<br \/><br \/>Only one of these items is allowed per configuration.","price":5000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_52_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"CL04K+CPU","item_caption":"Cloaking+CPU","item_prefix":"special","item_id":52,"item_cv":"9279bab384407926f1a319dfbeef8e00","price_plain":"5,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_cl04k-m"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/cl04k-m_100x100.png?__cv=44ceb70cb4a7cfd94ec4b75708208a00","cost":"5,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_cl04k-xl":{"category":"special","name":"Cloaking CPU XL","nameShort":"CLOAKING CPU XL","description":"Cloak your ship 50 times and stay invisible until you launch an attack yourself.<br \/><br \/>WARNING: Enemies can still see cloaked ships on the mini map.<br \/><br \/>Only one of these items is allowed per configuration.","price":22500,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_53_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"CL04K+CPU+XL","item_caption":"CLOAKING+CPU+XL","item_prefix":"special","item_id":53,"item_cv":"1f02db3e27156f007417c0de124a6900","price_plain":"22,500 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_cl04k-xl"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/cl04k-xl_100x100.png?__cv=5378f0fbbdf4e36ee572672a89967e00","cost":"22,500 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_nc-awb-x":{"category":"special","name":"Lab CPU","nameShort":"AUTO WEAPON BOOST CPU","description":"Boosts rockets and lasers with raw materials currently in lab use<br \/><br \/>Only one of these items is allowed per configuration.","price":10000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_61_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"NC-AWB","item_caption":"AUTO+WEAPON+BOOST+CPU","item_prefix":"special","item_id":61,"item_cv":"f79c219f2241dea13de05fde4d700d00","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_nc-awb-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/nc-awb-x_100x100.png?__cv=b4df32b610682314306316c06eed2600","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_nc-awr-x":{"category":"special","name":"Lab CPU 2","nameShort":"AUTO ROCKET BOOST CPU","description":"Boosts rockets with raw materials currently in lab use<br \/><br \/>Only one of these items is allowed per configuration.","price":150000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_62_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"NC-AWR","item_caption":"AUTO+ROCKET+BOOST+CPU","item_prefix":"special","item_id":62,"item_cv":"eabeb11f3d1f36460c3ba30a81cdd300","price_plain":"150,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_nc-awr-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/nc-awr-x_100x100.png?__cv=dd4d95f1e348e27ba53a6edf5f0ae000","cost":"150,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_nc-awl-x":{"category":"special","name":"Lab CPU 3","nameShort":"AUTO LASER BOOST CPU","description":"Boosts lasers with raw materials currently in lab use<br \/><br \/>Only one of these items is allowed per configuration.","price":150000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_63_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"NC-AWL","item_caption":"AUTO+LASER+BOOST+CPU","item_prefix":"special","item_id":63,"item_cv":"3e9bed79a89aaf4a1489272307b59e00","price_plain":"150,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_nc-awl-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/nc-awl-x_100x100.png?__cv=ae3f02fd47c651e3783dc633ed8d9600","cost":"150,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_g3x-crgo-x":{"category":"special","name":"Cargo bay expansion","nameShort":"Cargo compressor","description":"x2 cargo space thanks to molecular compression<br \/><br \/>Only one of these items is allowed per configuration.","price":10000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_71_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"GEMINEX+XI","item_caption":"Cargo+compressor","item_prefix":"special","item_id":71,"item_cv":"2245b056b4cbfe137af8f7906d28d800","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_g3x-crgo-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/g3x-crgo-x_100x100.png?__cv=52722009436318d043bee1373878f500","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_g3x-amry-s":{"category":"special","name":"Armory upgrade 1  ","nameShort":"Armory upgrade","description":"+50% armory capacity<br \/><br \/>Only one of these items is allowed per configuration.","price":5000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_72_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"GEMINEX+AC","item_caption":"Armory+upgrade","item_prefix":"special","item_id":72,"item_cv":"132cd2b447f4ea6b2bde25be153ca900","price_plain":"5,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_g3x-amry-s"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/g3x-amry-s_100x100.png?__cv=f1f5786b7dad796b927debefcad24800","cost":"5,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_g3x-amry-m":{"category":"special","name":"Armory upgrade 2  ","nameShort":"Armory upgrade","description":"+100% armory capacity<br \/><br \/>Only one of these items is allowed per configuration.","price":10000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_73_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"GEMINEX+ACC","item_caption":"Armory+upgrade","item_prefix":"special","item_id":73,"item_cv":"7a6e3fadc68d3d203ff84394921a5b00","price_plain":"10,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_g3x-amry-m"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/g3x-amry-m_100x100.png?__cv=b3287b51cb87d9da908c44fb22bc5000","cost":"10,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_g3x-amry-l":{"category":"special","name":"Armory upgrade 3","nameShort":"Armory upgrade","description":"+150% armory capacity<br \/><br \/>Only one of these items is allowed per configuration.","price":20000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_74_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"GEMINEX+AC%2B","item_caption":"Armory+upgrade","item_prefix":"special","item_id":74,"item_cv":"f9992997c698605d8dc9961985913900","price_plain":"20,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_g3x-amry-l"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/g3x-amry-l_100x100.png?__cv=70e1d6e1de75b7db34bb8859382a2600","cost":"20,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_sle-01":{"category":"special","name":"Slot CPU 1","nameShort":"SLOT EXTENDER","description":"+2 new slots for extras<br \/><br \/>Only one of these items is allowed per configuration.","price":600000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_81_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"SL01+CPU","item_caption":"SLOT+EXTENDER","item_prefix":"special","item_id":81,"item_cv":"d75ffbd588480b769a735dab998eeb00","price_plain":"600,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_sle-01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/sle-01_100x100.png?__cv=99ea1c9b0f2945903e1940e185656000","cost":"600,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_sle-02":{"category":"special","name":"Slot CPU 2","nameShort":"SLOT EXTENDER","description":"+4 new slots for extras<br \/><br \/>Only one of these items is allowed per configuration.","price":75000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_82_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SL02+CPU","item_caption":"SLOT+EXTENDER","item_prefix":"special","item_id":82,"item_cv":"e9a3634b3b7686770da05eef1c2ca800","price_plain":"75,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_sle-02"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/sle-02_100x100.png?__cv=9220f90c1874ed7d71b696d38d12e600","cost":"75,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_sle-03":{"category":"special","name":"Slot CPU 3","nameShort":"SLOT EXTENDER","description":"+6 new slots for extras<br \/><br \/>Only one of these items is allowed per configuration.","price":150000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_83_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SL03+CPU","item_caption":"SLOT+EXTENDER","item_prefix":"special","item_id":83,"item_cv":"48bcae5d349c144b8bf60ea24e9c9c00","price_plain":"150,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_sle-03"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/sle-03_100x100.png?__cv=4676fbf3832998139092e35c0b6e8000","cost":"150,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_sle-04":{"category":"special","name":"Slot CPU 4","nameShort":"SLOT EXTENDER","description":"+10 new slots for extras<br \/><br \/>Only one of these items is allowed per configuration.","price":250000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_84_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SL04+CPU","item_caption":"SLOT+EXTENDER","item_prefix":"special","item_id":84,"item_cv":"88c8072977929cc4f2104a1e3d551700","price_plain":"250,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_sle-04"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/sle-04_100x100.png?__cv=688a792d359998af68958acb7fbce500","cost":"250,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_dr-01":{"category":"special","name":"Drone Repair CPU 1","nameShort":"DRONE REPAIR CPU","description":"This CPU automatically repairs your drones when they sustain more than 70% damage upon ship destruction, as long as you have enough Uridium or Credits (depends on the drone type). Good for 8 repairs.<br \/><br \/>Only one of these items is allowed per configuration.","price":150000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_91_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"DR01+CPU","item_caption":"DRONE+REPAIR+CPU","item_prefix":"special","item_id":91,"item_cv":"5488de153fa75217f260847497a32500","price_plain":"150,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_dr-01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/dr-01_100x100.png?__cv=ac134270b2d6c46d48ff94bfbacfa300","cost":"150,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_dr-02":{"category":"special","name":"Drone Repair CPU 2","nameShort":"DRONE REPAIR CPU","description":"This CPU automatically repairs your drones when they have received the maximum damage upon ship destruction, as long as you have enough Uridium or Credits (depends on the drone type). Good for 32 repairs.<br \/><br \/>Only one of these items is allowed per configuration.","price":15000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_92_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"DR02+CPU","item_caption":"DRONE+REPAIR+CPU","item_prefix":"special","item_id":92,"item_cv":"17e328f52acd887f0900d6cd47c81000","price_plain":"15,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_dr-02"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/dr-02_100x100.png?__cv=2cd2ee99cfa7e803424786d9db551900","cost":"15,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_rd-x":{"category":"special","name":"Radar CPU","nameShort":"RADAR CPU","description":"Displays diplomacy status on mini map<br \/><br \/>Only one of these items is allowed per configuration.","price":15000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_101_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"RD+CPU","item_caption":"RADAR+CPU","item_prefix":"special","item_id":101,"item_cv":"7698df57e88dd294bd12e2a5d3653c00","price_plain":"15,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_rd-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/rd-x_100x100.png?__cv=597c2f3075c6a0453bae7dd1902dda00","cost":"15,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_jp-01":{"category":"special","name":"Jump CPU 1","nameShort":"GALAXY JUMP CPU","description":"10 jumps to X-1 home map. You may not jump from farther out than map X-4 and NOT from PvP maps (4-X). May not be used during battle.<br \/><br \/>Only one of these items is allowed per configuration.","price":150000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_111_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"JP01+CPU","item_caption":"GALAXY+JUMP+CPU","item_prefix":"special","item_id":111,"item_cv":"0e205ea36f47f32d40c202d0b49ada00","price_plain":"150,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_jp-01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/jp-01_100x100.png?__cv=5632c2889dd72df6178de4f1f579e100","cost":"150,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_jp-02":{"category":"special","name":"Jump CPU 2","nameShort":"GALAXY JUMP CPU","description":"Jump to X-1 home map, works everywhere except the pirate sector. 20 total jumps. May not be used during battle.<br \/><br \/>Only one of these items is allowed per configuration.","price":15000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_112_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"JP02+CPU","item_caption":"GALAXY+JUMP+CPU","item_prefix":"special","item_id":112,"item_cv":"2c1ee727e6e82de0c57042cf5b743b00","price_plain":"15,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_jp-02"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/jp-02_100x100.png?__cv=4c714d0033db967ba3a2720032ae8800","cost":"15,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_fb-x":{"category":"special","name":"Automatic CPU Fuel Assistant","nameShort":"AUTOMATIC FUEL ASSISTANT","description":"Automatically buys 10,000 units of P.E.T. fuel when your fuel reserves fall below 1000 units.<br \/><br \/>Only one of these items is allowed per configuration.","price":5000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_123_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"FB-X-CPU","item_caption":"AUTOMATIC+FUEL+ASSISTANT","item_prefix":"special","item_id":123,"item_cv":"51455d7c8dbc25a20ecfc9837c84d600","price_plain":"5,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_fb-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/fb-x_100x100.png?__cv=e06d39c29ea36fb5e9327bd606e95200","cost":"5,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_alb-x":{"category":"special","name":"Ammunition CPU","nameShort":"AMMO BUY ASSISTANT","description":"Automatically buys 10,000 laser rounds if less than 1,000 rounds on board. Settings can be adjusted in Equipment.<br \/><br \/>Only one of these items is allowed per configuration.","price":15000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_121_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"AM+CPU","item_caption":"AMMO+BUY+ASSISTANT","item_prefix":"special","item_id":121,"item_cv":"ffaea294d4d8f756be7477fde1534200","price_plain":"15,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_alb-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/alb-x_100x100.png?__cv=21e336721d12e791fb7e7c6414d86300","cost":"15,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_rb-x":{"category":"special","name":"Rocket CPU","nameShort":"ROCKET BUY ASSISTANT","description":"Automatically buys 500 rockets of the selected rocket type when you have less than 100 left on board. To set the rocket type, click on Hangar -> Equipment.<br \/><br \/>Only one of these items is allowed per configuration.","price":15000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_122_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"RB+CPU","item_caption":"ROCKET+BUY+ASSISTANT","item_prefix":"special","item_id":122,"item_cv":"4af910b4a0f71bf7f329380f8815be00","price_plain":"15,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_rb-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/rb-x_100x100.png?__cv=0a0c408176a8fa5c7dd6f6a004164a00","cost":"15,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_smb-01":{"category":"special","name":"Smart Bomb CPU","nameShort":"SMART BOMB CREATOR","description":"Instant bomb made from 10 mines and 100 Xenomit; doesn't cause any damage to your ship<br \/><br \/>It has the same cool-down time as mines.<br \/><br \/>Only one of these items is allowed per configuration.","price":50000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_131_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"SMB01+CPU","item_caption":"SMART+BOMB+CREATOR","item_prefix":"special","item_id":131,"item_cv":"5a918fcec7c5e188257334fc74814b00","price_plain":"50,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_smb-01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/smb-01_100x100.png?__cv=ad7e7ff45f564293dcac06b878e57b00","cost":"50,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_ish-01":{"category":"special","name":"Insta-shield CPU","nameShort":"ADVANCED SHIELD","description":"3-second protection against enemies; 10 mines and 100 Xenomit used every time<br \/><br \/>It has the same cool-down time as mines.<br \/><br \/>Only one of these items is allowed per configuration.","price":50000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_141_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"ISH01+CPU","item_caption":"ADVANCED+SHIELD","item_prefix":"special","item_id":141,"item_cv":"a4715d59f75d07458815b223eabaa500","price_plain":"50,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_ish-01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/ish-01_100x100.png?__cv=ba929c263af782b8fb64046ee2b94d00","cost":"50,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_nc-agb-x":{"category":"special","name":"Generator Boost CPU","nameShort":"GENERATOR BOOST","description":"Automatically gives your generators a boost using the best resources available<br \/><br \/>Only one of these items is allowed per configuration.","price":15000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_151_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"NC-AGB+CPU","item_caption":"GENERATOR+BOOST","item_prefix":"special","item_id":151,"item_cv":"493949647bd0087c6ba6064f185cc300","price_plain":"15,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_nc-agb-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/nc-agb-x_100x100.png?__cv=0a6203985f4baacdba419e68daef9700","cost":"15,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_aim-01":{"category":"special","name":"Targeting Guidance CPU 1","nameShort":"Targeting guidance CPU 1","description":"25% less chance that lasers will miss their target; 10 Xenomit used per volley <br \/><br \/>Click on the CPUs button in the shortcut bar to activate targeting guidance. Only one targeting guidance CPU is allowed per configuration.<br \/><br \/>Only one of these items is allowed per configuration.","price":20000000,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_161_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":0,"item_name":"AIM01+CPU","item_caption":"Targeting+guidance+CPU+1","item_prefix":"special","item_id":161,"item_cv":"88f6c7cc00376e9a096ce15415403900","price_plain":"20,000,000 C.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_aim-01"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/aim-01_100x100.png?__cv=9b5cb30e69d3871b077b2c9a16138600","cost":"20,000,000 C.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_aim-02":{"category":"special","name":"Targeting Guidance CPU 2","nameShort":"TARGETING GUIDANCE CPU 2","description":"50% less chance that lasers will miss their target; 10 Xenomit used per volley<br \/><br \/>Click on the CPUs button in the shortcut bar to activate targeting guidance. Only one targeting guidance CPU allowed per configuration.<br \/><br \/>Only one of these items is allowed per configuration.","price":200000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_162_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"AIM02+CPU","item_caption":"TARGETING+GUIDANCE+CPU+2","item_prefix":"special","item_id":162,"item_cv":"6e7702deafabf1f54d443eeab38d8f00","price_plain":"200,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_aim-02"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/aim-02_100x100.png?__cv=b8d5a02cf8bd3f5080007615048d0d00","cost":"200,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_cpu_rllb-x":{"category":"special","name":"Rocket-launcher CPU","nameShort":"ROCKET-LAUNCHER CPU","description":"The rocket-launcher CPU automatically reloads your rocket launcher with a specified rocket type to rain fire on your enemies when you launch a laser attack.<br \/><br \/>After installation is completed, the RL-LB1 CPU must be activated on the space map in \"CPUs\". <br \/><br \/>Only one of these items is allowed per configuration.","price":25000,"currency":"real","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_182_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"RL-LB1+CPU","item_caption":"ROCKET-LAUNCHER+CPU","item_prefix":"special","item_id":182,"item_cv":"5dff9a76cf05119ab20768cfa68c1000","price_plain":"25,000 U.","event_item_enabled":0,"loot_id":"equipment_extra_cpu_rllb-x"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/cpu\/rllb-x_100x100.png?__cv=c02ef79c7fb09afb18efa7bacb68e300","cost":"25,000 U.","isAmountSetable":true,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":false},"equipment_extra_hmd-07":{"category":"special","name":"HM7 trade drone","nameShort":"HM7 trade drone","description":"With the HM7 trade drone, you can sell your ore no matter what orbit you're in. Why waste time going back to the space station?<br \/>Valid for 100 transactions.<br \/><br \/><br \/><br \/>Only one of these items is allowed per configuration.","price":0,"currency":"virtual","nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=special_190_code&f=eurostyle_thea&color=white&bgcolor=grey","flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800","version":[10,0],"id":"shopdetails","width":"253","height":"206","wmode":"transparent","bgColor":"schwarz","allowScriptAccess":"always"},"variables":{"cdn":"http:\/\/darkorbit-22.level3.bpcdn.net\/","elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00","background_cv":"5a3549d51b64b3301a596e7197760500","limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200","limited_std_icon_cv":"506294ad55b3114581a227681644e200","elite":1,"item_name":"HM7","item_caption":"HM7+trade+drone","item_prefix":"special","item_id":190,"item_cv":"e85eaa336e858812dfc6cdbf4b3a6a00","price_plain":"Payment","event_item_enabled":0,"loot_id":"equipment_extra_hmd-07"}},"itemListImageUrl":"\/do_img\/global\/items\/equipment\/extra\/hmd-07_100x100.png?__cv=13dee6dcb1f39fc812db55e2db0ec800","cost":"Payment","isAmountSetable":false,"amountsSelectable":["five","twenty","max"],"maxAmount":200,"isConsumingCargoSpace":false,"isActiveEventItem":false,"requiresShipInActiveHangar":false,"discountPercent":null,"discountTooltipText":null,"isPaymentItem":true,"paymentUrl":"\/?action=internalPaymentProxy&req=61332b2dd6f30b7b9473173663805c8533b9c9828822367540aefa3bc43754e6876a6d9457c3b8e9c2f51d43c3af2eea12a9980c72e1a884a83148831ae3619a112b4d153507a92404e8a53d447a6af5b84ed310627085c6&v=e0cf179cf66c3d7d"}},
        numItems        : 43,
        startupItemId   : 'deal_logfile',
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
