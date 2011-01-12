<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
header('Content-Type: application/xml; charset=UTF-8');

$daytime = strtotime(date('Y-m-d'));
$condition = array( 
		'team_type' => 'normal',
		"begin_time <= {$daytime}",
		"end_time > {$daytime}",
		"audit" => 1, //所有已审核的团购
		);
$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY id DESC',
			));

$oa = array();
$si = array(
		'sitename' => $INI['system']['sitename'],
		'wwwprefix' => $INI['system']['wwwprefix'],
		'imgprefix' => $INI['system']['imgprefix'],
		);

foreach($teams AS $one) {
	$city = Table::Fetch('category', $one['city_id']);
	$group = Table::Fetch('category', $one['group_id']);
	$item = array();
	$item['loc'] = $si['wwwprefix'] . "/team.php?id={$one['id']}";
	$item['data'] = array();
	$item['data']['display'] = array();

	$o = array();
	$o['website'] = $INI['system']['sitename'];
	$o['siteurl'] = $INI['system']['wwwprefix'];
	($o['city'] = $city['name']) || ($o['city'] = '全国');
	$o['title'] = $one['title'];
	$o['image'] = $si['imgprefix']  .'/static/' . $one['image'];
	$o['startTime'] = $one['begin_time'];
	$o['endTime'] = $one['end_time'];
	$o['value'] = $one['market_price'];
	$o['price'] = $one['team_price'];
	if ( $one['market_price'] > 0 ) {
		$o['rebate'] = moneyit(10*$one['team_price']/$one['market_price']);
	} else {
		$o['rebate'] = '0';
	}
	$o['bought'] = abs(intval($one['now_number']));

	$item['data']['display'] = $o;
	$oa[] = $item;
}

Output::XmlBaidu($oa);
