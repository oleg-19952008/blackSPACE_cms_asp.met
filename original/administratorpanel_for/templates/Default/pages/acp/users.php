<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

<?php if(isset($_GET['id']) && is_numeric($_GET['id'])): ?>
	<div class="block">

		<div class="block_head">
			<div class="bheadl"></div>
			<div class="bheadr"></div>

			<h2>Редактировать пользователя: <?php echo $user['Name']; ?></h2>
		</div>		<!-- .block_head ends -->


		<div class="block_content">
			<br />
			<b style="color:<?php echo $color; ?>;font-size:120%;"><?php echo $message; ?></b>
			<br /><br />
			<form method="post" action="?acp=users&id=<?php echo $user['ID']; ?>">
                                <?php 
                                ?>
				<p>
					<label>Ник:</label><br />
					<input type="text" class="text medium" name="name" value="<?php echo $user['Name']; ?>"/> 
					<span class="note"></span>
					<select name="banned" class="styled" name="type">
                                                <option value="0" <?php if($user['banned'] == 0) echo 'selected="selected"'; ?>>Нет бана</option>
                                                <option value="1" <?php if($user['banned'] == 1) echo 'selected="selected"'; ?>>бан 1</option>
                                                <option value="2" <?php if($user['banned'] == 1) echo 'selected="selected"'; ?>>бан 2</option>
                                                <option value="3" <?php if($user['banned'] == 1) echo 'selected="selected"'; ?>>бан 3</option>
                                                <option value="4" <?php if($user['banned'] == 1) echo 'selected="selected"'; ?>>бан 4</option>
                                        </select>
				</p>				
                                <p>
					<label>User ID:</label><br />
                                        <input type="text" class="text medium" name="userID" readonly value="<?php echo $user['ID']; ?>"/> 
					<span class="note"></span>
				</p>
				<p>
					<label>Player ID:</label><br />
                                        <input type="text" class="text medium" name="playerID" readonly value="<?php echo $user['playerID']; ?>"/> 
					<span class="note"></span>
				</p>
				<p>
					<label>Email:</label><br />
					<input type="text" class="text medium" name="Email" value="<?php echo $user['Email']; ?>"/> 
					<span class="note"></span>
                                          <select name="VerifiedEmail" class="styled" name="type">
                                                <option value="0" <?php if($user['verified'] == 0) echo 'selected="selected"'; ?>>Not Email Verified</option>
                                                <option value="1" <?php if($user['verified'] == 1) echo 'selected="selected"'; ?>>Email Verified</option>
                                        </select></p>
				</p>
				<p>
					<label>Server Location:</label><br />
					<input type="text" class="text medium" name="Servers" Readonly value="<?php echo $user['Servers']; ?>"/> 
					<span class="note"></span>
				</p>
				<p>
                                        <label>Game Faction:</label>
                                        <select name="factionId" class="styled" name="type">
                                                <option value="1" <?php if($user['factionId'] == 1) echo 'selected="selected"'; ?>>MMO</option>
                                                <option value="2" <?php if($user['factionId'] == 2) echo 'selected="selected"'; ?>>EIC</option>
                                                <option value="3" <?php if($user['factionId'] == 3) echo 'selected="selected"'; ?>>VRU</option>
                                        </select></p>

                                <p>
				<p>
					<label>Premium:</label><br />
                                        <input type="text" class="text medium" name="premium" readonly value="<?php if(Subpage::cPT($user['premium'])): echo "Is Premium"; else: echo "Not Premium"; endif; ?>"/> 
                                        <span class="note"></span>
                                </p>
                                <?php if($user['Name']=="Seven & NavigatoR"):
                                    
                                
                                else: 
                                ?>
				<p>
					<label>Rank:</label><br />
                                        <input type="text" class="text small" name="rank" value="<?php echo $user['rank']; ?>"/> 
					<span class="note"><?php $isA = Subpage::getRank($user['rank']); echo $isA; ?></span>
				</p>     
                                <?php endif;?>
				<p>
					<label>Jackpot:</label><br />
                                        <input type="text" class="text medium" name="jackpot" readonly value="<?php echo $user['jackpot']; ?>"/> 
					<span class="note"></span>
				</p>
                                <p>
					<label>Honor:</label><br />
                                        <input type="text" class="text medium" name="honor"  value="<?php echo $user['honor']; ?>"/> 
					<span class="note"></span>
				</p>
                                <p>
					<label>Uridium:</label><br />
                                        <input type="text" class="text medium" name="uri" value="<?php echo $user['uri']; ?>"/> 
					<span class="note"></span>
				</p>
                                <p>
					<label>Credits:</label><br />
                                        <input type="text" class="text medium" name="credits" value="<?php echo $user['credits']; ?>"/> 
					<span class="note"></span>
				</p>
                                <p>
					<label>Spins for Galaxy Gate:</label><br />
                                        <input type="text" class="text medium" name="GGspins" value="<?php echo $user['GGspins']; ?>"/> 
					<span class="note"></span>
				</p>
                                
                                <p>
					<label>Admin account note:</label><br />
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
		<form method="get" action="?acp=users">
			<?php if($message == 'You can manage your users here.'): ?>
				<div class="message info"><p><?php echo $message; ?></p></div>
			<?php elseif($message == 'Settings saved successfully'): ?>
				<div class="message success"><p><?php echo $message; ?></p></div>
			<?php else: ?>
				<div class="message errormsg"><p><?php echo $message; ?></p></div>
			<?php endif; ?>

			<p>
				<input type="hidden" name="acp" value="users">
				<label>Search for User where:</label>
				<select class="styled" name="type">
					<option value="name" <?php if($type == 'name') echo 'selected="selected"'; ?>>Username</option>
					<option value="email" <?php if($type == 'email') echo 'selected="selected"'; ?>>Email</option>
                                        <option value="playerID" <?php if($type == 'playerID') echo 'selected="selected"'; ?>>Player ID</option>
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
						<th>Username</th>
						<th>Email</th>
					</tr>

				<?php foreach($results as $r): ?>
					<tr>
						<td><a href="?acp=users&id=<?php echo $r['ID']; ?>"><?php echo $r['Name']; ?></a></td>
						<td><?php echo $r['Email']; ?></td>
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