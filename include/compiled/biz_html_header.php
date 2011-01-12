<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="<?php echo $INI['sn']['sn']; ?>">
<head>
	<meta http-equiv=content-type content="text/html; charset=UTF-8">
	<title><?php echo $INI['system']['sitename']; ?> - 商户后台</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
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
	<script src="/static/js/index.js" type="text/javascript"></script>
	<script type="text/javascript" src="/static/js/datepicker/WdatePicker.js"></script>
	<link href="/static/js/datepicker/skin/WdatePicker.css" rel="stylesheet" type="text/css">
	<?php echo Session::Get('script',true);; ?>
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
		$(document).ready(function(){ 
			setTimeout(function(){
				$("#browser_tip").hide();
			},2000);

		});
	//-->
	</SCRIPT>
<div id="browser_tip" style="background-color:#ececec;width:100%;float:center;text-align:center;">如果您使用非IE内核的浏览器浏览本站，会有不同的发现哦!<span id="browser-tip-close" style="padding-left:40px;"><a href="javascript:void(0);" onclick="close_b_t();">关闭</a></span></div>

<?php }?>

<div id="pagemasker"></div><div id="dialog"></div>
<div id="doc">
