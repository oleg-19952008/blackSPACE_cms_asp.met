<?php


class Page
{
	static $data = array('modules' => array());

	static function Build()
	{
		if(User::$isAdmin == FALSE)
		{
			redirect();
		}
		
		self::$data['message'] = 'You can manage your site\'s modules here.';
		
		if(isset($_GET['install']))
		{
			self::install($_GET['install']);
		}
		
		if(isset($_GET['uninstall']))
		{
			self::uninstall($_GET['uninstall']);
		}
		
		self::getModules();
		Load::view('acp/modules', self::$data, TRUE);
	}

	static function getModules()
	{
		$source_dir = 'system/modules/';
		self::$data['templates'] = array();

		if ($fp = @opendir($source_dir))
		{
			while (FALSE !== ($module = readdir($fp)))
			{
				if (@is_dir($source_dir.$module) && $module[0] != '.')
				{
					$info = self::getModuleInfo($module);
					
					self::$data['modules'][] = array
					(
						'name'			=> capitalize($module),
						'description' 	=> $info['description'],
						'status' 		=> $info['status'],
						'pages'  		=> $info['pages'],
					);
				}
			}
		}
	}
	
	static function getModuleInfo($module)
	{
		$info = array(
			'description' 	=> '-',
			'status'		=> '<b style=\'color:red;\'>Corrupted</b>',
			'pages'			=> '-');
		
		if(file_exists('system/modules/' . $module . '/config.php'))
		{
			include 'system/modules/' . $module . '/config.php';
			
			if(isset($config) && is_array($config))
			{
				if(isset($config['description']) && isset($config['compatible']) && isset($config['pages']))
				{
					if(is_array($config['compatible']) && in_array(VERSION, $config['compatible']))
					{
						Cache::init('modules');

						$modules = Cache::get();
						$modules = unserialize($modules);
						
						if(in_array($module, $modules))
						{
							$info['status'] = 'Installed. <a href=\'?acp/modules&uninstall='.$module.'\'>Uninstall</a>';
						}
						
						else $info['status'] = 'Uninstalled. <a href=\'?acp/modules&install='.$module.'\'>Install</a>';

						$info['description'] = $config['description'];
						$info['pages']		 = count($config['pages']);
						
						if(isset($config['pages']['none']))
						{
							$info['pages']--;
						}
					}
					
					else $info['status'] = '<b style=\'color:red;\'>Module is incompatible with UnityCMS v'.VERSION.'</b>';
				}
			}
		}
		
		return $info;
	}
	
	static function install($module)
	{
		Cache::init('modules');
		$modules = Cache::get();
		$modules = unserialize($modules);

		$modules[] = $module;
		Cache::set($modules);
	}
	
	static function uninstall($module)
	{
		Cache::init('modules');
		$modules = Cache::get();
		$modules = unserialize($modules);

		$new = array();
		$i = 0;
		
		while(isset($modules[$i]))
		{
			if($modules[$i] != $module)
			{
				$new[] = $modules[$i];
			}

			$i++;
		}

		Cache::set($new);
	}

	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}