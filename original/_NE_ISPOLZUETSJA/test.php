<?php

$MySQLi->query('UPDATE server_1_players SET tokenId = ' . $sessionId . ' WHERE playerID = ' . $Users->DataRow['playerID']);
$mapid = $unity->getMapID($Users->DataRow['playerID']);
$res = $unity->getResolution($Users->DataRow['playerID']);
if ($res == 0){
$width = 820;
$height = 600;
} else if ($res == 1){
$width = 1024;
$height = 576;
}else if ($res == 2){
$width = 1366;
$height = 768;
}else if ($res == 3){
$width = 1920;
$height = 1080;
}else if ($res == 4){
$width = 1366;
$height = 768;
}else{
$width = 820;
$height = 600;
$res = 0;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
            <title><?php echo DynHost; ?> | Private Server</title>

<link href="css/globalForms.css" media="screen" rel="stylesheet" type="text/css">
<script src="js/ga.js" async="" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
    //<!--
$_jq=jQuery.noConflict(true);
    //-->
</script>

        <meta name="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">

        <link rel="SHORTCUT ICON" href="./favicon.ico" type="image/x-icon">

    <style type="text/css" media="screen">    @import "css/darkorbit.css"; </style>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="js/function.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.4.4.js"></script>
<script type="text/javascript" src="js/jquery.flashembed.js"></script>

<script type="text/javascript" charset="UTF-8">
/* <![CDATA[ */
try { if (undefined == xajax.config) xajax.config = {}; } catch (e) { xajax = {}; xajax.config = {}; };
xajax.config.requestURI = "/xajaxAPI.php?sid=";
xajax.config.statusMessages = false;
xajax.config.waitCursor = true;
xajax.config.version = "xajax 0.5";
xajax.config.legacy = false;
xajax.config.defaultMode = "asynchronous";
xajax.config.defaultMethod = "POST";
/* ]]> */
</script>
<script type="text/javascript" src="js/xajax_core.js" charset="UTF-8"></script>
<script type="text/javascript" charset="UTF-8">
/* <![CDATA[ */
window.setTimeout(
 function() {
  var scriptExists = false;
  try { if (xajax.isLoaded) scriptExists = true; }
  catch (e) {}
  if (!scriptExists) {
   alert("Error: the xajax Javascript component could not be included. Perhaps the URL is incorrect?\nURL: js/xajax_core.js");
  }
 }, 2000);
/* ]]> */
</script>
<script type='text/javascript' charset='UTF-8'>
/* <![CDATA[ */
xajax_showQuestDetails = function() { return xajax.request( { xjxfun: 'showQuestDetails' }, { parameters: arguments } ); };
xajax_acceptQuest = function() { return xajax.request( { xjxfun: 'acceptQuest' }, { parameters: arguments } ); };
xajax_abortQuest = function() { return xajax.request( { xjxfun: 'abortQuest' }, { parameters: arguments } ); };
xajax_disableTradeLayer = function() { return xajax.request( { xjxfun: 'disableTradeLayer' }, { parameters: arguments } ); };
xajax_saveTempResolution = function() { return xajax.request( { xjxfun: 'saveTempResolution' }, { parameters: arguments } ); };
xajax_clientResolutionChanged = function() { return xajax.request( { xjxfun: 'clientResolutionChanged' }, { parameters: arguments } ); };
xajax_saveOldClientUsage = function() { return xajax.request( { xjxfun: 'saveOldClientUsage' }, { parameters: arguments } ); };
xajax_buySkylabRobot = function() { return xajax.request( { xjxfun: 'buySkylabRobot' }, { parameters: arguments } ); };
xajax_skillTreePurchaseSkillReset = function() { return xajax.request( { xjxfun: 'skillTreePurchaseSkillReset' }, { parameters: arguments } ); };
xajax_skillTreePurchaseLevelUp = function() { return xajax.request( { xjxfun: 'skillTreePurchaseLevelUp' }, { parameters: arguments } ); };
xajax_nanoTechFactoryShowBuff = function() { return xajax.request( { xjxfun: 'nanoTechFactoryShowBuff' }, { parameters: arguments } ); };
xajax_pilotSheet = function() { return xajax.request( { xjxfun: 'pilotSheet' }, { parameters: arguments } ); };
xajax_pilotInvite = function() { return xajax.request( { xjxfun: 'pilotInvite' }, { parameters: arguments } ); };
xajax_pilotInviteIncentives = function() { return xajax.request( { xjxfun: 'pilotInviteIncentives' }, { parameters: arguments } ); };
xajax_tooltipAjaxHandler = function() { return xajax.request( { xjxfun: 'tooltipAjaxHandler' }, { parameters: arguments } ); };
/* ]]> */
</script>



</head>

    <body>
    <div id="container" style="width: {px"></div>

        <iframe src="indexInternal.es?action=internalMapRevolution&dontShow=1" name="reloader" width="0" height="0" scrolling="no" marginheight="0" marginwidth="0" frameborder="0"></iframe>





<script type='text/javascript'>
function onFailFlashembed() {
    var inner_html = '<div class="flashFailHead">Instala el Adobe Flash Player</div>\n\
    <div class="flashFailHeadText">Para jugar a DarkOrbit, necesitas el Flash Player m�s actual. �Solo tienes que instalarlo y empezar a jugar!\n\
    <div class="flashFailHeadLink" style="cursor: pointer">Desc�rgate aqu� el Flash Player gratis: <a href=\"http://www.adobe.com/go/getflashplayer\" style=\"text-decoration: underline; color:#A0A0A0;\">Descargar Flash Player<\/a> </div></div>';

    document.getElementById('container').innerHTML = inner_html;
}

function expressInstallCallback(info) {
        // possible values for info: loadTimeOut|Cancelled|Failed
        onFailFlashembed();
}

jQuery(document).ready(
    function(){
        
        
        flashembed("container", {"onFail": onFailFlashembed, "src": "spacemap/preloader.swf?__cv=49d8935f62d512ea6a52f2b2fd34c900","version": [11,0],"expressInstall": "swf_global/expressInstall.swf?__cv=93c5ee756f6d00a09159ecadd5e61c00","width": "100%","height": "100%","wmode": "direct","bgcolor": "#000000","id": "preloader","allowfullscreen": "true","allowFullScreenInteractive": "true"}, {"lang": "ru","userID": "97874751","sessionID": "d7fea54998644c1c2f08883c9778921f","basePath": "spacemap","pid": "679","boardLink": "%2FGameAPI.php%3Faction%3Dportal.redirectToBoard","helpLink": "http%3A%2F%2Fen.bigpoint.com%2Fdarkorbit%2Fboard%2Fcategories%2Fpomosch.492%2F","loadingClaim": "%D0%97%D0%90%D0%93%D0%A0%D0%A3%D0%97%D0%9A%D0%90","chatHost": "globalchat-eu-pub-01.bigpoint.net","cdn": "","useHash": "1","host": "test2.darkorbit.bigpoint.com","browser": "Chrome","fullscreen": "1","gameXmlHash": "4b9e0db06a833f6dd565c3b99e5a8000","resourcesXmlHash": "a2a56a199166ede8a26579cf41442700","profileXmlHash": "e6c5f6627f9a7b9bb7bf5471e08a1500","languageXmlHash": "f4adc9fa0f6008d5c51170a53765ab00","loadingscreenHash": "919f82e31bca10840f09fcaca92e5900","gameclientHash": "4c298a0a2a33d071a5bcddba9c186f00","gameclientPath": "spacemap","loadingscreenAssetsXmlHash": "1c540d399333ca7cc1755735a6082100","showAdvertisingHint": "","gameclientAllowedInitDelay": "10","eventStreamContext": "eyJwaWQiOjY3OSwidWlkIjo5Nzg3NDc1MSwidGlkIjoiZjVmYTgwZDRmOTM4MTM1MzkyZTY1OTUwMzM1Mzg5MDQiLCJpaWQiOiJiNWFhM2UzYzRmZjgwYzNkYTAxMWY3NDE0NTFiMGQzZiIsInNpZCI6ImQ3ZmVhNTQ5OTg2NDRjMWMyZjA4ODgzYzk3Nzg5MjFmIiwiY3RpbWUiOjE0MjM1MDI2ODA0MDh9","useDeviceFonts": "0","autoStartEnabled": "1","mapID": "71","allowChat": "1"});

	    
    }
);
</script>

<style>
    #container {
        color: #FFFFFF;
        background : #000000;
	}
</style>

</body>
</html>