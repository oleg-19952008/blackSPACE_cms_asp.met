<?php
class Subpage
{
	static $data = array
	(
		'message'	 => 'Прописать бан тут!',
		'color'		 => 'blue',
		'user'		 => array(),
		'type'		 => 'title',
		'search'	 => '',
		'results'		 => array(),
	);

	static function Build()
	{
		if(User::$isAdmin == FALSE)
		{
			redirect();
		}
                if(isset($_POST['add']))
		{
			$id = $_POST['uID'];
			$ban = $_POST['nBan'];

		$calc[0] = "/100*25";
		$calc[1] = "/100*35";
		$calc[2] = "/100*50";
		$exp_calc[0] = "/100*10";
		$exp_calc[1] = "/100*25";
		$exp_calc[2] = "/100*40";
		$banntime[0] = date("Y-m-d H:i:s",time()+86400);
		$banntime[1] = date("Y-m-d H:i:s",time()+604800);
        
        if($ban == 0){
			
			$update2 =  DB::query("UPDATE users SET banned = '0', banned_until = NULL WHERE ID = '".$id."'");
			 self::message("Разбанил!", 'green');

		}

		if($ban == 1){
			$update1 = DB::query("UPDATE server_1_players SET uri = (uri - (uri ".$calc[0].")), credits = (credits - (credits ".$calc[0].")), honor = (honor - (honor ".$calc[0].")),exp = (exp - (exp ".$exp_calc[0].")) WHERE playerID = '".$id."'");
			 self::message("Снял", 'red');

			
		}
		if($ban == 2){
			$update1 = DB::query("UPDATE server_1_players SET uri = (uri - (uri ".$calc[1].")), credits = (credits - (credits ".$calc[1].")), honor = (honor - (honor ".$calc[1].")),exp = (exp - (exp ".$exp_calc[1].")) WHERE playerID = '".$id."'");
			$update2 =  DB::query("UPDATE users SET banned_until = '".$banntime[0]."' WHERE ID = '".$id."'");

			 self::message("Снял и въебал 1 день", 'red');

			
		}
		if($ban == 3){
			$update1 = DB::query("UPDATE server_1_players SET uri = (uri - (uri ".$calc[2].")), credits = (credits - (credits ".$calc[2].")), honor = (honor - (honor ".$calc[2].")), exp = (exp - (exp ".$exp_calc[2].")) WHERE playerID = '".$id."'");
			$update2 =  DB::query("UPDATE users SET banned_until = '".$banntime[1]."' WHERE ID = '".$id."'");
			 self::message("Снял дохуя и въебал неделю", 'red');

			
		}
		if($ban == 4){
			$update2 =  DB::query("UPDATE users SET banned = '1' WHERE ID = '".$id."'");
			
			 self::message("Всё, пиздец! Перманент", 'red');
		}
			
			
                 
		}
		

		Load::view('ban', self::$data, TRUE);
	}

	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}