<?php
require_once(dirname(__FILE__)."/../inc/common.inc.php");
require(dirname(__FILE__)."/global.php");
@include(dirname(__FILE__)."/data/guide_fid.php");

/**
*获取栏目与模块的配置文件
**/
$fidDB=$db->get_one("SELECT A.* FROM {$_pre}sort A WHERE A.fid='$fid'");
$lmid=$_GET['lmid'];
/**
*跳转到外部地址
**/
if($fidDB[jumpurl])
{
	header("location:$fidDB[jumpurl]");
	exit;
}

$fidDB[descrip]=En_TruePath($fidDB[descrip],0);


//SEO
$titleDB[title]		= filtrate("$fidDB[name] - $webdb[Info_webname] - $titleDB[title]");
$titleDB[keywords]	= $titleDB[description] = filtrate("$webdb[Info_webname] - $webdb[Info_metakeywords] - $titleDB[title] - $titleDB[keywords]");


//栏目风格
$fidDB[style] && $STYLE=$fidDB[style];


/**
*模板
**/
$FidTpl=unserialize($fidDB[template]);
$head_tpl=$FidTpl['head'];
$foot_tpl=$FidTpl['foot'];

$_url="list.php?fid=$fid&lmid=$lmid";

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
*为获取标签参数
**/
if($fidDB[type]){
	$chdb[main_tpl]=getTpl("list",$FidTpl['list']);
}else{
	$chdb[main_tpl]=getTpl("list",$FidTpl['list']);
}
/**
*标签
**/
$ch_fid	= intval($fidDB[config][label_list]);		//是否定义了栏目专用标签
$ch_pagetype = 2;									//2,为list页,3,为bencandy页
$ch_module = $webdb[module_id];						//系统特定ID参数,每个系统不能雷同
$ch = 0;											//不属于任何专题
require(ROOT_PATH."inc/label_module.php");

if($spid)
{
	$SQL=" AND A.spid='$spid' AND A.lmid=$lmid ";
}
elseif($lmid)
{
	$SQL=" AND A.lmid=$lmid ";
}else{
$SQL=" ";
}

if($cityID)
{
	$SQL=" AND A.cityid='$cityID' AND A.lmid=$lmid ";
}
elseif($provinceID)
{
	$SQL=" AND A.provinceid='$provinceID' AND A.lmid=$lmid ";
}

$Lrows=$fidDB[maxperpage]>0?$fidDB[maxperpage]:($webdb[Infolist_row]>0?$webdb[Infolist_row]:20);
if($fidDB[type]==0)
{
	@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}content A WHERE A.fid=$fid AND A.yz=1 $SQL"));
}
/*大分类*/
if($fidDB[type]==1)
{
	$listdb=ListThisSort2($Lrows,$webdb[InfoListLeng]>0?$webdb[InfoListLeng]:70);
	$showpage=getpage("{$_pre}content A","WHERE A.fid in($fid".GetAllSonFid($fid).") AND A.yz=1 $SQL",$_url,$Lrows,$NUM);
}

/*小分类*/
if($fidDB[type]==0)
{	
	$listdb=ListThisSort($Lrows,$webdb[InfoListLeng]>0?$webdb[InfoListLeng]:70);
	$showpage=getpage("{$_pre}content A","WHERE A.fid=$fid AND A.yz=1 $SQL",$_url,$Lrows,$NUM);	
}


require(ROOT_PATH."inc/head.php");

if($fidDB[type]){
	require(getTpl("sell",$FidTpl['sell']));
}else{
	require(getTpl("sell",$FidTpl['sell']));
}
require(ROOT_PATH."inc/foot.php");

?>