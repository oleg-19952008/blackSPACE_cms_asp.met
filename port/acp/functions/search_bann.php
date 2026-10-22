<?php if(isset($_SESSION['username']) && $_SESSION['user_rank']>0){ 
	$searchItemCmd = "SELECT u.ID, u.Name, s.playerID, s.factionId, s.playerID
FROM users as u
INNER JOIN server_1_players as s
ON u.ID = s.playerID WHERE u.ID = '".esc($db, $_GET['uid'])."'";
	$searchItemQry = mysqli_query($db, $searchItemCmd);
		$searchItemQry = mysqli_query($db, $searchItemCmd);
	if(mysqli_num_rows($searchItemQry)>0){
		$searchItem = mysqli_fetch_object($searchItemQry);
	} else {
		$notfound = "This User doesn't exist";	
	}
	
	
	$warninglvlCmd = "SELECT * FROM users WHERE ID = '".esc($db, $_GET['uid'])."'";
	$warninglvlQry = mysqli_query($db, $warninglvlCmd);
	$warninglvl = mysqli_fetch_object($warninglvlQry);
	
	if(isset($_POST['set_warninglevel']) && !empty($_POST['reason'])){
		$warnCmd = "UPDATE users SET warning_level = (warning_level+1) WHERE ID = '".esc($db, $_GET['uid'])."'";
		$warnQry = mysqli_query($db, $warnCmd);
		
		$calc[0] = "/100*25";
		$calc[1] = "/100*35";
		$calc[2] = "/100*50";
		$exp_calc[0] = "/100*10";
		$exp_calc[1] = "/100*25";
		$exp_calc[2] = "/100*40";
		$banntime[0] = date("Y-m-d H:i:s",time()+86400);
		$banntime[1] = date("Y-m-d H:i:s",time()+604800);
		if($warninglvl->warning_level == 0){
			$punishCmd = "UPDATE server_1_players SET uri = (uri - (uri ".$calc[0].")), credits = (credits - (credits ".$calc[0].")), honor = (honor - (honor ".$calc[0].")),exp = (exp - (exp ".$exp_calc[0].")) WHERE playerID = '".esc($db, $_GET['uid'])."'";
			$punishlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('30|1|".$searchItem->Name."|".esc($db, $_POST['reason'])."', '".$_SESSION['uid']."', '".time()."', '".get_client_ip()."')";
		}
		if($warninglvl->warning_level == 1){
			$punishCmd = "UPDATE server_1_players SET uri = (uri - (uri ".$calc[1].")), credits = (credits - (credits ".$calc[1].")), honor = (honor - (honor ".$calc[1].")),exp = (exp - (exp ".$exp_calc[1].")) WHERE playerID = '".esc($db, $_GET['uid'])."'";
			$punbanCmd = "UPDATE users SET banned_until = '".$banntime[0]."' WHERE ID = '".esc($db, $_GET['uid'])."'";
			$punishlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('30|2|".$searchItem->Name."|".esc($db, $_POST['reason'])."|".esc($db, $_GET['uid'])."', '".$_SESSION['uid']."', '".time()."', '".get_client_ip()."')";
		}
		if($warninglvl->warning_level == 2){
			$punishCmd = "UPDATE server_1_players SET uri = (uri - (uri ".$calc[2].")), credits = (credits - (credits ".$calc[2].")), honor = (honor - (honor ".$calc[2].")), exp = (exp - (exp ".$exp_calc[2].")) WHERE playerID = '".esc($db, $_GET['uid'])."'";
			$punbanCmd = "UPDATE users SET banned_until = '".$banntime[1]."' WHERE ID = '".esc($db, $_GET['uid'])."'";
			$punishlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('30|3|".$searchItem->Name."|".esc($db, $_POST['reason'])."|".esc($db, $_GET['uid'])."', '".$_SESSION['uid']."', '".time()."', '".get_client_ip()."')";
		}
		if($warninglvl->warning_level == 3){
			$punbanCmd = "UPDATE users SET banned = '1' WHERE ID = '".esc($db, $_GET['uid'])."'";
			$punishlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('30|4|".$searchItem->Name."|".esc($db, $_POST['reason'])."|".esc($db, $_GET['uid'])."', '".$_SESSION['uid']."', '".time()."', '".get_client_ip()."')";
		}
		$punishQry = mysqli_query($db, $punishCmd);
		$punishlogqry = mysqli_query($db, $punishlogCmd);
		if(isset($punbanCmd)){
			$punbanQry = mysqli_query($db, $punbanCmd);
		}
		
		header('Location: ?p=search_bann&uid='.$_GET['uid'].'');

	}
?>

<h2>Search for User</h2>
<form method="post" action="index.php?p=search">
	<input type="text" name="user" <?php if(isset($_POST['search'])){echo 'value="'.$_POST['user'].'"';}elseif(isset($_GET['uid'])){echo 'value="'.$_GET['uid'].'"';} ?> required placeholder="Username or UserID or E-Mail" class="login_id search_input"><input type="submit" value="Search" class="button" name="search" style="margin-left:10px;">
</form>
<?php if(isset($notfound)){echo '<div style="margin-right:35px;" class="alert-box error"><span>error: </span>'.$notfound.'</div>';} ?>

<?php if(isset($searchItem)){ ?>
<div class="results"><h3>Logs from User: <?=$searchItem->Name?></h3>
	<div id="search_submenu">
		<a class="active" href="index.php?p=search_bann&uid=<?=$_GET['uid']?>"><p>Bannpanel</p></a>
        <a href="index.php?p=search_logs&uid=<?=$_GET['uid']?>"><p>Logs</p></a>
        <a href="index.php?p=search_items&uid=<?=$_GET['uid']?>"><p>Add Items</p></a>
        <a href="index.php?p=search&uid=<?=$_GET['uid']?>"><p>Generally</p></a>
	</div>
</div>
	<?php foreach(range(1,4) as $level){ ?>
	<div style="width:152px; height:152px; float:left; color:#DDD; margin-right:20px; text-align:center; line-height:150px; font-size:100px; margin-left:55px; margin-top:30px; background:url(css/images/level_0.png);
		<?php 
			if($warninglvl->warning_level == 0){echo '';}
			if($warninglvl->warning_level >= 1 && $level == 1){echo 'background:url(css/images/level_1.png);';}
			if($warninglvl->warning_level >= 2 && $level == 2){echo 'background:url(css/images/level_2.png);';}
			if($warninglvl->warning_level >= 3 && $level == 3){echo 'background:url(css/images/level_3.png);';}
			if($warninglvl->warning_level >= 4 && $level == 4){echo 'background:url(css/images/level_4.png);';}
		?>
	"><?=$level?></div>
	<?php ;} ?>
	
	<p style="width:200px; margin-left:75px; float:left;">-25% of his Credits<br>-25% of his Uridiuim<br>-25% of his Honor<br>-10% of his EXP</p>
	<p style="width:200px; margin-left:25px; float:left;">-35% of his Credits<br>-35% of his Uridiuim<br>-35% of his Honor<br>-25% of his EXP<br>24 Hours Ban</p>
	<p style="width:150px; margin-left:30px; float:left;">-50% of his Credits<br>-50% of his Uridiuim<br>-50% of his Honor<br>-40% of his EXP<br>7 Days Ban</p>
	<p style="width:200px; margin-left:85px; float:left;">Permanently Ban</p>
	
	<div style="float:left; width:950px; margin-top:50px; text-align:center;">
		<form method="post" action="">
			<?php if($warninglvl->warning_level <4){ ?>
				<?php if($warninglvl->warning_level < 2 && $_SESSION['user_rank'] < 3){ ?>
				<textarea name="reason" required placeholder="What have the User done?" style="width:235px; overflow:none; resize:none;"></textarea><br>
				<input type="submit" class="button" value="Set Player to Warning Level <?=$warninglvl->warning_level+1;?>" name="set_warninglevel">
				<?php ;} ?>
				<?php if($_SESSION['user_rank'] >= 3){ ?>
					<textarea name="reason" required placeholder="What have the User done?" style="width:235px; overflow:none; resize:none;"></textarea><br>
					<input type="submit" class="button" value="Set Player to Warning Level <?=$warninglvl->warning_level+1;?>" name="set_warninglevel">
				<?php ;} ?>
			<?php ;} else { echo '<img src="css/images/banned.gif">'; } ?>
		</form>
	</div>
<div class="cl"></div>
<?php ;}?>
<?php } else { echo $denied;} ?>