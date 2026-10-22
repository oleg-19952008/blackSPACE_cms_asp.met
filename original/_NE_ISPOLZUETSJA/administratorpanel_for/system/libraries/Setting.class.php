<?php


if(!defined('IN_TOPSITE')) die();

class Setting extends DB
{
	
	static $banner		= '';
      
        
	function Build()
	{
		$c = Config::load('main');
	}
        
        
        static function SettingHandler($handler)
	{
			DB::select('cms', "handler = '$handler'", '1');
			if(DB::num_rows() > 0)
			{
				$setting = DB::fetch_row();
				
				return $setting['setting'];
			}
		return false;
	}
        static function ContentHandler($handler)
	{
			DB::select('navigation', "link = '$handler'", '1');
			if(DB::num_rows() > 0)
			{
				$setting = DB::fetch_row();
				
				return $setting['content'];
			}
		return false;
	}
        
        static function generateRandom($length, $numbers = true, $letters = true, $otherChars = ''){
		$chars = '';
		$chars .= ($numbers) ? '0123456789' : '';
		$chars .= ($letters) ? 'QWERTYUIOPASDFGHJKLLZXCVBNMqwertyuiopasdfghjklzxcvbnm' : '';
		$chars .= $otherChars;

		$str = '';
		$c = 0;
		while ($c < $length){ 
			$str .= substr($chars, rand(0, strlen($chars) -1), 1);
			$c++;
		}
		
		return $str;
	}
        
	
	
	
}