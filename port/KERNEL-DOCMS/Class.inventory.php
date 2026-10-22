<?php

//If the system has issues with remembering the Json inventory
/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */

/* * ******************************** */
/* Out comment lines in this area   */
ini_set('display_errors', '1');  /**/
error_reporting(E_ALL);          /**/
/* * ******************************** */
// DB Class IMPORTANT!

class inventory{
    /* Everything the script needs to keep track */

    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    private $lootids = array();
    private $itemInfo = array();
    private $items = array();
    private $SM;
    private $money;
    private $hangars = array();
    private $hasPet;
    private $params;
    private $json;
    private $equipment;
    private $totalSlots;
    private $pie;
    private $droneEquip = FALSE;
    private $cpuslot;
    private $cpuFilled = false;
    private $s;
    private $cuCpu = null;

    /* Constructor does everything that needs to be done at every load */

    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con = $GLOBALS['DB'];
    }

    public function setId($uid, $pid) {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->uid = $uid;
        $this->pid = $pid;
       
        
    }

    public function droneEquip($i) {
        $this->droneEquip = $i;
    }

    public function getItemInfo() {
        return $this->itemInfo;
    }

    public function getItemsList() {
        return $this->items;
    }

    public function getLootIds() {
        return $this->lootids;
    }

    public function getJson() {
        return $this->json;
    }

    public function submitParams($params) {
        $this->params = json_decode($params);
    }

    public function init() {
        $mainInfo = self::getMainInfo();
        $json = new stdClass();
        $json->isError = 0;
        $json->data = new stdClass();
        $json->data->ret = new stdClass();
        $json->data->money = new stdClass();
        $json->data->map = new stdClass();
        /*
         *  FILTERS 
         */
        $json->data->ret->filters = new stdClass();
        /*  WEAPONS  */
        $json->data->ret->filters->weapons = array(0, 1, 2);
        /*  GENERATORS  */
        $json->data->ret->filters->generators = array(3, 4, 5);
        /*  EXTRAS  */
        $json->data->ret->filters->extras = array(6, 7, 8, 9, 10, 11);
        /*  AMMUNITION  */
        $json->data->ret->filters->ammunition = array(12, 13, 14);
        /*  RESOURCES  */
        $json->data->ret->filters->resources = array(15);
        /*  DRONE RELATED  */
        $json->data->ret->filters->drone_related = array(16, 17);
        /*  MODUELS  */
        $json->data->ret->filters->modules = array(18);
        /*  PET RELATED  */
        $json->data->ret->filters->pet_related = array(19, 20);

        $json->data->money = self::getMoney();
        /*
         *  ITEM RELATED
         */
        $json->data->ret->hangars = self::hangarGenerator();
        self::itemLootIdGenerator();
        $json->data->ret->items = self::getItemsList();
        $json->data->ret->itemInfo = self::getItemInfo();
        $json->data->ret->userinfo = new stdClass();
        $json->data->ret->userinfo->factionRelated = $mainInfo;
        $json->data->map->types = self::getTypes();
        $json->data->map->lootIds = self::getLootIds();
        return $json;
    }

    private function CompleteTrans($m, $ret, $update = null) {
        if ($ret == 2):
            $jsn = json_decode('{"isError":0,"data":{"ret":[]}}');
            foreach ($m as $k => $r):
                array_push($jsn->data->ret, $r);
            endforeach;
        elseif ($ret == 1):
            $jsn = json_decode('{"isError":0,"data":{"ret":1}}');
        else:
            $jsn = json_decode('{"isError":0,"data":{"ret":0}}');
        endif;
        $jsn->data->money = $this->money;
        if ($update != null) {
            $jsn->data->update = new stdClass();
            $jsn->data->update->slotCpuMove = array();
            foreach ($m as $b => $v) {
                array_push($jsn->data->update->slotCpuMove, $v);
            }
        }
        return base64_encode(json_encode($jsn));
    }

    public function errorTrans($message) {
        $jsn = json_decode('{"isError":1,"data":{"ret":0,"money":{"uridium":"","credits":""}},"error":{"message":"' . $message . '"}}');
        $jsn->data->money->uridium = $this->money->uridium;
        $jsn->data->money->credits = $this->money->credits;
        return base64_encode(json_encode($jsn));
    }

    private function checkMinus($id, $tran = NULL) {        
        $sqli = "DELETE FROM server_1_player_all_items WHERE Q < 1 && id=:id";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            switch ($tran):
                case 1:
                    $jsn = json_decode('{"isError":0,"data":{"ret":1,"update":{"deleted":["' . $id . '"],"slotCpuMove":{"1":[],"2":[]}}}}');
                    break;
                case 2:
                    $jsn = json_decode('{"isError":0,"data":{"slotCpuMove":{"1":[],"2":[]},"ret":1,"money":{"uridium":"' . $this->money->uridium . '","credits":"' . $this->money->credits . '"}}}');
                    break;
                default:
                    $jsn = json_decode('{"isError":0,"data":{"ret":1,"update":{"deleted":["' . $id . '"],"slotCpuMove":{"1":[],"2":[]}}}}');
            endswitch;
            $jsn->data->money = $this->money;
            return base64_encode(json_encode($jsn));
        }else {
            return self::errorTrans('Something went wrong!');
        }
    }

    public function renamePet() {
        $newName = $this->params->name;
        $left = $this->money->uridium - 3000;
        if ($left > 0):
            DB::pmc($this->pid, "Renaming pet failed", "error");
            return self::errorTrans("You do not have uridium enough!");
        else:
            $sql = "UPDATE server_1_players SET uri = (uri-3000) WHERE playerID=:playerID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            if ($stm->execute()) {
                DB::pmc($this->pid, "-3000 uridium | pet renamed", "uridium");
                return self::setName($newName);
            } else {
                return self::errorTrans("Something went wrong");
            }

        endif;
    }

    private function setName($name) {
        $sqli = "UPDATE server_1_player_pet10 SET pet_name = :name WHERE playerID=:playerID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            DB::pmc($this->pid, "Pet name changed to: ".$name, "equipment");
            return self::CompleteTrans(null, 1);
        } else {
            return self::errorTrans("Something went wrong");
        }
    }

    private function cashOut($itemId, $q) {
        $sqli = "SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootid WHERE server_1_player_all_items.id = :id";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $price = $result[0]['sell'] * $q;
        if ($result[0]['scd'] == "c"):
            DB::pmc($this->pid, "+$price credits | sold $q x $itemId", "credits");
            $sql = "UPDATE server_1_players SET credits = (credits+$price) WHERE playerID=:playerID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            if ($stm->execute()):
                return TRUE;
            else:
                return FALSE;
            endif;
        elseif ($result[0]['scd'] == "u"):
            DB::pmc($this->pid, "+$price uridium | sold $q x $itemId", "uridium");
            $sql = "UPDATE server_1_players SET credits = (uri+$price) WHERE playerID=:playerID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            if ($stm->execute()):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            DB::pmc($this->pid, "+$price credits | sold $q x $itemId", "credits");
            $sql = "UPDATE server_1_players SET credits = (credits+$price) WHERE playerID=:playerID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            if ($stm->execute()):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }
    
    private function checkDB($id){
        $sql = "SELECT Q FROM server_1_player_all_items WHERE playerID=:playerID && id=:id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
		$stm->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stm->execute()):
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['Q'];
        endif;
    }
    
    
    public function sell($tran = NULL) {
        $itemID = $this->params->itemId;
        if(self::checkItemsOwnerShip($itemID)){              
        $q = $this->params->quantity;
        if(!is_numeric($q)){
            return self::errorTrans('Something went wrong!');
        }else{
            $pq = self::checkDB($itemID);        
			if($q>$pq){
                $q = $pq;
            }
            $sqli = "UPDATE server_1_player_all_items SET Q = (Q -$q) WHERE id = :id";
            $stmt = $this->con->prepare($sqli);
            $stmt->bindParam(':id', $itemID, PDO::PARAM_INT);
            if ($stmt->execute()) {			
				self::cashOut($itemID, $q);
                if (!empty($tran) OR $tran != NULL):
                    return self::checkMinus($itemID, $tran);
                else:
                    return self::checkMinus($itemID);
                endif;
            }else {
                return self::errorTrans('Something went wrong!');
            }
       }
      }else{
          return self::errorTrans('Cheating is no allowed!');
      }
    }
    
    private function checkItemsOwnerShip($itemID){
        $sql = "SELECT id FROM server_1_player_all_items WHERE id=:id && playerID=:playerID";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $itemID, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($result)){
            return true;
        }else{
            return false;
        }
    }
    
    private function DelDrone($itemID) {
        $sql = "DELETE FROM server_1_hangar_config_drones WHERE item_id = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $itemID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function sellDrone() {
        $itemID = $this->params->itemId;
		
        if(self::checkItemsOwnerShip($itemID)){   
				$stmt = $this->con->prepare("DELETE FROM server_1_player_drones WHERE item_sale_id = :id");
				$stmt->bindParam(':id', $itemID, PDO::PARAM_INT);
				$stmt->execute();
			self::DelDrone($itemID);
			return self::sell(2);
        }else{
            return self::errorTrans('Cheating is no allowed!');
        }
    }

    private function wipeDrone($drone) {
        $sqli = "UPDATE server_1_hangar_config_drones SET $drone = '', design = '' WHERE ";
        $sqli .= "playerID=:playerID && hangarID=:hangarID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return self::CompleteTrans(null, 1);
        } else {
            return self::errorTrans('Something went wrong!');
        }
    }

    public function wipeConfigs() {
        if ($this->params->configID == 1) {
            $drone = "EQ";
        } else {
            $drone = "EQ2";
        }
        $sqli = "UPDATE server_1_hangar_config_ship AS s SET s.lasers = '', s.generators = '', s.heavy_guns = '', s.extras = '' WHERE ";
        $sqli .= " s.playerID=:playerID && s.configNum=:configNum && s.hangarID=:hangarID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':configNum', $this->params->configID, PDO::PARAM_INT);
        $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return self::wipeDrone($drone);
        } else {
            return self::errorTrans('Something went wrong!');
        }
    }

    public function changeShipModel() {
        $sql = "UPDATE server_1_player_hangar_general_ship SET ship_selected_model=:shipmodel WHERE playerID=:playerID && hangarID=:hangarID";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':shipmodel', $this->params->lootId, PDO::PARAM_STR);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return self::CompleteTrans(null, 1);
        } else {
            return self::errorTrans('Something went wrong!');
        }
    }

    private function addToDB($arrays, $target, $what, $drone_id = NULL) {
	$array = array_map('unserialize', array_unique(array_map('serialize', $arrays))); 
	foreach($array as $kne => $vln){
	if(self::checkItemsOwnerShip($vln)){ 
	
		}else{
			return self::errorTrans('Do NOT cheat!');
		}
	}
	
        if ($what == "design") {
            $imp = $array[0];
        } else {
            $imp = implode("|", $array);
        }
        if ($this->params->to->target == "drone"):
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && hangarID=:hangarID && item_id=:item_id";
        else:
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && hangarID=:hangarID && configNum=:configNum";
        endif;
        $stmt = $this->con->prepare($sql);
        if ($this->params->to->target == "drone"):
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            if ($drone_id != NULL OR ! empty($drone_id)):
                $stmt->bindParam(':item_id', $drone_id, PDO::PARAM_INT);
            else:
                $stmt->bindParam(':item_id', $this->params->to->droneId, PDO::PARAM_INT);
            endif;

        else:
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':configNum', $this->params->to->configId, PDO::PARAM_INT);
        endif;
        if ($stmt->execute()) {
            return self::CompleteTrans(null, 1);
        } else {
            return self::errorTrans('Something went wrong!');
        }
    }

    private function delFromDb($array, $target, $what) {
        $imp = implode("|", $array);
        
        if ($this->params->from->target == "drone"):
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && hangarID=:hangarID && item_id=:item_id";
        else:
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && hangarID=:hangarID && configNum=:configNum";
        endif;
        $stmt = $this->con->prepare($sql);
        if ($this->params->from->target == "drone"):
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $this->params->from->droneId, PDO::PARAM_INT);
        else:
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':configNum', $this->params->from->configId, PDO::PARAM_INT);
        endif;
        if ($stmt->execute()) {
            return TRUE;
        }
    }

    private function checkInput($what) {
        $re = array('disallowed' => array(), 'allowed' => array());
        if ($what == "heavy_guns") {
            foreach ($this->params->from->items as $key => $value) {
                $sqli = "SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId WHERE server_shop_items.type=1 && server_1_player_all_items.id = :id";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(':id', $value, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($result)) {
                    $re['allowed']['heavy_guns'] = $value;
                } else {
                    $re['disallowed'][$key] = $value;
                }
            }
        } elseif ($what == "lasers") {
            foreach ($this->params->from->items as $key => $value) {
                $sqli = "SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId WHERE server_shop_items.type=0 && server_1_player_all_items.id = :id";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(':id', $value, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $re['allowed'][$key] = $value;
                } else {
                    $re['disallowed'][$key] = $value;
                }
            }
        } elseif ($what == "generators") {
            foreach ($this->params->from->items as $key => $value) {
                $sqli = "SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId WHERE server_1_player_all_items.id = :id AND (server_shop_items.type=3 OR server_shop_items.type=4)";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(':id', $value, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $re['allowed'][$key] = $value;
                } else {
                    $re['disallowed'][$key] = $value;
                }
            }
        } elseif ($what == "extras") {
            foreach ($this->params->from->items as $key => $value) {
                $sqli = "SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid=server_shop_items.lootId WHERE server_1_player_all_items.id = :id AND (server_shop_items.type=7 OR server_shop_items.type=8 OR server_shop_items.type=9 OR server_shop_items.type=10 OR server_shop_items.type=11)";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(':id', $value, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($result)) {
                    $re['allowed'][$result[0]['lootId']] = $value;
                } else {
                    $re['disallowed'][$key] = $value;
                }
            }
        } else {
            $re['disallowed'] = $this->params->from->items;
        }
        return $re;
    }

    /* KAN IKKE HUSKE HVAD JEG GIK IGANG MED HER! */

    private function extrasExits() {
        $this->equipment = self::init();
        $conf = $this->params->to->configId;
        $hi = $this->params->params->hi;
        $extras = array();
        foreach ($this->equipment->data->ret->items as $kr => $vr) {
            array_push($extras, $this->equipment->data->map->lootIds[$vr->L]);
        }
    }

    private function cpuSlots($equipment, $target) {
        $conf = $this->params->to->configId;
        $hi = $this->params->params->hi;
        $cpu = array();
        foreach ($this->equipment->data->ret->items as $kr => $vr) {
            if (strpos($this->equipment->data->map->lootIds[$vr->L], 'equipment_extra_cpu_sle-0') !== FALSE) {
                $cpu[$vr->I] = $this->equipment->data->map->lootIds[$vr->L];
            } else {
                
            }
        }
        foreach ($this->equipment->data->ret->hangars as $key => $hangs) {
            if ($hangs->hangarID == $hi && isset($hangs->config->{$conf}->ship->EQ->extras) && !empty($hangs->config->{$conf}->ship->EQ->extras)) {
                foreach ($hangs->config->{$conf}->ship->EQ->extras as $kp => $vp) {
                    if (array_key_exists($vp, $cpu)) {
                        if ($cpu[$vp] == "equipment_extra_cpu_sle-01") {
                            return 2;
                        } elseif ($cpu[$vp] == "equipment_extra_cpu_sle-02") {
                            return 4;
                        } elseif ($cpu[$vp] == "equipment_extra_cpu_sle-03") {
                            return 6;
                        } elseif ($cpu[$vp] == "equipment_extra_cpu_sle-04") {
                            return 10;
                        } else {
                            return 0;
                        }
                    }
                }
            } else {
                
            }
        }
    }

    private function fullSystemCheck($what, $target, $equipment) {
        $s = self::shipspace($what, $target, $equipment);
        if ($target == "drones") {
            if (property_exists($this->params->from, 'droneItems')) {
                $ids = $this->params->from->droneItems;
                $ars = get_object_vars($this->params->from->droneItems);
                $id = key($ars);
            } else {
                $id = $this->params->to->droneId;
            }
            $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && item_id=:item_id";
            $stmt = $this->con->prepare($sqli);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($result[0][$what])) {
                    if (strpos($result[0][$what], '|') !== false) {
                        return FALSE;
                    } else {
                        if ($what == "design" OR $what == "design2"):
                            return FALSE;
                        else:
                            return TRUE;
                        endif;
                    }
                }else {
                    return TRUE;
                }
            } else {
                return FALSE;
            }
        } else {
            $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && configNum=:configNum";
            $stmt = $this->con->prepare($sqli);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':configNum', $this->params->to->configId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($result[0][$what])) {
                    if (strpos($result[0][$what], '|') !== false) {
                        $pie = explode("|", $result[0][$what]);
                        $o = count($pie);
                    } else {
                        $o = 1;
                    }
                } else {
                    return TRUE;
                }
            } else {
                return FALSE;
            }
            if ($what == "extras") {
                if (!self::extrasExits()) {
//                return FALSE;
                }
            }
            $s = self::shipspace($what, $target, $equipment);
            if ($o < $s) {
                if ($what == "extras") {
                    foreach ($this->equipment->data->ret->items as $ke => $ve) {
                        foreach ($this->params->from->items as $ky => $iy) {
                            if ($ve->I == $iy) {
                                if ($this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-04" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-03" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-02" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-01") {
                                    return FALSE;
                                } else {
                                    return TRUE;
                                }
                            }
                        }
                    }
                } else {
                    return TRUE;
                }
            } else {
                return FALSE;
            }
        }
    }

    private function shipspace($what, $target, $equipment, $drone_id = NULL) {
        $eqs = $this->equipment;
        if ($target == "drones") {
            if ($drone_id == NULL OR ! empty($drone_id)) {
                if (property_exists($this->params->from, 'droneItems')) {
                    $ids = $this->params->from->droneItems;
                    $ars = get_object_vars($this->params->from->droneItems);
                    $id = key($ars);
                } else {
                    $id = $this->params->to->droneId;
                }
            } else {
                $id = $drone_id;
            }

            $hay = $eqs->data->ret->hangars[0]->general->{$target};
            foreach ($hay as $ke => $va):
                if ($va->I == $id) {
                    $L = $va->L;
                }
            endforeach;
            $lids = $eqs->data->map->lootIds;
            foreach ($lids as $k => $v):
                if ($k == $L) {
                    $lo = $k;
                }
            endforeach;
            $where = $eqs->data->ret->itemInfo;
            if ($what == "design") {
                $j = $what;
            } else {
                $j = "default";
            }
            foreach ($where as $ke => $va):
                if ($va->L == $lo) {
                    $totalSlots = $va->levels[0]->slotsets->{$j}->Q;
                }
            endforeach;
            return $totalSlots;
        } elseif ($target == "pet10") {
            $L = $eqs->data->ret->hangars[0]->general->pet->L;
            $LV = $eqs->data->ret->hangars[0]->general->pet->LV;
            $LC = $eqs->data->ret->hangars[0]->general->pet->lockedSlots->{$what};
            $where = $eqs->data->ret->itemInfo;
            foreach ($where as $ke => $va):
                if ($va->L == $L) {
                    $totalSlots = $va->levels[$LV]->slotsets->{$what}->Q;
                }
            endforeach;
            $r = $totalSlots - $LC;
            return $r;
        } else {
            $sm = $eqs->data->ret->hangars[0]->general->{$target}->SM;
            $lids = $eqs->data->map->lootIds;
            $Lp = array_keys($lids, $sm);
            $lo = $Lp[0];
            $where = $eqs->data->ret->itemInfo;
            foreach ($where as $ke => $va):
                if ($va->L == $lo) {
                    $totalSlots = $va->levels[0]->slotsets->{$what}->Q;
                }
            endforeach;
            if ($what == "extras") {
                return $totalSlots + self::cpuSlots($eqs, $target);
            } else {
                return $totalSlots;
            }
        }
    }

    private function NotEmptyDrone($result, $what, $target, $equipment) {
        $s = self::shipspace($what, $target, $this->equipment);
        $pos = $this->params->from->items;
        if (strpos($result[0]->{$what}, '|') !== false) {
			  return self::errorTrans('Do NOT cheat!');
              return self::CompleteTrans($pos, 2);
//            $pie = explode("|", $result[0]->{$what});
//            $c = count($pie);
//            $e = $s - $c;
//            $k = count($this->params->from->items);
//            if ($k >= $e):
//                for ($i = 0; $i < $e; $i++) {
//                    array_push($pie, $this->params->from->items[$i]);
//                }
//                self::addToDB($pie, $target, $what);
//                if ($k == 1) {
//                    $ms = array_diff($pos, $pie);
//                    return self::CompleteTrans($ms, 1);
//                } else {
//                    $ms = array_diff($pos, $pie);
//                    return self::CompleteTrans($ms, 2);
//                } elseif ($k < $e):
//                for ($i = 0; $i < $k; $i++) {
//                    array_push($pie, $this->params->from->items[$i]);
//                }
//                self::addToDB($pie, $target, $what);
//                $ms = array_diff($pos, $pie);
//                return self::CompleteTrans($ms, 1);
//            endif;
        } else {
            $pie = explode("|", $result[0]->{$what});
            $k = count($this->params->from->items);
            $r = $s - 1;      
            if ($k >= $r):
                for ($i = 0; $i < $r; $i++) {
                    array_push($pie, $this->params->from->items[$i]);
                }
				
                self::addToDB($pie, $target, $what);
                if ($k == 1) {
                    $ms = array_diff($pos, $pie);
                    return self::CompleteTrans($ms, 1);
                } else {

                    $ms = array_diff($pos, $pie);
                    return self::CompleteTrans($ms, 2);
                } elseif ($k < $r):
                for ($i = 0; $i < $k; $i++) {
                    array_push($pie, $this->params->from->items[$i]);
                }
				
                self::addToDB($pie, $target, $what);
                $ms = array_diff($pos, $pie);
                return self::CompleteTrans($ms, 1);
            endif;
        }
    }

    private function EmptyDrone($what, $target, $equipment) {
        $pos = $this->params->from->items;
        $s = self::shipspace($what, $target, $this->equipment);
        $pie = array();
        $k = count($this->params->from->items);
        if ($k >= $s):
            for ($i = 0; $i < $s; $i++) {
                array_push($pie, $this->params->from->items[$i]);
            }
			
            self::addToDB($pie, $target, $what);
            $ms = array_diff($pos, $pie);
            return self::CompleteTrans($ms, 2);
        elseif ($k < $s):
            for ($i = 0; $i < $k; $i++) {
                array_push($pie, $this->params->from->items[$i]);
            }
			
            self::addToDB($pie, $target, $what);
            $ms = array_diff($pos, $pie);
            return self::CompleteTrans($ms, 1);
        endif;
    }

    private function NotEmptyShip($result, $what, $target, $equipment) {
        if ($what == "extras") {
            $rules = self::checkInput($what);
            $pos = self::checkExtrasService();
            $k = count($pos);
        } else {
            $rules = self::checkInput($what);
            $pos = $this->params->from->items;
            $k = count($this->params->from->items);
        }
        $s = self::shipspace($what, $target, $this->equipment);
        if (strpos($result[0]->{$what}, '|') !== false) {
            $pie = explode("|", $result[0]->{$what});
            $c = count($pie);
            $e = $s - $c;
            $k = count($this->params->from->items);
            if ($k >= $e):
                for ($i = 0; $i < $e; $i++) {
                    if ($what == "extras") {
                        if (in_array($pos[$i], $rules['allowed'])) {
                            array_push($pie, $pos[$i]);
                        }
                    } else {
                        if ($what == "heavy_guns") {
                            array_push($pie, $rules['allowed']['heavy_guns']);
                        } else {
                            if (in_array($this->params->from->items[$i], $rules['allowed'])) {
                                array_push($pie, $this->params->from->items[$i]);
                            }
                        }
                    }
                }
				
                self::addToDB($pie, $target, $what);
                if ($k == 1) {
                    if ($what == "extras") {
                        $ms = array_diff($this->params->from->items, $pie);
                    } else {
                        $ms = array_diff($pos, $pie);
                    }
                    return self::CompleteTrans($ms, 1);
                } else {
                    if ($what == "extras") {
                        $ms = array_diff($this->params->from->items, $pie);
                    } else {
                        $ms = array_diff($pos, $pie);
                    }
                    return self::CompleteTrans($ms, 2);
                } elseif ($k < $e):
                for ($i = 0; $i < $k; $i++) {
                    if ($what == "extras") {
                        if (in_array($pos[$i], $rules['allowed'])) {
                            array_push($pie, $pos[$i]);
                        }
                    } else {
                        if ($what == "heavy_guns") {
                            array_push($pie, $rules['allowed']['heavy_guns']);
                        } else {
                            if (in_array($this->params->from->items[$i], $rules['allowed'])) {
                                array_push($pie, $this->params->from->items[$i]);
                            }
                        }
                    }
                }
				
                self::addToDB($pie, $target, $what);
                if ($what == "extras") {
                    $ms = array_diff($this->params->from->items, $pie);
                } else {
                    $ms = array_diff($pos, $pie);
                }
                return self::CompleteTrans($ms, 1);
            endif;
        } else {
            $pie = explode("|", $result[0]->{$what});
            $k = count($this->params->from->items);
            $r = $s - 1;
            if ($k >= $r):
                for ($i = 0; $i < $r; $i++) {
                    if ($what == "extras") {
                        if (in_array($pos[$i], $rules['allowed'])) {
                            array_push($pie, $pos[$i]);
                        }
                    } else {
                        if ($what == "heavy_guns") {
                            array_push($pie, $rules['allowed']['heavy_guns']);
                        } else {
                            if (in_array($this->params->from->items[$i], $rules['allowed'])) {
                                array_push($pie, $this->params->from->items[$i]);
                            }
                        }
                    }
                }
				
                self::addToDB($pie, $target, $what);
                if ($k == 1) {
                    if ($what == "extras") {
                        $ms = array_diff($this->params->from->items, $pie);
                    } else {
                        $ms = array_diff($pos, $pie);
                    }
                    return self::CompleteTrans($ms, 1);
                } else {
                    if ($what == "heavy_guns") {
                        return self::CompleteTrans($pie, 1);
                    } else {
                        if ($what == "extras") {
                            $ms = array_diff($this->params->from->items, $pie);
                        } else {
                            $ms = array_diff($pos, $pie);
                        }
                    }
                } elseif ($k < $r):
                for ($i = 0; $i < $k; $i++) {
                    if ($what == "extras") {
                        if (in_array($pos[$i], $rules['allowed'])) {
                            array_push($pie, $pos[$i]);
                        }
                    } else {
                        if ($what == "heavy_guns") {
                            array_push($pie, $rules['allowed']['heavy_guns']);
                        } else {
                            if (in_array($this->params->from->items[$i], $rules['allowed'])) {
                                array_push($pie, $this->params->from->items[$i]);
                            }
                        }
                    }
                }
				
                self::addToDB($pie, $target, $what);
                if ($what == "extras") {
                    $ms = array_diff($this->params->from->items, $pie);
                    return self::CompleteTrans($ms, 2);
                } else {
                    $ms = array_diff($pos, $pie);
                    return self::CompleteTrans($ms, 1);
                }
            endif;
        }
    }

    private function EmptyShip($what, $target, $equipment) {
        if ($what == "extras") {
            $rules = self::checkInput($what);
            $pos = self::checkExtrasService();
            $k = count($pos);
        } else {
            $rules = self::checkInput($what);
            $pos = $this->params->from->items;
            $k = count($this->params->from->items);
        }
        $s = self::shipspace($what, $target, $this->equipment);
        $pie = array();
        if ($k >= $s):
            for ($i = 0; $i < $s; $i++) {
                if ($what == "extras") {
                    if (in_array($pos[$i], $rules['allowed'])) {
                        array_push($pie, $pos[$i]);
                    }
                } else {
                    if ($what == "heavy_guns") {
                        array_push($pie, $rules['allowed']['heavy_guns']);
                    } else {
                        if (in_array($this->params->from->items[$i], $rules['allowed'])) {
                            array_push($pie, $this->params->from->items[$i]);
                        }
                    }
                }
            }
			
            self::addToDB($pie, $target, $what);
            if ($what == "heavy_guns") {
                $ms = array_diff($pos, $pie);
                return self::CompleteTrans($ms, 1);
            } else {
                if ($what == "extras") {
                    $ms = array_diff($this->params->from->items, $pie);
                } else {
                    $ms = array_diff($pos, $pie);
                }

                return self::CompleteTrans($ms, 2);
            } elseif ($k < $s):
            for ($i = 0; $i < $k; $i++) {
                if ($what == "extras") {
                    if (in_array($pos[$i], $rules['allowed'])) {
                        array_push($pie, $pos[$i]);
                    }
                } else {
                    if ($what == "heavy_guns") {
                        array_push($pie, $rules['allowed']['heavy_guns']);
                    } else {
                        if (in_array($this->params->from->items[$i], $rules['allowed'])) {
                            array_push($pie, $this->params->from->items[$i]);
                        }
                    }
                }
            }
			
            self::addToDB($pie, $target, $what);
            if ($what == "extras") {
                $ms = array_diff($this->params->from->items, $pie);
                return self::CompleteTrans($ms, 2);
            } else {
                $ms = array_diff($pos, $pie);
                return self::CompleteTrans($ms, 1);
            }
        endif;
    }

    private function checkExtrasService() {
        $argsAll = array();
        foreach ($this->params->from->items as $key => $value) {
            $sqli = "SELECT * FROM server_1_player_all_items WHERE playerID=:playerID && id=:id";
            $stmt = $this->con->prepare($sqli);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':id', $value, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!array_key_exists($result[0]['lootid'], $argsAll)) {
                    $argsAll[$result[0]['lootid']] = $value;
                }
            }
        }
        $pos = array();
        foreach ($argsAll as $k => $v) {
            array_push($pos, $v);
        }
        return $pos;
    }

    private function editDB($equipment) {
        if ($this->droneEquip) {
            $target = $this->params->to->target . "s";
            if ($this->params->to->configId == 1):
                if ($this->params->to->slotset == "design") {
                    $what = "design";
                } else {
                    $what = "EQ";
                }
            else:
                if ($this->params->to->slotset == "design") {
                    $what = "design2";
                } else {
                    $what = "EQ2";
                }
            endif;
            $repeat = $this->params->from->droneItems;
            $conv = json_decode(json_encode($repeat), true);
            $unique = array_map('unserialize', array_unique(array_map('serialize', $conv)));            
            foreach ($unique as $key => $value) {
                $s = self::shipspace($what, $target, $this->equipment, $key);
                $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && item_id=:item_id";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $key, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                    if (!empty($result[0]->{$what})) {
                        array_push($value, $result[0]->{$what});
						
                        self::addToDB($value, $target, $what, $key);
                    } else {
						
                        self::addToDB($value, $target, $what, $key);
                    }
                } else {
                    return self::errorTrans('Something went wrong!');
                }
            }
            return self::CompleteTrans(null, 1);
        } else {
            $moved = array();
            if ($this->params->from->target == "inventory") {
                if ($this->params->to->target == "pet") {
                    $target = $this->params->to->target . "10";
                    $what = $this->params->to->slotset;
                    $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && configNum=:configNum";
                } elseif ($this->params->to->target == "drone") {
                    $target = $this->params->to->target . "s";
                    if ($this->params->to->configId == 1):
                        if ($this->params->to->slotset == "design") {
                            $what = "design";
                        } else {
                            $what = "EQ";
                        }
                    else:
                        if ($this->params->to->slotset == "design") {
                            $what = "design2";
                        } else {
                            $what = "EQ2";
                        }
                    endif;
                    $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && item_id=:item_id";
                } else {
                    $target = $this->params->to->target;
                    $what = $this->params->to->slotset;
                    $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && configNum=:configNum";
                }
                $stmt = $this->con->prepare($sqli);
                /*                 * ****************************************************************************
                 * SUPER TARGETING DB
                 * *************************************************************************** */
                if ($this->params->to->target == "drone"):
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $this->params->to->droneId, PDO::PARAM_INT);
                else:
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                    $stmt->bindParam(':configNum', $this->params->to->configId, PDO::PARAM_INT);
                endif;
                /*                 * *************************************************************************** */
                if ($what == null):
                    return self::errorTrans('You are not able to fit it into that ' . $target . '');
                endif;

                if (!self::fullSystemCheck($what, $target, $this->equipment)):
                    return self::errorTrans('You are not able to fit it into that ' . $target . '');
                endif;

                if ($target == "drones") {
                    if ($stmt->execute()) {
//                    return self::errorTrans('Out of Function');
                        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                        if (!empty($result[0]->{$what})) {
                            return self::NotEmptyDrone($result, $what, $target, $this->equipment);
                        } else {
                            return self::EmptyDrone($what, $target, $this->equipment);
                        }
                        return self::errorTrans('You are not able to fit it into that slot');
                    }
                } else {
                    if ($stmt->execute()) {
                        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                        if (!empty($result[0]->{$what})) {
                            return self::NotEmptyShip($result, $what, $target, $this->equipment);
                        } else {
                            return self::EmptyShip($what, $target, $this->equipment);
                        }
                        return self::errorTrans('You are not able to fit it into that slot');
                    }
                }
            } else {
                if ($this->params->from->target == "pet"):
                    $target = $this->params->from->target . "10";
                    $what = $this->params->from->slotset;
                    $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && configNum=:configNum";
                elseif ($this->params->from->target == "drone"):
                    $target = $this->params->from->target . "s";
                    if ($this->params->from->configId == 1):
                        if ($this->params->from->slotset == "design") {
                            $what = "design";
                        } else {
                            $what = "EQ";
                        }
                    else:
                        if ($this->params->from->slotset == "design") {
                            $what = "design2";
                        } else {
                            $what = "EQ2";
                        }
                    endif;
                    $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && item_id=:item_id";
                else:
                    $target = $this->params->from->target;
                    $what = $this->params->from->slotset;
                    $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && hangarID=:hangarID && configNum=:configNum";
                endif;
                $stmt = $this->con->prepare($sqli);
                /*                 * ****************************************************************************
                 * SUPER TARGETING DB
                 * *************************************************************************** */
//          print_r($this->params);
                if ($this->params->from->target == "drone"):
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                    $stmt->bindParam(':item_id', $this->params->from->droneId, PDO::PARAM_INT);
                else:
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                    $stmt->bindParam(':configNum', $this->params->from->configId, PDO::PARAM_INT);
                endif;
                /*                 * *************************************************************************** */
                if ($stmt->execute()) {
                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                    if (!empty($result[0]->{$what})) {
                        if (strpos($result[0]->{$what}, '|') !== false) {
                            $pie = explode("|", $result[0]->{$what});
                            foreach ($this->params->from->items as $o => $l) {
                                $pie = array_diff($pie, array($l));
                            }
                            foreach ($this->equipment->data->ret->items as $ke => $ve) {
                                foreach ($this->params->from->items as $ky => $iy) {
                                    if ($ve->I == $iy) {
                                        if ($this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-04" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-03" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-02" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-01") {
                                            $left = array();
                                            for ($n = 0; $n < $this->s; $n++) {
                                                $left[$n] = $pie[$n];
                                            }
                                            $pie = array_diff($pie, $left);
                                            array_push($pie, $iy);
                                            $this->cpuFilled = false;
                                            self::delFromDb($left, $target, $what);
                                            return self::CompleteTrans($pie, 1, 1);
                                        } else {

                                            self::delFromDb($pie, $target, $what);
                                            return self::CompleteTrans(null, 1);
                                        }
                                    }
                                }
                            }
                        } else {
                            $pie = array("");
                            foreach ($this->equipment->data->ret->items as $ke => $ve) {
                                foreach ($this->params->from->items as $ky => $iy) {
                                    if ($ve->I == $iy) {
                                        if ($this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-04" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-03" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-02" || $this->equipment->data->map->lootIds[$ve->L] == "equipment_extra_cpu_sle-01") {
                                            $this->cpuFilled = false;
                                            self::delFromDb($pie, $target, $what);
                                            return self::CompleteTrans(array($iy), 1, 1);
                                        } else {
                                            self::delFromDb($pie, $target, $what);
                                            return self::CompleteTrans(null, 1);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
//           return self::errorTrans('Something went wrong');
        }
    }

    public function editJson() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        if (isset($this->equipment) && !empty($this->equipment)) {
            
        } else {
            $this->equipment = new stdClass();
            $this->equipment = $_SESSION['EQ'];
        }
		return self::checkInConfig();
        
    }
	
	private function checkInConfig(){
	if ($this->params->from->target == "inventory") {
	if (isset($this->params->from->droneItems) && !empty($this->params->from->droneItems)) {
		return self::editDB($this->equipment);
	}else{
	if($this->params->to->target == "drone"){
		$target = $this->params->to->target . "s";
		$what = "default";
	}elseif($this->params->to->target == "ship"){
		$target = $this->params->to->target;
		$what = $this->params->to->slotset;
	}else{
		$target = $this->params->to->target;
		$what = $this->params->to->slotset;
	}
	$needle = $this->params->from->items;
	$conf = $this->params->to->configId;
	$args = $this->equipment->data->ret->hangars[0]->config->{$conf}->{$target};
	foreach ($args as $key => $val){
	if(!empty($val->EQ->{$what})){
		if(count(array_intersect($val->EQ->{$what}, $needle)) > 0){
			return self::errorTrans('You can not equip that!');
		}
	}
	}
		return self::editDB($this->equipment);	
	}
	}else{
	return self::editDB($this->equipment);	
	}
	}
	
    public function getTypes() {
        $stmt = $this->con->prepare("SELECT item_type_name FROM server_item_types ");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $array = array();
            foreach ($result as $key => $value) {
                array_push($array, $value->item_type_name);
            }
            return $array;
        }
    }

    public function getMoney() {
        return $this->money;
    }

    public function getMainInfo() {
        $stmt = $this->con->prepare("SELECT uri, credits, factionId FROM server_1_players WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $this->money = new stdClass();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->money->uridium = number_format($result[0]->uri);
            $this->money->credits = number_format($result[0]->credits);
            if ($result[0]->factionId == 1):
                return "mmo";
            elseif ($result[0]->factionId == 2):
                return "eic";
            else:
                return "vru";
            endif;
        }
    }

    public function getFacInfo() {
        $stmt = $this->con->prepare("SELECT uri, credits, factionId FROM server_1_players WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $this->money = new stdClass();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result[0]->factionId;
        }
    }

    private function ifExistsPet($pet) {
        $stmt = $this->con->prepare("SELECT `id`, `lootid` FROM `server_1_player_all_items` WHERE `lootid`=:lootid && `playerID`= :playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindvalue(':lootid', $pet);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if (!$row) {
                return false;
            } else {
                return $row;
            }
        }
    }

    private function ifExistsDrone() {
        $stmt = $this->con->prepare("SELECT `id`, `lootid` FROM `server_1_player_all_items` WHERE `lootid`=:lootid1 OR `lootid`=:lootid2 OR `lootid`=:lootid3 OR `lootid`=:lootid4 && `playerID`= :playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindvalue(':lootid1', 'drone_iris', PDO::PARAM_STR);
        $stmt->bindvalue(':lootid2', 'drone_flax', PDO::PARAM_STR);
        $stmt->bindvalue(':lootid3', 'drone_apis', PDO::PARAM_STR);
        $stmt->bindvalue(':lootid4', 'drone_zeus', PDO::PARAM_STR);
        if ($stmt->execute()) {
            $row = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!$row) {
                return false;
            } else {
                return $row;
            }
        }
    }

    private function GetPet($petId) {
        $stmt = $this->con->prepare("SELECT * FROM `server_1_player_pet10` WHERE `playerID`= :playerID && `item_id`=:itemid");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':itemid', $petId['id'], PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->pet = new stdClass();
            $this->pet->I = $petId['id'];
            $this->pet->HP = $result[0]->pet_hp;
            $this->pet->LV = intval($result[0]->pet_level);
            $this->pet->PN = $result[0]->pet_name;
            array_push($this->lootids, $petId['lootid']);
            $keying = max(array_keys($this->lootids));
            $this->pet->L = intval($keying);
            $this->pet->lockedSlots = new stdClass();
            $slots = explode("|", $result[0]->lockedSlots);
            $this->pet->lockedSlots->lasers = intval($slots[0]);
            $this->pet->lockedSlots->generators = intval($slots[1]);
            $this->pet->lockedSlots->gears = intval($slots[2]);
            $this->pet->lockedSlots->protocols = intval($slots[3]);
            return $this->pet;
        }
    }

    private function droneconfigsGenerator($hid, $conf) {
        $stmt = $this->con->prepare("SELECT * FROM `server_1_hangar_config_drones` WHERE `playerID`= :playerID && `hangarID`=:hangarID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':hangarID', $hid, PDO::PARAM_INT);
        $this->drones = new stdClass();
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($result)) {
                foreach ($result as $key => $value) {
                    $this->drones->{$value->item_id} = new stdClass();
                    $this->drones->{$value->item_id}->EQ = new stdClass();
                    if ($conf == 1) {
                        if (!empty($value->EQ)) {
                            if (strpos($value->EQ, '|') !== false) {
                                $this->drones->{$value->item_id}->EQ->default = explode("|", $value->EQ);
                            } else {
                                $this->drones->{$value->item_id}->EQ->default = array();
                                array_push($this->drones->{$value->item_id}->EQ->default, $value->EQ);
                            }
                        }
                        if (!empty($value->design)) {
                            $this->drones->{$value->item_id}->EQ->design = array();
                            array_push($this->drones->{$value->item_id}->EQ->design, $value->design);
                        }
                    } else {
                        if (!empty($value->EQ2)) {
                            if (strpos($value->EQ2, '|') !== false) {
                                $this->drones->{$value->item_id}->EQ->default = explode("|", $value->EQ2);
                            } else {
                                $this->drones->{$value->item_id}->EQ->default = array();
                                array_push($this->drones->{$value->item_id}->EQ->default, $value->EQ2);
                            }
                        }
                        if (!empty($value->design2)) {
                            $this->drones->{$value->item_id}->EQ->design = array();
                            array_push($this->drones->{$value->item_id}->EQ->design, $value->design2);
                        }
                    }
//                    if (!empty($value->design)) {
//                        $this->drones->{$value->item_id}->EQ->design = array();
//                        array_push($this->drones->{$value->item_id}->EQ->design, $value->design);
//                    }
                }
                return $this->drones;
            } else {
                return "non";
            }
        }
    }

    private function petconfigsGenerator($hid, $conf) {
        $stmt = $this->con->prepare("SELECT * FROM `server_1_hangar_config_pet10` WHERE `playerID`= :playerID && `hangarID`=:hangarID && `configNum`=:configNum");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':hangarID', $hid, PDO::PARAM_INT);
        $stmt->bindParam(':configNum', $conf, PDO::PARAM_INT);
        $this->pet = new stdClass();
        if ($stmt->execute()) {
            $this->pet->EQ = new stdClass();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $key => $value) {
                /*
                 * LASERS CONFIG
                 */
                if (!empty($value->lasers)) {
                    if (strpos($value->lasers, '|') !== false) {
                        $this->pet->EQ->lasers = explode("|", $value->lasers);
                    } else {
                        $this->pet->EQ->lasers = array();
                        array_push($this->pet->EQ->lasers, $value->lasers);
                    }
                }
                /*
                 * GENERATORS CONFIG
                 */
                if (!empty($value->generators)) {
                    if (strpos($value->generators, '|') !== false) {
                        $this->pet->EQ->generators = explode("|", $value->generators);
                    } else {
                        $this->pet->EQ->generators = array();
                        array_push($this->pet->EQ->generators, $value->generators);
                    }
                }
                /*
                 * HEAVY GUNS CONFIG
                 */
                if (!empty($value->gears)) {
                    if (strpos($value->gears, '|') !== false) {
                        $this->pet->EQ->gears = explode("|", $value->gears);
                    } else {
                        $this->pet->EQ->gears = array();
                        array_push($this->pet->EQ->gears, $value->gears);
                    }
                }
                /*
                 * EXTRAS CONFIG
                 */
                if (!empty($value->protocols)) {
                    if (strpos($value->protocols, '|') !== false) {
                        $this->pet->EQ->protocols = explode("|", $value->protocols);
                    } else {
                        $this->pet->EQ->extras = array();
                        array_push($this->pet->EQ->protocols, $value->protocols);
                    }
                }
            }
            return $this->pet;
        }
    }

    private function shipconfigsGenerator($hid, $conf) {
        $stmt = $this->con->prepare("SELECT * FROM `server_1_hangar_config_ship` WHERE `playerID`= :playerID && `hangarID`=:hangarID && `configNum`=:configNum");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':hangarID', $hid, PDO::PARAM_INT);
        $stmt->bindParam(':configNum', $conf, PDO::PARAM_INT);
        $this->ship = new stdClass();
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->ship->EQ = new stdClass();
            foreach ($result as $key => $value) {
                /*
                 * LASERS CONFIG
                 */
                if (!empty($value->lasers)) {
                    if (strpos($value->lasers, '|') !== false) {
                        $this->ship->EQ->lasers = explode("|", $value->lasers);
                    } else {
                        $this->ship->EQ->lasers = array();
                        array_push($this->ship->EQ->lasers, $value->lasers);
                    }
                }
                /*
                 * GENERATORS CONFIG
                 */
                if (!empty($value->generators)) {
                    if (strpos($value->generators, '|') !== false) {
                        $this->ship->EQ->generators = explode("|", $value->generators);
                    } else {
                        $this->ship->EQ->generators = array();
                        array_push($this->ship->EQ->generators, $value->generators);
                    }
                }
                /*
                 * HEAVY GUNS CONFIG
                 */
                if (!empty($value->heavy_guns)) {
                    if (strpos($value->heavy_guns, '|') !== false) {
                        $this->ship->EQ->heavy_guns = explode("|", $value->heavy_guns);
                    } else {
                        $this->ship->EQ->heavy_guns = array();
                        array_push($this->ship->EQ->heavy_guns, $value->heavy_guns);
                    }
                }
                /*
                 * EXTRAS CONFIG
                 */
                if (!empty($value->extras)) {
                    if (strpos($value->extras, '|') !== false) {
                        $this->ship->EQ->extras = explode("|", $value->extras);
                    } else {
                        $this->ship->EQ->extras = array();
                        array_push($this->ship->EQ->extras, $value->extras);
                    }
                }
            }
            return $this->ship;
        }
    }

    private function getdrone($pram) {
        if (!in_array($pram->lootid, $this->lootids)) {
            array_push($this->lootids, $pram->lootid);
        }
        $keying = array_search($pram->lootid, $this->lootids);
        $stmt = $this->con->prepare("SELECT * FROM `server_1_player_drones` WHERE item_sale_id=:item_sale_id && playerID=:playerID");
        $stmt->bindParam(':item_sale_id', $pram->id, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($result)) {
                $ending = new stdClass();
                $ending->I = $pram->id;
                $ending->L = intval($keying);
                $ending->LV = intval($result[0]->drone_level);
                $ending->HP = $result[0]->drone_hp . "%";
                $ending->EF = $result[0]->drone_effect;
                $ending->SP = intval($result[0]->drone_sp);
                $ending->DE = $result[0]->drone_design;
                $ending->DL = intval($result[0]->drone_dl);
                $ending->SL = intval($result[0]->drone_sl);
                $ending->repair = intval($result[0]->drone_repair);
                $ending->currencly = $result[0]->drone_currency;
                return $ending;
            } else {
                return;
            }
        }
    }

    private function allDesigns($base) {
        $like = $base[0] . "_" . $base[1] . "%";
        $stmt = $this->con->prepare("SELECT lootid FROM server_1_player_all_items WHERE lootid LIKE :like && playerID=:playerID");
        $stmt->bindParam(':like', $like, PDO::PARAM_STR);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->M = array();
			if(!empty($result)){
				foreach ($result as $key => $value) {
					array_push($this->M, $value->lootid);
				}
			}
            return $this->M;
        }
    }

    private function hangarGeneral($hangarId) {
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_hangar_general_ship INNER JOIN server_shop_items ON server_1_player_hangar_general_ship.ship_selected_model = server_shop_items.lootId WHERE server_1_player_hangar_general_ship.playerID = ?");
        $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->general = new stdClass();
            $this->general->ship = new stdClass();
            $this->general->ship->I = intval($result[0]->ship_internal_id);
            $this->general->ship->HP = $result[0]->ship_hp;
            array_push($this->lootids, $result[0]->lootId);
            $keying = max(array_keys($this->lootids));
            $this->general->ship->L = intval($keying);
            $this->general->ship->SM = $result[0]->lootId;
            $base = explode("_", $result[0]->lootId);
            $this->general->ship->M = self::allDesigns($base);
            $petId = self::ifExistsPet('pet_pet10');
            if (!empty($petId)) {
                $this->general->pet = new stdClass();
                $this->general->pet = self::GetPet($petId);
                $this->hasPet = 1;
            }
            $drones = self::ifExistsDrone();
            if (!empty($drones)) {
                $this->general->drones = array();
                foreach ($drones as $key => $value) {
                    $space = self::getdrone($value);
                    if (empty($space)) {
                        
                    } else {
                        array_push($this->general->drones, $space);
                    }
                }
            }
            return $this->general;
        }
    }

    public function hangarGenerator() {
        $stmt = $this->con->prepare("SELECT CASE WHEN hangar_is_active = 1 THEN 'TRUE' ELSE 'FALSE' END AS active, hangarID, name, CASE WHEN hangar_is_selected = 1 THEN 'TRUE' ELSE 'FALSE' END AS selected FROM server_1_hangar WHERE playerID = ?");
        $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $key => $value) {
                array_push($this->hangars, new stdClass());
                $keying = max(array_keys($this->hangars));
                $this->hangars[$keying]->hangarID = $value->hangarID;
                $this->hangars[$keying]->name = $value->name;
                $this->hangars[$keying]->hangar_is_active = $value->active === 'TRUE' ? true : false;
                $this->hangars[$keying]->hangar_is_selected = $value->selected === 'TRUE' ? true : false;
                $this->hangars[$keying]->general = new stdClass();
                $this->hangars[$keying]->general = self::hangarGeneral($value->hangarID);
                $this->hangars[$keying]->config = new stdClass();
                $this->hangars[$keying]->config->{1} = new stdClass();
                $this->hangars[$keying]->config->{1}->ship = self::shipconfigsGenerator($value->hangarID, 1);
                if (self::droneconfigsGenerator($value->hangarID, 1) == "non") {
                    
                } else {
                    $this->hangars[$keying]->config->{1}->drones = self::droneconfigsGenerator($value->hangarID, 1);
                }
                if ($this->hasPet == 1) {
                    $this->hangars[$keying]->config->{1}->pet = self::petconfigsGenerator($value->hangarID, 1);
                }
                $this->hangars[$keying]->config->{2} = new stdClass();
                $this->hangars[$keying]->config->{2}->ship = self::shipconfigsGenerator($value->hangarID, 2);
                if (self::droneconfigsGenerator($value->hangarID, 2) == "non") {
                    
                } else {
                    $this->hangars[$keying]->config->{2}->drones = self::droneconfigsGenerator($value->hangarID, 2);
                }
                if ($this->hasPet == 1) {
                    $this->hangars[$keying]->config->{2}->pet = self::petconfigsGenerator($value->hangarID, 2);
                }
            }
            return $this->hangars;
        }
    }

    public function itemLootIdGenerator() {
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid = server_shop_items.lootid WHERE server_1_player_all_items.playerID = ? ORDER BY server_1_player_all_items.lootid DESC");
        $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $i = 0;
            foreach ($result as $key => $value) {
                if (!in_array($value->lootid, $this->lootids)) {
                    array_push($this->lootids, $value->lootid);
                }
                $L = array_search($value->lootid, $this->lootids);
                if ($value->interactive == 0) {
                    array_push($this->items, new stdClass());
                    $itemkeying = max(array_keys($this->items));
                    $this->items[$itemkeying]->I = $value->id;
                    $this->items[$itemkeying]->LV = intval($value->LV);
                    $this->items[$itemkeying]->L = intval($L);
                    if ($value->type == 22 || $value->type == 21 || $value->type == 23 || $value->type == 24 || $value->type == 17) {
                        $this->items[$itemkeying]->S = intval(0);
                    } else {
                        $this->items[$itemkeying]->S = intval($i);
                        $i++;
                    }
                    if ($value->Q <= 1) {
                        
                    } else {
                        $this->items[$itemkeying]->Q = intval($value->Q);
                    }
                    if($value->charge!=0){
                        $this->items[$itemkeying]->properties = new stdClass();
                        $this->items[$itemkeying]->properties->durability = $value->charge;
                        $this->items[$itemkeying]->properties->active = "0";
                        $this->items[$itemkeying]->CH = "Charges: ".$value->charge;
                    }
                }
                $found = false;
                foreach ($this->itemInfo as $Longkey => $data) {
                    if ($data->name == $value->name) {
                        $found = true;
                        break;
                    } else {
                        $found = FALSE;
                    }
                }
                if ($found) {
                    
                } else {
                    array_push($this->itemInfo, new stdClass());
                    $infokeying = max(array_keys($this->itemInfo));
                    $this->itemInfo[$infokeying]->L = intval($L);
                    $this->itemInfo[$infokeying]->name = $value->name;
                    $this->itemInfo[$infokeying]->T = intval($value->type);
                    $this->itemInfo[$infokeying]->C = $value->C;
                    if ($value->name == "Aegis" OR $value->name == "Spearhead" OR $value->name == "Citadel"):
                        $this->itemInfo[$infokeying]->FD = self::getFacInfo();
                    endif;
                    if ($value->properties !== 0 AND $value->properties!==null AND !empty($value->properties)) {
                        $pro = json_decode(base64_decode($value->properties));
                        $this->itemInfo[$infokeying]->rename = intval($pro->rename);
                        $this->itemInfo[$infokeying]->costWeaponSlot = $pro->costWeaponSlot;
                        $this->itemInfo[$infokeying]->costGeneratorSlot = $pro->costGeneratorSlot;
                        $this->itemInfo[$infokeying]->costGearSlot = $pro->costGearSlot;
                        $this->itemInfo[$infokeying]->costProtocolSlot = $pro->costProtocolSlot;
                    }
                    
                    $this->itemInfo[$infokeying]->levels = array();
                    $levi = json_decode(base64_decode($value->levels));
                    foreach ($levi as $y => $z) {
                        array_push($this->itemInfo[$infokeying]->levels, $z);
                    }
                }                                   
                    
            }
        }
    }

}

?>