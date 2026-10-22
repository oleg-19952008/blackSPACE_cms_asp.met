	<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

<?php if(isset($_GET['read']) && is_numeric($_GET['read'])): ?>
<div class="block">

	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
		
		<h2>Read Message</h2>
	</div>		<!-- .block_head ends -->

	<div class="block_content">
		<form method="post" action="?acp=categories">

			<p>
				<label>Name:</label> <?php echo $message['name']; ?>
			</p>

			<p>
				<label>Email:</label> <a href="mailto:<?php echo $message['email']; ?>"><?php echo $message['email']; ?></a>
			</p>
			
			<p>
				<label>Message:</label>
			</p>
			<?php echo $message['message']; ?>
		</form>
	</div>		<!-- .block_content ends -->
	
	<div class="bendl"></div>
	<div class="bendr"></div>
		
</div><!-- .block ends -->
<?php endif; ?>

<div class="block">

	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>

		<h2>Messages</h2>
	</div>		<!-- .block_head ends -->


	<div class="block_content">
		<?php if(count($messages) == 0): ?>
			<div class="message errormsg"><p>You have no new messages</p></div>
		<?php else: ?>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<th>From</th>
					<th>Email</th>
					<th>Read</th>
					<th>Delete</th>
				</tr>

			<?php foreach($messages as $m): ?>
				<tr>
					<td><?php echo $m['name']; ?></td>
					<td><?php echo $m['email']; ?></td>
					<td><a href="?acp=messages&read=<?php echo $m['id']; ?>">Read</a></td>
					<td><a href="?acp=messages&id=<?php echo $m['id']; ?>">Delete</a></td>
				</tr>
			<?php endforeach; ?>

			</table>
		<?php endif; ?>
	</div>		<!-- .block_content ends -->

	<div class="bendl"></div>
	<div class="bendr"></div>

</div><!-- .block ends -->
		<!-- .leftcol ends -->