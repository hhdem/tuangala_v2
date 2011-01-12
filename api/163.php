<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
header('Content-Type: application/xml; charset=utf-8');
$daytime = strtotime(date('Y-m-d'));
$condition = array( 
		'team_type' => 'normal',
		"begin_time <= {$daytime}",
		"end_time > {$daytime}",
		"audit" => 1, //所有已审核的团购
		);
$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY sort_order DESC, now_number DESC, begin_time DESC, id DESC',
			));

$oa = array();
$si = array(
		'sitename' => $INI['system']['sitename'],
		'wwwprefix' => $INI['system']['wwwprefix'],
		'imgprefix' => $INI['system']['imgprefix'],
		);
$cities = option_category('city');
$groups = option_category('group');

foreach($teams AS $one) {
	$city = $cities[$one['city_id']];
	$group = $groups[$one['group_id']];
	$item = array();
	$item['loc'] = $si['wwwprefix'] . "/team.php?id={$one['id']}";
	$item['data'] = array();
	$item['data']['display'] = array();
	$item['data']['shops']['shop']= array();

	$o = array();
	$o['website'] = $INI['system']['sitename'];
	//$o['identifier'] = $one['id'];
	$o['siteurl'] = $INI['system']['wwwprefix'];
	($o['city'] = $city) || ($o['city'] = '全国');
	$o['title'] = $one['title'];
	$o['image'] = team_image($one['image'], true);
	($o['tag'] = $group) || ($o['tag'] = '无');
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
	$o['merchantEndTime'] = date('Y-n-j', $one['end_time']);

	$item['data']['display'] = $o;
	$p = Table::Fetch('partner', $one['partner_id']);
	$pval = array();
	$pval['name'] = $p['title'];
	$pval['tel'] = $p['tel'];
	$pval['addr'] = $p['address'];
	if ($p['longlat']) {
		list($pval['longitude'], $pval['latitude']) 
			= explode(',', $p['longlat']);
	}
	$item['data']['shops']['shop']=$pval;

	$oa[] = $item;
}

Output::XmlCustom($oa, 'urlset', 'utf-8');
