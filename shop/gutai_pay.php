<?php
require("global.php");

if($action=='del'){
    del_order($id);
    refreshto($FROMURL,'',0);

}elseif($job=='pay'||$job=='send'||$job=='del'){
    $rsdb=$db->get_one("SELECT * FROM {$_pre}join WHERE id='$id'");
    if($rsdb[cuid]!=$lfjuid){
        showerr("你没权限!");
    }
    if($job=='pay'){
        $db->query("UPDATE {$_pre}join SET ifpay='$ifpay' WHERE id='$id'");
    }elseif($job=='send'){
        $db->query("UPDATE {$_pre}join SET ifsend='$ifsend' WHERE id='$id'");
    }
}

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
        $SQL=" A.uid='$lfjuid' ";
    }else{
        $SQL=" A.cuid='$lfjuid' ";
    }

    $query = $db->query("SELECT SQL_CALC_FOUND_ROWS A.*,B.* FROM {$_pre}join A LEFT JOIN {$_pre}content_2 B ON A.id=B.id WHERE $SQL ORDER BY A.id DESC LIMIT $min,$rows");

    $RS=$db->get_one("SELECT FOUND_ROWS()");
    $totalNum=$RS['FOUND_ROWS()'];
    $showpage=getpage("","","?job=$job",$rows,$totalNum);

    while($rs = $db->fetch_array($query))
    {
        if ($rs[fid]==null ) continue;
        $rs[shop]=$db->get_one("SELECT * FROM {$_pre}content WHERE id='$rs[cid]'");
        $i_posttime = $rs[posttime];
        $rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
        $rs[system_posttime]=date("Y-m-d H:i",$i_posttime+3600*24*10);
        if($job=='mylist'){	//我的订单
            if ($rs[shop][price] ==null) {
                $rs[shop][price] = $rs[totalmoney];
                $rs[shop][title] = "充值";
            }
            $rs[editurl]="../join.php?job=edit&id=$rs[id]&fid=$rs[fid]&cid=$rs[cid]' target='_blank";
            if($rs[ifpay]){
                $rs[pay]="<A style='color:red;'>已付</A>";
            }elseif($rs[totalmoney]){
                $rs[pay]="<A HREF='../shop/olpay.php?id=$rs[id]&fid=$rs[fid]' target='_blank'><u>去付款</u></A>";
            }else{
                $rs[pay]='';
            }

            if ($rs[ifend]) {
                $rs[complete] = "已终止";
            } else {
                $rs[complete] = $rs[ifpay]&&$rs[ifsend]? "完成": "<span style='color:green'>进行中</span>";
            }
            $rs[send]=$rs[ifsend]?"<A style='color:red;'>已发</A>":"未发";
        }else{	//客户订单
            $rs[pay]=$rs[ifpay]?"<A class='sp2' HREF='?job=pay&id=$rs[id]&ifpay=0' style='color:red;'>已付</A>":"<A class='sp2' HREF='?job=pay&id=$rs[id]&ifpay=1' style='color:#333333;'>未付</A>";
            $rs[send]=$rs[ifsend]?"<A class='sp2' HREF='?job=send&id=$rs[id]&ifsend=0' style='color:red;'>已发</A>":"<A class='sp2' HREF='?job=send&id=$rs[id]&ifsend=1' style='color:#333333;'>未发</A>";
            $rs[complete] = $rs[ifpay]&&$rs[ifsend]? "完成": "进行中";
            $rs[editurl]="?job=edit&id=$rs[id]";
        }
        $rs[ajaxurl] = "$Murl/../do/ajax_gutai.php";
        $listdb[]=$rs;
    }

    /***************************************************************/
    require(getTpl("gutai_pay"));
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