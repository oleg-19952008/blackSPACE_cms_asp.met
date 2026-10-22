<?php

class View
{
	
	function __construct()
	{
		// echo 'This is the view!<br />';
	}

	public function render($name, $noInclude = false)
	{
		if ($noInclude == true) 
		{
			require 'views/'. $name .'.php';
		}
		else
		{
			date_default_timezone_set('Europe/Paris');
			require 'views/header.php';
			require 'views/'. $name .'.php';
			require 'views/footer.php';
		}
	}
}


?>
