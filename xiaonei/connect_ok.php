<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$xn = new Xiaonei('58f2b48818d446be97a1827dd10d89f2','852612554a5745878d89777c1dd1ca0a');
$params1 = array (
	"uids"	=> array($_COOKIE['58f2b48818d446be97a1827dd10d89f2_user']),
	"fields"=> array('name','sex','star','birthday','work_info','tinyurl','email_hash','headurl','mainurl','hometown_location')
);
$uu = $xn->users('getInfo',$params1);

$actid = $_REQUEST['act'];
$userid = $_REQUEST['uid'];
if (!$actid && $uu) {
	$renren_user_id = $uu['user']['uid'];
	$rrUser = ZUser::GetRenrenUser($renren_user_id);
	if ($rrUser) {
		ZLogin::Login($rrUser['id']);
		Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
	}
} elseif ($actid == 'create' && $userid == $uu['user']['uid']) {	//创建人人和本站的连接
	if (ZUser::GetRenrenUser($uu['user']['uid'])) {
		Session::Set('error', '注册失败，用户名已被使用');
	} else {
		$u = array();
		$u['username'] = $uu['user']['uid'];
		$u['realname'] = $uu['user']['name'];
		$u['password'] = 'fas3244n32ink4';
		$u['city_id'] = abs(intval($city['id']));
		$u['email'] = $uu['user']['email_hash']?$uu['user']['email_hash']:$uu['user']['uid'].'@renren.com';
		if ( option_yes('emailverify') ) { 
			$u['enable'] = 'N'; 
		}
		if ( $user_id = ZUser::CreateRenRen($u, $userid) ) {
			Session::Set('notice', '账号绑定成功');
			ZLogin::Login($user_id);
			Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
		} else {
			Session::Set('error', '账户关联出错!');
		}
	}
} elseif (!$uu) {
	Session::Set('error', '访问出错');
	Utility::Redirect(WEB_ROOT .'/index.php');
}

include template('xiaonei_connect_ok');

