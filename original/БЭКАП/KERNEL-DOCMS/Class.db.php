<?php
/*
 *  FOLLOW SCRIPT WAS MADE BY Seven & NavigatoR - MEDIANET IVS DENMARK
 */
class DB { 
        public static $instance; 

        public function __construct() {} 
         
        public static function getInstance() { 
         
                if(empty(self::$instance)) { 
                         
                        $db_info = array( 
                                "db_host" => "127.0.0.1", 
                                "db_port" => "3306", 
                                "db_user" => "root", 
                                "db_pass" => "SDFffas1663276safsdf7673VN345oiopiuopu34534", 
                                "db_name" => "darkorbit", 
                                "db_charset" => "UTF-8" 
                        ); 
                         
                         
                        try {                           
                                self::$instance = new PDO("mysql:host=".$db_info['db_host'].';port='.$db_info['db_port'].';dbname='.$db_info['db_name'], $db_info['db_user'], $db_info['db_pass']);
                                self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT ); 
								//self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                //self::$instance->query('SET NAMES utf8'); 
                                //self::$instance->query('SET CHARACTER SET utf8'); 

                        }   
                        catch(PDOException $e) {   
                                echo $e->getMessage();   
                        }                           
                         
                } 
                 
                return self::$instance; 
        } 
        public static function setLog($pid, $des){
		if($pid==0){
		}else{
            $con = self::getInstance();
            $sql = "INSERT INTO `server_1_log` (`playerID`, `descrip`) VALUES (?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $pid, PDO::PARAM_INT);
            $stmt->bindParam(2, $des, PDO::PARAM_STR);
            $stmt->execute();
			}
        }
		
		public static function pmc($pid, $des, $location){
		if($pid==0){
		}else{
            $con = self::$instance;
            $sql = "INSERT INTO `pmc_log` (`playerID`, `descrip` , `location`) VALUES (?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $pid, PDO::PARAM_INT);
            $stmt->bindParam(2, $des, PDO::PARAM_STR);            
            $stmt->bindParam(3, $location, PDO::PARAM_STR);
            $stmt->execute();
			}
        }
        static function safe($s = '')
		{
			$db_info = array( 
                                "db_host" => "127.0.0.1", 
                                "db_port" => "3306", 
                                "db_user" => "root", 
                                "db_pass" => "SDFffas1663276safsdf7673VN345oiopiuopu34534", 
                                "db_name" => "darkorbit", 
                                "db_charset" => "UTF-8" 
                        ); 
		    $con = $MySQLi = new mysqli($db_info["db_host"], $db_info["db_user"], $db_info['db_pass'], $db_info['db_name']);
			//TODO: finish this... not exactly perfect
			return mysqli_real_escape_string($con, $s);
		}
		
		static function getUserIP()
		{
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = $_SERVER['REMOTE_ADDR'];

			if(filter_var($client, FILTER_VALIDATE_IP))
			{
				$ip = $client;
			}
			elseif(filter_var($forward, FILTER_VALIDATE_IP))
			{
				$ip = $forward;
			}
			else
			{
				$ip = $remote;
			}

			return $ip;
		}

} 
?>
