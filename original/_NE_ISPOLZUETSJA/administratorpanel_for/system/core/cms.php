<?php


if(!defined('IN_TOPSITE')) die();

/***************************************************************************
*                             Build the Environment                        *
***************************************************************************/

//Turn on debug, if needed
if(DEBUG == TRUE)
{
	error_reporting(E_ALL);
	@ini_set('display_errors', 1);
}

//Load the other core files
include 'system/core/Base.php';
include 'system/core/Common.php';
include 'system/core/Load.php';

//Start the session
session_start();

//Set Error Handler
set_error_handler('_error_handler');

//Autoload configs and libraries
Load::library('config');
Base::autoload();

//Now set the template path
define('TMP', 'templates/' . Config::item('template') . '/');

/************************************************************
 * 	LOAD APPLICATION
 ************************************************************/

//Find the Requested Page
$isModule = FALSE;
$page = Base::get_page();

if(Base::page_exists($page) == FALSE)
{
	//Is it a template specific module?
	if(Base::module_exists($page) == TRUE)
	{
		$isModule = TRUE;
	}
	
	else $page = 'index';
}

//Load the page's addon (if exists)
if(Base::addon_exists($page))
{
	Load::addon($page);
}

//Load the Page
Load::page($page, $isModule);