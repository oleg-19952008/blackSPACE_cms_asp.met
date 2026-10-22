<?php


class Subpage
{
	static $data = array(
		'message'		=> 'You can manage your users here.',
		'navigation'	=> array(),
		'edit_nav'		=> array());

	static function Build()
	{
		//Check for Admin
		if(User::$isAdmin == FALSE)
		{
			redirect();
		}

		//Delete navigation link
		if(isset($_GET['delete']) && is_numeric($_GET['delete']))
		{
			$id = $_GET['delete'];
			DB::query("DELETE FROM news WHERE nID = '$id' LIMIT 1");
			DB::query("UPDATE news SET nID = id - 1 WHERE nID > $id");
			redirect('acp=navigation');
		}

		//Add navigation link
		if(isset($_POST['add']))
		{
			// $new_id = $_POST['after'] + 1;
			$display = $_POST['newsid'];
			$img = $_POST['img'];
			$icon = $_POST['icon'];
			$head = $_POST['head'];

			$content = urlencode($_POST['contentEditor']);
			//DB::query();
			// DB::query("UPDATE news SET `nID` = `nID` + 1 WHERE `nID` >= $new_id ORDER BY nID DESC") or die(mysqli_error());
			DB::query("INSERT INTO news SET newsID = '$display', image = '$img', icon = '$icon', headline = '$head', text ='$content'");
		}

		//Edit navigation links
		if(isset($_GET['id']) && is_numeric($_GET['id']))
		{
			DB::select('news', 'nID = \''.$_GET['id'].'\'');

			if(DB::num_rows() > 0)
			{
				self::$data['edit_nav'] = DB::fetch_row();
			}
			
			else $_GET['id'] = 'text';

			if(isset($_POST['edit']))
			{
				self::edit_link();
			}
		}

		//Get the navigation
		DB::query("SELECT * FROM navigation ORDER BY id ASC");

		if(DB::num_rows() > 0)
		{
			self::$data['navigation'] = DB::fetch_array();
		}

		Load::view('navigation', self::$data, TRUE);
	}
	
	static function edit_link()
	{
		$id = $_GET['id'];
		$name = DB::safe($_POST['headline']);
		$link = DB::safe($_POST['text']);                
		$loggedin = $_POST['loggedin'];
                $content = urlencode($_POST['contentEditor']);
                
		if((self::$data['edit_nav']['nID'] - 1) != $_POST['after'])
		{
			$new_id = $_POST['after'];
			$larger_id = $new_id;
			$smaller_id = $id;
			$order = 'ASC';
			$sign = '-';

			if((self::$data['edit_nav']['nID'] - 1) > $_POST['after'])
			{
				$new_id++;
				$sign = '+';
				$order = 'DESC';
				$smaller_id = $new_id;
				$larger_id = $id;
			}

			$id = $new_id;
			DB::query("DELETE FROM news WHERE nID = '$id' LIMIT 1");
			// DB::query("UPDATE news SET `id` = `id` $sign 1 WHERE `id` >= '$smaller_id' AND `id` <= '$larger_id' ORDER BY id $order");
			DB::query("INSERT INTO news SET newsID = '$display', image = '$img', icon = '$icon', headline = '$head', text ='$content'");
		}

		else
		{
			DB::query("UPDATE news SET newsID = '$display', image = '$img', icon = '$icon', headline = '$head', text ='$content' WHERE id = '$id' LIMIT 1");
		}

		redirect('acp=navigation&id=' . $id);
		die();
	}


	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}