<?php
/*$clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$clanid = $clan->getMyClan($Users->DataRow['playerID']);
$clanInfo = $clan->getClan($clanid);
if(isset($_POST['subAction']) && $_POST['subAction']=="applyAccept"):
    $clan->applyMember($clanid, $_POST['applyID']);
elseif(isset($_POST['subAction']) && $_POST['subAction']=="deleteMember"):
    if($Users->DataRow['playerID']==$clanInfo[0]['leader']):
        $clan->deleteMember($clanid, $_POST['removeUserID']);
    elseif($Users->DataRow['playerID']==$_POST['removeUserID']):
        $clan->deleteMember($clanid, $Users->DataRow['playerID']);
        else:
    endif;
    elseif(isset($_POST['subAction']) && $_POST['subAction']=="deleteClan"):
        $clan->deleteClan($clanid);
    else:
endif;
$applicants = $clan->getApplicants($clanInfo[0]['clanID']);
$members = $clan->getMembers($clanInfo[0]['members']);
//$clanInfo[0]['leader']*/
?>
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
            <style type="text/css" media="screen">    @import "./css/cdn/clan.css?__cv=d41d8cd98f00b204e9800998ecf84200"; </style>
<script type="text/javascript">
<!--

wmtt = null;

var aktiv=0;

jQuery(document).mousemove(function(e){

    var _x = e.pageX - 430;
    var _y = e.pageY - 220;
    if (wmtt != null) { //500 290

        wmtt.style.left = _x + "px";
        wmtt.style.top  = _y + "px";
    }
});

function showInfoLayer(text) {

    wmtt = document.getElementById('toolTip');

    if (aktiv==0){
        wmtt.innerHTML = text;
        wmtt.style.display = "block";
    }
}

function hideInfoLayer() {
    wmtt = document.getElementById('toolTip');
    wmtt.style.display = "none";
}


//-->
</script>

<?php if($Users->DataRow['playerID']==$clanInfo[0]['leader']): ?>
<form id="clanrights" name="clanrights" action="indexInternal.es" method="post"><input type="hidden" name="reloadToken" value="2cc837807c7d9c47a360be31b0d7c05f">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="editClanRanks">
<input type="hidden" name="tpl" value="internalClanMember">
<div id="toolTip" class="clan_rankinfo fliess10px-grey" style="z-index: 1000; position:absolute"></div>
<div id="editClanrights" style="width:512px;height:320px;left:174px;top:50px;position:absolute;background-image:url(./do_img/global/clan/bg_clanrechte.jpg?__cv=2d98cef2b523ae37e1156f3de33fe800);display:none;z-index:2" class="fliess10px-white">



    <div style="height:250px;margin-left:15px;">

        <table id="edit_clanrights" cellpadding="0" cellspacing="0">
            <tbody><tr>
                <td class="edit_clanrights_01"><img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_clanrechte&amp;w=160&amp;f=eurostyle_clan"></td>
                <td class="edit_clanrights_02"><img src="./do_img/global/clan/icon_1.gif?__cv=89adf470af9bb6ff93660451b9e33f00" onmouseover="showInfoLayer('Create newsletter')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_2.gif?__cv=cb7f9a2968f810d696ca45dd4fcf0e00" onmouseover="showInfoLayer('View and edit applications')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_3.gif?__cv=b9864f9fe3889cb0cc34241f031c0800" onmouseover="showInfoLayer('Dismiss members')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_4.gif?__cv=728a9e45d8f07ea7c769d79479345d00" onmouseover="showInfoLayer('Edit ranks')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_5.gif?__cv=dc38b47248df1d079809a17178dda000" onmouseover="showInfoLayer('Diplomacy: View requests, start diplomatic agreement')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_6.gif?__cv=71ce76729655c746563e630132e93100" onmouseover="showInfoLayer('Diplomacy: End alliances')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_7.gif?__cv=faabddf63fb195467fc36a66138e7700" onmouseover="showInfoLayer('Diplomacy: Declare war on other clans')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_8.gif?__cv=bdbaba25f9a79dff652b4efcd3b04000" onmouseover="showInfoLayer('Payment from clan treasury')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_9.gif?__cv=036ad69c1c3df4c1cb11dc0887842000" onmouseover="showInfoLayer('Change tax rate')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_10.gif?__cv=5f51954164bc6b2bbcdc333c9f076800" onmouseover="showInfoLayer('Create clan news')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_11.gif?__cv=7ed155c0f1b47b480a65366856527800" onmouseover="showInfoLayer('Manage Battle Station Modules')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_12.gif?__cv=a3a017a450e63c5529e47b35ad782b00" onmouseover="showInfoLayer('Activate/deactivate Battle Station Deflector')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_inner"><img src="./do_img/global/clan/icon_13.gif?__cv=82e6130d929a108ceba4e8af1232e400" onmouseover="showInfoLayer('Build Battle Station')" onmouseout="hideInfoLayer();" class="help"></td>
                <td class="edit_clanrights_close"><a href="javascript:void(0);" onclick="closeLayer('editClanrights');"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00" style="margin-top:8px;"></a></td>
            </tr>
                        <tr>
                <td><br></td>
                <td colspan="13">No ranks given yet</td>
            </tr>
                    </tbody></table>
    </div>

    <div>
        <div style="float:left;"><input type="text" name="newRank" id="newRank" style="" value="Enter rank name" onclick="this.value=''" class="fliess10px-white"></div>
        <div style="float:left;margin:10px 0 0 25px;"><a href="javascript:void(0);" onclick="insertNewRank();return false;"><div class="link_edit">New rank</div></a></div>
        <br class="clearMe">
    </div>

    <div id="editClanrights_foot">
        <div style="float:left;width:50%;"><div id="send_clanrights" class="send_button"><a href="javascript:void(0);" onclick="send('send_clanrights','clanrights'); return false;" class="send_button_clanPic fliess10px-white">OK</a></div></div>
        <div style="float:left;width:50%;"><div class="close_button"><a href="javascript:void(0);" onclick="closeLayer('editClanrights');" class="send_button_clanPic fliess10px-white">Cancel</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>

<form id="change_leader" name="change_leader" action="indexInternal.es" method="POST"><input type="hidden" name="reloadToken" value="2cc837807c7d9c47a360be31b0d7c05f">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="changeLeader">
<input type="hidden" name="tpl" value="internalClanMember">
<div id="changeLeader" style="position:absolute;top:50px;left:254px;width:352px;" class="fliess10px-white">
    <div id="changeLeader_headline_close"><a href="javascript:void(0);" onclick="closeLayer('changeLeader');"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div id="changeLeader_headline_img"><img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_mitglieder&amp;f=eurostyle_clan"></div>
    <br class="clearMe">
    <div id="changeLeader_username">Αnonymous</div>

    <div id="changeLeader_label">Function:</div>
    <div id="changeLeader_choose" class="fliess10px-black">
        <select name="changeLeaderID" style="width:195px;" class="fliess10px-black">
            <option value="">Please select</option>
                        <option value="101190755">Αnonymous</option>
                    </select>
    </div>
    <br class="clearMe">
    <div id="changeLeader_foot">
        <div style="float:left;width:50%;"><div id="send_leaderChange" class="send_button"><a href="javascript:void(0);" onclick="send('send_leaderChange','change_leader'); return false;" class="send_button_clanPic fliess10px-white">OK</a></div></div>
        <div style="float:left;width:50%;"><div class="close_button"><a href="javascript:void(0);" onclick="closeLayer('changeLeader');" class="send_button_clanPic fliess10px-white">Cancel</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>
<div id="clanConfirmationLayer" class="editMember_list fliess10px-white" style="position: absolute; top: 50px; left: 254px; display: none;">
    <div class="editMember_headline_close">
        <a href="javascript:void(0);" onclick="closeLayer('clanConfirmationLayer');">
            <img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00" alt="X">
        </a>
    </div>
    <div class="editMember_headline_img"></div>
    <br class="clearMe">
    <div id="confirmationText">Do you really want to delete this clan?</div>
    <div class="editMember_foot">
        <div style="float:left;width:50%;">
            <div id="clan_confirmation_send" class="send_button">
                <a id="confirmationLink" href="#" class="send_button_clanPic fliess10px-white">OK</a>
            </div>
        </div>
        <div style="float:left;width:50%;">
            <div class="close_button">
                <a href="javascript:void(0);" onclick="closeLayer('clanConfirmationLayer');" class="send_button_clanPic fliess10px-white">Cancel</a>
            </div>
        </div>
        <br class="clearMe">
    </div>
</div>
<?php
else:
    
endif;
?>
<div id="clanConfirmationLayer" class="editMember_list fliess10px-white" style="position: absolute; top: 50px; left: 254px; display: none;">
    <div class="editMember_headline_close">
        <a href="javascript:void(0);" onclick="closeLayer('clanConfirmationLayer');">
            <img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00" alt="X">
        </a>
    </div>
    <div class="editMember_headline_img"></div>
    <br class="clearMe">
    <div id="confirmationText">Dismiss clan member</div>
    <div class="editMember_foot">
        <div style="float:left;width:50%;">
            <div id="clan_confirmation_send" class="send_button">
                <a id="confirmationLink" href="#" class="send_button_clanPic fliess10px-white">OK</a>
            </div>
        </div>
        <div style="float:left;width:50%;">
            <div class="close_button">
                <a href="javascript:void(0);" onclick="closeLayer('clanConfirmationLayer');" class="send_button_clanPic fliess10px-white">Cancel</a>
            </div>
        </div>
        <br class="clearMe">
    </div>
</div>
<form method="post" name="delClanFrom" id="delClanFrom">
    <input type="hidden" name="reloadToken" value="2cc837807c7d9c47a360be31b0d7c05f">
    <input type="hidden" name="action" value="internalClan">
    <input type="hidden" name="subAction" value="deleteClan">
    <input type="hidden" name="reloadToken" value="2cc837807c7d9c47a360be31b0d7c05f">
</form>
<script type="text/javascript">
    function showConfirmationLayer(layerLink, layerText)
    {
        showLayer('clanConfirmationLayer');
        jQuery('#confirmationText').text(layerText);
        jQuery('#confirmationLink').attr('href', layerLink);
        
    }

    function showNewConfirmationLayer(layerText, callback)
    {   
        showLayer('clanConfirmationLayer');
        jQuery('#confirmationText').text(layerText);
        jQuery('#confirmationLink').attr('href', '#');
        jQuery('#confirmationLink').click(callback);
    }
</script>
<?php 

$i=1;
foreach($members as $mem => $info):
?>
<form id="edit_member_<?php echo $i;?>" name="edit_member_<?php echo $i;?>" action="indexInternal.es" method="POST"><input type="hidden" name="reloadToken" value="2cc837807c7d9c47a360be31b0d7c05f">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="editMember">
<input type="hidden" name="tpl" value="internalClanMember">
<input type="hidden" name="memberID" value="<?php echo $info['playerID'];?>">
<div id="editMember_<?php echo $i;?>" class="editMember_list fliess10px-white" style="position:absolute;top:50px;left:254px;width:352px;">
    <div class="editMember_headline_close"><a href="javascript:void(0);" onclick="closeLayer('editMember_<?php echo $i;?>');"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div class="editMember_headline_img"><img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_mitglieder&amp;f=eurostyle_clan"></div>
    <br class="clearMe">
    <div class="editMember_username"><?php echo $info['Name']; ?></div>

    <div class="editMember_label">Function:</div>
    <div class="editMeber_choose">
                    <select name="changeRank" style="width:195px;" class="fliess10px-black">
                <option value="">Please select</option>
                            </select>
            </div>
    <br class="clearMe">
    <div class="editMember_kick">
                    <a href="javascript:void(0);" onclick="showNewConfirmationLayer('Dismiss clan member', function() { jQuery('#kickMember_<?php echo $info['playerID'];?>').submit(); });">
                <div class="link_delete" style="float:left;margin-left:2px;">Dismiss clan member</div>
            </a>
            </div>
    <div class="editMember_foot">
        <div style="float:left;width:50%;"><div id="send_changeMember" class="send_button"><a href="javascript:void(0);" onclick="send('send_changeMember','edit_member_<?php echo $i;?>'); return false;" class="send_button_clanPic fliess10px-white">OK</a></div></div>
        <div style="float:left;width:50%;"><div class="close_button"><a href="javascript:void(0);" onclick="closeLayer('editMember_<?php echo $i;?>');" class="send_button_clanPic fliess10px-white">Cancel</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>

<form method="post" name="kickMember" id="kickMember_<?php echo $info['playerID'] ;?>"><input type="hidden" name="reloadToken" value="2cc837807c7d9c47a360be31b0d7c05f">
    <input type="hidden" name="action" value="internalClan">
    <input type="hidden" name="subAction" value="deleteMember">
    <input type="hidden" name="removeUserID" value="<?php echo $info['playerID'] ;?>">
    <input type="hidden" name="reloadToken" value="2cc837807c7d9c47a360be31b0d7c05f">
</form>

<?php
$i++;
endforeach;
if($Users->DataRow['playerID']==$clanInfo[0]['leader']): 
$i=1;
foreach($applicants as $aps => $info):
?>
<form id="apply_member_<?php echo $i; ?>" name="apply_member_<?php echo $i; ?>" action="indexInternal.es?action=internalClan&tpl=internalClanMember" method="post"><input type="hidden" name="reloadToken" value="399d893bb6f9183d6af1a6c6d470335e">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="">
<input type="hidden" name="tpl" value="internalClanMember">
<input type="hidden" name="applyID" value="<?php echo $info['playerID']; ?>">
<div id="candidate_<?php echo $i; ?>" class="candidate_list fliess10px-white" style="position: absolute; top: 50px; left: 254px; width: 352px; display: none;">
    <div class="candidate_headline_close"><a href="javascript:void(0);" onclick="closeLayer('candidate_<?php echo $i; ?>');"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div class="candidate_headline_img"><img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_bewerbung&amp;f=eurostyle_clan"></div>
    <br class="clearMe">
    <div class="candidate_username"><?php echo $info[0]['Name']; ?></div>
    <div class="candidate_description"><?php echo $info['application']; ?></div>
    <div class="candidate_foot">
        <div style="float:left;width:50%;"><div id="send_apply" class="send_button"><a href="javascript:void(0);" onclick="document.getElementById('apply_member_<?php echo $i; ?>').subAction.value='applyAccept'; send('send_apply','apply_member_<?php echo $i; ?>'); return false;" style="display:block" class="fliess10px-white">Accept</a></div></div>
        <div style="float:left;width:50%;"><div id="no_button" class="close_button"><a href="javascript:void(0);" onclick="document.getElementById('apply_member_<?php echo $i; ?>').subAction.value='applyDecline'; send('no_button','apply_member_<?php echo $i; ?>'); return false;" style="display:block" class="fliess10px-white">Decline</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>
<?php
$i++;
endforeach;
else:
    
endif;

?>
<script>
var rid = '2cc837807c7d9c47a360be31b0d7c05f';


function showLayer(id) {
    showBusyLayer();
//    var win = window;
//    width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
//    container_x = document.getElementById(id).style.width.substr(0,document.getElementById(id).style.width.length-2);
//    document.getElementById(id).style.left = ((width_x/2) - (container_x*1.2))+"px";
//    document.getElementById(id).style.top = "50px";
//    document.getElementById(id).style.display = "block";
    document.getElementById(id).style.display = 'block';
}

function closeLayer(id) {
    hideBusyLayer();
    document.getElementById(id).style.display = 'none';
}

function insertNewRank () {
    var newRank = jQuery('#newRank');
    var newRankValue = newRank.attr('value');
    var clanInsertRankName = 'Enter rank name';
    if('' == newRankValue || clanInsertRankName == newRankValue) {
        newRank.attr('value', clanInsertRankName);
    } else {
        document.location.href = "indexInternal.es?action=internalClan&tpl=internalClanMember&subAction=newRank&newRankValue="+document.getElementById('newRank').value+"&"+SID+"&reloadToken="+rid;
    }
}

function deleteRank(id) {
    document.location.href = "indexInternal.es?action=internalClan&tpl=internalClanMember&subAction=deleteRank&rankID="+id+"&"+SID+"&reloadToken="+rid;
}

function send(button, formular) {
    document.getElementById(button).innerHTML='Please wait';
    document.getElementById(formular).submit();
}

function showNew() {
    var win = window;
    width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
/*  width_y = win.innerHeight ? win.innerHeight : win.document.body.clientHeight;*/

    container_x = document.getElementById("infoNewUser").style.width.substr(0,document.getElementById("infoNewUser").style.width.length-2);
/*  container_y = document.getElementById("infoPopUpContainer").style.height.substr(0,document.getElementById("infoPopUpContainer").style.height.length-2);*/
//    document.getElementById("infoNewUser").style.left = ((width_x/2) - (container_x/2))+"px";
//    document.getElementById("infoNewUser").style.top = "250px";
    document.getElementById("infoNewUser").style.display = "block";
    //return false;
}


</script>
<div id="infoNewUser" style="position:absolute;left:232.5px;top:50px;width:395px;display:none;z-index:99">
    </div>
    <div id="content">
        <!-- Navigation -->
        <div id="nav"><style type="text/css" media="screen">    @import "./css/cdn/subnav2.css?__cv=febf785093411d0376196ede13c21e00"; </style>

    <div id="subNavTop">
                <ul>
            <li title="Information"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan" ><img src="/text?t=INFORMATION&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Members"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanMember" style="background-image: url(./do_img/global/bg_subnav_selected.gif?__cv=50e42b1a79a5d5a5532f192f60de6900);"><img src="/text?t=MEMBERS&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Administration"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanAdministrate"><img src="/text?t=ADMINISTRATION&w=12&s=8&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Messages"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanMail"><img src="/text?t=MESSAGES&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Diplomacy"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanDiplomacy"><img src="/text?t=DIPLOMACY&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Company"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanChangeFirm"><img src="/text?t=COMPANY&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Battle Station"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanBattleStation"><img src="/text?t=BATTLE STATION&w=12&s=8&color=white&h=40&ph=21&b=grey"></a></li>
                    </ul>
            </div>


</div>
        <!-- Ende Navigation -->
        <!-- Content -->
        <div id="mainContentClan3">

            <div id="inner-cont" class="fliess10px-white">

                <!-- Member -->

                <div id="member_headline"> <!-- Headline -->
                    <div id="member_headline_img"><img src="/text?t=Members&w=12&s=11&color=white&b=grey"></div>
                    <div id="member_headline_link"><a href="javascript:void(0);" onclick="showLayer('editClanrights');"><div class="link_editRank" style="float:left;margin:6px 0 0 10px;">Administrate ranks</div></a></div>
                </div> <!-- Headline -->

                <div id="member_all" class="scrollbars">
                    <?php 
                        $i=1;
                        foreach($members as $mem => $info):
//                            print_r($info);
                    ?>
                    <table class="member_view_<?php echo $i; ?>" cellpadding="0" cellspacing="0" style="background-image:url(./do_img/global/clan/bg_member_1.jpg?__cv=6fbbdcbf51d02b80ae683fd027383d00);background-repeat:no-repeat;">
                    <tbody><tr>
                        <td class="member_all_td1"><strong><?php echo $info['Name']; ?></strong></td>
                        <td class="member_all_td2">Joined: 00.00.2014</td>
                        <td class="member_all_td3">Company: <?php if($info['factionId']==1): echo "MMO"; elseif($info['factionId']==2): echo "EIC"; else: echo "VRU"; endif; ?></td>
                    </tr>
                    </tbody></table>
                    <table class="member_view_<?php echo $i; ?>" cellpadding="0" cellspacing="0" style="background-image:url(./do_img/global/clan/bg_member_2.jpg?__cv=fc5e5c612aca5bc55aa9eaa433c74700);background-repeat:no-repeat;">
                    <tbody><tr>
                        <td class="member_all_td1">EP: <?php echo $info['exp']; ?></td>
                        <td class="member_all_td2">Function: <strong> <?php if($info['playerID']==$clanInfo[0]['leader']): echo "Clan leader"; else: echo "Clan Member"; endif;?>  </strong></td>
                        <td class="member_all_td3"><?php if($Users->DataRow['playerID']==$clanInfo[0]['leader']&&$info['playerID']==$clanInfo[0]['leader']):?><a href="javascript:void(0);" onclick="showLayer('changeLeader');"><div class="link_delete" style="float:left;margin-left:2px;">Transfer leadership</div></a><?php else: endif;?>
                                                                                        
                                                    </td>
                    </tr>
                    </tbody></table>
                    <table class="member_view_<?php echo $i; ?>" cellpadding="0" cellspacing="0" style="background-image:url(./do_img/global/clan/bg_member_2.jpg?__cv=fc5e5c612aca5bc55aa9eaa433c74700);background-repeat:no-repeat;">
                    <tbody><tr>
                        <td class="member_all_td1">Rank: <?php echo $base->GetRankByRNK($info['rank']); ?></td>
                        <td class="member_all_td2">Position: <?php echo $info['mapId']; ?></td>
                        <td class="member_all_td3"><?php if($Users->DataRow['playerID']==$clanInfo[0]['leader'] && $info['playerID']==$clanInfo[0]['leader']):?><a href="javascript:void(0);" onclick="showNewConfirmationLayer('Do you really want to delete this clan?', function() { jQuery('#delClanFrom').submit(); });">
                                    <div class="link_delete" style="float:left;margin-left:2px;">Delete clan</div>
                                </a><?php elseif($Users->DataRow['playerID']==$clanInfo[0]['leader']):?>  <a href="javascript:void(0);" onclick="showNewConfirmationLayer('Dismiss clan member', function() { jQuery('#kickMember_<?php echo $info['playerID'];?>').submit(); });">
                                                        <div class="link_delete" style="float:left;margin-left:2px;">Dismiss clan member</div>
                                                    </a><?php elseif($Users->DataRow['playerID']==$info['playerID']):?> <a href="javascript:void(0);" onclick="showNewConfirmationLayer('Leave clan', function() { jQuery('#kickMember_<?php echo $info['playerID'];?>').submit(); });">
                                                        <div class="link_delete" style="float:left;margin-left:2px;">Leave Clan</div>
                                                    </a> <?php else: endif;?>
                                         
                                <!--<a href="#"><div class="link_delete" style="float:left;margin-left:2px;">Delete clan</div></a>-->
                                                    </td>
                    </tr>
                    </tbody></table>
                    <div style="height:5px;"></div>
                    <?php
                    $i++;
                    endforeach;
                    ?>
                </div>
                <!-- Member -->

                <!-- New Member -->

                <div id="candidates_headline"> <!-- Headline -->
                    <div id="candidate_headline_img"><img src="/text?t=Applications&w=12&s=11&color=white&b=grey"></div>
                </div> <!-- Headline -->

                <div id="member_new" class="scrollbars">
                    <?php 
                        $i=1;
                        foreach($applicants as $aps => $info):
                     ?>
                    <table class="member_view_<?php echo $i; ?>" cellpadding="0" cellspacing="0" style="background-image:url(./do_img/global/clan/bg_member_new_1.jpg?__cv=32fdb8408d448fe04d5d06351a4ef100);background-repeat:no-repeat;">
                    <tbody><tr>
                        <td class="member_all_td1"><?php echo $info[0]['Name']; ?></td>
                        <td class="member_all_td2">Level: <?php echo $info[0]['level']; ?></td>
                        <td class="member_all_td3">Date: 00.00.1970</td>
                    </tr>
                    </tbody></table>
                    <table class="member_view_<?php echo $i; ?>" cellpadding="0" cellspacing="0" style="background-image:url(./do_img/global/clan/bg_member_2.jpg?__cv=fc5e5c612aca5bc55aa9eaa433c74700);background-repeat:no-repeat;">
                    <tbody><tr>
                        <td class="member_all_td1">EP: <?php echo $info[0]['exp']; ?></td>
                        <td class="member_all_td2">Company: <?php if($info[0]['factionId']==1): echo "MMO"; elseif($info[0]['factionId']==2): echo "EIC"; else: echo "VRU"; endif; ?></td>
                        <td class="member_all_td3"><a href="javascript:void(0);" onclick="showLayer('candidate_<?php echo $i; ?>');"><div class="link_see" style="float:left;margin-top:2px;">View</div></a><br></td>
                    </tr>
                    </tbody></table>
                    <?php
                        $i++;
                        endforeach;
                    ?>
                  </div>
                <!-- New Member -->

                <div id="member_inactive">* Users inactive longer than 4 weeks</div>
            </div>

        </div>
        <!-- Ende Content -->
        <br class="clearMe">
    </div>

<script>

    if(isChrome()) {
        jQuery('#clanTextTxt').addClass('clan_text_chrome');jQuery('.clan_news').addClass('clan_news_chrome');
    }

    function closeClanEditWindow()
    {
        closeLayer('editClaninfo');

        var currentFaction = jQuery('#actualAffiliation').val();
        jQuery('#editFactionSelection').val(currentFaction);
//        jQuery("#editFactionSelection option[value='" + currentFaction + "']").attr('selected', true);
    }

</script>
<div class="footerContainer">

<div id="alertBox" class="fliesstext"></div>
<div id="imprint" style="width:523px;height:600px;" class="fliesstext">
    <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="./do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt="" /></a></div>
    <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>EBBC D <br>6 D route de Trèves<br>L-2633 Senningerberg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jeronimo Folgueira, Jochen Siegert<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 25331016<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 261 911 3515<br>Fax: +352 49 48 48 6606<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br />An der Hauptwache 7<br />60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
</div>
<?php require GLOBALS . 'credits.php';?>

<script type="text/javascript" id="sourcecode">

    jQuery(function()
    {
        jQuery('#teamCredits_text').jScrollPane({autoReinitialise: true, showArrows: true});
    });

</script>

    <div id="imprint_ingame" class="fliesstext">
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