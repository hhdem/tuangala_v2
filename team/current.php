<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = time();
$condition = array( 
		'city_id' => array(0, abs(intval($city['id']))),
		"begin_time <  {$daytime}",
		'team_type' => 'normal',	//kxx 增加
		"end_time >= {$daytime}",
		);

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 1000);
$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY begin_time DESC, id DESC',
			'size' => $pagesize,
			'offset' => $offset,
			));
foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	$teams[$id] = $one;
}

$pagetitle = '当期团购';
include template('team_current');
