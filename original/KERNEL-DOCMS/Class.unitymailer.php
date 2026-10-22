<?php
/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
/* * ******************************** */
ini_set('display_errors', '1');  /**/
error_reporting(E_ALL);          /**/
/* * ******************************** */
// DB Class IMPORTANT!
require_once 'libs/IXR_Library.php';
class unitymailer {
    /* Everything the script needs to keep it on track */

    private $call;
    protected $respons;
    
    function __construct() {
        $this->call = new IXR_Client('darkorbit.tv', '/DarkSpace/mail/index.php', 80);
        $this->call->debug = false;
    }
    
    function GetMethodList()
    {
        $this->call->query('system.listMethods');
        
        return $this->call->getResponse();
    }
    
    function mailSystem($content)
    {        
        $this->call->query('api.mail', $content);
        return $this->call->getResponse();
    }

}

?>