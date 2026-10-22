<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<!doctype html>
<html>
<head>

</head>
<body>	
<?php
$chatsessionId = GenerateRandom(10, true, false);
$db->query('UPDATE server_1_players SET tokenId = ' . $chatsessionId . ' WHERE playerID = ' . esc($db, $_SESSION['uid']));
	$chatid = "bu%250%".$_SESSION['username']."@".$chatsessionId."@en@noclan@2.3.3@-1@";
	
	$host = "95.211.214.74";
	$port = 9338;
	set_time_limit(5);
	$sock = socket_create(AF_INET, SOCK_STREAM, 0);
	if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
	{
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		 
		die("Couldn't create socket: [$errorcode] $errormsg \n");
	}
 
	echo "Socket created <br />";
	
	if(!socket_connect($sock , $host , $port))
	{
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		 
		die("Could not connect: [$errorcode] $errormsg \n");
	}
	 
	echo "Connection established \n <br />";
	
	if( ! socket_send ( $sock , $chatid , strlen($chatid) , 0))
	{
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		 
		die("Could not send data: [$errorcode] $errormsg \n");
	}

echo "Login Successfully send \n <br />";

	print_r($chatid);
	
	/* if(socket_recv ( $sock , $buf , 2045 , MSG_WAITALL ) === FALSE)
	{
		$errorcode = socket_last_error();
		$errormsg = socket_strerror($errorcode);
		 
		die("Could not receive data: [$errorcode] $errormsg \n");
	}
	echo $buf; */
 
?>
</body>
</html>