<?php
class Users
{
	public $DataRow = null;
	public function checkSession()
	{
		global $MySQLi;
		if(isset($_SESSION['server1']['user']['sessionId'], $_SESSION['server1']['user']['email']) && is_numeric($_SESSION['server1']['user']['sessionId'])):
			$userRow = $MySQLi->query('SELECT users.ID, users.Email, users.Name, users.regDate, server_1_players.playerID, server_1_players.userID, server_1_players.shipId, server_1_players.premium, server_1_players.factionId, server_1_players.GGspins, server_1_players.credits, server_1_players.uri, server_1_players.level, server_1_players.exp, server_1_players.honor FROM users, server_1_players WHERE users.sessionId = \'' . $_SESSION['server1']['user']['sessionId'] . '\' AND users.Email = \'' . $_SESSION['server1']['user']['email'] . '\' AND server_1_players.userID = users.ID');
			if($userRow && $userRow->num_rows === 1):
				$this->DataRow = $userRow->fetch_assoc();
			endif;
		endif;
	}
        public function changeUsername($new, $pw, $uid, $pid){
	global $MySQLi;
		$row = $MySQLi->query('SELECT * FROM users INNER JOIN server_1_players ON server_1_players.userID=users.ID WHERE users.ID="'.$uid.'"');
		if($row && $row->num_rows === 1):
				$userInfo = $row->fetch_assoc();
                                if($userInfo['pwHash'] == md5($pw)){
                                    if(strlen($new)>10 OR strlen($new)<3):
                                        return "Max 10 characters, minimum 3 characters";
                                    endif;
                                    if(self::checkName($new)){
                                        return "Name is in use";
                                    }else{
                                        return self::ChangeNow($userInfo, $new, $uid, $pid); 
                                    }
                                }else{
                                    return "error";
                                }
		endif;
	}
        private function checkName($name){
            global $MySQLi;
            $w = $MySQLi->query('SELECT ID FROM users WHERE Name="'.$name.'"');
            if($w && $w->num_rows === 1):
                 return TRUE;
                else:
                 return FALSE;
            endif;
        }
         private function ChangeNow($userInfo, $new, $uid, $pid){
           global $MySQLi;
            $now = time();
            $lst =  date('Y-m-d H:i:s',  strtotime(str_replace('-','/', $userInfo['change_time'])));
            $hour = abs($lst - $now)/(60*60);
//            if($hour>=24):
                $MySQLi->query('UPDATE server_1_players SET change_time=now() WHERE playerID="'.$pid.'"');
                $MySQLi->query('UPDATE users SET Name="'.$new.'" WHERE ID="'.$uid.'"');
                return "Your name is changed to: ".$new;
//                else:
//                return "You need to wait ".$hour." hours to change Username";
//            endif;
        }
}
?>