<?php


if(!defined('IN_TOPSITE')) die();

class Config
{
	static $configs	= array();

	function Load($name)
	{
		$var  = strtolower($name);
		$name = capitalize($var);

		if(!isset(self::$configs[$name]))
		{
			if(file_exists(CONFS . $var . '.conf'))
			{
				$return = array();
				include CONFS . $var . '.conf';

				if(isset($conf))
				{
					$return = $conf;
					self::$configs = array_merge($conf, self::$configs);
				}

				if(isset($$var))
				{
					self::$configs[$var] = $$var;
					$return = array_merge($return, $$var);
				}
			}
		}

		return $return;
	}

	function item($config, $file = FALSE)
	{
		if($file != FALSE)
		{
			if(isset(self::$configs[$file][$config]))
			{
				return self::$configs[$file][$config];
			}
		}

		else
		{
			if(isset(self::$configs[$config]))
			{
				return self::$configs[$config];
			}
		}

		return FALSE;
	}
}