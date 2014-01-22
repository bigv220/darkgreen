 Validator = {
	Require : /.+/,
	Email : /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
	Phone : /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/,
	Mobile : /^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/,
	Url : /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/,
	IdCard : "this.IsIdCard(value.replace('X','x'))",
	Currency : /^\d+(\.\d+)?$/,
	Number : /^\d+$/,
	Zip : /^[1-9]\d{5}$/,
	QQ : /^[1-9]\d{4,8}$/,
	Integer : /^[-\+]?\d+$/,
	Double : /^[-\+]?\d+(\.\d+)?$/,
	English : /^[A-Za-z]+$/,
	Chinese :  /^[\u0391-\uFFE5]+$/,
	Username : /^[a-z]\w{3,}$/i,
	UnSafe : /^(([A-Z]*|[a-z]*|\d*|[-_\~!@#\$%\^&\*\.\(\)\[\]\{\}<>\?\\\/\'\"]*)|.{0,5})$|\s/,
	IsSafe : function(str){return !this.UnSafe.test(str);},
	SafeString : "this.IsSafe(value)",
	Filter : "this.DoFilter(value, getAttribute('accept'))",
	Limit : "this.limit(value.length,getAttribute('min'),  getAttribute('max'))",
	LimitB : "this.limit(this.LenB(value), getAttribute('min'), getAttribute('max'))",
	Date : "this.IsDate(value, getAttribute('min'), getAttribute('format'))",
	Repeat : "value == document.getElementsByName(getAttribute('to'))[0].value",
	Range : "getAttribute('min') < (value|0) && (value|0) < getAttribute('max')",
	Compare : "this.compare(value,getAttribute('operator'),getAttribute('to'))",
	Custom : "this.Exec(value, getAttribute('regexp'))",
	Group : "this.MustChecked(getAttribute('name'), getAttribute('min'), getAttribute('max'))",
	ErrorItem : [document.forms[0]],
	ErrorMessage : ["以下原因导致提交失败：\t\t\t\t"],
	Validate : function(theForm, mode){
		var obj = theForm || event.srcElement;
		var count = obj.elements.length;
		this.ErrorMessage.length = 1;
		this.ErrorItem.length = 1;
		this.ErrorItem[0] = obj;
		for(var i=0;i<count;i++){
			with(obj.elements[i]){
				var _dataType = getAttribute("dataType");
				if(typeof(_dataType) == "object" || typeof(this[_dataType]) == "undefined")  continue;
				this.ClearState(obj.elements[i]);
				if(getAttribute("require") == "false" && value == "") continue;
				switch(_dataType){
					case "IdCard" :
					case "Date" :
					case "Repeat" :
					case "Range" :
					case "Compare" :
					case "Custom" :
					case "Group" : 
					case "Limit" :
					case "LimitB" :
					case "SafeString" :
					case "Filter" :
						if(!eval(this[_dataType]))	{
							this.AddError(i, getAttribute("msg"));
						}
						break;
					default :
						if(!this[_dataType].test(value)){
							this.AddError(i, getAttribute("msg"));
						}
						break;
				}
			}
		}
		if(this.ErrorMessage.length > 1){
			mode = mode || 1;
			var errCount = this.ErrorItem.length;
			switch(mode){
			case 2 :
				for(var i=1;i<errCount;i++)
					this.ErrorItem[i].style.color = "red";
			case 1 :
				alert(this.ErrorMessage.join("\n"));
				this.ErrorItem[1].focus();
				break;
			case 3 :
				for(var i=1;i<errCount;i++){
				try{
					var span = document.createElement("SPAN");
					span.id = "__ErrorMessagePanel";
					span.style.color = "red";
					this.ErrorItem[i].parentNode.appendChild(span);
					span.innerHTML = this.ErrorMessage[i].replace(/\d+:/,"*");
					}
					catch(e){alert(e.description);}
				}
				this.ErrorItem[1].focus();
				break;
			default :
				alert(this.ErrorMessage.join("\n"));
				break;
			}
			return false;
		}
		return true;
	},
	limit : function(len,min, max){
		min = min || 0;
		max = max || Number.MAX_VALUE;
		return min <= len && len <= max;
	},
	LenB : function(str){
		return str.replace(/[^\x00-\xff]/g,"**").length;
	},
	ClearState : function(elem){
		with(elem){
			if(style.color == "red")
				style.color = "";
			var lastNode = parentNode.childNodes[parentNode.childNodes.length-1];
			if(lastNode.id == "__ErrorMessagePanel")
				parentNode.removeChild(lastNode);
		}
	},
	AddError : function(index, str){
		this.ErrorItem[this.ErrorItem.length] = this.ErrorItem[0].elements[index];
		this.ErrorMessage[this.ErrorMessage.length] = this.ErrorMessage.length + ":" + str;
	},
	Exec : function(op, reg){
		return new RegExp(reg,"g").test(op);
	},
	compare : function(op1,operator,op2){
		switch (operator) {
			case "NotEqual":
				return (op1 != op2);
			case "GreaterThan":
				return (op1 > op2);
			case "GreaterThanEqual":
				return (op1 >= op2);
			case "LessThan":
				return (op1 < op2);
			case "LessThanEqual":
				return (op1 <= op2);
			default:
				return (op1 == op2);            
		}
	},
	MustChecked : function(name, min, max){
		var groups = document.getElementsByName(name);
		var hasChecked = 0;
		min = min || 1;
		max = max || groups.length;
		for(var i=groups.length-1;i>=0;i--)
			if(groups[i].checked) hasChecked++;
		return min <= hasChecked && hasChecked <= max;
	},
	DoFilter : function(input, filter){
return new RegExp("^.+\.(?=EXT)(EXT)$".replace(/EXT/g, filter.split(/\s*,\s*/).join("|")), "gi").test(input);
	},
	IsIdCard : function(number){
		var date, Ai;
		var verify = "10x98765432";
		var Wi = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
		var area = ['','','','','','','','','','','','北京','天津','河北','山西','内蒙古','','','','','','辽宁','吉林','黑龙江','','','','','','','','上海','江苏','浙江','安微','福建','江西','山东','','','','河南','湖北','湖南','广东','广西','海南','','','','重庆','四川','贵州','云南','西藏','','','','','','','陕西','甘肃','青海','宁夏','新疆','','','','','','台湾','','','','','','','','','','香港','澳门','','','','','','','','','国外'];
		var re = number.match(/^(\d{2})\d{4}(((\d{2})(\d{2})(\d{2})(\d{3}))|((\d{4})(\d{2})(\d{2})(\d{3}[x\d])))$/i);
		if(re == null) return false;
		if(re[1] >= area.length || area[re[1]] == "") return false;
		if(re[2].length == 12){
			Ai = number.substr(0, 17);
			date = [re[9], re[10], re[11]].join("-");
		}
		else{
			Ai = number.substr(0, 6) + "19" + number.substr(6);
			date = ["19" + re[4], re[5], re[6]].join("-");
		}
		if(!this.IsDate(date, "ymd")) return false;
		var sum = 0;
		for(var i = 0;i<=16;i++){
			sum += Ai.charAt(i) * Wi[i];
		}
		Ai +=  verify.charAt(sum%11);
		return (number.length ==15 || number.length == 18 && number == Ai);
	},
	IsDate : function(op, formatString){
		formatString = formatString || "ymd";
		var m, year, month, day;
		switch(formatString){
			case "ymd" :
				m = op.match(new RegExp("^((\\d{4})|(\\d{2}))([-./])(\\d{1,2})\\4(\\d{1,2})$"));
				if(m == null ) return false;
				day = m[6];
				month = m[5]*1;
				year =  (m[2].length == 4) ? m[2] : GetFullYear(parseInt(m[3], 10));
				break;
			case "dmy" :
				m = op.match(new RegExp("^(\\d{1,2})([-./])(\\d{1,2})\\2((\\d{4})|(\\d{2}))$"));
				if(m == null ) return false;
				day = m[1];
				month = m[3]*1;
				year = (m[5].length == 4) ? m[5] : GetFullYear(parseInt(m[6], 10));
				break;
			default :
				break;
		}
		if(!parseInt(month)) return false;
		month = month==0 ?12:month;
		var date = new Date(year, month-1, day);
        return (typeof(date) == "object" && year == date.getFullYear() && month == (date.getMonth()+1) && day == date.getDate());
		function GetFullYear(y){return ((y<30 ? "20" : "19") + y)|0;}
	}
 }

/***
*留言*
****/
var limitTime=null;

function quotecomment(oo){
	document.getElementById("comment_content").value=oo;
	document.getElementById("comment_content").focus();
}

function limitComment(){
	limitTime=limitTime-1;
	if(limitTime>0){
		document.getElementById("comment_content").value='还剩'+limitTime+'秒,你才可以再发表留言';
		document.getElementById("comment_content").disabled=true;
		document.getElementById("comment_submit").disabled=true;
		setTimeout("limitComment()",1000);
	}else if(limitTime==0){
		document.getElementById("comment_content").value='';
		document.getElementById("comment_content").disabled=false;
		document.getElementById("comment_submit").disabled=false;
	}
	
}
//旧版的需要用到
function postcomment(url,yzimgnum){
	var yzimgstr='';
	//if(yzimgnum=='1'){
	if(document.getElementById("yzImgNum")!=null){
		yzimgstr+="&yzimg="+ document.getElementById("yzImgNum").value;
	}
	if(document.getElementById("commentface")!=null){
		yzimgstr+="&commentface="+ document.getElementById("commentface").value;
	}
	username4 = document.getElementById("comment_username").value;
	content4 = document.getElementById("comment_content").value;
	if(content4==''){
		showerr("内容不能为空");
		return false;
	}
	content4=content4.replace(/(\n)/g,"@@br@@");
	//document.getElementById("comment_content").value='';
	//document.getElementById("comment_content").disabled=true;
	limitTime=10;
	limitComment();
	
	AJAX.get("comment",url + "&username=" + username4 + "&content=" + content4 + yzimgstr ,0);
	//if(yzimgnum=='1'){
	if(document.getElementById("yzImgNum")!=null){
		//document.getElementById("yz_Img").src;
		document.getElementById("yzImgNum").value='';
	}
}
function showerr(msg){
	alert(msg);
}
function getcomment(url){
	AJAX.get("comment",url,1);
}

function ShowMenu_mmc(){
}
function HideMenu_mmc(){
}

function get_position(o){//取得坐标
	var to=new Object();
	to.left=to.right=to.top=to.bottom=0;
	var twidth=o.offsetWidth;
	var theight=o.offsetHeight;
	while(o!=document.body){
		to.left+=o.offsetLeft;
		to.top+=o.offsetTop;
		o=o.offsetParent;
	}
	to.right=to.left+twidth;
	to.bottom=to.top+theight;
	return to;
}

/***
*在线操作*
****/
document.write('<div style="display:none;"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="AjaxEditTable"><tr><td class="head"><h3 class="L"></h3><h3 class="R"></h3><span class="eidtmodule" onclick="this.offsetParent.offsetParent.offsetParent.style.display=\'none\'" onMouseOver="this.style.cursor=\'hand\'">关闭</span></td></tr><tr> <td class="middle"></td></tr></table></div>');
var clickEdit={
	tableid:null,
	init:function(){
		oo=document.body.getElementsByTagName("A");
		for(var i=0;i<oo.length;i++){
			if(oo[i].getAttribute("editurl")!=null){
				if(oo[i].getAttribute("href")!=null)oo[i].href='javascript:';
				oo[i].title='点击可以修改这里的设置';
				if (document.all) { //For IE
					oo[i].attachEvent("onmousedown",clickEdit.showdiv);
					oo[i].attachEvent("onmouseover",clickEdit.showstyle);
					oo[i].attachEvent("onmouseout",clickEdit.hidestyle);
				}else{ //For Mozilla
					oo[i].addEventListener("onmousedown".substr(2,"onmousedown".length-2),clickEdit.showdiv,true);
				}
			}
		}
	},
	showstyle:function(evt){
		var evt = (evt) ? evt : ((window.event) ? window.event : "");
		if (evt) {
			 ao = (evt.target) ? evt.target : evt.srcElement;
		}
		ao.style.border='1px dotted red';
		ao.style.cursor='hand';
	},
	hidestyle:function(evt){
		var evt = (evt) ? evt : ((window.event) ? window.event : "");
		if (evt) {
			 ao = (evt.target) ? evt.target : evt.srcElement;
		}
		ao.style.border='0px dotted red';
	},
	showdiv:function(evt){
		var w=150;
		var h=100;
		var evt = (evt) ? evt : ((window.event) ? window.event : "");
		if (evt) {
			 ao = (evt.target) ? evt.target : evt.srcElement;
		}
		//oid=ao.offsetParent.offsetParent.id;
		//获取坐标的函数头部有定义
		position=get_position(ao);
		
		//alert(oid);
		url=ao.getAttribute("editurl");
		oid=url.replace(/(\.|=|\?|&|\\|\/|:)/g,"_");
		ao.id=oid;
		DivId="clickEdit_"+oid;
		url=url + "&TagId=" + oid;
		obj=document.getElementById(DivId);
		if(obj==null){
			obj=document.createElement("div");

			obj.innerHTML=document.getElementById('AjaxEditTable').outerHTML;
			objs=obj.getElementsByTagName("TD");
			objs[1].id=DivId;
			//obj.id=DivId;
			//obj.className="Editdiv";
			obj.style.Zindex='999';
			//obj.style.display='';
			obj.style.position='absolute';
			obj.style.top=position.bottom;
			obj.style.left=position.left;
			obj.style.height=h;
			obj.style.width=w;
			document.body.appendChild(obj);
			//obj.innerHTML='以下是显示内容...';
			AJAX.get(DivId,url,1);
		}else{
			fobj=obj.offsetParent.offsetParent;
			if(fobj.style.display=='none'){
				fobj.style.display='';
			}else{
				fobj.style.display='none';
			}
		}
	},
	save:function(oid,job,va){
		divid="clickEdit_"+oid;
		//alert(oid)
		//GET方式提交内容,如果有空格的话.会有BUG
		//即时显示,不过没判断是否保存成功也显示了
		document.getElementById(oid).innerHTML=va;
		va=va.replace(/(\n)/g,"@BR@");
		AJAX.get(divid,"ajax.php?inc="+job+"&step=2&TagId="+oid+"&va="+va,0);
	},
	cancel:function(divid){
		document.getElementById(divid).offsetParent.offsetParent.style.display='none';
	}
}

//显示子栏目
function showSonName(fid)
{
	oo=document.body.getElementsByTagName('DIV');
	for(var i=0;i<oo.length;i++){
		if(oo[i].className=='SonName'+fid){
			if(oo[i].style.display=='none'){
				oo[i].style.display='';
			}
			else
			{
				oo[i].style.display='none';
			}
		}
	}
}

function avoidgather(myname){
	fs=document.body.getElementsByTagName('P');
	for(var i=0;i<fs.length;i++){
		if(myname!=''&&fs[i].className.indexOf(myname)!=-1){
			fs[i].style.display='none';
		}
		
	}
	fs=document.body.getElementsByTagName('DIV');
	for(var i=0;i<fs.length;i++){
		if(myname!=''&&fs[i].className.indexOf(myname)!=-1){
			fs[i].style.display='none';
		}
	}
}

function dblclick_label(){
	if(/jobs=show$/.test(location.href)){
		a=confirm('你是否要退出标签管理');
		if (a){
			window.location.href=location.href+'abc';
		}
	}else{
		b=confirm('你是否要进入标签管理');
		if (b){
			url = location.href
			if (/\?/.test(url)){
				window.location.href=url+'&jobs=show';
			}else{
				window.location.href=url+'?jobs=show';
			}
		}
	}
}

function send_order_sms(url, type){
    if(document.getElementById('atc_order_mobphone').value==''){
        alert('请输入手机号码');
        document.getElementById('atc_order_mobphone').focus();
        return false;
    }
    $.get(url + "/do/job.php?job=regsendnum&num="+document.getElementById('atc_order_mobphone').value+"&type="+type);
    alert('已发送验证码，请查收');
}
function confirm_sms_code(url) {
    $.post(url + "/do/job.php?job=validatesms", {data: $('#yznum').val()}, function(data) {
        if (data =='success') {
            $('#atc_order_mobphone').attr('disabled','disabled');
            $('#send_validate_code').attr('disabled','disabled');
            $('.ok_marker').show();
            $('.fail_marker').hide();
            $('#validate_code_already').val('yes_right');
        } else {
            alert('验证码错误，无法通过验证');
        }
    });
}

function deliver_type(type, thisO) {
    if(thisO != null) {
        $('#send_type').val(thisO.nextSibling.nodeValue);
    } else {
        var txt = $("input[name='postdb[order_sendtype]']:checked")[0].nextSibling.nodeValue;
        $('#send_type').val(txt);
    }

    if (type == 1) {
        $('#deliver_total').html(0);
        $('#deliver_desc').val('');
        $('#price_content').val('');
    } else if (type == 2) {
        $('#deliver_total').html($('#slow_send').val());
        $('#deliver_desc').val($('#transfer_comment').val());
        $('#price_content').val($('#slow_send').val());
    } else if (type == 3) {
        $('#deliver_total').html($('#norm_send').val());
        $('#deliver_desc').val($('#transfer_comment').val());
        $('#price_content').val($('#norm_send').val());
    } else if (type == 4) {
        $('#deliver_total').html($('#ems_send').val());
        $('#deliver_desc').val($('#transfer_comment').val());
        $('#price_content').val($('#ems_send').val());
    } else if (type == 5) {
        $('#deliver_total').html($('#transfer_fee1').val());
        $('#deliver_desc').val($('#transfer_comment1').val());
        $('#price_content').val($('#transfer_fee1').val());
    } else if (type == 6) {
        $('#deliver_total').html($('#transfer_fee2').val());
        $('#deliver_desc').val($('#transfer_comment2').val());
        $('#price_content').val($('#transfer_fee2').val());
    } else if (type == 7) {
        $('#deliver_total').html($('#transfer_fee3').val());
        $('#deliver_desc').val($('#transfer_comment3').val());
        $('#price_content').val($('#transfer_fee3').val());
    }

    $('#deliverTotal').val($('#deliver_total').html());
    
//     var pro_total = parseInt($('#single_price').html()) * parseInt($('#shopnum').val());
//     pro_total += parseFloat($('#deliver_total').html());
//     $('#total_money').html(pro_total);
    countTotal();
}
function change_paytype(type) {
    if (type == 5) {
        jQuery("#ask_option").attr("checked", "checked");
        $('#online_pay').hide();
        $('#ask_before_pay').show();
    } else {
        $('#online_pay').show();
        $('#ask_before_pay').hide();
    }
}

 function end_order(id, url, is_seller) {
     $.post(url,
         {id:id, comment:$('#comment'+id).val(),job:'end',pwd:$('#pwd'+id).val(), is_seller:is_seller},
         function(data)
         {
             if (data =='phone') {alert('请验证手机');}
             if (data =='pwd') {alert('支付密码错误，请重新输入');}
             else {
                 if ($('#pwd'+id).val() == '') {
                     alert('请输入支付密码.');
                     return;
                 }
                 if ($('#comment'+id).val() == '') {
                     alert('请在简要备注处填写终止原因.');
                     return;
                 }
                 $('#status'+id).html("已终止");
             }
             }
     );
 }

 function withdraw(thisO,url,uid) {
     var balanceValue = parseInt($('#balanceValue').val());
     if(balanceValue == 0) {
         alert('余额为0，不能完成提现!');
         return;
     }
     var withdrawMoney = parseInt($('#withdraw_money').val());
     var withdrawPwd = $('#withdraw_pwd').val();

     if(withdrawMoney == "" || withdrawPwd == "") {
         alert('请输入提现金额和支付密码');
         return;
     }

     if(withdrawMoney > balanceValue) {
         alert('余额不足，交易金额最高为 '+ balanceValue + ' 元，请重新输入!');
         return;
     }

     var objTop = getOffsetTop(thisO);//对象x位置
     var objLeft = getOffsetLeft(thisO);//对象y位置
     $('#withdrawdiv').css('display', 'block');
     $('#withdrawdiv').css('left', objLeft-420);
     $('#withdrawdiv').css('top', objTop+20);

     $('#withdrawMoney').html(withdrawMoney);

     $.post(url, {job:'get_gutai_info',uid: uid}, function(data) {
         if (data != '') {
             var arr = data.split('|');
             $('#customName').html(arr[0]);
             $('#bankName').html(arr[1]);
             $('#withdrawAccount').html(arr[2]);
         }
     });

 }

 function withdrawYes(url) {
     $('#withdrawdiv').css('display', 'none');

     var withdrawMoney = $('#withdraw_money').val();
     var withdrawPwd = $('#withdraw_pwd').val();

     $.post(url, {job:'withdraw',money:withdrawMoney,pwd:withdrawPwd}, function(data) {
         if (data =='phone') {alert('请验证手机');}
         if (data =='pwd') {alert('支付密码错误，请重新输入');}
         else {
             alert(data);
         }
     });
 }

 function withdrawNo() {
     $('#withdrawdiv').css('display', 'none');
 }

 function charge(thisO) {
     var chargeMoney = $('#charge_money').val();
     var chargePwd = $('#charge_pwd').val();

     if(chargeMoney == "" || chargePwd == "") {
         alert('请输入充值金额和支付密码');
         return;
     }

     var objTop = getOffsetTop(thisO);//对象x位置
     var objLeft = getOffsetLeft(thisO);//对象y位置
     $('#chargediv').css('display', 'block');
     $('#chargediv').css('left', objLeft-420);
     $('#chargediv').css('top', objTop+20);

     $('#chargeMoney').html(chargeMoney);
 }

 function chargeYes(url) {
     $('#chargediv').css('display', 'none');

     var chargeMoney = $('#charge_money').val();
     var chargePwd = $('#charge_pwd').val();

     $.post(url, {job:'charge',price:chargeMoney,pwd:chargePwd}, function(data) {
         if (data =='phone') {alert('请验证手机');return;}
         if (data =='pwd') {alert('支付密码错误，请重新输入');return;}
         else {
             window.location.href = data;

         }
     });
 }

 function chargeNo() {
     $('#chargediv').css('display', 'none');
 }

 function pop_up() {
     $('#basic-modal-content').modal();
     return false;
 }

 function pay() {
     pop_up();

     $('#next_btn_step2').unbind('click');
     $('#next_btn_step2').hide();
     $('#next_btn_step2').text('请等待...');
     $('.waiting').show();
     $('#pay_form').submit();
 }

 function display_city_setting() {
     if($(".topList").is(":visible")==false){
         $('.topList').show();
     } else {
         $('.topList').hide();
     }
 }
 function download_file(url) {
     $.post(url + '/do/getfilename.php', {}, function(data) {
         window.open(url+'/upload_files/documents/' + data);
     });
 }
 function change_price(id) {
     if ($('#shopnum_'+id).val() > 0) {
         var single_total = parseInt($('#single_price_'+id).html()) * parseInt($('#shopnum_'+id).val());
         $('#total_product_price_'+id).html(single_total);
         countTotal();
     }
 }
function countTotal() {
    var pro_total = 0;
    pro_total += parseFloat($('#deliver_total').html());
    $('.table_bg').find('.total_product_price').each(function() {
        pro_total += parseFloat($(this).html());
    });

    $('#total_money').html(pro_total);
    $('#totalMoney').val(pro_total);
}
 function admin_confirm(id, url, jobStr) {
     $div_id = '#btnDdiv' + id;
     $.post(url, {job:jobStr,id:id}, function(data) {
         if (data =='succ') {
            $($div_id).html('已确认');
         }
     });
 }

 function confirm_pay_seller(url, id) {
    if(confirm('是否确认已付款到卖家账户？点击后不能修改')) {
        $.post(url, {job: 'pay_to_seller', id:id}, function(data) {
            if (data =='succ') {
                $('#oper'+id).html('完成');
            }
        });
    }
 }

 function openwindow(url,name,iWidth,iHeight)
 {
     var url;                             //转向网页的地址;
     var name;                            //网页名称，可为空;
     var iWidth;                          //弹出窗口的宽度;
     var iHeight;                         //弹出窗口的高度;
     //获得窗口的垂直位置
     var iTop = (window.screen.availHeight-30-iHeight)/2;
     //获得窗口的水平位置
     var iLeft = (window.screen.availWidth-10-iWidth)/2;
     window.open(url,name,'height='+iHeight+',,innerHeight='+iHeight+',width='+iWidth+',innerWidth='+iWidth+',top='+iTop+',left='+iLeft+',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no');
 }

 function saveUnitInfo(url) {
     var sendForm = $('#sendForm');
     var order_id = $('#orderId').val();
     var unit_name = $('#unit_name').val();
     var bill_num = $('#bill_number').val();
     if(order_id == null) {
         return;
     }

     if(unit_name == "" || bill_num == "") {
         alert('请输入物流信息');
         return;
     }
     $.post(url, sendForm.serialize(), function(data) {
         if (data =='succ') {
             var url = window.location.href;
             url = url.substring(0, url.indexOf('?'));
             window.location.href = url + "?job=send&id=" + order_id + "&ifsend=1";
         }
     });
 }

 function cancelUnitInfo() {
     $('#senddiv').css('display', 'none');
 }

 function sendBtnClick(event, thisO) {
     var order_id = $(thisO).attr('alt');

     $('#orderId').val(order_id);
     var objTop = getOffsetTop(thisO);//对象x位置
     var objLeft = getOffsetLeft(thisO);//对象y位置

     $('#senddiv').css('display', 'block');
     $('#senddiv').css('left', objLeft-250);
     $('#senddiv').css('top', objTop+20);
 }

 function getOffsetTop(obj){
     var tmp = obj.offsetTop;
     var val = obj.offsetParent;
     while(val != null){
         tmp += val.offsetTop;
         val = val.offsetParent;
     }
     return tmp;
 }
 function getOffsetLeft(obj){
     var tmp = obj.offsetLeft;
     var val = obj.offsetParent;
     while(val != null){
         tmp += val.offsetLeft;
         val = val.offsetParent;
     }
     return tmp;
 }

 function refundmentClick(thisO,url,uid, money,id) {
    $('#refundment_money').html(money);
     $('#order_id').val(id);

     var objTop = getOffsetTop(thisO);//对象x位置
     var objLeft = getOffsetLeft(thisO);//对象y位置
     $('#refundmentdiv').css('display', 'block');
     $('#refundmentdiv').css('left', objLeft-420);
     $('#refundmentdiv').css('top', objTop+20);

     $.post(url, {job:'get_gutai_info',uid: uid}, function(data) {
         if (data != '') {
             var arr = data.split('|');
             $('#custom_name').html(arr[0]);
             $('#bank_name').html(arr[1]);
             $('#account').html(arr[2]);
         }
     });
 }

 function refundmentYes(url) {
     $.post(url, {job:'refundment_yes',id: $('#order_id').val()}, function(data) {
         if (data == 'succ') {
             $('#refundmentdiv').css('display', 'none');
         }
     });
 }

 function selectTab(id) {
     $("#tab_area span").each(function(){
         $(this).removeAttr('class');
     });

     if(id == '充值') {
         $('#tab2').addClass('current_tab');
     } else if(id == '提现') {
         $('#tab1').addClass('current_tab');
     } else {
         $('#tab3').addClass('current_tab');
     }
 }

 function refundmentNo() {
     $('#refundmentdiv').css('display', 'none');
 }

 function apply_after_service(thisO, id) {
     $('#orderId').val(id);

     var objTop = getOffsetTop(thisO);//对象x位置
     var objLeft = getOffsetLeft(thisO);//对象y位置
     $('#get_shouhou_popup').css('display', 'block');
     $('#get_shouhou_popup').css('left', objLeft-420);
     $('#get_shouhou_popup').css('top', objTop+20);
 }

 function applyYes() {
     var id = $('#orderId').val();
     window.location.href = '?job=after_service&id='+ id + '&ifservice=1';
 }

 function applyNo() {
     $('#get_shouhou_popup').css('display', 'none');
 }

 function search_order() {
     var search_con = $('#searchArea').val();
     if(search_con == '') {
         alert('请输入查询内容!');
         return;
     }
     window.location.href = '?job=search&con='+ search_con;
 }

 $(document).ready(function() {
     countTotal();

     $('.show_order_popup_btn').click(function(){
         var imgsrc = $('.show_order_popup_btn').attr('src');
         if(imgsrc.indexOf('down_arrow') != -1){
             imgsrc = imgsrc.replace('down_arrow', 'up_arrow');
         }
         else
             imgsrc = imgsrc.replace('up_arrow', 'down_arrow');

         $('.show_order_popup_btn').attr('src', imgsrc);
         $('.order_popup').toggle();
     });
 });