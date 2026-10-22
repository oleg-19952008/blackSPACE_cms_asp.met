<?php
/*//////////////////////////////////////////////////////////////////////*/
/*/DO NOT CHANGE ANYTHING BELOW, THIS IS PRIVATE PROPERTY OF WEBSTAR.PW/*/
/*//////////////////////////////////////////////////////////////////////*/
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'lib/IXR_Library.php';
class Gateway{

    private $call;
    
    function __construct() {
        $this->call = new IXR_Client('DarkSpace.net', '/api/index.php', 80);
        $this->call->debug = false;
    }
    function GetMethodList()
    {
        $this->call->query('system.listMethods');
        
        return $this->call->getResponse();
    }
    function sendPayResult($args){
         $this->call->query('api.oce', array("cryptKeyingc25vd3lhZG1pbg0K", $args));
        
        return $this->call->getResponse();
    }
    
}
?>