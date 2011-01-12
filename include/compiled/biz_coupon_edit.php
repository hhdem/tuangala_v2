<?php include template("biz_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content">
                <div class="head">
					<h2>编辑团购项目</h2>
					<span class="headtip">(<?php echo $team['title']; ?>)</span>
				</div>
                <div class="sect">
				
				<form id="-user-form" method="post" action="/biz/coupon_edit.php?id=<?php echo $team['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $team['id']; ?>" />
					<div class="wholetip clear"><h3>1、基本信息</h3></div>
					<div class="field">
						<label>项目类型</label>
						<select name="team_type" class="f-input" style="width:160px;" onchange="X.team.changetype(this.options[this.options.selectedIndex].value);"><?php echo Utility::Option($option_teamtype, $team['team_type']); ?></select><select name="city_id" class="f-input" style="width:160px;"><?php echo Utility::Option(Utility::OptionArray($allcities, 'id','name'), $team['city_id'], '全部城市'); ?></select>
						<select name="group_id" class="f-input" style="width:160px;"><?php echo Utility::OptionGroup($groups, $cgroups, $team['group_id']); ?></select>
					</div>
					<div class="field" id="field_limit">
						<label>限制条件</label>
						<select name="conduser" class="f-input" style="width:160px;"><?php echo Utility::Option($option_cond, $team['conduser']); ?></select>
						<select name="buyonce" class="f-input" style="width:160px;"><?php echo Utility::Option($option_buyonce, $team['buyonce']); ?></select>
					</div>
					<div class="field">
						<label>项目标题</label>
						<input type="text" size="30" name="title" id="team-create-title" class="f-input" value="<?php echo htmlspecialchars($team['title']); ?>" datatype="require" require="true" />
					</div>
					<div class="field">
						<label>市场价</label>
						<input type="text" size="10" name="market_price" id="team-create-market-price" class="number" value="<?php echo moneyit($team['market_price']); ?>" datatype="money" require="true" />
						<label>网站价</label>
						<input type="text" size="10" name="team_price" id="team-create-team-price" class="number" value="<?php echo moneyit($team['team_price']); ?>" datatype="double" require="true" />
					</div>
					<div class="field">
						<label>最低数量</label>
						<input type="text" size="10" name="min_number" id="team-create-min-number" class="number" value="<?php echo intval($team['min_number']); ?>" maxLength="6" datatype="number" require="true" />
						<label>最高数量</label>
						<input type="text" size="10" name="max_number" id="team-create-max-number" class="number" value="<?php echo intval($team['max_number']); ?>" maxLength="6" datatype="number" require="true" />
						<label>每人限购</label>
						<input type="text" size="10" name="per_number" id="team-create-per-number" class="number" value="<?php echo intval($team['per_number']); ?>" maxLength="6" datatype="number" require="true" />
						<span class="hint">最低数量必须大于0，最高数量/每人限购：0 表示没最高上限 （产品数|人数 由成团条件决定）</span>
					</div>
					<div class="field">
						<label>开始时间</label>
						<input type="text" size="10" name="begin_time" id="team-create-begin-time1" class="date" xd="<?php echo date('Y-m-d', $team['begin_time']); ?>" xt="<?php echo date('H:i:s', $team['begin_time']); ?>" value="<?php echo date('Y-m-d H:i:s', $team['begin_time']); ?>" maxLength="20" require="true" onFocus="WdatePicker({startDate:'<?php echo date('Y-m-d H:i:s', $team['begin_time']); ?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/>
						<label>结束时间</label>
						<input type="text" size="10" name="end_time" id="team-create-end-time1" class="date" xd="<?php echo date('Y-m-d', $team['end_time']); ?>" xt="<?php echo date('H:i:s', $team['end_time']); ?>" value="<?php echo date('Y-m-d H:i:s', $team['end_time']); ?>" maxLength="20" require="true" onFocus="WdatePicker({startDate:'<?php echo date('Y-m-d H:i:s', $team['end_time']); ?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})" realvalue="<?php echo date('Y-m-d H:i:s', $team['end_time']); ?>"/>
						<label><?php echo $INI['system']['couponname']; ?>有效期</label>
						<input type="text" size="10" name="expire_time" id="team-create-expire-time1" class="number" value="<?php echo date('Y-m-d', $team['expire_time']); ?>" maxLength="20" require="true" onFocus="WdatePicker({startDate:'<?php echo date('Y-m-d', $team['expire_time']); ?>',dateFmt:'yyyy-MM-dd'})"/>
						<span class="hint">时间格式：hh:ii:ss (例：14:05:58)，日期格式：YYYY-MM-DD （例：2010-06-10）</span>
					</div>
					<div class="field">
						<label>本单简介</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="summary" id="team-create-summary" class="f-textarea" datatype="require" require="true"><?php echo htmlspecialchars($team['summary']); ?></textarea></div>
					</div>
					<div class="field">
						<label>本单详情</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="detail" id="team-create-detail" class="f-textarea editor" style="height:300px;"><?php echo htmlspecialchars($team['detail']); ?></textarea></div>
					</div>
					<div class="field">
						<label>特别提示</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="notice" id="team-create-notice" class="f-textarea editor" style="height:150px;"><?php echo $team['notice']; ?></textarea></div>
						<span class="hint">关于本单项目的有效期及使用说明</span>
					</div>
					
					<input type="hidden" name="guarantee" value="Y" />
					<input type="hidden" name="system" value="Y" />
					<div class="wholetip clear"><h3>2、项目信息</h3></div>
					<div class="field">
						<label>商户</label>
						<span style="line-height: 30px;color:red"><?php echo $login_partner['username']; ?></span>
					</div>
					<div class="field">
						<label>商品名称</label>
						<input type="text" size="30" name="product" id="team-create-product" class="f-input" value="<?php echo $team['product']; ?>" min="5" max="18" maxLength="18" datatype="require" require="true" />
						<span class="hint">填写5-18个字符，一个汉字为两个字符</span>
					</div>
					<div class="field">
						<label>购买必选项</label>
						<input type="text" size="30" name="condbuy" id="team-create-condbuy" class="f-input" value="<?php echo $team['condbuy']; ?>" />
						<span class="hint">格式如：{黄色}{绿色}{红色}，用户购买时必选其中一项</span>
					</div>
					<div class="field">
						<label>商品图片</label>
						<input type="file" size="30" name="upload_image" id="team-create-image" class="f-input"/>
						<?php if($team['image']){?><span class="hint"><?php echo team_image($team['image']); ?></span><?php }?>
					</div>
					<div class="field">
						<label>商品图片1</label>
						<input type="file" size="30" name="upload_image1" id="team-create-image1" class="f-input"/>
						<?php if($team['image1']){?><span class="hint" id="team_image_1"><?php echo team_image($team['image1']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 1);">删除</a></span><?php }?>
					</div>
					<div class="field">
						<label>商品图片2</label>
						<input type="file" size="30" name="upload_image2" id="team-create-image2" class="f-input" />
						<?php if($team['image2']){?><span class="hint" id="team_image_2"><?php echo team_image($team['image2']); ?>&nbsp;&nbsp;<a href="javascript:;" onclick="X.team.imageremove(<?php echo $team['id']; ?>, 2);">删除</a></span><?php }?>
					</div>
					<div class="field">
						<label>FLV视频短片</label>
						<input type="text" size="30" name="flv" id="team-create-flv" class="f-input" value="<?php echo $team['flv']; ?>" />
						<span class="hint">形式如：http://.../video.flv</span>
					</div>
					
					<div class="field" id="field_userreview">
						<label>网友点评</label>
						<div style="float:left;"><textarea cols="45" rows="5" name="userreview" id="team-create-userreview" class="f-textarea"><?php echo htmlspecialchars($team['userreview']); ?></textarea></div>
						<span class="hint">格式：“真好用|小兔|http://ww....|XXX网”，每行写一个点评</span>
					</div>
					<div class="wholetip clear"><h3>3、配送信息</h3></div>
					<div class="field">
						<label>递送方式</label>
						<div style="margin-top:5px;" id="express-zone-div"><input type="radio" name="delivery" value="coupon" <?php echo $team['delivery']=='coupon'?'checked':''; ?> />&nbsp;<?php echo $INI['system']['couponname']; ?>&nbsp;<input type="radio" name="delivery" value='express' <?php echo $team['delivery']=='express'?'checked':''; ?> />&nbsp;快递&nbsp;<input type="radio" name="delivery" value="pickup" <?php echo $team['delivery']=='pickup'?'checked':''; ?>/>&nbsp;自取</div>
					</div>
					<div id="express-zone-coupon" style="display:<?php echo $team['delivery']=='coupon'?'block':'none'; ?>;">
						<div class="field">
							<label></label>
							<span class="inputtip">如果使用<?php echo $INI['system']['couponname']; ?>方式递送，则买家购买后通过打印或短信两种方式获得的旮旯卷到商户消费</span>
						</div>
					</div>
					<div id="express-zone-pickup" style="display:<?php echo $team['delivery']=='pickup'?'block':'none'; ?>;">
						<div class="field">
							<label>联系电话</label>
							<input type="text" size="10" name="mobile" id="team-create-mobile" class="f-input" value="<?php echo $team['mobile']; ?>" />
						</div>
						<div class="field">
							<label>自取地址</label>
							<input type="text" size="10" name="address" id="team-create-address" class="f-input" value="<?php echo $team['address']; ?>" />
						</div>
					</div>
					<div id="express-zone-express" style="display:<?php echo $team['delivery']=='express'?'block':'none'; ?>;">
						<div class="field">
							<label>快递费用</label>
							<input type="text" size="10" name="fare" id="team-create-fare" class="number" value="<?php echo intval($team['fare']); ?>" maxLength="6" datatype="money"  require="true"/>
							<label>免单数量</label>
							<input type="text" size="10" name="farefree" id="team-create-farefree" class="number" value="<?php echo intval($team['farefree']); ?>" maxLength="6" datatype="money"  require="true"/>
							<span class="hint">快递费用，免单数量：0表示不免运费，2表示，购买2件免运费</span>
						</div>
						<div class="field">
							<label>配送说明</label>
							<div style="float:left;"><textarea cols="45" rows="5" name="express" id="team-create-express" max="20" maxLength="30"  class="f-textarea"><?php echo $team['express']; ?></textarea></div>
							<span class="hint">请保持在30字以内</span>
						</div>
					</div>
					<input type="submit" value="好了，提交" name="commit" id="leader-submit" class="formbutton" style="margin:10px 0 0 120px;"/>
				</form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>
<div id="sidebar">
</div>

</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<script type="text/javascript">
window.x_init_hook_teamchangetype = function(){
	X.team.changetype("<?php echo $team['team_type']; ?>");
};
window.x_init_hook_page = function() {
	X.team.imageremovecall = function(v) {
		jQuery('#team_image_'+v).remove();
	};
	X.team.imageremove = function(id, v) {
		return !X.get(WEB_ROOT + '/ajax/misc.php?action=imageremove&id='+id+'&v='+v);
	};
};
</script>
<?php include template("footer");?>
