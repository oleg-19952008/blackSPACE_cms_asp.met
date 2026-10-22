<?php
function bbcode($text)
{
	// First: If there isn't a "[" and a "]" in the message, don't bother.
	$text = ' ' . nl2br($text);
	if ( !( strpos( $text, "[" ) && strpos( $text, "]" ) ) ) return $text;	 

	$text = stripslashes( $text);
	$text = preg_replace( "/\\[b\\](.+?)\[\/b\]/is", '<b>\1</b>', $text);
	$text = preg_replace( "/\\[C\\](.+?)\[\/C\]/is", '<span align="center">\1</span>', $text);
	$text = preg_replace( "/\\[i\\](.+?)\[\/i\]/is", '<i>\1</i>', $text);
	$text = preg_replace( "/\\[u\\](.+?)\[\/u\]/is", '<u>\1</u>', $text);
	$text = preg_replace( "/\[s\](.+?)\[\/s\]/is", '<s>\1</s>', $text);
	$text = @eregi_replace( "\\[url=([^\\[]*)\\]([^\\[]*)\\[/url\\]", "<a href=\"\\1\">\\2</a>", $text);
	$text = @eregi_replace( "\\[url\\]([^\\[]*)\\[/url\\]", "<a href=\"\\1\">\\1</a>", $text);
	return $text;
}