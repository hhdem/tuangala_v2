var WEB_ROOT = WEB_ROOT || '';
var LOGINUID = LOGINUID || 0;
window.x_init_hook_validator = function() {
	jQuery('form.validator').each(function(){jQuery.fn.checkForm(this);});
	jQuery('a.needlogin').click(X.misc.needlogin);
};
window.x_init_hook_dealimage = function() {
	var teamside = jQuery('#team_partner_side_0').size() > 0;
	var m = teamside ? 650 : 410;
	if ( teamside ) {
		jQuery('#team_main_side').css('width', '650px');
		jQuery('.side #side-business img').each(function(){X.misc.scaleimage(this,m);});
	} else {
		jQuery('.side #side-business img').each(function(){X.misc.scaleimage(this,195);});
	}
	jQuery('#deal-stuff img').each(function(){X.misc.scaleimage(this,m);});
	jQuery('div.sbox-content img').each(function(){X.misc.scaleimage(this,195);});
};
window.x_init_hook_myaccount = function() {
	var ma = jQuery('#myaccount');
	var mm = jQuery('#myaccount-menu');
	ma.hover(function(){ mm.show(); ma.toggleClass('hover', true); },function(){ var menuhide = function(){ mm.hide(); ma.toggleClass('hover', false); }; menuout=setTimeout(menuhide,100); });
	mm.hover(function(){ clearTimeout(menuout);},function(){ jQuery(this).hide(); ma.toggleClass('hover', false); });
};
window.x_init_hook_click = function() {
	jQuery("div:not(#guides-city-change)").click(function(){
	jQuery('#guides-city-list').css('display', 'none');
});
jQuery('#guides-city-change').click(function(){
	return !jQuery('#guides-city-list').toggle();
});
jQuery('#sysmsg-guide-close').click(function(){
	jQuery('#sysmsg-guide').remove();
	return !X.get( WEB_ROOT + '/ajax/newbie.php');
});
	jQuery('#sysmsg-error span.close').click(function(){
		return !jQuery('#sysmsg-error').remove();
	});
	jQuery('#sysmsg-success span.close').click(function(){
		return !jQuery('#sysmsg-success').remove();
	});
	jQuery('#deal-share-im').click(function(){
		return !jQuery('#deal-share-im-c').toggle();
	});
	jQuery('a.ajaxlink').click(function() {
		if (jQuery(this).attr('no') == 'yes')
			return false;
		var link = jQuery(this).attr('href');
		var ask = jQuery(this).attr('ask');
		if (link.indexOf('/delete')>0 &&!confirm('确定删除本条记录吗？')) { 
			return false;
		} else if (ask && !confirm(ask)) {
			return false;
		}
		X.get(jQuery(this).attr('href'));
		return false;
    });
	jQuery('a.remove').click(function(){
		var u = jQuery(this).attr('href');
		if (confirm('确定删除该条记录吗？')){X.get(u);}
		return false;
	});
	jQuery('.remove-record').click(function(){
		return confirm('确定删除该条记录吗？');
	});
	jQuery('a.delay').click(function(){
		var u = jQuery(this).attr('href');
		if (confirm('确定要将此团购项目延期一天吗？')) {
			return !X.get(u) && false;
		}
		return false;
	});
	jQuery('#cardcode-link').click(function(){
		jQuery('.cardcode .act').toggle();
	});
	jQuery('#cardcode-verify-id').click(X.misc.cardcode);
	jQuery('#consult-add-form input[name="commit"]').click(function(){
		jQuery('#consult-add-form').ajaxSubmit({
			'success' : function() { X.team.consultation_again(); }
		});
		return false;
	});
	jQuery('#consult-add-more').click(X.team.consultation_again);
	jQuery('#express-zone-div input').click(function(){
		var v = jQuery(this).attr('value');
		if ( v == 'express' ) {
			jQuery('#express-zone-express').css('display', 'block');
			jQuery('#express-zone-pickup').css('display', 'none');
			jQuery('#express-zone-coupon').css('display', 'none');
		} else if ( v == 'pickup' ) {
			jQuery('#express-zone-pickup').css('display', 'block');
			jQuery('#express-zone-express').css('display', 'none');
			jQuery('#express-zone-coupon').css('display', 'none');
		} else if (v == 'coupon') {
			jQuery('#express-zone-coupon').css('display', 'block');
			jQuery('#express-zone-pickup').css('display', 'none');
			jQuery('#express-zone-express').css('display', 'none');
		}
	});
	jQuery('#mail-zone-div input').click(function(){
		var v = jQuery(this).attr('value');
		if ( v == 'smtp' ) {
			jQuery('#mail-zone-smtp').css('display', 'block');
		} else {
			jQuery('#mail-zone-smtp').css('display', 'none');
		}
	});
	jQuery('#share-copy-text').click(function(){jQuery(this).select();});
	jQuery('#share-copy-button').click(function(){
			X.misc.copyToCB('share-copy-text');
	});
	jQuery('#verify-coupon-id').click(function(){
		X.get( WEB_ROOT + '/ajax/coupon.php?action=dialog');
	});
	jQuery('#deal-subscribe-form').submit(function(){
		var v =jQuery('#deal-subscribe-form-email').attr('value');
		return /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(v);
	});
	jQuery('#header-subscribe-form').submit(function(){
		var v =jQuery('#header-subscribe-email').attr('value');
		return /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(v);
	});
	jQuery('input[xtip$="."]').each(X.misc.inputblur);
	jQuery('input[xtip$="."]').focus(X.misc.inputclick);
	jQuery('input[xtip$="."]').blur(X.misc.inputblur);
};

window.x_init_hook_imagerotate = function() {
	var imgListCurr = 0;
	var imgListCount = jQuery('#img_list a').size();
	if(imgListCount < 2) return;
	var imagesRun = function() { var imgListNext = imgListCurr + 1; if (imgListCurr == imgListCount - 1) imgListNext = 0; imagesPlay(imgListNext); imgListCurr++; if (imgListCurr > imgListCount - 1) { imgListCurr = 0; imgListNext = imgListCurr + 1; } };
	jQuery('#team_images').everyTime(3000, 'imagerotate', imagesRun);
	jQuery('#team_images li,#img_list a').hover(function(){ jQuery('#team_images').stopTime('imagerotate'); },function(){ jQuery('#team_images').everyTime(3000, 'imagerotate', imagesRun); }); 
	jQuery('#img_list a').click(function(){ var index = jQuery('#img_list a').index(this); if (imgListCurr != index){ imagesPlay(index); imgListCurr = index; }; return false; });
	var imagesPlay = function(next) { jQuery('#team_images li').eq(imgListCurr).css({'opacity':'0.5'}).animate({'left':'-440px','opacity':'1'},'slow',function(){ jQuery(this).css({'left':'440px' }); }).end().eq(next).animate({'left':'0px','opacity':'1'},'slow',function(){ jQuery('#img_list a').siblings('a').removeClass('active').end().eq(next).addClass('active'); }); };
};

window.x_init_hook_clock = function() {
	var a = parseInt(jQuery('div.deal-timeleft').attr('diff'));
	if (!a>0) return;
	var b = (new Date()).getTime();	
	var e = function() {
		var c = (new Date()).getTime();
		var ls = a + b - c;
		if ( ls > 0 ) {
			var ld = parseInt(ls/86400000) ; ls = ls % 86400000;
			var lh = parseInt(ls/3600000) ; ls = ls % 3600000;
			var lm = parseInt(ls/60000) ; 
			var ls = parseInt(Math.round(ls%60000)/1000);
			if (ld>0) {
				var html = '<li><span>'+ld+'</span>天</li><li><span>'+lh+'</span>小时</li><li><span>'+lm+'</span>分钟</li>';
			} else {
				var html = '<li><span>'+lh+'</span>小时</li><li><span>'+lm+'</span>分钟</li><li><span>'+ls+'</span>秒</li>';
			}
			jQuery('ul#counter').html(html);
		} else {
			jQuery("ul#counter").stopTime('counter');
			jQuery('ul#counter').html('end');
			window.location.reload();
		}
	};
	jQuery("ul#counter").everyTime(996, 'counter', e);
};

window.x_init_hook_team = function() {
	jQuery('#deal-buy-quantity-input').bind("keyup", function(){
		var n = parseInt(jQuery(this).attr('value'),10);
		var per = parseInt(jQuery('#deal-per-number').attr('value'),10);
		if (n>per && per>0) { n = per; }
		n = isNaN(n) ? '' : n; jQuery(this).attr('value', n);
		var p = parseFloat(jQuery('#deal-buy-price').html(),10);
		p = isNaN(p) ? 0 : p; n = isNaN(n) ? 0 : n; var t = n * p;
		jQuery('#deal-buy-total').html(t.toFixed(2));
		X.team.dealbuy_farefree(n);
		X.team.dealbuy_totalprice();
	});
};

window.x_init_hook_order = function() {
	jQuery('form[id="order-pay-form"]').bind('submit', function() {
		X.get( WEB_ROOT + '/ajax/order.php?action=dialog&id=' + jQuery(this).attr('sid'));
	});
};

/* X.misc Zone */
X.misc = {};
X.misc.copyToCB = function(tid) {
	var o = jQuery('#'+tid); o.select(); var maintext = o.val();
	if (window.clipboardData) {
		if ((window.clipboardData.setData("Text", maintext))) {
			var tip = o.attr('tip'); if ( tip ) alert(tip);
			return true;
		}
	}
	else if (window.netscape) {
		netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip) return;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans) return;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext=maintext;
		str.data=copytext;
		trans.setTransferData("text/unicode",str,copytext.length*2);
		var clipid=Components.interfaces.nsIClipboard;
		if (!clip) return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
		var tip = o.attr('tip'); if ( tip ) alert(tip);
		return true;
	}
	return false;
};
X.misc.scaleimage = function(o,mw) {
	var w = jQuery(o).width();
	if (w>mw) jQuery(o).css('width',mw+'px');
};
X.misc.inputblur = function() {
	var v =jQuery(this).attr('value');
	var t =jQuery(this).attr('xtip');
	if( v == t || !v ) {
		jQuery(this).attr('value', t);
		jQuery(this).css('color', '#999');
	}
};
X.misc.inputclick = function() {
	var v =jQuery(this).attr('value');
	var t =jQuery(this).attr('xtip');
	if( v == t ) {
		jQuery(this).attr('value', '');
	}
	jQuery(this).css('color', '#333');
};
X.misc.noticenext = function(tid, nid) {
	jQuery('#dialog_subscribe_count_id').html(nid);
	return X.get(WEB_ROOT + '/ajax/manage.php?action=noticesubscribe&id='+tid+'&nid='+nid);
};
X.misc.noticenextsms = function(tid, nid) {
	jQuery('#dialog_smssubscribe_count_id').html(nid);
	return X.get(WEB_ROOT + '/ajax/manage.php?action=noticesmssubscribe&id='+tid+'&nid='+nid);
};
X.misc.noticesms= function(tid, nid) {
	jQuery('#dialog_sms_count_id').html(nid);
	return X.get(WEB_ROOT + '/ajax/manage.php?action=noticesms&id='+tid+'&nid='+nid);
};
X.misc.needlogin = function() {
	return LOGINUID>0 ? true : !X.get(WEB_ROOT + '/ajax/system.php?action=needlogin');
};
X.misc.cardcode = function() {
	var oid = jQuery('#cardcode-order-id').attr('value');
	var cid = jQuery('#cardcode-card-id').attr('value');
	if(oid&&cid) return !X.get(WEB_ROOT + '/ajax/order.php?action=cardcode&id='+oid+'&cid='+cid);
};
X.misc.smscount = function() {
	var l = jQuery('#sms-content-id').val().length;
	var s = Math.ceil(l/70);
	jQuery('#span-sms-length-id').html(l);
	jQuery('#span-sms-split-id').html(s);
};
X.misc.locale = function() {
	return X.get(WEB_ROOT + '/ajax/system.php?action=locale');
};

/* X.team Zone */
X.team = {};
X.team.consultation_again = function() {
	jQuery('#consult-content').val('');
	jQuery('#consult-add-form').toggle();
	jQuery('#consult-add-succ').toggle();
};
X.team.dealbuy_farefree = function(n) {
	var ff = parseInt(jQuery('#deal-buy-quantity-input').attr('ff'));
	if (ff>0 && ff<=n) {
		jQuery('#deal-express-total').html('0');
	} else {
		var fa = parseInt(jQuery('#deal-express-price').attr('v'));
		jQuery('#deal-express-total').html(fa);
	}
};
X.team.dealbuy_totalprice = function() {
		var n = parseFloat(jQuery('#deal-buy-total').html(),10);
		n = isNaN(n) ? 0 : n;
		var p = parseFloat(jQuery('#deal-express-total').html(),10);
		p = isNaN(p) ? 0 : p;
		var t = n + p;
		jQuery('#deal-buy-total-t').html(t.toFixed(2));
};
X.team.changetype = function(type) {
	var display = (type=='goods') ? 'none' : 'block';
	if (type == 'goods') jQuery('#team-create-per-number').val('0');
	if (type != 'seconds') {
		jQuery('#team-create-begin-time').val(jQuery('#team-create-begin-time').attr('xd'));
		jQuery('#team-create-end-time').val(jQuery('#team-create-end-time').attr('xd'));
		jQuery('#team-create-begin-time').attr('maxLength', 10);
		jQuery('#team-create-end-time').attr('maxLength', 10);
	} else {
		jQuery('#team-create-begin-time').val(jQuery('#team-create-begin-time').attr('xd') + ' ' + jQuery('#team-create-begin-time').attr('xt'));
		jQuery('#team-create-end-time').val(jQuery('#team-create-end-time').attr('xd') + ' ' + jQuery('#team-create-end-time').attr('xt'));
		jQuery('#team-create-begin-time').attr('maxLength', 19);
		jQuery('#team-create-end-time').attr('maxLength', 19);
	}
	jQuery('#field_city').css('display', display);
	jQuery('#field_num').css('display', display);
	jQuery('#field_notice').css('display', display);
	jQuery('#field_card').css('display', display);
	jQuery('#field_userreview').css('display', display);
	jQuery('#field_systemreview').css('display', display);
	jQuery('#field_limit').css('display', display);
};

/* X.coupon */
X.coupon = {};
X.coupon.dialogquery = function() {
	var id = jQuery('#coupon-dialog-input-id').attr('value');
	if (id) return !X.get(WEB_ROOT + '/ajax/coupon.php?action=query&id='+encodeURIComponent(id));
};
X.coupon.dialogconsume = function() {
	var id = jQuery('#coupon-dialog-input-id').attr('value');
	var secret = jQuery('#coupon-dialog-input-secret').attr('value');
	if (id && secret) { 
		var ask = jQuery('#coupon-dialog-consume').attr('ask');
		return confirm(ask) && !X.get(WEB_ROOT + '/ajax/coupon.php?action=consume&id='+encodeURIComponent(id)+'&secret='+encodeURIComponent(secret)); 
	}
};
X.coupon.dialoginputkeyup = function(o) {jQuery(o).attr('value', jQuery(o).attr('value').toUpperCase())};

/* X.manage */
X.manage = {};
X.manage.loadtemplate = function(id) {
	window.location.href = WEB_ROOT + '/manage/system/template.php?id='+id;
};
X.manage.loadpage = function(id) {
	window.location.href = WEB_ROOT + '/manage/system/page.php?id='+id;
};
X.manage.usermoney = function() {
	var money = parseFloat(jQuery('#user-dialog-input-id').attr('value'));
	var uid = jQuery('#user-dialog-input-id').attr('uid');
	var ask = jQuery('#user-dialog-input-id').attr('ask');
	if (uid&&money&&(!ask||confirm(ask))) return !X.get(WEB_ROOT + '/ajax/manage.php?action=usermoney&id='+uid+'&money='+encodeURIComponent(money));
};
X.manage.orderexpress = function() {
	var eid = parseInt(jQuery('#order-dialog-select-id').val());
	var nid = jQuery('#order-dialog-input-id').attr('value');
	var oid = jQuery('#dialog-order-id').attr('oid');
	if(oid) return !X.get(WEB_ROOT + '/ajax/manage.php?action=orderexpress&id='+oid+'&eid='+eid+'&nid='+encodeURIComponent(nid));
};
X.manage.orderrefund = function() {
	var rid = jQuery('#order-dialog-refund-id').val();
	var oid = jQuery('#dialog-order-id').attr('oid');
	if(oid&&rid) return !X.get(WEB_ROOT + '/ajax/manage.php?action=orderrefund&id='+oid+'&rid='+rid);
};
X.manage.teamcoupon = function(tid) {
	return !X.get(WEB_ROOT + '/ajax/manage.php?action=teamcoupon&id='+tid);
};
/* X.miscajax */
X.miscajax = function(script, action) {
	return !X.get(WEB_ROOT + '/ajax/'+script+'.php?action='+action);
};
