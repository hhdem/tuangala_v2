<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = time();
$condition = array( 
		'city_id' => array(0, abs(intval($city['id']))),
		'team_type' => 'goods',
		"audit" => 1, //所有已审核的团购
		);

/* filter */
$group_id = abs(intval($_GET['gid']));
if ($group_id) $condition['group_id'] = $group_id;

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);
$goods = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$pagetitle = '热销商品';
include template('team_goods');

function current_teamcategory($gid='0') {
	global $city;
	$a = array(
			'/team/goods.php' => '所有',
			);
	foreach(option_hotcategory('group') AS $id=>$name) {
		$a["/team/goods.php?gid={$id}"] = $name;
	}
	$l = "/team/goods.php?gid={$gid}";
	if (!$gid) $l = "/team/goods.php";
	return current_link($l, $a, true);
}
