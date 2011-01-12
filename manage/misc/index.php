<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
$daytime = strtotime(date('Y-m-d'));

$team_count = Table::Count('team');
$order_count = Table::Count('order');
$user_count = Table::Count('user');
$subscribe_count = Table::Count('subscribe');

$order_today_count = Table::Count('order', array(
	"create_time > {$daytime}",
));
$order_today_pay_count = Table::Count('order', array(
	"create_time > {$daytime}",
	'state' => 'pay',
));
$order_today_unpay_count = $order_today_count - $order_today_pay_count;

$user_today_count = Table::Count('user', array(
	"create_time > {$daytime}",
));

$income_pay = Table::Count('order', array(
	"create_time > {$daytime}",
	'state' => 'pay',
), 'money');

$income_charge = Table::Count('flow', array(
	"create_time > {$daytime}",
	'action' => 'charge',
), 'money');

$income_store= Table::Count('flow', array(
	"create_time > {$daytime}",
	'action' => 'store',
), 'money');

$income_withdraw = Table::Count('flow', array(
	"create_time > {$daytime}",
	'action' => 'withdraw',
), 'money');

include template('manage_misc_index');
