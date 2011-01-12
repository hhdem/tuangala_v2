<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();
$id = abs(intval($_GET['id']));
$action = strval($_GET['action']);

if ( $action == 'exchange') {
	$goods = Table::Fetch('goods', $id);
	if ( $goods['consume'] >= $goods['number'] ) {
		json('本商品已兑换完毕', 'alert');
	}
	if ( $goods['score'] > $login_user['score'] ) {
		json('你的积分余额不足，兑换失败', 'alert');
	}
	if ( ZCredit::Create((0-$goods['score']), $login_user_id, 'exchange', $id) ) {

		Table::UpdateCache('goods', $id, array(
					'consume' => array( '`consume` + 1' ),
					));
		$v = "兑换商品[{$goods['title']}]成功，消耗积分{$goods['score']}";
		Session::Set('notice', "兑换商品[{$goods['title']}]成功，消耗积分{$goods['score']}");
		redirect( WEB_ROOT . "/credit/goods.php");
	}else {
		json('兑换失败', 'alert');
	}
}

