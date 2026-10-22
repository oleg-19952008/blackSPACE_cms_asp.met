<?php
$factory->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$args = $factory->getTimes();
//print_r($args);
?>

<script type="text/javascript" charset="UTF-8">
    /* <![CDATA[ */
    xajax_disableTradeLayer = function() {
        return xajax.request({xjxfun: 'disableTradeLayer'}, {parameters: arguments});
    };
    xajax_buySkylabRobot = function() {
        return xajax.request({xjxfun: 'buySkylabRobot'}, {parameters: arguments});
    };
    xajax_skillTreePurchaseSkillReset = function() {
        return xajax.request({xjxfun: 'skillTreePurchaseSkillReset'}, {parameters: arguments});
    };
    xajax_skillTreePurchaseLevelUp = function() {
        return xajax.request({xjxfun: 'skillTreePurchaseLevelUp'}, {parameters: arguments});
    };
    xajax_nanoTechFactoryShowBuff = function() {
        return xajax.request({xjxfun: 'nanoTechFactoryShowBuff'}, {parameters: arguments});
    };
    xajax_nanoTechFactoryShowApis = function() {
        return xajax.request({xjxfun: 'nanoTechFactoryShowApis'}, {parameters: arguments});
    };
    xajax_handleImageUpload = function() {
        return xajax.request({xjxfun: 'handleImageUpload'}, {parameters: arguments});
    };
    xajax_pilotSheet = function() {
        return xajax.request({xjxfun: 'pilotSheet'}, {parameters: arguments});
    };
    xajax_achievement = function() {
        return xajax.request({xjxfun: 'achievement'}, {parameters: arguments});
    };
    xajax_pilotInvite = function() {
        return xajax.request({xjxfun: 'pilotInvite'}, {parameters: arguments});
    };
    xajax_pilotInviteIncentives = function() {
        return xajax.request({xjxfun: 'pilotInviteIncentives'}, {parameters: arguments});
    };
    xajax_externalPPP = function() {
        return xajax.request({xjxfun: 'externalPPP'}, {parameters: arguments});
    };
    xajax_socialInviteDispatch = function() {
        return xajax.request({xjxfun: 'socialInviteDispatch'}, {parameters: arguments});
    };
    xajax_tooltipAjaxHandler = function() {
        return xajax.request({xjxfun: 'tooltipAjaxHandler'}, {parameters: arguments});
    };
    xajax_showHelpNeverAgain = function() {
        return xajax.request({xjxfun: 'showHelpNeverAgain'}, {parameters: arguments});
    };
    xajax_loadUserInfo = function() {
        return xajax.request({xjxfun: 'loadUserInfo'}, {parameters: arguments});
    };
    xajax_switchHangar = function() {
        return xajax.request({xjxfun: 'switchHangar'}, {parameters: arguments});
    };
    xajax_loadHangarInfo = function() {
        return xajax.request({xjxfun: 'loadHangarInfo'}, {parameters: arguments});
    };
    xajax_setHangarSelected = function() {
        return xajax.request({xjxfun: 'setHangarSelected'}, {parameters: arguments});
    };
    xajax_changeHangarName = function() {
        return xajax.request({xjxfun: 'changeHangarName'}, {parameters: arguments});
    };
    xajax_feedbackForm = function() {
        return xajax.request({xjxfun: 'feedbackForm'}, {parameters: arguments});
    };
    xajax_setFeedBackForm = function() {
        return xajax.request({xjxfun: 'setFeedBackForm'}, {parameters: arguments});
    };
    xajax_getCompanionAppCode = function() {
        return xajax.request({xjxfun: 'getCompanionAppCode'}, {parameters: arguments});
    };
    xajax_signupArena = function() {
        return xajax.request({xjxfun: 'signupArena'}, {parameters: arguments});
    };
    xajax_loadAuctionQuantityManager = function() {
        return xajax.request({xjxfun: 'loadAuctionQuantityManager'}, {parameters: arguments});
    };
    xajax_getListOfInstances = function() {
        return xajax.request({xjxfun: 'getListOfInstances'}, {parameters: arguments});
    };
    xajax_loadClanInfo = function() {
        return xajax.request({xjxfun: 'loadClanInfo'}, {parameters: arguments});
    };
    /* ]]> */
</script>
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
                            <style  type="text/css">

                                .tabLabelSkylabActive {
                                    background-image: url("text?t=SKYLAB&w=5&s=9&color=black&b=lightestBlue");
                                }
                                .tabLabelSkylabInActive {
                                    background-image: url(text?t=SKYLAB&w=5&s=9&color=white&b=grey);
                                }
                                .tabLabelTechFactoryActive {
                                    background-image: url("./text?t=TECH CENTER&w=9&s=9&color=black&b=lightestBlue");
                                }
                                .tabLabelTechFactoryInActive {
                                    background-image: url("text?t=TECH CENTER&w=9&s=9&color=white&b=grey");
                                }
                                .tabLabelItemUpgradeSystemActive {
                                    background-image: url("./text?t=ITEM UPGRADING&w=12&s=9&color=black&b=lightestBlue");
                                }
                                .tabLabelItemUpgradeSystemInActive {
                                    background-image: url("text?t=ITEM UPGRADING&w=12&s=9&color=white&b=grey");
                                }

                            </style>

                            <script language="javascript" type="text/javascript" src="./js/techFactory.js?__cv=e44d514708f44aa54bad684c899f4f00"></script>
                            <script type="text/javascript">
        Tools.Text.setResource('message_confirm_deleteTechs', 'Are you sure you want to delete this production facility\'s tech items?');
                            </script>

                            <input type="hidden" id="actionFile" value="internalNanoTechFactory" />

                            <div id="nanoTechFactory">
                                <div id="subnav">
                                    <div id="tabButton1" class="tabButtonInActive"
                                         onmouseover="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
                                         onmouseout="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
                                         onclick="do_redirect('indexInternal.es?action=internalSkylab');"
                                         style='cursor: pointer; float: left; width: 184px; height: 25px;'>
                                        <div id="tabLabel1" class="tabLabelInActive tabLabelSkylabInActive"></div>
                                    </div>
                                    <div id="tabButton2" class="tabButtonActive"
                                         onmouseover="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
                                         onmouseout="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
                                         onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory');"
                                         style='cursor: pointer; float: left; width: 184px; height: 25px;'>
                                        <div id="tabLabel2" class="tabLabelInActive tabLabelTechFactoryActive"></div>
                                    </div>
                                    <div id="tabButton3" class="tabButtonInActive"
                                         onmouseover="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
                                         onmouseout="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
                                         onclick="do_redirect('indexInternal.es?action=internalItemUpgradeSystem');"
                                         style='cursor: pointer; float: left; width: 184px; height: 25px;'>
                                        <div id="tabLabel3" class="tabLabelInActive tabLabelItemUpgradeSystemInActive"></div>
                                    </div>
                                </div>
                                <div class="nanoTechFactory">
                                    <div id="ntf_left">
                                        <div id="title_factory_left" title="Construction">Construction</div>
                                        <div id="title_buff" title="Tech items">Tech items</div>
                                        <div id="factory_list_main">
                                             <div id="factory_apis" class="buff" onclick="jQuery('#ntf_right_tech').hide();
                                                    jQuery('#ntf_right_factory').show();
                                                    xajax_nanoTechFactoryShowApis(3, '')">
                                                <div class="factory_apis_hover" title="Apis drone"></div>
                                            </div>
                                            <div id="factory_zeus" class="buff" onclick="jQuery('#ntf_right_tech').hide();
                                                    jQuery('#ntf_right_factory').show();
                                                    xajax_nanoTechFactoryShowApis(4, '')">
                                                <div class="factory_zeus_hover" title="Zeus drone"></div>
                                            </div> 
                                        </div>
                                        <div id="buff_list_main">
                                            <div id="buff_list_scroll">
                                                <div id="buff_ELA_1" class="buff" onclick="jQuery('#ntf_right_factory').hide();
                                                        jQuery('#ntf_right_tech').show();
                                                        xajax_nanoTechFactoryShowBuff('ELA', '1')">
                                                    <div class="buff_hover" title="Energy leech"></div>
                                                </div>
                                                <div id="buff_ECI_1" class="buff" onclick="jQuery('#ntf_right_factory').hide();
                                                        jQuery('#ntf_right_tech').show();
                                                        xajax_nanoTechFactoryShowBuff('ECI', '1')">
                                                    <div class="buff_hover" title="Chain impulse"></div>
                                                </div>
                                                <div id="buff_RPM_1" class="buff" onclick="jQuery('#ntf_right_factory').hide();
                                                        jQuery('#ntf_right_tech').show();
                                                        xajax_nanoTechFactoryShowBuff('RPM', '1')">
                                                    <div class="buff_hover" title="Precision targeter"></div>
                                                </div>
                                                <div id="buff_SBU_1" class="buff" onclick="jQuery('#ntf_right_factory').hide();
                                                        jQuery('#ntf_right_tech').show();
                                                        xajax_nanoTechFactoryShowBuff('SBU', '1')">
                                                    <div class="buff_hover" title="Backup shields"></div>
                                                </div>
                                                <div id="buff_BRB_1" class="buff" onclick="jQuery('#ntf_right_factory').hide();
                                                        jQuery('#ntf_right_tech').show();
                                                        xajax_nanoTechFactoryShowBuff('BRB', '1')">
                                                    <div class="buff_hover" title="Battle repair bot"></div>
                                                </div>
                                                <br class="clearMe">
                                            </div>
                                        </div>
                                    </div>

                                    <div id="buffcontainer">
                                        <div id="ntf_center">
                                            <div id="ntf_help_scroll" style="overflow-y: auto;">
                                                <div id="ntf_help_content">
                                                    Tech Center info</span>
                                                    <p>The Tech Center is a factory where you can use various materials to produce hi-tech defense and attack items, including <strong><a href="#faq_techs">Tech items</a></strong> and drones.<br><br>
                                                    <ul>
                                                        <li>Select an item to produce from the left-hand menu in the <strong><a href="#faq_tf">Factory</a></strong>.</li>
                                                        <li>Click on Produce to make the item: Make sure you have all the required <strong><a href="#tf_resources">materials</a></strong> for production.</li>
                                                        <li>Build extra <strong><a href="#tf_factory">production facilities</a></strong> to produce multiple items simultaneously.</a></li>
                                                    </ul></p>
                                                    <p>
                                                        Or:<br>
                                                    <ul>
                                                        <li>Select a drone type in the Factory</li>
                                                        <li>and build the drone instantly for Uridium.</li>
                                                        <li>In the pirate booty you'll sometimes find pieces of the blueprints. The advantage: You can build a drone with them without additional costs.</li>
                                                        <li>Tip: Each piece of the blueprints that you find reduces the price for buying it immediately.</li>
                                                    </ul><br>
                                                    Use tech items in <strong><a href="#tf_factory">battle</a></strong> directly on the space map. Start now and turn your ship into the ultimate spacefighter!<br><br>
                                                    For more information, take a look in our <strong><a href="#faq_tf">FAQ</a></strong>!</p>
                                                    <br class="linecountSix">
                                                    <a name="faq_tf" ></a>
                                                    <span class="text_headline">What exactly is the Tech Center?</span><br /><p>The Tech Center is a factory where you can produce hi-tech items that can be used to acquire new skills or enhance existing ones. There are many different tech items available.</p>
                                                    <span class="text_headline">Where is the Tech Center located?</span><br />
                                                    <p>The Tech Center can be found in the Skylab. Click on Skylab in the main menu and the Skylab page will open. There are two tabs on this page: One for the Skylab and one for the Tech Center. Click on the Tech Center tab to go there.</p>
                                                    <a name="faq_techs"></a>
                                                    <span class="text_headline">What type of tech items can be produced?</span><br />
                                                    <p>There are many different items that can be produced in the Tech Center, such as:
                                                    <ol>

                                                        <li><a href="#help_subnav_ELA_1">Energy leech</a></li>

                                                        <li><a href="#help_subnav_ECI_1">Chain impulse</a></li>

                                                        <li><a href="#help_subnav_RPM_1">Precision targeter</a></li>

                                                        <li><a href="#help_subnav_SBU_1">Backup shields</a></li>

                                                        <li><a href="#help_subnav_BRB_1">Battle repair bot</a></li>
                                                    </ol>



                                                    <a name="help_subnav_ELA_1"></a><strong class="text_subheadline">Energy leech</strong><br />
                                                    <p>Plain and simple: The more damage you inflict on your enemy, the more the energy leech will repair your ship.<br>
                                                        This item transforms a certain percentage of the laser damage you cause into HP and transfers it back to your ship in the form of energy, thus allowing you to repair your ship.</p>



                                                    <a name="help_subnav_ECI_1"></a><strong class="text_subheadline">Chain impulse</strong><br />
                                                    <p>When you shoot at an enemy with the chain impulse, it emits an energy pulse which inflicts damage on your target. The pulse then ricochets to your next adversary, and the next one, causing each one less damage than the one before.
                                                        It can inflict damage on a maximum of 7 opponents, after which it dissipates, becoming too weak to damage further ships. The chain impulse penetrates through all shields, causing direct damage to the ships in its path.</p>



                                                    <a name="help_subnav_RPM_1"></a><strong class="text_subheadline">Precision targeter</strong><br />
                                                    <p>This tech item increases your hit ratio to 100% for a certain amount of time.</p>



                                                    <a name="help_subnav_SBU_1"></a><strong class="text_subheadline">Backup shields</strong><br />
                                                    <p>The backup shields are a type of reserve shield. If your regular shield is destroyed in battle, the backup shields will replace some of your shield defenses instantly.</p>



                                                    <a name="help_subnav_BRB_1"></a><strong class="text_subheadline">Battle repair bot</strong><br />
                                                    <p>The battle repair bot functions like a normal repair bot, but it was developed for use in battle situations. It can resist enemy fire for a short time, repairing 10,000 HP per second for 10 seconds.</p>


                                                    <span class="text_headline">How many tech items can be produced?</span><br />
                                                    <p>At the beginning, you can only produce one tech item at a time. If you build multiple production facilities, you can produce multiple items simultaneously. Once your Tech Center has been completely expanded, you'll be able to produce three tech items at once.</p>
                                                    <a name="tf_resources"></a><span class="text_headline">What materials are needed to produce tech items?</span><br />
                                                    <p>The materials needed to make tech items are Credits, Seprom and log-disks. Credits and log-disks can be collected in the game and Seprom has to created in the Skylab.</p>
                                                    <span class="text_headline">Can tech items be produced if all required materials aren't available?</span><br />
                                                    <p>Yes. In this case, you can replace the missing materials with Uridium. Uridium helps to speed up the production process.</p>
                                                    <a name="tf_factory"></a><span class="text_headline">Where do the finished tech items go? How can they be used?</span><br />
                                                    <p>Your tech items will appear in a special box on the space map once they have been manufactured. There you'll be able to see how long you can use them for and how long the cool-down time is. Click on the tech item symbol to use the item.</p>
                                                    <span class="text_headline">Can I use multiple tech items at once?</span><br />
                                                    <p>Yes. Using multiple tech items at once will turn your ship into an ultimate starfighter. Remember to use your tech items effectively: Combine different types of tech items for a killer effect. Combining the same type of tech items won't do much for you.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>

                                        jQuery(document).ready(function() {
                                            jQuery(function() {
                                                jQuery('#ntf_help_scroll').jScrollPane({autoReinitialise: true, showArrows: true});
                                            });
                                        })
                                    </script>

                                    </script>
                                </div>

                                <div id="ntf_right_tech" >
                                    <div id="title_factory_right" title="Production">Production</div>
                                    <div id="hall_list_main">
                                        <script>
                                            counter = new Array();
                                        </script>


                                        <?php
                                        if ($args['slot_one'] != "locked") {
                                            if ($args['slot_one'] != "none") {
                                                $ex = explode("|", $args['slot_one']);
                                                $real = substr($ex[0], 1);
                                                $cls = "hall_buff_" . $real . "_1";
                                            } else {
                                                $cls = "";
                                                $ex = array();
                                                $ex[0] = "";
                                                $ex[1] = "";
                                                $ex[2] = 0;
                                                $real = "";
                                            }
                                            ?>
                                            <div id="hall_1" class="hall_list">

                                                <div class="hall_singleView hall_active">


                                                    <div class="hall_buff <?php echo $cls; ?>" onclick="xajax_nanoTechFactoryShowBuff('<?php echo $real; ?>', '1', '1')">
                                                        <?php   if ($ex[2] == 0) { ?>
                                                            <div class="hall_stackBuffBG"><div class="hall_stackBuffNumber"><?php echo $ex[1]; ?></div></div>
                                                        <?php }else{ ?>
                                                            <div class="hall_buff_in_progress"></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($ex[2] == 0) {
                                                    echo '<div class="hall_info">Ready</div>';
                                                } else {
//                                                   if($factory->updateStatus($args[$ex[0]], 'slot_one')){
//                                                        echo '<script type="text/javascript">location.reload();</script>';
//                                                   }else{
//                                                        
//                                                  }
                                                    $seconds = $factory->getSeconds($args[$ex[0]]);
                                                    echo '<div class="hall_info" id="remainingTime_1"></div>';
                                                    ?>
                                                    <script type="text/javascript">
                                                        counter[1] = <?php echo $seconds; ?>;

                                                        function updateRemainingTime(id) {
                                                            counter[id] = counter[id] - 1;
                                                            if (counter[id] <= 0)
                                                                counter[id] = 0;
                                                            h = Math.floor(counter[id] / 3600);
                                                            m = Math.floor((counter[id] - (h * 3600)) / 60);
                                                            s = Math.floor(counter[id] - h * 3600 - m * 60);

                                                            if (h == 0 && m == 0 && s == 1) {
                                                                jQuery.ajax({
                                                                    type: 'GET',
                                                                    async: false,
                                                                    url: "./ajax/nanoTechfactory/techShop.php?secureLoader=true&userid=<?php echo $Users->DataRow['playerID']; ?>&Slot=slot_one",
                                                                    success: function() {
                                                                        
                                                                    }
                                                                });
                                                                location.reload(true);
                                                            }
                                                            if (m < 10)
                                                                m = '0' + String(m);
                                                            if (s < 10)
                                                                s = '0' + String(s);

                                                            document.getElementById("remainingTime_" + id).innerHTML = String(h) + ':' + String(m) + ':' + String(s);
                                                        }

                                                        window.setInterval("updateRemainingTime(1)", 1000);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div id="hall_1" class="hall_list">
                                                <div class="hall_singleView hall_inactive">

                                                </div>

                                                <div class="hall_buy" onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory&subaction=expandHall&facilityID=2&reloadToken=30b872b08a241fb05891da7e81e8e0ac')">50,000 U.</div>

                                            </div>
                                            <?php
                                        }
                                        if ($args['slot_two'] != "locked") {
                                            if ($args['slot_two'] != "none") {
                                                $ex = explode("|", $args['slot_two']);
                                                $real = substr($ex[0], 1);
                                                $cls = "hall_buff_" . $real . "_1";
                                            } else {
                                                $cls = "";
                                                $ex = array();
                                                $ex[0] = "";
                                                $ex[1] = "";
                                                $ex[2] = 0;
                                                $real = "";
                                            }
                                            ?>
                                            <div id="hall_2" class="hall_list">

                                                <div class="hall_singleView hall_active">


                                                    <div class="hall_buff <?php echo $cls; ?>" onclick="xajax_nanoTechFactoryShowBuff('<?php echo $real; ?>', '2', '2')">
                                                       
                                                         <?php   if ($ex[2] == 0) { ?>
                                                            <div class="hall_stackBuffBG"><div class="hall_stackBuffNumber"><?php echo $ex[1]; ?></div></div>
                                                        <?php }else{ ?>
                                                            <div class="hall_buff_in_progress"></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($ex[2] == 0) {
                                                    echo '<div class="hall_info">Ready</div>';
                                                } else {
//                                                    if($factory->updateStatus($args[$ex[0]], 'slot_two')){
//                                                        echo '<script type="text/javascript">location.reload();</script>';
//                                                    }else{
//                                                        
//                                                    }
                                                    $seconds = $factory->getSeconds($args[$ex[0]]);
                                                    echo '<div class="hall_info" id="remainingTime_2"></div>';
                                                    ?>
                                                    <script type="text/javascript">
                                                        counter[2] = <?php echo $seconds; ?>;

                                                        function updateRemainingTime(id) {
                                                            counter[id] = counter[id] - 1;
                                                            if (counter[id] <= 0)
                                                                counter[id] = 0;
                                                            h = Math.floor(counter[id] / 3600);
                                                            m = Math.floor((counter[id] - (h * 3600)) / 60);
                                                            s = Math.floor(counter[id] - h * 3600 - m * 60);

                                                           if (h == 0 && m == 0 && s == 1 ) {
                                                                jQuery.ajax({
                                                                    type: 'GET',
                                                                    async: false,
                                                                    url: "./ajax/nanoTechfactory/techShop.php?secureLoader=true&userid=<?php echo $Users->DataRow['playerID']; ?>&Slot=slot_two",
                                                                    success: function() {
                                                                        
                                                                    }
                                                                });
                                                                location.reload(true);
                                                            }
                                                            if (m < 10)
                                                                m = '0' + String(m);
                                                            if (s < 10)
                                                                s = '0' + String(s);

                                                            document.getElementById("remainingTime_" + id).innerHTML = String(h) + ':' + String(m) + ':' + String(s);
                                                        }

                                                        window.setInterval("updateRemainingTime(2)", 1000);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div id="hall_2" class="hall_list">
                                                <div class="hall_singleView hall_inactive">

                                                </div>

                                                <div class="hall_buy" onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory&subaction=expandHall&facilityID=2&reloadToken=30b872b08a241fb05891da7e81e8e0ac')">50,000 U.</div>

                                            </div>
                                            <?php
                                        }
                                        if($args['slot_two'] != "locked"){
                                        if ($args['slot_three'] != "locked") {
                                            if ($args['slot_three'] != "none") {
                                                $ex = explode("|", $args['slot_three']);
                                                $real = substr($ex[0], 1);
                                                $cls = "hall_buff_" . $real . "_1";
                                            } else {
                                                $cls = "";
                                                $ex = array();
                                                $ex[0] = "";
                                                $ex[1] = "";
                                                $ex[2] = 0;
                                                $real = "";
                                            }
                                            ?>
                                            <div id="hall_3" class="hall_list">

                                                <div class="hall_singleView hall_active">


                                                    <div class="hall_buff <?php echo $cls; ?>" onclick="xajax_nanoTechFactoryShowBuff('<?php echo $real; ?>', '3', '3')">
                                                         <?php   if ($ex[2] == 0) { ?>
                                                            <div class="hall_stackBuffBG"><div class="hall_stackBuffNumber"><?php echo $ex[1]; ?></div></div>
                                                        <?php }else{ ?>
                                                            <div class="hall_buff_in_progress"></div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($ex[2] == 0) {
                                                    echo '<div class="hall_info">Ready</div>';
                                                } else {
//                                                    if($factory->updateStatus($args[$ex[0]], 'slot_three')){
//                                                        echo '<script type="text/javascript">location.reload();</script>';
//                                                    }else{
//                                                        
//                                                    }
                                                    $seconds = $factory->getSeconds($args[$ex[0]]);
                                                    echo '<div class="hall_info" id="remainingTime_3"></div>';
                                                    ?>
                                                    <script type="text/javascript">
                                                        counter[3] = <?php echo $seconds; ?>;

                                                        function updateRemainingTime(id) {
                                                            counter[id] = counter[id] - 1;
                                                            if (counter[id] <= 0)
                                                                counter[id] = 0;
                                                            h = Math.floor(counter[id] / 3600);
                                                            m = Math.floor((counter[id] - (h * 3600)) / 60);
                                                            s = Math.floor(counter[id] - h * 3600 - m * 60);

                                                            if (h == 0 && m == 0 && s == 1) {
                                                                jQuery.ajax({
                                                                    type: 'GET',
                                                                    async: false,
                                                                    url: "./ajax/nanoTechfactory/techShop.php?secureLoader=true&userid=<?php echo $Users->DataRow['playerID']; ?>&Slot=slot_three",
                                                                    success: function() {
                                                                        
                                                                    }
                                                                });
                                                                location.reload(true);
                                                            }
                                                            if (m < 10)
                                                                m = '0' + String(m);
                                                            if (s < 10)
                                                                s = '0' + String(s);

                                                            document.getElementById("remainingTime_" + id).innerHTML = String(h) + ':' + String(m) + ':' + String(s);
                                                        }

                                                        window.setInterval("updateRemainingTime(3)", 1000);
                                                    </script>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div id="hall_3" class="hall_list">
                                                <div class="hall_singleView hall_inactive">

                                                </div>

                                                <div class="hall_buy" onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory&subaction=expandHall&facilityID=3&reloadToken=30b872b08a241fb05891da7e81e8e0ac')">100,000 U.</div>

                                            </div>
                                            <?php
                                        }
                                        }else{
                                            
                                        }
                                        ?>
                                        
<!--                                        <div id="hall_2" class="hall_list">
                                            <div class="hall_singleView hall_inactive">

                                            </div>

                                            <div class="hall_buy" onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory&subaction=expandHall&facilityID=2&reloadToken=30b872b08a241fb05891da7e81e8e0ac')">50,000 U.</div>

                                        </div>-->
<!--                                        <div id="hall_3" class="hall_list">
                                            <div class="hall_singleView hall_inactive">

                                            </div>

                                            <div class="hall_buy" onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory&subaction=expandHall&facilityID=2&reloadToken=30b872b08a241fb05891da7e81e8e0ac')">50,000 U.</div>

                                        </div>-->



                                    </div>
                                </div>
                                <div id="ntf_right_factory" style="display:none">
                                    <div id="title_factory_right" title="Progress"><strong>Progress</strong></div>
                                    <div id="factory_progress_main">
                                    </div>
                                    <div id="factory_progress_count" class="dronePartsDisplay" ></div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                misc.testForScrollbar("ntf_help_scroll");
                            </script>
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

    <!-- LayertoolService JavaScript Injection end -->


</body>
</html>