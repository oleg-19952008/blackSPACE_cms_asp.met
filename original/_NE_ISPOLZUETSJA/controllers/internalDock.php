<?php

class internalDock extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
		$this->view->js = array('internalDock/js/ships.js');
	}

	public function index()
	{
		$this->view->render('internalDock/index');
	}

	public function Ships()
	{
		$this->view->render('internalDock/Ships');
	}

	public function Buy_Ship()
	{
		$this->model->BuyShip();
	}
}

?>
