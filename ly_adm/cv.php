<?php
!function_exists('html') && exit('ERR');
if($job=="edit"&&$Apower[alonepage_list])
{
	$rsdb=$db->get_one("SELECT * FROM `{$pre}cv` WHERE id='$id'");
	$rsdb[content]=En_TruePath($rsdb[content],0);
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/cv/edit.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="list"&&$Apower[alonepage_list])
{
	!$page && $page=1;
	$rows=10;
	$min=($page-1)*$rows;
	$showpage=getpage("`{$pre}cv`","","index.php?lfj=cv&job=list",$rows);
	$query=$db->query("SELECT * FROM `{$pre}cv` ORDER BY id DESC LIMIT $min,$rows");
	while($rs=$db->fetch_array($query)){
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/cv/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="delete"&&$Apower[alonepage_list])
{
	$rs=$db->get_one("SELECT * FROM `{$pre}cv` WHERE id='$id'");
	unlink(ROOT_PATH.$rs[filename]);
	$db->query("DELETE FROM `{$pre}cv` WHERE id='$id'");
	jump("É¾³ý³É¹¦","index.php?lfj=cv&job=list",2);
}