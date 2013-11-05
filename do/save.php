<?php
require(dirname(__FILE__)."/"."global.php");
require_once(ROOT_PATH."inc/encode.php");

if($action=="add"){
	if(!$postdbpara11){
		showerr("应聘职位不能为空");
	}
	if(!$postdbpara12){
		showerr("姓名不能为空");
	}
	if ($postdbpara16&&!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$postdbpara16)) {
		showerr("邮箱不符合规则");
	}
	if( $webdb[yzImgGuestBook]&&!$web_admin ){
		if(!check_imgnum($yzimg)){
			showerr("验证码不符合");
		}else{
			set_cookie("yzImgNum","");
		}
	}
$db->query("INSERT INTO `{$pre}cv` ( `readok` , `para11` , `para12` , `para13` , `para14` , `para15` , `para16` , `para17` , `para18` , `para19` , `para20` , `para21` ) 
	VALUES (
	'$timestamp','$postdbpara11','$postdbpara12','$postdbpara13','$postdbpara14','$postdbpara15','$postdbpara16','$postdbpara17','$postdbpara18','$postdbpara19','$postdbpara20','$postdbpara21')
	");
	refreshto("/do/about.php?id=9","提交成功",1);
}
?>
