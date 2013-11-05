<?php
require("global.php");
@include_once(ROOT_PATH."data/all_area.php");
if($lfjuid==$uid||!$uid){
	//$linkdb=array("查看个人信息"=>"?uid=$lfjuid","修改个人信息"=>"?job=edit");
}else{
	//$linkdb=array("查看个人信息"=>"?uid=$uid");
}


//修改用户信息
if($job=="reg")
{
	if(!$lfjid)
	{
		showerr("你还没登录");
	}
	if($step==2)
	{
		
		$to='xyt@green-cc.com';
		$message='<br>'."名字：".$emailname.'<br>'."后缀：".$email.'<br>'."密码：".$password.'<br>'."大小：".$emailsize;
		$subject=$emailname." 启用免费邮箱";
		$titleemail='绿页商务';
		$message=mb_convert_encoding($message, "UTF-8", "GBK");
		$subject=mb_convert_encoding($subject, "UTF-8", "GBK");
		$titleemail=mb_convert_encoding($titleemail, "UTF-8", "GBK");
		require_once(ROOT_PATH."/jmail.php");
	    jmailsend('golife@green-cc.com',$titleemail,$to,$subject,$message,'golife@green-cc.com','200913','smtp.green-cc.com');
		refreshto("$FROMURL","申请成功",1);
	}
	else
	{
		$sex_db[$lfjdb[sex]]=" checked ";

		if(!$webdb[EditYzEmail]&&$lfjdb[email_yz]){
			$ipunt_email=" readonly onclick=\"alert('邮箱已审核,不可再修改')\" ";
		}elseif($lfjdb[email_yz]){
			$ipunt_email=" onclick=\"alert('邮箱已审核,修改的话,会处于未审核状态')\" ";
		}
		if(!$webdb[EditYzMob]&&$lfjdb[mob_yz]){
			$ipunt_mob=" readonly onclick=\"alert('手机已审核,不可再修改')\"  ";
		}elseif($lfjdb[mob_yz]){
			$ipunt_mob=" onclick=\"alert('手机已审核,修改的话,会处于未审核状态')\"  ";
		}
		if(!$webdb[EditYzIdcard]&&$lfjdb[idcard_yz]){
			$ipunt_idcard=" readonly onclick=\"alert('身份证已审核,不可再修改')\"  ";
		}elseif($lfjdb[idcard_yz]){
			$ipunt_idcard=" onclick=\"alert('身份证已审核,修改的话,会处于未审核状态')\"  ";
		}

		$lfjdb[postalcode]==0&&$lfjdb[postalcode]='';

		require(dirname(__FILE__)."/"."template/default/headmail.htm");
		require(dirname(__FILE__)."/"."template/email.htm");
		require(dirname(__FILE__)."/"."foot.php");
	}
}if($job=="buy"){
	
	if(!$lfjid)
	{
		showerr("你还没登录");
	}
	if($step==2)
	{
		$addtime=date("Y-m-d H:i:s");
		 //$mailtimee=date_add("Y-m-d H:i:s", interval 1 year);
		 $mailtimee=date('Y-m-d H:i:s',strtotime('+'.$mailtime.' year'));
		
		$db->query("UPDATE {$pre}memberdata SET money=money-$mailallpirce WHERE username='$emailname' ");
		$db->query("INSERT INTO {$pre}mailuser SET memberid='$emailname', domain='$domain', mailsize='$mailsize', mailpirce='$mailpirce', mailnum='$mailnum', mailtime='$mailtimee', remark='$remark', addtime='$addtime', isopen='0', mailallpirce='$mailallpirce' ");
		//exit;
		refreshto("$FROMURL","购买成功",1);
		
	}
	else
	{
		$sex_db[$lfjdb[sex]]=" checked ";

		if(!$webdb[EditYzEmail]&&$lfjdb[email_yz]){
			$ipunt_email=" readonly onclick=\"alert('邮箱已审核,不可再修改')\" ";
		}elseif($lfjdb[email_yz]){
			$ipunt_email=" onclick=\"alert('邮箱已审核,修改的话,会处于未审核状态')\" ";
		}
		if(!$webdb[EditYzMob]&&$lfjdb[mob_yz]){
			$ipunt_mob=" readonly onclick=\"alert('手机已审核,不可再修改')\"  ";
		}elseif($lfjdb[mob_yz]){
			$ipunt_mob=" onclick=\"alert('手机已审核,修改的话,会处于未审核状态')\"  ";
		}
		if(!$webdb[EditYzIdcard]&&$lfjdb[idcard_yz]){
			$ipunt_idcard=" readonly onclick=\"alert('身份证已审核,不可再修改')\"  ";
		}elseif($lfjdb[idcard_yz]){
			$ipunt_idcard=" onclick=\"alert('身份证已审核,修改的话,会处于未审核状态')\"  ";
		}

		$lfjdb[postalcode]==0&&$lfjdb[postalcode]='';

		require(dirname(__FILE__)."/"."template/default/headmail.htm");
		require(dirname(__FILE__)."/"."template/email.htm");
		require(dirname(__FILE__)."/"."foot.php");
	}
	
	}

?>