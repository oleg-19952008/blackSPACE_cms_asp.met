<?php
// - selectionner le joueur
// - prendre ses userslog
// - vérifier si il y a plusieurs kill à la suite
// - si plus de 3 à la suite afficher le résultat

$timestart=microtime(true);

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

function get_users()
{
	$req = Connexion::bdd()->prepare('SELECT id, username, user_kill FROM `users` ORDER BY user_kill DESC');
	$req->execute();

	$data = $req->fetchAll();

	return $data;
}

function get_user_log($id)
{
	$req = Connexion::bdd()->prepare('SELECT * FROM `users_log` WHERE `playerid`='.$id.' AND `message` LIKE "%You have destroyed%"');
	$req->execute();

	$data = $req->fetchAll();

	return $data;
}

$userslist = get_users();

foreach ($userslist as $key => $value) 
{
	$user_log = get_user_log($userslist[$key]['id']);
	$userresult = array();
	foreach ($user_log as $key2 => $value2) 
	{
		if ($key2 == 0)
		{
			$tmp = '';
		}
		else
		{
			$tmp = $user_log[$key2-1]['message'];
		}

		if($tmp == $user_log[$key2]['message'])
		{
			array_push($userresult, $user_log[$key2]['message']);
		}
	}

	if (count($userresult) > 0)
	{
		foreach ($userresult as $key3 => $value3) 
		{
			echo $userslist[$key]['id'].' - '.$userslist[$key]['username'].' : '.$userresult[$key3].'<br>';
		}
	}
}

?>