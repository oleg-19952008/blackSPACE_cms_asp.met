
<meta http-equiv="refresh" content="3;URL=/indexInternal.es.php?action=internalStart" />
<?php
// added by invi for some reasons..
//die("something went wrong...");


$itemHour = $auc->getHourAuctionItems();
$itemDay = $auc->getDayAuctionItems();
$bc = $auc->blackMarketTime();
$shop->setId($Users->DataRow['ID'], $Users->DataRow['playerID'], $Users->DataRow['premium']);
$base->setId($Users->DataRow['ID'], $Users->DataRow['playerID']);
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
                    <img src="/text?t=OK&w=3&s=12&color=white&h=13&b=grey" />
                </div>
            </div>
        </div>
    </div>


    <div id="busy_layer"></div>


    <!-- seitenabdecker -->

    <style type="text/css" media="screen">    @import "http://<?php echo DynHost; ?>/css/cdn/includeInfoLayer.css?__cv=6f32d2604f47c348e721414f1418ee00";</style>
    <script type="text/javascript">
                infoText = '<?php if (isset($log_message)): echo $log_message;
endif; ?>';
                icon = '<?php if (isset($type)): echo $type;
endif; ?>';    </script>

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
                             '/text?t=OK&w=3&s=12&color=white&h=13&b=grey'
                             );">
                        </div>
                    </div>
                    <div class="popup_shop_abort_button">
                        <div class="popup_shop_abort_text"
                             style="background-image: url(
                             '/text?t=Cancel&w=6&s=12&color=white&h=13&b=grey'
                             );"
                             onclick="closeInfoLayer();">
                        </div>
                    </div>
                </div>

                <div id="infoLayerInfo">
                    <div class="popup_shop_close_button">
                        <div class="popup_shop_close_text"
                             style='background-image: url("/text?t=OK&w=3&s=12&color=white&h=13&b=grey");'
                             onclick="closeInfoLayer();"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
<?php if (isset($type) && isset($log_message) && !empty($type)): echo "showInfoLayer('info', 0, infoText);";
endif; ?>

    </script>


<?php require GLOBALS . 'internalHelpLayer.php';
require GLOBALS . 'internalNews.php'; ?>
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



                            <script language="javascript">
                                var _m = 0;
                                        var _s = 59;
                                        var filterGroups = new Array();
                                        filterGroups['hour'] = new Array();
                                        filterGroups['hour'].push('battery');
                                        filterGroups['hour'].push('rocket');
                                        filterGroups['hour'].push('generator');
                                        filterGroups['hour'].push('extra');
                                        filterGroups['hour'].push('weapon');
                                        filterGroups['hour'].push('special');
                                        filterGroups['hour'].push('ship');
                                        filterGroups['hour'].push('booster');
                                        filterGroups['hour'].push('shipdesign');
                                        filterGroups['day'] = new Array();
                                        filterGroups['day'].push('ship');
                                        filterGroups['day'].push('shipdesign');
                                        filterGroups['day'].push('module');
                                        filterGroups['week'] = new Array();
                                        filterGroups['week'].push('shipdesign');
                                        filterGroups['event'] = new Array();
                                        filterGroups['event'].push('rocket');
                                        filterGroups['event'].push('shipdesign');
                                        var counterHour = {
<?php echo $auc->minToNextHour(); ?>,
                                                hour:   0,
                                                day:    0
                                        }
                                var counterDay = {
<?php echo $auc->minToNextHour(); ?>,
                                        hour:   <?php echo $auc->hourToNextDay(); ?>,
                                        day:    0
                                }
                                var counterWeek = {
                                    <?php 
                                        if($bc[0]=="open"){
                                            echo $bc[1];
                                        }else{
                                            
                                        }
                                    ?>
                                }

                                var myBidCount = {
                                hour:   0,
                                        day:    0,
                                        week:   0
                                }

                                var mayEquip = {
                                showHint: false,
                                        itemId: '',
                                        category: '',
                                        amount: 0,
                                        msg: ''
                                }

                                Tools.Text.setResource('items_shop_buy_confirm_s', 'Do you really want to buy <b>%ITEMNAME%<\/b> for <b>%ITEMPRICE%<\/b>?');
                                        Tools.Text.setResource('pricetag_uridium_compact', '%VALUE% U.');
                                        Tools.Text.setResource('auction_filter', 'Filter');
                                        Tools.Text.setResource('auction_filter_history', 'Select auction');
                                        Tools.Text.setResource('auction_ttip_bid', 'Place bid');
                                        Tools.Text.setResource('auction_ttip_buy', 'Buy it now with Uridium');
                                        Tools.Text.setResource('auction_ttip_bid_disabled', 'Please choose an item before bidding.');
                                        Tools.Text.setResource('auction_ttip_buy_disabled', 'Please choose an item.');
                                        Tools.Text.setResource('auction_ttip_buy_permitted', 'This item can only be bid on, not bought instantly.');
                                        Tools.Text.setResource('captcha_btn_label', 'Submit ');
                                        Tools.Text.setResource('auction_enable_mail', 'Enable confirmation messages');
                                        Tools.Text.setResource('auction_disable_mail', 'Disable confirmation messages');
                                        var reloadToken = '6f7738ebfa26f371b36f518fc05b969f';
                                        var requestedTab = 'hour';
                                        var showCaptcha = false;                            </script>

                            <script type="text/javascript" src="./js/auction.js?__cv=5522feca4e9b87b8e195f66bc31c3600"></script>

                            <div id="layerQuantityManager"></div>
                            <div id="content">
                                <!-- Content -->
                                <div id="auction_container">
                                    <div id="auction_headline">
                                        AUCTION HOUSE
                                    </div>

                                    <div id="auction_filter_wrapper" class="filter_wrapper">
                                        <div id="auction_filter_selector" class="filter_selector">Filter</div>
                                        <div id="auction_filter_selection" class="filter_selection" style="display: none;">
                                            <div class="filter_item" id="filter_all">All</div>
                                            <div class="filter_item" id="filter_battery" style="display: block;">Batteries</div>
                                            <div class="filter_item" id="filter_rocket" style="display: block;">Rockets and Mines</div>
                                            <div class="filter_item" id="filter_generator" style="display: block;">Generators</div>
                                            <div class="filter_item" id="filter_extra" style="display: block;">Extras</div>
                                            <div class="filter_item" id="filter_weapon" style="display: block;">Weaponry</div>
                                            <div class="filter_item" id="filter_special" style="display: block;">Special</div>
                                            <div class="filter_item" id="filter_ship" style="display: block;">Ships</div>
                                            <div class="filter_item" id="filter_booster" style="display: block;">Boosters</div>
                                            <div class="filter_item" id="filter_shipdesign">Designs</div>
                                            <div class="filter_item" id="filter_module" style="display: none;">Modules</div>
                                            <div class="auction_filter_btm"></div>
                                        </div>
                                    </div>

                                    <div id="auction_history_dropdown" class="filter_wrapper" style="display: none;">


                                    </div>

                                    <div id="auction_tab_wrapper">
                                        <div class="auction_tab_main auction_tab_active" id="tab_hour">HOURLY</div>
                                        <div class="auction_tab_main" id="tab_day">DAILY</div>
                                        <div class="auction_tab_main" id="tab_week">BLACK MARKET</div>
                                    </div>

                                    <div id="auction_content" class="auction_deco_1">
                                        <div id="auction_top_area">
                                            <div class="auction_subtab auction_subtab_active" id="auction_current">
                                                AUCTION
                                            </div>
                                            <div id="auction_countdown" style="display: block;">
                                                Auction ends in
                                                <span id="countdown_hour" class="countdown_item" style="display: inline;"></span>
                                                <span id="countdown_day" class="countdown_item" style="display: none;"></span>
                                                <?php 
                                                            if($bc[0]=="open"){
                                                                echo '<span id="countdown_week" class="countdown_item" style="display: none;"></span>';
                                                            }else{
                                                            }
                                             ?>
                                                
                                            </div>
                                        </div>

                                        <div id="auction_content_hour" class="auction_content_sub" style="display: block;">
                                            <div class="auctionList auction_list_current" style="display: block;">
                                                <table border="0" cellpadding="0" cellspacing="0" class="auctionItemList">
                                                    <tbody><tr>
                                                            <th class="auction_item_name" colspan="2">Item Name</th>
                                                            <th class="auction_item_type">Type</th>
                                                            <th class="auction_item_highest">Highest Bidder</th>
                                                            <th class="auction_item_current">Current Bid</th>
                                                            <th class="auction_item_you">Your Bid</th>
                                                            <th class="auction_item_instant">Instant Buy</th>
                                                        </tr>

                                                    </tbody><tbody class="auction_item_wrapper jspScrollable" style="overflow: hidden; padding: 0px; width: 633px;" tabindex="0">

<?php
if($Users->DataRow['playerID']!=4198){

																
$i = 0;
//print_r($itemHour);
//exit;
foreach ($itemHour as $key => $val) {
    if ($val['ItemName'] == "drone_iris" && $base->currentDrones($Users->DataRow['ID'], $Users->DataRow['playerID']) >= 8):

    else:
        if ($val['ItemName'] == "drone_iris"):
            $iBuy = $shop->dronePrice("iris");
        else:
            $iBuy = $val['iBuy'];
        endif;
        if ($i % 2 == 0) {
            $cl = "";
        } else {
            $cl = "evenRow";
        }
        if ($val['sType'] == "Batteries"):
            $C = strtolower("battery");
        elseif ($val['sType'] == "Weaponry"):
            $C = strtolower("weapon");
        elseif ($val['sType'] == "Special"):
            $C = strtolower("Special");
        elseif ($val['sType'] == "Designs"):
            $C = strtolower("shipdesign");
        else:
            $filter = explode(" ", $val['sType']);
            $C = substr(strtolower($filter[0]), 0, -1);
        endif;
        echo '
                                 <tr class="auctionItemRow ' . $cl . '" itemgroup="' . $C . '" itemkey="item_hour_' . $i . '" onclick="Auction.showItem(this)">
                            <td class="firstColumn">
                                <img src="'.base64_decode($val['thirty']).'" width="30" height="30" alt="' . $val['name'] . '">
                            </td>
                            <td class="auction_item_name_col">
                                ' . $val['name'] . '
                            </td>
                            <td class="auction_item_type">
                                ' . $val['sType'] . '
                            </td>
                            <td class="auction_item_highest" showuser="4WWM3" title="' . $base->getNameBypid($val['HBidder']) . ' - click for details">
                            
                                ' . $base->getNameBypid($val['HBidder']) . '
                            </td>
                            <td class="auction_item_current">
                                 ' . number_format($val['cBud']) . '
                            </td>
                            <td class="auction_item_you">
                                -
                            </td>
                            <td class="auction_item_instant">
                                                                     ' . number_format($iBuy) . '
                                
                                <input type="hidden" id="item_hour_' . $i . '_image" value="'. base64_decode($val['sixtythree']) .'">
                                <input type="hidden" id="item_hour_' . $i . '_descr" value="' . $val['deco'] . '">
                                <input type="hidden" id="item_hour_' . $i . '_bid" value="' . $val['cBud'] . '">
                                <input type="hidden" id="item_hour_' . $i . '_buyPrice" value="' . $iBuy . '">
                                <input type="hidden" id="item_hour_' . $i . '_lootId" value="' . $val['ItemName'] . '">
                                <input type="hidden" id="item_hour_' . $i . '_instantBuy" value="1">
                            </td>
                        </tr>';


        $i++;
    endif;
}

}
?>



                                                        </div></tbody>
                                                </table>
                                            </div>


                                        </div>
                                        <div id="auction_content_day" class="auction_content_sub" style="display: none;">
                                            <div class="auctionList auction_list_current" style="display: block;">
                                                <table border="0" cellpadding="0" cellspacing="0" class="auctionItemList">
                                                    <tbody><tr>
                                                            <th class="auction_item_name" colspan="2">Item Name</th>
                                                            <th class="auction_item_type">Type</th>
                                                            <th class="auction_item_highest">High Bidder</th>
                                                            <th class="auction_item_current">Current Bid</th>
                                                            <th class="auction_item_you">Your Bid</th>
                                                            <th class="auction_item_instant">Instant Buy</th>
                                                        </tr>

                                                    </tbody>
                                                    <tbody class="auction_item_wrapper" style="overflow: hidden; padding: 0px; width: 633px;">
<?php
 /* echo '<div id="myBid_hintbox_day" class="mybid_hintwindow">
                                                                        The auction is disabled!
                                                                    </div>'; */
																	
 $j = 101;
foreach ($itemDay as $key => $val) {
//                             print_r($val);
//                             exit;
    if ($val['ItemName'] == "drone_iris" && $base->currentDrones($Users->DataRow['ID'], $Users->DataRow['playerID']) >= 8):

    else:
        if ($val['ItemName'] == "drone_iris"):
            $iBuy = $shop->dronePrice("iris");
        else:
            $iBuy = $val['iBuy'];
        endif;
        $json = json_decode(base64_decode($val['levels']));
        if (isset($json[0]->cdn->{'30x30'})) {
            $img30 = $auc->getXmlImages($json[0]->cdn->{'30x30'});
        } else {
            $img30 = $auc->getXmlImages($json[0]->cdn->{'63x63'});
        }
        if (isset($json[0]->cdn->{'63x63'})) {
            $img63 = $auc->getXmlImages($json[0]->cdn->{'63x63'});
        } else {
            $img63 = $auc->getXmlImages($json[0]->cdn->{'63x63'});
        }

        if ($j % 2 == 0) {
            $cl = "";
        } else {
            $cl = "evenRow";
        }
        if ($val['sType'] == "Batteries"):
            $C = strtolower("battery");
        elseif ($val['sType'] == "Weaponry"):
            $C = strtolower("weapon");
        elseif ($val['sType'] == "Special"):
            $C = strtolower("Special");
        elseif ($val['sType'] == "Designs"):
            $C = strtolower("shipdesign");
        else:
            $filter = explode(" ", $val['sType']);
            $C = substr(strtolower($filter[0]), 0, -1);
        endif;
        echo '
                                 <tr class="auctionItemRow ' . $cl . '" itemgroup="' . $C . '" itemkey="item_hour_' . $j . '" onclick="Auction.showItem(this)">
                            <td class="firstColumn">
                                <img src="./do_img/global' . $img30 . '" width="30" height="30" alt="' . $val['name'] . '">
                            </td>
                            <td class="auction_item_name_col">
                                ' . $val['name'] . '
                            </td>
                            <td class="auction_item_type">
                                ' . $val['sType'] . '
                            </td>
                            <td class="auction_item_highest" showuser="4WWM3" title="' . $base->getNameBypid($val['HBidder']) . ' - click for details">
                            
                                ' . $base->getNameBypid($val['HBidder']) . '
                            </td>
                            <td class="auction_item_current">
                                 ' . number_format($val['cBud']) . '
                            </td>
                            <td class="auction_item_you">
                                -
                            </td>
                            <td class="auction_item_instant">
                                                                     ' . number_format($iBuy) . '
                                
                                <input type="hidden" id="item_hour_' . $j . '_image" value="./do_img/global' . $img63 . '">
                                <input type="hidden" id="item_hour_' . $j . '_descr" value="' . $val['deco'] . '">
                                <input type="hidden" id="item_hour_' . $j . '_bid" value="' . $val['cBud'] . '">
                                <input type="hidden" id="item_hour_' . $j . '_buyPrice" value="' . $iBuy . '">
                                <input type="hidden" id="item_hour_' . $j . '_lootId" value="' . $val['ItemName'] . '">
                                <input type="hidden" id="item_hour_' . $j . '_instantBuy" value="1">
                            </td>
                        </tr>';


        $j++;
    endif; 
}
?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="auctionList auction_list_mybids" style="display: none;">
                                                <table border="0" cellpadding="0" cellspacing="0" class="auctionItemList">
                                                    <tbody><tr>
                                                            <th class="auction_item_name" colspan="2">Item Name</th>
                                                            <th class="auction_item_type">Type</th>
                                                            <th class="auction_item_highest">High Bidder</th>
                                                            <th class="auction_item_current">Current Bid</th>
                                                            <th class="auction_item_you">Your Bid</th>
                                                            <th class="auction_item_instant">Instant Buy</th>
                                                        </tr>

                                                    </tbody><tbody class="auction_item_wrapper" style="overflow: hidden; padding: 0px; width: 633px;"><div class="jspContainer" style="width: 633px; height: 255px;"><div class="jspPane" style="padding: 0px; top: 0px; width: 633px;">

                                                        </div></div></tbody>
                                                </table>

                                                <div id="myBid_hintbox_day" class="mybid_hintwindow">
                                                    You have not yet placed a bid.
                                                </div>
                                            </div>
                                        </div>
                                        <div id="auction_content_week" class="auction_content_sub" style="display: none;">
                                            <div class="auctionList auction_list_current" style="display: block;">
                                                <table border="0" cellpadding="0" cellspacing="0" class="auctionItemList">
                                                    <tbody><tr>
                                                            <th class="auction_item_name" colspan="2">Item Name</th>
                                                            <th class="auction_item_type">Type</th>
                                                            <th class="auction_item_highest">High Bidder</th>
                                                            <th class="auction_item_current">Current Bid</th>
                                                            <th class="auction_item_you">Your Bid</th>
                                                            <th class="auction_item_instant">Instant Buy</th>
                                                        </tr>

                                                    </tbody>
													<tbody class="auction_item_wrapper" style="overflow: hidden; padding: 0px; width: 633px;">
                                                        <?php 
                                                            if($bc[0]=="open"){
                                                                echo '<div id="myBid_hintbox_day" class="mybid_hintwindow">
                                                                        The Black Market is open
                                                                    </div>';
                                                            }else{
                                                                 echo '<div id="myBid_hintbox_day" class="mybid_hintwindow">
                                                                        The Black Market is closed
                                                                    </div>';
                                                            }
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="auctionList auction_list_mybids" style="display: none;">
                                                <table border="0" cellpadding="0" cellspacing="0" class="auctionItemList">
                                                    <tbody><tr>
                                                            <th class="auction_item_name" colspan="2">Item Name</th>
                                                            <th class="auction_item_type">Type</th>
                                                            <th class="auction_item_highest">High Bidder</th>
                                                            <th class="auction_item_current">Current Bid</th>
                                                            <th class="auction_item_you">Your Bid</th>
                                                            <th class="auction_item_instant">Instant Buy</th>
                                                        </tr>

                                                    </tbody><tbody class="auction_item_wrapper" style="overflow: hidden; padding: 0px; width: 633px;"><div class="jspContainer" style="width: 633px; height: 255px;"><div class="jspPane" style="padding: 0px; top: 0px; width: 633px;">

                                                        </div></div></tbody>
                                                </table>

                                                <div id="myBid_hintbox_week" class="mybid_hintwindow">
                                                    You have not yet placed a bid.
                                                </div>
                                            </div>

                                        </div>

                                        <div id="auction_item_info" style="display: block;">
                                            <div id="item_info_image_wrapper">
                                                <img src="" width="63" height="63" id="auction_item_image" style="display: none;">
                                            </div>

                                            <div id="auction_item_descr" class="item_qtip" title=""></div>
                                            <div id="auction_descr_ttip" style="display: none;"></div>

                                            <div id="auction_item_buy" style="display: block;">
                                                <form method="post" name="placeBid" action="/indexInternal.es?action=internalAuction&amp;reloadToken=6f7738ebfa26f371b36f518fc05b969f" onsubmit="return Auction.checkForm()"><input type="hidden" name="reloadToken" value="6f7738ebfa26f371b36f518fc05b969f">
                                                    <input type="hidden" name="auctionType" value="hour">
                                                    <input type="hidden" name="subAction" value="bid">
                                                    <input type="hidden" name="lootId" value="">
                                                    <input type="hidden" name="itemId" value="">

                                                    <input type="text" name="credits" value="0">
                                                    <img src="./do_img/global/auction/credits.png?__cv=505a650ada9ece3b973a30abc53c8500" width="21" height="21" class="currency_icon" id="auction_crd">

                                                    <input type="submit" name="auction_buy_button" class="disabled" id="auction_place_bid" value="BID">
                                                    <img src="./do_img/global/auction/uridium.png?__cv=b78e7600ee1cbc03b3f7062390a87600" width="21" height="21" class="currency_icon" id="auction_uri">
                                                </form>

                                                <input type="text" name="instant" readonly="readonly" value="0">
                                                <input type="button" class="auction_buy_button disabled" id="auction_instant_buy" value="INSTANT BUY" onclick="Auction.instantBuy()">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mail_wrapper">
                                        <div id="auction_mail_receive" class="button-singleCheckbox button-singleCheckbox-checked"></div>
                                        <div id="auction_mail_receiveLabel">Confirmation messages</div>
                                    </div>
                                </div>
                                <!-- Ende Content -->
                            </div>

                        </div><!-- END contentFrame -->
                    </div><!-- END realContainer -->

                    <div class="footerContainer">
                        <div class="frameLeft_bottom"></div>
                        <div class="frameRight_bottom"></div>
                        <div class="frameBottom"></div>

                        <div id="alertBox" class="fliesstext"></div>
                        <div id="imprint" style="width:523px;height:600px;" class="fliesstext">
                            <div id="imprint_close"><a href="javascript:void(0);" onclick="closeInfo('imprint');"><img src="./do_img/global/intro/but_close.png" alt=""></a></div>
                            <div id="imprint_text"><b>Bigpoint S.à.r.l. and Co, SCS</b><br>EBBC D <br>6 D route de Trèves<br>L-2633 Senningerberg<br><br><b>Our business portal</b><br><a class="" href="http://www.bigpoint.net" target="_blank">http://www.bigpoint.net</a><br><br><b>Corporate information</b><br>CEO: Bigpoint S.à.r.l.<br>Jochen Siegert<br>Court of registry: R.C.S. Luxemburg<br>Trade register number: B 167809<br>VAT number: LU 26337827<br><br><b>Disclaimer</b><br>Although every effort is made to present current and accurate information, we cannot assume responsibility for information from external links. The author of each web page is solely responsible for the content of that page.<br><br><b>Contact</b><br>Telephone <b>(no Support)</b>: +352 263 4651<br>Fax: +352 26 34 6590<br><br><b>Questions or problems? Contact Support</b><br>E-mail: <a class="gl_imprint_support_link" href="/index.es?action=support" target="_blank">Support form</a><br>Internet: http://www.bigpoint.com<br><br><b>Commissioner for Youth Protection</b><br>Lawyer Dr. Andreas Lober<br>SCHULTE RIESENKAMPFF Rechtsanwaltsgesellschaft mbH<br>An der Hauptwache 7<br>60313 Frankfurt am Main<br>E-mail: jugendschutzbeauftragter@bigpoint.com<br><br><b>Data protection officer</b><br>E-mail: privacy@bigpoint.net<br><a style="text-decoration: underline" class="" href="/index.es?action=info&amp;subAction=privacyPolicy" target="_blank">Data Privacy Policy</a></div>
                        </div>
<?php require GLOBALS . 'credits.php'; ?>

                        <script type="text/javascript" id="sourcecode">

                                    jQuery(function()
                                    {
                                    jQuery('#teamCredits_text').jScrollPane({autoReinitialise: true, showArrows: true});
                                    });                        </script>

                        <div id="imprint_ingame" class="fliesstext" style="position:absolute; left:40px; top:24px; height:15px;">
                            <a href="javascript:void(0);" onclick="showFooterLayer('imprint');">
                               
                            <a href="javascript:void(0);" onclick="showFooterLayer('teamCreditsBox')">Credits</a> |
                            <a href="/GameAPI.php?action=portal.redirectToBoard" target="_blank">Forum</a>
                        </div>




                        
                          
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

    <!-- LayertoolService JavaScript Injection end -->


</body>
</html>
