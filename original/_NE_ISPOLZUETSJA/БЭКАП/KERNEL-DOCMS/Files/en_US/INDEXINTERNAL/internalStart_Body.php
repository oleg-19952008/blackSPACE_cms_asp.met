<body onLoad="" >
    <!-- affiliateStartTag -->
    <link href="http://fonts.googleapis.com/css?family=Ubuntu+Condensed&amp;subset=latin,greek,cyrillic" rel="stylesheet" type="text/css">
    <?php
    $rank = $base->GetRank($Users->DataRow['ID'], $Users->DataRow['playerID']);
    $clan->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
    $clanid = $clan->getMyClan($Users->DataRow['playerID']);
    $top10 = $rnk->getAllRankingPlayers(9);
    $mRy = $rnk->getMyRanking($Users->DataRow['playerID']);
    $myRanking = $mRy[0];
	// news
	$newsC = new news();
	$newsC->init();
    ?>
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
<?php 
if(MHH==TRUE){
$mhti = $auc->nextCloseTimeHOUR();
?>

<div id="bonus_hh" style="left: 471.5px; display: block;">
    <div id="bonus_hh_head"></div>
    <div id="bonus_hh_close"></div>
    <div id="bonus_hh_teaser"></div>
    <div id="bonus_hh_context" class="text_bonus_hh">
        <strong>It's time for action!</strong><br><br>
        The countdown's begun! For the next full hour, we're rolling out the big guns:<br><br>
        <span class="breakingNewsHighlightBlue"><ul style="margin-left: 20px;">
    <li style="list-style-type:disc">Three for the price of one</li>
    <li style="list-style-type:disc">90,000 Uridium now for the price of 30,000</li>
    <li style="list-style-type:disc">Valid for all payment methods except for bank transfers and paysafecard
    </li></ul></span><br><br>
        <strong>Reel in triple the Uridium now!</strong>
            </div>
    <div id="bonus_hh_counter"></div>
</div>

<script language="javascript">    
showBusyLayer();
var _m = <?php echo $mhti['min']; ?>;
var _s = <?php echo $mhti['sec']; ?>;

var end = false;
function counterTimer()
{
    if (end == false) {_s--; }
    if (_s<0) { _s=59; _m--; }
    if (_m<0) { _m=59; }
    if (_s == 0 && _m == 0) {
        end = true;
    }
    var __s = ""+_s; if (__s.length == 1) __s = '0'+__s;
    var __m = ""+_m; if (__m.length == 1) __m = '0'+__m;
    try {
        var counter = document.getElementById('bonus_hh_counter');
        if (counter) {
            document.getElementById('bonus_hh_counter').innerHTML = __m + ':' + __s;
        }
    } catch (e) {
    }
}
window.setInterval('counterTimer();', 1000);

</script>

<style type="text/css">

#bonus_hh {
    display: none;
    position:absolute;
    left:0px;
    top:38px;
    width: 480px;
    height: 500px;
    background-image: url(./do_img/global/layer/bonus/bg.png?__cv=b0f20fca0a2d091367f3cb91102dfd00);
    z-index:1000;
    cursor: pointer;
}
#bonus_hh_head {
    font-family: verdana;
    position: absolute;
    top: 17px;
    left: 32px;
    width: 417px;
    height: 105px;
    background-image: url(./do_img/global/layer/bonus/head_mhh.png?__cv=164b86c9e20f61540e07f89a311a4e00);
}
#bonus_hh_close {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 24px;
    height: 24px;
    background-image: url(./do_img/global/layer/close_button_sprite.png?__cv=fa1f7ef0f89ab04212dbf02f3424d700);
    cursor: pointer;
}
#bonus_hh_close:hover {
    background-position: 0px -24px;
}
#bonus_hh_close:active {
    background-position: 0px -48px;
}
#bonus_hh_teaser {
    position: absolute;
    width: 167px;
    height: 30px;
    top: 155px;
    left: 155px;
    background-image: url(./do_img/global/layer/bonus/teaser_mhh.png?__cv=2d867aa1ed84d8c0871036c472498200);
}
#bonus_hh_context {
    position: absolute;
    top: 200px;
    left: 70px;
    text-align: left;
    width: 350px;
}

#bonus_hh_counter {
    position: absolute;
    top: 434px;
    left:187px;
    width: 104px;
    height: 20px;
    color: #fffdfe;
    font-size: 18px;
    font-weight: bold;
    line-height: 20px;
}

.text_bonus_hh {
    color: #fffdfe;
    font-size: 11px;
}
#bonus_hh_advertisingHint {
	position: absolute;
    top: 225px;
    left: 295px;
    color: #547b88;
    font-family: Verdana;
    font-size: 7pt;
}

</style>

<script type="text/javascript">
 
    var globalPaymentUrl = '/indexInternal.es.php?action=internalPaymentProxy';
    
    var useClose = false;
    jQuery(document).ready(function(){
        jQuery('#bonus_hh_close').click(function() {
            useClose = true;
            jQuery('#bonus_hh').hide();
            hideBusyLayer();
        });
        jQuery('#bonus_hh').click(function() {
            if (useClose == false) {
                openExternal(globalPaymentUrl);
                useClose = true;
                jQuery('#bonus_hh').hide();
                hideBusyLayer();
            }
        });

        jQuery('#bonus_hh').css('left', jQuery(window).width() / 2 - jQuery('#bonus_hh').width() / 2 + "px");
        jQuery('#bonus_hh').show();
    });

    

</script>
<?php
}
?>
    <!-- seitenabdecker -->

    <style type="text/css" media="screen">    @import "./css/cdn/includeInfoLayer.css?__cv=6f32d2604f47c348e721414f1418ee00";</style>
	
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
<?php
	// Daily-Login-Box
	// Avoid an error (Level: Notice)
	if(!isset($_GET['acceptDailyLoginBonus']))
		$_GET['acceptDailyLoginBonus'] = 0;

	// init class
	$dailyBonus = new dailybonus();
	// set id
	$dailyBonus->setId($Users->DataRow['ID']);
	// give the bonus
	$dailyBonus->executeb();
	// get html-data
	$dailyBonusd = $dailyBonus->getData();

	// Layer or not?
	if($_GET['acceptDailyLoginBonus'] != 1 && $dailyBonus->getState() == "yes"){
?>
	<style type="text/css" media="screen">    @import "./css/cdn/layer_dailyLogin.css</style>
	<div id="dailyLogin" style="top: 35px; left: 359.5px;">
		<div id="dl_headline"><strong>Daily-Login-Bonus</strong></div>
		<div id="dl_infoBox">
			<div id="dl_infoBox_headline"><strong>Welcome back pilot!</strong></div>
			<div id="dl_infoBox_content"><?php echo $dailyBonusd['headline']; ?></div>
		</div>
		<div id="dl_boni">
			<div id="dl_progressbar_bonus_<?php echo $dailyBonusd['progressbar']; ?>"></div>
			<div id="dl_boniBox" onclick="do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockAmmo&amp;hdl=1', false)">
				<div class="dl_boniState_<?php echo $dailyBonusd['boxstate_1'] ?>">
					<div class="dl_boni_1">
						<div class="dl_boni_headline">Bonus 1</div>
						<?php echo $dailyBonusd['boxstate_1_icon']; ?>
						<div class="dl_boni_content dl_boni_content_1">50,000 credits<br>100x PLT-2026 rockets<br>5x GG-spin</div>
					</div>
				</div>
			</div>
            <div id="dl_boniBox" onclick="do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockAmmo&amp;hdl=1', false)">
				<div class="dl_boniState_<?php echo $dailyBonusd['boxstate_2'] ?>">
					<div class="dl_boni_2">
						<div class="dl_boni_headline">Bonus 2</div>
						<?php echo $dailyBonusd['boxstate_2_icon']; ?>
						<div class="dl_boni_content dl_boni_content_2">750x MCB-25 ammo<br>85,000 credits<br>5x GG-spin</div>
					</div>
				</div>
			</div>
			<div id="dl_boniBox" onclick="do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockSpecials&amp;hdl=1', false)">
				<div class="dl_boniState_<?php echo $dailyBonusd['boxstate_3'] ?>">
					<div class="dl_boni_3">
						<div class="dl_boni_headline">Bonus 3</div>
						<?php echo $dailyBonusd['boxstate_3_icon']; ?>
						<div class="dl_boni_content dl_boni_content_3">150x PLT-2021 rockets<br>3x Jump-voucher<br>5x GG-spin</div>
					</div>
				</div>
			</div>
			<div id="dl_boniBox" onclick="do_redirect('indexInternal.es?action=internalDock&amp;tpl=internalDockAmmo&amp;hdl=1', false)">
				<div class="dl_boniState_<?php echo $dailyBonusd['boxstate_4'] ?>">
					<div class="dl_boni_5">
						<div class="dl_boni_headline">Bonus 4</div>
						<?php echo $dailyBonusd['boxstate_4_icon']; ?>
						<div class="dl_boni_content dl_boni_content_4">5x Logfile<br>250 Uridium<br>5x GG-spin</div>
					</div>
				</div>
			</div>
			<div id="dl_boniBox" onclick="do_redirect('indexInternal.es?action=internalPilotSheet&amp;tpl=skilltree&amp;hdl=1', false)">
				<div class="dl_boniState_<?php echo $dailyBonusd['boxstate_5'] ?>">
					<div class="dl_boni_4">
						<div class="dl_boni_headline">Bonus 5</div>
						<?php echo $dailyBonusd['boxstate_5_icon']; ?>
						<div class="dl_boni_content dl_boni_content_5">1000x MCB-50 ammo<br>3x Repair-voucher<br>5x WIZ-X rockets</div>
					</div>
				</div>
			</div>
			<div id="dl_accept">
				<div id="dl_bt_accept"><a href="/indexInternal.es?action=internalStart&amp;acceptDailyLoginBonus=1">OK</a></div>
			</div>
		</div>
	</div>

<?php
	}
	// End of Daily-Login-Box
 ?>

    <script type="text/javascript">
    </script>

    <?php require GLOBALS . 'internalHelpLayer.php';
    require GLOBALS . 'internalNews.php'; ?>


    <div class="backgroundImageContainer">
        <div class="overallContainer">

            <div class="outerContainer fliess11px-gelb">

<?php require GLOBALS . 'internalHeaderIntern.php'; ?>



                <div class="bodyContainer">
                    <script type="text/javascript" language="javascript" src="/js/internalStart.js"></script>
                    <script type="text/javascript" src="/js/page/clan/internalNewClanIndexDomReady.js"></script>
                    <script type="text/javascript">
        // server time setup
        var serverTime = '<?php echo date('h:i'); ?>';
        var serverDate = '<?php echo date('d-m-Y'); ?>';
        var meridiem_am = 'A.M.';
        var meridiem_pm = 'P.M.';

        var tmp = serverTime.split(':');
        var tmp2 = tmp[1].split(' ');

        var hour = tmp[0];
        var minute = tmp2[0];
        var meridiem = tmp2[1];
                    </script>
                    <div id="mainContainer">
                        <div id="mainContainerContent">
                            <div id="homeUserContent">

                                <img src="/do_img/global/avatar.png" alt="<?php echo $Users->DataRow['Name']; ?>" id="pilotAvatar">

                                <div id="companyLogo" class="companyLogoSmall_<?php echo ($Users->DataRow['factionId'] === '1') ? 'mmo' : (($Users->DataRow['factionId'] === '2') ? 'eic' : 'vru'); ?>"></div>

                                <div class="infoContainerHeadline">PILOT LICENSE</div>
                                <div id="userInfoSheet">
                                    <div class="userInfoLine">
                                        <label>Username:</label> <?php echo $Users->DataRow['Name']; ?>
                                    </div>
                                    <div class="userInfoLine clan_name_qtip" title="<?php if ($clanid == 0): echo "---";
else: echo $clan->getClanName($clanid);
endif; ?>">
                                        <label>Clan:</label> <?php if ($clanid == 0): echo "---";
else: echo $clan->getClanName($clanid);
endif; ?>
                                    </div>
                                    <div class="userInfoLine">
                                        <label>Rank:</label>
                                        <img id="userRankIcon" src="./do_img/global/ranks/rank_<?php echo $rank['rank']; ?>.png?__cv=09c1cfe2db977e7eb54a4776a5831300">
<?php echo $rank['name']; ?>
                                    </div>
                                </div>
                                <div id="userContentLevel">
                                    <label>Level:</label> <?php echo $Users->DataRow['level']; ?>
                                </div>

                                <!--            <a id="userButtonLeft" class="userHomeButton" href="/p/6qaKx-Jj6nf/?lang=en" target="_blank">
                                                Pilot
                                            </a>-->
                                <a id="userButtonMiddle" class="userHomeButton" href="/indexInternal.es?action=internalHallofFame&amp;view=dailyRank">
                                    Ranking
                                </a>
                                <a id="userButtonRight" class="userHomeButton" href="/indexInternal.es?action=internalHistory">
                                    Logbook
                                </a>
                            </div>

                            <div id="homeRankingContent">
                                <div class="infoContainerHeadline">CORPORATE RECORDS</div>

                                <div id="rankingTabLeft" class="rankingTab homeTabActive">
                                    BEST PILOTS
                                </div>
                                <div id="rankingTabRight" class="rankingTab">
                                    BEST CLANS
                                </div>

                                <table class="homeRankingTable" id="ranking_Users" border="0" cellpadding="0" cellspacing="0">
                                    <tbody><tr class="rankingHeadline">
                                            <td>Name</td>
                                            <td>Company</td>
                                            <td>Rank</td>
                                            <td>Value</td>
                                        </tr>
<?php
$Odd = array(1, 3, 5, 7, 9);
foreach ($top10 as $k => $v) {
    if (in_array($k, $Odd)):
        ?>
                                                <tr class="rankingOdd">
                                                    <td showuser="1uQwW" title="<?php echo $v['Name'] ?> - click for details" style="cursor: pointer">
        <?php echo $v['Name'] ?>
                                                    </td>
                                                    <td>
                                                        <img src="./do_img/global/logos/logo_<?php echo ($v['factionId'] === '1') ? 'mmo' : (($v['factionId'] === '2') ? 'eic' : 'vru'); ?>_mini.png?__cv=e8c00bbe2bd8bf9c0480374ca09f8800" alt="vru" width="7" height="8">
                                                    </td>
                                                    <td title="<?php echo $k+1; ?>" style="cursor: pointer"><?php echo $k+1 ?></td>
                                                    <td><?php echo $v['rankpoints'] ?></td>
                                                </tr>
                                                        <?php
                                                    else:
                                                        ?>
                                                <tr class="non">
                                                    <td showuser="1uQwW" title="<?php echo $v['Name'] ?> - click for details" style="cursor: pointer">
        <?php echo $v['Name'] ?>
                                                    </td>
                                                    <td>
                                                        <img src="./do_img/global/logos/logo_<?php echo ($v['factionId'] === '1') ? 'mmo' : (($v['factionId'] === '2') ? 'eic' : 'vru'); ?>_mini.png?__cv=e8c00bbe2bd8bf9c0480374ca09f8800" alt="vru" width="7" height="8">
                                                    </td>
                                                    <td title="<?php echo $k+1; ?>" style="cursor: pointer"><?php echo $k+1; ?></td>
                                                    <td><?php echo $v['rankpoints'] ?></td>
                                                </tr>
                                                    <?php
                                                    endif;
                                                }
                                                ?>
                                        <tr class="none">
                                            <td showuser="6qaKx" title="<?php echo $Users->DataRow['Name']; ?> - click for details" style="cursor: pointer">
<?php echo $Users->DataRow['Name']; ?>
                                            </td>
                                            <td>
                                                <img src="./do_img/global/logos/logo_<?php echo ($myRanking['factionId'] === '1') ? 'mmo' : (($myRanking['factionId'] === '2') ? 'eic' : 'vru'); ?>_mini.png?__cv=e8c00bbe2bd8bf9c0480374ca09f8800" alt="vru" width="7" height="8">
                                            </td>
                                            <td title="<?php echo $myRanking['overallRank']; ?>" style="cursor: pointer"><?php echo $myRanking['overallRank']; ?></td>
                                            <td><?php echo $myRanking['rankpoints']; ?></td>
                                        </tr>
                                    </tbody></table>
                                <table class="homeRankingTable" id="ranking_Clans" border="0" cellpadding="0" cellspacing="0" style="display: none">
                                    <tbody><tr class="rankingHeadline">
                                            <td>Name</td>
                                            <td>Rank</td>
                                            <td>Value</td>
                                        </tr>
										<?php 
											$clanc = "SELECT * FROM server_1_clan ORDER BY rankpoints DESC LIMIT 10";
											$clanq = mysqli_query($MySQLi, $clanc); $r=1;
											while($clanr = mysqli_fetch_array($clanq)){
										?>
                                        <tr class="<?php if(is_int($r/2)){echo 'none';}else{echo 'rankingOdd';}?>">
                                            <td class="clan_name_qtip" title="<?=$clanr['clanName']?>">
                                                <a href="/indexInternal.es?action=internalNewClanDetails&amp;clanId=<?=$clanr['clanID']?>">
                                                    [<?=$clanr['tagName']?>]
                                                </a>
                                            </td>
                                            <td><?=$r?></td>
                                            <td><?=$clanr['rankpoints']?></td>
                                        </tr>
										<?php $r++;} ?>
                                    </tbody></table>
                                <a id="hallOfFame" class="userHomeButton" href="/indexInternal.es?action=internalHallofFame">
                                    Hall of Fame
                                </a>
                            </div>

                            <script type="text/javascript">
                                jQuery(".clan_name_qtip").qtip({
                                    style: 'dohdr',
                                    position: {target: 'mouse'}
                                })
                            </script>

                            <div id="homeNewsContent">
                                <script type="text/javascript" language="javascript">
                                    var newsItemIds = new Array();
									<?php echo $newsC->get("jsarray"); ?>

                                    var uploadedNewsIds = new Array();
                                    <?php echo $newsC->get("jsarray2"); ?>
                                </script>

                                <div id="breakingNewsHeadline">
                                    <span class="bnHead_<?php echo ($Users->DataRow['factionId'] === '1') ? 'mmo' : (($Users->DataRow['factionId'] === '2') ? 'eic' : 'vru'); ?>"><?php echo ($Users->DataRow['factionId'] === '1') ? 'MMO' : (($Users->DataRow['factionId'] === '2') ? 'EIC' : 'VRU'); ?></span> NEWSLETTER
                                </div>


                                <div id="breakingNewsTop">
                                    <div class="empty"></div>
                                    <div id="newsImageOverlay" style="display: block;"></div> 
									<?php echo $newsC->get("images"); ?>
                                </div>

                                <div id="breakingNewsLeftArrow" class="breakingNewsArrow"></div>
                                <div id="breakingNewsRightArrow" class="breakingNewsArrow"></div>
                                <div id="breakingNewsIconWrapper">
									<?php echo $newsC->get("icons"); ?>
									<div id="newsIconHighlight" style="left: 54px;"></div>
                                </div>


                                <div id="breakingNewsTopGradiant"></div>
                                <div id="breakingNewsBottomGradiant"></div>
                                <div id="breakingNewsText" class="js-scroll-pane" tabindex="0" style="overflow: auto; padding: 0px; width: 320px; height: 229px;">
                                   <?php echo $newsC->get("news"); ?>
                                </div>                              
                                        
							</div>
                        </div>
                    </div>
                        <div id="sidebarHome">
                            <div id="serverTimeContainer">
                                <span id="serverTime">04:45</span>
                                <span id="meridiem">P.M.</span>
                            </div>

                            <div id="sidebarLights" class="sidebarNoEvent">
                            </div>

                            <div id="sidebarStatus">
                                UPCOMING
                            </div>

                            <div id="sidebarEvent">

                                <div id="eventDisplay_upcoming" class="eventDisplay">
                                    <div class="upcomingEvent">
                                        <div class="eventDate">28/07</div>
                                        <div class="eventTitle">Spaceball</div>
                                        <div class="eventTime">
                                            07:00 pm -
                                            10:00 pm
                                        </div>
                                    </div>
                                    <div class="upcomingEvent">
                                        <div class="eventDate">29/07</div>
                                        <div class="eventTitle">SECTOR CONTROL</div>
                                        <div class="eventTime">
                                            07:00 pm -
                                            10:00 pm
                                        </div>
                                    </div>
                                    <div class="upcomingEvent">
                                        <div class="eventDate">30/07</div>
                                        <div class="eventTitle">Invasion</div>
                                        <div class="eventTime">
                                            07:00 pm -
                                            10:00 pm
                                        </div>
                                    </div>
                                    <div class="upcomingEvent">
                                        <div class="eventDate">01/08</div>
                                        <div class="eventTitle">Spaceball</div>
                                        <div class="eventTime">
                                            07:00 pm -
                                            10:00 pm
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <a class="sidebarBottomLink" href="/indexInternal.es?action=internalHallofFame&amp;view=TDMCompanyOverallRanking">
                                Ranking
                            </a>
                        </div>
                    </div>
                    <div class="footerContainer">

                        <div id="alertBox" class="fliesstext"></div>
                        <div id="imprint" style="width:523px;height:600px;" class="fliesstext">
                            <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="./do_img/global/intro/but_close.png?__cv=4addfeeb6d889c0632072f85386d1900" alt=""></a></div>
                            <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>EBBC D <br>6 D route de Trèves<br>L-2633 Senningerberg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jochen Siegert<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 26337827<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 263 4651<br>Fax: +352 26 34 6590<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support" target="_blank">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br>An der Hauptwache 7<br>60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&amp;subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
                        </div>

<?php require GLOBALS . 'credits.php'; ?>

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




                        <div class="socialBar">
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

                    </div>
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
    
</body>
</html>