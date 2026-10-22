<?php
date_default_timezone_set("Europe/Copenhagen");
define('IP', str_replace('::1', '127.0.0.1', $_SERVER['REMOTE_ADDR']));
define('KERNEL', dirname(__FILE__) . DIRECTORY_SEPARATOR);
$maintenance = FALSE;
define('MHH', FALSE);

require_once 'Class.db.php';
$db = new DB();
$db::getInstance();
$GLOBALS['DB'] = $db::$instance;

if($maintenance==TRUE){
echo "SERVER MAINTENANCE! Back at 23:40 minutes";
echo "<script type='text/javascript'>	(function () { var done = false;	var script = document.createElement('script');	script.async = true;	script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) {	if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {	var w = new PCWidget({ c: '29d56b56-c70f-45e4-a050-cdffe45597c8', f: true });	done = true; }	};	})();	</script>";
exit;
}
ini_set('default_charset', 'UTF-8');
ini_set('expose_php', 0);
ini_set('session.name', 'DO-BPP1');
ini_set('session.gc_probability', 10);
ini_set('session.gc_divisor', 100);
ini_set('session.cookie_httponly', 1);
ini_set('session.gc_maxlifetime', 60*60*24);
ini_set('zlib_output_compression', 'On');

$_SERVER['REQUEST_URI'] = str_replace('.php', '', strtolower($_SERVER['REQUEST_URI']));
if(strstr($_SERVER['REQUEST_URI'], '?')):
	define ('URI', explode('?', $_SERVER['REQUEST_URI'])[0]);
else:
	define ('URI', $_SERVER['REQUEST_URI']);
endif;

@session_start();

require_once(KERNEL .  "/Server.Config.php");

if(!empty($_SERVER['SERVER_NAME'])):
	$_Server = str_replace("www.", "", $_SERVER['SERVER_NAME']);

	if(!empty($Config['URL']["devPrivateServer"]) && ($Config['URL']["devPrivateServer"] === $_SERVER['SERVER_NAME'])):
		$Config['Lang'] = $Config['URL']['Default']['Lang'];
		define("SERVER", "http://" . $_SERVER['SERVER_NAME']);
		define("HOST", $_SERVER['SERVER_NAME']);
		define("sSERVER", "http://" . $_SERVER['SERVER_NAME']);
	elseif(isset($Config['URL']['Other'][$_Server])):
		$Config['MySQL'] = $Config['URL']['Other'][$_Server]['MySQL'];
		$Config['Lang'] = $Config['URL']['Other'][$_Server]['Lang'];
		define("SERVER", ($Config['URL']['Other'][$_Server]["Require.www"]) ? "http://www." . $_Server : "http://" . $_Server);
		define("HOST", ($Config['URL']['Other'][$_Server]["Require.www"]) ? "www." . $_Server : $_Server);
		define("sSERVER", ($Config['URL']['Other'][$_Server]["SSL.enabled"]) ? "https://" . HOST : "http://" . HOST);
	elseif(!empty($Config['URL']["Default"]["Server"])):
		$Config['Lang'] = $Config['URL']['Default']['Lang'];
		define("SERVER", ($Config["URL"]["Default"]["Require.www"]) ? "http://www." . $Config['URL']["Default"]["Server"] : "http://" . $Config['URL']["Default"]["Server"]);
		define("HOST", ($Config["URL"]["Default"]["Require.www"]) ? "www." . $Config['URL']["Default"]["Server"] : $Config['URL']["Default"]["Server"]);
		define("sSERVER", ($Config["URL"]["Default"]["SSL.enabled"]) ? "https://" . HOST : "http://" . HOST);
	else:
		echo "You don�t have access.";
		exit;
	endif;
else:
	exit;
endif;

$MySQLi = new mysqli($Config['MySQL']["host"], $Config['MySQL']["user"], $Config['MySQL']["pass"], $Config['MySQL']["dbname"]);

if ($MySQLi->connect_error) {
    die('Error de Conexi�n MySQLi (' . $MySQLi->connect_errno . ') '
            . $mysqli->connect_error);
}

$_mysqliCharacter = $MySQLi->character_set_name();

		
require_once 'Class.Core.php';
$Core = new Core();
require_once 'Class.Users.php';
$Users = new Users();
require_once 'Class.Encryption.php';
$Encryption = new Encryption("5eqD0fpzf9JzaKWP");
require_once 'Class.GalaxyGate.php';
$GalaxyGate = new GalaxyGate();
require_once 'Class.inventory.php';
$inventory = new inventory();
require_once 'Class.reg.php';
$reg = new register();
require_once 'Class.shop.php';
$shop = new shop();
require_once 'Class.base.php';
$base = new base();
require_once 'Class.clan.php';
$clan = new clan();
require_once 'Class.rank.php';
$rnk = new rank();
require_once 'Class.auction.php';
$auc = new auction();
require_once 'Class.log.php';
$log = new log();
require_once 'Class.voucher.php';
$vouch = new voucher();
require_once 'Class.unity.php';
$unity = new unity();
require_once 'Class.factory.php';
$factory = new factory();
require_once 'Class.unitymailer.php';
$mailer = new unitymailer();
require_once 'Class.Hangar.php';
$HangarC = new Hangar();
require_once 'Class.Skylab.php';
$Skylab = new Skylab();
require_once 'Class.dailybonus.php';
require_once 'Class.news.php';
//....

// AntiHTML & SQL Injection
$_POST = str_replace(['<', '>', '\'', '\'', '\\'], ['&lt;', '&gt;', '&quot;', '&#39;', '&#92;'], $_POST);
$_GET = str_replace(['<', '>', '\'', '\'', '\\'], ['&lt;', '&gt;', '&quot;', '&#39;', '&#92;'], $_GET);

DEFINE('FILES', KERNEL . 'Files/' . DIRECTORY_SEPARATOR . $Config['Lang'] . DIRECTORY_SEPARATOR);
DEFINE('GLOBALS', FILES . '/GLOBAL/');
DEFINE('DynHost', '127.0.0.1');

?>