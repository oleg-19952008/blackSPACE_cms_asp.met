<?php


class Page
{
	static function Build()
	{
		$subpage = 'index';
		$file_path = 'system/application/pages/acp/';

		if(isset($_GET['acp']) && !empty($_GET['acp']))
		{
			if(file_exists($file_path . $_GET['acp'] . '.php'))
			{
				$subpage = $_GET['acp'];
			}
		}

		include $file_path . $subpage . '.php';
		Subpage::Build();
	}
}