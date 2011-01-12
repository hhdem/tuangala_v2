<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();

$daytime = strtotime(date('Y-m-d'));
$partner_id = abs(intval($_SESSION['partner_id']));
$login_partner = Table::Fetch('partner', $partner_id);

$condition = array(
	'partner_id' => $partner_id,
	"begin_time <= '{$daytime}'",
	"end_time >= '{$daytime}'",
);
$count1 = Table::Count('team', $condition);

$condition2 = array(
	'partner_id' => $partner_id,
	"begin_time > '{$daytime}'",
);
$count2 = Table::Count('team', $condition2);
//$condition[] = "expire_time >= {$daytime}";

$count = $count1+$count2;

if ($count >= 5) {	
	need_partner_group_id(5, 'biz_coupon_maxlimit');
}
elseif ($count >= 2 && $count < 5) {
	need_partner_group_id(3, 'biz_coupon_maxlimit');
}

if ($_POST) {
	$team = $_POST;
	$insert = array(
		'title', 'market_price', 'team_price', 'end_time', 'begin_time', 'expire_time', 'min_number', 'max_number', 'summary', 'notice', 'conduser', 'per_number', 'buyonce',
		'product', 'image', 'detail', 'userreview', 'systemreview', 'image1', 'image2', 'flv', 'card', 'bonus',
		'mobile', 'address', 'fare', 'express', 'delivery', 
		'user_id', 'state', 'city_id', 'group_id', 'partner_id',
		'team_type', 'sort_order', 'condbuy', 'farefree',
		);
	$team['user_id'] = $login_user_id;
	$team['state'] = 'none';
	$team['begin_time'] = strtotime($team['begin_time']);
	$team['city_id'] = abs(intval($team['city_id']));
	$team['partner_id'] = abs(intval($partner_id));
	$team['sort_order'] = 0;
	$team['fare'] = abs(intval($team['fare']));
	$team['farefree'] = abs(intval($team['farefree']));
	$team['end_time'] = strtotime($team['end_time']);
	$team['expire_time'] = strtotime($team['expire_time']);
	$team['image'] = upload_image('upload_image', null, 'team', true);
	$team['image1'] = upload_image('upload_image1', null, 'team');
	$team['image2'] = upload_image('upload_image2', null, 'team');
	$table = new Table('team', $team);

	//team_type == goods
	if($table->team_type=='goods'){$table->min_number = 1;}

	$table->SetStrip('detail', 'systemreview', 'notice');
	if ( $team_id = $table->insert($insert) ) {
		Session::Set('notice', '新建项目成功, 请耐心等待审核!');
		Utility::Redirect( WEB_ROOT . "/biz/index.php");
	}
}
else {
	$profile = Table::Fetch('leader', $login_user_id, 'user_id');
	//1
	$team = array();
	$team['user_id'] = $login_user_id;
	$team['begin_time'] = strtotime('+0 days');
	$team['end_time'] = strtotime('+2 days'); 
	$team['expire_time'] = strtotime('+3 months +1 days');
	$team['min_number'] = 10;
	$team['per_number'] = 1;
	$team['market_price'] = 1;
	$team['team_price'] = 1;
	//3
	$team['delivery'] = 'coupon';
	$team['address'] = $profile['address'];
	$team['mobile'] = $profile['mobile'];
	$team['fare'] = 5;
	$team['bonus'] = abs(intval($INI['system']['invitecredit']));
	$team['conduser'] = $INI['system']['conduser'] ? 'Y' : 'N';
	$team['buyonce'] = 'Y';
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
$groups = Utility::OptionArray($groups, 'id', 'name');
$partners = DB::LimitQuery('partner', array(
			'order' => 'ORDER BY id DESC',
			));
$partners = Utility::OptionArray($partners, 'id', 'title');
$selector = 'create';

$pagetitle = '新建团购';
include template('biz_coupon_create');
