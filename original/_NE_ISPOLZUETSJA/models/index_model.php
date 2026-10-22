<?php

class Index_Model extends Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function convertToNumericEntities($string) {
	    $convmap = array(0x80, 0x10ffff, 0, 0xffffff);
	    return mb_encode_numericentity($string, $convmap, "UTF-8");
	}

	function run()
	{
		if (isset($_POST['loginForm_default_password']) && isset($_POST['loginForm_default_username']))
		{
			$sth = $this->db->prepare("SELECT id, username FROM users WHERE username = :username AND password= :password");


			$username = $this->convertToNumericEntities(htmlentities($_POST['loginForm_default_username']));
			$sth->execute(array(
				':username' => $username,
				':password' => md5($_POST['loginForm_default_password'])
			));

			$data = $sth->fetchAll();

			// $data = $sth->fetchAll();
			$count = $sth->rowCount();

			if ($count > 0)
			{
				$sth = $this->db->prepare("SELECT is_ban, ban_reason FROM users WHERE id = :id");
				$sth->execute(array(':id' => $data[0]['id']));

				$data2 = $sth->fetchAll();
				
				if ($data2[0]['is_ban'] == 1)
				{
					echo json_encode(array('result' => $data2[0]['ban_reason'].' If you want more information, contact linkpad at linkpad@linkpad.fr'));
				}
				else if ($data2[0]['is_ban'] == 0)
				{
					// login
					Session::init();
					Session::set('loggedIn', true);
		            Session::set('account_ID', $data[0]['id']);
					echo json_encode(array('result' => 'logged'));
				}
			}

			else
			{
			echo json_encode(array('result' => 'La combinaison entre le pseudonyme et le mot de passe est inconnue.<br>Veuillez vérifier vos données et réessayez.'));
		 	// header('location: /index');
			}
		}
	}


	function add_to_db_generator($id, $item_id)
	{
		$sql = 
		'
			INSERT INTO `users_items`(`player_id`, `item_id`)
			VALUES
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id);
		';

		$req = $this->db->prepare($sql);
		$req->execute(array('player_id' => $id, 'item_id' => $item_id));
	}

	function add_to_db_laser($id, $item_id)
	{
		$sql = 
		'
			INSERT INTO `users_items`(`player_id`, `item_id`)
			VALUES
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id);
		';

		$req = $this->db->prepare($sql);
		$req->execute(array('player_id' => $id, 'item_id' => $item_id));
	}

	function add_to_db_drone($id, $item_id)
	{
		$sql = 
		'
			INSERT INTO `users_items`(`player_id`, `item_id`)
			VALUES
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id),
			(:player_id,:item_id);
		';

		$req = $this->db->prepare($sql);
		$req->execute(array('player_id' => $id, 'item_id' => $item_id));
	}


	function add_user_config($playerid, $configid, $current_shield, $max_shield, $ship_speed)
	{
		$req = $this->db->prepare('INSERT INTO `player_config`(`player_id`, `config_id`, `current_shield`, `max_shield`, `ship_speed`) VALUES (:playerid, :configid, :current_shield, :max_shield, :ship_speed)');
		$req->execute(
			array('playerid' => $playerid,
					'configid' => $configid,
					'current_shield' => $current_shield,
					'max_shield' => $max_shield,
					'ship_speed' => $ship_speed
				));
	}


	function register()
	{
		try 
		{
			$form = new Form();

			$form 	->post('signup_username')
					->val('verifyUsername')
					->post('signup_passwordRepeat')
					->post('signup_password')
					->val('verifyPassword', 'signup_passwordRepeat')
					->post('signup_email')
					->val('emailIsValid')
					->post('signup_company')
					->val('verifyFirm');

			$form 	->submit();
			$data = $form->fetch();

			$this->db->insert('users', array(
				'username' => $data['signup_username'],
				'password' => md5($data['signup_password']),
				'email' => $data['signup_email'],
				'factionid' => $data['signup_company']
			));

			$sth = $this->db->prepare("SELECT id FROM users WHERE username = :username AND password= :password");


			$sth->execute(array(
				':username' => $data['signup_username'],
				':password' => md5($data['signup_password'])
			));

			$result = $sth->fetchAll();

			$this->db->insert('users_settings', array(
				'playerid' => $result[0]['id']
			));

			$this->add_to_db_laser($result[0]['id'], 1);
			$this->add_to_db_generator($result[0]['id'], 2);
			$this->add_to_db_generator($result[0]['id'], 2);
			$this->add_to_db_generator($result[0]['id'], 4);
			$this->add_to_db_drone($result[0]['id'], 3);
			$this->add_user_config($result[0]['id'], 1, 0, 0, 300);
			$this->add_user_config($result[0]['id'], 2, 0, 0, 300);

			echo json_encode(array('result' => 'You have been registered. You can now login '.$data['signup_username'].' !'.Session::get('aleat_nbr')));


		} 
		catch (Exception $e) 
		{
			echo $e->getMessage();
		}
	}

    function captcha()
    {
        // On définit la configuration :
        $nbr_chiffres = 6; // Nombre de chiffres qui formeront le nombre

        ##### Ici on crée la variable qui contiendra le nombre aléatoire #####
        $i = 0;
        while($i < $nbr_chiffres) {
                $chiffre = mt_rand(0, 9); // On génère le nombre aléatoire
                $chiffres[$i] = $chiffre;
                $i++;
        }
        $nombre = null;
        // On explore le tableau $chiffres afin d'y afficher toutes les entrées qui s'y trouvent
        foreach ($chiffres as $caractere) {
                $nombre .= $caractere;
        }
        ##### On a fini de créer le nombre aléatoire, on le rentre maintenant dans une variable de session #####
        Session::set('aleat_nbr', $nombre);

        // Là, on définit le header de la page pour la transformer en image
        // header ("Content-type: image/png");
        // Là, on crée notre image
        $_img = imagecreatefrompng(URL.'util/fond_verif_img.png');

        // On définit maintenant les couleurs
        // Couleur de fond :
        $arriere_plan = imagecolorallocate($_img, 0, 0, 0); // Au cas où on n'utiliserait pas d'image de fond, on utilise cette couleur-là.
        // Autres couleurs :
        $avant_plan = imagecolorallocate($_img, 255, 255, 255); // Couleur des chiffres

        // On détruit les variables inutiles :
        unset($chiffre);
        unset($i);
        unset($caractere);
        unset($chiffres);

        imagestring($_img, 5, 18, 8, $nombre, $avant_plan);
        $red = imagecolorallocate($_img, 0, 255, 0);
        imagesetthickness($_img, 1);
        imageline($_img, 0, 10, 100, 20, $red);
        // imageline(image, x1, y1, x2, y2, color);

        imagepng($_img);
    }

}

?>