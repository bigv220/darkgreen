<?php
session_start();
//unset($_SESSION['goods_in_cart']);exit;

$already_exits = false;
$fid = $_POST['data']['fid'];
$cid = $_POST['data']['cid'];
if(!isset($_SESSION['goods_in_cart'])){
    //echo "no goods in cart";
    $_SESSION['goods_in_cart'] = array();
}
//check if we already have this product in the cart, if we already have one, just add the quantity of this product
if (array_key_exists($fid, $_SESSION['goods_in_cart'])) {

    foreach ($_SESSION['goods_in_cart'][$fid] as $key => $value) {
        if ($value['fid'] == $fid && $value['cid'] == $cid) {
            $already_exits = true;
            // 如果多次点击加入采购订单，那么数量增加
            $_SESSION['goods_in_cart'][$fid][$key]['quantity']++;
        }
    }
} else {
    if (!is_array($_SESSION['goods_in_cart'][$fid])) {
        $_SESSION['goods_in_cart'][$fid] = array();
    }
}

if(!$already_exits){
   array_push($_SESSION['goods_in_cart'][$fid],array("fid" => $_POST['data']['fid'], "cid" => $_POST['data']['cid'], "quantity" => 1));
}

echo "success";
?>