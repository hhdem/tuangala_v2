<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
require_once(dirname(dirname(__FILE__)) . '/order/paybank.php');

need_login();

$money = abs(intval($_GET['money']));
if (!$money) $money = '';

if($INI['alipay']['mid']) {
	$ordercheck['alipay'] = 'checked';
}
else if($INI['chinabank']['mid']) {
	$ordercheck['chinabank'] = 'checked';
}
else if($INI['tenpay']['mid']) {
	$ordercheck['tenpay'] = 'checked';
}
else if($INI['bill']['mid']) {
	$ordercheck['bill'] = 'checked';
}

$pagetitle = '在线充值';
include template('credit_charge');
