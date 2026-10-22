<?php
if(isset($_GET['action']) && !empty($_GET['action'])){
if($_GET['action']=="portal.redirectToBoard"){
header('Location: http://forum.127.0.0.1');
exit;
}else{
exit;
}


}
?>
