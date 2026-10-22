<?php
$clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$clanid = $clan->getMyClan($Users->DataRow['playerID']);
$clanInfo = $clan->getClan($clanid);
if(isset($_POST['set_rate']) && filter_var($_POST['tax_rate'], FILTER_VALIDATE_INT) && $Users->DataRow['playerID']==$clanInfo[0]['leader']){
	$tax = "UPDATE server_1_clan SET Tax = '".mysqli_real_escape_string($MySQLi, $_POST['tax_rate'])."' WHERE clanID = '".$clanInfo[0]['clanID']."'";
	$taxqry = mysqli_query($MySQLi, $tax);
}

if(isset($_POST['crgive']) && !empty($_POST['cramount']) && filter_var($_POST['cramount'], FILTER_VALIDATE_INT)){
	$replace = array(" ", "+", "-");
	$replaceto = array("", "", "");
	$crwert = str_replace($replace, $replaceto, $_POST['cramount']);
	if($clanInfo[0]['clan_credits'] >= $crwert){
		$crCmd = "UPDATE server_1_clan SET clan_credits = (clan_credits - '".$crwert."') WHERE clanID = '".$clanInfo[0]['clanID']."'";
		$crQry = mysqli_query($MySQLi, $crCmd);
		
		$crtoplayer = "UPDATE server_1_players SET credits = (credits + '".$crwert."') WHERE md5(playerID) = '".mysqli_real_escape_string($MySQLi, $_POST['crtouser'])."'";
		$crtoplayerQry = mysqli_query($MySQLi, $crtoplayer);
		$crwhoplayer = "SELECT * FROM users WHERE md5(ID) = '".mysqli_real_escape_string($MySQLi, $_POST['crtouser'])."'";
		$crwhoplayerqry = mysqli_query($MySQLi, $crwhoplayer);
		$whoplayer = mysqli_fetch_object($crwhoplayerqry);
		$logcr = "INSERT INTO server_1_clan_logs (clanID, clanplayer, descrip, logtime) VALUES ('".$clanInfo[0]['clanID']."', '".$whoplayer->Name."', 'got ".number_format($crwert,0, ",", ".")." Credits.', '".date("Y-m-d H:i:s")."')";
		$logQry = mysqli_query($MySQLi, $logcr);
	}
}
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

<script>

function showInfo() {
//	var win = window;
//	width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
//	container_x = document.getElementById("infoPopUpContainer").style.width.substr(0,document.getElementById("infoPopUpContainer").style.width.length-2);
//	document.getElementById("infoPopUpContainer").style.left = ((width_x/2) - (container_x/2))+"px";
//	document.getElementById("infoPopUpContainer").style.top = "230px";
	document.getElementById("infoPopUpContainer").style.display = "block";
    showBusyLayer();
}

function closeAll() {
    document.getElementById("infoPopUpContainer").style.display = "none";
    hideBusyLayer();
}

</script>
<div id="infoPopUpContainer" style="position: absolute; left: 50%; top: 280px; width: 350px; margin-left: -175px; display: none; z-index: 2;">


    <div style="width:352px;height:186px;background-image:url(./do_img/global/clan/info_bg_standard.jpg?__cv=e110484832cb46ace456ab360d621c00);text-align:left;">
        <div style="float:right;padding:8px 8px 0 0;"><a href="javascript:void(0);" onclick="closeAll();"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
        <div style="float:left;padding:16px 0 0 16px;"><img src="do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_systemnachricht&amp;f=eurostyle_clan"></div>
        <br class="clearMe">
        <div class="fliess10px-white" style="width:284px;height:65px;margin:17px 0 0 30px;overflow:auto;">You already submitted a diplomacy request to this clan.</div>
        <br class="clearMe">
        <div style="margin:27px 0 0 125px">
            <a href="javascript:void(0);" onclick="closeAll();" class="fliess10px-white" style="cursor:pointer"><div style="width:99px;height:15px;background-image:url(./do_img/global/clan/bg_button.gif?__cv=64bbe91ffda8d3988dd016c99cf47800);text-align:center;">OK</div></a>
        </div>
    </div>

</div>
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
<div id="editRequests" style="position: absolute; top: 50px; left: 238px; width: 384px; display: none;" class="fliess10px-white">
    <div id="editRequests_close"><a href="javascript:void(0);" onclick="closeLayer('editRequests');"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div id="editRequests_headline"><img src="/text?t=Pending requests&w=16&s=11&color=white&b=grey"></div>
    <br class="clearMe">
    <div id="editRequests_showAll">
        <table margin="0" padding="0" style="width:100%">
            <?php 
            $i =1;
            foreach($MyPending as $k => $v):
                ?>
                    <form id="diploRequests_<?php echo $i; ?>" name="clantext" action="indexInternal.es?action=internalClan&tpl=internalClanDiplomacy">
                    <input type="hidden" name="reloadToken" value="02b6ffb8c55734805acaafa8ca254d24">
                    <input type="hidden" name="action" value="internalClan">
                    <input type="hidden" name="subAction" value="deleteOpenDiploRequest">
                    <input type="hidden" name="type" value="<?php echo $v['type']; ?>">
                    <input type="hidden" name="mID" value="<?php echo $clanid; ?>">
                    <input type="hidden" name="tID" value="<?php echo $v['fromID']; ?>">
                    <input type="hidden" name="tpl" value="internalClanDiplomacy">
                    <input type="hidden" name="requestID" value="<?php echo $v['autoID']; ?>">
                    <tbody><tr>
                        <td style="width:50px">00.00</td>
                        <td style="width:25%;white-space:nowrap;padding-right:3px;"><?php if($v['fromID']==$clanid): echo $clan->getClanName($v['toID']); else: echo $clan->getClanName($v['fromID']); endif;  ?></td>
                        <td style="width:25%"><?php if($v['type']==3): echo "end war"; else: echo $clan->getType($v['type']); endif;?></td>
                        <td style="width:25%">Waiting ...</td>
                        <?php
if($Users->DataRow['playerID']==$clanInfo[0]['leader']):
    ?>
                        <td><a href="javascript:void(0);" onclick="document.getElementById('diploRequests_<?php echo $i; ?>').submit(); return;"><div class="link_delete" style="float:left;margin-left:15px;"><br></div></a></td>
                    <?php endif; ?>
                        </tr>
                </form>
                <?php
                $i++;
            endforeach;
            ?>
        
        
        </tbody></table>
    </div>
    <br class="clearMe">
</div>

<form id="stop_war" name="stop_war" action="indexInternal.es?action=internalClan&tpl=internalClanDiplomacy"><input type="hidden" name="reloadToken" value="3524763d224185b610602b5fa6fddb56">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="stopWar">
<input type="hidden" name="status" value="stopWar">
<input type="hidden" name="clanID" id="clanID" value="">
<input type="hidden" name="type_typo" id="type_typo" value="">
<input type="hidden" name="diploID" id="diploID" value="">
<input type="hidden" name="diploForm2" id="diploForm2" value="0">
<input type="hidden" name="tpl" value="internalClanDiplomacy">
    <div id="stopWar" style="position:absolute;top:50px;left:254px; width:352px;z-index: 3;" class="fliess10px-white">
    <div id="stopWar_close"><a href="javascript:void(0);" onclick="closeLayer('stopWar');"><img src="/do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div id="stopWar_headline"><img src="/text?t=Diplomacy request&w=16&s=11&color=white&b=grey"></div>
    <br class="clearMe">
    <div id="clanName"><br></div>
    <div id="stopWar_form_headline">Form</div>
    <div id="stopWar_form_value">End war</div>
    <div id="stopWar_desription">Text</div>
    <div style="position:absolute; top: 130px; ">
        <textarea name="descr" class="fliess10px-white" style="width:288px;height:60px;margin:2px 0 0 30px;background:none;border:none;overflow: hidden"></textarea>
    </div>
    <!--<div style="height:30px;"></div>-->
    <div id="stopWar_footer">
        <div style="float:left;width:50%;"><div class="send_button" id="send_stopwar"><a href="javascript:void(0);" onclick="send('send_stopwar','stop_war'); return false;" style="display:block;" class="fliess10px-white">OK</a></div></div>
        <div style="float:left;width:50%;"><div class="close_button" id="no_button"><a href="javascript:void(0);" onclick="closeLayer('stopWar')" style="display:block" class="fliess10px-white">Cancel</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>
<script>

function showLayer(id) {
    showBusyLayer();
//    var win = window;
//    width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
//    container_x = document.getElementById(id).style.width.substr(0,document.getElementById(id).style.width.length-2);
//    document.getElementById(id).style.left = ((width_x/2) - (container_x*1.5))+"px";
//    document.getElementById(id).style.top = "50px";
//    document.getElementById(id).style.display = "block";
    document.getElementById(id).style.display = 'block';
}

function closeLayer(id) {
    hideBusyLayer();
    document.getElementById(id).style.display = 'none';
}

function send(button, formular) {
    document.getElementById(button).innerHTML='Please wait';
    document.getElementById(formular).submit();
}


function showNew() {
    var win = window;
    width_x = win.innerWidth ? win.innerWidth : win.document.body.clientWidth;
/*    width_y = win.innerHeight ? win.innerHeight : win.document.body.clientHeight;*/

    container_x = document.getElementById("infoNewUser").style.width.substr(0,document.getElementById("infoNewUser").style.width.length-2);
/*    container_y = document.getElementById("infoPopUpContainer").style.height.substr(0,document.getElementById("infoPopUpContainer").style.height.length-2);*/
    document.getElementById("infoNewUser").style.left = ((width_x/2) - (container_x*1.5))+"px";
    document.getElementById("infoNewUser").style.top = "50px";
    document.getElementById("infoNewUser").style.display = "block";
    //return false;
}



function getClanID(clanID) {
    search = document.getElementById("clanList");

    for ( i = 0; i<search.options.length; i++) {
        if (search.options[i].value == clanID) {
            search.options[i].selected = "true";
            document.getElementById("showUserSearch").style.display = "none";
            document.getElementById("clanSearchAjax").value = '';
        }
    }
}

function setClan(clanID,count) {
    document.getElementById('clanSearchAjax').value = document.getElementById('setClanName_'+count).innerHTML;
    document.getElementById('clanList').value = clanID;
    document.getElementById('showUserSearch').style.display = "none";
}

function updateStopWarLayer(diploID, clanID, clanName, type, typo) {
    document.getElementById("clanName").innerHTML = clanName;
    document.getElementById("clanID").value = clanID;
    document.getElementById("diploID").value = diploID;
    document.getElementById("type_typo").value = typo;
    document.getElementById("stopWar_form_value").innerHTML = "End "+type;
}

function sendForm() {
    document.getElementById('diplo').submit();
    return false;
}

function encode_utf8(rohtext) {
     // dient der Normalisierung des Zeilenumbruchs
     rohtext = rohtext.replace(/\r\n/g,"\n");
     var utftext = "";
     for(var n=0; n<rohtext.length; n++)
         {
         // ermitteln des Unicodes des  aktuellen Zeichens
         var c=rohtext.charCodeAt(n);
         // alle Zeichen von 0-127 => 1byte
         if (c<128)
             utftext += String.fromCharCode(c);
         // alle Zeichen von 127 bis 2047 => 2byte
         else if((c>127) && (c<2048)) {
             utftext += String.fromCharCode((c>>6)|192);
             utftext += String.fromCharCode((c&63)|128);}
         // alle Zeichen von 2048 bis 66536 => 3byte
         else {
             utftext += String.fromCharCode((c>>12)|224);
             utftext += String.fromCharCode(((c>>6)&63)|128);
             utftext += String.fromCharCode((c&63)|128);}
         }
     return utftext;
 }

function sendSearch () {
    if (document.getElementById('clanSearchAjax').value.length > 2) {
        x_searchUser(encode_utf8(document.getElementById('clanSearchAjax').value), searchUser_cb)
    }
}

function searchUser_cb(erg) {

    document.getElementById("showUserSearch").innerHTML = "";
    if (erg['count']==0) {
        document.getElementById("showUserSearch").style.display = "none";
    }
    for (var i=0; i<erg['count']; i++) {
        var subDiv = document.createElement('div');
        subDiv.setAttribute('id', 'search_'+i);
        subDiv.setAttribute('class', 'normal');
        //subDiv.setAttribute('onmouseover', 'buttonOver(this.id, "#FF0000");');
        //subDiv.setAttribute('onmouseout', 'buttonOut(this.id, "transparent");');
        if (i==0) {
            subDiv.innerHTML = '<div style="float:right"><a href="javascript:void(0);" onclick="document.getElementById(\'showUserSearch\').style.display = \'none\'" style="\'float:left\'"><img src="./do_img/global/icon_delete.gif?__cv=5f7dbe1a9b7514b34fc55fb803c89700"></a></div><br />';
        }
        //subDiv.innerHTML += '<a style="display:block" onmouseover="this.style.backgroundColor=\'#A1C8E7\'" onmouseout="this.style.backgroundColor=\'transparent\'" href="javascript:void(0);" onclick="getClanID('+erg['daten'][i].clan_clanID+')">'+erg['daten'][i].clan_name+'</a>';
        subDiv.innerHTML += '<a style="display:block" id="setClanName_'+i+'" onmouseover="this.style.backgroundColor=\'#A1C8E7\'" onmouseout="this.style.backgroundColor=\'transparent\'" href="javascript:void(0);" onclick="setClan('+erg['daten'][i].clan_clanID+','+i+');">'+erg['daten'][i].clan_name+'</a>';

        document.getElementById("showUserSearch").appendChild(subDiv);
        document.getElementById("showUserSearch").style.display = 'block';
    }
}


</script>

<div id="infoNewUser" style="position:absolute;left:232.5px;top:50px;width:395px;display:none;z-index:99">
    </div>
    <div id="content">
        <!-- Navigation -->
        <div id="nav"><style type="text/css" media="screen">    @import "./css/cdn/subnav2.css?__cv=febf785093411d0376196ede13c21e00"; </style>

    <div id="subNavTop">
               <ul>
            <li title="Information"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan"><img src="/text?t=INFORMATION&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Members"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanMember" ><img src="/text?t=MEMBERS&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Administration"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanAdministrate" style="background-image: url(./do_img/global/bg_subnav_selected.gif?__cv=50e42b1a79a5d5a5532f192f60de6900);"><img src="/text?t=ADMINISTRATION&w=12&s=8&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Messages"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanMail"><img src="/text?t=MESSAGES&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Diplomacy"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanDiplomacy"><img src="/text?t=DIPLOMACY&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Company"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanChangeFirm"><img src="/text?t=COMPANY&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Battle Station"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanBattleStation"><img src="/text?t=BATTLE STATION&w=12&s=8&color=white&h=40&ph=21&b=grey"></a></li>
                    </ul>
            </div>


</div>
        <!-- Ende Navigation -->
        <!-- Content -->
        <div id="mainContentClan6">

            <div id="inner-cont" class="fliess10px-white">

                <!-- Beziehungen -->
                <!-- <img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_clan_diplomatie&amp;f=eurostyle_clan"></div> -->
                <div id="diplo_all_headline"> <!-- Headline -->
                    <div style="float:left;width:210px;">Clan Administration</div>
                </div> <!-- Headline -->
                <br class="clearMe">
                <div id="diplo_all" class="scrollbars">
						<div style="float:left; padding:10px 10px 10px 10px;">
							<h2 style="color:#fff;">Clan Settings</h2>
							<table>
							<?php if($Users->DataRow['playerID']!=$clanInfo[0]['leader']){ ?>
								<tr>
									<th>Tax Rate:</th>
									<td><?=$clanInfo[0]['Tax']?> %</td>
								</tr>
							<?php } else { ?>
								<tr>
									<form method="post" action="">
									<th>Tax Rate:</th>
									<td><select name="tax_rate" style="font-size:10px; background:none; color:#fff; border:none;"><?php for($t=0;$t<6;++$t){?><option <?php if($clanInfo[0]['Tax'] == $t){echo 'selected';}?> value="<?=$t?>"><?=$t?>%</option>'<?php ;}?></select></td>
									<td><input type="submit" value="Set" name="set_rate" style="padding-left: 12px; background: url('/do_img/global/icon_send.gif?__cv=e6cfb6516828bd9b3047f6308833ee00') no-repeat; border:none; font-size:10px; color:#A1C8E7; cursor:pointer;"></td>
									</form>
								</tr>
							<?php ;} ?>
								<tr>
									<th>Clan Credits:</th>
									<td style="padding-left:4px;"><?=number_format($clanInfo[0]['clan_credits'],0, ",", ".");?></td>
								</tr>
							</table>
						</div>
				</div>
				
                <!-- Beziehungen -->

                <!-- Neue Beziehungen -->

                <!-- Headline -->
                <div id="diplo_new_headline">
                    Logs
                </div>
                <!-- Headline -->

                <br class="clearMe">

                <div id="diplo_new" class="scrollbars">
                     <table width="100%" border="0" cellpadding="0" cellspacing="0" class="fliess11px-grey diplo-new-1">
						<tbody>
							<tr style="height:16px;">
								<td>User</td>
								<td>Description</td>
								<td>Date</td>
							</tr>
						<?php 
						$clc = "SELECT * FROM server_1_clan_logs WHERE clanID = '".$clanInfo[0]['clanID']."' ORDER BY logtime DESC LIMIT 70";
						$clq = mysqli_query($MySQLi, $clc);
						while($myclanlog = mysqli_fetch_array($clq)){ ?>
							<tr style="height:16px;">
								<td><?=$myclanlog['clanplayer']?></td>
								<td><?=$myclanlog['descrip']?></td>
								<td><?=date("d.m.Y", strtotime($myclanlog['logtime']))?></td>
							</tr>
						<?php ;} ?>
						</tbody>
					</table>                               
                </div>
                <!-- Neue Beziehungen -->

                <div id="diplo_apply_headline"> <!-- Headline -->
                    <div style="float:left;">Credits Distribute</div>
                        <br class="clearMe">
                </div> <!-- Headline -->
                <?php
                if($Users->DataRow['playerID']==$clanInfo[0]['leader']):
                    ?>
				<form method="post" action="">
                <div id="diplo_apply_content">
                    <div style="float:left">
                        <select name="crtouser" style="font-size:10px;">
							<?php
								$members = explode("|", $clanInfo[0]['members']);
								foreach($members as $crto){
								$userCmd = "SELECT * FROM server_1_players INNER JOIN users ON users.ID = server_1_players.playerID WHERE server_1_players.playerID = '".$crto."'";
								$userQry = mysqli_query($MySQLi, $userCmd);
								$user = mysqli_fetch_object($userQry);
							?>
								<option value="<?=md5($crto)?>"><?=$user->Name?></option>
							<?php ;} ?>
						</select>
						<input type="text" name="cramount" placeholder="How much Credits?" style="font-size:10px;">
						<input type="submit" value="Give Credits to User" name="crgive" style="padding-left: 12px; background: url('/do_img/global/icon_send.gif?__cv=e6cfb6516828bd9b3047f6308833ee00') no-repeat; border:none; font-size:10px; color:#A1C8E7; cursor:pointer;">
                    </div>
                    
                    <br class="clearMe">
                </div>
                </form>
                <?php
                endif;
                ?>

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