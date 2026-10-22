<?php 
	if(isset($_POST['nf'])){
		$rand = md5(date(Ymdhis).rand(54654,9999999)).$_FILES['up_file']['name'];
		move_uploaded_file($_FILES['up_file']['tmp_name'], '/files/'.$rand.'');
		echo $rand.'<br>';
		print_r ( $_FILES );
	}
?>
<h3>Create News</h3>

<center>
<form method="post" action="" enctype="multipart/form-data">
<textarea style="resize:none; width:600px; height:200px;" name="descrip" placeholder="Enter your News here"></textarea></br>
<input type="file" name="up_file"></br><br>
<input type="submit" class="button" name="nf" value="Post">
</form>
</center>