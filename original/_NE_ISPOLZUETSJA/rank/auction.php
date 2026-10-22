<?php
require '../KERNEL-DOCMS/Init.php';
if(isset($_GET['crypt']) && $_GET['crypt']=="1c0ca69060d37677e1612b287ab02365"){
if(isset($_GET['period']) && $_GET['period']=="hour"){
    $auc->applyCronJobHour(); 
}elseif(isset($_GET['period']) && $_GET['period']=="day"){
	$auc->applyCronJobDaily(); 
}else{
    echo "Please specify the period of time";
}
}else{
Echo "Api does only accept internal call";
}

?>