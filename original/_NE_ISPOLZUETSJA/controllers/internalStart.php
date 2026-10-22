<?php

class internalStart extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
		$this->view->js = array('internalStart/js/default.js', 'internalStart/js/jquery.countdown.min.js');
	}

	public function index()
	{
		$this->view->hall_of_fame = $this->model->halloffame();
		$this->view->logbook = $this->model->logbook();
		$this->view->render('internalStart/index');
	}

	public function HallOfFame()
	{
		$this->view->hall_of_fame_100 = $this->model->halloffame100();
		$this->view->render('internalStart/HallOfFame');
	}

	public function EditAccount()
	{
		$this->model->editaccount();
	}
}

?>
