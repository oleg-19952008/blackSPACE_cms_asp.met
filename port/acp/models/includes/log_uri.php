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
<?php
	$getlogCmd = "SELECT * FROM pmc_log INNER JOIN server_1_player_all_items ON pmc_log.playerID = server_1_player_all_items.playerID WHERE pmc_log.playerID = '".esc($db, $_GET['uid'])."'";
	$getlogQry = mysqli_query($db, $getlogCmd);
	
	while($getlog = mysqli_fetch_array($getlogQry)){
?>
<table width="450" cellpadding="0" cellspacing="0" style="float:left;">
	<tr style="background:rgba(206,52,16,0.8)">
    	<th colspan="3">- Credits</th>
    </tr>
	<tr <?php if(is_int($c/2)){echo 'style="background-color: rgb(241, 241, 241);"';}?>>
    	<td>Date</td>
    	<td>Descripton</td>
        <td style="font-weight:bold; text-align:right;">Cost</td>
    </tr>
</table>

<?php ;} ?>