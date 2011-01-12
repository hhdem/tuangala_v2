<?php
function current_frontend() {
	global $INI;
	$a = array(
			'/index.php' => '首页',
			'/team/current_list.php' => '团购列表',
			'/team/index.php' => '往期团购',
			);
	if(option_yes('navseconds')) $a['/team/seconds.php'] = '秒杀抢团';
	if(option_yes('navgoods')) $a['/team/goods.php'] = '热销商品';
	if(option_yes('navpartner')) $a['/partner/index.php'] = '品牌商户';
	$a['/help/tour.php'] = '玩转团购';
	//$a['/play/puzzle.php'] = '拼图游戏';
	if(option_yes('navforum')) $a['/forum/index.php'] = '讨论区';
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/team#',$r)) $l = '/team/index.php';
	//elseif (preg_match('#/help#',$r)) $l = '/help/tour.php';
	elseif (preg_match('#/subscribe#',$r)) $l = '/subscribe.php';
	else $l = '/index.php';
	return current_link(null, $a);
}

function current_backend() {
	global $INI;
	$a = array(
			'/manage/misc/index.php' => '首页',
			'/manage/team/index.php' => '项目',
			'/manage/order/index.php' => '订单',
			'/manage/coupon/index.php' => $INI['system']['couponname'],
			'/manage/user/index.php' => '用户',
			'/manage/partner/index.php' => '商户',
			'/manage/market/index.php' => '营销',
			'/manage/category/index.php' => '类别',
			'/manage/vote/index.php' => '调查',
			'/manage/credit/index.php' => '积分',
			'/manage/system/index.php' => '设置',
			);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/manage/(\w+)/#',$r, $m)) {
		$l = "/manage/{$m[1]}/index.php";
	} else $l = '/manage/misc/index.php';
	return current_link($l, $a);
}

function current_biz() {
	global $INI;
	$a = array(
			'/biz/index.php' => '首页',
			'/biz/coupon_create.php' => '建立团购',
			'/biz/order/index.php' => '订单',
			'/biz/money.php' => '财务',
			'/biz/settings.php' => '商户资料',
			'/biz/coupon.php' => $INI['system']['couponname'] . '列表',
			);
	$r = $_SERVER['REQUEST_URI'];
	if (preg_match('#/biz/coupon_create#',$r)) $l = '/biz/coupon_create.php';
	elseif (preg_match('#/biz/coupon_edit#',$r)) $l = '/biz/coupon_create.php';
	elseif (preg_match('#/biz/coupon#',$r)) $l = '/biz/coupon.php';
	elseif (preg_match('#/biz/settings#',$r)) $l = '/biz/settings.php';
	elseif (preg_match('#/biz/order#',$r)) $l = '/biz/order/index.php';
	elseif (preg_match('#/biz/money#',$r)) $l = '/biz/money.php';
	else $l = '/biz/index.php';
	return current_link($l, $a);
}

function current_biz_order($selector=null) {
	$a = array(
		'/biz/order/index.php' => '当期订单',
		'/biz/order/pay.php' => '付款订单',
		'/biz/order/unpay.php' => '未付订单',
	);
	$l = "/biz/order/{$selector}.php";
	return current_link($l,$a,true);
}

function current_forum($selector='index') {
	global $city;
	$a = array(
			'/forum/index.php' => '所有',
			'/forum/city.php' => "{$city['name']}讨论区",
			'/forum/public.php' => '公共讨论区',
			);
	if (!$city) unset($a['/forum/city.php']);
	$l = "/forum/{$selector}.php";
	return current_link($l, $a, true);
}

function current_invite($selector='refer') {
	$a = array(
			'/account/refer.php' => '所有',
			'/account/referpending.php' => "未购买",
			'/account/referdone.php' => '已返利',
			);
	$l = "/account/{$selector}.php";
	return current_link($l, $a, true);
}

function current_partner($gid='0') {
	$a = array(
			'/partner/index.php' => '所有',
			);
	foreach(option_category('partner') AS $id=>$name) {
		$a["/partner/index.php?gid={$id}"] = $name;
	}
	$l = "/partner/index.php?gid={$gid}";
	if (!$gid) $l = "/partner/index.php";
	return current_link($l, $a, true);
}

function current_city($cename, $citys) {
	$link = "/city.php?ename={$cename}";
	$links = array();
	foreach($citys AS $city) {
		$links["/city.php?ename={$city['ename']}"] = $city['name'];
	}
	return current_cigy_link($link, $links);
}

function current_cigy_link($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	foreach($links AS $l=>$n) {
		if (trim($l,'/')==trim($link,'/')) {
			$html .= "<li style=\"float:left;width:80px;margin-bottom:5px;text-align:center;margin-left:5px;border:1px dashed #666;background:#eef2f7;color:#f1f1f1;\"><a href=\"{$l}\" style=\"float:center\">{$n}</a>{$span}</li>";
		}
		else $html .= "<li style=\"float:left;width:80px;margin-bottom:5px;text-align:center;margin-left:5px;dborder:1px dashed #666;\"><a href=\"{$l}\" style=\"float:center\">{$n}</a>{$span}</li>";
	}
	return $html;
}

function current_coupon_sub($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/coupon/index.php' => '未使用',
		'/coupon/consume.php' => '已使用',
		'/coupon/expire.php' => '已过期',
	);
	$l = "/coupon/{$selector}.php";
	return current_link($l, $a);
}

function current_account($selector='/account/settings.php') {
	global $INI;
	$a = array(
		'/coupon/index.php' => '我的' . $INI['system']['couponname'],
		'/order/index.php' => '我的订单',
		'/account/refer.php' => '我的邀请',
		'/credit/index.php' => '账户余额',
		'/account/settings.php' => '账户设置',
		'/account/myask.php' => '我的问答',
	);
	if (option_yes('usercredit')) {
		$a['/credit/score.php'] = '我的积分';
	}
	return current_link($selector, $a, true);
}

function current_m_account($selector='/account/settings.php') {
	global $INI;
	$a = array(
		'/coupon/index.php' => '我的' . $INI['system']['couponname'],
		'/order/index.php' => '我的订单',
		'/account/refer.php' => '我的邀请',
		'/credit/index.php' => '账户余额',
		'/account/address.php' => '配送地址',
		'/account/settings.php' => '账户设置',
		'/account/myask.php' => '我的问答',
	);
	if (option_yes('usercredit')) {
		$a['/credit/score.php'] = '我的积分';
	}
	return current_link($selector, $a, true);
}

function current_about($selector='us') {
	global $INI;
	$a = array(
		'/about/us.php' => '关于' . $INI['system']['abbreviation'],
		'/about/contact.php' => '联系方式',
		'/about/job.php' => '工作机会',
		'/about/terms.php' => '用户协议',
		'/about/bizs.php' => '商户协议',
		'/about/privacy.php' => '隐私声明',
	);
	$l = "/about/{$selector}.php";
	return current_link($l, $a, true);
}

function current_help($selector='faqs') {
	global $INI;
	$a = array(
		'/help/tour.php' => '玩转' . $INI['system']['abbreviation'],
		'/help/faqs.php' => '常见问题',
		'/help/tuangala.php' => $INI['system']['abbreviation'] . '是什么',
		'/help/bizhowtouse.php' => '商家使用说明',
	);
	$l = "/help/{$selector}.php";
	return current_link($l, $a, true);
}

function current_order_index($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/order/index.php?s=index' => '全部',
		'/order/index.php?s=unpay' => '未付款',
		'/order/index.php?s=pay' => '已付款',
	);
	$l = "/order/index.php?s={$selector}";
	return current_link($l, $a);
}

function current_credit_index($selector='index') {
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/credit/score.php' => '我的积分',
		'/credit/goods.php' => '兑换商品',
	);
	$l = "/credit/{$selector}.php";
	return current_link($l, $a);
}

function current_link($link, $links, $span=false) {
	$html = '';
	$span = $span ? '<span></span>' : '';
	foreach($links AS $l=>$n) {
		if (trim($l,'/')==trim($link,'/')) {
			$html .= "<li class=\"current\"><a href=\"{$l}\">{$n}</a>{$span}</li>";
		}
		else $html .= "<li><a href=\"{$l}\">{$n}</a>{$span}</li>";
	}
	return $html;
}

function current_biz_index($selector=null) {
	$a = array(
		'/biz/index.php' => '项目列表',
		'/biz/ask.php' => '项目答疑',
	);
	$l = "/biz/{$selector}.php";
	return current_link($l,$a,true);
}

function current_biz_money($selector=null){
	$selector = $selector ? $selector : 'cash';
	$a = array(
		'/biz/money.php?s=drawmoney' => '支取明细',
		'/biz/money.php?s=cash' => '财务明细',		
	);
	$l = "/biz/money.php?s={$selector}";
	return current_link($l, $a);
}


/* manage current */
function mcurrent_misc($selector=null) {
	$a = array(
		'/manage/misc/index.php' => '首页',
		'/manage/misc/ask.php' => '答疑',
		'/manage/misc/feedback.php' => '反馈',
		'/manage/misc/subscribe.php' => '邮件',
		'/manage/misc/smssubscribe.php' => '短信',
		'/manage/misc/invite.php' => '返利',
		'/manage/misc/money.php' => '财务',
		'/manage/misc/link.php' => '友链',
		'/manage/misc/backup.php' => '备份',
	);
	$l = "/manage/misc/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_misc_money($selector=null){
	$selector = $selector ? $selector : 'store';
	$a = array(
		'/manage/misc/money.php?s=store' => '线下充值',
		'/manage/misc/money.php?s=charge' => '在线充值',
		'/manage/misc/money.php?s=withdraw' => '提现记录',
		'/manage/misc/money.php?s=cash' => '现金支付',
		'/manage/misc/money.php?s=refund' => '退款记录',
	);
	$l = "/manage/misc/money.php?s={$selector}";
	return current_link($l, $a);
}

function mcurrent_misc_backup($selector=null){
	$selector = $selector ? $selector : 'backup';
	$a = array(
		'/manage/misc/backup.php' => '数据库备份',
		'/manage/misc/restore.php' => '数据库恢复',
	);
	$l = "/manage/misc/{$selector}.php";
	return current_link($l, $a);
}

function mcurrent_misc_invite($selector=null){
	$selector = $selector ? $selector : 'index';
	$a = array(
		'/manage/misc/invite.php?s=index' => '邀请记录',
		'/manage/misc/invite.php?s=record' => '返利记录',
		'/manage/misc/invite.php?s=cancel' => '违规记录',
	);
	$l = "/manage/misc/invite.php?s={$selector}";
	return current_link($l, $a);
}
function mcurrent_order($selector=null) {
	$a = array(
		'/manage/order/index.php' => '当期订单',
		'/manage/order/pay.php' => '付款订单',
		'/manage/order/credit.php' => '余额支付',
		'/manage/order/unpay.php' => '未付订单',
	);
	$l = "/manage/order/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_user($selector=null) {
	$a = array(
		'/manage/user/index.php' => '用户列表',
		'/manage/user/manager.php' => '管理员列表',
	);
	$l = "/manage/user/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_team($selector=null) {
	$a = array(
		'/manage/team/index.php' => '当前项目',
		'/manage/team/success.php' => '成功项目',
		'/manage/team/failure.php' => '失败项目',
		'/manage/team/edit.php' => '新建项目',
	);
	$l = "/manage/team/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_feedback($selector=null) {
	$a = array(
		'/manage/feedback/index.php' => '总览',
	);
	$l = "/manage/feedback/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_coupon($selector=null) {
	$a = array(
		'/manage/coupon/index.php' => '未消费',
		'/manage/coupon/consume.php' => '已消费',
		'/manage/coupon/expire.php' => '已过期',
		'/manage/coupon/card.php' => '代金券',
		'/manage/coupon/cardcreate.php' => '新建代金券',
	);
	$l = "/manage/coupon/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_category($selector=null) {
	$zones = get_zones();
	$a = array();
	foreach( $zones AS $z=>$o ) {
		$a['/manage/category/index.php?zone='.$z] = $o;
	}
	$l = "/manage/category/index.php?zone={$selector}";
	return current_link($l,$a,true);
}
function mcurrent_partner($selector=null) {
	$a = array(
		'/manage/partner/index.php' => '商户列表',
		'/manage/partner/create.php' => '新建商户',
	);
	$l = "/manage/partner/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market($selector=null) {
	$a = array(
		'/manage/market/index.php' => '邮件营销',
		'/manage/market/sms.php' => '短信群发',
		'/manage/market/down.php' => '数据下载',
	);
	$l = "/manage/market/{$selector}.php";
	return current_link($l,$a,true);
}
function mcurrent_market_down($selector=null) {
	$a = array(
		'/manage/market/down.php' => '手机号码',
		'/manage/market/downemail.php' => '邮件地址',
		'/manage/market/downorder.php' => '项目订单',
		'/manage/market/downcoupon.php' => '项目优惠券',
		'/manage/market/downuser.php' => '用户信息',
	);
	$l = "/manage/market/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_system($selector=null) {
	$a = array(
		'/manage/system/index.php' => '基本',
		'/manage/system/option.php' => '选项',
		'/manage/system/bulletin.php' => '公告',
		'/manage/system/pay.php' => '支付',
		'/manage/system/email.php' => '邮件',
		'/manage/system/sms.php' => '短信',
		'/manage/system/page.php' => '页面',
		'/manage/system/cache.php' => '缓存',
		'/manage/system/skin.php' => '皮肤',
		'/manage/system/template.php' => '模板',
		'/manage/system/upgrade.php' => '升级',
	);
	$l = "/manage/system/{$selector}.php";
	return current_link($l,$a,true);
}

function mcurrent_credit($selector=null) {
	$a = array(
		'/manage/credit/index.php' => '积分记录',
		'/manage/credit/settings.php' => '积分规则',
		'/manage/credit/goods.php' => '商品兑换',
	);
	$l = "/manage/credit/{$selector}.php";
	return current_link($l,$a,true);
}
