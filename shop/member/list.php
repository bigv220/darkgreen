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
            showerr("ֻ����.doc��.txt��.docx��ʽ");
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

    $msg = '�ϴ��ɹ�!';

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
*��ѡ�е�ģ���Ժ�ɫ������ʾ
**/
$colordb[$mid]="red;";

$SQL=" WHERE uid='$lfjuid' ";


/**
*ÿҳ��ʾ40��
**/
$rows=15;

if(!$page)
{
	$page=1;
}
$min=($page-1)*$rows;

/*��ҳ����*/
$showpage=getpage("{$_pre}content","$SQL","?","$rows");

$webdb[UpdatePostTime]>0 || $webdb[UpdatePostTime]=1;

unset($listdb,$i);

$query = $db->query("SELECT * FROM {$_pre}content $SQL ORDER BY id DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query))
{
	if($timestamp-$rs[posttime]<(3600*$webdb[UpdatePostTime])){
		$rs[update]='<A HREF="#" style="color:#ccc;" onclick="alert(\'�����ϴθ���ʱ��'.$webdb[UpdatePostTime].'Сʱ��,�ſ��Խ���ˢ��!\')">ˢ��</A>';
	}else{
		$rs[update]="<A HREF=\"../job.php?job=update&fid=$rs[fid]&id=$rs[id]\">ˢ��</A>";
	}
	if($rs['list']>$timestamp){
		$rs[dotop]='<A HREF="#" style="color:#ccc;" onclick="alert(\'�Ѿ��ö���\')">�ö�</A>';
	}else{
		$rs[dotop]="<A HREF=\"../job.php?job=dotop&fid=$rs[fid]&id=$rs[id]\">�ö�</A>";
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