<?php


class Page
{
	static function Build($serial)
	{
		$data['showform'] = TRUE;

		if(User::$isLoggedin == TRUE)
		{
			redirect('ucp');
		}

		else
		{
			$time = time();

			$outdated = $time - (60 * 60);
			DB::query("DELETE FROM reset_request WHERE `timestamp` <= $outdated");
			
			if(isset($_GET['serial']))
			{
				$data['showform'] = FALSE;
				$data['color'] = 'red';
				$data['message'] = 'Invalid or outdated request. Please click <a herf="?forgot">here</a>';

				$serial = DB::safe($_GET['serial']);
				DB::select('reset_request', 'serial = \''.$serial.'\'');

				if(DB::num_rows() > 0)
				{
					$user = DB::fetch_row();
					$username = $user['username'];

					$new_pass = md5($username . $serial);
					DB::query("UPDATE users SET password = '$new_pass' WHERE username = '$username' LIMIT 1");
					User::login($username, $serial);

					$data['color'] = 'green';
					$data['message'] = 'Your new password has been set to `'.$serial.'`. Please change it <a href="?edit=password">here</a>';
				}
			}
			
			elseif(isset($_POST['submit']))
			{
				$email = DB::safe($_POST['email']);

				DB::query("SELECT username FROM users WHERE email = '$email' LIMIT 1");

				if(DB::num_rows() > 0)
				{
					$id = DB::fetch_row();
					$username = $id['username'];

					$serial = self::make_serial();
					$url = Config::item('siteurl') . '?forgot&serial=' . $serial;
					$q = "INSERT INTO reset_request SET username = '$username', email = '$email', `serial` = '$serial', `timestamp` = '$time'";
					DB::query($q);
					
					$message  = "Hello,\n";
					$message .= "You have requested a password reset.";
					$message .= " Please go to this link to receive your new password: $url";
					$message = wordwrap($message, 70);

					// Send
					mail($email, 'You have requested a password reset', $message);

					$data['showform'] = FALSE;
					$data['message']  = 'Please check your emails to reset your password. ';
					$data['message'] .= 'Remember, check your spam folder!';
					$data['color'] = 'green';
				}
			}
			/*
			$time = time();
			DB::query("DELETE FROM reset_request WHERE `timestamp` <= $time AND type = '2'");

			if($serial != 'none')
			{
				if(self::resetpassword($serial) == TRUE)
				{
					$data['message'] = 'Your new password has been sent to ' . $email;
				}

				else $data['message'] = 'Invalid serial';
			}

			if(isset($_POST['reset']))
			{
				self::preparereset($_POST['email']);
			}*/
		}

		Load::view('forgot', $data);
	}
	
	static function make_serial()
	{
		return md5(microtime());
	}
}