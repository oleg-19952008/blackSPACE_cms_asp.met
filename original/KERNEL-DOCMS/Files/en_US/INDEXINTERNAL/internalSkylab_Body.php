<?php

/*if(isset($_POST['subAction']) && $_POST['subAction']=="addShipToHangar"){
    $base->changeShip($_POST['hangarId'], $_POST['inventoryId']);
}*/

// set id
// $Skylab->setId($Users->DataRow['ID']);

// init the thingy
//$Skylab->initSkylab();
$Skylab->ressupdate("update");
$Lab = $Skylab->getSiteData();

?>

<script language="javascript" type="text/javascript" src="./js/skylab.js"></script>
</head>
<body onLoad="" >

<!-- /////////////////////////////////////////////////////////////////////////////////// -->

<!-- affiliateStartTag -->


<script type="text/javascript">window.name = "do_webpage";</script>



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
                <img src="../do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey" />
            </div>
        </div>
    </div>
</div>


<div id="busy_layer"></div>
<div id="instanceList"></div>
<div id="spinner" class="hidden"></div>


<!-- seitenabdecker -->

<style type="text/css" media="screen">    @import "./css/cdn/includeInfoLayer.css?__cv=a0a813df090fdb3002c3891307238000";</style>
<script type="text/javascript">
infoText = '';
icon = '';
</script>
<script type="text/javascript" src="./js/infoLayer.js?__cv=49d5cbe0b1125ad7d3c272d67c3f4d00"></script>

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
                            '../do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey'
                         );">
                    </div>
                </div>
                <div class="popup_shop_abort_button">
                    <div class="popup_shop_abort_text"
                         style="background-image: url(
                            '../do_img/global/text_tf.esg?l=en&s=12&t=confirmBox_cancel&f=eurostyle_thea&color=white&bgcolor=grey'
                         );"
                         onclick="closeInfoLayer();">
                    </div>
                </div>
            </div>

            <div id="infoLayerInfo">
                <div class="popup_shop_close_button">
                    <div class="popup_shop_close_text"
                         style='background-image: url("../do_img/global/text_tf.esg?l=en&s=12&t=ok&f=eurostyle_thea&color=white&bgcolor=grey");'
                         onclick="closeInfoLayer();"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
</script>
<?php require GLOBALS . 'internalHelpLayer.php'; require GLOBALS . 'internalNews.php'; ?>
                  
<div class="backgroundImageContainer" style="background-image: url(./do_img/global/bg_standard_vru.jpg?__cv=4aa3437fda694ce7dc5665697c466900)">
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

<script language="javascript" type="text/javascript" src="./js/skylab.js?__cv=877e5fd9712d685bb42272356ba58100"></script>

<script language="javascript" type="text/javascript">
    currentTime = 1408480318;
    var rid = '1e1064a8fdf038ee6e4c99e2beab4d29';
</script>

<input type="hidden" id="videoAvailable" value="1" />
<input type="hidden" id="videoURL" value="https://api.tokenads.com/TAS/script.jsf?s=5132_0ea211feae7a0626d7064815d74d509d&a=87040&_token=6a6713a61f957ccab2a907b3380d10d2" />
<input type="hidden" id="videoSize" value="700x500" />
<style type="text/css">

    #brand_cinema_layer {
        position: fixed;
        top: 0;
        left: 0;
        background: #000000;
        color: #FFFFFF;
        z-index: 30;
        display: none;
    }

    #brand_cinema_hint {
        text-align: center;
        font-size: 10px;
        margin: 0 40px 10px;
        padding-top: 10px;
    }

    #brand_cinema_layer iframe {
        border: 1px solid #FFFFFF;
        margin: 10px auto 15px;
        display: block;
        border-left: 15px solid #000000;
        border-right: 15px solid #000000;
    }

    #brand_cinema_layer .close_button {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        width: 24px;
        height: 24px;
        background: url(./do_img/global/skylab/modules_large/close_button_sprite.png?__cv=fa1f7ef0f89ab04212dbf02f3424d700) no-repeat center -24px;
    }
    #brand_cinema_layer .close_button:hover {
        background-position: center 0;
    }

</style>

<div id="brand_cinema_layer">
    <div class="close_button" onclick="BrandCinema.closeVideoLayer()"></div>
    <div id="brand_cinema_hint">You have to watch the full video to get an incentive. Please disable your adblocker!</div>

    <iframe src="" height="300" width="300" scrolling="no" frameborder="0">
        Your browser does not support embedded frames.
    </iframe>
</div>

<script type="text/javascript" language="javascript">

    var BrandCinema = {
        iFrameWidth: 100,
        iFrameHeight: 100,
        iFrameUrl: '',

        openVideoLayer: function()
        {
            showBusyLayer();

            var layerElm = jQuery('#brand_cinema_layer');

            layerElm.show();

            // set up the iFrame
            var videoContent = jQuery('#brand_cinema_layer iframe');
            videoContent.attr('src', this.iFrameUrl);
            videoContent.attr('width', this.iFrameWidth);
            videoContent.attr('height', this.iFrameHeight);

            // center the layer relative to it's parent element
            bodyOffsetWidth     = document.documentElement.offsetWidth,
            objectWidth         = layerElm.width(),
        // Take the banner (and it's margin) on the right hand side into account
            widthWithBanner     = objectWidth + 120,
            objectLeft          = (bodyOffsetWidth / 2) - (widthWithBanner / 2),
            bodyOffsetHeight    = document.documentElement.offsetHeight,
            objectHeight        = layerElm.height(),
            objectTop           = (bodyOffsetHeight / 2) - (objectHeight / 2);

            layerElm.css({
                top     : objectTop  + 'px',
                left    : objectLeft + 'px'
            });
        },

        closeVideoLayer: function()
        {
//            hideBusyLayer();
//            jQuery('#brand_cinema_layer').hide();
            do_redirect('/indexInternal.es?action=internalSkylab');
        }
    };

</script>    
<div id="skylab">
	<?php echo $Skylab->displayBuild(); ?>
<div id="subnav">
    <div id="tabButton1" class="tabButtonActive"
        onmouseover="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton1', 'tabButton', 'tabLabel1', 'tabLabel')"
        onclick="do_redirect('indexInternal.es?action=internalSkylab');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel1" class="tabLabelInActive tabLabelSkylabActive"></div>
    </div>
    <div id="tabButton2" class="tabButtonInActive"
        onmouseover="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton2', 'tabButton', 'tabLabel2', 'tabLabel')"
        onclick="do_redirect('indexInternal.es?action=internalNanoTechFactory');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel2" class="tabLabelInActive tabLabelTechFactoryInActive"></div>
    </div>
        <div id="tabButton3" class="tabButtonInActive"
        onmouseover="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
        onmouseout="buttonHandler.toggleButtons('tabButton3', 'tabButton', 'tabLabel3', 'tabLabel')"
        onclick="do_redirect('indexInternal.es?action=internalItemUpgradeSystem');"
        style='cursor: pointer; float: left; width: 184px; height: 25px;'>
        <div id="tabLabel3" class="tabLabelInActive tabLabelItemUpgradeSystemInActive"></div>
    </div>
    </div>
    <div id="view_prometium" class="view_generally">
        <div id="view_prometium_stock">
            <span class="ore_prometium">Prometium:</span><br />
            <?php echo $Lab['ressources']['prometium']['count']; ?>
        </div>
        <div id="view_prometium_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['prometium']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_promerium_maximal_number"><?php echo $Lab['ressources']['prometium']['max_storage']?></div>
        </div>
    </div>
    <div id="view_endurium" class="view_generally">
        <div id="view_endurium_stock">
            <span class="ore_endurium">Endurium:</span><br />
            <?php echo $Lab['ressources']['endurium']['count']; ?>
        </div>
        <div id="view_endurium_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['endurium']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_promerium_maximal_number"><?php echo $Lab['ressources']['endurium']['max_storage']?></div>
        </div>
    </div>
    <div id="view_terbium" class="view_generally">
        <div id="view_terbium_stock">
            <span class="ore_terbium">Terbium:</span><br />
            <?php echo $Lab['ressources']['terbium']['count']; ?>
        </div>
        <div id="view_terbium_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['terbium']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_promerium_maximal_number"><?php echo $Lab['ressources']['terbium']['max_storage']?></div>
        </div>
    </div>
    <div id="view_prometid" class="view_generally">
        <div id="view_prometid_stock">
            <span class="ore_prometid">Prometid:</span><br />
            <?php echo $Lab['ressources']['prometid']['count']; ?>
        </div>
        <div id="view_prometid_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['prometid']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_promerium_maximal_number"><?php echo $Lab['ressources']['prometid']['max_storage']?></div>
        </div>
    </div>
    <div id="view_duranium" class="view_generally">
        <div id="view_duranium_stock">
            <span class="ore_duranium">Duranium:</span><br />
            <?php echo $Lab['ressources']['duranium']['count']; ?>
        </div>
        <div id="view_duranium_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['duranium']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_promerium_maximal_number"><?php echo $Lab['ressources']['duranium']['max_storage']?></div>
        </div>
    </div>
    <div id="view_xenomit" class="view_generally">
        <div id="view_xenomit_stock">
            <span class="ore_xenomit">Xenomit:</span><br />
            <?php echo $Lab['ressources']['xenomit']['count']; ?>
        </div>
        <div id="view_xenomit_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['xenomit']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_promerium_maximal_number"><?php echo $Lab['ressources']['xenomit']['max_storage']?></div>
        </div>
    </div>
    <div id="view_promerium" class="view_generally">
        <div id="view_promerium_stock">
            <span class="ore_promerium">Promerium:</span><br />
            <?php echo $Lab['ressources']['promerium']['count']; ?>
        </div>
        <div id="view_promerium_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['promerium']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_promerium_maximal_number"><?php echo $Lab['ressources']['promerium']['max_storage']?></div>
        </div>
    </div>
    <div id="view_seprom" class="view_generally">
        <div id="view_seprom_stock">
            <span class="ore_seprom">Seprom:</span><br />
            <?php echo $Lab['ressources']['seprom']['count']; ?>
        </div>
        <div id="view_seprom_maximal">
            <div class="view_generally_maximal_bg" style="width: <?php echo $Lab['ressources']['seprom']['perc']?>%;"></div>
            <div class="view_generally_maximal_number view_seprom_maximal_number"><?php echo $Lab['ressources']['seprom']['max_storage']?></div>
        </div>
    </div>


    <div id="skylabReloader" onclick="javascript: do_redirect('indexInternal.es?action=internalSkylab');"></div>
	<!--<div id="blueprint"></div>-->
        <div id="modules">

<?php echo $Skylab->showModule("baseModule","smallbox"); ?>

<div id="module_baseModule_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Basic module</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_baseModule" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'baseModule')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'baseModule')">Upgrade</div>
                </div>

        <div id="module_infobox_baseModule_content" class="skylab_module_content">
            <div id="module_infobox_baseModule_overview_large" class="tabContent skylab_standard">
                            <table class="module_infobox_baseModule" cellpadding="2" cellspacing="0">
    <tr>
        <td style="width:160px"><strong><?php echo $Lab['modules']['mod_basic']['name']; ?></strong></td>
        <td style="width:65px;">
            <div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['mod_basic']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div>
            <div style="width:<?php echo $Lab['modules']['mod_basic']['progressbar']; ?>px;position:absolute;height:172px;margin-top:-6px;border-right:1px solid #989898;z-index:100;"></div>
        </td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['mod_basic']['sd_status']?>"><strong><?php echo $Lab['modules']['mod_basic']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['mod_solar']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['mod_solar']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['mod_solar']['sd_status']?>"><strong><?php echo $Lab['modules']['mod_solar']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['mod_store']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['mod_store']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['mod_store']['sd_status']?>"><strong><?php echo $Lab['modules']['mod_store']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['generator_xeno']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['generator_xeno']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['generator_xeno']['sd_status']?>"><strong><?php echo $Lab['modules']['generator_xeno']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['collector_prometium']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['collector_prometium']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['collector_prometium']['sd_status']?>"><strong><?php echo $Lab['modules']['collector_prometium']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['collector_endurium']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['collector_endurium']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['collector_endurium']['sd_status']?>"><strong><?php echo $Lab['modules']['collector_endurium']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['collector_terbium']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['collector_terbium']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['collector_terbium']['sd_status']?>"><strong><?php echo $Lab['modules']['collector_terbium']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['refine_prometid']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['refine_prometid']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['refine_prometid']['sd_status']?>"><strong><?php echo $Lab['modules']['refine_prometid']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['refine_duranium']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['refine_duranium']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['refine_duranium']['sd_status']?>"><strong><?php echo $Lab['modules']['refine_duranium']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['refine_promerium']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['refine_promerium']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['refine_promerium']['sd_status']?>"><strong><?php echo $Lab['modules']['refine_promerium']['level']; ?></strong></td>
    </tr>
    <tr>
        <td><strong><?php echo $Lab['modules']['refine_seprom']['name']; ?></strong></td>
        <td><div class="iteminfo_overview_progressbar" style="width:<?php echo $Lab['modules']['refine_seprom']['progressbar']; ?>px;"></div>
            <div class="iteminfo_overview_progressgrid"></div></td>
        <td class="baseModul_level baseModul_level_<?php echo $Lab['modules']['refine_seprom']['sd_status']?>"><strong><?php echo $Lab['modules']['refine_seprom']['level']; ?></strong></td>
    </tr>
</table>
                        </div>
<?php echo $Skylab->showModule("baseModule","upthis"); ?>
            <div id="module_infobox_baseModule_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_baseModule_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_baseModule_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

	<?php echo $Skylab->showModule("baseModule","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("solarModule","smallbox"); ?>

<div id="module_solarModule_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Solar module</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_solarModule" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'solarModule')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'solarModule')">Upgrade</div>
                </div>

        <div id="module_infobox_solarModule_content" class="skylab_module_content">
            <div id="module_infobox_solarModule_overview_large" class="tabContent skylab_standard">
                            <table id="solarModul_overview_content" cellpadding="0" cellspacing="0">
    <tr>
        <td class="firstRow label">Total energy consumption:</td>
        <td class="secondRow value"><?php echo $Lab['modules']['mod_solar']['energy_all_usage']; ?> / <?php echo $Lab['modules']['mod_solar']['energy_production']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['mod_basic']['solarinfo']; ?> label">Basic module:</td>
        <td class="secondRow <?php echo $Lab['modules']['mod_basic']['solarinfo']; ?> value"><?php echo $Lab['modules']['mod_basic']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['mod_store']['solarinfo']; ?> label">Storage module:</td>
        <td class="secondRow <?php echo $Lab['modules']['mod_store']['solarinfo']; ?> value"><?php echo $Lab['modules']['mod_store']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow label">Transport module:</td>
        <td class="secondRow value">16</td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['collector_prometium']['solarinfo']; ?> label">Prometium collector:</td>
        <td class="secondRow <?php echo $Lab['modules']['collector_prometium']['solarinfo']; ?> value"><?php echo $Lab['modules']['collector_prometium']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['collector_endurium']['solarinfo']; ?> label">Endurium collector:</td>
        <td class="secondRow <?php echo $Lab['modules']['collector_endurium']['solarinfo']; ?> value"><?php echo $Lab['modules']['collector_endurium']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['collector_terbium']['solarinfo']; ?> label">Terbium collector:</td>
        <td class="secondRow <?php echo $Lab['modules']['collector_terbium']['solarinfo']; ?> value"><?php echo $Lab['modules']['collector_terbium']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['refine_prometid']['solarinfo']; ?> label">Prometid refinery:</td>
        <td class="secondRow <?php echo $Lab['modules']['refine_prometid']['solarinfo']; ?> value"><?php echo $Lab['modules']['refine_prometid']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['refine_duranium']['solarinfo']; ?> label">Duranium refinery:</td>
        <td class="secondRow <?php echo $Lab['modules']['refine_duranium']['solarinfo']; ?> value"><?php echo $Lab['modules']['refine_duranium']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['refine_promerium']['solarinfo']; ?> label">Promerium refinery:</td>
        <td class="secondRow <?php echo $Lab['modules']['refine_promerium']['solarinfo']; ?> value"><?php echo $Lab['modules']['refine_promerium']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['refine_seprom']['solarinfo']; ?> label">Seprom refinery:</td>
        <td class="secondRow <?php echo $Lab['modules']['refine_seprom']['solarinfo']; ?> value"><?php echo $Lab['modules']['refine_seprom']['energyusage']; ?></td>
    </tr>
    <tr>
        <td class="firstRow <?php echo $Lab['modules']['generator_xeno']['solarinfo']; ?> label">Xeno module:</td>
        <td class="secondRow <?php echo $Lab['modules']['generator_xeno']['solarinfo']; ?> value"><?php echo $Lab['modules']['generator_xeno']['energyusage']; ?></td>
    </tr>
</table>                        </div>

<?php echo $Skylab->showModule("solarModule","upthis"); ?>
        
            <div id="module_infobox_solarModule_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_solarModule_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_solarModule_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

	<?php echo $Skylab->showModule("solarModule","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("storageModule","smallbox"); ?>

<div id="module_storageModule_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Storage module</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_storageModule" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'storageModule')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'storageModule')">Upgrade</div>
                </div>

        <div id="module_infobox_storageModule_content" class="skylab_module_content">
            <div id="module_infobox_storageModule_overview_large" class="tabContent skylab_standard">
                            <table>
    <tr>
	<?php $Skylab->ressupdate("out");
	$output = $Skylab->getOutput(); 
	
	$vc1 = ($output['prometium'] >= 0) ? "#69bf67" : "#ff0000";
	$vc2 = ($output['endurium'] >= 0) ? "#69bf67" : "#ff0000";
	$vc3 = ($output['terbium'] >= 0) ? "#69bf67" : "#ff0000";
	$vc4 = ($output['prometid'] >= 0) ? "#69bf67" : "#ff0000";
	$vc5 = ($output['duranium'] >= 0) ? "#69bf67" : "#ff0000";
	$vc6 = ($output['promerium'] >= 0) ? "#69bf67" : "#ff0000";
	$vc7 = ($output['seprom'] >= 0) ? "#69bf67" : "#ff0000";?>
        <td width="140px"><strong>Prometium</strong></td>
        <td width="76px"><?php echo $Lab['ressources']['prometium']['count']; ?></td>
        <td width="54px"><span style="color: <?=$vc1?>"><?php echo $output['prometium'];?></span></td>
    </tr>
    <tr>
        <td><strong>Endurium</strong></td>
        <td><?php echo $Lab['ressources']['endurium']['count']?></td>
        <td><span style="color: <?=$vc2?>"><?php echo $output['endurium'];?></span></td>
    </tr>
    <tr>
        <td><strong>Terbium</strong></td>
        <td><?php echo $Lab['ressources']['terbium']['count']?></td>
        <td><span style="color: <?=$vc3?>"><?php echo $output['terbium'];?></span></td>
    </tr>
    <tr>
        <td><strong>Prometid</strong></td>
        <td><?php echo $Lab['ressources']['prometid']['count']?></td>
        <td><span style="color: <?=$vc4?>"><?php echo $output['prometid'];?></span></td>
    </tr>
    <tr>
        <td><strong>Duranium</strong></td>
        <td><?php echo $Lab['ressources']['duranium']['count']?></td>
        <td><span style="color: <?=$vc5?>"><?php echo $output['duranium'];?></span></td>
    </tr>
    <tr>
        <td><strong>Promerium</strong></td>
        <td><?php echo $Lab['ressources']['promerium']['count']?></td>
        <td><span style="color: <?=$vc6?>"><?php echo $output['promerium'];?></span></td>
    </tr>
    <tr>
        <td><strong>Seprom</strong></td>
        <td><?php echo $Lab['ressources']['seprom']['count']?></td>
        <td><span style="color: <?=$vc7?>"><?php echo $output['seprom'];?></span></td>
    </tr>
</table>                        </div>

<?php echo $Skylab->showModule("storageModule","upthis"); ?>
        
            <div id="module_infobox_storageModule_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_storageModule_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_storageModule_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

<?php echo $Skylab->showModule("storageModule","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<div id="module_transportModule_small" class="module module_small" onclick="Skylab.showModule('transportModule');"">
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td id="corner_small_top_left_active">
                <div class="name">Transport module</div>
            </td>
            <td id="corner_small_top_right_active"></td>
        </tr>
        <tr>
            <td id="corner_small_bottom_left_active">
               <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                                                            <div class="level_icon"></div>
                                                        <div class="level skylab_font_level">1</div>
                        </td>
                        <td class="cellview">
                            <div class="power_icon"></div>
                            <div class="power skylab_font_power">16</div>
                        </td>
                                                <td><br /></td>
                                            </tr>
                </table>
            </td>
            <td id="corner_small_bottom_right_active"></td>
        </tr>
    </table>
</div>

<div id="module_transportModule_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Transport module</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_transportModule" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'transportModule')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'transportModule')">Upgrade</div>
                </div>

        <div id="module_infobox_transportModule_content" class="skylab_module_content">
            <div id="module_infobox_transportModule_overview_large" class="tabContent skylab_standard">
                            

<div id="boxTimeForTransport" style="padding:30px 0 0 3px;">Arriving in: <span id="timeForTransport">?</span></div>

<form name="sendTransport" id="sendTransport" action="indexInternal.es" method="post"><input type="hidden" name="reloadToken" value="1e1064a8fdf038ee6e4c99e2beab4d29"><input type="hidden" name="reloadToken" value="1e1064a8fdf038ee6e4c99e2beab4d29">
<input type="hidden" name="action" value="internalSkylab">
<input type="hidden" name="subaction" value="startTransport">
<input type="hidden" id="mode" name="mode" value="normal">
<input type="hidden" id="construction" name="construction" value="TRANSPORT_MODULE">


<div id="transport_left">
    <table class="module_infobox_transportModule">
    <tr>
        <td style="width:83px;"><label for="count_prometium">Prometium:</label></td>
        <td style="width:49px;"><input type="text" name="count_prometium" id="count_prometium" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
    <tr>
        <td><label for="count_endurium">Endurium:</label></td>
        <td><input type="text" name="count_endurium" id="count_endurium" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
    <tr>
        <td><label for="count_terbium">Terbium:</label></td>
        <td><input type="text" name="count_terbium" id="count_terbium" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
    <tr>
        <td><label for="count_prometid">Prometid:</label></td>
        <td><input type="text" name="count_prometid" id="count_prometid" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
    <tr>
        <td><label for="count_duranium">Duranium:</label></td>
        <td><input type="text" name="count_duranium" id="count_duranium" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
    <tr>
        <td><label for="count_xenomit">Xenomit:</label></td>
        <td><input type="text" name="count_xenomit" id="count_xenomit" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
    <tr>
        <td><label for="count_promerium">Promerium:</label></td>
        <td><input type="text" name="count_promerium" id="count_promerium" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
    <tr>
        <td><label for="count_seprom">Seprom:</label></td>
        <td><input type="text" name="count_seprom" id="count_seprom" onkeyup="checkTransportTime(0.12, 0);" class="skylab_standard" value="0" autocomplete="off" /></td>
    </tr>
</table>
</div>

<div id="transport_right">
    <table>
        <tr>
            <td style="width:41px;"><img id="to_skylab" src="./do_img/global/pilotSheet/skylab/to_skylab_0.png?__cv=1f08c141b032cd3f3800247fe3f58100" width="41" height="36"></td>
            <td style="width:23px;"><img id="but_to_skylab" src="./do_img/global/pilotSheet/skylab/but_right_0.png?__cv=ac1391c5509c09a46cc9bd5e36c51400" width="17" height="17"></td>
            <td style="width:29px"><img id="to_ship" src="./do_img/global/pilotSheet/skylab/to_ship_0.png?__cv=b76cfb40c24b488ac9f685627faad600" width="29" height="36"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top:20px;">
                <div class="button_standard">
                    <a style="display:block" onfocus="this.blur()" href="javascript:Skylab.sendTransport('fast', 'Confirm transport?','OK','Cancel');">Instant send</a>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top:5px;"><strong>1250 U.</strong></td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top:25px;">
                <div class="button_standard">
                    <a style="display:block" onfocus="this.blur()" href="javascript:Skylab.sendTransport('normal');">Send</a>
                </div></td>
        </tr>
    </table>
</div>
<div class="clearMe"></div>
</form>

                        </div>

            <div id="module_infobox_transportModule_upgrade_large" class="tabContent skylab_standard" style="display: none;">
                    <div class="upgrade_container_max">
        Maximum upgrade level attained
    </div>
            </div>
        
            <div id="module_infobox_transportModule_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_transportModule_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_transportModule_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

        <div id="module_infobox_transportModule_footer" class="skylab_module_footer">
            <div class="module_info_active_state module_infobox_info">
                            <img src="./do_img/global/pilotSheet/skylab/power_disabled.png?__cv=b0a4878430feb41ac03c5a6d796fda00" width="14" height="14" />
                        </div>

            <div class="module_info_level module_infobox_info">
                            <div class="level_icon">1</div>
                        </div>

            <div class="module_info_power_usage module_infobox_info">
                16
            </div>

                </div>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("xenoModule","smallbox"); ?>

<div id="module_xenoModule_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Xeno module</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_xenoModule" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'xenoModule')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'xenoModule')">Upgrade</div>
                </div>

        <div id="module_infobox_xenoModule_content" class="skylab_module_content">
            <div id="module_infobox_xenoModule_overview_large" class="tabContent skylab_standard">
                                        <table class="module_infobox_xenoModule" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="firstRow"><strong>Xeno module</strong></td>
                    <td class="secondRow"><strong>Active</strong></td>
                    <td class="thirdRow skylab_price_normal">
                        <div style="position:absolute;width:1px;height:124px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_vertical_short.png?__cv=b73ea38fd4a85fa2799b1ebde1973a00);background-repeat: no-repeat;background-position: 0px 5px"></div>
                        <strong>Inactive</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" style="height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;"></td>
                </tr>
                <tr>
                    <td class="firstRow"><strong>Xenomit consumption:</strong></td>
                    <td class="secondRow"><strong>0</strong></td>
                    <td class="thirdRow skylab_price_normal"><strong>0</strong></td>
                </tr>
                <tr>
                    <td class="firstRow"><strong>Efficiency:</strong></td>
                    <td class="secondRow"><strong>100%</strong></td>
                    <td class="thirdRow skylab_price_normal"><strong>0%</strong></td>
                </tr>
                <tr>
                    <td class="firstRow"><strong>Energy:</strong></td>
                    <td class="secondRow"><strong>0</strong></td>
                    <td class="thirdRow skylab_price_normal"><strong>0</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" style="height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;"></td>
                </tr>
            </table>
                        </div>

<?php echo $Skylab->showModule("xenoModule","upthis"); ?>
        
            <div id="module_infobox_xenoModule_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_xenoModule_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_xenoModule_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

<?php echo $Skylab->showModule("xenoModule","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("prometiumCollector","smallbox"); ?>

<div id="module_prometiumCollector_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Prometium collector</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_prometiumCollector" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'prometiumCollector')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'prometiumCollector')">Upgrade</div>
                    <div class="tab_third skylab_module_tab" onclick="Skylab.changeToTab('third', 'prometiumCollector')">Productivity</div>
                </div>

        <div id="module_infobox_prometiumCollector_content" class="skylab_module_content">
            <div id="module_infobox_prometiumCollector_overview_large" class="tabContent skylab_standard">
				<?php echo $Skylab->showModule("prometiumCollector","collectorDetails"); ?>
            </div>

 <?php echo $Skylab->showModule("prometiumCollector","upthis"); ?>
                    <div id="module_infobox_prometiumCollector_productivity_large" class="tabContent skylab_standard" style="display: none;">
                
<script>
jQuery(document).ready(function(){
    jQuery('#tdActiveRobts, #prometiumCollector_showActiveRobots').mouseover(function(){
        jQuery('#prometiumCollector_showActiveRobots').show();
    });
    jQuery('#tdActiveRobts, #prometiumCollector_showActiveRobots').mouseout(function(){
        jQuery('#prometiumCollector_showActiveRobots').hide();
    });
});
</script>

<div id="productivity_container">


    <div id="prometiumCollector_showActiveRobots" class="showActiveRobots" style="display:none;">
        
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            <br class="clearMe" />
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
            </div>

    <table cellpadding="0" cellspacing="1">
        <tr>
            <td colspan="2">Efficiency:</td>
            <td>Bonus:</td>
            <td style="text-align:right;">Robots:</td>
            <td><br /></td>
        </tr>
        <tr>
            <td style="width:70px;background-color:#1f2022;padding-left:5px;cursor:pointer;">100%</td>
            <td style="width:15px;cursor:pointer;">+</td>
            <td style="width:50px;background-color:#1f2022;padding-left:5px;cursor:pointer;color:#23fd10"><span id="prometiumCollector_skylabRobotBonus">0</span>%</td>
            <td style="width:70px;text-align:right;padding-right:3px;cursor:pointer;">Active</td>
            <td id="tdActiveRobts" style="width:45px;background-color:#1f2022;text-align:center;cursor:pointer;"><span id="prometiumCollector_skylabActiveRobots" style="color:#23fd10">0</span>/12</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:right;padding-right:3px;">in storage</td>
            <td style="background-color:#1f2022;text-align:center;" id="prometiumCollector_skylabPendingRobots">0</td>
        </tr>
    </table>

    <div class="productivity_robotShop">
        <div class="productivity_robotShop_credits">
            <img src="./do_img/global/pilotSheet/skylab/icon_robot_big.png?__cv=29d973635304fd6902b88e3678b88400" width="66" height="57">
            <div class="skylab_robot_price">250 Credits</div>
            <div class="button_standard" style="margin: auto;">
                <a style="display: block;" onfocus="this.blur()" onclick="xajax_buySkylabRobot('1','prometiumCollector');" href="javascript:void(0);">Buy</a>
            </div>
        </div>
        <div class="productivity_robotShop_uridium">
            <img src="./do_img/global/pilotSheet/skylab/icon_robot_big_elite.png?__cv=8d70dd00ac084d814c347beb80267400" width="66" height="57">
            <div class="skylab_robot_price">50 Uridium</div>
            <div class="button_standard" style="margin: auto;">
                <a style="display: block;" onfocus="this.blur()" onclick="xajax_buySkylabRobot('2','prometiumCollector');" href="javascript:void(0);">Buy</a>
            </div>
        </div>
    </div>

</div>            </div>
        
            <div id="module_infobox_prometiumCollector_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_prometiumCollector_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_prometiumCollector_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

<?php echo $Skylab->showModule("prometiumCollector","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("enduriumCollector","smallbox"); ?>

<div id="module_enduriumCollector_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Endurium collector</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_enduriumCollector" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'enduriumCollector')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'enduriumCollector')">Upgrade</div>
                    <div class="tab_third skylab_module_tab" onclick="Skylab.changeToTab('third', 'enduriumCollector')">Productivity</div>
                </div>

        <div id="module_infobox_enduriumCollector_content" class="skylab_module_content">
            <div id="module_infobox_enduriumCollector_overview_large" class="tabContent skylab_standard">
                <?php echo $Skylab->showModule("enduriumCollector","collectorDetails"); ?>
			</div>

 <?php echo $Skylab->showModule("enduriumCollector","upthis"); ?>
                    <div id="module_infobox_enduriumCollector_productivity_large" class="tabContent skylab_standard" style="display: none;">
                
<script>
jQuery(document).ready(function(){
    jQuery('#tdActiveRobts, #enduriumCollector_showActiveRobots').mouseover(function(){
        jQuery('#enduriumCollector_showActiveRobots').show();
    });
    jQuery('#tdActiveRobts, #enduriumCollector_showActiveRobots').mouseout(function(){
        jQuery('#enduriumCollector_showActiveRobots').hide();
    });
});
</script>

<div id="productivity_container">


    <div id="enduriumCollector_showActiveRobots" class="showActiveRobots" style="display:none;">
        
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            <br class="clearMe" />
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
            </div>

    <table cellpadding="0" cellspacing="1">
        <tr>
            <td colspan="2">Efficiency:</td>
            <td>Bonus:</td>
            <td style="text-align:right;">Robots:</td>
            <td><br /></td>
        </tr>
        <tr>
            <td style="width:70px;background-color:#1f2022;padding-left:5px;cursor:pointer;">100%</td>
            <td style="width:15px;cursor:pointer;">+</td>
            <td style="width:50px;background-color:#1f2022;padding-left:5px;cursor:pointer;color:#23fd10"><span id="enduriumCollector_skylabRobotBonus">0</span>%</td>
            <td style="width:70px;text-align:right;padding-right:3px;cursor:pointer;">Active</td>
            <td id="tdActiveRobts" style="width:45px;background-color:#1f2022;text-align:center;cursor:pointer;"><span id="enduriumCollector_skylabActiveRobots" style="color:#23fd10">0</span>/12</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:right;padding-right:3px;">in storage</td>
            <td style="background-color:#1f2022;text-align:center;" id="enduriumCollector_skylabPendingRobots">0</td>
        </tr>
    </table>

    <div class="productivity_robotShop">
        <div class="productivity_robotShop_credits">
            <img src="./do_img/global/pilotSheet/skylab/icon_robot_big.png?__cv=29d973635304fd6902b88e3678b88400" width="66" height="57">
            <div class="skylab_robot_price">250 Credits</div>
            <div class="button_standard" style="margin: auto;">
                <a style="display: block;" onfocus="this.blur()" onclick="xajax_buySkylabRobot('1','enduriumCollector');" href="javascript:void(0);">Buy</a>
            </div>
        </div>
        <div class="productivity_robotShop_uridium">
            <img src="./do_img/global/pilotSheet/skylab/icon_robot_big_elite.png?__cv=8d70dd00ac084d814c347beb80267400" width="66" height="57">
            <div class="skylab_robot_price">50 Uridium</div>
            <div class="button_standard" style="margin: auto;">
                <a style="display: block;" onfocus="this.blur()" onclick="xajax_buySkylabRobot('2','enduriumCollector');" href="javascript:void(0);">Buy</a>
            </div>
        </div>
    </div>

</div>            </div>
        
            <div id="module_infobox_enduriumCollector_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_enduriumCollector_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_enduriumCollector_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

 <?php echo $Skylab->showModule("enduriumCollector","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("terbiumCollector","smallbox"); ?>
<div id="module_terbiumCollector_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Terbium collector</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_terbiumCollector" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'terbiumCollector')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'terbiumCollector')">Upgrade</div>
                    <div class="tab_third skylab_module_tab" onclick="Skylab.changeToTab('third', 'terbiumCollector')">Productivity</div>
                </div>

        <div id="module_infobox_terbiumCollector_content" class="skylab_module_content">
            <div id="module_infobox_terbiumCollector_overview_large" class="tabContent skylab_standard">
                <?php echo $Skylab->showModule("terbiumCollector","collectorDetails"); ?>
			</div>

 <?php echo $Skylab->showModule("terbiumCollector","upthis"); ?>
                    <div id="module_infobox_terbiumCollector_productivity_large" class="tabContent skylab_standard" style="display: none;">
                
<script>
jQuery(document).ready(function(){
    jQuery('#tdActiveRobts, #terbiumCollector_showActiveRobots').mouseover(function(){
        jQuery('#terbiumCollector_showActiveRobots').show();
    });
    jQuery('#tdActiveRobts, #terbiumCollector_showActiveRobots').mouseout(function(){
        jQuery('#terbiumCollector_showActiveRobots').hide();
    });
});
</script>

<div id="productivity_container">


    <div id="terbiumCollector_showActiveRobots" class="showActiveRobots" style="display:none;">
        
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            <br class="clearMe" />
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
                    <div class="container_robot_small">
                            <img src="./do_img/global/pilotSheet/skylab/icon_robot_empty.png?__cv=f7ff82658232a01263ae70afb4011400" width="39" height="34">
                <div style="width:33px;text-align:center;margin-left:5px;"><br /></div>
                        </div>
            
            </div>

    <table cellpadding="0" cellspacing="1">
        <tr>
            <td colspan="2">Efficiency:</td>
            <td>Bonus:</td>
            <td style="text-align:right;">Robots:</td>
            <td><br /></td>
        </tr>
        <tr>
            <td style="width:70px;background-color:#1f2022;padding-left:5px;cursor:pointer;">100%</td>
            <td style="width:15px;cursor:pointer;">+</td>
            <td style="width:50px;background-color:#1f2022;padding-left:5px;cursor:pointer;color:#23fd10"><span id="terbiumCollector_skylabRobotBonus">0</span>%</td>
            <td style="width:70px;text-align:right;padding-right:3px;cursor:pointer;">Active</td>
            <td id="tdActiveRobts" style="width:45px;background-color:#1f2022;text-align:center;cursor:pointer;"><span id="terbiumCollector_skylabActiveRobots" style="color:#23fd10">0</span>/12</td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:right;padding-right:3px;">in storage</td>
            <td style="background-color:#1f2022;text-align:center;" id="terbiumCollector_skylabPendingRobots">0</td>
        </tr>
    </table>

    <div class="productivity_robotShop">
        <div class="productivity_robotShop_credits">
            <img src="./do_img/global/pilotSheet/skylab/icon_robot_big.png?__cv=29d973635304fd6902b88e3678b88400" width="66" height="57">
            <div class="skylab_robot_price">250 Credits</div>
            <div class="button_standard" style="margin: auto;">
                <a style="display: block;" onfocus="this.blur()" onclick="xajax_buySkylabRobot('1','terbiumCollector');" href="javascript:void(0);">Buy</a>
            </div>
        </div>
        <div class="productivity_robotShop_uridium">
            <img src="./do_img/global/pilotSheet/skylab/icon_robot_big_elite.png?__cv=8d70dd00ac084d814c347beb80267400" width="66" height="57">
            <div class="skylab_robot_price">50 Uridium</div>
            <div class="button_standard" style="margin: auto;">
                <a style="display: block;" onfocus="this.blur()" onclick="xajax_buySkylabRobot('2','terbiumCollector');" href="javascript:void(0);">Buy</a>
            </div>
        </div>
    </div>

</div>            </div>
        
            <div id="module_infobox_terbiumCollector_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_terbiumCollector_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_terbiumCollector_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>
<?php echo $Skylab->showModule("terbiumCollector","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("prometidRefinery","smallbox"); ?>

<div id="module_prometidRefinery_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Prometid refinery</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_prometidRefinery" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'prometidRefinery')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'prometidRefinery')">Upgrade</div>
                </div>

        <div id="module_infobox_prometidRefinery_content" class="skylab_module_content">
<?php echo $Skylab->showModule("prometidRefinery","refineryDetails"); ?>

 <?php echo $Skylab->showModule("prometidRefinery","upthis"); ?>
        
            <div id="module_infobox_prometidRefinery_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_prometidRefinery_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_prometidRefinery_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

<?php echo $Skylab->showModule("prometidRefinery","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("duraniumRefinery","smallbox"); ?>

<div id="module_duraniumRefinery_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Duranium refinery</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_duraniumRefinery" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'duraniumRefinery')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'duraniumRefinery')">Upgrade</div>
                </div>

        <div id="module_infobox_duraniumRefinery_content" class="skylab_module_content">
            <?php echo $Skylab->showModule("duraniumRefinery","refineryDetails"); ?>

 <?php echo $Skylab->showModule("duraniumRefinery","upthis"); ?>
        
            <div id="module_infobox_duraniumRefinery_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_duraniumRefinery_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_duraniumRefinery_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

<?php echo $Skylab->showModule("duraniumRefinery","footer"); ?>
    </div>

</div>
<script type="text/javascript">
</script>
<?php echo $Skylab->showModule("promeriumRefinery","smallbox"); ?>

<div id="module_promeriumRefinery_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Promerium refinery</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_promeriumRefinery" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'promeriumRefinery')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'promeriumRefinery')">Upgrade</div>
                </div>

        <div id="module_infobox_promeriumRefinery_content" class="skylab_module_content">
<?php echo $Skylab->showModule("promeriumRefinery","refineryDetails"); ?>

 <?php echo $Skylab->showModule("promeriumRefinery","upthis"); ?>
        
            <div id="module_infobox_promeriumRefinery_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_promeriumRefinery_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_promeriumRefinery_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

<?php echo $Skylab->showModule("promeriumRefinery","footer"); ?>
    </div>

</div>
<script type="text/javascript">
    jQuery('#module_infobox_promeriumRefinery_infomessage').html("Before you upgrade your Promerium refinery, you should build Prometid and Duranium refineries as well as a Xeno module so that you'll have enough resources to refine. These refineries are located on the right in the Skylab.");
    jQuery('#module_infobox_promeriumRefinery_resourceWarning_large').show();
</script>
<?php echo $Skylab->showModule("sepromRefinery","smallbox"); ?>

<div id="module_sepromRefinery_large" class="module module_large" style="display: none;">
    <div class="skylab_module_header">
        <div class="name">Seprom refinery</div>
        <div class="skylab_module_close"></div>
    </div>

    <div id="module_infobox_sepromRefinery" class="skylab_module_middle">
        <div class="skylab_module_tabs">
            <div class="tab_first skylab_module_tab tab_active" onclick="Skylab.changeToTab('first', 'sepromRefinery')">Info</div>
            <div class="tab_second skylab_module_tab" onclick="Skylab.changeToTab('second', 'sepromRefinery')">Upgrade</div>
                </div>

        <div id="module_infobox_sepromRefinery_content" class="skylab_module_content">
<?php 
	echo $Skylab->showModule("sepromRefinery","refineryDetails");
	echo $Skylab->showModule("sepromRefinery","upthis");
?>
        
            <div id="module_infobox_sepromRefinery_resourceWarning_large" class="tabContent skylab_standard module_resourceWarning">
                <div id="module_infobox_sepromRefinery_infomessage" class="module_resourceWarning_text"></div>
                <div class="button_standard module_resourceWarning_button">
                    <a style="display: block;" onfocus="this.blur()" onclick="jQuery('#module_infobox_sepromRefinery_resourceWarning_large').hide();" href="#">
                        <strong>OK</strong>
                    </a>
                </div>
            </div>
        </div>

<?php echo $Skylab->showModule("sepromRefinery","footer"); ?>
    </div>
    </div>

<script type="text/javascript">
$('module_infobox_sepromRefinery_infomessage').innerHTML = "Before you upgrade your Seprom refinery, you should build a Promerium refinery so that you'll have enough resources to refine. This refinery is located on the right in the Skylab.";
$('module_infobox_sepromRefinery_resourceWarning_large').show();
</script>    </div>
   </div>
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
    Dialog.alert('<ul><li>Не работает!</li></ul>', { width:300 } );
</script>





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
<script language="javascript" type="text/javascript">

var refresh = 'Refresh skylab';
var help = 'Help';



jQuery("#skylabReloader").qtip({
    content: refresh,
    style:'dohdr',
    position:{target:'mouse'}
})

jQuery("#skylabHelp").qtip({
    content: help,
    style:'dohdr',
    position:{target:'mouse'}
})

</script>