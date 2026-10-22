<?php

class Val
{
	public function __construct()
	{
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}


	public function verifyShipID($data)
	{
	    $type = array(56, 59, 52, 7, 67, 65, 66, 54,63,64,10,55,127,128,129);
	    if (!in_array($data, $type))
	    {            
	    	return "You use an incorrect ship ID.";
		}
	}

	public function verifyDiplomacyType($data)
	{
	    $type = array(1, 2);
	    if (!in_array($data, $type))
	    {            
	    	return "You use an incorrect diplomacy type.";
		}
	}

	public function verifyClanID($data)
	{
	    $returnvalue = $this->db->select('SELECT id FROM clan WHERE id=:clan_id', array('clan_id' => $data));
	    if (isset($returnvalue[0]) == 0)
	    {            
	    	return "This clan doesn't exist.";
		}
	}

	public function verifyPlayerRequestDecline($data)
	{
	    $returnvalue = $this->db->select('SELECT id FROM users', array('id' => $data));
	    if (isset($returnvalue[0]) == 0)
	    {            
	    	return "This player don't exist.";
		}
	}

	public function verifyPlayerRequestAccept($data)
	{
	    $returnvalue = $this->db->select('SELECT id FROM users WHERE id=:id AND clanid=0', array('id' => $data));
	    if (isset($returnvalue[0]) == 0)
	    {            
	    	return "This player don't exist or is already in a clan.";
		}
	}

	public function verifyPlayerClan($data)
	{
	    $returnvalue = $this->db->select('SELECT id FROM users WHERE clanid=:clan_id AND id=:id', array('clan_id' => Auth::getUser('clanid'), 'id' => $data));
	    if (isset($returnvalue[0]) == 0)
	    {            
	    	return "This player is not in your clan or don't exist.";
		}
	}

	public function verifyClanTag($data)
	{
		if (strlen($data) > 4 || preg_match("/[^a-zA-Z0-9]/", $data)) 
		{
			return "The clan tag is too big or contains not allowed characters.";
		
		}
		else
		{
			    $returnvalue = $this->db->select('SELECT clan_tag FROM clan WHERE clan_tag= :clan_tag', array('clan_tag' => $data));
			    if (isset($returnvalue[0]) != 0)
			    {            
			    	return "This clan tag is already used. Please choose another one.";
				}
		}
	}

	public function verifyClanName($data)
	{
		if (strlen($data) > 15) 
		{
			return "The clan name is too big or contains not allowed characters.";
		
		}
		else
		{
			    $returnvalue = $this->db->select('SELECT clan_name FROM clan WHERE clan_name= :clan_name', array('clan_name' => $data));
			    if (isset($returnvalue[0]) != 0)
			    {            
			    	return "This clan name is already used. Please choose another one.";
				}
		}
	}


	public function verifyFirm($data)
	{
		/**
		 * If the username is beetween 4 and 20
		 */
			$faction = array("1", "2", "3");
			if (!in_array($data, $faction))
			{
				return 'That company don\'t exist.';
			}
	}

	public function verifyUsername($data)
	{
		/**
		 * If the username is beetween 4 and 20
		 */

		if (strlen(utf8_decode(html_entity_decode($data, ENT_COMPAT, 'utf-8'))) < 4 || strlen(utf8_decode(html_entity_decode($data, ENT_COMPAT, 'utf-8'))) > 20) 
		{
			return "Your username is too short. Please choose a username which has between 4 and 20 characters.";
		
		}

		$decoded = utf8_decode(html_entity_decode($data, ENT_COMPAT, 'utf-8'));

		if (preg_match('/[|@%]/', $decoded))
		{
			return "Your username contains not allowed characters. Remove | or @ or %. ";
		}
		else
		{
			/**
			 * If the username is not taken
			 */

	        $returnvalue = $this->db->select('SELECT username FROM users WHERE username= :username', array('username' => $data));
	        if (isset($returnvalue[0]) != 0)
	        {            
	        	return "This username is already used. Please choose another one.";
	    	}
		}
	}

	public function verifyPassword($data, $arg)
	{
		if ( strlen(utf8_decode(html_entity_decode($data, ENT_COMPAT, 'utf-8'))) < 4 || strlen(utf8_decode(html_entity_decode($_POST[$arg], ENT_COMPAT, 'utf-8'))) > 20 && strlen(utf8_decode(html_entity_decode($data, ENT_COMPAT, 'utf-8'))) < 4 || strlen(utf8_decode(html_entity_decode($_POST[$arg], ENT_COMPAT, 'utf-8'))) > 20) 
		{
			return "Your password is too short. Please choose a password which has between 4 and 20 characters.";
		}
		else
		{
			if($data != $_POST[$arg])
			{
				return "Passwords do not match.";
			}
		}
	}

	public function emailIsValid($data)
	{
        $value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $data);
        if ($value == 0)
            return "Your email is incorrect. Please use a correct one.";
	}







	public function __call($name, $arguments)
	{
		throw new Exception("$name does not exist inside of:". __CLASS__);
		
	}


}

?>