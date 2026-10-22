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
?>

<h2>Search for User</h2>
<form method="post" action="index.php?p=search">
	<input type="text" name="user" <?php if(isset($_POST['search'])){echo 'value="'.$_POST['user'].'"';}elseif(isset($_GET['uid'])){echo 'value="'.$_GET['uid'].'"';} ?> required placeholder="Username or UserID or E-Mail" class="login_id search_input"><input type="submit" value="Search" class="button" name="search" style="margin-left:10px;">
</form>
<?php if(isset($notfound)){echo '<div style="margin-right:35px;" class="alert-box error"><span>error: </span>'.$notfound.'</div>';} ?>

<?php if(isset($searchItem)){ ?>
<div class="results"><h3>Logs from User: <?=$searchItem->Name?></h3>
<div id="search_submenu">
		<a href="index.php?p=search_bann&uid=<?=$_GET['uid']?>"><p>Bannpanel</p></a>
        <a class="active" href="index.php?p=search_logs&uid=<?=$_GET['uid']?>"><p>Logs</p></a>
        <a href="index.php?p=search_items&uid=<?=$_GET['uid']?>"><p>Add Items</p></a>
        <a href="index.php?p=search&uid=<?=$_GET['uid']?>"><p>Generally</p></a>
	</div>
</div>
<div id="log_sub">
    <a class="active" href="" style="margin-left:12px;"><p>Credits</p></a>
    <a href="" style="margin-left:12px;"><p>Uridium</p></a>
    <a href="" style="margin-left:12px;"><p>Auctions</p></a>
    <a href="" style="margin-left:12px;"><p>Donations</p></a>
</div>


	<?php// include('models/includes/log_credits.php'); ?>
	
	<?php// include('models/includes/log_uri.php'); ?>
<div class="cl"></div>
<?php ;} ?>
<?php } else { echo $denied;} ?>