<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$actions = array('store', 'charge', 'withdraw', 'cash', 'refund');

($s = strtolower(strval($_GET['s']))) || ($s = 'store');
if(!$s||!in_array($s, $actions)) $s = 'store';

if ('store' == $s ) {
	$condition = array( 'action' => 'store', );
	$count = Table::Count('flow', $condition);
	$summary = Table::Count('flow', $condition, 'money');
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	$flows = DB::LimitQuery('flow', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'offset' => $offset,
		'size' => $pagesize,
	));
	$user_ids = Utility::GetColumn($flows, 'user_id');
	$admin_ids = Utility::GetColumn($flows, 'admin_id');
	$users = Table::Fetch('user', array_merge($user_ids,$admin_ids));
	include template('manage_misc_money_store');
}
else if ('charge' == $s ) {
	$condition = array( 'action' => 'charge', );
	$count = Table::Count('flow', $condition);
	$summary = Table::Count('flow', $condition, 'money');
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	$flows = DB::LimitQuery('flow', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'offset' => $offset,
		'size' => $pagesize,
	));
	$user_ids = Utility::GetColumn($flows, 'user_id');
	$admin_ids = Utility::GetColumn($flows, 'admin_id');
	$users = Table::Fetch('user', array_merge($user_ids,$admin_ids));
	//$pay_ids = Utility::GetColumn($flows, 'detail_id');
	//$pays = Table::Fetch('pay', $pay_ids);
	include template('manage_misc_money_charge');
}
else if ('withdraw' == $s ) {
	$condition = array( 'action' => 'withdraw', );
	$count = Table::Count('flow', $condition);
	$summary = Table::Count('flow', $condition, 'money');
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	$flows = DB::LimitQuery('flow', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'offset' => $offset,
		'size' => $pagesize,
	));
	$user_ids = Utility::GetColumn($flows, 'user_id');
	$admin_ids = Utility::GetColumn($flows, 'admin_id');
	$users = Table::Fetch('user', array_merge($user_ids,$admin_ids));
	include template('manage_misc_money_store');
}
else if ( 'cash' == $s ) {
	$condition = array( 'service' => 'cash', 'state' => 'pay', );
	$summary = Table::Count('order', $condition, 'money');
	$count = Table::Count('order', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	$orders = DB::LimitQuery('order', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'offset' => $offset,
		'size' => $pagesize,
	));

	$user_ids = Utility::GetColumn($orders, 'user_id');
	$admin_ids = Utility::GetColumn($orders, 'admin_id');
	$users = Table::Fetch('user', array_merge($user_ids,$admin_ids));

	$team_ids = Utility::GetColumn($orders, 'team_id');
	$teams = Table::Fetch('team', $team_ids);
	include template('manage_misc_money_cash');
}
else if ( 'refund' == $s ) {
	$condition = array( 'action' => 'refund', );
	$summary = Table::Count('flow', $condition, 'money');
	$count = Table::Count('flow', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	$flows = DB::LimitQuery('flow', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'offset' => $offset,
		'size' => $pagesize,
	));

	$user_ids = Utility::GetColumn($flows, 'user_id');
	$admin_ids = Utility::GetColumn($flows, 'admin_id');
	$users = Table::Fetch('user', array_merge($user_ids,$admin_ids));

	$team_ids = Utility::GetColumn($flows, 'detail_id');
	$teams = Table::Fetch('team', $team_ids);
	include template('manage_misc_money_refund');
}
else redirect( WEB_ROOT . '/manage/misc/money.php' );
