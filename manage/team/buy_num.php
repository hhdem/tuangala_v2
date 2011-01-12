<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('team');

if ($_POST) {
	$table = new Table('team', $_POST);
	Table::UpdateCache('team', $_POST['id'], array(
		'now_number' => intval($_POST['now_number']),
	));
	Session::Set('notice', '修改团购(id='.$_POST['id'].')人数成功');
		redirect( WEB_ROOT. "/manage/team/index.php");
	
}