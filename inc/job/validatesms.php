<?php
!function_exists('html') && exit('ERR');
//��ǰ�ļ���ע��ʱͨ���ֻ��������ȡע����Ĺ���
//ע����˶�
	if($_POST['data']){
        $yznum = $_POST['data'];
		$time=$timestamp-3600;	//1Сʱǰ��ע����ʧЧ.
		if($db->get_one("SELECT * FROM {$pre}regnum WHERE num='$yznum' AND sid='$usr_sid'")){
			$db->query("DELETE FROM {$pre}regnum WHERE (num='$yznum' AND sid='$usr_sid') OR posttime<$time");
            set_cookie("valid_phone",true,3600*12);
            echo "success";
		}else{
			echo("failed");
		}
	}
?>