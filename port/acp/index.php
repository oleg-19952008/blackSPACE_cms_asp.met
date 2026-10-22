<?php
	session_name("gs_acp_do");
	session_start();
	date_default_timezone_set("Europe/Copenhagen");
	require("./models/global_config.php");
	$db = mysqli_connect(HOST, USER, PASSW, DBASE);
	mysqli_query($db, 'SET NAMES utf8');
	mysqli_query($db, 'SET CHARACTER SET utf8');
	require("./models/global_functions.php");
	$url_nonsplit = $_SERVER['REQUEST_URI'];
	$url_split = explode("/acp/", $url_nonsplit);
	$url_after = explode("&", $url_split[1]);
	$url = $url_after[0];
	if(isset($_POST['submit_login']) && !empty($_POST['upw']) && !empty($_POST['uid'])){
		$loginCmd = "SELECT ID, Name, pwHash, acp_rank FROM users WHERE Name = '".esc($db, $_POST['uid'])."'";
		$loginQry = mysqli_query($db, $loginCmd);
		$login = mysqli_fetch_array($loginQry);
		$cmd = "SELECT * FROM staff_log WHERE action = '1|1' AND date_time+900 > '".time()."' AND user = '".$login['ID']."'";
		$qry = mysqli_query($db, $cmd);
		if(mysqli_num_rows($qry)<4){
			if(decrypt($login['pwHash'])==$_POST['upw']){
				if($login['acp_rank']>0){
					$loginlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('1|0', '".$login['ID']."', '". time() ."', '".get_client_ip()."')";
					$loginlogQry = mysqli_query($db, $loginlogCmd);
					$_SESSION['username'] = $login['Name'];
					$_SESSION['user_rank'] = $login['acp_rank'];
					$_SESSION['uid'] = $login['ID'];
				} else {
					$error = "You dont have enough Permission to Login into the ACP.";	
				}
			} else {
				$loginlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('1|1', '".$login['ID']."', '". time() ."', '".get_client_ip()."')";
				$loginlogQry = mysqli_query($db, $loginlogCmd);
				$error = "Incorrect Password";
			}
		} else {
			$error = "Your Login is blocked for 15 minutes";
		}
	}
?>
<!DOCTYPE html>
<html lang="en" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
<head>
	<meta charset="utf-8" />
	<title>GameSolutions - ACP for Darkorbit</title>
	<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css' />
	
	<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<!--[if lt IE 9]>
		<script src="js/modernizr.custom.js"></script>
	<![endif]-->
	<script src="js/functions.js" type="text/javascript"></script>
	<script>
	</script>
</head>
<body>
	<div id="wrapper">
		<div class="shell">
			<div class="container">
				<header id="header">
					<h1 id="logo"><a href="#">GameSolutions ACP (c) GameSolutions</a></h1>
				</header>
				<nav id="navigation">
					<ul>
                    	<?php if(!isset($_SESSION['username'])){?><li class="active"><a href="#"><img src="css/images/login-icon.png" style="margin-top:15px; float:left; margin-right:5px;">Login</a></li><?php ;} ?>
                        <?php if(isset($_SESSION['username'])){ ?>
                        <li id="drop" style="cursor:pointer;"><a href="#"><img src="css/images/more-icon.png" style="margin-top:15px; float:left; margin-right:5px;"></a></li>
						<li <?php if($url == '' || $url == 'index.php'){echo 'class="active"';}?>><a href="index.php"><img src="css/images/home-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Home</a></li>
                        <li	<?php if($url == '?p=search' || $url == 'index.php?p=search'){echo 'class="active"';}?>><a href="?p=search"><img src="css/images/user-search-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Users</a></li>
						<li><a href="#"><img src="css/images/buglist-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Buglist</a></li>
						<li <?php if($url == '?p=staff' || $url == 'index.php?p=staff' || $url == 'index.php?p=staff_members'){echo 'class="active"';}?>><a href="?p=staff"><img src="css/images/staff-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Staff</a></li>
                        <li><a href="?p=chat"><img src="css/images/chat-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Game Chat</a></li>
                        <?php ;} ?>
					</ul>
				</nav>
                <style>
				</style>
				<div class="dropdown">
                	<p><a href="#" id="drop"><img src="css/images/donate-icon.png" style="margin-top:15px; float:left; margin-right:10px;">Donations</a></p>
                    <p <?php if($url == '?p=staff' || $url == 'index.php?p=voucher' || $url == 'index.php?p=voucher'){echo 'class="active"';}?>><a href="?p=voucher"><img src="css/images/voucher-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Voucher</a></p>
                    <p><a href="#"><img src="css/images/settings-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Settings</a></p>
                    <?php if($_SESSION['user_rank'] >= 4 || $_SESSION['uid'] == '4064'){echo '<p><a href="?p=coding"><img src="css/images/coding-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Coding Area</a></p>';} ?>
					<p><a href="?p=write_news"><img src="css/images/news-icon.png" style="margin-top:13px; float:left; margin-right:5px;">Create News</a></p>
					<p><a href="?p=logout"><img src="css/images/logout-icon.png" style="margin-top:15px; float:left; margin-right:10px;">Logout</a></p>
                </div>
    			<div class="main">
                <?php if(!isset($_SESSION['username'])){ ?>
					<div class="login_content">
                    <form method="post" action="./">
                    	<input type="text" placeholder="Username" class="login_id" name="uid"><br>
	               	    <input type="password" placeholder="Password" class="login_pw" name="upw"><br>
                        <input type="submit" class="button" value="Login" name="submit_login" >
                    </form>
                    </div>
                    <?php if(isset($_POST['submit_login']) && !isset($_SESSION['username'])){ ?>
                	<div class="alert-box error"><span>error: </span><?=$error?></div>
                	<?php ;} ?>
                <?php } else {
                    	$includeDir = ".".DIRECTORY_SEPARATOR."functions".DIRECTORY_SEPARATOR;
						$includenoexist = $includeDir."home.php";
						if(isset($_GET['p']) && !empty($_GET['p'])) {
							$pro = str_replace("\0", '', $_GET['p']);
							$includeFile = basename(realpath($includeDir.$pro.".php"));
							$includePath = $includeDir.$includeFile;
							if(!empty($includeFile) && file_exists($includePath)) {
								include($includePath);
							} else {
								include($includenoexist);
							}
						} else {
							include($includenoexist);
						}
				;} ?>
                </div>
				<div class="footer-bottom">
					<nav class="footer-nav">
						<ul>
							<li><a href="#">Home</a></li>
						</ul>
					</nav>
					<p class="copy">&copy; Copyright 2014 GameSolutions <span>|</span> <strong>Coded by <a target="_blank" href="http://www.elitepvpers.com/forum/members/5780782--yoshii-.html">.Yoshii™</a> & <a target="_blank" href="http://www.elitepvpers.com/forum/members/2877411--au.html">Seven & NavigatoR</a></strong> <span>|</span> In cooperation with <a target="_blank" href="http://www.DarkSpace.net/">DarkSpace</a></p>
					<div class="cl">&nbsp;</div>
				</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>