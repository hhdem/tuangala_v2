<?php include template("block_main_friendlink");?>
<div id="ftw">
	<div id="ft">
		<p class="contact"><a href="/city.php">城市列表</a>&nbsp;<a href="/feedback/suggest.php">意见反馈</a></p>
		<ul class="cf">
			<li class="col">
				<h3>用户帮助</h3>
				<ul class="sub-list">
					<li><a href="/help/tour.php">玩转<?php echo $INI['system']['abbreviation']; ?></a></li>
					<li><a href="/help/faqs.php">常见问题</a></li>
					<li><a href="/help/tuangala.php"><?php echo $INI['system']['abbreviation']; ?>概念</a></li>
					<li><a href="/help/api.php">开发API</a></li>
					<li><a href="/help/bizhowtouse.php">商家使用说明</a></li>
				</ul>
			</li>
			<li class="col">
				<h3>获取更新</h3>
				<ul class="sub-list">
					<li><a href="/subscribe.php?ename=<?php echo $city['ename']; ?>">邮件订阅</a></li>
					<li><a href="/feed.php?ename=<?php echo $city['ename']; ?>">RSS订阅</a></li>
				<?php if($INI['system']['sinajiwai']){?>
					<li><a href="<?php echo $INI['system']['sinajiwai']; ?>" target="_blank">新浪微博</a></li>
				<?php }?>
				<?php if($INI['system']['tencentjiwai']){?>
					<li><a href="<?php echo $INI['system']['tencentjiwai']; ?>" target="_blank">腾讯微博</a></li>
				<?php }?>
				</ul>
			</li>
			<li class="col">
				<h3>合作联系</h3>
				<ul class="sub-list">
					<li><a href="/about/fentuan.php">我要分团</a></li>
					<li><a href="/feedback/seller.php">商务合作</a></li>
					<li><a href="/help/link.php">友情链接</a></li>
					<li><a href="/biz/index.php">商家后台</a></li>
					<?php if(is_manager(false, true)){?>
					<li><a href="/manage/index.php">管理<?php echo $INI['system']['abbreviation']; ?></a></li>
					<?php }?>
				</ul>
			</li>
			<li class="col">
				<h3>公司信息</h3>
				<ul class="sub-list">
					<li><a href="/about/us.php">关于<?php echo $INI['system']['abbreviation']; ?></a></li>
					<li><a href="/about/job.php">工作机会</a></li>
					<li><a href="/about/contact.php">联系方式</a></li>
					<li><a href="/about/terms.php">买家协议</a></li>
					<li><a href="/about/bizs.php">商户协议</a></li>
				</ul>
			</li>
			<li class="col end">
					<div class="logo-footer">
						<a href="/"><?php if($browser == 'IE' ){?><img src="/static/css/ie/logo-footer.gif" height="52px" width="246px"/><?php } else { ?><img src="/static/css/i/logo-footer.png" alt="<?php echo $INI['system']['sitename']; ?>" /><?php }?></a>
					</div>
					<div class="tot_board">
						<div style="width:40px; float:left;border-right-width: 1px;border-right-style: dashed;border-right-color: #373536;padding: 0px 10px 0px 0px;">
							<p><b>目前</b><br><br></p>
						</div>
						<div>
							<p class="total" style="float:right;"><?php echo $currency; ?><?php echo moneyit($totalSavedMoney['tsm']); ?></p><p>共节省金额: </p>
							<p class="total" style="float:right;"><?php echo $allteamcount; ?></p><p>共组织团购次数: </p>
						</div>
					</div>
			</li>
		</ul>
		<div class="copyright">
		<p>&copy;<span>2010</span>&nbsp;<?php echo $INI['system']['sitename']; ?>（TuanGaLa.com）版权所有&nbsp;<a href="/about/terms.php">使用<?php echo $INI['system']['abbreviation']; ?>前必读</a>&nbsp;<a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $INI['system']['icp']; ?></a>&nbsp;Powered by <a href="http://www.hhdem.com/" target="_blank">HHdem</a>.</p>
		<p><img src="http://img.tongji.linezing.com/2129146/tongji.gif"></p>
		<p>为了社会的进步, 建议采用Chrome, Firefox等非IE内核浏览器浏览本站!</p>
		</div>
		<div style="float:center;">
			<a href="http://t.bj100.com/" target="_blank" title="找团购">找团购</a>
			<a href="http://www.linkgou.com" target="_blank" title="领客购团购返利网">领客购团购返利网</a>
			<a href="http://www.bxtuan.com" target="_blank" title="必须团">必须团</a>
			<a href="http://www.tuanpark.com" target="_blank" title="团购乐园">团购乐园</a>
			<a href="http://www.tuanzj.com" target="_blank" title="团购网站导航">团购网站导航</a>
			<a href="http://www.wgou.com" target="_blank" title="团购网站导航">网购在线团购导航</a>
			<a href="http://www.laotz.com" target="_blank" title="老团长">老团长</a>
			<a href="http://www.tuan345.com" target="_blank" title="团网址-放心团购">团网址-放心团购</a>
			<a href="http://www.eguo.com/" target="_blank" title="E国团购导航">E国团购导航</a>
			<a href="http://www.daocool.com" target="_blank" title="导酷网-团购网站导航~团购之家|团购网址大全">导酷网</a>
			<a href="http://www.huizibo.com" target="_blank" title="淄博团购导航">淄博团购导航</a>
		</div>
		</div>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-16688536-2']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</div>
</div>
<?php include template("html_footer");?>
