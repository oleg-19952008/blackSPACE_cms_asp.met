<?php
ini_set('default_charset', 'utf-8')
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Orbit Reborn</title>
    <link rel="stylesheet" type="text/css" href="../public/css/default.css">
	<link type="text/css" href="../public/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
	<link type="text/css" href="../public/css/scrollbar_dark.css" rel="stylesheet" media="all" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js">
	</script>
	<script type="text/javascript" src="../public/js/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="../public/js/jquery.jscrollpane.min.js"></script>
	<script>
		$(function()
		{
			$('.scroll-panel').jScrollPane(
				{
					showArrows: true
				}
			);


		});

  //       function openMiniMap()
  //       {
  //           console.log("works");
  //           window.open('<?php echo URL; ?>internalMap', '_blank', 'width=830,height=670');
  //       }
	</script>

    <noscript>
        <style type="text/css">
            #container {display:none;}
            .noscriptmsg
            {
                width: 100%;
                height: 100%;
            }
            .msg
            {
                background-color: rgb(90, 90, 90);
                width: 500px;
                border-radius: 5px;
                margin: auto;
                margin-top: 25%;
                padding: 10px;
                text-align: center;
            }
        </style>
        <div class="noscriptmsg">
            <div class="msg">
                You don't have javascript enabled. Please turn it on !
            </div>
        </div>
    </noscript>

</head>

<body>
    <div id="container">
        <div id="header">
    <embed src="http://127.0.0.1/public/images/header.swf" flashvars="uid=<?php echo Auth::getUser('id'); ?>&amp;rank=<?php echo Auth::getUser('grade'); ?>&amp;lvl=10&amp;xp=5827144&amp;cred=<?php echo Auth::getUser('credits'); ?>&amp;xcred=<?php echo Auth::getUser('uridium'); ?>&amp;ouser=<?php echo Server_status::online_users(); ?>&amp;section=1&amp;jackpot=0&amp;repair=1&amp;aid=579&amp;premium=1&amp;eventItemEnabled=&amp;supporturl=#&amp;serverdesc=Old DO&amp;server_code=en&amp;isGuestUser=0&amp;openSocial=&amp;wmode=opaque&amp;ship_id=10&amp;cdn=<?php echo url_no_slash; ?>&amp;allowedScriptAccess=always&amp;allowNetworking=true&amp;coBrandHref=&amp;coBrandImgUrl=&amp;lang=en" play="true" loop="true" menu="false" quality="best" name="" allowscriptaccess="always" allownetworking="true" swliveconnect="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" wmode="opaque" width="860" height="229">
	</div>

<div id="mainContent">
