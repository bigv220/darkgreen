<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sophia
 * Date: 13-7-22
 * Time: ����1:19
 * To change this template use File | Settings | File Templates.
 */
require_once(dirname(__FILE__).'/../inc/function.inc.php');
!function_exists('html') && exit('ERR');

$_pre = 'home_shop_';
if($job=="status"&&$Apower[member_list])
{
    $listdb = array();
    $rows = 15;

    if(!$page) {
        $page = 1;
    }

    $min = ($page-1)*$rows;

    $all_query = $db->query("SELECT A.*,B.*,C.title,C.fname FROM {$_pre}join A LEFT JOIN {$_pre}content_2 B ON A.id=B.id LEFT JOIN {$_pre}content C ON A.cid=C.id ORDER BY A.id DESC");

    $RS=$db->get_one("SELECT FOUND_ROWS()");
    $totalNum=$RS['FOUND_ROWS()'];
    $showpage = getpage("","","?lfj=order&job=$job",$rows,$totalNum);

    $query = $db->query("SELECT A.id as ID,A.*,B.*,C.title,C.fname FROM {$_pre}join A LEFT JOIN {$_pre}content_2 B ON A.id=B.id LEFT JOIN {$_pre}content C ON A.cid=C.id ORDER BY A.id DESC LIMIT $min,$rows");
    while($rs = $db->fetch_array($query))
    {
        $rs[posttime] = date("Y-m-d",$rs[posttime]);
        $rs[send]=$rs[ifsend]?"<A style='color:red;'>�ѷ���</A>":"δ����";
        $rs[complete] = $rs[ifpay]&&$rs[ifsend]? "���": "������";
        $rs[pay]=$rs[ifpay]?"<A style='color:red;'>�Ѹ�</A>":"δ����";
        $rs[admin_oper]=$rs[admin_confirm]?"<A style='color:green;'>��ȷ��</A>":"δȷ��";
        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/status.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "buyer_commond_pay" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT * FROM {$_pre}join WHERE ifpay=1 AND buyer_pay_date is not null");

    $ajaxUlr = "../ly_adm/ajax_order.php";
    while($rs = $db->fetch_array($query)) {
        $rs[buyer_pay_date] = date("Y-m-d",$rs[buyer_pay_date]);
        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/buyer_commond_pay.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "system_pay_time" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT A.*,C.title FROM home_shop_join A LEFT JOIN {$_pre}content C ON A.cid=C.id WHERE system_pay_date is not null");

    while($rs = $db->fetch_array($query)) {
        $rs[system_pay_date] = date("Y-m-d",$rs[system_pay_date]);
        $rs[complete] = $rs[ifpay]&&$rs[ifsend]? "���": "������";
        $listdb[] = $rs;
    }

    $ajaxUlr = "../ly_adm/ajax_order.php";

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/system_pay_time.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "buyer_end" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT * FROM {$_pre}join WHERE if_buyer_end=1");

    while($rs = $db->fetch_array($query)) {
        $rs[end_date] = date("Y-m-d",$rs[end_date]);
        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/buyer_end.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "seller_end" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT * FROM {$_pre}join WHERE if_seller_end=1");

    while($rs = $db->fetch_array($query)) {
        $rs[end_date] = date("Y-m-d",$rs[end_date]);
        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/seller_end.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "gutai_withdraw" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT A.*, M.username FROM {$_pre}charge A LEFT JOIN home_members M ON A.uid=M.uid WHERE gutai_type='����'");

    while($rs = $db->fetch_array($query)) {
        $rs[posttime] = date("Y-m-d",$rs[posttime]);
        $listdb[] = $rs;
    }

    $ajaxUlr = "../ly_adm/ajax_order.php";

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/gutai_withdraw.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "gutai_deposit" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT A.*, M.username FROM {$_pre}charge A LEFT JOIN home_members M ON A.uid=M.uid WHERE gutai_type='��ֵ'");

    while($rs = $db->fetch_array($query)) {
        $rs[posttime] = date("Y-m-d",$rs[posttime]);
        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/gutai_deposit.htm");
    require(dirname(__FILE__)."/"."foot.php");
}

?>