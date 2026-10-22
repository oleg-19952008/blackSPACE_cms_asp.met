<?php
/*
 *  THIS SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
 ini_set('display_errors', '0');
// error_reporting(E_ALL);

class base{
    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    private $uridium;
    private $credits;
    private $hid;
    private $ships;
    public $numbs;
    public $myShip;
    public $shipShow;
    public $shipnum;
    public $shipn;
    private $fac;
    public $rankNum;
    
    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con =  $GLOBALS['DB'];
    }
    public function setId($uid, $pid){
            if($this->copyright!="BY Seven & NavigatoR - MEDIANET IVS"){
                die("Do not violate my copyright");
            }
            $this->uid = $uid; 
            $this->pid = $pid; 
            
        self::money();
    }
    public function currentCompany($com){
             if ($com == 1):
                return "mmo";
            elseif ($com == 2):
                return "eic";
            else:
                return "vru";
            endif;
    }
    public function currentDrones(){
        $iris = "drone_iris";
        $flax = "drone_flax";
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_drones WHERE userID=:userID && playerID=:playerID");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
//        $stmt->bindParam(':iris', $iris, PDO::PARAM_STR);
//        $stmt->bindParam(':flax', $flax, PDO::PARAM_STR);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             $o = count($result);
             return $o;
         }
    }
    private function money(){
        $stmt = $this->con->prepare("SELECT uri, credits FROM server_1_players WHERE userID=:userID && playerID=:playerID");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_OBJ);
             $this->uridium = $result[0]->uri;
             $this->credits = $result[0]->credits;
         }
    }    
    public function ShipName($id){
       $stmt = $this->con->prepare("SELECT Name FROM sips WHERE Id=:id LIMIT 1");
         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
           if ($stmt->execute()) {
               $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
               print_r($result);
               exit;
           }
    }
    public function HangarId(){
        $stmt = $this->con->prepare("SELECT hangarID FROM server_1_hangar WHERE userID=:userID && playerID=:playerID LIMIT 1");
         $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_OBJ);
             if(!empty($result)){
                $this->hid = $result[0]->hangarID;
                return $this->hid;
             }else{
                 return false;
             }
         }
        
    }
    private function Wipe(){
        $sqli = "UPDATE server_1_hangar_config_ship AS s SET s.lasers = '', s.generators = '', s.heavy_guns = '', s.extras = '' WHERE ";
        $sqli .= " s.playerID=:playerID && s.userID=:userID && s.configNum=:configNum && s.hangarID=:hangarID";
        $stmt = $this->con->prepare($sqli);
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        for($i =1; $i <= 2; $i++){
                  $stmt->bindParam(':configNum', $i, PDO::PARAM_INT);
                  $stmt->bindParam(':hangarID', $this->hid, PDO::PARAM_INT);
                  if($stmt->execute()){
                      if($i==1){
                          $drone = "EQ";
                        }else{
                          $drone = "EQ2";
                        }
                      self::wipeDrone($drone);
                  }
        }
              
    }
    private function wipeDrone($drone){
        $sqli = "UPDATE server_1_hangar_config_drones SET $drone = '', design = '' WHERE ";
        $sqli .= "playerID=:playerID && userID=:userID && hangarID=:hangarID";
        $stmt = $this->con->prepare($sqli);
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                    $stmt->bindParam(':hangarID', $this->hid, PDO::PARAM_INT);
                    $stmt->execute();
    }
    public function postShip(){
        if(!empty($this->ships)){
            $base = "";
            $i = 1;
            foreach($this->ships AS $key => $value){
                $s = $i-1;
                if($s == 0):
                    $base  .= '<form class="shipDumpForm" id="shipDumpForm_'.$i.'" acton="indexInternal.es.php" method="post"><input type="hidden" name="reloadToken" value="">
                            <input type="hidden" name="action" value="internalDock">
                            <input type="hidden" name="subAction" value="addShipToHangar">
                            <input type="hidden" id="hangarId" name="hangarId" value="'.$this->hid.'">
                            <input type="hidden" id="inventoryId" name="inventoryId" value="'.$value.'">
                                    <div id="shipDump_'.$i.'" class="shipDumpViewActual shipyard">
                                <div id="ship_'.$s.'" class="shipyard_image ship_'.$value.'" title=""></div>
                            </div>
                        </form>';
                    else:
                    $base  .= '<form class="shipDumpForm" id="shipDumpForm_'.$i.'" acton="indexInternal.es.php" method="post"><input type="hidden" name="reloadToken" value="">
                            <input type="hidden" name="action" value="internalDock">
                            <input type="hidden" name="subAction" value="addShipToHangar">
                            <input type="hidden" id="hangarId" name="hangarId" value="'.$this->hid.'">
                            <input type="hidden" id="inventoryId" name="inventoryId" value="'.$value.'">
                                    <div id="shipDump_'.$i.'" class="shipDumpViewNext shipyard">
                                <div id="ship_'.$s.'" class="shipyard_image ship_'.$value.'" title=""></div>
                            </div>
                        </form>';
                endif;
                
                $i++;
            }
            return $base;
            
        }
    }
    private function currentShip(){
        $stmt = $this->con->prepare("SELECT ship_selected_model FROM server_1_player_hangar_general_ship WHERE playerID=:playerID LIMIT 1");
        //$stmt->bindParam(':hangarID', $this->hid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_OBJ);
             $this->myShip = $result[0]->ship_selected_model;
        }
    }
    private function shipByID($id){
        $stmt = $this->con->prepare("SELECT Name FROM ships WHERE Id=:id");
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            if ($stmt->execute()) {
                 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                 return $result[0]['Name'];
            }
    }
    private function modelID($shipExo, $shipLoot){
        if(count($shipExo)!=2){
            $stmt = $this->con->prepare("SELECT Id, ShipId, Name FROM ships_designs WHERE type=:type");
            $stmt->bindParam(':type', $this->myShip, PDO::PARAM_STR);
            if ($stmt->execute()) {
                 $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                 if($result[0]->Id == 49):
                     $this->shipShow = "aegis-".$this->fac;
                     $this->shipnum = 12;
                     $this->shipn = "49-".$this->fac;
                     elseif($result[0]->Id == 69):
                     $this->shipShow = "citadel-".$this->fac;
                     $this->shipnum = 11;
                     $this->shipn = "69-".$this->fac;
                     elseif($result[0]->Id == 70):
                     $this->shipShow = "spearhead-".$this->fac;
                     $this->shipnum = 13;
                     $this->shipn = "70-".$this->fac;
                     else:
                     $this->shipShow = self::shipByID($result[0]->Id);
                     $this->shipnum = $result[0]->Id;
                     $this->shipn = $result[0]->Id;
                 endif;
                 
            }
        }else{
            $stmt = $this->con->prepare("SELECT Id, Name FROM ships WHERE type=:type");
            $stmt->bindParam(':type', $shipLoot, PDO::PARAM_STR);
            if ($stmt->execute()){
                 $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                 if($result[0]->Id == 49):
                     $this->shipShow = "aegis-".$this->fac;
                     $this->shipnum = 12;
                     $this->shipn = "49-".$this->fac;
                     elseif($result[0]->Id == 69):
                     $this->shipShow = "citadel-".$this->fac;
                     $this->shipnum = 11;
                     $this->shipn = "69-".$this->fac;
                     elseif($result[0]->Id == 70):
                     $this->shipShow = "spearhead-".$this->fac;
                     $this->shipnum = 13;
                     $this->shipn = "70-".$this->fac;
                     else:
                     $this->shipShow = $result[0]->Name;
                     $this->shipnum = $result[0]->Id;
                     $this->shipn = $result[0]->Id;
                     endif;
            }
        }
    }
    public function GetRank($uid, $pid){
        $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN rank ON server_1_players.rank=rank.id WHERE server_1_players.userID=:userID && server_1_players.playerID=:playerID");        
        $stmt->bindParam(':userID', $uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0];
        }
    }
    public function GetRankByRNK($num){
        if($num==21):
            return "General";
        elseif($num==0):
            return "Basic Space Pilot";
            else:
        endif;
        $stmt = $this->con->prepare("SELECT * FROM rank WHERE id=:num");        
        $stmt->bindParam(':num', $num, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['name'];
        }
    }
    public function GetDateReg($uid){
        $stmt = $this->con->prepare("SELECT regDate FROM users WHERE ID=:userID ");        
        $stmt->bindParam(':userID', $uid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['regDate'];
        }
    }
    
    public function getNameBypid($pid=null){
        if(!empty($pid)){
            $stmt = $this->con->prepare("SELECT server_1_players.playerID, users.Name FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID=:playerID ");        
            $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result[0]['Name'];
            }
        }else{
                return "-";
        }
      
    }
    public function getShips(){     
        $this->fac = self::currentCompany($_SESSION['fact']);
        self::currentShip();
        $stmt = $this->con->prepare("SELECT lootid FROM server_1_player_all_items WHERE lootid LIKE 'ship%' && userID=:userID && playerID=:playerID");        
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
             $array = array();
             $result = $stmt->fetchAll(PDO::FETCH_OBJ);
             foreach($result as $key => $val){
			 
                 $pie = explode("_", $val->lootid);
                 if(in_array($pie[0]."_".$pie[1], $array)){
                     
                 }else{
				 if(empty($pie[2])){
                     array_push($array, $pie[0]."_".$pie[1]);  
				 }
                 }
             }
            $shipExo = explode("_", $this->myShip);
            $shipLoot = $shipExo[0]."_".$shipExo[1];
            if(in_array($shipLoot, $array)){
                if(($key = array_search($shipLoot, $array)) !== false) {
                    unset($array[$key]);
                }
            }
            self::modelID($shipExo, $shipLoot);
            $this->numbs = count($array);
            $this->ships = $array;
            
        }
        
    }
    
    private function checkExistence($lootid, $pid) {
        $stmt = $this->con->prepare("SELECT id FROM server_1_player_all_items WHERE playerID = ? && lootid = ?");
        $stmt->bindParam(1, $pid, PDO::PARAM_INT);
        $stmt->bindParam(2, $lootid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($result)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    private function shipID($lootid){
        $stmt = $this->con->prepare("SELECT Id FROM ships WHERE type = ? ");
        $stmt->bindParam(1, $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $result[0]['Id'];
            } else {
                return 1;
            }
        }
    }
    
    public function changeShip($hangarId, $inventoryId){
        if(!self::checkExistence($inventoryId, $this->pid)){
            return FALSE;
        }else{
            $modelnumber = self::shipID($inventoryId);
        self::Wipe();
        $sqli = "UPDATE `server_1_player_hangar_general_ship` SET ship_selected_model = ?, ship_internal_id = ? WHERE hangarID=? && playerID=?";
        $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(1, $inventoryId, PDO::PARAM_STR);
                $stmt->bindParam(2, $modelnumber, PDO::PARAM_INT);
                $stmt->bindParam(3, $this->hid, PDO::PARAM_INT);
                $stmt->bindParam(4, $this->pid, PDO::PARAM_STR);
                $stmt->execute();
        }
    }
    //SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_shop_items.lootId=server_1_player_all_items.lootid WHERE && server_shop_items.type=0 || server_shop_items.type=1 || server_shop_items.type=3 || server_shop_items.type=4 || server_shop_items.type=23 || server_shop_items.type=24 && server_1_player_all_items.userID=:userID && server_1_player_all_items.playerID=:playerID
    public function getItemUpgrade(){
        $sql = "SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_shop_items.lootId=server_1_player_all_items.lootid WHERE server_1_player_all_items.playerID=:playerID";
        $stmt = $this->con->prepare($sql);        
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             $sorted = array();
             foreach($result as $key => $val)
             {
                 if(array_key_exists($val['type'], $sorted)){
                     array_push($sorted[$val['type']], $val);
                 }else{
                     $sorted[$val['type']] = array($val);
                 }
             }
             return $sorted;
        }
    }
    public function upListPercent($lv){
        $array = array("0.2","0.4","0.8","1.2","1.6","2.0","2.4","2.8","3.2","3.6","4.0","4.4","4.8","5.2","5.6","6.0");
        return $array[$lv];
    }
	
	public function checkBan(){
        $sql = "SELECT banned FROM users WHERE ID=:playerID";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
         if ($stm->execute()):
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
         if($result[0]['banned']!=0){
             return TRUE;
         }else{
              return FALSE;
         }
        else:
            return FALSE;
        endif;
    }
	
    private function priceCalUpgrade($cu, $pricelist, $per){        
       self::money();
        if ($cu == "C."):
            $price = $pricelist->default->Credits->l1{$per};
            if ($this->credits - $price < 0):
                return FALSE;
            else:
                $sql = "UPDATE server_1_players SET credits = (credits-$price) WHERE playerID=:playerID && userID=:userID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
            endif;
        else:
            $price = $pricelist->default->Uridium->l1->{$per};
            if ($this->uridium - $price < 0):
                return FALSE;
            else:
                $sql = "UPDATE server_1_players SET uri = (uri-$price) WHERE playerID=:playerID && userID=:userID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
            endif;
        endif;
    }
    
    public function upgradeItem($args){
        $prices = '{"default":{"Credits":{"l1":{"5":125000,"10":225000,"15":325000,"20":425000,"25":525000,"30":625000,"35":725000,"40":825000,"45":925000,"50":1025000,'
            . '"55":1125000,"60":1225000,"65":1325000,"70":1425000,"75":1525000,"80":1625000,"85":1725000,"90":1825000,"95":1925000,"100":2025000}},'
            . '"Uridium":{"l1":{"5":200,"10":260,"15":335,"20":425,"25":530,"30":650,"35":785,"40":935,"45":1100,"50":1280,'
            . '"55":1475,"60":1685,"65":1910,"70":2150,"75":2405,"80":2675,"85":2960,"90":3260,"95":3575,"100":3905}}}}';
        $priceList = json_decode($prices);     
        $percent = trim($args['itemUpgradePercent'], "%");
        if(self::priceCalUpgrade($args['itemID'], $priceList, $percent)){
            $rdm = rand(1,100);
            if($rdm<=$percent){
                $_SESSION['Upgradeings'][$args['itemID']]['success'] = 1;
                   $sqli = "UPDATE `server_1_player_all_items` SET LV = LV + 1 WHERE playerID=? && id=?";
                    $stmt = $this->con->prepare($sqli);
                    $stmt->bindParam(1, $this->pid, PDO::PARAM_STR);
                    $stmt->bindParam(2, $args['itemID'], PDO::PARAM_INT);
                    $stmt->execute();
                    return TRUE;
            }else{
                $_SESSION['Upgradeings'][$args['itemID']]['success'] = 0;
                return TRUE;
            }
        }else{
           return FALSE;
        }
        
    }
}
?>