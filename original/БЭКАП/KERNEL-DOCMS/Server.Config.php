<?php
## URL
$Config['URL'] = [
	'Default' => [
		'Require.www' => false, // www.example.com
		'SSL.enabled' => false, // https://
		'Server' => '127.0.0.1',
		'Lang' => 'en_US', // GLOBAL.
		// added to set a var for media
		//'media' => 'localhost' // all copyrighted stuff HERE
	],
	'Other' => [
		//'example.com' => ['Require.www' => false, 'SSL.enabled' => false, 'Lang' => 'es_ES', 'MySQL' => ['host' => '127.0.0.1','user' => 'root','pass' => '','dbname' => 'cmsdb']]
	],
	'devPrivateServer' => '127.0.0.1' // servidor privado de desarrollo
];

## SQL Server Data
$Config['MySQL'] = [
	'host' => '127.0.0.1',
	'user' => 'root',
	'pass' => 'SDFffas1663276safsdf7673VN345oiopiuopu34534',
	'dbname' => 'darkorbit'
];
// DO not touch the code below this text if you do not know what you're doing.
           define( "DB_DSN", "mysql:host=".$Config['MySQL']['host'].";dbname=".$Config['MySQL']['dbname'].""); //this constant will be use as our connectionstring/dsn
define( "DB_USERNAME", $Config['MySQL']["user"] ); //username of the database
define( "DB_PASSWORD", $Config['MySQL']["pass"] ); //password of the database
define( "CLS_PATH", "class" ); //the class path of our project
?>