<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$action = strval($_GET['action']);

if ( 'unsubscribe' == $action ) {
	$html = render('ajax_dialog_smsun');
	json($html, 'dialog');
}
elseif ( 'unsubscribecheck' == $action ) {
	$mobile = trim(strval($_GET['mobile']));
	$verifycode= trim(strval($_GET['verifycode']));
	if ( Utility::CaptchaCheck($verifycode) ) {
		$sms = Table::Fetch('smssubscribe', $mobile, 'mobile');
		if ( !$sms ) {
			$html = render('ajax_dialog_smsunsuc');
		} else if ( $sms['enable'] == 'N' ) {
			ZSMSSubscribe::UnSubscribe($mobile);
			$html = render('ajax_dialog_smsunsuc');
		} else {
			$secret = ZSMSSubscribe::Secret($mobile);
			$html = render('ajax_dialog_smscode');
			sms_secret($mobile, $secret, false);
		}
		json($html, 'dialog');
	} else {
		json( 'captcha_again();', 'eval' );
	}
}
else if ( 'subscribe' == $action ) {
	$html = render('ajax_dialog_smssub');
	json($html, 'dialog');
} 
elseif ( 'subscribecheck' == $action ) {
	$mobile = trim(strval($_GET['mobile']));
	$verifycode= trim(strval($_GET['verifycode']));
	$city_id = abs(intval($_GET['city_id']));
	$secret = Utility::VerifyCode();
	if ( Utility::CaptchaCheck($verifycode) ) {
		if ( ZSMSSubscribe::Create($mobile, $city_id, $secret) === true ) {
			$html = render('ajax_dialog_smssuc');
		} else {
			$html = render('ajax_dialog_smscode');
			sms_secret($mobile, $secret, true);
		}
		json($html, 'dialog');
	} else {
		json( 'captcha_again();', 'eval' );
	}
}
else if ( 'codeyes' == $action ) {
	$mobile = trim(strval($_GET['mobile']));
	$secretcode= trim(strval($_GET['secretcode']));
	$sms = Table::Fetch('smssubscribe', $mobile, 'mobile');
	if ( !$sms ) {
		json(array(
					array('data' => '非法访问！', 'type'=>'alert'),
					array('data' => 'X.boxClose();', 'type'=>'eval'),
				  ), 'mix');
	}

	if ($sms['secret'] != $secretcode) {
		json('短信认证码不正确，请重新输入！', 'alert');
	}

	if ($sms['enable'] == 'Y') {
		ZSMSSubscribe::Unsubscribe($mobile);
		$html = render('ajax_dialog_smsunsuc');
		json($html, 'dialog');
	}
	else {
		ZSMSSubscribe::Enable($mobile, true);
		$html = render('ajax_dialog_smssuc');
		json($html, 'dialog');
	}
}
