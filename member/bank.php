<?php
require_once("global.php");

$rs=$db->get_one("SELECT * FROM `{$pre}purse` WHERE uid='$lfjuid'");

if($action=='set'){
	foreach( $postdb AS $key=>$value){
		$postdb[$key] = filtrate($value);
	}
	$string = addslashes( serialize($postdb) );
	if($rs){
		$db->query("UPDATE `{$pre}purse` SET config='$string' WHERE uid='$lfjuid'");
	}else{
		$db->query("INSERT INTO `{$pre}purse` SET config='$string',uid='$lfjuid'");
	}
	refreshto('?','设置成功',1);
}

$gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$lfjuid'");
if($action == 'gutaibank_set') {
    if($postpwd[gutai_pwd] != $postpwd[gutai_repwd]) {
        showerr("两次输入的密码不一致！");
    }

    foreach( $postdb AS $key=>$value){
        $postdb[$key] = filtrate($value);
    }

    $card_url = "";
    if($_FILES[postcard][name]) {
            $array[name]=$_FILES[postcard][name];
            $filetype=strtolower(strrchr($array[name],"."));
            if($_FILES[postcard][name] && $filetype!='.gif'&&$filetype!='.jpg')
            {
                showerr("只能是.gif或.jpg格式");
            }
            $array[path]=$webdb[updir]."/identity_card";

            $filename=upfile(is_array($postcard)?$_FILES[postcard][tmp_name]:$postcard,$array);
            $card="identity_card/{$lfjuid}".strtolower(strrchr($filename,"."));
            @unlink(ROOT_PATH."$webdb[updir]/$card");
            rename(ROOT_PATH."$webdb[updir]/identity_card/$filename",ROOT_PATH."$webdb[updir]/$card");

            $icon_array=getimagesize(ROOT_PATH."$webdb[updir]/$card");
            if($icon_array[0]>150||$icon_array[1]>150){
                $card_url="$webdb[www_url]/$webdb[updir]/$card";
            }
    }

    $gutai_conf = unserialize($gutai_rs[config]);
    $postdb[upload_card] = $_FILES[postcard][name] ? $card_url : $gutai_conf[upload_card];

    $postdb[gutai_pwd] = "";
    if($postpwd[gutai_pwd]) {
        $postdb[gutai_pwd] = md5(filtrate($postpwd[gutai_pwd]));
    } else if($gutai_conf[gutai_pwd]) {
        $postdb[gutai_pwd] = $gutai_conf[gutai_pwd];
    }

    $string = addslashes( serialize($postdb) );
    if($gutai_rs){
        $db->query("UPDATE `{$pre}gutai_bank` SET config='$string' WHERE uid='$lfjuid'");
    }else{
        $db->query("INSERT INTO `{$pre}gutai_bank` SET config='$string',uid='$lfjuid'");
    }
    refreshto('?','设置成功',1);
}


$conf=unserialize($rs[config]);

$alipay_service[$conf[alipay_service]] = ' selected ';

$gutai_conf = unserialize($gutai_rs[config]);

require(ROOT_PATH."member/head.php");
require(dirname(__FILE__)."/"."template/bank.htm");
require(ROOT_PATH."member/foot.php");
?>