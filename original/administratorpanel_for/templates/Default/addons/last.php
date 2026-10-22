<?php
function can_edit($site)
{
	return ((User::$isLoggedin == TRUE && User::$id == $site['id']) || User::$isAdmin == TRUE) ? TRUE : FALSE;
}

function show_banner($site)
{
	return ($site['isMember'] == TRUE && !empty($site['banner']) && $site['banner'] != 'http://') ? TRUE : FALSE;
}