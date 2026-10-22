<?php
class Page
{
	static $data = array();

	static function Build($start = 1)
	{
		
		$start = (is_numeric($start) && $start > 0) ? $start : 1;
		self::$data['start'] = $start;

		$category = (isset($_GET['category']) && is_numeric($_GET['category'])) ? $_GET['category'] : FALSE;		
		self::$data['category'] = $category;

		Load::view('contact', self::$data);
	}

	static function points()
	{
		DB::query("SELECT Full_name, points FROM users ORDER BY points DESC LIMIT 5");
		self::$data['count'] = DB::num_rows();

		if(DB::num_rows() > 0)
		{
			$return = DB::fetch_array();
		
			if(DB::num_rows() > Config::item('sites_per_page'))
			{
				$i = 0;
				$new = array();

				while(Config::item('sites_per_page') > $i)
				{
					$new[] = $return[$i];
					$i++;
				}
				
				$return = $new;
			}
	
			return $return;
		}

		return array();
	}

	static function paginate()
	{
		$p			= '';
		$start		= self::$data['start'];
		$news		= self::$data['count'];
		$max		= Config::item('sites_per_page');
		$category	= self::$data['category'];
		
		if($start > $max + 1 || (($start > $max) == FALSE && $start != 1))
		{
			$p .= '<a href=\'?index=1&category='.$category.'\'><</a> ';
		}

		if($start > $max)
		{
			$page = $start - $max;
			$p .= '<a href=\'?index='.$page.'&category='.$category.'\'>'.$page.'</a> ';
		}
		
		$page = $start + $max;
		$p .= $start . ' ';

		if($max <= $news - 1)
		{
			$p .= '<a href=\'?index='.$page.'&category='.$category.'\'>'.$page.'</a> ';
		}

		if( (($start + $max < $news) == FALSE && ($start + $max < $news - $max + 1)) || ($page < $news - $max + 1))
		{
			$page = $news - $max + 1;
			$p .= '<a href=\'?index='.$page.'&category='.$category.'\'>></a>';
		}

		if($p != $start . ' ')
		{
			echo $p;
		}
	}
}