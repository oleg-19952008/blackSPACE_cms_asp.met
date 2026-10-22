<?php


if(!defined('IN_TOPSITE')) die();

class User extends DB
{
	static $isLoggedin  = FALSE;
	static $isMember		= FALSE;
	static $isAdmin		= FALSE;

	static $id			= 0;
	static $username 	= '';
        static $Full_name 	= '';
	static $password	= '';
	static $email		= '';
	static $ip			= '127.0.0.1';
	static $title		= '';
	static $url			= 'http://';
	static $category	= '1';
	static $description	= '';
	static $details		= '';
	static $banner		= 'http://';

	static $in			= 0;
	static $out			= 0;
	static $intotal		= 0;
	static $outtotal	= 0;
	
	function Build()
	{
		if(isset($_GET['logout']))
		{
			$_SESSION['isLoggedin'] = FALSE;
		}

		if(isset($_SESSION['isLoggedin']))
		{
			if($_SESSION['isLoggedin'] === TRUE)
			{
				if(isset($_SESSION['username']) && isset($_SESSION['password']))
				{
					$username = $_SESSION['username'];
					$password = $_SESSION['password'];

					self::login($username, $password);
				}
			}
		}
	}
	
	static function register($username, $password)
	{
		DB::query("SELECT id FROM users WHERE username = '$username' LIMIT 1");
		
		if(DB::num_rows() < 1)
		{
			$encrypted = md5($username . $password);
			$ip = (getenv('HTTP_X_FORWARDED_FOR')) ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR');
			
			DB::query("INSERT INTO users SET username = '$username', password = '$encrypted', ip = '$ip'");
			self::login($username, $password);
			return true;
		}
		
		return false;
	}
	
        static function decrypt($ciphertext) {
            $ciphertext = base64_decode($ciphertext);
            $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
            if (strlen($ciphertext) < $ivSize) {
                throw new Exception('Missing initialization vector');
            }

            $iv = substr($ciphertext, 0, $ivSize);
            $ciphertext = substr($ciphertext, $ivSize);
            $plaintext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, '5eqD0fpzf9JzaKWP', $ciphertext, MCRYPT_MODE_ECB, $iv);
            return rtrim($plaintext, "\0");
        }
    
	static function login($username, $password, $encrypt = TRUE)
	{
		if(!empty($username) && !empty($password))
		{
//			$encrypted = ($encrypt == TRUE) ? md5($password) : $password;
//			DB::select('users', "name = '$username' AND pwHash = '$encrypted'", '1', 'INNER JOIN server_1_players ON users.ID=server_1_players.userID');
                        
                        $encrypted = ($encrypt == TRUE) ? md5($password) : $password;
			DB::select('users', "name = '$username'", '1', 'INNER JOIN server_1_players ON users.ID=server_1_players.userID');
                        
			if(DB::num_rows() > 0)
			{
				$user = DB::fetch_row();
				foreach($user as $k => $v)
				{
					if(isset(self::$$k))
					{
						self::$$k = $v;
					}
					
					if($k = 'password')
					{
						continue;
					}
                                        
					$$k = $v;
				}
                                if(self::decrypt($user['pwHash'])===$password){
                                     self::$isLoggedin = TRUE;
                                     self::$ip		  = $_SERVER['REMOTE_ADDR'];

                                     if($user['rank']==21)
                                     {
                                         User::$isAdmin = TRUE;
                                     }
                                     $_SESSION['isLoggedin'] = TRUE;
                                     $_SESSION['username']	= $username;
                                     $_SESSION['password']	= $password;
                                     return true; 
                                }else{
                                    return false;
                                }
				
			}
		}
		return false;
	}
	
	static function save($id, $user)
	{
		$i = 0;
		$query = 'UPDATE users SET ';

		foreach($user as $k => $v)
		{
			$i++;
			if(isset(self::$$k))
			{
				$query .= $k . ' = \'' . $v . '\'';
				$query .= ($i != count($user)) ? ', ' : ' ';
			}
		}

		$query .= 'WHERE id = \''.$id.'\' LIMIT 1';
		DB::query($query);
	}
}