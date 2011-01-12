<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = time();
$condition = array( 
		'city_id' => array(0, abs(intval($city['id']))),
		'team_type' => 'seconds',
		);

/* filter */
$group_id = abs(intval($_GET['gid']));
if ($group_id) $condition['group_id'] = $group_id;

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);
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

$pagetitle = '秒杀抢团';
include template('team_seconds');

function current_teamcategory($gid='0') {
	global $city;
	$a = array(
			'/team/seconds.php' => '所有',
			);
	foreach(option_hotcategory('group') AS $id=>$name) {
		$a["/team/seconds.php?gid={$id}"] = $name;
	}
	$l = "/team/seconds.php?gid={$gid}";
	if (!$gid) $l = "/team/seconds.php";
	return current_link($l, $a, true);
}
