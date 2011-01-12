<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$pagetitle = '邀请有奖';

if (! is_login() ) {
	die(include template('account_invite_signup'));
}

if($_POST['recipients'] && $_POST['invitation_content']) {
	$emails = $_POST['recipients'];
	($name = $_POST['real_name']) || ($name = $login_user['username']);
	$content = $_POST['invitation_content'];
	mail_invitation($emails, $content, $name);
	Session::Set('notice', '邀请发送成功');
	redirect( WEB_ROOT . '/account/invite.php' );
}


$condition = array( 
		'user_id' => $login_user_id, 
		'credit > 0',
		'pay' => 'Y',
		);
$money = Table::Count('invite', $condition, 'credit');
$count = Table::Count('invite', $condition);

$team = current_team($city['id']);
$condition = array(
	'city_id' => array(0, abs(intval($city['id']))),
	'team_type' => 'normal',
	"begin_time <= '{$daytime}'",
	"end_time > '{$daytime}'",
	"audit" => 1, //所有已审核的团购
);
$tcount = Table::Count('team', $condition);
if ($tcount > 1) {
	list($pagesize, $offset, $pagestring) = pagestring($tcount, 6);
	$teams = DB::LimitQuery('team', array(
		'condition' => $condition,
		'order' => 'ORDER BY  sort_order DESC, begin_time DESC, id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
	foreach($teams AS $id=>$one){
		team_state($one);
		if (!$one['close_time']) $one['picclass'] = 'isopen';
		if ($one['state']=='soldout') $one['picclass'] = 'soldout';
		$one['discount_price'] = $one['market_price'] - $one['team_price'];
		$left = array();
		if($one['end_time']<$one['begin_time']){$one['end_time']=$one['begin_time'];}
		$diff_time = $left_time = $one['end_time']-$now;
		
		if ( $one['team_type'] == 'seconds' && $one['begin_time'] >= $now ) {
			$diff_time = $left_time = $one['begin_time']-$now;
		}
		$one['left_day'] = floor($diff_time/86400);
		$left_time = $left_time % 86400;
		$one['left_hour'] = floor($left_time/3600);
		$left_time = $left_time % 3600;
		$one['left_minute'] = floor($left_time/60);
		$one['left_time'] = $left_time % 60;
		$diff_time = $left_time = null;

		/* progress bar size */
		$one['bar_size'] = ceil(190*($one['now_number']/$one['min_number']));
		$one['bar_offset'] = ceil(5*($one['now_number']/$one['min_number']));
		
		$partner = Table::Fetch('partner', $one['partner_id']);
		$one['authenticate'] = $partner['authenticate'];
		$teams[$id] = $one;
	}
}
die(include template('account_invite'));
