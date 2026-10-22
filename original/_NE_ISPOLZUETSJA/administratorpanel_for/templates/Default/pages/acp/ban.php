<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

	<div class="block">

		<div class="block_head">
			<div class="bheadl"></div>
			<div class="bheadr"></div>

			<h2>Въебать бан</h2>
		</div>		<!-- .block_head ends -->
	<p style="width:200px; margin-left:75px; float:left;">-25% кредитов<br>-25% Уридиума<br>-25% Чести<br>-10% Опыта</p>
	<p style="width:200px; margin-left:25px; float:left;">-35% Кредитов<br>-35% Уридиума<br>-35% Чести<br>-25% Опыта<br>24 Часа бан</p>
	<p style="width:150px; margin-left:30px; float:left;">-50% Кредитов<br>-50% Уридиума<br>-50% Чести<br>-40% Опыта<br>7 Дней бан</p>
	<p style="width:200px; margin-left:85px; float:left;">Перманент бан</p>

		<div class="block_content">
			<br />
			<b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>
			<br /><br />


			<form method="post" action="?acp=ban">

				<p>
					<label>ID:</label><br />
					<input type="text" class="text medium" name="uID" />
                                        
				</p>
				<p>
					<label>Номер бана:</label><br />
					<input type="text" class="text medium" name="nBan" />
                                        
				</p> 
					<input type="submit" name="add" class="submit small" value="Add" />
				
			</form>
		</div>		<!-- .block_content ends -->

		<div class="bendl"></div>
		<div class="bendr"></div>

	</div>
