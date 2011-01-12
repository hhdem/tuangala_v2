<?php include template("header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">

<?php if($order){?>
<div id="sysmsg-tip" ><div class="sysmsg-tip-top"></div><div class="sysmsg-tip-content">您已经下过订单，但还没有付款。<a href="/order/check.php?id=<?php echo $order['id']; ?>">查看订单并付款</a><span id="sysmsg-tip-close" class="sysmsg-tip-close">关闭</span></div><div class="sysmsg-tip-bottom"></div></div><div id="deal-default"> 
<?php }?>

	<div id="deal-default">
		<?php include template("block_team_share");?>
		<div class="content">
			<div class="cityimg_<?php echo $city['ename']; ?>"></div>
			<div id="deal-intro" class="cf">
				<div class="conleft_title">
					<h1><?php if($team['close_time']==0){?><a class="deal-today-link" href="/team.php?id=<?php echo $team['id']; ?>">今日团购：</a><?php }?><?php echo $team['title']; ?></h1>
				</div>
                <div class="main">
                    <div class="deal-buy">
                        <div class="deal-price-tag"></div>
					<?php if(($team['state']=='soldout')){?>
                        <p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong><span class="deal-price-soldout"></span></p>
					<?php } else if($team['close_time']) { ?>
                        <p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong><span class="deal-price-expire"></span></p>
					<?php } else { ?>
                        <p class="deal-price"><strong><?php echo $currency; ?><?php echo moneyit($team['team_price']); ?></strong><span><a <?php echo $team['begin_time']<time()?'href="/team/buy.php?id='.$team['id'].'"':''; ?>><img src="/static/css/i/button-deal-buy.gif" /></a></span></p>
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
                            <td><?php echo $currency; ?><?php echo $discount_price; ?></td>
                        </tr>
                    </table>
					<?php if($team['close_time']){?>
                    <div class="deal-box deal-timeleft deal-off" id="deal-timeleft" curtime="<?php echo $now; ?>000" diff="<?php echo $diff_time; ?>000">
						<h3>本团购结束于</h3>
						<div class="limitdate"><p class="deal-buy-ended"><?php echo date('Y-m-d', $team['close_time']); ?><br><?php echo date('H:i:s', $team['close_time']); ?></p></div>
					</div>
					<?php } else { ?>
                    <div class="deal-box deal-timeleft deal-on" id="deal-timeleft" curtime="<?php echo $now; ?>000" diff="<?php echo $diff_time; ?>000">
						<h3>剩余时间</h3>
						<div class="limitdate">
						<p id="counter" class="last_time">
						<?php if($left_day>0){?>
							<span class="day"><em><?php echo $left_day; ?></em>天</span><span class="hour"><em><?php echo $left_hour; ?></em>小时</span><span class="minute"><em><?php echo $left_minute; ?></em>分钟</span>
						<?php } else { ?>
							<span class="hour"><em><?php echo $left_hour; ?></em>小时</span><span class="minute"><em><?php echo $left_minute; ?></em>分钟</span><span class="second"><em><?php echo $left_time; ?></em>秒</span>
						<?php }?>
						</p>
						</div>

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
					<div style="padding-top:10px;">
						<a href="/team/list.php">
							<div class="moreteam">
							</div>
						</a>
					</div>
				</div>
                <div class="side">
					<div style="width:696px;height:280px;">
						<div class="deal-buy-cover-img" id="team_images">
						<?php if($team['image1']||$team['image2']){?>
							<div class="mid">
								<ul>
									<li class="first"><img src="<?php echo team_image($team['image']); ?>"/></li>
								<?php if($team['image1']){?>
									<li><img src="<?php echo team_image($team['image1']); ?>"/></li>
								<?php }?>
								<?php if($team['image2']){?>
									<li><img src="<?php echo team_image($team['image2']); ?>"/></li>
								<?php }?>
								</ul>
								<div id="img_list">
									<a ref="1" class="active">1</a>
								<?php $imageindex=1;; ?>
								<?php if($team['image1']){?>
									<a ref="<?php echo ++$imageindex; ?>" ><?php echo $imageindex; ?></a>
								<?php }?>
								<?php if($team['image2']){?>
									<a ref="<?php echo ++$imageindex; ?>" ><?php echo $imageindex; ?></a>
								<?php }?>
								</div> 
							</div>
							<?php } else { ?>
								<img src="<?php echo team_image($team['image']); ?>" width="440" height="280" />
							<?php }?>
						</div>
						<?php 
							$ask_con = array('length(comment)>0');
							if(option_yes('teamask')) { $ask_con[] = 'team_id > 0'; } 
							else { $ask_con['team_id'] = $id; }
							$ask_count = Table::Count('ask', $ask_con);
							$asks = DB::LimitQuery('ask', array('condition'=>$ask_con, 'size'=>1, 'order'=>'ORDER BY id DESC'));
						; ?>
						<div id="post_type">
							<label class="lab">配送方式:<?php if($team['delivery']=='express'){?>快递<?php } else if($team['delivery']=='pickup') { ?>自取<?php } else { ?><?php echo $INI['system']['couponname']; ?><?php }?></label>
							<div style="padding:10px;">
							<?php if($team['delivery']=='express'){?>快递费用 <span class="money"><?php echo $currency; ?></span><?php echo $team['fare']; ?><br>配送说明: <?php echo $team['express']; ?><?php } else if($team['delivery']=='pickup') { ?><span><b>自取地址:</b> <?php echo $team['address']; ?><br><b>电话:</b> <?php echo $team['mobile']; ?></span><?php } else { ?><span>旮旯卷的配送说明</span><?php }?>
							</div>
							<div style="padding:10px 10px 0 10px;float:left;"><label class="lab">本单答疑</label></div>
							<p class="nav" style="padding-top:5px;border-top: 1px dashed #CDCCCA;font-size: 10px;"><a href="/team/ask.php?id=<?php echo $team['id']; ?>">查看全部(<?php echo $ask_count; ?>)</a><br><a href="/team/ask.php?id=<?php echo $team['id']; ?>#post">我要提问</a></p>
							<ul class="list">
							<?php if(is_array($asks)){foreach($asks AS $one) { ?>
								<li><a href="/team/ask.php?id=<?php echo $team['id']; ?>#ask-entry-<?php echo $one['id']; ?>" target="_blank"><?php echo htmlspecialchars(mb_substr($one['content'],0,22,'UTF-8')); ?>...</a></li>
							<?php }}?>
							</ul>
							<div class="custom-service"><p class="im"><a id="service-msn-help" href="msnim:chat?contact=<?php echo $INI['system']['kefumsn']; ?>"><img src="/static/css/i/button-custom-msn.gif" /></a>&nbsp;<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $INI['system']['kefuqq']; ?>&amp;site=qq&amp;menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $INI['system']['kefuqq']; ?>:42" alt="在线客服:<?php echo $INI['system']['kefuqq']; ?>" title="在线客服:<?php echo $INI['system']['kefuqq']; ?>" /></a>&nbsp;<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=244756508&amp;site=qq&amp;menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:244756508:42" alt="在线客服:244756508" title="在线客服:244756508" /></a><a href="/about/contact.php" target="_blank;">更多>></a></p></div>
						</div>
					</div>
				<?php if(strip_tags($team['summary'])!=$team['summary']){?><?php echo $team['summary']; ?><?php } else { ?><div class="digest"><br /><?php echo nl2br(strip_tags($team['summary'])); ?></div><?php }?>
                </div>
            </div>
            <div id="deal-stuff" class="cf">
                <div class="clear box <?php echo ($partner&&!option_yes('teamwhole'))?'box':''; ?>" style="width: 702px;float:left; padding-right: 16px;">
                    <div class="box-top"></div>
                    <div class="box-content cf">
                        <div class="main" id="team_main_side">
						<?php if(trim(strip_tags($team['detail']))){?>
                            <h2 class="h2" id="detail">本单详情</h2>
							<div class="blk detail"><?php echo $team['detail']; ?></div>
						<?php }?>
						<?php if(trim(strip_tags($team['notice']))){?>
							<h2 class="h2" id="detailit">特别提示</h2>
							<div class="blk cf"><?php echo $team['notice']; ?></div>
						<?php }?>
						<?php if(trim(strip_tags($team['userreview']))){?>
							<h2 class="h2" id="userreview">他们说</h2>
							<div class="blk review"><?php echo userreview($team['userreview']); ?></div>
						<?php }?>
						<?php if(trim(strip_tags($team['systemreview']))){?>
							<h2 class="h2" id="systemreview"><?php echo $INI['system']['abbreviation']; ?>说</h2>
							<div class="blk review"><?php echo $team['systemreview']; ?></div>
						<?php }?>
						</div>

                        <div class="side" id="team_partner_side_<?php echo (!option_yes('teamwhole')&&abs(intval($partner['id'])))?1:0; ?>">
                            <div >
								<h2 class="h2">商户名称: <a href="/partner.php?id=<?php echo $partner['id']; ?>" style="color:#ececec;"><?php echo $partner['title']; ?></a></h2>
								<div style="float:left;width:330px;">
									<div style="margin-top:10px;"><?php echo $partner['location']; ?></div>
									<div style="margin-top:10px;">主页:<a href="<?php echo $partner['homepage']; ?>" target="_blank"> <?php echo domainit($partner['homepage']); ?></a></div>
									<div style="margin-top:10px;">联系方式: <?php echo $partner['phone']; ?> / <?php echo $partner['mobile']; ?></div>
									<div style="margin-top:10px;"><?php echo $partner['other']; ?></div>
								</div>
								<div id="pmap" style="float:right;">
								<?php include template("block_block_partnermap");?>
								</div>
							</div>
							
						</div>

                        <div class="clear"></div>
                    </div>
                    <div class="box-bottom"></div>
                </div>
				 <div id="sidebar">
					<?php include template("block_side_invite");?>
					<?php include template("block_side_flv");?>
					<?php include template("block_side_others_seconds");?>
					<?php include template("block_side_others");?>
					<?php include template("block_side_vote");?>
					<?php include template("block_side_business");?>
					<?php include template("block_side_subscribe");?>
				</div>
            </div>
    </div>
   
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
