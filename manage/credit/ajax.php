<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

$action = strval($_GET['action']);
$id = abs(intval($_GET['id']));

if ( 'edit' == $action ) {
	if ($id) {
		$goods = Table::Fetch('goods', $id);
		if (!$goods) json('无数据', 'alert');
	}
	$html = render('manage_ajax_dialog_goodsedit');
	json($html, 'dialog');
}
elseif ( 'remove' == $action ) {
	$goods = Table::Fetch('goods', $id);
	if (!$goods) json('无数据', 'alert');
	Table::Delete('goods', $id);
	Session::Set('notice', '删除商品成功');
	json(null, 'refresh');
}
elseif ( 'disable' == $action ) {
	$goods = Table::Fetch('goods', $id);
	if (!$goods) json('无数据', 'alert');
	$enable = ($goods['enable'] == 'Y') ? 'N' : 'Y';
	$enablestring = ($goods['enable']=='Y') ? '禁用' : '启用';
	Table::UpdateCache('goods', $id, array(
		'enable' => $enable,
	));
	Session::Set('notice', "{$enablestring}兑换商品成功");
	json(null, 'refresh');
}
