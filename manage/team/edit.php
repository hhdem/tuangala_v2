<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');
require_once(dirname(__FILE__) . '/current.php');

need_manager();
need_auth('team');

$id = abs(intval($_GET['id']));
$team = $eteam = Table::Fetch('team', $id);

if ( is_get() && empty($team) ) {
	$team = array();
	$team['id'] = 0;
	$team['user_id'] = $login_user_id;
	$team['begin_time'] = strtotime('+1 days');
	$team['end_time'] = strtotime('+2 days'); 
	$team['expire_time'] = strtotime('+3 months +1 days');
	$team['min_number'] = 10;
	$team['per_number'] = 1;
	$team['market_price'] = 1;
	$team['team_price'] = 1;
	$team['delivery'] = 'coupon';
	$team['address'] = $profile['address'];
	$team['mobile'] = $profile['mobile'];
	$team['fare'] = 5;
	$team['farefree'] = 0;
	$team['bonus'] = abs(intval($INI['system']['invitecredit']));
	$team['conduser'] = $INI['system']['conduser'] ? 'Y' : 'N';
	$team['buyonce'] = 'Y';
	$team['schedulable'] = 'N';
}
else if ( is_post() ) {
	$team = $_POST;
	$insert = array(
		'title', 'market_price', 'team_price', 'schedule_price', 'schedulable', 'end_time', 
		'begin_time', 'expire_time', 'min_number', 'max_number', 
		'summary', 'notice', 'per_number', 'product', 
		'image', 'image1', 'image2', 'flv', 'now_number',
		'detail', 'userreview', 'card', 'systemreview', 
		'conduser', 'buyonce', 'bonus', 'sort_order',
		'delivery', 'mobile', 'address', 'fare', 
		'express', 'credit', 'farefree', 'pre_number',
		'user_id', 'city_id', 'group_id', 'partner_id',
		'team_type', 'sort_order', 'state',
		'condbuy',
		);

	$team['user_id'] = $login_user_id;
	$team['state'] = 'none';
	$team['begin_time'] = strtotime($team['begin_time']);
	$team['city_id'] = abs(intval($team['city_id']));
	$team['partner_id'] = abs(intval($team['partner_id']));
	$team['sort_order'] = abs(intval($team['sort_order']));
	$team['fare'] = abs(intval($team['fare']));
	$team['farefree'] = abs(intval($team['farefree']));
	$team['pre_number'] = abs(intval($team['pre_number']));
	$team['end_time'] = strtotime($team['end_time']);
	$team['expire_time'] = strtotime($team['expire_time']);
	$team['image'] = upload_image('upload_image',$eteam['image'],'team',true);
	$team['image1'] = upload_image('upload_image1',$eteam['image1'],'team');
	$team['image2'] = upload_image('upload_image2',$eteam['image2'],'team');

	//team_type == goods
	if($team['team_type'] == 'goods'){ 
		$team['min_number'] = 1; 
		$tean['conduser'] = 'N';
	}

	if ( !$id ) {
		$team['now_number'] = $team['pre_number'];
	} else {
		$field = strtoupper($table->conduser)=='Y' ? null : 'quantity';
		$now_number = Table::Count('order', array(
					'team_id' => $id,
					'state' => 'pay',
					), $field);
		$team['now_number'] = ($now_number + $team['pre_number']);

		/* 增加了总数，未卖完状态 */
		if ( $team['max_number'] > $team['now_number'] ) {
			$team['close_time'] = 0;
			$insert[] = 'close_time';
		}
	}

	$insert = array_unique($insert);
	$table = new Table('team', $team);
	$table->SetStrip('detail', 'systemreview', 'notice');

	if ( $team['id'] && $team['id'] == $id ) {
		$table->SetPk('id', $id);
		$table->update($insert);
		Session::Set('notice', '编辑项目信息成功');
		redirect( WEB_ROOT . "/manage/team/index.php");
	} 
	else if ( $team['id'] ) {
		Session::Set('error', '非法编辑');
		redirect( WEB_ROOT . "/manage/team/index.php");
	}

	if ( $table->insert($insert) ) {
		Session::Set('notice', '新建项目成功');
		redirect( WEB_ROOT . "/manage/team/index.php");
	}
	else {
		Session::Set('error', '编辑项目失败');
		redirect(null);
	}
}

$groups = DB::LimitQuery('category', array(
			'condition' => array( 'zone' => 'group', 'display'=>'Y' , 'parent_id is null'),
			));
$c_groups = DB::LimitQuery('category', array(
			'condition' => array( 'zone' => 'group', 'display'=>'Y' , 'parent_id is not null'),
			));
foreach($groups AS $id=>$one){
		$in = 1;
		foreach($c_groups AS $cid=>$cone){
			
			if ($one['id'] == $cone['parent_id']) {
				$cgroups[$one['id']][$in++] = $cone;
			}
		}
	}



$partners = DB::LimitQuery('partner', array(
			'order' => 'ORDER BY id DESC',
			));
$partners = Utility::OptionArray($partners, 'id', 'title');
$selector = $team['id'] ? 'edit' : 'create';
include template('manage_team_edit');
