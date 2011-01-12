<?php include template("header");?>

<div id="bdw" class="bdw">
	<div id="bd" class="cf">

	<?php include template("team_view_slider");?>

		<?php if($order){?>
		<div id="ads_content_box" class="coupons-box clear mainwide">
			<div class="box clear">
				<div class="ads_top"></div>
				<div id="ads_content">
					您已经下过订单，但还没有付款。<a href="/order/check.php?id=<?php echo $order['id']; ?>">查看订单并付款</a>
				</div>
				<div class="ads_bottom"></div>
			</div>
		</div>
		<?php }?>

		<div id="deal-default" class="l" style="width:720px;display:block;">
			<div id="deal-intro" class="cf">
				<div class="conleft_title">
					<img src="/static/css/i/ajax-loader.gif" />
				</div>
			</div>
		</div>
		<div id="sidebar">
			<?php include template("block_side_schedule_intro");?>
			<?php include template("block_side_invite");?>
			<?php include template("block_side_others_seconds");?>
			<?php include template("block_side_others");?>
			<?php include template("block_side_vote");?>
			<?php include template("block_side_business");?>
			<?php include template("block_side_ads");?>
			<?php include template("block_site_changelog");?>
			<?php include template("block_side_blog");?>
			<?php include template("block_side_subscribe");?>
		</div>
	</div> <!-- bd end -->
</div> <!-- bdw end -->

<?php if(!$login_user){?>

  <script type="text/javascript">
	XN_RequireFeatures(["EXNML"], function()
	{
	  XN.Main.init("58f2b48818d446be97a1827dd10d89f2", "/xd_receiver.html", {"forceLoginPopup": false,"ifUserConnected":"/xiaonei/connect_ok.php"});
	});
</script>
<?php }?>
  <script type="text/javascript">

$(document).ready(function(){	
		$("#deal-default").css("width", "720px");
        $("#deal-default").html("<div id=\"deal-intro\" class=\"cf\"><div class=\"conleft_title\"><img src=\""+WEB_ROOT+"/static/theme/noietheme/css/i/ajax-loader.gif\" /></div></div>");
        $("#deal-default").load(WEB_ROOT+"/ajax/team_list.php?gid="+<?php echo $group_id; ?> + "&page=" + <?php echo $page; ?>,
            function(a,b,c){
                
                $(this).show();

            });
	});

	
</script>
<?php include template("footer");?>
