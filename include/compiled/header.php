<?php include template("html_header");?>

<div id="hdw">
	<div id="hd">
		<div id="logo"><a href="/index.php" class="link"><?php if($browser == 'IE' ){?><img src="/static/css/ie/logo.gif" alt="<?php echo $INI['system']['sitename']; ?>" /><?php } else { ?><img src="/static/css/i/logo.png" alt="<?php echo $INI['system']['sitename']; ?>" /><?php }?></a></div>
		<div class="guides">
			<div class="city">
				<h2><?php echo $city['name']; ?></h2>
			</div>
			<?php if(count($hotcities)>1){?>
			<script type="text/javascript" src="/static/js/jquery.colorbox-min.js"></script>
			<link rel="stylesheet" type="text/css" href="/static/css/colorbox.css" media="screen" />
			<script type="text/javascript">
				$(document).ready(function() {
					$("#city-change").colorbox({width:"50%", opacity: 0.3, inline:true, href:"#city-list"});
				});
			</script>
			<a id="city-change" href="#" class="change" title="切换城市">切换城市</a>
			<div style="display: none;">
				<div id="city-list" style="margin-top:5px;padding:10px 10px;">
					<ul style="float:left;padding-bottom:5px;"><?php echo current_city($city['ename'], $hotcities); ?></ul>
					<div style="clear:both;border-top:1px dashed #666;padding-top:5px;padding-bottom:10px;padding-right:5px;font-size:12px;zoom:1;"><a href="/city.php" style="float:right;">其他城市？</a></div>
				</div>
			</div>
			<?php }?>
		</div>
		<div id="header-subscribe-body" class="subscribe">
		<form action="/subscribe.php" method="post" id="header-subscribe-form">
			<label for="header-subscribe-email" class="text">想知道<?php echo $city['name']; ?>明天的团购是什么吗？</label>
			<input type="hidden" name="city_id" value="<?php echo $city['id']; ?>" />
			<input id="header-subscribe-email" type="text" xtip="输入Email，订阅每日团购信息..." value="" class="f-text" name="email" />
			<input type="hidden" value="1" name="cityid" />
			<input type="submit" class="commit" value="订阅" />
		</form>
		<?php if(option_yes('smssubscribe')){?>
		<span><a class="sms" onclick="X.miscajax('sms','subscribe');">&raquo; 短信订阅，免费！</a>&nbsp; <a class="sms" onclick="X.miscajax('sms','unsubscribe');">&raquo; 取消手机订阅</a></span>
		<?php }?>
		</div>
		<ul class="nav cf"><?php echo current_frontend(); ?></ul>
	<?php if(option_yes('trsimple')){?>
		<div class="vcoupon">&raquo;&nbsp;<a href="/account/invite.php">邀请好友</a>&nbsp;&nbsp;&raquo;&nbsp;<a id="verify-coupon-id" href="javascript:;"><?php echo $INI['system']['couponname']; ?>验证及消费登记</a>&nbsp;&nbsp;&raquo;&nbsp;<a href="javascript:;" onclick="return X.misc.locale();">简繁转换</a></div>
	<?php } else { ?>
		<div class="vcoupon"><p style="color: blue;float:left;"><?php if(!$login_user){?><img id="xn_login_image" style="cursor:pointer;" src="/static/css/ie/renren.png" alt="用人人账户登陆" title="用人人账户登陆"><?php } else { ?><img style="cursor:pointer;" src="/static/css/ie/xiaoneilogo.png" alt="人人账户" title="人人账户"><?php }?></p><p>&nbsp;&raquo;&nbsp;<a href="/account/invite.php">邀请好友购买返利&nbsp;<?php echo abs($INI['system']['invitecredit']); ?>&nbsp;元</a>&nbsp;&nbsp;&nbsp;&raquo;&nbsp;<a id="verify-coupon-id" href="javascript:;"><?php echo $INI['system']['couponname']; ?>验证及消费登记</a></p></div>
		
	<?php }?>
		<div class="logins">
		<?php if($login_user){?>
			<ul class="links">
				<li class="username">欢迎您，</li>
				<li class="account"><a href="/order/index.php" id="myaccount" class="account" alt="<?php echo $login_user['username']; ?>" title="<?php echo $login_user['username']; ?>"><?php if($login_user['realname']){?><?php echo mb_strimwidth($login_user['realname'],0,10); ?><?php } else { ?><?php echo mb_strimwidth($login_user['username'],0,10); ?><?php }?></a></li>
				<li class="logout"><a href="#" onclick="XN.Connect.logout(function(){window.location.href='/account/logout.php';});return true;">退出</a></li>
			</ul>
			 <script type="text/javascript">
				 jQuery(function(){
					XN_RequireFeatures(["EXNML"], function()
					{
					  XN.Main.init("58f2b48818d446be97a1827dd10d89f2", "/xd_receiver.html");
					  
					});
				});
			</script>
		<?php } else if(is_partner()) { ?>
			<ul class="links">
				<li class="username">欢迎您，</li>
				<li class="account"><a href="/biz/index.php" id="myaccount" class="account" alt="<?php echo $login_partner['username']; ?>" title="<?php echo $login_partner['username']; ?>"><?php echo $login_partner['username']; ?></a></li>
				<li class="logout"><a href="/biz/logout.php">退出</a></li>
			</ul>
		<?php } else { ?>
			
			<ul class="links">
				<li class="register"><a href="/account/signup.php">买家注册</a></li>
				<li class="register"><a href="/partner/create.php"><b style="color:red;">商户注册</b></a></li>
				<li class="login"><a href="#" id="myaccount" class="account">登录</a></li>
				
			</ul>
			<script type="text/javascript" >
				addEventListener = function(element, type, handler) {
				  if (element.addEventListener) {
						element.addEventListener(type, handler, false);
				  } else if (element.attachEvent){
					handler._ieEventHandler = function () {
					  handler(window.event);
					};
					(element).attachEvent("on" + type, (handler._ieEventHandler));
				  }
				};
				jQuery(function(){
					XN_RequireFeatures(["EXNML"], function()
					{
					  XN.Main.init("58f2b48818d446be97a1827dd10d89f2", "/xd_receiver.html", {"forceLoginPopup": false,"ifUserConnected":"/xiaonei/connect_ok.php","doNotUseCachedConnectState":true});
					  addEventListener(document.getElementById("xn_login_image"), "click", function() {	XN.Connect.requireSession();  });
					});
				});
			</script>
		<?php }?>
			<div class="line islogin"></div>
		</div>
	<?php if($login_user){?>
		<ul id="myaccount-menu"><?php echo current_m_account(null); ?></ul>
	<?php } else if(is_partner()) { ?>
		<ul id="myaccount-menu">
			<li><a href="/biz/index.php">商户后台</a></li>
			<li><a href="/biz/coupon_create.php">新建团购</a></li>
			<li><a href="/biz/settings.php">商户资料</a></li>
			<li><a href="/biz/coupon.php">优惠卷列表</a></li>
		</ul>
	<?php } else { ?>
		<ul id="myaccount-menu">
			<li><a href="/account/login.php">买家登陆</a></li>
			<li><a href="/biz/login.php">商户登陆</a></li>
		</ul>
	<?php }?>
	</div>
</div>

<?php if($session_notice=Session::Get('notice',true)){?>
<div class="sysmsgw" id="sysmsg-success"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
<?php if($session_notice=Session::Get('error',true)){?>
<div class="sysmsgw" id="sysmsg-error"><div class="sysmsg"><p><?php echo $session_notice; ?></p><span class="close">关闭</span></div></div> 
<?php }?>
