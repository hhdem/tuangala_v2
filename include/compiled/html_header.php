<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv=content-type content="text/html; charset=UTF-8" />
<?php if(!$pagetitle||$request_uri=='index'){?>
	<title><?php echo $INI['system']['sitename']; ?> - <?php echo $INI['system']['sitetitle']; ?>|<?php echo $city['name']; ?>购物|<?php echo $city['name']; ?>团购|<?php echo $city['name']; ?>打折</title>
<?php } else { ?>
	<title><?php echo $pagetitle; ?> | <?php echo $INI['system']['sitename']; ?> - <?php echo $INI['system']['sitetitle']; ?> |<?php echo $city['name']; ?>购物|<?php echo $city['name']; ?>团购|<?php echo $city['name']; ?>打折<?php echo $INI['system']['subtitle']; ?></title>
<?php }?>

<?php if($seo_description){?>
	<meta name="description" content="<?php echo $seo_description; ?>" />
<?php } else if($team) { ?>
	<meta name="description" content="<?php echo mb_strimwidth(strip_tags($team['title'] .', '. $team['summary'] .', '. $team['systemreview']), 0, 320); ?>" />
<?php } else { ?>
	<meta name="description" content="<?php echo $INI['system']['sitetitle']; ?>|<?php echo $city['name']; ?>购物|<?php echo $city['name']; ?>团购|<?php echo $city['name']; ?>打折" />
<?php }?>
<?php if($seo_keyword){?>
	<meta name="keywords" content="<?php echo $seo_keyword; ?>，<?php echo $city['name']; ?>购物，<?php echo $city['name']; ?>团购，<?php echo $city['name']; ?>打折，团购，打折，精品消费，购物指南，消费指南" />
<?php } else { ?>
	<meta name="keywords" content="<?php echo $INI['system']['sitename']; ?>, <?php echo $city['name']; ?>, <?php echo $city['name']; ?><?php echo $INI['system']['sitename']; ?>，<?php echo $city['name']; ?>购物，<?php echo $city['name']; ?>团购，<?php echo $city['name']; ?>打折，团购，打折，精品消费，购物指南，消费指南" />
<?php }?>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<link href="<?php echo $INI['system']['wwwprefix']; ?>/feed.php?ename=<?php echo $city['ename']; ?>" rel="alternate" title="订阅更新" type="application/rss+xml" />
	<link rel="shortcut icon" href="/static/icon/favicon.ico" />
	<?php 
		$today=getdate();
		$css_hour=(int)$today['hours'];
		$agent = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
			$browser = 'IE';
		}
	; ?>
	<?php if($browser == 'IE'){?>
	<link rel="stylesheet" href="/static/css/index_ie.css" type="text/css" media="screen" charset="utf-8" />
	<?php } else { ?>
	<link rel="stylesheet" href="/static/css/index.css" type="text/css" media="screen" charset="utf-8" />
	<?php }?>

	<script type="text/javascript">var WEB_ROOT = '<?php echo WEB_ROOT; ?>';</script>
	<script type="text/javascript">var LOGINUID= <?php echo abs(intval($login_user_id)); ?>;</script>
	<script src="/static/js/index.js" type="text/javascript"></script>
	<script src="/static/js/tuangala.js" type="text/javascript"></script>
	<script type="text/javascript" src="http://static.connect.renren.com/js/v1.0/FeatureLoader.jsp"></script>

	<script src="/static/js/jquery.lazyload.mini.js" type="text/javascript"></script>
	<script src="/static/js/supersleight.plugin.js" type="text/javascript"></script>
	
	<?php echo Session::Get('script',true);; ?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		(function () {
		if (top != self) {
		var a = self.location.href,
		b = top.location;
		try {
		if (b.href == a || b.href == undefined) {
		setInterval(function () {
		b.replace(a);
		}, 1);
		}
		} catch (e) {
		setInterval(function () {
		b.replace(a);
		}, 1);
		}
		}
		})(window);
		
	//-->
	</SCRIPT>
</head>
<body class="<?php echo $request_uri=='index'?'bg-alt':'newbie'; ?>">
<?php if($browser != 'IE'){?>
<div class="background">
	<?php if($css_hour >=7 && $css_hour <= 20){?>
	<img src="/static/css/i/body_bg.jpg">
	<?php } else { ?>
	<img src="/static/css/i/body_bg_n.jpg">
	<?php }?>
</div>
<?php } else { ?>
<SCRIPT LANGUAGE="JavaScript">
	<!--
		function close_b_t() {
			$("#browser_tip").hide();
		}
		$("img").lazyload({ 
			placeholder : "img/grey.gif",
			effect : "fadeIn" 
		});
		$(document).ready(function(){ 
			setTimeout(function(){
				$("#browser_tip").hide();
			},2000);
		});
		
	//-->
	</SCRIPT>
<div id="browser_tip" style="position: absolute;background-color:#ececec;width:100%;float:center;text-align:center;z-index:9999;">建议使用IE6以上版本或非IE内核的浏览器浏览本站，会有不同的发现哦!<span id="browser-tip-close" style="padding-left:40px;"><a href="javascript:void(0);" onclick="close_b_t();">关闭</a></span></div>

<?php }?>
<div id="pagemasker"></div><div id="dialog"></div>
<div id="doc">
