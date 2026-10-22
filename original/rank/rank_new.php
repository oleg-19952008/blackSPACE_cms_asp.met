<?php
require_once 'Class.rank.php';
$rnk = new rank();
$rnk->getAllPlayers(null, 1);
print_r("MMO Complete \n");
$rnk->getAllPlayers(null, 2);
print_r("EIC Complete \n");
$rnk->getAllPlayers(null, 3);
print_r("VRU Complete \n");
$rnk->setOverAll(); 
print_r("ALL Complete \n");

/*
if(isset($_GET['id'])){
    $all = $rnk->getAllPlayers($_GET['id']);
}elseif(isset($_GET['fi']) && $_GET['fi']==1){
    $fi = $_GET['fi'];
    $all = $rnk->getAllPlayers(null, $fi);
    header('location: /cron/rank_new?fi=2&crypt=1c0ca69060d37677e1612b287ab02365');
}elseif(isset($_GET['fi']) && $_GET['fi']==2){
    $fi = $_GET['fi'];
    $all = $rnk->getAllPlayers(null, $fi);
    header('location: /cron/rank_new?fi=3&crypt=1c0ca69060d37677e1612b287ab02365');
}elseif(isset($_GET['fi']) && $_GET['fi']==3){
    $fi = $_GET['fi'];
    $all = $rnk->getAllPlayers(null, $fi);
    header('location: /cron/rank_new?o=1&crypt=1c0ca69060d37677e1612b287ab02365');
}elseif(isset($_GET['o'])){
  $rnk->setOverAll();  
}else{

}*/
 

header('Location: http://127.0.0.1/indexInternal.es.php?action=internalStart');

?>

 