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
   <div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">��˾����</div>
	  <!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	  
	  <div class="cophome_l_tit_tit"><a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=postnews&uid=$uid&id=$id' target='_blank'>�༭</a> | <a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=delnews&uid=$uid&id=$id' target='_blank'>ɾ��</a> </div>
	  <!--
EOT;
}
print <<<EOT
-->
    </div>
    <div class="cophome_l_cen"> 

<center style='font-size:16px;'><strong>$data[title]</strong></center>
<center style='border-bottom:1px #454646 dotted'>ʱ�䣺$data[posttime] �����$data[hits]�� </center>
<br>
$data[content]
</div>
 
<!--
EOT;
}
}
?>
-->