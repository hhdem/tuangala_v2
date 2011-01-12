<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
header('Content-Type: application/xml; charset=UTF-8');

$daytime = strtotime(date('Y-m-d'));
$condition = array( 
		"begin_time <= {$daytime}",
		"end_time > {$daytime}",
		"audit" => 1, //��������˵��Ź�
		);
$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY id DESC',
			));

$wwwurl = $INI['system']['wwwprefix'];
$imgurl = "{$INI['system']['imgprefix']}/static";

$oa = array(
		'Site' => $INI['system']['sitename'],
		'SiteUrl' => $wwwurl,
		'Update' => date('Y-m-d'),
		);

$acts = array();

foreach($teams AS $one) {
	$city = Table::Fetch('category', $one['city_id']);
	$group = Table::Fetch('category', $one['group_id']);
	$partner = Table::Fetch('partner', $one['partner_id']);

	$item = array();
	$item['data'] = array();
	$item['data']['display'] = array();

	$o = array();
	$o['Title'] = $one['title'];
	$o['Url'] = "{$wwwurl}/team.php?id={$one['id']}";
	$o['Description'] = $one['summary'];
	$o['ImageUrl'] = "{$imgurl}/{$one['image']}";
	$o['CityName'] = $city['name'];
	$o['AreaCode'] = null;
	$o['Value'] = $one['market_price'];
	$o['Price'] = $one['team_price'];
	if ( $one['market_price'] > 0 ) {
		$o['ReBate'] = moneyit(10*$one['team_price']/$one['market_price']);
	} else {
		$o['ReBate'] = '0';
	}
	$o['StartTime'] = date('YmdHis', $one['begin_time']);
	$o['EndTime'] = date('YmdHis', $one['end_time']);
	$o['Quantity'] = $one['max_number'];
	$o['Bought'] = $one['now_number'];
	$o['MinBought'] = $one['min_number'];
	$o['BoughtLimit'] = $one['per_number'];

		$g = array();
		$g['Name'] = $partner['title'];
		$g['ProviderName'] = $partner['title'];
		$g['ProviderUrl'] = $partner['homepage'];
		$g['ImageUrlSet'] = "{$imgurl}/{$one['image']}";
		$g['Contact'] = $partner['contact'];
		$g['Address'] = $partner['address'];
		$g['Map'] = null;
		$g['Description'] = $partner['location'];

	$o['Goods'] = $g;
	$oa[] = $o;
}

Output::SetTagSon('ActivitySet', 'Activity');
Output::XmlCustom($oa, 'ActivitySet');
