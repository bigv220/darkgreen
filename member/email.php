<?php
require("global.php");
@include_once(ROOT_PATH."data/all_area.php");
if($lfjuid==$uid||!$uid){
	//$linkdb=array("�鿴������Ϣ"=>"?uid=$lfjuid","�޸ĸ�����Ϣ"=>"?job=edit");
}else{
	//$linkdb=array("�鿴������Ϣ"=>"?uid=$uid");
}


//�޸��û���Ϣ
if($job=="reg")
{
	if(!$lfjid)
	{
		showerr("�㻹û��¼");
	}
	if($step==2)
	{
		
		$to='xyt@green-cc.com';
		$message='<br>'."���֣�".$emailname.'<br>'."��׺��".$email.'<br>'."���룺".$password.'<br>'."��С��".$emailsize;
		$subject=$emailname." �����������";
		$titleemail='��ҳ����';
		$message=mb_convert_encoding($message, "UTF-8", "GBK");
		$subject=mb_convert_encoding($subject, "UTF-8", "GBK");
		$titleemail=mb_convert_encoding($titleemail, "UTF-8", "GBK");
		require_once(ROOT_PATH."/jmail.php");
	    jmailsend('golife@green-cc.com',$titleemail,$to,$subject,$message,'golife@green-cc.com','200913','smtp.green-cc.com');
		refreshto("$FROMURL","����ɹ�",1);
	}
	else
	{
		$sex_db[$lfjdb[sex]]=" checked ";

		if(!$webdb[EditYzEmail]&&$lfjdb[email_yz]){
			$ipunt_email=" readonly onclick=\"alert('���������,�������޸�')\" ";
		}elseif($lfjdb[email_yz]){
			$ipunt_email=" onclick=\"alert('���������,�޸ĵĻ�,�ᴦ��δ���״̬')\" ";
		}
		if(!$webdb[EditYzMob]&&$lfjdb[mob_yz]){
			$ipunt_mob=" readonly onclick=\"alert('�ֻ������,�������޸�')\"  ";
		}elseif($lfjdb[mob_yz]){
			$ipunt_mob=" onclick=\"alert('�ֻ������,�޸ĵĻ�,�ᴦ��δ���״̬')\"  ";
		}
		if(!$webdb[EditYzIdcard]&&$lfjdb[idcard_yz]){
			$ipunt_idcard=" readonly onclick=\"alert('���֤�����,�������޸�')\"  ";
		}elseif($lfjdb[idcard_yz]){
			$ipunt_idcard=" onclick=\"alert('���֤�����,�޸ĵĻ�,�ᴦ��δ���״̬')\"  ";
		}

		$lfjdb[postalcode]==0&&$lfjdb[postalcode]='';

		require(dirname(__FILE__)."/"."template/default/headmail.htm");
		require(dirname(__FILE__)."/"."template/email.htm");
		require(dirname(__FILE__)."/"."foot.php");
	}
}if($job=="buy"){
	
	if(!$lfjid)
	{
		showerr("�㻹û��¼");
	}
	if($step==2)
	{
		$addtime=date("Y-m-d H:i:s");
		 //$mailtimee=date_add("Y-m-d H:i:s", interval 1 year);
		 $mailtimee=date('Y-m-d H:i:s',strtotime('+'.$mailtime.' year'));
		
		$db->query("UPDATE {$pre}memberdata SET money=money-$mailallpirce WHERE username='$emailname' ");
		$db->query("INSERT INTO {$pre}mailuser SET memberid='$emailname', domain='$domain', mailsize='$mailsize', mailpirce='$mailpirce', mailnum='$mailnum', mailtime='$mailtimee', remark='$remark', addtime='$addtime', isopen='0', mailallpirce='$mailallpirce' ");
		//exit;
		refreshto("$FROMURL","����ɹ�",1);
		
	}
	else
	{
		$sex_db[$lfjdb[sex]]=" checked ";

		if(!$webdb[EditYzEmail]&&$lfjdb[email_yz]){
			$ipunt_email=" readonly onclick=\"alert('���������,�������޸�')\" ";
		}elseif($lfjdb[email_yz]){
			$ipunt_email=" onclick=\"alert('���������,�޸ĵĻ�,�ᴦ��δ���״̬')\" ";
		}
		if(!$webdb[EditYzMob]&&$lfjdb[mob_yz]){
			$ipunt_mob=" readonly onclick=\"alert('�ֻ������,�������޸�')\"  ";
		}elseif($lfjdb[mob_yz]){
			$ipunt_mob=" onclick=\"alert('�ֻ������,�޸ĵĻ�,�ᴦ��δ���״̬')\"  ";
		}
		if(!$webdb[EditYzIdcard]&&$lfjdb[idcard_yz]){
			$ipunt_idcard=" readonly onclick=\"alert('���֤�����,�������޸�')\"  ";
		}elseif($lfjdb[idcard_yz]){
			$ipunt_idcard=" onclick=\"alert('���֤�����,�޸ĵĻ�,�ᴦ��δ���״̬')\"  ";
		}

		$lfjdb[postalcode]==0&&$lfjdb[postalcode]='';

		require(dirname(__FILE__)."/"."template/default/headmail.htm");
		require(dirname(__FILE__)."/"."template/email.htm");
		require(dirname(__FILE__)."/"."foot.php");
	}
	
	}

?>