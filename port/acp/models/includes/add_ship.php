	<!-- All Ships -->
	
    
    <div class="in_item">
    	<h3>Add a Ship</h3>
    	<hr style="float:left; width:100%; margin-bottom:1px;">
		<?php  
            $shipCmd = "SELECT * FROM server_shop_items WHERE C = 'ship' AND type = '22' AND autoId NOT IN (9) ORDER BY ucd ASC, CAST(buy AS SIGNED)";
            $shipQry = mysqli_query($db, $shipCmd);
            while($ships = mysqli_fetch_array($shipQry)){
        ?>
        	<img style="float:left;" src="css/images/items/ships/<?=strtolower($ships['name'])?><?php if(in_array($ships['name'],$specship)){echo '-'.$searchItem->factionId;} ?>_63x63.png" height="42px"><p style="margin-top:10px; float:left; width:120px; margin-left:10px;"><?=$ships['name']?></p>
            <hr style="float:left; width:100%; margin-top:1px; margin-bottom:1px;">
		<?php ;} ?>
        <div class="cl"></div>
    </div>
    
    
    
    
    <!-- WHich Ships the user have -->
    
    <div class="in_item">
    	<h3>User Ships</h3>
        <hr style="float:left; width:100%; margin-bottom:1px;">
        <?php
            $userShipCmd = "SELECT * FROM server_1_player_all_items WHERE playerID = '".esc($db, $_GET['uid'])."' AND lootId LIKE 'ship_%' AND lootId NOT LIKE '%design%'";
			$userShipQry = mysqli_query($db, $userShipCmd);
			while($userships = mysqli_fetch_array($userShipQry)){
		 ?>
         	<img style="float:left;" src="css/images/items/ships/<?=strtolower($items_array[$userships['lootid']])?><?php if(in_array($items_array[$userships['lootid']],$specship)){echo '-'.$searchItem->factionId;} ?>_63x63.png" height="42px"><p style="margin-top:10px; float:left; width:120px; margin-left:10px;"><?=$items_array[$userships['lootid']]?></p>
        	<hr style="float:left; width:100%; margin-top:1px; margin-bottom:1px;">
         <?php ;} ?>
         <div class="cl"></div>
    </div>
    
    
    
    
    
    
    <!-- LOG What was given -->
    <div class="in_item">
    	<h3>Recently added Ships</h3>
        <hr style="float:left; width:100%; margin-bottom:1px;">
        <?php
            $logShipCmd = "SELECT * FROM staff_log ORDER BY date_time DESC";
			$logShipQry = mysqli_query($db, $logShipCmd);
			while($logShip = mysqli_fetch_array($logShipQry)){
		 	$show = ex($logShip['action']);
			if($show[0] == '5'){$loot = explode("_", $show[2]);}
			if($show[0] == '5' && $show[1] == $_GET['uid'] && $loot[0] == 'ship' && !isset($loot[2])){
				if($show[4] == '0'){
					$what = "Added ";
				} else {
					$what = "<font color='#990000'>Removed</font> ";
				}
				echo $what.'<b>'.$items_array[$show[2]].'</b> - ('.date("M, d.Y - H:i", $logShip['date_time']).')<br>';
			}
         ;} ?>
         <?php if($_SESSION['uid'] == $_GET['uid']){echo 'No Logs needed, Staff Account';};?>
         <div class="cl"></div>
    </div>
    <div class="cl"></div>