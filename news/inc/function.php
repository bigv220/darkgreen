<?php

//���û������������Ƽ����µĽ���yz,unyz,com,uncom,del
function Give_News_money($uid,$type='',$rsdb){
	global $webdb,$Mdomain;
	if($type=='yz'){
		$money	=	$webdb[postArticleMoney];
		$msg = '��������ͨ����˽���';
	}elseif($type=='unyz'){
		$money	=	-$webdb[postArticleMoney];
		$msg = '��������ȡ����˳ͷ�';
	}elseif($type=='com'){
		$money	=	$webdb[comArticleMoney];
		$msg = '���±���Ϊ��������';
	}elseif($type=='uncom'){
		$money	=	-$webdb[comArticleMoney];
		$msg = '���±�ȡ�������ͷ�';
	}elseif($type=='top'){
		$money	=	$webdb[topArticleMoney];
		$msg = '���±��ö���ʾ����';
	}elseif($type=='front'){
		$money	=	$webdb[frontArticleMoney];
		$msg = '���±���ǰ��ʾ����';
	}
	
	if($type=='del'){
		$money	=	$webdb[deleteArticleMoney];
		$msg = '���±�ɾ���۷�:'.$rsdb[title];
	}else{
		$msg .= " [<A HREF='$Mdomain/bencandy.php?fid=$rsdb[fid]&id=$rsdb[id]' target=_blank>".get_word($rsdb[title],30)."</A>]";
	}
	if(!$money||!$uid){
		return ;
	}
	add_user($uid,$money,$msg);
}

?>