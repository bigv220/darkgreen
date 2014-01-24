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

    if($job=='mylist'){
        $SQL=" A.uid='$lfjuid' and ifgutai=1 and ifpay=1";
    }else{
        $SQL=" A.cuid='$lfjuid'  and ifgutai=1 and ifpay=1";
    }

    $balance_arr = $db->get_one("SELECT gutai,mobphone FROM home_memberdata WHERE uid='$lfjuid'");

    $query = $db->query("SELECT SQL_CALC_FOUND_ROWS A.*,B.*,A.id as id,C.title,A.uid as uid FROM {$_pre}join A LEFT JOIN {$_pre}content_2 B ON A.id=B.id LEFT JOIN {$_pre}content C ON A.id=C.id WHERE $SQL ORDER BY A.id DESC LIMIT $min,$rows");

    $RS=$db->get_one("SELECT FOUND_ROWS()");
    $totalNum=$RS['FOUND_ROWS()'];
    $showpage=getpage("","","?job=$job",$rows,$totalNum);

    $totalmoney = 0;
    while($rs = $db->fetch_array($query))
    {
        //$rs[shop]=$db->get_one("SELECT * FROM {$_pre}content WHERE id='$rs[cid]'");
        $rs[totalmoney] = str_replace(',', '', $rs[totalmoney]);
        $totalmoney += intval($rs[totalmoney]);
        $rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
        $rs[endtime]=date("Y-m-d H:i",$rs[end_date]);
        if($job=='mylist'){	//我的订单
            $rs[editurl]="../join.php?job=edit&id=$rs[id]&fid=$rs[fid]&cid=$rs[cid]' target='_blank";
            if($rs[ifpay]){
                $rs[pay]="<A style='color:red;'>已付</A>";
            }elseif($rs[totalmoney]){
                $rs[pay]="<A HREF='../olpay.php?id=$rs[id]&fid=$rs[fid]' target='_blank'><u>付款</u></A>";
            }else{
                $rs[pay]='';
            }
            $rs[send]=$rs[ifsend]?"<A style='color:red;'>已发</A>":"未发";
        }else{	//客户订单
            $rs[pay]=$rs[ifpay]?"<A HREF='?job=pay&id=$rs[id]&ifpay=0' style='color:red;'>已付</A>":"<A HREF='?job=pay&id=$rs[id]&ifpay=1' style='color:#333333;'>未付</A>";
            $rs[send]=$rs[ifsend]?"<A HREF='?job=send&id=$rs[id]&ifsend=0' style='color:red;'>已发</A>":"<A HREF='?job=send&id=$rs[id]&ifsend=1' style='color:#333333;'>未发</A>";
            $rs[complete] = $rs[ifpay]&&$rs[ifsend]? "完成": "进行中";
            $rs[editurl]="?job=edit&id=$rs[id]";
        }
        $rs[ajaxurl] = "$Murl/../do/ajax_gutai.php";
        $rs[refundment_ajaxurl] = "$Murl/../ly_adm/ajax_order.php";
        $listdb[]=$rs;
    }

    $rs[ajaxurl] = "$Murl/../do/ajax_gutai.php";
    $refundment_ajaxurl = "$Murl/../ly_adm/ajax_order.php";
    $login_uid = $lfjuid;

    /***************************************************************/
    require(getTpl("gutai_money"));
    require(ROOT_PATH."inc/footer_gutai.php");
} else {
    require(ROOT_PATH."inc/head.php");
    require(getTpl("olpay"));
    require(ROOT_PATH."inc/foot.php");
}


function olpay_send(){
    global $db,$pre,$webdb,$banktype,$infodb,$timestamp,$lfjuid,$lfjid,$pay_code,$Murl;

    if(!$pay_code){
        showerr("数据有误!");
    }
    list($atc_moeny,$id)=explode("\t",mymd5($pay_code,'DE'));

    if($atc_moeny<0.01){
        showerr("总额不能小于1分钱!");
    }

    $numcode=$id;
    while(strlen($numcode)<10){
        $numcode="0$numcode";
    }

    $array[money]=$atc_moeny;
    $pay_code = str_replace('=','QIBO',$pay_code);	//这个符号“=”容易出问题
    if ($banktype =='chinapay') {
        $array[return_url]="$Murl/olpay.php";
    } else {
        $array[return_url]="$Murl/olpay.php?banktype=$banktype&pay_code=$pay_code&";
    }

    $array['priv1'] = $pay_code;
    $array['priv2'] = "pay_code=$pay_code";
    $array[title]="购买:$infodb[title]";
    $array[content]="购买:$infodb[title]";
    $array[numcode]=$numcode;
    return $array;
}

function olpay_end($numcode){
    global $db,$_pre,$webdb,$banktype,$pay_code,$lfjuid,$infodb;

    if(!$pay_code){
        showerr("数据有误!!");
    }

    list($atc_moeny,$id,$fid)=explode("\t",mymd5($pay_code,'DE'));

    $db->query("UPDATE {$_pre}join SET ifpay='1',banktype='$banktype' WHERE id='$id'");

    refreshto("bencandy.php?city_id=$infodb[city_id]&fid=$fid&id=$infodb[cid]","恭喜你订单付款成功!",60);
}

?>