<?php
class Server extends thread {
    
    public function __construct($socket, $IO){
                $this->IO = $IO;
		$this->socket = $socket;
		$this->start();
    }
    
    public function run(){
		$client = $this->socket;
                $this->ti = $this->getThreadId();
                Zedron::$_socket[$this->IO] = $client;
		if ($client) {
                    while(($chars = socket_read($client, 1024000))) {
                        Zedron::Output($chars, $this->IO);
                        self::PacketHandler($chars);
		    }
                }
                $this->notify();
    }
    
    public function SQLexe($sqlstring){
        $mysqli = mysqli_connect("localhost", "root", "", "darkorbit");
        mysqli_real_escape_string($mysqli, $sqlstring);
        $result = mysqli_query($mysqli, $sqlstring);
        if (!$result){
                printf("Error: %s\n", mysqli_error($mysqli));
            }
        if ($w = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $result->close();
            return $w;
        }
    }
    
    private function PacketHandler($packet) {
        if (stristr($packet, "<policy-file-request/>") > -1) {
            Zedron::Output($packet, $this->IO);
            Zedron::Send("<cross-domain-policy><allow-access-from domain='*' to-ports='*' /></cross-domain-policy>", $this->IO);
        } elseif (substr($packet, 0, 5) == "LOGIN") {
            self::uLogin($packet);
            $t = $this->IO -1;
            print_r(Zedron::$_thread[$this->IO]);
        } elseif (trim($packet)=="l") {
            if($user['premium']==1){
                sleep(5);
            }else{
                sleep(20);
            }
            Zedron::Output("is logging out", "Player: ");
        } elseif (stristr($packet, "SEL") > -1) {
            list($a, $b) = explode('|', $packet);
            Zedron::Send("0|N|" . $b . "||1|1|1|1|1", $this->IO);
        } elseif (substr($packet,0,1) ==1){
            list($a, $b, $c) = explode('|', $packet);
            $m = self::movement($a, $b, $c);        
            Zedron::Send("0|1|".$user['playerID']."|".$b."|".$c."|".$m, $this->IO);
	}else {
            
        }
    }
    
    private function uLogin($packet) {
        $s = explode("|", $packet);
        $w = self::SQLexe('SELECT * FROM server_1_players INNER JOIN users ON users.ID=server_1_players.userID WHERE server_1_players.tokenId=' . $s[2] . ' && server_1_players.playerID=' . $s[1] . '');
      if (!empty($w)){
            $e = self::SQLexe('SELECT tagName FROM `server_1_clan` WHERE clanID = '.$w['clanId'].'');
            if(!empty($e['tagName'])):
                $w['tag'] = $e['tagName'];
                else:
                $w['tag'] = "";
            endif;
            $j = self::SQLexe('SELECT ship_selected_model FROM server_1_player_hangar_general_ship WHERE playerID='.$w['playerID'].' LIMIT 1');
            $shi = $j['ship_selected_model'];
            if(strpos($shi, 'design')!==false):
                $f = self::SQLexe("SELECT * FROM ships_designs WHERE type='".$shi."' LIMIT 1");
            else:
                $f = self::SQLexe("SELECT * FROM ships WHERE type='".$shi."' LIMIT 1"); 
            endif;
            $w['Ship'] = $f['Id'];
            Zedron::$_thread[$this->IO] = $w;
//            self::addData($w);
//            self::init($w['playerID'], $w['mapId'], self::getData());
            Zedron::Output($w['Name'] . " has connected", $this->IO);
        } else {
            Zedron::Output("Invalid sessionID.", "Error");
        }
    }
    
}
?>