<?php if($INI['system']['googlemap']&&$partner['longlat']){?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $INI['system']['googlemap']; ?>" type="text/javascript"></script>
<script type="text/javascript">
window.x_init_hook_gmp = function() {
	X.misc.showgooglemap = function() {
		X.get(WEB_ROOT+'/ajax/system.php?id=<?php echo $partner['id']; ?>&action=showgooglemap');
	};
};
</script>
<div class="mapbody map"><img id="pgm_id" src="http://ditu.google.cn/maps/api/staticmap?zoom=12&size=300x300&maptype=roadmap&mobile=true&markers=<?php echo $partner['longlat']; ?>&sensor=false&language=zh_CN" style="margin:2px;border: 2px solid black;"/><br><span style="text-align:center;background:#ececec;width:300px;margin:2px;"><a class="link" href="javascript:;" onclick="X.misc.showgooglemap();" title="点击查看完整地图">查看完整地图</a></span></div>

<?php }?>
