<?php

/*
 *  FOLLOW SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */

class Va {

    public static $instance;
    protected static $db_info;
    public static $_socket = array();
    public static $workers = array();

    public function __construct() {
        
    }
    
    public static function Output($msg, $type = NULL) {
        print_r(date("H\:i\:s") . " - [$type] :> $msg\n");
    }

    public static function Send($packet, $p) {
        if (@stristr($packet, strlen($packet) - 1, 1) != chr(0)) {
            $packet = $packet . chr(0);
            if(!empty($socket)){
                if (!socket_write(self::$_socket[$p], $packet, strlen($packet))) {
                 $this->selfDestruct = true;
                 } 
             }else{
                 if (!socket_write(self::$_socket[$p], $packet, strlen($packet))) {
                 $this->selfDestruct = true;
             }
             }
        }
    }

}

?>
