<?php

class internalClan extends Controller
{
	
	public function __construct()
	{
		parent::__construct();
		Auth::handleLogin();
		$this->view->js = array('internalClan/js/default.js');
	}

	public function index()
	{
		$this->view->ListClan = $this->model->ListClan();
		if (Auth::getUser('clanid') > 0)
		{
			$this->view->GetMyClanMembers = $this->model->GetMyClanMembers();
			$this->view->GetMyClanRequest = $this->model->GetMyClanRequest();
			$this->view->isAdmin = $this->model->isAdmin();
		}
		$this->view->render('internalClan/index');
	}

	public function Diplomacy()
	{
		$this->view->ListClan = $this->model->ListDiplomacyClan();
		$this->view->ListDiplomacy = $this->model->ListDiplomacy();
		$this->view->ListSecondDiplomacy = $this->model->ListSecondDiplomacy();
		$this->view->isAdmin = $this->model->isAdmin();
		$this->view->render('internalClan/Diplomacy');
	}

	public function ClanRanking()
	{
		$this->view->ClanRanking = $this->model->ClanRanking();
		$this->view->render('internalClan/ClanRanking');
	}

	public function create()
	{
		$this->model->createClan();
	}

	public function kick()
	{
		$this->model->kickPlayer();
		header('location: '.URL.'internalClan');
	}

	public function accept()
	{
		$this->model->AcceptMembers();
		header('location: '.URL.'internalClan');
	}

	public function decline()
	{
		$this->model->DeclineMembers();
		header('location: '.URL.'internalClan');
	}

	public function join()
	{
		$this->model->JoinClan();
	}

	public function DiplomacyRequest()
	{
		$this->model->DiplomacyRequest();
	}

	public function CancelDiplomacy()
	{
		$this->model->CancelDiplomacy();
	}

	public function leave()
	{
		$this->model->Leave();
		header('location: '.URL.'internalClan');
	}

	public function destroy()
	{
		$this->model->Destroy();
		header('location: '.URL.'internalClan');
	}
}

?>
