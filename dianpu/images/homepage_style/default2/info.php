<?php
unset($array);
$page>1 || $page=1;
$rows=12;
$min=($page-1)*$rows;
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$pre}shop_content WHERE uid='$uid' ORDER BY id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
while($rs = $db->fetch_array($query)){
	$rs[picurl]=tempdir($rs[picurl]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$array[]=$rs;
}

$showpage=getpage("","","?m=$m&uid=$uid",$rows,$RS['FOUND_ROWS()']);




$rsdb[content] = En_TruePath($rsdb[content],0);
$rsdb[fname]=str_replace("|",",",$rsdb[fname]);
//得到绑定的图片
$show_bd_pics=show_bd_pics("{$_pre}company"," where uid=$uid",10);

?>

<!--
<?php
print <<<EOT
-->
<div class="lysw_main_r_tit_shop_tit">
    <div class="lysw_main_r_tit_shop_tit_c">商家简介</div>
	<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<div class="lysw_main_r_tit_shop_tit_c"><a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?&atn=info2' target='_blank'>修改简介</a></div>
<!--
EOT;
}
print <<<EOT
-->
  </div>
  <div class="cophome_l_home_cen heightbox">   
<table width="1010" border="0" cellspacing="0" cellpadding="0" class="rightinfo">
  
  <tr>
    <td class="content contmiddle">
<table width="980" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="750">
		<div style=' font-size:14px;font-weight:bold;padding:5px;'><font color='#004600'>$rsdb[title]</font> 概况</div>
		<div style="padding-left:10px;line-height:25px;">$rsdb[content]</div>
		<table width="100%" border="0" cellspacing="1" cellpadding="10" algin=center style='margin-top:10px;'>
              <tr> 
                <td width="20%" align="left">&nbsp;主营分类：</td>
                <td colspan="3" align="left">$rsdb[fname]&nbsp;&nbsp;</td>
              </tr>
              <tr> 
                <td width="20%" align="left">&nbsp;所属行业：</td>
                <td width="30%" align="left">$rsdb[my_trade]&nbsp;</td>
                <td width="20%" align="left">&nbsp;店铺类型：</td>
                <td width="30%" align="left">$rsdb[qy_cate]&nbsp;</td>
              </tr>
              <tr> 
                <td align="left">&nbsp;注册地址：</td>
                <td align="left">$rsdb[qy_regplace]&nbsp;</td>
                <td align="left">&nbsp;成立时间：</td>
                <td align="left">$rsdb[qy_createtime]&nbsp;</td>
              </tr>
              <tr> 
                <td align="left">&nbsp;主营产品或服务：</td>
                <td align="left" >$rsdb[qy_pro_ser]&nbsp;</td>
                <td align="left">&nbsp;主要采购产品：</td>
                <td align="left" >$rsdb[my_buy]&nbsp;</td>
              </tr>
            </table>
	</td>
	<td width="230" class="contacts">
		<div>$rsdb[qy_contact_email]</div>
		<div class="bold">$rsdb[qy_contact_tel]</div>
		<div class="bold">$rsdb[qy_contact_mobile]</div>
	</td>
</tr>
</table>	
	</td>
  </tr>
    <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
<!--
EOT;
if(!$m){
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
<li><a href="$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]"><img src="$rs[picurl]" width="236" height="179" border="0" /></a></li>
  <!--
EOT;
}
print <<<EOT
-->
    </div></div>
   
<!--
EOT;
}
if($show_bd_pics){
print <<<EOT
-->
<div class="lysw_main_r_tit_shop_tit">
    <div class="lysw_main_r_tit_shop_tit_c">企业资质 资料</div>
	</div>
	 <div class="cophome_l_home_cen heightbox"> 
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="rightinfo">
  
  <tr>
    <td class="content">
	$show_bd_pics
	</td></tr>
	</table>
	</div>
<!--
EOT;
}
?>
-->