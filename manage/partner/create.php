<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$table = new Table('partner', $_POST);
	$table->SetStrip('location', 'other');
	$table->create_time = time();
	$table->user_id = $login_user_id;
	$table->password = ZPartner::GenPassword($table->password);
	$table->group_id = abs(intval($table->group_id));
	$table->city_id = abs(intval($table->city_id));
	$table->open = (strtoupper($table->open)=='Y') ? 'Y' : 'N';
	$table->display = (strtoupper($table->display)=='Y') ? 'Y' : 'N';
	$table->image = upload_image('upload_image', null, 'team', true);
	$table->image1 = upload_image('upload_image1', null, 'team');
	$table->image2 = upload_image('upload_image2', null, 'team');
	$table->insert(array(
		'username', 'user_id', 'city_id', 'title', 'group_id',
		'bank_name', 'bank_user', 'bank_no', 'create_time',
		'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
		'password', 'address', 'open', 'display',
		'image', 'image1', 'image2', 'longlat',
	));
	$partner = DB::GetTableRow('partner', array(
					'username' => $username,
					'password' => $password,));
	// 更新商户支付信息
	if ( $login_partner ) {
		$table = new Table('partner_pay', $_POST);
		$table->SetPk('id', $partner['id']);
		$insert = array(
			'id', 'tenpaymid', 'tenpaysec', 'alipaymid', 'alipaysec',
		);
		$flag = $table->insert($insert);
	}

	Session::Set('notice', '新建商户成功');
	Utility::Redirect( WEB_ROOT . '/manage/partner/index.php');
}

include template('manage_partner_create');
