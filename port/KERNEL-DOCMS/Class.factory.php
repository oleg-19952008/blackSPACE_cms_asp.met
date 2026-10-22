<?php
/*
 *  THIS SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
ini_set('display_errors', '1');
error_reporting(E_ALL);

class factory{
    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    private $uridium;
    private $credits;
    
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
        self::checkMakeDBrow();
        self::money();
    }
    
    public function getPrices($argC) {
        $SELA = array("c" => 1000000, "seprom" => 500, "logdisk" => 5, "buyn" => 6500, "producetime" => "43200", "instant" => 2500);
        $SECI = array("c" => 500000, "seprom" => 200, "logdisk" => 1, "buyn" => 1800, "producetime" => "21600", "instant" => 900);
        $SRPM = array("c" => 20000, "seprom" => 0, "logdisk" => 0, "buyn" => 500, "producetime" => "7200", "instant" => 250);
        $SSBU = array("c" => 500000, "seprom" => 250, "logdisk" => 2, "buyn" => 2800, "producetime" => "43200", "instant" => 1400);
        $SBRB = array("c" => 500000, "seprom" => 250, "logdisk" => 2, "buyn" => 2800, "producetime" => "43200", "instant" => 1400);

        if (!empty($$argC)) {
            return $$argC;
        } else {
            return "";
        }
        return $$argC;
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
    
    private function checkMakeDBrow(){
        $stmt = $this->con->prepare("SELECT autoID FROM server_1_player_nanotech WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             if(!empty($result)){
                 return true;
             }else{
                self::makeRow();
             }
         }
        
    }
    public function cPT($timestamp) {
        if (time() > strtotime($timestamp)) {
            return TRUE; // Still premium
        } else {
            return FALSE; // Not premium
        }
    }    
    
    public function deleteTech($slot){
        if(!isset($slot) && empty($slot)){
            return FALSE;
        }
        $dic = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three');
        $slotset = "slot_".$dic[$slot];
        $sql = "UPDATE server_1_player_nanotech SET $slotset='none' WHERE playerID=:playerID";
        $stmt = $this->con->prepare($sql);            
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        if($stmt->execute()){
              return TRUE;           
        }else{
            return false;
        }
    }
    
    public function updateStatus($pid, $slot){
        $this->pid = $pid;
        $peri = self::getTimes();
        $s = explode("|", $peri[$slot]);
        $status = self::cPT($peri[$s[0]]);
        if($status){            
            $s = explode("|", $peri[$slot]);
            if($s==0){
                return FALSE;
            }
            $s[2] = 0;
            $s[1] +=1;
            $x = implode("|", $s);
            $sql = "UPDATE server_1_player_nanotech SET $slot='$x' WHERE autoID=:autoID && playerID=:playerID";
            $stmt = $this->con->prepare($sql);            
            $stmt->bindParam(':autoID', $peri['autoID'], PDO::PARAM_INT);
            $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
            if($stmt->execute()){
              return TRUE;           
            }
        }else{
            return FALSE;
        }
    }
    
    public function getSeconds($datestripe){
        return strtotime($datestripe) - time();
    }
    
    private function makeRow(){
        $stm = $this->con->prepare("INSERT INTO `server_1_player_nanotech`(`playerID`) VALUES (:playerID)");
                $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                $stm->execute();
                return true;
    }
    
    public function cancelProduction($buff, $slot){
        $halls = self::getTimes();
        $dic = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three');
        $slotset = "slot_".$dic[$slot];
        $c = time();
            if($halls[$slotset]=="none"){
                return array('log_message'=>"Do not cheat!",'type'=>'error');
            }else{
                $s = explode("|", $halls[$slotset]);
                
                if($s[1]==0){
                    self::updateDatesINtech($buff, $c, $slotset, 'none');
                    return array('log_message'=>"Procution on ".self::l($buff."name")." has stopped",'type'=>'success'); 
                }
                if($s==0){
                    return FALSE;
                }
                $s[2] = 0;
                $x = implode("|", $s);
                self::updateDatesINtech($buff, $c, $slotset, $x);              
        }
        return array('log_message'=>"Procution on ".self::l($buff."name")." has stopped",'type'=>'success'); 
    }
    
    private function executeBuyNow($slot, $buff, $args){        
        $halls = self::getTimes();
            $c = $halls[$buff];
            if($halls[$slot]=="none"){
                $cs =$buff."|1|0";
                self::updateDatesINtech($buff, $c, $slot, $cs); 
            }else{
                $s = explode("|", $halls[$slot]);               
                if($s==0){
                    return FALSE;
                }
                $s[1] = $s[1] + 1;
                $x = implode("|", $s);
                self::updateDatesINtech($buff, $c, $slot, $x);              
            }
            return array('log_message'=>"You bought 1 ".self::l($buff."name"),'type'=>'success');   
    }
    
    public function buyNow($buff){
        $halls = self::getTimes();
        $args = self::getPrices($buff);
        if($this->uridium<$args['buyn']){
            return array('log_message'=>"You have not enough Uridum for that!",'type'=>'error');
        }else{
            if(self::pullUri($args['buyn'])){
                if($halls['slot_one']!="none"){
                    if(strpos($halls['slot_one'], $buff) !== false){
                        return self::executeBuyNow('slot_one', $buff, $args);
                    }else{
                        if($halls['slot_two']!="none"){
                            if(strpos($halls['slot_two'], $buff) !== false){
                                return self::executeBuyNow('slot_two', $buff, $args);
                            }else{
                                if($halls['slot_three']!="none"){
                                   if(strpos($halls['slot_three'], $buff) !== false){
                                       return self::executeBuyNow('slot_three', $buff, $args);
                                   }else{
                                       return array('log_message'=>"You does not have space for that!",'type'=>'error');
                                   }
                               }else{
                                    return self::executeBuyNow('slot_three', $buff, $args);
                               }
                            }

                        }else{
                            return self::executeBuyNow('slot_two', $buff, $args);
                        }
                    }
                }else{
                    return self::executeBuyNow('slot_one', $buff, $args);
                } 
            }else{
                return array('log_message'=>"Do not cheat!",'type'=>'error');
            }
        }
    }
    
    public function getTimes(){
        $stmt = $this->con->prepare("SELECT * FROM server_1_player_nanotech WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             if(!empty($result)){
                 return $result[0];
             }
         }
    }
    
    public function convertSeconds($seconds){

        $hours = floor($seconds / 3600);
        $seconds %= 3600;

        $minutes = floor($seconds / 60);
        $seconds %= 60;

      return "$hours hr. $minutes min.";   
    }
    
    public function getDroneParts($lootid){
        $stmt = $this->con->prepare("SELECT Q FROM server_1_player_all_items WHERE lootid=:lootid && playerID=:playerID");
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             if(!empty($result)){
                 if($result[0]['Q'] > 45){
                     return 45;
                 }else{
                     return $result[0]['Q'];
                 }
             }else{
                 return 0;
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
    
    private function pullcre($cre){
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
    
    private function updateSeprom($am, $cm) {
        $sm = $cm - $am;
        $w = "resource_ore_seprom";
        if ($sm >= 0) {
            $rm = $sm;
        }elseif($sm < 0){
            return FALSE;
        }else{
            $rm = 0;
        }  
        $sql = "UPDATE server_1_player_all_items SET Q = $rm  WHERE playerID=:playerID && lootid=:resource_ore_seprom";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stm->bindParam(':resource_ore_seprom', $w, PDO::PARAM_STR);
        if ($stm->execute()):
            return TRUE;
        else:
            return FALSE;
        endif;
    }

    private function updateLogfiles($am, $cm) {
        
        $sm = $cm - $am;
        $w = "resource_logfile";
        if ($sm >= 0) {
            $rm = $sm;
        }elseif($sm < 0){
            return FALSE;
        }else{
            $rm = 0;
        }  
        $sql = "UPDATE server_1_player_all_items SET Q = $rm  WHERE playerID=:playerID && lootid=:resource_logfile";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
        $stm->bindParam(':resource_logfile', $w, PDO::PARAM_STR);
        if ($stm->execute()):
            return TRUE;
        else:;
            return FALSE;
        endif;
        
    }
    
    private function updateDatesINtech($W, $Wvalue, $slot, $slotvalue){
            $sql = "UPDATE server_1_player_nanotech SET $W='$Wvalue', $slot='$slotvalue' WHERE playerID=:playerID";
            $stmt = $this->con->prepare($sql);            
            $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
            if($stmt->execute()){
              return TRUE;           
            }
    }
    private function startProducing($slot, $buff, $args, $instant=null){        
        $cTime = time();
        $c = date("Y-m-d H:i:s", time() + $args['producetime']);
        $halls = self::getTimes();
        if(isset($instant) && $instant!=null && !empty($instant)){
            if($this->uridium<$args['instant']){
                return array('log_message'=>"You have not enough Uridum for that!",'type'=>'error');
            }else{
            self::pullUri($args['instant']);
            $c = $halls[$buff];
            if($halls[$slot]=="none"){
                $cs =$buff."|1|0";
                self::updateDatesINtech($buff, $c, $slot, $cs); 
            }else{
                $s = explode("|", $halls[$slot]);
               
                if($s==0){
                    return FALSE;
                }
                $s[1] = $s[1] + 1;
                $x = implode("|", $s);
                self::updateDatesINtech($buff, $c, $slot, $x);              
            }
            return array('log_message'=>"You started bought 1 ".self::l($buff."name"),'type'=>'success'); 
         }
        }else{
        if($halls[$slot]=="none"){
            $cs =$buff."|0|1";
            self::updateDatesINtech($buff, $c, $slot, $cs); 
            return array('log_message'=>"You started producing 1 ".self::l($buff."name"),'type'=>'success');  
        }else{
            $s = explode("|", $halls[$slot]);
            if($s==0){
                return FALSE;
            }
            if($s[2]==1){
                return array('log_message'=>"You are already producing this tech!",'type'=>'error');
            }
            $s[2] = 1;
            $x = implode("|", $s);
            self::updateDatesINtech($buff, $c, $slot, $x);              
            return array('log_message'=>"You started producing 1 ".self::l($buff."name"),'type'=>'success'); 
        }
        }
    }
    
    public function produceStart($args, $buff, $instant=null) {
        if(empty($buff)){
            return array('log_message'=>"Do not cheat!!",'type'=>'error');
        }
        if(empty($args)){
             return array('log_message'=>"Do not cheat!!",'type'=>'error');
        }
        $myLogfiles = self::getItemsRequired('resource_logfile');
        $mySeprom = self::getItemsRequired('resource_ore_seprom');
        if($args['logdisk']<=$myLogfiles && $args['c']<=$this->credits && $args['seprom']<=$mySeprom){
            if(!self::updateSeprom($args['seprom'], $mySeprom)){
                 return array('log_message'=>"Do not cheat!!",'type'=>'error');
            }
            if(!self::updateLogfiles($args['logdisk'], $myLogfiles)){
                 return array('log_message'=>"Do not cheat!!",'type'=>'error');
            } 
            if(!self::pullcre($args['c'])){
                 return array('log_message'=>"Do not cheat!!",'type'=>'error');
            } 
            $halls = self::getTimes();
            if($halls['slot_one']!="none"){
                if(strpos($halls['slot_one'], $buff) !== false){
                    return self::startProducing('slot_one', $buff, $args, $instant);
                }else{
                    if($halls['slot_two']!="none"){
                        if(strpos($halls['slot_two'], $buff) !== false){
                            return self::startProducing('slot_two', $buff, $args, $instant);
                        }else{
                            if($halls['slot_three']!="none"){
                               if(strpos($halls['slot_three'], $buff) !== false){
                                   return self::startProducing('slot_three', $buff, $args, $instant);
                               }else{
                                   return array('log_message'=>"You does not have space for that!",'type'=>'error');
                               }
                           }else{
                                return self::startProducing('slot_three', $buff, $args, $instant);
                           }
                        }
                       
                    }else{
                        return self::startProducing('slot_two', $buff, $args, $instant);
                    }
                }
            }else{
                return self::startProducing('slot_one', $buff, $args, $instant);
            }       
        }else{
            return array('log_message'=>"You have not enough resources for that!",'type'=>'error');
        }
    }
    
    public function expandHall($facilityID){
        $args = self::getTimes();
        if($facilityID==2){ 
            if($this->uridium>=50000){
                if(self::pullUri(50000)){
                    $sql = "UPDATE server_1_player_nanotech SET slot_two='none' WHERE playerID=:playerID";
                    $stmt = $this->con->prepare($sql);            
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    if($stmt->execute()){
                        DB::setLog($this->pid, "You used 50,000 Uridium on 1 tech slot.");
                          return array('log_message'=>"You expanded your tech slots by 1.",'type'=>'success');          
                    }else{
                         return array('log_message'=>"Do not cheat!!",'type'=>'error');
                    }
                }else{
                    return array('log_message'=>"Do not cheat!!",'type'=>'error');
                }
            }else{                
                return array('log_message'=>"You have not enough Uridum for that!",'type'=>'error');
            }
        }elseif($facilityID==3){
            if($this->uridium>=100000){
                if(self::pullUri(100000)){
                    $sql = "UPDATE server_1_player_nanotech SET slot_three='none' WHERE playerID=:playerID";
                    $stmt = $this->con->prepare($sql);            
                    $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
                    if($stmt->execute()){
                            DB::setLog($this->pid, "You used 100,000 Uridium on 1 tech slot.");
                          return array('log_message'=>"You expanded your tech slots by 1.",'type'=>'success');          
                    }else{
                         return array('log_message'=>"Do not cheat!!",'type'=>'error');;
                    }
                }else{
                    return array('log_message'=>"Do not cheat!!",'type'=>'error');
                }
            }else{                
                return array('log_message'=>"You have not enough Uridum for that!",'type'=>'error');
            }
        }else{
            return array('log_message'=>"Do not cheat!!",'type'=>'error');
        }
//        return array('log_message'=>"You have not enough Uridum for that!",'type'=>'error');
//        return array('log_message'=>"You expanded your tech slots by 1.",'type'=>'success');
    }
    
    public function getItemsRequired($lootid){
        $stmt = $this->con->prepare("SELECT Q FROM server_1_player_all_items WHERE lootid=:lootid && playerID=:playerID");
        $stmt->bindParam(':lootid', $lootid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             if(!empty($result)){                
                return $result[0]['Q'];
             }else{
                 return 0;
             }
         }
    }
    
    public function l($s) {
        $doc = new DOMDocument();
        $doc->load('./ajax/nanoTechfactory/en.xml');
        $xpath = new DOMXPath($doc);
        $query = "//translation/sentence[@id='$s']";
        $elements = $xpath->query($query);
        foreach ($elements as $field) {
            return $field->nodeValue;
        }
        exit;
    }
    
}
?>