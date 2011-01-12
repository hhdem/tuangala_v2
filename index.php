<?php
require_once(dirname(__FILE__) . '/app.php');

//if(!$INI['db']['host']) redirect( WEB_ROOT . '/install.php' );

$request_uri = 'index';
$team = current_team($city['id']);

$daytime = strtotime(date('Y-m-d'));
$condition = array(
	'city_id' => array(0, abs(intval($city['id']))),
	'team_type' => 'normal',
	"begin_time <= '{$daytime}'",
	"end_time > '{$daytime}'",
	"audit" => 1, //所有已审核的团购
);
$count = Table::Count('team', $condition);
if ($count > 1) {
	Utility::Redirect( WEB_ROOT . '/team/list.php');
}


if ($team) {
	$_GET['id'] = abs(intval($team['id']));
	die(require_once( dirname(__FILE__) . '/team.php'));
}

include template('subscribe');
