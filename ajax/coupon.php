<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);
$cid = strval($_GET['id']);
$sid = strval($_GET['sid']);
$sec = strval($_GET['secret']);

if ($action == 'dialog') {
	$html = render('ajax_dialog_coupon');
	json($html, 'dialog');
}
else if($action == 'query') {
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);
	$e = date('Y-m-d', $team['expire_time']);

	if (!$coupon) { 
		$v[] = "#{$cid}&nbsp;无效";
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = $INI['system']['couponname'] . '无效';
		$v[] = '消费于：' . date('Y-m-d H:i:s', $coupon['consume_time']);
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = "#{$cid}&nbsp;已过期";
		$v[] = '过期日期：' . date('Y-m-d', $coupon['expire_time']);
	} else {
		$v[] = "#{$cid}&nbsp;有效";
		$v[] = "{$team['title']}";
		$v[] = "有效期至&nbsp;{$e}";
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	json($d, 'updater');
}

else if($action == 'consume') {
	$coupon = Table::FetchForce('coupon', $cid);
	$partner = Table::Fetch('partner', $coupon['partner_id']);
	$team = Table::Fetch('team', $coupon['team_id']);

	if (!$coupon) {
		$v[] = "#{$cid}&nbsp;无效";
		$v[] = '本次消费失败';
	}
	else if ($coupon['secret']!=$sec) {
		$v[] = $INI['system']['couponname'] . '编号密码不正确';
		$v[] = '本次消费失败';
	} else if ( $coupon['expire_time'] < strtotime(date('Y-m-d')) ) {
		$v[] = "#{$cid}&nbsp;已过期";
		$v[] = '过期时间：' . date('Y-m-d', $coupon['consume_time']);
		$v[] = '本次消费失败';
	} else if ( $coupon['consume'] == 'Y' ) {
		$v[] = "#{$cid}&nbsp;已消费";
		$v[] = '消费于：' . date('Y-m-d H:i:s', $coupon['consume_time']);
		$v[] = '本次消费失败';
	} else {
		ZCoupon::Consume($coupon);
		//credit to user'money'
		$tip = ($coupon['credit']>0) ? " 返利{$coupon['credit']}元" : '';
		$v[] = $INI['system']['couponname'] . '有效';
		$v[] = '消费时间：' . date('Y-m-d H:i:s', time());
		$v[] = '本次消费成功' . $tip;
	}
	$v = join('<br/>', $v);
	$d = array(
			'html' => $v,
			'id' => 'coupon-dialog-display-id',
			);
	json($d, 'updater');
}
else if ($action == 'sms') {
	$coupon = Table::Fetch('coupon', $sid);
	if ( $coupon['sms']>=5 && !is_manager() ) { 
		json('短信发送'.$INI['system']['couponname'].'最多5次, 如有任何疑问请联系客服!', 'alert'); 
	}
	$interval = abs(intval($INI['sms']['interval']));
	$lefttime = $interval + $coupon['sms_time'] - time();
	if ( !is_manager() && $lefttime>0 ) {
		json("你好，请在{$lefttime}秒后，再次尝试短信发送优惠券".$INI['system']['couponname'], 'alert');
	}
	if (!$coupon||!is_login()||($coupon['user_id']!= ZLogin::GetLoginId()&&!is_manager())) {
		json($cid, 'alert');
	}
	$flag = sms_coupon($coupon);
	if ( $flag === true ) {
		json('手机短信发送成功，请及时查收', 'alert');
	} else if ( is_string($flag) ) {
		json($flag, 'alert');
	}
	json("手机短信发送失败，错误码：{$code}", 'alert');
}
