<?php

$menu_partDB['other'][]='电子商务管理';
$menudb['电子商务管理']['在线充值支付管理']=array('power'=>'alipay_set','link'=>'index.php?lfj=alipay&job=list');

$menu_partDB['other'][]='其它功能';
$menudb['其它功能']['不良词语过滤']=array('power'=>'limitword_list','link'=>'index.php?lfj=limitword&job=list');

$menu_partDB['other'][]='其它功能';
$menudb['其它功能']['推广赚取积分功能']=array('power'=>'propagandize','link'=>'index.php?lfj=propagandize&job=list');

$menu_partDB['other'][]='其它功能';
$menudb['其它功能']['积分介绍管理']=array('power'=>'jfadmin_mod','link'=>'index.php?lfj=jfadmin&job=listjf');

if($IS_BIZPhp168||$GLOBALS[IS_BIZPhp168]){
$menu_partDB['other'][]='电子商务管理';
$menudb['电子商务管理']['点卡充值管理']=array('power'=>'moneycard_make','link'=>'index.php?lfj=moneycard&job=make');
}

$menu_partDB['other'][]='其它功能';
$menudb['其它功能']['附件管理']=array('power'=>'attachment_list','link'=>'index.php?lfj=attachment&job=list');

$menu_partDB['other'][]='消息/邮件群发';
$menudb['消息/邮件群发']['站内消息群发']=array('power'=>'message_send','link'=>'index.php?lfj=message&job=send');

$menu_partDB['other'][]='风格/模板设置';
$menudb['风格/模板设置']['风格管理']=array('power'=>'style_editstyle','link'=>'index.php?lfj=style&job=edittpl');

$menu_partDB['other'][]='消息/邮件群发';
$menudb['消息/邮件群发']['邮件群发']=array('power'=>'mail_send','link'=>'index.php?lfj=mail&job=send');

$menu_partDB['other'][]='日志管理';
$menudb['日志管理']['后台登录日志']=array('power'=>'logs_login_logs','link'=>'index.php?lfj=logs&job=login_logs');

$menu_partDB['other'][]='风格/模板设置';
$menudb['风格/模板设置']['标签数据导入与导出']=array('power'=>'labelstyle','link'=>'index.php?lfj=labelstyle&job=label');

$menu_partDB['other'][]='风格/模板设置';
$menudb['风格/模板设置']['模板设置']=array('power'=>'template_list','link'=>'index.php?lfj=template&job=list');

$menu_partDB['other'][]='消息/邮件群发';
$menudb['消息/邮件群发']['手机短信群发']=array('power'=>'sms_send','link'=>'index.php?lfj=sms&job=send');

$menu_partDB['other'][]='日志管理';
$menudb['日志管理']['后台操作日志']=array('power'=>'logs_admin_do_logs','link'=>'index.php?lfj=logs&job=admin_logs');

$menu_partDB['other'][]='插件大全';
$menudb['插件大全']['用户登录插件']=array('power'=>'login','link'=>'index.php?lfj=hack&hack=login&job=list');

$menu_partDB['other'][]='插件大全';
$menudb['插件大全']['用户消费积分记录']=array('power'=>'moneylog','link'=>'index.php?lfj=moneylog&job=list');

$menu_partDB['other'][]='插件大全';
$menudb['插件大全']['定时任务']=array('power'=>'crontab','link'=>'index.php?lfj=crontab&job=list');
?>