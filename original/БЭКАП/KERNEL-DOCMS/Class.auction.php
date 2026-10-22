<?php
/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
/***********************************/
ini_set('display_errors', '1');  /**/
error_reporting(E_ALL);          /**/
/***********************************/
// DB Class IMPORTANT!

class auction{

    /* Everything the script needs to keep it on track */
    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    public $uridium;
    public $credits;
  

    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con =  $GLOBALS['DB'];
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
        $stmt = $this->con->prepare("SELECT uri, credits FROM server_1_players WHERE userID=:userID && playerID=:playerID");
        $stmt->bindParam(':userID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->uridium = $result[0]->uri;
            $this->credits = $result[0]->credits;
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
    
     public function currentDrones($pid){
        $iris = "drone_iris";
        $flax = "drone_flax";
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_drones WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
//        $stmt->bindParam(':iris', $iris, PDO::PARAM_STR);
//        $stmt->bindParam(':flax', $flax, PDO::PARAM_STR);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             $o = count($result);
             return $o;
         }
    }
    private function Logs($pid, $lootid, $am){
                $log = "You won ".$am." Unit(s) of ".$lootid." on the auction";
                DB::setLog($pid, $log);
    }
    
	public function applyCronJobHour(){
        $all = self::getHourITEMScron();
        //$all = self::getHourAuctionItems();
        $time = date('m-d-Y-H', time());
        $my_file = './logs/hourly/'.'auctionLoging_'.$time.'_.php';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $json = json_encode($all);
        $write = '<?php $json=\''.$json.'\'; echo $json; ?>';
        fwrite($handle, $write);
        fclose($handle);
        self::clearCronJobHour();    
        foreach($all as $k => $v){
            if($v['HBidder']!=0):
                $uid = self::getUserIdFromPid($v['HBidder']);
            if($v['ItemName']=="drone_iris" && self::currentDrones($v['HBidder'])<8){
                self::giverCronJob($v['ItemName'], $v['amount'], $v['apply'], $v['HBidder'], $v['HBidder'], $v['cBud'], $v['name']);                
                self::droneReg('drone_iris', $v['HBidder'], $uid);
            }else{
                self::giverCronJob($v['ItemName'], $v['amount'], $v['apply'], $v['HBidder'], $v['HBidder'], $v['cBud'], $v['name']);
            }            
            endif;            
        }
    }
	
    /* public function applyCronJobHour(){
        $all = self::getHourAuctionItems();
        foreach($all as $k => $v){
            if($v['HBidder']!=0):
                $uid = self::getUserIdFromPid($v['HBidder']);
            if($v['ItemName']=="drone_iris" && self::currentDrones($v['HBidder'])<8){
                self::giverCronJob($v['ItemName'], $v['amount'], $v['apply'], $v['HBidder'], $v['HBidder'], $v['cBud']);
                
                self::droneReg('drone_iris', $v['HBidder'], $uid);
            }else{
                self::giverCronJob($v['ItemName'], $v['amount'], $v['apply'], $v['HBidder'], $v['HBidder'], $v['cBud']);
            }
                self::clearCronJobHour($v['ItemName']);
            self::Logs($v['HBidder'], $v['name'], $v['amount']);
            endif;
            
        }
    }
     */
    public function applyCronJobDaily(){
        $all = self::getDailyAuctionItems();
        foreach($all as $k => $v){
            if($v['HBidder']!=0):
                $uid = self::getUserIdFromPid($v['HBidder']);
                self::giverCronJob($v['ItemName'], $v['amount'], $v['apply'], $v['HBidder'], $uid, $v['cBud']);   
                self::clearCronJobDaily($v['ItemName']);
                self::Logs($v['HBidder'], $v['name'], $v['amount']);
            endif;
            
        }
    }
    
    public function getDailyAuctionItems(){
        $stmt = $this->con->prepare("SELECT * FROM server_1_auction_daily INNER JOIN server_shop_items ON server_1_auction_daily.ItemName=server_shop_items.lootId ORDER BY server_1_auction_daily.autoID ASC");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    
    private function giverCronJob($lootid, $am, $in, $pid, $uid, $cbud){
	DB::pmc($uid, "$lootid was won at auction for $cbud Credits", "auction");
        if(self::checkExistence($lootid, $pid)==true){
            if($lootid=="drone_iris"){
                $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(1, $lootid, PDO::PARAM_STR);
                $stmt->bindParam(2, $am, PDO::PARAM_INT);
                $stmt->bindParam(3, $in, PDO::PARAM_INT);
                $stmt->bindParam(4, $pid, PDO::PARAM_INT);
                $stmt->bindParam(5, $uid, PDO::PARAM_INT);
                $stmt->execute();
            }else{
                if($in!=1){
                   $sqli = "UPDATE `server_1_player_all_items` SET Q = Q + $am WHERE playerID=? && lootid=?";
                   $stmt = $this->con->prepare($sqli);
                   $stmt->bindParam(1, $pid, PDO::PARAM_INT);
                   $stmt->bindParam(2, $lootid, PDO::PARAM_STR);
				   $stmt->execute();
                }else{
				   if(strpos($lootid,'ship') !== FALSE){
				   $ins = 1;
				   }else{
				   $ins = 0;
				   }
                   $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
                   $stmt = $this->con->prepare($sql);
                   $stmt->bindParam(1, $lootid, PDO::PARAM_STR);
                   $stmt->bindParam(2, $am, PDO::PARAM_INT);
                   $stmt->bindParam(3, $ins, PDO::PARAM_INT);
                   $stmt->bindParam(4, $pid, PDO::PARAM_INT);
                   $stmt->bindParam(5, $uid, PDO::PARAM_INT);
                   $stmt->execute();
				   
                }
            }
        }else{
		if(strpos($lootid,'ship') !== FALSE){
				   $ins = 1;
				}else{
				   $ins = 0;
				}
                $sql = "INSERT INTO `server_1_player_all_items` (`lootid`, `Q`, `interactive`, `playerID`, `userID`) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->con->prepare($sql);
                $stmt->bindParam(1, $lootid, PDO::PARAM_STR);
                $stmt->bindParam(2, $am, PDO::PARAM_INT);
                $stmt->bindParam(3, $ins, PDO::PARAM_INT);
                $stmt->bindParam(4, $pid, PDO::PARAM_INT);
                $stmt->bindParam(5, $uid, PDO::PARAM_INT);
                $stmt->execute();
        }
       
    }
    private function clearCronJobHour($lootid){
        $stmt = $this->con->prepare("UPDATE server_1_auction_hour SET HBidder=0, cBud=0 WHERE ItemName=:lootid");
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        $stmt->execute();
    }
    
    private function clearCronJobDaily($lootid){
        $stmt = $this->con->prepare("UPDATE server_1_auction_daily SET HBidder=0, cBud=0 WHERE ItemName=:lootid");
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        $stmt->execute();
    }
    
    private function getBiddedOnItem($lootid){
        $stmt = $this->con->prepare("SELECT * FROM server_1_auction_hour INNER JOIN server_shop_items ON server_1_auction_hour.ItemName=server_shop_items.lootId WHERE server_1_auction_hour.ItemName=:lootid ORDER BY server_1_auction_hour.autoID ASC");
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($result)){			
				return $result[0];
			}else{
				return array();
			}
			
        }
    }
    
    private function setBiddedOnItem($lootid, $bid){
        $stmt = $this->con->prepare("UPDATE server_1_auction_hour SET HBidder=:HBidder, cBud=:cBud WHERE ItemName=:lootid");
        $stmt->bindParam(':HBidder', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':cBud', $bid, PDO::PARAM_INT);
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return array('log_message'=>"Bid is submited",'type'=>'success');
        } 
    }
	
    private function pullCredits($cre, $loot){
        $after = $this->credits-$cre;
        $list = "-$cre Before: $this->credits after: $after from Auction on: $loot ";
                DB::pmc($this->pid, $list, "credits");
                $sql = "UPDATE server_1_players SET credits = (credits-$cre) WHERE playerID=:playerID && userID=:userID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
    }
    
     private function droneReg($lootid, $pid, $uid) {
        $sqli = "SELECT id FROM server_1_player_all_items WHERE lootid=:lootid && playerID=:playerID && userID=:userID ORDER BY id DESC LIMIT 1";
        $stmt = $this->con->prepare($sqli);
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $uid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $hid = self::HangarId($pid, $uid);           
            self::CreateDrone($result[0]->id, "uridium", $lootid, $pid, $uid);            
            self::CreateConfig($result[0]->id, $pid, $uid, $hid); 
        }
    }
    public function HangarId($pid, $uid){
        $stmt = $this->con->prepare("SELECT hangarID FROM server_1_hangar WHERE userID=:userID && playerID=:playerID LIMIT 1");
         $stmt->bindParam(':userID', $uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_OBJ);
             if(!empty($result)){
                $hid = $result[0]->hangarID;
                return $hid;
             }else{
                 return false;
             }
         }
        
    }
	
	public function currentDronesSET(){
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
	
    private function CreateConfig($id, $pid, $uid, $hid) {
        $sql = "INSERT INTO `server_1_hangar_config_drones` (`playerID`, `userID`, `hangarID`, `item_id`) VALUES (?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $pid, PDO::PARAM_INT);
        $stmt->bindParam(2, $uid, PDO::PARAM_INT);
        $stmt->bindParam(3, $hid, PDO::PARAM_INT);
        $stmt->bindParam(4, $id, PDO::PARAM_INT);
        $stmt->execute();
    }
	
	public function nextCloseTimeHOUR() {
		date_default_timezone_set("Europe/Copenhagen");
      $date = date("i:s");
      list($cur_min, $cur_sec) = explode(':', $date);
      $mins_left = ($cur_min == 59) ? 0 : 60 - $cur_min -1;
      $secs_left = 60 - $cur_sec;
      return array("min"=>$mins_left,"sec"=>$secs_left);
    }
	
	public function nextCloseTimeDAY() {
		date_default_timezone_set("Europe/Copenhagen");
      $date = date("H:i:s");
      list($cur_hour, $cur_min, $cur_sec) = explode(':', $date);
      $mins_left = ($cur_min == 59) ? 0 : 60 - $cur_min -1;
      $secs_left = 60 - $cur_sec;
	  $hour_left = 23 - $cur_hour;
      return array("hour"=>$hour_left,"min"=>$mins_left,"sec"=>$secs_left);
    }
	
    private function CreateDrone($id, $currency, $lootid, $pid, $uid) {
        $sql = "INSERT INTO `server_1_player_drones` (`item_sale_id`, `drone_currency`, `userID`, `playerID`, `drone_kind`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $currency, PDO::PARAM_INT);
        $stmt->bindParam(3, $uid, PDO::PARAM_INT);
        $stmt->bindParam(4, $pid, PDO::PARAM_INT);
        $stmt->bindParam(5, $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            
        }
    }
	
    private function pushCredits($am, $pid, $loot){
        DB::pmc($pid, "+$am credits, user was overbidded at auction: $loot!", "credits");
                $sql = "UPDATE server_1_players SET credits = (credits+$am) WHERE playerID=:playerID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $pid, PDO::PARAM_INT);
                if ($stm->execute()):
                    DB::setLog($pid, "You were overbidded, you receive ".number_format($am)." credits.");
                    return TRUE;
                else:
                    return FALSE;
                endif;
    }
	
	public function setHourBid($args){
        $info = self::getBiddedOnItem($args['lootId']);
		if(empty($info)){
			return array('log_message'=>"S.H.E.I.L.D. does not allow that value!",'type'=>'error');
			exit;
		}
		if(strpos($args['lootId'],'drones') !== false){
			if(self::currentDronesSET() >= 8){
				return array('log_message'=>"S.H.E.I.L.D. does not allow that value!",'type'=>'error');
				exit;
			}else{
			
			}
		}
        $cre = preg_replace("/[^0-9]/", "", $args['credits']);
		if(ctype_digit($cre)){
        if($this->credits - $cre > 0){
            try {
                $stmt = $this->con->prepare("UPDATE server_1_auction_hour SET HBidder = CASE WHEN :comp > cBud THEN :HBidder ELSE HBidder END, cBud = CASE WHEN :comp > cBud THEN :cBud ELSE cBud END WHERE ItemName=:lootid");
                $stmt->bindParam(':HBidder', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':cBud', $cre, PDO::PARAM_INT);
                $stmt->bindParam(':lootid', $args['lootId'], PDO::PARAM_STR);
                $comp = $cre - 9999;
                $stmt->bindParam(':comp', $comp, PDO::PARAM_INT);
                $stmt->execute();     
                $result = $stmt->rowCount() ? true : false;                     
                if($result){
                    self::pullCredits($cre,$args['lootId']);
                    self::pushCredits($info['cBud'], $info['HBidder'], $args['lootId']);
                    return array('log_message'=>"Bid is submited",'type'=>'success');
                }else{
                   return array('log_message'=>"You need to big atleast 10,000 credits over last bid.",'type'=>'error'); 
                }
                } catch ( PDOException $e ) {
                    return $e->getMessage();
                }
        }else{
            return array('log_message'=>"You don\'t have enough Credits to bid on this item.",'type'=>'error');
        } 
	}else{
		return array('log_message'=>"S.H.E.I.L.D. does not allow that value!",'type'=>'error');
	}		
    }
	
    private function setDayBiddedOnItem($lootid, $bid){
        $stmt = $this->con->prepare("UPDATE server_1_auction_daily SET HBidder=:HBidder, cBud=:cBud WHERE ItemName=:lootid");
        $stmt->bindParam(':HBidder', $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(':cBud', $bid, PDO::PARAM_INT);
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return array('log_message'=>"Bid is submited",'type'=>'success');
        } 
    }
	public function setDayBid($args){
        $info = self::getBiddedDayOnItem($args['lootId']);	
		if(empty($info)){
			return array('log_message'=>"S.H.E.I.L.D. does not allow that value!",'type'=>'error');
			exit;
		}		
        $cre = (int)preg_replace("/[^0-9]/", "", $args['credits']);
		if(ctype_digit($cre)){
        if($this->credits - $cre > 0){
            try {
                $stmt = $this->con->prepare("UPDATE server_1_auction_daily SET HBidder = CASE WHEN :comp > cBud THEN :HBidder ELSE HBidder END, cBud = CASE WHEN :comp > cBud THEN :cBud ELSE cBud END WHERE ItemName=:lootid");
                $stmt->bindParam(':HBidder', $this->pid, PDO::PARAM_INT);
                $stmt->bindParam(':cBud', $cre, PDO::PARAM_INT);
                $stmt->bindParam(':lootid', $args['lootId'], PDO::PARAM_STR);
                $comp = $cre - 9999;
                $stmt->bindParam(':comp', $comp, PDO::PARAM_INT);
                $stmt->execute();     
                $result = $stmt->rowCount() ? true : false;                     
                if($result){
                    self::pullCredits($cre,$args['lootId']);
                    self::pushCredits($info['cBud'], $info['HBidder'], $args['lootId']);
                    return array('log_message'=>"Bid is submited",'type'=>'success');
                }else{
                   return array('log_message'=>"You need to big atleast 10,000 credits over last bid.",'type'=>'error'); 
                }
                } catch ( PDOException $e ) {
                    return $e->getMessage();
                }
        }else{
            return array('log_message'=>"You don\'t have enough Credits to bid on this item.",'type'=>'error');
        } 
	}else{
		return array('log_message'=>"S.H.E.I.L.D. does not allow that value!",'type'=>'error');
	}		
    }
	
    private function getBiddedDayOnItem($lootid){
        $stmt = $this->con->prepare("SELECT * FROM server_1_auction_daily INNER JOIN server_shop_items ON server_1_auction_daily.ItemName=server_shop_items.lootId WHERE server_1_auction_daily.ItemName=:lootid ORDER BY server_1_auction_daily.autoID ASC");
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($result)){			
            return $result[0];
			}else{
			return array();
			}
        }
    }
	
    public function hourToNextDay(){
        date_default_timezone_set("Europe/Copenhagen");
        $dateget = date("H");
        $hour_left = 23 - $dateget;
        return $hour_left;
    }
	
    public function nextMonday(){
	date_default_timezone_set("Europe/Copenhagen");
        $date = date("Y-m-d");
        $nextM = date('Y-m-d', strtotime('next Monday', strtotime($date)));
        $now = strtotime($date);
        $your_date = strtotime($nextM);
        $datediff = $your_date - $now;
        return floor($datediff/(60*60*24))-1;
    }
	
    public function blackMarketTime(){
	    date_default_timezone_set("Europe/Copenhagen");
        $seconds = strtotime("2014-09-01 19:10:18") - time();

        $days = floor($seconds / 86400);
        $seconds %= 86400;

        $hours = floor($seconds / 3600);
        $seconds %= 3600;

        $minutes = floor($seconds / 60);
        $seconds %= 60;

      return array("closed","second: $seconds, minute: $minutes, hour:   $hours, day:    $days");   
    }

    public function minToNextHour() {
      $date = date("i:s");
      list($cur_min, $cur_sec) = explode(':', $date);
      $mins_left = ($cur_min == 59) ? 0 : 60 - $cur_min -1;
      $secs_left = 60 - $cur_sec;
      return "second: ".$secs_left.", minute: ".$mins_left;
    }
    public function getHourAuctionItems(){
        $stmt = $this->con->prepare("SELECT * FROM server_1_auction_hour INNER JOIN server_shop_items ON server_1_auction_hour.ItemName=server_shop_items.lootId ORDER BY server_1_auction_hour.autoID ASC");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function getDayAuctionItems(){
        $stmt = $this->con->prepare("SELECT * FROM server_1_auction_daily INNER JOIN server_shop_items ON server_1_auction_daily.ItemName=server_shop_items.lootId ORDER BY server_1_auction_daily.autoID ASC");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function getXmlImages($hash){
        $source = "./do_img/global/xml/resource_items_auction.xml";
        $xml = simplexml_load_file($source);
	$speItem = json_encode($xml);
        $stdItem = json_decode($speItem);

        foreach ($xml as $file => $val) {
            foreach($val as $item => $vos){
	           if(!empty($vos->{0}['hash']) && $vos['hash'] == $hash){
			$g = array();
			foreach($vos->{0}->attributes() as $a => $b){
				$g[$a] = $b;
			}

                   $loca = explode("_", $g['location'][0]);
                   $url = "/";
                   foreach($loca as $key => $loc){
                       $url .= $loc."/";
                   }
                   $url .= $g['id'][0].".".$g['type'][0];
                   

		   return $url;
              }
            }
            
        }
        }
} 
?>