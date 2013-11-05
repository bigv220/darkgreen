<?php
require(dirname(__FILE__)."/"."global.php");

if(!$lfjuid){
	showerr("ÇëÏÈµÇÂ¼");
}

if($act=='del'){
	$db->query("DELETE FROM {$pre}mailuser WHERE memberid='$lfjid' AND id='$id'");
}


$rows=20;
if(!$page){
	$page=1;
}
$min=($page-1)*$rows;
$showpage=getpage("{$pre}mailuser","WHERE memberid='$lfjid'","?job=$list",20);
$query = $db->query("SELECT * FROM `{$pre}mailuser` WHERE memberid='$lfjid' ORDER BY id DESC LIMIT $min,$rows");
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
require(dirname(__FILE__)."/"."template/emaillist.htm");
require(dirname(__FILE__)."/"."foot.php");
 
?>