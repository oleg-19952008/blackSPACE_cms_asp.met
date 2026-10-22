<?php

class payment_check extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
	}

	function index()
	{
		$this->view->result = $this->model->check();
		$this->view->render('donate/payment_check', true);
	}
}

?>