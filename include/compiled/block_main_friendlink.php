<?php 
	$_fl_logos = DB::LimitQuery('friendlink', array(
				'condition' => array( 
					'LENGTH(logo)>0',
					'display' => 'Y',
					),
				'order' => 'ORDER BY sort_order DESC',
				));
	$_fl_texts = DB::LimitQuery('friendlink', array(
				'condition' => array( 
					'LENGTH(logo)=0',
					'display' => 'Y',
			),
			'order' => 'ORDER BY sort_order DESC',
			));
; ?>
<?php if(($_fl_logos||$_fl_texts)){?>
<div class="bdw" style="margin:-50px auto 20px;; width:944px;">
<div class="box mainwide cf">
	<div class="box-top"></div>
	<div class="box-content cf" style="padding:15px;">
	<?php if(is_array($_fl_logos)){foreach($_fl_logos AS $one) { ?>
		<a href="<?php echo $one['url']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><img src="<?php echo $one['logo']; ?>" alt="<?php echo $one['title']; ?>" /></a>
	<?php }}?>
		<div class="cl"></div>
	<?php if(is_array($_fl_texts)){foreach($_fl_texts AS $one) { ?>
		<a href="<?php echo $one['url']; ?>" title="<?php echo $one['title']; ?>" target="_blank"><?php echo $one['title']; ?></a>
	<?php }}?>
		<a href="/help/link.php">&gt;&gt;更多</a>
	</div>
	<div class="box-bottom"></div>
</div>
</div>
<?php }?>
