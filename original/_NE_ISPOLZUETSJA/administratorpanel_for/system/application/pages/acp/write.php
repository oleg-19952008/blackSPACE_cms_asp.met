<?php
class Subpage
{
	static $data = array
	(
		'message'	 => 'You can add your articels here.',
		'color'		 => 'green',
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
			$username = $_POST['author'];
			$title = addslashes($_POST['title']);
			$category = $_POST['category'];
                        $details = addslashes($_POST['details']);
			//DB::query();
			 $insert = DB::query("INSERT INTO articels SET author = '$username', title = '$title', details = '$details', category = '$category'");
                        if($insert){
                            self::message("Your articel is addet", 'green');
                        }
		}

                self::$data['categories'] = array();
		DB::query("SELECT * FROM categories");
		
		if(DB::num_rows() > 0)
		{
			self::$data['categories'] = DB::fetch_array();
		}

		

		Load::view('write', self::$data, TRUE);
	}

	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}