
<?php

     require_once '/../../KERNEL-DOCMS/Init.php';
	   $mysqli = new mysqli('127.0.0.1', 'root', '', 'darkorbit', 3306);
     $mysqli->set_charset('utf8');

     $pid= $Users->DataRow['playerID'];
     $rand = rand(0,100);
    
    if ($Users->DataRow['uri'] >= 2000) {
        # code...
    
        if ($rand <= 10) {
            echo "LF4 x1";
              $mysqli->query("INSERT INTO `server_1_player_all_items`(`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES ('equipment_weapon_laser_lf-4', '1', '0', '$pid', '$pid')");
              $mysqli->query("UPDATE server_1_players SET uri = uri - '2000' WHERE playerID = ".$pid);
            ?><div id="Gimg"><img src="./do_img/global/items/equipment/weapon/laser/lf-4_63x63.png" width="63" height="63"></div><?php

        }
        elseif ($rand <= 30 && $rand > 10) {
            echo "LF3 x1";
              $mysqli->query("INSERT INTO `server_1_player_all_items`(`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES ('equipment_weapon_laser_lf-3', '1', '0', '$pid', '$pid')");
              $mysqli->query("UPDATE server_1_players SET uri = uri - '2000' WHERE playerID = ".$pid);
            ?><div id="Gimg"><img src="./do_img/global/items/equipment/weapon/laser/lf-3_63x63.png" width="63" height="63"></div><?php

        }
        elseif ($rand <= 50 && $rand > 30) {
            echo "RSB-75 x10000";
              $mysqli->query("UPDATE server_1_player_all_items SET Q = Q + '10000' WHERE playerID = '".$pid."' AND lootid = 'ammunition_laser_rsb-75'");
              $mysqli->query("UPDATE server_1_players SET uri = uri - '2000' WHERE playerID = ".$pid);

            ?><div id="Gimg"><img src="./do_img/global/items/ammunition/laser/rsb-75_63x63.png" width="63" height="63"></div><?php
        }
        elseif ($rand <= 75 && $rand > 50) {
            echo "BO2 x1";
              $mysqli->query("INSERT INTO `server_1_player_all_items`(`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES ('equipment_generator_shield_sg3n-b02', '1', '0', '$pid', '$pid')");
              $mysqli->query("UPDATE server_1_players SET uri = uri - '2000' WHERE playerID = ".$pid);

            ?><div id="Gimg"><img src="./do_img/global/items/equipment/generator/shield/sg3n-b02_63x63.png" width="63" height="63"></div><?php
            
         }
        elseif ($rand >= 75) {
             echo "UCB-100 x10000";
              $mysqli->query("UPDATE server_1_player_all_items SET Q = Q + '10000' WHERE playerID = '".$pid."' AND lootid = 'ammunition_laser_ucb-100'");
              $mysqli->query("UPDATE server_1_players SET uri = uri - '2000' WHERE playerID = ".$pid);         
            ?><div id="Gimg"><img src="./do_img/global/items/ammunition/laser/ucb-100_63x63.png" width="63" height="63"></div><?php

        }
    }
    else{
        echo "ПИЗДУЙ ФАРМИТЬ, БОМЖ, У ТЕБЯ НЕТ УРИКА";
    }
?>

<div id="gg_text_uri">
 <?php echo "Уридиум:".number_format($Users->DataRow['uri']); ?> 
</div>

<!-- 
LF4 = 10%  equipment_weapon_laser_lf-4
LF3 = 20%  equipment_weapon_laser_lf-3
RSB = 20%  ammunition_laser_rsb-75
BO2 = 25%  equipment_generator_shield_sg3n-b02
UCB = 25%  ammunition_laser_ucb-100
-->
