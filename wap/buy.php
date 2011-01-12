<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login(true);

$id = abs(intval($_GET['id']));

$team = Table::Fetch('team', $id);
if ( !$team || $team['begin_time']>time() ) {
	Session::Set('error', '团购项目不存在');
	redirect( 'index.php' );
}
team_state($team);
if ($team['close_time']) {
	Session::Set('error', '团购项目已结束，不能再次购买');
	redirect( 'index.php' );
}

//whether buy
$ex_con = array(
		'user_id' => $login_user_id,
		'team_id' => $team['id'],
		'state' => 'unpay',
		);
$order = DB::LimitQuery('order', array(
	'condition' => $ex_con,
	'one' => true,
));

//buyonce
if (strtoupper($team['buyonce'])=='Y') {
	$ex_con['state'] = 'pay';
	if ( Table::Count('order', $ex_con) ) {
		Session::Set('error', '您已经成功购买了本单产品，请勿重复购买，快去关注一下其他产品吧！');
		redirect( "now.php"); 
	}
}

//peruser buy count
if ($team['per_number']>0) {
	$now_count = Table::Count('order', array(
		'user_id' => $login_user_id,
		'team_id' => $id,
		'state' => 'pay',
	), 'quantity');
	$team['per_number'] -= $now_count;
	if ($team['per_number']<=0) {
		Session::Set('error', '您购买本单产品的数量已经达到上限，快去关注一下其他产品吧！');
		redirect( 'now.php' ); 
	}
}

//post buy
if ( $_POST ) {
	need_login(true);
	$table = new Table('order', $_POST);
	$table->quantity = abs(intval($table->quantity));

	if ( $table->quantity == 0 ) {
		Session::Set('error', '购买数量不能小于1份');
		redirect( "team.php?id={$team['id']}");
	} 
	elseif ( $team['per_number']>0 && $table->quantity > $team['per_number'] ) {
		Session::Set('error', '您本次购买本单产品已超出限额！');
		redirect( "team.php?id={$id}"); 
	}

	if ($order && $order['state']=='unpay') {
		$table->id = $order['id'];
	}

	$table->user_id = $login_user_id;
	$table->team_id = $team['id'];
	$table->city_id = $team['city_id'];
	$table->express = ($team['delivery']=='express') ? 'Y' : 'N';
	$table->fare = $table->express=='Y' ? $team['fare'] : 0;
	$table->price = $team['team_price'];
	$table->credit = 0;
	$table->state = 'unpay';

	if ( $table->id ) {
		$eorder = Table::Fetch('order', $table->id);
		$table->origin = ($table->quantity * $team['team_price']) + ($team['delivery'] == 'express' ? $team['fare'] : 0) - $eorder['card'];
	} else {
		$table->create_time = time();
		$table->origin = ($table->quantity * $team['team_price']) + ($team['delivery'] == 'express' ? $team['fare'] : 0);
	}

	if ($team['delivery']=='express') {
		if (!$table->address 
			|| !Utility::IsMobile($table->mobile)
			|| !$table->zipcode
			|| !$table->realname
			) {
			Session::Set('error', '购买选项填写不完整');
			Session::Set('loginpagepost', json_encode($_POST));
			redirect("buy.php?id={$team['id']}");
		}
	}

	$insert = array(
			'user_id', 'team_id', 'city_id', 'state', 
			'fare', 'express', 'origin', 'price',
			'address', 'zipcode', 'realname', 'mobile', 'quantity',
			'create_time', 'remark',
		);
	
	if ($flag = $table->update($insert)) {
		$order_id = abs(intval($table->id));
		redirect("pay.php?id={$order_id}");
	}
}

//each user per day per buy
if (!$order) { 
	$order = json_decode(Session::Get('loginpagepost'),true);
	settype($order, 'array');
	if ($order['mobile']) $login_user['mobile'] = $order['mobile'];
	if ($order['zipcode']) $login_user['zipcode'] = $order['zipcode'];
	if ($order['address']) $login_user['address'] = $order['address'];
	if ($order['realname']) $login_user['realname'] = $order['realname'];
	$order['quantity'] = 1;
}
//end;

$order['origin'] = ($order['quantity'] * $team['team_price']) + ($team['delivery']=='express' ? $team['fare'] : 0);

if ($team['max_number']>0 && $team['conduser']=='N') {
	$left = $team['max_number'] - $team['now_number'];
	if ($team['per_number']>0) {
		$team['per_number'] = min($team['per_number'], $left);
	} else {
		$team['per_number'] = $left;
	}
}

include template('wap_buy');
