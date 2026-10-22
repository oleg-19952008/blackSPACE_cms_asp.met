<?php

class donate extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
	}

	public function index()
	{
		$this->view->render('donate/index');
	}

}

?>
