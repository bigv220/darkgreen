<?php
require("global.php");
@include_once(ROOT_PATH."data/all_area.php");
if ($_POST) {
    if (!empty($_POST['suggest'])) {
        $str = "<br/>意见和建议:".$_POST['suggest'];
    }
    send_mail("dreewind361@126.com","有客户希望关闭账户",
        "{$lfjid}在后台提交关闭账户申请，请尽快查看<br/><A HREF='http://www.darkgreen.cn/member/homepage.php?uid=$lfjuid' target='_blank'>查看{$lfjid}信息</A>$str",0);
    send_mail("xyt.qingdao@163.com","有客户希望关闭账户",
        "{$lfjid}在后台提交关闭账户申请，请尽快查看<br/><A HREF='http://www.darkgreen.cn/member/homepage.php?uid=$lfjuid' target='_blank'>查看{$lfjid}信息</A>$str",0);
}
require(dirname(__FILE__)."/"."template/default/headmail.htm");
require(dirname(__FILE__)."/"."template/setClose.htm");
require(dirname(__FILE__)."/"."foot.php");

?>