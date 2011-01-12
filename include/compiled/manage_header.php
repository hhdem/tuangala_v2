<?php include template("manage_html_header");?>
<script type="text/javascript" src="/static/js/xheditor/xheditor.js"></script> 
<div id="hdw">
	<div id="hd">
		<div id="logo"><a href="/index.php" class="link" target="_blank"><img src="/static/css/i/logo.gif" /></a></div>
		<div class="guides">
			<div class="city">
				<h2>管理后台</h2>
			</div>
			<div id="guides-city-change" class="change"><?php echo $login_user['realname']; ?></div>
		</div>
		<ul class="nav cf"><?php echo current_backend('super'); ?></ul>
		<?php if(is_manager()){?><div class="vcoupon">&raquo;&nbsp;<a href="/manage/logout.php">管理员退出</a></div><?php }?>
	</div>
</div>

<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
