<?php

/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
/* * ******************************** */
ini_set('display_errors', '1');  /**/
error_reporting(E_ALL);          /**/
/* * ******************************** */
// DB Class IMPORTANT!
require_once 'Class.db.php';
require_once 'Class.unitymailer.php';
require_once 'Class.Encryption.php';

class unity{
    /* Everything the script needs to keep it on track */

    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    public $uridium;
    public $credits;
    private $mailfrom;
    private $mailtoinfo;
    private $header;
    private $tpl;
    private $fileexist;
    private $crypto;

    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con = $GLOBALS['DB'];
    }
	
	public function applyRankList($pid){
		$stmt = $this->con->prepare("SELECT * FROM player_kills_count WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
		if($stmt->execute()){
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(!empty($result)){
				
			}else{
				self::rankingList($pid);
			}
		}
		
	}
	
	public function applyRankListNpc($pid){
		$stmt = $this->con->prepare("SELECT * FROM npc_kills WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
		if($stmt->execute()){
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(!empty($result)){
				
			}else{
				self::npcList($pid);
			}
		}
		
	}
	
	private function npcList($pid) {
        $sql = "INSERT INTO `npc_kills` (`playerID`) VALUES (?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $pid, PDO::PARAM_INT);
        $stmt->execute();
    }
	
	private function rankingList($pid) {
        $sql = "INSERT INTO `player_kills_count` (`playerID`) VALUES (?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $pid, PDO::PARAM_INT);
        $stmt->execute();
    }
	
	private function updateLevel($level){
        $sql = "UPDATE server_1_players SET level = :level WHERE playerID=:playerID";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':level', $level, PDO::PARAM_INT);
        $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stm->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function levelCorrection(){
        $stmt = $this->con->prepare("SELECT exp FROM server_1_players WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			//array slutter med level 40
            $levels = array(0,10000,20000,40000,80000,160000,320000,640000,1280000,2560000,
			5120000,10240000,20480000,40960000,81920000,163840000,327680000,655360000,1310720000,
			2621440000,5242880000,10485760000,20971520000,41943040000,83886080000,167772160000,335544320000,
			671088640000,1342177280000,2684354560000,5368709120000,10737418240000,21474836480000,
			42949672960000,85899345920000,171798691840000,343597383680000,687194767360000,1374389534720000,2748779069440000);
            foreach($levels as $key => $value){
            if($result[0]['exp']<$value){
                self::updateLevel($key);
                return $key;
            }
        }
        }
        
    }
	
    public function setId($uid, $pid) {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->uid = $uid;
        $this->pid = $pid;
    }
    public function get_client_ip() {
    $ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

    public function getResolution($id){
        $stmt = $this->con->prepare("SELECT res FROM server_1_player_settings WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['res'];
        }
    }
	
	public function everisign($id){
        $stmt = $this->con->prepare("SELECT verified FROM users WHERE ID=:ID");
        $stmt->bindParam(':ID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['verified'];
        }
    }
	 private function getUserInfo($uid){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE ID=:ID");
        $stmt->bindParam(':ID', $uid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($result)){
                return $result[0];
            }
        }
    }
	
    private function updateName($newName){
        $sql = "UPDATE users SET Name =:Name, change_username='0' WHERE ID=:ID";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':Name', $newName, PDO::PARAM_STR);
        $stm->bindParam(':ID', $this->crypto['ID'], PDO::PARAM_INT);
        if ($stm->execute()) {
            Return "Your username has changed to $newName";
        }else{
             Return "Something went wrong, contact support!";
        }
    }
    
    public function checkNamechange($scode){
	global $MySQLi;
        $stmt = $this->con->prepare("SELECT * FROM users WHERE change_username=:scode LIMIT 1");
        $stmt->bindParam(':scode', $scode, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
           if(!empty($result)){
               if($result[0]['change_username']!="0" OR $result[0]['change_username']!=0){                   
                    $this->crypto = $result[0];
                     $newName = mysqli_real_escape_string($MySQLi, trim(base64_decode($scode)));
                     return self::updateName($newName);
               }else{
                   return FALSE;
               }
           }else{
               return FALSE;
           }            
        }else{
            return FALSE;
        }
    }
	
     private function setNewNameAcceptance($new){
        $info = self::getUserInfo($this->uid);
        $newNm = base64_encode($new);
        $id = $info['ID'];
        $mailer = new unitymailer();
        $sql = "UPDATE users SET change_username ='$newNm' WHERE ID=:ID";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':ID', $this->uid, PDO::PARAM_INT);
        if ($stm->execute()) {
            $mailer->mailSystem(array('header'=>array('mailfrom'=> 'no-reply@DarkSpace.net', 'template'=>'changename', 'subject' => 'Dark Space Confirm Name Change'),'content'=>array('newname'=>$new,'username' => $info['Name'], 'link' => 'http://DarkSpace.net/emailconfirmation/nameChange.php?s='.urlencode($newNm),'reasonforemail'=>'Name Change', 'author' => 'Best Regards <br /> Dark Space Staff Team', 'year'=>date('Y')), 'recivers'=>array($info['Email'])));
            return '{"status":"OK","message":"Confirmation email was sent."}';          
        }
    }
    public function changeName($newName){   
		if(strlen($newName) < 3):
			return '{"status":"ERROR","message":"Username must be longer than 3 character"}';
		elseif(strlen($newName) > 40):
			return '{"status":"ERROR","message":"Username must be less than 40 character"}';
		endif;
        $stmt = $this->con->prepare("SELECT * FROM users WHERE Name=:Name");
        $stmt->bindParam(':Name', $newName, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result)){
                return self::setNewNameAcceptance($newName);
            }else{                
                return '{"status":"ERROR","message":"This Pilot name is already in use."}';
            }
        }
    }    
    public function saveNewPassword($pw, $cpw){
        if($pw!=$cpw){
            Return "The passwords does NOT match!";
        }else{
            if($this->crypto['banned']!=0 or $this->crypto['banned']!="0"){
                Return "You has been banned!";
            }else{            
                $Encryption = new Encryption("5eqD0fpzf9JzaKWP");
                $newPw = $Encryption->encrypt($pw);
                $sql = "UPDATE users SET pwHash =:pwhash, change_password='0' WHERE ID=:ID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':pwhash', $newPw, PDO::PARAM_STR);
                $stm->bindParam(':ID', $this->crypto['ID'], PDO::PARAM_INT);
                if ($stm->execute()) {
                    Return "Your Password has been changed";
                }else{
                     Return "Something went wrong, contact support!";
                }
            }
        }
        
    }
    
    public function checkPwRecover($scode){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE change_password=:scode LIMIT 1");
        $stmt->bindParam(':scode', $scode, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
           if(!empty($result)){
               if($result[0]['change_password']!="0" OR $result[0]['change_password']!=0){                   
                    $this->crypto = $result[0];
                    return TRUE;
               }else{
                   return FALSE;
               }
           }else{
               return FALSE;
           }            
        }else{
            return FALSE;
        }
    }
	private function setPwRecoderAccpetance($args){
        $id = $args['ID'];
        $mailer = new unitymailer();
        $num = Core::generateRandom(25);
        $sql = "UPDATE users SET `change_password`='$num' WHERE ID=:ID";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':ID', $id, PDO::PARAM_INT);
        if ($stm->execute()) {
            $mailer->mailSystem(array('header'=>array('mailfrom'=> 'no-reply@DarkSpace.net', 'template'=>'pwRecover', 'subject' => 'Dark Space Password Recovery'),'content'=>array('username' => $args['Name'], 'link' => 'http://DarkSpace.net/emailconfirmation/pwRecover.php?s='.$num,'reasonforemail'=>'Password Recovery', 'author' => 'Best Regards <br /> Dark Space Staff Team', 'year'=>date('Y')), 'recivers'=>array($args['Email'])));
            return "<div>Password Recovery email was sent to you!</div>";            
        }
    }
    
    public function passwordRecovery($email){
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		$stmt = $this->con->prepare("SELECT * FROM users WHERE Email=:Email");
        $stmt->bindParam(':Email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);			
            if(!empty($result)){
                return self::setPwRecoderAccpetance($result[0]);
            }else{                
                return "<div>Email Does not exist!</div>";
            }
        }
	}else{
		return "<div>Invalid email!</div>";
	}
        
    }    
	public function checkIpBan($ip){
		$stmt = $this->con->prepare("SELECT * FROM ip_bans WHERE IP=:IP");
        $stmt->bindParam(':IP', $ip, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($result)){
				if(self::cPT($result[0]['period'])){
				return TRUE;
				}else{
				return FALSE;
				}
			}else{
				return FALSE;
			}
        }else{
		return FALSE;
		}
	}
	
    private function getUserIdFromPid($pid) {
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
	
	public function registerNewAccount($pid){	
		try {
					$stmt = $this->con->prepare("INSERT INTO server_1_players (playerID, overallRank, userId, settings) VALUES ('$pid', '$pid', '$pid', '')");					
					if($stmt->execute()){
						return TRUE;
					}		
		} catch (PDOException $e) {
					print "Error!: " . $e->getMessage() . "<br/>";
					die();
		}
	}
	
	public function updateAccount($pid){	
		try {
					$stmt = $this->con->prepare('UPDATE users SET Servers = \'[{1:' . $pid. '}]\' WHERE ID = \'' . $pid . '\'');			
					if($stmt->execute()){
						return TRUE;
					}		
		} catch (PDOException $e) {
					print "Error!: " . $e->getMessage() . "<br/>";
					die();
		}
	}
	public function regAmmo($pid){	
		try {
					$stmt = $this->con->prepare("INSERT INTO server_1_player_ammunation (playerID) VALUES ($pid)");			
					if($stmt->execute()){
						return TRUE;
					}		
		} catch (PDOException $e) {
					print "Error!: " . $e->getMessage() . "<br/>";
					die();
		}
	}
    public function cPT($timestamp) {
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

    public function aPT($pid, $period) {
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

    private function sPT($pid, $times) {
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

    public function gDI($args) {
        if ($args[0] != "cryptKeying") {
            return FALSE;
        } else {
            $stdJson = json_decode(base64_decode($args[1]));
			
            if ($stdJson->error == 0) {
                if ($stdJson->package == "premium") {
				$loglist = "User:".$stdJson->playerID." donated ". $stdJson->price. " for ". $stdJson->package . " with success.";
				DB::pmc($stdJson->playerID, $loglist, "donations");
                    //print_r($stdJson);
                    if (self::aPT($stdJson->playerID, $stdJson->period)) {
                        $log = "You bought " . $stdJson->period . " days of " . $stdJson->package;
                        DB::setLog($stdJson->playerID, $log);
                    } else {
                        $log = "Something went wrong with your purchase of " . $stdJson->period . " days of " . $stdJson->package . ", please contact support!";						
                        DB::setLog($stdJson->playerID, $log);
                    }
                } elseif ($stdJson->package == "uridium") {
				$loglist = "User:".$stdJson->playerID." donated ". $stdJson->price. " for ". $stdJson->package . " of ".$stdJson->a." with success.";
				DB::pmc($stdJson->playerID, $loglist, "donations");
                    $sql = "UPDATE server_1_players SET uri = uri + $stdJson->a WHERE playerID=:playerID";
                    $stm = $this->con->prepare($sql);
                    $stm->bindParam(':playerID', $stdJson->playerID, PDO::PARAM_INT);
                    if ($stm->execute()) {
                        $log = "You bought " . number_format($stdJson->a) . " units of " . $stdJson->package;
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
                $loglist = "User:".$stdJson->playerID." donated ". $stdJson->price. " for " .$stdJson->package . " was not succesfull.";
				DB::pmc($stdJson->playerID, $loglist, "donations");
				return false;
            }
        }
    }
    
    private function giveVeriUri($id){
         $sql = "UPDATE server_1_players SET uri = uri + 2000 WHERE playerID=:playerID";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':playerID', $id, PDO::PARAM_INT);
            if ($stm->execute()) {

            }
    }
    
    private function getPlayerid($id){
        $sqli = "SELECT playerID FROM server_1_players WHERE userID = :userID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam("userID", $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result[0]->playerID;
        }
    }
    private function checkIfVeri($id){
        $sqli = "SELECT * FROM users WHERE ID = :userID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam("userID", $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($result[0]['verified']==0){
                return false;
            }else{
                return true;
            }
        }
    }
    public function emailVerify($args){
        $playerid = self::getPlayerid($args->userid);
        if(self::checkIfVeri($args->userid)){
            return "Your email is already verified!";
            exit;
        }else{
            $sql = "UPDATE users SET verified = 1 WHERE ID=:ID && Email=:Email";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':ID', $args->userid, PDO::PARAM_INT);        
            $stm->bindParam(':Email', $args->email, PDO::PARAM_STR);
            if ($stm->execute()) {
               DB::setLog($playerid, "Your email is verified, you received 2,000 Uridium"); 
               self::giveVeriUri($playerid);
               return "Your email is now verified!";
            }
        }
        print_r($args);
    }
    
    public function mailer($reciver, $emailbackendinfo, $fields_and_values) {
        foreach ($emailbackendinfo as $field_n => $field_val) {
            $this->$field_n = $field_val;
        }
        /* ARRAY RETRIVER */
        foreach ($fields_and_values as $field_name => $field_value) {
            $this->$field_name = $field_value;
        }
        /* RECIVER ARRAY TO STRING, IF ANY OF THE EMAILS IS INVALID
         * IT STOPS AND POST AN ERROR */
        $mailto="";
        foreach ($reciver as $email_name => $email_value) {
            if (filter_var($email_value, FILTER_VALIDATE_EMAIL)) {
                $mailto .= $email_value;
                $mailto .= ', ';
            } else {
                /* DEBUG ECHO */
//              echo "Error: this is not an email: " . $email_value;
                /* DEBUG ECHO END */
                return "Error_this_is_not_an_email: " . $email_value;
            }
        }
        $this->mailtoinfo = substr_replace($mailto, "", -2);
        /* REMOVING THE LAST 2 CHARACTERS=>" ," */
    }

    public function mailFrom() {
        /* IF THE SENDERMAIL IS EMPTY THEN DEFINE DEFAULT EMAIL */
        if (!empty($this->mailfrom)) {
            if (!filter_var($this->mailfrom, FILTER_VALIDATE_EMAIL)) {
                return "Your_own_email_is_not_valid";
            }
        } else {
            /* DEFAULT EMAIL */
            $this->mailfrom = "no-reply@" . websiteName;
        }
    }

    public function setHeader() {
        /* SET THE HEADER FOR THE EMAIL */
        $this->header = 'From: ' . $this->mailfrom . "\r\n" . 'Reply-To: ' . $this->mailfrom . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    }

    public function templateUse($fields_and_values) {
        /* DEFINE IF TEMPLATE SHOULD BE USED OR NOT */
        if (isset($this->template)) {
            $this->fileexist = './mailtemplates/' . $this->template . '.tpl';
            if (file_exists($this->fileexist)) {
                ob_start();
                $this->tpl = file_get_contents('./mailtemplates/' . $this->template . '.tpl');
                foreach ($fields_and_values as $field_name => $field_value) {
                    $this->tpl = str_replace('{{' . $field_name . '}}', $field_value, $this->tpl);
                }
                ob_end_flush();
            } else {
                return "template_does_not_exist";
            }
        } else {
            ob_start();
            foreach ($fields_and_values as $field_name => $field_value) {
                $this->tpl = $this->$field_name;
            }
            ob_end_flush();
        }
    }

    public function sendMail() {
        /* SENDER SUCCESS OR NOT */
        if (mail($this->mailtoinfo, $this->subject, $this->tpl, $this->header)) {
            if (file_exists($this->fileexist)) {
                return "With_template_success";
            } else {
                return "Without_template_success";
            }
        } else {
            return "Mail_error";
        }
    }
	
	 public function getMapID($playerID){
        $sqli = "SELECT mapId FROM server_1_players WHERE playerID = :playerID";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam("playerID", $playerID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result[0]->mapId;
        }else{
            return 1;
        }
    }
    
    
}

?>