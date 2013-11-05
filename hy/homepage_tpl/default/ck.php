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
<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">”—«È¡¥Ω”</div>
    </div>
    <div class="cophome_l_cen">   
<!--
EOT;
foreach($listdb as $rs){
print <<<EOT
-->
<div style='padding-left:20px;'>
<div>°§<a href="{$rs[url]}" target="_blank">$rs[title]</a>
</div>
</div>

<!--
EOT;
}
print <<<EOT
-->
	

</div>

   
 
<!--
EOT;
unset($listdb);
?>
-->