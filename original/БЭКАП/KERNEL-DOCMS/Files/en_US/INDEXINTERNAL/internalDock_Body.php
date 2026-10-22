<?php
//$Users->checkSession();
$base->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$hid = $base->HangarId();
if(isset($_POST['subAction']) && $_POST['subAction']=="addShipToHangar"){
    $base->changeShip($_POST['hangarId'], $_POST['inventoryId']);
}

$_SESSION['fact'] = $Users->DataRow['factionId'];
$base->getShips();

$HangarC->setId($Users->DataRow['ID']);
$HRow = $HangarC->getHData();


if(isset($_GET['sa']) && $_GET['sa']=="repair"){
	$HangarC->repairship();
}
?>

<body class="internalDock_overview" onLoad="" >
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
                <script>


function changeView(category) {
    if (category == "ship") {
        jQuery('#infoBox_ship').css('display', 'block');
        if(0 < 0) {
            jQuery('#overview_shipYard').css('display', 'block');
        } else {
            jQuery('#overview_shipYard').css('display', 'none');
        }
        jQuery('#infoBox_shipView').css('display', 'block');
        jQuery('#infoBox_drones').css('display', 'none');
        jQuery('#infoBox_droneView').css('display', 'none');
        jQuery('#nav_drones').css('display', 'none');
        jQuery('#infoBox_pet').css('display', 'none');
        jQuery('#infoBox_petView').css('display', 'none');
        if (jQuery('#repair_pet').length != 0) {
            jQuery('#repair_pet').css('display', 'none');
        }
        if (jQuery('#repair_ship').length != 0) {
            jQuery('#repair_ship').css('display', 'block');
        }
        jQuery('#overview_button_ship').attr('class', 'overview_button_active  fliess10px-gelb');
        jQuery('#overview_button_drones').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_pet').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_container').css('backgroundImage', 'url(./do_img/global/hangar/overview/bg_ship.jpg?__cv=2f0b7fa865744a15c103265953d75e00)');
        jQuery('#hangarExpansion_slotHint').show();
    } else if (category == "drone"){
        jQuery('#infoBox_ship').css('display', 'none');
        jQuery('#overview_shipYard').css('display', 'none');
        jQuery('#infoBox_shipView').css('display', 'none');
        jQuery('#infoBox_drones').css('display', 'block');
        jQuery('#infoBox_droneView').css('display', 'block');
        jQuery('#nav_drones').css('display', 'block');
        jQuery('#infoBox_pet').css('display', 'none');
        jQuery('#infoBox_petView').css('display', 'none');
        if (jQuery('#repair_pet').length != 0) {
            jQuery('#repair_pet').css('display', 'none');
        }
        if (jQuery('#repair_ship').length != 0) {
            jQuery('#repair_ship').css('display', 'none');
        }
        jQuery('#overview_button_ship').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_drones').attr('class', 'overview_button_active  fliess10px-gelb');
        jQuery('#overview_button_pet').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_container').css('backgroundImage', 'url(./do_img/global/hangar/overview/bg_drone.jpg?__cv=c6785597a7aafba50abda328a1243c00)');
        jQuery('#hangarExpansion_slotHint').hide();
    } else {
        jQuery('#infoBox_ship').css('display', 'none');
        jQuery('#overview_shipYard').css('display', 'none');
        jQuery('#infoBox_shipView').css('display', 'none');
        jQuery('#infoBox_drones').css('display', 'none');
        jQuery('#infoBox_droneView').css('display', 'none');
        jQuery('#infoBox_pet').css('display', 'block');
        jQuery('#infoBox_petView').css('display', 'block');
        if (jQuery('#repair_pet').length != 0) {
        jQuery('#repair_pet').css('display', 'block');
        }
        if (jQuery('#repair_ship').length != 0) {
        jQuery('#repair_ship').css('display', 'none');
        }
        jQuery('#nav_drones').css('display', 'none');
        jQuery('#overview_button_ship').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_drones').attr('class', 'overview_button_inactive fliess10px-weiss');
        jQuery('#overview_button_pet').attr('class', 'overview_button_active  fliess10px-gelb');
        jQuery('#overview_container').css('backgroundImage', ' url(./do_img/global/hangar/overview/bg_pet.jpg?__cv=a3e89d660ee922c2e5e0fa5425e4b100)');
        jQuery('#hangarExpansion_slotHint').hide();
    }
}

function clearDroneView (howmuch) {
    for(i = 1; i <= howmuch; i++) {
        $('drone_'+i).style.display      = 'none';
    }
    $('droneView_start').style.display = 'none';
    $('droneView_middle').style.display = 'none';
    $('droneView_end').style.display = 'none';

}

var droneView = 1;
var maxDroneView = 0;

function changeDroneView(nextView, maxView) {
    clearDroneView(maxView);
    $('droneView_middle').style.display      = 'block';

    if (nextView == "next" && droneView+1 < maxView) {
        droneView = droneView + 1;
        $('drone_'+(droneView)).style.display      = 'block';
        //$('droneView_middle').style.display      = 'block';
    } else if (nextView == 'next' && droneView+1 >= maxView) {
        droneView = droneView+1;
        $('drone_'+droneView).style.display      = 'block';
        //$('droneView_end').style.display      = 'block';
    } else if (nextView == 'previous' && droneView-1 > 1) {
        droneView = droneView - 1;
        $('drone_'+droneView).style.display      = 'block';
        //$('droneView_middle').style.display      = 'block';
    } else {
        droneView = 1;
        $('drone_'+droneView).style.display      = 'block';
        //$('droneView_start').style.display      = 'block';
    }
}

jQuery(document).ready(function() {
    function toggleDroneNavigation(page) {
        if (page > maxDroneView) {
            return;
        }

        droneView = page;

        if (page == 1) {
            jQuery('#dronePrev').css( 'backgroundPosition', '0px 0px');
            jQuery('#droneNext').css( 'backgroundPosition', '-25px 25px');
        } else if(page > 1 && page < maxDroneView) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-25px 0px');
            jQuery('#droneNext').css( 'backgroundPosition', '-25px 25px');
        } else if (page == maxDroneView) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-25px 0px');
            jQuery('#droneNext').css( 'backgroundPosition', '0px 25px');
        }

        for (i = 1; i <= maxDroneView; i++) {
            jQuery('#drone_' + i).css( 'display', 'none');
        }

        jQuery('#drone_' + page).css( 'display', 'block');

    }

    toggleDroneNavigation(1);

    jQuery('#dronePrev').mouseover(function() {
        if (droneView > 1) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-50px 0px');
        }
    }).mouseout(function() {
        if (droneView > 1) {
            jQuery('#dronePrev').css( 'backgroundPosition', '-25px 0px');
        }
    }).click(function() {
        if (droneView > 1) {
            toggleDroneNavigation(droneView - 1);
        }
    });

    jQuery('#droneNext').mouseover(function() {
        if (droneView < maxDroneView) {
            jQuery('#droneNext').css( 'backgroundPosition', '-50px 25px');
        }
    }).mouseout(function() {
        if (droneView < maxDroneView) {
            jQuery('#droneNext').css( 'backgroundPosition', '-25px 25px');
        }
    }).click(function() {
        if (droneView < maxDroneView) {
            toggleDroneNavigation(droneView + 1);
        }
    });


});

</script>

<div style="display:none;">
    <img src="./do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_hangar_overview&f=eurostyle_thea&color=black&bgcolor=grey1" />
    <img src="./do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_hangar_overview&f=eurostyle_thea&color=white&bgcolor=grey" />
    <img src="./do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_hangar_equipment&f=eurostyle_thea&color=black&bgcolor=grey1" />
    <img src="./do_img/global/text_tf.esg?l=us&s=9&t=nav_sub1_hangar_equipment&f=eurostyle_thea&color=white&bgcolor=grey" />
    <img src="./do_img/global/text_tf.esg?l=us&s=9&t=nav_sub1_hangar_shop&f=eurostyle_thea&color=black&bgcolor=grey1" />
    <img src="./do_img/global/text_tf.esg?l=us&s=9&t=nav_sub1_hangar_shop&f=eurostyle_thea&color=white&bgcolor=grey" />
</div>

<div id="dock_content">
    <style type="text/css" media="screen">    @import "./css/cdn/includeNavigation.css?__cv=98a8d4f301a5e91375fd873515891000";</style>
<style  type="text/css">

.tabLabelOverviewActive {
    background-image: url(text?t=OVERVIEW&w=8&s=9&color=black&b=lightestBlue);
}
.tabLabelOverviewInActive {
    background-image: url(text?t=OVERVIEW&w=8&s=9&color=white&b=grey);
}
.tabLabelEquipmentActive {
    background-image: url(text?t=EQUIPMENT&w=8&s=9&color=white&b=grey);
}
.tabLabelEquipmentInActive {
    background-image: url(text?t=EQUIPMENT&w=8&s=9&color=white&b=grey);
}
.tabLabelShopActive {
    background-image: url(./do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_hangar_shop&f=eurostyle_thea&color=black&bgcolor=grey1);
}
.tabLabelShopInActive {
    background-image: url(./do_img/global/text_tf.esg?l=us&s=9&t=nav_sub1_hangar_shop&f=eurostyle_thea&color=white&bgcolor=grey);
}

</style>

<script type="text/javascript">

jQuery(document).ready(function(){



/**
 *
 *  navigation tooltips
 *
 */

var navigation_ttips = new Object;

navigation_ttips['tp_expand_hangar'] = 'Purchase an additional hangar hall.';
navigation_ttips['tp_quickselection_design'] = '';
navigation_ttips['tp_quickselection_active'] = '';
navigation_ttips['tp_switchship_deploy'] = 'Prepare the ship from the selected hangar hall for use.';
navigation_ttips['tp_quickselection_destroyed'] = '';
navigation_ttips['tp_inventory_item_allocation'] = 'Equipped: %HANGAR_NAME%';
navigation_ttips['tp_switchship'] = 'Add this ship to the hangar hall of your choice.';


    jQuery("*[class~='buySlot']").qtip({
        content: navigation_ttips['tp_expand_hangar'],
        style:'dohdr',
        position:{target:'mouse'}
    });

    jQuery("#buttonActivateShip").qtip({
        content: navigation_ttips['tp_switchship'],
        style:'dohdr',
        position:{target:'mouse'}
    });

    jQuery("#btnActivateHangarSlot").qtip({
        content: navigation_ttips['tp_switchship_deploy'],
        style:'dohdr',
        position:{target:'mouse'}
    });

    jQuery(".hangarSlotForBuy").qtip({
        content: navigation_ttips['tp_expand_hangar'],
        style:'dohdr',
        position:{target:'mouse'}
    });
});


function setActiveTab(category) {
    if (category == "internalDockEquipment") {
         jQuery('#tabButton1').attr('class', 'tabButtonInActive');
         jQuery('#tabLabel1').attr('class', 'tabLabelInActive  tabLabelOverviewInActive');

         jQuery('#tabButton2').attr('class', 'tabButtonActive');
         jQuery('#tabLabel2').attr('class', 'tabLabelActive  tabLabelEquipmentActive');
    } else {
         jQuery('#tabButton2').attr('class', 'tabButtonInActive');
         jQuery('#tabLabel2').attr('class', 'tabLabelInActive  tabLabelEquipmentInActive');

         jQuery('#tabButton1').attr('class', 'tabButtonActive');
         jQuery('#tabLabel1').attr('class', 'tabLabelActive  tabLabelOverviewActive');
    }
}

</script>

<div id="subNav_container">
    <div id="tabButton1" class="tabButtonInActive"
        onmouseover="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
        onclick="redirect('?action=internalDock');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel1" class="tabLabelInActive tabLabelOverviewInActive"></div>
    </div>
    <div id="tabButton2" class="tabButtonInActive"
        onmouseover="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
        onclick="redirect('?action=internalDock&tpl=internalDockEquipment');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel2" class="tabLabelInActive tabLabelEquipmentInActive"></div>
    </div>
</div>
<script type="text/javascript">
    setActiveTab('internalDock');
</script>

    <style type="text/css" media="screen">    @import "/css/cdn/includeHangarSlots.css";</style>
<script type="text/javascript" src="/js/hangarSlots.js?"></script>

    
<form id="hangarView" name="hangarView" action="indexInternal.es?action=internalDock" method="post"><input type="hidden" name="reloadToken" value="ccae1b88053f6480830fb5e096cc3001">
<input type="hidden" name="subAction" value="changeHangar">
<input type="hidden" id="hangarId" name="hangarId" value="<?php echo $hid; ?>">
<div id="hangarSlotsDisable"></div>
<div id="hangarSlotsContainer">
    <div id="hangarSlots">
                                    <div showHangarInfo="pCk" id="slot_0" class="hangarSlot slotEquipped
                     active
                                        " onclick="
                    switchHangarView(
                        <?php echo $hid; ?>,
                        0,
                        'active',
                        false,
                        'internalDock'
                    );">
                    1
                </div>
                                    <div class="hangarSlotForBuy" onClick="do_redirect('indexInternal.es?action=internalDock&tpl=internalDockShips&lootId=hangar_slot');">+</div>
            </div>
    <div id="btnActivateHangarSlot">
        <a class="setImage leftCorner"></a>
        <a class="setImage middleContent">
            <div id="btnActivateHangarSlotContent">
                ACTIVATE
            </div>
        </a>
        <a class="setImage rightCorner"></a>
    </div>
            <div id="showHangarNameInUpperRightCorner">
                        <div id="showHangarNameInUpperRightCornerTextPremium" onclick="showHangarRenameForm();">HANGAR HALL 1</div>
                <input type="hidden" id="hangarName" name="hangarName" value="">
    </div>
</div>
</form>
<form id="renameHangarForm" name="renameHangarForm" action="indexInternal.es?action=renameHangar" method="post" target="uploadTarget"><input type="hidden" name="reloadToken" value="ccae1b88053f6480830fb5e096cc3001">
                        <div id="renameHangarContainer"><link rel="stylesheet" type="text/css" href="./resources/css/popup.css?__cv=4e58da2dec4df33ee5f4c239848dda00" />
<div id="renameHangarPopup">
    <div class="header">
        <div class="header-name">Rename Hangar</div>
        <div class="button-close" onclick="hideHangarRenameForm();"></div>
    </div>
    <div class="body">
        <div class="rename-title">Choose a name for your hangar. The name must conform to the Bigpoint General Terms and Conditions.</div> <br /><br />
        <div class="content fliess13px-grey">
            <input id="renameHangarInputField" class="renameHangarInputField" type="text" name="hangarName" value="HANGAR HALL 1" maxlength="20"/>
        </div>
    </div>

    <div class="footer single-button">
        <div class="button button-green">
            <div class="text"
                 style="background-image: url(./do_img/global/text_tf.esg?l=us&s=12&t=hangar_renamimg_accept_caps&f=eurostyle_thea&color=white&bgcolor=grey);"
                 onclick="renameHangar();"></div>
        </div>
    </div>
</div>
<div id="renameHangarPopupBackground"></div>
<img id="renameHangarLoading" alt="Loading..." src="./do_img/global/pilotSheet/profilePage/loadingAnimation.gif" />
</div>
    <input type="hidden" id="hangar_Id" name="hangar_Id" value="196834">
</form>
<iframe id="uploadTarget" name="uploadTarget" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>


    <div id="dock_container">
        <div id="overview_container" class="overview_image">
            <div id="overview_navigation" class="overview_seperator">
                <div class="overview_button_active fliess10px-gelb" id="overview_button_ship" onclick="changeView('ship');"><div style="background-image:  url(./do_img/global/text_tf.esg?l=us&s=8&t=hangar_overview_but_ship&f=eurostyle_thea&color=white&bgcolor=grey); background-repeat: no-repeat;width: 94px; height: 23px;margin: 7px 20x;">Ship</div></div>
                <div class="overview_button_inactive fliess10px-weiss" id="overview_button_drones" onclick="changeView('drone');"><div style="background-image:  url(./do_img/global/text_tf.esg?l=us&s=8&t=hangar_overview_but_drones&f=eurostyle_thea&color=white&bgcolor=grey); background-repeat: no-repeat;width: 94px; height: 23px;margin: 0px 0px;">Drones</div></div>
                <div class="overview_button_inactive fliess10px-weiss" id="overview_button_pet" onclick="changeView('pet');"><div style="background-image:  url(./do_img/global/text_tf.esg?l=us&s=8&t=hangar_overview_but_pet&f=eurostyle_thea&color=white&bgcolor=grey); background-repeat: no-repeat;width: 94px; height: 23px;margin: 0px 0px;">P.E.T.</div></div>
                <br class="clearMe" />
            </div>
            <div id="overview_background">
                <div id="overview_content">
                    <div id="overview_ship">
                        <div class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_ship">
                        <table class="overview_table" cellpadding="1" cellspacing="0">
                            <tr class="overview_line_highlight">
                                <td class="labels">Hit points</td>
                                <td class="values"><?php if($HRow['hp'] == 0) {
															echo "<a onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalDock&sa=repair\">Repair the ship!</a>";
														}else{
															echo $HRow['hp']; 
														}?></td>
                            </tr>
							<tr>
                                <td class="labels">Max. hit points</td>
                                <td class="values"><?php echo $HRow['maxhp']; ?></td>
                            </tr>
                            <tr>
                                <td class="labels">Nanohull</td>
                                <td class="values"><?php echo $HRow['Nanohull'] ?></td>
                            </tr>
                            <tr>
                                <td class="labels">Max. Nanohull</td>
                                <td class="values"><?php echo $HRow['MaxNanohull'] ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Repair credits</td>
                                <td class="values"><?php echo $HRow['repairvouchers'] ?></td>
                            </tr>
                            <tr>
                                <td class="labels">Jump credits</td>
                                <td class="values"><?php echo $HRow['jumpvouchers'] ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Booty Keys</td>
                                <td class="values"><?php echo $HRow['BKeys'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockLaser">Lasers</a></td>
                                <td class="values"><?php echo $HRow['Lasercnt'] ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockAmmo">Laser ammo</a></td>
                                <td class="values"><?php echo $HRow['Ammocnt'] ?></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockAmmo">Rockets</a></td>
                                <td class="values"><?php echo $HRow['Rocketcnt'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Speed generators</a></td>
                                <td class="values"><?php echo $HRow['Speedgens'] ?></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Max. possible speed</a></td>
                                <td class="values"><?php echo $HRow['MaxSpeed'] ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Shield generators</a></td>
                                <td class="values"><?php echo $HRow['Shieldgens'] ?></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Damage distribution</a></td>
                                <td class="values">&nbsp;</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Shield/hull</a></td>
                                <td class="values"><?php echo $HRow['ratio']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones">Drones</a></td>
                                <td class="values">&nbsp;</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones">Flax</a></td>
                                <td class="values"><?php echo $HRow['Flaxcnt']; ?></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones">Iris</a></td>
                                <td class="values"><?php echo $HRow['Irescnt']; ?></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones">Apis</a></td>
                                <td class="values"><?php echo $HRow['Apis']; ?></td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockDrones">Zeus</a></td>
                                <td class="values"><?php echo $HRow['Zeus']; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div id="hangarExpansion_slotHint">
                        <div id="hangarExpansion_counter" class="hangarExpansion_counter_0"></div>
                        <div id="hangarExpansion_empty"></div>
                    </div>

                    <div class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_shipView">
                        <div class="shipNotation" id="shipNotation">
                            <img id="shipName" src="./do_img/global/text.esg?l=us&s=17&t=<?php if($base->shipnum==98): echo "Police"; else:?>ship_<?php echo $base->shipnum; ?>_name<?php endif; ?>&uc=1&f=ship_name"><br />
                                                        <img id="shipTitle" class="shipTitle" src="./do_img/global/text.esg?l=us&s=12&t=<?php if($base->shipnum==98): echo "Police Cruiser"; else:?>ship_<?php echo $base->shipnum; ?>_short<?php endif; ?>&uc=1&cs=1&f=ship_title">
                                                        <br class="clearMe" />
                        </div>
                        <div id="shipVideo" ></div>

                    </div>
                        <script type="text/javascript">flashembed("shipVideo", {"src": "./do_img/global/videoPlayer.swf","version": [10,2],"width": 353,"height": 208,"wmode": "transparent"}, {"cdn": "http://<?php echo $_SERVER['SERVER_NAME']; ?>/","nosid": "1","videoUrl": "/do_img/global/items/ship/<?php echo strtolower ($base->shipShow); ?>.flv","videoHost": "http://<?php echo $_SERVER['SERVER_NAME']; ?>","videoHash": "fdb3c14a449a823ec0b25b15e97c4800"});</script>


                    </div>
                    <div id="overview_drones">
                                            <div class="infoBox infoBox_drones fliess10px-weiss" id="infoBox_drones" style="display: none;">
                                                <div id="drone_1" style="display: block">
                            <table class="overview_table" cellpadding="1" cellspacing="0">
								<tr class="overview_line_highlight">
                                    <td class="labels">1. Iris</td>
                                    <td class="values">Level 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">33%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">2</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                    <tr class="overview_line_highlight">
                                    <td class="labels">2. Iris</td>
                                    <td class="values">Level 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">33%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">2</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                    <tr class="overview_line_highlight">
                                    <td class="labels">3. Iris (Havoc)</td>
                                    <td class="values">Level 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">32%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">3</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                    <tr class="overview_line_highlight">
                                    <td class="labels">4. Iris</td>
                                    <td class="values">Level 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">32%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">3</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                        </table>
                        </div>
                                                <div id="drone_2" style="display: none">
                            <table class="overview_table" cellpadding="1" cellspacing="0">
                                                                                                                    <tr	class="overview_line_highlight">
                                    <td class="labels">5. Iris (Havoc)</td>
                                    <td class="values">Level 6</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">32%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">3</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                        <tr	class="overview_line_highlight">
                                    <td class="labels">6. Iris</td>
                                    <td class="values">Level 5</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">2%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">481</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values">1600</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                        <tr	class="overview_line_highlight">
                                    <td class="labels">7. Iris</td>
                                    <td class="values">Level 5</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">2%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">481</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values">1600</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                                                                                        <tr	class="overview_line_highlight">
                                    <td class="labels">8. Iris</td>
                                    <td class="values">Level 5</td>
                                </tr>
                                <tr>
                                    <td class="labels">Damage</td>
                                    <td class="values">2%</td>
                                </tr>
                                <tr class="overview_line_highlight">
                                    <td class="labels">Points</td>
                                    <td class="values">481</td>
                                </tr>
                                <tr>
                                    <td class="labels">Next level</td>
                                    <td class="values">1600</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                                </tr>
                                                            </table>
                        </div>
                        <div id="drone_3" style="display: none">
                            <table class="overview_table" cellpadding="1" cellspacing="0">
                                                        </table>
                        </div>
                        <div id="nav_drones" style="display: none;">
                                                    <div id="droneView_middle" class="label labelNextDrones fliess10px-gelb">
                                <div style="width: 25px; height: 25px; background-image: url(./do_img/global/hangar/overview/drone_navigation.png?__cv=041f2616a9426f89f0d6801caac86400); backgound-repeat: no-repeat;background-position: 0px 0px;position: absolute; top: -15px; left: 190px;" id="dronePrev"></div>
                                <div style="width: 25px; height: 25px; background-image: url(./do_img/global/hangar/overview/drone_navigation.png?__cv=041f2616a9426f89f0d6801caac86400); backgound-repeat: no-repeat;background-position: 0px 25px;position: absolute; top: -15px; left: 220px;" id="droneNext"></div>
                            </div>
                            <!--
                            <div id="droneView_start" class="label labelNextDrones fliess10px-gelb" style="display: block; width: 235px">
                                <div onclick="changeDroneView('next',2);" style="float: right">Next</div>
                            </div>
                            <div id="droneView_middle" class="label labelNextDrones fliess10px-gelb" style="display: none; width: 235px">
                                <div onclick="changeDroneView('previous',2);" style="float: left;">Previous</div>
                                <div onclick="changeDroneView('next',2);" style="float: right;">Next</div>
                            </div>
                            <div id="droneView_end" class="label labelNextDrones fliess10px-gelb" style="display: none; width: 235px">
                                <div onclick="changeDroneView('previous',2);" style="float: left">Previous</div>
                            </div>
                            -->
                                                </div>
                        <div style="display: none;" class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_droneView">
                                                    <div class="droneNotation" id="droneNotation">
                                <img id="droneName" src="https://int4.darkorbit.bigpoint.com/do_img/global/text.esg?l=en&s=17&t=Iris&uc=1&f=ship_name"><br />
                                                                <img id="droneTitle" class="droneTitle" src="https://int4.darkorbit.bigpoint.com/do_img/global/text.esg?l=en&s=12&t=Battle drone&uc=1&cs=1&f=ship_title">
                                                                <br class="clearMe" />
                            </div>
                            <div id="droneVideo" style="width:253px; height:208px;"><div></div></div>
                                                </div>
                    </div>
                    <script type="text/javascript">flashembed("droneVideo", {"src": "./do_img/global/videoPlayer.swf?__cv=f36c472d2c9ce86264b2cbb113072a00","version": [10,2],"width": 253,"height": 208,"wmode": "transparent"}, {"videoUrl": "/do_img/global/hangar/drones/drone_iris-6.flv","videoHost": ".","videoHash": "eafafa57934eff2323b78c35cdf10700"});</script>                    </div>

                     <div id="overview_pet">
                                            <div class="infoBox infoBox_pet fliess10px-weiss" id="infoBox_pet" style="display: none;">
                                                <table class="overview_table" cellpadding="1" cellspacing="0">
                            <tr class="overview_line_highlight">
                                <td class="labels">Name</td>
                                <td class="values">Artifact</td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockPetGear">Fuel</a></td>
                                <td class="values">43,156/50,000</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Level</td>
                                <td class="values">8</td>
                            </tr>
                            <tr>
                                <td class="labels">Experience points</td>
                                <td class="values">4,992,941/5,832,000</td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels">Hit points</td>
                                <td class="values">0/130,000</td>
                            </tr>
                            <tr>
                                <td class="labels">Lasers</a></td>
                                <td class="values">0/1</td>
                            </tr>
                            <tr>
                                <td colspan="2"><img class="overview_line" src="./do_img/global/hangar/overview/devider.png?__cv=ac0092e33d92cca9adb9c0436a12c700" alt=""></td>
                            </tr>
                            <tr  class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Shield generators</a></td>
                                <td class="values">0</td>
                            </tr>
                            <tr>
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Damage distribution</a></td>
                                <td class="values"></td>
                            </tr>
                            <tr class="overview_line_highlight">
                                <td class="labels"><a onfocus="this.blur()" href="indexInternal.es?action=internalDock&tpl=internalDockGenerator">Shield/hull</a></td>
                                <td class="values">0/0</td>
                            </tr>
                        </table>
                                            </div>
                    <div class="infoBox infoBox_ship fliess10px-weiss" id="infoBox_petView">
                                                <div class="petNotation" id="petNotation">
                            <img id="petName" src="./do_img/global/text.esg?l=en&s=17&t=pet_name&uc=1&f=ship_name"><br />
                                                        <img id="petTitle" class="petTitle" src="./do_img/global/text.esg?l=en&s=12&t=Artifact&uc=1&cs=1&f=ship_title">
                                                        <br class="clearMe" />
                        </div>
                        <div id="petVideo" style="width:253px; height:208px;"><div></div></div>
                                            </div>
                    <script type="text/javascript">flashembed("petVideo", {"src": "do_img/global/videoPlayer.swf","version": [10,2],"width": 253,"height": 208,"wmode": "transparent"}, {"videoUrl": "/do_img/global/hangar/pet/pet-8.flv?__cv=8460033cb2c3d6eeeffa5eae1abd3600","videoHost": ".","videoHash": "8460033cb2c3d6eeeffa5eae1abd3600"});</script>                    </div>
                </div>

                <div id="overview_shipYard">
                    
<div id="shipDump">
<?php 
echo $base->postShip();
?>
    <div id="showPrevious" class="showPreviousInactive"></div>
    <div id="showNext" class="showNext"></div>
            <div id="buttonActivateShip" class="buttonActiv">
            <div id="activateShipHighlight" style="display: block;"></div>
            ALLOCATE
        </div>
    </div>
<script type="text/javascript">
    var totalShipsInDump    = <?php echo $base->numbs; ?>,
        activeShipDump      = 0,
        confirmText         = 'Would you like to place this ship in the hangar hall?<br/>Your currently assigned ship will be sold and the new ship equipped with the best items available to you. Remaining items will be placed in your inventory.';
    

    /**
     * Open confirmation dialog when the user clicks on 'activate' button.
     * If he confirms submit the active shipDumpForm.
     */
    jQuery('#buttonActivateShip').live('click', function(e) {
        Tools.Popup.Presets.showQuestionDialog(confirmText, {
            callback    : function () {
                var formId  = 'shipDumpForm_' + activeShipDump;

                // Show loading dialog while the form is being submitted
                Tools.Popup.showLoadingDialog();

                jQuery('#' + formId).submit();
            }
        });
    });

    function checkStart() {


        if (totalShipsInDump <=0) {
            jQuery('#buttonActivateShip').removeClass('buttonActiv').addClass('buttonInactiv');
            jQuery('#buttonActivateShip').unbind('click');
        } else if (totalShipsInDump == 1) {
            activeShipDump = 1;
        } else if (totalShipsInDump > 1) {
            activeShipDump = 1;

            jQuery('#showNext').click(function() {
                activeShipDump = 1
                switchShip(activeShipDump + 1)
            });
            jQuery('#showNext').removeClass('showNextInactive').addClass('showNext');
        }
    }

    function switchShip(shipToShow) {
        activeShipDump = shipToShow;
        changeButtonNext(shipToShow, totalShipsInDump);
        changeButtonPrevious(shipToShow, totalShipsInDump);
        jQuery('#shipDump_' + (shipToShow - 1)).removeClass('shipDumpViewActual').addClass('shipDumpViewPrevious').show();
        jQuery('#shipDump_' + (shipToShow)).removeClass('shipDumpViewNext').addClass('shipDumpViewActual').show();
        jQuery('#shipDump_' + (shipToShow + 1)).addClass('shipDumpViewNext').show();
        jQuery('#shipDump_' + (shipToShow - 2)).hide();
        jQuery('#shipDump_' + (shipToShow + 2)).hide();
    }

    function switchShipPrev(shipToShow) {
        activeShipDump = shipToShow;
        changeButtonNext(shipToShow, totalShipsInDump);
        changeButtonPrevious(shipToShow, totalShipsInDump);
        jQuery('#shipDump_' + (shipToShow - 1)).removeClass('shipDumpViewPrevious').addClass('shipDumpViewPrevious').show();
        jQuery('#shipDump_' + (shipToShow)).removeClass('shipDumpViewPrevious').addClass('shipDumpViewActual').show();
        jQuery('#shipDump_' + (shipToShow + 1)).removeClass('shipDumpViewActual').addClass('shipDumpViewNext').show();
        jQuery('#shipDump_' + (shipToShow - 2)).hide();
        jQuery('#shipDump_' + (shipToShow + 2)).hide();
    }

    function changeButtonNext(shipToShow, max) {
        if (shipToShow < max ) {
            jQuery('#showNext').unbind('click');
            jQuery('#showNext').click(function() {
                switchShip(activeShipDump + 1)
            });
            jQuery('#showNext').removeClass('showNextInactive').addClass('showNext');
        } else {
            jQuery('#showNext').removeClass('showNext').addClass('showNextInactive');
            jQuery('#showNext').unbind('click');
        }
    }

    function changeButtonPrevious(shipToShow, max) {
        if (1 < shipToShow) {
            jQuery('#showPrevious').unbind('click');
            jQuery('#showPrevious').click(function() {
                switchShipPrev(activeShipDump - 1)
            });
            jQuery('#showPrevious').removeClass('showPreviousInactive').addClass('showPrevious');
        } else {
            jQuery('#showPrevious').unbind('click');
            jQuery('#showPrevious').removeClass('showPrevious').addClass('showPreviousInactive');
        }
    }




    //loop to apply tooltip styles in ship dump.
    



    
        

                jQuery("div#ship_0").qtip({

        style:'dohdr',
        position:{target:'mouse'},
        show: { ready: false }
    });

    

    
        

                jQuery("div#ship_1").qtip({

        style:'dohdr',
        position:{target:'mouse'},
        show: { ready: false }
    });

    

    



    checkStart();


</script>


                </div>

            </div>
        </div>
    </div>

 </div>
<script type="text/javascript" src="./resources/js/user.js?__cv=b79aef5e50246af886bf99f0a7678400"></script>
<script type="text/javascript" src="./resources/js/dock.js?__cv=c0e02fcf2bc2486593ac64d0cd1f4400"></script>
<script type="text/javascript">

    // Parameters for Tools.Popup
    Tools.Popup.Parameters = {"showOnLoad":false,"type":"success","content":""};

    // User parameters
    User.Parameters = {"balance":{"uridium":10000,"credits":30000},"discountFactor":0.95,"language":"us","ship":{"laserAmmunitionSpace":0,"rocketSpace":0},"isActiveHangarEmpty":false,"isShipDumpEmpty":true};

jQuery(document).ready(function(){
    Tools.ErrorHandler.Initialize();
    Tools.Popup.Initialize();
    // Initialize dock
    Dock.Initialize();
    }
);

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
    <div id="imprint_text"><b>Bigpoint S.�.r.l. and Co, SCS</b><br>Building Vertigo - Polaris<br>2-4 rue Eug�ne Ruppert<br>L-2453 Luxemburg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.�.r.l.<br>Jeronimo Folgueira<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 25331016<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 261 911 3515<br>Fax: +352 49 48 48 6606<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
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


    


    
        <a href="http://www.facebook.com/darkorbit" target="_blank">
           
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

</body>
</html><link rel="stylesheet" type="text/css" href="./resources/css/popup.css?__cv=4e58da2dec4df33ee5f4c239848dda00" />
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