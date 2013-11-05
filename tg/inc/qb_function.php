<?php 

if(defined('SYS_TYPE') && SYS_TYPE!='tg'){
	die('err 01');
}
 
if(!function_exists('LIFE2_CK')||!defined('BIZ_PATH')){
	die('文件不存在,或者是文件太旧,需要更新!');
}
else{
	LIFE_CK('2tg');
}
 
 
/**
*获取模板的函数
**/
function getTpl($html,$tplpath=''){
	global $STYLE;
	if($tplpath&&file_exists($tplpath)){
		return $tplpath;
	}elseif($tplpath&&file_exists(Mpath.$tplpath)){
		return Mpath.$tplpath;
	}elseif(file_exists(Mpath."template/$STYLE/$html.htm")){
		return Mpath."template/$STYLE/$html.htm";
	}else{
		return Mpath."template/default/$html.htm";
	}
}
 
function modules_tg(){
	global $_pre;
	return $_pre.'module';
}


?>