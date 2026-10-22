<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

<?php if(isset($_GET['id']) && is_numeric($_GET['id'])): ?>
	<div class="block">

		<div class="block_head">
			<div class="bheadl"></div>
			<div class="bheadr"></div>

			<h2>Edit User: <?php echo $user['Name']; ?></h2>
		</div>		<!-- .block_head ends -->


		<div class="block_content">
			<br />
			<b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>
			<br /><br />
			<form method="post" action="?acp=logs&id=<?php echo $user['ID']; ?>">
                                <?php 
                                ?>
				<p>
					<label>Username:</label><br />
					<input type="text" class="text medium" name="name" value="<?php echo $user['Name']; ?>"/> 
					<span class="note"></span>
				</p>
				<p>
					<label>Player ID:</label><br />
                                        <input type="text" class="text medium" name="playerID" readonly value="<?php echo $user['playerID']; ?>"/> 
					<span class="note"></span>
				</p>
				
                                <p>
					<label>Logbook:</label><br />
                                        <textarea class="text medium" name="accountnote" ><?php echo $user['accountnote']; ?></textarea>
					<span class="note"></span>
				</p>
				<br /><br />

				
				
				<p>
					<input type="submit" name="edit" class="submit small" value="Save" />
				</p>
			</form>
		</div>		<!-- .block_content ends -->

		<div class="bendl"></div>
		<div class="bendr"></div>

	</div>
<?php else: ?>
<div class="block">

	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
		
		<h2>Search for User</h2>
	</div>		<!-- .block_head ends -->

	<div class="block_content">
		<form method="get" action="?acp=logs">
			<?php if($message == 'You can manage your users here.'): ?>
				<div class="message info"><p><?php echo $message; ?></p></div>
			<?php elseif($message == 'Settings saved successfully'): ?>
				<div class="message success"><p><?php echo $message; ?></p></div>
			<?php else: ?>
				<div class="message errormsg"><p><?php echo $message; ?></p></div>
			<?php endif; ?>

			<p>
				<input type="hidden" name="acp" value="logs">
				<label>Search for User where:</label>
				<select class="styled" name="type">
				 <option value="donations" <?php if($type == 'donations"') echo 'selected="selected"'; ?>>Donations</option>
					<option value="credits" <?php if($type == 'credits') echo 'selected="selected"'; ?>>Credits</option>
					<option value="uridium" <?php if($type == 'uridium') echo 'selected="selected"'; ?>>Uridium</option>
					<option value="logins" <?php if($type == 'logins') echo 'selected="selected"'; ?>>Logins</option>
                                        <option value="site" <?php if($type == 'site') echo 'selected="selected"'; ?>>Site</option>                                        
                                        <option value="auction" <?php if($type == 'auction') echo 'selected="selected"'; ?>>auction</option>
                                        <option value="user" <?php if($type == 'user"') echo 'selected="selected"'; ?>>Users Log</option>
				</select></p>

			<p>
				<label>is:</label> <br />
				<input type="text" name="search" class="text medium error" value="<?php echo $search; ?>"/>
			</p>
			<br />

			<p>
				<input type="submit" class="submit small" value="Search" />
			</p>
		</form>	
	</div>		<!-- .block_content ends -->
	
	<div class="bendl"></div>
	<div class="bendr"></div>
		
</div>		<!-- .block ends -->

<?php if($search != ''): ?>
	<div class="block">

		<div class="block_head">
			<div class="bheadl"></div>
			<div class="bheadr"></div>

			<h2>Results</h2>
		</div>		<!-- .block_head ends -->


		<div class="block_content">
			<?php if(count($results) == 0): ?>
				<div class="message errormsg"><p>Could not find any results</p></div>
			<?php else: ?>
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<th>Log</th>
						<th>Time</th>
					</tr>

				<?php foreach($results as $r): 
                                    if($_GET['type']=="user"){
                                        ?>
                                         <tr>
						<td><?php echo $r['descrip']; ?></td>
						<td><?php echo $r['addDate']; ?></td>
					</tr>
                                        <?php
                                    }elseif($_GET['type']=="equipment"){
                                       
                                    }else{
                                        ?>
                                        <tr>
						<td><?php echo $r['descrip']; ?></td>
						<td><?php echo $r['offitime']; ?></td>
					</tr>
                                        <?php
                                    }
                                    ?>
					
				<?php endforeach; ?>

				</table>
			<?php endif; ?>
		</div>		<!-- .block_content ends -->

		<div class="bendl"></div>
		<div class="bendr"></div>

	</div>
<?php endif;?>
<?php endif; ?>	<!-- .block ends -->
		<!-- .leftcol ends -->