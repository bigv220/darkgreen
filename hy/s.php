<?php
require(dirname(__FILE__)."/"."global.php");

$GuideFid[$fid]=" > 内容搜索";

if($action=="search")
{
	if(!$webdb[Info_allowGuesSearch]&&!$lfjid)
	{
		//showerr("请先登录");
	}
	
	$keyword=trim($keyword);
	$keyword=str_replace("%",'\%',$keyword);
	$keyword=str_replace("_",'\_',$keyword);

	if(!$keyword)
	{
		showerr("关键字不能为空");
	}
	
	/*每页显示50条*/
	$rows=48;
	if(!$page)
	{
		$page=1;
	}
	$min=($page-1)*$rows;

	$_SQL=" WHERE title LIKE '%$keyword%' ";

	$showpage=getpage("{$_pre}company A",$_SQL,"?fid=$fid&keyword=$keyword&action=search&type=$type",$rows);

	$query = $db->query("SELECT * FROM {$_pre}company A $_SQL ORDER BY A.posttime DESC LIMIT $min,$rows ");
	while($rs = $db->fetch_array($query))
	{
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);
		$rs[content]=get_word($rs[content],150);
		$listdb[]=$rs;
	}

	if(!$listdb)
	{
		showerr("抱歉, 没有您查询的内容");
	}
	$typedb[$type]=" checked ";
}

else
{
	$typedb[title]=" checked ";
}

$mid=intval($mid);

$colordb[$mid]="red;";
if($mid){
	require(getTpl("search_$mid"));
}else{
	require(getTpl("search"));
}
?>