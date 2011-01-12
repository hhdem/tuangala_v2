<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('admin');

$like = strval($_GET['like']);
$uname = strval($_GET['uname']);
$ucity = abs(intval($_GET['ucity']));
$cs = strval($_GET['cs']);

$condition = array();

/* filter */
if ($like) { 
	$condition[] = "email like '%".mysql_escape_string($like)."%'";
}
if ($uname) {
	$condition[] = "username like '%".mysql_escape_string($uname)."%'";
}
if (abs(intval($ucity))) {
	$condition['city_id'] = abs(intval($ucity));
}
/* end */

$count = Table::Count('user', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$users = DB::LimitQuery('user', array(
	'condition' => $condition,
	'order' => 'ORDER BY id DESC',
	'size' => $pagesize,
	'offset' => $offset,
));

include template('manage_user_index');
