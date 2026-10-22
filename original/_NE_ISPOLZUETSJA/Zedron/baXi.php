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

require_once 'libraries/Class.WebWorker.php';
class baXi{
    
    protected $ip;
    protected $port;
    protected $count;
    protected $con;
    protected $init;
    protected static $db_info;
    public static $_socket;
    public $pool;    
    public static $workers;
    
    public function Build() {
        date_default_timezone_set('UTC');
        if ($this->init != TRUE):
            self::ccINFO();
        else:
            $this->init = TRUE;
        endif;
        $this->ip = "127.0.0.1";
        $this->port = 8080;
        $this->pool = new Pool(10, 'GameInstances', [new SafeLog()]);
    }
    
    public static function Output($msg, $type = NULL) {
        print_r(date("H\:i\:s") . " - [$type] :> $msg\n");
    }
    
    public function setMultiCall($packet){
        file_put_contents('log.txt', print_r($packet, true));
        print_r("multi");
    }
    private function multiCall($packet){
    }
    public function initialize() {
            $server = socket_create_listen($this->port);
            while(($client = socket_accept($server))){
                $this->pool->submit(new GameInt($client));
                $this->pool->collect(function(GameInt $task){
                    if($task->isComplete()!==FALSE):
                        return $task->isComplete();
                    endif;
                });
            }
    }
    
    
    private function ccINFO() {
        baXi::Output("\n   |----------------------------------------------|\n"
                . "   |              Zedron Servers                  |\n"
                . "   |----------------------------------------------|\n"
                . "   |            Created by Seven & NavigatoR LG                 |\n"
                . "   |----------------------------------------------|\n"
         ."\n".
         "Limit: 10 users \n");
    }

    
}

?>