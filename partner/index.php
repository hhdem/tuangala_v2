<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$daytime = time();
$condition = array( 
		'open' => 'Y',
		);
$group_id = abs(intval($_GET['gid']));
if ($group_id) $condition['group_id'] = $group_id;

if (option_yes('citypartner') && ($cid=abs(intval($city['id']))) ) {
	$condition['city_id'] = $cid;
}

$count = Table::Count('partner', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);
$partners = DB::LimitQuery('partner', array(
	'condition' => $condition,
	'order' => 'ORDER BY head DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
foreach($partners AS $id=>$one){
	team_state($one);
	if ($one['state']=='none') $one['picclass'] = 'isopen';
	if ($one['state']=='soldout') $one['picclass'] = 'soldout';
	$partners[$id] = $one;
}

$category = Table::Fetch('category', $group_id);
$pagetitle = '品牌商户';
include template('partner_index');
