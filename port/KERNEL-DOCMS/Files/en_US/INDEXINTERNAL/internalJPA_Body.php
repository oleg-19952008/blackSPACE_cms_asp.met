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
            

                    <link rel="stylesheet" href="./css/cdn/navigation.css?__cv=027602d6f1863686ece0574190059400" />
                    <link rel="stylesheet" href="./css/cdn/internalNewClan.css?__cv=b067289aca88e7bdf4c5386619af2000" />
                    <script type="text/javascript" src="./js/page/clan/internalNewClanIndexDomReady.js?__cv=2dc5d4f0df5f490bb84b9ada5fab8a00"></script>
                    <script type="text/javascript" src="./resources/js/user.js?__cv=b79aef5e50246af886bf99f0a7678400"></script>
                   <?php require GLOBALS . 'internalHeaderIntern.php'; ?>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
                    <script type="text/javascript" src="./pages/jpa/jpa.js"></script>

            <div class="bodyContainer">
                <div class="frameTop"></div>
                    <div class="frameLeft_top"></div>
                        <div class="frameRight_top"></div>
                            <div class="contentFrame">
                                <div class="borderFrame">
                                <div id="navigationFrame">

                                    <!-- start internal clan2 -->

                                    <div id="navigation">
                                        <!-- Join -->


                                        <div class="button">
                                            <a href="indexInternal.es?action=internalJPA-list" title="Join">
                                                <img src="./text?t=ТАБЛИЦА&w=16&s=9.2&color=white&b=grey"/>
                                            </a>
                                        </div>

                                        <div class="button active">
                                            <a href="indexInternal.es?action=internalJPA" title="Found">
                                                <img src="./text?t=РЕГИСТРАЦИЯ&w=16&s=9.2&color=black&font=1&b=lightestBlue"/>
                                            </a>
                                        </div>  
                                    </div>

                                    <!-- end internal clan2 -->
                                    <div id="wrapper" class="clanFound"  style="height:404px;">

                                        <div class="headline">Регистрация на JPA</div>

                                        <div class="description">

                                            <br/>
                                            <span class="bluegrey">

                                               <!-- баланс -->
                                            <?php
                                                $mysqli = new mysqli('127.0.0.1', 'root', '', 'darkorbit', 3306);
                                                $mysqli->set_charset('utf8');
                                                $pid= $Users->DataRow['playerID'];
                                                $jackpot = $mysqli->query("SELECT `jackpot` FROM `server_1_players` WHERE `userID` = '$pid'"); 
                                                $uid = $mysqli->query("SELECT `id` FROM `jpa` WHERE `user_id` = $pid ")->fetch_assoc()['id'];
                                                $uidw = $mysqli->query("SELECT `war` FROM `jpa` WHERE `user_id` = $pid ")->fetch_assoc()['war'];

                                                while ($row = $jackpot->fetch_assoc()) {
                                                    $row_jackpot = (float)$row['jackpot'];
                                                    echo  "У вас: ".$row_jackpot." EUR <br>";
                                                    echo "Для участия необходимо 2000.00 EUR <br><br>";
                                                    if ($row_jackpot  < 2000.00) {
                                                        $lacks = 2000.00 - $row_jackpot;
                                                        echo "<span class='red'>Для участия не хватает: ".$lacks." EUR</span>";
                                                    }
                                                    else{
                                                        echo "<span class='green'>Вы можете принять участие!</span>
                                                        ";
                                                    }
                                                }
                                            ?>


                                    <center>    
                                        
                                        <div id="GalaxyBody">
                                        </div>   
                                    </center>
                                            </span>

                                            <br/>

                                        </div>
                                        <div class="formular">
                                         
                                            <div id="clanFoundForm">
                                            <!-- <form id="clanFoundForm" action="indexInternal.es?action=internalJPA" method="POST" onsubmit="cleanClanFoundForm()"> -->
                                                <input type="hidden" name="reloadToken" value="d3fcf6d9ebcf9803fd732ab0405b940e">

                                                <input type="hidden" name="language" value="us"/>
                                                <?php
                                                if ($uid != 0) { ?>
                                                <input type="text" name="clanName" value="" maxlength="50" title="Ваш уникальный ID: <?php echo $uid; ?>" disabled=""/><br/>
                                                <input type="text" name="clanTag" value="" maxlength="7" title="Ваш соперник: ID <?php echo $uidw; ?>" disabled=""/><br/>
                                                <?php }
                                                 else{
                                                ?>
                                                <input type="text" name="clanName" value="" maxlength="50" title="Вы не зарегистрированы" disabled=""/><br/>
                                                <input type="text" name="clanTag" value="" maxlength="7" title="Вы не зарегистрированы" disabled=""/><br/>
                                                <?php } ?>
                                                <textarea name="clanDescription" disabled="" title=""></textarea>

                                                <div class="costs">
                                                    <div class="left"></div>
                                                    <div class="center">2000 EUR</div>
                                                    <div class="right"></div>
                                                    <div style="clear:both;"><!-- --></div>
                                                </div>

                                                <div id="jpaSubmit">
                                                <button name="submit" type="submit"  class="jpaSubmit">
                                                    <img src="http://127.0.0.1/do_img/global/text_tf.esg?l=us&s=12&t=clan_button_send&f=eurostyle_thea&color=white&bgcolor=grey" alt="send"/>
                                                </button>
                                            </div>
                                            <!-- </form> -->
                                            </div>
                                        </div>

                                        <div style="clear:both;"><!--  --></div>
                                    </div><!-- end div#wrapper -->

                                    <div style="clear:both;"><!--  --></div>

                                </div><!-- end div#navigationWrapper -->

                            </div>

</div><!-- END contentFrame -->
</div><!-- END realContainer -->

<div class="footerContainer">
    <div class="frameLeft_bottom"></div>
    <div class="frameRight_bottom"></div>
    <div class="frameBottom"></div>


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