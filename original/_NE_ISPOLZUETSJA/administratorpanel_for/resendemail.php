<?php

require '../KERNEL-DOCMS/Init.php';
if(isset($_GET['id'])){
if(isset($_GET['email'])){
$verificationcaode = urlencode($Encryption->encrypt('{"userid":' . $_GET['id'] . ',"email":"' . $_GET['email'] . '"}'));
$mailer->mailSystem(array('header' => array('mailfrom' => 'no-reply@DarkSpace.net', 'template' => 'confirmemail', 'subject' => 'Dark Spaces Email Confirmation'), 'content' => array('username' => $_GET['id'], 'link' => 'http://DarkSpace.net/emailconfirmation/?s=' . $verificationcaode, 'reasonforemail' => 'Email Verification', 'author' => 'Best Regards <br /> Dark Spaces Staff Team', 'year' => date('Y')), 'recivers' => array($_GET['email'])));
echo "Email resended";
}else{
	echo "remember Email";
}
}else{
echo "remember id";
}
?>