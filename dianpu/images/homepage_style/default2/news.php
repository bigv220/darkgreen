<?php
unset($listdb);
if($m){
	$rows=$conf[listnum][Mnewslist]?$conf[listnum][Mnewslist]:20;
}else{
	$rows=$conf[listnum][newslist]?$conf[listnum][newslist]:5;
}
	
$rows=20;
if($page<1){
	$page=1;
}
$min=($page-1)*$rows;
$where=" WHERE uid='$rsdb[uid]' AND yz=1 ";
$query=$db->query("SELECT * FROM {$_pre}news $where ORDER BY posttime DESC LIMIT $min,$rows");
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);	//把HTML代码过滤
	$rs[content]=get_word(str_replace("&nbsp;","",$rs[content]),200);
	$listdb[]=$rs;
}	
	
$showpage=getpage("{$_pre}news",$where,"?uid=$uid&m=$m",$rows);
$mod_in=$mod_in?$mod_in:'right';
?>
<!--
<?php
print <<<EOT
-->

<!--
EOT;
if($mod_in=='left'){
print <<<EOT
-->	
<div class="ly_shop_left1">
<div class="ly_shop_left1_tit">公司新闻</div>
<div class="ly_shop_left1_link">
<!--
EOT;
foreach($listdb as $rs){
$rs[title]=get_word($rs[title_full]=$rs[title],20);
print <<<EOT
-->

 > <a href="homepage.php?uid=$uid&m=newsview&id=$rs[id]"  title='$rs[posttime]-$rs[title_full]'>$rs[title]</a><br>


<!--
EOT;
}
}else{
print <<<EOT
-->
<div class="lysw_main_r_tit_shop_tit">
    <div class="lysw_main_r_tit_shop_tit_c">公司新闻</div>
	<!--
EOT;
if($lfjuid==$uid && $mod_in=='right'){
	
print <<<EOT
-->
	<div class="lysw_main_r_tit_shop_tit_c"><a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=news' target='_blank'>管理新闻</a></div><div class="lysw_main_r_tit_shop_tit_c"> <a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=postnews' target='_blank'>发布新闻</a> </div>
<!--
EOT;
}
print <<<EOT
-->
  </div>
  <div class="cophome_l_pro_cen">
<table width="98%" border="0" cellspacing="0" cellpadding="0">
<!--
EOT;
foreach($listdb as $rs){

print <<<EOT
-->
<tr>
    <td height=15></td>
  </tr>

  <tr>
    <td height=15>【$rs[posttime]】<a href="homepage.php?uid=$uid&m=newsview&id=$rs[id]"  >$rs[title]</a></td>
  </tr>
  


<!--
EOT;
}
print <<<EOT
-->
</table>
<div class="page">$showpage</div>

<!--
EOT;
}
print <<<EOT
-->
</div></div></div>
	
 
<!--
EOT;
?>
-->