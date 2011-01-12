<?php
require_once(dirname(__FILE__) . '/app.php');

$id = abs(intval($_GET['r']));
if ($id) { 
	if ($login_user_id) {
		ZInvite::CreateFromId($id, $login_user_id);
	} else {
		$longtime = 86400 * 3; //3 days
		cookieset('_rid', $id, $longtime);
	}
}
redirect( WEB_ROOT  . '/index.php');
