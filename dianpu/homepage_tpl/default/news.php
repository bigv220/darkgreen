<?php
unset($listdb);
if($m){
	$rows=$conf[listnum][Mnewslist]?$conf[listnum][Mnewslist]:20;
}else{
	$rows=$conf[listnum][newslist]?$conf[listnum][newslist]:5;
}
	
$rows=10;
if($page<1){
	$page=1;
}
$min=($page-1)*$rows;
$where=" WHERE uid='$rsdb[uid]' AND yz=1 ";
$query=$db->query("SELECT * FROM {$_pre}news $where ORDER BY posttime DESC LIMIT $min,$rows");
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);	//��HTML�������
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
<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">��˾����</div>
    </div>
    <div class="cophome_l_cen">

<!--
EOT;
if($lfjuid==$uid && $mod_in=='right'){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=news' target='_blank'>��������</a> | <a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=postnews' target='_blank'>��������</a> 
<!--
EOT;
}
print <<<EOT
-->
<!--
EOT;
if($mod_in=='left'){

foreach($listdb as $rs){
$rs[title]=get_word($rs[title_full]=$rs[title],30);
print <<<EOT
-->

 ��<a href="homepage.php?uid=$uid&m=newsview&id=$rs[id]"  title='$rs[posttime]-$rs[title_full]'>$rs[title]</a><br>


<!--
EOT;
}

}else{
print <<<EOT
-->
<!--
EOT;
foreach($listdb as $rs){

print <<<EOT
-->

<!--
EOT;
}
print <<<EOT
-->
<!--
EOT;
}
print <<<EOT
-->
	
	
</div>
 
<!--
EOT;
?>
-->