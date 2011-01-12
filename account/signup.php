<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

if ( $_POST ) {
	$u = array();
	$u['username'] = strval($_POST['username']);
	$u['password'] = strval($_POST['password']);
	$u['email'] = strval($_POST['email']);
	$u['city_id'] = isset($_POST['city_id']) 
		? abs(intval($_POST['city_id'])) : abs(intval($city['id']));
	$u['mobile'] = strval($_POST['mobile']);

	if ( $_POST['subscribe'] ) { 
		ZSubscribe::Create($u['email'], abs(intval($u['city_id']))); 
	}
	if ( ! Utility::ValidEmail($u['email'], true) ) {
		Session::Set('error', 'Email地址为无效地址');
		redirect( WEB_ROOT . '/account/signup.php');
	}
	if ($_POST['password2']==$_POST['password'] && $_POST['password']) {
		if ( option_yes('emailverify') ) { 
			$u['enable'] = 'N'; 
		}
		if ( $user_id = ZUser::Create($u) ) {
			if ( option_yes('emailverify') ) {
				mail_sign_id($user_id);
				Session::Set('unemail', $_POST['email']);
				redirect( WEB_ROOT . '/account/signuped.php');
			} else {
				ZLogin::Login($user_id);
				redirect(get_loginpage(WEB_ROOT . '/index.php'));
			}
		} else {
			$au = Table::Fetch('user', $_POST['email'], 'email');
			if ( $au ) {
				Session::Set('error', '注册失败，Email已被使用');
			} else {
				Session::Set('error', '注册失败，用户名已被使用');
			}
		}
	} else {
		Session::Set('error', '注册失败，密码设置有问题');
	}
}

$pagetitle = '注册';
include template('account_signup');
