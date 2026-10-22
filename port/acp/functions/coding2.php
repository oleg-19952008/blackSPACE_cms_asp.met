<style>
	label{
		cursor:pointer;
	}
	div{
		cursor:default;
	}
</style>
<?php
	if(isset($_POST['credits'])){
		$_SESSION['credits'] = $_SESSION['credits'] + $_POST['anzahl'];
	}
	if(isset($_POST['guri'])){
		$_SESSION['uridium'] = $_SESSION['uridium'] + $_POST['uanzahl'];
	}
	
	$ruid = $_SESSION['uid'];
	$rcred = $_SESSION['credits'];
	$ruridium = $_SESSION['uridium'];
	$db = $db;
	
	$srescmd = "SELECT * FROM player_cargo WHERE uID = '".$ruid."'";
	$sresQry = mysqli_query($db, $srescmd);
	if(mysqli_num_rows($sresQry)==0){
		$nresCmd = "INSERT INTO player_cargo (uID) VALUES ('".$ruid."')";
		$nresQry = mysqli_query($db, $nresCmd);
		header("Location: index.php?p=coding");
	} else {
	$sres = mysqli_fetch_object($sresQry);
	}

	if(isset($_POST['adden'])){
		$s1 = "2";
		$s2 = "4";
		$s3 = "16";
		$suri = "3";
		
		$replace = array(" ", "-", "+");
		$replaceto = array("", "", "");
		//Prometium
		if(!empty($_POST['prometium']) && filter_var(str_replace($replace, $replaceto, $_POST['prometium']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['prometium']);
			$r1 = $wert * $s1;
			if($r1 < $rcred){
				$pum = "UPDATE player_cargo SET prometium = (prometium + '".$wert."') WHERE uID = '".$ruid."'";
				$pumq = mysqli_query($db, $pum);
				$_SESSION['credits'] = $_SESSION['credits'] - $r1;
			} else {
				echo 'Nicht genug Credits';
			}
		}
		//Endurium
		if(!empty($_POST['endurium']) && filter_var(str_replace($replace, $replaceto, $_POST['endurium']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['endurium']);
			$r1 = $wert * $s1;
			if($r1 < $rcred){
				$pum = "UPDATE player_cargo SET endurium = (endurium + '".$wert."') WHERE uID = '".$ruid."'";
				$pumq = mysqli_query($db, $pum);
				$_SESSION['credits'] = $_SESSION['credits'] - $r1;
			} else {
				echo 'Nicht genug Credits';
			}
		}
		//Terbium
		if(!empty($_POST['terbium']) && filter_var(str_replace($replace, $replaceto, $_POST['terbium']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['terbium']);
			$r1 = $wert * $s1;
			if($r1 < $rcred){
				$pum = "UPDATE player_cargo SET terbium = (terbium + '".$wert."') WHERE uID = '".$ruid."'";
				$pumq = mysqli_query($db, $pum);
				$_SESSION['credits'] = $_SESSION['credits'] - $r1;
			} else {
				echo 'Nicht genug Credits';
			}
		}
		//Endurium2
		if(!empty($_POST['endurium2']) && filter_var(str_replace($replace, $replaceto, $_POST['endurium2']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['endurium2']);
			$r1 = $wert * $s1;
			if($r1 < $rcred){
				$pum = "UPDATE player_cargo SET endurium = (endurium + '".$wert."') WHERE uID = '".$ruid."'";
				$pumq = mysqli_query($db, $pum);
				$_SESSION['credits'] = $_SESSION['credits'] - $r2;
			} else {
				echo 'Nicht genug Credits';
			}
		}
		//Xenomit
		if(!empty($_POST['xenomit']) && filter_var(str_replace($replace, $replaceto, $_POST['xenomit']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['xenomit']);
			$r1 = $wert * 10;
			if($r1 < $rcred){
				$pum = "UPDATE player_cargo SET xenomit = (xenomit + '".$wert."') WHERE uID = '".$ruid."'";
				$pumq = mysqli_query($db, $pum);
				$_SESSION['credits'] = $_SESSION['credits'] - $r1;
			} else {
				echo 'Nicht genug Credits';
			}
		}
		// Prometid
		if(!empty($_POST['prometid']) && filter_var(str_replace($replace, $replaceto, $_POST['prometid']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['prometid']);
			$r = $wert * $s2;
			$calc_prometid = ($wert*10);
			if($calc_prometid <= $sres->prometium && $calc_prometid <= $sres->endurium){
				if($r < $rcred){
					$abzug = "UPDATE player_cargo SET prometium = (prometium - '".$calc_prometid."'), endurium = (endurium - '".$calc_prometid."')WHERE uID = '".$ruid."'";
					$abzugQry = mysqli_query($db, $abzug);
					$pum = "UPDATE player_cargo SET prometid = (prometid + '".$wert."') WHERE uID = '".$ruid."'";
					$pumq = mysqli_query($db, $pum);
					$_SESSION['credits'] = $_SESSION['credits'] - $r;
				} else {
					echo 'Nicht genug Credits';
				}
			} else {
				echo 'Nicht genug Prometium oder Endurium';
			}
		}
		// Duranium
		if(!empty($_POST['duranium']) && filter_var(str_replace($replace, $replaceto, $_POST['duranium']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['duranium']);
			$r = $wert * $s2;
			$calc_carge_needed = ($wert*10);
			if($calc_carge_needed <= $sres->terbium && $calc_carge_needed <= $sres->endurium){
				if($r < $rcred){
					$abzug = "UPDATE player_cargo SET terbium = (terbium - '".$calc_carge_needed."'), endurium = (endurium - '".$calc_carge_needed."') WHERE uID = '".$ruid."'";
					$abzugQry = mysqli_query($db, $abzug);
					$pum = "UPDATE player_cargo SET duranium = (duranium + '".$wert."') WHERE uID = '".$ruid."'";
					$pumq = mysqli_query($db, $pum);
					$_SESSION['credits'] = $_SESSION['credits'] - $r;
				} else {
					echo 'Nicht genug Credits';
				}
			} else {
				echo 'Nicht genug Terbium oder Endurium';
			}
		}
		// Promerium
		if(!empty($_POST['promerium']) && filter_var(str_replace($replace, $replaceto, $_POST['promerium']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['promerium']);
			$r = $wert * $s2;
			$calc_carge_needed = ($wert*10);
			if($calc_carge_needed <= $sres->prometid && $calc_carge_needed <= $sres->duranium){
				if($r < $rcred){
					$abzug = "UPDATE player_cargo SET prometid = (prometid - '".$calc_carge_needed."'), duranium = (duranium - '".$calc_carge_needed."') WHERE uID = '".$ruid."'";
					$abzugQry = mysqli_query($db, $abzug);
					$pum = "UPDATE player_cargo SET promerium = (promerium + '".$wert."') WHERE uID = '".$ruid."'";
					$pumq = mysqli_query($db, $pum);
					$_SESSION['credits'] = $_SESSION['credits'] - $r;
				} else {
					echo 'Nicht genug Credits';
				}
			} else {
				echo 'Nicht genug Terbium oder Endurium';
			}
		}
		// Seprom
		if(!empty($_POST['seprom']) && filter_var(str_replace($replace, $replaceto, $_POST['seprom']), FILTER_VALIDATE_INT)){
			$wert = str_replace($replace, $replaceto, $_POST['seprom']);
			$r = $wert * $suri;
			$calc_carge_needed = ($wert*10);
			$calc_xen_needed = ($wert*5);
			if($calc_carge_needed <= $sres->promerium && $calc_xen_needed <= $sres->xenomit){
				if($ruri < $ruridium){
					$abzug = "UPDATE player_cargo SET promerium = (promerium - '".$calc_carge_needed."'), xenomit = (xenomit - '".$calc_xen_needed."') WHERE uID = '".$ruid."'";
					$abzugQry = mysqli_query($db, $abzug);
					$pum = "UPDATE player_cargo SET seprom = (seprom + '".$wert."') WHERE uID = '".$ruid."'";
					$pumq = mysqli_query($db, $pum);
					$_SESSION['uridium'] = $_SESSION['uridium'] - $r;
				} else {
					echo 'Nicht genug Uridium';
				}
			} else {
				echo 'Nicht genug Terbium oder Endurium';
			}
		}
		
		header("Location: index.php?p=coding");
	}
?>
<div style="float:right">
<form method="post" action="">
	<input type="text" name="anzahl">
	<input type="submit" name="credits" value="Credits adden"><br>
	<?=$_SESSION['credits']?> Credits
</form>
<form method="post" action="">
	<input type="text" name="uanzahl">
	<input type="submit" name="guri" value="Uridium adden"><br>
	<?=$_SESSION['uridium']?> Uri
</form>
</div>
<form method="post" action="">
<label for="prometium" style="width:63px; height:63px; background:url(../do_img/global/items/resource/ore/prometium_63x63.png); float:left;">
	<input id="prometium" type="text" name="prometium" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->prometium?>">
</label>
<label for="endurium" style="margin-left:20px; width:63px; height:63px; background:url(../do_img/global/items/resource/ore/endurium_63x63.png); float:left;">
	<input id="endurium" type="text" name="endurium" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->endurium?>">
</label>
<div style="float:left; width:32px; height:32px; background:url(../do_img/global/items/resource/ore/ar_right.png); margin-top:22px; margin-left:10px;"></div>
<label for="prometid" style="margin-left:20px; width:63px; height:63px; background:url(../do_img/global/items/resource/ore/prometid_63x63.png); float:left;">
	<input id="prometid" type="text" name="prometid" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->prometid?>">
</label>
<div style="float:left; margin-left:40px; font-weight:bold;">
Prometium:<br>
Endurium:<br>
Prometid:
</div>
<div style="float:left; margin-left:5px;">
2 Credits / Unit<br>
2 Credits / Unit<br>
10 Promerium | 10 Endurium | 4 Credits / Unit
</div>
<div class="cl"></div>



<label for="terbium" style="width:63px; height:63px; background:url(../do_img/global/items/resource/ore/terbium_63x63.png); float:left;">
	<input id="terbium" type="text" name="terbium" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->terbium?>">
</label>
<label for="endurium2" style="margin-left:20px; width:63px; height:63px; background:url(../do_img/global/items/resource/ore/endurium_63x63.png); float:left;">
	<input id="endurium2" type="text" name="endurium2" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->endurium?>">
</label>
<div style="float:left; width:32px; height:32px; background:url(../do_img/global/items/resource/ore/ar_right.png); margin-top:22px; margin-left:10px;"></div>
<label for="duranium" style="margin-left:20px; width:63px; height:63px; background:url(../do_img/global/items/resource/ore/duranium_63x63.png); float:left;">
	<input id="duranium" type="text" name="duranium" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->duranium?>">
</label>
<div style="float:left; margin-left:40px; font-weight:bold;">
Terbium:<br>
Endurium:<br>
Duranium:
</div>
<div style="float:left; margin-left:5px;">
2 Credits / Unit<br>
2 Credits / Unit<br>
10 Terbium | 10 Endurium | 4 Credits / Unit
</div>
<div class="cl" style="margin-bottom:20px;"></div>


<div style="width:63px; height:63px; background:url(../do_img/global/items/resource/ore/prometid_63x63.png); float:left;">
	<div style="float:left; margin-top:63px; color:#8a8a8a; background:#000; height:15px; width:63px; color:#aaa; text-align:center; font-weight:bold; border:none; line-height:15px;"><?=$sres->prometid?></div>
</div>
<div style="width:63px; height:63px; background:url(../do_img/global/items/resource/ore/duranium_63x63.png); float:left; margin-left: 20px;">
	<div style="float:left; margin-top:63px; color:#8a8a8a; background:#000; height:15px; width:63px; color:#aaa; text-align:center; font-weight:bold; border:none; line-height:15px;"><?=$sres->duranium?></div>
</div>
<div style="float:left; width:32px; height:32px; background:url(../do_img/global/items/resource/ore/ar_right.png); margin-top:22px; margin-left:10px;"></div>
<label for="promerium" style="margin-left:20px; width:63px; height:63px; background:url(../do_img/global/items/resource/ore/promerium_63x63.png); float:left;">
	<input id="promerium" type="text" name="promerium" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->promerium?>">
</label>
<div style="float:left; margin-left:40px; font-weight:bold;">
Promerium:
</div>
<div style="float:left; margin-left:5px;">
10 Prometid | 10 Duranium | 16 Credits / Unit
</div>
<div class="cl" style="margin-bottom:20px;"></div>


<div style="width:63px; height:63px; background:url(../do_img/global/items/resource/ore/promerium_63x63.png); float:left;">
	<div style="float:left; margin-top:63px; color:#8a8a8a; background:#000; height:15px; width:63px; color:#aaa; text-align:center; font-weight:bold; border:none; line-height:15px;"><?=$sres->promerium?></div>
</div>
<label for="xenomit" style="margin-left:20px; width:63px; height:63px; background:url(../do_img/global/items/resource/ore/xenomit_63x63.png); float:left;">
	<input id="xenomit" type="text" name="xenomit" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->xenomit?>">
</label>
<div style="float:left; width:32px; height:32px; background:url(../do_img/global/items/resource/ore/ar_right.png); margin-top:22px; margin-left:10px;"></div>
<label for="seprom" style="margin-left:20px; width:63px; height:63px; background:url(../do_img/global/items/resource/ore/seprom_63x63.png); float:left;">
	<input id="seprom" type="text" name="seprom" style="float:left; margin-top:63px; color:#fff; background:#000; width:63px; text-align:center; font-weight:bold; border:none;" placeholder="<?=$sres->seprom?>">
</label>
<div style="float:left; margin-left:40px; font-weight:bold;">
Xenomit:<br>
Seprom:
</div>
<div style="float:left; margin-left:5px;">
10 Credits / Unit<br>
10 Promerium | 5 Xenomit | 3 Uridium / Unit
</div>
<div class="cl" style="margin-bottom:20px;"></div>
<input type="submit" style="visibility:hidden" name="adden">
</form>