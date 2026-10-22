<?php
   $mysql = new mysqli('localhost', 'root', '', 'darkorbit') or die('Невозможно открыть базу');
   $sql = "SELECT * FROM `server_1_voucher`";
   $result = $mysql->query($sql); 
?>
   <html>
	<head>
		<title>Бонус коды</title>
	</head>
	<body>
		<table border="1" width="100%" height="100">
			<tr>
				<td bgcolor="#ADFF2F">Бонус код</td>
				<td bgcolor="#ADFF2F">Осталось</td>
				<td bgcolor="#ADFF2F">Активен</td>
			</tr>
			
			<?php while ($row = $result->fetch_assoc()){
				?>
				<tr>
					<td><?php echo $row['vkey'];?></td>
					<td><?php echo $row['vavi'] - $row['vused'];?></td>
			   <?php if ($row['vavi'] == $row['vused']){ ?>
					<td bgcolor="#FA8072">Не активен</td>
			   <?php }else { ?>
					<td bgcolor="#32CD32">Активен</td>
				</tr>
				<?php } } ?>
		</table>
	</body>
</html>

