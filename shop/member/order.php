<?php
require_once("global.php");


if($action=='del'){
	del_order($id);
	refreshto($FROMURL,'',0);
	
}elseif($job=='pay'||$job=='send'||$job=='del'){
	$rsdb=$db->get_one("SELECT * FROM {$_pre}join WHERE id='$id'");
	if($rsdb[cuid]!=$lfjuid){
		showerr("你没权限!");
	}
	if($job=='pay'){
		$db->query("UPDATE {$_pre}join SET ifpay='$ifpay' WHERE id='$id'");
	}elseif($job=='send'){
		$db->query("UPDATE {$_pre}join SET ifsend='$ifsend' WHERE id='$id'");
	}
}elseif($job=='edit'){
	$rsdb=$db->get_one("SELECT * FROM {$_pre}join WHERE id='$id'");
	if($rsdb[cuid]!=$lfjuid){
		showerr("你没权限!");
	}
	if($step==2){
		$totalmoney = filtrate($totalmoney);
		$emscode = filtrate($emscode);
		$db->query("UPDATE {$_pre}join SET totalmoney='$totalmoney',emscode='$emscode' WHERE id='$id'");
		refreshto('?job=list','修改成功',1);
	}
	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/"."template/order_edit.htm");
	require(ROOT_PATH."member/foot.php");
	exit;
} elseif($action == 'saveProtocolText') {
    $order_id = $_POST['order_id'];
    $protocol_text = $_POST['protocol_text'];

    $db->query("UPDATE {$_pre}join SET sellertext='" . addslashes($protocol_text) . "' WHERE id=$order_id");
} elseif($action == 'saveSendInfo') {
    $order_id = $_POST['orderId'];
    $unit_name = iconv("UTF-8","GB2312",$_POST['unit_name']);
    $bill_number = $_POST['bill_number'];
    $other = $_POST['other'];

    $db->query("REPLACE INTO home_order_unit_info values($order_id,'".$unit_name."','".$bill_number."','".$other."')");
    echo "succ";
    exit;
}

$rows=15;

if(!$page){
	$page=1;
}
$min=($page-1)*$rows;


unset($listdb,$i);

if($job=='mylist'){
	$SQL=" A.uid='$lfjuid' ";
}else{
	$SQL=" A.cuid='$lfjuid' ";
}

$query = $db->query("SELECT SQL_CALC_FOUND_ROWS A.*,B.* FROM {$_pre}join A LEFT JOIN {$_pre}content_2 B ON A.id=B.id WHERE $SQL ORDER BY A.id DESC LIMIT $min,$rows");

$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];
$showpage=getpage("","","?job=$job",$rows,$totalNum);

while($rs = $db->fetch_array($query))
{
	$rs[shop]=$db->get_one("SELECT * FROM {$_pre}content WHERE id='$rs[cid]'");
    $rs[shop][sellertext] = stripslashes($rs[shop][sellertext]);
	$rs[posttime]=date("m-d H:i",$rs[posttime]);
	if($job=='mylist'){	//我的订单
		$rs[editurl]="../join.php?job=edit&id=$rs[id]&fid=$rs[fid]&cid=$rs[cid]' target='_blank";
		if($rs[ifpay]){
			$rs[pay]="<A style='color:red;'>已付</A>";
		}elseif($rs[totalmoney]){
			$rs[pay]="<A HREF='../olpay.php?id=$rs[id]&fid=$rs[fid]' target='_blank'><u>付款</u></A>";
		}else{
			$rs[pay]='';
		}
		$rs[send]=$rs[ifsend]?"<A style='color:red;'>已发</A>":"未发";
	}else{	//客户订单
		$rs[pay]=$rs[ifpay]?"<A HREF='?job=pay&id=$rs[id]&ifpay=0' style='color:red;'>已付</A>":"<A HREF='?job=pay&id=$rs[id]&ifpay=1' style='color:#333333;'>未付</A>";
		$rs[send]=$rs[ifsend]?"<A HREF='?job=send&id=$rs[id]&ifsend=0' style='color:red;'>已发</A>":"<A HREF='javascript:void(0)' onclick='sendBtnClick(event,this)' alt='".$rs[id]."' style='color:#333333;'>未发</A>";
		$rs[editurl]="?job=edit&id=$rs[id]";
	}

    if(empty($rs[deliver_total])) {
        $rs[deliver_total] = 0;
    }

    $rs[all_total] = number_format(($rs[deliver_total] + $rs[totalmoney]),2);
	$listdb[]=$rs;
}

require(ROOT_PATH."member/head.php");
require(dirname(__FILE__)."/"."template/order.htm");
require(ROOT_PATH."member/foot.php");
?>