<?php
class GameInt extends Stackable{

    public function __construct($client) {
        $this->client = $client;
    }

    public function run() {
        $this->worker->logger->log("%s executing in Thread #%lu", __CLASS__, $this->worker->getThreadId());
        if ($this->client) {
            while (($chars = socket_read($this->client, 1024000))) {
                BaXi::Output($chars, $this->worker->getThreadId());
                self::PacketHandler($chars);
            }
        }
    }

    public function isComplete() {
        return $this->complete;
    }
    protected $complete = FALSE;

    public function Send($packet) {
        if (@stristr($packet, strlen($packet) - 1, 1) != chr(0)) {
            $packet = $packet . chr(0);
            if (!socket_write($this->client, $packet, strlen($packet))) {
                $this->selfDestruct = true;
            }
        }
    }

    public function SQLexe($sqlstring) {
        $mysqli = mysqli_connect("localhost", "root", "", "darkorbit");
        mysqli_real_escape_string($mysqli, $sqlstring);
        $result = mysqli_query($mysqli, $sqlstring);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($mysqli));
        }
        if ($w = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $result->close();
            return $w;
        }
    }

    private function PacketHandler($packet) {
        if (stristr($packet, "<policy-file-request/>") > -1) {
            self::Send("<cross-domain-policy><allow-access-from domain='*' to-ports='*' /></cross-domain-policy>");
            $this->complete = true;
        } elseif (substr($packet, 0, 5) == "LOGIN") {
            self::uLogin($packet);
        } elseif (trim($packet) == "l") {
            if ($user['premium'] == 1) {
                sleep(5);
            } else {
                sleep(20);
            }
            baXi::Output("is logging out", "Player: ");
        } elseif (stristr($packet, "SEL") > -1) {
            list($a, $b) = explode('|', $packet);
            self::Send("0|N|" . $b . "||1|1|1|1|1");
        } elseif (substr($packet, 0, 1) == 1) {
            list($a, $b, $c) = explode('|', $packet);
            $m = self::movement($a, $b, $c);
            self::Send("0|1|" . $this->worker->user['playerID'] . "|" . $b . "|" . $c . "|" . $m);
        } else {
            
        }
    }

    private function uLogin($packet) {
        $s = explode("|", $packet);
        $w = self::SQLexe('SELECT * FROM server_1_players INNER JOIN users ON users.ID=server_1_players.userID WHERE server_1_players.tokenId=' . $s[2] . ' && server_1_players.playerID=' . $s[1] . '');
        if (!empty($w)) {
            $e = self::SQLexe('SELECT tagName FROM `server_1_clan` WHERE clanID = ' . $w['clanId'] . '');
            if (!empty($e['tagName'])):
                $w['tag'] = $e['tagName'];
            else:
                $w['tag'] = "";
            endif;
            $j = self::SQLexe('SELECT ship_selected_model FROM server_1_player_hangar_general_ship WHERE playerID=' . $w['playerID'] . ' LIMIT 1');
            $shi = $j['ship_selected_model'];
            if (strpos($shi, 'design') !== false):
                $f = self::SQLexe("SELECT * FROM ships_designs WHERE type='" . $shi . "' LIMIT 1");
            else:
                $f = self::SQLexe("SELECT * FROM ships WHERE type='" . $shi . "' LIMIT 1");
            endif;
            $w['Ship'] = $f['Id'];
            self::init($w['playerID'], $w['mapId'], $w);
            baXi::Output($w['Name'] . " has connected", $this->worker->getThreadId());
        } else {
            baXi::Output("Invalid sessionID.", "Error");
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

    private function movement($a, $b, $c) {
        return 500;
    }

    public function init($playerID, $map, $args) {
        $this->worker->toUser($args);
        $this->map = (int) $map;
        $this->pid = $playerID;
        self::Send("0|A|SET|1|1|1|1|1|1|1|1|1|1|1|1|1|1|1|0|0|1|1|0|0|1|1|1|1");
        self::Send("0|7|MINIMAP_SCALE,0|11");
        self::Send("0|7|DISPLAY_PLAYER_NAMES|1");
        self::Send("0|7|DISPLAY_CHAT|1");
        self::Send("0|7|PLAY_MUSIC|0");
        self::Send("0|7|PLAY_SFX|0");
        self::Send("0|7|BAR_STATUS|23,0,24,0,25,1,26,0,27,0");
        self::Send("0|7|WINDOW_SETTINGS,0|0,9,4,1,1,232,3,1,3,780,388,1,5,5,5,0,10,5,288,0,13,187,50,0,20,5,402,1,22,347,188,0,23,458,1,1,24,284,25,0");
        self::Send("0|7|AUTO_REFINEMENT|0");
        self::Send("0|7|QUICKSLOT_STOP_ATTACK|0");
        self::Send("0|7|DOUBLECLICK_ATTACK|0");
        self::Send("0|7|AUTO_START|0");
        self::Send("0|7|DISPLAY_NOTIFICATIONS|0");
        self::Send("0|7|SHOW_DRONES|0");
        self::Send("0|7|DISPLAY_WINDOW_BACKGROUND|0");
        self::Send("0|7|ALWAYS_DRAGGABLE_WINDOWS|0");
        self::Send("0|7|PRELOAD_USER_SHIPS|0");
        self::Send("0|7|QUALITY_PRESETTING|3");
        self::Send("0|7|QUALITY_CUSTOMIZED|0");
        self::Send("0|7|QUALITY_BACKGROUND|3");
        self::Send("0|7|QUALITY_POIZONE|3");
        self::Send("0|7|QUALITY_SHIP|3");
        self::Send("0|7|QUALITY_ENGINE|3");
        self::Send("0|7|QUALITY_COLLECTABLE|3");
        self::Send("0|7|QUALITY_ATTACK|3");
        self::Send("0|7|QUALITY_EFFECT|3");
        self::Send("0|7|QUALITY_EXPLOSION|3");
        self::Send("0|7|QUICKBAR_SLOT|-1,-1,-1,-1,-1,-1,-1,-1,-1,-1");
        self::Send("0|7|SLOTMENU_POSITION|313,451");
        self::Send("0|7|SLOTMENU_ORDER|0");
        self::Send("RDY|I|" . self::getID() . "|" . self::getUName() . "|" . self::getShip() . "|333|333|333|333|333|100|100|" . self::getX() . "|" . self::getY() . "|1|" . self::getFaction() . "|0|120000|1500|0|1|1|0|1|1|1|1|" . self::getRank() . "|" . self::getTag() . "|7|1|0");
        self::sendToAll("f|C|" . self::getID() . "|" . self::getShip() . "|15|" . self::getUName() . "|" . self::getTag() . "|" . self::getX() . "|" . self::getY() . "|" . self::getFaction() . "|0|" . self::getRank() . "|0|0|7||0|0");
        self::Send("0|B|111|111|111|111|111|111");
        self::Send("0|7|HS");
        self::Send("0|S|CFG|2");
        self::Send("0|RL|R|1111|111|1110");
        self::Send("0|RL|S|2|7|5");
        self::Send("0|A|JV|0");
        self::Send("0|A|BK|200");
        self::Send("0|A|ITM|0|0|0|0|3|0|0|1|1|0|0|0|1|0|0|0|0");
        self::Send("0|TX|S|1|15|0|1|15|0|1|15|0|1|15|0|1|15|0");
        self::Send("0|3|100|100|100|100|0|0|0|0|100|100|100|0|0|0|0|0");
        self::Send("0|A|CPU|C|99");
        self::Send("0|POI|RDY");
        $this->LoadUsers();
    }

    public function getUName() {
        return $this->worker->user['Name'];
    }

    public function move() {
        $this->moving = 1;
        while ($this->moving == 1) {
            
        }
    }

    public function getID() {
        return $this->worker->user['playerID'];
    }

    public function getShip() {
        return $this->worker->user['Ship'];
    }

    public function getX() {
        return $this->worker->user['x'];
    }

    public function getY() {
        return $this->worker->user['y'];
    }

    public function getTag() {
        return $this->worker->user['tag'];
    }

    public function getFaction() {
        return $this->worker->user['factionId'];
    }

    public function getMap() {
        return $this->worker->user['mapId'];
    }

    public function setXY($x, $y) {
        
    }

    public function getRank() {
        return $this->worker->user['rank'];
    }

    public function sendToAll($packet) {
        print_r($this->pool);
        $this->worker->toAll($packet);
    }

    public function LoadUsers() {
//        foreach ($this->pool as $k => $user) {
//            if ($user->mapId == Zedron::$users[$this->IO]->mapId)
//                self::Send("f|C|" .$user->playerID. "|".$user->Ship."|15|".$user->Name."|".$user->tag."|".$user->x."|".$user->y."|".$user->factionId."|0|".$user->rank."|0|0|7|".$user->mapId."|0|0");
//        }
    }

}

class GameInstances extends Worker {

    public function __construct(SafeLog $logger) {
        $this->logger = $logger;
    }

    protected $logger;
    protected $pack;
    
    public function toUser($args) {
        $this->user = $args;
    }
    
    public function toAll($packet){
        $game = new baXi();
        $game->setMultiCall($packet);
    }

}

class SafeLog extends Stackable {

    protected function log($message, $args = []) {
        $args = func_get_args();

        if (($message = array_shift($args))) {
            echo vsprintf(
                    "{$message}\n", $args);
        }
    }

}

?>