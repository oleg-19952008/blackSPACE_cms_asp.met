
<?php

     require_once '/../../KERNEL-DOCMS/Init.php';
	 $mysqli = new mysqli('127.0.0.1', 'root', '', 'darkorbit', 3306);
     $mysqli->set_charset('utf8');
     $pnick = $Users->DataRow['Name'];
     $pid= $Users->DataRow['playerID'];
	 $jackpot = $mysqli->query("SELECT `jackpot` FROM `server_1_players` WHERE `userID` = '$pid'");

	 $uid = $mysqli->query("SELECT `id` FROM `jpa` ORDER BY `id` DESC LIMIT 1") ;
	 while ($rew = $uid->fetch_assoc()) {
    	$uuid= $rew['id'] + 1;
		}
	 


    while ($row = $jackpot->fetch_assoc()) {
			$row_jackpot = (float)$row['jackpot'];
			if ($row_jackpot  < 2000.00) {
				$lacks = 2000.00 - $row_jackpot;
				echo "<h2><span class='red'>Для участия не хватает: ".$lacks."</span></h2>";
			}
			else{
				echo "<h2><span class='green'>Вы уcпешно зарегистрировались на участие!<br> Ваш уникальный id:".$uuid." </span></h2>";
              	$mysqli->query("INSERT INTO `jpa`(`user_id`, `nickname`) VALUES ('$pid', '$pnick')");
                $mysqli->query("UPDATE server_1_players SET jackpot = jackpot - '2000.00' WHERE playerID = ".$pid);
              	?><div id="Gimg"><img src="./do_img/global/popups/icon_success.png" width="63" height="63"></div><?php
			}
		}


              // $mysqli->query("INSERT INTO `server_1_player_all_items`(`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES ('equipment_weapon_laser_lf-4', '1', '0', '$pid', '$pid')");
              // $mysqli->query("UPDATE server_1_players SET uri = uri - '2000' WHERE playerID = ".$pid);


?>
