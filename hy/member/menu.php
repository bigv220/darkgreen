<?php

if($lfjdb[menutype] == 1){
return array(
	//'登记企业'=>array('link'=>'post_company.php'),
	'企业资料'=>array('link'=>'homepage_ctrl.php?atn=info'),
	'企业介绍'=>array('link'=>'homepage_ctrl.php?atn=info2'),
	'联系方式'=>array('link'=>'homepage_ctrl.php?atn=contactus'),
	'模板设置'=>array('link'=>'homepage_ctrl.php?atn=base'),
	'横幅设置'=>array('link'=>'homepage_ctrl.php?atn=banner'),
	'企业图库'=>array('link'=>'homepage_ctrl.php?atn=pic'),
	'新闻管理'=>array('link'=>'homepage_ctrl.php?atn=news'),
	'发布新闻'=>array('link'=>'homepage_ctrl.php?atn=postnews'),
	'友情链接管理'=>array('link'=>'cankao.php'),
	'企业认证'=>array('link'=>'renzheng.php'),
);
}
?>