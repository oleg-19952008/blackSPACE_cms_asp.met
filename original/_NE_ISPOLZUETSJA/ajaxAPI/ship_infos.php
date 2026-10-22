<?php

require '../libs/Session.php';
Session::init();

$logged = Session::get('loggedIn');
if ($logged == false)
{
	Session::destroy();
	header('location: /index');
	exit;
}
$account_ID = Session::get('account_ID');

class Connexion 
{
     
    public static function bdd() {     
        try 
        {
            $bdd = new PDO('mysql:host=127.0.0.1;dbname=darkorbit_new', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (Exception $e) 
        {
        die('Erreur : '. $e->getMessage());
        }
            return $bdd;
        }
}

function get_ship_infos($id)
{
	$req = Connexion::bdd()->prepare('SELECT ship_hp, laser, generator, extras, base_speed FROM ships WHERE ship_id=:id');
	$req->execute(array('id' => $id));
	$data = $req->fetchAll();

	return $data[0];
}


if(!empty($_GET))
{
	$ship_list = array(3,4,5,7,8,9,10);
	if (in_array($_GET['id'], $ship_list))
	{
		$ship_array = get_ship_infos($_GET['id']);

		echo '<table><tr><td style="width: 50%">Speed : '.$ship_array['base_speed'].'</td><td>Hit Points : '.$ship_array['ship_hp'].'</td></tr><tr><td>Lasers : '.$ship_array['laser'].'<td>Generators : '.$ship_array['generator'].'</td></td></tr><tr><td>Extras : '.$ship_array['extras'].'</td></tr></table><br><br><center><form action="http://127.0.0.1/internalDock/Buy_Ship" method="post"><input type="hidden" name="id" value="'.$_GET['id'].'"><input type="submit" value="BUY" style="border: 0;background: rgba(36, 150, 0, 0.5);cursor: pointer;color: darkblue;font-weight: bold;border-radius: 5px;"></form></center>';
	}
}


?>

