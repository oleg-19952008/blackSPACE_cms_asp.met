<?php


if(!defined('IN_TOPSITE')) die();

function write($filename, $content = '')
{
	if(file_exists($filename))
	{
		if(is_writable($filename))
		{
			$fh = fopen($filename, 'w+');
			fwrite($fh, $content);
			fclose($fh);
			return TRUE;
		}
	}
	
	return FALSE;
}

function append($filename, $content)
{
	if(file_exists($filename))
	{
		$previous = file_get_contents($filename);
		$content  = $previous . $content;
		write($filename, $content);
	}
}
?>