jQuery.fn.countdown=function(options){if(!options){options="()"}if(jQuery(this).length==0){return false}var obj=this;if(options.seconds<0||options.seconds=="undefined"){if(options.callback){eval(options.callback)}return null}window.setTimeout(function(){jQuery(obj).html(String(options.seconds));--options.seconds;jQuery(obj).countdown(options)},1000);return this};jQuery.fn.countdown.stop=function(){window.clearTimeout(setTimeout("0")-1)};
$(function(){

	$(".goodcategory-change").click(function(){
		$("#deal-default").css("width", "715px");
        $("#deal-default").html("<img src=\""+WEB_ROOT+"/static/theme/noietheme/css/i/ajax-loader.gif\" />");
		var ur = WEB_ROOT+"/ajax/team_list.php?gid="+$(this).attr("groupid");
		if ($(this).attr("page"))
		{
			ur += "&page=" + $(this).attr("page");
		}
        $("#deal-default").load(ur ,
            function(a,b,c){
                
                $(this).show();

            });
        
    })
})

 

 // 说明 ：用 Javascript 实现锚点(Anchor)间平滑跳转
function intval(v)
{
v = parseInt(v);
return isNaN(v) ? 0 : v;
}
// 获取元素信息
function getPos(e)
{
var l = 0;
var t  = 0;
var w = intval(e.style.width);
var h = intval(e.style.height);
var wb = e.offsetWidth;
var hb = e.offsetHeight;
while (e.offsetParent){
l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
t += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
e = e.offsetParent;
}
l += e.offsetLeft + (e.currentStyle?intval(e.currentStyle.borderLeftWidth):0);
t  += e.offsetTop  + (e.currentStyle?intval(e.currentStyle.borderTopWidth):0);
return {x:l, y:t, w:w, h:h, wb:wb, hb:hb};
}
// 获取滚动条信息
function getScroll()
{
var t, l, w, h;
if (document.documentElement && document.documentElement.scrollTop) {
t = document.documentElement.scrollTop;
l = document.documentElement.scrollLeft;
w = document.documentElement.scrollWidth;
h = document.documentElement.scrollHeight;
} else if (document.body) {
t = document.body.scrollTop;
l = document.body.scrollLeft;
w = document.body.scrollWidth;
h = document.body.scrollHeight;
}
return { t: t, l: l, w: w, h: h };
}
// 锚点(Anchor)间平滑跳转
function scroller(el, duration)
{
if(typeof el != 'object') { el = document.getElementById(el); }
if(!el) return;
var z = this;
z.el = el;
z.p = getPos(el);
z.s = getScroll();
z.clear = function(){window.clearInterval(z.timer);z.timer=null};
z.t=(new Date).getTime();
z.step = function(){
var t = (new Date).getTime();
var p = (t - z.t) / duration;
if (t >= duration + z.t) {
z.clear();
window.setTimeout(function(){z.scroll(z.p.y, z.p.x)},13);
} else {
st = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.y-z.s.t) + z.s.t;
sl = ((-Math.cos(p*Math.PI)/2) + 0.5) * (z.p.x-z.s.l) + z.s.l;
z.scroll(st, sl);
}
};
z.scroll = function (t, l){window.scrollTo(l, t)};
z.timer = window.setInterval(function(){z.step();},13);
}