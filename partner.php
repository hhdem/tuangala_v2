<?php
require_once(dirname(__FILE__) . '/app.php');

$id = abs(intval($_GET['id']));
if (!$id || !$partner = Table::FetchForce('partner', $id) ) {
	redirect( WEB_ROOT . '/partner/index.php');
}
$pagetitle = $partner['title'];

$daytime = time();
$condition = array( 
		'partner_id' => $id,
		"begin_time <  {$daytime}",
		"audit" => 1, //所有已审核的团购
		'OR' => array(
			"now_number >= min_number",
			"end_time > {$daytime}",
			),
		);
$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY begin_time DESC, id DESC',
			));

$team_count = count($teams);
$join_number = 0;
foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	$teams[$id] = $one;
	$join_number += $one['now_number'];
	$save_number += $one['now_number'] * ($one['market_price'] - $one['team_price']);
}

include template('partner');
