<?php
require("global.php");
if (isset($_POST['Priv1'])) {
    global $pay_code;
    $banktype = "chinapay";
    $_POST['pay_code'] = $paycode = trim($_POST['Priv1']);
}
$pay_code = $_POST['pay_code']==null?$_GET['pay_code']:$_POST['pay_code'];
if($pay_code){	//POST��API����ʱ
	$pay_code = str_replace('QIBO','=',$pay_code);	//������š�=�����׳�����
	$_POST['pay_code'] = $pay_code;
	list(,$id,$fid)=explode("\t",mymd5($pay_code,'DE'));
}

//��ȡ������Ϣ

$infodb = $db->get_one("SELECT A.id,A.title,A.price,A.posttime,A.uid,B.totalmoney,B.ifpay,B.fid,B.cid FROM `{$_pre}join` B LEFT JOIN `{$_pre}content` A ON A.id=B.cid WHERE B.id='$id'");

if(!$infodb){
	showerr('����������!');
}elseif($infodb[fid]!=$fid){
	showerr('FID����!');
}elseif($infodb[ifpay]){
	showerr('�˶����Ѿ�֧������!');
}

$rs = $db->get_one("SELECT * FROM `{$pre}purse` WHERE uid='$infodb[uid]'");
$array = unserialize($rs[config]);

//�ױ�֧��
$webdb[chinapay_id] = $array[yeepay_id];
$webdb[chinapay_key] = $array[yeepay_key];

//�Ƹ�ͨ
$webdb[tenpay_id] = $array[tenpay_id];
$webdb[tenpay_key] = $array[tenpay_key];

//֧����
$webdb[alipay_id] = $array[alipay_id];
$webdb[alipay_key] = $array[alipay_key];
$webdb[alipay_partner] = $array[alipay_partner];
$webdb[alipay_service] = $array[alipay_service];
$webdb[alipay_transport] = $array[alipay_transport];

//��Ǯ
$webdb[pay99_id] = $array[pay99_id];
$webdb[pay99_key] = $array[pay99_key];


if(in_array($banktype,array('alipay','tenpay','99pay','yeepay','chinapay'))){	//POST��API����ʱ
//    $webdb[alipay_id] = 'emily1973@yahoo.cn';
//    $webdb[alipay_key] = '70em2m6czryqufcji4iyqfmhu7pyb6b3';
//    $webdb[alipay_partner] = '2088002621665853';
//    $webdb[alipay_service] = 'create_direct_pay_by_user';
//    $webdb[alipay_transport] = 'http';
	include(ROOT_PATH."inc/olpay/{$banktype}.php");
	exit;
}

//$infodb[totalmoney]=number_format($infodb[totalmoney],2);


$pay_code = mymd5("$infodb[totalmoney]\t$id\t$fid");


if(!$array[yeepay_id]&&!$array[tenpay_id]&&!$array[alipay_id]&&!$array[pay99_id]) {
    $array[yeepay_id] = "808080231803147";
    $array[alipay_id] = 'emily1973@yahoo.cn';
    $order_id = date('ymdhs');

    require(ROOT_PATH."inc/head_gutai.php");
    if ($lfjdb) {
        $uid = $lfjdb[uid];
    } else {
        header("Location:login.php");
    }
    $userdb=$db->get_one("SELECT gutai FROM {$pre}memberdata WHERE uid='$uid'");

    require(getTpl("gutai_shoudai"));
    require(ROOT_PATH."inc/footer_gutai.php");
} else {
    require(ROOT_PATH."inc/head.php");
    require(getTpl("olpay"));
    require(ROOT_PATH."inc/foot.php");
}


function olpay_send(){
	global $db,$pre,$webdb,$banktype,$infodb,$timestamp,$lfjuid,$lfjid,$pay_code,$Murl;

	if(!$pay_code){
		showerr("��������!");
	}
	list($atc_moeny,$id)=explode("\t",mymd5($pay_code,'DE'));
	
	if($atc_moeny<0.01){
		showerr("�ܶ��С��1��Ǯ!");
	}
	
	$numcode=$id;
	while(strlen($numcode)<10){
		$numcode="0$numcode";
	}

	$array[money]=$atc_moeny;
	$pay_code = str_replace('=','QIBO',$pay_code);	//������š�=�����׳�����

    if ($banktype =='chinapay') {
        $array[return_url]="$Murl/olpay.php";
    } else {
        $array[return_url]="$Murl/olpay.php?banktype=$banktype&pay_code=$pay_code&";
    }

    $array['priv1'] = $pay_code;
    $array['priv2'] = "pay_code=$pay_code";
	$array[title]="����:$infodb[title]";
	$array[content]="����:$infodb[title]";
	$array[numcode]=$numcode;
	return $array;
}

function olpay_end($numcode){
	global $db,$_pre,$webdb,$banktype,$pay_code,$lfjuid,$infodb;
	$pay_code = $_POST['pay_code'];
	if(!$pay_code){
		showerr("��������!!");
	}
	
	list($atc_moeny,$id,$fid)=explode("\t",mymd5($pay_code,'DE'));

	$db->query("UPDATE {$_pre}join SET ifpay='1',banktype='$banktype' WHERE id='$id'");

	refreshto("bencandy.php?city_id=$infodb[city_id]&fid=$fid&id=$infodb[cid]","��ϲ�㶩������ɹ�!",60);
}

?>