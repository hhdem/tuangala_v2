<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();

$id = abs(intval($_GET['id']));
$ask = Table::Fetch('ask', $id);
$partner_id = abs(intval($_SESSION['partner_id']));

need_biz_auth($ask['partner_id']==$partner_id);
if (!$ask) {
	redirect( WEB_ROOT . '/biz/ask.php');
}
if ($ask['type'] == 'transfer' 
		&& empty($ask['comment']) ) {
	$ask['comment'] = '顶';
}

if ($_POST && $id == $_POST['id'] ) {
	$table = new Table('ask', $_POST);
	$table->update( array('comment', 'content') );
	redirect(udecode($_GET['r']));
}

$team = Table::Fetch('team', $ask['team_id']);
$user = Table::Fetch('user', $ask['user_id']);
include template('biz_askedit');
