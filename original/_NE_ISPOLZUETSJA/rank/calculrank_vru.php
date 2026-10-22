<?php

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

function count_users()
{
	$req = Connexion::bdd()->prepare('SELECT count(id) FROM `users` WHERE user_kill > 10 AND factionid=3');
	$req->execute();

	$data = $req->fetch();

	return $data[0];
}

function get_users()
{
	$req = Connexion::bdd()->prepare('SELECT id, username, user_kill FROM `users` WHERE user_kill > 10 AND factionid=3 ORDER BY user_kill DESC');
	$req->execute();

	$data = $req->fetchAll();

	return $data;
}

function edit_rank($id, $rank)
{
	$req = Connexion::bdd()->prepare('UPDATE `users` SET `grade`=:rank WHERE id=:id');
	$req->execute(array('rank' => $rank, 'id' => $id));

}

$rank = array(1 => 20,
				2 => 12.29,
				3 => 10,
				4 => 9,
				5 => 8,
				6 => 7,
				7 => 6,
				8 => 5,
				9 => 4.5,
				10 => 4,
				11 => 3.5,
				12 => 3,
				13 => 2.5,
				14 => 2,
				15 => 1.5,
				16 => 1,
				17 => 0.5,
				18 => 0.1,
				19 => 0.01
			);

$addition = 0;
$userscount = count_users() - 1;
$predictcount = 0;
$userslist = get_users();

$rank = array_reverse($rank, true);

echo '- '.$userslist[0]['username']. ' set rank 20';
edit_rank($userslist[0]['id'], 20);
unset($userslist[0]);
echo '<br>';

foreach ($rank as $key => $value) {
	$predict = $userscount / 100 * $value;
	if ($predictcount < $userscount)
	{
		$predictcount += ceil($predict);
		// echo 'rank '.$key. ' = '.$value.' should have '.ceil($predict).' users<br>';
		// echo 'Players in it :<br>';
		$tmp = 0;
		foreach ($userslist as $key2 => $value2) {
				if ($tmp < $predict)
				{
					echo '- '.$userslist[$key2]['username'].' set rank '.$key.'<br>';
					edit_rank($userslist[$key2]['id'], $key);
					unset($userslist[$key2]);
					$tmp += 1;
				}
		}
	}
	$addition += $value;
}


// echo 'total rank : '.$addition.'<br>';
echo '<br>';
echo 'total predict : '.$predictcount.'<br>';


echo 'total users : '.$userscount;

var_dump($userslist);

 edit_rank(1, 21); // linkpad
 edit_rank(5, 21); // linkpad
$timeend=microtime(true);
$time=$timeend-$timestart;

$page_load_time = number_format($time, 3);
echo "<br><br>Script execute en " . $page_load_time . " sec";


?>