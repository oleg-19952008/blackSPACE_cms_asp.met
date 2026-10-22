<?php

class payment_error extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
	}

	function index()
	{
		$this->view->render('donate/payment_error', true);
	}
}

?>