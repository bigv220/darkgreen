<?php
/**
 * Created by JetBrains PhpStorm.
 * User: DAVID
 * Date: 13-9-14
 * Time: 上午12:09
 * Handle Chinapay return
 */
require("global.php");
if (isset($_POST['Priv1'])) {
    $arr = explode("&&", $_POST['Priv1']);
    $id = $arr[0];
    $fid = $arr[1];
}
if (isset($_POST['merid'])) {
    $respond_id = $c->respond($payment);

    if ($respond_id !== false) {
        global $db,$_pre,$webdb,$banktype,$pay_code,$lfjuid,$infodb;


        $db->query("UPDATE {$_pre}join SET ifpay='1',banktype='chinapay' WHERE id='$id'");

        refreshto("bencandy.php?city_id=$infodb[city_id]&fid=$fid&id=$infodb[cid]","恭喜你订单付款成功!",60);
        exit;
    }
}