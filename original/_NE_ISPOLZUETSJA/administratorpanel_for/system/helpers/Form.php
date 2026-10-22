<?php


if(!defined('FLAMEWORK')) die();


function create_form($action = '?index', $inputs = array(), $save = FALSE)
{
	echo "<form method='post' action='$action'>\n";
	echo "<table>\n";
	
	if(is_array($inputs))
	{
		foreach($inputs as $name => $attributes)
		{
			$attributes = _parse_attributes($attributes, $name, $save);
			
			echo "	<tr>\n";
			echo "		<td><small>{$attributes['label']}</small></td>\n";
			echo '		<td>';
			switch($attributes['kind'])
			{
				case 'input':
					echo "<input type='{$attributes['type']}' name='$name' value='{$attributes['value']}'>";
					break;
			}
			
			echo "</td>\n";
			echo "	</tr>\n";
		}
	}
	
	echo "</table>\n";
	echo '</form>';
}

function _parse_attributes($attributes = array(), $name = '', $save = FALSE)
{
	switch($attributes['kind'])
	{
		case 'input': $required = array('label' => '', 'type' => 'text', 'value' => ''); break;
	}
	
	foreach($required as $k => $v)
	{		
		if(!isset($attributes[$k]))
		{
			$attributes[$k] = $v;
		}
	}

	if($save == TRUE)
	{
		if(isset($_POST[$name]))
		{
			$attributes['value'] = $_POST[$name];
		}
	}

	return $attributes;
}
?>