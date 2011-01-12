<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();

$condition = array( 'pid'=> $partner_id, 'state'=>'draw', );
$count = Table::Count('partner_drawmoney', $condition);

if ($_POST['drawmoney'] < 200) {
	Session::Set('error', '您每次的支取底线为200元, 请确保您输入的金额正确!');
	redirect( WEB_ROOT. "/biz/money.php");
}

if ($count == 0 && $_POST) {
	// 获得总金额
	$summoney = current_partner_sum_money($partner_id, 0);

	// 获得最近一次支取记录
	$condition = array( 'pid'=> $partner_id, );
	$last_draw = DB::LimitQuery('partner_drawmoney', array(
				'condition' => $condition,
				'one' => true,
				'order' => 'ORDER BY drawdatetime',
				));

	// 获得已经支取金额
	$condition = array( 'pid'=> $partner_id );
	$sumdrawmoney = Table::Count('partner_drawmoney', $condition, 'drawmoney');

	if ($summoney < ($_POST['drawmoney'] + $sumdrawmoney)) {
		Session::Set('error', '您要支取的金额超过可支取金额！如有疑问请联系客服!');
		redirect( WEB_ROOT. "/biz/money.php");
	}
	
	$table = new Table('partner_drawmoney', $_POST);
	$table->pid = $partner_id;
	$table->drawdatetime = time();
	$table->state = 'draw';
	$table->currentmoney = $summoney - $sumdrawmoney - $_POST['drawmoney'];
	$insert = array(
		'pid', 'currentmoney', 'drawmoney', 'drawdatetime', 'state',
	);
	$flag = $table->insert($insert);
	Session::Set('notice', '申请支取金额'.$_POST['drawmoney'].'已经提交, 请耐心等待!');
	redirect( WEB_ROOT. "/biz/money.php");
	
}
elseif ($count > 0) {
	Session::Set('error', '您有一个支取申请正在进行中, 请耐心等待!');
	redirect( WEB_ROOT. "/biz/money.php");
}