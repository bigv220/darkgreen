<?php
!function_exists('html') && exit('ERR');
//当前文件是注册时通过手机或邮箱获取注册码的功能
//注册码核对
	if($_POST['data']){
        $yznum = $_POST['data'];
		$time=$timestamp-3600;	//1小时前的注册码失效.
		if($db->get_one("SELECT * FROM {$pre}regnum WHERE num='$yznum' AND sid='$usr_sid'")){
			$db->query("DELETE FROM {$pre}regnum WHERE (num='$yznum' AND sid='$usr_sid') OR posttime<$time");
            set_cookie("valid_phone",true,3600*12);
            echo "success";
		}else{
			echo("failed");
		}
	}
?>