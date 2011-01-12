<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_login();

$id = abs(intval($_REQUEST['id']));
$address = Table::Fetch('user_address', $id);

$table = new Table('user_address', $_POST);
$table->uid = $login_user['id'];
$uarray = array('name','address','post','phone','mobile','uid',);

if (!$_POST['name'] || !$_POST['address'] ||!$_POST['post']||!$_POST['mobile']) {
	Session::Set('error', '有必填字段没有填写');
	redirect(null);
}

if ( $address ) {
	if ( $flag = $table->update( $uarray ) ) {
		Session::Set('notice', '编辑配送地址成功');
	} else {
		Session::Set('error', '编辑配送地址失败');
	}
} else {
	if ( $flag = $table->insert( $uarray ) ) {
		Session::Set('notice', '新建配送地址成功');
	} else {
		Session::Set('error', '新建配送地址失败');
	}
}

redirect(null);
