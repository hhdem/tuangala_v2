<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

$xn = new Xiaonei('58f2b48818d446be97a1827dd10d89f2','852612554a5745878d89777c1dd1ca0a');
$params1 = array (
	"uids"	=> array($_COOKIE['58f2b48818d446be97a1827dd10d89f2_user']),
	"fields"=> array('name','sex','star','birthday','work_info','tinyurl','headurl','mainurl','hometown_location')
);
$uu = $xn->users('getInfo',$params1);

if ( $_POST && $uu) {
	$login_user = ZUser::GetLogin($_POST['email'], $_POST['password']);
	if ( !$login_user ) {
		Session::Set('error', '登录失败,请确认你的用户名/密码正确!');
	} else if (option_yes('emailverify')
			&& $login_user['enable']=='N'
			&& $login_user['secret']
			) {
		Session::Set('unemail', $_POST['email']);
		Utility::Redirect(WEB_ROOT .'/account/verify.php');
	} else {
		if (ZUser::GetRenrenUser($uu['user']['uid'])) {
			Session::Set('error', '注册失败，用户名已被使用');
		} else {
			Session::Set('user_id', $login_user['id']);
			ZLogin::Remember($login_user);
			ZUser::SynLogin($login_user['username'], $_POST['password']);
			if(!ZUser::BindRenRen($login_user, $uu['user']['uid'])){
				Session::Set('error', '账号绑定失败');
			} else {
				Session::Set('notice', '账号绑定成功');
				Utility::Redirect(get_loginpage(WEB_ROOT . '/index.php'));
			}
		}
	}
} else {
	Session::Set('error', '账号绑定失败');
}

include template('xiaonei_connect_ok');

