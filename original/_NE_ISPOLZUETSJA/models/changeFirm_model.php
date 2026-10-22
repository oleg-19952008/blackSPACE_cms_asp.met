<?php

class ChangeFirm_Model extends Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function FirmInfos()
	{
		$sth = $this->db->prepare("SELECT user_kill FROM users WHERE factionid=:factionid");
		$sth->execute(array('factionid' => Auth::getUser('factionid')));
		$data = $sth->fetchAll();

		return $data;
	}

	function ChangeFirm()
	{
		try 
		{
			$form = new Form();

			$form 	->post('factionid')
					->val('verifyFirm');

			$form 	->submit();
			$data = $form->fetch();
			$sth = $this->db->prepare("UPDATE `users` SET `factionid`=:factionid WHERE id=:id");
			$sth->execute(array(
				':factionid' => $data['factionid'],
				':id' => Session::get('account_ID')
			));

		}
		catch (Exception $e) 
		{
			echo $e->getMessage();
		}

	}
}

?>