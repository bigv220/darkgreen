<?php
unset($array);
$page>1 || $page=1;
$rows=12;
$min=($page-1)*$rows;
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS B.*,A.* FROM {$pre}coupon_content A LEFT JOIN {$pre}coupon_content_1 B ON A.id=B.id WHERE A.uid='$uid' ORDER BY A.id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
while($rs = $db->fetch_array($query)){
	$rs[picurl]=tempdir($rs[picurl]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$array[]=$rs;
}

$showpage=getpage("","","?m=$m&uid=$uid",$rows,$RS['FOUND_ROWS()']);
?>

<!--
<?php
print <<<EOT
-->
<div class="lysw_main_r_tit_shop_tit">
    <div class="lysw_main_r_tit_shop_tit_c">优惠促销</div>
  </div>
  <div class="cophome_l_pro_cen"> 
	<div class="cophome_l_procoupon">
<!--
EOT;
foreach($array AS $rs){
print <<<EOT
-->
      <li><table width="100%" border="0" cellspacing="0" cellpadding="0" class="couponlist">
        <tr> 
          <td align="center" class="ig" width="50%"><a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank"><img src="$rs[picurl]"   onerror="this.src='$webdb[www_url]/images/default/nopic.jpg'" width="160" height="120" border="0"></a></td>
          <td align="left" width="50%" valign="top" class="des"> <a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank"> 
            <font color="#CC0000"><b>$rs[title]</b></font> </a><br>
             市场价： <strike><span style="color:#333333;font-size:21px;">￥{$rs[mart_price]} 元</span></strike> <br>
            优惠价: <span style="color:#FF0000;font-size:21px;">{$rs[price]}元</span> <br>
            截止日期:$rs[end_time]</td>
        </tr>
      </table></li>
      <!--
EOT;
}
print <<<EOT
-->
   <div class="page">$showpage</div>
   </div></div>
<!--
EOT;
?>
-->