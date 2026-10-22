<?php


if(!defined('FLAMEWORK'))
{
	session_start();
	$_SESSION['captcha'] = rand('1000', '9999');
	echo $_SESSION['captcha'];
}

else
{
	global $captcha_path;
	$captcha_path = 'system/helpers/Captcha.php';

	function check_captcha($captcha = '')
	{/*
		if(isset($_SESSION['captcha']))
		{
			if($_SESSION['captcha'] === $captcha)
			{
				return TRUE;
			}
		}

		return FALSE;*/
		return TRUE;
	}
}
?>