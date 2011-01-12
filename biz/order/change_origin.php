<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_partner();
$id = $_GET['id'];
if (!$id) $id = $_POST['id'];
$order = Table::Fetch('order', $id);
$team = Table::Fetch('team', $order['team_id']);
$user = Table::Fetch('user', $order['user_id']);
need_auth($team['partner_id']==$partner_id);

if ($_POST) {
	$table = new Table('order', $_POST);
	Table::UpdateCache('order', $_POST['id'], array(
		'origin' => intval($_POST['origin']),
	));
	Session::Set('notice', '修改订单金额成功');
		redirect( WEB_ROOT. "/biz/order/index.php");
	
}