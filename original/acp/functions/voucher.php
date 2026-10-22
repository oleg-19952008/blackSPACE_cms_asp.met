<?php if(isset($_SESSION['user_rank']) && $_SESSION['user_rank'] >= 1){ 
	$vcmd = "SELECT * FROM server_1_voucher";
	$vqry = mysqli_query($db, $vcmd);
?>
<h2>Activ Voucher Codes</h2>
<table width="600px" cellpadding="0" cellspacing="0">
	<tr>
    	<th>Code</th>
        <th>Usable</th>
	</tr>
    <?php $i=0; while($vouch = mysqli_fetch_array($vqry)){?>
    <tr <?php if(is_int($i/2)){echo 'style="background-color: rgb(241, 241, 241);"';}?>>
        <td><?=$vouch['vkey']?></td>
        <td><?=dot3($vouch['vavi']-$vouch['vused'])?></td>
	    <?php if($_SESSION['user_rank'] >= 3){ ?>
	    <td><form method="post" action=""><input value="Deactivate Voucher" type="submit" name="deactivate_voucher"><input type="hidden" readonly name="id_voucher" value="<?=$vouch['autoID']?>>"></form></td>
		<?php ;} ?>
        <td><?=base64_decode($vouch['vpro'])?></td>
	</tr>
    <?php $i++ ;} ?>
</table>
<?php } else { echo $denied;} ?>