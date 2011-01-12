<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

set_time_limit(0);
ignore_user_abort(true);

$team_id = abs(intval($_GET['tid']));
$secret = strval($_GET['secret']);

$team = Table::Fetch('team', $team_id);
$partner = Table::Fetch('partner', $team['partner_id']);
$city = Table::Fetch('city', $team['city_id']);
$subscribe = Table::Fetch('subscribe', $secret, 'secret');

if ( $team && $subscribe ) {
	mail_subscribe($city, $team, $partner, $subscribe);
}
