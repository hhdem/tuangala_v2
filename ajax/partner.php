<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();
$partner_id = abs(intval($_SESSION['partner_id']));
$action = strval($_GET['action']);
$id = $order_id = abs(intval($_GET['id']));

if ( 'teamdetail' == $action) {
	$team = Table::Fetch('team', $id);
	need_auth($team['partner_id']==$partner_id);
	$partner = Table::Fetch('partner', $team['partner_id']);
	$paycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	));
	$buycount = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'quantity');
	$onlinepay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'money');
	$creditpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'credit');
	$cardpay = Table::Count('order', array(
		'state' => 'pay',
		'team_id' => $id,
	), 'card');
	$couponcount = Table::Count('coupon', array(
		'team_id' => $id,
	));
	$team['state'] = team_state($team);
	$html = render('manage_ajax_dialog_teamdetail');
	json($html, 'dialog');
}
elseif ( 'teamremove' == $action) {
	$team = Table::Fetch('team', $id);
	need_auth($team['partner_id']==$partner_id);
	$order_count = Table::Count('order', array(
		'team_id' => $id,
		'state' => 'pay',
	));
	if ( $order_count > 0 ) {
		json('本团购包含付款订单，不能删除', 'alert');
	}
	$order_count = Table::Count('order', array(
		'team_id' => $id,
		"audit" => 1, //已审核,
	));
	if ( $order_count > 0 ) {
		json('本团购已被管理员审核通过，若确实要删除请联系管理员!', 'alert');
	}
	ZTeam::DeleteTeam($id);

	/* remove coupon */
	$coupons = Table::Fetch('coupon', array($id), 'team_id');
	foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	/* remove order */
	$orders = Table::Fetch('order', array($id), 'team_id');
	foreach($orders AS $one) Table::Delete('order', $one['id']);
	/* end */

	Session::Set('notice', "团购 {$team['product']} 删除成功！");
	json(null, 'refresh');
}

elseif ( 'orderrefund' == $action) {
	$order = Table::Fetch('order', $id);
	$team = Table::Fetch('team', $order['team_id']);
	need_auth($team['partner_id']==$partner_id);
	$rid = strtolower(strval($_GET['rid']));
	if ( $rid == 'credit' ) {
		ZFlow::CreateFromRefund($order);
	} else {
		Table::UpdateCache('order', $id, array(
					'service' => 'cash',
					'state' => 'unpay'
			));
	}
	/* team -- */
	$team = Table::Fetch('team', $order['team_id']);
	team_state($team);
	if ( $team['state'] != 'failure' ) {
		$minus = $team['conduser'] == 'Y' ? 1 : $order['quantity'];
		Table::UpdateCache('team', $team['id'], array(
					'now_number' => array( "now_number - {$minus}", ),
		));
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	/* coupons */
	if ( in_array($team['delivery'], array('coupon', 'pickup') )) {
		$coupons = Table::Fetch('coupon', array($order['id']), 'order_id');
		foreach($coupons AS $one) Table::Delete('coupon', $one['id']);
	}

	/* order update */
	Table::UpdateCache('order', $id, array(
				'card' => 0, 
				'card_id' => '',
				'express_id' => 0,
				'express_no' => '',
				));
	Session::Set('notice', '退款成功');
	json(null, 'refresh');
}
elseif ( 'orderremove' == $action) {
	$order = Table::Fetch('order', $id);
	$team = Table::Fetch('team', $order['team_id']);
	need_auth($team['partner_id']==$partner_id);
	if ( $order['state'] != 'unpay' ) {
		json('付款订单不能删除', 'alert');
	}
	/* card refund */
	if ( $order['card_id'] ) {
		Table::UpdateCache('card', $order['card_id'], array(
			'consume' => 'N',
			'team_id' => 0,
			'order_id' => 0,
		));
	}
	Table::Delete('order', $order['id']);
	Session::Set('notice', "删除订单 {$order['id']} 成功");
	json(null, 'refresh');
}
else if ( 'ordercash' == $action ) {

	$order = Table::Fetch('order', $id);
	$team = Table::Fetch('team', $order['team_id']);
	need_auth($team['partner_id']==$partner_id);

	ZOrder::CashIt($order);
	$user = Table::Fetch('user', $order['user_id']);
	Session::Set('notice', "现金付款成功，购买用户：{$user['email']}");
	json(null, 'refresh');
}
else if ( 'orderview' == $action) {
	$order = Table::Fetch('order', $id);
	$team = Table::Fetch('team', $order['team_id']);
	$user = Table::Fetch('user', $order['user_id']);
	need_auth($team['partner_id']==$partner_id);

	
	if ($team['delivery'] == 'express') {
		$option_express = option_category('express');
	}
	$payservice = array(
		'alipay' => '支付宝',
		'tenpay' => '财付通',
		'chinabank' => '网银在线',
		'credit' => '余额付款',
		'cash' => '线下支付',
	);
	$paystate = array(
		'unpay' => '<font color="green">未付款</font>',
		'pay' => '<font color="red">已付款</font>',
	);
	$option_refund = array(
		'credit' => '退款到账户余额',
		'online' => '其他途径已退款',
	);
	$html = render('biz_ajax_dialog_orderview');
	json($html, 'dialog');
}

elseif ('changeorigin' == $action) {
	$order = Table::Fetch('order', $id);
	$team = Table::Fetch('team', $order['team_id']);
	$user = Table::Fetch('user', $order['user_id']);
	need_auth($team['partner_id']==$partner_id);
	
	$html = render('biz_ajax_dialog_changeorigin');
	json($html, 'dialog');
}

elseif ('drawmoney' == $action) {
	$summoney = current_partner_sum_money($partner_id, 0);
	$condition = array( 'pid'=> $partner_id );
	$sumdrawmoney = Table::Count('partner_drawmoney', $condition, 'drawmoney');
	$html = render('biz_ajax_dialog_drawmoney');
	json($html, 'dialog');
}
