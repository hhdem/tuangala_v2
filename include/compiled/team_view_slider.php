<script type="text/javascript" src="/static/js/easySlider1.7.js"></script>

<link href="/static/css/screen.css" rel="stylesheet" type="text/css" media="screen" />	
<script type="text/javascript">
	$(document).ready(function(){	
		$("#slider").easySlider({
			auto: true, 
			continuous: true,
			controlsShow: true,
			nextText: 		'',
			prevText: 		'',
			pause:			8000,
			speed: 		2000
		});
		function cur(ele,currentClass,tag){
		ele= $(ele)? $(ele):ele;
		if(!tag){
			ele.addClass(currentClass).siblings().removeClass(currentClass);
			}else{
				ele.addClass(currentClass).siblings(tag).removeClass(currentClass);
				}
		}
	$.fn.tab=function(options){
	var org={
		tabId:    "",
		tabTag:   "",
		conId:    "",
		conTag:   "",
		curClass: "cur",
		act:      "click",
		dft:      0,
		effact:   null,
		auto:     true,
		autotime: 10000,
		aniSpeed: 500
		}	
		
	$.extend(org,options);
	
	var t=false;
	var k=0;
	var _this=$(this);
	var tagwrp=$(org.tabId);
	var conwrp=$(org.conId);
	var tag=tagwrp.find(org.tabTag);
	var con=conwrp.find(org.conTag);	
	var len=tag.length;
	var taght=parseInt(tagwrp.css("height"));
	var conwh=conwrp.get(0).offsetWidth;
	var conht=conwrp.get(0).offsetHeight;
	var curtag=tag.eq(org.dft);
	//prepare
	//cur(curtag,org.curClass);
	con.eq(org.dft).show().siblings(org.conTag).hide();
	
	if(org.effact=="scrollx"){
		var padding=parseInt(con.css("padding-left"))+parseInt(con.css("padding-right"));										
		_this.css({
				  "position"   :"relative",
				  "height"     :0+conht+"px",
				  "overflow-x"   :"hidden" 
				  });				
		
		conwrp.css({
				   "width"     :len*conwh+"px",
				   "height"    :conht+"px",
				   "position"  :"absolute",
				   "top"       :0+"px"
				   });
		
		con.css({
				"float"        :"left",
				"width"        :conwh-padding+"px",
				"display"      :"block"
				});
		}
		
	if(org.effact=="scrolly"){
		var padding=parseInt(con.css("padding-top"))+parseInt(con.css("padding-bottom"));										
		_this.css({
				  "position"   :"relative",
				  "height"     :156+"px",
				  "overflow"   :"hidden" 
				  });
		tagwrp.css({
				   "z-index"   :100
				   })		
		conwrp.css({
				   "width"     :"100%",
				   "height"    :354+"px",
				   "position"  :"absolute",
				   "z-index"   :99												 
				   })		
		con.css({
				"height"       :177+"px",
				"display"      :"block"
				});
		}	
	
	tag.css({"cursor":"pointer"})
	    .each(function(i){
		tag.eq(i).bind(org.act,function(){
				cur(this,org.curClass);	
				k=i;
				switch(org.effact){					
					case "slow"    : con.eq(i).show("slow").siblings(org.conTag).hide("slow");
					break;
					case "fast"    : con.eq(i).show("fast").siblings(org.conTag).hide("fast");
					break;
					case "scrollx" : conwrp.animate({left:-i*conwh+"px"},org.aniSpeed);
					break;
					case "scrolly" : {
						conwrp.animate({top:-i*177+"px"},org.aniSpeed);
					}
					break;
					default        : con.eq(i).show().siblings(org.conTag).hide();
					break;
					//End of switch
					}			
				}		
			)									  
		})	
	
	if(org.auto){		
		var drive=function(){
			if(org.act=="mouseover"){
				tag.eq(k).mouseover();
				}else if(org.act=="click"){
				tag.eq(k).click();
				}			
			k++;			
			if(k==len) k=0;			
			}
		t=setInterval(drive,org.autotime);	
		}		
	//End of $.fn.tab	
	}
//Drive
$("#testtab2").tab({
	tabId:"#tabtag2",
	tabTag:"li",
	conId:"#tabcon2",
	conTag:"div",
	act:"click",
	effact: "scrolly",
	dft:0
	})

	});	
</script>
<?php 
$others_city_id = abs(intval($city['id']));
$daytime = strtotime(date('Y-m-d'));
	$oc = array( 
			'city_id' => array($others_city_id, 0), 
			'team_type' => 'normal',
			"begin_time <= '$daytime'",
			"end_time > '$daytime'",
			"audit" => 1, //所有已审核的团购
			);
	$sterms = DB::LimitQuery('team', array(
				'condition' => $oc,
				'order' => 'ORDER BY `sort_order` DESC, `lastbuy_time` DESC, `begin_time` DESC, `now_number` DESC, `id` DESC',
				));

	$condition = array( 
			'parent_id is null', 
			);
	$condition['zone'] = 'group';
	$condition['display'] = 'Y';

	$p_categories = DB::LimitQuery('category', array(
		'condition' => $condition,
		'order' => 'ORDER BY czone , sort_order DESC '
	));

	$condition = array( 
			'parent_id is not null', 
			);
	$condition['zone'] = 'group';
	$condition['display'] = 'Y';

	$c_categories = DB::LimitQuery('category', array(
		'condition' => $condition,
		'order' => 'ORDER BY sort_order DESC '
	));
	foreach($p_categories AS $id=>$one){
		$in = 1;
		foreach($c_categories AS $cid=>$cone){
			if ($one['id'] == $cone['parent_id']) {
				$p_c_c[$one['id']][$in++] = $cone;
			}
		}
	}

; ?>

	
			<div id="ads_content_box" class="coupons-box clear mainwide">
				<div class="box clear">
					<script type="text/javascript">function cls(){var getId = document.getElementById("ads_content_box");getId.style.display="none";}</script>
					<s onclick="javascript:cls();"><img src="/static/css/i/close.gif"></s>
					<div class="ads_word"></div>
					<div class="ads_top"></div>
						
						<div id="ads_content" style="position:relative;overflow-y: hidden;">
						<div class="testtab" id="testtab2"> 
						<div id="tabtag2" class="tabtag" style="float:left;position:relative;"> 
							<ul> 
								<li class="cur">分类</li> 
								<li>推荐</li>
							</ul> 
						</div> 
						<div id="tabcon2" class="tabcon"> 
							<div id="goods-type"> 
								<div style="width:100%;float:left;">
									
									<?php if(is_array($p_categories)){foreach($p_categories AS $index=>$one) { ?>
											<?php if($index == 0 || $index == 2){?>
												<span style="line-height:30px;float:left;padding:0px 5px 5px 10px;display:block;">
											<?php } else { ?><span style="line-height:30px;padding:0px 5px 5px 10px;display:block;"><?php }?>
											<span style="color:#FF7100;font-weight:bold;font-size:15px;">＞<a href="javascript:void(0);" class="goodcategory-change" style="color:#FF7100;" groupid="<?php echo $one['id']; ?>"><?php echo $one['name']; ?></a></span>
											<?php if(is_array($p_c_c[$one['id']])){foreach($p_c_c[$one['id']] AS $index1=>$one1) { ?>
												<span id="c-<?php echo $one['id']; ?>" style="padding:0px 5px;"><a href="javascript:void(0);" class="goodcategory-change" groupid="<?php echo $one1['id']; ?>"><?php echo $one1['name']; ?></a></span>
											<?php }}?>
										</span>
									<?php }}?>
									
								</div>
							</div> 
							<div>	
								<div id="slider">
									<ul style="overflow-y: hidden;">
										<?php if(is_array($sterms)){foreach($sterms AS $index=>$one) { ?>
											<?php if($index == 0){?>
											<li style="width:846px;height:156px;float:left;">
											<?php } else if($index%4 == 0) { ?>
											</li>
											<li style="width:846px;height:156px;float:left;">
											<?php }?>
												<div style="float:left;width:195px;padding:10px 5px 5px 5px;">
													<a target="_blank" href="/team.php?id=<?php echo $one['id']; ?>" alt="<?php echo $one['title']; ?>"><img src="<?php echo team_image($one['image'], true); ?>" alt="<?php echo $one['title']; ?>" title="<?php echo $one['title']; ?>">
													</a>
													<span style="display: inline;"><p >现价: <font class="su1"><?php echo $currency; ?><?php echo moneyit($one['team_price']); ?></font>&nbsp;售出:<font class="su1"><?php echo $one['now_number']; ?></font>件</p></span>
												</div>
											
										<?php }}?>
										</li>
									</ul>
								</div>
							</div>
						</div>
					
					
				</div>
				
			</div>
		</div>
		<div class="ads_bottom"></div>
</div>
