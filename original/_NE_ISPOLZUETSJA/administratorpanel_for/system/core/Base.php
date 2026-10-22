<?php


if(!defined('IN_TOPSITE')) die();

class Base
{
	function autoload()
	{
		$a = Config::load('autoload');

		foreach($a as $type => $array)
		{
			foreach($array as $id => $name)
			{
				Load::$type($name);
			}
		}
	}

	public static function get_page()
	{
		$page = 'index';

		if(count($_GET) > 0)
		{
			$keys = array_keys($_GET);
			$page = $keys[0];
		}

		return $page;
	}

	function page_exists($page)
	{
		if(file_exists('system/application/pages/' . $page . '.php'))
		{
			return TRUE;
		}

		else return FALSE;
	}

	function module_exists($page)
	{
		if(file_exists(TMP . 'modules/' . $page . '.php'))
		{
			return TRUE;
		}

		return FALSE;
	}

	function addon_exists($page)
	{
		if(file_exists(TMP . 'addons/' . $page . '.php'))
		{
			return TRUE;
		}

		else return FALSE;
	}
}