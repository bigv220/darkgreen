<?php
session_start();

var_dump($_POST);
$already_exits = false;
if(!isset($_SESSION['goods_in_cart'])){
    echo "no goods in cart";
    $_SESSION['goods_in_cart'] = array();
}
else{
    //check if we already have this product in the cart, if we already have one, just add the quantity of this product
    for($i=0;i<$_SESSION['goods_in_cart'].length;$i++){
        if($_SESSION['goods_in_cart']['fid'] == $_POST['data']['fid'] && $_SESSION['goods_in_cart']['cid'] == $_POST['data']['cid']){
            $_SESSION['goods_in_cart']['quantity']++;
            $already_exits = true;
            break;
        }
    }
}
if(!$already_exits){
    $_SESSION['goods_in_cart'][] = array("fid"=>$_POST['data']['fid'], "cid"=>$_POST['data']['cid'], "quantity"=>1);
}
var_dump($_SESSION);
?>