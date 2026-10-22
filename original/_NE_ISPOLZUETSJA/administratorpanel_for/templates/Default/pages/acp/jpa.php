<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

	<div class="block">

		<div class="block_head">
			<div class="bheadl"></div>
			<div class="bheadr"></div>

			<h2>Перенести игрока</h2>
		</div>		<!-- .block_head ends -->
	<p style="width:200px; margin-left:75px; float:left;">16 = 4-4<br>42 = ???</p>

		<div class="block_content">
			<br />
			<b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>
			<br /><br />


			<form method="post" action="?acp=jpa">

				<p>
					<label>ID игрока:</label><br />
					<input type="text" class="text medium" name="uID" />
                                        
				</p>
				<p>
					<label>ID карты:</label><br />
					<input type="text" class="text medium" name="mID" />
                                        
				</p> 
					<input type="submit" name="add" class="submit small" value="Add" />
				
			</form>
		</div>		<!-- .block_content ends -->

		<div class="bendl"></div>
		<div class="bendr"></div>

	</div>
