<?php
$rank = $base->GetRank($Users->DataRow['ID'], $Users->DataRow['playerID']);
$top1 = $rnk->getAllRankingPlayers(5);
$mRy = $rnk->getMyRanking($Users->DataRow['playerID']);
$top5 = $rnk->getAllRankingPlayers(5);
$myRanking= $mRy[0];
$be = $rnk->getRankBesideMe($myRanking['overallRank']);
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

<link type="text/css" rel="stylesheet" href="./css/hallOfFame.css?__cv=2f40569349845e48e1d01121b78bd300" />
<script type="text/javascript" src="./js/hallOfFame.js?__cv=ffbdc92d2d061c2e6277004c3074b700" language="javascript"></script>

<div class="content_frame_top">
    <div class="content_frame_top_left"></div>
    <div class="content_frame_top_right"></div>
</div>

<div class="content_frame_middle">

    <div id="hallOfFame" class="fliess11px-weiss">
        <div id="hof_spacer"></div>

        <div id="hof_sectionSelection">
            <a id="section_your" class="hof_section" href="/indexInternal.es?action=internalHallofFame&view=dailyRank">
            </a>
            <a id="section_exp" class="hof_section" href="/indexInternal.es?action=internalHallofFame&view=home_exp">
            </a>
            <a id="section_hnr" class="hof_section" href="/indexInternal.es?action=internalHallofFame&view=home_honor">
            </a>
            <a id="section_user" class="hof_section_active" href="/indexInternal.es?action=internalHallofFame">
            </a>
            <a id="section_clan" class="hof_section" href="/indexInternal.es?action=internalHallofFame&view=home_clan">
            </a>
            <a id="section_gate" class="hof_section" href="/indexInternal.es?action=internalHallofFame&view=GalaxyGatesTime1">
            </a>
            <a id="section_event" class="hof_section" href="/indexInternal.es?action=internalHallofFame&view=Spaceball">
            </a>
        </div>

        <div id="hof_content">
            <h3>TOP USER</h3>

            <div class="hof_home_tabs">
    <div id="hof_home_tab_total" class="hof_home_tab_active">TOTAL</div>
<!--    <div id="hof_home_tab_weekly" class="">LAST WEEK</div>
    <div id="hof_home_tab_climbers" class="">HIGHEST CLIMBERS</div>-->
</div>

<div id="hof_home_content_total" class="hof_inner_content hof_home_content">
    <table border="0" cellspacing="0" class="home_listing_table hof_ranking_table">
        <?php 
        foreach($top5 as $k => $v):
            echo '<tr>
            <td class="rank_position">'.$v['overallRank'].'.</td>
                    <td class="rank_name" title="'.$v['Name'].'" showuser="4pscE" style="cursor:pointer">
                '.$v['Name'].'
            </td>
                    <td class="rank_points">'.number_format($v['rankpoints']).'</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>        
        ';
        endforeach;
        ?>
        
        
           
        </table>

    <div class="hof_content_splitter" style="margin-top: 15px;"></div>

    <table border="0" cellspacing="0" class="home_listing_table hof_ranking_table" style="margin-top: 20px;">
        <?php
        foreach($be as $k => $v):
            if($v['playerID']==$Users->DataRow['playerID']):
                echo '<tr class="rank_myRank">
            <td class="rank_position">'.number_format($v['overallRank']).'</td>
                    <td class="rank_name" title="" showuser="0" style="cursor:pointer">
                        '.$v['Name'].'
                </td>
                <td class="rank_points">'.number_format($v['rankpoints']).'</td>
            </tr>
            <tr>
                <td colspan="3" class="hof_spacer_vc"></td>
            </tr>';
                else:
                 echo '<tr>
            <td class="rank_position">'.number_format($v['overallRank']).'</td>
                    <td class="rank_name" title="" showuser="0" style="cursor:pointer">'.$v['Name'].'</td>
            <td class="rank_points">'.number_format($v['rankpoints']).'</td>
            </tr>
            <tr>
                <td colspan="3" class="hof_spacer_vc"></td>
            </tr>';
            endif;
       
        endforeach;
        ?>
    </table>
</div>

<div id="hof_home_content_weekly" class="hof_inner_content hof_home_content" style="display: none">
    <table border="0" cellspacing="0" class="home_listing_table hof_ranking_table">
            <tr>
            <td class="rank_position">1.</td>
                    <td class="rank_name" title="cracker4954" showuser="4dCEt" style="cursor:pointer">
                        cracker4954
            </td>
            <td class="rank_points">872,000</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">2.</td>
                    <td class="rank_name" title="icub4." showuser="515oz" style="cursor:pointer">
                        icub4.
            </td>
            <td class="rank_points">863,128</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">3.</td>
                    <td class="rank_name" title="Ryback.!" showuser="50HzJ" style="cursor:pointer">
                        Ryback.!
            </td>
            <td class="rank_points">826,798</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">4.</td>
                    <td class="rank_name" title="BakaSeng" showuser="4A1NZ" style="cursor:pointer">
                        BakaSeng
            </td>
            <td class="rank_points">792,050</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">5.</td>
                    <td class="rank_name" title="Acho_Picaso" showuser="4pIbE" style="cursor:pointer">
                        Acho_Picaso
            </td>
            <td class="rank_points">755,889</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">6.</td>
                    <td class="rank_name" title="♦Multi♦[GА™]" showuser="69kGq" style="cursor:pointer">
                        ♦Multi♦[GА™]
            </td>
            <td class="rank_points">589,638</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">7.</td>
                    <td class="rank_name" title="аxreus" showuser="4Eyeu" style="cursor:pointer">
                        аxreus
            </td>
            <td class="rank_points">552,143</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">8.</td>
                    <td class="rank_name" title="=mudgod=" showuser="4vGKE" style="cursor:pointer">
                        =mudgod=
            </td>
            <td class="rank_points">544,970</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">9.</td>
                    <td class="rank_name" title="*WeLoveMongolia*" showuser="4EQDZ" style="cursor:pointer">
                        *WeLoveMongolia*
            </td>
            <td class="rank_points">512,289</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">10.</td>
                    <td class="rank_name" title="Redmax™" showuser="64Aiw" style="cursor:pointer">
                        Redmax™
            </td>
            <td class="rank_points">486,371</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
        </table>
</div>

<div id="hof_home_content_climbers" class="hof_inner_content hof_home_content" style="display: none;">
    <table border="0" cellspacing="0" class="home_listing_table hof_ranking_table">
            <tr>
            <td class="rank_position">1.</td>
                            <td class="rank_name" title="Acho_Picaso" showuser="4pIbE" style="cursor:pointer">
                            Acho_Picaso
            </td>
            <td class="rank_points">12,687</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">2.</td>
                            <td class="rank_name" title="bobesponja198989" showuser="6Ukzq" style="cursor:pointer">
                            bobesponja198989
            </td>
            <td class="rank_points">7,766</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">3.</td>
                            <td class="rank_name" title="†Polis.Men†Is-Back" showuser="5GUuM" style="cursor:pointer">
                            †Polis.Men†Is-Back
            </td>
            <td class="rank_points">7,130</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">4.</td>
                            <td class="rank_name" title="Mahdi*Salah" showuser="6ONqb" style="cursor:pointer">
                            Mahdi*Salah
            </td>
            <td class="rank_points">7,005</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">5.</td>
                            <td class="rank_name" title="-»ŦΣIK™«-" showuser="6c5fu" style="cursor:pointer">
                            -»ŦΣIK™«-
            </td>
            <td class="rank_points">6,692</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">6.</td>
                            <td class="rank_name" title="fatih06061" showuser="6ePUy" style="cursor:pointer">
                            fatih06061
            </td>
            <td class="rank_points">5,027</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">7.</td>
                            <td class="rank_name" title="BlueDragonOfJustice" showuser="6e6fI" style="cursor:pointer">
                            BlueDragonOfJustice
            </td>
            <td class="rank_points">4,332</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">8.</td>
                            <td class="rank_name" title="PhoenixinMist" showuser="6e0Su" style="cursor:pointer">
                            PhoenixinMist
            </td>
            <td class="rank_points">4,313</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">9.</td>
                            <td class="rank_name" title="Pain#90" showuser="6ehQ4" style="cursor:pointer">
                            Pain#90
            </td>
            <td class="rank_points">4,112</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
            <tr>
            <td class="rank_position">10.</td>
                            <td class="rank_name" title="**azrail_2882**70" showuser="6dbM2" style="cursor:pointer">
                            **azrail_2882**70
            </td>
            <td class="rank_points">3,719</td>
        </tr>
        <tr>
            <td colspan="3" class="hof_spacer_vc"></td>
        </tr>
        </table>
</div>        </div>

        <div id="hof_dropdown_wrapper">
                    <div id="hof_dropdown" class="hof_selection_down" onclick="HOF.toggleRankingSelection()">
                            OVERALL RANKINGS
                        </div>
            <div id="hof_dropdown_menu">
                            <a href="/indexInternal.es?action=internalHallofFame&view=dailyRank">
                   YOUR RANK
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&view=Faction">
                   COMPANIES
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&view=User">
                   TOP USER
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&view=UserEP">
                   EXPERIENCE
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&view=UserHonor">
                   HONOR
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&view=Ships">
                   SHIPS DESTROYED
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&view=Aliens">
                   ALIENS DESTROYED
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&view=Title">
                   TITLE OVERVIEW
                </a>
                        </div>
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


</body>
</html>