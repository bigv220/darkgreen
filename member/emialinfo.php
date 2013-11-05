<?php
require(dirname(__FILE__)."/"."global.php");

if(!$lfjuid){
	showerr("请先登录");
}

if($act=='del'){
	$db->query("DELETE FROM {$pre}maillist WHERE id='$id'");
	refreshto("$FROMURL","删除成功",1);
}
if($act=='add'){
	$addtime=date("Y-m-d H:i:s");
	$mailnum=$db->get_one("SELECT mailnum FROM {$pre}mailuser WHERE id='$mailuserid'");
	$mailnum2=$db->get_one("SELECT COUNT(*) AS NUM FROM {$pre}maillist WHERE mailuserid='$mailuserid'");
	
   if($mailnum2[NUM]<$mailnum[mailnum]){
	
	
	
	
	$db->query("INSERT INTO {$pre}maillist SET mailuserid='$mailuserid', userid='$userid', userpass='$userpass', remark='$remark', addtime='$addtime', isopen='0' ");
	refreshto("$FROMURL","添加成功",1);
   }else{
	   refreshto("$FROMURL","添加失败,已达用户上限！",1);
	   }
	
}

$rows=20;
if(!$page){
	$page=1;
}
$min=($page-1)*$rows;
$showpage=getpage("{$pre}maillist","WHERE mailuserid='$id'","?job=list&id=$id",20);
$query = $db->query("SELECT * FROM `{$pre}maillist` WHERE mailuserid='$id' ORDER BY id DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query)){
	$rs[title] = get_word($rs[about],250);
	if($rs[money]>0){
		$rs[money]="<font color=red>$rs[money]</font>";
	}
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$listdb[]=$rs;
}

$lfjdb[money]=get_money($lfjuid);
require(dirname(__FILE__)."/"."head.php");
require(dirname(__FILE__)."/"."template/emailinfo.htm");
require(dirname(__FILE__)."/"."foot.php");
 
?>