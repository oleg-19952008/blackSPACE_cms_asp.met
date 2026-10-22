<?php
class dailybonus
{
	// basic stuff
	private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
	private $con;
	private $uid;

	private $reward;
	private $reward_level;

	public $data;
	public $layer = "no";


	
    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
		$this->con = $GLOBALS['DB'];
    }

	public function setId($uid) {
        $this->uid = $uid;
    }

	public function getData(){
		return $this->data;
	}

	public function getState(){
		return $this->layer;
	}
	
	private function getBonus($day) {
		$bonus = array(
			"day_one" => array(
				"loot" => array ( "credits",
									"plt2026",
									"ggspin"),
				"count" => array ( "50000",
									"100",
									"5")
							),
			"day_two" => array(
				"loot" => array ( "mcb25",
									"credits",
									"ggspin"),
				"count" => array ( "750",
									"85000",
									"5")
							),
			"day_three" => array(
				"loot" => array ( "plt2021",
									"jumpvoucher",
									"ggspin"),
				"count" => array ( "150",
									"3",
									"5")
							),
			"day_four" => array(
				"loot" => array ( "resource_lgf",
									"uridium",
									"ggspin"),
				"count" => array ( "5",
									"250",
									"5")
							),
			"day_five" => array(
				"loot" => array ( "mcb50",
									"repairvoucher",
									"wizx"),
				"count" => array ( "1000",
									"3",
									"5")
							),
						);

		return $bonus['day_' . $day];
	}

	private function init()
	{
		$qry = $this->con->prepare("SELECT dbonus FROM server_1_players WHERE userID = :uID");
		$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
		if ($qry->execute()) {
			if ($qry->rowCount () != 0) {
				$result = $qry->fetchAll(PDO::FETCH_ASSOC);
				
				$arr = explode("|", $result[0]['dbonus']);
				$b['level'] = $arr[0];
				$b['timestamp'] = $arr[1];

				$time = new DateTime();
				$time = $time->getTimestamp();
				
				if(($b['timestamp'] + 86400) <= $time && $time <= ($b['timestamp'] + 192800) || $b['timestamp'] == 0) {
					if($b['level'] == 1)
						$this->reward = "one";
					elseif($b['level'] == 2)
						$this->reward = "two";
					elseif($b['level'] == 3)
						$this->reward = "three";
					elseif($b['level'] == 4)
						$this->reward = "four";
					elseif($b['level'] == 5)
						$this->reward = "five";
					elseif($b['level'] > 5)
						return FALSE;

					$this->reward_level = $b['level'];
					$this->layer = "yes";
					return TRUE;
					
				} elseif($time >= ($b['timestamp'] + 192800) && $b['timestamp'] != 0) {
					$this->reward_level = 1;
					$this->reward = "one";
					$this->layer = "yes";
					return TRUE;
				} else {
					$this->layer = "no";
					return FALSE;
				}
			}
			else
				return FALSE;
		}
		else
			return FALSE;
		
	}
	
	
	
	public function executeb()
	{
		if(isset($_SESSION['server1']['user']['sessionId'], $_SESSION['server1']['user']['email']) && is_numeric($_SESSION['server1']['user']['sessionId'])){
			if(self::init())
			{
				$btype = self::getBonus($this->reward);
				for($i=0;$i<3;$i++){
					if($btype['loot'][$i] == "credits"){
						$qry = $this->con->prepare("UPDATE server_1_players SET credits = credits + :count WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->bindParam(':count', $btype['count'][$i], PDO::PARAM_INT);
						$qry->execute();
					}

					if($btype['loot'][$i] == "uridium"){
						$qry = $this->con->prepare("UPDATE server_1_players SET uri = uri + :count WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->bindParam(':count', $btype['count'][$i], PDO::PARAM_INT);
						$qry->execute();
					}

					if($btype['loot'][$i] == "ggspin"){
						$qry = $this->con->prepare("UPDATE server_1_players SET GGspins = GGspins + :count WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->bindParam(':count', $btype['count'][$i], PDO::PARAM_INT);
						$qry->execute();
					}
						
					if($btype['loot'][$i] == "jumpvoucher"){
						$qry = $this->con->prepare("UPDATE server_1_players SET jumpvouchers = jumpvouchers + :count WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->bindParam(':count', $btype['count'][$i], PDO::PARAM_INT);
						$qry->execute();
					}
						
					if($btype['loot'][$i] == "repairvoucher"){
						$qry = $this->con->prepare("UPDATE server_1_players SET repairvouchers = repairvouchers + :count WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->bindParam(':count', $btype['count'][$i], PDO::PARAM_INT);
						$qry->execute();
					}
						
					if($btype['loot'][$i] != "credits" && $btype['loot'][$i] != "uridium" && $btype['loot'][$i] != "GGspins" && $btype['loot'][$i] != "jumpvoucher" && $btype['loot'][$i] != "repairvoucher")
					{
						//$type = $btype['loot'][$i];
						$qry = $this->con->prepare("SELECT * FROM server_1_player_ammunation WHERE playerID = :uID");
						//$qry = $this->con->prepare("SELECT id FROM server_1_player_all_items WHERE lootid = :type AND userID = :uID");
						//$qry->bindParam(':type', $btype['loot'][$i], PDO::PARAM_STR);
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->execute();

						if ($qry->execute()) {
							if($qry->rowCount () != 0) {
								$sql = "UPDATE server_1_player_ammunation SET " . $btype['loot'][$i] . " = " . $btype['loot'][$i] . " + :count WHERE playerID = :uID";
								$qry = $this->con->prepare($sql);
								$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
								$qry->bindParam(':count', $btype['count'][$i], PDO::PARAM_INT);
								//$qry->bindParam(':type', $btype['loot'][$i], PDO::PARAM_STR);
								$qry->execute();
							} else {
								//storing in old system
								$qry = $this->con->prepare("INSERT INTO server_1_player_all_items (`lootid`, `Q`, `properties`, `interactive`, `playerID`, `userID`) VALUES (:type, :count, '0', 0, :uID, :uID)");
								$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
								$qry->bindParam(':count', $btype['count'][$i], PDO::PARAM_INT);
								$qry->bindParam(':type', $btype['loot'][$i], PDO::PARAM_STR);
								$qry->execute();
							}
						}
					}
				}
				if($this->reward_level != 5)
					$bdata['headline'] = "You logged in today and get the following bonus. Login tomorrow to get the next bonus.";
				else
					$bdata['headline'] = "You get the last bonus. Login tomorrow to get this bonus again.";
				
				$sample_active = "active";
				$sample_comming = "comming";
				$sample_received = "received";
				
				$icon_div = "<div class=\"dl_bonus_received_icon\"><img src=\"do_img/global/pilotSheet/dailyLogin/icon_received.png?__cv=b8d2514ac1824664d197db0587498800\" width=\"21\" height=\"22\"></div>";
				$noicon_div = " ";
				
				$bdata['boxstate_1'] = ($this->reward_level == 1) ? $sample_active : (($this->reward_level > 1) ? $sample_received : $sample_comming);
				$bdata['boxstate_2'] = ($this->reward_level == 2) ? $sample_active : (($this->reward_level > 2) ? $sample_received : $sample_comming);
				$bdata['boxstate_3'] = ($this->reward_level == 3) ? $sample_active : (($this->reward_level > 3) ? $sample_received : $sample_comming);
				$bdata['boxstate_4'] = ($this->reward_level == 4) ? $sample_active : (($this->reward_level > 4) ? $sample_received : $sample_comming);
				$bdata['boxstate_5'] = ($this->reward_level == 5) ? $sample_active : (($this->reward_level > 5) ? $sample_received : $sample_comming);

				$bdata['boxstate_1_icon'] = ($this->reward_level == 1) ? $noicon_div : $icon_div;
				$bdata['boxstate_2_icon'] = ($this->reward_level < 3) ? $noicon_div : $icon_div;
				$bdata['boxstate_3_icon'] = ($this->reward_level < 4) ? $noicon_div : $icon_div;
				$bdata['boxstate_4_icon'] = ($this->reward_level < 5) ? $noicon_div : $icon_div;
				$bdata['boxstate_5_icon'] = ($this->reward_level != 5) ? $noicon_div : $icon_div;
				
				$bdata['progressbar'] = $this->reward_level;
				if($this->reward_level != 5)
					$dbarr[0] = $this->reward_level+1;
				else
					$dbarr[0] = $this->reward_level;
				$time = new DateTime();
				$dbarr[1] = $time->getTimestamp();
				$dbdata = implode("|" , $dbarr);
				$qry = $this->con->prepare("UPDATE server_1_players SET dbonus = :level WHERE userID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':level', $dbdata, PDO::PARAM_INT);
				$qry->execute();

				$this->data = $bdata;
			}
		}
	}
}
?>