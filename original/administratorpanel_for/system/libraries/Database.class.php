<?php


if(!defined('IN_TOPSITE')) die();

class DB
{
	static $connection  = NULL;
	static $connections = array();
	static $querycount  = 0;
	static $queries		= array();
	
	function Build()
	{
		$c = Config::load('main');
		self::connect($c['hostname'], $c['username'], $c['password'], $c['database']);
	}

	/*
	|--------------------------------------------------------------|
	| CONNECT							   |
	|--------------------------------------------------------------|
	*/
	function connect($host,$user,$pass,$db) {

            $mysqli = new mysqli($host, $user, $pass, $db);

            if($mysqli->connect_error) 
              die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());

            self::$connections[] = $mysqli;
            self::$connection    = $mysqli;
            return $mysqli;
         }

	
	static function switchConnection($id = 0)
	{
		if(isset(self::$connections[$id]))
		{
			self::$connection = self::$connections[$id];
		}
		
		else
		{
			show_error('Connection id `'.$id.'` does not exist');
		}
	}

	static function safe($s = '')
	{
            $con = self::$connection;
		//TODO: finish this... not exactly perfect
		return mysqli_real_escape_string($con, $s);
	}
	
	static function query($query, $conid = FALSE, $insertid = FALSE)
	{
		$con = self::$connection;

		if($conid != FALSE)
		{
			if(isset(self::$connections[$conid]))
			{
				$con = self::$connections[$conid];
			}
		}
                mysqli_set_charset($con,"utf8");
		$rquery = mysqli_query($con, $query) or die(mysqli_error($con));

			self::$querycount++;
			self::$queries[] = $rquery;
                if($insertid != FALSE){
                    return $con->insert_id;
                }else{
                    return $rquery;
                }
			
	}
	
	static function select($table, $WHERE = FALSE, $LIMIT = FALSE, $JOIN = FALSE)
	{
		$query = "SELECT * FROM $table";

                if($JOIN != FALSE)
		{
			$query .= " $JOIN";
		}
 
		if($WHERE != FALSE)
		{
			$query .= " WHERE $WHERE";
		}

		if($LIMIT != FALSE)
		{
			$query .= " LIMIT $LIMIT";
		}

		return self::query($query);
	}
	

	static function num_rows($queryid = FALSE)
	{
		$query = self::getid($queryid);
		return mysqli_num_rows($query);
	}

	static function fetch_array($queryid = FALSE)
	{
		$query  = self::getid($queryid);
		$result = array();

		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			foreach($row as $k => $v)
			{
				$row[$k] = stripslashes($v);
			}

			$result[] = $row;
		}
		
		return $result;
	}

	static function fetch_row($queryid = FALSE, $rowid = 0)
	{
		$result = self::fetch_array($queryid);
		
		if(isset($result[$rowid]))
		{
			return $result[$rowid];
		}
		
		return false;
	}
	
	static function getid($queryid = FALSE)
	{
		$query = self::$queries[count(self::$queries)-1];
		
		if($queryid != FALSE)
		{
			if(isset(self::$queries[$queryid]))
			{
				$query = self::$queries[$queryid];
			}
		}

		return $query;
	}
        
}
?>