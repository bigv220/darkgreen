<?php
require_once("global.php");

if(!$lfjuid){
    header("Location:".$webdb[www_url]."/do/login.php");
}

$fidDB=$db->get_one("SELECT A.* FROM {$_pre}sort A WHERE A.fid='$fid'");

if(!$fidDB){
	showerr("FID����!");
}
$fidDB[mid] = 1;

$infodb=$db->get_one("SELECT B.*,A.*,D.email FROM `{$_pre}content` A LEFT JOIN `{$_pre}content_$fidDB[mid]` B ON A.id=B.id LEFT JOIN `{$pre}memberdata` D ON A.uid=D.uid WHERE A.id='$cid'");

$fidDB[mid] = 2;
$contact_db=$db->get_one("SELECT B.* FROM `{$_pre}content_$fidDB[mid]` B LEFT JOIN `{$pre}memberdata` D ON b.uid=D.uid WHERE B.uid='$lfjuid' order by rid desc");

if(!$infodb){
	showerr("���ݲ�����");
}elseif($infodb[fid]!=$fid){
	showerr("FID����!!!");
}


//$totalmoney = number_format($shopnum*$infodb[price],2);
$totalmoney = $shopnum*$infodb[price];
$hownum = 1;

$infodb['is_ask'] = $_POST['is_ask'];
$mid=2;

/**
*ģ����������ļ�
**/
$field_db = $module_DB[$mid][field];


/**�����ύ���·�������**/
if($action=="postnew")
{
	if($shopnum<1){
		showerr("�����Ĳ�Ʒ����С��һ��!");
	}

	//�Զ����ֶεĺϷ���������ݴ���
	$Module_db->checkpost($field_db,$postdb,'');

	$rs=$db->get_one("SELECT * FROM `{$pre}purse` WHERE uid='$infodb[uid]'");
	$array=unserialize($rs[config]);
	
	if($postdb[order_sendtype]==2){			//ƽ��
		$totalmoney+=floatval($array[slow_send]);
	}elseif($postdb[order_sendtype]==3){	//���
		$totalmoney+=floatval($array[norm_send]);
	}elseif($postdb[order_sendtype]==4){	//EMS
		$totalmoney+=floatval($array[ems_send]);
	} else if($postdb[order_sendtype] == 5) {
        $totalmoney+=floatval($array[transfer_fee1]);
    } else if($postdb[order_sendtype] == 6) {
        $totalmoney+=floatval($array[transfer_fee2]);
    } else if($postdb[order_sendtype] == 7) {
        $totalmoney+=floatval($array[transfer_fee3]);
    }

	$totalmoney = number_format($totalmoney,2);

    $sellertext = stripcslashes($postdb[sellertext]);
    $buyertext = stripcslashes($postdb[buyertext]);
	/*������Ϣ���������*/
	$db->query("INSERT INTO `{$_pre}join` ( `mid` , `cid` , `cuid` , `fid` ,  `posttime` ,  `uid` , `username` , `yz` , `ip` , `shopnum` , `totalmoney`,`isagreement`,`sellertext`,`buyertext`,`ismodify`,`send_type`,`deliver_desc`)
	VALUES (
	'$mid','$cid','$infodb[uid]', '$fid','$timestamp','$lfjdb[uid]','$lfjdb[username]','0','$onlineip','$shopnum','$totalmoney','$postdb[isagreement]',\"$sellertext\",\"$buyertext\",'$postdb[ismodify]','$postdb[send_type]','$postdb[deliver_desc]')");

	$id = $db->insert_id();

	unset($sqldb);
	$sqldb[]="id='$id'";
	$sqldb[]="fid='$fid'";
	$sqldb[]="uid='$lfjuid'";

	
	/*����жϸ���Ϣ��Ҫ������Щ�ֶε�����*/
	foreach( $field_db AS $key=>$value){
		isset($postdb[$key]) && $sqldb[]="`{$key}`='{$postdb[$key]}'";
	}

	$sql=implode(",",$sqldb);

	$db->query("INSERT INTO `{$_pre}content_$mid` SET $sql");

	//$db->query("UPDATE {$_pre}content SET totaluser=totaluser+1 WHERE id='$cid'");
	


	if($webdb[order_send_mail]){
		send_mail($infodb[email],"���пͻ��¶�����","�뾡��鿴<A HREF='$Murl/member/joinshow.php?fid=$fid&id=$id' target='_blank'>$Murl/member/joinshow.php?fid=$fid&id=$id</A>",0);
	}
	if($webdb[order_send_msg]){
		send_msg($infodb[uid],"���пͻ��¶�����","�뾡��鿴<A HREF='$Murl/member/joinshow.php?fid=$fid&id=$id' target='_blank'>$Murl/member/joinshow.php?fid=$fid&id=$id</A>");
	}

	if($webdb[order_send_sms]){
		$rs=$db->get_one("SELECT mobphone FROM {$pre}memberdata WHERE uid='$infodb[uid]'");
		if($rs[mobphone]){
			$content=get_word("���пͻ��¶�����:$infodb[title]",68);
			sms_send($rs[mobphone],$content);
		}
	}

	//����֧��
	if($postdb['order_paytype']==4){
		header("location:olpay.php?id=$id&fid=$fid");
		exit;
	}else{
		refreshto("bencandy.php?city_id=$infodb[city_id]&fid=$fid&id=$cid","�����ɹ�,��ȴ�����!");
	}	
}

/*ɾ������,ֱ��ɾ��,������*/
elseif($action=="del")
{
	del_order($id);
	refreshto($FROMURL,"ɾ���ɹ�");
}

/*�༭����*/
elseif($job=="edit")
{
	$rsdb=$db->get_one("SELECT A.*,B.* FROM `{$_pre}join` A LEFT JOIN `{$_pre}content_$mid` B ON A.id=B.id WHERE A.id='$id'");

	if($rsdb[uid]!=$lfjuid&&!$web_admin)
	{
		showerr("����Ȩ�޸�");
	}

	$hownum=$rsdb[shopnum];

	/*��Ĭ�ϱ���������*/
	$Module_db->formGetVale($field_db,$rsdb);

	$atc="edit";	

	require(ROOT_PATH."inc/head.php");
	require(getTpl("post_$mid",$FidTpl['post']));
	require(ROOT_PATH."inc/foot.php");
}

/*�����ύ���������޸�*/
elseif($action=="edit")
{
	if($shopnum<1){
		showerr("�����Ĳ�Ʒ����С��һ��!");
	}
	$rsdb=$db->get_one("SELECT A.*,B.* FROM `{$_pre}join` A LEFT JOIN `{$_pre}content_$mid` B ON A.id=B.id WHERE A.id='$id' LIMIT 1");

	if($rsdb[uid]!=$lfjuid&&!$web_admin)
	{
		showerr("����Ȩ�޸�");
	}

	//�Զ����ֶεĺϷ���������ݴ���
	$Module_db->checkpost($field_db,$postdb,$rsdb);


	/*��������Ϣ������*/
	//$db->query("UPDATE `{$_pre}join` SET title='$postdb[title]' WHERE id='$id'");


	/*����жϸ���Ϣ��Ҫ������Щ�ֶε�����*/
	unset($sqldb);
	foreach( $field_db AS $key=>$value){
		$sqldb[]="`$key`='{$postdb[$key]}'";
	}	
	$sql=implode(",",$sqldb);

	/*���¸���Ϣ��*/
	$db->query("UPDATE `{$_pre}content_$mid` SET $sql WHERE id='$id'");
	$db->query("UPDATE `{$_pre}join` SET shopnum='$shopnum' WHERE id='$id'");
	
	refreshto("bencandy.php?city_id=$infodb[city_id]&fid=$fid&id=$cid","�޸ĳɹ�");
}
else
{
	if(!$web_admin && $infodb[uid]==$lfjuid){
		showerr("�㲻�ܶ����Լ������Ĳ�Ʒ!");
	}
	/*ģ������ʱ,��Щ�ֶ���Ĭ��ֵ*/
	foreach( $field_db AS $key=>$rs){	
		if($rs[form_value]){		
			$rsdb[$key]=$rs[form_value];
		}
	}

	$rs=$db->get_one("SELECT * FROM `{$pre}purse` WHERE uid='$infodb[uid]'");
	$conf=unserialize($rs[config]);

    $conf[slow_send] = intval($conf[slow_send]);
	$conf[norm_send] = intval($conf[norm_send]);
	$conf[ems_send] = intval($conf[ems_send]);
    $conf[transfer_comment] = $conf[transfer_comment];

    //5/6/7
    $deliver_array = array();
    if($conf[deliver_type1]) {
        $deliver_array[5] = array('id'=>1, 'deliver_type'=>$conf[deliver_type1], 'transfer_fee'=>$conf[transfer_fee1], 'transfer_comment'=>$conf[transfer_comment1]);
    }

    if($conf[deliver_type2]) {
        $deliver_array[6] = array('id'=>2, 'deliver_type'=>$conf[deliver_type2], 'transfer_fee'=>$conf[transfer_fee2], 'transfer_comment'=>$conf[transfer_comment2]);
    }

    if($conf[deliver_type3]) {
        $deliver_array[7] = array('id'=>3, 'deliver_type'=>$conf[deliver_type3], 'transfer_fee'=>$conf[transfer_fee3], 'transfer_comment'=>$conf[transfer_comment3]);
    }

    //�����ı�
    $seller_text = $infodb[sellertext];
    $if_changeable = $infodb[if_changeable] ? $infodb[if_changeable] : 1;

    $conf[default_sendtype] = $rsdb[order_sendtype];
	/*��Ĭ�ϱ���������*/
	$Module_db->formGetVale($field_db,$rsdb);

	$atc="postnew";

	require(ROOT_PATH."inc/head.php");
	require(getTpl("post_$mid"));
	require(ROOT_PATH."inc/foot.php");
}

?>