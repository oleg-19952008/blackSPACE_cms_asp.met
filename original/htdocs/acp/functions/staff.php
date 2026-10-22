<?php if(isset($_SESSION['user_rank']) && $_SESSION['user_rank'] >= 3){
	$staffmemberCmd = "SELECT * FROM users INNER JOIN server_1_players ON users.ID = server_1_players.playerID WHERE users.acp_rank > 0 AND users.banned = '0' OR server_1_players.rank = '21' ORDER by acp_rank DESC";
	$staffmemberQry = mysqli_query($db, $staffmemberCmd);
		
	if(isset($_POST['staff_add']) && !empty($_POST['staff_member'])){
		$staffconCmd = "SELECT * FROM users WHERE ID = '".esc($db, $_POST['staff_member'])."'"; $staffconQry = mysqli_query($db, $staffconCmd);
		if(mysqli_num_rows($staffconQry)>0){
			$sqlCmd = "UPDATE users SET acp_rank = '".esc($db, $_POST['staff_rank'])."' WHERE ID = '".esc($db, $_POST['staff_member'])."'";
			$sqlQry = mysqli_query($db, $sqlCmd);
			$rank21Cmd = "UPDATE server_1_players SET rank = '21' WHERE playerID = '".esc($db, $_POST['staff_member'])."' LIMIT 1";
			$rank21Qry = mysqli_query($db, $rank21Cmd);
			$slogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('2|".esc($db, $_POST['staff_member'])."', '".$_SESSION['uid']."', '".time()."', '".$_SERVER['REMOTE_ADDR']."')";
			$slogQry = mysqli_query($db, $slogCmd);
			$error = '<div style="margin-right:35px;" class="alert-box success"><span>Success: </span>Added Staffmember successful</div>';
			echo '<meta http-equiv="refresh" content="2; url=?p=staff">';
		} else {
			$error = '<div style="margin-right:35px;" class="alert-box error"><span>error: </span>User dont exist</div>';
		}
	}
?>
<h2 style="float:left;">Control your Staff members</h2>
<div style="float:right; width:270px; z-index:2; position:relative">
<h2>Add a new Staffmember</h2>
<form method="post">
	<input name="staff_member" type="text" class="login_id id_user" placeholder="UserID" style="margin-bottom:3px;">
    <select style="width:241px; height:32px; padding-left:15px;" name="staff_rank">
    	<?php foreach($staffrank as $key => $rankname){ ?>
        	<?php if($_SESSION['user_rank'] >= $key){ ?><option value="<?=$key?>"><?=$rankname?></option><?php ;} ?>
        <?php ;} ?>
    </select>
    <input type="submit" class="button" value="Add" name="staff_add">
</form>
<?php if(isset($error)){echo $error ;} ?>
</div>
<table style="width:540px;" cellpadding="0" cellspacing="0">
	<tr>
    	<th>UserID</th>
        <th>Username</th>
        <th>Last Online</th>
	</tr>
    <?php $i=0; while($staff = mysqli_fetch_array($staffmemberQry)){ ?>
    <tr <?php if(is_int($i/2)){echo 'style="background-color: rgb(241, 241, 241);"';}?>>
    	<td><?=$staff['ID']?></td>
        <td>[<?=$staffrank[$staff['acp_rank']]?>] <a href="index.php?p=staff_members&id=<?=$staff['ID']?>"><?=$staff['Name']?></a></td>
        <td></td>
    </tr>
    <?php $i++ ;} ?>
</table>
<div class="cl"></div>
<?php } else {echo $denied;}?>