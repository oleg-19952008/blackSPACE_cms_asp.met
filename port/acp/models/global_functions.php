<?php
	// Standard Functions
	function esc($db, $wert){
		return mysqli_real_escape_string($db, $wert);
	}
	function ex($wert){
		return explode("|", $wert);
	}
	function sqltodate($wert) {
		return date("d.m.Y, H:i",$wert);
	}
	function datetosql($wert) {
		return date("Y-m-d H:i:s",strtotime($wert));
	}
	function dateeng($wert) {
		return date("M d, Y - H:i",$wert);
	}
	function dot3($wert) {
		return number_format($wert,0, ",", ".");
	}
	
	function generateRandom($length, $numbers = true, $letters = true, $otherChars = ''){
		$chars = '';
		$chars .= ($numbers) ? '0123456789' : '';
		$chars .= ($letters) ? 'QWERTYUIOPASDFGHJKLLZXCVBNMqwertyuiopasdfghjklzxcvbnm' : '';
		$chars .= $otherChars;

		$str = '';
		$c = 0;
	while ($c < $length){ 
	   $str .= substr($chars, rand(0, strlen($chars) -1), 1);
	   $c++;
	}
	  
		return $str;
	}
	
	function get_client_ip() {
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
	

	function decrypt($ciphertext) {
            $ciphertext = base64_decode($ciphertext);
            $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
            if (strlen($ciphertext) < $ivSize) {
                throw new Exception('Missing initialization vector');
            }

            $iv = substr($ciphertext, 0, $ivSize);
            $ciphertext = substr($ciphertext, $ivSize);
            $plaintext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, '5eqD0fpzf9JzaKWP', $ciphertext, MCRYPT_MODE_ECB, $iv);
            return rtrim($plaintext, "\0");
    }
//Arrays
$maptoname = array(
	"1" => "1|1-1",
	"2" => "1|1-2",
	"3" => "1|1-3",
	"4" => "1|1-4",
	"17" => "1|1-5",
	"18" => "1|1-6",
	"19" => "1|1-7",
	"20" => "1|1-8",
	"5" => "2|2-1",
	"6" => "2|2-2",
	"7" => "2|2-3",
	"8" => "2|2-4",
	"21" => "2|2-5",
	"22" => "2|2-6",
	"23" => "2|2-7",
	"24" => "2|2-8",
	"9" => "3|3-1",
	"10" => "3|3-2",
	"11" => "3|3-3",
	"12" => "3|3-4",
	"25" => "3|3-5",
	"26" => "3|3-6",
	"27" => "3|3-7",
	"28" => "3|3-8",
	"13" => "1|4-1",
	"14" => "2|4-2",
	"15" => "3|4-3",
	"16" => "4|4-4",
	"29" => "4|4-5",
	"91" => "4|5-1",
	"92" => "4|5-2",
	"93" => "4|5-3"
);

$rankname = array(
	"0" => "Unranked",
	"1" => "Basic Space Pilot",
	"2" => "Space Pilot",
	"3" => "Chief Space Pilot",
	"4" => "Basic Sergeant",
	"5" => "Sergeant",
	"6" => "Chief Sergeant",
	"7" => "Basic Lieutenant",
	"8" => "Lieutenant",
	"9" => "Chief Lieutenant",
	"10" => "Basic Captain",
	"11" => "Captain",
	"12" => "Chief Captain",
	"13" => "Basic Major",
	"14" => "Major",
	"15" => "Chief Major",
	"16" => "Basic Colonel",
	"17" => "Colonel",
	"18" => "Chief Colonel",
	"19" => "Basic General",
	"20" => "General",
	"21" => "Administrator",
	"99" => "Administrator"
);

$staffrank = array(
	"0" => "Trial",
	"1" => "Moderator",
	"2" => "Senior Moderator",
	"3" => "Staff Admin",
	"4" => "Developer",
	"5" => "Manager",
	"6" => "Owner"
);

$add = array (
	"1" => "Credits",
	"2" => "Uridium",
	"3" => "Honor"
);

$items_array = array (
	"ship_goliath_design_crimson" => "Crimson",
	"ship_goliath_design_exalted" => "Exalted",
	"ship_goliath_design_veteran" => "Veteran",
	"ship_goliath_design_enforcer" => "Enforcer",
	"ship_goliath_design_bastion" => "Bastion",
	"ship_goliath_design_sentinel" => "Sentinel",
	"ship_goliath" => "Goliath",
	"drone_iris" => "Iris Drone",
	"ship_nostromo" => "Nostromo",
	"ship_spearhead" => "Spearhead",
	"equipment_weapon_laser_mp-1" => "MP-1",
	"ammunition_laser_lcb-10" => "LCB-10",
	"resource_booty-key" => "Booty Key",
	"ammunition_laser_mcb-25" => "MCB-25",
	"ammunition_rocket_plt-2026" => "PLT-2026",
	"equipment_weapon_laser_lf-2" => "LF-2",
	"equipment_generator_shield_sg3n-b01" => "SG3N-B01",
	"equipment_extra_cpu_nc-rrb-x" => "Repair-Bot Auto CPU",
	"ammunition_laser_mcb-50" => "MCB-50",
	"ammunition_rocket_plt-2021" => "PLT-2021",
	"equipment_generator_speed_g3n-7900" => "G3N-7900",
	"equipment_weapon_laser_lf-3" => "LF-3",
	"resource_ore_xenomit" => "Xenomit",
	"ammunition_laser_sab-50" => "SAB-50",
	"ammunition_mine_acm-01" => "ACM 1",
	"ammunition_laser_ucb-100" => "UCB-100",
	"equipment_generator_shield_sg3n-a03" => "SG3N-A03",
	"equipment_generator_shield_sg3n-b02" => "SG3N-B02",
	"equipment_extra_cpu_alb-x" => "Ammunition Buy CPU 1",
	"ammunition_firework_fwx-m" => "Fireworks 09M",
	"ammunition_mine_slm-01" => "SL-M01",
	"ammunition_rocketlauncher_eco-10" => "ECO-10",
	"ammunition_firework_fwx-s" => "Fireworks 09S",
	"ammunition_rocketlauncher_sar-02" => "SAR-02",
	"ammunition_firework_fwx-l" => "Fireworks 09L",
	"ammunition_specialammo_pld-8" => "PLD-8",
	"equipment_extra_cpu_sle-04" => "Slot CPU 4",
	"equipment_extra_cpu_rok-t01" => "Rocket Turbo 1",
	"equipment_extra_cpu_arol-x" => "Auto-Rocket CPU 1",
	"ammunition_rocket_plt-3030" => "PLT-3030",
	"equipment_extra_repbot_rep-4" => "Repair Robot 4",
	"equipment_extra_cpu_ish-01" => "Instashield CPU 1",
	"equipment_extra_cpu_ajp-01" => "Advanced Jump CPU 1",
	"equipment_extra_cpu_g3x-crgo-x" => "Cargo Compressor",
	"equipment_weapon_rocketlauncher_hst-2" => "HST-2",
	"equipment_extra_cpu_jp-02" => "Jump CPU 2",
	"equipment_extra_cpu_rllb-x" => "Rocket-launcher CPU",
	"equipment_extra_cpu_rb-x" => "Rocket-Buy CPU 1",
	"ammunition_rocket_r-310" => "R-310",
	"equipment_petgear_g-rep1" => "G-REP1",
	"equipment_petgear_g-al1" => "G-AL1",
	"equipment_petgear_g-tra1" => "G-TRA1",
	"equipment_aiprotocol_ai-r1" => "AI-R1",
	"module_ltm-mr" => "Laser Turret Module - Mid Range",
	"resource_blueprint_apis-part" => "Blueprint - Apis Part",
	"ammunition_mine_ddm-01" => "DD-M01",
	"drone_designs_havoc" => "Havoc",
	"ammunition_laser_rsb-75" => "RSB-75",
	"module_ram-ma" => "Rocket Array Module - Mid Accuracy",
	"ammunition_mine_empm-01" => "EMP-M01",
	"ammunition_rocketlauncher_hstrm-01" => "HSTRM-01",
	"equipment_extra_cpu_g3x-amry-m" => "Armory Upgrade 2",
	"equipment_petgear_g-kk1" => "G-KK1",
	"drone_designs_hercules" => "Hercules",
	"module_ram-la" => "Rocket Array Module - Low Accuracy",
	"drone_formation_f-01-tu" => "F-01-TU",
	"drone_formation_f-02-ar" => "F-02-AR",
	"equipment_petgear_g-ar1" => "G-AR1",
	"equipment_weapon_laser_lf-4" => "LF-4",
	"ammunition_mine_sabm-01" => "SAB-M01",
	"equipment_extra_cpu_cl04k-m" => "Cloak CPU 1",
	"ammunition_specialammo_wiz-x" => "Wizard",
	"ammunition_rocketlauncher_ubr-100" => "UBR-100",
	"module_ltm-hr" => "Laser Turret Module - High Range",
	"drone_formation_f-07-di" => "F-07-DI",
	"equipment_extra_cpu_cl04k-xl" => "Cloak CPU XL",
	"module_xpm-1" => "Experience Booster Module",
	"module_ltm-lr" => "Laser Turret Module - Low Range",
	"pet_pet10" => "P.E.T.10",
	"ship_vengeance_design_revenge" => "Revenge",
	"ship_vengeance_design_avenger" => "Avenger",
	"ship_vengeance_design_adept" => "Adept",
	"ship_vengeance_design_corsair" => "Corsair",
	"ship_vengeance" => "Vengeance",
	"resource_ore_seprom" => "Seprom",
	"equipment_extra_cpu_g3x-amry-l" => "Armory Upgrade 3",
	"equipment_extra_cpu_rd-x" => "Radar CPU",
	"equipment_extra_cpu_dr-02" => "Drone repair CPU 2",
	"resource_ore_palladium" => "Palladium",
	"equipment_extra_cpu_nc-agb-x" => "Generator Update CPU 1",
	"equipment_extra_cpu_nc-awb-x" => "Laboratory CPU 1",
	"equipment_extra_cpu_min-t02" => "Mines-Turbo CPU 2",
	"drone_formation_f-11-he" => "F-11-HE",
	"equipment_extra_cpu_smb-01" => "Smartbomb CPU 1",
	"drone_flax" => "Flax Drone",
	"equipment_generator_shield_sg3n-a01" => "SG3N-A01",
	"equipment_extra_repbot_rep-s" => "Repair Robot Basic",
	"resource_ore_prometium" => "Prometium",
	"resource_ore_endurium" => "Endurium",
	"resource_ore_terbium" => "Terbium",
	"resource_ore_promerium" => "Promerium",
	"resource_ore_prometid" => "Prometid",
	"resource_ore_duranium" => "Duranium",
	"ship_phoenix" => "Phoenix",
	"ship_spearhead_design_spearhead-superelite" => "Spearhead Elite",
	"equipment_weapon_laser_lf-1" => "LF-1",
	"equipment_weapon_rocketlauncher_hst-1" => "HST-1",
	"equipment_generator_speed_g3n-1010" => "G3N-1010",
	"equipment_generator_speed_g3n-2010" => "G3N-2010",
	"equipment_generator_speed_g3n-3210" => "G3N-3210",
	"equipment_generator_speed_g3n-3310" => "G3N-3310",
	"equipment_generator_speed_g3n-6900" => "G3N-6900",
	"equipment_generator_shield_sg3n-a02" => "SG3N-A02",
	"equipment_extra_repbot_rep-1" => "Repair Robot 1",
	"equipment_extra_repbot_rep-2" => "Repair Robot 2",
	"equipment_extra_cpu_nc-awr-x" => "Laboratory CPU 2",
	"equipment_extra_cpu_nc-awl-x" => "Laboratory CPU 3",
	"equipment_extra_cpu_sle-02" => "Slot CPU 2",
	"equipment_extra_cpu_sle-03" => "Slot CPU 3",
	"equipment_extra_cpu_aim-02" => "Targeting guidance CPU 2",
	"equipment_extra_cpu_cl04k-xs" => "Cloak Module Typ A",
	"equipment_extra_repbot_rep-3" => "Repair Robot 3",
	"ship_goliath_design_saturn" => "Saturn",
	"ship_police" => "Police",
	"ammunition_rocketlauncher_sar-01" => "SAR-01",
	"ship_goliath_design_amber" => "Amber",
	"ship_goliath_design_sapphire" => "Sapphire",
	"ammunition_specialammo_emp-01" => "EMP-01",
	"ammunition_rocketlauncher_cbr" => "CBR",
	"ammunition_laser_cbo-100" => "CBO-100",
	"ship_goliath_design_venom" => "Venom",
	"ship_goliath_design_solace" => "Solace",
	"ship_goliath_design_spectrum" => "Spectrum",
	"ship_goliath_design_kick" => "Kick",
	"ship_goliath_design_referee" => "Referee",
	"ship_goliath_design_goal" => "Goal",
	"ship_goliath_design_diminisher" => "Diminisher",
	"ship_goliath_design_jade" => "Jade",
	"ship_goliath_design_sovereign" => "Sovereign",
	"ship_goliath_design_goliath-razer" => "Razer-Goliath",
	"drone_apis" => "Apis Drone",
	"drone_zeus" => "Zeus Drone",
	"ship_aegis" => "Aegis",
	"ship_aegis_design_aegis-superelite" => "Aegis Elite",
	"ship_citadel" => "Citadel",
	"drone_formation_f-10-cr" => "F-10-CR",
	"ammunition_specialammo_dcr-250" => "DCR-250",
	"resource_blueprint_zeus-part" => "Blueprint - Zeus Part",
	"equipment_petgear_g-rl1" => "G-RL1",
	"equipment_petgear_g-el1" => "G-EL1",
	"equipment_extra_cpu_fb-x" => "Fuel-Buy Assistant",
	"drone_formation_f-09-mo" => "F-09-MO",
	"drone_formation_f-06-da" => "F-06-DA",
	"module_hulm-1" => "Hull Module",
	"equipment_petgear_csr-02" => "CSR-02",
	"module_dmgm-1" => "Damage Booster Module",
	"module_honm-1" => "Honor Booster Module",
	"drone_formation_f-05-pi" => "F-05-PI",
	"ammunition_laser_job-100" => "JOB-100",
	"equipment_aiprotocol_ai-lm1" => "AI-LM1",
	"module_repm-1" => "Repair Module",
	"drone_formation_f-08-ch" => "F-08-CH",
	"ammunition_firework_fwx-rz" => "Fireworks Razer",
	"ship_leonov" => "Leonov",
	"ship_piranha" => "Piranha",
	"equipment_extra_cpu_g3x-amry-s" => "Armory Upgrade 1",
	"resource_logfile" => "Logfile",
	"ship_vengeance_design_lightning" => "Lightning",
	"ship_Liberator" => "Liberator",
	"ship_bigboy" => "Bigboy",
	"equipment_extra_cpu_jp-01" => "Jump CPU 1"
);

$npc_array = array(
	"21" => "Ufonit",
	"112" => "Baracude",
	"111" => "interceptor"
);
//global variables

$denied = '<div class="alert-box error"><span>error: </span>Not enough rights</div>';
?>