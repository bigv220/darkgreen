<?php

if($lfjdb[menutype] != 9){
return array(
	'发表文章'=>array('link'=>'post_choose.php'),
	'管理文章'=>array('link'=>'list.php?job=list'),
	'我发布的留言'=>array('power'=>'1','link'=>'comment.php?job=list'),
	'我的留言'=>array('power'=>'1','link'=>'comment.php?job=mylist'),
);
}
?>