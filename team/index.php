<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = strtotime(date('Y-m-d'));
$condition = array(
	'team_type' => 'normal',
	'city_id' => array(0, abs(intval($city['id']))),
	"end_time < '{$daytime}'",
	"audit" => 1, //所有已审核的团购
);

if (!option_yes('displayfailure')) {
	$condition['OR'] = array(
		"now_number >= min_number",
	);
}

$group_id = abs(intval($_GET['gid']));
if ($group_id) {
	$condition['czone'] = $group_id;
}

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);
$mes = '`t`.`group_id` = `c`.`id`';
$t1 = 'team';
$t2 = 'category';
$as1 = 't';
$as2 = 'c';
$teams = DB::LimitTwoTableQuery($t1, $t2, $as1, $as2, $mes, array(
	'select' => '`t`.*',
	'condition' => $condition,
	'order' => 'ORDER BY `t`.`sort_order` DESC, `t`.`begin_time` DESC, `t`.id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	$teams[$id] = $one;
}

$category = Table::Fetch('category', $group_id);
$pagetitle = '往期团购';
include template('team_index');

function current_teamcategory($gid='0') {
	global $city;
	$a = array(
			'/team/index.php' => '所有',
			);
	foreach(option_one_level_category('group') AS $id=>$name) {
		$a["/team/index.php?gid={$id}"] = $name;
	}
	$l = "/team/index.php?gid={$gid}";
	if (!$gid) $l = "/team/index.php";
	return current_link($l, $a, true);
}
