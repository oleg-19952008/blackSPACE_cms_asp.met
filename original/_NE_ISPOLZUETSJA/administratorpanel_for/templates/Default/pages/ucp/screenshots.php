<h3 class="no_ind">Upload  <span>images</span></h3>
<div id="middlebtopa">
<small>
<span style="font-size: 12px; font-family:Verdana;">


 <div class="menu_block">
        	<div class="container">
                <nav>
                    <ul class="sf-menu">
                        
                        <li><a href="?ucp" id="leftmostitem">Main edit</a></li>
            <li><a href="?edit=screenshots">Upload images</a></li>

                    </ul>
                    <div class="clear"></div>
                </nav>
            </div>
        </div>
<br style="clear: left" />
<br />

		<div id="boxy">
		<ul>	
		<li>Maximum file size is 400kb.</li><br />
		<li>You can add a maximum of 10 images (Meaning you have <?php echo 10 - $screenshot_count; ?> screenshots left).</li><br />
		<li>Uploading any kind of adult/pornographic images will get you banned and then reported to your ISP (Internet supplier).</li><br />
		</ul>
		</div>
		<br /><br />

<form method="post" action="?edit=screenshots">
	<table>
		<tr>
			<td>Link:</td>
			<td><input type="text" name="image" size="40"></td>
		</tr>
		<tr>
			<td></td>
			<td><input name="submit" type="submit" value="Add image"></td>
		</tr>
	</table> 
</form><br />
<?php if($screenshot_count == 0): ?>
	This user has not uploaded any images.
<?php else: ?>
	<h1>Your Screenshots:</h1>
	
	<table>
	<?php foreach($screenshots as $s): ?>
		<tr>
			<td><img src="<?php echo $s['link']; ?>"></td>
			<td style="padding-left:10px;"><a href="?edit=screenshots&remove=<?php echo $s['id'];?>"><b>Remove</b></a></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</span>
</small>
</div>

<div style="padding-left: 12px; padding-top: 12px;">

</div>