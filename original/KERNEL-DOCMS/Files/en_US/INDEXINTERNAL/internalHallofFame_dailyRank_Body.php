<?php
$rank = $base->GetRank($Users->DataRow['ID'], $Users->DataRow['playerID']);
$top1 = $rnk->getAllRankingPlayers(5);
$mRy = $rnk->getMyRanking($Users->DataRow['playerID']);
$top5 = $rnk->getAllRankingPlayers(5);
$myRanking= $mRy[0];
$pwn = $rnk->getAllPlayers($Users->DataRow['playerID']);
$npc = $rnk->getNpcKill($Users->DataRow['playerID']);
$player = $rnk->gePlayerKills($Users->DataRow['playerID']);
?>
</head>
<body onLoad="" >
<!-- affiliateStartTag -->



<!-- user context info layer -->
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
<script type="text/javascript" src="/js/infoLayer.js?__cv=f873586616939bcb06c5d95a7ef73200"></script>

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
                
<script type="text/javascript">
    // tooltip definitions
    var hof_ttips = new Object;
    hof_ttips['your'] = 'YOUR RANK';
    hof_ttips['exp'] = 'TOP EXPERIENCE HOME';
    hof_ttips['hnr'] = 'TOP HONOR HOME';
    hof_ttips['user'] = 'TOP USER';
    hof_ttips['clan'] = 'TOP CLANS HOME';
    hof_ttips['gate'] = 'GALAXY GATE RANKINGS';
    hof_ttips['event'] = 'EVENT RANKINGS';
</script>

<link type="text/css" rel="stylesheet" href="/css/hallOfFame.css?__cv=2f40569349845e48e1d01121b78bd300" />
<script type="text/javascript" src="/js/hallOfFame.js?__cv=ffbdc92d2d061c2e6277004c3074b700" language="javascript"></script>

<div class="content_frame_top">
    <div class="content_frame_top_left"></div>
    <div class="content_frame_top_right"></div>
</div>

<div class="content_frame_middle">
<div id="hallOfFame" class="fliess11px-weiss">
        <div id="hof_spacer"></div>

        <div id="hof_sectionSelection">
            <a id="section_your" class="hof_section_active" href="/indexInternal.es?action=internalHallofFame&amp;view=dailyRank">
            </a>
            <a id="section_exp" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=home_exp">
            </a>
            <a id="section_hnr" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=home_honor">
            </a>
            <a id="section_user" class="hof_section" href="/indexInternal.es?action=internalHallofFame">
            </a>
            <a id="section_clan" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=home_clan">
            </a>
            <a id="section_gate" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=GalaxyGatesTime1">
            </a>
            <a id="section_event" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=Spaceball">
            </a>
        </div>

        <div id="hof_content">
            <h3>YOUR RANK</h3>

            <div class="small_grey_center">You are a <strong><?php echo $base->GetRankByRNK($rank['rank']); ?></strong>. Your rank is calculated as follows:</div>

<div class="hof_inner_content">

    <div id="hof_daily_formulaUnits" class="js-scroll-pane" tabindex="0" style="overflow: hidden; padding: 0px; width: 642px;">
        
        <div id="hof_daily_pointsAchieved" class="hof_ranking_margin">
            <div id="hof_daily_points_descr">Ranking points you achieved:</div>
            <div id="hof_daily_points_points"><?php echo number_format($pwn[0]['total']);?></div>
        </div>

        <div id="hof_daily_wrapper">
            <table border="0" class="hof_daily_unitsTable hof_ranking_table" id="daily_positive" cellspacing="0">
                            <tbody><tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
                <tr>
                    <td class="hof_units_formula"> + </td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_text">Experience points</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_amount"><?php echo number_format(($pwn[0]['exp']*100000)); ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_factor">/ 100,000</td>
                </tr>

                                <tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
                <tr>
                    <td class="hof_units_formula"> + </td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_text">Honor points</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_amount"><?php echo number_format(($pwn[0]['honor']*100)); ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_factor">/ 100</td>
                </tr>

                                <tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
                <tr>
                    <td class="hof_units_formula"> + </td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_text">Player shot points</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_amount"><?php echo number_format(($pwn[0]['playerkills']/3)); ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_factor">x 3</td>
                </tr>

                                <tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
                <tr>
                    <td class="hof_units_formula"> + </td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_text">Your level</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_amount"><?php echo number_format(($pwn[0]['level']/100)); ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_factor">x 100</td>
                </tr>

                                <tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
                <tr>
                    <td class="hof_units_formula"> + </td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_text">Days since registration</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_amount"><?php echo number_format(($pwn[0]['days']/6)); ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_factor">x 6</td>
                </tr>

                                <tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
				<tr>
                    <td class="hof_units_formula"> + </td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_text">NPC shot points</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_amount"><?php echo number_format(($pwn[0]['npckills']*2)); ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_factor">/ 2</td>
                </tr>
				              <tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
                <tr>
                    <td class="hof_units_formula"> + </td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_text">Your ship type (<?php echo $rnk->shipNameFromNumber($pwn[0]['shipId']/1000); ?>)</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_amount"><?php echo number_format(($pwn[0]['shipId']/1000)); ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="hof_units_factor">x 1,000</td>
                </tr>

                                <tr>
                    <td colspan="5" class="hof_spacer_vc"></td>
                </tr>
                        </tbody>
            </table>
            <br><br>

            <p>You can see how your score will be calculated in the table pictured above. Each value will be balanced using a predetermined factor. Experience Points, for instance, are divided by 100,000 and added to other balanced values, which is how we determine your total Rank Points.</p>
            <br>
            <?php if($rank['rank']>=20): ?><p>You have the highest rank possible: <strong><?php echo $base->GetRankByRNK($rank['rank']); ?></strong> or <strong>Administrator</strong></p><?php else:?><p>You need approx. <?php echo round($rnk->getApprox($pwn[0]['total'], '>', $rank['rank'], $Users->DataRow['factionId'])); ?> rank points to reach the next rank of <img src="/do_img/global/ranks/rank_<?php if($rank['rank']+1==21): echo $rank['rank']; else: echo $rank['rank']+1; endif; ?>.png?__cv=0e33367f8604cebebb0ef62a1b498100"> <strong><?php echo $base->GetRankByRNK($rank['rank']+1); ?></strong>.</p> <?php endif; ?>
            <br>
            <p>The rank directly below yours is that of <img src="/do_img/global/ranks/rank_<?php if($rank['rank']-1==0): echo $rank['rank']; else: echo $rank['rank']-1; endif; ?>.png?__cv=d0d033082e6f5947dab73f9be6f13300"> <strong><?php echo $base->GetRankByRNK($rank['rank']-1); ?></strong>. Space pilots with this rank have approx. <?php echo $rnk->getApprox($pwn[0]['total'], '<', $rank['rank'], $Users->DataRow['factionId']); ?> rank points.</p>
            <br><br>
            <p><strong>Note:</strong> The rank is only calculated twice a day. The figures listed here are only meant as a rough estimate. There is no guarantee that you'll automatically change ranks if you've reached a certain number of points, since the values of the other players are also constantly changing.</p>
            <br><br>

            
        </div>
        <br><br>
		<table class="hof_shooting_table" id="daily_npc_points">
                <tbody><tr>
                    <th style="padding-left: 20px;">Alien type</th>
                    <td class="hof_spacer_hz"></td>
                    <th align="center">Points per kill</th>
                    <td class="hof_spacer_hz"></td>
                    <th align="center">Kills</th>
                    <td class="hof_spacer_hz"></td>
                    <th align="center">Total points</th>
                </tr>
				<?php 
				$io = 1;
				$totalkills = 0;
				foreach ($npc['playerNPC'] as $key => $am){	
					
				$kne = substr($key, 3);
				if ($io % 2 == 0) {
				  $cl = "hof_highlighted";
				}else{
					$cl = "none"; 
				}
				$points = $am*$npc['npcINFO'][$kne]['rankPoints'];
				?>
				<tr class="<?php echo $cl; ?>">
                    <td class="rank_name_font"><?php echo $npc['npcINFO'][$kne]['Name']; ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font"><?php echo $npc['npcINFO'][$kne]['rankPoints']; ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font"><?php echo $am; ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font"><?php echo $points; ?></td>
                </tr>
				<?php
				$io++;				
				}
				?>
                       
            </tbody></table>
			<br />
			<table class="hof_shooting_table" id="daily_player_points">
                <tbody>
				<tr>
                    <th style="padding-left: 20px;">User ship type</th>
                    <td class="hof_spacer_hz"></td>
                    <th>Points per kill</th>
                    <td class="hof_spacer_hz"></td>
                    <th>Kills</th>
                    <td class="hof_spacer_hz"></td>
                    <th>Total points</th>
                </tr>
				
				<?php 
				$io = 1;
				$totalkills = 0;
				foreach ($player['playerNPC'] as $key => $am){	
				if($key =="ship11" OR $key =="ship12" OR $key =="ship13"){	

				}else{				
				$kne = substr($key, 4);
				if ($io % 2 == 0) {
				  $cl = "none";
				}else{
					$cl = "hof_highlighted"; 
				}
				$points = $am*$player['npcINFO'][$kne]['rankPoints'];
				?>
                                <tr class="<?php echo $cl; ?>">
                    <td class="rank_name_font"><?php echo $player['npcINFO'][$kne]['Name']; ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font"><?php echo $player['npcINFO'][$kne]['rankPoints']; ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font"><?php echo $am; ?></td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font"><?php echo $points; ?></td>
                </tr>
				
				<?php
				$io++;
				}				
				}
				?>
                        
                                <tr class="hof_highlighted">
                    <td class="rank_name_font">Kills according to most recent calculation</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font">1</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font">0</td>
                    <td class="hof_spacer_hz"></td>
                    <td class="rank_points_font">0</td>
                </tr>
            </tbody></table>
			<br /><br />
    </div>
           
         

    <div class="hof_content_splitter"></div>

    <div id="hof_daily_sum">
        <table border="0" class="hof_daily_unitsTable hof_ranking_table" cellspacing="0">
            <tbody><tr>
                <td class="hof_units_text hof_units_text_long">Total ranking points</td>
                <td class="hof_spacer_hz"></td>
                <td class="hof_units_amount" style="font-weight: bold;"><?php echo number_format($pwn[0]['total']);?></td>
            </tr>
        </tbody></table>
    </div>
</div>        </div>

        <div id="hof_dropdown_wrapper">
                    <div id="hof_dropdown" class="hof_selection_inactive"></div>
                </div>

            </div>
</div>

<div class="content_frame_bottom">
    <div class="content_frame_bottom_left"></div>
    <div class="content_frame_bottom_right"></div>
</div>


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

<!-- LayertoolService JavaScript Injection end -->
<div></div>

</body>
</html>