<style>
#log_sub{
	float:left;
	margin-top:10px;
	width:950px;
	border-bottom:1px solid #DDD;
}
#log_sub a{
	text-decoration:none;
	float:left;
	text-align:center;
	width:220px;
	border:1px solid #DDD;
	margin-bottom:0px;
	border-bottom:none;
	color:#060;
}

#log_sub a:hover{
	border:1px solid #BBB;
	border-bottom:none;
}

#log_sub .active {
	background:#8eff8c;
}
th {
	color:#fff;
	font-weight:bold;
	text-align:center;	
}
</style>

<table width="450" cellpadding="0" cellspacing="0" style="float:left;">
	<tr style="background:rgba(206,52,16,0.8)">
    	<th colspan="3">- Credits</th>
    </tr>
    <?php
		$crCmd = "SELECT * FROM pmc_log WHERE playerID = '".esc($db, $_GET['uid'])."' AND location = 'credits' ORDER BY offitime DESC";
		$crQry = mysqli_query($db, $crCmd);
		$c = 1;
		while($cr = mysqli_fetch_array($crQry)){
		$cru = ex($cr['descrip']);
		$iteminfoCmd = "SELECT * FROM server_1_player_all_items WHERE id = '".$cru[3]."'";
		$itemInfoQry = mysqli_query($db, $iteminfoCmd);
		$iteminfo = mysqli_fetch_array($itemInfoQry);
	?>
    <?php if($cru[1] == '0'){ ?>
	<tr <?php if(is_int($c/2)){echo 'style="background-color: rgb(241, 241, 241);"';}?>>
    	<td><?=sqltodate($cr['offitime'])?></td>
    	<td><?=$searchItem->Name?> bought <?=$cru[4]?> <?=$items_array[$iteminfo['lootid']]?> for</td>
        <td style="font-weight:bold; text-align:right;"><?=dot3($cru[4])?></td>
    </tr>
    <?php $c++;} ?>
    <?php ;} ?>
</table>
<table width="450" cellpadding="0" cellspacing="0" style="float:left; margin-left:50px;">
	<tr style="background:rgba(0,153,0, 0.8);">
    	<th>+ Credits</th>
    </tr>
      <?php
		$crpCmd = "SELECT * FROM pmc_log WHERE playerID = '".esc($db, $_GET['uid'])."' AND location = 'credits'";
		$crpQry = mysqli_query($db, $crpCmd);
		$c = 1;
		while($crp = mysqli_fetch_array($crpQry)){
		$crup = ex($crp['descrip']);
		$iteminfoCmd = "SELECT * FROM server_1_player_all_items WHERE id = '".$crup[3]."'";
		$itemInfoQry = mysqli_query($db, $iteminfoCmd);
		$iteminfo = mysqli_fetch_array($itemInfoQry);
	?>
    <?php if($crup[1] == '1'){ ?>
	<tr <?php if(is_int($c/2)){echo 'style="background-color: rgb(241, 241, 241);"';}?>>
    	<td><?=$searchItem->Name?> bought <?=$crup[4]?> <?=$items_array[$iteminfo['lootid']]?> for</td>
        <td style="font-weight:bold; text-align:right;"><?=dot3($crup[4])?></td>
    </tr>
    <?php $c++;} ?>
    <?php ;} ?>
</table>