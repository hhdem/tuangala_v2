<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$action = strval($_GET['action']);
$aid = strval($_GET['id']);

if ( 'modify' == $action ) {
	if ($aid) {
		$address = Table::Fetch('user_address', $aid);
		if (!$address) json('无数据', 'alert');
	}
	$html = render('ajax_dialog_address');
	json($html, 'dialog');
}
else if($action == 'delete') {
	$addr = Table::Fetch('user_address', $aid);
	if (!$addr) json('无数据', 'alert');
	Table::Delete('user_address', $aid);
	Session::Set('notice', '删除地址成功');
	json(null, 'refresh');
}
