<?php
require("global.php");

if($pay_code){	//POST与API返回时
	$pay_code = str_replace('QIBO','=',$pay_code);	//这个符号“=”容易出问题
	list(,$id,$fid)=explode("\t",mymd5($pay_code,'DE'));
}

//获取订单信息
if ($_GET['type'] =='charge') {
    $infodb[id] = $id;
    $infodb[order_amount] = $_GET[price];
    $infodb[uid] = $lfjdb[uid];
    $infodb[totalmoney] = $_GET[price];
} else {
if ($_GET[fid] ==0) {
    $infodb = $db->get_one("SELECT B.id,B.posttime,B.uid,B.totalmoney as price,B.totalmoney,B.ifpay,B.fid,B.cid FROM `{$_pre}join` B WHERE B.id='$id'");
} else {
    $infodb = $db->get_one("SELECT A.id,A.title,A.price,B.posttime,A.uid,B.totalmoney,B.ifpay,B.fid,B.cid FROM `{$_pre}join` B LEFT JOIN `{$_pre}content` A ON A.id=B.cid WHERE B.id='$id'");
}

if(!$infodb){
	showerr('订单不存在!');
}elseif($infodb[fid]!=$fid){
	showerr('FID有误!');
}elseif($infodb[ifpay]){
	showerr('此订单已经支付过了!');
}
}

$rs = $db->get_one("SELECT * FROM `{$pre}purse` WHERE uid='$infodb[uid]'");
$array = unserialize($rs[config]);
$array[yeepay_id] = "808080231803147";
if(!$array[yeepay_id]&&!$array[tenpay_id]&&!$array[alipay_id]&&!$array[pay99_id]){
	refreshto("bencandy.php?city_id=$infodb[city_id]&fid=$fid&id=$infodb[cid]","在线支付失败,商户没有设置网银帐号!",10);
}
$account_order_link = "$Murl/../shop/gutai_pay.php?job=mylist";
//易宝支付
$webdb[chinapay_id] = $array[yeepay_id];
$webdb[chinapay_key] = $array[yeepay_key];

//财付通
$webdb[tenpay_id] = $array[tenpay_id];
$webdb[tenpay_key] = $array[tenpay_key];

//支付宝
$webdb[alipay_id] = $array[alipay_id];
$webdb[alipay_key] = $array[alipay_key];
$webdb[alipay_partner] = $array[alipay_partner];
$webdb[alipay_service] = $array[alipay_service];
$webdb[alipay_transport] = $array[alipay_transport];

//快钱
$webdb[pay99_id] = $array[pay99_id];
$webdb[pay99_key] = $array[pay99_key];


if(in_array($banktype,array('alipay','tenpay','99pay','yeepay','chinapay'))){	//POST与API返回时
	include(ROOT_PATH."inc/olpay/{$banktype}.php");
	exit;
}

//$infodb[totalmoney]=number_format($infodb[totalmoney],2);


$pay_code = mymd5("$infodb[totalmoney]\t$id\t$fid");


require(ROOT_PATH."inc/head_gutai.php");
if ($lfjdb) {
    $uid = $lfjdb[uid];
} else {
    header("Location:login.php");
}
$userdb=$db->get_one("SELECT gutai FROM {$pre}memberdata WHERE uid='$uid'");

require(getTpl("gutai_shoudai"));
require(ROOT_PATH."inc/footer_gutai.php");


function olpay_send(){
	global $db,$pre,$webdb,$banktype,$infodb,$timestamp,$lfjuid,$lfjid,$pay_code,$Murl;

	if(!$pay_code){
		showerr("数据有误!");
	}
	list($atc_moeny,$id)=explode("\t",mymd5($pay_code,'DE'));
	
	if($atc_moeny<0.01){
		showerr("总额不能小于1分钱!");
	}
	
	$numcode=$id;
	while(strlen($numcode)<10){
		$numcode="0$numcode";
	}

	$array[money]=$atc_moeny;
	$pay_code = str_replace('=','QIBO',$pay_code);	//这个符号“=”容易出问题

    if ($banktype =='chinapay') {
        $array[return_url]="$Murl/olpay.php";
    } else {
        $array[return_url]="$Murl/olpay.php?banktype=$banktype&pay_code=$pay_code&";
    }

    $array['priv1'] = $pay_code;
    $array['priv2'] = "pay_code=$pay_code";
	$array[title]="购买:$infodb[title]";
	$array[content]="购买:$infodb[title]";
	$array[numcode]=$numcode;
	return $array;
}

function olpay_end($numcode){
	global $db,$_pre,$webdb,$banktype,$pay_code,$lfjuid,$infodb;

	if(!$pay_code){
		showerr("数据有误!!");
	}
	
	list($atc_moeny,$id,$fid)=explode("\t",mymd5($pay_code,'DE'));

	$db->query("UPDATE {$_pre}join SET ifpay='1',banktype='$banktype' WHERE id='$id'");

	refreshto("bencandy.php?city_id=$infodb[city_id]&fid=$fid&id=$infodb[cid]","恭喜你订单付款成功!",60);
}

?>