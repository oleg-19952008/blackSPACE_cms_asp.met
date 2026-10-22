<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

<?php if(isset($_GET['id']) && is_numeric($_GET['id'])): ?>
	<div class="block">

		<div class="block_head">
			<div class="bheadl"></div>
			<div class="bheadr"></div>

			<h2>Edit articel `<?php echo $user['title']; ?>`</h2>
		</div>		<!-- .block_head ends -->


		<div class="block_content">
			<br />
			<b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>
			<br /><br />
			<form method="post" action="?acp=articel&id=<?php echo $user['id']; ?>">
				<p>
					<label>Author:</label><br />
					<input type="text" class="text medium" name="author" readonly value="<?php echo $user['author']; ?>"/> 
					<span class="note"></span>
				</p>

				<p>
					<label>Title:</label><br />
					<input type="text" class="text medium" name="title" value="<?php echo $user['title']; ?>"/> 
				</p>
				
				<p><label>Category:</label> <br />

					<select name="category" class="styled">
						<?php foreach(categories() as $c): ?>
							<option value="<?php echo $c['id']; ?>" <?php if($c['id'] == $user['category']) echo 'selected=\'selected\''; ?>>
								<?php echo $c['name']; ?>
							</option>
						<?php endforeach; ?>
					</select></p
				<p>
					<label>Details:</label><br />
					<textarea name="details"><?php echo $user['details']; ?></textarea>
				</p>
				
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
		
		<h2>Search for Articel</h2>
	</div>		<!-- .block_head ends -->

	<div class="block_content">
		<form method="get" action="?acp=articel">
			<?php if($message == 'You can manage your articels here.'): ?>
				<div class="message info"><p><?php echo $message; ?></p></div>
			<?php elseif($message == 'Articel saved successfully'): ?>
				<div class="message success"><p><?php echo $message; ?></p></div>
			<?php else: ?>
				<div class="message errormsg"><p><?php echo $message; ?></p></div>
			<?php endif; ?>

			<p>
				<input type="hidden" name="acp" value="articel">
				<label>Search for articel where:</label>
				<select class="styled" name="type">
					<option value="author" <?php if($type == 'username') echo 'selected="selected"'; ?>>Author</option>
                                        <option value="title" <?php if($type == 'title') echo 'selected="selected"'; ?>>Articel title</option>
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
						<th>Title</th>
						<th>author</th>
						<th>Details</th>
                                                <th>Category</th>
					</tr>

				<?php foreach($results as $r): ?>
					<tr>
						<td><a href="?acp=articel&id=<?php echo $r['id']; ?>"><?php echo $r['title']; ?></a></td>
						<td><?php echo $r['author']; ?></td>
						<td><?php echo $r['details']; ?></td>
                                                <td><?php echo $r['category']; ?></td>
					</tr>
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