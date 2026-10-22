<?php 
	include('yoshi.db.php');
	$clanCmd = "SELECT clan.clanID, clan.clanName, clan.tagName, clan.memberCount, clan.members FROM server_1_clan as clan";
	$clanQry = mysqli_query($db, $clanCmd);

	while($clan = mysqli_fetch_array($clanQry)){
		$members = explode("|", $clan['members']);
		$r = 0;
		$h = 0;
		$l = 0;
		$p = 0;
		foreach($members as $member){
			$userCmd = "SELECT * FROM server_1_players WHERE playerID = '".$member."'";
			$userQry = mysqli_query($db, $userCmd);
			$user = mysqli_fetch_object($userQry);
			$r = $r + $user->exp;
			$h = $h + $user->honor;
			$l = $l + $user->level;
			$p = $p + $user->playerkills;
		}
		$points = (($r / 10000) + ($h / 1000) + ($l*100) + ($p*6)) / 100;
		$nr = "UPDATE server_1_clan SET rankpoints = '".$points."' WHERE clanID = '".$clan['clanID']."'";
		$newQ = mysqli_query($db, $nr);
	}
?>