<?php
require(dirname(__FILE__)."/"."global.php");
require_once(ROOT_PATH."inc/encode.php");

if($action=="add"){
	if(!$postdbpara11){
		showerr("ӦƸְλ����Ϊ��");
	}
	if(!$postdbpara12){
		showerr("��������Ϊ��");
	}
	if ($postdbpara16&&!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$postdbpara16)) {
		showerr("���䲻���Ϲ���");
	}
	if( $webdb[yzImgGuestBook]&&!$web_admin ){
		if(!check_imgnum($yzimg)){
			showerr("��֤�벻����");
		}else{
			set_cookie("yzImgNum","");
		}
	}
$db->query("INSERT INTO `{$pre}cv` ( `readok` , `para11` , `para12` , `para13` , `para14` , `para15` , `para16` , `para17` , `para18` , `para19` , `para20` , `para21` ) 
	VALUES (
	'$timestamp','$postdbpara11','$postdbpara12','$postdbpara13','$postdbpara14','$postdbpara15','$postdbpara16','$postdbpara17','$postdbpara18','$postdbpara19','$postdbpara20','$postdbpara21')
	");
	refreshto("/do/about.php?id=9","�ύ�ɹ�",1);
}
?>
