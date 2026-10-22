<?php
	 $mysqli = new mysqli('127.0.0.1', 'root', '', 'darkorbit', 3306);
     $mysqli->set_charset('utf8');
     $ids = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
	 shuffle($ids);

	foreach (array_chunk($ids, 2) as $opponents) {
	    if (count($opponents) == 2) {  // check this in case you have odd numbers of ids
	        list($a, $b) = $opponents;
	        $mysqli->query("UPDATE `jpa` SET `war` = $b WHERE `id` = $a");
	        $mysqli->query("UPDATE `jpa` SET `war` = $a WHERE `id` = $b");
	    }
	}


?>
