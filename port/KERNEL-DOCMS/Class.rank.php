<?php
/*
 *  FOLLOWING SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
/***********************************/
ini_set('display_errors', '1');  /**/
error_reporting(E_ALL);          /**/
/***********************************/
// DB Class IMPORTANT!

class rank{

    /* Everything the script needs to keep it on track */
    private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
    private $con;
    private $uid;
    private $pid;
    public $uridium;
    public $credits;
    private $count;
    private $paginator;
    private $_limit_per_page = 100;
    private $range = 100; 
    private $page;
    private $url;

    public function __construct() {
        
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
        $this->con = $GLOBALS['DB'];
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
    
    private function getIdFrom($table, $u, $w){
        $sql = "SELECT * FROM $table WHERE type=:w";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':w', $w, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0][$u];
        }
    }
    
    private function getShipID($pid){
        $stmt = $this->con->prepare("SELECT ship_selected_model FROM server_1_player_hangar_general_ship WHERE playerID=:playerID LIMIT 1");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($result)){			
            if(substr_count($result[0]['ship_selected_model'], '_')>1):
                 return self::getIdFrom('ships_designs', 'ShipId', $result[0]['ship_selected_model']);
            else:
                 if($result[0]['ship_selected_model']=="ship_spearhead"):
                    return 11;
                    elseif($result[0]['ship_selected_model']=="ship_aegis"):
                    return 12;
                    elseif($result[0]['ship_selected_model']=="ship_citadel"):
                    return 13;
                    else:
                return self::getIdFrom('ships', 'Id', $result[0]['ship_selected_model']);
                    endif;
            endif;
	    }else{
			return 1; 
		}
        }
    }
	
	public function shipNameFromNumber($num){
	$num = $num-1;
		$nums = array("Phoenix","Yamato","Leonov","Defcom","Liberator","Piranha","Nostromo","Vengeance","Bigboy","Goliath","Spearhead","Aegis","Citadel");
		return $nums[$num];
	}
	
	public function calculateNpcs($arg){
	
		$points = 0;
		foreach ($arg['playerNPC'] as $key => $am){	
			$kne = substr($key, 3);
			if($kne != "84" && $kne != "71")
			$points += $am*$arg['npcINFO'][$kne]['rankPoints'];
		}
		return $points;
	}
	
	public function calculatePlayer($arg){
	
		$points = 0;
		foreach ($arg['playerNPC'] as $key => $am){	
			$kne = substr($key, 4);
			$points += $am*$arg['npcINFO'][$kne]['rankPoints'];
		}
		return $points;
	}
	
	private function updatePlayerpoints($point, $pid){
		$stmt = $this->con->prepare("UPDATE server_1_players SET playerkills=:playerkills WHERE playerID=:playerID");
            $stmt->bindParam(':playerkills', $point, PDO::PARAM_INT);
            $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
            $stmt->execute(); 
	}
	
	private function updateNPCpoints($point, $pid){
		$stmt = $this->con->prepare("UPDATE server_1_players SET npcPoints=:npcPoints WHERE playerID=:playerID");
            $stmt->bindParam(':npcPoints', $point, PDO::PARAM_INT);
            $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
            $stmt->execute(); 
	}
	
	private function getNpcInfo($arg){

		$imp = implode("','", $arg['npcINFO']);
		$stmt = $this->con->prepare("SELECT Id, Name, rankPoints FROM ships WHERE Id in ('".$imp."')");
		if ($stmt->execute()) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$peer = array();
			foreach($result as $k => $val){
				$peer[$val['Id']] = $val;
			}
			$arg['npcINFO'] = $peer;
			return $arg;
		}
	}
	
	public function gePlayerKills($pid){
		$stmt = $this->con->prepare("SELECT * FROM player_kills_count WHERE playerID=:playerID LIMIT 1");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
		if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($result)){
		unset($result[0]['playerID']);
		$re = array("npcINFO"=>array(),"playerNPC"=>$result[0]);
		foreach($result[0] as $key => $val){
			if($key !="ship11" OR $key !="ship12" OR $key !="ship13"){	
				$kne = substr($key, 4);
				array_push($re['npcINFO'], $kne);
			}
		}
			return self::getNpcInfo($re);
		}else{
			return 0;
		}
		}
	}
	
	public function getNpcKill($pid){
		$stmt = $this->con->prepare("SELECT * FROM npc_kills WHERE playerID=:playerID LIMIT 1");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
		if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($result)){
		unset($result[0]['playerID']);
		$re = array("npcINFO"=>array(),"playerNPC"=>$result[0]);
		foreach($result[0] as $key => $val){
			$kne = substr($key, 3);
			array_push($re['npcINFO'], $kne);
		}
			return self::getNpcInfo($re);
		}else{
			return 0;
		}
		}
	}
	
	// companyranking start
	// action=internalHallofFame&view=Faction
	/*
	public function cr_cache_data(){
		$sql = "SELECT SUM(CASE WHEN factionId = '1' THEN rankpoints ELSE 0 END) AS mmo_total,
				SUM(CASE WHEN factionId = '2' THEN rankpoints ELSE 0 END) AS eic_total,
				SUM(CASE WHEN factionId = '3' THEN rankpoints ELSE 0 END) AS vru_total,
				FROM    server_1_players";
				
		
	}
	*/
	
	public function cr_allplayers($fid){
		if(!empty($fid)){
			$factions = array();

			$stmt = $this->con->prepare("SELECT playerID FROM server_1_players WHERE factionId = :fid");
            $stmt->bindParam(':fid', $fid, PDO::PARAM_INT);
			if ($stmt->execute()) {
				if($stmt->rowCount() > 0){
					$result = $stmt->rowCount();
				}else{
					$result = 0;
				}
			}
			return $result;
	$ret = "<td class=\"hof_spacer_hz\"></td>";
	$ret .= "<td class=\"rank_points\">8,816,341,400</td>";
		}
	}
	//cr end
	
	//user exp
	public function ur_exp(){
		$qry = $this->con->prepare("SELECT server_1_players.playerID, server_1_players.exp AS exp, users.name AS name FROM server_1_players, users WHERE users.ID=server_1_players.playerID ORDER BY exp DESC LIMIT 13");
		$qry->execute();
		$res = $qry->fetchAll(PDO::FETCH_ASSOC);
		$ret = "";
		for($i=0;$i<13;$i++){
			$ret .= "<tr>";
			$ret .= "<td class=\"rank_position\">" . ($i+1) . "</td>";
			$ret .= "    <td class=\"rank_name\" title=\"\" showuser=\"" . $i*5234 . "\" style=\"cursor:pointer\">" . $res[$i]['name'] . "</td>"; // dummy -> *5234 -> realdata -> 5 chars
			$ret .= "    <td class=\"rank_points\">" . number_format($res[$i]['exp'], 0, '',',') . "</td>";
			$ret .= "</tr>";
			$ret .= "<tr><td colspan=\"3\" class=\"hof_spacer_vc\"></td></tr>";
		}
		return $ret;
	}
	
	//user honor
	// copy & paste xD
	public function ur_hnr(){
		$qry = $this->con->prepare("SELECT server_1_players.playerID, server_1_players.honor AS exp, users.name AS name FROM server_1_players, users WHERE users.ID=server_1_players.playerID ORDER BY exp DESC LIMIT 13");
		$qry->execute();
		$res = $qry->fetchAll(PDO::FETCH_ASSOC);
		$ret = "";
		for($i=0;$i<13;$i++){
			$ret .= "<tr>";
			$ret .= "<td class=\"rank_position\">" . ($i+1) . "</td>";
			$ret .= "    <td class=\"rank_name\" title=\"\" showuser=\"" . $i*5234 . "\" style=\"cursor:pointer\">" . $res[$i]['name'] . "</td>"; // dummy -> *5234 -> realdata -> 5 chars
			$ret .= "    <td class=\"rank_points\">" . number_format($res[$i]['exp'], 0, '',',') . "</td>";
			$ret .= "</tr>";
			$ret .= "<tr><td colspan=\"3\" class=\"hof_spacer_vc\"></td></tr>";
		}
		return $ret;
	}
	
    public function getAllPlayers($pid = null, $fid = null){
        if(!empty($pid)):
            $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID=:playerID ORDER BY users.ID DESC");
            $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        else:
            $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.playerID=users.ID WHERE server_1_players.rank not in ('21','99') && server_1_players.factionId=:fid ORDER BY users.ID DESC");
            $stmt->bindParam(':fid', $fid, PDO::PARAM_INT);
        endif;
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $all = array();
            foreach ($result as $key => $info){
                $points = array();
                if($info['exp']>100000):
                    $points['exp'] = $info['exp']/100000;
                    else:
                    $points['exp'] = 0;
                endif;
                 if($info['honor']>100):
                    $points['honor'] = $info['honor']/100;
                    else:
                    $points['honor'] = 0;
                endif;
                
				
			if(!empty($pid)):
				$points['playerkills'] = $info['playerkills'];
			else:
				$reag = self::gePlayerKills($info['playerID']);
				if($reag!=0){
					$points['playerkills'] = self::calculatePlayer($reag);	
				}else{
					$points['playerkills'] = 0;
				}      
			    $points['playerkills'] = $points['playerkills']*3;
				self::updatePlayerpoints($points['playerkills'], $info['playerID']);
		    endif;
			
            if(!empty($pid)):
				$points['npckills'] = $info['npcPoints'];
			else:
				$reag = self::getNpcKill($info['playerID']);				
				if($reag!=0){
					$points['npckills'] = self::calculateNpcs($reag);					
				}else{
					$points['npckills'] = 0;
				}                
				self::updateNPCpoints(($points['npckills']/2),$info['playerID']);
		    endif;
                $points['level'] = $info['level']*100;
                $totalDays = self::totalDays($info['regDate']);
                $points['days'] = $totalDays*6;
                
                $shipId = self::getShipID($info['playerID']);
                $points['shipId'] = $shipId*1000;
                if($info['banned']==0){
					$points['total'] = $points['exp']+$points['honor']+$points['playerkills']+$points['level']+$points['days']+$points['shipId']+$points['npckills'];
					$points['playerID'] = $info['playerID'];
					$points['userID'] = $info['userID'];
					$points['Name'] = $info['Name'];
					array_push($all, $points);
				}else{
					$points['total'] = 0;
					$points['playerID'] = $info['playerID'];
					$points['userID'] = $info['userID'];
					$points['Name'] = $info['Name'];
					array_push($all, $points);
				}
                
            }
            if(empty($pid)):
                function cust_sort($a, $b) {
                    return strtolower($a['total']) > strtolower($b['total']);
                }
                usort($all, 'cust_sort');
            endif;
            if(!empty($pid)):
                return array_reverse($all);
            else:
                return self::giveFactionRanks(self::calculateRanks($all, $fid));   
            endif;
        }
    }
    public function setOverAll(){
        $stmt = $this->con->prepare("SELECT server_1_players.playerID, server_1_players.rankpoints, users.banned FROM server_1_players INNER JOIN users ON server_1_players.playerID=users.ID WHERE users.banned='0' ORDER BY rankpoints DESC");
         if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            self::secureSetOverAll($result);
         }
    }
    private function secureSetOverAll($args){
        foreach($args as $k => $v){
            $r = $k +1;
            $stmt = $this->con->prepare("UPDATE server_1_players SET overallRank=:overallRank WHERE playerID=:playerID");
            $stmt->bindParam(':overallRank', $r, PDO::PARAM_INT);
            $stmt->bindParam(':playerID', $v['playerID'], PDO::PARAM_INT);
            $stmt->execute(); 
        }
    }
    private function allRanks(){
        $stmt = $this->con->prepare("SELECT * FROM rank ORDER BY id ASC");
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $k => $v){
                if($v['id']==21 || $v['id']==22 || $v['id']==99 || $v['id']==20):
                    unset($result[$k]);
                endif;
            }
            return $result;
        }
    }
    private function calculateRanks($args, $fid){
        $args = array_reverse($args);
        $a = array();
        array_push($a, $args[0]);
        $a[0]['rankName']="General";
        $a[0]['rankId']=20;
        unset($args[0]);
        $tkeys = count($args);
        $ranks = array_reverse(self::allRanks());
        $nums = array();
        foreach($ranks as $k => $v){
            $nums[$v['id']] = array();
            $cal = round(($v['percentage'] / 100) * $tkeys);
            if($cal<1): $cal=$cal+1; endif;
            $nums[$v['id']]['players'] = $cal;
            $nums[$v['id']]['name'] = $v['name'];
            $nums[$v['id']]['percentage'] = $v['percentage'];
            $nums[$v['id']]['id'] = $v['id'];
        }        
        foreach($nums as $key => $in){
            if(!empty($args)){
            $k = min(array_keys($args));
                for($i = 0; $i < $in['players']; $i++){
                    if(!empty($args)){
                    array_push($a, $args[$k]);
                    $a[$k]['rankName'] = $in['name'];
                    $a[$k]['rankId'] = $in['id']; 
                    unset($args[$k]);
                    $k++;
                    }
                }
            }
        }
        return $a;
    }
    private function giveFactionRanks($args){
        foreach($args as $k => $info){            
            $stmt = $this->con->prepare("UPDATE server_1_players SET rank=:rank, rankpoints=:rankpoints, rankPosition=:rankPosition, rankName=:rankName WHERE playerID=:playerID");
            $stmt->bindParam(':rank', $info['rankId'], PDO::PARAM_INT);
            $stmt->bindParam(':rankpoints', $info['total'], PDO::PARAM_INT);
            $stmt->bindParam(':rankPosition', $k, PDO::PARAM_INT);
            $stmt->bindParam(':rankName', $info['rankName'], PDO::PARAM_STR);
            $stmt->bindParam(':playerID', $info['playerID'], PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    public function getAllRankingPlayers($limit = null){
      if(isset($limit) && !empty($limit)){
         $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.playerID=users.ID WHERE server_1_players.rank not in ('0','21','22','99') && users.banned='0' ORDER BY server_1_players.overallRank ASC LIMIT $limit"); 
        }else{
        $stmt = $this->con->prepare("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.playerID=users.ID WHERE server_1_players.rank not in ('0','21','22','99') && users.banned='0' ORDER BY server_1_players.overallRank ASC");
        }
        if ($stmt->execute()) {
            $this->count = $stmt->rowCount();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function getMyRanking($pid){
        $stmt = $this->con->prepare("SELECT server_1_players.rank, server_1_players.factionId, server_1_players.rankpoints, server_1_players.overallRank  , server_1_players.rankPosition, server_1_players.playerID, users.Name FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE playerID=:playerID");
        $stmt->bindParam(':playerID', $pid, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
    public function getApprox($po, $way, $rid, $fid){
        if($way=="<"):
            $rid = $rid-1;
            $stmt = $this->con->prepare("SELECT rankpoints, overallRank, rankPosition FROM server_1_players WHERE factionId=:fid && rankpoints $way :po && rank=:rid ORDER BY overallRank ASC LIMIT 1");
         
            else:
            $rid = $rid+1;
            $stmt = $this->con->prepare("SELECT rankpoints, overallRank, rankPosition FROM server_1_players WHERE factionId=:fid && rankpoints $way :po && rank=:rid ORDER BY overallRank DESC LIMIT 1");
         
        endif;
        $stmt->bindParam(':po', $po, PDO::PARAM_INT);
         $stmt->bindParam(':rid', $rid, PDO::PARAM_INT);
         $stmt->bindParam(':fid', $fid, PDO::PARAM_INT);
         if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($result)):
               return "-"; 
            endif;
            $pi = $result[0]['rankpoints'];
            if($way=="<"):
                    return $pi;
                else:
                    return $pi-$po;
            endif;
            return $result;
        }
    }
    public function getRankBesideMe($points){
            $be = $points +1;
            $af = $points -1;
            $stmt = $this->con->prepare("SELECT server_1_players.rank, server_1_players.rankpoints, server_1_players.overallRank, server_1_players.rankPosition, server_1_players.playerID, users.Name FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.overallRank=:me || server_1_players.overallRank=:be || server_1_players.overallRank=:af ORDER BY overallRank DESC"); 
            $stmt->bindParam(':me', $points, PDO::PARAM_INT);
            $stmt->bindParam(':be', $be, PDO::PARAM_INT);
            $stmt->bindParam(':af', $af, PDO::PARAM_INT);
//        endif;
        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_reverse($result);
        }
    }
    private function totalDays($reg){
        $now = date('Y-m-d');
        $your_date =  gmdate("Y-m-d", strtotime($reg));
        $startTimeStamp = strtotime($your_date);
        $endTimeStamp = strtotime($now);
        
        $timeDiff = abs($endTimeStamp - $startTimeStamp);

        $numberDays = $timeDiff/86400;  // 86400 seconds in one day

        // and you might want to convert to integer
        $numberDays = intval($numberDays);
        return $numberDays;
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
    public function setUrl($url){
        $this->url = $url;
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
                $navReturn .= "";  
                $previous = $current_page - 1;  
                $navReturn .= " <a href=\"".$this->url."&page" . "="  
                        . $previous .$so  
                        . "\" class=\"previous hof_pages_prev $cl\">Previous</a> ";  
            }  
              $navReturn .="<div class=\"hof_pages\">";
            for (  
                $x = ( $current_page - $range );  
                $x < ( ( $current_page + $range ) + 1 );  
                $x++				
            ) {  
			
				$xs = $x;
                if ( ( $x > 0 ) && ( $x <= $total_of_pages ) ) {  
                    if ( $x == $current_page ) {  
                        $navReturn .= " <span class=\"current $cl\">$x</span> ";  
                    }elseif(($xs+3) == $current_page || ($xs+2) == $current_page || ($xs+1) == $current_page){
						$navReturn .= " <a href=\"".$this->url."&page=". $x  
                              . $so . "\" class=\"others $cl\">$x</a> ";
					}elseif(($xs-3) == $current_page || ($xs-2) == $current_page || ($xs-1) == $current_page){
					$navReturn .= " <a href=\"".$this->url."&page=". $x  
                              . $so . "\" class=\"others $cl\">$x</a> ";
					}else{  
                        /*$navReturn .= " <a href=\"".$this->url."&page=". $x  
                              . $so . "\" class=\"others $cl\">$x</a> ";  */
                    }  
                }  
            }  
               $navReturn .="</div>";
            if ( $current_page != $total_of_pages ) {  
                $next = $current_page + 1;  
                $navReturn .= " <a href=\"".$this->url."&page=" . $next.$so 
                        . "\" class=\"next hof_pages_next $cl\">Next</a> ";  
                $navReturn .= "";  
            }  
              
            $navReturn .= '</div>';
            
        }   
        return $navReturn;
    }  
    
} 
?>