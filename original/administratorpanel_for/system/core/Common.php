<?php


if(!defined('IN_TOPSITE')) die();

/***************************************************************************
*                     Create Global Filpaths Variables                     *
***************************************************************************/

define('CONFS',  'system/config/');
define('LIBS',   'system/libraries/');
define('APP',    'system/application/');

/***************************************************************************
*                              Error Functions                             *
***************************************************************************/

function _error_handler($severity, $message, $filepath, $line)
{	
	if ($severity == E_STRICT)
	{
		return;
	}

		show_error($message);
}

function show_error($message)
{	
	include(APP . 'errors/error_general.php');
	die();
}

/***************************************************************************
*                              Misc. Functions                             *
***************************************************************************/

function capitalize($string)
{
	return ucfirst(strtolower($string));
}

function redirect($location = 'index')
{
	$location = '?' . $location;
	header('Location: ' . $location);
}

function dump($data)
{
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}
/*
 |-----------------------------------------------------------
 | Clean Post Variables
 |-----------------------------------------------------------
 |
 | If Magic Quotes are on, we need to strip slashes. This
 | handles it automatically for the application.
 */
		
if(get_magic_quotes_gpc())
{
	if(count($_POST) > 0)
	{
		foreach($_POST as $k => $v)
		{
			$_POST[$k] = stripslashes($v);
		}
	}
}


/************************************************************
 * 						CUSTOM FUNCTIONS
 ************************************************************/

function time_until_reset()
{
	$now = time();
	DB::select('reset_timer');
	$timer = DB::fetch_row();	
	$timer = $timer['reset_timer'];
	$difference = ($now - $timer);
	return (2629743 - $difference);
}

function navigation()
{
	DB::query("SELECT * FROM navigation ORDER BY id ASC");
	return (DB::num_rows() > 0) ? DB::fetch_array() : array();
}

function categories()
{
	DB::select('categories');
	return (DB::num_rows() > 0) ? DB::fetch_array() : array();
}