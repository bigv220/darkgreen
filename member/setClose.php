<?php
require("global.php");
@include_once(ROOT_PATH."data/all_area.php");
if ($_POST) {
    if (!empty($_POST['suggest'])) {
        $str = "<br/>����ͽ���:".$_POST['suggest'];
    }
    send_mail("dreewind361@126.com","�пͻ�ϣ���ر��˻�",
        "{$lfjid}�ں�̨�ύ�ر��˻����룬�뾡��鿴<br/><A HREF='http://www.darkgreen.cn/member/homepage.php?uid=$lfjuid' target='_blank'>�鿴{$lfjid}��Ϣ</A>$str",0);
    send_mail("xyt.qingdao@163.com","�пͻ�ϣ���ر��˻�",
        "{$lfjid}�ں�̨�ύ�ر��˻����룬�뾡��鿴<br/><A HREF='http://www.darkgreen.cn/member/homepage.php?uid=$lfjuid' target='_blank'>�鿴{$lfjid}��Ϣ</A>$str",0);
}
require(dirname(__FILE__)."/"."template/default/headmail.htm");
require(dirname(__FILE__)."/"."template/setClose.htm");
require(dirname(__FILE__)."/"."foot.php");

?>