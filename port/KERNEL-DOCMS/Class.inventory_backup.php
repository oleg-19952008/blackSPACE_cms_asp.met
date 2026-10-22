<?php

@session_start();
/*
 *  FOLLOW SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);
require_once 'Class.db.php';

class inventory extends DB {

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

    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con = DB::getInstance();
    }

    public function setId($uid, $pid) {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->uid = $uid;
        $this->pid = $pid;
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
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
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

    private function CompleteTrans($m, $ret) {
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
//                    $jsn = json_decode('{"isError":0,"data":{"ret":1,"update":{"deleted":["'.$id.'"],"slotCpuMove":{"1":[],"2":[]}}}}');
//                    $jsn = json_decode('{"isError":0,"data":{"slotCpuMove":{"1":[],"2":[]},"ret":1,"money":{"uridium":"'.$this->money->uridium.'","credits":"'.$this->money->credits.'"}}}');
            $jsn->data->money = $this->money;
            return base64_encode(json_encode($jsn));
        }else {
            return self::errorTrans('Something went wrong!');
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
            $sql = "UPDATE server_1_players SET credits = (credits+$price) WHERE playerID=:playerID && userID=:userID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stm->bindParam(':userID', $this->uid, PDO::PARAM_INT);
            if ($stm->execute()):
                return TRUE;
            else:
                return FALSE;
            endif;
        elseif ($result[0]['scd'] == "u"):
            $sql = "UPDATE server_1_players SET credits = (uri+$price) WHERE playerID=:playerID && userID=:userID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stm->bindParam(':userID', $this->uid, PDO::PARAM_INT);
            if ($stm->execute()):
                return TRUE;
            else:
                return FALSE;
            endif;
        else:
            $sql = "UPDATE server_1_players SET credits = (credits+$price) WHERE playerID=:playerID && userID=:userID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stm->bindParam(':userID', $this->uid, PDO::PARAM_INT);
            if ($stm->execute()):
                return TRUE;
            else:
                return FALSE;
            endif;
        endif;
    }

    public function sell($tran = NULL) {
        $itemID = $this->params->itemId;
        $q = $this->params->quantity;
        self::cashOut($itemID, $q);
        $sqli = "UPDATE server_1_player_all_items SET Q = (Q -$q) WHERE id = :id";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':id', $itemID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            if (!empty($tran) OR $tran != NULL):
                return self::checkMinus($itemID, $tran);
            else:
                return self::checkMinus($itemID);
            endif;
        }else {
            return self::errorTrans('Something went wrong!');
        }
    }

    private function DelDrone() {
        $sql = "DELETE FROM server_1_hangar_config_drones WHERE item_id = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id', $itemID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function sellDrone() {
        $itemID = $this->params->itemId;
        $sq = "DELETE FROM server_1_player_drones WHERE item_sale_id = :id";
        $stmt = $this->con->prepare($sq);
        $stmt->bindParam(':id', $itemID, PDO::PARAM_INT);
        $stmt->execute();
        self::DelDrone();
        return self::sell(2);
    }

    private function wipeDrone($drone) {
        $sqli = "UPDATE server_1_hangar_config_drones SET $drone = '', design = '' WHERE ";
        $sqli .= "playerID=:playerID && userID=:userID && hangarID=:hangarID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
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
        $sqli .= " s.playerID=:playerID && s.userID=:userID && s.configNum=:configNum && s.hangarID=:hangarID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
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
//            {"params":{"hi":85169},"lootId":"ship_spearhead","action":"changeShipModel"}
    }

    private function addToDB($array, $target, $what) {
        if ($what == "design") {
            $imp = $array[0];
        } else {
            $imp = implode("|", $array);
        }
        if ($this->params->to->target == "drone"):
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && item_id=:item_id";
        else:
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && configNum=:configNum";
        endif;
        $stmt = $this->con->prepare($sql);
        if ($this->params->to->target == "drone"):
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $this->params->to->droneId, PDO::PARAM_INT);
        else:
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
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
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && item_id=:item_id";
        else:
            $sql = "UPDATE server_1_hangar_config_$target SET $what=:imp WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && configNum=:configNum";
        endif;
        $stmt = $this->con->prepare($sql);
        if ($this->params->from->target == "drone"):
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':item_id', $this->params->from->droneId, PDO::PARAM_INT);
        else:
            $stmt->bindParam(':imp', $imp, PDO::PARAM_STR);
            $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
            $stmt->bindParam(':configNum', $this->params->from->configId, PDO::PARAM_INT);
        endif;
        if ($stmt->execute()) {
            return TRUE;
        }
    }

    private function shipspace($what, $target, $equipment) {
        $eqs = $equipment;
//        if(property_exists($equipment, 'data')):
//            echo "is";
//            exit;
//        else:
//            echo "no";
//            exit;
//        endif;
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
        $this->totalSlots = $totalSlots;
        $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && configNum=:configNum";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
        $stmt->bindParam(':configNum', $this->params->to->configId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (!empty($result[0]->{$what})) {
            if (strpos($result[0]->{$what}, '|') !== false) {
                $pie = explode("|", $result[0]->{$what});
                $memo = count($pie);
            } else {
                if ($what == "heavy_guns") {
                    $memo = 1;
                } else {
                    $memo = 0;
                }
            }
        } else {
            $memo = 0;
        }
        return $totalSlots - $memo;
    }

    private function editDB($equipment) {
        $moved = array();
        if ($this->params->from->target == "inventory") {
            if ($this->params->to->target == "pet"):
                $target = $this->params->to->target . "10";
                $what = $this->params->to->slotset;
                $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && configNum=:configNum";
            elseif ($this->params->to->target == "drone"):
                $target = $this->params->to->target . "s";
                if ($this->params->to->configId == 1):
                    if ($this->params->to->slotset == "design") {
                        $what = "design";
                    } else {
                        $what = "EQ";
                    }
                else:
                    if ($this->params->to->slotset == "design") {
                        $what = "design";
                    } else {
                        $what = "EQ2";
                    }
                endif;
                $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && item_id=:item_id";
            else:
                $target = $this->params->to->target;
                $what = $this->params->to->slotset;
                $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && configNum=:configNum";
            endif;
            $stmt = $this->con->prepare($sqli);
            /*             * ****************************************************************************
             * SUPER TARGETING DB
             * *************************************************************************** */
//          print_r($this->params);
            if ($this->params->to->target == "drone"):
                $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $this->params->to->droneId, PDO::PARAM_INT);
            else:
                $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                $stmt->bindParam(':configNum', $this->params->to->configId, PDO::PARAM_INT);
            endif;
            /*             * *************************************************************************** */
            if ($what == null):
                return self::errorTrans('You are not able to fit it into that ' . $target . '');
            endif;
            $left = self::shipspace($what, $target, $equipment);
//               echo $left;
//               exit;
            $key = count($this->params->from->items);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                if (!empty($result[0]->{$what})) {
                    if (strpos($result[0]->{$what}, '|') !== false) {
                        $pie = explode("|", $result[0]->{$what});
                        $c = count($pie);

                        if ($left == 0):
                            return self::errorTrans("This item can't be equipped to this slot");
                        else:
                            if ($key > $left):
                                $p = 2;
                                $f = $left;
                            elseif ($key == $left):
                                $p = 2;
                                $f = $left;
                            elseif ($key < $left):
                                $p = 1;
                                $f = $key;
                            else:
                                $p = 1;
                                $f = $key;
                            endif;

                            for ($i = 0; $i < $f; $i++) {
                                array_push($pie, $this->params->from->items[$i]);
                                array_push($moved, $this->params->from->items[$i]);
                            }
                            self::addToDB($pie, $target, $what);
                            $j = count($pie);

                            if ($j == $this->totalSlots):
                                return self::CompleteTrans($pie, 2);
                            elseif ($left <= $j):
                                return self::CompleteTrans($pie, 0);
                            else:
                                return self::CompleteTrans($pie, 1);
                            endif;

                        endif;
                    }else {
                        if ($what == "design") {
                            return self::errorTrans('You are not able to fit it into that slot');
                        } else {
                            $pie = array($result[0]->{$what});
                            if ($left == 0):
                                return self::errorTrans("This item can't be equipped to this slot");
                            else:
                                if ($key > $left):
                                    $p = 2;
                                    $f = $left;
                                elseif ($key == $left):
                                    $p = 2;
                                    $f = $left;
                                elseif ($key < $left):
                                    $p = 1;
                                    $f = $key;
                                else:
                                    $p = 1;
                                    $f = $key;
                                endif;
                                for ($i = 0; $i < $f; $i++) {
                                    array_push($pie, $this->params->from->items[$i]);
                                    array_push($moved, $this->params->from->items[$i]);
                                }
                                self::addToDB($pie, $target, $what);
                                return self::CompleteTrans($pie, $p);
                            endif;
                        }
                    }
                } else {
                    $pie = array();
                    if ($key > $left):
                        $p = 2;
                        $f = $left;
                    elseif ($key == $left):
                        $p = 2;
                        $f = $left;
                    elseif ($key < $left):
                        $p = 1;
                        $f = $key;
                    else:
                        $p = 1;
                        $f = $key;
                    endif;
                    for ($i = 0; $i < $f; $i++) {
                        array_push($pie, $this->params->from->items[$i]);
                        array_push($moved, $this->params->from->items[$i]);
                    }

                    if ($key >= $left) {
                        self::addToDB($pie, $target, $what);
                        if ($what == "heavy_guns") {
                            return self::CompleteTrans($pie, $p);
                        } else {
                            return self::CompleteTrans($pie, $p);
                        }
                    } else {
                        self::addToDB($pie, $target, $what);
                        if ($key == $left) {
                            return self::CompleteTrans($pie, $p);
                        } else {
                            return self::CompleteTrans($pie, $p);
                        }

//                     return self::errorTrans('You are not able to fit it into that slot');
                    }
                }
                return self::errorTrans('You are not able to fit it into that slot');
            } else {
                
            }
        } else {
            if ($this->params->from->target == "pet"):
                $target = $this->params->from->target . "10";
                $what = $this->params->from->slotset;
                $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && configNum=:configNum";
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
                        $what = "design";
                    } else {
                        $what = "EQ2";
                    }
                endif;
                $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && item_id=:item_id";
            else:
                $target = $this->params->from->target;
                $what = $this->params->from->slotset;
                $sqli = "SELECT $what FROM server_1_hangar_config_$target WHERE playerID=:playerID && userID=:userID && hangarID=:hangarID && configNum=:configNum";
            endif;
            $stmt = $this->con->prepare($sqli);
            /*             * ****************************************************************************
             * SUPER TARGETING DB
             * *************************************************************************** */
//          print_r($this->params);
            if ($this->params->from->target == "drone"):
                $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                $stmt->bindParam(':item_id', $this->params->from->droneId, PDO::PARAM_INT);
            else:
                $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':hangarID', $this->params->params->hi, PDO::PARAM_INT);
                $stmt->bindParam(':configNum', $this->params->from->configId, PDO::PARAM_INT);
            endif;
            /*             * *************************************************************************** */
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                if (!empty($result[0]->{$what})) {
                    if (strpos($result[0]->{$what}, '|') !== false) {
                        $pie = explode("|", $result[0]->{$what});
                        foreach ($this->params->from->items as $o => $l) {
                            unset($pie[$o]);
                        }
                        self::delFromDb($pie, $target, $what);
                        return self::CompleteTrans(null, 1);
                    } else {
                        $pie = array("");
                        self::delFromDb($pie, $target, $what);
                        return self::CompleteTrans(null, 1);
                    }
                }
            }
        }
//           return self::errorTrans('Something went wrong');
    }

    public function editJson($json) {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $equipment = json_decode(base64_decode($json));
        $this->equipment = new stdClass();
        $this->equipment = $_SESSION['json'];
        return self::editDB($equipment);
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
        $stmt = $this->con->prepare("SELECT uri, credits, factionId FROM server_1_players WHERE userID=:userID && playerID=:playerID");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
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

    private function ifExistsPet($pet) {
        $stmt = $this->con->prepare("SELECT `id`, `lootid` FROM `server_1_player_all_items` WHERE `lootid`=:lootid && `playerID`= :playerID && `userID`=:userID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
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
        $stmt = $this->con->prepare("SELECT `id`, `lootid` FROM `server_1_player_all_items` WHERE `lootid`=:lootid1 OR `lootid`=:lootid2 && `playerID`= :playerID && `userID`=:userID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindvalue(':lootid1', 'drone_iris', PDO::PARAM_STR);
        $stmt->bindvalue(':lootid2', 'drone_flax', PDO::PARAM_STR);
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
                    } else {
                        if (!empty($value->EQ2)) {
                            if (strpos($value->EQ2, '|') !== false) {
                                $this->drones->{$value->item_id}->EQ->default = explode("|", $value->EQ2);
                            } else {
                                $this->drones->{$value->item_id}->EQ->default = array();
                                array_push($this->drones->{$value->item_id}->EQ->default, $value->EQ2);
                            }
                        }
                    }
                    if (!empty($value->design)) {
                        $this->drones->{$value->item_id}->EQ->design = array();
                        array_push($this->drones->{$value->item_id}->EQ->design, $value->design);
                    }
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
        $stmt = $this->con->prepare("SELECT lootid FROM server_1_player_all_items WHERE lootid LIKE :like && userID=:userID && playerID=:playerID");
        $stmt->bindParam(':like', $like, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->M = array();
            foreach ($result as $key => $value) {
                array_push($this->M, $value->lootid);
            }
            return $this->M;
        }
    }

    private function hangarGeneral($hangarId) {
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_hangar_general_ship INNER JOIN server_shop_items ON server_1_player_hangar_general_ship.ship_selected_model = server_shop_items.lootId WHERE server_1_player_hangar_general_ship.hangarID = ? && server_1_player_hangar_general_ship.playerID = ?");
        $stmt->bindParam(1, $hangarId, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->general = new stdClass();
            $this->general->ship = new stdClass();
            $this->general->ship->I = intval($result[0]->ship_id);
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
        $stmt = $this->con->prepare("SELECT CASE WHEN hangar_is_active = 1 THEN 'TRUE' ELSE 'FALSE' END AS active, hangarID, name, CASE WHEN hangar_is_selected = 1 THEN 'TRUE' ELSE 'FALSE' END AS selected FROM server_1_hangar WHERE userID = ? && playerID = ?");
        $stmt->bindParam(1, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
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
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid = server_shop_items.lootid WHERE server_1_player_all_items.userID = ? && server_1_player_all_items.playerID = ? ORDER BY server_1_player_all_items.lootid DESC");
        $stmt->bindParam(1, $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
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
                    if ($value->properties != "0") {
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