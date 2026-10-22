<?php if(isset($_SESSION['user_rank']) && $_SESSION['user_rank'] >= 3 && isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)){
	if(isset($_GET['site'])){
		$site = $_GET['site'];
	} else {
		$site = 1;
	}
	$entrys = 10;
	$start = $site * $entrys - $entrys;
	
	
	$memCmd = "SELECT * FROM staff_log INNER JOIN users ON user = ID WHERE user = '".esc($db, $_GET['id'])."' AND action NOT LIKE '%31|%' ORDER BY log_nr DESC LIMIT ".$start.", ".$entrys."";
	$memQry = mysqli_query($db, $memCmd);
	$nc = "SELECT * FROM users INNER JOIN server_1_players ON ID = playerID WHERE ID = '".esc($db, $_GET['id'])."'"; $nq = mysqli_query($db, $nc);
	$nar = mysqli_fetch_object($nq);
	
	if(isset($_POST['kick_out']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) && isset($_POST['notdrunk'])){
		$firedCmd = "UPDATE users SET banned = '2', acp_rank = '0' WHERE ID = '".esc($db, $_GET['id'])."'";
		$firedCmd = mysqli_query($db, $firedCmd);
		$fireLogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('4|".$nar->Name."', '".$_SESSION['uid']."', '".time()."', '".get_client_ip()."')";
		$fireLogQry = mysqli_query($db, $fireLogCmd);
		header("Location: index.php?p=staff");
	}
?>
<div style="float:left;">
<h2>Recent Activity from <?=$nar->Name?></h2>
<table style="width:640px;" cellpadding="0" cellspacing="0">
	<tr>
    	<th>Action</th>
        <th>Date</th>
        <th>IP</th>
	</tr>
    <?php $i=0; while($mem = mysqli_fetch_array($memQry)){ 
		$action = ex($mem['action']);
	?>
    <tr <?php if(is_int($i/2)){echo 'style="background-color: rgb(241, 241, 241);"';}?>>
    	<td style="width:300px;">
			<?php if($mem['action'] == '1|0'){ ?><div style="height:10px; line-height:10px;" class="alert-box success">ACP Login successfully</div><?php ;} ?>
            <?php if($mem['action'] == '1|1'){ ?><div style="height:10px; line-height:10px;" class="alert-box error">ACP Login failed</div><?php ;} ?>
            <?php if($action[0] == '2'){ ?><div style="height:10px; line-height:10px;" class="alert-box warning">Added Staffmember. ID: <a href="?p=search&uid=<?=$action[1]?>"><?=$action[1]?></a></div><?php ;} ?>
            <?php if($action[0] == '3'){ ?><div style="min-height:10px; line-height:10px;" class="alert-box notice">Added to UserId: <a href="?p=search&uid=<?=$action[2]?>"><?=$action[2]?></a><br><b><?=dot3($action['3'])?> <?=$add[$action[1]]?></b><br>Reason: <?=$action[4]?></div><?php ;} ?>
            <?php if($action[0] == '4'){ ?><div style="height:10px; line-height:10px;" class="alert-box warning">Delete Staffmember. Name: <?=$action[1]?></div><?php ;} ?>
            <?php if($action[0] == '5'){ ?><div style="min-height:10px; line-height:10px;" class="alert-box <?php if($action[4] == '0'){ echo 'warning';}else { echo 'error';}?>"><?php if($action[4] == '0'){echo 'Added to ';}else{echo 'Removed from ';} ?>UserID: <a href="?p=search&uid=<?=$action[1]?>"><?=$action[1]?></a><br> <?=$action[3]?>x <b><?=$items_array[$action['2']]?></b></div><?php ;} ?>
			<?php if($action[0] == '30'){?><div style="min-height:10px; line-height:10px;" class="alert-box warning"><a href="?p=search&uid=<?=$action['4']?>"><?=$action[2]?>'s</a> warning level has been setted to <?=$action[1]?><br>Reason: <?=$action[3]?><div><?php ;} ?>
		</td>
        <td><?=date("M, d.Y - H:i", $mem['date_time'])?></td>
        <td><?=$mem['user_ip']?></td>
    </tr>
    <?php $i++ ;} ?>
	<?php 
		  $ccmd = "SELECT * FROM staff_log INNER JOIN users ON user = ID WHERE user = '".esc($db, $_GET['id'])."'";
		  $cqry = mysqli_query($db, $ccmd);
		  $amount = mysqli_num_rows($cqry);
		  $pages = $amount / $entrys;
	?>
    <tr>
    	<td align="center" colspan="2">
		<?php 
			for($x=0; $x < $pages; $x++){
				$y = $x +1;
				if($site == $y){echo '<b style="margin-right:10px;">'.$y.'</b>';}
				else{echo '<a style="margin-right:10px;" href="index.php?p=staff_members&id='.$_GET['id'].'&site='.$y.'">'.$y.'</a>';}
				if(is_int($y/30)){echo '<br>';}
			}
		?>
		</td>
    </tr>
</table>
</div>
<div style="float:right; margin-right:10px;">
	<h2 style="margin-left:20px;">Delete this Staffmember</h2>
    <form method="post" action="index.php?p=staff_members&id=<?=$_GET['id']?>">
    	<input type="submit" class="button red" id="warning_kick" name="kick_out" value="Kick Out"><br>
        <input type="checkbox" style="margin-left:30px; margin-top:5px;" name="notdrunk"> Im not drunk, in Rage or something like this Shit.<br><p style="margin-left:30px;">If i'm abuse this function, i'll jump out of my Window</p>
    </form>
	<div class="div_warning">
    	<div style="margin-left:30px;" class="alert-box error"><span>error: </span>Take Care!</div>
    </div>
</div>
<div class="cl"></div>
<?php } else {echo $denied;}?>