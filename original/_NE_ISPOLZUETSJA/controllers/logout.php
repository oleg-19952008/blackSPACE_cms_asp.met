<?php

class Logout extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		Session::init();
		Session::destroy();
	}

	public function index()
	{
		header('location: '.URL);
	}
}

?>