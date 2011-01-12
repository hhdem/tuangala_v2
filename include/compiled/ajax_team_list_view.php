		<script src="/static/js/ajax_tuangala.js" type="text/javascript"></script>
		<script type="text/javascript" src="/static/js/jquery.easing.min.js"></script>
		<?php if(!$teams){?>
			<div class="content_list">
				<div id="deal-intro" class="cf">
					<div class="conleft_title">
						<h1>[<?php echo $city['name']; ?>] <?php echo $category['name']; ?> 中没有相应的商品呢！</h1>
					</div>
				</div>
			</div>
		<?php } else { ?>
		<?php if(is_array($teams)){foreach($teams AS $index=>$team) { ?>
		<div id="team_<?php echo $team['id']; ?>" >
		
		<div class="content_list">
			<div class="cityimg_<?php echo $city['ename']; ?>"></div>
			<div id="deal-intro" class="cf">
				<div class="conleft_title">
					<h1><?php if($team['close_time']==0){?><a class="deal-today-link" href="/team.php?id=<?php echo $team['id']; ?>">今日第<?php echo $index+1; ?>团：</a><?php }?><a href="/team.php?id=<?php echo $team['id']; ?>" title="<?php echo $team['title']; ?>" style="color:black;"><?php echo $team['title']; ?></a></h1>
				</div>
                <div class="main">
					<?php if($team['schedulable'] == 'N'){?>
						<div class="deal-buy">
							<div class="deal-price-tag"></div>
						<?php if(($team['state']=='soldout')){?>
							<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong><span class="deal-price-soldout"></span></p>
						<?php } else if($team['close_time']) { ?>
							<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong><span class="deal-price-expire"></span></p>
						<?php } else { ?>
							<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong><span><a <?php echo $team['begin_time']<time()?'href="/team/buy.php?id='.$team['id'].'"':''; ?>>
							
								<img src="/static/css/i/button-deal-buy.gif" /></a></span></p>
							
						<?php }?>
						</div>
						<table class="deal-discount">
							<tr>
								<th>原价</th>
								<th>折扣</th>
								<th>节省</th>
							</tr>
							<tr>
								<td><?php echo $currency; ?><?php echo moneyit($team['market_price']); ?></td>
								<td><?php echo team_discount($team); ?></td>
								<td><?php echo $currency; ?><?php echo $team['discount_price']; ?></td>
							</tr>
						</table>
					<?php } else { ?>
						<div class="deal-buy">
							<div class="deal-price-tag"></div>
						<?php if(($team['state']=='soldout')){?>
							<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['schedule_price']); ?></strong><span class="deal-price-soldout"></span></p>
						<?php } else if($team['close_time']) { ?>
							<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['schedule_price']); ?></strong><span class="deal-price-expire"></span></p>
						<?php } else { ?>
							<p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['schedule_price']); ?></strong><span><a <?php echo $team['begin_time']<time()?'href="/team/buy.php?id='.$team['id'].'"':''; ?>>
							
								<img src="/static/css/i/button-schedule-buy.gif" /></a></span></p>
							
						<?php }?>
						</div>
						<table class="deal-discount">
							<tr>
								<th>原价</th>
								<th>团购价</th>
								
								<th>折扣</th>
							</tr>
							<tr>
								<td><?php echo $currency; ?><?php echo moneyit($team['market_price']); ?></td>
								<td><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></td>
								
								<td><?php echo team_discount($team); ?></td>
							</tr>
						</table>
					<?php }?>
					<?php if($team['close_time']){?>
                    <div class="deal-box deal-timeleft deal-off" id="deal-timeleft" curtime="<?php echo $now; ?>000" diff="$<?php echo $one['end_time']-$now; ?>000">
						<h3>本团购结束于</h3>
						<div class="limitdate"><p class="deal-buy-ended"><?php echo date('Y-m-d', $team['close_time']); ?><br><?php echo date('H:i:s', $team['close_time']); ?></p></div>
					</div>
					<?php } else { ?>
                    <div class="deal-box deal-timeleft deal-on" id="deal-timeleft" curtime="<?php echo $now; ?>000" diff="$<?php echo $one['end_time']-$now; ?>000">
						<h3>剩余时间</h3>
						<div class="limitdate">
						<p id="counter" class="last_time">
						<?php if($team['left_day']>0){?>
							<span class="day"><em><?php echo $team['left_day']; ?></em>天</span><span class="hour"><em><?php echo $team['left_hour']; ?></em>小时</span><span class="minute"><em><?php echo $team['left_minute']; ?></em>分钟</span>
						<?php } else { ?>
							<span class="hour"><em><?php echo $team['left_hour']; ?></em>小时</span><span class="minute"><em><?php echo $team['left_minute']; ?></em>分钟</span><span class="second"><em><?php echo $team['left_time']; ?></em>秒</span>
						<?php }?>
						</p></div>
					</div>
					<?php }?>

				<?php if($team['close_time']==0){?>
					<?php if($team['state']=='none'){?>
					<div class="deal-box deal-status" id="deal-status">
						<p class="deal-buy-tip-top"><strong><?php echo $team['now_number']; ?></strong> 人已购买</p>
						
						<div class="meter-wrap">
							<div class="meter-value" style="float:left;background-color: #0a0; width: <?php echo $team['now_number']/$team['min_number']*100; ?>%;">
								<div class="meter-text">
									<?php echo $team['now_number']; ?>/<?php echo $team['min_number']; ?>
								</div>
							</div>
						</div>
						<div class="cf"><div class="min">0</div><div class="max"><?php echo $team['min_number']; ?></div></div>
						<p class="deal-buy-tip-btm">还差 <strong><?php echo $team['min_number']-$team['now_number']; ?></strong> 人到达最低团购人数</p>
					</div>
					<?php } else { ?>
					<div class="deal-box deal-status deal-status-open" id="deal-status">
						<p class="deal-buy-tip-top"><strong><?php echo $team['now_number']; ?></strong> 人已购买</p>
					<?php if($team['max_number']&&$team['max_number']>$team['now_number']){?>
						<p class="deal-buy-tip-btm">本单仅剩：<strong><?php echo $team['max_number']-$team['now_number']; ?></strong>份，欲购从速</p>
					<?php }?>
						<p class="deal-buy-on" style="line-height:200%;"><img src="/static/css/i/deal-buy-succ.gif"/> 团购成功！ <?php if($team['max_number']>$team['now_number']||$team['max_number']==0){?><br/>还可以继续购买<?php }?></p>
					<?php if($team['reach_time']){?>
						<p class="deal-buy-tip-btm"><?php echo date('G点i分', $team['reach_time']); ?>达到最低团购人数：<strong><?php echo $team['min_number']; ?></strong>人</p>
					<?php }?>
					</div>
					<?php }?>
				<?php } else { ?>
					<div class="deal-box deal-status deal-status-<?php echo $team['state']; ?>" id="deal-status"><div class="deal-buy-<?php echo $team['state']; ?>"></div><p class="deal-buy-tip-total">共有 <strong><?php echo $team['now_number']; ?></strong> 人购买</p></div> 
				<?php }?>
				</div>
				<div class="side">
                     <div class="deal-buy-cover-img" id="team_images">
						<a href="/team.php?id=<?php echo $team['id']; ?>" title="<?php echo $team['title']; ?>">
							<img src="<?php echo team_image($team['image']); ?>" width="440" height="280" />
						</a>
					</div>
					<div class="auth"><?php if($team['authenticate']==1){?><img border="0" src="/static/css/i/biz-authenticate.png"><?php }?></div>
                    <div class="digest_list"><br /><?php echo nl2br(strip_tags($team['summary'])); ?></div>
                </div>
            </div>
		</div>
    </div>
	<a class="hidedetail-top" teamid="<?php echo $team['id']; ?>" style="display: none; ">▲点击收起此团购详情</a>
	<div></div>
	<a class="loadmoredetail" teamid="<?php echo $team['id']; ?>" style="display: block; ">▼点击获取更多详情</a>
	<a class="hidedetail-bottom" teamid="<?php echo $team['id']; ?>" onclick="javascript:scroller('team-<?php echo $team['id']; ?>', 800);" style="display: none; ">▲点击收起此团购详情</a>
	<p></p>
<?php }}?>
<?php }?>
    <div class="clear"></div>
	<div><?php echo $pagestring; ?></div>
