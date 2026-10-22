<?php
class Subpage
{
	static $data = array
	(
		'message'	 => 'Перенести игрока на другую карту!',
		'color'		 => 'blue',
		'user'		 => array(),
		'type'		 => 'title',
		'search'	 => '',
		'results'		 => array(),
	);

	static function Build()
	{
		if(User::$isAdmin == FALSE)
		{
			redirect();
		}
                if(isset($_POST['add']))
		{
			$id = $_POST['uID'];
			$map = $_POST['mID'];


			$update =  DB::query("UPDATE server_1_players SET mapId = ".$map." WHERE userID = '".$id."'");
			 self::message("перенес!", 'green');
		
		}
			
			
                 
		
		

		Load::view('jpa', self::$data, TRUE);
	}

	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}