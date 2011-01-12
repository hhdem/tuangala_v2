<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');

need_partner();

$actions = array('drawmoney', 'cash');
$daytime = strtotime(date('Y-m-d'));
($s = strtolower(strval($_GET['s']))) || ($s = 'cash');
if(!$s||!in_array($s, $actions)) $s = 'cash';

if ( 'cash' == $s ) {
	$condition = array( 'partner_id'=> $partner_id, "end_time < $daytime",
	"now_number >= min_number", );
	$count = Table::Count('team', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	$teams = DB::LimitQuery('team', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'offset' => $offset,
		'size' => $pagesize,
	));
	$team_ids = Utility::GetColumn($teams, 'id');
	foreach($teams AS $id=>$one) {
		$onlinepay = Table::Count('order', array(
			'state' => 'pay',
			'team_id' => $one['id'],
		), 'money');
		$creditpay = Table::Count('order', array(
			'state' => 'pay',
			'team_id' => $one['id'],
		), 'credit');
		$buycount = Table::Count('order', array(
			'state' => 'pay',
			'team_id' => $one['id'],
		), 'quantity');
		/*$c1 = array( 'team_id'=> $$one['id'], );
		$orders = DB::LimitQuery('order', array(
			'condition' => $c1,
		));*/
		$sumonlinepay += $onlinepay;
		$sumcreditpay += $creditpay;
		$one['onlinepay'] = $onlinepay;
		$one['creditpay'] = $creditpay;
		$one['buycount'] = $buycount;
		$teams[$id] = $one;
	}
	$condition = array( 'pid'=> $partner_id );
	$sumdrawmoney = Table::Count('partner_drawmoney', $condition, 'drawmoney');
	include template('biz_money_cash');
}
elseif ( 'drawmoney' == $s ) {
	$condition = array( 'pid'=> $partner_id, );
	$count = Table::Count('partner_drawmoney', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 20);
	$draws = DB::LimitQuery('partner_drawmoney', array(
		'condition' => $condition,
		'order' => 'ORDER BY drawdatetime',
		'offset' => $offset,
		'size' => $pagesize,
	));
	foreach($draws AS $id=>$one) {
		if ($one['state'] == 'draw') {
			$drawmoney = $one['drawmoney'];
		}
		elseif ($one['state'] == 'success') {
			$summoney += $one['drawmoney'];
		}
		else {
			$ingmoney += $one['drawing'];
		}
	}
	
	include template('biz_money_draw');
}

else redirect( WEB_ROOT . '/biz/money.php' );
