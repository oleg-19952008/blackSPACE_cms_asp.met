<?php
require_once 'Class.auction.php';
$auc = new auction();
$auc->applyCronJobDaily(); 
?>