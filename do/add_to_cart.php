<?php
session_start();
//unset($_SESSION['goods_in_cart']);exit;

$already_exits = false;
$fid = $_POST['data']['fid'];
$cid = $_POST['data']['cid'];
$uid = $_POST['data']['uid'];
if(!isset($_SESSION['goods_in_cart'])){
    //echo "no goods in cart";
    $_SESSION['goods_in_cart'] = array();
}
//check if we already have this product in the cart, if we already have one, just add the quantity of this product
if (array_key_exists($uid, $_SESSION['goods_in_cart'])) {

    foreach ($_SESSION['goods_in_cart'][$uid] as $key => $value) {
        if ($value['uid'] == $uid && $value['cid'] == $cid) {
            $already_exits = true;
            // 如果多次点击加入采购订单，那么数量增加
            $_SESSION['goods_in_cart'][$uid][$key]['quantity']++;
            //$_SESSION['goods_in_cart'][$uid][$key]['price'] = (float)$_SESSION['goods_in_cart'][$uid][$key]['price']*(int)$_SESSION['goods_in_cart'][$uid][$key]['quantity'];
        }
    }
} else {
    if (!is_array($_SESSION['goods_in_cart'][$uid])) {
        $_SESSION['goods_in_cart'][$uid] = array();
    }
}

if(!$already_exits){
    //array_push($_SESSION['goods_in_cart'][$uid],array("uid" => $_POST['data']['uid'], "fid" => $_POST['data']['fid'], "cid" => $_POST['data']['cid'], "price" =>$_POST['data']['price'],"quantity" => 1));
    $_SESSION['goods_in_cart'][$uid][$_POST['data']['cid']] = array("uid" => $_POST['data']['uid'], "fid" => $_POST['data']['fid'], "cid" => $_POST['data']['cid'], "price" =>$_POST['data']['price'],"quantity" => 1);
}

echo "success";
?>