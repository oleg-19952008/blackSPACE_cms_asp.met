<style>
.hatesme{background: url(css/images/session-icon.png) 12px 7px no-repeat, linear-gradient(to bottom, #f7f7f8 0%,#ffffff 100%);}
.hatesme:focus{background: url(css/images/session-icon.png) 12px 5px no-repeat, #FFF;}
</style>
<?php if(isset($_SESSION['username']) && $_SESSION['user_rank']>0){ 

if(isset($_POST['search']) && !empty($_POST['user']) || isset($_GET['uid'])){
	if(isset($_POST['search'])){
		
		if(filter_var(str_replace(" ", "",$_POST['user']), FILTER_VALIDATE_INT)){
			$sqlCmd = "SELECT * FROM users WHERE ID = '".esc($db, $_POST['user'])."'";
		} elseif(!is_numeric($_POST['user']) && !filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)){
			$sqlCmd = "SELECT * FROM users WHERE Name LIKE '%".esc($db, $_POST['user'])."%'";
		} elseif(!is_numeric($_POST['user']) && filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)){
			$sqlCmd = "SELECT * FROM users WHERE Email LIKE '%".esc($db, $_POST['user'])."%'";
		}
	}
	if(!isset($_POST['search']) && isset($_GET['uid']) && filter_var($_GET['uid'], FILTER_VALIDATE_INT)){
		$sqlCmd = "
SELECT u.ID, u.Name, u.Servers, u.banned, u.verified, u.Email, s.playerID, s.factionId, s.mapId, s.x, s.y, s.premium, s.rank, s.uri, s.credits, s.honor, s.tokenId
FROM users as u
INNER JOIN server_1_players as s
ON u.ID = s.playerID WHERE u.ID = '".esc($db, $_GET['uid'])."'";
	}
	$sqlQry = mysqli_query($db, $sqlCmd);
	if(mysqli_num_rows($sqlQry)>0){
		$res = mysqli_fetch_array($sqlQry);
	} else {
		$notfound = "This User doesn't exist";	
	}
	
	if(isset($_POST['save_user']) && !empty($_POST['staff_reason'])){
		$credits = str_replace(".", "", $_POST['user_credits']);
		$uri = str_replace(".", "", $_POST['user_uridium']);
		$honor = str_replace(".", "", $_POST['user_honor']);
		if(!empty($_POST['user_credits']) && filter_var($credits, FILTER_VALIDATE_INT)){
			$crcmd = "UPDATE server_1_players SET credits = (credits + '".$credits."') WHERE playerID = '".esc($db, $_POST['user_id'])."' LIMIT 1";
			$crQry = mysqli_query($db, $crcmd);
			if($_POST['user_id'] != $_SESSION['uid']){
				$crlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('3|1|".esc($db, $_POST['user_id'])."|".$credits."|".esc($db, $_POST['staff_reason'])."', '".$_SESSION['uid']."', '".time()."', '".$_SERVER['REMOTE_ADDR']."')";
				$crlogQry = mysqli_query($db, $crlogCmd);
			}
		}
		if(!empty($_POST['user_uridium']) && filter_var($uri, FILTER_VALIDATE_INT)){
			$crcmd = "UPDATE server_1_players SET uri = (uri + '".$uri."') WHERE playerID = '".esc($db, $_POST['user_id'])."' LIMIT 1";
			$crQry = mysqli_query($db, $crcmd);
			if($_POST['user_id'] != $_SESSION['uid']){
				$crlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('3|2|".esc($db, $_POST['user_id'])."|".$uri."|".esc($db, $_POST['staff_reason'])."', '".$_SESSION['uid']."', '".time()."', '".$_SERVER['REMOTE_ADDR']."')";
				$crlogQry = mysqli_query($db, $crlogCmd);
			}
		}
		if(!empty($_POST['user_honor']) && filter_var($honor, FILTER_VALIDATE_INT)){
			$hncmd = "UPDATE server_1_players SET honor = (honor + '".$honor."') WHERE playerID = '".esc($db, $_POST['user_id'])."' LIMIT 1";
			$hnQry = mysqli_query($db, $hncmd);
			if($_POST['user_id'] != $_SESSION['uid']){
				$hnlogCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('3|3|".esc($db, $_POST['user_id'])."|".$honor."|".esc($db, $_POST['staff_reason'])."', '".$_SESSION['uid']."', '".time()."', '".$_SERVER['REMOTE_ADDR']."')";
				$hnlogQry = mysqli_query($db, $hnlogCmd);			
			}
		}
	}
}
?>
<h2>Search for User</h2>
<form method="post" action="" style="position:relative; z-index:2000;">
	<input type="text" name="user" <?php if(isset($_POST['search'])){echo 'value="'.$_POST['user'].'"';}elseif(isset($_GET['uid'])){echo 'value="'.$_GET['uid'].'"';} ?> required placeholder="Username or UserID or E-Mail" class="login_id search_input"><input type="submit" value="Search" class="button" name="search" style="margin-left:10px;">
</form>
<?php if(isset($notfound)){echo '<div style="margin-right:35px;" class="alert-box error"><span>error: </span>'.$notfound.'</div>';} ?>

<?php if(isset($res) && $_GET['uid'] != '6640'){ ?>
	<?php if(isset($_POST['search']) && mysqli_num_rows($sqlQry)>1){ ?>
<div class="results"><h3>Results: <?=mysqli_num_rows($sqlQry)?></h3></div>
<table style="width:940px;" cellpadding="0" cellspacing="0">
	<tr>
    	<th>UserID</th>
        <th>Username</th>
        <th>Email</th>
	</tr>
    <?php $i=0; while($found = mysqli_fetch_array($sqlQry)){ ?>
    <tr <?php if(is_int($i/2)){echo 'style="background-color: rgb(241, 241, 241);"';}?>>
    	<td><?=$found['ID']?></td>
        <td><a href="index.php?p=search&uid=<?=$found['ID']?>"><?=$found['Name']?></a></td>
        <td><?=$found['Email']?></td>
    </tr>
    <?php $i++ ;} ?>
</table>
	<?php } elseif(isset($_POST['search']) && mysqli_num_rows($sqlQry) == 1) { header('location: index.php?p=search&uid='.$res['ID'].'');}?>
    <?php if(!isset($_POST['search']) && isset($_GET['uid']) && filter_var($_GET['uid'], FILTER_VALIDATE_INT)){ 
		$getmap_comp = $maptoname[$res['mapId']];
		$map_comp = explode("|", $getmap_comp);

		$lookCmd = "SELECT * FROM staff_log WHERE user = '".$_SESSION['uid']."' AND action LIKE '31|%|".$res['ID']."'";
		$lookQry = mysqli_query($db, $lookCmd);
		if(mysqli_num_rows($lookQry)==0){
			$lastCmd = "INSERT INTO staff_log (action, user, date_time, user_ip) VALUES ('31|".$res['Name']."|".$res['ID']."', '".$_SESSION['uid']."', '".time()."', '".get_client_ip()."')";
			$lastQry = mysqli_query($db, $lastCmd);
		} else {
			$lastCmd = "UPDATE staff_log SET date_time = '".time()."' WHERE action LIKE '31|%|".$res['ID']."' AND user = '".$_SESSION['uid']."'";
			$lastQry = mysqli_query($db, $lastCmd);
		}
	?>
		<?php if($res['banned'] == '1'){ ?><div style="position:absolute; z-index:1000; background:url(css/images/isbanned.png) 0 -50px; width:900px; height:620px; left:70px; top:0px;"></div><?php ;} ?>
    	<div class="results"><h3>Edit User: <?=$res['Name']?></h3>
        	<div id="search_submenu">
	            <a href="index.php?p=search_bann&uid=<?=$_GET['uid']?>"><p>Bannpanel</p></a>
                <a href="index.php?p=search_logs&uid=<?=$_GET['uid']?>"><p>Logs</p></a>
                <a href="index.php?p=search_items&uid=<?=$_GET['uid']?>"><p>Add Items</p></a>
                <a class="active" href="index.php?p=search&uid=<?=$_GET['uid']?>"><p>Generally</p></a>
        	</div>
        </div>
        <form method="post" action="index.php?p=search&uid=<?=$_GET['uid']?>">
        <table style="width:720px; float:left;" cellpadding="0" cellspacing="0">
            <tr>
                <th width="270px">Username</th>
                <td><input type="text" value="<?=$res['Name']?>" class="login_id" name="user_name" style="margin-bottom:0px;" readonly></td>
            </tr>
            <tr style="background-color: rgb(241, 241, 241);">
                <th>UserID</th>
                <td><input type="text" value="<?=$res['ID']?>" class="login_id id_user" name="user_id" style="margin-bottom:0px;" readonly></td>
            </tr>
			<?php if($_SESSION['user_rank'] >= 4){ ?>
			<tr>
                <th>SessionID</th>
                <td><input type="text" class="login_id hatesme" name="sad" style="margin-bottom:0px;" readonly value="<?=$res['tokenId']?>"></td>
            </tr>
			<?php ;} ?>
            <tr>
                <th width="270px">Email</th>
                <td><input type="text" value="<?=$res['Email']?>" class="login_id email" name="user_email" style="margin-bottom:0px;" readonly> <?php if($res['verified'] == '0'){echo '<img src="css/images/uncheck.png" style="margin-right:130px; float:right; margin-top:0px;">';}else{echo '<img src="css/images/check.png" style="margin-right:130px; float:right; margin-top:0px;">';}?></td>
            </tr>
            <tr style="background-color: rgb(241, 241, 241);">
                <th>Map Location</th>
                <td style="height:36px;"><img src="css/images/location-icon.png" style="float:left; margin-left:10px;"><img src="css/images/company/<?=$map_comp[0]?>.png" style="float:left; margin-left:10px; margin-top:3px; padding-right:15px;"><?=$map_comp[1]?>  [X=<?=$res['x']?> | Y=<?=$res['y']?>]</td>
            </tr>
            <tr style="height:36px;">
                <th width="270px">Game Faction</th>
                <td >
                	<label class="player_fraction" for="fraction_mmo"><input type="radio" id="fraction_mmo" value="1" class="mmo" name="user_fraction" <?php if($res['factionId'] == '1'){echo 'checked';} ?>/>MMO</label>
                    <label class="player_fraction" for="fraction_eic"><input type="radio" id="fraction_eic" value="2" class="eic" name="user_fraction" <?php if($res['factionId'] == '2'){echo 'checked';} ?>/>EIC</label>
                    <label class="player_fraction" for="fraction_vru"><input type="radio" id="fraction_vru" value="3" class="vru" name="user_fraction" <?php if($res['factionId'] == '3'){echo 'checked';} ?>/>VRU</label>
                </td>
            </tr>
            <tr style="background-color: rgb(241, 241, 241);">
                <th>Rank</th>
                <td><input type="text" class="login_id rank_<?=$res['rank']?>" name="user_rank" style="margin-bottom:0px;" readonly value="<?=$rankname[$res['rank']]?>"></td>
            </tr>
            <tr>
                <th>Credits</th>
                <td><input type="text" class="login_id credits" name="user_credits" style="margin-bottom:0px;" id="numbers1" placeholder="<?=dot3($res['credits'])?>"></td>
            </tr>
            <tr style="background-color: rgb(241, 241, 241);">
                <th>Uridium</th>
                <td><input type="text" class="login_id uridium" name="user_uridium" style="margin-bottom:0px;" id="numbers2" placeholder="<?=dot3($res['uri'])?>"></td>
            </tr>
            <tr>
                <th>Honor</th>
                <td><input type="text" class="login_id honor" name="user_honor" style="margin-bottom:0px;" id="numbers3" placeholder="<?=dot3($res['honor'])?>"></td>
            </tr>
			<?php if($_SESSION['user_rank'] >= 3){ ?>
            <tr>
            	<th>Why you have to change the informations?</th>
                <td><textarea style="width:270px; overflow:none; resize:none" name="staff_reason" required placeholder="Please enter a Reason..."></textarea></td>
            </tr>
            <tr>
            	<td colspan="2"><input style="margin-left:180px;" type="submit" class="button" value="Save" name="save_user"></td>
            </tr>
			<?php ;}?>
        </table>
        </form>
        <script type="text/javascript">
		var valueLength = 0;
		  function checkNumber(event) {
			  var value = this.value;
			  if(valueLength == value.length) return true;
			  valueLength = value.length;
			  value = value.replace(/\./g,"");
	 
			  var reverseArray = value.split("").reverse();
	 
			  var newString = "";
	 
			  for(var i=0; i < reverseArray.length; i++) {
				  if(i != 0 && i % 3 == 0) {
					  if(reverseArray[i] != ".")
					  newString += ".";
				  }
				  newString += reverseArray[i];
			  }
	 
			  this.value = newString.split("").reverse().join("");
		  }
		  window.onload = function() {
			document.getElementById("numbers1").onkeyup = checkNumber;
			document.getElementById("numbers2").onkeyup = checkNumber;
			document.getElementById("numbers3").onkeyup = checkNumber;
		  };
		</script>
        <?php if($res['premium'] >= date("Y-m-d H:i:s")){ ?><div style="float:right; width:200px; margin-right:30px; height:383px; background:url(css/images/company/<?=$res['factionId']?>_image_prem.png);"></div><?php ;} else { ?>
        <div style="float:right; width:200px; margin-right:30px; height:383px; background:url(css/images/company/<?=$res['factionId']?>_image.png);"></div>
        <?php ;} ?>
        <div class="cl"></div>
    <?php ;} ?>
<?php ;} ?>
<?php ;} ?>