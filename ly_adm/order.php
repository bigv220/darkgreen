<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sophia
 * Date: 13-7-22
 * Time: 下午1:19
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
        $rs[send]=$rs[ifsend]?"<A style='color:red;'>已发货</A>":"未发货";
        $rs[complete] = $rs[ifpay]&&$rs[ifsend]? "完成": "进行中";
        $rs[pay]=$rs[ifpay]?"<A style='color:red;'>已付</A>":"未付款";
        $rs[admin_oper]=$rs[admin_confirm]?"<A style='color:green;'>已确认</A>":"未确认";
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

        $gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$rs[cuid]'");
        $gutai_conf = unserialize($gutai_rs[config]);
        if($gutai_conf[gutai_pwd] && $gutai_conf[gutai_mobile]) {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统已确认买家');
        } else {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统未确认买家');
        }
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
        $rs[complete] = $rs[ifpay]&&$rs[ifsend]? "完成": "进行中";
        $rs[complete] = iconv('UTF-8','GBK',$rs[complete]);

        $gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$rs[cuid]'");
        $gutai_conf = unserialize($gutai_rs[config]);
        if($gutai_conf[gutai_pwd] && $gutai_conf[gutai_mobile]) {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统已确认买家');
        } else {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统未确认买家');
        }

        $listdb[] = $rs;
    }

    $ajaxUlr = "../ly_adm/ajax_order.php";

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/system_pay_time.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "buyer_end" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT A.*,C.title FROM {$_pre}join A LEFT JOIN {$_pre}content C ON A.cid=C.id WHERE if_buyer_end=1");

    $ajaxUlr = "../ly_adm/ajax_order.php";
    while($rs = $db->fetch_array($query)) {
        $rs[end_date] = date("Y-m-d h:i:s",$rs[end_date]);

        $gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$rs[cuid]'");
        $gutai_conf = unserialize($gutai_rs[config]);
        if($gutai_conf[gutai_pwd] && $gutai_conf[gutai_mobile]) {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统已确认买家');
        } else {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统未确认买家');
        }

        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/buyer_end.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "seller_end" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT A.*,C.title FROM {$_pre}join A LEFT JOIN {$_pre}content C ON A.cid=C.id WHERE if_seller_end=1");

    $ajaxUlr = "../ly_adm/ajax_order.php";
    while($rs = $db->fetch_array($query)) {
        $rs[end_date] = date("Y-m-d h:i:s",$rs[end_date]);

        $gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$rs[cuid]'");
        $gutai_conf = unserialize($gutai_rs[config]);
        if($gutai_conf[gutai_pwd] && $gutai_conf[gutai_mobile]) {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统已确认买家');
        } else {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统未确认买家');
        }

        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/seller_end.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "gutai_withdraw" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT A.*, M.username FROM {$_pre}charge A LEFT JOIN home_members M ON A.uid=M.uid WHERE gutai_type='".iconv('UTF-8','GBK','提现')."'");

    while($rs = $db->fetch_array($query)) {
        $rs[posttime] = date("Y-m-d",$rs[posttime]);

        $gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$rs[cuid]'");
        $gutai_conf = unserialize($gutai_rs[config]);
        if($gutai_conf[gutai_pwd] && $gutai_conf[gutai_mobile]) {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统已确认买家');
        } else {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统未确认买家');
        }

        $listdb[] = $rs;
    }

    $ajaxUlr = "../ly_adm/ajax_order.php";

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/gutai_withdraw.htm");
    require(dirname(__FILE__)."/"."foot.php");
} elseif($job == "gutai_deposit" && $Apower[member_list]) {
    $listdb = array();
    $query = $db->query("SELECT A.*, M.username FROM {$_pre}charge A LEFT JOIN home_members M ON A.uid=M.uid WHERE gutai_type='".iconv('UTF-8','GBK','充值')."'");

    while($rs = $db->fetch_array($query)) {
        $rs[posttime] = date("Y-m-d",$rs[posttime]);

        $gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$rs[cuid]'");
        $gutai_conf = unserialize($gutai_rs[config]);
        if($gutai_conf[gutai_pwd] && $gutai_conf[gutai_mobile]) {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统已确认买家');
        } else {
            $rs[buyer_confirmed] = iconv('UTF-8','GBK','系统未确认买家');
        }

        $listdb[] = $rs;
    }

    require(dirname(__FILE__)."/"."head.php");
    require(dirname(__FILE__)."/"."template/order/gutai_deposit.htm");
    require(dirname(__FILE__)."/"."foot.php");
}

?>