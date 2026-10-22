<?php
require 'eq.php';
$game = new EQ();
$game->Build();
echo $game->initialize();

//while(true){
//	echo $game->idle();
//}
?>