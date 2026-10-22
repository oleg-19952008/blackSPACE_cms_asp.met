<?php
	 $mysqli = new mysqli('127.0.0.1', 'root', '', 'darkorbit', 3306);
     $mysqli->set_charset('utf8');
     $ids = [1, 2, 3, 4, 5];
     // $ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];
	 shuffle($ids);
	 $map = '1';
	foreach (array_chunk($ids, 2) as $opponents) {
	    if (count($opponents) == 2) {  // check this in case you have odd numbers of ids
	        list($a, $b) = $opponents;
	        $mysqli->query("UPDATE `jpa` SET `war` = $b , map = $map WHERE `id` = $a");
	        $mysqli->query("UPDATE `jpa` SET `war` = $a , map = $map WHERE `id` = $b");
	        $map++;
	    }
	}


?>
