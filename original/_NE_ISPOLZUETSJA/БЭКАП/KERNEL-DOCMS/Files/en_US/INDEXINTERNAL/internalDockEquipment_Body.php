<body class="internalDockEquipment_equipment" onLoad="" >
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
        <img src="/do_img/global/popups/general/success_icon.png" id="general_popup_success" class="success" />
        <img src="/do_img/global/popups/general/error_icon.png" id="general_popup_error" class="error" />
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

<style type="text/css" media="screen">    @import "/css/cdn/includeInfoLayer.css";</style>
<script type="text/javascript">
infoText = '';
icon = '';
</script>
<script type="text/javascript" src="/js/infoLayer.js"></script>

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
                

<script type="text/javascript" src="/resources/js/dock.js"></script>
<script language="JavaScript">
// Parameters for Tools.Popup
Tools.Popup.Parameters = {"showOnLoad":false,"type":"success","content":""};
// Initialize Tools.Popup
Tools.Popup.Initialize();
// Initialize dock
Dock.Initialize();

if (window.addEventListener)
    /** DOMMouseScroll is for mozilla. */
    window.addEventListener('DOMMouseScroll', handleWheelEvent, false);
/** IE/Opera. */
window.onmousewheel = document.onmousewheel = handleWheelEvent;

function handleWheelEvent(e){
    e.preventDefault();
}
</script>


<div id="dock_content">
    <style type="text/css" media="screen">    @import "/css/cdn/includeNavigation.css";</style>
<style  type="text/css">

.tabLabelOverviewActive {
    background-image: url(text?t=OVERVIEW&w=8&s=9&color=black&b=lightestBlue);
}
.tabLabelOverviewInActive {
    background-image: url(text?t=OVERVIEW&w=8&s=9&color=white&b=grey);
}
.tabLabelEquipmentActive {
    background-image: url(text?t=EQUIPMENT&w=8&s=9&color=black&b=lightestBlue);
}
.tabLabelEquipmentInActive {
    background-image: url(text?t=EQUIPMENT&w=8&s=9&color=white&b=grey);
}
.tabLabelShopActive {
    background-image: url(http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=10&t=nav_sub1_hangar_shop&f=eurostyle_thea&color=black&bgcolor=grey1);
}
.tabLabelShopInActive {
    background-image: url(http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=9&t=nav_sub1_hangar_shop&f=eurostyle_thea&color=white&bgcolor=grey);
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
    setActiveTab('internalDockEquipment');
</script>

    <style type="text/css" media="screen">    @import "/css/cdn/includeHangarSlots.css";</style>
<script type="text/javascript" src="/js/hangarSlots.js"></script>

<?php 

?>
<form id="hangarView" name="hangarView" action="indexInternal.es?action=internalDock&tpl=internalDockEquipment" method="post"><input type="hidden" name="reloadToken" value="ba25bbabf3dd75d673963d5203cd1eaa">
<input type="hidden" name="subAction" value="changeHangar">
<input type="hidden" id="hangarId" name="hangarId" value="196834">
<div id="hangarSlotsDisable"></div>
<div id="hangarSlotsContainer">
    <div id="hangarSlots">
                                    <div showHangarInfo="pCk" id="slot_0" class="hangarSlot slotEquipped
                     active
                                        " onclick="
                    switchHangarView(
                        3,
                        0,
                        'active',
                        false,
                        'internalDockEquipment'
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
<form id="renameHangarForm" name="renameHangarForm" action="indexInternal.es?action=renameHangar" method="post" target="uploadTarget"><input type="hidden" name="reloadToken" value="ba25bbabf3dd75d673963d5203cd1eaa">
                        <div id="renameHangarContainer"><link rel="stylesheet" type="text/css" href="/resources/css/popup.css" />
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
                 style="background-image: url(http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=12&t=hangar_renamimg_accept_caps&f=eurostyle_thea&color=white&bgcolor=grey);"
                 onclick="renameHangar();"></div>
        </div>
    </div>
</div>
<div id="renameHangarPopupBackground"></div>
<img id="renameHangarLoading" alt="Loading..." src="/do_img/global/pilotSheet/profilePage/loadingAnimation.gif" />
</div>
    <input type="hidden" id="hangar_Id" name="hangar_Id" value="180825">
</form>
<iframe id="uploadTarget" name="uploadTarget" src="" style="width:0;height:0;border:0px solid #fff;"></iframe>


    <div id="dock_container">
        <div id="equipment_container"></div>
    </div>
</div>



<script type='text/javascript'>

function onFailFlashembed() {
    var html = '';

    html += '<div id="flashFail">';

    html += '<div class="flashFailHead">Get the Adobe Flash Player</div>';

    html += '<div class="flashFailHeadText">';
    html += 'In order to play DarkOrbit, you need the latest version of Flash Player. Just install it to start playing!';
    html += '<div class="flashFailHeadLink">';
    html += 'Download the Flash Player here for free: <a href=\"http://www.adobe.com/go/getflashplayer\" style=\"text-decoration: underline; color:#A0A0A0;\">Download Flash Player<\/a>';
    html += '</div>';
    html += '</div>';

    html += '</div>';

    jQuery('#equipment_container').html(html);
}

function expressInstallCallback(info) {
        // possible values for info: loadTimeOut|Cancelled|Failed
        onFailFlashembed();
}
jQuery(document).ready(
    function(){
        
	    flashembed("equipment_container", {"onFail": onFailFlashembed, "src": "http://<?php echo DynHost; ?>/swf_global/inventory/inventory.swf","version": [10,0],"expressInstall": "http://<?php echo DynHost; ?>/swf_global/expressInstall.swf","onFail": function(){ onFailFlashembed(); },"width": 770,"height": 395,"id": "inventory","wmode": "transparent"}, {"cdn": "http://<?php echo DynHost; ?>/","nosid": "1","navPoint": "2","eventItemEnabled": "1","supporturl": "indexInternal.es%3Faction%3Dsupport%26back%3DinternalStart","serverdesc": "Global","server_code": "1","jackpot": "00.00 EUR","uridium_highlighted": "","lang": "en","sid": "0791427cd7224aaa217402182f9175fc","locale_hash": "","dynamicHost": "<?php echo DynHost; ?>","menu_layout_config_hash": "dcabf46f2c5aa8e6ffb5d36419de8000","assets_config_hash": "4bce8f878f899afc6b1d2fac52737d00","items_config_hash": "3c49115df8de86947e0bc643852e6600","useDeviceFonts": "0"});
	
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
    <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="http://127.0.0.1/do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt="" /></a></div>
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

    
    <div id="banner-bottom" align="center">
    <!-- affiliateBanner: banner enabled --><script type="text/javascript" src="http://adin-www.bigpoint.net/adxx.php?pid=4&source=country%3DES%26areaID%3Dinternal.trade%26aid%3D0%26acm%3D%26acr%3D47%26aip%3D%26gameID%3D47%26uid%3D98173484%26locale%3Dus&sign=VjGnoI9RBoneX0QLRSbyu%2F21VkmF3sy0cAwW2kIe"></script>    </div>
</div><!-- End footerContainer -->
</div><!-- End bodyContainer -->
</div><!-- End outerContainer -->
</div><!-- End overallContainer -->
</div>




<!-- affiliateEndTag -->
<!-- SensorT-Bigpoint - Page View - START -->
<script type="text/javascript" language="JavaScript" src="https://akimu.bigpoint.com/trk?rt=1&ti=3547&cs=8377&aid=0&aip=&pid=47&ppid=22&language=en&country=ES&ctype=0&ts=1368367270&mid=261695600&jsopenclose=false"></script>
<!-- SensorT-Bigpoint - Page View - END -->

<!-- SensorT-Bigpoint - SEA-SEO Pageview - START -->
<script type="text/javascript">
(function() {
var s = null, sp = null, se = null, st = null, r = document.referrer, res = null; 
if (!r) return;
if (r.indexOf("google") >= 0) {
se = "google"; sp = "q";
} else if (r.indexOf("bing") >= 0) {
se = "bing"; sp = "q";
} else if (r.indexOf("yahoo") >= 0) {
se = "yahoo"; sp = "p";
} else {
return;
}
var idx = r.indexOf("?") + 1;
if (idx > 0) {
var p = r.substr(idx).split("&");
for (var i = 0; i < p.length; i++) {
var kv = p[i].split("=");
if (kv[0] == sp) {
s = kv[1];
} else if (se == "google" && kv[0] == "url") {
st = "seo";
} else if (se == "google" && kv[0] == "adurl") {
st = "sea";
}
if (s && st) {
break;
}
}
}
if (s) {
res = '<scr' + 'ipt type="text/javascript" src="http://akimu.bigpoint.com/trk?rt=1&ti=3549&cs=5764&aid=0&aip=&pid=47&ppid=22&language=en&country=ES&ctype=0&ts=1368367270&searchQuery=' + s;
}
if (res && st) {
res = res + "&searchType=" + st;
}
if (res) {
res = res + "&ts=" + new Date().getTime() + '"></scr' + "ipt>";
document.write(res);
if (st && st == "seo" && 1) {
document.write('<scr' + 'ipt type="text/javascript" src="http://akimu.bigpoint.com/ads?rt=2&et=35&se=m&bi=[bookedInsertionId]&cs=[cs]&ev=' + s + '&ts=' + new Date().getTime() + '"></scr' + 'ipt>');
}
}
})();
</script>
<!-- SensorT-Bigpoint - SEA-SEO Pageview - END --><!-- BPID --><script language="javascript">window.bpid=window.bpid||{};window.bpid.callbacks=window.bpid.callbacks||[];window.bpid.callbacks.push(function(bpid) {document.cookie="__bpid="+bpid+";path=/;expires=Fri, 03 Jun 2022 13:59:24 GMT;";if (bpid != "51812404dl5KklKxnen7GpIbbQNwIqOB") {try {var xhr = new XMLHttpRequest();xhr.open("GET", "\/GameAPI.php?action=core.bpid&bpid="+bpid, true);xhr.send(null);} catch(e) {}}});</script><script language="javascript" src="//assets.bpsecure.com/bpid/bpid.js?ts=380102" defer="defer"></script><!-- /BPID --><script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_gat._anonymizeIp']);_gaq.push(['_setDomainName', 'none']);_gaq.push(['_setAllowLinker', true]);_gaq.push(['_setAllowHash', false]);_gaq.push(['_setCustomVar', 1, 'aid', '0', 2]);_gaq.push(['_setCustomVar', 2, 'aip', '', 2]);_gaq.push(['_setCustomVar', 3, 'ait', '', 2]);_gaq.push(['_setCustomVar', 4, 'areaID', 'internal.trade', 2]);_gaq.push(['_setAccount', 'UA-1848713-1']);_gaq.push(['_trackPageview', '/indexInternal.es?action=internalDock&tpl=internalDockEquipment&areaID=internal.trade']);_gaq.push(['_trackPageLoadTime']);_gaq.push(['_setAccount', 'UA-17685913-1']);_gaq.push(['_trackPageview', '/indexInternal.es?action=internalDock&tpl=internalDockEquipment&areaID=internal.trade']);_gaq.push(['_trackPageLoadTime']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = 'http://www.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>

<!-- SZM VERSION="1.5" -->
<script type="text/javascript">
<!--
var IVW="http://bigpoint.ivwbox.de/cgi-bin/ivw/CP/5201gamecont;/spiele/darkorbit";
document.write("<img src=\""+IVW+"?r="+escape(document.referrer)+"&d="+(Math.random()*100000)+"\"width=\"1\" height=\"1\" alt=\"\" />");
//-->
</script>
<noscript>
<img src="http://bigpoint.ivwbox.de/cgi-bin/ivw/CP/5201gamecont;/spiele/darkorbit";
width="1" height="1" alt="" />
</noscript>
<!-- /SZM -->




<script type="text/javascript">
    
    if (jQuery('#toolbar').length > 0) {
        jQuery('#toolbar').css('float', 'none');
        jQuery('body').css('background-position', 'center 30px');
    }
    
</script>
<link rel="stylesheet" type="text/css" href="http://127.0.0.1/resources/css/popup.css?__cv=4e58da2dec4df33ee5f4c239848dda00" />
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
<img id="popup-loading" alt="Loading..." src="http://127.0.0.1/do_img/global/pilotSheet/profilePage/loadingAnimation.gif" />

<!-- LayertoolService JavaScript Injection start -->
<script type="text/javascript">
    //<![CDATA[
    // add fancybox css to the head
    var cssLink  = document.createElement('link');
    cssLink.type = 'text/css';
    cssLink.rel  = 'stylesheet';
    cssLink.href = 'http://lts-920.ah.bpcdn.net/application/fancybox/jquery.fancybox-1.3.4.css';
    document.getElementsByTagName('head')[0].appendChild(cssLink);
    //]]>
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="http://lts-920.ah.bpcdn.net/application/fancybox/jquery.fancybox-1.3.4.js"></script>
<script type="text/javascript" src="http://lts-920.ah.bpcdn.net/application/client/client.js"></script>
<script type="text/javascript" src="http://lts-920.ah.bpcdn.net/application/cookie/jquery.cookie.js"></script>
<script type="text/javascript">var jQueryLts = jQuery.noConflict(true);</script>
<script type="text/javascript">
    //<![CDATA[
    jQueryLts('document').ready(function() {
        try {
            var serviceLinks = ['http://lts-920.ah.bpcdn.net/47/us/ES/-14400/0','http://lts-920.ah.bpcdn.net/email/47/us'];
            var paymentURL   = 'https://ssl.bigpoint.net/billing/?req=YToxMzp7czo2OiJ1c2VySUQiO3M6ODoiOTgxNzM0ODQiO3M6ODoidXNlcm5hbWUiO3M6MTE6InhkcnNlcmVzdHNyIjtzOjg6Im1lbWJlcklEIjtzOjk6IjI2MTY5NTYwMCI7czo0OiJicGlkIjtzOjMyOiI1MTgxMjQwNGRsNUtrbEt4bmVuN0dwSWJiUU53SXFPQiI7czo3OiJ1c2VyQWdlIjtpOjE2O3M6MTQ6ImZiX2FwcGxpY2F0aW9uIjtiOjA7czo5OiJmYl91c2VySWQiO3M6MTU6IjEwMDAwNDg4NzY2MjUzMiI7czo5OiJwcm9qZWN0SUQiO3M6MjoiNDciO3M6MzoiYWlkIjtpOjA7czozOiJhaXAiO3M6MDoiIjtzOjQ6ImxhbmciO3M6MjoiZW4iO3M6MzoiZGV2IjtiOjA7czo0OiJ0aW1lIjtpOjEzNjgzNjcyNjk7fQ%3D%3D&aid=0&aip=&hash=fa14c21f64316279b5a2a5f3488c97c7';
            BPLayertool2.Helper.setPaymentLink(paymentURL);
            BPLayertool2.Helper.setUserId(98173484);
            BPLayertool2.Helper.setRequestTime(1368367269);
            BPLayertool2.Helper.setServices(serviceLinks);
            BPLayertool2.JSONPRequest.setRequestURL(serviceLinks[0]);
            BPLayertool2.JSONPRequest.doRequest(BPLayertool2.LayerView.prepareView);
        } catch (Exception) {
            if (true === Boolean(console.log)) {
                console.log(Exception);
            } else {
                throw Exception;
            };
        }
    });
    //]]>
</script>
<!-- LayertoolService JavaScript Injection end -->


</body>
</html>