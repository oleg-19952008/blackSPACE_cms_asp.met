<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

	<div class="block">

		<div class="block_head">
			<div class="bheadl"></div>
			<div class="bheadr"></div>

			<h2>Add articel</h2>
		</div>		<!-- .block_head ends -->


		<div class="block_content">
			<br />
			<b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>
			<br /><br />
			<form method="post" action="?acp=write">

				<p>
					<label>Title:</label><br />
					<input type="text" class="text medium" name="title" />
                                        
				</p>
				<p>
					<label>Author:</label><br />
					<input type="text" readonly class="text medium" name="author"  value="<?php echo User::$username; ?>"/>
                                        
				</p> 
				<p><label>Category:</label> <br />
                                    
					<select name="category" class="styled">
			<?php foreach($categories as $c): ?>
				<option value="<?php echo $c['id']; ?>">
								<?php echo $c['name']; ?>
							</option>
			<?php endforeach; ?>
                                
				</select></p
				<p>
					<label>Details:</label><br />
					<textarea name="details"></textarea>
				</p>
				
				<p>
					<input type="submit" name="add" class="submit small" value="Add" />
				</p>
			</form>
		</div>		<!-- .block_content ends -->

		<div class="bendl"></div>
		<div class="bendr"></div>

	</div>
