<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = strtotime(date('Y-m-d'));
$condition = array(
	'team_type' => 'normal',
	'city_id' => array(0, abs(intval($city['id']))),
	"begin_time <= '{$daytime}'",
	"end_time >= '{$daytime}'",
	"audit" => 1, //所有已审核的团购
);
$page = abs(intval($_GET['page']));
$group_id = abs(intval($_GET['gid']));
if ($group_id) $condition['group_id'] = $group_id;

/*$count = Table::Count('team', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 6);
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY  sort_order DESC, now_number DESC, begin_time DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
$now = time();
foreach($teams AS $id=>$one){
	team_state($one);
	if (!$one['close_time']) $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	$one['discount_price'] = $one['market_price'] - $one['team_price'];
	$left = array();
	if($one['end_time']<$one['begin_time']){$one['end_time']=$one['begin_time'];}
	$diff_time = $left_time = $one['end_time']-$now;
	
	if ( $one['team_type'] == 'seconds' && $one['begin_time'] >= $now ) {
		$diff_time = $left_time = $one['begin_time']-$now;
	}
	$one['left_day'] = floor($diff_time/86400);
	$left_time = $left_time % 86400;
	$one['left_hour'] = floor($left_time/3600);
	$left_time = $left_time % 3600;
	$one['left_minute'] = floor($left_time/60);
	$one['left_time'] = $left_time % 60;
	$diff_time = $left_time = null;
*/
	/* progress bar size */
/*	$one['bar_size'] = ceil(190*($one['now_number']/$one['min_number']));
	$one['bar_offset'] = ceil(5*($one['now_number']/$one['min_number']));
	
	$partner = Table::Fetch('partner', $one['partner_id']);
	$one['authenticate'] = $partner['authenticate'];
	$teams[$id] = $one;
}

$category = Table::Fetch('category', $group_id);
*/

include template('team_view_list');
