<?php
class GalaxyGate {
    public $dataCon = null;
    public $dataGates = null;
    private $con;
    public $proberbil;
    private $stm;
    private $stu;
    private $playerid;
    private $userid;
    private $corpAll;
    public $AllGat;
    private $multiplier;
    public $FinalData;
    private $spinNum;
    public $Uri = null;
    
    public function __construct() {
        $this->con = $GLOBALS['DB'];
        
    }
    public function setInfo($playerID, $userID){
        $this->playerid = $playerID;
        $this->userid = $userID;
    }
    public function reloadUri(){
        $stmt = $this->con->prepare("SELECT uri FROM server_1_players WHERE userID = ? && playerID = ? ");
            $stmt->bindParam(1, $this->userid, PDO::PARAM_INT);
            $stmt->bindParam(2, $this->playerid, PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->uri = $result[0]['uri'];
            return $result[0]['uri'];
        }
    }
    public function proberbiliteis() {
        if (isset($_SESSION['server1']['user']['sessionId'], $_SESSION['server1']['user']['email']) && is_numeric($_SESSION['server1']['user']['sessionId'])):
            $query = $this->con->prepare("SELECT galaxygate_name, ammunition, resource, voucher, logfile, part, ammo_x2, ammo_x3, ammo_x4, ammo_abs, ammo_rocket, ammo_mine, gate_1, gate_2, gate_3, gate_4, gate_5, gate_6, gate_7, gate_8, gate_13, special, special_hitpoints FROM server_galaxygate");
            if ($query->execute()) {
                $this->proberbil = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        endif;
    }
    
    public function multipliersShow() {
        if (isset($_SESSION['server1']['user']['sessionId'], $_SESSION['server1']['user']['email']) && is_numeric($_SESSION['server1']['user']['sessionId'])):
            $query = $this->con->prepare("SELECT `galaxygate_id`, `state`, `galaxygate_multipliers` FROM `server_1_players_galaxygate` WHERE playerID = :playerID AND userID = :userID");
                $query->bindValue('playerID', $this->playerid, PDO::PARAM_STR);
                $query->bindValue('userID', $this->userid, PDO::PARAM_STR);
//                $query->bindValue('galaxygate_id', $gateid, PDO::PARAM_STR);
                if ($query->execute()) {
                    $all = $query->fetchAll(PDO::FETCH_OBJ);
                    $this->corpAll = $all;
//                return self::gatesInfos($all);
            }
        endif;
    }
    public function getIt($search){
        $query = $this->con->prepare("SELECT * FROM clans WHERE clanName LIKE ?");
        $query->bindParam(1, $search, PDO::PARAM_STR);
             if ($query->execute()) {
                 $result = $query->fetchAll(PDO::FETCH_OBJ);
                 $this->html = NULL;
                 foreach ($result AS $key => $value){
                     $this->html .= "<option>$value->clanName</option>";
                 }
                 return $this->html;
             }else{
                 return false;
             }
    }
     private function checkExistence($lootid){
        $stmt = $this->con->prepare("SELECT id FROM server_1_player_all_items WHERE userID = ? && playerID = ? && lootid = ?");
            $stmt->bindParam(1, $this->userid, PDO::PARAM_INT);
            $stmt->bindParam(2, $this->playerid, PDO::PARAM_INT);
            $stmt->bindParam(3, $lootid, PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(!empty($result)){
                return true;
            }else{
                return false;  
            }
        }
     
    }
    
    private function addItems($args){
        $lootIds = array('2'=>'ammunition_laser_mcb-25', '3'=>'ammunition_laser_mcb-50', '4'=>'ammunition_laser_ucb-100', '5'=>'ammunition_laser_sab-50','12'=>'ammunition_rocket_plt-2021','11'=>'ammunition_mine_acm-01');
        foreach($args as $k => $r){
            if(array_key_exists($r['id'], $lootIds)):
                $li = $lootIds[$r['id']];
                if(self::checkExistence($li)):
                    if(!empty($r['q'])):
                    $Q = $r['q'];
                    $sqli = "UPDATE `server_1_player_all_items` SET Q = Q + $Q WHERE userID=? && playerID=? && lootid=?";
                    $stmt = $this->con->prepare($sqli);
                    $stmt->bindParam(1, $this->userid, PDO::PARAM_INT);
                    $stmt->bindParam(2, $this->playerid, PDO::PARAM_INT);
                    $stmt->bindParam(3, $li, PDO::PARAM_STR);
                    $stmt->execute();
                    endif;
                else:
                  if(!empty($r['q'])):
                    $in = 0;
                    $Q = $r['q'];
                    $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam(1, $li, PDO::PARAM_STR);
                    $stmt->bindParam(2, $Q, PDO::PARAM_INT);
                    $stmt->bindParam(3, $in, PDO::PARAM_INT);
                    $stmt->bindParam(4, $this->playerid, PDO::PARAM_INT);
                    $stmt->bindParam(5, $this->userid, PDO::PARAM_INT);
                    $stmt->execute();
                    endif;
                endif;
            endif;
        }
        return true;
    }
    public function gatesInfos(){
        $allGates = new stdClass();
         $query = $this->con->prepare("SELECT `galaxygate_name` FROM `server_galaxygate` WHERE galaxygate_id = ?");
//         $g = 0;
         $this->AllGat = null;
         foreach ($this->corpAll as $keys => $value) {
//             return $all;
            $query->bindParam(1, $value->galaxygate_id, PDO::PARAM_STR);
            $query->execute();
                $pear = $query->fetchAll(PDO::FETCH_ASSOC);
            if ($query->execute()) {
//                return $pear;
//            $allGates->$g = new stdClass();
//            $allGates->$g->galaxygate_name = $pear[0]['galaxygate_name'];
//            $allGates->$g->galaxygate_id = $value->galaxygate_id;
//            $allGates->$g->galaxygate_multipliers = $value->galaxygate_multipliers;
            $this->AllGat .= '<multiplier mode="'.strtolower($pear[0]['galaxygate_name']).'" value="'.$value->galaxygate_multipliers.'" state="0" />';
//            $g++;
//                return $pear->galaxygate_name;
//                $allGates[$g]['galaxygate_name'] = $pear->galaxygate_name;
//                $allGates[$g]['galaxygate_id'] = $value['galaxygate_id'];
             
            }
        }
        return $this->AllGat;
//        $this->AllGat = null;
//        foreach($allGates as $keysw => $valuesw){
//            $this->AllGat .= '<multiplier mode="'.$valuesw->galaxygate_name.'" value="'.$valuesw->galaxygate_multipliers.'" state="'.$valuesw->galaxygate_multipliers.'" />';
//        }
    }
    public function GetGates() {
        if (isset($_SESSION['server1']['user']['sessionId'], $_SESSION['server1']['user']['email']) && is_numeric($_SESSION['server1']['user']['sessionId'])):
            self::AllGates();
            self::CheckGateCount();
            if ($this->stm != $this->stu) {
                self::AddGates();
                self::UserGates();
                self::multipliersShow();
                self::gatesInfos();
            } else {
                self::UserGates();
                self::multipliersShow();
                self::gatesInfos();
            }
        endif;
    }

    private function AllGates() {
        $query = $this->con->prepare("SELECT galaxygate_id, galaxygate_name, galaxygate_part, galaxygate_totalWave, lifePrice FROM server_galaxygate");
        if ($query->execute()) {
            $this->stm = 9;
//            $this->stm = $query->rowCount();
            $this->dataGates = $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    private function CheckGateCount() {
        $query = $this->con->prepare("SELECT galaxygate_id FROM server_1_players_galaxygate WHERE playerID = :playerID");
        $query->bindValue('playerID', $this->playerid, PDO::PARAM_STR);
        if ($query->execute()) {
            $this->stu = $query->rowCount();
//            if($stm!=$stu){
//                self::AddGates($stm, $playerID, $userID);
//            }else{
//                self::UserGates($playerID, $userID);
//            }
        }
    }

    public function UserGates() {
        $query = $this->con->prepare("SELECT playerID, userID, galaxygate_id, galaxygate_current_parts, galaxygate_prepared, livesLeft, state, galaxygate_current_wave FROM server_1_players_galaxygate WHERE playerID = :playerID AND userID = :userID");
        $query->bindValue('playerID', $this->playerid, PDO::PARAM_STR);
        $query->bindValue('userID', $this->userid, PDO::PARAM_STR);
        if ($query->execute()) {
            $this->dataCon = $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function setMulti($set){
        $this->multiplier = $set;
    }
    private function AddGates() {
        foreach ($this->dataGates as $insertRow) {
            $query = $this->con->prepare("INSERT INTO server_1_players_galaxygate (playerID, userID, galaxygate_id, galaxygate_current_parts, galaxygate_prepared, livesLeft, state, galaxygate_current_wave) VALUES (:playerID, :userID, :galaxygate_id, :galaxygate_current_parts, :galaxygate_prepared, :livesLeft, :state, :galaxygate_current_wave)");
            $query->bindValue('playerID', $this->playerid, PDO::PARAM_STR);
            $query->bindValue('userID', $this->userid, PDO::PARAM_STR);
            $query->bindValue('galaxygate_id', $insertRow['galaxygate_id'], PDO::PARAM_STR);
            $query->bindValue('galaxygate_current_parts', 0, PDO::PARAM_STR);
            $query->bindValue('galaxygate_prepared', 0, PDO::PARAM_STR);
            $query->bindValue('livesLeft', "-1", PDO::PARAM_STR); 
            $query->bindValue('state', "in_progress", PDO::PARAM_STR);
            $query->bindValue('galaxygate_current_wave', 0, PDO::PARAM_STR);
            $query->execute();
        }
//        self::UserGates($playerID, $userID);
    }

    public function spinerUri($userUri, $c, $cost, $playerID, $userID, $gateID) {
        self::reloadUri();
        $ammount = preg_replace("/[^0-9]/", "",$c);
        $preCost = $ammount * $cost;   
        $finalUri = $this->uri - $preCost;
        if($finalUri<0):
            $itemsget = '<items>';  
                $itemsget .= '</items>
                    <boosts>
                </boosts>';
                return $itemsget;
        endif;
            $query = $this->con->prepare("UPDATE server_1_players SET uri = :uri WHERE playerID = :playerID and userID = :userID");
            $query->bindValue('uri', $finalUri, PDO::PARAM_STR);
            $query->bindValue('playerID', $playerID, PDO::PARAM_STR);
            $query->bindValue('userID', $userID, PDO::PARAM_STR);
        if ($query->execute()) {
            return self::currentGate($userUri, $ammount, $cost, $playerID, $userID, $gateID);
        }
    }
    private function MultiplierUpdate($playerID, $userID, $gateID, $count){
        if($gateID ==1 OR $gateID==2 OR $gateID==3){
            $query = $this->con->prepare("UPDATE `server_1_players_galaxygate` SET `galaxygate_multipliers`=:count WHERE playerID = :playerID && userID = :userID && galaxygate_id = :galaxygate_id");
            $query->bindValue('count', $count, PDO::PARAM_STR);  
            $query->bindValue('playerID', $playerID, PDO::PARAM_STR);
            $query->bindValue('userID', $userID, PDO::PARAM_STR);
            for ($i = 1; $i < 4; $i++) {
                $query->bindValue('galaxygate_id', $i, PDO::PARAM_STR);
                $query->execute();
            }
            self::multipliersShow();
        }else{
        $query = $this->con->prepare("UPDATE `server_1_players_galaxygate` SET `galaxygate_multipliers`=:count WHERE playerID = :playerID && userID = :userID && galaxygate_id = :galaxygate_id");
            $query->bindValue('count', $count, PDO::PARAM_STR);  
            $query->bindValue('playerID', $playerID, PDO::PARAM_STR);
            $query->bindValue('userID', $userID, PDO::PARAM_STR);
            $query->bindValue('galaxygate_id', $gateID, PDO::PARAM_STR);
            $query->execute();
            self::multipliersShow();
        }
    }
    public function WhereMulti($cou){
        $this->spinNum = $cou;
    }
    private function currentGate($userUri, $ammount, $cost, $playerID, $userID, $gateID) {
        if($this->multiplier ==1){
         $query = $this->con->prepare("SELECT `galaxygate_multipliers` FROM `server_1_players_galaxygate` WHERE playerID = ? && userID = ? && galaxygate_id = ?");
            $query->bindValue(1, $playerID, PDO::PARAM_STR);
            $query->bindValue(2, $userID, PDO::PARAM_STR);
            $query->bindValue(3, $gateID, PDO::PARAM_STR);            
                if ($query->execute()) {
                    $multiObj = $query->fetchAll(PDO::FETCH_OBJ);
                    $multi = $multiObj[0]->galaxygate_multipliers;
                    self::MultiplierUpdate($playerID, $userID, $gateID, 0);
                }
         }else{
            $multi = 0;
    }
//        $gateNum = "gate_" . $gateID;
//        $query = $this->con->prepare("SELECT galaxygate_name, ammunition, resource, voucher, logfile, part, ammo_x2, ammo_x3, ammo_x4, ammo_abs, ammo_rocket, ammo_mine, :gate, special, special_hitpoints FROM server_galaxygate WHERE galaxygate_id = :galaxygate_id");
//        $query->bindValue('gate', $gateNum, PDO::PARAM_STR);
//        $query->bindValue('galaxygate_id', $gateID, PDO::PARAM_STR);
//        if ($query->execute()) {
//            $gateInfo = $query->fetchAll(PDO::FETCH_ASSOC);
            $total = 1.0;
            $pammo = $total - 0.67;
            $pgate = $total - 0.13;
            $presource = $total - 0.12;
            $pvoucher = $total - 0.03;
            $plogfile = $total - 0.01;
            $pspecial = $total - 0.04;

            $pammo2 = $total - 0.35;
            $pammo3 = $total - 0.25;
            $pammo4 = $total - 0.10;
            $pammoabs = $total - 0.20;
            $pammoRo = $total - 0.05;
            $pammomine = $total - 0.05;
            
            $itemArray = array();
            
            if($multi!=1 OR $multi !=0){
                $multiplier = $multi+1;
            }else{
                $multiplier = 1;
            }
            
            for ($i = 0; $i < $ammount; $i++) {
                $rand = mt_rand(0, 100);
                $rand = $rand / 100.0;
                if ($rand > $plogfile) {
                    if(array_key_exists('mine', $itemArray)){
                        $itemArray['mine']['q'] += 4;
                        $itemArray['mine']['spinUsed'] += 1;
                    }else{
                      $itemArray['mine']['id'] = 12;
                      $itemArray['mine']['q'] = rand(1, 10) * $multiplier;
                      $itemArray['mine']['type'] = "rocket";
                      $itemArray['mine']['spinUsed'] = 1;
                      $multiplier = 1;
                    }
//                    $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="12" type="rocket"></item>';
                } else if ($rand > $pvoucher) {
                    if(array_key_exists('voucher', $itemArray)){
                        $itemArray['voucher']['q'] += rand(1, 3);
                        $itemArray['voucher']['spinUsed'] += 1;
                    }else{
                      $itemArray['voucher']['id'] = "voucher";
                      $itemArray['voucher']['q'] = rand(1, 3) * $multiplier;
                      $itemArray['voucher']['type'] = "voucher";
                      $itemArray['voucher']['spinUsed'] = 1;
                      $multiplier = 1;
                    }
//                     $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="12" type="rocket"></item>';
                } else if ($rand > $pspecial) {
                    if(array_key_exists('mine', $itemArray)){
                        $itemArray['mine']['q'] += 4;
                        $itemArray['mine']['spinUsed'] += 1;
                    }else{
                      $itemArray['mine']['id'] = 12;
                      $itemArray['mine']['q'] = rand(1, 10) * $multiplier;
                      $itemArray['mine']['type'] = "rocket";
                      $itemArray['mine']['spinUsed'] = 1;
                      $multiplier = 1;
                    }
//                     $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="12" type="rocket"></item>';
                } else if ($rand > $presource) {
                   if(array_key_exists('mine', $itemArray)){
                        $itemArray['mine']['q'] += 4;
                        $itemArray['mine']['spinUsed'] += 1;
                    }else{
                        $itemArray['mine']['id'] = 12;
                      $itemArray['mine']['q'] = rand(1, 10) * $multiplier;
                      $itemArray['mine']['type'] = "rocket";
                      $itemArray['mine']['spinUsed'] = 1;
                      $multiplier = 1;
                    }
//                     $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="12" type="rocket"></item>';
                } else if ($rand > $pgate) {
                    if(array_key_exists('Gate', $itemArray)){
//                      $itemArray['Gate'] = 20;
                        $itemArray['gate']['spinUsed'] += 1;
                    }else{
                      $itemArray['gate']['id'] = rand(1, 34) * $multiplier;
                      $itemArray['gate']['type'] = "gate";
                      $itemArray['gate']['spinUsed'] = 1;
                      $multiplier = 1;
                    }
//                    $itemsget .= '<item part_id="20" gate_id="1" date="' . date_timestamp_get($currentDate) . '" state="in_progress" total="34" current="1" type="part"></item>';
                } else if ($rand > $pammo) {
                    $rand2 = mt_rand(0, 100);
                    $rand2 = $rand2 / 100.0;
                    if ($rand2 > $pammomine) {
                        if (rand(0, 100) / 100 > 0.45) {
                            if(array_key_exists('mine', $itemArray)){
                                
                                $itemArray['mine']['q'] += rand(1, 10);
                                $itemArray['mine']['spinUsed'] += 1;
                            }else{
                               $itemArray['mine']['id'] = 12;
                              $itemArray['mine']['q'] = rand(1, 10) * $multiplier;
                              $itemArray['mine']['type'] = "rocket";
                              $itemArray['mine']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                            $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="12" type="rocket"></item>';
                        } else {
                            if(array_key_exists('1', $itemArray)){
                                $itemArray['rocket']['q'] += rand(10, 50);
                                $itemArray['rocket']['spinUsed'] += 1;
                            }else{
                              $itemArray['rocket']['id'] = 11;
                              $itemArray['rocket']['q'] = rand(10, 50) * $multiplier;
                              $itemArray['rocket']['type'] = "rocket";
                              $itemArray['rocket']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                            $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="11" type="rocket"></item>';
                        }
                    } else if ($rand2 > $pammo4) {
                         if(array_key_exists('x4', $itemArray)){
                                $itemArray['x4']['q'] += rand(50, 320);
                                $itemArray['x4']['spinUsed'] += 1;
                            }else{
                                $itemArray['x4']['id'] = 4;
                              $itemArray['x4']['q'] = rand(50, 320) * $multiplier;
                              $itemArray['x4']['type'] = "battery";
                              $itemArray['x4']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="4" type="battery"></item>';
                    } else if ($rand2 > $pammoabs) {
                         if(array_key_exists('sab', $itemArray)){
                                $itemArray['sab']['q'] += rand(50, 320);
                                $itemArray['sab']['spinUsed'] += 1;
                            }else{
                                 $itemArray['sab']['id'] = 5;
                              $itemArray['sab']['q'] = rand(50, 320) * $multiplier;
                              $itemArray['sab']['type'] = "battery";
                              $itemArray['sab']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="4" type="battery"></item>';
                    } else if ($rand2 > $pammo3) {
                         if(array_key_exists('x3', $itemArray)){
                                $itemArray['x3']['q'] += rand(50, 320);
                                $itemArray['x3']['spinUsed'] += 1;
                            }else{
                                 $itemArray['x3']['id'] = 3;
                              $itemArray['x3']['q'] = rand(50, 320) * $multiplier;
                              $itemArray['x3']['type'] = "battery";
                              $itemArray['x3']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="3" type="battery"></item>';
                    } else if ($rand2 > $pammo2) {
                         if(array_key_exists('x2', $itemArray)){
                                $itemArray['x2']['q'] += rand(50, 320);
                                $itemArray['x2']['spinUsed'] += 1;
                            }else{
                              $itemArray['x2']['id'] = 2;
                              $itemArray['x2']['q'] = rand(50, 320);
                              $itemArray['x2']['q'] = $itemArray['x2']['q'] * $multiplier;
                              $itemArray['x2']['type'] = "battery";
                              $itemArray['x2']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="2" type="battery"></item>';
                    } else {
                        if(array_key_exists('x2', $itemArray)){
                                $itemArray['x2']['q'] += rand(50, 320);
                                $itemArray['x2']['spinUsed'] += 1;
                            }else{
                              $itemArray['x2']['id'] = 2;
                              $itemArray['x2']['q'] = rand(50, 320);
                              $itemArray['x2']['q'] = $itemArray['x2']['q'] * $multiplier;
                              $itemArray['x2']['type'] = "battery";
                              $itemArray['x2']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="2" type="battery"></item>';
                    }
                } else {
                  $rand2 = mt_rand(0, 100);
                    $rand2 = $rand2 / 100.0;
                    if ($rand2 > $pammomine) {
                        if (rand(0, 100) / 100 > 0.45) {
                            if(array_key_exists('mine', $itemArray)){
                                
                                $itemArray['mine']['q'] += rand(1, 10);
                                $itemArray['mine']['spinUsed'] += 1;
                            }else{
                               $itemArray['mine']['id'] = 12;
                              $itemArray['mine']['q'] = rand(1, 10) * $multiplier;
                              $itemArray['mine']['type'] = "rocket";
                              $itemArray['mine']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                            $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="12" type="rocket"></item>';
                        } else {
                            if(array_key_exists('1', $itemArray)){
                                $itemArray['rocket']['q'] += rand(10, 50);
                                $itemArray['rocket']['spinUsed'] += 1;
                            }else{
                              $itemArray['rocket']['id'] = 11;
                              $itemArray['rocket']['q'] = rand(10, 50) * $multiplier;
                              $itemArray['rocket']['type'] = "rocket";
                              $itemArray['rocket']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                            $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="11" type="rocket"></item>';
                        }
                    } else if ($rand2 > $pammo4) {
                         if(array_key_exists('x4', $itemArray)){
                                $itemArray['x4']['q'] += rand(50, 320);
                                $itemArray['x4']['spinUsed'] += 1;
                            }else{
                                $itemArray['x4']['id'] = 4;
                              $itemArray['x4']['q'] = rand(50, 320) * $multiplier;
                              $itemArray['x4']['type'] = "battery";
                              $itemArray['x4']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="4" type="battery"></item>';
                    } else if ($rand2 > $pammoabs) {
                         if(array_key_exists('sab', $itemArray)){
                                $itemArray['sab']['q'] += rand(50, 320);
                                $itemArray['sab']['spinUsed'] += 1;
                            }else{
                                 $itemArray['sab']['id'] = 5;
                              $itemArray['sab']['q'] = rand(50, 320) * $multiplier;
                              $itemArray['sab']['type'] = "battery";
                              $itemArray['sab']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="4" type="battery"></item>';
                    } else if ($rand2 > $pammo3) {
                         if(array_key_exists('x3', $itemArray)){
                                $itemArray['x3']['q'] += rand(50, 320);
                                $itemArray['x3']['spinUsed'] += 1;
                            }else{
                                 $itemArray['x3']['id'] = 3;
                              $itemArray['x3']['q'] = rand(50, 320) * $multiplier;
                              $itemArray['x3']['type'] = "battery";
                              $itemArray['x3']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="3" type="battery"></item>';
                    } else if ($rand2 > $pammo2) {
                         if(array_key_exists('x2', $itemArray)){
                                $itemArray['x2']['q'] += rand(50, 320);
                                $itemArray['x2']['spinUsed'] += 1;
                            }else{
                                 $itemArray['x2']['id'] = 2;
                              $itemArray['x2']['q'] = rand(50, 320);
                              $itemArray['x2']['q'] = $itemArray['x2']['q'] * $multiplier;
                              $itemArray['x2']['type'] = "battery";
                              $itemArray['x2']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="2" type="battery"></item>';
                    } else {
                        if(array_key_exists('x2', $itemArray)){
                                $itemArray['x2']['q'] += rand(50, 320);
                                $itemArray['x2']['spinUsed'] += 1;
                            }else{
                              $itemArray['x2']['id'] = 2;
                              $itemArray['x2']['q'] = rand(50, 320);
                              $itemArray['x2']['q'] = $itemArray['x2']['q'] * $multiplier;
                              $itemArray['x2']['type'] = "battery";
                              $itemArray['x2']['spinUsed'] = 1;
                              $multiplier = 1;
                            }
//                        $itemsget .= '<item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="2" type="battery"></item>';
                    }
                }
            }
            
//            return $itemArray;
            $currentDate = date_create();
            if(self::addItems($itemArray)):
            
            $itemsget = '<items>';  
            foreach ($itemArray as $keys => $values) {
//                return $itemArray;
                if(isset($values['type'])&& $values['type']=="gate"){
//                   $itemsget .= '<item part_id="20" gate_id="1" date="' . date_timestamp_get($currentDate) . '" state="in_progress" total="34" current="1" type="part"></item>';
                }else{
                   $itemsget .=  '<item date="' . date_timestamp_get($currentDate) . '" amount="'.$values['q'].'" spins="'.$values['spinUsed'].'" item_id="'.$values['id'].'" type="'.$values['type'].'"></item>';
                }
               }
                $itemsget .= '</items>
                    <boosts>
                </boosts>';
//                return $key;
//            self::GetGates($playerID, $userID);
            $this->FinalData = $itemsget;
//            return $itemsget;
//            return '
//                <item part_id="20" gate_id="1" date="' . date_timestamp_get($currentDate) . '" state="in_progress" total="34" current="1" type="part"></item>
//                <item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="2" type="battery"></item>
//                <item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="3" type="battery"></item>
//                <item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="4" type="battery"></item>
//                <item date="' . date_timestamp_get($currentDate) . '" amount="180" spins="1" item_id="5" type="battery"></item>
//                
//                <item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="11" type="rocket"></item>
//                <item date="' . date_timestamp_get($currentDate) . '" amount="4" spins="1" item_id="12" type="rocket"></item>
//';
            endif;
        }
//    }

}
?>