<?php
if(!function_exists('html')){
	die('F');
}
if($ip){
	if(!ereg("([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)",$ip)){
		$ip=base64_decode($ip);
		$area=ipfrom($ip);
		if(!$web_admin){
			$ip="暂不公布！";
		}
	}else{
		$area=ipfrom($ip);
	}
	if(!$area){
		showerr("很抱歉,没有你要查询的资料");
	}
	unset($string);
}


require(Mpath."inc/head.php");
require(getTpl("ip"));
require(Mpath."inc/foot.php");
?>