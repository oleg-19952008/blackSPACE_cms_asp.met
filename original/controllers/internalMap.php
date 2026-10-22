<?php

class internalMap extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
	}

	public function index()
	{
		$this->view->sid = $this->model->generate_sid();
		// // $banned = $this->model->IsBanned();
		// if (!$banned)
		// {
			$this->view->render('internalMap/index', true);
		// }
	}
}

?>
