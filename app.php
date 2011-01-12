<?php
require_once(dirname(__FILE__). '/include/application.php');
/* magic_quota_gpc */
$_GET = magic_gpc($_GET);
$_POST = magic_gpc($_POST);
$_COOKIE = magic_gpc($_COOKIE);

/* process currefer*/
$currefer = uencode(strval($_SERVER['REQUEST_URI']));

/* session,cache,configure,webroot register */
Session::Init();
$INI = ZSystem::GetINI();
/* end */

/* biz logic */
$currency = $INI['system']['currency'];
$login_user_id = ZLogin::GetLoginId();
$login_user = Table::Fetch('user', $login_user_id);
// 获得地址列表
$condition = array(
	'uid' => $login_user["id"],
);
$login_user_addresses = DB::LimitQuery('user_address', array(
	'condition' => $condition,
	'order' => 'ORDER BY  id DESC',
));

$hotcities = option_hotcategory('city', false, true);
$allcities = option_category('city', false, true);
$city = cookie_city(null);

$partner_id = abs(intval($_SESSION['partner_id']));
$login_partner = Table::Fetch('partner', $partner_id);

$today=getdate();
$yday=(int)$today['yday'];

if (!$totalSavedMoney || !$allteamcount) {
	$sql = "SELECT sum(now_number*(market_price-team_price)) AS tsm FROM `team`";
	$totalSavedMoney = DB::GetQueryResult($sql);
	$usercount = 1;
	/* get team count */
	$daytime = strtotime(date('Y-m-d'));
	$condition = array(
		'team_type' => 'normal',
		"audit" => 1, //所有已审核的团购
	);
	$allteamcount = Table::Count('team', $condition);
}

/* not allow access app.php */
if($_SERVER['SCRIPT_FILENAME']==__FILE__){
	redirect( WEB_ROOT . '/index.php');
}
/* end */
$AJAX = ('XMLHttpRequest' == @$_SERVER['HTTP_X_REQUESTED_WITH']);
if (false==$AJAX) { 
	header('Content-Type: text/html; charset=UTF-8'); 
	run_cron();
} else {
	header("Cache-Control: no-store, no-cache, must-revalidate");
}
