<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$n = strval($_GET['n']);
$v = strval($_GET['v']);

if ( 'signupemail' == $n ) {
	$u = Table::Fetch('user', $v, 'email');
	if ( $u ) Output::Json(null, 1);
	Output::Json(0);
}
elseif ( 'signupname' == $n ) {
	$slength = strlen($v);
	if ($slength<4) Output::Json(null, 1);
	$u = Table::Fetch('user', $v, 'username');
	if ( $u ) Output::Json(null, 1);
	Output::Json(0);
}
elseif ( 'signupmobile' == $n ) {
	$u = Table::Fetch('user', $v, 'mobile');
	if ( $login_user['id'] == $u['id'] ) return Output::Json(0);
	if ( $u ) Output::Json(null, 1);
	Output::Json(0);
}
elseif ( 'signuppartnername' == $n ) {
	$slength = strlen($v);
	if ($slength<4) Output::Json(null, 1);
	$u = Table::Fetch('partner', $v, 'username');
	if ( $u ) Output::Json(null, 1);
	Output::Json(0);
}