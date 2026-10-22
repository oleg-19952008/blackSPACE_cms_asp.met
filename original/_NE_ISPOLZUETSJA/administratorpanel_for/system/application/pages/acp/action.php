<?php
class Subpage
{
	static $data = array
	(
		'message'	 => 'Управление акциями',
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
			$action = $_POST['nAction'];

		$ice = '[{"NpcId":79,"Count":3},{"NpcId":78,"Count":20},{"NpcId":80,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":4},{"NpcId":35,"Count":1}]';
		$cube = '[{"NpcId":79,"Count":3},{"NpcId":78,"Count":20},{"NpcId":126,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":0},{"NpcId":35,"Count":1}]';

		$stop = '[{"NpcId":79,"Count":3},{"NpcId":78,"Count":20},{"NpcId":80,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":0},{"NpcId":35,"Count":1}]';
		/*
карты
16 = 4-4
26 = 3-6  [{"NpcId":79,"Count":3},{"NpcId":78,"Count":20},{"NpcId":80,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":0},{"NpcId":35,"Count":1}]
22 = 2-6  [{"NpcId":79,"Count":3},{"NpcId":78,"Count":10},{"NpcId":80,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":0},{"NpcId":35,"Count":1}]
18 = 1-6  [{"NpcId":79,"Count":3},{"NpcId":78,"Count":10},{"NpcId":80,"Count":6},{"NpcId":29,"Count":6},{"NpcId":101,"Count":0},{"NpcId":35,"Count":1}]

мобы
101 = айс
80  = обычный куб
		*/

        
        if($action == 'stop'){
			
			$update1 = DB::query("UPDATE maps SET NPCS = '".$stop."' WHERE id = '18'");
			$update1 = DB::query("UPDATE maps SET NPCS = '".$stop."' WHERE id = '22'");
			$update1 = DB::query("UPDATE maps SET NPCS = '".$stop."' WHERE id = '26'");

			 self::message("Все акции отключены", 'green');

		}
		
		if($action == 1){
			$update1 = DB::query("UPDATE maps SET NPCS = '".$ice."' WHERE id = '18'");
			$update1 = DB::query("UPDATE maps SET NPCS = '".$ice."' WHERE id = '22'");
			$update1 = DB::query("UPDATE maps SET NPCS = '".$ice."' WHERE id = '26'");
			 self::message("ICE Включены. Перезапустите эмулятор!", 'red');

			
		}
		if($action == 2){
			// $update1 = DB::query("UPDATE maps SET NPCS = '".$cube."' WHERE id = '18'");
			// $update1 = DB::query("UPDATE maps SET NPCS = '".$cube."' WHERE id = '22'");
			// $update1 = DB::query("UPDATE maps SET NPCS = '".$cube."' WHERE id = '26'");

			 self::message("пока не работает!", 'red');
			 // self::message("Кубы Включены. Перезапустите эмулятор!", 'red');

			
		}
		
		
			
			
                 
		}
		

		Load::view('action', self::$data, TRUE);
	}

	static function message($message, $color = 'red')
	{
		self::$data['message'] = '<b style=\'color:'.$color.';\'>'.$message.'</b>';
	}
}