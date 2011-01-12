<div class="sbox side-invite-tip">
	<div class="sbox-top"></div>
	<div class="sbox-content">
		<div class="tip">
			<h2>邀请有奖</h2>
			<p class="text">每邀请一位好友首次购买，您将获<strong><span class="money"><?php echo $currency; ?></span><?php echo abs(intval($INI['system']['invitecredit'])); ?></strong>元返利</p>
			<p class="link"><a href="/account/invite.php">&raquo;&nbsp;点击获取您的专用邀请链接</a></p>
			<iframe id="sinat_frame" width="0" height="0" class="share_self"  frameborder="0" scrolling="no" src="/static/css/i/ajax-loader.gif"></iframe>
		</div>
	</div>
	<div class="sbox-bottom"></div>
</div>
<script type="text/javascript">
	$(document).ready(function(){	
		
		$("#sinat_frame").attr("src", "http://service.t.sina.com.cn/widget/WeiboShow.php?width=0&height=250&fansRow=2&ptype=0&speed=0&skin=1&isTitle=1&noborder=0&isWeibo=0&isFans=1&uid=1877108607&verifier=a48af3d4");
		$("#sinat_frame").css("width","190px");
		$("#sinat_frame").css("height","250px");
	});	
</script>
