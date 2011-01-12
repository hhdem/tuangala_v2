<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

$id = abs(intval($_GET['id']));
$partner = Table::Fetch('partner', $id);
$partner_pay = Table::Fetch('partner_pay', $id);

if ( $_POST && $id==$_POST['id'] && $partner) {
	$table = new Table('partner', $_POST);
	$table->SetStrip('location', 'other');
	$table->group_id = abs(intval($table->group_id));
	$table->city_id = abs(intval($table->city_id));
	$table->open = (strtoupper($table->open)=='Y') ? 'Y' : 'N';
	$table->display = (strtoupper($table->display)=='Y') ? 'Y' : 'N';
	$table->image = upload_image('upload_image', $partner['image'], 'team', true);
	$table->image1 = upload_image('upload_image1', $partner['image1'], 'team');
	$table->image2 = upload_image('upload_image2', $partner['image2'], 'team');

	$up_array = array(
			'username', 'title', 'bank_name', 'bank_user', 'bank_no',
			'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
			'address', 'group_id', 'open', 'city_id', 'display',
			'image', 'image1', 'image2', 'longlat',
			);

	if ($table->password ) {
		$table->password = ZPartner::GenPassword($table->password);
		$up_array[] = 'password';
	}
	$flag = $table->update( $up_array );

	// 更新商户支付信息
	if ( $flag ) {
		$pp['alipayacc'] = $_POST['alipayacc'];
		$pp['alipayitbpay'] = $_POST['alipayitbpay'];
		$pp['alipaymid'] = $_POST['alipaymid'];
		$pp['alipaysec'] = $_POST['alipaysec'];
		$table = new Table('partner_pay', $pp);
		$table->SetPk('id', $id);
		$update = array(
				'id', 'alipayacc', 'alipayitbpay', 'alipaymid', 'alipaysec',
			);
		if ($partner_pay){
			$flag = $table->update($update);
		}else {
			$flag = $table->insert($update);
		}
	}

	if ( $flag ) {
		Session::Set('notice', '修改商户信息成功');
		redirect( WEB_ROOT . "/manage/partner/edit.php?id={$id}");
	}
	Session::Set('error', '修改商户信息失败');
	$partner = $_POST;
}

include template('manage_partner_edit');
