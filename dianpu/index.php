<?php

require(dirname(__FILE__)."/"."global.php");
if($page<1){
	$page=1;
}
$rows=10;
$min=($page-1)*$rows;
if(!in_array($ordertype,array('hits','rid','levelstime'))){
	$ordertype='rid';
}
if($ordertype=='levelstime'){
	$SQL=" AND levels=1 ";
}else{
	$SQL=" ";
}
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$_pre}company WHERE city_id='$city_id' $SQL ORDER BY $ordertype DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];
while($rs = $db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$rs[picurl]=tempdir($rs[picurl]);
	$listdb[]=$rs;
}
$showpage=getpage("","","listall.php?ordertype=$ordertype",$rows,$totalNum);
//SEO
$titleDB['title'] = "{$city_DB[name][$city_id]} $webdb[Info_webname]";
$titleDB['keywords']	= "{$city_DB[name][$city_id]} $webdb[metakeywords]";

//主页个性头部与尾部
$head_tpl=html('head');
$foot_tpl=html('foot');
if($webdb[IF_Private_tpl]){
	if(is_file(Mpath.$webdb[Private_tpl_head])){
		$head_tpl=Mpath.$webdb[Private_tpl_head];
	}
	if(is_file(Mpath.$webdb[Private_tpl_foot])){
		$foot_tpl=Mpath.$webdb[Private_tpl_foot];
	}
}

/**
*标签使用
**/
$ch_fid	= $ch_pagetype = 0;
$ch_module = $webdb[module_id]?$webdb[module_id]:99;	//系统特定ID参数,每个系统不能雷同
require(ROOT_PATH."inc/label_module.php");


require(ROOT_PATH."inc/head.php");
require(getTpl('index'));
require(ROOT_PATH."inc/foot.php");

?>