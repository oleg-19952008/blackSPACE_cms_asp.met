<?php
class Subpage
{
	static $data = array
	(
		'message'	 => '',
		'hh'	     => '',
		'reg'	     => '',
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
			$system = $_POST['add'];



		$reg_stat = DB::query("SELECT * FROM `system` WHERE id = '1'") ->fetch_assoc();
		



		$ice = '[{"NpcId":79,"Count":3},{"NpcId":78,"Count":20},{"NpcId":80,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":4},{"NpcId":35,"Count":1}]';
		$cube = '[{"NpcId":79,"Count":3},{"NpcId":78,"Count":20},{"NpcId":126,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":0},{"NpcId":35,"Count":1}]';

		$stop = '[{"NpcId":79,"Count":3},{"NpcId":78,"Count":20},{"NpcId":80,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":0},{"NpcId":35,"Count":1}]';
		


        
        if($system == 'reg'){
        	if ($reg_stat['registration'] == 0) {
				$update1 = DB::query("UPDATE system SET registration = '1' WHERE id = '1'");
			    self::message("Регистрация включена", 'green');
        	}
        	elseif ($reg_stat['registration'] == 1) {
				$update1 = DB::query("UPDATE system SET registration = '0' WHERE id = '1'");
			    self::message("Регистрация отключена", 'red');
        	}
		


		}
		
		if($system == "hh"){
			if ($reg_stat['hh'] == 0) {
				$update1 = DB::query("UPDATE system SET hh = '1' WHERE id = '1'");
			    self::message("Happy Hour включен", 'green');
        	}
        	elseif ($reg_stat['hh'] == 1) {
				$update1 = DB::query("UPDATE system SET hh = '0' WHERE id = '1'");
			    self::message("Happy Hour отключен", 'red');
        	}
		}
		if($system == 2){
			// $update1 = DB::query("UPDATE maps SET NPCS = '".$cube."' WHERE id = '18'");
			// $update1 = DB::query("UPDATE maps SET NPCS = '".$cube."' WHERE id = '22'");
			// $update1 = DB::query("UPDATE maps SET NPCS = '".$cube."' WHERE id = '26'");

			 self::message("пока не работает!", 'red');
			 // self::message("Кубы Включены. Перезапустите эмулятор!", 'red');

			
		}
		
		
			
			
                 
		}
		

		Load::view('system', self::$data, TRUE);
	}

        	if ($reg_stat['registration'] == 0) {
				self::$data['reg'] = '<b style=\'color:red;\'>Выкл</b>';
				
        	}
        	elseif ($reg_stat['registration'] == 1) {
				self::$data['reg'] = '<b style=\'color:lime;\'>Вкл</b>';				
        	}

		
	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
		
	}
}