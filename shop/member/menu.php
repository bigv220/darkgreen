<?php

if($lfjdb[menutype] == 0){
    return array(
        '����'=>array('power'=>'1','link'=>'order.php?job=mylist'),
        '�ղؼ�'=>array('power'=>'1','link'=>'collection.php'),
        '�������԰������'=>array('power'=>'1','link'=>'comment.php?job=mylist'),
        '�յ�������'=>array('power'=>'1','link'=>'comment.php?job=list'),
    );
}
else if($lfjdb[menutype] != 9){
    return array(
        '������Ʒ'=>array('power'=>'1','link'=>'post_choose.php'),
        '��Ʒ����'=>array('power'=>'1','link'=>'list.php'),
        '�ͻ�����'=>array('power'=>'1','link'=>'order.php?job=list'),
        '�ҵĶ���'=>array('power'=>'1','link'=>'order.php?job=mylist'),
        '�ղؼ�'=>array('power'=>'1','link'=>'collection.php'),
        '�ҷ���������'=>array('power'=>'1','link'=>'comment.php?job=list'),
        '�ҵ�����'=>array('power'=>'1','link'=>'comment.php?job=mylist'),
    );
}
?>