<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if (is_post()) {
	if ($_POST['action'] == 'partnerupgrade') {
		$table = new Table('partner', $_POST);
		Table::UpdateCache('partner', $_POST['id'], array(
			'group_id' => abs(intval($_POST['group_id'])),
		));
		$table->Set('group_id', abs(intval($_POST['group_id'])));
	}
	Session::Set('notice', '商户级别变更成功');
	redirect( WEB_ROOT . "/manage/partner/index.php");
}

$condition = array();

/* filter */
$ptitle = strval($_GET['ptitle']);
if ($ptitle ) {
	$condition[] = "title LIKE '%".mysql_escape_string($ptitle)."%'";
}
$group_id = strval($_GET['group_id']);
if ($group_id) {
	$condition['group_id'] = $group_id;
}
$city_id = strval($_GET['city_id']);
if ($group_id) {
	$condition['city_id'] = $city_id;
}
$open = strval($_GET['open']);
if ($open) {
	$condition['open'] = $open;
}
/* filter end */

$count = Table::Count('partner', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$partners = DB::LimitQuery('partner', array(
	'condition' => $condition,
	'order' => 'ORDER BY head DESC, id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
$groups = option_category('partner');
$vips = option_category('vip');
$cities = option_category('city');




include template('manage_partner_index');
