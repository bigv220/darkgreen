<?php
require_once(dirname(__FILE__).'/../inc/function.inc.php');
if (!get_cookie("valid_phone")) {
    echo "phone";
    exit;
}
//require_once(dirname(__FILE__)."/../"."data/mysql_config.php");
require_once(dirname(__FILE__)."/../".'inc/common.inc.php');

$db=new MYSQL_DB;
$gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$lfjuid'");
$gutai_conf = unserialize($gutai_rs[config]);
$job = $_POST[job];;

if($gutai_conf[gutai_pwd] != md5($_POST[pwd])) {
    echo "pwd";
    exit;
}
header('Content-Type: text/html; charset=gb2312');

if($job=='end'){
    $comment = iconv("UTF-8","GB2312",$_POST["comment"]);

    $id = $_POST[id];
    $is_seller_end = $_POST[is_seller];
    $is_buyer_end = !$is_seller;
    $db->query("UPDATE home_shop_join SET if_seller_end='$is_seller_end', if_buyer_end='$is_buyer_end', end_date='$timestamp', end_comment='$comment' WHERE id='$id'");
} else if ($job == 'withdraw') {
    $gutai_rs=$db->get_one("SELECT gutai FROM `{$pre}memberdata` WHERE uid='$lfjuid'");
    $gutai_yu = $gutai_rs['gutai'];
    $money = $_POST["money"];
    if ($gutai_yu < $money) {
        echo "余额不足, 您的古太行余额为".$gutai_yu;
        exit;
    } else {
        $left = $gutai_yu - $money;
        $db->query("UPDATE `{$pre}memberdata` SET gutai=$left WHERE id='$id'");
        // 发邮件告知管理员，有人提现
        $db->query("INSERT INTO `home_shop_charge` values('$lfjuid','提现','$money','$gutai_yu','$left','已完成','古太行','$timestamp');");
        echo "提现成功";
    }
} else if ($job =='charge') {
    $rs=$db->get_one("SELECT * FROM `{$pre}purse` WHERE uid='$lfjuid'");
    $array=unserialize($rs[config]);
    $mid =2;
    $totalmoney = number_format($_POST[price],2);
    /*往主信息表插入内容*/
    $db->query("INSERT INTO `home_shop_join` ( `mid` , `cid` , `cuid` , `fid` ,  `posttime` ,  `uid` , `username` , `yz` , `ip` , `shopnum` , `totalmoney`,`ifgutai`)
	VALUES (
	'$mid',0,'$lfjuid','$fid','$timestamp','$lfjdb[uid]','$lfjdb[username]','0','$onlineip','1','$totalmoney',1)");

    $id = $db->insert_id();

    unset($sqldb);
    $sqldb[]="id=$id";
    $sqldb[]="fid='$fid'";
    $sqldb[]="uid='$lfjuid'";
    $postdb[paytype] = 4;
    /*检查判断辅信息表要插入哪些字段的内容*/
    foreach( $field_db AS $key=>$value){
        isset($postdb[$key]) && $sqldb[]="`{$key}`='{$postdb[$key]}'";
    }

    $sql=implode(",",$sqldb);

    $db->query("INSERT INTO `home_shop_content_$mid` SET $sql");
    $db->query("INSERT INTO `home_shop_charge` values(null,'$lfjuid','充值','$totalmoney',0,0,'进行中','银联在线','$timestamp');");
    echo "../shop/gutai.php?id=$id&fid=$fid";
}

?>