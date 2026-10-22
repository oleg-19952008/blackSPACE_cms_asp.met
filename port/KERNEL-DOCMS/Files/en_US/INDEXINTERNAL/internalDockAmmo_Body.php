</head>
<?php
$shop->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$mhh = true;
?>
<body class="internalDockShop_battery" onLoad="" >
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
                icon = '';    </script>
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
                                            <div id="subNavAmmo" class="subNavButtonAmmo subNavButtonActive" onmouseover="subNavRollover('subNavAmmo')" onmouseout="subNavRollover('subNavAmmo')">
                                                <a href="indexInternal.es?action=internalDock&tpl=internalDockAmmo"><div class="subNavTextActiveAmmo"></div></a>
                                            </div>
                                            <div id="subNavGenerators" class="subNavButtonGenerators subNavButtonInactive" onmouseover="subNavRollover('subNavGenerators')" onmouseout="subNavRollover('subNavGenerators')">
                                                <a href="indexInternal.es?action=internalDock&tpl=internalDockGenerator"><div class="subNavTextInactiveGenerators"></div></a>
                                            </div>
                                            <div id="subNavExtras" class="subNavButtonExtras subNavButtonInactive" onmouseover="subNavRollover('subNavExtras')" onmouseout="subNavRollover('subNavExtras')">
                                                <a href="indexInternal.es?action=internalDock&tpl=internalDockSpecials"><div class="subNavTextInactiveExtras"></div></a>
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

                                            <div id="item_list" style="margin-top: 0px;">

                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/laser/ucb-100_100x100.png?__cv=fa407a1644e0563e5138b0499c682100);">
                                                        <a id="ammunition_laser_ucb-100" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>150 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/laser/rsb-75_100x100.png?__cv=ed334efd4833335cb183b8b3fbb11500);">
                                                        <a id="ammunition_laser_rsb-75" href="javascript:void(0);" class="active">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>15 U.</strong>
                                                    </div>
                                                </div>
<!--                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/laser/rb-214_100x100.png?__cv=ed7124e5d7b36d0d0182758e4b057100);">
                                                        <a id="ammunition_laser_rb-214" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>10 U.</strong>
                                                    </div>
                                                </div>-->
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/laser/sab-50_100x100.png?__cv=8c128831210a77fdebfc8085f0de2700);">
                                                        <a id="ammunition_laser_sab-50" href="javascript:void(0);" class="">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>1 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/laser/mcb-50_100x100.png?__cv=86f834298693b605147ccf579bb84d00);">
                                                        <a id="ammunition_laser_mcb-50" href="javascript:void(0);" class="">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>1 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/laser/mcb-25_100x100.png?__cv=fa407a1644e0563e5138b0499c682100);">
                                                        <a id="ammunition_laser_mcb-25" href="javascript:void(0);" class="">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>95 C.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/laser/lcb-10_100x100.png?__cv=d8db5c48fe907c65a74b77b7206a5e00);">
                                                        <a id="ammunition_laser_lcb-10" href="javascript:void(0);" class="">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>10 C.</strong>
                                                    </div>
                                                </div>
                                               <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/specialammo/dcr-250_100x100.png?__cv=afa8d1471065deb26672ce7c88c9ab00);">
                                                        <a id="ammunition_specialammo_dcr-250" href="javascript:void(0);">
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
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/specialammo/pld-8_100x100.png?__cv=a36af5f0b4d96fdf49506edd3b42f300);">
                                                        <a id="ammunition_specialammo_pld-8" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>100 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/specialammo/emp-01_100x100.png?__cv=55fa7a5cd26d00b39f963795c3ab1900);">
                                                        <a id="ammunition_specialammo_emp-01" href="javascript:void(0);">
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
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocketlauncher/hstrm-01_100x100.png?__cv=be2503f2e93334f320dce9156363fc00);">
                                                        <a id="ammunition_rocketlauncher_hstrm-01" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>25 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocketlauncher/ubr-100_100x100.png?__cv=c6ca51af1bb56f163268ae1f5564f400);">
                                                        <a id="ammunition_rocketlauncher_ubr-100" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>30 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocketlauncher/sar-02_100x100.png?__cv=e71bbf67775146cacab9fd82bb4e5e00);">
                                                        <a id="ammunition_rocketlauncher_sar-02" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>20 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/mine/slm-01_100x100.png?__cv=423a7429701436f742babda30b43bc00);">
                                                        <a id="ammunition_mine_slm-01" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>50 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/mine/ddm-01_100x100.png?__cv=7041b21050caa6ba09b52096aadf7400);">
                                                        <a id="ammunition_mine_ddm-01" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>150 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/mine/sabm-01_100x100.png?__cv=4c7dd63001053a9de0c5d3d335470e00);">
                                                        <a id="ammunition_mine_sabm-01" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>150 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/mine/empm-01_100x100.png?__cv=38b506ca821f324b01415507d2df3900);">
                                                        <a id="ammunition_mine_empm-01" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>150 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocket/plt-2021_100x100.png?__cv=57dc1c46160862d3e6e73e451764ab00);">
                                                        <a id="ammunition_rocket_plt-2021" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>5 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocket/plt-3030_100x100.png?__cv=43ea84fc8e020f3f93a7ae004be4b600);">
                                                        <a id="ammunition_rocket_plt-3030" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>150 U.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocket/r-310_100x100.png?__cv=9d29b47ca17ee0316f80a4bee39c9600);">
                                                        <a id="ammunition_rocket_r-310" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>100 C.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocket/plt-2026_100x100.png?__cv=58fdf543bd4fbd7bfd7bcb011c9d1100);">
                                                        <a id="ammunition_rocket_plt-2026" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>500 C.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocketlauncher/sar-01_100x100.png?__cv=8a240cd56aafb6e2f731693a9eda5c00);">
                                                        <a id="ammunition_rocketlauncher_sar-01" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>2,000 C.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/rocketlauncher/eco-10_100x100.png?__cv=64ae584f553ab15e1dcacd7a7a595e00);">
                                                        <a id="ammunition_rocketlauncher_eco-10" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>1,500 C.</strong>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <div class="itemList_singleItem" style="background-image:url(./do_img/global/items/ammunition/mine/acm-01_100x100.png?__cv=7111672f8762e1eb473248272678ea00);">
                                                        <a id="ammunition_mine_acm-01" href="javascript:void(0);">
                                                            <div class="item_borders">
                                                                <div class="item_hover"></div>
                                                                <div class="item_active"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="itemList_singlePrice fliess11px-weiss">
                                                        <strong>100 U.</strong>
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
                            <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>Building Vertigo - Polaris<br>2-4 rue Eugène Ruppert<br>L-2453 Luxemburg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jeronimo Folgueira<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 25331016<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 261 911 3515<br>Fax: +352 49 48 48 6606<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
                        </div>
                        <?php require GLOBALS . 'credits.php'; ?>

                        <script type="text/javascript" id="sourcecode">

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
                jQuery(document).ready(function() {
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
        category: 'battery',
                paymentLink: 'indexInternal.es?action=internalPayment',
                itemRows: [],
<?php if ($mhh == TRUE):
    
    
    ?>
            itemData: {"ammunition_laser_rsb-75":{"category":"battery", "name":"RSB-75", "nameShort":"RAPID SALVO BATTERY", "description":"One type of ammo you just can't do without: Rain death on your enemies when you fire off a rapid laser salvo.", "price":15, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_6_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"RSB-75", "item_caption":"RAPID+SALVO+BATTERY", "item_prefix":"battery", "item_id":6, "item_cv":"8fe984aa4995aaa7e979cad47dd4bd00", "price_plain":"15 U.", "event_item_enabled":1, "loot_id":"ammunition_laser_rsb-75", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/laser\/rsb-75_100x100.png?__cv=ed334efd4833335cb183b8b3fbb11500", "cost":"5 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_laser_rsb-75','ammunition_laser_', 'Batteries'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_laser_ucb-100":{"category":"battery", "name":"UCB-200", "nameShort":"EPIC CAPACITY BATTERY", "description":"One type of ammo you just can't do without: Rain death on your enemies when you fire off a rapid laser salvo.", "price":150, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_4_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"UCB-200", "item_caption":"EPIC+CAPACITY+BATTERY", "item_prefix":"battery", "item_id":4, "item_cv":"0adc6efb69f978dbfd401aeeb9204c00", "price_plain":"150 U.", "event_item_enabled":1, "loot_id":"ammunition_laser_ucb-100", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/laser\/ucb-100_100x100.png?__cv=ed334efd4833335cb183b8b3fbb11500", "cost":"2 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php if ($unity->cPT($Users->DataRow['premium'])): echo "100000"; else: echo $shop->mXac('ammunition_laser_ucb-100','ammunition_laser_', 'Batteries'); endif; ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_laser_rb-214":{"category":"battery", "name":"RB-214", "nameShort":"RADIATIUM BATTERY", "description":"This special-order ammo developed from rare Radiatium packs a wallop: 4 times stronger than conventional lasers when used on anything but Demaner hulls, against which it deals 8-fold damage!", "price":9.5, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_10_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"RB-214", "item_caption":"RADIATIUM+BATTERY", "item_prefix":"battery", "item_id":10, "item_cv":"c0b8867564167ee752e60a78cd4ff900", "price_plain":"10 U.", "event_item_enabled":1, "loot_id":"ammunition_laser_rb-214", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/laser\/rb-214_100x100.png?__cv=ed7124e5d7b36d0d0182758e4b057100", "cost":"10 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":106, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_laser_sab-50":{"category":"battery", "name":"SAB-50", "nameShort":"SHIELD LEECH BATTERY", "description":"Special ammunition that reinforces your Shield, strengthening it by tapping into enemy shields (Shield Leech).", "price":1, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_5_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"SAB-50", "item_caption":"SHIELD+LEECH+BATTERY", "item_prefix":"battery", "item_id":5, "item_cv":"555c0f864e452fd5efc6d5af7980cf00", "price_plain":"1 U.", "event_item_enabled":0, "loot_id":"ammunition_laser_sab-50", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/laser\/sab-50_100x100.png?__cv=8c128831210a77fdebfc8085f0de2700", "cost":"1 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_laser_sab-50','ammunition_laser_', 'Batteries'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":true, "isRocket":false},
                "ammunition_laser_mcb-50":{"category":"battery", "name":"MCB-50", "nameShort":"MAXIMUM CAPACITY BATTERY", "description":"The best standard laser ammo: x3 laser damage per round", "price":1, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_3_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"MCB-50", "item_caption":"MAXIMUM+CAPACITY+BATTERY", "item_prefix":"battery", "item_id":3, "item_cv":"1689f73da7e9fc34e3fc9e3a0386d700", "price_plain":"1 U.", "event_item_enabled":0, "loot_id":"ammunition_laser_mcb-50", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/laser\/mcb-50_100x100.png?__cv=86f834298693b605147ccf579bb84d00", "cost":"1 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_laser_mcb-50','ammunition_laser_', 'Batteries'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":true, "isRocket":false},
                "ammunition_laser_mcb-25":{"category":"battery", "name":"MCB-25", "nameShort":"MID-CAPACITY BATTERY", "description":"More bang for your buck: x2 laser damage per round", "price":95, "currency":"virtual", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_2_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":0, "item_name":"MCB-25", "item_caption":"MID-CAPACITY+BATTERY", "item_prefix":"battery", "item_id":2, "item_cv":"4a1c0113ae59ac7b0f9b58b1edab9000", "price_plain":"95 C.", "event_item_enabled":0, "loot_id":"ammunition_laser_mcb-25", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/laser\/mcb-25_100x100.png?__cv=fa407a1644e0563e5138b0499c682100", "cost":"0.5 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php if ($unity->cPT($Users->DataRow['premium'])): echo "100000"; else: echo $shop->mXac('ammunition_laser_mcb-25', 'ammunition_laser_', 'Batteries'); endif; ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":true, "isRocket":false},
                "ammunition_laser_lcb-10":{"category":"battery", "name":"LCB-10", "nameShort":"LOW CAPACITY BATTERY", "description":"Low efficiency for a low price", "price":10, "currency":"virtual", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_1_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":0, "item_name":"LCB-10", "item_caption":"LOW+CAPACITY+BATTERY", "item_prefix":"battery", "item_id":1, "item_cv":"de93be2ff21616e876c6be7ab846f500", "price_plain":"10 C.", "event_item_enabled":0, "loot_id":"ammunition_laser_lcb-10", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/laser\/lcb-10_100x100.png?__cv=d8db5c48fe907c65a74b77b7206a5e00", "cost":"10 C.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php if ($unity->cPT($Users->DataRow['premium'])): echo "100000"; else: echo $shop->mXac('ammunition_laser_lcb-10', 'ammunition_laser_', 'Batteries'); endif; ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, "discountPercent":null, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":true, "isRocket":false},
                "ammunition_specialammo_dcr-250":{"category":"rocket", "name":"Deceleration rockets", "nameShort":"Deceleration rockets", "description":"Hit your opponent with a deceleration rocket to slow them down by 30% for 5 seconds", "price":500, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_10_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"DCR-250", "item_caption":"Deceleration+rockets", "item_prefix":"rocket", "item_id":10, "item_cv":"c8b3a3fda1b3df2233705565c0070f00", "price_plain":"500 U.", "event_item_enabled":1, "loot_id":"ammunition_specialammo_dcr-250", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/specialammo\/dcr-250_100x100.png?__cv=afa8d1471065deb26672ce7c88c9ab00", "cost":"500 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->spaceleft('Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_specialammo_pld-8":{"category":"rocket", "name":"PLD-8", "nameShort":"PLASMA CHARGER", "description":"Plasma charger - Temporarily reduces the accuracy of your enemy's weapons system, offering you a number of tactical advantages.", "price":100, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_4_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"PLD-8", "item_caption":"PLASMA+CHARGER", "item_prefix":"rocket", "item_id":4, "item_cv":"85f80329ad2ccad2d6be725ac0b5ee00", "price_plain":"100 U.", "event_item_enabled":1, "loot_id":"ammunition_specialammo_pld-8", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/specialammo\/pld-8_100x100.png?__cv=a36af5f0b4d96fdf49506edd3b42f300", "cost":"100 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->spaceleft('Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_specialammo_emp-01":{"category":"rocket", "name":"EMP burst", "nameShort":"EMP burst", "description":"The EMP burst will release an electromagnetic impulse wave to temporarily short-circuit your enemies' onboard instruments and disable their targeting devices. If you're really lucky, the burst will also uncloak them, allowing you to shoot them out of the sky like birds.", "price":500, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_40_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"EMP-01", "item_caption":"EMP+burst", "item_prefix":"rocket", "item_id":40, "item_cv":"deefadefc223155919f9c2005debe100", "price_plain":"500 U.", "event_item_enabled":1, "loot_id":"ammunition_specialammo_emp-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/specialammo\/emp-01_100x100.png?__cv=55fa7a5cd26d00b39f963795c3ab1900", "cost":"500 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo round($Users->DataRow['uri']/500); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_rocketlauncher_hstrm-01":{"category":"rocket", "name":"Hellstorm", "nameShort":"HELLSTORM", "description":"Double the rockets, double the trouble!<br \/>Upon being fired from the rocket launcher, these rockets will rapidly descend upon your enemy and scorch their target with a near apocalyptic explosion. Fired off in a broadside, they will cause even more damage, hitting an enemy ship from multiple sides to weaken its hull structure.", "price":25, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_50_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"HSTRM-01", "item_caption":"HELLSTORM", "item_prefix":"rocket", "item_id":50, "item_cv":"10ac5c67c8dfe4d5bdbe8b8a9c954100", "price_plain":"25 U.", "event_item_enabled":1, "loot_id":"ammunition_rocketlauncher_hstrm-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocketlauncher\/hstrm-01_100x100.png?__cv=be2503f2e93334f320dce9156363fc00", "cost":"25 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocketlauncher_hstrm-01', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_rocketlauncher_ubr-100":{"category":"rocket", "name":"Uber", "nameShort":"UBER ROCKET", "description":"Your rocket launcher will fire salvos of UBR-100 rockets. Their optimized warheads are at least 80% more effective against aliens, and they also utilize the multi-angle damage feature of conventional Hellstorm rockets.", "price":30, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_51_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"UBR-100", "item_caption":"UBER+ROCKET", "item_prefix":"rocket", "item_id":51, "item_cv":"749bed8d03b3b89740790c66dbcf7f00", "price_plain":"30 U.", "event_item_enabled":1, "loot_id":"ammunition_rocketlauncher_ubr-100", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocketlauncher\/ubr-100_100x100.png?__cv=c6ca51af1bb56f163268ae1f5564f400", "cost":"30 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocketlauncher_ubr-100', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_rocketlauncher_sar-02":{"category":"rocket", "name":"SAR-02 rocket", "nameShort":"HELLSTORM", "description":"The Hellstorm SAR-02, a Shield Leeching rocket, is fired from a rocket launcher. An especially good quick-strike weapon!", "price":20, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_54_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"SAR-02", "item_caption":"HELLSTORM", "item_prefix":"rocket", "item_id":54, "item_cv":"5214aaa53a84c3e1fece2dcac5b95e00", "price_plain":"20 U.", "event_item_enabled":1, "loot_id":"ammunition_rocketlauncher_sar-02", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocketlauncher\/sar-02_100x100.png?__cv=e71bbf67775146cacab9fd82bb4e5e00", "cost":"20 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocketlauncher_sar-02', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_mine_slm-01":{"category":"rocket", "name":"Slowdown Mine", "nameShort":"MINE", "description":"Slows your opponent for 5 seconds by 50%. Furthermore, it takes effect in just 1 second.", "price":50, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_16_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"SL-M01", "item_caption":"MINE", "item_prefix":"rocket", "item_id":16, "item_cv":"a67de9260310a687bd7f61292091af00", "price_plain":"50 U.", "event_item_enabled":1, "loot_id":"ammunition_mine_slm-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/mine\/slm-01_100x100.png?__cv=423a7429701436f742babda30b43bc00", "cost":"50 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_mine_slm-01', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_mine_ddm-01":{"category":"rocket", "name":"Direct-damage mine", "nameShort":"Mine", "description":"Proximity mine:<br>20% direct damage calculated from ship's base HP and pilot-bio upgrades - powerful enough to destroy enemy ships entirely!", "price":150, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_14_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"DD-M01", "item_caption":"Mine", "item_prefix":"rocket", "item_id":14, "item_cv":"ca743b6d636c7973028d9e524c6f0f00", "price_plain":"150 U.", "event_item_enabled":1, "loot_id":"ammunition_mine_ddm-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/mine\/ddm-01_100x100.png?__cv=7041b21050caa6ba09b52096aadf7400", "cost":"150 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_mine_ddm-01', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_mine_sabm-01":{"category":"rocket", "name":"Anti-shield mine", "nameShort":"Mine", "description":"Proximity mine: <br>50% shield damage upon detonation; combinable with other mine types", "price":150, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_13_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"SAB-M01", "item_caption":"Mine", "item_prefix":"rocket", "item_id":13, "item_cv":"0f588e8a1e106731ecbfe84b9dd43400", "price_plain":"150 U.", "event_item_enabled":1, "loot_id":"ammunition_mine_sabm-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/mine\/sabm-01_100x100.png?__cv=4c7dd63001053a9de0c5d3d335470e00", "cost":"150 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_mine_sabm-01', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_mine_empm-01":{"category":"rocket", "name":"Anti-cloaking mine", "nameShort":"Mine", "description":"Proximity mine: 100% uncloaking upon detonation", "price":150, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_12_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"EMP-M01", "item_caption":"Mine", "item_prefix":"rocket", "item_id":12, "item_cv":"601300ee32affb6025afce562ba22300", "price_plain":"150 U.", "event_item_enabled":1, "loot_id":"ammunition_mine_empm-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/mine\/empm-01_100x100.png?__cv=38b506ca821f324b01415507d2df3900", "cost":"150 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_mine_empm-01', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":false, "isActiveEventItem":true, "requiresShipInActiveHangar":false, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false},
                "ammunition_rocket_plt-2021":{"category":"rocket", "name":"PLT-2021", "nameShort":"LONG-RANGE ROCKET", "description":"Long-range rocket: causes up to 4,000 points per rocket fired", "price":5, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_3_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"PLT-2021", "item_caption":"LONG-RANGE+ROCKET", "item_prefix":"rocket", "item_id":3, "item_cv":"7f58a0ef6312b174407d72dbc63de500", "price_plain":"5 U.", "event_item_enabled":0, "loot_id":"ammunition_rocket_plt-2021", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocket\/plt-2021_100x100.png?__cv=57dc1c46160862d3e6e73e451764ab00", "cost":"5 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocket_plt-2021', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":false, "isRocket":true},
                "ammunition_rocket_plt-3030":{"category":"rocket", "name":"PLT-3030", "nameShort":"LONG-RANGE ROCKET", "description":"Each rocket inflicts a max. of 6,000 HP of damage, but has a lower accuracy rate due to its impressive firepower.<br \/> An exceptional weapon when used in combination with the Tech Center's precision targeter.", "price":7, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_5_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"PLT-3030", "item_caption":"LONG-RANGE+ROCKET", "item_prefix":"rocket", "item_id":5, "item_cv":"12000cb1101fd616c9bc11a0a2ed8400", "price_plain":"7 U.", "event_item_enabled":0, "loot_id":"ammunition_rocket_plt-3030", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocket\/plt-3030_100x100.png?__cv=43ea84fc8e020f3f93a7ae004be4b600", "cost":"7 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocket_plt-3030', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":false, "isRocket":true},
                "ammunition_rocket_r-310":{"category":"rocket", "name":"R310", "nameShort":"SHORT-RANGE ROCKET", "description":"Short-range rocket: causes up to 1,000 damage points per rocket fired", "price":100, "currency":"virtual", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_1_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":0, "item_name":"R310", "item_caption":"SHORT-RANGE+ROCKET", "item_prefix":"rocket", "item_id":1, "item_cv":"cb7c34b317d89ac554e8158875fe9f00", "price_plain":"100 C.", "event_item_enabled":0, "loot_id":"ammunition_rocket_r-310", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocket\/r-310_100x100.png?__cv=9d29b47ca17ee0316f80a4bee39c9600", "cost":"100 C.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocket_r-310', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, "discountPercent":null, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":false, "isRocket":true},
                "ammunition_rocket_plt-2026":{"category":"rocket", "name":"PLT-2026", "nameShort":"MID-RANGE ROCKET", "description":"Mid-range rocket: causes up to 2,000 damage points per rocket fired", "price":500, "currency":"virtual", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_2_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":0, "item_name":"PLT-2026", "item_caption":"MID-RANGE+ROCKET", "item_prefix":"rocket", "item_id":2, "item_cv":"f44edb46ddcf5240589d9fa19cb75400", "price_plain":"500 C.", "event_item_enabled":0, "loot_id":"ammunition_rocket_plt-2026", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocket\/plt-2026_100x100.png?__cv=58fdf543bd4fbd7bfd7bcb011c9d1100", "cost":"500 C.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocket_plt-2026', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, "discountPercent":null, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":false, "isRocket":true},
                "ammunition_rocketlauncher_sar-01":{"category":"rocket", "name":"SAR-01 rocket", "nameShort":"HELLSTORM", "description":"The Hellstorm SAR-01, a Shield Leeching rocket, is fired from a rocket launcher. An especially good quick-strike weapon!", "price":2000, "currency":"virtual", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_53_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":0, "item_name":"SAR-01", "item_caption":"HELLSTORM", "item_prefix":"rocket", "item_id":53, "item_cv":"71e0e1b9c393bfb26a539c0c2bdf8100", "price_plain":"2,000 C.", "event_item_enabled":0, "loot_id":"ammunition_rocketlauncher_sar-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocketlauncher\/sar-01_100x100.png?__cv=8a240cd56aafb6e2f731693a9eda5c00", "cost":"2,000 C.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocketlauncher_sar-01', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, "discountPercent":null, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":false, "isRocket":true},
                "ammunition_rocketlauncher_eco-10":{"category":"rocket", "name":"ECO-10 rocket", "nameShort":"HELLSTORM", "description":"The multi-angle damage rocket for smart spenders. Your toughest enemies won't stand a chance against the many broadsides of the ECO Hellstorm.", "price":1500, "currency":"virtual", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_52_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":0, "item_name":"ECO-10", "item_caption":"HELLSTORM", "item_prefix":"rocket", "item_id":52, "item_cv":"5eeb950a0020b5f4fed430e9776cb200", "price_plain":"1,500 C.", "event_item_enabled":0, "loot_id":"ammunition_rocketlauncher_eco-10", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/rocketlauncher\/eco-10_100x100.png?__cv=64ae584f553ab15e1dcacd7a7a595e00", "cost":"1,500 C.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_rocketlauncher_eco-10', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, "discountPercent":null, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":false, "isRocket":true},
                "ammunition_mine_acm-01":{"category":"rocket", "name":"ACM-1", "nameShort":"MINE", "description":"Proximity mine: 20% damage upon detonation", "price":100, "currency":"real", "nameBackgroundImageUrl":"\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_11_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash":{"parameters":{"src":"\/swf_global\/shopdetails.swf?__cv=19b8d1bc628a6917bbb40a8cc7c0f900", "version":[10, 0], "id":"shopdetails", "width":"253", "height":"206", "wmode":"transparent", "bgColor":"schwarz", "allowScriptAccess":"always"}, "variables":{"cdn":"http:\/\/127.0.0.1\/", "elite_icon_cv":"4738d9ac735bc66ddb9d288a3d982e00", "background_cv":"5a3549d51b64b3301a596e7197760500", "limited_icon_cv":"74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv":"506294ad55b3114581a227681644e200", "elite":1, "item_name":"ACM-1", "item_caption":"MINE", "item_prefix":"rocket", "item_id":11, "item_cv":"934da884d3eabff326ce41145702ce00", "price_plain":"100 U.", "event_item_enabled":0, "loot_id":"ammunition_mine_acm-01", "useDeviceFonts":0}}, "itemListImageUrl":"\/do_img\/global\/items\/ammunition\/mine\/acm-01_100x100.png?__cv=7111672f8762e1eb473248272678ea00", "cost":"100 U.", "isAmountSetable":true, "amountsSelectable":["ten", "hundred", "thousand", "max"], "maxAmount":<?php echo $shop->mXac('ammunition_mine_acm-01', 'ammunition_rocket', 'Rockets'); ?>, "isConsumingCargoSpace":true, "isActiveEventItem":false, "requiresShipInActiveHangar":true, <?php if ($unity->cPT($Users->DataRow['premium'])): echo '"discountPercent":"-5%"'; else:   echo '"discountPercent":""';     endif;?>, "discountTooltipText":null, "isPaymentItem":false, "weight":1, "isBattery":false, "isRocket":true}},
    <?php
else:
    ?>
            itemData: {"ammunition_laser_lcb-10": {"category": "battery", "name": "LCB-10", "nameShort": "LOW CAPACITY BATTERY", "description": "Low efficiency for a low price", "price": 10, "currency": "virtual", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_1_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 0, "item_name": "LCB-10", "item_caption": "LOW+CAPACITY+BATTERY", "item_prefix": "battery", "item_id": 1, "item_cv": "de93be2ff21616e876c6be7ab846f500", "price_plain": "10 C.", "event_item_enabled": 0, "loot_id": "ammunition_laser_lcb-10"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/laser\/lcb-10_100x100.png?__cv=d8db5c48fe907c65a74b77b7206a5e00", "cost": "10 C.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": true, "isRocket": false}, "ammunition_laser_sab-50": {"category": "battery", "name": "SAB-50", "nameShort": "SHIELD LEECH BATTERY", "description": "Special ammunition that reinforces your Shield, strengthening it by tapping into enemy shields (Shield Leech).", "price": 1, "currency": "real", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_5_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 1, "item_name": "SAB-50", "item_caption": "SHIELD+LEECH+BATTERY", "item_prefix": "battery", "item_id": 5, "item_cv": "555c0f864e452fd5efc6d5af7980cf00", "price_plain": "1 U.", "event_item_enabled": 0, "loot_id": "ammunition_laser_sab-50"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/laser\/sab-50_100x100.png?__cv=8c128831210a77fdebfc8085f0de2700", "cost": "1 U.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": true, "isRocket": false}, "ammunition_laser_mcb-50": {"category": "battery", "name": "MCB-50", "nameShort": "MAXIMUM CAPACITY BATTERY", "description": "The best standard laser ammo: x3 laser damage per round", "price": 1, "currency": "real", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_3_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 1, "item_name": "MCB-50", "item_caption": "MAXIMUM+CAPACITY+BATTERY", "item_prefix": "battery", "item_id": 3, "item_cv": "1689f73da7e9fc34e3fc9e3a0386d700", "price_plain": "1 U.", "event_item_enabled": 0, "loot_id": "ammunition_laser_mcb-50"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/laser\/mcb-50_100x100.png?__cv=86f834298693b605147ccf579bb84d00", "cost": "1 U.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": true, "isRocket": false}, "ammunition_laser_mcb-25": {"category": "battery", "name": "MCB-25", "nameShort": "MID-CAPACITY BATTERY", "description": "More bang for your buck: x2 laser damage per round", "price": 0.5, "currency": "real", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=battery_2_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 1, "item_name": "MCB-25", "item_caption": "MID-CAPACITY+BATTERY", "item_prefix": "battery", "item_id": 2, "item_cv": "4a1c0113ae59ac7b0f9b58b1edab9000", "price_plain": "0.5 U.", "event_item_enabled": 0, "loot_id": "ammunition_laser_mcb-25"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/laser\/mcb-25_100x100.png?__cv=fa407a1644e0563e5138b0499c682100", "cost": "0.5 U.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": true, "isRocket": false}, "ammunition_rocket_plt-3030": {"category": "rocket", "name": "PLT-3030", "nameShort": "LONG-RANGE ROCKET", "description": "Each rocket inflicts a max. of 6,000 HP of damage, but has a lower accuracy rate due to its impressive firepower.<br \/> An exceptional weapon when used in combination with the Tech Center's precision targeter.", "price": 7, "currency": "real", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_5_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 1, "item_name": "PLT-3030", "item_caption": "LONG-RANGE+ROCKET", "item_prefix": "rocket", "item_id": 5, "item_cv": "12000cb1101fd616c9bc11a0a2ed8400", "price_plain": "7 U.", "event_item_enabled": 0, "loot_id": "ammunition_rocket_plt-3030"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/rocket\/plt-3030_100x100.png?__cv=43ea84fc8e020f3f93a7ae004be4b600", "cost": "7 U.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": false, "isRocket": true}, "ammunition_rocket_plt-2021": {"category": "rocket", "name": "PLT-2021", "nameShort": "LONG-RANGE ROCKET", "description": "Long-range rocket: causes up to 4,000 points per rocket fired", "price": 5, "currency": "real", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_3_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 1, "item_name": "PLT-2021", "item_caption": "LONG-RANGE+ROCKET", "item_prefix": "rocket", "item_id": 3, "item_cv": "7f58a0ef6312b174407d72dbc63de500", "price_plain": "5 U.", "event_item_enabled": 0, "loot_id": "ammunition_rocket_plt-2021"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/rocket\/plt-2021_100x100.png?__cv=57dc1c46160862d3e6e73e451764ab00", "cost": "5 U.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": false, "isRocket": true}, "ammunition_rocket_plt-2026": {"category": "rocket", "name": "PLT-2026", "nameShort": "MID-RANGE ROCKET", "description": "Mid-range rocket: causes up to 2,000 damage points per rocket fired", "price": 500, "currency": "virtual", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_2_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 0, "item_name": "PLT-2026", "item_caption": "MID-RANGE+ROCKET", "item_prefix": "rocket", "item_id": 2, "item_cv": "f44edb46ddcf5240589d9fa19cb75400", "price_plain": "500 C.", "event_item_enabled": 0, "loot_id": "ammunition_rocket_plt-2026"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/rocket\/plt-2026_100x100.png?__cv=58fdf543bd4fbd7bfd7bcb011c9d1100", "cost": "500 C.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": false, "isRocket": true}, "ammunition_rocket_r-310": {"category": "rocket", "name": "R310", "nameShort": "SHORT-RANGE ROCKET", "description": "Short-range rocket: causes up to 1,000 damage points per rocket fired", "price": 100, "currency": "virtual", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_1_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 0, "item_name": "R310", "item_caption": "SHORT-RANGE+ROCKET", "item_prefix": "rocket", "item_id": 1, "item_cv": "cb7c34b317d89ac554e8158875fe9f00", "price_plain": "100 C.", "event_item_enabled": 0, "loot_id": "ammunition_rocket_r-310"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/rocket\/r-310_100x100.png?__cv=9d29b47ca17ee0316f80a4bee39c9600", "cost": "100 C.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": false, "isRocket": true}, "ammunition_rocketlauncher_eco-10": {"category": "rocket", "name": "ECO-10 rocket", "nameShort": "HELLSTORM", "description": "The multi-angle damage rocket for smart spenders. Your toughest enemies won't stand a chance against the many broadsides of the ECO Hellstorm.", "price": 1500, "currency": "virtual", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_52_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 0, "item_name": "ECO-10", "item_caption": "HELLSTORM", "item_prefix": "rocket", "item_id": 52, "item_cv": "5eeb950a0020b5f4fed430e9776cb200", "price_plain": "1,500 C.", "event_item_enabled": 0, "loot_id": "ammunition_rocketlauncher_eco-10"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/rocketlauncher\/eco-10_100x100.png?__cv=64ae584f553ab15e1dcacd7a7a595e00", "cost": "1,500 C.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": false, "isRocket": true}, "ammunition_rocketlauncher_sar-01": {"category": "rocket", "name": "SAR-01 rocket", "nameShort": "HELLSTORM", "description": "The Hellstorm SAR-01, a Shield Leeching rocket, is fired from a rocket launcher. An especially good quick-strike weapon! ", "price": 2000, "currency": "virtual", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_53_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 0, "item_name": "SAR-01", "item_caption": "HELLSTORM", "item_prefix": "rocket", "item_id": 53, "item_cv": "71e0e1b9c393bfb26a539c0c2bdf8100", "price_plain": "2,000 C.", "event_item_enabled": 0, "loot_id": "ammunition_rocketlauncher_sar-01"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/rocketlauncher\/sar-01_100x100.png?__cv=8a240cd56aafb6e2f731693a9eda5c00", "cost": "2,000 C.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": false, "isRocket": true}, "ammunition_mine_acm-01": {"category": "rocket", "name": "ACM-1", "nameShort": "MINE", "description": "Proximity mine: 20% damage upon detonation", "price": 100, "currency": "real", "nameBackgroundImageUrl": "\/do_img\/global\/text_tf.esg?l=en&s=12&t=rocket_11_code&f=eurostyle_thea&color=white&bgcolor=grey", "flash": {"parameters": {"src": "\/swf_global\/shopdetails.swf?__cv=ac0ef34b601550b98a79d2318dd67800", "version": [10, 0], "id": "shopdetails", "width": "253", "height": "206", "wmode": "transparent", "bgColor": "schwarz", "allowScriptAccess": "always"}, "variables": {"cdn": "http:\/\/127.0.0.1\/", "elite_icon_cv": "4738d9ac735bc66ddb9d288a3d982e00", "background_cv": "5a3549d51b64b3301a596e7197760500", "limited_icon_cv": "74e9a59f2ccf5e2a3a69ebead990c200", "limited_std_icon_cv": "506294ad55b3114581a227681644e200", "elite": 1, "item_name": "ACM-1", "item_caption": "MINE", "item_prefix": "rocket", "item_id": 11, "item_cv": "934da884d3eabff326ce41145702ce00", "price_plain": "100 U.", "event_item_enabled": 0, "loot_id": "ammunition_mine_acm-01"}}, "itemListImageUrl": "\/do_img\/global\/items\/ammunition\/mine\/acm-01_100x100.png?__cv=7111672f8762e1eb473248272678ea00", "cost": "100 U.", "isAmountSetable": true, "amountsSelectable": ["ten", "hundred", "thousand", "max"], "maxAmount": 100000, "isConsumingCargoSpace": true, "isActiveEventItem": false, "requiresShipInActiveHangar": true, "discountPercent": null, "discountTooltipText": null, "isPaymentItem": false, "weight": 1, "isBattery": false, "isRocket": true}},
<?php endif; ?>
        numItems: 23,
                startupItemId: 'ammunition_laser_lcb-10',
                userDroneAmount: 0,
                maxDroneAmount: 10,
                language: 'en'
        };
                User.Parameters = {"balance": {"uridium":<?php echo $Users->DataRow['uri']; ?>, "credits":<?php echo $Users->DataRow['credits']; ?>}, "discountFactor": 1, "language": "en", "ship": {"laserAmmunitionSpace": <?php if ($unity->cPT($Users->DataRow['premium'])): echo "1000000"; else: echo "100000"; /*$shop->spaceleft('Batteries');*/ endif; ?>, "rocketSpace": <?php if ($unity->cPT($Users->DataRow['premium'])): echo "1000000"; else: echo "100000"; /*$shop->spaceleft('Rockets');*/ endif; ?>}, "isActiveHangarEmpty": false, "isShipDumpEmpty": true, "pet": {"hasPet": false, "level": 0, "fuel": 0, "maxFuel": 0}};
                //add texts
                var textResources = {"items_shop_buy_confirm_s": "Do you really want to buy <b>%ITEMNAME%<\/b> for <b>%ITEMPRICE%<\/b>?", "items_shop_buy_confirm_p": "Do you really want to buy %AMOUNT%x of <b>%ITEMNAME%<\/b> for <b>%ITEMPRICE%<\/b>?", "items_shop_abo_confirm": "Do you really want to subscribe to <b>%itemName%<\/b>?", "booster_subscription_cancel_confirmation": "Do you really want to end your \"%BOOSTERNAME%\" subscription?", "drone_have_max": "Too many drones; you can't buy any more.", "thousands_separator": ",", "decimal_separator": ".", "pricetag_credits_compact": "%VALUE% C.", "pricetag_uridium_compact": "%VALUE% U.", "items_currency_realcurrency_credits": "Credits", "items_booster_subscription_cancel_confirmation": "Do you really want to end your \"%BOOSTERNAME%\" booster subscription?", "booster_subscription_running": "Booster subscription active", "booster_countdown": "Remaining time: %DAYS% days %HOURS% hours %MINUTES% min.", "error_pet_name_char": "Invalid characters used in the P.E.T. name. Please only use letters and digits.", "error_pet_name_length": "The P.E.T. name must be between 1 and 24 characters long.", "shop_itemNameWithLevel": "%ITEMNAME% (Level: %LEVEL%)", "shop_techfactory_long": "You may construct the item in the tech factory.", "shop_techfactory": "Tech Factory", "tf_message_not_enough_uridium": "Not enough Uridium available", "tf_message_not_enough_credits": "Not enough Credits available", "buy_toManyBATTERY": "You already have the max. amount of laser ammo on board!", "buy_toManyROCKET": "You already have the max. number of rockets on board!", "pet_gear_requirement": "Required: P.E.T. Level %level%", "current_in_use": "In use", "buy_pet_invalidFuelAmount": "Your P.E.T. cannot hold that much fuel.", "active_hangar_empty": "Purchase unsuccessful.<br>The hangar that is currently activated is empty.", "active_hangar_empty_equip": "You must first place a ship in the hangar.", "active_hangar_empty_buy": "You must first acquire a ship and then place it in this hangar. ", "hint_go_to_payment": "Need more Uridium? Click here to add some more Uridium!"};
                jQuery.each(textResources, function(i, n) {
                Tools.Text.setResource(i, n)
                });
                Tools.Popup.Parameters = {"showOnLoad": false, "type": "success", "content": ""};
                if ('') {
        jQuery("#discount").qtip({
        content: '',
                style: 'dohdr',
                width: 50,
                position: {target: 'mouse'}
        });
        }


</script>

