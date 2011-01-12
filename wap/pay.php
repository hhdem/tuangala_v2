<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login(true);

if (is_post()) {
	$order_id = abs(intval($_POST['order_id']));
} else {
	$order_id = $id = abs(intval($_GET['id']));
}
if(!$order_id || !($order = Table::Fetch('order', $order_id))) {
	redirect( 'index.php');
}

/* generator unique pay_id */
if (! ($order['pay_id'] 
			&& (preg_match('#-(\d+)-(\d+)-#', $order['pay_id'], $m) 
				&& ( $m[1] == $order['id'] && $m[2] == $order['quantity']) )
	  )) {
	$randid = rand(1000,9999);
	$pay_id = "go-{$order['id']}-{$order['quantity']}-{$randid}";
	Table::UpdateCache('order', $order['id'], array(
				'pay_id' => $pay_id,
				));
	$order['pay_id'] = $pay_id;
}
/* end */

//payed order
if ( $order['state'] == 'pay' ) {  
	Session::Set('notice', '本单已支付成功');
	redirect("team.php?id={$order['team_id']}");
}

$team = Table::Fetch('team', $order['team_id']);
$randno = rand(1000,9999);

if ($login_user['money'] >= $order['origin']) { 
	$order['service'] = 'credit'; 
} 
else {
	Session::Set('error', '余额不足，请去网页版本先行充值！');
	redirect('index.php');
}

if ( $_POST['service'] == 'credit' ) {
	if ( $order['origin'] > $login_user['money'] ) {
		Table::Delete('order', $order_id);
		redirect('index.php');
	}
	Table::UpdateCache('order', $order_id, array(
				'service' => 'credit',
				'money' => 0,
				'state' => 'pay',
				'credit' => $order['origin'],
				));
	$order = Table::FetchForce('order', $order_id);
	ZTeam::BuyOne($order);
	Session::Set('notice', '购买成功');
	redirect("order.php?id={$order_id}");
}

die(include template('wap_pay'));
