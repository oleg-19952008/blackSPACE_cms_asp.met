<?php
class Subpage
{
	static $data = array
	(
		'message'	 => 'You can manage your articels here.',
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

		if(isset($_GET['id']) && is_numeric($_GET['id']))
		{
			DB::query("SELECT * FROM articels WHERE id = '{$_GET['id']}' LIMIT 1");

			if(DB::num_rows() > 0)
			{
				self::$data['user'] = DB::fetch_row();

				if(isset($_POST['edit']))
				{
					self::edit_user();
				}
			}

			else
			{
				$_GET['id'] = 'text';
			}
		}

		elseif(isset($_GET['type']) && isset($_GET['search']))
		{
			self::$data['type'] = $_GET['type'];
			self::$data['search'] = $_GET['search'];
			self::search();
		}

		Load::view('articel', self::$data, TRUE);
	}

	static function search()
	{
		$search = $_GET['search'];
		$type	= $_GET['type'];

		DB::query("SELECT * FROM articels WHERE $type LIKE '%$search%'");

		if(DB::num_rows() > 0)
		{
			self::$data['results'] = DB::fetch_array();
		}
	}

	static function edit_user()
	{
		self::$data['color'] = 'red';

		$id = $_GET['id'];
		$q	= "UPDATE articels SET ";
		$i	= 0;

		foreach($_POST as $k => $v)
		{
			$i++;

			if($i != count($_POST))
			{
				if($k == 'username')
				{
					if($v != self::$data['user']['username'])
					{
						$v = DB::safe($v);

						if(User::$username == self::$data['user']['username'])
						{
							$new_pass = md5($v . $_SESSION['password']);
							$q .= "`password` = '$new_pass', ";
							$_SESSION['username'] = $v;
						}

						else
						{
							$v = self::$data['user']['username'];
							self::$data['message'] = 'You cannot edit someone else\'s articel.';
							return;
						} 
					}
				}

                                $v = addslashes($v);
				$q .= "`$k` = '$v'";
				$q .= ((count($_POST) - 1) == $i) ? ' ' : ', ';
			}
		}

		self::$data['color'] = 'green';
		self::$data['message'] = 'Articel saved successfully';
		$q .= "WHERE id = '$id' LIMIT 1";
		DB::query($q);

		//Now, we need to update the info
		DB::query("SELECT * FROM articels WHERE id = '".$_GET['id']."' LIMIT 1");
		self::$data['user'] = DB::fetch_row();
	}


	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}