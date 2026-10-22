<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

<div class="block">

	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
		
		<h2>Add Category</h2>
	</div>		<!-- .block_head ends -->

	<div class="block_content">
		<form method="post" action="?acp=categories">

			<p>
				<label>Name:</label><br />
				<input type="text" name="name" class="text medium error" value=""/>
			</p>

			<p>
				<input type="submit" class="submit small" name="add" value="Add" />
			</p>
		</form>
	</div>		<!-- .block_content ends -->
	
	<div class="bendl"></div>
	<div class="bendr"></div>
		
</div>
		<!-- .block ends -->

<div class="block">

	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>

		<h2>Delete Navigation</h2>
	</div>		<!-- .block_head ends -->


	<div class="block_content">
		<?php if(count($categories) == 0): ?>
			<div class="message errormsg"><p>Could not find any results</p></div>
		<?php else: ?>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<th>Name</th>
					<th>Action</th>
				</tr>

			<?php foreach($categories as $c): ?>
				<tr>
					<td><?php echo $c['name']; ?></td>
					<td><a href="?acp=categories&id=<?php echo $c['id']; ?>">Delete</a></td>
				</tr>
			<?php endforeach; ?>

			</table>
		<?php endif; ?>
	</div>		<!-- .block_content ends -->

	<div class="bendl"></div>
	<div class="bendr"></div>

</div><!-- .block ends -->
		<!-- .leftcol ends -->