<?php include_once 'menu.php';?>
	
	<p class="user">Hello, <a href="?ucp"><?php echo User::$username; ?></a> | <a href="?logout">Logout</a></p>
</div>		<!-- #header ends -->

<div class="block">

	<div class="block_head">
		<div class="bheadl"></div>
		<div class="bheadr"></div>
		
		<h2>Main Settings</h2>
	</div>		<!-- .block_head ends -->
	
	
	
	<div class="block_content">
		<form method="post" action="?acp">
			<?php if($message == 'You can edit your site\'s settings here.'): ?>
				<div class="message info"><p><?php echo $message; ?></p></div>
			<?php elseif($message == 'Settings saved successfully'): ?>
				<div class="message success"><p><?php echo $message; ?></p></div>
			<?php else: ?>
				<div class="message errormsg"><p><?php echo $message; ?></p></div>
			<?php endif; ?>
			
			<h2>Main Settings</h2>
			
		</form>
	
<!--	<div class="message errormsg"><p>An error message goes here</p></div>
		
		<div class="message success"><p>A success message goes here</p></div>
		
		<div class="message info"><p>An informative message goes here</p></div>
		
		<div class="message warning"><p>A warning message goes here</p></div>
		
		
		<form action="" method="post">
			<p>
				<label>Small input label:</label><br />
				<input type="text" class="text small" /> 
				<span class="note">*A note</span>
			</p>
			
			<p>
				<label>Medium input label:</label><br />
				<input type="text" class="text medium error" /> 
				<span class="note error">Error!</span>
			</p>
			
			<p>
				<label>Big input label:</label><br />
				<input type="text" class="text big" />
			</p>
			
			<p>
				<label>Textarea label:</label><br />
				<textarea class="wysiwyg"></textarea>
			</p>
			
			<p>
				<label>Starting date:</label> 
				<input type="text" class="text date_picker" />
				&nbsp;&nbsp;
				<label>Ending date:</label> 
				<input type="text" class="text date_picker" />
			</p>
			
			
			<p><label>Select label:</label> <br />
			
				<select class="styled">
					<optgroup label="Group 1">
						<option>Option one</option>
						<option>Option two</option>
						<option>Option three</option>
					</optgroup>
					
					<optgroup label="Group 2">
						<option>Option one</option>
						<option>Option two</option>
						<option>Option three</option>
					</optgroup>
					
					<optgroup label="Group 3">
						<option>Option one</option>
						<option>Option two</option>
						<option>Option three</option>
					</optgroup>							
				</select></p>
			
									
			<p class="fileupload">
				<label>File input label:</label><br />
				<input type="file" id="fileupload" />
				<span id="uploadmsg">Max size 3Mb</span>
			</p>
															
			<p>
				<input type="checkbox" class="checkbox" checked="checked" id="cbdemo1" /> <label for="cbdemo1">Checkbox label</label> 
				<input type="checkbox" class="checkbox" id="cbdemo2" /> <label for="cbdemo2">Checkbox label</label>
			</p>
			
			<p><input type="radio" checked="checked" class="radio" /> <label>Radio button label</label></p>
									
			<hr />
			
			<p>
				<input type="submit" class="submit small" value="Submit" />
				<input type="submit" class="submit mid" value="Long submit" />
				<input type="submit" class="submit long" value="Even longer submit" />
			</p>
		</form>-->
		
		
	</div>		<!-- .block_content ends -->
	
	<div class="bendl"></div>
	<div class="bendr"></div>
		
</div>		<!-- .block ends -->
		<!-- .leftcol ends -->