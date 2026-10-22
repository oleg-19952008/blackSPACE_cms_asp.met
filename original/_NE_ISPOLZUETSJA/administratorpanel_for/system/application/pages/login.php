<?php


class Page
{
	static function Build()
	{
		if(User::$isLoggedin == TRUE)
		{
			redirect('acp');
		}

		$max_attempts     = Config::item('max_attempts');
		$prevention_timer = Config::item('prevention_timer'); 
		$data['message'] = 'Please login using your credentials';

		if(!isset($_SESSION['LOGIN_ATTEMPTS']))
		{
			$_SESSION['LOGIN_ATTEMPTS'] = 0;
		}
		
		if(isset($_SESSION['BRUTE_FORCE_TIMER']) && $_SESSION['LOGIN_ATTEMPTS'] >= $max_attempts)
		{
			if($_SESSION['BRUTE_FORCE_TIMER'] <= time())
			{
				$_SESSION['LOGIN_ATTEMPTS'] = 0;
			}
		}
		
		if($_SESSION['LOGIN_ATTEMPTS'] >= $max_attempts)
		{
			$minutes = round(($_SESSION['BRUTE_FORCE_TIMER'] - time()) / 60);
			$data['message']  = '<b style=\'color:red;\'>You have used up all ' . $max_attempts . ' attempts. ';
			$data['message'] .= 'Please wait ' . $minutes . ' minutes before trying again.</b>';
		}
		
		elseif(isset($_POST['login']))
		{
			$username = DB::safe($_POST['username']);
			$password = DB::safe($_POST['password']);

			User::login($username, $password);
			
			if(isset($_SESSION['LOGIN_ATTEMPTS']))
			{
				$_SESSION['LOGIN_ATTEMPTS']++;
			}

			else $_SESSION['LOGIN_ATTEMPTS'] = 1;
			
			if(User::$isLoggedin == FALSE)
			{
				if($_SESSION['LOGIN_ATTEMPTS'] >= $max_attempts)
				{
					$_SESSION['BRUTE_FORCE_TIMER'] = time() + $prevention_timer * 60;
				}
				
				$data['message'] = '<b style=\'color:red;\'>Invalid login information</b>';
			}
			
			else $_SESSION['LOGIN_ATTEMPTS'] = 0;
		}
		
		if(User::$isLoggedin == FALSE)
		{
			$data['username'] = (isset($_POST['username'])) ? $_POST['username'] : '';
			$data['password'] = (isset($_POST['password'])) ? $_POST['password'] : '';

			Load::view('login', $data);
		}

		else redirect('acp');
	}
}