<?php

class payment_donation extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
	}

	function index()
	{
		$this->view->render('donate/payment_donation', true);
	}
}

?>