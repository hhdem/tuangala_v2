<?php
class ZTeam
{
	static public function DeleteTeam($id) {
		$orders = Table::Fetch('order', array($id), 'team_id');
		foreach( $orders AS $one ) {
			if ($one['state']=='pay') return false;
			if ($order['card_id']) {
				Table::UpdateCache('card', $order['card_id'], array(
					'team_id' => 0,
					'order_id' => 0,
					'consume' => 'N',
				));
			}
			Table::Delete('order', $one['id']);
		}
		return Table::Delete('team', $id);
	}

	static public function AuditTeam($id, $aud) {
		$table = new Table('team', $id);
		Table::UpdateCache('team', $id, array(
			'audit' => $aud,
		));
		return $table->Set('audit', $aud);
	}

	static public function BuyOne($order) {
		$order = Table::FetchForce('order', $order['id']);
		$team = Table::FetchForce('team', $order['team_id']);
		$plus = $team['conduser']=='Y' ? 1 : $order['quantity'];
		$team['now_number'] += $plus;

		/* close time */
		if ( $team['max_number']>0 
				&& $team['now_number'] >= $team['max_number'] ) {
			$team['close_time'] = time();
		}

		/* reach time */
		if ( $team['now_number']>=$team['min_number']
			&& $team['reach_time'] == 0 ) {
			$team['reach_time'] = time();
		}

		Table::UpdateCache('team', $team['id'], array(
			'close_time' => $team['close_time'],
			'reach_time' => $team['reach_time'],
			'lastbuy_time' => time(),
			'now_number' => array( "`now_number` + {$plus}", ),
		));

		/* cash flow */
		ZFlow::CreateFromOrder($order);
		/* order : send coupon ? */
		ZCoupon::CheckOrder($order);
		/* order : invite buy */
		ZInvite::CheckInvite($order);
		/* credit */
		ZCredit::Buy($order['user_id'], $order);
	}
}
?>
