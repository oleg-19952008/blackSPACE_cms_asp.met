<?php


class Page
{
	static $data = array(
		'showselect'   => TRUE,
		'showtextarea' => FALSE,);

	static function Build()
	{
		if(User::$isAdmin == FALSE)
		{
			redirect();
		}
		
		self::$data['message'] = 'You can edit your site\'s pages here. You can start by selecting a page:';
		
		if(isset($_GET['page']))
		{
			if(isset($_GET['parse']))
			{
				self::parseURL();
			}
			
			self::$data['showtextarea'] = TRUE;
			self::$data['location'] = $_GET['page'];
			$template  = Config::item('template');
			$location = self::$data['location'];
			$page_path = 'system/templates/'.$template.'/'.$location.'.php';
			self::$data['page_path'] = $page_path;
			
			if(is_writable($page_path) != TRUE)
			{
				self::$data['editable'] = FALSE;
			}
			
			if(isset($_POST['edit']))
			{
				self::savePage();
			}
		}
		
		self::getPages();
		Load::view('acp/pages', self::$data, TRUE);
	}
	
	static function getPages($recursive = 'pages/')
	{
		$source_dir  = 'system/templates/' . Config::item('template') . '/';
		$source_dir .= $recursive;

		$i = 0;
		self::$data['pages'] = array();

		if ($fp = @opendir($source_dir))
		{
			while (FALSE !== ($file = readdir($fp)))
			{
				if (@!is_dir($source_dir.$file) && $file[0] != '.')
				{
					$i++;
					if((isset($_GET['page']) && $recursive.$file == $_GET['page'].'.php') )
					{
						self::$data['selected'] = $recursive . $file;
					}

					else self::$data['pages'][] = $recursive . $file;
				}
				
				elseif($file[0] != '.') self::getPages($recursive . $file . '/');
			}
		}
	}
	
	static function parseURL()
	{
		$i = 0;
		$r = '';
		foreach($_GET as $k => $v)
		{
			$i++;
			
			if($i <= 2)
			{
				$k = str_replace('%2F', '/', $k);
				$r .= $k;

				if($k == 'acp/pages')
				{
					$r .= '&';
				}

				if(!empty($v))
				{
					$r .= '=' .str_replace(array('%2F', '.php'), array('/', ''), $v);
				}
			}
		}

		redirect($r);
	}
	
	static function savePage()
	{
		Load::helper('filehandler');
		$page_path = self::$data['page_path'];
		write($page_path, $_POST['page']);
	}

	static function message($message, $color = 'red')
	{
		self::$data['show'] = FALSE;
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}