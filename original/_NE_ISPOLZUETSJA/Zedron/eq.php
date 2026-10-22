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
set_time_limit(0);
/* * ******************************** */

class Client extends Thread {

    public function __construct($socket) {
        $this->client = $socket;
        $this->start();
    }

    public function setId($uid, $pid) {
        if (!empty(EQ::$users[$pid])) {
            return TRUE;
        } else {
            EQ::$users[$pid] = array($uid, $pid);
        }
    }

    public function run() {
        $client = $this->client;
        if ($this->client) {
            while (($chars = socket_read($this->client, 1024000))) {
                EQ::Output($chars, $this->client);
                self::PacketHandler($chars);
            }
        }
    }

    private function setEQblock($id) {
        $json = file_get_contents('deq.php');
        $obj = json_decode($json);
        $obj->$id = $id;
        if (!property_exists($obj, $id)) {
            unset($obj->$id);
        }
        file_put_contents('deq.php', json_encode($obj));
    }

    private function reEQblock($id) {
        $json = file_get_contents('deq.php');
        $obj = json_decode($json);
        if (property_exists($obj, $id)) {
            unset($obj->$id);
        }
        file_put_contents('deq.php', json_encode($obj));
    }

    private function resetEQblock() {
        file_put_contents('deq.php', '{"0":"0"}');
    }

    private function getEQblock($id) {
        $json = file_get_contents('deq.php');
        $obj = json_decode($json);
        if (property_exists($obj, $id)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function PacketHandler($packet) {
        $e = explode("|", $packet);
        if (isset($e[0]) && $e[0] == "init") {
            if (!self::getEQblock($e[1])) {
                self::Send(self::errorTrans("Equipment is disabled when you are ingame."));
            } else {
                self::setId($e[2], $e[1]);
                print_r(EQ::$users);
                exit;
                $jsn = base64_encode(json_encode(self::init()));
                self::Send($jsn);
                self::$instance = null;
            }
        } elseif (isset($e[0]) && $e[0] == "move") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "droneEquip") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "changeShipModel") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "clearConfig") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "sell") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "sellShip") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "sellDrone") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "unlockSlot") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "renamePet") {

            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "oln") {
            self::setEQblock($e[1]);
            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "lln") {
            self::reEQblock($e[1]);
            self::$instance = null;
        } elseif (isset($e[0]) && $e[0] == "lan") {
            self::resetEQblock();
            self::$instance = null;
        } else {
            self::Send(self::errorTrans("SHEILD is rebuilding Equipment"));
            self::$instance = null;
        }
        //
    }

    
    public function Send($packet) {
        print_r($packet);
        if (@stristr($packet, strlen($packet) - 1, 1) != chr(0)) {
            $packet = $packet . chr(0);
            if (!socket_write($this->client, $packet, strlen($packet))) {
                $this->selfDestruct = true;
            }
        }
    }
     public function errorTrans($message) {
        $jsn = json_decode('{"isError":1,"data":{"ret":0,"money":{"uridium":"","credits":""}},"error":{"message":"' . $message . '"}}');
//        $jsn->data->money->uridium = $this->money->uridium;
//        $jsn->data->money->credits = $this->money->credits;
        $jsn->data->money->uridium = 0;
        $jsn->data->money->credits = 0;
        return base64_encode(json_encode($jsn));
    }
}

class EQ {

    protected $ip;
    protected $port;
    protected $count;
    protected $con;
    protected $init;
    public static $users = array();
    public static $clients = array();

    public function Build() {
        date_default_timezone_set('UTC');
        if ($this->init != TRUE):
            self::ccINFO();
        else:
            $this->init = TRUE;
        endif;
        $this->ip = "127.0.0.1";
        $this->port = 9861;
    }

    public static function Output($msg, $type = NULL) {
        print_r(date("H\:i\:s") . " - [$type] :> $msg\n");
    }
    
    
    public function setMultiCall($packet) {
        file_put_contents('log.txt', print_r($packet, true));
        print_r("multi");
    }

    private function multiCall($packet) {
        
    }

    public function initialize() {
        $server = socket_create_listen($this->port);
        while (($client = socket_accept($server))) {
            $clients[] = new Client($client);
        }
    }

    private function ccINFO() {
        EQ::Output("\n   |----------------------------------------------|\n"
                . "   |              Zedron Servers                  |\n"
                . "   |----------------------------------------------|\n"
                . "   |            Created by Seven & NavigatoR LG                 |\n"
                . "   |----------------------------------------------|\n"
                . "\n" .
                "Limit: 10 users \n");
    }

}

?>