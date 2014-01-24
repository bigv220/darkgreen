<?php
require("global.php");

if(!$array[yeepay_id]&&!$array[tenpay_id]&&!$array[alipay_id]&&!$array[pay99_id]) {
    $array[yeepay_id] = "808080231803147";
    $array[alipay_id] = 'emily1973@yahoo.cn';
    $order_id = date('ymdhs');

    require(ROOT_PATH."inc/head_gutai.php");
    if ($lfjdb) {
        $uid = $lfjdb[uid];
    } else {
        header("Location:../do/login.php");
    }
    $gutai_rs=$db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$lfjuid'");
    $gutai_conf = unserialize($gutai_rs[config]);


    /***************************************************************/
    $rows=15;

    if(!$page){
        $page=1;
    }
    $min=($page-1)*$rows;


    unset($listdb,$i);

    $opera = $_GET['opera'];

    $SQL=" A.uid='$lfjuid' AND gutai_type='$opera'";

    $query = $db->query("SELECT SQL_CALC_FOUND_ROWS A.* FROM {$_pre}charge A WHERE $SQL ORDER BY A.uid='$lfjuid' DESC LIMIT $min,$rows");

    $RS=$db->get_one("SELECT FOUND_ROWS()");
    $totalNum=$RS['FOUND_ROWS()'];
    $showpage=getpage("","","",$rows,$totalNum);

    $totalmoney = 0;
    while($rs = $db->fetch_array($query))
    {
        $rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
        $listdb[]=$rs;
    }



    /***************************************************************/
    require(getTpl("gutai_money_list"));
    require(ROOT_PATH."inc/footer_gutai.php");
}


?>