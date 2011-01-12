<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = abs(intval($_GET['id']));
if (!$id || !$team = Table::FetchForce('team', $id) ) {
	redirect('index.php');
}

$discount_price = $team['market_price'] - $team['team_price'];

$left = array();
$now = time();
$diff_time = $left_time = $team['end_time']-$now;

$left_day = floor($diff_time/86400);
$left_time = $left_time % 86400;
$left_hour = floor($left_time/3600);
$left_time = $left_time % 3600;
$left_minute = floor($left_time/60);
$left_time = $left_time % 60;

team_state($team);
include template('wap_team');
