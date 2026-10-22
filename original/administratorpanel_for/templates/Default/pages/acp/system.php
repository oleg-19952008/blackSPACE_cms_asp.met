<?php include_once 'menu.php';




?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

	<div class="block" >

		<div class="block_head" >
			<div class="bheadl"></div>
			<div class="bheadr" ></div>

			<h2 style="color:red; ">Управление сервером</h2>
		</div>
		<div style="background-color: black;color: lime;width:100%; height:100px;">
			<p style="width:200px; margin-left:75px; float:left;">Регистрация<br>ВКЛ\ВЫКЛ</p> 
			<p style="width:200px; margin-left:25px; float:left;">Happy Hour<br>ВКЛ\ВЫКЛ</p> 
			<p style="width:150px; margin-left:30px; float:left;">Эмулятор<br>Статус</p>  
		</div>
		<form method="post" action="?acp=system">
				<p>
					<input type="submit" name="add" class="submit small" value="reg" />
					<input type="submit" name="add" class="submit small" value="hh" />
				 
				</p> 
					
				
		</form>
	
		<div class="block_content">
			<br />
			<b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>
		</div>		<!-- .block_content ends -->

		<div class="bendl"></div>
		<div class="bendr"></div>

	</div>
