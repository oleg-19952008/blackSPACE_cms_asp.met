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
                    if(isset($_GET['type'])){
                        DB::query("SELECT * FROM pmc_log WHERE playerID = '{$_GET['id']}' && location='{$_GET['type']}'");
                    }else{
			DB::query("SELECT * FROM pmc_log WHERE playerID = '{$_GET['id']}'");
                    }
                    
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

		Load::view('logs', self::$data, TRUE);
	}

	static function search()
	{
		$search = $_GET['search'];
		$type	= $_GET['type'];
                if(isset($_GET['type'])){
                    if($_GET['type']=="user"){
                        DB::query("SELECT * FROM server_1_log WHERE playerID = '{$_GET['search']}' ORDER BY addDate DESC");
                    }else{
                        DB::query("SELECT * FROM pmc_log WHERE playerID = '{$_GET['search']}' && location='{$_GET['type']}' ORDER BY offitime DESC");
                    }
                }else{
			DB::query("SELECT * FROM pmc_log WHERE playerID = '{$_GET['search']}' ORDER BY offitime DESC");
                }
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
        
        static function getType($id){
            $q = "SELECT * FROM server_1_player_all_items INNER JOIN server_shop_items ON server_1_player_all_items.lootid = server_shop_items.lootid WHERE server_1_player_all_items.id = '$id' ORDER BY server_1_player_all_items.lootid DESC";
            DB::query($q);
            if(DB::num_rows() > 0)
            {
                    return DB::fetch_array();
            }
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