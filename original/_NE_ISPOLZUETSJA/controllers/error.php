<?php


class Error extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		header('location: '.URL.'internalStart');
		exit;
	}


}

?>