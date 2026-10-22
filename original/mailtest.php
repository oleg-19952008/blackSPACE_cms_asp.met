<?php
require './KERNEL-DOCMS/Init.php';
$Users->checkSession();

$emailbackendinfo = array('mailfrom'=> 'no-reply@DarkSpace.net', 'template'=>'confirmemail', 'subject' => 'Dark Space Email Confirmation');
$content = array('reason' => 'test script', 'username' => 'Santino', 'link' => 'http://127.0.0.1/#emailconfirmation', 'author' => 'Seven & NavigatoR | Dark Space', 'year'=>date('Y'));
$reciver = array('xkay@xkay.dk');

$unity->mailer($reciver, $emailbackendinfo, $content);
$unity->mailFrom();
$unity->setHeader();
$unity->templateUse($content);
echo $unity->sendMail(); */

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once './api/libs/IXR_Library.php';

class mailsender {
    private $call;
    protected $respons;
    
    function __construct() {
        $this->call = new IXR_Client('darkorbit.tv', '/DarkSpace/mail/index.php', 80);
        $this->call->debug = true;
    }
    
    function GetMethodList()
    {
        $this->call->query('system.listMethods');
        
        return $this->call->getResponse();
    }
    
    function mailSystem()
    {        
        $this->call->query('api.mail', array("test"));
        
        return $this->call->getResponse();
    }
    
}
$s = new mailsender();
$s->mailSystem(); */
?>