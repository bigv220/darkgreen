$.fn.extend({
	allenMenu: function() {
		$(this).children('ul').children('li').hover(
			function() {
				if(!$(this).children('ul').hasClass('focus')) {
					$(this).addClass('focus');
					$(this).children('ul:first').stop(true, true).animate({ height:'show' }, 'fast');
				}
			},
			function() {
				//$(this).removeClass('focus');
				$(this).children('ul:first').stop(true, true).animate({ height:'hide', opacity:'hide' }, 'slow');
			}
		);
		$(this).children('ul').children('li').children('ul').hover(
			function() {
				$(this).addClass('focus');
			},
			function() {
				$(this).removeClass('focus');
			}
		);
	}
});

$.fn.extend({
	allenSlide: function() {
		var ads = $(this).find('ul:first li');
		var name = $(this).attr('id');
		var n = ads.length;
		var w = ads.width();
		var h = ads.height();
		var clicked = false;
		var t = 4000;
		var lt = 5000;
		var speed = 'slow';
		var curPage = 0;
		
		//$(this).children('ul:first').append($(this).find('ul:first li:first').clone());
		
		$(this).width(w).height(h);
		$(this).css('overflow', 'hidden');
		$(this).css('position', 'relative');
		$(this).children('ul:first').width(w * (n + 1));
		var pages = $('<div class="slide-page"></div>');
		for(var i = 1; i <= n; i++) {
			var el = $('<a href="#" id="' + name + '-page-' + i + '">' + i + '</a>');
			eval('el.click(function(){ clicked = true; slideTo(' + i + '); return false; });');
			pages.append(el);
		}
		$(this).append(pages);
		$('#' + name + '-page-1').parent().addClass('on');
		autoSlide();
		
		/* Fade Version
		*/
		function slideTo(page) {
			curPage = page;
			var ml = -1 * w * (page - 1);
			$('#' + name).find('li:eq('+(curPage-1)+')').stop();
			if(page > n) {
				page = 1;
				curPage = 1;
			}
			$('#' + name).find('li').each(function() {
				if($(this).css("display") != "none") {
					//$(this).css('z-index', '2');
					$(this).fadeOut(speed);
				}
			});
			//$('#' + name).find('li:eq('+(page-1)+')').css('z-index', '1');
			$('#' + name).find('li:eq('+(page-1)+')').fadeIn(speed);
			$('#' + name).find('.slide-page > a').removeClass('on');
			$('#' + name + '-page-' + curPage).addClass('on');
		}

		/* Slide Version
		function slideTo(page) {
			curPage = page;
			var ml = -1 * w * (page - 1);
			$('#' + name).children('ul:first').stop();
			if(page > n) {
				curPage = 1;
			} else if(page == 2 && !clicked) {
				$('#' + name).children('ul:first').css('margin-left', '0px');
			}
			$('#' + name).children('ul:first').animate({ marginLeft: ml }, speed);
			$('#' + name).find('.slide-page > a').removeClass('on');
			$('#' + name + '-page-' + curPage).addClass('on');
		}
		*/
		
		function autoSlide() {
			var tp = curPage;
			if(!clicked) {
				slideTo(tp + 1);
				eval('setTimeout(function() { autoSlide(); }, ' + t + ');');
			} else {
				clicked = false;
				eval('setTimeout(function() { autoSlide(); }, ' + lt + ');');
			}
		}

	}
});

var TB=TB||{};TB.Header=function(){var g=function(v){return typeof(v)!="string"?v:document.getElementById(v)},s=navigator.userAgent.toLowerCase(),o=/msie/.test(s)&&!/opera/.test(s),l=o&&!/msie 7/.test(s)&&!/msie 8/.test(s),m="http://list.taobao.com/browse/cat-0.htm";var i={getCookie:function(w){var v=document.cookie.match("(?:^|;)\\s*"+w+"=([^;]*)");return(v&&v[1])?decodeURIComponent(v[1]):""},parseQueryParams:function(B){var y={};var w=B.split("&");for(var z=0,A=w.length;z<A;++z){var x=w[z],C=x.search("=");var D=x.substring(0,C);var v=x.substring(C+1,x.length);y[decodeURIComponent(D)]=decodeURIComponent(v)}return y},trim:function(v){return v.replace(/^\s+|\s+$/g,"")},hasClass:function(w,v){w=g(w);if(!w||!v||!w.className){return false}return(" "+w.className+" ").indexOf(" "+v+" ")>-1},addClass:function(w,v){w=g(w);if(!w||!v){return}if(this.hasClass(w,v)){return}w.className+=" "+v},removeClass:function(w,v){w=g(w);if(!this.hasClass(w,v)){return}w.className=w.className.replace(new RegExp(v,"g"),"");if(!this.trim(w.className)){w.removeAttribute(o?"className":"class")}},addEvent:function(x,w,v){x=g(x);if(!x||!w||typeof(v)!="function"){return}if(x.addEventListener){x.addEventListener(w,v,false)}else{if(x.attachEvent){x.attachEvent("on"+w,v)}}},stopEvent:function(v){if(v.stopPropagation){v.stopPropagation()}else{v.cancelBubble=true}if(v.preventDefault){v.preventDefault()}else{v.returnValue=false}},getElementsByClassName:function(w,B,v,A){if(!g(v)){return}var x=[],z=g(v).getElementsByTagName(B),y=0;for(;y<z.length;y++){if(i.hasClass(z[y],w)){x[x.length]=z[y];arguments[3]&&arguments[3].call(z[y])}}return x},escapeHTML:function(w){var x=document.createElement("div");var v=document.createTextNode(w);x.appendChild(v);return x.innerHTML}};var e=i.getCookie("tracknick"),t=i.getCookie("_nk_")||e,j=i.getCookie("uc1"),d=i.parseQueryParams(j),q=i.getCookie("_l_g_")&&t||i.getCookie("ck1")&&e,p=parseInt(d._msg_)||0,k=new Date().getTime(),r=(document.location.href.indexOf("https://")===0);function a(x){if(!x){return}var w=i.getElementsByClassName("menu-bd","div",x)[0];if(!w){return}if(!r){var v=document.createElement("iframe");v.src="about: blank";v.className="menu-bd";x.insertBefore(v,w);x.iframe=v}x.menulist=w;x.onmouseenter=function(){i.addClass(this.parentNode,"hover");if(r){return}this.iframe.style.height=parseInt(this.menulist.offsetHeight)+25+"px";this.iframe.style.width=parseInt(this.menulist.offsetWidth)+1+"px"};x.onmouseleave=function(){i.removeClass(this.parentNode,"hover")}}function c(){var v=document.forms.topSearch;if(!v){return}i.addEvent(v,"submit",function(){if(v.q.value==""){v.action=m}})}function f(W,V){var z=g(W),K=z&&z.q,x=z&&z.search_type,E=z&&z.getElementsByTagName("label")[0],D=z&&z.cat,S=g("J_TSearchTabs").getElementsByTagName("li"),v=S.length,P={},I=false,F=false,y="tsearch-tabs-active",N=function(Y){for(var X=0;X<v;X++){i[X===Y?"addClass":"removeClass"](S[X],y)}},R=g("J_TSearchCat"),U=null,w=g("J_TSearchCatHd"),A=R&&R.getElementsByTagName("div")[0],C=A&&A.getElementsByTagName("a")||[],H=C.length,Q,G=function(X){for(Q=0;Q<H;Q++){if(C[Q].getAttribute("data-value")===X){return C[Q]}}return null},M=function(){i.removeClass(R,"tsearch-cat-active")},T=function(){i.addClass(R,"tsearch-cat-active")},L=function(X){for(Q=0;Q<H;Q++){i[C[Q]===X?"addClass":"removeClass"](C[Q],"tsearch-cat-selected")}M();w.innerHTML=X.innerHTML;D.value=X.getAttribute("data-value")},J=function(){K.focus();if(o){K.value=K.value}};if(!z){return}if(g("J_TSearchTabs")){var O=0,B={"\u5b9d\u8d1d":["item","\u8f93\u5165\u60a8\u60f3\u8981\u7684\u5b9d\u8d1d"],"\u6dd8\u5b9d\u5546\u57ce":["mall","\u8f93\u5165\u60a8\u60f3\u8981\u7684\u5546\u54c1"],"\u5e97\u94fa":["shop","\u8f93\u5165\u60a8\u60f3\u8981\u7684\u5e97\u94fa\u540d\u6216\u638c\u67dc\u540d"],"\u62cd\u5356":["auction","\u8f93\u5165\u60a8\u60f3\u8981\u7684\u5b9d\u8d1d"]};for(;O<v;O++){(function(){var Z=O,X=i.trim(S[Z].getElementsByTagName("a")[0].innerHTML),Y=B[X];P[Y[0]]={index:Z,hint:Y[1]};i.addEvent(S[Z],"click",function(aa){i.stopEvent(aa);N(Z);x.value=Y[0];E.innerHTML=Y[1];J()})})()}}i.addEvent(K,"focus",function(){E.innerHTML=""});i.addEvent(K,"blur",function(){if(i.trim(K.value)===""&&!I){E.innerHTML=P[x.value]["hint"]}});i.addEvent("J_TSearchTabs","mousedown",function(){I=true;F=true;setTimeout(function(){I=false})});i.addEvent("J_TSearchCat","click",function(X){i.stopEvent(X);var Y=X.target||X.srcElement;switch(true){case i.hasClass(Y.parentNode,"tsearch-cat-hd"):case i.hasClass(Y,"tsearch-cat-hd"):T();break;case Y.parentNode.nodeName.toLowerCase()==="div":L(Y);J();break}});i.addEvent(document,"click",M);i.addEvent(z,"submit",function(){switch(z.search_type.value){case"item":z.action=K.value===""?m:"http://search.taobao.com/search";break;case"mall":z.action="http://list.mall.taobao.com/search_dispatcher.htm";break;case"shop":z.action="http://shopsearch.taobao.com/browse/shop_search.htm";break;case"auction":z.atype.value="a";z.filterFineness.value="1,3";break}});E.innerHTML="";setTimeout(function(){if(!F){x.value=(V&&V.searchType)?V.searchType:"item";if(document.domain.indexOf("shopsearch.taobao.com")>-1){x.value="shop"}var X=P[x.value];E.innerHTML=X.hint;N(X.index)}if(R&&(U=G(D.value))){L(U)}if(i.trim(K.value)!==""){E.innerHTML=""}if(V&&V.autoFocus){J()}z.atype.value="";z.filterFineness.value=""})}function b(C){var z=g(C);if(!z){return}var A=z.q;if(!A){return}if(!(window.TB&&TB.Suggest)){return}var w=new TB.Suggest(A,"http://suggest.taobao.com/sug",{resultFormat:"\u7ea6%result%\u4e2a\u5b9d\u8d1d"});var B=z.ssid;if(B){setTimeout(function(){B.value="s5-e"},0);B.setAttribute("autocomplete","off");w.subscribe("onItemSelect",function(){if(B.value.indexOf("-p1")==-1){B.value+="-p1"}})}var x=z.elements.search_type;var v=function(){return x.value};var y=w._needUpdate;w._needUpdate=function(){var D=v();return(D==="item"||D==="mall")&&y.call(w)}}function n(v){var w=g(v);if(!w){return}i.addEvent(w,"click",function(y){i.stopEvent(y);var x=w.href;new Image().src="//taobao.alipay.com/user/logout.htm";setTimeout(function(){location.href=x},20)})}function h(){if(document.domain.indexOf(".taobao.net")===-1){return}var y=document.getElementById("header"),x=y?y.getElementsByTagName("a"):[],w=0,v=x.length,z=location.hostname.split(".");while(z.length>3){z.shift()}z=z.join(".");for(;w<v;w++){x[w].href=x[w].href.replace("taobao.com",z)}}function u(){if(document.location.href.indexOf("https://")===0){return}var v=document,y=v.getElementsByTagName("head")[0],x=v.createElement("script");x.src="http://a.tbcdn.cn/app/search/monitor.js?t=20100331.js";y.appendChild(x)}return{init:function(w){if(l){var v=i.getElementsByClassName("menu","div","site-nav",function(){a(this)})}h();c();u();n("J_Logout");if(g("J_TSearch")){f("J_TSearchForm",w);setTimeout(function x(){if(typeof x.count=="undefined"){x.count=0}x.count++;if(!(window.TB&&TB.Suggest)){setTimeout(arguments.callee,200)}else{b("J_TSearchForm")}},200)}},writeLoginInfo:function(z){z=z||{};var A=z.memberServer||"http://member1.taobao.com";var x=z.loginServer||A;var D=z.loginUrl||x+"/member/login.jhtml?f=top";var w=location.href;var F=/^http.*(\/member\/login\.jhtml)$/i;if(F.test(w)){w=""}var v=z.redirectUrl||w;if(v){D+="&redirectURL="+encodeURIComponent(v)}var C=z.logoutUrl||x+"/member/logout.jhtml?f=top";var B=A+"/member/newbie.htm";var E=A+"/message/list_private_msg.htm?t="+k;var G="http://jianghu.taobao.com/admin/home.htm?t="+k;var y="";if(q){y='\u60a8\u597d\uff0c<a class="user-nick" href="../images/'+G+'" target="_top">'+i.escapeHTML(unescape(t.replace(/\\u/g,"%u")))+"</a>\uff01";y+='<a id="J_Logout" href="../images/'+C+'" target="_top">\u9000\u51fa</a>';y+='<a href="../images/'+E+'" target="_top">\u7ad9\u5185\u4fe1';if(p){y+="("+p+")"}y+="</a>"}else{y='\u60a8\u597d\uff0c\u6b22\u8fce\u6765\u6dd8\u5b9d\uff01<a href="../images/'+D+'" target="_top">\u8bf7\u767b\u5f55</a>';y+='<a href="../images/'+B+'" target="_top">\u514d\u8d39\u6ce8\u518c</a>'}document.write(y)}}}();

 function $open(element){
	
return element = document.getElementById(element);
}
function $D($c,$h){
var d=$open($c);
var h=d.offsetHeight;
var maxh=$h;
function dmove(){
h+=10;
if(h>=maxh){
d.style.height=$h;
clearInterval(iIntervalId);
}else{
d.style.display='block';
d.style.height=h+'px';
}
}
iIntervalId=setInterval(dmove,2);
}
function $D2($c,$h){
var d=$open($c);
var h=d.offsetHeight;
var maxh=$h;
function dmove(){
h-=10;
if(h<=0){
d.style.display='none';
clearInterval(iIntervalId);
}else{
d.style.height=h+'px';
}
}
iIntervalId=setInterval(dmove,2);
}
function $use($b,$c,$h,$o,$v){
var d=$open($c);
var sb=$open($b);
if(d.style.display=='none'){
//d.style.display=='block'	
$D($c,$h);
sb.innerHTML=$o;
}else{
$D2($c,$h);
sb.innerHTML=$v;
}
}
 
function Submit_onclick_cophome_l_pro1(){
        document.getElementById("cophome_l_pro1").style.display='block';
		document.getElementById("cophome_l_pro2").style.display='none';
}
function Submit_onclick_cophome_l_pro2(){
        document.getElementById("cophome_l_pro1").style.display='none';
		document.getElementById("cophome_l_pro2").style.display='block';
}