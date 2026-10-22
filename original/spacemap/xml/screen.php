<?php
 require "../../KERNEL-DOCMS/Init.php";
 $naviID = $Users->DataRow['playerID'];

	mysql_connect('localhost', 'root', '') or die (mysql_error ());
	mysql_select_db("darkorbit") or die(mysql_error());
	$strSQL = "SELECT * FROM scr WHERE u_id = '$naviID'";
	$rs = mysql_query($strSQL);
	$row = mysql_fetch_array($rs);
?>