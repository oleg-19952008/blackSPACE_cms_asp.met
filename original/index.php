<?php
 // echo "Технические работы.";
 // Exit;
// 0 - отключить регистрацию
// 1 - включить регистрацию
$regist = 1;

require './KERNEL-DOCMS/Init.php';
require_once './PHPMailer/PHPMailerAutoload.php';

// --- КАПЧА ОТКЛЮЧЕНА ---
// $secret = "6LcNQFUUAAAAAJCakv8UHNSPww15rhJSBU3VPKqj";
// require_once "./recaptcha/recaptchalib.php";
// $reCaptcha = new ReCaptcha($secret);
// ------------------------

if(isset($_POST['recoverTrue']) && !empty($_POST['recoverTrue'])){
	$_SESSION['errorData'] = $unity->passwordRecovery($_POST['recoverPw']);
}
if(isset($_POST['loginForm_default_username'], $_POST['loginForm_default_password'], $_POST['loginForm_default_login_submit']) && $_POST['loginForm_default_login_submit'] === 'Login'):
	$_SESSION['errorData'] = "";
	if(preg_match('/[|]/', $_POST['loginForm_default_username']) || strlen($_POST['loginForm_default_password']) < 6 || strlen($_POST['loginForm_default_password']) > 20 || !preg_match('`[0-9]`', $_POST['loginForm_default_password']) || $_POST['loginForm_default_password'] === '******' || strlen($_POST['loginForm_default_username']) < 2 || strlen($_POST['loginForm_default_username']) > 40):
		$_SESSION['errorData'] .= '<div class="singup_errorMessage signup_errorMessage">Данная комбинация логина и пароля неизвестна.
<br>Пожалуйста проверьте данные и попробуйте снова.</div>';
        else:		
									
//             
				$name = mysqli_real_escape_string($MySQLi, $_POST['loginForm_default_username']);
                $query = $MySQLi->query("SELECT users.pwHash, users.ID, users.Email, users.verified, users.banned, users.banned_until, users.IP, server_1_players.rank FROM users INNER JOIN server_1_players ON users.ID=server_1_players.userID WHERE users.Name = '". $name ."'");
                if($query->num_rows === 1):
				$row = $query->fetch_assoc();
				if($row['banned']!=0){
					header('Location: http://127.0.0.1/?calmdown=99&until=Banned%20Permanent');					
				}else{
				//if($row['rank']==21){
				if(($unity->cPT($row['banned_until']))){
					header('Location: http://127.0.0.1/?calmdown=99&until='.$row['banned_until']);		
				}else{
                        if($Encryption->decrypt($row['pwHash'])===$_POST['loginForm_default_password']){                            
                            $sessionId = $Core::GenerateRandom(18, true, false);
                            $MySQLi->query('UPDATE users SET sessionId = \' ' . $sessionId . '\', IP = \''.$unity->get_client_ip().'\' WHERE ID = ' . $row['ID'] . '');
                            $_SESSION['server1']['user']['sessionId'] = $sessionId;
                            $_SESSION['server1']['user']['email'] = $row['Email'];
                            $_SESSION['server1']['user']['verified'] = $row['verified'];
							DB::pmc($row['ID'], "User logged in from ip: ".$unity->get_client_ip(), "logins");
                            header('Location: /indexInternal.es.php?action=internalStart');
                        }else{
                            $_SESSION['errorData'] .= '<div>Данная комбинация логина и пароля неизвестна.
<br>Пожалуйста проверьте данные и попробуйте снова.</div>';
		
                        }
						}
				//}else{
				//$_SESSION['errorData'] .= '<div>The server is currently under maintenance.<br>Please check again later.</div>';
		
//				}
			   }
		else:
			$_SESSION['errorData'] .= '<div>Данная комбинация логина и пароля неизвестна.
<br>Пожалуйста проверьте данные и попробуйте снова.</div>';
		endif;
	endif;
elseif(isset($_POST['signup_winnings'], $_POST['signup_username'], $_POST['signup_submit'], $_POST['signup_province'], $_POST['signup_passwordRepeat'], $_POST['signup_password'], $_POST['signup_newsletter'], $_POST['signup_instance'], $_POST['signup_email'], $_POST['signup_country'], $_POST['signup_birthdayYear'], $_POST['signup_birthdayMonth'], $_POST['signup_birthdayDay'])):
	
	if($_POST['signup_submit'] == 'Register'):
		$_SESSION['errorData'] = "";
		if(strlen($_POST['signup_password']) < 6):
			$_SESSION['errorData'] .= '<div>Пароль слишком короткий. Пожалуйста, введите пароль от 6 до 30 символов.</div>';
			
		elseif(strlen($_POST['signup_password']) > 30):
			$_SESSION['errorData'] .= '<div>Пароль слишком длинный. Пожалуйста, введите пароль от 6 до 30 символов.</div>';
			
		elseif(!preg_match('`[0-9]`', $_POST['signup_password'])):
			$_SESSION['errorData'] .= '<div>The password must include numbers.</div>';
			
		endif;

		// --- БЛОК ПРОВЕРКИ КАПЧИ ОТКЛЮЧЕН ---
		// if ($_POST["g-recaptcha-response"]) {
		// 	$response = $reCaptcha->verifyResponse(
		// 	        $_SERVER["REMOTE_ADDR"],
		// 	        $_POST["g-recaptcha-response"]
		// 	 );
		// 	if ($response != null) { //  && $response->success
		// 	        
		// 	      } else {
		// 	 	// $_SESSION['errorData'] .= '<div>Вы не ввели капчу!</div>';
		//
		// 	}}
		// 	else {
		// 	 	$_SESSION['errorData'] .= '<div>Вы не ввели капчу!</div>';
		//
		// 	}
		// -------------------------------------

	if($regist == 0){
		$_SESSION['errorData'] .= '<div style="color:red;background: #ccc;"><b>Регистрация временно отключена!<br>Вся информация в группе <a href="https://vk.com/club87391028"> VK </a>и <a href="https://discord.gg/ZmKNyFM">DISCORD</a></b></div>';
	}

		if(strlen($_POST['signup_username']) < 3):
			$_SESSION['errorData'] .= '<div>Логин слишком короткий. Пожалуйста, введите логин от 3 до 15 символов.</div>';
			
		elseif(strlen($_POST['signup_username']) > 15):
			$_SESSION['errorData'] .= '<div>Логин слишком длинный. Пожалуйста, введите логин от 3 до 15 символов.</div>';
		elseif(preg_match('/[\'\/`\!@#\$%\&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $_POST['signup_username'])):
			$_SESSION['errorData'] .= '<div>Данный логин уже используется.</div>';
				
		endif;
		
		if(empty($_POST['signup_email']) || strlen($_POST['signup_email']) > 50 || preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $_POST['signup_email']) !== 1):
			$_SESSION['errorData'] .= '<div>Вы ввели неверный e-mail адрес.</div>';
			
		endif;
		
		if(!isset($_POST['signup_termsAndCondition']) || $_POST['signup_termsAndCondition'] !== '1'):
			$_SESSION['errorData'] .= '<div>Please confirm that you have accepted our Terms & Conditions. Afterwards, you may continue with your registration.</div>';
			
		endif;
		$name = trim($_POST['signup_username']);
		if($_SESSION['errorData'] === ''):
		$con = $GLOBALS['DB'];
		$query = $con->prepare('SELECT null FROM users WHERE Name=:name  || Email=:email ');
		$query->bindParam(":name",	$name, PDO::PARAM_STR);
		$query->bindParam(":email", $_POST['signup_email'], PDO::PARAM_STR);
		if($query->execute()){
			$result = $query->fetchAll(PDO::FETCH_OBJ);
			if(!empty($result)){
				$_SESSION['errorData'] .= '<div>This username or email already exists. Please select another username.</div>';
			}else{
				$sessionId = $Core::GenerateRandom(18, true, false);
                $hashpw = $Encryption->encrypt($_POST['signup_password']);
				try {
					$stmt = $con->prepare("INSERT INTO `users` (Email, Name, pwHash, Servers, sessionId, accountnote) VALUES (?, ?, ?, '', ?, '')");				
					$stmt->bindParam(1, $_POST['signup_email'], PDO::PARAM_STR);
					$stmt->bindParam(2, $name, PDO::PARAM_STR);
					$stmt->bindParam(3,	$hashpw, PDO::PARAM_STR);						
					$stmt->bindParam(4, $sessionId, PDO::PARAM_INT);
					if($stmt->execute()){
						$pid = $con->lastInsertId(); 	
					    $verificationcaode = urlencode($Encryption->encrypt('{"userid":'.$pid.',"email":"'.$_POST['signup_email'].'"}'));	
						$mailer->mailSystem(array('header'=>array('mailfrom'=> 'no-reply@127.0.0.1', 'template'=>'confirmemail', 'subject' => 'Dark Space Email Confirmation'),'content'=>array('username' => $name, 'link' => 'http://127.0.0.1/emailconfirmation/?s='.$verificationcaode,'reasonforemail'=>'Email Verification', 'author' => 'Best Regards <br /> Dark Space Staff Team', 'year'=>date('Y')), 'recivers'=>array($_POST['signup_email'])));
							$unity->registerNewAccount($pid);
							$unity->updateAccount($pid);
							$unity->regAmmo($pid);
						$reg->SuperReg($pid);
						$_SESSION['server1']['user']['sessionId'] = $sessionId;
						$_SESSION['server1']['user']['email'] = $_POST['signup_email'];
						header('Location: /indexInternal.es.php?action=internalCompanyChoose');
					}		
				} catch (PDOException $e) {
							print "Error!: " . $e->getMessage() . "<br/>";
							die();
				}
			}
		}

$text = 
'
<center>DarkSpace </center>
  Добро пожаловать, '.$_POST['signup_username'].'<br>
  DarkSpace - приватный сервер игры DarkOrbit<br><br>

  Ваш логин: '.$_POST['signup_username'].'<br>
  Ваш пароль:'.$_POST['signup_password'].'
<br><br><br>

Welcome, '.$_POST['signup_username'].' <br>
DarkSpace - The private server of the game Dark Orbit <br> <br>

Your login: '.$_POST['signup_username'].' <br> 
Your password: '.$_POST['signup_password'].'
';


		  $mail = new PHPMailer;
          // $mail->SMTPDebug = 3;
          $mail->isSMTP();
          $mail->Host         = 'smtp.yandex.ru';
          $mail->SMTPAuth     = true;
          $mail->Username     = 'noreply@127.0.0.1';
          $mail->Password     = 'ZrHkD0*c#YszxFstj^H1kg*';
          $mail->SMTPSecure   = 'tls';
          $mail->From         = 'noreply@127.0.0.1';
          $mail->FromName     = 'Dark Space [Private server]';
          $mail->addAddress($_POST['signup_email']);
          $mail->CharSet      = "utf-8";
          $mail->isHTML(true);
          $mail->Subject      = 'Dark Space [Private server]';
          $mail->Body         = $text;
 		 // if(!$mail->send()) {
    //         echo 'Message could not be sent.';
    //         echo 'Error: ' . $mail->ErrorInfo;
    //       } else {
    //         $msg = '<h2>Данные отправлены на Email</h2>';
    //         echo 'Message has been sent';
    //       }
			//if($MySQLi->query('SELECT null FROM users WHERE Name = \'' .$_POST['signup_username']. '\' || Email= \'' .$_POST['signup_email'] . '\'  ')->num_rows > 0):
				//$_SESSION['errorData'] .= '<div>This username or email already exists. Please select another username.</div>';
				
			//else:
						
				//$name = trim(mysqli_real_escape_string($MySQLi, $_POST['signup_username']));
				//print_r($hashpw);
				//if($MySQLi->query('INSERT INTO users (Email, Name, pwHash, Servers, sessionId) VALUES (\'' . $_POST['signup_email'] . '\', \'' . $name . '\', \'' . $hashpw . '\', \'\', ' . $sessionId . ');')):
/* 				$userId = $MySQLi->insert_id;
                                        $verificationcaode = urlencode($Encryption->encrypt('{"userid":'.$userId.',"email":"'.$_POST['signup_email'].'"}'));
					$mailer->mailSystem(array('header'=>array('mailfrom'=> 'no-reply@127.0.0.1', 'template'=>'confirmemail', 'subject' => 'Dark Space Email Confirmation'),'content'=>array('username' => trim($_POST['signup_username']), 'link' => 'http://127.0.0.1/emailconfirmation/?s='.$verificationcaode,'reasonforemail'=>'Email Verification', 'author' => 'Best Regards <br /> Dark Space Staff Team', 'year'=>date('Y')), 'recivers'=>array($_POST['signup_email'])));
                                        $MySQLi->multi_query('INSERT INTO server_1_players (playerID, overallRank, userId, settings) VALUES (' . $userId . ', ' . $userId . ', ' . $userId . ', \'\');UPDATE users SET Servers = \'[{1:' . $MySQLi->insert_id . '}]\' WHERE ID = \'' . $userId . '\'');
                                            $reg->SuperReg($userId);
					$_SESSION['server1']['user']['sessionId'] = $sessionId;
					$_SESSION['server1']['user']['email'] = $_POST['signup_email'];
					header('Location: /indexInternal.es.php?action=internalCompanyChoose'); */
				//endif;
		endif;
	endif;
endif;




require FILES . 'INDEX/header.php';
require FILES . 'INDEX/body.php';
echo "<script type='text/javascript'>	(function () { var done = false;	var script = document.createElement('script');	script.async = true;	script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) {	if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {	var w = new PCWidget({ c: '29d56b56-c70f-45e4-a050-cdffe45597c8', f: true });	done = true; }	};	})();	</script>";
?>