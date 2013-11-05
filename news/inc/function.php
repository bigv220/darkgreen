<?php

//对用户发表文章与推荐文章的奖罚yz,unyz,com,uncom,del
function Give_News_money($uid,$type='',$rsdb){
	global $webdb,$Mdomain;
	if($type=='yz'){
		$money	=	$webdb[postArticleMoney];
		$msg = '发表文章通过审核奖励';
	}elseif($type=='unyz'){
		$money	=	-$webdb[postArticleMoney];
		$msg = '发表文章取消审核惩罚';
	}elseif($type=='com'){
		$money	=	$webdb[comArticleMoney];
		$msg = '文章被设为精华奖励';
	}elseif($type=='uncom'){
		$money	=	-$webdb[comArticleMoney];
		$msg = '文章被取消精华惩罚';
	}elseif($type=='top'){
		$money	=	$webdb[topArticleMoney];
		$msg = '文章被置顶显示奖励';
	}elseif($type=='front'){
		$money	=	$webdb[frontArticleMoney];
		$msg = '文章被提前显示奖励';
	}
	
	if($type=='del'){
		$money	=	$webdb[deleteArticleMoney];
		$msg = '文章被删除扣分:'.$rsdb[title];
	}else{
		$msg .= " [<A HREF='$Mdomain/bencandy.php?fid=$rsdb[fid]&id=$rsdb[id]' target=_blank>".get_word($rsdb[title],30)."</A>]";
	}
	if(!$money||!$uid){
		return ;
	}
	add_user($uid,$money,$msg);
}

?>