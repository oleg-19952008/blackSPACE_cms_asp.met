<?php
$base->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$hid = $base->HangarId();
$base->getShips();
$unity->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$unity->levelCorrection();
?>

<div class="header_standard" id="header_intern">


    <div id="header_ship" style="background-image: url(/do_img/global/header/ships/model<?php echo $base->shipn; ?>.png?__cv=785a4e646637f4307c1d3873ceffec00)"></div>
    
    <div id="header_top_bar">
        <div id="header_top_id" class="header_top_item">
            <div class="header_item_wrapper">
                <img src="./do_img/global/header/buttons/icon_stats_ID.png?__cv=a4bc90727a951c42f0901a307858ca00" width="16" height="13" alt="" />
                <span><?php echo $Users->DataRow['playerID']; ?></span>
            </div>
        </div>
        <div id="header_top_level" class="header_top_item">
            <div class="header_item_wrapper">
                <img src="./do_img/global/header/buttons/icon_stats_lvl.png?__cv=b84d7d86e451fdfbaa2115080867b100" width="16" height="13" alt="" />
                <?php echo $Users->DataRow['level']; ?>
            </div>
        </div>
        <div id="header_top_hnr" class="header_top_item">
            <div class="header_item_wrapper">
                <img src="./do_img/global/header/buttons/icon_stats_hon.png?__cv=7fdab834dd65f0860a51a616caa05800" width="16" height="13" alt="" />
                <span><?php echo number_format($Users->DataRow['honor']); ?></span>
            </div>
        </div>
        <div id="header_top_exp" class="header_top_item">
            <div class="header_item_wrapper">
                <img src="./do_img/global/header/buttons/icon_stats_exp.png?__cv=e2d3b6193cbab9dd23d67638df826700" width="16" height="13" alt="" />
                <span><?php echo number_format($Users->DataRow['exp']); ?></span>
            </div>
        </div>
    </div>
    <div id="header_second_bar">
        <script type="text/javascript" src="/js/externalDefault/lpInstances.js"></script>
        <div id="header_button_home" onclick="do_redirect('/indexInternal.es.php?action=internalStart')"></div>
        <!--<div id="header_button_server" onclick="Main.getInstanceList()"></div>-->
        <div id="header_button_logout" onclick="do_redirect('/indexInternal.es.php?action=externalLogout')"></div>
        <div id="header_button_help" onclick="showHelp()"></div>

    </div>


    <div id="header_main">
        <div id="header_hangar_slots">
            <a showHangarInfo="pCk"
               class="header_hangar_slot
               current_slot"
               href="indexInternal.es.php?action=internalDock&tpl=internalDockEquipment"
               >
                1
            </a>
            <a class="header_hangar_slot_getNext"
               href="indexInternal.es.php?action=internalDock&tpl=internalDockShips&lootId=hangar_slot">+</a>
            <div id="header_hangar_arrow"></div>
        </div>

        <div id="hangar_slot_current"></div>
        <div id="hangar_slot_arrow"></div>

        <div id="header_main_left">
            <a class="header_std_btn header_lft_std" id="hangar_btn" href="/indexInternal.es.php?action=internalDock">
                <img src="/text?t=HANGAR&w=6&s=10&color=lightestBlue&b=darkblue" alt="" />
            </a>
       <?php
            $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
            $clanid = $clan->getMyClan($Users->DataRow['playerID']);
            if ($clanid == 0):
                ?>
                <a class="header_std_btn header_lft_std" id="clan_btn" href="/indexInternal.es.php?action=internalNewClan">
                    <img src="/text?t=CLAN&w=4&s=10&color=lightestBlue&b=darkblue" alt="" />
                </a>
                <?php
            else:
                ?>
                <a class="header_std_btn header_lft_std" id="clan_btn" href="/indexInternal.es.php?action=internalClan">
                    <img src="/text?t=CLAN&w=4&s=10&color=lightestBlue&b=darkblue" alt="" />
                </a>
            <?php
            endif;
            ?>

            <a class="header_std_btn header_lft_std" id="upgrades_btn" href="/indexInternal.es.php?action=internalItemUpgradeSystem">
                <img src="/text?t=GAME IN 1366x768&w=16&s=9&color=lightestBlue&b=darkblue" alt="" />
            </a>

            <a class="header_std_btn header_lft_email" id="mail_btn" href="/indexInternal.es.php?action=internalMessaging">
                <!--                            <div id="emailHighlight"></div>                            -->
                <img src="/text?t=GAME IN 1920x1080&w=15&s=8&color=lightestBlue&b=darkblue" />
            </a>

            <a class="header_big_btn header_lft_big" id="profile_btn" href="/indexInternal.es.php?action=internalPilotSheet">
               <img src="/text?t=GAME IN 1440x900&w=15&s=8&color=lightestBlue&b=darkblue"" />
            </a>
        </div>

        <div id="header_main_middle">
            <?php if ($unity->cPT($Users->DataRow['premium'])): ?>
                <div id="header_is_premium"></div>
                <?php
            else:
                echo '<div id="ip_placeholder"></div>';
            endif;
            ?>

            <div id="header_start_btn" >
                <img src="/text?t=START&w=8.5&s=18&color=white&h=19&b=grey" />
            </div>

            <a class="header_event_wrapper" href="/indexInternal.es.php?action=internalPilotSheet&tpl=friends">
                <img class="txt_img" src="/text?t=FRIENDS %26 BONUSES&w=14&s=9&color=lightestBlue" />
            </a>
        </div>

                <div id="header_main_right">
            <a class="header_std_btn header_rgt_std" id="shop_btn" href="/indexInternal.es.php?action=internalDock&tpl=internalDockShips" alt="">
                <img src="/text?t=SHOP&w=5&s=10&color=lightestBlue&b=darkblue" alt="" />
            </a>
            <a class="header_std_btn header_rgt_std" id="trade_btn" href="/indexInternal.es.php?action=internalAuction">
                <img src="/text?t=GAME IN 1024х576&w=15&s=9&color=lightestBlue&b=darkblue" />
            </a>
            <a class="header_std_btn header_rgt_std" id="uri_btn" href="/indexInternal.es.php?action=internalPayment">
                <img src="/text?t=DONATION&w=8&s=10&color=lightestBlue&b=darkblue" />            </a>

            <a class="header_std_btn header_rgt_std" id="lab_btn" href="/indexInternal.es?action=internalGalaxyGates">
                <img src="/text?t=GAME IN 2390x768&w=16&s=9&color=lightestBlue&b=darkblue" />				
            </a>
<a class="header_big_btn header_rgt_big" id="gg_btn" href="/indexInternal.es.php?action=internalNanoTechFactory">
                <img src="/text?t= TECH CENTER&w=10&s=9&color=lightestBlue&b=darkblue" />
            </a>
			
        </div>


      

    </div>
    <div id="header_bottom">
        <img id="news_overlay_left" src="./do_img/global/header/buttons/newsticker_gradient_left.png" width="123" height="26" />
        <img id="news_overlay_right" src="./do_img/global/header/buttons/newsticker_gradient_right.png" width="123" height="26" />
        <div id="header_news_wrapper">
            <ul id="header_news_ticker">
                <li id="header_news_item_benefitPremium" onclick="HeaderFunc.showNews('benefitPremium')">
                    Premium fun with Premium advantages
                </li>
                <li id="header_news_item_messageSystemLaunch" onclick="HeaderFunc.showNews('messageSystemLaunch')">
                    <span class="bn_headline">New messaging system!</span>
                </li>
                <li id="header_news_item_achievementSystemMS2" onclick="HeaderFunc.showNews('achievementSystemMS2')">
                    New title system - many new achievements
                </li>
                <li id="header_news_item_killscreen2" onclick="HeaderFunc.showNews('killscreen2')">
                    Repair your ship on the spot right now.
                </li>
                <li id="header_news_item_hangarRenamingPremium" onclick="HeaderFunc.showNews('hangarRenamingPremium')">
                    New Premium Plus! Name Your Hangars
                </li>
                <li id="header_news_item_hadesGate" onclick="HeaderFunc.showNews('hadesGate')">
                    Hades Gate - a Galaxy Gate for groups!
                </li>
            </ul>
        </div>
        <div id="header_credits" class="header_money">
<?php echo number_format($Users->DataRow['credits']); ?>
        </div>
        <a id="header_uri" class="header_money"  href="/indexInternal.es.php?action=internalPayment" >
<?php echo number_format($Users->DataRow['uri']); ?>
        </a>
    </div>
</div>
<script type="text/javascript">
    function onFailFlashembed() {
        var inner_html = '<div class="flashFailHead">Get the Adobe Flash Player</div>\n\
   <div class="flashFailHeadText">In order to play DarkOrbit, you need the latest version of Flash Player. Just install it to start playing!\n\
   <div class="flashFailHeadLink" style="cursor: pointer">Download the Flash Player here for free: <a href=\"http://www.adobe.com/go/getflashplayer\" style=\"text-decoration: underline; color:#A0A0A0;\">Download Flash Player<\/a></div></div>';

        if (!document.getElementById('flashHeader')) {
            document.getElementById('header_container').innerHTML = inner_html;
            document.getElementById('equipment_container').innerHTML = "";
            document.getElementById('materialiser').innerHTML = "";
        }

        if (document.getElementById('inventory')) {
            document.getElementById('equipment_container').innerHTML = inner_html;
        }

        if (document.getElementById('flashGG')) {
            document.getElementById('materialiser').innerHTML = inner_html;
            jQuery('#materialiser').css('margin-left', 110);
            jQuery('#materialiser').css('margin-top', 40);
        }
    }

    function expressInstallCallback(info) {
        // possible values for info: loadTimeOut|Cancelled|Failed
        onFailFlashembed();
    }

    /* this is a hack because the this.hideEmailInviteDialog which is defined as the callback function in the social plugin does not work. So i need this hack for now */
    function hackEmailInviteDialog() {
        var invite_bg = jQuery('#social-invite-container #invite-dialog #invite-bg .invite-dialog-header');
        /*var invite_bg = jQuery('#social-invite-container #invite-dialog #invite-bg');*/
        var closeButton = jQuery('.close');
        closeButton.remove();
        var closeDiv = jQuery(document.createElement('div'))
                .attr('id', 'emailInviteCloseButton')
                .appendTo(invite_bg);
    }

    jQuery(document).ready(function() {
        hackEmailInviteDialog();
        jQuery('#emailInviteCloseButton').click(function() {
            var inviteDialog = jQuery('#invite-dialog');
            var inviteResult = jQuery('.invite-result');
            inviteDialog.css('display', 'none');
            inviteResult.css('display', 'none');
            hideBusyLayer();
            inviteIncentives.mailInviteCallback();
        });

        jQuery(".header_hangar_slot").mouseover(function() {
            jQuery("#hangarInfoLayer").show();

        });

        jQuery(".header_hangar_slot").mouseout(function() {
            jQuery("#hangarInfoLayer").hide();
        });

        /**
         * Apply jScrollpane to history log table
         * if the element is available.
         */
        var tableHistory = jQuery('#table_history'),
                isTableHistoryPresent = 0 < tableHistory.length,
                historyContainer;

        if (isTableHistoryPresent) {
            historyContainer = tableHistory.find('#text_history');
            historyContainer.jScrollPane({
                showArrows: true
            });
        }
        ;

        // Initial parameter for SLAYER
        var parameter = {
            // BASIC SETTINGS
            gameId: 22,
            gameTitle: 'Darkorbit',
            dispatcherUrl: '/socialAPI/mailInvite.php', // The path where you call the dispatcher

            instanceId: '1',
            affiliateId: '0',
            userId: '<?php echo $Users->DataRow['ID']; ?>', // globalID
            userKeyId: '<?php echo $Users->DataRow['playerID']; ?>', // userID (of your game)

            // FACEBOOK SETTINGS
            facebook: {
                language: 'en_GB'
            },
            // GOOGLE SETTINGS Vicens
            google: {
                language: 'en-GB'
            },
            invite: {
                currentUsername: '<?php echo $Users->DataRow['Name']; ?>', // After initiating the invite dialog, this functions gets called with information wether it was successful or not
                hideButton: true, // Default: True \| Wether to show an invite dialog button or not (Set to false if You want to call the dialog directly)
                /*onComplete       : inviteIncentives.mailInviteCallback(),*/                     // This function gets called after the user closes the Invite Dialog
                editableUsername: true,
                showTooltip: true,
                /*onReady          : inviteIncentives.mailInviteCallback(),     */                // After initiating the invite dialog, this functions gets called with information wether it was successful or not*/
                inviteUrl: 'http://<?php echo DynHost; ?>/', // Define Your invite url

                // Tabs
                defaultTab: 'Mail', // Defines which tab is shown initially. Can be: 'Mail' (default if facebookTab is false), 'Facebook' (default if facebookTab is true) or 'Buddy'
                facebookTab: true, // Defines wether to show the Facebook tab or not
                buddyList: false, // Defines wether to show the Buddylist and Friendsearch or not
                friendSearch: {
                    enable: false, // Default: False
                    url: '/socialAPI/friendSearch.php'        // Url to Your search engine
                }
            },
            // GAME EVENT SERVICE
            events: {}                                       // You just need to place this empty object inside the initParameter to tell SLAYER it should initiate the GES
        }

        SLAYER.init(parameter);
    });
</script>
