<?php
	$newsCmd = "SELECT * FROM x_acp WHERE location = 'news' ORDER by offitime DESC";
	$newsQry = mysqli_query($db, $newsCmd);
	
	$lastsCmd = "SELECT * FROM staff_log WHERE action LIKE '31|%' AND user = '".$_SESSION['uid']."' ORDER BY date_time DESC LIMIT 20";
	$lastsQry = mysqli_query($db, $lastsCmd);
?>

<div class="in_item" style="width:599px; margin-left:-20px; margin-right:0px;">
   	<h3>Staff News</h3>
	<table width="100%">
		<?php while($news = mysqli_fetch_array($newsQry)){ ?>
		<tr>
			<td></td> 
		</tr>
		<?php ;} ?>
	</table>
</div>

<div class="in_item" style="float:right; width:300px; margin:0 0 0 0;">
   	<h3>Last searched Users</h3>
	<table width="100%">
		<?php $c=1; while($lasts = mysqli_fetch_array($lastsQry)){ $thisuser = ex($lasts['action']) ?>
		<tr style="background-color: <?php if((!is_int($c/2))){echo 'rgb(241, 241, 241)';} else {echo 'rgb(250, 250 ,250)';} ?>;">
			<th style="width:145px;"><a href="?p=search&uid=<?=$thisuser[2]?>"><?=$thisuser[1]?></a></th>
			<th><?=dateeng($lasts['date_time'])?></th>
		</tr>
		<?php $c++ ;} ?>
	</table>
</div>
<div class="cl"></div>