<?php 
	include('yoshi.db.php');
	date_default_timezone_set("Europe/Copenhagen");
	$clanCmd = "SELECT * FROM server_1_clan WHERE Tax > 0";
	$clanQry = mysqli_query($db, $clanCmd);
	if(date("Hi") > '0000' && date("Hi") < '0015'){
		while($clan = mysqli_fetch_array($clanQry)){
			$members = explode("|", $clan['members']);
			$steuer=0;
			foreach($members as $member){
				$userCmd = "SELECT * FROM server_1_players INNER JOIN users ON users.ID = server_1_players.playerID WHERE server_1_players.playerID = '".$member."'";
				$userQry = mysqli_query($db, $userCmd);
				$user = mysqli_fetch_object($userQry);
				$steuer = $steuer + round($user->credits /100 * $clan['Tax']);
				$spend = round($user->credits /100 * $clan['Tax']);
				
				$updateuserCredits = "UPDATE server_1_players SET credits = (credits - '".$spend."') WHERE playerID = '".$member."'";
				$updateuserqry = mysqli_query($db, $updateuserCredits);
				$clanlog = "INSERT INTO server_1_clan_logs (clanID, clanplayer, descrip, logtime) VALUES ('".$clan['clanID']."', '".$user->Name."', 'Spend ".number_format($spend,0, ",", ".")." Credits.', '".date("Y-m-d H:i:s")."')";
				$clanlogQry = mysqli_query($db, $clanlog);
			}
			$clannewCr = "UPDATE server_1_clan SET clan_credits = (clan_credits + '".$steuer."') WHERE clanID = '".$clan['clanID']."'";
			$clanNewQry = mysqli_query($db, $clannewCr);
		}
	}
?>