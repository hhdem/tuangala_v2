<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$vid = '';
if ($login_user['passowrd']) {
	$vid = ZUser::GenPassword($login_user['passowrd'].time());
	Session::Set('vid', $vid);
}
$ramd = rand(1, 5);
if ( $_POST ) {
	if ( $_REQUEST['vid']) {
		
	}
}

include template('play_puzzle');