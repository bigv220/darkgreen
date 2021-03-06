<?php
require(dirname(__FILE__)."/global.php");
$fidDB=$db->get_one("SELECT A.* FROM {$_pre}sort A WHERE A.fid='$fid'");
if(!$fidDB){
	showerr("栏目不存在");
}elseif($fidDB[jumpurl]){
	header("location:$fidDB[jumpurl]");
	exit;
}
$fidDB['mid'] = 1;
if($page<1){
	$page=1;
}
$rows=24;
$min=($page-1)*$rows;
if(!in_array($ordertype,array('hits','id','levelstime'))){
	$ordertype='id';
}
if($ordertype=='levelstime'){
	$SQL=" WHERE A.levels=1 ";
}else{
	$SQL = " WHERE A.fid='$fid' $SQL ";
}


$query = $db->query("SELECT SQL_CALC_FOUND_ROWS B.*,A.*,C.title AS companyname,C.renzheng  FROM {$_pre}content A LEFT JOIN {$_pre}content_{$fidDB[mid]} B ON A.id=B.id LEFT JOIN {$pre}hy_company C ON A.uid=C.uid $SQL GROUP BY A.id  ORDER BY A.$ordertype DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];
while($rs = $db->fetch_array($query)){
	$rs[picurl]=tempdir($rs[picurl]);
	$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$listdb[]=$rs;
}


$showpage=getpage("","","listall.php?fid=$fid&ordertype=$ordertype",$rows,$totalNum);
$showpage2=getpage("","","listall.php?fid=$fid&style=1&ordertype=$ordertype",$rows,$totalNum);
/**
*为获取标签参数
**/
$chdb[main_tpl]=getTpl("listall");
//列表页个性头部与尾部
$head_tpl=html('head');
$foot_tpl=html('foot');
if($webdb[IF_Private_tpl]==2||$webdb[IF_Private_tpl]==3){
	if(is_file(Mpath.$webdb[Private_tpl_head])){
		$head_tpl=Mpath.$webdb[Private_tpl_head];
	}
	if(is_file(Mpath.$webdb[Private_tpl_foot])){
		$foot_tpl=Mpath.$webdb[Private_tpl_foot];
	}
}
/**
*标签
**/
$ch_fid	= 0;										//是否定义了栏目专用标签
$ch_pagetype = 4;									//2,为list页,3,为bencandy页
$ch_module = $webdb[module_id]?$webdb[module_id]:99;//系统特定ID参数,每个系统不能雷同
$ch = 0;											//不属于任何专题
require(ROOT_PATH."inc/label_module.php");

require(ROOT_PATH."inc/head.php");
require(getTpl("listall"));
require(ROOT_PATH."inc/foot.php");

?>