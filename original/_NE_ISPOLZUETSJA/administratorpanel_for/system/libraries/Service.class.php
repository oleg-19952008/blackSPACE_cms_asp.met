<?php

if(!defined('IN_TOPSITE')) die();

class Service extends DB
{
	
	static $banner		= '';
      
        
	function Build()
	{
		$c = Config::load('main');
	}
	
}

?>