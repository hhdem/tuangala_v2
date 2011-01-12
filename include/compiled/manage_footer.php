<div id="ftw">
	<div id="ft">
		<p class="contact"><a href="/feedback/suggest.php">意见反馈</a></p>
		<ul class="cf">
			<li class="col">
				<h3>用户帮助</h3>
				<ul class="sub-list">
					<li><a href="/help/tour.php">玩转<?php echo $INI['system']['abbreviation']; ?></a></li>
					<li><a href="/help/faqs.php">常见问题</a></li>
					<li><a href="/help/zuitu.php"><?php echo $INI['system']['abbreviation']; ?>概念</a></li>
					<li><a href="/help/api.php">开发API</a></li>
				</ul>
			</li>
			<li class="col">
				<h3>获取更新</h3>
				<ul class="sub-list">
					<li><a href="/subscribe.php?ename=<?php echo $city['ename']; ?>">邮件订阅</a></li>
					<li><a href="/feed.php?ename=<?php echo $city['ename']; ?>">RSS订阅</a></li>
					<li><a href="http://t.sina.com.cn/tuangala" target="_blank">新浪微博</a></li>
					<li><a href="http://t.qq.com/tuangala" target="_blank">腾讯微博</a></li>
				</ul>
			</li>
			<li class="col">
				<h3>合作与联系</h3>
				<ul class="sub-list">
					<li><a href="/feedback/seller.php">商务合作</a></li>
					<li><a href="/feedback/suggest.php">意见反馈</a></li>
					<li><a href="/about/contact.php">联系方式</a></li>
					<?php if(is_manager()){?>
					<li><a href="/manage/index.php">管理<?php echo $INI['system']['abbreviation']; ?></a></li>
					<?php }?>
				</ul>
			</li>
			<li class="col">
				<h3>公司信息</h3>
				<ul class="sub-list">
					<li><a href="/about/us.php">关于<?php echo $INI['system']['abbreviation']; ?></a></li>
					<li><a href="/about/job.php">工作机会</a></li>
					<li><a href="/about/terms.php">用户协议</a></li>
					<li><a href="/about/privacy.php">隐私声明</a></li>
				</ul>
			</li>
			<li class="col end">
					<div class="logo-footer">
						<a href="/"><img src="/static/css/i/logo-footer.gif" /></a>
					</div>
			</li>
		</ul>
		<div class="copyright">
		<p>&copy;<span>2010</span>&nbsp;<?php echo $INI['system']['sitename']; ?>（TuanGala.com）版权所有&nbsp;&nbsp;<a href="/about/terms.php">使用<?php echo $INI['system']['abbreviation']; ?>前必读</a>&nbsp;<a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $INI['system']['icp']; ?></a>&nbsp;Powered by <a href="http://www.hhdem.com/" target="_blank">HHdem</a>.</p>
		</div>
	</div>
</div>
<?php include template("manage_html_footer");?>
