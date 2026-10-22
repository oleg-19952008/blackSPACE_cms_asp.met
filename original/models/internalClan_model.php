<?php

class InternalClan_Model extends Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function CreateClan()
	{
		try
		{

			$form = new Form();

			$form 	->post('clan_tag')
					->val('verifyClanTag')
					->post('clan_name')
					->val('verifyClanName');

			$form 	->submit();
			$data = $form->fetch();

		    $returnvalue = $this->db->select('SELECT admin_id FROM clan WHERE admin_id= :id', array('id' => Session::get('account_ID')));
		    if (isset($returnvalue[0]) == 0)
		    {      
				$sth = $this->db->prepare("INSERT INTO `clan`(`clan_tag`, `clan_name`, `admin_id`) VALUES (:tag, :name, :admin_id)");
				$sth->execute(array('tag' => $data['clan_tag'], 'name' => $data['clan_name'], 'admin_id' => Session::get('account_ID')));
				echo json_encode(array('result' => 'Clan created !'));

				 $returnvalue = $this->db->select('SELECT id FROM clan_request WHERE player_id=:id', array('id' => Session::get('account_ID')));
				 foreach ($returnvalue as $key => $value) {
				 	$sth = $this->db->prepare("DELETE FROM `clan_request` WHERE id=:id");
				 	$sth->execute(array('id' => $returnvalue[$key]['id']));
				 }

			 	$returnvalue = $this->db->select('SELECT id FROM clan WHERE admin_id= :id', array('id' => Session::get('account_ID')));
				$sth = $this->db->prepare("UPDATE `users` SET `clanid`=:clanid WHERE id=:id");
				$sth->execute(array('clanid' => $returnvalue['0']['id'], 'id' => Session::get('account_ID')));

			}
			else
			{
				echo json_encode(array('result' => 'You already have a clan !'));
			}
		}

		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
	}

	public function JoinClan()
	{
		try
		{

			$form = new Form();

			$form 	->post('clan_id')
					->val('verifyClanID');

			$form 	->submit();
			$data = $form->fetch();

		    $returnvalue = $this->db->select('SELECT id FROM users WHERE clanid > 1 AND id=:id', array('id' => Session::get('account_ID')));
		    if (isset($returnvalue[0]) == 0)
		    {      
			    $returnvalue = $this->db->select('SELECT id FROM clan_request WHERE clan_id=:clan_id AND player_id=:id', array('clan_id' => $data['clan_id'], 'id' => Session::get('account_ID')));
			    if (isset($returnvalue[0]) == 0)
			    {
					$sth = $this->db->prepare("INSERT INTO `clan_request`(`clan_id`, `player_id`) VALUES (:clan_id, :id)");
					$sth->execute(array('clan_id' => $data['clan_id'], 'id' => Session::get('account_ID')));
					echo json_encode(array('result' => 'Request send !'));
			    }
			    else
			    {
			    	echo json_encode(array('result' => 'You already made a request for that clan !'));
			    }
			}
			else
			{
				echo json_encode(array('result' => 'You already have a clan !'));
			}
		}

		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
	}

	public function ClanRanking()
	{
			$sth = $this->db->prepare("SELECT id, clan_tag, clan_name FROM clan");
			$sth->execute();
			$data = $sth->fetchAll();

			$clan_ranking = array();

			foreach ($data as $key => $value) 
			{
				$kill_count = 0;
				$sth = $this->db->prepare("SELECT user_kill FROM users WHERE clanid = :id");
				$sth->execute(array('id' => $data[$key]['id']));
				$data2 = $sth->fetchAll();

				foreach ($data2 as $key2 => $value2) 
				{
					$kill_count += $data2[$key2]['user_kill'];
				}

				$data[$key]['user_kill'] = $kill_count;
			}

			usort($data, function ($item1, $item2) 
			{
    			return $item2['user_kill'] - $item1['user_kill'];
			});
			return $data;
	}

	public function DiplomacyRequest()
	{
		if ($this->isAdmin() == 1)
		{
			$form = new Form();

			$form 	->post('clan_id')
					->val('verifyClanID')
					->post('diplomacy_type')
					->val('verifyDiplomacyType');

			$form 	->submit();
			$data = $form->fetch();

			$type = array(1 => "war", 2 => "nap");

			$returnvalue = $this->db->select('SELECT id FROM clan_diplomacy WHERE clan_id =:id AND second_clan_id=:second_clan_id AND type=:type', array('id' => Auth::getUser('clanid'), 'second_clan_id' => $data['clan_id'], 'type' => $type[$data['diplomacy_type']]));
			$returnvalue2 = $this->db->select('SELECT id FROM clan_diplomacy WHERE clan_id =:second_clan_id AND second_clan_id=:id AND type=:type', array('id' => Auth::getUser('clanid'), 'second_clan_id' => $data['clan_id'], 'type' => $type[$data['diplomacy_type']]));
			if ($data['diplomacy_type'] == 1)
			{
				if (isset($returnvalue[0]) == 0 && isset($returnvalue2[0]) == 0 && $data['clan_id'] != Auth::getUser('clanid'))
				{      

					$sth = $this->db->prepare("INSERT INTO `clan_diplomacy`(`clan_id`, `second_clan_id`, `type`) VALUES (:clan_id,:second_clan_id,:type)");
					$sth->execute(array('clan_id' => Auth::getUser('clanid'), 'second_clan_id' => $data['clan_id'], 'type' => $data['diplomacy_type']));
					header('location: '.URL.'internalClan/Diplomacy');
				}
				else
				{
					header('location: '.URL.'internalClan/Diplomacy');
				}
			}

			if ($data['diplomacy_type'] == 2)
			{
				if (isset($returnvalue[0]) == 0 && isset($returnvalue2[0]) == 0 && $data['clan_id'] != Auth::getUser('clanid'))
				{      

					$sth = $this->db->prepare("INSERT INTO `clan_diplomacy_request`(`clan_id`, `second_clan_id`, `type`) VALUES (:clan_id,:second_clan_id,:type)");
					$sth->execute(array('clan_id' => Auth::getUser('clanid'), 'second_clan_id' => $data['clan_id'], 'type' => $data['diplomacy_type']));
					header('location: '.URL.'internalClan/Diplomacy');
				}
				else
				{
					header('location: '.URL.'internalClan/Diplomacy');
				}
			}
		}
	}

	public function ListDiplomacy()
	{
		try
		{
			$sth = $this->db->prepare("SELECT clan_diplomacy.id, clan.clan_tag, clan.clan_name FROM  `clan`,`clan_diplomacy` WHERE clan_id = :clan_id AND clan.id = clan_diplomacy.second_clan_id");
			$sth->execute(array('clan_id' => Auth::getUser('clanid')));
			$data = $sth->fetchAll();

			return $data;
		}

		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
	}

	public function ListSecondDiplomacy()
	{
		try
		{
			$sth = $this->db->prepare("SELECT clan_diplomacy.id, clan.clan_tag, clan.clan_name FROM  `clan`,`clan_diplomacy` WHERE second_clan_id = :clan_id AND clan.id = clan_diplomacy.clan_id");
			$sth->execute(array('clan_id' => Auth::getUser('clanid')));
			$data = $sth->fetchAll();

			return $data;
		}

		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
	}




	public function CancelDiplomacy()
	{

		if ($this->isAdmin() == 1)
		{
			$form = new Form();

			$form 	->post('diplomacy_id');

			$form 	->submit();
			$data = $form->fetch();
			$sth = $this->db->prepare("DELETE FROM `clan_diplomacy` WHERE id=:id AND clan_id=:clanid");
			$sth->execute(array('id' => $data['diplomacy_id'], 'clanid' => Auth::getUser('clanid')));
			// header('location: '.URL.'internalClan/Diplomacy');
		}
	}

	public function ListDiplomacyClan()
	{
		$sth = $this->db->prepare("SELECT * FROM clan WHERE id != :id");
		$sth->execute(array('id' => Auth::getUser('clanid')));
		$data = $sth->fetchAll();

		return $data;
	}

	public function ListClan()
	{
		$sth = $this->db->prepare("SELECT * FROM clan");
		$sth->execute();
		$data = $sth->fetchAll();

		return $data;
	}

	public function AcceptMembers()
	{
		if ($this->isAdmin() == 1)
		{
			$form = new Form();

			$form 	->post('player_id')
					->val('verifyPlayerRequestAccept');

			$form 	->submit();
			$data = $form->fetch();

			$returnvalue = $this->db->select('SELECT id FROM clan_request WHERE player_id=:id', array('id' => $data['player_id']));
			foreach ($returnvalue as $key => $value) {
				$sth = $this->db->prepare("DELETE FROM `clan_request` WHERE id=:id");
				$sth->execute(array('id' => $returnvalue[$key]['id']));
			}

			$sth = $this->db->prepare("UPDATE `users` SET `clanid`=:clanid WHERE id=:id");
			$sth->execute(array('clanid' => Auth::getUser('clanid'), 'id' => $data['player_id']));

		}
	}

	public function DeclineMembers()
	{
		if ($this->isAdmin() == 1)
		{
			$form = new Form();

			$form 	->post('player_id')
					->val('verifyPlayerRequestDecline');

			$form 	->submit();
			$data = $form->fetch();

			$sth = $this->db->prepare("DELETE FROM `clan_request` WHERE player_id=:id AND clan_id=:clanid");
			$sth->execute(array('id' => $data['player_id'], 'clanid' => Auth::getUser('clanid')));
		}
	}

	public function GetMyClanMembers()
	{
		$sth = $this->db->prepare("SELECT id, username FROM users WHERE clanid=:id");
		$sth->execute(array('id' => Auth::getUser('clanid')));
		$data = $sth->fetchAll();

		return $data;
	}

	public function GetMyClanRequest()
	{
		$sth = $this->db->prepare("SELECT player_id FROM clan_request WHERE clan_id=:clanid");
		$sth->execute(array('clanid' => Auth::getUser('clanid')));
		$data = $sth->fetchAll();

		return $data;
	}

	public function isAdmin()
	{
		$returnvalue = $this->db->select("SELECT id FROM clan WHERE admin_id=:id", array('id' => Session::get('account_ID')));
	    if (isset($returnvalue[0]) == 0)
	    {
	    	return 0;
	    }  
		else
		{
			return 1;
		}
	}

	public function kickPlayer()
	{

		if ($this->isAdmin() == 1)
		{
			$form = new Form();

			$form 	->post('player_id')
					->val('verifyPlayerClan');

			$form 	->submit();
			$data = $form->fetch();

			$sth = $this->db->prepare("UPDATE `users` SET `clanid`=0 WHERE clanid=:clanid AND id=:id");
			$sth->execute(array('clanid' => Auth::getUser('clanid'), 'id' => $data['player_id']));
		}
	}


	public function Destroy()
	{

		if ($this->isAdmin() == 1)
		{
			$sth = $this->db->prepare("DELETE FROM `clan` WHERE id=:clanid");
			$sth->execute(array('clanid' => Auth::getUser('clanid')));

			$sth = $this->db->prepare("DELETE FROM `clan_request` WHERE clan_id=:clanid");
			$sth->execute(array('clanid' => Auth::getUser('clanid')));

			$sth = $this->db->prepare("UPDATE `users` SET `clanid`=0 WHERE clanid=:clanid");
			$sth->execute(array('clanid' => Auth::getUser('clanid')));
		}
	}


	public function Leave()
	{
		$sth = $this->db->prepare("UPDATE `users` SET `clanid`=0 WHERE id=:id");
		$sth->execute(array('id' => Session::get('account_ID')));
	}
}

?>