<?php
$clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
$clanid = $clan->getMyClan($Users->DataRow['playerID']);
$clanInfo = $clan->getClan($clanid);
if(isset($_GET['subAction']) && $_GET['subAction']=="showClanInfo"):
   $clanIn = $clan->getClan($_GET['clanID']);
    $col = $clanIn[0];
endif;
//print_r($clanInfo);
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
                <form id="firmenauswahl" name="firmenauswahl" action="indexInternal.es"><input type="hidden" name="reloadToken" value="9c5f4bb67c92ec8967c21c2e50a9da46">
            <input type="hidden" name="action" value="internalClan">
            <input type="hidden" name="subAction" value="editClanInfo">
            <input type="hidden" name="postback" value="1">
            <input type="hidden" name="tpl" value="internalClan">
            <div id="editClaninfo" class="fliess10px-white" style="position:absolute;top:50px;left:254px;width:352px;">
                <div id="editClaninfo_close"><a href="javascript:void(0);" onclick="closeClanEditWindow();"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
                <div id="editClaninfo_headline"><img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_claninformationen&amp;f=eurostyle_clan"></div>
                <br class="clearMe">
                <div id="editClaninfo_faction">Company affiliation:</div>
                <div id="editClaninfo_faction_choose" class="fliess10px-black">
                    <select name="firmenauswahl" id="editFactionSelection" style="width:120px;" class="fliess10px-black">
                        <option value="0">All</option>
                        <option value="1">Mars Mining Operations (MMO)</option>
                        <option value="2">Earth Industries Corporation (EIC)</option>
                        <option value="3">Venus Resources Unlimited (VRU)</option>
                    </select>
                    <input type="hidden" id="actualAffiliation" name="actualAffiliation" value="0">
                </div>
                <br class="clearMe">
                <div class="changeInfo_name_title"><label for="clan_name">Clan name:</label></div>
                <div><input type="text" id="clan_name" name="clan_name" value="Seven & NavigatoR" class="changeInfo_name_input fliess10px-white"></div>
                <div class="changeInfo_tag_title"><label for="clan_tag">Clan tag:</label></div>
                <div><input type="text" id="clan_tag" name="clan_tag" value="Seven & NavigatoR" maxlength="4" class="changeInfo_tag_input fliess10px-white"></div>
                    <div class="changeInfo_ts_title"><label for="clan_ts">Teamspeak address:</label></div>
                <div><input type="text" id="clan_ts" name="clan_ts" value="" class="changeInfo_ts_input fliess10px-white"></div>

                <div id="editClaninfo_recruiting">Recruiting Status:</div>
                <div id="editClaninfo_recruiting_choose" class="fliess10px-black">
                    <select name="recruiting_status" style="width:120px;" class="fliess10px-black">
                        <option value="1" selected="selected">Recruiting</option>
                        <option value="11">Recruiting (Level 10+)</option>
                        <option value="12">Recruiting (Level 16+)</option>
                        <option value="13">Recruiting (Fully Elite)</option>
                        <option value="0">Closed</option>
                    </select>
                </div>
                <br class="clearMe">

                <br class="clearMe">
                <div class="changeInfo_footer">
                    <div style="float:left;width:50%;"><div id="send_clandata" class="send_button"><a href="javascript:void(0);" onclick="send('send_clandata','firmenauswahl');" style="display:block" class="fliess10px-white">OK</a></div></div>
                    <div style="float:left;width:50%;"><div class="close_button"><a href="javascript:void(0);" onclick="closeClanEditWindow()" style="display:block" class="fliess10px-white">Cancel</a></div></div>
                    <br class="clearMe">
                </div>
            </div>
            </form>
                <form id="imgUpload" name="imgUpload" action="indexInternal.es" method="POST" enctype="multipart/form-data"><input type="hidden" name="reloadToken" value="92fbf2eac3c11c9b2e7ba7bb86826bed">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="upload">
<input type="hidden" name="tpl" value="internalClan">
<div id="editClanPic" style="position:absolute;top:50px;left:254px;width:352px;" class="fliess10px-white">
    <div id="editClanPic_close"><a href="javascript:void(0);" onclick="closeEditPic();"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div id="editClanPic_headline"><img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_clan_logo&amp;f=eurostyle_clan"></div>
    <br class="clearMe">
    <div class="editClanPic_pic"><img src="./do_img/global/clan/default.jpg?_cv=d0fe7802028be7b66bfe6f8c1124d500" width="81" height="81" alt=""></div>
    <div class="editClanPic_descr">
        <p>Upload your clan logo here. Please abide to the following rules:</p>
         <ul style="padding:10px 0 0 5px;">
            <li>- JPG or GIF only</li>
            <li>- No larger than 15KB</li>
            <li>- No forbidden symbols</li>
            <li>- No offensive images</li>
            <li>- Animated GIFs are allowed</li>
         </ul>
    </div>
    <div style="clear:both"></div>
    <div style="text-align:center; margin-top:12px;">
        <input name="logo" type="file">
    </div>
    <div style="clear:both"></div>
    <div style="margin-top: 8px">
        <div style="float:left;width:50%;"><div id="sendclanpic" class="send_button"><a href="javascript:void(0);" onclick="send('sendclanpic','imgUpload');" class="send_button_clanPic fliess10px-white">OK</a></div></div>
        <div style="float:left;width:50%;"><div class="close_button"><a href="javascript:void(0);" onclick="closeEditPic();" class="send_button_clanPic fliess10px-white">Cancel</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>
<form id="clantext" name="clantext" action="indexInternal.es"><input type="hidden" name="reloadToken" value="9c5f4bb67c92ec8967c21c2e50a9da46">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="changeClanDescription">
<input type="hidden" name="tpl" value="internalClan">
<div id="editClanText" style="position:absolute;top:50px;left:254px;width:352px;" class="fliess10px-white">
    <div id="editClanText_close"><a href="javascript:void(0);" onclick="closeClanText();"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div id="editClanText_headline"><img src="./do_img/global/text.esg?l=en&amp;s=9&amp;t=clan_hl_clan_text&amp;f=eurostyle_clan"></div>
    <br class="clearMe">
    <div id="editClanText_cont">
        <textarea cols="17" rows="4" name="clandescription" style="width:286px;height:94px;border:none;background-color:transparent;padding:5px;" class="scrollbars fliess10px-white">Seven & NavigatoR</textarea>
    </div>
    <br class="clearMe">
    <div>
        <div style="float:left;width:50%;"><div id="sendclantext" class="send_button"><a href="javascript:void(0);" onclick="send('sendclantext','clantext');" class="send_button_clanPic fliess10px-white">OK</a></div></div>
        <div style="float:left;width:50%;"><div class="close_button"><a href="javascript:void(0);" onclick="closeClanText();" class="send_button_clanPic fliess10px-white">Cancel</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>
<form name="clannews" id="clannews" method="post" action="indexInternal.es?action=internalClan"><input type="hidden" name="reloadToken" value="9c5f4bb67c92ec8967c21c2e50a9da46">
<input type="hidden" name="action" value="internalClan">
<input type="hidden" name="subAction" value="addNews">
<input type="hidden" name="tpl" value="internalClan">
<div id="editClanNews" style="position:absolute;top:50px;left:254px;width:352px;" class="fliess10px-white">
    <div id="editClanNews_close"><a href="javascript:void(0);" onclick="closeClanNews();"><img src="./do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <br class="clearMe">
    <div id="editClanNews_cont">
        <textarea cols="17" rows="4" name="newsText" style="width:286px;height:94px;border:none;background-color:transparent;padding:5px;" class="scrollbars fliess10px-white"></textarea>
    </div>
    <br class="clearMe">
    <div style="margin-top:10px;">
        <div style="float:left;width:50%;"><div id="sendnewstext" class="send_button"><input type="submit" name="clannewssend" value="Send" style="background:none; border:none; color:#F1C839; cursor:pointer; font-size:10px; width:99px;"></div></div>
        <div style="float:left;width:50%;"><div class="close_button"><a href="javascript:void(0);" onclick="closeClanNews();" class="send_button_clanPic fliess10px-white">Cancel</a></div></div>
        <br class="clearMe">
    </div>
</div>
</form>
<?php 
if(isset($_GET['subAction']) && $_GET['subAction']=="showClanInfo"):
    
?>
    <div id="showClanInfo" style="width: 352px; height: 336px; position: absolute; left: 0px; top: 50px; display: block; z-index: 50; background-image: url(/do_img/global/clan/bg_clan_info.jpg);" class="fliess10px-white">
    <div style="float:right;padding:8px 8px 0 0;"><a href="javascript:void(0);" onclick="closeInfo('showClanInfo');"><img src="/do_img/global/clan/close.jpg?__cv=c35f9cf0f69102728804ab5750708d00"></a></div>
    <div style="float:left;padding:14px 0 0 16px;"><img src="/text?t=Clan info&w=14&s=11&color=white&b=grey"></div>
    <br class="clearMe">
    <div class="clanInfo_pic"><img src="/do_img/global/clan/default.jpg" width="80" height="80"></div>
    <div class="clanInfo_descr"><?php  echo $col['clandescription']; ?></div>
    <br class="clearMe">
    <div id="showClanInfo_cont">
    <table cellpadding="0" cellspacing="0" width="289">
        <tbody><tr>
            <td style="width:111px;background-image:url(/do_img/global/clan/bg_nomemb_list1.jpg);height:16px;padding-left:5px;">Name: </td>
            <td style="width:188px;background-image:url(/do_img/global/clan/bg_nomemb_list2.jpg);padding-left:5px;"><?php echo $col['clanName']; ?></td>
        </tr>
        <tr>
            <td style="height:16px;padding-left:5px;">Tag: </td>
            <td style="padding-left:5px;">[<?php echo $col['tagName']; ?>]</td>
        </tr>
        <tr>
            <td style="background-image:url(/do_img/global/clan/bg_nomemb_list1.jpg);height:16px;padding-left:5px;">Founding date: </td>
            <td style="background-image:url(/do_img/global/clan/bg_nomemb_list3.jpg);padding-left:5px;"><?php echo $col['Found']; ?></td>
        </tr>
        <tr>
            <td style="height:16px;padding-left:5px;">Clan-Leader: </td>
            <td style="padding-left:5px;"><?php echo $clan->GetClanLeader($col['leader']); ?></td>
        </tr>
        <tr>
            <td style="background-image:url(/do_img/global/clan/bg_nomemb_list1.jpg);height:16px;padding-left:5px;">Number of members: </td>
            <td style="background-image:url(/do_img/global/clan/bg_nomemb_list3.jpg);padding-left:5px;"><?php echo $col['memberCount']; ?></td>
        </tr>
        <tr>
            <td style="height:16px;padding-left:5px;">Clan rank: </td>
            <td style="padding-left:5px;"><?php echo $col['rank']; ?></td>
        </tr>
        <tr>
            <td style="background-image:url(/do_img/global/clan/bg_nomemb_list1.jpg);height:16px;padding-left:5px;">Company: </td>
            <td style="background-image:url(/do_img/global/clan/bg_nomemb_list3.jpg);padding-left:5px;"><?php echo $col['company']; ?></td>
        </tr>
                <tr>
            <td colspan="2" style="height:16px;"><br></td>
        </tr>
    </tbody></table>
    </div>
    <div id="showClanInfo_foot">
        <div id="showClanInfo_close">
            <a href="javascript:void(0);" onclick="closeInfo('showClanInfo');" class="fliess10px-white" style="cursor:pointer;display:block;">Close</a>
        </div>
    </div>
</div>
                <?php    
endif;  ?> 
<script type="text/javascript">
rid = 'ddb2d8b3509d19028d00c15a64442186';

function changeFaction(id, factionName) {
    showBusyLayer();
    $('factionName').innerHTML = factionName;
    $('changeFaction').onclick = new Function("sendChangeFaction('indexInternal.es.php?action=internalClan&subAction=changeFirm&tpl=internalClanChangeFirm&newFirm="+id+"&reloadToken="+rid+"')");
//    width_x = document.body.offsetWidth;
//    container_x = $("change").getWidth();
//    $("change").style.left = ((width_x/2) - (container_x*1.2))+"px";
//    $("change").style.top = "50px";
    $("change").style.display = "block";
}

function sendChangeFaction (target) {
    document.location.href = target;
}
function changeFactionImg(wich) {
    var image = $(wich).src;
    //var endung = (image.substr(image.length-3,3));
    if((image.substr(image.length-5,1)) == 0) {
        var teil = 1;
        var endung = 'gif';
    } else {
        var teil = 0;
        var endung = 'jpg';
    }
    var newImage = (image.substring(0,image.length-5)) + teil + "." +endung;
    $(wich).src = newImage;
}

</script>
<script>

var rid = '9c5f4bb67c92ec8967c21c2e50a9da46';

function getClaninfo(clanID) {
    //document.location.href = "indexInternal.es?action=internalClan&"+SID+"&reloadToken="+rid+"&subAction=showClanInfo&clanID="+document.clanEnter.clanList.options[document.clanEnter.clanList.selectedIndex].value;
    document.location.href = "indexInternal.es?action=internalClan&"+SID+"&reloadToken="+rid+"&subAction=showClanInfo&clanID="+clanID;
}

function closeInfo(wert) {
    document.getElementById(wert).style.display = "none";
    hideBusyLayer();
}

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
function closeEditPic() {
    hideBusyLayer();
    document.getElementById('editClanPic').style.display = 'none';
}
function closeClanText() {
    hideBusyLayer();
    document.getElementById('editClanText').style.display = 'none';
}
function closeClanNews() {
    hideBusyLayer();
    document.getElementById('editClanNews').style.display = 'none';
}

function send (button, formular) {
    document.getElementById(button).innerHTML='Please wait';
    document.getElementById(formular).submit();
    return false;
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

function searchUser_cb(erg)
{
    var userSearch = jQuery('#showUserSearch');
    userSearch.html('');

    if (erg.count < 1) {
        userSearch.hide();
    }

    for (var i = 0; i < erg.count; i++) {
        var subDiv = document.createElement('div');
        subDiv.setAttribute('id', 'search_'+i);
        subDiv.setAttribute('class', 'normal');
        subDiv.innerHTML = '<a style="display:block" onmouseover="this.style.backgroundColor=\'#A1C8E7\'" onmouseout="this.style.backgroundColor=\'transparent\'" href="javascript:void(0);" onclick="getClaninfo('+erg.daten[i].clan_clanID+')">'+erg.daten[i].clan_name+'</a>';

        userSearch.append(subDiv);
        userSearch.show();
    }
}


</script>
    <div id="content">
        <!-- Navigation -->
        <div id="nav"><style type="text/css" media="screen">    @import "./css/cdn/subnav2.css?__cv=febf785093411d0376196ede13c21e00"; </style>

    <div id="subNavTop">
                <ul>
            <li title="Information"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan" style="background-image: url(./do_img/global/bg_subnav_selected.gif?__cv=50e42b1a79a5d5a5532f192f60de6900);"><img src="/text?t=INFORMATION&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
            <li title="Members"><a onfocus="this.blur()" href="indexInternal.es?action=internalClan&amp;tpl=internalClanMember" ><img src="/text?t=MEMBERS&w=12&s=9&color=white&h=40&ph=21&b=grey"></a></li>
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
        <div id="mainContentClan2">

            <div id="inner-cont">

                <!-- Clan Info -->
                <div id="clanInfo" class="fliess10px-white">

                    <div id="clanInfo_headline">
						<div style="float:left;"><img src="/text?t=Clan Information&w=14&s=11&color=white&b=grey"></div>
                        <a href="javascript:void(0);" onclick="showLayer('editClaninfo');"><div class="link_edit" style="float:left;margin-left:15px;">Edit</div></a><br>
                        <br class="clearMe">
                    </div>

                    <div id="clanInfo_data">
                        <div class="clan-info-row">
                            <div class="clan-info-1st">Tag/Clan name:</div>
                            <div class="clan-info-2nd">[<?php echo $clanInfo[0]['tagName']; ?>] <?php echo $clanInfo[0]['clanName']; ?></div>
                        </div>
                        <br class="clearMe">
                        <div>
                            <div class="clan-info-1st">Founding date:</div>
                            <div class="clan-info-2nd"><?php echo $clanInfo[0]['Found']; ?></div>
                        </div>
                        <br class="clearMe">
                        <div class="clan-info-row">
                            <div class="clan-info-1st">Clan leader:</div>
                            <div class="clan-info-2nd"><?php echo $clan->GetClanLeader($clanInfo[0]['leader']); ?></div>
                        </div>
                        <br class="clearMe">
                        <div>
                            <div class="clan-info-1st">Number of members:</div>
                            <div class="clan-info-2nd"><?php echo $clanInfo[0]['memberCount']; ?></div>
                        </div>
                        <br class="clearMe">
                        <div class="clan-info-row">
                            <div class="clan-info-1st">Clan rank:</div>
                            <div class="clan-info-2nd"><?php echo $clanInfo[0]['rank']; ?></div>
                        </div>
                        <br class="clearMe">
                        <div>
                            <div class="clan-info-1st">Company affiliation:</div>
                            <div class="clan-info-2nd"><?php echo $clanInfo[0]['company']; ?>
                                </div>
                        </div>
                        <br class="clearMe">
                        <div class="clan-info-row">
                            <div class="clan-info-1st">Tax rate:</div>
							<?php 
								$members = explode("|", $clanInfo[0]['members']);
								$steuer=0;
								foreach($members as $member){
									$userCmd = "SELECT * FROM server_1_players INNER JOIN users ON users.ID = server_1_players.playerID WHERE server_1_players.playerID = '".$member."'";
									$userQry = mysqli_query($MySQLi, $userCmd);
									$user = mysqli_fetch_object($userQry);
									$steuer = $steuer + round($user->credits /100 * $clanInfo[0]['Tax']);
								}
							?>
                            <div class="clan-info-2nd"><?php echo $clanInfo[0]['Tax']; ?>% (<?=number_format($steuer,0, ",", ".");?> Credits / Daily)</div>
                        </div>
                        <br class="clearMe">
                        <div>
                            <div class="clan-info-1st">Teamspeak address:</div>
                            <div class="clan-info-2nd"><?php echo $clanInfo[0]['Teamspeak']; ?></div>
                        </div>
                        <br class="clearMe">
                        <div class="clan-info-row">
                            <div class="clan-info-1st">Recruiting Status</div>
                            <div class="clan-info-2nd">Recruiting</div>
                        </div>
                        <br class="clearMe">
                    </div>
                </div>
                <!-- Clan Info -->

                <!-- Clan Image -->
                <div id="clanImage" class="fliess10px-white">
                    <img src="/text?t=Clan Logo&w=12&s=11&color=white&b=grey">
                    <div id="clanImage_picture" class="fliess10px-white">
                        <div style="width:100px;height:100px;">
                            <img src="./do_img/global/clan/default.jpg?_cv=6f604c69991473115b7cafe2b7634900" width="80" height="80">
                        </div>
                        <a href="javascript:void(0);" onclick="showLayer('editClanPic');"><div class="link_edit" style="float:left;margin-top:15px;">Edit</div></a>                    </div>
                </div>
                <!-- Clan Image -->

                <br class="clearMe">

                <!-- Clan Text -->
                <div id="box_clan_text" class="fliess10px-white">
                    <div>
                        <span style="float:left;"><img src="/text?t=Clan text&w=12&s=11&color=white&b=grey"></span>
                        <a href="javascript:void(0);" onclick="showLayer('editClanText');"><span class="link_edit" style="float:left;margin-left:15px;">Edit</span></a>                    </div>
                    <textarea id="clanTextTxt" readonly="readonly" class="clan_text scroll fliess10px-white clan_text_chrome"><?php echo $clanInfo[0]['clandescription']; ?></textarea>
                </div>
                <!-- Clan Text -->
                <!-- Clan News -->
                <div id="box_clan_news" class="fliess10px-white">
                    <div style="float:left;"><img src="/text?t=Clan news&w=12&s=11&color=white&b=grey"></div>
                    <a href="javascript:void(0);" onclick="showLayer('editClanNews');"><div class="link_add" style="float:left;margin-left:15px;">Add</div></a><br>
                    <br class="clearMe">
                    <div class="clan_news clan_news_chrome">
					<?php
						if(isset($_POST['clannewssend']) && !empty($_POST['newsText'])){
							$icn = "INSERT INTO server_1_clan_news (clanID, news) VALUES ('".$clanInfo[0]['clanID']."', '".mysqli_real_escape_string($MySQLi, $_POST['newsText'])."')";
							$icq = mysqli_query($MySQLi, $icn);
						}
						$cnews = "SELECT * FROM server_1_clan_news WHERE clanID = '".$clanInfo[0]['clanID']."' ORDER BY ctime DESC";
						$cqry = mysqli_query($MySQLi, $cnews);
						while($cn = mysqli_fetch_array($cqry)){
					?>
						<div style="border-bottom:1px solid #52534e;">
							<div class="box_clan_news_date"><?=date("d.m.Y", strtotime($cn['ctime']))?> - </div>
                            <div class="box_clan_news_data"><?=$cn['news']?></div>
                            <br class="clearMe">
                        </div>
					<?php ;} ?>
					</div>
					
				</div>
                <!-- Clan News -->

                <!-- Clan Suche -->
                <div id="clanSearch" class="fliess10px-white">
                    <img src="/text?t=Clan Search&w=12&s=11&color=white&b=grey"><br>
                    <table>
                    <tbody><tr>
                        <td style="vertical-align:top;">
                            <form action=""><input type="hidden" name="reloadToken" value="b160ddca1b308d359ab58c5526c072ac">
                                <input type="hidden" name="action" value="internalClan">
                                <input type="text" id="clanSearchAjax" name="clanSearchAjax" onkeyup="sendSearch();" class="clan-search fliess10px-weiss"><br>
                                <div id="showUserSearch" class="fliess10px-black"></div>
                            </form>
                        </td>
                        <td>
                            <div style="margin-left:50px;" class="link_see"><a href="javascript:void(0);" onclick="popup(480, 352, 'Clanlist', 'indexInternal.es?action=internalClanList&amp;tpl=internalClanList&amp;m=1&amp;dosid=05e487dd0b21a4600d0d6ed6d228f6df')">List of clans</a></div>
                        </td>

                    </tr>
                    </tbody></table>
                </div>
                <!-- Clan Suche -->
            </div>

        </div>
        <!-- Ende Content -->
        <br class="clearMe">
    </div>
<?php 
if(isset($_GET['subAction']) && $_GET['subAction']=="showClanInfo"):
    echo "<script>showLayer('showClanInfo');</script>";
endif;
?>

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