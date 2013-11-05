<?php
$rsdb[content] = En_TruePath($rsdb[content],0);
if(!$m){
	$rsdb[content]=@preg_replace('/<([^>]*)>/is',"",$rsdb[content]);

	
	$rsdb[content]=get_word($rsdb[content],200)."<div style='text-align:right'><a href='?uid=$uid&m=info'>查看更多>>></a></div>";
	
	$rsdb[qy_contact_email] =str_replace("@","#",$rsdb[qy_contact_email]);
	$rsdb[show_qq]=getOnlinecontact('qq',$rsdb[qq]);
	$rsdb[show_msn]=getOnlinecontact('msn',$rsdb[msn]);
	$rsdb[show_ww]=getOnlinecontact('ww',$rsdb[ww]);
}
$rsdb[fname]=str_replace("|",",",$rsdb[fname]);
//得到绑定的图片
$show_bd_pics=show_bd_pics("{$_pre}company"," where uid=$uid",10);


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

?>

<!--
<?php
print <<<EOT
-->   

<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">公司简介</div>
	  <!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<div class="cophome_l_tit_tit"><a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?&atn=info2' target='_blank'>修改公司介绍</a></div>
<!--
EOT;
}
print <<<EOT
--></div>


<div class="cophome_l_cen">


<table width="97%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan=2 width='150' align=center><img src="$Murl/images/homepage_style/info.gif"  border="0"  class="logo" onerror="this.src='$webdb[www_url]/images/default/nopic.jpg';"/></td> <td>
	<b style=' font-size:14px;'><font color='#004600'>$rsdb[title]</font> 概况</b><br>
	<div  style='line-height:25px;'>$rsdb[content]</div>
	</td>
  </tr>
  <tr>
   
    <td>
	        <table width="100%" border="0" cellspacing="1" cellpadding="10" algin=center style='margin-top:10px;'>
              <tr> 
                <td width="20%" align="left">&nbsp;主营分类：</td>
                <td colspan="3" align="left">$rsdb[fname]&nbsp;&nbsp;</td>
              </tr>
              <tr> 
                <td width="20%" align="left">&nbsp;所属行业：</td>
                <td width="30%" align="left">$rsdb[my_trade]&nbsp;</td>
                <td width="20%" align="left">&nbsp;企业类型：</td>
                <td width="30%" align="left">$rsdb[qy_cate]&nbsp;</td>
              </tr>
              <tr> 
                <td align="left">&nbsp;注册资本：</td>
                <td align="left">$rsdb[qy_regmoney]万&nbsp;</td>
                <td align="left">&nbsp;经营模式：</td>
                <td align="left">$rsdb[qy_saletype]&nbsp;</td>
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
  </tr>
</table>

</div>
<!--
EOT;
print <<<EOT
-->
<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">产品供应</div>
    </div>
    <div class="cophome_l_pro">
<!--
EOT;
foreach($array AS $rs){
$rs[title]=get_word($rs[title],26);
print <<<EOT
-->
<li><a href="$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]"><img style="padding:0px;border:2px solid gray" src="$rs[picurl]" width="252" height="165" border="0" /></a>
<a href="$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]">$rs[title]</a>
</li>
  <!--
EOT;
}
print <<<EOT
-->
    </div>
<!--
EOT;
if($show_bd_pics){
print <<<EOT
-->
<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">企业资质 资料</div>
    </div>
    <div class="cophome_l_cen">$show_bd_pics</div>
<!--
EOT;
}
?>
-->