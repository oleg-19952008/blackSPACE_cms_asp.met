<?php
class Server extends Thread {
    
    public function __construct($socket, $IO){
                $this->IO = $IO;
		$this->socket = $socket;
		$this->start();
    }
    
    public function run(){
		$client = $this->socket;
                $this->ti = $this->getThreadId();
                Zedron::$_socket = $client;
		if ($client) {
                    while(($chars = socket_read($client, 1024000))) {
                        Zedron::Output($chars, $this->IO);
                        self::PacketHandler($chars);
		    }
                }
    }
    public function SendNew($packet) {
        if (@stristr($packet, strlen($packet) - 1, 1) != chr(0)) {
            $packet = $packet . chr(0);
            socket_write($this->socket, $packet, strlen($packet));
        }
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
        if(!empty(Zedron::$_thread[$this->IO])):
            $user = Zedron::$_thread[$this->IO];
        endif;
        if (stristr($packet, "<policy-file-request/>") > -1) {
            Zedron::Output($packet, $this->IO);
            Zedron::Send($this->IO, "<cross-domain-policy><allow-access-from domain='*' to-ports='*' /></cross-domain-policy>");
        } elseif (substr($packet, 0, 5) == "LOGIN") {
            self::uLogin($packet);
            $t = $this->IO -1;
        } elseif (trim($packet)=="l") {
            if($user['premium']==1){
                sleep(5);
            }else{
                sleep(20);
            }
            Zedron::Output("is logging out", "Player: ");
        } elseif (stristr($packet, "SEL") > -1) {
            list($a, $b) = explode('|', $packet);
            Zedron::Send($this->IO, "0|N|" . $b . "||1|1|1|1|1");
        } elseif (substr($packet,0,1) ==1){
            list($a, $b, $c) = explode('|', $packet);
            $m = self::movement($a, $b, $c);        
            Zedron::Send($this->IO, "0|1|".$user['playerID']."|".$b."|".$c."|".$m);
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
            self::setData($w);
            self::init($w['playerID'], $w['mapId'], self::getData());
            Zedron::Output($w['Name'] . " has connected", $this->IO);
        } else {
            Zedron::Output("Invalid sessionID.", "Error");
        }
    }
    
    protected function setData($data) {
        $this->data = $data;
    }

    protected function addData($data) {
        $this->data = array_merge($this->data, $data);
    }

    protected function getData() {
        return $this->data;
    }
    
    private function movement($a, $b, $c){
        return 1000;
    }
    
    public function init($playerID, $map, $args) {
            Zedron::$users[$this->IO] = new stdClass();
        foreach($args as $k => $v){
            Zedron::$users[$this->IO]->{$k} = $v;
        }
        $this->map = (int)$map;
        $this->pid = $playerID;
        Zedron::Send($this->IO, "0|A|SET|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|0|0|1|1|0|0|1|1|1|1");
        Zedron::Send($this->IO, "0|7|MINIMAP_SCALE,0|11");
        Zedron::Send($this->IO, "0|7|DISPLAY_PLAYER_NAMES|1");
        Zedron::Send($this->IO, "0|7|DISPLAY_CHAT|1");
        Zedron::Send($this->IO, "0|7|PLAY_MUSIC|0");
        Zedron::Send($this->IO, "0|7|PLAY_SFX|0");
        Zedron::Send($this->IO, "0|7|BAR_STATUS|23,0,24,0,25,1,26,0,27,0");
        Zedron::Send($this->IO, "0|7|WINDOW_SETTINGS,0|0,9,4,1,1,232,3,1,3,780,388,1,5,5,5,0,10,5,288,0,13,187,50,0,20,5,402,1,22,347,188,0,23,458,1,1,24,284,25,0");
        Zedron::Send($this->IO, "0|7|AUTO_REFINEMENT|0");
        Zedron::Send($this->IO, "0|7|QUICKSLOT_STOP_ATTACK|0");
        Zedron::Send($this->IO, "0|7|DOUBLECLICK_ATTACK|0");
        Zedron::Send($this->IO, "0|7|AUTO_START|0");
        Zedron::Send($this->IO, "0|7|DISPLAY_NOTIFICATIONS|0");
        Zedron::Send($this->IO, "0|7|SHOW_DRONES|0");
        Zedron::Send($this->IO, "0|7|DISPLAY_WINDOW_BACKGROUND|0");
        Zedron::Send($this->IO, "0|7|ALWAYS_DRAGGABLE_WINDOWS|0");
        Zedron::Send($this->IO, "0|7|PRELOAD_USER_SHIPS|0");
        Zedron::Send($this->IO, "0|7|QUALITY_PRESETTING|3");
        Zedron::Send($this->IO, "0|7|QUALITY_CUSTOMIZED|0");
        Zedron::Send($this->IO, "0|7|QUALITY_BACKGROUND|3");
        Zedron::Send($this->IO, "0|7|QUALITY_POIZONE|3");
        Zedron::Send($this->IO, "0|7|QUALITY_SHIP|3");
        Zedron::Send($this->IO, "0|7|QUALITY_ENGINE|3");
        Zedron::Send($this->IO, "0|7|QUALITY_COLLECTABLE|3");
        Zedron::Send($this->IO, "0|7|QUALITY_ATTACK|3");
        Zedron::Send($this->IO, "0|7|QUALITY_EFFECT|3");
        Zedron::Send($this->IO, "0|7|QUALITY_EXPLOSION|3");
        Zedron::Send($this->IO, "0|7|QUICKBAR_SLOT|-1,-1,-1,-1,-1,-1,-1,-1,-1,-1");
        Zedron::Send($this->IO, "0|7|SLOTMENU_POSITION|313,451");
        Zedron::Send($this->IO, "0|7|SLOTMENU_ORDER|0");
        Zedron::Send($this->IO, "RDY|I|" . self::getID() . "|" . self::getUName() . "|" . self::getShip() . "|333|333|333|333|333|100|100|" . self::getX() . "|" . self::getY() . "|1|".self::getFaction()."|0|120000|1500|0|1|1|0|1|1|1|1|".self::getRank()."|".self::getTag()."|7|1|0");
        Zedron::sendAll("f|C|" . self::getID() . "|" . self::getShip() . "|15|" . self::getUName() . "|".self::getTag()."|" . self::getX() . "|" . self::getY() . "|".self::getFaction()."|0|".self::getRank()."|0|0|7||0|0");      
        Zedron::Send($this->IO, "0|B|111|111|111|111|111|111");
        Zedron::Send($this->IO, "0|7|HS");
        Zedron::Send($this->IO, "0|S|CFG|2");
        Zedron::Send($this->IO, "0|RL|R|1111|111|1110");
        Zedron::Send($this->IO, "0|RL|S|2|7|5");
        Zedron::Send($this->IO, "0|A|JV|0");
        Zedron::Send($this->IO, "0|A|BK|200");
        Zedron::Send($this->IO, "0|A|ITM|0|0|0|0|3|0|0|1|1|0|0|0|1|0|0|0|0");
        Zedron::Send($this->IO, "0|TX|S|1|15|0|1|15|0|1|15|0|1|15|0|1|15|0");
        Zedron::Send($this->IO, "0|3|100|100|100|100|0|0|0|0|100|100|100|0|0|0|0|0");
        Zedron::Send($this->IO, "0|A|CPU|C|99");
        Zedron::Send($this->IO, "0|POI|RDY");
        $this->LoadUsers();
    }

    public function getUName() {
        return Zedron::$users[$this->IO]->Name;
    }

    public function move() {
        $this->moving = 1;
        while ($this->moving == 1) {
            
        }
    }

    public function getID() {
        return Zedron::$users[$this->IO]->playerID;
    }

    public function getShip() {
        return Zedron::$users[$this->IO]->Ship;
    }

    public function getX() {
        return Zedron::$users[$this->IO]->x;
    }

    public function getY() {
        return Zedron::$users[$this->IO]->y;
    }

    public function getTag() {
        return Zedron::$users[$this->IO]->tag;
    }
    public function getFaction() {
        return Zedron::$users[$this->IO]->factionId;
    }
     public function getMap() {
        return Zedron::$users[$this->IO]->mapId;
    }

    public function setXY($x, $y) {
        
    }
    
    public function getRank() {
        return Zedron::$users[$this->IO]->rank;
    }
    
    public function LoadUsers() {
        foreach (Zedron::$users as $k => $user) {
            if ($user->mapId == Zedron::$users[$this->IO]->mapId)
                Zedron::Send($this->IO, "f|C|" .$user->playerID. "|".$user->Ship."|15|".$user->Name."|".$user->tag."|".$user->x."|".$user->y."|".$user->factionId."|0|".$user->rank."|0|0|7|".$user->mapId."|0|0");
        }
    }
}
?>