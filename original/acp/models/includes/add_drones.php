<div class="in_item">
    	<h3>Add a Drone</h3>
    	<hr style="float:left; width:100%; margin-bottom:1px;">
		<?php  
            $droneCmd = "sELECT * FROM server_shop_items WHERE C = 'drone' AND type = '24' OR type = '23' AND lootId NOT LIKE '%pet%' ORDER BY ucd ASC, CAST(buy AS SIGNED)";
            $droneQry = mysqli_query($db, $droneCmd);
            while($drone = mysqli_fetch_array($droneQry)){
        ?>
        	<img style="float:left;" src="css/images/items/drones/<?=str_replace(" ", "_", strtolower($drone['name']))?>-1_63x63.png" height="42px"><p style="margin-top:10px; float:left; width:120px; margin-left:10px;"><?=$drone['name']?></p>
            <form method="post" style="float:left; margin-top:10px; margin-left:0px;">
            	<input type="submit" name="add" value="" style="background:url(css/images/add_16.png); width:19px; height:19px;">
            	<input type="hidden" name="add_id" value="<?=$drone['autoId']?>" readonly>
                <input type="hidden" readonly name="add_move" value="1">
                <input type="hidden" readonly name="type" value="drone">
            </form>
        	<hr style="float:left; width:100%; margin-top:1px; margin-bottom:1px;">
		<?php ;} ?>
        <div class="cl"></div>
    </div>
    
    
    <div class="in_item">
    	<h3>User Drones</h3>
        <hr style="float:left; width:100%; margin-bottom:1px;">
        <?php
            $userdroneCmd = "SELECT * FROM server_1_player_all_items WHERE playerID = '".esc($db, $_GET['uid'])."' AND lootId LIKE '%drone%'";
			$userdroneQry = mysqli_query($db, $userdroneCmd);
			while($userdrone = mysqli_fetch_array($userdroneQry)){
		 ?>
         	<img style="float:left;" src="css/images/items/drones/<?=str_replace(" ", "_", strtolower($items_array[$userdrone['lootid']]))?>-1_63x63.png" height="42px"><p style="margin-top:10px; float:left; width:120px; margin-left:10px;"><?=$items_array[$userdrone['lootid']]?></p>
            <form method="post" style="margin-top:10px; float:left; margin-left:0px;">
            	<input type="submit" style="background:url(css/images/remove_16.png); width:19px; height:19px;" value="" name="remove_item">
                <input type="hidden" readonly value="<?=$userdrone['id']?>" name="id_re">
                <input type="hidden" readonly value="<?=$userdrone['lootid']?>" name="loot_re">
                <input type="hidden" readonly value="<?=$userdrone['Q']?>" name="q_re">
            </form>
        	<hr style="float:left; width:100%; margin-top:1px; margin-bottom:1px;">
         <?php ;} ?>
         <div class="cl"></div>
    </div>
    <div class="in_item">
    	<h3>Recently added Drones</h3>
        <hr style="float:left; width:100%; margin-bottom:1px;">
        <?php
            $logDroneCmd = "SELECT * FROM staff_log ORDER BY date_time DESC";
			$logDroneQry = mysqli_query($db, $logDroneCmd);
			while($logDrone = mysqli_fetch_array($logDroneQry)){
		 	$showd = ex($logDrone['action']);
			if($showd[0] == '5'){$lootd = explode("_", $showd[2]);}
			if($showd[0] == '5' && $showd[1] == $_GET['uid'] && $lootd[0] == 'drone'){
				if($showd[4] == '0'){
					$whatd = "Added ";
				} else {
					$whatd = "<font color='#990000'>Removed</font> ";
				}
				echo $whatd.'<b>'.$items_array[$showd[2]].'</b> - ('.date("M, d.Y - H:i", $logDrone['date_time']).')<br>';
			}
         ;} ?>
         <?php if($_SESSION['uid'] == $_GET['uid']){echo 'No Logs needed, Staff Account';};?>
         <div class="cl"></div>
    </div>
   	<div class="cl"></div>