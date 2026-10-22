
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
    <title>Андромеда 5</title>
    
    <link href="css/no_unity3.css?ver=1" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Play:400,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css' />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject2.js"></script>
    
    <!-- start Mixpanel -->
<script type="text/javascript">
(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);
//mixpanel.init("aa9a4cf67a4bb4e82b7d8c352de64b39");

//mixpanel.identify('159368_1_ru');

//mixpanel.register({
//    game_type: 'ru',
//    world_id: '1',
//    player_id: '159368',
//    user_agent: navigator['userAgent'],
    
//});

</script>
<!-- end Mixpanel -->

    <script type="text/javascript">
	
    var RACE_ID = '1';
    var GAME_ID = '$smarty.session.game_id';
/* Translated Strings */
    var Ok = 'ОК';
    var Yes = 'Да';
    var No = 'Нет';
    var Go = 'Вперёд!';
    var Close = 'Закрыть';
    var Disable = 'Отключить';
    var Submit = 'Отправить';
    var Select = 'Выбрать';
    var Cancel = 'Отмена';
    var Attention = 'Внимание';
    var Success = 'Успех';
    var ErrorMsg = 'Ошибка';
    var Info = 'Информация';
    var RUSure = 'Вы уверены?';
    var invalidArtefact = 'Этот символ уже был использован.';

    var PHP_SELF = '/unity.php';
    var JQ_ANIMATION_SPEED = 'fast';

    var DEC_SEPARATOR = '.';
    var THO_SEPARATOR = ',';

    var currentTime = new Date('January 15, 2015 22:54:25');

    var paymentsUrl = 'http://andromeda5.playvision.ru/shop/content';
    var paymentsSupportUrl = 'LINK_PAYMENTS_SUPPORT';
    var surveyUrl = 'SURVEY_URL';
    var feedbackUrl = 'http://feedback.xs-software.com/andromeda5/ru/1/index/index/159368/37f8631e53a569377039770390a5a2a14f662afcb2e654b342bb654a28fc6822/ru_RU/partnerid/771';
    
    
    	
</script>
    
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-34298631-1']);
        _gaq.push(['_setDomainName', 'andromeda5.com']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        var game_id = "ru";
        var world_id = "1";
        var player_id = "159368";
        var madmoo_id = "26931856";
    
        var conf = {
            width : "100%",
            height : "100%",
            params: {
                backgroundcolor: "000000",
                bordercolor: "000000",
                textcolor: "FFFFFF",
                logoimage: "img/header_logo.png",
                disableContextMenu: true
            }
        };
    

        function logState(state_id, time_string) {

            if(typeof mixpanel !== 'undefined' && mixpanel != null) {

                var eventName = "";
                state_id = state_id*1;
                switch(state_id) 
                {

                    case 100:
                        eventName="Without Unity player";
                        break;
                    case 101:
                        eventName="With Unity player";
                        break;
                    case 102:
                        eventName="Click On Install Unity";
                        break;
                    case 1:
                        eventName="Start Unity";
                        break;
                    case 2:
                        eventName="Loading Langs";
                        break;
                    case 22:
                        eventName="Langs Done";
                        break;
                    case 3:
                        eventName="Error at GameServer";
                        break;
                    case 41:
                        eventName="GUI loading 25%";
                        break;
                    case 42:
                        eventName="GUI loading 50%";
                        break;
                    case 43:
                        eventName="GUI loading 75%";
                        break;
                    case 4:
                        eventName="GUI Loaded";
                        break;
                    case 5:
                        eventName="Loading Assets 25%";
                        break;
                    case 6:
                        eventName="Loading Assets 50%";
                        break;
                    case 7:
                        eventName="Loading Assets 75%";
                        break;
                    case 8:
                        eventName="Start Loading scene";
                        break;
                    case 9:
                        eventName="Scene is loaded";
                        break;
                    case 10:
                        eventName="Click in tutorial";
                        break;
                }

                //return;
                //mixpanel.track(eventName,{ 'event_id': state_id, 'time_spend': time_string });
            }


            var ajaxLoging = 'ajax_loging.php?uid=' + (new Date()).valueOf();
            $.post(ajaxLoging, {
                type: 'logStates',
                state: state_id,
                time: time_string
            }, function(response){
                return true;
            });

            if(state_id == "3" || state_id == "11") {
                //Could not connect to server ... refresh
                window.location.href=window.location.href;
            }
        }

    
    
        var unity = new UnityObject2(conf);
        
        unity.observeProgress(function (progress) {
            var $missingScreen = jQuery(progress.targetEl).find(".missing");
            switch(progress.pluginStatus) {
                case "unsupported":
                    showUnsupported();
                break;
                case "broken":
                    alert("You will need to restart your browser after installation.");
                break;
                case "missing":
                    startRotate();
                    $missingScreen.find("a").click(function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        unity.installPlugin();
                        logState("102","0");
                        return false;
                    });
                    $missingScreen.show();

                     logState("100","0");
                    $('#unityPlayer').width("100%");
                    $('#unityPlayer').height("");
                    $('#unityPlayer').css("position", "absolute");
                    $('#unityPlayer').css("text-align", "center");
                    $('#unityPlayer').css("background-color", "");
                    $('#unityPlayer').css("border", "0px solid");
                    $('#unityPlayer').css("z-index", "4");

                    //Try auto install
                    unity.installPlugin();

                    _gaq.push(['_trackEvent', 'tracking', 'without_unity', 'tracking', '1']);

                break;
                case "installed":
                    $missingScreen.remove();

                    $('#unityPlayer').width("100%");
                    $('#unityPlayer').height("100%");
                    $('#unityPlayer').css("position", "absolute");
                    $('#unityPlayer').css("top", "0px");
                    $('#unityPlayer').css("background-color", "");
                    
                    
                    logState("101","0");

                    showPixels();

                    _gaq.push(['_trackEvent', 'tracking', 'with_unity', 'tracking', '1']);

                    $(document).ready(function() {
                        $(document).trigger('unity.loaded', [null]);
                    });
                break;
                case "first":
                break;
            }
        });
        
        jQuery(function(){
                                                unity.initPlugin(jQuery("#unityPlayer")[0], "http://ru.static.andromeda5.com/webplayer/WebPlayer_156.unity3d");
                                     });
    

    function showPixels() {
        $('#tracking_iframe').attr('src', "http://ru.game.andromeda5.com/pixels.php");
    }
    
    function startGame() {
        logState("1", "0"); //Start Game
        var unityObj = unity.getUnity();
        
        unityObj.SendMessage("GlobalObject", "JSSetId" , "2783");
        unityObj.SendMessage("GlobalObject", "JSSetGalaxyId" , "220");
        unityObj.SendMessage("GlobalObject", "JSSetIsInBase" , "false");
        unityObj.SendMessage("GlobalObject", "JSSetServerIp" , "217.174.159.31");
        unityObj.SendMessage("GlobalObject", "JSSetServerPort" , "13632");
        unityObj.SendMessage("GlobalObject", "JSSetSceneName" , "Taurus");
        unityObj.SendMessage("GlobalObject", "JSSetURLPayments" , "http://andromeda5.playvision.ru/shop/content");
        unityObj.SendMessage("GlobalObject", "JSSetURLAvatar" , "http://ru.game.andromeda5.com/avatars/ru/world_1/{0}.jpg");
        unityObj.SendMessage("GlobalObject", "JSSetURLFeedback" , "http://feedback.xs-software.com/andromeda5/ru/1/index/index/159368/37f8631e53a569377039770390a5a2a14f662afcb2e654b342bb654a28fc6822/ru_RU/partnerid/771");
        unityObj.SendMessage("GlobalObject", "JSSetURLLogout" , "http://andromeda5.playvision.ru");
        unityObj.SendMessage("GlobalObject", "JSSetURLRecruit" , "http://ru.game.andromeda5.com/profile.php?sub=recruit");
        unityObj.SendMessage("GlobalObject", "JSSetURLFacebook" , "http://ru.game.andromeda5.com/profile.php?sub=facebook");
        unityObj.SendMessage("GlobalObject", "JSSetPaymentsPromotion" , "0");
        unityObj.SendMessage("GlobalObject", "JSSetLoginServerIP" , "217.174.159.31");
        unityObj.SendMessage("GlobalObject", "JSSetAssetsUrl" , "http://ru.static.andromeda5.com/assets");
        unityObj.SendMessage("GlobalObject", "JSSetGameType" , "ru");
        unityObj.SendMessage("GlobalObject", "JSSetMadmooId" , "26931856");
        unityObj.SendMessage("GlobalObject", "JSSetPlayerId" , "159368");
        unityObj.SendMessage("GlobalObject", "JSStartGame" , "");
    }

    function sendNotification(eventType, eventData) {
        var ajaxPixels = 'ajax_notifications.php?uid=' + (new Date()).valueOf();
	$.post(ajaxPixels, {
		type: eventType,
                eventData: eventData,
                game_id: game_id,
                world_id: world_id,
                player_id: player_id,
                madmoo_id: madmoo_id
	}, function(response){
            //Ok
	});
    }

    function openPayments() {
        
                    
            $("#dialogBox").html('<iframe src="iframe_payments.php" style="width: 845px;height: 750px" scrolling="no" frameborder="0" />');
            $("#dialogMessage").show(); 
            
        
    }
    
    function hidePayments() {
        $("#dialogMessage").hide();
        $("#dialogBox").html(" ");
    }
    

</script>



</head>
<body style="height:100%;"  class="unityPlayerPage">

<script type="text/javascript" src="js/three.js"></script>
<script>
     window.requestAnimFrame = (function(callback){
         return window.requestAnimationFrame ||
         window.webkitRequestAnimationFrame ||
         window.mozRequestAnimationFrame ||
         window.oRequestAnimationFrame ||
         window.msRequestAnimationFrame ||
         function(callback){
         window.setTimeout(callback, 1000 / 30);
         };
     })();

     function animate(lastTime, angularSpeed, three){
         // update this frame
         var date = new Date();
         var time = date.getTime();
         var timeDiff = time - lastTime;
         var angleChange = angularSpeed * timeDiff * 2 * Math.PI / 1000;
         three.earth.rotation.y += angleChange * 1.5;
         three.earth2.rotation.y -= angleChange;
         lastTime = time;

         // render this frame
         three.renderer.render(three.scene, three.camera);

         // next frame
         requestAnimFrame(function(){
             animate(lastTime, angularSpeed, three);
         });
     }

     function startRotate(){
        var angularSpeed = 0.005;
        var lastTime = 0;

        // load renderer
        var renderer = new THREE.WebGLRenderer();
        renderer.setSize( 1100, 550 );
        container = document.getElementById('content');
        document.body.appendChild(container);
        container.appendChild( renderer.domElement );

        // set a camera
        var camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 1, 1000);
        camera.position.z = 900;

        // create a scene
        var scene = new THREE.Scene();

        // add a texture to a material
        var material = new THREE.MeshLambertMaterial({
            map: THREE.ImageUtils.loadTexture("img/no_unity3/planet1.jpg"),
        });

        var material2 = new THREE.MeshLambertMaterial({
           map: THREE.ImageUtils.loadTexture("img/no_unity3/planet2.jpg")
        });

        // create an earth object
        var earth = new THREE.Mesh(new THREE.SphereGeometry(300, 55, 55), material);
        earth.overdraw = true;
        scene.add(earth);
        earth.position = new THREE.Vector3(450, -225, 100);

        var earth2 = new THREE.Mesh(new THREE.SphereGeometry(180, 90, 90), material2);
        earth2.overdraw = true;
        scene.add(earth2);
        earth2.position = new THREE.Vector3(-780, 92, 0);

        // add a directional light source
        var directionalLight = new THREE.DirectionalLight(0xffffff);
        directionalLight.position.set(100, 1500, 0).normalize();
        scene.add(directionalLight);

        // keep everything together to make passing it around easier
        var three = {
            renderer: renderer,
            camera: camera,
            scene: scene,
            earth: earth,
            earth2: earth2
        };

                    // Preload textures before begining animation
        var textureImg = new Image();
        textureImg.onload = function(){
           animate(lastTime, angularSpeed, three, this);
        };
        textureImg.src = "img/no_unity3/planet1.jpg";
        textureImg.src = "img/no_unity3/planet2.jpg";
    };
 </script>
    
    

    <div id="dialogMessage">
        <div id="dialogBox"></div>
    </div>
    
    
    <!-- This will be replaced by Unity content. -->
    <div id="unityPlayer">
        <div class="missing">
            
            <div id="room">
                    <div id="frame"></div>
                    <div id="flares"></div>
                    <div id="glows"></div>
                    <div id="content">
                            <a href="http://unity3d.com/webplayer/" id="unityButton"><div href="#" class="playNow">play now</div></a>
                            <div id="display"></div>
                            <div id="suitLights"></div>
                    </div>
            </div>
        </div>
    </div><!--container end-->         
    

    

    
    <div id="tracking_pixels" style="display: none">
        <iframe width="0" height="0" src="" id="tracking_iframe"></iframe>
        
                
            </div>

</body>
</html>
