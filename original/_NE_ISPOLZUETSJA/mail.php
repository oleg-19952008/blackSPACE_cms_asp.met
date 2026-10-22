<?php
require_once '/PHPMailer/PHPMailerAutoload.php';
$text = 
'
<center>DarkSpace </center>
  Добро пожаловать, USERNAME<br>
  DarkSpace - приватный сервер игры DarkOrbit<br><br>

  Ваш логин: USERNAME<br>
  Ваш пароль: PASS
<br><br><br>

Welcome, USERNAME <br>
DarkSpace - The private server of the game Dark Orbit <br> <br>

Your login: USERNAME <br> 
Your password: PASS
';
 		  $mail = new PHPMailer;
          $mail->SMTPDebug = 3;
          $mail->isSMTP();
          $mail->Host         = 'smtp.yandex.ru';
          $mail->SMTPAuth     = true;
          $mail->Username     = 'noreply@127.0.0.1';
          $mail->Password     = 'ZrHkD0*c#YszxFstj^H1kg*';
          $mail->SMTPSecure   = 'tls';
          $mail->From         = 'noreply@127.0.0.1';
          $mail->FromName     = 'Dark Space [Private server]';
          $mail->addAddress('navigator.do@yandex.ru');
          $mail->CharSet      = "utf-8";
          $mail->isHTML(true);
          $mail->Subject      = 'Dark Space [Private server]';
          $mail->Body         = $text;

          if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Error: ' . $mail->ErrorInfo;
          } else {
            $msg = '<h2>Данные отправлены на Email</h2>';
            echo 'Message has been sent';
          }
          
?>