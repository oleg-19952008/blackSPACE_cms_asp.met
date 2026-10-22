<?php
class Hangar
{
	private $copyright = "BY Seven & NavigatoR - MEDIANET IVS";
	private $con;
	private $uid;
	//public $DataRow = null;
	//public $HRow = null;
	
    public function __construct() {
        if ($this->copyright != "BY Seven & NavigatoR - MEDIANET IVS") {
            die("Do not violate my copyright");
        }
		$this->con =  $GLOBALS['DB'];

    }

	public function setId($uid) {
        $this->uid = $uid;
    }
	
	public function repairship() {
		$qry = $this->con->prepare("SELECT premium, uri, health, repairvouchers FROM server_1_players WHERE userID = :uID");
		$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
		$qry->execute();
		if ($qry->execute()) {
			$res = $qry->fetchAll(PDO::FETCH_ASSOC);
			if($res[0]['health'] == 0) {
				$prem_timestamp = strtotime($res[0]['premium']);
				$time = new DateTime();
				$time = $time->getTimestamp();
				if($time < $prem_timestamp) {
					$qry = $this->con->prepare("UPDATE server_1_players SET health = 1000 WHERE userID = :uID");
					$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
					$qry->execute();
				}else{
					if($res[0]['repairvouchers'] > 0) {
						$qry = $this->con->prepare("UPDATE server_1_players SET health = 1000, repairvouchers = repairvouchers-1 WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->execute();
					}elseif($res[0]['uri'] < 500){
						$qry = $this->con->prepare("UPDATE server_1_players SET uri = 0, health = 1000 WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->execute();
					}else{
						$qry = $this->con->prepare("UPDATE server_1_players SET uri = uri-500, health = 1000 WHERE userID = :uID");
						$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
						$qry->execute();
					}
				}
			}else{
				die("What are you trying?");
			}
		}else{
			die("Something went wrong!");
		}
	}
	
	public function getHData()
	{
		if(isset($_SESSION['server1']['user']['sessionId'], $_SESSION['server1']['user']['email']) && is_numeric($_SESSION['server1']['user']['sessionId'])){
			
			$shipIdsql = $this->con->prepare("SELECT server_1_players.health AS hp, server_1_players.Nanohull, server_1_players.MaxNanohull, server_1_players.repairvouchers, server_1_players.jumpvouchers, server_1_player_hangar_general_ship.ship_internal_id AS shipId, server_1_hangar.hangarID
												FROM server_1_players, server_1_player_hangar_general_ship, server_1_hangar
													WHERE server_1_players.userID = :uID AND server_1_player_hangar_general_ship.hangarID = server_1_hangar.hangarID AND server_1_hangar.userID = :uID");
			$shipIdsql->bindParam(':uID', $this->uid, PDO::PARAM_INT);
			if ($shipIdsql->execute()) {
				$res = $shipIdsql->fetchAll(PDO::FETCH_ASSOC);
				$shipId = $res[0]['shipId'];
				$HRow['hp'] = $res[0]['hp'];
				$HRow['Nanohull'] = $res[0]['Nanohull'];
				$HRow['MaxNanohull'] = $res[0]['MaxNanohull'];
				$HRow['repairvouchers'] = $res[0]['repairvouchers'];
				$HRow['jumpvouchers'] = $res[0]['jumpvouchers'];
			}

			$shipqry = $this->con->prepare("SELECT ships.HP AS maxhp, ships.shieldAbsorb AS sratio, ships.Speed AS BSpeed, ships.Generators AS Gens FROM ships WHERE ships.Id = :shipId");
			$shipqry->bindParam(':shipId', $shipId, PDO::PARAM_INT);
			if ($shipqry->execute()) {
				$shipdata = $shipqry->fetchAll(PDO::FETCH_ASSOC);
				$HRow['maxhp'] = $shipdata[0]['maxhp'];
				$ratio = 100-$shipdata[0]['sratio'];
				$HRow['ratio'] = "" . $shipdata[0]['sratio'] . "/" . $ratio . "";
				$HRow['MaxSpeed'] = $shipdata[0]['BSpeed'] + ($shipdata[0]['Gens']*10);
			}

			$stuffqry = $this->con->prepare("SELECT count(*) AS rnd
												,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like '%weapon_laser%' AND userID = :uID) AS Lasercnt
												,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid like 'ammunition_laser%' AND userID = :uID) AS Ammocnt
												,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid like 'ammunition_rocket%' AND userID = :uID) AS Rocketcnt
												,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like '%generator_speed%' AND userID = :uID) AS Speedgens
												,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like '%generator_shield%' AND userID = :uID) AS Shieldgens
												,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_i%' AND userID = :uID) AS Uridrones
												,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_f%' AND userID = :uID) AS Credrones
												,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_a%' AND userID = :uID) AS Apis
												,(SELECT count(*) FROM server_1_player_all_items WHERE lootid like 'drone_z%' AND userID = :uID) AS Zeus
												,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid = 'resource_booty-key' AND userID = :uID) AS GreenBKeys
												,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid = 'resource_booty-key-red' AND userID = :uID) AS RedBKeys
												,(SELECT SUM(Q) FROM server_1_player_all_items WHERE lootid = 'resource_booty-key-blue' AND userID = :uID) AS BlueBKeys
													FROM server_1_player_all_items
														WHERE userID = :uID");
			$stuffqry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
			if ($stuffqry->execute()) {
				$equip = $stuffqry->fetchAll(PDO::FETCH_ASSOC);
				$HRow['Lasercnt'] = $equip[0]['Lasercnt'];
				$HRow['Ammocnt'] = $equip[0]['Ammocnt'];
				$HRow['Rocketcnt'] = $equip[0]['Rocketcnt'];
				$HRow['Speedgens'] = $equip[0]['Speedgens'];
				$HRow['Shieldgens'] = $equip[0]['Shieldgens'];
				$HRow['Irescnt'] = $equip[0]['Uridrones'];
				$HRow['Flaxcnt'] = $equip[0]['Credrones'];
				$HRow['Apis'] = $equip[0]['Apis'];
				$HRow['Zeus'] = $equip[0]['Zeus'];

				if ($equip[0]['GreenBKeys'] < 1) {
					$equip[0]['GreenBKeys'] = 0;
				}
				if ($equip[0]['RedBKeys'] < 1) {
					$equip[0]['RedBKeys'] = 0;
				}
				if ($equip[0]['BlueBKeys'] < 1) {
					$equip[0]['BlueBKeys'] = 0;
				}

				$HRow['BKeys'] = "<span title=\"" . $equip[0]['GreenBKeys'] . " Green Booty Keys\" style=\"color: #00FF00\">" . $equip[0]['GreenBKeys'] . "</span> | <span title=\"" . $equip[0]['RedBKeys'] . " Red Booty Keys\" style=\"color: #FF0000\">" . $equip[0]['RedBKeys'] . "</span> | <span title=\"" . $equip[0]['BlueBKeys'] . " Blue Booty Keys\" style=\"color: #0055FF\">" . $equip[0]['BlueBKeys'] . "</span>";
			}
			
			return $HRow;
			//$this->HRow = $HRow;
		}
	}
}
?>