<?php 
$others_side_ns = abs(intval($INI['system']['sideteam']));
$others_team_id = abs(intval($team['id']));
$others_city_id = abs(intval($city['id']));
$others_now = time();
if ( abs(intval($INI['system']['sideteam'])) ) {
	$oc = array( 
			'city_id' => array($others_city_id, 0), 
			'team_type' => 'normal',
			"id <> '$others_team_id'",
			"begin_time < '$others_now'",
			"end_time > '$others_now'",
			"audit" => 1, //所有已审核的团购
			);
	$others = DB::LimitQuery('team', array(
				'condition' => $oc,
				'order' => 'ORDER BY `sort_order` DESC, `id` DESC',
				'size' => $others_side_ns,
				));
}
; ?>
<?php if($others){?>
<div class="sbox side-business">
	<div class="sbox-top"></div>
	<div class="sbox-content">
		<div class="tip">
		<h2>正在团购...</h2>
		<?php $index=0; ?>
		<?php if(is_array($others)){foreach($others AS $one) { ?>
			<b><?php echo ++$index; ?>、<?php echo $one['title']; ?></b>
			<?php if($one['image']){?><p><a href="/team.php?id=<?php echo $one['id']; ?>"><img src="<?php echo team_image($one['image'], true); ?>" width="195" border="0" /></a></p><?php }?>
			<p><a href="/team.php?id=<?php echo $one['id']; ?>">&raquo;&nbsp;点击查看本单详情</a></p>
		<?php }}?>
		</div>
	</div>
	<div class="sbox-bottom"></div>
</div>
<?php }?>
