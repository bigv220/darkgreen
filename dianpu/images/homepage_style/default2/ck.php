<?php
unset($listdb);
$query=$db->query("SELECT * FROM {$_pre}friendlink WHERE uid='$uid' AND yz=1 ");
while($rs=$db->fetch_array($query)){
	$listdb[]=$rs;	
}
?>
<!--
<?php
print <<<EOT
-->
<div class="ly_shop_left1">
      <div class="ly_shop_left1_tit">”—«È¡¥Ω”</div>
      <div class="ly_shop_left1_link">    
<!--
EOT;
foreach($listdb as $rs){
print <<<EOT
-->
<li><a href="{$rs[url]}" target="_blank">$rs[title]</a></li>
<!--
EOT;
}
print <<<EOT
-->
</div></div>
<!--
EOT;
unset($listdb);
?>
-->