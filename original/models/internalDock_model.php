<?php

class InternalDock_Model extends Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function get_ship_infos()
	{
		$req = $this->db->prepare('SELECT ship_hp, laser, generator, extras, base_speed FROM ships WHERE ship_id=:id');
		$req->execute(array('id' => $id));
		$data = $req->fetchAll();

		return $data;
	}

	function BuyShip()
	{
		try
		{

			$form = new Form();

			$form 	->post('id')
					->val('verifyShipID');

			$form 	->submit();
			$data = $form->fetch();


			$sth = $this->db->prepare("SELECT ship_id, ship_hp, base_speed FROM ships WHERE ship_id = :id");
			$sth->execute(array('id' => $data['id']));
			$data2 = $sth->fetchAll();

			$sth = $this->db->prepare("UPDATE users SET shipid=:ship_id, current_hp=:curr_hp, max_hp=:max_hp WHERE id=:id");
			$sth->execute(array('id' => Session::get('account_ID'), 'ship_id' => $data2[0]['ship_id'], 'curr_hp' => 0, 'max_hp' => $data2[0]['ship_hp']));

			$sth = $this->db->prepare("UPDATE player_config SET current_shield=0, max_shield=0, ship_speed=:speed, min_damage=0, max_damage=0 WHERE player_id=:id");
			$sth->execute(array('id' => Session::get('account_ID'), 'speed' => $data2[0]['base_speed']));

			$sth = $this->db->prepare("UPDATE users_items SET OnConfig_1=0, OnConfig_2=0, Config1_DroneID=0, Config2_DroneID=0 WHERE player_id=:id");
			$sth->execute(array('id' => Session::get('account_ID')));


			echo json_encode(array('result' => 'Ship bought !'));

			header('location: '.URL.'internalDock');
		}

		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
	}
	
}

?>