<?php
error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("error_log", "php-error.txt");
require 'libs/IXR_Library.php';
require '../KERNEL-DOCMS/Class.db.php';
class api extends IXR_Server{ 
    
    private $con;
	
    function __construct() {
        $this->con = DB::getInstance();
        $this->IXR_Server(array(
            'api.oce' => 'this:orderComplete'
        ));
        
    }
    
    function orderComplete($args){      
        if($args[0]=="cryptKeyingc25vd3lhZG1pbg0K"){
                self::gDI($args);
        }else{
           return FALSE;
        }
    }  
	
    function setId($uid, $pid) {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->uid = $uid;
        $this->pid = $pid;
    }
    
    function everisign($id){
        $stmt = $this->con->prepare("SELECT verified FROM users WHERE ID=:ID");
        $stmt->bindParam(':ID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['ID'];
        }
    }
    
    function getUserIdFromPid($pid) {
        $stmt = $this->con->prepare("SELECT userID FROM server_1_players WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result[0]->userID;
        }
    }

    /* cPT : calculate Premium Time
     * Simple calculation made on the 2 timestamps
     * current time, and the players premium expire date.
     * Everything is database controlled and use the
     * SSL panel found on secure.DarkSpace.net admin system,
     * to edit any users premium.
     */

    function cPT($timestamp) {
        if (time() < strtotime($timestamp)) {
            return TRUE; // Still premium
        } else {
            return FALSE; // Not premium
        }
    }

    /* aPT : apply Premium Time 
     * $period is the days you want to add to the user
     * please take note if the user is already premium
     * the day time you apply the premium exstention, 
     * will it prolong it with the current time.
     * And not override the current time.   
     * This function must be private.
     */

    function aPT($pid, $period) {
        $stmt = $this->con->prepare("SELECT premium FROM server_1_players WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $pTime = $result[0]->premium; // What exists in the db of time
            $cTime = time(); // The time this function is made.     
            if ($cTime < strtotime($pTime)) {
                $c = strtotime(date("Y-m-d H:i:s", strtotime($pTime)) . " +$period day");
                $da = date('Y-m-d H:i:s', $c);
                return self::sPT($pid, $da);
            } else {
                $c = strtotime(date(strtotime($cTime)) . " +$period day");
                $da = date('Y-m-d H:i:s', $c);
                return self::sPT($pid, $da);
            }
        }
    }

    /* sPT : set Premium Time
     * This function will just update the premium that you give.
     * Please note that this will give you access to REVOKE premium time to.
     */

    function sPT($pid, $times) {
        $sql = "UPDATE server_1_players SET premium = :premium WHERE playerID=:playerID";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':premium', $times, PDO::PARAM_STR);
        $stm->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stm->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* gDI: give Donation Items
     * The xml api is submitting the json and the player ID.
     * Once the payment is confirmed. 
     */
      function gDI($args) {
	  $mhh = false;
        if ($args[0] != "cryptKeyingc25vd3lhZG1pbg0K") {
            return FALSE;
        } else {
            $stdJson = json_decode(base64_decode($args[1]));
			
            if ($stdJson->error == 0) {
                if ($stdJson->package == "premium") {
				$loglist = "9|".$stdJson->playerID."|". $stdJson->price ."|0|". $stdJson->currency ."|".$stdJson->gross;
				DB::pmc($stdJson->playerID, $loglist, "donations");				
                    if (self::aPT($stdJson->playerID, $stdJson->period)) {
                        $log = "You bought " . $stdJson->period . " days of " . $stdJson->package;
                        DB::setLog($stdJson->playerID, $log);
                    } else {
                        $log = "Something went wrong with your purchase of " . $stdJson->period . " days of " . $stdJson->package . ", please contact support!";						
                        DB::setLog($stdJson->playerID, $log);
                    }
                } elseif ($stdJson->package == "uridium") {
				if($mhh===TRUE){
				$atype = $stdJson->a *3;
				}else{
				$atype = $stdJson->a;
				}
				$loglist = "10|".$stdJson->playerID."|". $stdJson->price ."|". $atype ."|0|". $stdJson->currency ."|".$stdJson->gross;
				DB::pmc($stdJson->playerID, $loglist, "donations");
                    $sql = "UPDATE server_1_players SET uri = uri + $atype WHERE playerID=:playerID";
                    $stm = $this->con->prepare($sql);
                    $stm->bindParam(':playerID', $stdJson->playerID, PDO::PARAM_INT);
                    if ($stm->execute()) {
                        $log = "You bought " . number_format($atype) . " units of " . $stdJson->package;
                        DB::setLog($stdJson->playerID, $log);
                    } else {
                        $log = "Something went wrong with your purchase of " . number_format($stdJson->period) . $stdJson->package . ", please contact support!";
                        DB::setLog($stdJson->playerID, $log);
                    }
                } elseif ($stdJson->package == "kit") {
                    $log = "Please contact support about you game Kit!";
                    DB::setLog($stdJson->playerID, $log);
                } else {
                    return false;
                }
            } else {
			if ($stdJson->package == "premium") {
				$loglist = "9|".$stdJson->playerID."|". $stdJson->price ."|1|". $stdJson->currency ."|".$stdJson->gross;
			} elseif ($stdJson->package == "uridium") {
				$loglist = "10|".$stdJson->playerID."|". $stdJson->price ."|". $stdJson->package ."|1|". $stdJson->currency ."|".$stdJson->gross;
			}else{
				
			}
				DB::pmc($stdJson->playerID, $loglist, "donations");
				return false;
            }
        }
    }

    function giveVeriUri($id){
         $sql = "UPDATE server_1_players SET uri = uri + 2000 WHERE playerID=:playerID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $id, PDO::PARAM_INT);
            if ($stm->execute()) {

            }
    }
    
    function getPlayerid($id){
        $sqli = "SELECT playerID FROM server_1_players WHERE userID = :userID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam("userID", $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result[0]->playerID;
        }
    }	
  
}
$s = new api();
?>