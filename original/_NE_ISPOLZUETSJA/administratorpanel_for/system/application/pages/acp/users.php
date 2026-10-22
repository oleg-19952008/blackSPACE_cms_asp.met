<?php


class Subpage
{
	static $data = array
	(
		'message'	 => 'You can manage your users here.',
		'color'		 => 'green',
		'user'		 => array(),
		'type'		 => 'username',
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
			DB::query("SELECT * FROM users INNER JOIN server_1_players ON users.ID=server_1_players.userID WHERE users.ID = '{$_GET['id']}' LIMIT 1");
                        
			if(DB::num_rows() > 0)
			{
				self::$data['user'] = DB::fetch_row();

				if(isset($_POST['edit']))
				{
					self::edit_user();
				}
                                 self::$data['message'] = "You're editing " .self::$data['user']['Name'];
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

		Load::view('users', self::$data, TRUE);
	}

	static function search()
	{
		$search = $_GET['search'];
		$type	= $_GET['type'];
                if($type=="playerID"):
                        DB::query("SELECT * FROM server_1_players INNER JOIN users ON server_1_players.userID=users.ID WHERE server_1_players.playerID='$search'");
                    else:
                        DB::query("SELECT * FROM users INNER JOIN server_1_players ON users.ID=server_1_players.userID WHERE $type LIKE '%$search%'");
                endif;
		if(DB::num_rows() > 0)
		{
			self::$data['results'] = DB::fetch_array();
		}
	}
        static function getRank($rank){
            DB::select('rank', ' id = '.$rank.'');
            if(DB::num_rows() > 0)
            {
                $re = DB::fetch_row();
                return $re['name'];
            }
		return "unknown";	
        }
	static function edit_user()
	{
		
		self::$data['color'] = 'red';

		$id = $_GET['id'];
                if($_POST['factionId']=="Is Premium"):
                        $pre=1;
                    else:
                        $pre = 0;
                endif;
		$q	= "UPDATE server_1_players SET ";
		$q .= "`factionId`='".DB::safe($_POST['factionId'])."', `jackpot` = '".DB::safe($_POST['jackpot'])."', `honor` = '".DB::safe($_POST['honor'])."', `uri` = '".DB::safe($_POST['uri'])."', `credits` = '".DB::safe($_POST['credits'])."', `GGspins` = '".DB::safe($_POST['GGspins'])."' ";

		self::$data['color'] = 'green';
		self::$data['message'] = 'Successfully saved settings';
		$q .= " WHERE `playerID` = ".trim(DB::safe($_POST['playerID']))." LIMIT 1";
                DB::query($q);
                $qe = "UPDATE users SET verified='".DB::safe($_POST['VerifiedEmail'])."', banned='".DB::safe($_POST['banned'])."', accountnote='".DB::safe($_POST['accountnote'])."' WHERE ID='".DB::safe($_GET['id'])."'";
                DB::query($qe);
		//Now, we need to update the info
                DB::query("SELECT * FROM users INNER JOIN server_1_players ON users.ID=server_1_players.userID WHERE users.ID= '".DB::safe($_GET['id'])."' LIMIT 1");
//		DB::query("SELECT * FROM users WHERE id = '".$_GET['id']."' LIMIT 1");
		self::$data['user'] = DB::fetch_row();
		
		$file = 'acpuse.php';
		// Open the file to get existing content
		// $current = file_get_contents($file);
		// Append a new person to the file
		// $current .= "\n".$_SESSION['username']." edited:".$id." on page ?acp=users";
		// Write the contents back to the file
		// file_put_contents($file, $current);
	}

        static function cPT($timestamp) {
            if (time() < strtotime($timestamp)) {
                return TRUE; // Still premium
            } else {
                return FALSE; // Not premium
            }
        }
	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}