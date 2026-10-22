<?php


class Subpage
{
	static function Build()
	{
		$message = array();
		if(isset($_GET['read']) && is_numeric($_GET['read']))
		{
			DB::select('messages', 'id = \''.$_GET['read'].'\'');

			if(DB::num_rows())
			{
				$message = DB::fetch_row();

				if($message['name'] == '')
				{
					$message['name'] = 'none';
				}
			}
		}

		elseif(isset($_GET['id']) && is_numeric($_GET['id']))
		{
			DB::query("DELETE FROM messages WHERE id = '".$_GET['id']."' LIMIT 1");
		}

		$messages = array();
		DB::select('messages');
		
		if(DB::num_rows() > 0)
		{
			$messages = DB::fetch_array();
		}

		Load::view('messages', array('message' => $message, 'messages' => $messages), TRUE);
	}
}