<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();
$partner_id = abs(intval($_SESSION['partner_id']));
$login_partner = $partner = Table::Fetch('partner', $partner_id);
$partner_pay = Table::Fetch('partner_pay', $partner_id);

if ( $_POST ) {
	if (abs(intval($_POST['id'])) != $partner_id) {
		$errmsg = '错误的链接地址!';
		Session::Set('error', $errmsg);
		redirect( WEB_ROOT . '/biz/index.php');
	}
	$table = new Table('partner', $_POST);
	$table->SetStrip('location', 'other');
	$table->SetPk('id', $partner_id);
	$table->image = upload_image('upload_image', $partner['image'], 'team', true);
	$table->image1 = upload_image('upload_image1', $partner['image1'], 'team');
	$table->image2 = upload_image('upload_image2', $partner['image2'], 'team');
	$update = array(
		'title', 'bank_name', 'bank_user', 'bank_no',
		'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
		'address','image', 'image1', 'image2', 'longlat',
	);
	if ( $table->password == $table->password2 && $table->password ) {
		$update[] = 'password';
		$table->password = ZPartner::GenPassword($table->password);
	}
	$flag = $table->update($update);

	// 更新商户支付信息
	if ( $flag ) {
		$table = new Table('partner_pay', $_POST);
		if (!$partner_id) {
			$errmsg = '错误的链接地址!';
			Session::Set('error', $errmsg);
			redirect( WEB_ROOT . '/biz/index.php');
			
		}
		$condition = array(
			'id' => $partner_id,
		);
		$count = Table::Count('partner_pay', $condition);

		$update = array(
			'id', 'alipaymid', 'alipaysec', 'alipayacc', 'alipayitbpay',
		);
		if ($count > 0) {
			$table->SetPk('id', $partner_id);
			$flag = $table->update($update);
		} else {
			$table->SetPk('id', $partner_id);
			$flag = $table->insert($update);
		}
	}

	if ( $flag ) {
		Session::Set('notice', '修改商户信息成功');
		redirect( WEB_ROOT . "/biz/settings.php");
	}
	Session::Set('error', '修改商户信息失败');
	$partner = $_POST;
}

include template('biz_settings');
