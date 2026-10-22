<?php
class Skylab
{
	// basic stuff
	private $con;
	private $uid;
	
	// player table
	private $uridium;
	private $credits;

	// skylab_ressources table
	private $ressources_array;
	
	// skylab table
	private $mod_basic;
	private $mod_store;
	private $mod_solar;
	private $collector_prometium;
	private $collector_endurium;
	private $collector_terbium;
	private $refine_prometid;
	private $refine_duranium;
	private $refine_promerium;
	private $refine_seprom;
	private $generator_xeno;
	
	public $output;
	
	// generated data
	public $site_data;


	
    public function __construct() {
		$this->con =  $GLOBALS['DB'];

    }
	
	public function getSiteData(){
		return $this->site_data;
	}

	public function getOutput(){
		return $this->output;
	}
	
	
	
	public function setId($uid) {
        $this->uid = $uid;
    }
	
	private function money(){
        $stmt = $this->con->prepare("SELECT uri, credits FROM server_1_players WHERE userID=:uID");
        $stmt->bindParam(':uID', $this->uid, PDO::PARAM_INT);
        $stmt->bindParam(':playerID', $this->pid, PDO::PARAM_INT);
         if ($stmt->execute()) {
             $result = $stmt->fetchAll(PDO::FETCH_OBJ);
             $this->uridium = $result[0]->uri;
             $this->credits = $result[0]->credits;
         }
    }  

	public function initSkylab()
	{
		$qry = $this->con->prepare("SELECT * FROM skylab WHERE UserID = :uID");
		$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
		if ($qry->execute()) {
			if ($qry->rowCount () != 0) {
				$result = $qry->fetchAll(PDO::FETCH_ASSOC);

				$time = new DateTime();
				$time = $time->getTimestamp();

				//todo finish transports here
				
				$basicmod_arr = explode("|", $result[0]['basicmod']);
				$this->mod_basic['level'] = $basicmod_arr[0];
				$this->mod_basic['status'] = $basicmod_arr[1];
				$this->mod_basic['upgrade_finished'] = $basicmod_arr[2];
				
				$storagemod_arr = explode("|", $result[0]['storagemod']);
				$this->mod_store['level'] = $storagemod_arr[0];
				$this->mod_store['status'] = $storagemod_arr[1];
				$this->mod_store['upgrade_finished'] = $storagemod_arr[2];
				
				$solarmod_arr = explode("|", $result[0]['solarmod']);
				$this->mod_solar['level'] = $solarmod_arr[0];
				$this->mod_solar['status'] = $solarmod_arr[1];
				$this->mod_solar['upgrade_finished'] = $solarmod_arr[2];

				$prometiumcol_arr = explode("|", $result[0]['prometiumcol']);
				$this->collector_prometium['level'] = $prometiumcol_arr[0];
				$this->collector_prometium['status'] = $prometiumcol_arr[1];
				$this->collector_prometium['upgrade_finished'] = $prometiumcol_arr[2];
				
				$enduriumcol_arr = explode("|", $result[0]['enduriumcol']);
				$this->collector_endurium['level'] = $enduriumcol_arr[0];
				$this->collector_endurium['status'] = $enduriumcol_arr[1];
				$this->collector_endurium['upgrade_finished'] = $enduriumcol_arr[2];
				
				$terbiumcol_arr = explode("|", $result[0]['terbiumcol']);
				$this->collector_terbium['level'] = $terbiumcol_arr[0];
				$this->collector_terbium['status'] = $terbiumcol_arr[1];
				$this->collector_terbium['upgrade_finished'] = $terbiumcol_arr[2];
				
				$prometidref_arr = explode("|", $result[0]['prometidref']);
				$this->refine_prometid['level'] = $prometidref_arr[0];
				$this->refine_prometid['status'] = $prometidref_arr[1];
				$this->refine_prometid['upgrade_finished'] = $prometidref_arr[2];
				
				$duraniumref_arr = explode("|", $result[0]['duraniumref']);
				$this->refine_duranium['level'] = $duraniumref_arr[0];
				$this->refine_duranium['status'] = $duraniumref_arr[1];
				$this->refine_duranium['upgrade_finished'] = $duraniumref_arr[2];
				
				$promeriumref_arr = explode("|", $result[0]['promeriumref']);
				$this->refine_promerium['level'] = $promeriumref_arr[0];
				$this->refine_promerium['status'] = $promeriumref_arr[1];
				$this->refine_promerium['upgrade_finished'] = $promeriumref_arr[2];
				
				$sepromref_arr = explode("|", $result[0]['sepromref']);
				$this->refine_seprom['level'] = $sepromref_arr[0];
				$this->refine_seprom['status'] = $sepromref_arr[1];
				$this->refine_seprom['upgrade_finished'] = $sepromref_arr[2];
				
				$xenogen_arr = explode("|", $result[0]['xenogen']);
				$this->generator_xeno['level'] = $xenogen_arr[0];
				$this->generator_xeno['status'] = $xenogen_arr[1];
				$this->generator_xeno['upgrade_finished'] = $xenogen_arr[2];
				

				$qryr = $this->con->prepare("SELECT * FROM skylab_ressources WHERE LabID = :uID");
				$qryr->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				if ($qryr->execute()) {
					$ress = $qryr->fetchAll(PDO::FETCH_ASSOC);
					$ress_array = array(
									"prometium" => $ress[0]['prometium'],
									"endurium" => $ress[0]['endurium'],
									"terbium" => $ress[0]['terbium'],
									"prometid" => $ress[0]['prometid'],
									"duranium" => $ress[0]['duranium'],
									"xenomit" => $ress[0]['xenomit'],
									"promerium" => $ress[0]['promerium'],
									"seprom" => $ress[0]['seprom']
										);
					$this->ressources_array = $ress_array;
					
					// update ressources here
					
					// check the upgrades after update ressources
					// 
					if($this->mod_basic['status'] == 2 && $this->mod_basic['upgrade_finished'] != 0){
						if($time >= $this->mod_basic['upgrade_finished']){
							$this->mod_basic['level'] = $this->mod_basic['level']+1;
							$this->mod_basic['status'] = 1;
							$this->mod_basic['upgrade_finished'] = 0;
							$data = implode("|", $this->mod_basic);
							$type = "basicmod";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}

					if($this->mod_store['status'] == 2 && $this->mod_store['upgrade_finished'] != 0){
						if($time >= $this->mod_store['upgrade_finished']){
							$this->mod_store['level'] = $this->mod_store['level']+1;
							$this->mod_store['status'] = 1;
							$this->mod_store['upgrade_finished'] = 0;
							$data = implode("|", $this->mod_store);
							$type = "storagemod";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->mod_solar['status'] == 2 && $this->mod_solar['upgrade_finished'] != 0){
						if($time >= $this->mod_solar['upgrade_finished']){
							$this->mod_solar['level'] = $this->mod_solar['level']+1;
							$this->mod_solar['status'] = 1;
							$this->mod_solar['upgrade_finished'] = 0;
							$data = implode("|", $this->mod_solar);
							$type = "solarmod";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->collector_prometium['status'] == 2 && $this->collector_prometium['upgrade_finished'] != 0){
						if($time >= $this->collector_prometium['upgrade_finished']){
							$this->collector_prometium['level'] = $this->collector_prometium['level']+1;
							$this->collector_prometium['status'] = 1;
							$this->collector_prometium['upgrade_finished'] = 0;
							$data = implode("|", $this->collector_prometium);
							$type = "prometiumcol";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->collector_endurium['status'] == 2 && $this->collector_endurium['upgrade_finished'] != 0){
						if($time >= $this->collector_endurium['upgrade_finished']){
							$this->collector_endurium['level'] = $this->collector_endurium['level']+1;
							$this->collector_endurium['status'] = 1;
							$this->collector_endurium['upgrade_finished'] = 0;
							$data = implode("|", $this->collector_endurium);
							$type = "enduriumcol";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->collector_terbium['status'] == 2 && $this->collector_terbium['upgrade_finished'] != 0){
						if($time >= $this->collector_terbium['upgrade_finished']){
							$this->collector_terbium['level'] = $this->collector_terbium['level']+1;
							$this->collector_terbium['status'] = 1;
							$this->collector_terbium['upgrade_finished'] = 0;
							$data = implode("|", $this->collector_terbium);
							$type = "terbiumcol";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->refine_prometid['status'] == 2 && $this->refine_prometid['upgrade_finished'] != 0){
						if($time >= $this->refine_prometid['upgrade_finished']){
							$this->refine_prometid['level'] = $this->refine_prometid['level']+1;
							$this->refine_prometid['status'] = 1;
							$this->refine_prometid['upgrade_finished'] = 0;
							$data = implode("|", $this->refine_prometid);
							$type = "prometidref";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->refine_duranium['status'] == 2 && $this->refine_duranium['upgrade_finished'] != 0){
						if($time >= $this->refine_duranium['upgrade_finished']){
							$this->refine_duranium['level'] = $this->refine_duranium['level']+1;
							$this->refine_duranium['status'] = 1;
							$this->refine_duranium['upgrade_finished'] = 0;
							$data = implode("|", $this->refine_duranium);
							$type = "duraniumref";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->refine_promerium['status'] == 2 && $this->refine_promerium['upgrade_finished'] != 0){
						if($time >= $this->refine_promerium['upgrade_finished']){
							$this->refine_promerium['level'] = $this->refine_promerium['level']+1;
							$this->refine_promerium['status'] = 1;
							$this->refine_promerium['upgrade_finished'] = 0;
							$data = implode("|", $this->refine_promerium);
							$type = "promeriumref";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->refine_seprom['status'] == 2 && $this->refine_seprom['upgrade_finished'] != 0){
						if($time >= $this->refine_seprom['upgrade_finished']){
							$this->refine_seprom['level'] = $this->refine_seprom['level']+1;
							$this->refine_seprom['status'] = 1;
							$this->refine_seprom['upgrade_finished'] = 0;
							$data = implode("|", $this->refine_seprom);
							$type = "sepromref";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					
					if($this->generator_xeno['status'] == 2 && $this->generator_xeno['upgrade_finished'] != 0){
						if($time >= $this->generator_xeno['upgrade_finished']){
							$this->generator_xeno['level'] = $this->generator_xeno['level']+1;
							$this->generator_xeno['status'] = 1;
							$this->generator_xeno['upgrade_finished'] = 0;
							$data = implode("|", $this->generator_xeno);
							$type = "xenogen";
							$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
							$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
							$qry->bindParam(':data', $data, PDO::PARAM_STR);
							$qry->execute();
						}
					}
					return TRUE;
				}
			} else {
				$time = new DateTime();
				$time = $time->getTimestamp();

				// level|status|finished-timestamp
				$qrys = $this->con->prepare("INSERT INTO `skylab` 
											(`LabID`, `UserID`, `lastvisit`, `basicmod`, `solarmod`, `storagemod`,
											`prometiumcol`, `enduriumcol`, `terbiumcol`, `prometidref`, `duraniumref`,
											`promeriumref`, `xenogen`, `sepromref`)
											VALUES 
											(:uID, :uID, :lv, '1|1|0', '1|1|0', '1|1|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0', '0|0|0')");
				$qrys->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qrys->bindParam(':lv', $time, PDO::PARAM_INT);
				$qrys->execute();
				$qryr = $this->con->prepare("INSERT INTO `skylab_ressources`
											(`LabID`, `prometium`, `endurium`, `terbium`, `prometid`, `duranium`, `xenomit`, `promerium`, `seprom`) 
											VALUES
											(:uID, 50000, 50000, 50000, 0, 0, 0, 0, 0)");
				$qryr->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qryr->execute();
				self::initSkylab();
			}
		}	
	}
	/* 
		$Skylab['ressources']['prometium']['count'] = $this->ressources_array['prometium'];
		$Skylab['ressources']['endurium']['count'] = $this->ressources_array['endurium'];
		$Skylab['ressources']['terbium']['count'] = $this->ressources_array['terbium'];
		$Skylab['ressources']['prometid']['count'] = $this->ressources_array['prometid'];
		$Skylab['ressources']['duranium']['count'] = $this->ressources_array['duranium'];
		$Skylab['ressources']['xenomit']['count'] = $this->ressources_array['xenomit'];
		$Skylab['ressources']['promerium']['count'] = $this->ressources_array['promerium'];
		$Skylab['ressources']['seprom']['count'] = $this->ressources_array['seprom'];

		$Skylab['ressources']['prometium']['max_storage'] = self::storage('raw', $this->mod_store['level']);
		$Skylab['ressources']['endurium']['max_storage'] = self::storage('raw', $this->mod_store['level']);
		$Skylab['ressources']['terbium']['max_storage'] = self::storage('raw', $this->mod_store['level']);
		$Skylab['ressources']['prometid']['max_storage'] = self::storage('refined', $this->mod_store['level']);
		$Skylab['ressources']['duranium']['max_storage'] = self::storage('refined', $this->mod_store['level']);
		$Skylab['ressources']['xenomit']['max_storage'] = self::storage('proxeno', $this->mod_store['level']);
		$Skylab['ressources']['promerium']['max_storage'] = self::storage('proxeno', $this->mod_store['level']);
		$Skylab['ressources']['seprom']['max_storage'] = self::storage('seprom', $this->mod_store['level']);
				
				
	$this->ressources_array['prometium'];
	$this->ressources_array['endurium'];
	$this->ressources_array['prometium'];
	$this->ressources_array['prometium'];
	*/

	public function ressupdate($mode = "out"){
		$qry = $this->con->prepare("SELECT lastvisit FROM Skylab WHERE UserID = :uID");
		$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
		$qry->execute();
		$arr = $qry->fetchAll(PDO::FETCH_ASSOC);
		$lv = $arr[0]['lastvisit'];
		
		$time = new DateTime();
		$time = $time->getTimestamp();
		
		$multi = $time-$lv;
	
		if($this->collector_prometium['status'] == 1)
			$prometium_per_sec = (int) self::ressource_generation('raw',$this->collector_prometium['level'])/3600;
		else
			$prometium_per_sec = 0;
			
		if($this->collector_endurium['status'] == 1)
			$endurium_per_sec = (int) self::ressource_generation('raw',$this->collector_endurium['level'])/3600;
		else
			$endurium_per_sec = 0;
		
		if($this->collector_terbium['status'] == 1)
			$terbium_per_sec = (int) self::ressource_generation('raw',$this->collector_terbium['level'])/3600;
		else
			$terbium_per_sec = 0;
		
		if($this->refine_prometid['status'] == 1){
			$prometid_per_sec = (int) self::ressource_generation('refined',$this->refine_prometid['level'])/3600;
			$prometium_usage = $prometid_per_sec*20;
			$endurium_usage1 = $prometid_per_sec*10;
		}else
			$prometid_per_sec = 0;
		
		if($this->refine_duranium['status'] == 1){
			$duranium_per_sec = (int) self::ressource_generation('refined',$this->refine_duranium['level'])/3600;
			$terbium_usage = $duranium_per_sec*20;
			$endurium_usage2 = $duranium_per_sec*10;
		}else
			$duranium_per_sec = 0;
		
		if($this->refine_promerium['status'] == 1){
			$promerium_per_sec = (int) self::ressource_generation('proxeno',$this->refine_promerium['level'])/3600;
			$prometid_usage = $promerium_per_sec*10;
			$duranium_usage = $promerium_per_sec*10;
		 }else
			$promerium_per_sec = 0;
			
		if($this->refine_seprom['status'] == 1){
			$seprom_per_sec = (int) self::ressource_generation('seprom',$this->refine_seprom['level'])/3600;
			$promerium_usage = $seprom_per_sec*10;
		}else	
			$seprom_per_sec = 0;
			
		if($this->generator_xeno['status'] == 1)
			$xeno_per_sec = (int) self::ressource_generation('proxeno',$this->generator_xeno['level'])/3600;
		else
			$xeno_per_sec = 0;
		
		if(isset($prometium_usage))
			$prometium_per_sec = $prometium_per_sec-$prometium_usage;

		if(isset($endurium_usage1) && isset($endurium_usage2))
			$endurium_per_sec = $endurium_per_sec-($endurium_usage1+$endurium_usage2);
		elseif(isset($endurium_usage1) && !isset($endurium_usage2))
			$endurium_per_sec = $endurium_per_sec-$endurium_usage1;
		elseif(!isset($endurium_usage1) && isset($endurium_usage2))
			$endurium_per_sec = $endurium_per_sec-$endurium_usage2;
		
		if(isset($terbium_usage))
			$terbium_per_sec = $terbium_per_sec-$terbium_usage;
		
		if(isset($prometid_usage))
			$prometid_per_sec = $prometid_per_sec-$prometid_usage;
		
		if(isset($duranium_usage))
			$duranium_per_sec = $duranium_per_sec-$duranium_usage;
		
		if(isset($promerium_usage))
			$promerium_per_sec = $promerium_per_sec-$promerium_usage;
		
		$raw_max = self::storage('raw', $this->mod_store['level']);
		$ref_max = self::storage('refined', $this->mod_store['level']);
		$pro_max = self::storage('proxeno', $this->mod_store['level']);
		$sep_max = self::storage('seprom', $this->mod_store['level']);
		
		$free = $raw_max-$this->ressources_array['prometium'];
		$v01 = round($prometium_per_sec*$multi);
		if($v01 > $free)
			$v01 = $free;
		
		$freee = $raw_max-$this->ressources_array['endurium'];
		$v02 = round($endurium_per_sec*$multi);
		if($v02 > $freee)
			$v02 = $freee;

		$freeee = $raw_max-$this->ressources_array['terbium'];
		$v03 = round($terbium_per_sec*$multi);
		if($v03 > $freeee)
			$v03 = $freeee;
		
		$reeee = $ref_max-$this->ressources_array['prometid'];
		$v04 = round($prometid_per_sec*$multi);
		if($v04 > $reeee)
			$v04 = $reeee;
		
		$eeeee = $ref_max-$this->ressources_array['duranium'];
		$v05 = round($duranium_per_sec*$multi);
		if($v05 > $eeeee)
			$v05 = $eeeee;
		
		$yoour = $pro_max-$this->ressources_array['xenomit'];
		$v06 = round($xeno_per_sec*$multi);
		if($v06 > $yoour)
			$v06 = $yoour;
		
		$mmiii = $pro_max-$this->ressources_array['promerium'];
		$v07 = round($promerium_per_sec*$multi);
		if($v07 > $mmiii)
			$v07 = $mmiii;
		
		$iinnd = $sep_max-$this->ressources_array['seprom'];
		$v08 = round($seprom_per_sec*$multi);
		if($v08 > $iinnd)
			$v08 = $iinnd;
		
		
		if($mode == "out"){
			$this->output['prometium'] = round($prometium_per_sec*3600);
			$this->output['endurium'] = round($endurium_per_sec*3600);
			$this->output['terbium'] = round($terbium_per_sec*3600);
			$this->output['prometid'] = round($prometid_per_sec*3600);
			$this->output['duranium'] = round($duranium_per_sec*3600);
			$this->output['xenomit'] = round($xeno_per_sec*3600);
			$this->output['promerium'] = round($promerium_per_sec*3600);
			$this->output['seprom'] = round($seprom_per_sec*3600);
		}elseif($mode == "update"){
			$qry = $this->con->prepare("UPDATE skylab, skylab_ressources 
										  SET skylab.lastvisit = :ts,
											  skylab_ressources.prometium = skylab_ressources.prometium + :v01,
											  skylab_ressources.endurium = skylab_ressources.endurium + :v02,
											  skylab_ressources.terbium = skylab_ressources.terbium + :v03,
											  skylab_ressources.prometid = skylab_ressources.prometid + :v04,
											  skylab_ressources.duranium = skylab_ressources.duranium + :v05,
											  skylab_ressources.xenomit = skylab_ressources.xenomit + :v06,
											  skylab_ressources.promerium = skylab_ressources.promerium + :v07,
											  skylab_ressources.seprom = skylab_ressources.seprom + :v08 
											WHERE skylab.UserID = :uID AND skylab_ressources.LabID = skylab.UserID");
			$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
			$qry->bindParam(':ts', $time, PDO::PARAM_INT);
			$qry->bindParam(':v01', $v01, PDO::PARAM_INT);
			$qry->bindParam(':v02', $v02, PDO::PARAM_INT);
			$qry->bindParam(':v03', $v03, PDO::PARAM_INT);
			$qry->bindParam(':v04', $v04, PDO::PARAM_INT);
			$qry->bindParam(':v05', $v05, PDO::PARAM_INT);
			$qry->bindParam(':v06', $v06, PDO::PARAM_INT);
			$qry->bindParam(':v07', $v07, PDO::PARAM_INT);
			$qry->bindParam(':v08', $v08, PDO::PARAM_INT);
			$qry->execute();
		}
	}
	
	public function displayBuild()
	{
		//if(self::initSkylab()) {
			$ret = "<div id=\"skylab_shadow\"></div>";
			
			if($this->collector_prometium['level'] != 0){
				$ret .= "<div id=\"backgroundPrometiumCollector\"></div>";
				$ret .= "<div id=\"uplinkPrometiumCollector\"></div>";
			}

			if($this->collector_endurium['level'] != 0){
				$ret .= "<div id=\"backgroundEnduriumCollector\"></div>";
				$ret .= "<div id=\"uplinkEnduriumCollector\"></div>";
			}

			if($this->collector_terbium['level'] != 0){
				$ret .= "<div id=\"backgroundTerbiumCollector\"></div>";
				$ret .= "<div id=\"uplinkTerbiumCollector\"></div>";
			}

			if($this->refine_prometid['level'] != 0){
				$ret .= "<div id=\"backgroundPrometidRefinery\"></div>";
				$ret .= "<div id=\"uplinkPrometidRefinery\"></div>";
			}

			if($this->refine_duranium['level'] != 0){
				$ret .= "<div id=\"backgroundDuraniumRefinery\"></div>";
				$ret .= "<div id=\"uplinkDuraniumRefinery\"></div>";
			}

			if($this->refine_promerium['level'] != 0){
				$ret .= "<div id=\"backgroundPromeriumRefinery\"></div>";
				$ret .= "<div id=\"uplinkPromeriumRefinery\"></div>";
			}

			if($this->refine_seprom['level'] != 0){
				$ret .= "<div id=\"backgroundSepromRefinery\"></div>";
				$ret .= "<div id=\"uplinkSepromRefinery\"></div>";
			}

			if($this->generator_xeno['level'] != 0){
				$ret .= "<div id=\"backgroundXenoModule\"></div>";
				$ret .= "<div id=\"uplinkXenoModule\"></div>";
			}
			
			return $ret;
		//}
	}
	
	public function setStatus($module, $nst, $act){
		if($act == "status"){
			if($module == "xenoModule"){
				$type = "xenogen";
				$data = "" . $this->generator_xeno['level'] . "|" . $nst . "|0";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);

				if($qry->execute()){
					$this->generator_xeno['status'] = $nst;
				}
			}elseif($module == "prometiumCollector"){
				$type = "prometiumcol";
				$data = "" . $this->collector_prometium['level'] . "|" . $nst . "|0";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->collector_prometium['status'] = $nst;
				}
			}elseif($module == "enduriumCollector"){
				$type = "enduriumcol";
				$data = "" . $this->collector_endurium['level'] . "|" . $nst . "|0";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->collector_endurium['status'] = $nst;
				}
			}elseif($module == "terbiumCollector"){
				$type = "terbiumcol";
				$data = "" . $this->collector_terbium['level'] . "|" . $nst . "|0";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->collector_terbium['status'] = $nst;
				}
			}elseif($module == "prometidRefinery"){
				$type = "prometidref";
				$data = "" . $this->refine_prometid['level'] . "|" . $nst . "|0";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_prometid['status'] = $nst;
				}
			}elseif($module == "duraniumRefinery"){
				$type = "duraniumref";
				$data = "" . $this->refine_duranium['level'] . "|" . $nst . "|0";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_duranium['status'] = $nst;
				}
			}elseif($module == "promeriumRefinery"){
				$type = "promeriumref";
				$data = "" . $this->refine_promerium['level'] . "|" . $nst . "|0";
				
				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_promerium['status'] = $nst;
				}
			}elseif($module == "sepromRefinery"){
				$type = "sepromref";
				$data = "" . $this->refine_seprom['level'] . "|" . $nst . "|0";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_seprom['status'] = $nst;
				}
			}
		}elseif($act == "upthis"){
		
			$time = new DateTime();
			$time = $time->getTimestamp();
			// actions table
			// actionid(AI)(PK)|labid(PK)|actiontype|actiondate|finishedts
		
			if($module == "xenoModule"){
				$type = "xenogen";
				$nt = (int) self::upgrade_time('refine',$this->generator_xeno['level']+1);
				$time = $time + $nt;
				$data = "" . $this->generator_xeno['level'] . "|" . $nst . "|" . $time . "";
				
				/*
				
				private function req_ress($type, $level, $instant = 'no'){
				
				$up_cost_raw = self::upgrade_cost('generator','cost_raw',$this->generator_xeno['level']+1);
				$up_cost_cre = self::upgrade_cost('generator','cost_cre',$this->generator_xeno['level']+1);
				$up_cost_uri = self::upgrade_cost('generator','cost_uri',$this->generator_xeno['level']+1);
					$raw = ;
					$cre = ;
					if($instant != 'no')
						$uri = ;
					
				}
				$qry = $this->con->prepare("UPDATE skylab_ressources SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->execute();*/
				
				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				
				

				if($qry->execute()){
					$this->generator_xeno['status'] = $nst;
				}
			}elseif($module == "prometiumCollector"){
				$type = "prometiumcol";
				$nt = (int) self::upgrade_time('collectors',$this->collector_prometium['level']+1);
				$time = $time + $nt;
				$data = "" . $this->collector_prometium['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->collector_prometium['status'] = $nst;
				}
			}elseif($module == "enduriumCollector"){
				$type = "enduriumcol";
				$nt = (int) self::upgrade_time('collectors',$this->collector_endurium['level']+1);
				$time = $time + $nt;
				$data = "" . $this->collector_endurium['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->collector_endurium['status'] = $nst;
				}
			}elseif($module == "terbiumCollector"){
				$type = "terbiumcol";
				$nt = (int) self::upgrade_time('collectors',$this->collector_terbium['level']+1);
				$time = $time + $nt;
				$data = "" . $this->collector_terbium['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->collector_terbium['status'] = $nst;
				}
			}elseif($module == "prometidRefinery"){
				$type = "prometidref";
				$nt = (int) self::upgrade_time('refine',$this->refine_prometid['level']+1);
				$time = $time + $nt;
				$data = "" . $this->refine_prometid['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_prometid['status'] = $nst;
				}
			}elseif($module == "duraniumRefinery"){
				$type = "duraniumref";
				$nt = (int) self::upgrade_time('refine',$this->refine_duranium['level']+1);
				$time = $time + $nt;
				$data = "" . $this->refine_duranium['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_duranium['status'] = $nst;
				}
			}elseif($module == "promeriumRefinery"){
				$type = "promeriumref";
				$nt = (int) self::upgrade_time('refine',$this->refine_promerium['level']+1);
				$time = $time + $nt;
				$data = "" . $this->refine_promerium['level'] . "|" . $nst . "|" . $time . "";
				
				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
			//	$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_promerium['status'] = $nst;
				}
			}elseif($module == "sepromRefinery"){
				$type = "sepromref";
				$nt = (int) self::upgrade_time('seprom',$this->refine_seprom['level']+1);
				$time = $time + $nt;
				$data = "" . $this->refine_seprom['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);
				
				if($qry->execute()){
					$this->refine_seprom['status'] = $nst;
				}
			}elseif($module == "storageModule"){
				$type = "storagemod";
				$nt = (int) self::upgrade_time('basic',$this->mod_store['level']+1);
				$time = $time + $nt;
				$data = "" . $this->mod_store['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);

				if($qry->execute()){
					$this->mod_store['status'] = $nst;
				}
			}elseif($module == "solarModule"){
				$type = "solarmod";
				$nt = (int) self::upgrade_time('basic',$this->mod_solar['level']+1);
				$time = $time + $nt;
				$data = "" . $this->mod_solar['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);

				if($qry->execute()){
					$this->mod_solar['status'] = $nst;
				}
			}elseif($module == "baseModule"){
				$type = "basicmod";
				$nt = (int) self::upgrade_time('basic',$this->mod_basic['level']+1);
				$time = $time + $nt;
				$data = "" . $this->mod_basic['level'] . "|" . $nst . "|" . $time . "";

				$qry = $this->con->prepare("UPDATE skylab SET {$type} = :data WHERE UserID = :uID");
				$qry->bindParam(':uID', $this->uid, PDO::PARAM_INT);
				$qry->bindParam(':data', $data, PDO::PARAM_STR);
				//$qry->bindParam(":type", $type, PDO::PARAM_STR);

				if($qry->execute()){
					$this->mod_basic['status'] = $nst;
				}
			}
		}elseif($act == "instaup"){
		
		}
	}
	
	public function showModule($module,$srq) {
		if($module == "xenoModule"){
			$req = "xenoModule";
			$name = "Xeno Module";
			$level = $this->generator_xeno['level'];
			$status = $this->generator_xeno['status'];
			$eusage = self::energy_usage($this->generator_xeno['level']);
			$type = "other";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('generator','cost_raw',$this->generator_xeno['level']+1);
				$up_cost_cre = self::upgrade_cost('generator','cost_cre',$this->generator_xeno['level']+1);
				$up_cost_uri = self::upgrade_cost('generator','cost_uri',$this->generator_xeno['level']+1);
				$up_time = (int) self::upgrade_time('refine',$this->generator_xeno['level']+1);
			}
			if($status == 2)
				$fts = $this->generator_xeno['upgrade_finished'];
		}elseif($module == "prometiumCollector"){
			$req = "prometiumCollector";
			$name = "Prometium collector";
			$level = $this->collector_prometium['level'];
			$status = $this->collector_prometium['status'];
			$eusage = self::energy_usage($this->collector_prometium['level']);
			$type = "other";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('collectors','cost_raw',$this->collector_prometium['level']+1);
				$up_cost_cre = self::upgrade_cost('collectors','cost_cre',$this->collector_prometium['level']+1);
				$up_cost_uri = self::upgrade_cost('collectors','cost_uri',$this->collector_prometium['level']+1);
				$up_time = (int) self::upgrade_time('collectors',$this->collector_prometium['level']+1);
			}
			if($status == 0 || $status == 2)
				$cdgens_cnt = "0";
			else
				$cdgens_cnt = self::ressource_generation("raw",$this->collector_prometium['level']);
			
			if($status == 2)
				$fts = $this->collector_prometium['upgrade_finished'];
		}elseif($module == "enduriumCollector"){
			$req = "enduriumCollector";
			$name = "Endurium collector";
			$level = $this->collector_endurium['level'];
			$status = $this->collector_endurium['status'];
			$eusage = self::energy_usage($this->collector_endurium['level']);
			$type = "other";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('collectors','cost_raw',$this->collector_endurium['level']+1);
				$up_cost_cre = self::upgrade_cost('collectors','cost_cre',$this->collector_endurium['level']+1);
				$up_cost_uri = self::upgrade_cost('collectors','cost_uri',$this->collector_endurium['level']+1);
				$up_time = (int) self::upgrade_time('collectors',$this->collector_endurium['level']+1);
			}
			if($status == 0 || $status == 2)
				$cdgens_cnt = "0";
			else
				$cdgens_cnt = self::ressource_generation("raw",$this->collector_endurium['level']);

			if($status == 2)
				$fts = $this->collector_endurium['upgrade_finished'];
		}elseif($module == "terbiumCollector"){
			$req = "terbiumCollector";
			$name = "Terbium collector";
			$level = $this->collector_terbium['level'];
			$status = $this->collector_terbium['status'];
			$eusage = self::energy_usage($this->collector_terbium['level']);
			$type = "other";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('collectors','cost_raw',$this->collector_terbium['level']+1);
				$up_cost_cre = self::upgrade_cost('collectors','cost_cre',$this->collector_terbium['level']+1);
				$up_cost_uri = self::upgrade_cost('collectors','cost_uri',$this->collector_terbium['level']+1);
				$up_time = (int) self::upgrade_time('collectors',$this->collector_terbium['level']+1);
			}
			if($status == 0 || $status == 2)
				$cdgens_cnt = "0";
			else
				$cdgens_cnt = self::ressource_generation("raw",$this->collector_terbium['level']);
				
			if($status == 2)
				$fts = $this->collector_terbium['upgrade_finished'];
		}elseif($module == "prometidRefinery"){
			$req = "prometidRefinery";
			$name = "Prometid refinery";
			$level = $this->refine_prometid['level'];
			$status = $this->refine_prometid['status'];
			$eusage = self::energy_usage($this->refine_prometid['level']);
			$type = "refinery";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('refine','cost_raw',$this->refine_prometid['level']+1);
				$up_cost_cre = self::upgrade_cost('refine','cost_cre',$this->refine_prometid['level']+1);
				$up_cost_uri = self::upgrade_cost('refine','cost_uri',$this->refine_prometid['level']+1);
				$up_time = (int) self::upgrade_time('refine',$this->refine_prometid['level']+1);
			}
			$rdtype = "3";
			$rduseone = "prometium";
			$rdusetwo = "endurium";
			$rdgens = "prometid";
			if($status == 0 || $status == 2){
				$rduseone_con = "0";
				$rdusetwo_con = "0";
				$rdgens_cnt = "0";
			}else{
				$rdgens_cnt = self::ressource_generation("refined",$this->refine_prometid['level']);
				$rduseone_con = $rdgens_cnt*20;
				$rdusetwo_con = $rdgens_cnt*10;
			}
			
			if($status == 2)
				$fts = $this->refine_prometid['upgrade_finished'];
		}elseif($module == "duraniumRefinery"){
			$req = "duraniumRefinery";
			$name = "Duranium refinery";
			$level = $this->refine_duranium['level'];
			$status = $this->refine_duranium['status'];
			$eusage = self::energy_usage($this->refine_duranium['level']);
			$type = "refinery";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('refine','cost_raw',$this->refine_duranium['level']+1);
				$up_cost_cre = self::upgrade_cost('refine','cost_cre',$this->refine_duranium['level']+1);
				$up_cost_uri = self::upgrade_cost('refine','cost_uri',$this->refine_duranium['level']+1);
				$up_time = (int) self::upgrade_time('refine',$this->refine_duranium['level']+1);
			}
			$rdtype = "3";
			$rduseone = "endurium";
			$rdusetwo = "terbium";
			$rdgens = "duranium";
			if($status == 0 || $status == 2){
				$rduseone_con = "0";
				$rdusetwo_con = "0";
				$rdgens_cnt = "0";
			}else{
				$rdgens_cnt = self::ressource_generation("refined",$this->refine_duranium['level']);
				$rduseone_con = $rdgens_cnt*10;
				$rdusetwo_con = $rdgens_cnt*20;
			}
			
			if($status == 2)
				$fts = $this->refine_duranium['upgrade_finished'];
		}elseif($module == "promeriumRefinery"){
			$req = "promeriumRefinery";
			$name = "Promerium refinery";
			$level = $this->refine_promerium['level'];
			$status = $this->refine_promerium['status'];
			$eusage = self::energy_usage($this->refine_promerium['level']);
			$type = "refinery";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('refine','cost_raw',$this->refine_promerium['level']+1);
				$up_cost_cre = self::upgrade_cost('refine','cost_cre',$this->refine_promerium['level']+1);
				$up_cost_uri = self::upgrade_cost('refine','cost_uri',$this->refine_promerium['level']+1);
				$up_time = (int) self::upgrade_time('refine',$this->refine_promerium['level']+1);
			}
			
			//$rdtype = "4"; // for xeno
			$rdtype = "3";
			$rduseone = "prometid";
			$rdusetwo = "duranium";
			$rdgens = "promerium";
			if($status == 0 || $status == 2){
				$rduseone_con = "0";
				$rdusetwo_con = "0";
				$rdgens_cnt = "0";
			}else{
				$rdgens_cnt = self::ressource_generation("proxeno",$this->refine_promerium['level']);
				$rduseone_con = $rdgens_cnt*10;
				$rdusetwo_con = $rdgens_cnt*10;
			}
		
			if($status == 2)
				$fts = $this->refine_promerium['upgrade_finished'];
		}elseif($module == "sepromRefinery"){
			$req = "sepromRefinery";
			$name = "Seprom refinery";
			$level = $this->refine_seprom['level'];
			$status = $this->refine_seprom['status'];
			$eusage = self::energy_usage($this->refine_seprom['level']);
			$type = "refinery";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('refine_sep','cost_raw',$this->refine_seprom['level']+1);
				$up_cost_cre = self::upgrade_cost('refine_sep','cost_cre',$this->refine_seprom['level']+1);
				$up_cost_uri = self::upgrade_cost('refine_sep','cost_uri',$this->refine_seprom['level']+1);
				$up_time = (int) self::upgrade_time('seprom',$this->refine_seprom['level']+1);
			}
			$rdtype = "2";
			$rduseone = "promerium";
			$rdusetwo = "";
			$rdgens = "seprom";
			if($status == 0 || $status == 2){
				$rduseone_con = "0";
				$rdusetwo_con = "";
				$rdgens_cnt = "0";
			}else{
				$rdgens_cnt = self::ressource_generation("seprom",$this->refine_seprom['level']);
				$rduseone_con = $rdgens_cnt*10;
				$rdusetwo_con = "";
			}
			
			if($status == 2)
				$fts = $this->refine_seprom['upgrade_finished'];
		}elseif($module == "storageModule"){
			$req = "storageModule";
			$name = "Storage module";
			$level = $this->mod_store['level'];
			$status = $this->mod_store['status'];
			$eusage = self::energy_usage($this->mod_store['level']);
			$type = "other";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('store','cost_raw',$this->mod_store['level']+1);
				$up_cost_cre = self::upgrade_cost('store','cost_cre',$this->mod_store['level']+1);
				$up_cost_uri = self::upgrade_cost('store','cost_uri',$this->mod_store['level']+1);
				$up_time = (int) self::upgrade_time('basic',$this->mod_store['level']+1);
			}
			if($status == 2)
				$fts = $this->mod_basic['upgrade_finished'];
		}elseif($module == "solarModule"){
			$req = "solarModule";
			$name = "Solar module";
			$level = $this->mod_solar['level'];
			$status = $this->mod_solar['status'];
			$type = "other";
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('solar','cost_raw',$this->mod_solar['level']+1);
				$up_cost_cre = self::upgrade_cost('solar','cost_cre',$this->mod_solar['level']+1);
				$up_cost_uri = self::upgrade_cost('solar','cost_uri',$this->mod_solar['level']+1);
				$up_time = (int) self::upgrade_time('basic',$this->mod_solar['level']+1);
			}
			$eusage = self::energy_all_usage();
			$prod = self::energy_production($this->mod_solar['level']);

			if($status == 2)
				$fts = $this->mod_solar['upgrade_finished'];
		}elseif($module == "baseModule"){
			$req = "baseModule";
			$name = "Basic module";
			$level = $this->mod_basic['level'];
			if($level < 20){
				$up_cost_raw = self::upgrade_cost('basic','cost_raw',$this->mod_basic['level']+1);
				$up_cost_cre = self::upgrade_cost('basic','cost_cre',$this->mod_basic['level']+1);
				$up_cost_uri = self::upgrade_cost('basic','cost_uri',$this->mod_basic['level']+1);
				$up_time = (int) self::upgrade_time('basic',$this->mod_basic['level']+1);
			}
			
			$status = $this->mod_basic['status'];
			$eusage = self::energy_usage($this->mod_basic['level']);
			$type = "other";
			
			if($status == 2)
				$fts = $this->mod_basic['upgrade_finished'];
		}
		
		if($module != "solarModule" && $module != "baseModule" && $module != "storageModule")
			$eusage = ($status == 0 || $status == 2) ? "0" : $eusage;

		$corner_status = ($status == 0 || $status == 2) ? "inactive" : "active";
		$name_status = ($status > 0) ? "" : "_inactive";
		$level_icon_status = ($status == 2) ? "level_icon_upgrade" : (($status == 0) ? "level_icon_inactive" : "level_icon");
		$font_level_status = ($status == 0) ? "level skylab_font_level_inactive" : "level skylab_font_level";
		$efficiency = ($status == 0 || $status == 2) ? "0" : "100";

		if($srq == "smallbox"){
			$ret = "<div id=\"module_" . $req . "_small\" class=\"module module_small\" onclick=\"Skylab.showModule('" . $req . "');\"\">";
			$ret .= "    <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
			$ret .= "        <tr>";
			$ret .= "            <td id=\"corner_small_top_left_" . $corner_status . "\">";
			$ret .= "                <div class=\"name" . $name_status . "\">" . $name . "</div>";
			$ret .= "            </td>";
			$ret .= "            <td id=\"corner_small_top_right_" . $corner_status . "\"></td>";
			$ret .= "        </tr>";
			$ret .= "        <tr>";
			$ret .= "            <td id=\"corner_small_bottom_left_" . $corner_status . "\">";
			if($level > 0){
				$ret .= "	    <table cellpadding=\"0\" cellspacing=\"0\">";
				$ret .= "            <tr>";
				$ret .= "                <td>";
				$ret .= "                    <div class=\"" . $level_icon_status . "\"></div>";
				$ret .= "                    <div class=\"" . $font_level_status . "\">" . $level . "</div>";
				$ret .= "                </td>";
				$ret .= "                <td class=\"cellview\">";
				$ret .= "                    <div class=\"power_icon\"></div>";
				if($req != "solarModule")
					$ret .= "                   <div class=\"power skylab_font_power\">" . $eusage . "</div>";
				else
					$ret .= "                   <div class=\"power skylab_font_power\">" . $eusage . " / " . $prod . "</div>";
				$ret .= "                </td>";
				if($type == "refinery"){
					$ret .= "            <td class=\"cellview\">";
					$ret .= "                 <div class=\"efficiency_icon\"></div>";
					$ret .= "                 <div class=\"efficiency skylab_font_efficiency\">" . $efficiency . "%</div>";
					$ret .= "            </td>";
				}
				$ret .= "                <td><br /></td>";
				$ret .= "            </tr>";
				$ret .= "        </table>";
			}
			$ret .= "    </td>";
			$ret .= "    <td id=\"corner_small_bottom_right_" . $corner_status . "\"></td>";
			$ret .= "</tr>";
			$ret .= "</table>";
			$ret .= "</div>";
		}elseif($srq == "refineryDetails"){
			$ret = "<div id=\"module_infobox_" . $req . "_overview_large\" class=\"tabContent skylab_standard\">";
			$ret .= "    <div style=\"height:135px;background-image: url(./do_img/global/pilotSheet/skylab/bg_refinery_" . $rdtype . ".png?__cv=8a7c8d311f248f5e62d247296cbdc300); background-repeat:no-repeat;background-position: center 25px\">";
			$ret .= "		<div style=\"position:absolute;left:75px;top:90px;\" class=\"ore_" . $rduseone . "\"><strong>" . $rduseone . "<br />" . $rduseone_con . "</strong></div>";
			if($req != "sepromRefinery"){
				$ret .= "        <div style=\"position:absolute;left:235px;top:90px;text-align:right;\" class=\"ore_" . $rdusetwo . "\"><strong>" . $rdusetwo . "<br />" . $rdusetwo_con . "</strong></div>";
			}
			$ret .= "        <div style=\"position:absolute;left:100px;top:150px;\">" . $efficiency . "%</div>";
			$ret .= "        <div style=\"position:absolute;left:155px;top:185px;\" class=\"ore_" . $rdgens . "\"><strong>" . $rdgens . "<br />" . $rdgens_cnt . "</strong></div>";
			$ret .= "        <div class=\"icon_efficiency icon_efficiency_" . $efficiency . "\"></div>";
			if($efficiency == 0){
				$ret .= "        <div class=\"icon_attention\"></div>";
			}
			$ret .= "    </div>";
			$ret .= "</div>";
		}elseif($srq == "collectorDetails"){
			$ret = "<div class=\"collector_info collector_info_" . $req . "\"> Level: 1 - Production: " . $cdgens_cnt . "</div>";
		}elseif($srq == "upthis"){
			if($status != 2 && $level < 20)
				$ret = "<div id=\"module_infobox_" . $req . "_upgrade_large\" class=\"tabContent skylab_standard\" style=\"display: none;\"><table class=\"module_infobox_upgrade\" cellpadding=\"0\" cellspacing=\"0\"><tr><td class=\"firstRow\"><br /></td><td class=\"secondRow\">Instant</td><td class=\"thirdRow skylab_price_normal\" style=\"width:1px;\"><div style=\"position:absolute;width:1px;height:124px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_vertical.jpg?__cv=0f3388b877b7ef4dd20df64be8699800);\"></div><br /></td><td>Normal</td></tr><tr><td colspan=\"4\" style=\"height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;background-position: 65px;\"></td></tr><tr><td class=\"firstRow\">Uridium</td><td class=\"secondRow\">" .  $up_cost_uri . "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">0</td></tr><tr><td colspan=\"4\" style=\"height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;background-position: 65px;\"></td></tr><tr><td class=\"firstRow\">Credits</td><td class=\"secondRow\">" .  $up_cost_cre . "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" .  $up_cost_cre . "</td></tr><tr><td class=\"firstRow\">Time</td><td class=\"secondRow\">instant</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" . ($up_time/3600) . "h</td></tr><tr><td class=\"firstRow\">Prometium</td><td class=\"secondRow\">" .  $up_cost_raw . "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" .  $up_cost_raw . "</td></tr><tr><td class=\"firstRow\">Endurium</td><td class=\"secondRow\">" .  $up_cost_raw . "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" .  $up_cost_raw . "</td></tr><tr><td class=\"firstRow\">Terbium</td><td class=\"secondRow\">" .  $up_cost_raw . "</td><td><br /></td><td class=\"thirdRow skylab_price_normal\">" .  $up_cost_raw . "</td></tr><tr><td colspan=\"4\" style=\"height:1px;background-image: url(./do_img/global/pilotSheet/skylab/seperator_horizontal.jpg?__cv=b7a2175510ce6023a12e11870f954500);background-repeat:no-repeat;background-position: 65px;\"></td></tr><tr><td colspan=\"2\" style=\"padding:8px 3px\"><div class=\"button_standard\" style=\"float:right;\"><a style=\"display:block;\" onfocus=\"this.blur()\" onclick=\"setConfirmButtonText('confirmText', 'OK'); setCancelButtonText('cancelText', 'Cancel'); openConfirm('indexInternal.es?action=internalSkylab&amp;subaction=instantUpgrade&amp;construction=" . $req . "&amp;reloadToken=1e1064a8fdf038ee6e4c99e2beab4d29', 'Confirm upgrade?')\">Instant build</a></div></td><td colspan=\"2\" style=\"padding:8px 5px\"><div class=\"button_standard\"><a style=\"display:block\" onfocus=\"this.blur()\" href=\"indexInternal.es?action=internalSkylab&amp;subaction=upgrade&amp;construction=" . $req . "&amp;reloadToken=1e1064a8fdf038ee6e4c99e2beab4d29\">Build</a></div></td></tr></table></div>";
			elseif($level >= 20)
				$ret = "<div id=\"module_infobox_" . $req . "_upgrade_large\" class=\"tabContent skylab_standard\" style=\"\"><div class=\"upgrade_container_max\">Maximum upgrade level attained</div></div>";
			elseif($status == 2){
				$rdy = date("m-d-Y h:i a",$fts);
				$ret = "<div id=\"module_infobox_" . $req . "_upgrade_large\" class=\"tabContent skylab_standard\" style=\"\"><div class=\"upgrade_container_max\">Upgrade until: " . $rdy . "</div></div>";
			}
				
		}elseif($srq == "footer"){
			$ret = "<div id=\"module_infobox_" . $req . "_footer\" class=\"skylab_module_footer\">";
			$ret .= "<div class=\"module_info_active_state module_infobox_info\">";
			if(($module != "baseModule" && $module != "solarModule" && $module != "storageModule") && $status == 1){
				$ret .= "<img src=\"./do_img/global/pilotSheet/skylab/power_on.png?__cv=4eeda785991deb1830052b0d935d3d00\" width=\"14\" height=\"14\" onclick=\"javascript: do_redirect('indexInternal.es?action=internalSkylab&subaction=setInactive&construction=" . $req . "&reloadToken=1e1064a8fdf038ee6e4c99e2beab4d29');\" style=\"cursor: pointer\" />";
			}elseif($module == "baseModule" || $module == "solarModule" || $module == "storageModule"){
				$ret .= "<img src=\"./do_img/global/pilotSheet/skylab/power_on.png?__cv=b0a4878430feb41ac03c5a6d796fda00\" width=\"14\" height=\"14\" />";
			}elseif($level == 0){
				$ret .= "<img src=\"./do_img/global/pilotSheet/skylab/power_disabled.png?__cv=b0a4878430feb41ac03c5a6d796fda00\" width=\"14\" height=\"14\" />";
			}else{
				$ret .= "<img src=\"./do_img/global/pilotSheet/skylab/power_off.png?__cv=58f1b6a316567d6b736c56c2e314ab00\" width=\"14\" height=\"14\" onclick=\"javascript: do_redirect('indexInternal.es?action=internalSkylab&amp;subaction=setActive&amp;construction=" . $req . "&amp;reloadToken=4de85a941fcd833dd7709715da051258');\" style=\"cursor: pointer\">";
			}
			$ret .= "</div>";
			$ret .= "<div class=\"module_info_level module_infobox_info\">";
			$ret .= " <div class=\"level_icon\">" . $level . "</div>";
			$ret .= "</div>";
			if($req == "solarModule")
				$ret .= "<div class=\"module_info_power_usage module_infobox_info\">" . $prod . "</div>";
			else
				$ret .= "<div class=\"module_info_power_usage module_infobox_info\">" . $eusage . "</div>";
			if($type == "refinery"){
				$ret .= "  <div class=\"module_info_efficiency module_infobox_info\">" . $efficiency . " %</div>";
			}
			$ret .= "</div>";
		}
		return $ret;
    }

	public function getAllData()
	{
		if(isset($_SESSION['server1']['user']['sessionId'], $_SESSION['server1']['user']['email']) && is_numeric($_SESSION['server1']['user']['sessionId'])){
			//if(self::initSkylab()) {
				$Skylab['ressources']['prometium']['count'] = $this->ressources_array['prometium'];
				$Skylab['ressources']['endurium']['count'] = $this->ressources_array['endurium'];
				$Skylab['ressources']['terbium']['count'] = $this->ressources_array['terbium'];
				$Skylab['ressources']['prometid']['count'] = $this->ressources_array['prometid'];
				$Skylab['ressources']['duranium']['count'] = $this->ressources_array['duranium'];
				$Skylab['ressources']['xenomit']['count'] = $this->ressources_array['xenomit'];
				$Skylab['ressources']['promerium']['count'] = $this->ressources_array['promerium'];
				$Skylab['ressources']['seprom']['count'] = $this->ressources_array['seprom'];

				$Skylab['ressources']['prometium']['max_storage'] = self::storage('raw', $this->mod_store['level']);
				$Skylab['ressources']['endurium']['max_storage'] = self::storage('raw', $this->mod_store['level']);
				$Skylab['ressources']['terbium']['max_storage'] = self::storage('raw', $this->mod_store['level']);
				$Skylab['ressources']['prometid']['max_storage'] = self::storage('refined', $this->mod_store['level']);
				$Skylab['ressources']['duranium']['max_storage'] = self::storage('refined', $this->mod_store['level']);
				$Skylab['ressources']['xenomit']['max_storage'] = self::storage('proxeno', $this->mod_store['level']);
				$Skylab['ressources']['promerium']['max_storage'] = self::storage('proxeno', $this->mod_store['level']);
				$Skylab['ressources']['seprom']['max_storage'] = self::storage('seprom', $this->mod_store['level']);

				$Skylab['ressources']['prometium']['perc'] = number_format(100*$Skylab['ressources']['prometium']['count']/$Skylab['ressources']['prometium']['max_storage'], 0, '', '');
				$Skylab['ressources']['endurium']['perc'] = number_format(100*$Skylab['ressources']['endurium']['count']/$Skylab['ressources']['endurium']['max_storage'], 0, '', '');
				$Skylab['ressources']['terbium']['perc'] = number_format(100*$Skylab['ressources']['terbium']['count']/$Skylab['ressources']['terbium']['max_storage'], 0, '', '');
				$Skylab['ressources']['prometid']['perc'] = number_format(100*$Skylab['ressources']['prometid']['count']/$Skylab['ressources']['prometid']['max_storage'], 0, '', '');
				$Skylab['ressources']['duranium']['perc'] = number_format(100*$Skylab['ressources']['duranium']['count']/$Skylab['ressources']['duranium']['max_storage'], 0, '', '');
				$Skylab['ressources']['xenomit']['perc'] = number_format(100*$Skylab['ressources']['xenomit']['count']/$Skylab['ressources']['xenomit']['max_storage'], 0, '', '');
				$Skylab['ressources']['promerium']['perc'] = number_format(100*$Skylab['ressources']['promerium']['count']/$Skylab['ressources']['promerium']['max_storage'], 0, '', '');
				$Skylab['ressources']['seprom']['perc'] = number_format(100*$Skylab['ressources']['seprom']['count']/$Skylab['ressources']['seprom']['max_storage'], 0, '', '');
				
				
				$Skylab['modules']['mod_basic']['name'] = "Basic module";
				$Skylab['modules']['mod_basic']['progressbar'] = (int) 3*$this->mod_basic['level'];
				$Skylab['modules']['mod_basic']['level'] = $this->mod_basic['level'];
				if($this->mod_basic['level'] > 0) {
					$Skylab['modules']['mod_basic']['sd_status'] = "ACTIVE";
					$Skylab['modules']['mod_basic']['solarinfo'] = "";
				} else {
					$Skylab['modules']['mod_basic']['sd_status'] = "INACTIVE";
					$Skylab['modules']['mod_basic']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['mod_basic']['energyusage'] = self::energy_usage($this->mod_basic['level']);
				$Skylab['modules']['mod_basic']['cost_raw'] = self::upgrade_cost('basic','cost_raw',$this->mod_basic['level']);
				$Skylab['modules']['mod_basic']['cost_cre'] = self::upgrade_cost('basic','cost_cre',$this->mod_basic['level']);
				$Skylab['modules']['mod_basic']['cost_uri'] = self::upgrade_cost('basic','cost_uri',$this->mod_basic['level']);
				############################################################
				$Skylab['modules']['mod_store']['name'] = "Storage module";
				$Skylab['modules']['mod_store']['progressbar'] = (int) 3*$this->mod_store['level'];
				$Skylab['modules']['mod_store']['level'] = $this->mod_store['level'];
				if($this->mod_store['level'] > 0) {
					$Skylab['modules']['mod_store']['sd_status'] = "ACTIVE";
					$Skylab['modules']['mod_store']['solarinfo'] = "";
				} else {
					$Skylab['modules']['mod_store']['sd_status'] = "INACTIVE";
					$Skylab['modules']['mod_store']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['mod_store']['energyusage'] = self::energy_usage($this->mod_store['level']);
				$Skylab['modules']['mod_store']['cost_raw'] = self::upgrade_cost('store','cost_raw',$this->mod_store['level']);
				$Skylab['modules']['mod_store']['cost_cre'] = self::upgrade_cost('store','cost_cre',$this->mod_store['level']);
				$Skylab['modules']['mod_store']['cost_uri'] = self::upgrade_cost('store','cost_uri',$this->mod_store['level']);
				############################################################
				$Skylab['modules']['mod_solar']['name'] = "Solar module";
				$Skylab['modules']['mod_solar']['progressbar'] = (int) 3*$this->mod_solar['level'];
				$Skylab['modules']['mod_solar']['level'] = $this->mod_solar['level'];
				if($this->mod_solar['level'] > 0) {
					$Skylab['modules']['mod_solar']['sd_status'] = "ACTIVE";
				} else {
					$Skylab['modules']['mod_solar']['sd_status'] = "INACTIVE";
				}
				$Skylab['modules']['mod_solar']['energy_all_usage'] = self::energy_all_usage();
				$Skylab['modules']['mod_solar']['energy_production'] = self::energy_production($this->mod_solar['level']);
				$Skylab['modules']['mod_solar']['cost_raw'] = self::upgrade_cost('solar','cost_raw',$this->mod_solar['level']);
				$Skylab['modules']['mod_solar']['cost_cre'] = self::upgrade_cost('solar','cost_cre',$this->mod_solar['level']);
				$Skylab['modules']['mod_solar']['cost_uri'] = self::upgrade_cost('solar','cost_uri',$this->mod_solar['level']);
				############################################################
				$Skylab['modules']['collector_prometium']['name'] = "Prometium collector";
				$Skylab['modules']['collector_prometium']['progressbar'] = (int) 3*$this->collector_prometium['level'];
				$Skylab['modules']['collector_prometium']['level'] = $this->collector_prometium['level'];
				if($this->collector_prometium['level'] > 0) {
					$Skylab['modules']['collector_prometium']['sd_status'] = "ACTIVE";
					$Skylab['modules']['collector_prometium']['solarinfo'] = "";
				} else {
					$Skylab['modules']['collector_prometium']['sd_status'] = "INACTIVE";
					$Skylab['modules']['collector_prometium']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['collector_prometium']['energyusage'] = self::energy_usage($this->collector_prometium['level']);
				$Skylab['modules']['collector_prometium']['cost_raw'] = self::upgrade_cost('collectors','cost_raw',$this->collector_prometium['level']);
				$Skylab['modules']['collector_prometium']['cost_cre'] = self::upgrade_cost('collectors','cost_cre',$this->collector_prometium['level']);
				$Skylab['modules']['collector_prometium']['cost_uri'] = self::upgrade_cost('collectors','cost_uri',$this->collector_prometium['level']);
				############################################################
				$Skylab['modules']['collector_endurium']['name'] = "Endurium collector";
				$Skylab['modules']['collector_endurium']['progressbar'] = (int) 3*$this->collector_endurium['level'];
				$Skylab['modules']['collector_endurium']['level'] = $this->collector_endurium['level'];
				if($this->collector_endurium['level'] > 0) {
					$Skylab['modules']['collector_endurium']['sd_status'] = "ACTIVE";
					$Skylab['modules']['collector_endurium']['solarinfo'] = "";
				} else {
					$Skylab['modules']['collector_endurium']['sd_status'] = "INACTIVE";
					$Skylab['modules']['collector_endurium']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['collector_endurium']['energyusage'] = self::energy_usage($this->collector_endurium['level']);
				$Skylab['modules']['collector_endurium']['cost_raw'] = self::upgrade_cost('collectors','cost_raw',$this->collector_endurium['level']);
				$Skylab['modules']['collector_endurium']['cost_cre'] = self::upgrade_cost('collectors','cost_cre',$this->collector_endurium['level']);
				$Skylab['modules']['collector_endurium']['cost_uri'] = self::upgrade_cost('collectors','cost_uri',$this->collector_endurium['level']);
				############################################################
				$Skylab['modules']['collector_terbium']['name'] = "Terbium collector";
				$Skylab['modules']['collector_terbium']['progressbar'] = (int) 3*$this->collector_terbium['level'];
				$Skylab['modules']['collector_terbium']['level'] = $this->collector_terbium['level'];
				if($this->collector_terbium['level'] > 0) {
					$Skylab['modules']['collector_terbium']['sd_status'] = "ACTIVE";
					$Skylab['modules']['collector_terbium']['solarinfo'] = "";
				} else {
					$Skylab['modules']['collector_terbium']['sd_status'] = "INACTIVE";
					$Skylab['modules']['collector_terbium']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['collector_terbium']['energyusage'] = self::energy_usage($this->collector_terbium['level']);
				$Skylab['modules']['collector_terbium']['cost_raw'] = self::upgrade_cost('collectors','cost_raw',$this->collector_terbium['level']);
				$Skylab['modules']['collector_terbium']['cost_cre'] = self::upgrade_cost('collectors','cost_cre',$this->collector_terbium['level']);
				$Skylab['modules']['collector_terbium']['cost_uri'] = self::upgrade_cost('collectors','cost_uri',$this->collector_terbium['level']);
				############################################################
				$Skylab['modules']['refine_prometid']['name'] = "Prometid refinery";
				$Skylab['modules']['refine_prometid']['progressbar'] = (int) 3*$this->refine_prometid['level'];
				$Skylab['modules']['refine_prometid']['level'] = $this->refine_prometid['level'];
				if($this->refine_prometid['level'] > 0) {
					$Skylab['modules']['refine_prometid']['sd_status'] = "ACTIVE";
					$Skylab['modules']['refine_prometid']['solarinfo'] = "";
				} else {
					$Skylab['modules']['refine_prometid']['sd_status'] = "INACTIVE";
					$Skylab['modules']['refine_prometid']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['refine_prometid']['energyusage'] = self::energy_usage($this->refine_prometid['level']);
				$Skylab['modules']['refine_prometid']['cost_raw'] = self::upgrade_cost('refine','cost_raw',$this->refine_prometid['level']);
				$Skylab['modules']['refine_prometid']['cost_cre'] = self::upgrade_cost('refine','cost_cre',$this->refine_prometid['level']);
				$Skylab['modules']['refine_prometid']['cost_uri'] = self::upgrade_cost('refine','cost_uri',$this->refine_prometid['level']);
				############################################################
				$Skylab['modules']['refine_duranium']['name'] = "Duranium refinery";
				$Skylab['modules']['refine_duranium']['progressbar'] = (int) 3*$this->refine_duranium['level'];
				$Skylab['modules']['refine_duranium']['level'] = $this->refine_duranium['level'];
				if($this->refine_duranium['level'] > 0) {
					$Skylab['modules']['refine_duranium']['sd_status'] = "ACTIVE";
					$Skylab['modules']['refine_duranium']['solarinfo'] = "";
				} else {
					$Skylab['modules']['refine_duranium']['sd_status'] = "INACTIVE";
					$Skylab['modules']['refine_duranium']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['refine_duranium']['energyusage'] = self::energy_usage($this->refine_duranium['level']);
				$Skylab['modules']['refine_duranium']['cost_raw'] = self::upgrade_cost('refine','cost_raw',$this->refine_duranium['level']);
				$Skylab['modules']['refine_duranium']['cost_cre'] = self::upgrade_cost('refine','cost_cre',$this->refine_duranium['level']);
				$Skylab['modules']['refine_duranium']['cost_uri'] = self::upgrade_cost('refine','cost_uri',$this->refine_duranium['level']);
				############################################################
				$Skylab['modules']['refine_promerium']['name'] = "Promerium refinery";
				$Skylab['modules']['refine_promerium']['progressbar'] = (int) 3*$this->refine_promerium['level'];
				$Skylab['modules']['refine_promerium']['level'] = $this->refine_promerium['level'];
				if($this->refine_promerium['level'] > 0) {
					$Skylab['modules']['refine_promerium']['sd_status'] = "ACTIVE";
					$Skylab['modules']['refine_promerium']['solarinfo'] = "";
				} else {
					$Skylab['modules']['refine_promerium']['sd_status'] = "INACTIVE";
					$Skylab['modules']['refine_promerium']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['refine_promerium']['energyusage'] = self::energy_usage($this->refine_promerium['level']);
				$Skylab['modules']['refine_promerium']['cost_raw'] = self::upgrade_cost('refine','cost_raw',$this->refine_promerium['level']);
				$Skylab['modules']['refine_promerium']['cost_cre'] = self::upgrade_cost('refine','cost_cre',$this->refine_promerium['level']);
				$Skylab['modules']['refine_promerium']['cost_uri'] = self::upgrade_cost('refine','cost_uri',$this->refine_promerium['level']);
				############################################################
				$Skylab['modules']['refine_seprom']['name'] = "Seprom refinery";
				$Skylab['modules']['refine_seprom']['progressbar'] = (int) 3*$this->refine_seprom['level'];
				$Skylab['modules']['refine_seprom']['level'] = $this->refine_seprom['level'];
				if($this->refine_seprom['level'] > 0) {
					$Skylab['modules']['refine_seprom']['sd_status'] = "ACTIVE";
					$Skylab['modules']['refine_seprom']['solarinfo'] = "";
				} else {
					$Skylab['modules']['refine_seprom']['sd_status'] = "INACTIVE";
					$Skylab['modules']['refine_seprom']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['refine_seprom']['energyusage'] = self::energy_usage($this->refine_seprom['level']);
				$Skylab['modules']['refine_seprom']['cost_raw'] = self::upgrade_cost('refine_sep','cost_raw',$this->refine_seprom['level']);
				$Skylab['modules']['refine_seprom']['cost_cre'] = self::upgrade_cost('refine_sep','cost_cre',$this->refine_seprom['level']);
				$Skylab['modules']['refine_seprom']['cost_uri'] = self::upgrade_cost('refine_sep','cost_uri',$this->refine_seprom['level']);
				############################################################
				$Skylab['modules']['generator_xeno']['name'] = "Xeno module";
				$Skylab['modules']['generator_xeno']['progressbar'] = (int) 3*$this->generator_xeno['level'];
				$Skylab['modules']['generator_xeno']['level'] = $this->generator_xeno['level'];
				if($this->generator_xeno['level'] > 0) {
					$Skylab['modules']['generator_xeno']['sd_status'] = "ACTIVE";
					$Skylab['modules']['generator_xeno']['solarinfo'] = "";
				} else {
					$Skylab['modules']['generator_xeno']['sd_status'] = "INACTIVE";
					$Skylab['modules']['generator_xeno']['solarinfo'] = "inactive";
				}
				$Skylab['modules']['generator_xeno']['energyusage'] = self::energy_usage($this->generator_xeno['level']);
				$Skylab['modules']['generator_xeno']['cost_raw'] = self::upgrade_cost('generator','cost_raw',$this->generator_xeno['level']);
				$Skylab['modules']['generator_xeno']['cost_cre'] = self::upgrade_cost('generator','cost_cre',$this->generator_xeno['level']);
				$Skylab['modules']['generator_xeno']['cost_uri'] = self::upgrade_cost('generator','cost_uri',$this->generator_xeno['level']);
				
				
				$this->site_data = $Skylab;
			//}
		}
	}

	private function energy_production($level)
	{
		$energy = array (	"0",
							"270",
							"310",
							"370",
							"450",
							"550",
							"670",
							"810",
							"970",
							"1150",
							"1350",
							"1570",
							"1810",
							"2070",
							"2350",
							"2650",
							"2970",
							"3310",
							"3670",
							"4050",
							"4450"
							);
		return $energy[$level];
	}

	private function ressource_generation($type,$level)
	{
		$gen = array (	
					"raw" => array ( "0",
										"2200",//1
										"7400",
										"15045",
										"24890",
										"36782",
										"50604",
										"66274",
										"83720",
										"102884",
										"123715",//10
										"146171",
										"170212",
										"195805",
										"222919",
										"251526",
										"281600",
										"313118",
										"346059",
										"380401",
										"416216"),
										
					"refined" => array( "0",
										"110",//1
										"370",
										"752",
										"1245",
										"1839",
										"2530",
										"3314",
										"4186",
										"5144",
										"6186",//10
										"7309",
										"8511",
										"9790",
										"11146",
										"12013",
										"14080",
										"15656",
										"17303",
										"19020",
										"20806"),
					"proxeno" => array( "0",
										"11",//1
										"37",
										"75",
										"124",
										"184",
										"253",
										"331",
										"419",
										"514",
										"619",//10
										"731",
										"851",
										"979",
										"1115",
										"1258",
										"1408",
										"1566",
										"1730",
										"1902",
										"2081"),//20
					"seprom" => array( "0", //0
										"1",
										"3",
										"7",
										"11",
										"17",
										"23",
										"30",
										"38",
										"47",
										"56", //10
										"66",
										"77",
										"89",
										"101",
										"114",
										"128",
										"142",
										"157",
										"173",
										"189"), //20
						);
		return $gen[$type][$level];
	}
	
	private function energy_usage($level)
	{
		$energy = array (	"0",
							"16",
							"19",
							"24",
							"31",
							"40",
							"51",
							"64",
							"79",
							"96",
							"115",
							"136",
							"159",
							"184",
							"211",
							"240",
							"271",
							"304",
							"339",
							"376",
							"415"
							);
		return $energy[$level];
	}

	private function energy_all_usage()
	{
		$v01 = self::energy_usage($this->mod_basic['level']);
		$v02 = self::energy_usage($this->mod_store['level']);
		$v03 = ($this->collector_prometium['status'] == 1) ? self::energy_usage($this->collector_prometium['level']) : 0;
		$v04 = ($this->collector_endurium['status'] == 1) ? self::energy_usage($this->collector_endurium['level']) : 0;
		$v05 = ($this->collector_terbium['status'] == 1) ? self::energy_usage($this->collector_terbium['level']) : 0;
		$v06 = ($this->refine_prometid['status'] == 1) ? self::energy_usage($this->refine_prometid['level']) : 0;
		$v07 = ($this->refine_duranium['status'] == 1) ? self::energy_usage($this->refine_duranium['level']) : 0;
		$v08 = ($this->refine_promerium['status'] == 1) ? self::energy_usage($this->refine_promerium['level']) : 0;
		$v09 = ($this->refine_seprom['status'] == 1) ? self::energy_usage($this->refine_seprom['level']) : 0;
		$v10 = ($this->generator_xeno['status'] == 1) ? self::energy_usage($this->generator_xeno['level']) : 0;
		$energy = $v01+$v02+$v03+$v04+$v05+$v06+$v07+$v08+$v09+$v10;
		return $energy+16;  // +16 for transport module
	}

	private function storage($type,$level)
	{
		$storage = array(
					"raw" => array ( "0",
										"105600",
										"355195",
										"722148",
										"1194728",
										"1765474",
										"2429006",
										"3181160",
										"4018569",
										"4938423",
										"5938324",
										"7016186",
										"8170170",
										"9398635",
										"10700104",
										"12073234",
										"13516800",
										"15029673",
										"16610810",
										"18259241",
										"19974063"),
					"refined" => array( "0",
										"5280",
										"17760",
										"36107",
										"59736",
										"88274",
										"121450",
										"159058",
										"200928",
										"246921",
										"296916",
										"350809",
										"408509",
										"469932",
										"535005",
										"603662",
										"675840",
										"751484",
										"830540",
										"912962",
										"998703"),
					"proxeno" => array( "0",
										" 528",
										"1776",
										"3611",
										"5974",
										"8827",
										"12145",
										"15906",
										"20093",
										"24692",
										"29692",
										"35081",
										"40851",
										"46993",
										"53501",
										"60366",
										"67584",
										"75148",
										"83054",
										"91296",
										"99870"),
					"seprom" => array( "0",
										"48",
										"161",
										"328",
										"543",
										"802",
										"1104",
										"1446",
										"1827",
										"2245",
										"2699",
										"3189",
										"3714",
										"4272",
										"4864",
										"5488",
										"6144",
										"6832",
										"7550",
										"8300",
										"9079"),
						);
		return $storage[$type][$level];
	}

	/*
		// switched to easier system to handle this
		// priority: rework
	private function pretty_time($tins)
	{
		return floor($sec/60)."min:".($sec%60)."secs";
	}*/

	private function upgrade_time($type,$level)
	{
		//t in s econds
		$tinsarr = array(
					"basic" => array(	"0", //0
										"3600",
										"14400",
										"28800",
										"43200",
										"57600",
										"72000",
										"86400",
										"100800",
										"115200",
										"129600",//10
										"144000",
										"158400",
										"172800",
										"187200",
										"201600",
										"216000",
										"230400",
										"244800",
										"259200",
										"273600"),//20
					"collectors" => array(	"0",
										"3600",
										"14400",
										"28800",
										"43200",
										"57600",
										"72000",
										"86400",
										"100800",
										"115200",
										"129600",
										"144000",
										"158400",
										"172800",
										"187200",
										"201600",
										"216000",
										"230400",
										"244800",
										"259200",
										"273600"),
					"refine" => array(	"0",
										"3600",
										"18000",
										"36000",
										"54000",
										"72000",
										"90000",
										"108000",
										"126000",
										"144000",
										"180000",
										"198000",
										"216000",
										"234000",
										"252000",
										"270000",
										"288000",
										"306000",
										"324000",
										"342000",
										"360000"),
					"seprom" => array(	"0",
										"3600",
										"21600",
										"43200",
										"64800",
										"86400",
										"108000",
										"129600",
										"151200",
										"172800",
										"194400",
										"216000",
										"237600",
										"259200",
										"280800",
										"302400",
										"324000",
										"345600",
										"367200",
										"388800",
										"410400"),
						);
		return $tinsarr[$type][$level];
	}

	private function upgrade_cost($type,$costtype,$level)
	{
		$cost = array(
					"basic" => array( "cost_raw" => array ( "0",
															"707",
															"2923",
															"8000",
															"17469",
															"33068",
															"56718",
															"90510",
															"136688",
															"197642",
															"275902",
															"374123",
															"495087",
															"641694",
															"816957",
															"1024000",
															"1266051",
															"1546443",
															"1868605",
															"2236068",
															"3236068"),
									  "cost_cre" => array ( "0",
															"16352",
															"27144",
															"38891",
															"51403",
															"64560",
															"78279",
															"92499",
															"107171",
															"122257",
															"137725",
															"153550",
															"169708",
															"186180",
															"202949",
															"220000",
															"237320",
															"254896",
															"272719",
															"290777",
															"300000"),
									  "cost_uri" => array ( "0",
															"1487",
															"2468",
															"3536",
															"4673",
															"5869",
															"7116",
															"8409",
															"9743",
															"11114",
															"12520",
															"13959",
															"15428",
															"16925",
															"18450",
															"20000",
															"21575",
															"23172",
															"24793",
															"26434",
															"30000"),
									),
					"store" => array( "cost_raw" => array ( "0",
															"707",
															"2923",
															"8000",
															"17469",
															"33068",
															"56718",
															"90510",
															"136688",
															"197642",
															"275902",
															"374123",
															"495087",
															"641694",
															"816957",
															"1024000",
															"1266051",
															"1546443",
															"1868605",
															"2236068",
															"3000000"),
									  "cost_cre" => array ( "0",
															"16352",
															"27144",
															"38891",
															"51403",
															"64560",
															"78279",
															"92499",
															"107171",
															"122257",
															"137725",
															"153550",
															"169708",
															"186180",
															"202949",
															"220000",
															"237320",
															"254896",
															"272719",
															"290777",
															"300000"),
									  "cost_uri" => array ( "0",
															"1487",
															"2468",
															"3536",
															"4673",
															"5869",
															"7116",
															"8409",
															"9743",
															"11114",
															"12520",
															"13959",
															"15428",
															"16925",
															"18450",
															"20000",
															"21575",
															"23172",
															"24793",
															"26434",
															"30000"),
									),
					"solar" => array( "cost_raw" => array ( "0",
															"707",
															"2923",
															"8000",
															"17469",
															"33068",
															"56718",
															"90510",
															"136688",
															"197642",
															"275902",
															"374123",
															"495087",
															"641694",
															"816957",
															"1024000",
															"1266051",
															"1546443",
															"1868605",
															"2236068",
															"2400000"),
									  "cost_cre" => array ( "0",
															"16352",
															"27144",
															"38891",
															"51403",
															"64560",
															"78279",
															"92499",
															"107171",
															"122257",
															"137725",
															"153550",
															"169708",
															"186180",
															"202949",
															"220000",
															"237320",
															"254896",
															"272719",
															"290777",
															"300000"),
									  "cost_uri" => array ( "0",
															"1487",
															"2468",
															"3536",
															"4673",
															"5869",
															"7116",
															"8409",
															"9743",
															"11114",
															"12520",
															"13959",
															"15428",
															"16925",
															"18450",
															"20000",
															"21575",
															"23172",
															"24793",
															"26434",
															"30000"),
									),
					"collectors" => array( "cost_raw" => array ( "0",
																"50",
																"566",
																"2338",
																"6400",
																"13975",
																"26454",
																"45375",
																"72408",
																"109350",
																"158114",
																"220721",
																"299298",
																"396070",
																"513355",
																"653566",
																"819200",
																"1012841",
																"1237154",
																"1494884",
																"1788854"),
										  "cost_cre" => array ( "0",
																"5500",
																"13081",
																"21715",
																"31113",
																"41122",
																"51648",
																"62623",
																"73999",
																"85737",
																"97805",
																"110180",
																"122840",
																"135766",
																"148944",
																"162359",
																"176000",
																"189856",
																"203917",
																"218175",
																"232622"),
										  "cost_uri" => array ( "0",
																"500",
																"1189",
																"1974",
																"2828",
																"3738",
																"4695",
																"5693",
																"6727",
																"7794",
																"8891",
																"10016",
																"11167",
																"12342",
																"13540",
																"14760",
																"16000",
																"17260",
																"18538",
																"19834",
																"21147"),
									),
					"refine" => array( "cost_raw" => array ( "0",
															"75",
															"849",
															"3507",
															"9600",
															"20963",
															"39682",
															"68062",
															"108612",
															"164025",
															"237171",
															"331082",
															"448948",
															"594205",
															"770033",
															"980349",
															"1228800",
															"1519261",
															"1855731",
															"2242327",
															"2683282"),
										"cost_cre" => array( "0",
															"8250",
															"19622",
															"32573",
															"46669",
															"61683",
															"77472",
															"93935",
															"110998",
															"128605",
															"146708",
															"165270",
															"184260",
															"203649",
															"223416",
															"243539",
															"264000",
															"284784",
															"305875",
															"327262",
															"348933"),
										"cost_uri" => array( "0",
															"750",
															"1784",
															"2961",
															"4243",
															"5608",
															"7043",
															"8540",
															"10091",
															"11691",
															"13337",
															"15025",
															"16751",
															"18514",
															"20311",
															"22140",
															"24000",
															"25889",
															"27807",
															"29751",
															"31721"),
									),
					"refine_sep" => array( "cost_raw" => array ( "0",
																"250",
																"2828",
																"11691",
																"32000",
																"69877",
																"132271",
																"226873",
																"362039",
																"546750",
																"790569",
																"1103607",
																"1496492",
																"1980349",
																"2566777",
																"3267830",
																"4096000",
																"5064204",
																"6185770",
																"7474422",
																"8944272"),
											"cost_cre" => array( "0",
																"27500",
																"65406",
																"108576",
																"155563",
																"205610",
																"258239",
																"313116",
																"369994",
																"428683",
																"489027",
																"550901",
																"614199",
																"678831",
																"744720",
																"811796",
																"880000",
																"949279",
																"1019585",
																"1090874",
																"1163108"),
											"cost_uri" => array( "0",
																"2500",
																"5946",
																"9871",
																"14142",
																"18692",
																"23476",
																"28465",
																"33636",
																"38971",
																"44457",
																"50082",
																"55836",
																"61712",
																"67702",
																"73800",
																"80000",
																"86298",
																"92690",
																"99170",
																"105737"),
									),
					"generator" => array( "cost_raw" => array ( "0",
															"75",
															"849",
															"3507",
															"9600",
															"20963",
															"39682",
															"68062",
															"108612",
															"164025",
															"237171",
															"331082",
															"448948",
															"594205",
															"770033",
															"980349",
															"1228800",
															"1519261",
															"1855731",
															"2242327",
															"2683282"),
										"cost_cre" => array( "0",
															"8250",
															"19622",
															"32573",
															"46669",
															"61683",
															"77472",
															"93935",
															"110998",
															"128605",
															"146708",
															"165270",
															"184260",
															"203649",
															"223416",
															"243539",
															"264000",
															"284784",
															"305875",
															"327262",
															"348933"),
										"cost_uri" => array( "0",
															"750",
															"1784",
															"2961",
															"4243",
															"5608",
															"7043",
															"8540",
															"10091",
															"11691",
															"13337",
															"15025",
															"16751",
															"18514",
															"20311",
															"22140",
															"24000",
															"25889",
															"27807",
															"29751",
															"31721"),
									),
);
		return $cost[$type][$costtype][$level];
	}
}
?>