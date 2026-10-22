<?php

class Index extends Controller
{
	
	function __construct()
	{
		parent::__construct();
		Session::init();
		Auth::isLogged();
		$this->view->js = array('index/js/default.js');
	}

	function index()
	{
		$this->view->render('index/index', true);
	}

	function run()
	{
		$this->model->run();
	}

	function register()
	{
		$this->model->register();
		// $this->view->render('index/register', true);
	}

	function captcha()
	{
		$this->model->captcha();
	}
}

?>