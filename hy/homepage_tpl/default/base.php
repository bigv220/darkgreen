<!--
<?php
$rsdb[posttime]=date("Y-m-d",$rsdb[posttime]);
print <<<EOT
-->
<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">�̼ҵ���</div>
	  <!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<div class="cophome_l_tit_tit"><a href='$webdb[www_url]/member/?main=$Mdomain/member/homepage_ctrl.php?atn=info&uid=$uid' target='_blank'>����</a></div> 
<!--
EOT;
}
print <<<EOT
-->
    </div>
    <div class="cophome_l_cen">
	<center><a href="?uid=$uid"><img src="$rsdb[logo]"  border="0"  onload="this.width=150;"  class="logo" onerror="this.src='$webdb[www_url]/images/default/nopic.jpg';"/></a>      </center>

<center><B>$rsdb[company_name_big]</B></center>
<center>$rsdb[services]</center>
<center>{$area_DB[name][$rsdb[province_id]]} {$city_DB[name][$rsdb[city_id]]} {$zone_DB[name][$rsdb[zone_id]]} {$street_DB[name][$rsdb[street_id]]}</center>

<center>ͨ��֤��$rsdb[username]</center>
<center>�Ǽ�ʱ�䣺$rsdb[posttime]</center>
<center>		
<a href="javascript:window.external.AddFavorite('$WEBURL','$rsdb[title]')"><img src='$Murl/images/homepage_style/addcoll.gif' border=0 alt="�ղر�ҳ"></a>
<a href='$webdb[www_url]/member/?main=pm.php?job=send&username=$rsdb[username]' target="_blank"><img src='$Murl/images/homepage_style/sendmsg.gif' border=0 alt='����վ����'></a>	</center>
</div>   
<!--
EOT;
?>
-->