<?php
require_once(dirname(__FILE__)."/"."global.php");

if(!$lfjid){
	header("Location:".$webdb[www_url]."/do/login.php");
}



//echo $lfjdb[grouptype]; //1是企业用户

if($_GET["menutype"] == 9){
	$lfjdb[menutype] = 9;
}
else{
	$lfjdb[menutype] = $lfjdb[grouptype];
}

//echo $lfjdb[menutype]; //0 个人 1企业普通班 9 企业应用版

if($web_admin){
	$power=3;
}else{
	$power=1;
}

//if( $db->get_one("SELECT fid FROM {$pre}sort WHERE BINARY admin LIKE '%$lfjid%' LIMIT 1") ){
//	$power=2;
//}

preg_match("/(.*)\/(index\.php|)\?main=(.+)/is",$WEBURL,$UrlArray);
$MainUrl=$UrlArray[3]?$UrlArray[3]:"map.php?uid=$lfjuid";
if(eregi('^http',$MainUrl)&&!eregi("^$webdb[www_url]",$MainUrl)){
	showerr('URL被禁止的!');
}

unset($menudb);

//设法获取后台自定义菜单
$query = $db->query("SELECT * FROM {$pre}admin_menu WHERE groupid='-$lfjdb[groupid]' AND fid=0 ORDER BY list DESC");
while($rs = $db->fetch_array($query)){
	$query2 = $db->query("SELECT * FROM {$pre}admin_menu WHERE fid='$rs[id]' ORDER BY list DESC");
	while($rs2 = $db->fetch_array($query2)){
		$menudb[$rs[name]][$rs2[name]]['link']=$rs2['linkurl'];
	}
}

//后台不存在自定义菜单,则用默认的
if(!$menudb){

	require_once(dirname(__FILE__)."/"."menu.php");

	//获取模块系统的会员菜单
	$query = $db->query("SELECT * FROM {$pre}module WHERE type=2 AND ifclose=0 ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$array=@include(ROOT_PATH."$rs[dirname]/member/menu.php");
		foreach($array AS $key=>$value){
			$value['link']="$webdb[www_url]/$rs[dirname]/member/".$value['link'];
			$menudb["$rs[name]"][$key]=$value;
		}
	}
	
	
	//添加分类信息 古太行 绿叶城市
	if($lfjdb[menutype] == 1){
	//企业用户
		//$menudb["分类信息"] = array();
		//$menudb["绿页 城.市"] = array();
		$menudb["古太行"] = array();	
		$endmenutext = '应用版块';
		$endmenulink = 'http://www.darkgreen.cn/member/?menutype=9';	
	}
	else if($lfjdb[menutype] == 9){
		$menudb["绿页 城.市"] = array();
		$menudb["绿页工作与招聘"] = array();
		$menudb["古太行"] = array();		
		$endmenutext = '商务版';
		$endmenulink = 'http://www.darkgreen.cn/member/';
	}
	else{
		$menudb["分类信息"] = array();
		$menudb["绿页 城.市"] = array();
		$menudb["古太行"] = array();
		$endmenutext = '注册商务版';
		$endmenulink = 'http://www.darkgreen.cn/hy/reg.php';
		
	}
	
}


require(get_member_tpl('index'));


//处理内网的问题,内网的话$webdb[www_url]='/.';
if($webdb[www_url]=='/.'){
	$content=str_replace('/./','/',ob_get_contents());
	ob_end_clean();
	echo $content;
}

?>