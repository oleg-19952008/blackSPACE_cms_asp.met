<?php


class Subpage
{
	static $data = array();

	static function Build()
	{
		if(User::$isAdmin == FALSE)
		{
			redirect();
		}
		
		self::$data['message'] = 'You can edit your site\'s settings here.';
		
		if(!is_writable('system/config/main.conf'))
		{
			$msg  = 'The `main` config file is not writable! ';
			$msg .= 'You will not be able to save any settings on this page.';
			self::message($msg);
		}
		
		elseif(isset($_POST['edit']))
		{
			self::saveConfig();
		}
		
		self::getTemplates();
		Load::view('index', self::$data, TRUE);
	}
	
	static function getTemplates()
	{
		/*$source_dir = 'templates/';
		self::$data['templates'] = array();

		if ($fp = @opendir($source_dir))
		{
			while (FALSE !== ($file = readdir($fp)))
			{
				if (@is_dir($source_dir.$file) && $file[0] != '.')
				{
					if(Config::item('template') == $file)
					{
						self::$data['default'] = $file;
					}
					
					else self::$data['templates'][] = $file;
				}
			}
		}*/
	}
	
	static function saveConfig()
	{
		$config  = Config::load('main');
		$content = file_get_contents('system/config/main.conf'); 
		$a = array(
			'sites_per_page' => 'Sites per Page',
			'max_pages' => 'Max Pages',
			'max_attempts' => 'Max Login Attempts',
			'prevention_timer' => 'Login Prevention Timer',
		);
		
		foreach($_POST as $k => $v)
		{
			if(isset($config[$k]))
			{
				if((isset($a[$k])) && !is_numeric($_POST[$k]))
				{
					$message = $a[$k] . ' must be numeric';
					self::message($message);
					return;
				}
				
				if($k == 'database')
				{
                                        $conn = DB::connect($_POST['hostname'], $_POST['username'], $_POST['password'], $v);
					if(!$conn)
					{
							self::message('Could not find the database');
							return;
					}
					
				}

				if($k == 'password')
				{
					//Just a failsafe to make sure the correct value
					//is used.
					if($v == ' ')
					{
						$v = '';
						$_POST[$k] = $v;
					}
				}

				Config::$configs[$k] = $v;
				$search  = '$conf[\''.$k.'\'] = \''.addslashes($config[$k]).'\';';
				$replace = '$conf[\''.$k.'\'] = \''.addslashes($_POST[$k]).'\';';
				$content = str_replace($search, $replace, $content);
			}
		}
		
		Load::helper('Filehandler');
		write('system/config/main.conf', $content);
		self::message('Settings saved successfully', 'green');
	}

	static function message($message, $color = 'red')
	{
		self::$data['message'] = $message;return;
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}