<?php
require_once("global.php");

$protocol_text = '';
$msg = '';
if($action == 'upload_text') {
    $text_url = "";
    if($_FILES[uploadtext][name]) {
        $array[name]=$_FILES[uploadtext][name];
        $filetype=strtolower(strrchr($array[name],"."));
        if($_FILES[uploadtext][name] && $filetype!='.doc'&&$filetype!='.txt'&&$filetype!='.docx')
        {
            showerr("只能是.doc或.txt或.docx格式");
        }
        $array[path]=$webdb[updir]."/protocol_text";

        $filename=upfile(is_array($uploadtext)?$_FILES[uploadtext][tmp_name]:$uploadtext,$array);
        $card="protocol_text/{$lfjuid}".strtolower(strrchr($filename,"."));
        @unlink(ROOT_PATH."$webdb[updir]/$card");
        rename(ROOT_PATH."$webdb[updir]/protocol_text/$filename",ROOT_PATH."$webdb[updir]/$card");

        //read protocol text form the uploaded file
        $card_url="$webdb[www_url]/$webdb[updir]/$card";

        $protocol_text = readProtocolText($card_url, $filetype);
    }

    $msg = '上传成功!';

    // update database
    if(!empty($protocol_text)) {
        $db->query("UPDATE {$_pre}content SET sellertext='" . addslashes($protocol_text) . "' WHERE uid='$lfjuid'");
    }
}

if($action == 'save_text') {
    $txt = $_POST['protocolText'];
    $db->query("UPDATE {$_pre}content SET sellertext='" . addslashes($txt) . "' WHERE uid='$lfjuid'");
}

/**
*被选中的模块以红色字体显示
**/
$colordb[$mid]="red;";

$SQL=" WHERE uid='$lfjuid' ";


/**
*每页显示40条
**/
$rows=15;

if(!$page)
{
	$page=1;
}
$min=($page-1)*$rows;

/*分页功能*/
$showpage=getpage("{$_pre}content","$SQL","?","$rows");

$webdb[UpdatePostTime]>0 || $webdb[UpdatePostTime]=1;

unset($listdb,$i);

$query = $db->query("SELECT * FROM {$_pre}content $SQL ORDER BY id DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query))
{
	if($timestamp-$rs[posttime]<(3600*$webdb[UpdatePostTime])){
		$rs[update]='<A HREF="#" style="color:#ccc;" onclick="alert(\'距离上次更新时间'.$webdb[UpdatePostTime].'小时后,才可以进行刷新!\')">刷新</A>';
	}else{
		$rs[update]="<A HREF=\"../job.php?job=update&fid=$rs[fid]&id=$rs[id]\">刷新</A>";
	}
	if($rs['list']>$timestamp){
		$rs[dotop]='<A HREF="#" style="color:#ccc;" onclick="alert(\'已经置顶了\')">置顶</A>';
	}else{
		$rs[dotop]="<A HREF=\"../job.php?job=dotop&fid=$rs[fid]&id=$rs[id]\">置顶</A>";
	}
	$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);

	$i++;
	$rs[cl]=$i%2==0?'t2':'t1';
	$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);

	$listdb[]=$rs;
}
$lfjdb[money]=intval(get_money($lfjuid));

require(ROOT_PATH."member/head.php");
require(dirname(__FILE__)."/"."template/list.htm");
require(ROOT_PATH."member/foot.php");
?>