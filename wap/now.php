<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = time();
$condition = array( 
		'team_type' => 'normal',
		'city_id' => array(0, abs(intval($city['id']))),
		"begin_time <  {$daytime}",
		"end_time > {$daytime}",
		"audit" => 1, //所有已审核的团购
		);

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 1000, true);
$teams = DB::LimitQuery('team', array(
			'condition' => $condition,
			'order' => 'ORDER BY begin_time DESC, id DESC',
			'size' => $pagesize,
			'offset' => $offset,
			));
foreach($teams AS $id=>$one){
	team_state($one);
	if ($one['state']=='none') $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	$teams[$id] = $one;
}

include template('wap_now');
