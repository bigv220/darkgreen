<?php

if($lfjdb[menutype] == 0){
    return array(
        '订单'=>array('power'=>'1','link'=>'order.php?job=mylist'),
        '收藏夹'=>array('power'=>'1','link'=>'collection.php'),
        '发布留言板的内容'=>array('power'=>'1','link'=>'comment.php?job=mylist'),
        '收到的留言'=>array('power'=>'1','link'=>'comment.php?job=list'),
    );
}
else if($lfjdb[menutype] != 9){
    return array(
        '发布商品'=>array('power'=>'1','link'=>'post_choose.php'),
        '商品管理'=>array('power'=>'1','link'=>'list.php'),
        '客户订单'=>array('power'=>'1','link'=>'order.php?job=list'),
        '我的订单'=>array('power'=>'1','link'=>'order.php?job=mylist'),
        '收藏夹'=>array('power'=>'1','link'=>'collection.php'),
        '我发布的评论'=>array('power'=>'1','link'=>'comment.php?job=list'),
        '我的评论'=>array('power'=>'1','link'=>'comment.php?job=mylist'),
    );
}
?>