<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();

$ing = $_GET['ing'];
$daytime = strtotime(date('Y-m-d'));

$condition = array(
	'partner_id' => $partner_id,
);
if ($ing) {
	$condition[] = "begin_time <= '{$daytime}'";
	$condition[] = "end_time > '{$daytime}'";
}

$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);

$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

$city_ids = Utility::GetColumn($teams, 'city_id');
$cities = Table::Fetch('category', $city_ids);


include template('biz_index');
