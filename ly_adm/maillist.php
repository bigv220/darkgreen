<?php
!function_exists('html') && exit('ERR');
if($action=="update")
{
	$db->query("UPDATE {$pre}maillist SET isopen=$isopen WHERE id='$id'");
	jump("更新成功","index.php?lfj=maillist&id=$mailid&job=list",2);
}
elseif($job=="list"&&$Apower[alonepage_list])
{
	!$page && $page=1;
	$rows=15;
	$min=($page-1)*$rows;
	$showpage=getpage("`{$pre}maillist`","where mailuserid=$id","index.php?lfj=maillist&id=$id&job=list",$rows);
	$query=$db->query("SELECT * FROM `{$pre}maillist` where mailuserid=$id ORDER BY id DESC LIMIT $min,$rows");
	while($rs=$db->fetch_array($query)){
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/maillist/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="delete"&&$Apower[alonepage_list])
{
	$rs=$db->get_one("SELECT * FROM `{$pre}maillist` WHERE id='$id'");
	unlink(ROOT_PATH.$rs[filename]);
	$db->query("DELETE FROM `{$pre}maillist` WHERE id='$id'");
	jump("删除成功","index.php?lfj=maillist&id=$mailid&job=list",2);
}