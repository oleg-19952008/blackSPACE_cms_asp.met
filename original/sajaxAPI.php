<?php
if(isset($_POST['rs']) && $_POST['rs']=="searchUser"){
require './KERNEL-DOCMS/Init.php';
echo "+:var res = ".$clan->clanVoid($_POST['rsargs'][0])."; res;";
}else{
    
}
?>