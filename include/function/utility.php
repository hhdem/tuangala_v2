<?php
function get_city($ip=null) {
	$cities = option_category('city', false, true);
	$ip = ($ip) ? $ip : Utility::GetRemoteIP();
	$url = "http://open.baidu.com/ipsearch/s?wd={$ip}&tn=baiduip";
	$res = mb_convert_encoding(Utility::HttpRequest($url), 'UTF-8', 'GBK');
	if ( preg_match('#来自：<b>(.+)</b>#Ui', $res, $m) ) {
		foreach( $cities AS $one) {
			if ( FALSE !== strpos($m[1], $one['name']) ) {
				return $one;
			}
		}
	}
	return array();
}

function mail_zd($email) {
	global $option_mail;
	if ( ! Utility::ValidEmail($email) ) return false;
	preg_match('#@(.+)$#', $email, $m);
	$suffix = strtolower($m[1]);
	return $option_mail[$suffix];
}

function nanooption($string) {
	if ( preg_match_all('#{(.+)}#U', $string, $m) ){
		return $m[1];
	}
	return array();
}

global $striped_field;
$striped_field = array(
	'username',
	'realname',
	'name',
	'tilte',
	'email',
	'address',
	'mobile',
	'url',
	'logo',
	'contact',
);

global $option_gender;
$option_gender = array(
		'F' => '女',
		'M' => '男',
		);
global $option_pay;
$option_pay = array(
		'pay' => '已支付',
		'unpay' => '未支付',
		);
global $option_service;
$option_service = array(
		'alipay' => '支付宝',
		'tenpay' => '财付通',
		'chinabank' => '网银在线',
		'cash' => '现金支付',
		'credit' => '余额付款',
		'other' => '其他',
		);
global $option_delivery;
$option_delivery = array(
		'express' => '快递',
		'coupon' => '券',
		'pickup' => '自取',
		);
global $option_flow;
$option_flow = array(
		'buy' => '购买',
		'invite' => '邀请',
		'store' => '充值',
		'withdraw' => '提现',
		'coupon' => '返利',
		'refund' => '退款',
		'register' => '注册',
		'charge' => '充值',
		);
global $option_mail;
$option_mail = array(
		'gmail.com' => 'https://mail.google.com/',
		'163.com' => 'http://mail.163.com/',
		'126.com' => 'http://mail.126.com/',
		'qq.com' => 'http://mail.qq.com/',
		'sina.com' => 'http://mail.sina.com/',
		'sohu.com' => 'http://mail.sohu.com/',
		'yahoo.com.cn' => 'http://mail.yahoo.com.cn/',
		'yahoo.com' => 'http://mail.yahoo.com/',
		);
global $option_cond;
$option_cond = array(
		'Y' => '以购买成功人数成团',
		'N' => '以产品购买数量成团',
		);
global $option_open;
$option_open = array(
		'Y' => '开放展示',
		'N' => '关闭展示',
		);
global $option_buyonce;
$option_buyonce = array(
		'Y' => '仅购买一次',
		'N' => '可购买多次',
		);
global $option_teamtype;
$option_teamtype = array(
		'normal' => '团购项目',
		'seconds' => '秒杀项目',
		'goods' => '热销商品',
		);
global $option_teamtype2;
$option_teamtype2 = array(
		'normal' => '团购项目',
		'seconds' => '秒杀项目',
		);
global $option_yn;
$option_yn = array(
		'Y' => '是',
		'N' => '否',
		);
global $option_alipayitbpay;
$option_alipayitbpay= array(
		'1h' => '1小时',
		'2h' => '2小时',
		'3h' => '3小时',
		'1d' => '1天',
		'3d' => '3天',
		'7d' => '7天',
		'15d' => '15天',
		);

