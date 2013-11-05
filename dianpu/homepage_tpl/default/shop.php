<?php
unset($array);
$page>1 || $page=1;
$rows=30;
$min=($page-1)*$rows;
if (isset($_GET['fid'])) {
    //$fid_where = "AND fid = '$_GET[fid]'";
}
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$pre}shop_content WHERE uid='$uid' $fid_where ORDER BY id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
$fid_arr = array();
while($rs = $db->fetch_array($query)){
    $fid_arr[$rs['fid']] = $rs['fid'];
    if (isset($_GET[fid]) && $_GET[fid] != $rs['fid']) {
        continue;
    }
	$rs[picurl]=tempdir($rs[picurl]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$array[]=$rs;
}
$fid_str = implode(',',$fid_arr);
$query2 = $db->query("SELECT * FROM {$pre}shop_sort WHERE fid in ($fid_str)");
$fid_content = array();
while ($rs2 = $db->fetch_array($query2)) {
    $fid_content[] = $rs2;
}
$link = "shome/?m=$m&uid=$uid";
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
    <div id="navsite" style="height:30px;clear:both;padding:8px 0 2px;"><ul>
    <li><a href="$webdb[www_url]/$link">所有分类</a></li>
<!--
EOT;
foreach($fid_content AS $fid_row){
    $name=get_word($fid_row[name],26);
    $fid = $fid_row[fid];
    print <<<EOT
-->
   <li><a href="$webdb[www_url]/$link&fid=$fid">$name</a></li>
 <!--
EOT;
}
print <<<EOT
-->
    </ul>
    </div>
  <div class="cophome_l_pro_cen">
  <div class="cophome_l_pro" id="cophome_l_pro1">
<!--
EOT;
foreach($array AS $rs){
$rs[title]=get_word($rs[title],26);
print <<<EOT
-->
<li><a href="$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]"><img src="$rs[picurl]" width="288" height="189" border="0" /></a>
<div style="padding-top:4px;font-weight:bold;"><a href="$rs[url]">$rs[title]</a></div>
</li>
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