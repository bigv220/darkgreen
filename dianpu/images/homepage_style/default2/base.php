<!--
<?php
$rsdb[posttime]=date("Y-m-d",$rsdb[posttime]);
print <<<EOT
-->   
<div class="ly_shop_left1">
      <div class="ly_shop_left1_tit">商家档案</div>
      <div class="ly_shop_left1_link">

<center><a href="?uid=$uid"><img src="$rsdb[logo]"  border="0"  onload="this.width=120;" class="logo" onerror="this.src='$webdb[www_url]/images/default/nopic.jpg';" width="150"/></a>      </center>
<div class="baseinfo">
	<span><B>$rsdb[company_name_big]</B></span>
	<span>$rsdb[services]</span>
	<span>{$area_DB[name][$rsdb[province_id]]} {$city_DB[name][$rsdb[city_id]]} {$zone_DB[name][$rsdb[zone_id]]}{$street_DB[name][$rsdb[street_id]]}</span>
	<span>通行证：$rsdb[username]</span>
	<span>登记时间：$rsdb[posttime]</span>
	<span><a href="javascript:window.external.AddFavorite('$WEBURL','$titleDB[title]')"><img src='$Murl/images/homepage_style/$homepage_style/addcoll.gif' border=0 alt="收藏本商铺"></a></span>
	<span><a href='$webdb[www_url]/member/?main=pm.php?job=send&username=$rsdb[username]' target="_blank"><img src='$Murl/images/homepage_style/$homepage_style/sendmsg.gif' border=0 alt='发送站内信'></a></span>
</div>
</div></div>
<!--
EOT;
?>
-->