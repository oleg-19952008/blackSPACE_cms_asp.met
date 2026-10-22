<?php
$rank = $base->GetRank($Users->DataRow['ID'], $Users->DataRow['playerID']);
$top = $rnk->getAllRankingPlayers();
$rnk->setUrl('?action=internalHallofFame&view=User');
$range = $rnk->getRange();
$cuPage = $rnk->getCurrentPage();
$total = $rnk->getTotalOfResults();
$tPage = $rnk->getTotalOfPages();
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
            <a id="section_your" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=dailyRank">
            </a>
            <a id="section_exp" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=home_exp">
            </a>
            <a id="section_hnr" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=home_honor">
            </a>
            <a id="section_user" class="hof_section_active" href="/indexInternal.es?action=internalHallofFame">
            </a>
            <a id="section_clan" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=home_clan">
            </a>
            <a id="section_gate" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=GalaxyGatesTime1">
            </a>
            <a id="section_event" class="hof_section" href="/indexInternal.es?action=internalHallofFame&amp;view=Spaceball">
            </a>
        </div>

        <div id="hof_content">
            <h3>TOP USER</h3>

            <table class="hof_tableHeader" border="0" cellspacing="0">
    <tbody><tr>
        <td class="hof_rank">Rank</td>
        <td class="hof_name" style="width: 250px;">Name</td>
        <td style="width: 60px;"></td>
        <td class="hof_value">Value</td>
    </tr>
</tbody></table>

<div class="hof_defaultListing js-scroll-pane" tabindex="0" style="overflow: hidden; padding: 0px; width: 642px;">
<table border="0" cellspacing="0" class="hof_ranking_table defaultRanking" style="width: 565px;">
    <tbody>
        <?php
                                                if ($total != 0) {
                                                    if ($cuPage == 1) {
                                                        $start = 0;
                                                        if($total<$range):
                                                            $end = $total;
                                                            else:                                                            
                                                            $end = $range;
                                                        endif;
                                                    } else {
                                                        $start = ($cuPage - 1) * $range;
                                                        if ($cuPage != $tPage) {
                                                            $end = $cuPage * $range;
                                                        } else {
                                                            $end = $total;
                                                        }
                                                    }
                                                    for ($i = $start; $i < $end; $i++) {
                                                        echo '<tr>
                                                            <td class="rank_position_font" style="width: 56px;">'.$top[$i]['overallRank'].'</td>
                                                            <td class="splitter">
                                                                <img src="./do_img/global/hof/splitter_line_01.png?__cv=78ee08dae397b17a4057b350a4329000" width="1">
                                                            </td>
                                                            <td class="rank_name_font" style="width: 165px;cursor: pointer;" title="'.$top[$i]['Name'].'" showuser="1uQwW">
                                                                '.$top[$i]['Name'].'
                                                            </td>
                                                            <td class="splitter">
                                                                <img src="./do_img/global/hof/splitter_line_01.png?__cv=78ee08dae397b17a4057b350a4329000" width="1">
                                                            </td>
                                                            <td class="rank_name_font" style="width: 170px; font-weight: normal; color: #6b6b6b;">'.$base->GetRankByRNK($top[$i]['rank']).'</td>
                                                            <td class="splitter">
                                                                <img src="./do_img/global/hof/splitter_line_01.png?__cv=78ee08dae397b17a4057b350a4329000" width="1">
                                                            </td>
                                                            <td class="rank_points_font" style="text-align: right; padding-right: 30px;">
                                                                '.number_format($top[$i]['rankpoints']).'
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="hof_spacer_vc"></td>
                                                        </tr>';
                                                    }
                                                } else {
                                                    echo '<li class="no_items even">This search produced no results.</li>';
                                                }
                                                ?>
   
   
</tbody></table>
</div>
    
              </div>

        <div id="hof_dropdown_wrapper">
                    <div id="hof_dropdown" class="hof_selection_down" onclick="HOF.toggleRankingSelection()">
                            OVERALL RANKINGS
                        </div>
            <div id="hof_dropdown_menu">
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=dailyRank">
                   YOUR RANK
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=Faction">
                   COMPANIES
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=User">
                   TOP USER
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=UserEP">
                   EXPERIENCE
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=UserHonor">
                   HONOR
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=Ships">
                   SHIPS DESTROYED
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=Aliens">
                   ALIENS DESTROYED
                </a>
                            <a href="/indexInternal.es?action=internalHallofFame&amp;view=Title">
                   TITLE OVERVIEW
                </a>
                        </div>
                </div>

                <div id="hof_pagination">
                    <?php echo $rnk->paginate(); ?>
                
            
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

<div></div>

</body>
</html>