<?php
function sms_send($phone, $content) {
	global $INI;
	if (mb_strlen($content, 'UTF-8') < 20) {
		return '短信长度低于20汉字？长点吧～';
	}
	$user = strval($INI['sms']['user']); 
	$pass = strtolower(md5($INI['sms']['pass']));
	if(null==$user) return true;
	$content = urlEncode($content);
	$api = "http://notice.zuitu.com/sms?user={$user}&pass={$pass}&phones={$phone}&content={$content}";
	$res = Utility::HttpRequest($api);
	return trim(strval($res))=='+OK' ? true : strval($res);
}

function sms_secret($mobile, $secret, $enable=true) {
	global $INI;
	$funccode = $enable ? '订阅' : '退订';
	$content = "{$INI['system']['sitename']}，您的手机号：{$mobile} 短信{$funccode}功能认证码：{$secret}。";
	sms_send($mobile, $content);
}

function sms_coupon($coupon, $mobile=null) {
	global $INI;
	if ( $coupon['consume'] == 'Y' 
			|| $coupon['expire_time'] < strtotime(date('Y-m-d'))) {
		return $INI['system']['couponname'] . '已失效';
	}

	$user = Table::Fetch('user', $coupon['user_id']);
	$order = Table::Fetch('order', $coupon['order_id']);

	if (!Utility::IsMobile($mobile)) {
		$mobile = $order['mobile'];
		if (!Utility::IsMobile($mobile)) {
			$mobile= $user['mobile'];
		}
	}
	if (!Utility::IsMobile($mobile)) {
		return '请设置合法的手机号码，以便接受短信';
	}
	$team = Table::Fetch('team', $coupon['team_id']);
	$partner = Table::Fetch('partner', $coupon['partner_id']);

	$coupon['end'] = date('Y-n-j', $coupon['expire_time']);
	$coupon['name'] = $team['product'];
	$content = render('manage_tpl_smscoupon', array(
				'partner' => $partner,
				'coupon' => $coupon,
				'user' => $user,
				));

	if (true===($code=sms_send($mobile, $content))) {
		Table::UpdateCache('coupon', $coupon['id'], array(
					'sms' => array('`sms` + 1'),
					'sms_time' => time(),
					));
		return true;
	}
	return $code;
}
