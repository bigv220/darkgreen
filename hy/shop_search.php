<?php
require(dirname(__FILE__)."/"."global.php");

$GuideFid[$fid]=" > ��������";

if($action=="search")
{
	if(!$webdb[Info_allowGuesSearch]&&!$lfjid)
	{
		showerr("���ȵ�¼");
	}
	
	$keyword=trim($keyword);
	$keyword=str_replace("%",'\%',$keyword);
	$keyword=str_replace("_",'\_',$keyword);
	$street_id=$_POST[street_id];
	if($street_id==''){$street_id=0;}

	if(!$keyword)
	{
		showerr("�ؼ��ֲ���Ϊ��");
	}
	
	/*ÿҳ��ʾ50��*/
	$rows=50;
	if(!$page)
	{
		$page=1;
	}
	$min=($page-1)*$rows;

	$_SQL=" WHERE title LIKE '%$keyword%' AND street_id='$street_id' ";

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
		showerr("��Ǹ, û������ѯ������");
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