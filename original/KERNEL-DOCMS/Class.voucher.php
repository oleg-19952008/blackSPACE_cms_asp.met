<?php
/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
/***********************************/
ini_set('display_errors', '1');  /**/
error_reporting(E_ALL);          /**/
/***********************************/
// DB Class IMPORTANT!

class voucher{

    /* Everything the script needs to keep it on track */
    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    public $uridium;
    public $credits;
    public $jackpot;
  

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

        self::money();
    }
    
    public function money() {
        $stmt = $this->con->prepare("SELECT uri, credits, jackpot FROM server_1_players WHERE userID=:userID && playerID=:playerID");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->uridium = $result[0]->uri;
            $this->credits = $result[0]->credits;
            $this->jackpot = $result[0]->jackpot;
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
    private function getUserIdFromPid($pid){
        $stmt = $this->con->prepare("SELECT userID FROM server_1_players WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result[0]->userID;
        }
    }
    
    private function giveVoucherItems($itemsJson) {
        $vItem =  json_decode(base64_decode($itemsJson));
        foreach ($vItem as $key => $value) {
            if($key=="uridium"){
                $am = $value->a;
                $sql = "UPDATE server_1_players SET uri = uri + $am WHERE playerID=:playerID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->execute();    
            }elseif($key=="credits"){                
                $am = $value->a;
                $sql = "UPDATE server_1_players SET credits = credits + $am WHERE playerID=:playerID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->execute();   
            }
            elseif($key=="jackpot"){                
                $am = $value->a;
                $sql = "UPDATE server_1_players SET jackpot = jackpot + $am WHERE playerID=:playerID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->execute();   
            }else{
            if($value->i==1){
                if(self::checkExistence($key, $this->pid)){
                    
                }else{
                    $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $this->con->prepare($sql);
                    $stmt->bindParam(1, $key, PDO::PARAM_STR);
                    $stmt->bindParam(2, $value->a, PDO::PARAM_INT);
                    $stmt->bindParam(3, $value->i, PDO::PARAM_INT);
                    $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
                    $stmt->bindParam(5, $this->uid, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }else{
                if(isset($value->e) && $value->e==1){
                    $vs = 1;
                    for($i =0; $i<$value->a; $i++){
                     $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
                     $stmt = $this->con->prepare($sql);
                     $stmt->bindParam(1, $key, PDO::PARAM_STR);
                     $stmt->bindParam(2, $vs, PDO::PARAM_INT);
                     $stmt->bindParam(3, $value->i, PDO::PARAM_INT);
                     $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
                     $stmt->bindParam(5, $this->uid, PDO::PARAM_INT);
                     $stmt->execute();
                    }
                }else{
                    if(self::checkExistence($key, $this->pid)){
                        $am = $value->a;
                        $sqli = "UPDATE `server_1_player_all_items` SET Q = Q + $am WHERE playerID=? && lootid=?";
                        $stmt = $this->con->prepare($sqli);
                        $stmt->bindParam(1, $this->pid, PDO::PARAM_INT);
                        $stmt->bindParam(2, $key, PDO::PARAM_STR); 
                        $stmt->execute();
                    }else{
                         $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
                         $stmt = $this->con->prepare($sql);
                         $stmt->bindParam(1, $key, PDO::PARAM_STR);
                         $stmt->bindParam(2, $value->a, PDO::PARAM_INT);
                         $stmt->bindParam(3, $value->i, PDO::PARAM_INT);
                         $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
                         $stmt->bindParam(5, $this->uid, PDO::PARAM_INT);
                         $stmt->execute();
                    } 
              }
            }  
            }
        }
        return array('log_message'=>"You used your voucher!",'type'=>'success');
    }
    
    private function updateVoucherUsed($args, $key){
        array_push($args, $this->pid);
        $ar = implode("|", $args);
        $sqli = "UPDATE `server_1_voucher` SET vuser = :vuser, vused = vused+1 WHERE vkey=:vkey";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':vuser', $ar, PDO::PARAM_STR);
        $stmt->bindParam(':vkey', $key, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return TRUE;
        }else{
            return FALSE;
        }
//        return TRUE;
    }
    
    public function redeemVoucher($key){
        $stmt = $this->con->prepare("SELECT * FROM server_1_voucher WHERE vkey = ?");
        $stmt->bindParam(1, $key, PDO::PARAM_STR);
         if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($result)){
//                print_r($result);
                if($result[0]['active']!=1){
                    return array('log_message'=>"The Voucher does not exits",'type'=>'error');
                }
                if($result[0]['vused']>=$result[0]['vavi']){
                    return array('log_message'=>"The Voucher does not exits",'type'=>'error');
                }
                $vUs = explode("|", $result[0]['vuser']);
                if(!in_array($this->pid, $vUs)){
                    if(self::updateVoucherUsed($vUs, $key)){
                        return self::giveVoucherItems($result[0]['vpro']);
                    }else{
                       return array('log_message'=>"Something went wrong, contact support",'type'=>'error'); 
                    }                    
                }else{
                   return array('log_message'=>"You have already used this Voucher",'type'=>'error'); 
                }
            }else{
                return array('log_message'=>"The Voucher does not exits",'type'=>'error');
            }
         }else{
             return array('log_message'=>"The Voucher does not exits",'type'=>'error');
         }
    }
    
} 
?>