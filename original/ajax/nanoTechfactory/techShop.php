<?php
require_once '../../KERNEL-DOCMS/Init.php';
if(isset($_GET['secureLoader'])){
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
if(!IS_AJAX) {die('Restricted');}
 
$factory->updateStatus($_GET['userid'], $_GET['Slot']);

}
?>

