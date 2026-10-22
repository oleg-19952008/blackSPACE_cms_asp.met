<?php
/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
/***********************************/
ini_set('display_errors', '1');  /**/
error_reporting(E_ALL);          /**/
/***********************************/
// DB Class IMPORTANT!

class clan{

    /* Everything the script needs to keep it on track */
    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    public $uridium;
    public $credits;
    private $count;
    private $paginator;
    private $_limit_per_page = 10;
    private $range = 10; 
    private $page;
    private $url;

    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con =  $GLOBALS['DB'];
        $this->getPager(); 
        if(isset($_GET['page'])){
            $this->page = $_GET['page'];
        }else{
            $this->page = 1;
        }
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
	 public function deleteClan($clanID){
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan` WHERE `clanID` =:clanID ");
            $stmt->bindParam(':clanID', $clanID, PDO::PARAM_INT);
             if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (strpos($result[0]['members'], '|') !== false) {
                  $members = explode("|", $result[0]['members']);   
                }else{
                    $members = array($result[0]['members']);
                }
                foreach($members as $key => $id){
                    self::reUsersClan(0, $id);   
                }
                self::deleteAps($clanID);
                self::deleteClanDiplomacy($clanID);
                return self::deleteClanNow($clanID);
             }
    }
	private function getUser(){
		$stmt = $this->con->prepare("SELECT factionId, honor FROM server_1_players WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0];
        }
	}
	
    public function changeFirm($firmID){
	$pars = self::getUser();
	if($firmID==$pars['factionId']){
		return array('log_message'=>"You can't change to the company!",'type'=>'error');		
	}else{
	$dishonor = round(($pars['honor']/100)*50);
        $price = $this->uridium -5000;
        if($price>=0){
            if(self::pullUri(5000)){
                DB::pmc($this->pid, "-5000 : Company change to $firmID", "uridium"); 
				if($firmID=== '1'){ $mapId=1; $x=1000; $y=1000; }elseif($firmID=== '2'){ $mapId=5; $x=19800; $y=1000; }else{ $mapId=9; $x=19600; $y=11900; };
                $sql = 'UPDATE server_1_players SET factionId = ' . $firmID . ', mapId = ' . $mapId . ', x = ' . $x . ', y = ' . $y . ', honor = '.$dishonor.' WHERE playerID=:playerID';
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                if ($stm->execute()):
                    DB::setLog($this->pid, "You used 5000 uridium on company change!");
                    return array('log_message'=>"You changed company!",'type'=>'success');
                endif;
            }else{
                 DB::pmc($this->pid, "Something went wrong, -5000", "Uridium");
                 return array('log_message'=>"Something went wrong with company change contact support!",'type'=>'error');
            }
        }else{
            return array('log_message'=>"You don't have the 5000 uridium requirement!",'type'=>'error');
        }
	 }
    }
    
    private function pullUri($uri){
                $sql = "UPDATE server_1_players SET uri = (uri-$uri) WHERE playerID=:playerID && userID=:userID";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->bindParam(':userID', $this->uid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
    }
    
    private function deleteClanNow($cid){
            $stmt = $this->con->prepare("DELETE FROM server_1_clan WHERE clanID=?");
            $stmt->bindParam(1, $cid, PDO::PARAM_INT);
            if ($stmt->execute()) {
                    return TRUE;   
            }else{
                RETURN FALSE;
            }
    }
    
    private function deleteClanDiplomacy($cid){
            $stmt = $this->con->prepare("DELETE FROM server_1_clan_diplomacy WHERE fromID=? OR toID=?");
            $stmt->bindParam(1, $cid, PDO::PARAM_INT);
            $stmt->bindParam(2, $cid, PDO::PARAM_INT);
            if ($stmt->execute()) {
                    return TRUE;   
            }else{
                RETURN FALSE;
            }
    }
    
    public function deleteAps($cid){
            $stmt = $this->con->prepare("DELETE FROM server_1_clan_join WHERE clanID=?");
            $stmt->bindParam(1, $cid, PDO::PARAM_INT);
            if ($stmt->execute()) {
                    return TRUE;   
            }else{
                RETURN FALSE;
            }
    }
	
    public function clanVoid($lookup){
        $term = "%$lookup%";
        $r = new stdClass();
        $r->daten = new stdClass();
            $stmt = $this->con->prepare("SELECT * FROM `server_1_clan` WHERE `clanName` LIKE :sr");
            $stmt->bindParam(':sr', $term, PDO::PARAM_STR);
             if ($stmt->execute()) {
                $r->count = intval($stmt->rowCount());
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $k => $v){
                    $r->daten->{$k} = new stdClass();
                    $r->daten->{$k}->clan_clanID = $v['clanID'];
                    $r->daten->{$k}->clan_name = $v['clanName'];
                    $r->daten->{$k}->clan_tag = $v['tagName'];
                    $r->daten->{$k}->clan_TAG = "";
                }                
            }
        return json_encode($r);
    }
    public function getClans($lookup = null, $url){
        $this->url = $url;
        if($lookup!=null){
            $term = "%$lookup%";
            $stmt = $this->con->prepare("SELECT * FROM `server_1_clan` WHERE `clanName` LIKE :rs && visible=1");
            $stmt->bindParam(':rs', $term, PDO::PARAM_STR);
        }else{
            $stmt = $this->con->prepare("SELECT * FROM server_1_clan WHERE visible=1");
        }
        if ($stmt->execute()) {
            $this->count = $stmt->rowCount();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function join($args){
        $stmt = $this->con->prepare("INSERT INTO `server_1_clan_join` (`clanID`, `playerID`, `application`) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $args['clanId'], PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(3, $args['applicationText'], PDO::PARAM_STR);
        if ($stmt->execute()) {
           return TRUE;  
        }
    }
    public function deleteMember($cid, $pid){
        $stmt = $this->con->prepare("SELECT * FROM server_1_clan WHERE clanID=?");
        $stmt->bindParam(1, $cid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $arl = $result[0]['members'];
            if (strpos($arl, '|') !== false) {
                $all = explode("|", $arl);
                foreach($all as $k => $v){
                    
                    if($v == $pid):
                        unset($all[$k]);
                    endif;
                }                
                self::removeMembers($cid, $pid, $all);
            }else{
                return false;
            }
        }
    }
    public function applyMember($cid, $pid){
            $stmt = $this->con->prepare("DELETE FROM server_1_clan_join WHERE playerID=?");
            $stmt->bindParam(1, $pid, PDO::PARAM_INT);
            if ($stmt->execute()) {
                    self::runNewInfo($cid, $pid);
                       
            }
    }
    private function runNewInfo($cid, $pid){
        $smt = $this->con->prepare("SELECT * FROM server_1_clan WHERE clanID=?");
                       $smt->bindParam(1, $cid, PDO::PARAM_INT);
                       if ($smt->execute()) {
                           $result = $smt->fetchAll(PDO::FETCH_ASSOC);
                           self::indentNewMember($cid, $pid, $result[0]['members']);
                       }
    }
    private function indentNewMember($cid, $pid, $arl){
        if (strpos($arl, '|') !== false) {
            $all = explode("|", $arl);
            array_push($all, $pid);
            self::updateMembers($cid, $pid, $all);
        }else{            
            $all = array($pid, $arl);
            self::updateMembers($cid, $pid, $all);
        } 
    }
    private function setUsersClan($cid, $pid){
        $sql = "UPDATE server_1_players SET clanId=? WHERE playerID=?";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(1, $cid, PDO::PARAM_INT);
                $stm->bindParam(2, $pid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
    }
     private function reUsersClan($cid, $pid){
        $sql = "UPDATE server_1_players SET clanId=? WHERE playerID=?";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(1, $cid, PDO::PARAM_INT);
                $stm->bindParam(2, $pid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
    }
    private function updateMembers($cid, $pid, $all){
        $m = implode("|", $all);
        if(self::setUsersClan($cid, $pid)):
            $sql = "UPDATE server_1_clan SET memberCount = (memberCount+1),members=? WHERE clanID=?";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(1, $m, PDO::PARAM_STR);
                $stm->bindParam(2, $cid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
        endif;
        
    }
     private function removeMembers($cid, $pid, $all){
        $c = count($all);
        if ($c>1) {
            $m = implode("|", $all); 
        }else{
            $k = max(array_keys($all));
            $m = $all[$k];
        }
        self::reUsersClan(0, $pid);
            $sql = "UPDATE server_1_clan SET memberCount = (memberCount-1), members=? WHERE clanID=?";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(1, $m, PDO::PARAM_STR);
                $stm->bindParam(2, $cid, PDO::PARAM_INT);
                if ($stm->execute()):
                    return TRUE;
                else:
                    return FALSE;
                endif;
        
    }
    private function loadMembers($args) 
    {
        $return = array();
        foreach($args as $key => $val){
            $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID=?");
            $stmt->bindParam(1, $val, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                array_push($return, $result[0]);
            }
        }
        return $return;
    }
    
    public function getMembers($mem){
        if (strpos($mem, '|') !== false) {
            $all = explode("|", $mem);
            return self::loadMembers($all);
        }else{            
            return self::loadMembers(array($mem));
        } 
    }
    private function GetApplicantNames($args){
        $return = array();
        foreach($args as $key => $val){
            $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID=?");
            $stmt->bindParam(1, $val['playerID'], PDO::PARAM_INT);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $m = array_merge($val, $result);
                array_push($return, $m);
            }
        }
        return $return;
    }
    public function getApplicants($cID){
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan_join` WHERE clanID=?");
        $stmt->bindParam(1, $cID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return self::GetApplicantNames($result);
        }
    }
    public function getPending($id){
        $stmt = $this->con->prepare("SELECT * FROM server_1_clan_join WHERE clanID = ? && playerID = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->rowCount();
            if($result==0):
                return false;
            else:
                return true;
            endif;
        }else{
            return false;
        }
    }
    private function getMyNewClan($tag){
        $stmt = $this->con->prepare("SELECT * FROM server_1_clan WHERE tagName = ? ");
        $stmt->bindParam(1, $tag, PDO::PARAM_STR);
        if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             return self::regMyClan($result);
        }
    }
    private function regMyClan($args){
        $sqli = "UPDATE `server_1_players` SET clanId = ? WHERE playerID=?";
        $stmt = $this->con->prepare($sqli);        
        $stmt->bindParam(1, $args[0]['clanID'], PDO::PARAM_INT);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_STR);
        if($stmt->execute()){
            return TRUE;
        }
    }
    private function regClan($args, $faction){

        $tag = substr($args['clanTag'], 0, 4);
        $de = $args['clanDescription'];
        $n = 1;
        if ($faction == 1):
                $fac = "mmo";
            elseif ($faction == 2):
                $fac = "eic";
            else:
                $fac = "vru";
            endif;
        $stmt = $this->con->prepare("INSERT INTO `server_1_clan` (`clanName`, `leader`, `tagName`, `members`, `memberCount`, `company`, `recruiting`, `clandescription`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $args['clanName'], PDO::PARAM_STR);
        $stmt->bindParam(2, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(3, $tag, PDO::PARAM_STR);
        $stmt->bindParam(4, $this->pid, PDO::PARAM_INT);
        $stmt->bindParam(5, $n, PDO::PARAM_INT);
        $stmt->bindParam(6, $fac, PDO::PARAM_STR);
        $stmt->bindParam(7, $n, PDO::PARAM_INT);
        $stmt->bindParam(8, $de, PDO::PARAM_STR);
        if ($stmt->execute()) {
		
            return self::getMyNewClan($tag);
        }
    }
    public function foundClan($args, $faction){
        if($args['clanName']>4 OR $args['clanName']>33):
            return "Your Clan Name Most be on 4 - 32 characters";
        endif;
        if($args['clanTag']>1 OR $args['clanTag']>5):
            return "Your Clan tag Most be on 1 - 4 characters";
        endif;
        $stmt = $this->con->prepare("SELECT * FROM server_1_clan WHERE clanName = ? || tagName = ? || leader = ?");
        $stmt->bindParam(1, $args['clanName'], PDO::PARAM_STR);
        $stmt->bindParam(2, $args['clanTag'], PDO::PARAM_STR);        
        $stmt->bindParam(3, $this->pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result)){
                return self::regClan($args, $faction);
            }else{
                return "The clan name or Tag already Exists";
            }
        }
    }
    public function getMyClan($id){
        $stmt = $this->con->prepare("SELECT clanId FROM server_1_players WHERE playerID = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['clanId'];
        }
    }
    public function GetClanLeader($id){
        $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['Name'];
        }
    }
    public function getType($num){
        if($num==1):
            return "Alliance";
            elseif($num==2):
            return "NAP";
            else:
            return "War";
        endif;
    }
    private function postDiplomacy($myCID, $tCID, $type, $tName, $dec){
        if($type==3){
            $ac = 1;
        }else{
            $ac = 0;
        }
        $stmt = $this->con->prepare("INSERT INTO `server_1_clan_diplomacy`(`fromID`, `toID`, `type`, `descr`, `accepted`) VALUES (?,?,?,?,?)");
        $stmt->bindParam(1, $myCID, PDO::PARAM_INT);
        $stmt->bindParam(2, $tCID, PDO::PARAM_INT);
        $stmt->bindParam(3, $type, PDO::PARAM_INT);
        $stmt->bindParam(4, $dec, PDO::PARAM_STR);  
        $stmt->bindParam(5, $ac, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return TRUE;
        }
    }
    public function getClanName($id){
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan` WHERE clanID = :ID");
        $stmt->bindParam(':ID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['clanName'];
        }
    }
    public function getClanTag($id){
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan` WHERE clanID = :mD");
        $stmt->bindParam(':ID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['tagName'];
        }
    }
    public function setDiplomacy($myCID, $tCID, $type, $tName, $dec){
        if($myCID==$tCID){
            return FALSE;
        }
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan_diplomacy` WHERE fromID = :mCID && toID = :tCID || fromID = :tCID && toID = :mCID");
        $stmt->bindParam(':mCID', $myCID, PDO::PARAM_INT);
        $stmt->bindParam(':tCID', $tCID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $count = $stmt->rowCount();
            if($count==0){
                return self::postDiplomacy($myCID, $tCID, $type, $tName, $dec);
            }else{
                return FALSE;
            }
        }
    }
    public function stopWarRequest($autoID, $message, $type, $myID, $tID){
        if($type==3){
            if($myID==$tID){
                $sqli = "UPDATE `server_1_clan_diplomacy` SET request=1, message=:m WHERE autoID=:aid";
                $stmt = $this->con->prepare($sqli);        
                $stmt->bindParam(":m", $message, PDO::PARAM_STR);
                $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
                if($stmt->execute()){
                    return TRUE;
                }
            }else{
               $sqli = "UPDATE `server_1_clan_diplomacy` SET request2=1, message=:m WHERE autoID=:aid";
               $stmt = $this->con->prepare($sqli);        
               $stmt->bindParam(":m", $message, PDO::PARAM_STR);
               $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
               if($stmt->execute()){
                   return TRUE;
               }
            }
           
        }else{
           $sqli = "DELETE FROM server_1_clan_diplomacy WHERE autoID=:aid";
            $stmt = $this->con->prepare($sqli);        
            $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
            if($stmt->execute()){
                return TRUE;
            }
        }
    }
    public function acceptRequest($autoID, $type){
        if($type==3){
            $sqli = "DELETE FROM server_1_clan_diplomacy WHERE autoID=:aid";
            $stmt = $this->con->prepare($sqli);        
            $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
            if($stmt->execute()){
                return TRUE;
            }
        }else{
            $sqli = "UPDATE `server_1_clan_diplomacy` SET accepted=1 WHERE autoID=:aid";
            $stmt = $this->con->prepare($sqli);        
            $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
            if($stmt->execute()){
                return TRUE;
            }
        }
    }
    public function declineRequest($autoID, $type){
        if($type!=3){
            $sqli = "DELETE FROM server_1_clan_diplomacy WHERE autoID=:aid";
            $stmt = $this->con->prepare($sqli);        
            $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
            if($stmt->execute()){
                return TRUE;
            }
        }else{
                $sqli = "UPDATE `server_1_clan_diplomacy` SET request=0, request2=0 WHERE autoID=:aid";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
                if($stmt->execute()){
                    return TRUE;
                }
        }
    }
    public function cancelRequest($autoID, $type, $myID, $tID){
        if($type!=3){
            $sqli = "DELETE FROM server_1_clan_diplomacy WHERE autoID=:aid";
            $stmt = $this->con->prepare($sqli);        
            $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
            if($stmt->execute()){
                return TRUE;
            }
        }else{
            if($myID==$tID){
                $sqli = "UPDATE `server_1_clan_diplomacy` SET request2=0 WHERE autoID=:aid";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
                if($stmt->execute()){
                    return TRUE;
                }
            }else{
                $sqli = "UPDATE `server_1_clan_diplomacy` SET request=0 WHERE autoID=:aid";
                $stmt = $this->con->prepare($sqli);
                $stmt->bindParam(":aid", $autoID, PDO::PARAM_INT);
                if($stmt->execute()){
                    return TRUE;
                }
            }
        }
    }
    public function getAcceptedDiplomacy($id){
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan_diplomacy` WHERE fromID = :mCID && accepted=1 || toID = :mCID && accepted=1");
        $stmt->bindParam(':mCID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
     public function getPendingDiplomacy($id){
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan_diplomacy` WHERE toID = :mCID && accepted=0 || toID = :mCID && request2=1 || fromID = :mCID && request=1 ORDER BY fromID DESC");
        $stmt->bindParam(':mCID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function getMyPendingDiplomacy($id){
        $stmt = $this->con->prepare("SELECT * FROM `server_1_clan_diplomacy` WHERE fromID = :mCID && accepted=0 || toID = :mCID && request=1 || fromID = :mCID && request2=1 ORDER BY fromID DESC");
        $stmt->bindParam(':mCID', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function getClan($id){
        $stmt = $this->con->prepare("SELECT * FROM server_1_clan WHERE clanID = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $this->count = $stmt->rowCount();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function getCurrentPage()  
    {  
        $total_of_pages = $this->getTotalOfPages(); 
        $pager = $this->getPager(); 
         
        if ( isset( $pager ) && is_numeric( $pager ) ) {           
            $currentPage = $pager;  
        } else {  
            $currentPage = 1;  
        }  

        if ( $currentPage > $total_of_pages ) {  
            $currentPage = $total_of_pages;  
        }  

        if ($currentPage < 1) {  
            $currentPage = 1;  
        }  
        
        return (int) $this->page;
          
    }
    
     public function getLimitPerPage()  
    { 
         
        return $this->_limit_per_page; 
         
    } 
    
     public function getTotalOfResults()  
    { 
        return (int) $this->count; 
    } 
    
     public function getTotalOfPages()  
    {         
         
        return ceil( $this->getTotalOfResults() / $this->getLimitPerPage() ); 
         
    } 
    public function getPager()  
    { 
         
        if(isset($_GET['page'])){
            $this->paginator = $_GET['page'];
        }else{
            $this->paginator = 0;
        }
         
    } 
     private function getPaginator() 
    { 
        return $this->paginator; 
    } 
    public function setLimitPerPage( $limit )  
    { 
         
        if( !is_int( $limit ) ) { 
            throw new Execption( "<<THE LIMIT MUST BE AN INTEGER>>" ); 
        } 
         
        $this->_limit_per_page = $limit; 
         
         
    } 
    public function getRange()  
    { 
        return $this->range; 
    } 
    public function paginate($cl = null)
    {     
        if($cl!=null){
            $c = $cl;
        }else{
            $c ="";
        }
       $current_page = $this->getCurrentPage(); 
        $total_of_pages = $this->getTotalOfPages(); 
        $paginator = $this->getPaginator(); 
        $range = $this->getRange(); 
        $navReturn = "";
        if(isset($_GET['sort'])&& isset($_GET['direction'])){
            $so = "&sort=".$_GET['sort']."&direction=".$_GET['direction'];
        }else{
            $so = "";
        }
        
        if($this->getTotalOfResults() > 0) {          
            $navReturn .= "<div id=\"navigation-bar\">";  
            if ( $current_page > 1 ) {  
                $navReturn .= " <a href=\"".$this->url."&page" . "=1".$so   
                         
                        . "\" class=\"first $cl\"><span>First</span></a> ";  
                $previous = $current_page - 1;  
                $navReturn .= " <a href=\"".$this->url."&page" . "="  
                        . $previous .$so  
                        . "\" class=\"previous $cl\"><span>Previous</span></a> ";  
            }  
              
            for (  
                $x = ( $current_page - $range );  
                $x < ( ( $current_page + $range ) + 1 );  
                $x++  
            ) {  
			$xs = $x;
                if ( ( $x > 0 ) && ( $x <= $total_of_pages ) ) {  
                    if ( $x == $current_page ) {  
                        $navReturn .= " [<span class=\"current $cl\">$x</span>] ";  
				    }elseif(($xs+3) == $current_page || ($xs+2) == $current_page || ($xs+1) == $current_page){
						$navReturn .= " <a href=\"".$this->url."&page=". $x  
                              . $so . "\" class=\"others $cl\">$x</a> ";
					}elseif(($xs-3) == $current_page || ($xs-2) == $current_page || ($xs-1) == $current_page){
					$navReturn .= " <a href=\"".$this->url."&page=". $x  
                              . $so . "\" class=\"others $cl\">$x</a> ";
					
                    } else {  
                        /*$navReturn .= " <a href=\"".$this->url."&page=". $x  
                              . $so . "\" class=\"others $cl\">$x</a> ";  */
                    }  
                }  
            }  
              
            if ( $current_page != $total_of_pages ) {  
                $next = $current_page + 1;  
                $navReturn .= " <a href=\"".$this->url."&page=" . $next.$so 
                        . "\" class=\"next $cl\">Next</a> ";  
                $navReturn .= " <a href=\"".$this->url."&page="   
                        . $total_of_pages  .$so 
                        . "\" class=\"last $cl\">Last</a> ";  
            }  
              
            $navReturn .= '</div>';
            
        }   
        return $navReturn;
    }  
    
} 
?>