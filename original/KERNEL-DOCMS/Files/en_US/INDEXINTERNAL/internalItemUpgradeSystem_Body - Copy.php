<meta http-equiv="refresh" content="0;URL=/indexInternal.es.php?action=internalStart" />
<?php
if(isset($_GET['RestrictedApi'])){
	define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	if(!IS_AJAX) {
		die('Restricted');
	}
	
    $_SESSION['Upgradeings'][$_GET['id']]['tick'] = $_GET['tick'];
    exit;
}
if(!isset($_SESSION['Upgradeings'])){
   $_SESSION['Upgradeings'] = array(); 
}
$base->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
if(isset($_POST['subAction']) && $_POST['subAction'] == "upgradeItem" && isset($_POST['itemID']) && !empty($_POST['itemID'])){
if($_POST['itemUpgradePercent'] === "100%"){
    $_SESSION['Upgradeings'][$_POST['itemID']]['tick'] = 99;  
}else{
     $_SESSION['Upgradeings'][$_POST['itemID']]['tick'] = 0;
}
if($base->upgradeItem($_POST)){
    $id = $_POST['itemID'];
    $_SESSION['Upgradeings'][$_POST['itemID']]['id'] = $id;
    $_SESSION['Upgradeings'][$_POST['itemID']]['img'] = $_POST['itemUrl'];
}
    
    
}elseif(isset($_POST['subAction']) && $_POST['subAction'] == "completeUpgrade" && isset($_POST['itemID']) && !empty($_POST['itemID'])){
    if(isset($_SESSION['Upgradeings'][$_POST['itemID']]['success'])){
        $done = $_SESSION['Upgradeings'][$_POST['itemID']]['success'];   
    }
    unset($_SESSION['Upgradeings'][$_POST['itemID']]);
}elseif(isset($_POST['subAction']) && $_POST['subAction'] == "completeAll" ){
    foreach($_SESSION['Upgradeings'] as $key => $val){
        if($val['tick']>99.1){
             unset($_SESSION['Upgradeings'][$key]);
        }
    }
}
$upItems = $base->getItemUpgrade();
?>
</head>
<body onLoad="" onunload="PageClose();">
<!-- affiliateStartTag -->



<!.. user context info layer -->
<div id="userInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
<!-- hangar context info layer -->
<div id="hangarInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
<!-- clan info layer -->
<div id="clanInfoLayer" style="display:none;position:absolute;z-index:100;"></div>
<!-- seitenabdecker -->

<!--
<div id="generalInfoPopup" class="fliess13px-grey">
    <div class="popup_headcontainer">
        <a id="general_popup_close" class="popup_close" href="#" ></a>
    </div>
    <div id="general_popup_question" class="question">
        <img src="./do_img/global/popups/general/success_icon.png" id="general_popup_success" class="success" />
        <img src="./do_img/global/popups/general/error_icon.png" id="general_popup_error" class="error" />
        <p id="general_popup_question_text">this text will be replace on xajax call</p>
    </div>
    <div class="popup_contentcontainer">
        <div class="popup_footcontainer">
            <div id="general_popup_close_button" class="popup_close_button">
                    <img src="./do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey" />
            </div>
        </div>
    </div>
</div>-->


<div id="busy_layer"></div>


<!-- seitenabdecker -->

<style type="text/css" media="screen">    @import "http://<?php echo DynHost; ?>/css/cdn/includeInfoLayer.css";</style>
<script type="text/javascript">
infoText = '';
icon = '';
</script>
<script type="text/javascript" src="./js/infoLayer.js"></script>

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

<script>


jQuery(document).ready(function(){
    jQuery('#selectUpgradeItems').change(getItems);
});

        buttonTextStart = 'START UPGRADE';
        buttonTextStartAttempt = 'ATTEMPT UPGRADE';


var upgradeCostData = {"default":{"Credits":{"l2":{"g1":150000,"g2":300000,"g3":475000,"g4":675000,"g5":900000,"g6":1150000,"g7":1425000,"g8":1725000,"g9":2050000,"g10":2400000,"g11":2775000,"g12":3175000,"g13":3600000,"g14":4050000,"g15":4525000,"g16":5025000,"g17":5550000,"g18":6100000,"g19":6675000,"g20":7275000},"l1":{"g1":125000,"g2":225000,"g3":325000,"g4":425000,"g5":525000,"g6":625000,"g7":725000,"g8":825000,"g9":925000,"g10":1025000,"g11":1125000,"g12":1225000,"g13":1325000,"g14":1425000,"g15":1525000,"g16":1625000,"g17":1725000,"g18":1825000,"g19":1925000,"g20":2025000}},"Uridium":{"l1":{"g1":200,"g2":260,"g3":335,"g4":425,"g5":530,"g6":650,"g7":785,"g8":935,"g9":1100,"g10":1280,"g11":1475,"g12":1685,"g13":1910,"g14":2150,"g15":2405,"g16":2675,"g17":2960,"g18":3260,"g19":3575,"g20":3905}}}};

function getItems() {
    jQuery('#lasers, #rocketLaunchers, #shieldGenerators, #drones, #modules').hide();
    jQuery('#'+jQuery('#selectUpgradeItems').val()).show();
    jQuery('#selectedTypeUpgrade, #selectedTypeComplete, #selectedTypeCompleteAll').val(jQuery('#selectUpgradeItems').val());
    jQuery('.scroll-pane').jScrollPane({showArrows: true});
}
var oldHoverId = null;
var currentType = null;
function selectItem(id, level, type, imgPath, currency, currencyValue, bonus, resource_bonus, resource_bonus_short, resource_bonus_percent, priceTable, url) {
//    alert(url);
    jQuery('#upgrHappyHourInfo').hide();
    jQuery('#itemID').val(id);
    jQuery('#itemLevel').val(level);
    jQuery('#itemType').val(type);
    jQuery('#itemUrl').val(url);
    jQuery('#itemCurrency').val(currency);
    jQuery('#itemCurrencyValue').val(currencyValue);
    jQuery('#itemBonus').val(bonus);
        jQuery('#itemInfo').text('Level'+' '+level);

    if (oldHoverId != null) {
        jQuery('#itemLevel_'+oldHoverId).css('background-position','0 0');
        oldHoverId = id;
    } else {
        oldHoverId = id;
    }

    jQuery('#itemLevel_'+id).css('background-position','-90px 0');
    jQuery('#selectedItem').css('background-image','url('+imgPath+')');
    var upgradeVouchers = 0;
    var chanceInfoString = '%VALUE%%';

    jQuery('#upgradeVouchers').html(upgradeVouchers);

    if(upgradeVouchers > 0) {
        jQuery('#itemUpgradePercent').val('100%');
        jQuery('#chanceInfo').html(chanceInfoString.replace("%VALUE%",100));
        jQuery('#itemUpgradeMinus').css('visibility', 'hidden');
        jQuery('#itemUpgradePlus').css('visibility', 'hidden');
        jQuery('#itemUpgradePercent').attr('readonly', 'readonly');
        jQuery("#itemUpgradeButton div").html(buttonTextStart);

        //remove onblur; causes display of wrong upgrade costs when having upgrade vouchers
        jQuery('#itemUpgradePercent').attr('onblur', '');
    } else {
        jQuery('#itemUpgradePercent').val('5%');
        jQuery('#chanceInfo').html(chanceInfoString.replace("%VALUE%",5));
        jQuery("#itemUpgradeButton div").html(buttonTextStartAttempt);
    }






    jQuery('.itemSingleViewChoose').hide();
    jQuery('.itemSingleView').show();

    currentType = priceTable;
    updateUpgradeInfo(1, level, currency, currencyValue, resource_bonus, resource_bonus_short, resource_bonus_percent);
}

function numbersonly(e) {
    var key;
    var keychar;
    if(window.event) key = window.event.keyCode;
    else if(e) key = e.which;
    else return true;
    keychar = String.fromCharCode(key);
    if((key==null)||(key==0)||(key==8)||
            (key==9)||(key==13)||(key==27)) return true;
    else if((('0123456789').indexOf(keychar)>-1))
        return true;
    else return false;
}

function percentonly(input) {
    val = parseInt(input.value);
    if(val<5) val=5;
    if(val>100) val=100;
    if(val%5!=0) {
        val = Math.round(val/10)*10;
    }
    input.value = val+'%';
    jQuery('#chanceInfo').text(val+'%');
    grade = val/5;
    level = jQuery('#itemLevel').val();
    currency = jQuery('#itemCurrency').val();
    currencyValue = jQuery('#itemCurrencyValue').val();
    updateUpgradeInfo(grade, level, currency, currencyValue);
}

function minusUpgrade() {
    val = parseInt(jQuery('#itemUpgradePercent').val());
    if(val > 5) {
        jQuery('#itemUpgradePercent').val(val-5+'%');
        if (parseInt(jQuery('#itemUpgradePercent').val()) < 100) {
            jQuery("#itemUpgradeButton div").html(buttonTextStartAttempt);
        } else {
            jQuery("#itemUpgradeButton div").html(buttonTextStart);
        }
        jQuery('#chanceInfo').text(val-5+'%');
        grade = (val-5)/5;
        level = jQuery('#itemLevel').val();
        currency = jQuery('#itemCurrency').val();
        currencyValue = jQuery('#itemCurrencyValue').val();
        updateUpgradeInfo(grade, level, currency, currencyValue);
    }
}

function plusUpgrade() {
    val = parseInt(jQuery('#itemUpgradePercent').val());
    if(val < 100) {
        jQuery('#itemUpgradePercent').val(val+95+'%');
        if (parseInt(jQuery('#itemUpgradePercent').val()) < 100) {
            jQuery("#itemUpgradeButton div").html(buttonTextStartAttempt);
        } else {
            jQuery("#itemUpgradeButton div").html(buttonTextStart);
        }
        jQuery('#chanceInfo').text(val+95+'%');
        grade = (val+5)/5;
        level = jQuery('#itemLevel').val();
        currency = jQuery('#itemCurrency').val();
        currencyValue = jQuery('#itemCurrencyValue').val();
        updateUpgradeInfo(grade, level, currency, currencyValue);
    } else {
        jQuery("#itemUpgradeButton").val(buttonTextStart);
    }
}

function updateUpgradeInfo(grade, level, currency, currencyValue, resource_bonus, resource_bonus_short, resource_bonus_percent) {
    var costs_level_upgrade = 0;
    costs_level_upgrade = upgradeCostData[currentType][currency]['l1']['g' + grade];

    jQuery('#costsInfo').text(Math.round(costs_level_upgrade)+' '+currencyValue);
    bonus = jQuery('#itemBonus').val();
    if(bonus.indexOf('/') != -1) {
        bonus = bonus.split('/');
        bonus = resource_bonus_percent.replace("%VALUE%", Math.round(parseFloat(bonus[0]*(level))*1000)/1000)
                +'/'+resource_bonus_percent.replace("%VALUE%", Math.round(parseFloat(bonus[1]*(level))*1000)/1000);
    } else 
    bonus = resource_bonus_percent.replace("%VALUE%",  Math.round(parseFloat(jQuery('#itemBonus').val()*(level))*1000)/1000);
    jQuery('#bonusInfoTxt').attr('title',resource_bonus_short).html(resource_bonus);
    jQuery('#bonusInfo').text(bonus+"%");
}

function updateUpgradeStatus(itemId, interval) {
        upgrInfoText = '%VALUE%%';
        upgrReadyText = 'Done - click here';
    progress = parseFloat(jQuery('#progressId'+itemId).val());
    tick = parseFloat(jQuery('#tickId'+itemId).val());
    progress = progress+tick;
    if(progress >= 100) {
        interval=clearInterval(interval);
        progress = 100;
        jQuery('#infoId'+itemId).text(upgrReadyText);
        finishUpgradeView(itemId);
        jQuery('#upgrListItemId'+itemId).css('cursor','pointer').click(function() {
            document.upgradeForm.itemID.value=itemId;
            document.upgradeForm.itemLevel.value=jQuery('#itemLevelId'+itemId).text();
            document.upgradeForm.itemType.value=jQuery('#typeId'+itemId).val();
            document.upgradeForm.submit();
        });
        jQuery('#itemLevel_'+itemId).css('background-position','-120px 0');
        
    } else {
        jQuery.ajax({
        type: 'GET',
        async: false,
        url: "./indexInternal.es?action=internalItemUpgradeSystem&RestrictedApi&id="+itemId+"&tick="+progress,
        success: function() {

           }
         });
        jQuery('#progressId'+itemId).val(progress);
        upgrInfoText = upgrInfoText.replace("%VALUE%", Math.round(progress));
        jQuery('#progressBar'+itemId).css('width',Math.round(progress)+'%');
        jQuery('#infoId'+itemId).text(upgrInfoText);
    }
    
}
function showProgress() {
    jQuery('#logList').hide();
    jQuery('#upgradeList').show();
    jQuery('.scroll-pane').jScrollPane({showArrows: true});
}

function showLog() {
    jQuery('#upgradeList').hide();
    jQuery('#logList').show();
    jQuery('.scroll-pane').jScrollPane({showArrows: true});
}

function switchButton(active) {
    if(active == 'upgradeProgress') {
        jQuery('#upgradeProgress').css('background-position', '0 0');
        jQuery('#upgradeLog').css('background-position', '0 -42px');
    } else {
        jQuery('#upgradeProgress').css('background-position', '0 -42px');
        jQuery('#upgradeLog').css('background-position', '0 0');
    }
}

function finishUpgradeView(itemId) {
    jQuery("#progressBar"+itemId).css('width', '100%');
    jQuery("#upgrListItemId"+itemId).css('backgroundImage','url(./do_img/global/itemUpgrade/bg_progress_finish.png?__cv=3b7633b70177b591a363b160e4939100)');
    jQuery("#upgradeReadyId"+itemId).show();
}

function showInfoPopup() {
    showBusyLayer();
    width_x = document.body.offsetWidth;
    container_x = jQuery("#shopInfoPopup").width();
    jQuery("#shopInfoPopup").css('left', ((width_x/2) - (container_x/2))+"px");
   jQuery("#shopInfoPopup").css('top', "300px");
    jQuery("#shopInfoPopup").show();
}
function closeInfoPopup() {
   hideBusyLayer();
    jQuery("#shopInfoPopup").hide();
}

minusUpgr_interval = null;
plusUpgr_interval = null;

document.body.onmouseup = function() {
    if(window.minusUpgr_interval) minusUpgr_interval=clearInterval(minusUpgr_interval);
    if(window.plusUpgr_interval) plusUpgr_interval=clearInterval(plusUpgr_interval);
}

function toggleHelp() {
    jQuery('#itemUpgradeHelpContainer').center('horizontal');
    jQuery('#itemUpgradeHelpContainer').toggle();
    jQuery('.scroll-pane').jScrollPane({showArrows: true});

}

</script>


<!-- styles needed by jScrollPane - include in your own sites -->
<link type="text/css" href="./css/jQuery/jquery.jscrollpane.css?__cv=9af65d2e9c92153b72e7289186102900" rel="stylesheet" media="all" />
<style type="text/css" id="page-css">
    
        /* Styles specific to this particular page */
    #slot1 #scroll-pane-content {
        width: 200px;
        text-align: left;
        margin:  10px;
    }
        /*
        *+html #slot1  #scroll-pane-content {
            margin-left: -396px;
        }
        */

        /* Styles specific to this particular page */
    #slot1 .scroll-pane {
        border: 1px solid #434344;
    }
    #slot1 .scroll-pane, #slot1 .scroll-pane-arrows {
        width: 220px;
        height: 235px;
        overflow: auto;
        position: relative;
        left:10px;
        top: 56px;
    }
    #slot1 .horizontal-only {
        height: auto;
        max-height: 230px;
    }
    #slot1 .scroll-pane .jspVerticalBar {
        right: 0;
    }

    #slot3 #scroll-pane-content2 {
        width: 215px;
        text-align: left;
        margin:  10px;
        padding-bottom: 20px;
    }
        /*
        *+html #slot3  #scroll-pane-content2 {
            margin-left: -396px;
        }
        */

        /* Styles specific to this particular page */
    #slot3 .scroll-pane {
        /*border: 1px solid #434344;*/
    }
    #slot3 .scroll-pane, #slot3 .scroll-pane-arrows {
        width: 260px;
        height: 175px;
        overflow: auto;
        position: relative;
        left:10px;
        top: 30px;
    }
    #slot3 .horizontal-only {
        height: auto;
        max-height: 230px;
    }

    
</style>

<script type="text/javascript" id="sourcecode">
    
    jQuery=jQuery.noConflict(true);
    jQuery(function()
    {
        jQuery('.scroll-pane').jScrollPane({showArrows: true});
    });

    
</script>

<?php 
if(isset($done) && $done == 1):
    ?>
<div id="shopInfoPopup" class="fliess13px-grey">
    <div class="popup_shop_headcontainer">
        <a class="popup_shop_close" href="javascript: void(0);" onclick="closeInfoPopup()"></a>
    </div>

    <div class="popup_shop_contentcontainer">
        <br>
        <div class="question icon_success">
        <div class="content fliess13px-grey">The item upgrade was successful.<br><br></div>
        </div>
        <div class="popup_shop_footcontainer">
            <div id="shopInfoPopupInfo">
                <div class="popup_shop_close_button">
                    <div class="popup_shop_close_text" style='background-image: url("../do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey");' onclick="closeInfoPopup();"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        showInfoPopup();
</script>
<?php
    elseif(isset($done) && $done == 0):
 ?>
<div id="shopInfoPopup" class="fliess13px-grey">
    <div class="popup_shop_headcontainer">
        <a class="popup_shop_close" href="javascript: void(0);" onclick="closeInfoPopup()"></a>
    </div>

    <div class="popup_shop_contentcontainer">
        <br>
        <div class="question icon_error">
        <div class="content fliess13px-grey">The item upgrade failed.<br><br></div>
        </div>
        <div class="popup_shop_footcontainer">
            <div id="shopInfoPopupInfo">
                <div class="popup_shop_close_button">
                    <div class="popup_shop_close_text" style='background-image: url("../do_img/global/text_tf.esg?l=us&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey");' onclick="closeInfoPopup();"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        showInfoPopup();
</script>

<?php
else:
    
endif;
?>

<div id="itemUpgradeSystem">
<div id="subnav">
    <div id="tabButton1" class="tabButtonInActive"
         onmouseover="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
         onmouseout="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
         onclick="do_redirect('indexInternal.es?action=internalSkylab');"
         style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel1" class="tabLabelInActive tabLabelSkylabInActive"></div>
    </div>
    <div id="tabButton2" class="tabButtonInActive"
         onmouseover="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
         onmouseout="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
         onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory');"
         style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel2" class="tabLabelInActive tabLabelTechFactoryInActive"></div>
    </div>
    <div id="tabButton3" class="tabButtonActive"
         onmouseover="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
         onmouseout="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
         onclick="do_redirect('indexInternal.es?action=internalItemUpgradeSystem');"
         style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel3" class="tabLabelInActive tabLabelItemUpgradeSystemActive"></div>
    </div>
</div>
<div class="itemUpgradeSystem">
    <div id="slot1">
        <div id="slot1_head">
            <div class="headline">Step 1</div>
        </div>
        <div id="slot1_content">
            <div class="upgrDescr_text">Select an item you want to upgrade.</div>
            <select id="selectUpgradeItems">
                <option value="lasers" >Lasers</option>
                <option value="rocketLaunchers" >Rocket launchers</option>
                <option value="shieldGenerators" >Shield generators</option>
                <option value="drones" >Drones</option>
                <option value="modules" >Modules</option>

            </select>

            <div class="scroll-pane">
		                <div id="scroll-pane-content">
                    <div id="lasers" style="">
                        <?php
                        if(!empty($upItems[0])):
                            foreach($upItems[0] as $key => $val):
                            if($val['LV']<16):
                                ?>
                                        <div id="itemID<?php echo $val['id']; ?>" style="background-image:url(http://<?php echo DynHost;?>/do_img/global/items/equipment/weapon/laser/<?php echo strtolower($val['name']); ?>_30x30.png);" class="upgradeItem" onclick="selectItem(<?php echo $val['id']; ?>,<?php echo $val['LV'] +1; ?>,'<?php echo $val['C']; ?>','http://<?php echo DynHost;?>/do_img/global/items/equipment/weapon/laser/<?php echo strtolower($val['name']); ?>_100x100.png?__cv=23ad6cc5c949ffce0e6ff2683b16e700','<?php if($val['ucd']=='c'): echo "Credits"; else: echo "Uridium"; endif;?>','<?php if($val['ucd']==="x"): echo "U"; else: echo strtoupper($val['ucd']); endif; ?>.','<?php echo $base->upListPercent($val['LV']); ?>','Damage:','Damage:','%VALUE%%', 'default','do_img/global/items/equipment/weapon/laser/<?php echo strtolower($val['name']); ?>_30x30.png');">
                                        <div id="itemLevel_<?php echo $val['id']; ?>" class="itemLevel" ><?php echo $val['LV']; ?></div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                                            </div>
                    <div id="rocketLaunchers" style="display:none;">
                        <?php
                        if(!empty($upItems[1])):
                            foreach($upItems[1] as $key => $val):
                            if($val['LV']<16):
                                ?>
                                        <div id="itemID<?php echo $val['id']; ?>" style="background-image:url(http://<?php echo DynHost;?>/do_img/global/items/equipment/weapon/rocketlauncher/<?php echo strtolower($val['name']); ?>_30x30.png);" class="upgradeItem" onclick="selectItem(<?php echo $val['id']; ?>,<?php echo $val['LV'] +1; ?>,'<?php echo $val['C']; ?>','http://<?php echo DynHost;?>/do_img/global/items/equipment/weapon/rocketlauncher/<?php echo strtolower($val['name']); ?>_100x100.png?__cv=23ad6cc5c949ffce0e6ff2683b16e700','<?php if($val['ucd']=='c'): echo "Credits"; else: echo "Uridium"; endif;?>','<?php if($val['ucd']==="x"): echo "U"; else: echo strtoupper($val['ucd']); endif; ?>.','<?php echo ($val['LV']+1)*0.2; ?>','Damage:','Damage:','%VALUE%%', 'default','/do_img/global/items/equipment/weapon/rocketlauncher/<?php echo strtolower($val['name']); ?>_30x30.png');">
                                        <div id="itemLevel_<?php echo $val['id']; ?>" class="itemLevel" ><?php echo $val['LV']; ?></div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                                            </div>
                    <div id="shieldGenerators" style="display:none;">
                        <?php
                        if(!empty($upItems[4])):
                            foreach($upItems[4] as $key => $val):
                            if($val['LV']<16):
                                ?>
                                        <div id="itemID<?php echo $val['id']; ?>" style="background-image:url(http://<?php echo DynHost;?>/do_img/global/items/equipment/generator/shield/<?php echo strtolower($val['name']); ?>_30x30.png);" class="upgradeItem" onclick="selectItem(<?php echo $val['id']; ?>,<?php echo $val['LV'] +1; ?>,'<?php echo $val['C']; ?>','http://<?php echo DynHost;?>/do_img/global/items/equipment/generator/shield/<?php echo strtolower($val['name']); ?>_100x100.png?__cv=23ad6cc5c949ffce0e6ff2683b16e700','<?php if($val['ucd']=='c'): echo "Credits"; else: echo "Uridium"; endif;?>','<?php if($val['ucd']==="x"): echo "U"; else: echo strtoupper($val['ucd']); endif; ?>.','<?php echo ($val['LV']+1)*0.2; ?>','Damage:','Damage:','%VALUE%%', 'default','/do_img/global/items/equipment/generator/shield/<?php echo strtolower($val['name']); ?>_30x30.png');">
                                        <div id="itemLevel_<?php echo $val['id']; ?>" class="itemLevel" ><?php echo $val['LV']; ?></div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                        <?php
                        if(!empty($upItems[3])):
                            foreach($upItems[3] as $key => $val):
                          if($val['LV']<16):
						   ?>
							  <div id="itemID<?php echo $val['id']; ?>" style="background-image:url(http://<?php echo DynHost;?>/do_img/global/items/equipment/generator/speed/<?php echo strtolower($val['name']); ?>_30x30.png?__cv=cfde29bcddbbfbcf4abccb06a1bad900);" class="upgradeItem" onclick="selectItem(<?php echo $val['id']; ?>,<?php echo $val['LV'] +1; ?>,'<?php echo $val['C']; ?>','http://<?php echo DynHost;?>/do_img/global/items/equipment/generator/speed/<?php echo strtolower($val['name']); ?>_100x100.png?__cv=23ad6cc5c949ffce0e6ff2683b16e700','<?php if($val['ucd']=='c'): echo "Credits"; else: echo "Uridium"; endif;?>','<?php if($val['ucd']==="x"): echo "U"; else: echo strtoupper($val['ucd']); endif; ?>.','<?php echo ($val['LV']+1)*0.2; ?>','Damage:','Damage:','%VALUE%%', 'default','/do_img/global/items/equipment/generator/speed/<?php echo strtolower($val['name']); ?>_30x30.png');">
                                        <div id="itemLevel_<?php echo $val['id']; ?>" class="itemLevel" ><?php echo $val['LV']; ?></div>
                                    </div>
                               <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                                            </div>
                    <div id="drones" style="display:none;">
                        <?php
                        if(!empty($upItems[23])):
                            foreach($upItems[23] as $key => $val):
                            if($val['lootid']!="pet_pet10"):
                                $s = explode("_", $val['lootid']);
                                $val['name'] = $s[1];
                                if($val['LV']<16):
                                ?>
                                        <div id="itemID<?php echo $val['id']; ?>" style="background-image:url(./do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_30x30.png);" class="upgradeItem" onclick="selectItem(<?php echo $val['id']; ?>,<?php echo $val['LV'] +1; ?>,'<?php echo $val['C']; ?>','http://<?php echo DynHost;?>/do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_100x100.png?__cv=23ad6cc5c949ffce0e6ff2683b16e700','<?php if($val['ucd']=='c'): echo "Credits"; else: echo "Uridium"; endif;?>','<?php if($val['ucd']==="x"): echo "U"; else: echo strtoupper($val['ucd']); endif; ?>.','<?php echo ($val['LV']+1)*0.2; ?>','Damage:','Damage:','%VALUE%%', 'default','do_img/global/items/drone/<?php echo strtolower($val['name']); ?>_30x30.png');">
                                        <div id="itemLevel_<?php echo $val['id']; ?>" class="itemLevel" ><?php echo $val['LV']; ?></div>
                                    </div>
                                <?php
                                endif;
                                else:
                                    
                                endif;
                            endforeach;
                        endif;
                        if(!empty($upItems[24])):
                            foreach($upItems[24] as $key => $val):
                            $s = explode("_", $val['lootid']);
                            $val['name'] = $s[1];
//                        exit;
                            if($val['LV']<16):
                                ?>
                                        <div id="itemID<?php echo $val['id']; ?>" style="background-image:url(http://<?php echo DynHost;?>/do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_30x30.png);" class="upgradeItem" onclick="selectItem(<?php echo $val['id']; ?>,<?php echo $val['LV'] +1; ?>,'<?php echo $val['C']; ?>','http://<?php echo DynHost;?>/do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_100x100.png?__cv=23ad6cc5c949ffce0e6ff2683b16e700','<?php if($val['ucd']=='c'): echo "Credits"; else: echo "Uridium"; endif;?>','<?php if($val['ucd']==="x"): echo "U"; else: echo strtoupper($val['ucd']); endif; ?>.','<?php echo ($val['LV']+1)*0.2; ?>','Damage:','Damage:','%VALUE%%', 'default', '/do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_30x30.png');">
                                        <div id="itemLevel_<?php echo $val['id']; ?>" class="itemLevel" ><?php echo $val['LV']; ?></div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                                            </div>
                    <div id="modules" style="display:none;">
                        <?php
                         if(!empty($upItems[18])):
                            foreach($upItems[18] as $key => $val):
                        exit;
                        if($val['LV']<16):
                                ?>
                                        <div id="itemID<?php echo $val['id']; ?>" style="background-image:url(http://<?php echo DynHost;?>/do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_30x30.png);" class="upgradeItem" onclick="selectItem(<?php echo $val['id']; ?>,<?php echo $val['LV'] +1; ?>,'<?php echo $val['C']; ?>','http://<?php echo DynHost;?>/do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_100x100.png?__cv=23ad6cc5c949ffce0e6ff2683b16e700','<?php if($val['ucd']=='c'): echo "Credits"; else: echo "Uridium"; endif;?>','<?php if($val['ucd']==="x"): echo "U"; else: echo strtoupper($val['ucd']); endif; ?>.','<?php echo ($val['LV']+1)*0.2; ?>','Damage:','Damage:','%VALUE%%', 'default', '/do_img/global/items/drone/<?php echo strtolower($val['name']); ?>-0_30x30.png');">
                                        <div id="itemLevel_<?php echo $val['id']; ?>" class="itemLevel" ><?php echo $val['LV']; ?></div>
                                    </div>
                                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
                                            </div>
                </div>
				<?php 
				?>
            </div>
        </div>
        <div id="slot1_footer"><span id="maxUpgradeHint">*Max upgrading level is 16</span></div>
    </div>

    <form id="upgradeItem" action="indexInternal.es?action=internalItemUpgradeSystem" method="POST"><input type="hidden" name="reloadToken" value="9af367af249107a7e23218624c006193">
        <input type="hidden" name="action" value="internalItemUpgradeSystem">
        <input type="hidden" name="subAction" value="upgradeItem">
        <input id="selectedTypeUpgrade" name="selectedType" type="hidden" value="">
        <div id="slot2">
            <div id="slot2_head">
                <div class="headline">Step 2</div>
            </div>
            <div id="slot2_content">
                <div class="upgrDescr_text">Decide how many upgrade boosts you want to use for the upgrade attempt.
    Every boost increases your chance of a successful upgrade by
    <span class="highlight">5%</span>.</div>
                <div id="selectedItem" class="itemSingleView">
                    <div id="itemInfo"></div>
                </div>
                <div class="itemSingleViewChoose"><b>Не работает!</b><br> урик снимает, но % добавляет</div>
                <!-- <div class="itemSingleViewChoose">In Step 1, please select an item you want to upgrade.</div> -->

                <input id="itemID" name="itemID" type="hidden" value="">
                <input id="itemLevel" name="itemLevel" type="hidden" value="">
                <input id="itemType" name="itemType" type="hidden" value="">
                <input id="itemUrl" name="itemUrl" type="hidden" value="">
                <div id="itemUpgradePercentContainer" class="itemSingleView">
                    <input id="itemUpgradeMinus" type="button" value="" onclick="minusUpgrade()" onmousedown="minusUpgr_interval=setInterval('minusUpgrade()',200);">
                    <input id="itemUpgradePercent" name="itemUpgradePercent" readonly type="text" value="5%" size="4" maxlength="4" onkeypress="return numbersonly(event)" onblur="percentonly(this)">
                    <input id="itemUpgradePlus" type="button" value="" onclick="plusUpgrade()" onmousedown="plusUpgr_interval=setInterval('plusUpgrade()',200);">
                </div>
                <input id="itemCurrency" name="itemCurrency" type="hidden" value="">
                <input id="itemCurrencyValue" name="itemCurrencyValue" type="hidden" value="">
                <input id="itemBonus" name="itemBonus" type="hidden" value="">
                                                        <div id="step2_info_container" class="itemSingleView">

                    <div class="step2_info_vouchers">
                        <div class="step2_info_var">Upgrade Vouchers:</div>
                        <div class="step2_info_value" id="upgradeVouchers" style="color:#D8D8D8;">0</div>
                    </div>

                    <div class="step2_info_propability step2_info_bg">
                        <div class="step2_info_var">Chance of upgrade success:</div>
                        <div class="step2_info_value" id="chanceInfo" style="color:#D8D8D8;">5%</div>
                    </div>
                    <div class="step2_info_cost">
                        <div class="step2_info_var">Total cost of upgrade:</div>
                        <div class="step2_info_value" id="costsInfo" style="color:#D8D8D8;">0</div>
                    </div>
                    <div class="step2_info_bonus step2_info_bg">
                        <div id="bonusInfoTxt" title="" class="step2_info_var"></div>
                        <div class="step2_info_value" id="bonusInfo" style="color:#D8D8D8;">0%</div>
                    </div>
                </div>
            </div>
            <div id="slot2_footer"></div>
        </div>

        <div id="itemUpgradeHelp" onclick="toggleHelp();"></div>
        <div id="itemUpgradeHelpContainer">
            <div id="itemUpgradeHelpClose" onclick="toggleHelp();"></div>
            <div id="itemUpgradeHelpText" class="scroll-pane">
                The upgrade system enables you to enhance your lasers, shield generators, rocket launchers and drones with a permanent bonus. <br></br>All items have 15 upgrade levels. Upgrades for each level and item have to be carried out separately.<br><br>There is no guarantee that an upgrade attempt will succeed, unless you influence the process with upgrade boosts. <br><br>You can influence the number of upgrade boosts, up to achieving a 100% success rate, in step two of the upgrade process.
            </div>
        </div>

        <div id="slot3">
            <div id="slot3_head">
                <div class="headline">Step 3</div>
            </div>
            <div id="slot3_content">
                <div class="upgrDescr_text">After selecting the item and the number of upgrade boosts, you can start the upgrade attempt.</div>
                <div id="itemUpgradeButton" onclick="jQuery('#upgradeItem').submit(); jQuery('#itemUpgradeButton').attr('onclick', '');" title="ATTEMPT UPGRADE">
                    <div>ATTEMPT UPGRADE</div>
                </div>
                            </div>
            <div id="slot3_footer"></div>

            <div id="slot3_progressContainer">

                            <div id="upgradeProgress" onclick="showProgress();switchButton(jQuery(this).attr('id'));jQuery(this).css('backgroundPosition', '0 0');" >
                    <div>Progress</div>
                </div>
                            <div id="upgradeLog" onclick="showLog();switchButton(jQuery(this).attr('id'));jQuery(this).css('backgroundPosition', '0 0');" class="buttonDisable">
                    <div>Upgrade log</div>
                </div>


                <div id="scroll-pane-content3" class="scroll-pane">
                    <div id="upgradeList" style="">
                        <?php
                        if(!empty($_SESSION['Upgradeings'])):                           
                        foreach ($_SESSION['Upgradeings'] as $key => $val):
						if(!empty($val['id'])){
                            echo '<div id="upgrListItemId'.$val['id'].'" class="upgradeListItem" style="" onclick="">
                                <div style="background-image:url(http://'. DynHost .'/'.$val['img'].');" class="upgradeListItemPic">
                                    <p id="itemLevelId'.$val['id'].'" class="itemLevel" style="text-align:left;">1</p>
                                </div>
                                <div id="infoId'.$val['id'].'" class="upgradeListInfo">0%</div>
                                <div class="progressBarBorder">
                                    <div id="progressBar'.$val['id'].'" style="width: 0%;"></div>
                                </div>
                                <div class="upgradeReady" id="upgradeReadyId'.$val['id'].'" style="display:none"></div>
                                <input id="typeId'.$val['id'].'" type="hidden" value="laser">
                                <input id="progressId'.$val['id'].'" type="hidden" value="'.$val['tick'].'">
                                <input id="tickId'.$val['id'].'" type="hidden" value="0.833333333333">
                            </div>';
                            }
                        endforeach;
                        
                        endif;
                        ?>

                    </div>
                     
                <div id="logList" style="display:none;">
                  <div class="logListItem">
                            <div class="logListItemPic" style="background-image: url(./do_img/global/items/equipment/weapon/laser/lf-2_30x30.png?__cv=a686531a2d27b5ca6973457e1be28800)"></div>
                            <div class="logListInfo" "="">LF-2 Upgrade attempt failed</div>
                        <div class="logFail"></div>
                    </div>
                    <div class="logListItem">
                            <div class="logListItemPic" style="background-image: url(./do_img/global/items/equipment/weapon/laser/lf-2_30x30.png?__cv=a686531a2d27b5ca6973457e1be28800)"></div>
                            <div class="logListInfo" "="">LF-2 Upgrade from level 2 to level 3</div>
                        <div class="logSuccess"></div>
                    </div>
                </div>
            </div>
                <?php 
                if(!empty($_SESSION['Upgradeings'])){
                foreach ($_SESSION['Upgradeings'] as $key => $val):
				if(!empty($val['id'])){
                    echo '<script>if(0<100) {
                            updateUpgrSt_interval_id'.$val['id'].'=setInterval("updateUpgradeStatus('.$val['id'].',updateUpgrSt_interval_id'.$val['id'].')", 1000);
                        } else {
                                finishUpgradeView('.$val['id'].');
                        }</script>';
						}
                endforeach; 
                
               }else{
				}			   ?> 
                                <div id="upgradeFinishAllSeparator"></div>
            <div id="upgradeFinishAll" title="Finish all" onclick="document.upgradeAllForm.submit();">
                <div>Finish all</div>
            </div>
        </div>
</div>
</form>
<form name="upgradeForm" action="indexInternal.es" method="POST"><input type="hidden" name="reloadToken" value="9af367af249107a7e23218624c006193">
    <input type="hidden" name="action" value="internalItemUpgradeSystem">
    <input type="hidden" name="subAction" value="completeUpgrade">
    <input id="itemID" name="itemID" type="hidden" value="">
    <input id="itemLevel" name="itemLevel" type="hidden" value="">
    <input id="itemType" name="itemType" type="hidden" value="">
    <input id="selectedTypeComplete" name="selectedType" type="hidden" value="">
</form>
<form name="upgradeAllForm" action="indexInternal.es" method="POST"><input type="hidden" name="reloadToken" value="9af367af249107a7e23218624c006193">
    <input type="hidden" name="action" value="internalItemUpgradeSystem">
    <input type="hidden" name="subAction" value="completeAll">
    <input id="selectedTypeCompleteAll" name="selectedType" type="hidden" value="">
</form>

    
</div>
</div>



<script type="text/javascript">
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