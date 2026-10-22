<?php

/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 *  Original Idea by Cryz35
 */
/* * ******************************** */
/* Out comment lines in this area   */
ini_set('display_errors', '1');  
error_reporting(E_ALL);          
/* * ******************************** */
set_time_limit (0); 
/* * ******************************** */
require_once './libraries/Class.Server.php';
class Zedron extends thread{
    
    protected $ip;
    protected $port;
    protected $count;
    protected $con;
    protected $init;
    protected static $db_info;
    public static $_socket;
    public static $_thread = array();    
    public static $users = array();
    
    public function __construct() {
        date_default_timezone_set('UTC');
        if ($this->init != TRUE):
            self::ccINFO();
        else:
            $this->init = TRUE;
        endif;
        $this->ip = "127.0.0.1";
        $this->port = 8080;
    }
    
    public static function Output($msg, $type = NULL) {
        print_r(date("H\:i\:s") . " - [$type] :> $msg\n");
    }
    
    public static function sendAll($packet){
         if (@stristr($packet, strlen($packet) - 1, 1) != chr(0)) {
            $packet = $packet . chr(0);
            file_put_contents('log.txt', print_r(self::$_thread , true));
            foreach(self::$_thread as $k => $v){
                    socket_write(self::$_socket, $packet, strlen($packet));
           }
        }
    }
    public static function Send($p,$packet) {
        if (@stristr($packet, strlen($packet) - 1, 1) != chr(0)) {
            $packet = $packet . chr(0);
            if(!empty($socket)){
                if (!socket_write(self::$_socket, $packet, strlen($packet))) {
                 $this->selfDestruct = true;
                 } 
             }else{
                 if (!socket_write(self::$_socket, $packet, strlen($packet))) {
                 $this->selfDestruct = true;
             }
             }
        }
    }
    
     public function initialize() {
            $server = socket_create_listen($this->port);
            $i = 0;
            while(($client = socket_accept($server))){
                array_push(self::$_thread ,  new Server($client, $i));
            $i++;
            }
    }
    
    
    private function ccINFO() {
        Zedron::Output("\n   |----------------------------------------------|\n"
                . "   |              Zedron Servers                  |\n"
                . "   |----------------------------------------------|\n"
                . "   |            Created by Seven & NavigatoR LG                 |\n"
                . "   |----------------------------------------------|\n"
         ."\n".
         "Limit: 10 users \n");
    }

    
}

?>