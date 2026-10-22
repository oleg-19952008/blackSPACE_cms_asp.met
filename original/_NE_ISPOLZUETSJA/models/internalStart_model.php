<?php

class InternalStart_Model extends Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function halloffame()
	{
		$tmp = time();
		$sth = $this->db->prepare("SELECT users.username, users.user_kill FROM users WHERE (SELECT count(id) AS is_ban FROM bans WHERE bans.user_id = users.id AND bans.timestamp_expire > UNIX_TIMESTAMP() ) = 0  ORDER BY users.user_kill DESC LIMIT 0, 9");
		$sth->execute();
		$data = $sth->fetchAll();

		return $data;
	}

	public function halloffame100()
	{
		$sth = $this->db->prepare("SELECT users.username, users.user_kill FROM users WHERE (SELECT count(id) AS is_ban FROM bans WHERE bans.user_id = users.id AND bans.timestamp_expire > UNIX_TIMESTAMP() ) = 0  ORDER BY users.user_kill DESC LIMIT 0, 100");
		$sth->execute();
		$data = $sth->fetchAll();

		return $data;
	}

	public function logbook()
	{
		$sth = $this->db->prepare("SELECT * FROM users_log WHERE playerid=:id ORDER BY id DESC LIMIT 0, 5");
		$sth->execute(array('id' => Session::get('account_ID')));
		$data = $sth->fetchAll();

		return $data;
	}

	public function editaccount()
	{
		try 
		{
			$form = new Form();

			$form 	->post('username')
					->val('verifyUsername');

			$form 	->submit();
			$data = $form->fetch();

			$sth = $this->db->prepare("UPDATE `users` SET `username`=:username WHERE id=:id");
			$sth->execute(array('username' => $data['username'], 'id' => Session::get('account_ID')));

			echo json_encode(array('result' => 'Your username has been edited to ', 'username' => $data['username']));


		} 
		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
	}
}

?>