<?php
if($id){
	$data=$db->get_one("SELECT * FROM {$_pre}news WHERE id='$id'");
	//��ʵ��ַ��ԭ
	$data[content]=En_TruePath($data[content],0);
	$data[posttime] =date("Y-m-d",$data[posttime] );

	//�õ��󶨵�ͼƬ
	$show_bd_pics=show_bd_pics("{$_pre}news"," WHERE id=$id");
	$db->query("UPDATE `{$_pre}news` SET hits=hits + 1  WHERE id='$id'");
}
?>

<!--
<?php
if($id){
if($data[uid]!=$lfjuid && !$data[yz]){
print <<<EOT
-->   
    
��Ϣ���������...
<!--
EOT;
	}else{
print <<<EOT
-->   
<div class="lysw_main_r_tit_shop_tit">
    <div class="lysw_main_r_tit_shop_tit_c">��˾����</div>
	<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<div class="lysw_main_r_tit_shop_tit_c"><a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=postnews&uid=$uid&id=$id' target='_blank'>�༭</a></div><div class="lysw_main_r_tit_shop_tit_c"><a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=delnews&uid=$uid&id=$id' target='_blank'>ɾ��</a></div> 
<!--
EOT;
}
print <<<EOT
-->
  </div>
  <div class="cophome_l_pro_cen">    
<table width="98%" border="0" cellspacing="0" cellpadding="0"  class="rightinfo">
 
  <tr>
    <td  class="content contmiddle">
<center style='font-size:16px;'><strong>$data[title]</strong></center>
<center style='border-bottom:1px #454646 dotted'>ʱ�䣺$data[posttime] �����$data[hits]�� </center>
<br>
<div>$show_bd_pics</div>
<div><table class="content" width="100%" cellspacing="0" cellpadding="0" style='TABLE-LAYOUT: fixed;WORD-WRAP: break-word'>
              <tr> 
                <td>$data[content]</td>
              </tr>
            </table></div>

	</td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table>
</div>
 
<!--
EOT;
}
}
?>
-->