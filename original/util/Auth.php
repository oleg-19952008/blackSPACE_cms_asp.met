<?php

class Auth
{
	public static function handleLogin()
	{

		@session_start();
		$logged = Session::get('loggedIn');
		if ($logged == false)
		{
			Session::destroy();
			header('location: /index');
			exit;
		}
	}

	public static function isLogged()
	{
		@session_start();
		$logged = Session::get('loggedIn');
		if($logged == true)
		{
			header('location: /internalStart');
			exit;
		}
	}

	public function getUser($data)
	{
		@session_start();
		$logged = Session::get('loggedIn');
		if ($logged == true)
		{
			$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	        $returnvalue = $this->db->select('SELECT '.$data.' FROM users WHERE id= :account_id', array('account_id' => Session::get('account_ID')));       
        	return $returnvalue[0][$data];
		}
	}

	public function getUserSettings($data)
	{
		@session_start();
		$logged = Session::get('loggedIn');
		if ($logged == true)
		{
			$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	        $returnvalue = $this->db->select('SELECT '.$data.' FROM users_settings WHERE playerid= :account_id', array('account_id' => Session::get('account_ID')));       
        	return $returnvalue[0][$data];
		}
	}

	public function getUserByID($data, $id)
	{
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $returnvalue = $this->db->select('SELECT '.$data.' FROM users WHERE id= :account_id', array('account_id' => $id));       
    	return $returnvalue[0][$data];
	}
}


?>