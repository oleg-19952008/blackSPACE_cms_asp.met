<?php

class Page
{
	static function Build()
	{
		if(User::$isLoggedin == TRUE)
		{
			redirect('ucp');
			return;
		}
		$data = array
		(
			'message'		=> 'Please register using your desired information',
                        'username'		=> '',
			'full_name'		=> '',
			'password'		=> '',
			'confirm'		=> '',
			'email'			=> '',
			'adress'		=> '',
                        'isMember' => ''
 		);

		$data['message']  = 'Please register to using your desired information.';
		
		if(isset($_POST['register']))
		{                    
                     
			$error = FALSE;
			$query = 'INSERT INTO users SET ip = \'' . $_SERVER['REMOTE_ADDR'] . '\', ';
			$i = 0;

			foreach($_POST as $k => $v)
			{
				$v = DB::safe($v);
				$data[$k] = $v;
				
				if($error == FALSE)
				{
					if($k == 'confirm')
					{
						if($data['password'] == $v)
						{
							$v = md5($data['username'] . $v);
						}

						else
						{
							$data['message'] = self::msg('The passwords must match!');
							$error = TRUE;
						}
					}

					$i++;
					if($k != 'password' && $k != 'register')
					{
						if($k == 'confirm') $k = 'password';

						$query .= $k . ' = \'' . $v . '\'';
						$query .= ($i != count($_POST) - 1) ? ', ' : ', points = \' \' ';
					}
				}
			}

			if($error != TRUE)
			{
					$ip = (getenv('HTTP_X_FORWARDED_FOR')) ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR');
					DB::query("SELECT id FROM users WHERE ip = '$ip'");

					if(DB::num_rows() < Config::item('max_reg_ips'))
					{
						DB::query("SELECT id FROM users WHERE email = '".$data['email']."' LIMIT 1");

						if(DB::num_rows() == 0)
						{
							DB::query("SELECT id FROM users WHERE username = '".$data['username']."' LIMIT 1");

							if(DB::num_rows() == 0)
							{
								DB::query($query);
                                                                 mail($data['email'], "MotionCenteret Username", $data['username']);
								User::login($data['username'], $data['password']);
								redirect('ucp');
							}

							else $data['message'] = self::msg('Username `'.$data['username'].'` is taken');
						}

						else $data['message'] = self::msg('Email `'.$data['email'].'` is taken');
					}
					
					else $data['message'] = self::msg('Only up to ' . Config::item('max_reg_ips') . ' sites are allowed per IP');
				}
			}

		Load::view('register', $data);
	}

	static function categories()
	{
		DB::select('categories');
		return (DB::num_rows() > 0) ? DB::fetch_array() : array();
        }
	static function msg($message = '', $color = 'red')
	{
		return '<b style=\'color:' . $color . ';\'>' . $message . '</b>';
	}
}