<?php if(isset($_SESSION['username']) && $_SESSION['user_rank']>=3){ 
	$searchItemCmd = "SELECT u.ID, u.Name, s.playerID, s.factionId, s.playerID
FROM users as u
INNER JOIN server_1_players as s
ON u.ID = s.playerID WHERE u.ID = '".esc($db, $_GET['uid'])."'";
	$searchItemQry = mysqli_query($db, $searchItemCmd);
	if(mysqli_num_rows($searchItemQry)>0){
		$searchItem = mysqli_fetch_object($searchItemQry);
	} else {
		$notfound = "This User doesn't exist";	
	}
	
	$specship = array(
		"Spearhead",
		"Citadel",
		"Aegis"
	);
?>


<h2>Search for User</h2>
<form method="post" action="index.php?p=search">
	<input type="text" name="user" <?php if(isset($_POST['search'])){echo 'value="'.$_POST['user'].'"';}elseif(isset($_GET['uid'])){echo 'value="'.$_GET['uid'].'"';} ?> required placeholder="Username or UserID or E-Mail" class="login_id search_input"><input type="submit" value="Search" class="button" name="search" style="margin-left:10px;">
</form>
<?php if(isset($notfound)){echo '<div style="margin-right:35px;" class="alert-box error"><span>error: </span>'.$notfound.'</div>';} ?>

<?php if(isset($searchItem)){ ?>
<div class="results"><h3>Edit User: <?=$searchItem->Name?></h3>
	<div id="search_submenu">
		<a href="index.php?p=search_logs&uid=<?=$_GET['uid']?>"><p>Warn this Player</p></a>
        <a href="index.php?p=search_logs&uid=<?=$_GET['uid']?>"><p>Logs</p></a>
        <a class="active" href="index.php?p=search_items&uid=<?=$_GET['uid']?>"><p>Add Items</p></a>
        <a href="index.php?p=search&uid=<?=$_GET['uid']?>"><p>Generally</p></a>
	</div>
</div>
<div class="item_title" id="1">Ships</div>
<div class="item_show" id="jsitem1">
	<?php include('models/includes/add_ship.php'); ?>
</div>


<div class="item_title" id="2">Drones</div>
<div class="item_show" id="jsitem2">
	<?php include('models/includes/add_drones.php'); ?>
</div>
<div class="cl"></div>
<?php ;} ?>
<?php } else { echo $denied;} ?>