<?php
unset($array);
$page>1 || $page=1;
$rows=30;
$min=($page-1)*$rows;
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$pre}shop_content WHERE uid='$uid' ORDER BY id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
while($rs = $db->fetch_array($query)){
	$rs[picurl]=tempdir($rs[picurl]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$array[]=$rs;
}

$showpage=getpage("","","?m=$m&uid=$uid",$rows,$RS['FOUND_ROWS()']);
?>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<!--
<?php
print <<<EOT
-->
<div class="lysw_main_r_tit_shop_tit">
    <div class="lysw_main_r_tit_shop_tit_c">产品供应</div>
  </div>
  <div class="cophome_l_pro_cen">
  <div class="cophome_l_pro" id="cophome_l_pro1">
<!--
EOT;
foreach($array AS $rs){
$rs[title]=get_word($rs[title],26);
print <<<EOT
-->
<li><a href="$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]"><img src="$rs[picurl]" width="146" height="125" border="0" /></a></li>
  <!--
EOT;
}
print <<<EOT
-->
    </div></div>
    <div class="cophome_l_cen" style="width:1010px;"><div class="page">$showpage</div>
</div>
<!--
EOT;
?>
-->