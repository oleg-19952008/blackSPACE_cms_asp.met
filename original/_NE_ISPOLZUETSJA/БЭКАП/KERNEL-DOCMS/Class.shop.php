<?php
@session_start;
/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);

class shop{

    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    public $uridium;
    public $credits;
    private $hid;
    public $totalAmmount;
	public $premium;
	private $itemInformation;
	private $cuId;
	private $newID;

    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con = $GLOBALS['DB'];
		
    }


    public function setId($uid, $pid, $premium=null) {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->uid = $uid;
        $this->pid = $pid;
		$this->premium = $_SESSION['premium'];
        self::money();
    }

    private function checkExistence($lootid) {
        $stmt = $this->con->prepare("SELECT id FROM server_1_player_all_items WHERE userID = ? && playerID = ? && lootid = ?");
        $stmt->bindParam(1, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(3, $lootid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($result)) {
			$this->cuId = $result;
                return true;
            } else {
                return false;
            }
        }
    }

    public function HangarId() {
        $stmt = $this->con->prepare("SELECT hangarID FROM server_1_hangar WHERE userID=:userID && playerID=:playerID LIMIT 1");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($result)) {
                $this->hid = $result[0]->hangarID;
            }
        }
    }
    
    /* mXac : Max Ammo Calculator
     * Calculates max ammunition you can buy.
     */
    public function mXac($lootid, $w, $x){
        $tAmmo = self::countAllAmmoLaser($w);
        self::HangarId();
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId WHERE server_1_player_all_items.userID=:userID && server_1_player_all_items.playerID=:playerID && server_1_player_all_items.lootid=:lootid LIMIT 1");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($result)){
                 if($lootid=="ammunition_laser_rsb-75"){
                    $ammoArg = self::GetAmmoPrice($lootid);
                    if($ammoArg[0]['ucd']=="u"){
                       $totalFU = $this->uridium/$ammoArg[0]['buy']; 
                    }elseif($ammoArg[0]['ucd']=="c"){
                       $totalFU = $this->credits/$ammoArg[0]['buy'];
                    }else{
                        $totalFU = $this->uridium/$ammoArg[0]['buy'];
                    }
                    $totalFU = $this->uridium/$ammoArg[0]['buy'];
                    return round($totalFU);
                }else{
                    $ammoArg = self::GetAmmoPrice($lootid);
                    $tAmmo = self::countAllAmmoLaser($w);
                    $cShip = self::currentShip($x);
                    $this->totalAmmount = $cShip-$tAmmo;
                    if($ammoArg[0]['ucd']=="u"){
                       $totalFU = $this->uridium/$ammoArg[0]['buy']; 
                    }elseif($ammoArg[0]['ucd']=="c"){
                       $totalFU = $this->credits/$ammoArg[0]['buy'];
                    }else{
                        $totalFU = $this->uridium/$ammoArg[0]['buy'];
                    }
                    if($this->totalAmmount < 0){
                       return 0; 
                    }else{  
                        if($this->totalAmmount<$totalFU){
                            return round($totalFU);
                        }else{
                            return round($this->totalAmmount);
                        }
                    }
                }
            }else{
                $ammoArg = self::GetAmmoPrice($lootid);
                if($lootid=="ammunition_laser_rsb-75"){                    
                    $totalFU = $this->uridium/$ammoArg[0]['buy'];
                    return round($totalFU);
                }else{
                    $tAmmo = self::countAllAmmoLaser($w);
                    $cShip = self::currentShip($x);
                    $this->totalAmmount = $cShip-$tAmmo;
                    if($ammoArg[0]['ucd']=="u"){
                       $reTo = $this->uridium/$ammoArg[0]['buy']; 
                    }elseif($ammoArg[0]['ucd']=="c"){
                       $reTo = $this->credits/$ammoArg[0]['buy'];
                    }else{
                        $reTo = $this->uridium/$ammoArg[0]['buy'];
                    }
                    if($this->totalAmmount < 0){
                       return 0; 
                    }else{
                       if($this->totalAmmount>$reTo){
                           return round($reTo);
                        }else{
                            return round($this->totalAmmount);
                        }
                    }
                }
            }
        }
    }
    
    public function spaceleft($w){
        $space = self::currentShip($w);
        if($w=="Rockets"){            
            $tAmmo = self::countAllAmmoLaser('ammunition_rocket');
        }else{
            $tAmmo = self::countAllAmmoLaser('ammunition_laser_');
        }
        if($tAmmo < 0){
           return 0; 
        }else{
           return $space - $tAmmo;
        }
    }
    
    public function currentShip($w){
        self::HangarId();
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_hangar_general_ship INNER JOIN ships ON server_1_player_hangar_general_ship.ship_selected_model=ships.type WHERE server_1_player_hangar_general_ship.hangarID=:hangarID && server_1_player_hangar_general_ship.playerID=:playerID LIMIT 1");
        $stmt->bindParam(':hangarID', $this->hid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             return $result[0][$w];
        }
    }
    
    private function countAllAmmoLaser($lookup){
        $term = "%$lookup%";
        $nr = "ammunition_laser_rsb-75";
            $stmt = $this->con->prepare("SELECT * FROM server_1_player_all_items WHERE lootid LIKE :sr && lootid!=:nr && playerID=:playerID ");
            $stmt->bindParam(':sr', $term, PDO::PARAM_STR);
            $stmt->bindParam(':nr', $nr, PDO::PARAM_STR);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
             if ($stmt->execute()) {
                 $total = 0;
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($result as $k => $v){
                    $total += $v['Q'];
                }
                
                return $total;
            }        
    }
    
    private function GetAmmoPrice($lootid){
        $stmt = $this->con->prepare("SELECT * FROM server_shop_items WHERE lootId=:lootid LIMIT 1");
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    
    public function ship($id) {
	if(self::blockIDs($id)){
			$message = '{"result":"error","message":"S.H.I.E.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}
        $sqli = "SELECT Name, type FROM ships WHERE Id = :shipid";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam("shipid", $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
//            print_r($result);
//            exit;
            if (self::checkExistence($result[0]->type)) {
                $message = '{"result":"error","message":"You already have this type of ship in your inventory.<br \/> To be able to purchase another one of these ships, move the ship from your inventory to the hangar hall.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
            } else {
                if (self::priceCal($result[0]->type, 1)):
                    return self::itemReg($id, 'ship', $result[0]->type, $result[0]->Name, 1, 1, 0, 1);
                 else:
                    $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                    return $message;
                endif;
            }
        }
    }
    public function model($am, $id) {
	if(self::blockIDs($id)){
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}
	$am = (int)preg_replace("/[^0-9]/", "", $am);
        $exploded = explode("_", $id);
        $name = end($exploded);
        if (self::priceCal($id, 1)):
            return self::itemReg($id, 'model', $id, $name,  $am, 1, 0, 1);
        else:
            $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
        endif;
    }
    public function dronePrice($type){
        $drones = array("iris"=>array(15000,24000,42000,60000,84000,96000,126000,200000,1250000,1500000), "flax"=>array(100000,200000,400000,800000,1600000,3200000,6400000,12800000),"apis"=>array(1250000),"zeus"=>array(1500000));
	    $lootid = "drone_".$type;
        $sqli = "SELECT * FROM server_1_player_all_items WHERE lootid=:lootid && playerID=:playerID && userID=:userID";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
                $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $i = $stmt->rowCount();
            if($i!=10){
                return $drones[$type][$i];
            }else{
                return 0;
            }
        }else{
            return 10000;
        }
    }
	
	 public function cPT() {
        if (time() < strtotime($this->premium)) {
            return TRUE; // Still premium
        } else {
            return FALSE; // Not premium
        }
    }
	
    private function priceCal($lootId, $c) {
	if(self::blockIDs($lootId)){
		$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
        return $message;
	}
        if($c<0):
            return FALSE;
        endif;
        $q = preg_replace("/[^0-9]/", "",$c);
        $q = intval($q);
        self::money();
        $sqli = "SELECT * FROM server_shop_items WHERE lootId = :lid LIMIT 1";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(":lid", $lootId, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$this->itemInformation = $result[0];
        if($lootId=="drone_iris"):
            $price = self::dronePrice("iris");
            elseif($lootId=="drone_flax"):
            $price = self::dronePrice("flax");
			   elseif($lootId=="drone_apis"):
            $price = self::dronePrice("apis");
				   elseif($lootId=="drone_zeus"):
            $price = self::dronePrice("zeus");
            else:
            $price = $result[0]['buy'] * $q;
        endif;
        if ($result[0]['ucd'] == "c"):
            if ($this->credits - $price < 0):
                return FALSE;
            else:
			if(self::cPT()){
				$eprice = ($price/100)*95;
				$after = $this->credits - $eprice . "-5%";
			}else{
				$eprice = $price;
				$after = $this->credits - $eprice; 
			}
                //$list = "-$eprice Before: $this->credits after: $after | Item: $lootId  | Amount: $q";
                //DB::pmc($this->pid, $list, "credits");
                $sql = "UPDATE server_1_players SET credits = (credits-$eprice) WHERE playerID=:playerID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
            endif;
        elseif ($result[0]['ucd'] == "u"):
            if ($this->uridium - $price < 0):
                return FALSE;
            else:
			if(self::cPT()){
				$eprice = ($price/100)*95;
				$after = $this->uridium - $eprice . "-5%";
			}else{
				$eprice = $price;
				$after = $this->uridium - $eprice; 
			}
                //$list = "-$eprice Before: $this->uridium after: $after | Item: $lootId  | Amount: $q";
                //DB::pmc($this->pid, $list, "uridium");
                $sql = "UPDATE server_1_players SET uri = (uri-$eprice) WHERE playerID=:playerID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
            endif;
        elseif ($result[0]['ucd'] == "x"):
           return FALSE;
        else:
            return FALSE;
        endif;
    }

    public function guns($amw, $id) {
	if(self::blockIDs($id)){
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}	
        $am = preg_replace("/[^0-9]/", "", $amw);
		if(ctype_digit($am)){
        $exploded = explode("_", $id);
        $name = end($exploded);
        if (self::priceCal($id, $am)):
            return self::itemReg($id, 'weapon', $id, $name, $am, 0, 1, 1);
        else:
            $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
        endif;
		}else{
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
		}
    }
	private function blockIDs($id){
		$blocked = array("equipment_weapon_laser_lf-6","police_ship");
		if(in_array($id, $blocked)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	private function updateAmmo($am, $full){
		$sqli = "UPDATE server_1_player_ammunation SET $full = ($full+$am) WHERE playerID=:pid";
		$stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':pid', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
				$message = '{"result":"success","message":"' . $am . 'x ammunition: \"' . $name . '\" purchased.<br \/><br \/>","showEquipOption":false,"userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":100000000,"rocketSpace":100000000},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ammunition"}';
                return $message;
		}else{
				$message = '{"result":"error","message":"S.H.E.I.L.D. found a bug on your account, contact staff.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
        return $message;
		}
	}
    public function battery($amw, $id) {
	/*$m essage = '{"result":"error","message":"S.H.E.I.L.D. is troubleshooting.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
    return $message;
	exit; */
	if(self::blockIDs($id)){
		$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
        return $message;
	}
	$ammoClassing = array(
	'ammunition_laser_lcb-10'=>'lcb10',
	'ammunition_laser_mcb-25'=>'mcb25',
	'ammunition_laser_mcb-50'=>'mcb50',
  'ammunition_laser_ucb-100'=>'ucb100',
  'ammunition_laser_sab-50'=>'sab50',
  'ammunition_laser_rsb-75'=>'rsb75',
  'ammunition_rocket_r-310'=>'r310',
  'ammunition_rocket_plt-2026'=>'plt2026',
  'ammunition_rocket_plt-2021'=>'plt2021',
  'ammunition_rocket_plt-3030'=>'plt3030',
  'ammunition_specialammo_pld-8'=>'pld8',
  'ammunition_specialammo_dcr-250'=>'dcr250',
  'ammunition_specialammo_wiz-x'=>'wizx',
  'ammunition_rocketlauncher_hstrm-01'=>'hstrm01',
  'ammunition_rocketlauncher_ubr-100'=>'ubr100',
  'ammunition_rocketlauncher_eco-10'=>'eco10',
  'ammunition_mine_acm-01'=>'acm01',
  'ammunition_mine_empm-01'=>'empm01',
  'ammunition_mine_sabm-01'=>'sabm01',
  'ammunition_mine_ddm-01'=>'ddm01',
  'ammunition_specialammo_smb01'=>'smb01',
  'ammunition_specialammo_ish01'=>'ish01',
  'ammunition_specialammo_emp-01'=>'emp01',
  'ammunition_firework_fwx-s'=>'fwxs',
  'ammunition_firework_fwx-m'=>'fwxm',
  'ammunition_firework_fwx-l'=>'fwxl'
	);
	$am = preg_replace("/[^0-9]/", "", $amw);
	if(ctype_digit($am)){
        $exploded = explode("_", $id);
        $name = end($exploded);
		if($id=="ammunition_laser_mcb-25" && $am % 2 != 0){
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}
		$n = explode("-", $name);
            if (self::priceCal($id, $am)){
                //return self::updateAmmo($am, $ammoClassing[$id]);
                 if (self::checkExistence($id)) {
                  return self::itemReg($id, 'ammo', $id, $name, $am, 0, 0, 0);
                }else{
                  return self::itemReg($id, 'ammo', $id, $name, $am, 0, 0, 1);
                  }
                  }  
            }else{
                $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
           }}
	
    public function petPet($amw, $id, $name) {
	if(self::blockIDs($id)){
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}
	$message = '{"result":"error","message":"S.H.E.I.L.D. has disabled PET. ","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
	return $message;
	
	$am = preg_replace("/[^0-9]/", "", $amw);
	if(ctype_digit($am)){
        if (self::checkExistence($id)) {
              $message = '{"result":"error","message":"You already got a pet","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
        }else {
             if (self::priceCal($id, $am)):
                 self::itemReg($id, 'ship', $id, $name, 1, 1, 0, 1);
                 return self::regPet($id, $name);
            else:
                $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
            endif;
            
        }
		}else{
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
		}
    }
    private function regPet($lootid, $name){
        $sqli = "SELECT id FROM server_1_player_all_items WHERE lootid=:lootid && playerID=:playerID && userID=:userID ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return self::CreatePet($result[0]->id, $name, $lootid);
        }
    }
     private function CreateConfigPet($pet_id, $lootid) {
         for($i = 1; $i <= 2; $i++){
             $sql = "INSERT INTO server_1_hangar_config_pet10 ('hangarID', 'petID', 'playerID', 'userID', 'configNum') VALUES (?, ?, ?, ?, ?)";
             $stmt = $this->con->prepare($sql);
             $stmt->bindParam(1, $this->hid, PDO::PARAM_INT);
             $stmt->bindParam(2, $pet_id, PDO::PARAM_INT);
             $stmt->bindParam(3, $this->pid, PDO::PARAM_INT);
             $stmt->bindParam(4, $this->uid, PDO::PARAM_INT);
             $stmt->bindParam(5, $i, PDO::PARAM_INT);
             $stmt->execute();
         }
         $message = '{"result":"success","message":"You bought 1 pet<br \/><br \/>","showEquipOption":false,"userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":100000000,"rocketSpace":100000000},"isShipDumpEmpty":false,"itemId":"' . $lootid . '","category":"drone"}';
         return $message;
        
    }
    private function my_pet_id($item_id)
    {
        $stmt = $this->con->prepare("SELECT pet_id FROM server_1_player_pet10 WHERE userID = ? && playerID = ? && item_id = ?");
        $stmt->bindParam(1, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(3, $item_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result[0]->pet_id;
        }
    }
     private function CreatePet($id, $name, $lootid) {
         $co = "4|8|3|4";
        $sql = "INSERT INTO server_1_player_pet10 ('pet_name', 'lockedSlots', 'item_id', 'userID', 'playerID') VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $co, PDO::PARAM_STR);
        $stmt->bindParam(3, $id, PDO::PARAM_INT);
        $stmt->bindParam(4, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(5, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return self::CreateConfigPet(self::my_pet_id($id), $lootid);
        }
    }
    public function special($amw, $id) {
	if(self::blockIDs($id)){
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}
	$am = preg_replace("/[^0-9]/", "", $amw);
	if(ctype_digit($am)){
        $exploded = explode("_", $id);
        $name = end($exploded);
        if (self::priceCal($id, $am)){
            if($id=="resource_booty-key" || $id=="resource_logfile"){
                if (self::checkExistence($id)) {
                  return self::itemReg($id, 'special', $id, $name, $am, 0, 0, 0);
                }else{
                  return self::itemReg($id, 'special', $id, $name, $am, 0, 1, 1);  
                }
            }else{
                return self::itemReg($id, 'special', $id, $name, $am, 0, 1, 1);
            }
        }else{
            $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
        }
		}else{
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
		}
    }
     public function generator($amw, $id) {
	 if(self::blockIDs($id)){
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}
	 $am = preg_replace("/[^0-9]/", "", $amw);
	if(ctype_digit($am)){
        $exploded = explode("_", $id);
        $name = end($exploded);
        if (self::priceCal($id, $am)):
            return self::itemReg($id, 'generator', $id, $name, $am, 0, 1, 1);
        else:
            $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
        endif;
		}else{
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
            return $message;
		}
    }
    private function droneReg($lootid) {
            self::CreateConfig($this->newID);
            if ($lootid == "drone_flax"):
                return self::CreateDrone($this->newID, "credits", $lootid);
            else:
                return self::CreateDrone($this->newID, "uridium", $lootid);
            endif;
    }

    private function CreateConfig($id) {
        $sql = "INSERT INTO `server_1_hangar_config_drones` (`playerID`, `userID`, `hangarID`, `item_id`) VALUES (?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->hid, PDO::PARAM_INT);
        $stmt->bindParam(4, $this->newID, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function CreateDrone($id, $currency, $lootid) {
        $sql = "INSERT INTO server_1_player_drones (`item_sale_id`, `drone_currency`, `userID`, `playerID`, `drone_kind`, `drone_design`) VALUES (?, ?, ?, ?, ?, '')";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $this->newID, PDO::PARAM_INT);
        $stmt->bindParam(2, $currency, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(5, $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $names = explode("_", $lootid);
            $name = $names[1];
            $message = '{"result":"success","message":"You bought 1x ' . $name . ' <br \/><br \/>","showEquipOption":false,"userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":100000000,"rocketSpace":100000000},"isShipDumpEmpty":false,"itemId":"' . $lootid . '","category":"drone"}';
            return $message;
        }
    }
    
    public function drone($id) {
	if(self::blockIDs($id)){
			$message = '{"result":"error","message":"S.H.E.I.L.D. does not allow this.","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
			return $message;
		}
        if ($id == 1) {
            if (self::priceCal('drone_flax', 1)):
                 self::itemReg('drone_flax', 'drone', 'drone_flax', 'Flax', 1, 1, 0, 1);
                 return self::droneReg('drone_flax');
            else:
                $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
            endif;
            
        }elseif ($id == 2) {
            if (self::priceCal('drone_iris', 1)):
                self::itemReg('drone_iris', 'drone', 'drone_iris', 'Iris', 1, 1, 0, 1);
                return self::droneReg('drone_iris');
            else:
                $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
            endif;
            }elseif ($id == 3) {
            if (self::priceCal('drone_apis', 1)):
                self::itemReg('drone_apis', 'drone', 'drone_apis', 'apis', 1, 1, 0, 1);
                return self::droneReg('drone_apis');
            else:
                $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
            endif;
			     }elseif ($id == 4) {
            if (self::priceCal('drone_zeus', 1)):
                self::itemReg('drone_zeus', 'drone', 'drone_zeus', 'zeus', 1, 1, 0, 1);
                return self::droneReg('drone_zeus');
            else:
                $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                return $message;
            endif;
        }else {
            $exploded = explode("_", $id);
            $name = end($exploded);
            if (self::checkExistence($id)) {
                $message = '{"result":"success","message":"You already own this item. <br \/><br \/>","showEquipOption":false,"userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":100000000,"rocketSpace":100000000},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"' . $what . '"}';
                return $message;
            } else {
                if (self::priceCal($id, 1)):
                    self::itemReg($id, 'drone', $id, $name, 1, 1, 0, 1);
					return self::droneReg('drone_iris');
                else:
                    $message = '{"result":"error","message":"You have not money enough!","userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":0,"rocketSpace":0},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"ship"}';
                    return $message;
                endif;
            }
        }
    }

    public function money() {
        $stmt = $this->con->prepare("SELECT uri, credits FROM server_1_players WHERE userID=:userID && playerID=:playerID");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->uridium = $result[0]->uri;
            $this->credits = $result[0]->credits;
        }
    }

    private function itemReg($id, $what, $lootId, $name, $am, $inter, $Count, $add) {
        self::money();		
        $zero = 0;
        $ch = array('equipment_extra_cpu_cl04k-m'=>10,'equipment_extra_cpu_cl04k-xl'=>50,'equipment_extra_cpu_jp-02'=>20,'equipment_extra_cpu_jp-01'=>10);
        if ($Count != 0) {
            $Q = 1;
        } else {
            $Q = $am;
        }
        $in = $inter;
        if ($add != 0) {
			if(array_key_exists($lootId, $ch)){
				  $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`, `charge`) VALUES (?, ?, ?, ?, ?, ?)";
				}else{
					$sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
			}
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(1, $lootId, PDO::PARAM_STR);
            if($id!="resource_booty-key" || $id!="resource_logfile"):                
                $stmt->bindParam(2, $Q, PDO::PARAM_INT);
            else:
				$stmt->bindParam(2, $am, PDO::PARAM_INT);
                
            endif;
            $stmt->bindParam(3, $in, PDO::PARAM_INT);
            $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(5, $this->uid, PDO::PARAM_INT);
            if(array_key_exists($lootId, $ch)){
                $stmt->bindParam(6, $ch[$lootId], PDO::PARAM_INT);
            }else{
                
            }
            
            if ($Count != 0) {
                if($id!="resource_booty-key" || $id!="resource_logfile"):
					for ($i = 1; $i <= $am; $i++) {
						$stmt->execute();
						$iId = $this->con->lastInsertId();
						$this->newID = $iId;
						if($this->itemInformation['ucd']=="c"){
							$list = "11|0|".$this->itemInformation['buy']."|$iId|1";
							DB::pmc($this->pid, $list, "credits");					
						}else{
							$list = "12|0|".$this->itemInformation['buy']."|$iId|1";
							DB::pmc($this->pid, $list, "uridium");
						}
					}
                else:				
				    $stmt->execute();
					$iId = $this->con->lastInsertId();
					$this->newID = $iId;
					if($this->itemInformation['ucd']=="c"){
						$list = "11|0|".$this->itemInformation['buy']*$Q."|$iId|$Q";
						DB::pmc($this->pid, $list, "credits");					
					}else{
						$list = "12|0|".$this->itemInformation['buy']*$Q."|$iId|$Q";
						DB::pmc($this->pid, $list, "uridium");
					}
                endif;
                $message = '{"result":"success","message":"' . $am . 'x ' . $what . ': \"' . $name . '\" purchased.<br \/><br \/>","showEquipOption":false,"userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":100000000,"rocketSpace":100000000},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"' . $what . '"}';
                return $message;
            } else {
                if ($stmt->execute()) {
				$iId = $this->con->lastInsertId();
				$this->newID = $iId;
				if($this->itemInformation['ucd']=="c"){
					$list = "11|0|".$this->itemInformation['buy']."|$iId|1";
					DB::pmc($this->pid, $list, "credits");					
				}else{
					$list = "12|0|".$this->itemInformation['buy']."|$iId|1";
					DB::pmc($this->pid, $list, "uridium");
				}
                    $message = '{"result":"success","message":"' . $am . 'x ' . $what . ': \"' . $name . '\" purchased.<br \/><br \/>","showEquipOption":false,"userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":100000000,"rocketSpace":100000000},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"' . $what . '"}';
                    return $message;
                } else {
                    print_r($stmt->errorInfo());
                    exit;
                }
            }
        } else {
            $sqli = "UPDATE `server_1_player_all_items` SET Q = Q + $Q WHERE playerID=? && lootid=?";
            $stmt = $this->con->prepare($sqli);
            $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(2, $lootId, PDO::PARAM_STR);
            if ($stmt->execute()) {
				if($this->itemInformation['ucd']=="c"){
						$list = "11|0|".$this->itemInformation['buy']*$Q."|".$this->cuId[0]->id."|$Q";
						DB::pmc($this->pid, $list, "credits");					
					}else{
						$list = "12|0|".$this->itemInformation['buy']*$Q."|".$this->cuId[0]->id."|$Q";
						DB::pmc($this->pid, $list, "uridium");
					}
                $message = '{"result":"success","message":"' . $am . 'x ' . $what . ': \"' . $name . '\" purchased.<br \/><br \/>","showEquipOption":false,"userBalance":{"uridium":' . $this->uridium . ',"credits":' . $this->credits . '},"userShip":{"laserAmmunitionSpace":100000000,"rocketSpace":100000000},"isShipDumpEmpty":false,"itemId":"' . $id . '","category":"' . $what . '"}';
                return $message;
            } else {
                print_r($stmt->errorInfo());
                exit;
            }
        }
    }

}

?>