<?php include template("biz_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">	
	<div class="dashboard" id="dashboard">
		<ul><?php echo current_biz_index('index'); ?></ul>
	</div>
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
                    <h2>项目列表</h2>
					<ul class="filter"><li><a href="/biz/index.php">全部项目</a></li><li><a href="/biz/index.php?ing=ing">进行中的项目</a></li></ul>
				</div>
                <div class="sect">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					<tr><th width="500">项目名称</th><th width="80">城市</th><th width="100">日期</th><th width="50">成交</th><th width="55">团购价</th><th width="40">审核</th><th width="120">操作</th></tr>
					<?php if(is_array($teams)){foreach($teams AS $index=>$one) { ?>
					<?php $one['state'] = team_state($one); ?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td style="text-align:left;"><a class="deal-title" href="/team.php?id=<?php echo $one['id']; ?>" target="_blank"><?php echo $one['title']; ?></a></td>
						<td><?php if($one['city_id']){?><?php echo $cities[$one['city_id']]['name']; ?><?php } else { ?>全国<?php }?></td>
						<td><?php echo date('Y-m-d',$one['begin_time']); ?><br/><?php echo date('Y-m-d',$one['end_time']); ?></td>
						<td><?php echo $one['now_number']; ?>/<?php echo $one['min_number']; ?></td>
						<td><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['team_price']); ?><br/><span class="money"><?php echo $currency; ?></span><?php echo moneyit($one['market_price']); ?></td>
						<td><?php if($one['audit']==1){?>是<?php } else if($one['audit']==2) { ?>审核未通过<?php } else { ?><p style="color:red;">等待审核</p><?php }?></td>
						<td class="op" nowrap><a href="/ajax/partner.php?action=teamdetail&id=<?php echo $one['id']; ?>" class="ajaxlink">详情</a> <?php if($one['audit']<>1){?>| <a href="/biz/coupon_edit.php?id=<?php echo $one['id']; ?>">编辑</a> | <a href="/ajax/partner.php?action=teamremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="确定删除本项目吗？">删除</a><?php }?><?php if($one['now_number']>=$one['min_number']){?>｜<a href="/biz/down.php?id=<?php echo $one['id']; ?>" target="_blank">下载</a><?php }?></td>
					</tr>
					<?php }}?>
					<tr><td colspan="7"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php include template("footer");?>
