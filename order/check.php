<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(__FILE__) . '/paybank.php');

$id = abs(intval($_GET['id']));
$order = Table::Fetch('order', $id);
if (!$order) { 
	Session::Set('error', '订单不存在');
	redirect( WEB_ROOT . '/index.php' );
}
if ( $order['user_id'] != $login_user['id']) {
	redirect( WEB_ROOT . "/team.php?id={$order['team_id']}");
}
$team = Table::Fetch('team', $order['team_id']);
$team['state'] = team_state($team);

if ( $team['close_time'] ) {
	redirect( WEB_ROOT . "/team.php?id={$id}");
}

if ( $order['state'] == 'unpay' ) {
	if($INI['alipay']['mid'] && $order['service']=='alipay') {
		$ordercheck['alipay'] = 'checked';
	}
	else if($INI['chinabank']['mid'] && $order['service']=='chinabank') {
		$ordercheck['chinabank'] = 'checked';
	}
	else if($INI['tenpay']['mid'] && $order['service']=='tenpay') {
		$ordercheck['tenpay'] = 'checked';
	}
	else if($INI['bill']['mid'] && $order['service']=='bill') {
		$ordercheck['bill'] = 'checked';
	}
	else if($INI['paypal']['acc'] && $order['service']=='paypal') {
		$ordercheck['paypal'] = 'checked';
	}

	else if($INI['alipay']['mid']) {
		$ordercheck['alipay'] = 'checked';
	}
	else if($INI['tenpay']['mid']) {
		$ordercheck['tenpay'] = 'checked';
	}
	else if($INI['chinabank']['mid']) {
		$ordercheck['chinabank'] = 'checked';
	}
	else if($INI['bill']['mid']) {
		$ordercheck['bill'] = 'checked';
	}
	else if($INI['paypal']['acc']) {
		$ordercheck['paypal'] = 'checked';
	}

	$credityes = ($login_user['money'] >= $order['origin']);
	$creditonly = ($team['team_type'] == 'seconds' && option_yes('creditseconds'));

	/* generator unique pay_id */
	if (! ($order['pay_id'] 
				&& (preg_match('#-(\d+)-(\d+)-#', $order['pay_id'], $m) 
					&& ( $m[1] == $order['id'] && $m[2] == $order['quantity']) )
		  )) {
		$randid = rand(1000,9999);
		$pay_id = "tgl-{$order['id']}-{$order['quantity']}-{$randid}";
		Table::UpdateCache('order', $order['id'], array(
					'pay_id' => $pay_id,
					));
	}

	die(include template('order_check'));
}

redirect( WEB_ROOT . "/order/view.php?id={$id}");
