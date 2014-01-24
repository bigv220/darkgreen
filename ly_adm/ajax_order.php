<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sophia
 * Date: 13-7-24
 * Time: ����11:48
 * To change this template use File | Settings | File Templates.
 */
require_once(dirname(__FILE__)."/../".'inc/common.inc.php');

$pre = "home_shop_";
$db = new MYSQL_DB;

header('Content-Type: text/html; charset=gb2312');

$job = $_POST[job];
if($job == "admin_confirm") {
    $id = $_POST[id];
    $db->query("UPDATE `{$pre}join` SET admin_confirm=1 WHERE id='$id'");
    echo "succ";
} elseif ($job == "withdraw_admin_confirm") {
    $id = $_POST[id];
    $db->query("UPDATE `{$pre}charge` SET admin_confirm=1 WHERE id='$id'");
    echo "succ";
} else if($job == 'pay_to_seller') {
    $id = $_POST[id];
    $db->query("UPDATE home_shop_join SET if_pay_seller=1 WHERE id='$id'");
    echo "succ";
} else if($job == 'get_gutai_info') {
    $uid = $_POST[uid];

    $rs = $db->get_one("SELECT * FROM `home_gutai_bank` WHERE uid='$uid'");
    $gutai_conf = unserialize($rs[config]);
    echo $gutai_conf[gutai_name]."|".$gutai_conf[gutai_bankid]."|".$gutai_conf[gutai_obligate_account];
    exit;
} else if($job == 'refundment_yes') {
    $id = $_POST[id];
    $db->query("UPDATE home_shop_join SET if_refundment=1 WHERE id='$id'");
    echo "succ";
}
?>