<?php

$x=  $_GET['x'] ;
$y= $_GET['y'] ;
$user_id = $_GET['u'];


$mysqli = new mysqli('127.0.0.1', 'root', '', 'darkorbit', 3306);
$mysqli->set_charset('utf8');


@mysql_connect('localhost', 'root', '') or die (mysql_error ());
 mysql_select_db("darkorbit") or die(mysql_error());
 $strSQL = "SELECT * FROM scr WHERE u_id = '$user_id'";
 $rs = mysql_query($strSQL);
 $row = mysql_fetch_array($rs);



if($row['u_id'] == $user_id){
	$mysqli->query('UPDATE scr SET screen_x = '.$x.' WHERE u_id = '.$user_id);
    $mysqli->query('UPDATE scr SET screen_y = '.$y.' WHERE u_id = '.$user_id);
    echo "if";
}
else{
	 $mysqli->query("INSERT INTO `scr` ( `u_id`, `screen_x`, `screen_y`) VALUES ('$user_id', '$x', '$y')");
	echo "else";
}


 ?>