<?php


class Subpage
{
	static function Build()
	{
		if(isset($_POST['add']))
		{
			if(!empty($_POST['name']))
			{
				DB::query("INSERT INTO categories SET name = '".$_POST['name']."'");
			}
		}

		elseif(isset($_GET['id']) && is_numeric($_GET['id']))
		{
			DB::query("DELETE FROM categories WHERE id = '".$_GET['id']."' LIMIT 1");
		}

		$categories = array();
		DB::query("SELECT * FROM categories");
		
		if(DB::num_rows() > 0)
		{
			$categories = DB::fetch_array();
		}

		Load::view('categories', array('categories' => $categories), TRUE);
	}
}