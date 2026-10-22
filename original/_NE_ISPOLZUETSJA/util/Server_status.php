<?php

class Server_status
{
	public function get($data)
	{
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $returnvalue = $this->db->select('SELECT '.$data.' FROM server_status');       
    	return $returnvalue[0][$data];
	}


	public function online_users()
	{
			$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
			$req = $this->db->prepare('SELECT count(online) FROM users WHERE online=1');
		    $req->execute();

		    $resultat = $req->fetch();
			
			return $resultat[0];
	}
}


?>