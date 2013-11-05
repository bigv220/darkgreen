<?php
!function_exists('html') && exit('ERR');
if($action=="update")
{
	$db->query("UPDATE {$pre}mailuser SET isopen=$isopen WHERE id='$id'");
	jump("更新成功","index.php?lfj=mail&job=list",2);
}
elseif($job=="list"&&$Apower[alonepage_list])
{
	!$page && $page=1;
	$rows=15;
	$min=($page-1)*$rows;
	$showpage=getpage("`{$pre}mailuser`","","index.php?lfj=mail&job=list",$rows);
	$query=$db->query("SELECT * FROM `{$pre}mailuser` ORDER BY id DESC LIMIT $min,$rows");
	while($rs=$db->fetch_array($query)){
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/mail/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="delete"&&$Apower[alonepage_list])
{
	$rs=$db->get_one("SELECT * FROM `{$pre}mailuser` WHERE id='$id'");
	unlink(ROOT_PATH.$rs[filename]);
	$db->query("DELETE FROM `{$pre}mailuser` WHERE id='$id'");
	jump("删除成功","index.php?lfj=mail&job=list",2);
}