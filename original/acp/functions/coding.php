<?php

	$oldammo = "SELECT * FROM server_1_player_all_items INNER JOIN users ON server_1_player_all_items.playerID = users.ID WHERE lootId LIKE  '%ammu%' AND playerID > 4556 ORDER by playerID ";
	$oldammoqry = mysqli_query($db, $oldammo);

while($ammo = mysqli_fetch_array($oldammoqry)){
	$replace = array("ammunition", "rocket", "laser", "_", "-", "mine", "special", "ammo", "launcher");
	$replaceto = array("","","","","","","","","");
	$real = str_replace($replace, $replaceto, $ammo['lootid']);
	echo $real.'<br>';
	
	$select = "SELECT * FROm server_1_player_ammunation WHERE playerID = '".$ammo['playerID']."'";
	$selectqry = mysqli_query($db, $select);
	
	if(mysqli_num_rows($selectqry)>0){
		$update = "UPDATE server_1_player_ammunation SET ".$real." = '".$ammo['Q']."' WHERE playerID = '".$ammo['playerID']."'";
		$qry = mysqli_query($db, $update);
	} else {
		$insert = "INSERT INTO server_1_player_ammunation (playerID) VALUES ('".$ammo['playerID']."')";
		$iqry = mysqli_query($db, $insert);
	}
}
?>