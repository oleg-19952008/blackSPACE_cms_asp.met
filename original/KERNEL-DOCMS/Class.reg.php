<?php

/*
 *  FOLLOW SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);

class register{
    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    private $hid;
    
    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con = $GLOBALS['DB'];
    }

    public function SuperReg($id) {
        $this->uid = $id;
        $sqli = "SELECT playerID FROM server_1_players WHERE userID = :userID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam("userID", $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->pid = $result[0]->playerID;
			self::premiumSet();
            self::makeSettings();
            return self::hangarReg();
        }
    }
	private function premiumSet(){
	$sql ="UPDATE server_1_players SET premium=CURRENT_TIMESTAMP WHERE playerID=:playerID ";
	 $stmt = $this->con->prepare($sql);
        $stmt->bindParam("playerID", $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
			return TRUE;
		}
	}
//    private function delete(){
//        $sqli = "DELETE U, S FROM users AS U INNER JOIN server_1_players AS S ON U.ID = S.userID WHERE U.ID = :id";
//         $stmt = $this->con->prepare($sql);
//         $stmt->bindParam(':id', $this->uid, PDO::PARAM_INT);
//         $stmt->execute();
//    }
    private function hangarID(){
        $sqli = "SELECT hangarID FROM server_1_hangar WHERE userID=:userID && playerID=:playerID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam("userID", $this->uid, PDO::PARAM_INT);
        $stmt->bindParam("playerID", $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->hid = $result[0]->hangarID;
        }
    }
    
    private function makeSettings(){
        $sql = "INSERT INTO `server_1_player_settings` (`userID`, `playerID`) VALUES (?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        if($stmt->execute()){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    private function hangarReg() {
	    self::rankingList();
        $name = "Hangar 1";
        $a = 1;
        $s = 1;
        $sql = "INSERT INTO `server_1_hangar` (`hangar_is_active`, `hangar_is_selected`, `name`, `userID`, `playerID`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $a, PDO::PARAM_INT);
        $stmt->bindParam(2, $s, PDO::PARAM_INT);
        $stmt->bindParam(3, $name, PDO::PARAM_STR);
        $stmt->bindParam(4, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(5, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            self::hangarID();
            self::HangarGeneral();
        }
    }
	
	private function rankingList() {
        $sql = "INSERT INTO `player_kills_count` (`playerID`) VALUES (?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
        $stmt->execute();
		self::npcList();
    }
	private function npcList() {
        $sql = "INSERT INTO `npc_kills` (`playerID`) VALUES (?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
        $stmt->execute();
    }
    private function HangarGeneral(){
        $shipip = 1;
        $shiphp = 4000;
        $shipModel = "ship_phoenix";
        $sql = "INSERT INTO `server_1_player_hangar_general_ship` (`hangarID`, `playerID`, `ship_internal_id`, `ship_hp`, `ship_selected_model`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
            $stmt->bindParam(1, $this->hid, PDO::PARAM_INT);
            $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(3, $shipip, PDO::PARAM_INT);
            $stmt->bindParam(4, $shiphp, PDO::PARAM_INT);
            $stmt->bindParam(5, $shipModel, PDO::PARAM_STR);
        if ($stmt->execute()) {
            self::shipConfig();
            self::ShipItem();
        }
    }
     private function shipConfig(){
        $sql = "INSERT INTO `server_1_hangar_config_ship` (`hangarID`, `playerID`, `userID`, `configNum`) VALUES (?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
            $stmt->bindParam(1, $this->hid, PDO::PARAM_INT);
            $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(3, $this->uid, PDO::PARAM_INT);
            for ($count = 1; $count <= 2; $count++) {
                   $stmt->bindParam(4, $count, PDO::PARAM_INT);
                   $stmt->execute();
            }
    }
    private function ShipItem(){
		self::logitem();
		self::repBot();
        $shipModel = "ship_phoenix";
        $Q = 1;
        $in = 1;
        $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
            $stmt->bindParam(1, $shipModel, PDO::PARAM_STR);
            $stmt->bindParam(2, $Q, PDO::PARAM_INT);
            $stmt->bindParam(3, $in, PDO::PARAM_INT);
            $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(5, $this->uid, PDO::PARAM_INT);
            if($stmt->execute()){
                
            }else{
                print_r($stmt->errorInfo());
                exit;
            }
            
    }
	 private function logitem(){
        $shipModel = "resource_logfile";
        $Q = 1;
        $in = 0;
        $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
            $stmt->bindParam(1, $shipModel, PDO::PARAM_STR);
            $stmt->bindParam(2, $Q, PDO::PARAM_INT);
            $stmt->bindParam(3, $in, PDO::PARAM_INT);
            $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(5, $this->uid, PDO::PARAM_INT);
            if($stmt->execute()){
                
            }else{
                print_r($stmt->errorInfo());
                exit;
            }
            
    }
	private function repBot(){
        $shipModel = "equipment_extra_repbot_rep-4";
        $Q = 1;
        $in = 0;
        $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
            $stmt->bindParam(1, $shipModel, PDO::PARAM_STR);
            $stmt->bindParam(2, $Q, PDO::PARAM_INT);
            $stmt->bindParam(3, $in, PDO::PARAM_INT);
            $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(5, $this->uid, PDO::PARAM_INT);
            if($stmt->execute()){
                
            }else{
                print_r($stmt->errorInfo());
                exit;
            }
            
    }

}

?>
