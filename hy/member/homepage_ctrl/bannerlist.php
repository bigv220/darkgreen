<?php
//ͼƬ�б�

//if(!$psid) showerr("����ʧ��");

//$rsdb=$db->get_one("SELECT * FROM {$_pre}picsort WHERE psid=0 LIMIT 1");

//if(!$rsdb) showerr("ϵͳ����");

//$rsdb[faceurl]=tempdir($rsdb[faceurl]);
$rows=14;

if($page<1){
	$page=1;
}

$min=($page-1)*$rows;
$query=$db->query("SELECT * FROM {$_pre}pic WHERE uid='$uid' AND psid=0 ORDER BY orderlist DESC LIMIT $min,$rows;");
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
	$rs[url]=tempdir($rs[url]);
	$listdb[]=$rs;
}
$showpage=getpage("{$_pre}pic"," WHERE uid='$uid' AND psid=0","?atn=$atn&uid=$uid&psid=$psid",$rows);


?>