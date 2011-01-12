<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$id = $team_id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $team_id);
$partner = Table::Fetch('partner', $team['partner_id']);

/*kxx team_type */
if ($team['team_type'] == 'seconds') {
	die(include template('team_detail_view_seconds'));
}
if ($team['team_type'] == 'goods') {
	die(include template('team_detail_view_goods'));
}
/*xxk*/
include template('ajax_team_detail_view');
?>
