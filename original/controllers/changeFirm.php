<?php

class changeFirm extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
	}

	public function index()
	{
		$this->view->FirmInfos = $this->model->FirmInfos();
		$this->view->render('changeFirm/index');
	}

	function Update()
	{
		$this->model->ChangeFirm();
		// header('location: '.URL.'internalStart');
	}

}

?>
