<?php


if(!defined('IN_TOPSITE')) die();

class Load
{
	function config($name)
	{
		//Load the config class if needed
		if(class_exists('config') != TRUE)
		{
			self::library('config');
		}

		Config::load($name);
	}

	function library($name)
	{
		$name = capitalize($name);

		if(file_exists(LIBS . $name . '.class.php'))
		{
			include LIBS . $name . '.class.php';

			if($name == 'Database') $name = 'DB';
			if(is_callable(array($name, 'Build')))
			{
				call_user_func(array($name, 'Build'));
			}
		}

		else return FALSE;
	}

	function page($page, $isModule = FALSE)
	{
		$path = ($isModule == FALSE)?
				APP . 'pages/' . $page . '.php':
				TMP . 'modules/' . $page . '.php';

		include $path;

		$param = FALSE;
		if(isset($_GET[$page]) && !empty($_GET[$page]))
		{
			$param = $_GET[$page];
		}

		Page::Build( $param );
	}

	function module($name)
	{
		include TMP . 'modules/' . $name . '.php';
	}

	function addon($name)
	{
		include TMP . 'addons/' . $name . '.php';
	}

	function helper($name)
	{
		$name = ucfirst(strtolower($name));
		if(file_exists('system/helpers/' . $name . '.php'))
		{
			include 'system/helpers/' . $name . '.php';
		}
	}

	function view($name, $variables, $isACP = FALSE)
	{
		$name = strtolower($name);

		foreach($variables as $k => $v)
		{
			$$k = $v;
		}

		$page  =  TMP . 'pages/';
		$page .= ($isACP) ? 'acp/' . $name . '.php': $name . '.php';
		if(file_exists($page))
		{
			include ($isACP) ? TMP . 'global/acp/header.php':		TMP . 'global/header.php';
			include ($isACP) ? TMP . 'pages/acp/' . $name . '.php':	TMP . 'pages/' . $name . '.php';
			include ($isACP) ? TMP . 'global/acp/footer.php': 		TMP . 'global/footer.php';
		}
	}
}