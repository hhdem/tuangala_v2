<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
$condition = array( 'user_id' => $login_user['id'],);
$count = Table::Count('credit', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 20);

$credits = DB::LimitQuery('credit', array(
			'condition'=>$condition,
			'size' => $pagesize,
			'offset' => $offset,
			'order' => 'ORDER BY id DESC',
			));

$detail_ids = Utility::GetColumn($credits, 'detail_id');

$pagetitle = '我的积分';
include template('credit_score');
