<?php
!function_exists('html') && exit('ERR');

$payment_lang = ROOT_PATH . 'languages/' . $GLOBALS['_CFG']['lang'] . '/payment/ChinaPay.php';

include_once("chinapay_base.php");
include_once("netpayclient_config.php");

include_once("netpayclient.php");

$array=olpay_send();

$c = new chinapay();
$order_id_len = str_pad($infodb['id'], 6, "0", STR_PAD_LEFT);
$order['order_sn'] = $order_id_len . $infodb['posttime'];
$order['order_amount'] = $infodb['price'];
$payment['chinapay_account'] = '808080231803147';
$payment['chinapay_merkey_file'] = "/key/MerPrK_808080231803147_20130110145059.key";
$payment['chinapay_pubkey_file'] = "/key/PgPubk.key";
$payment['return_url'] = $array['return_url'];
$payment['priv1'] = $array['priv1'];
$payment['priv2'] = $array['priv2'];
$payment['id'] = $id;
if (isset($_POST['merid'])) {
    $respond_id = $c->respond($payment);

    if ($respond_id !== false) {
        olpay_end($respond_id);
        exit;
    }
} else {
echo $c->get_code($order, $payment);
}




?>