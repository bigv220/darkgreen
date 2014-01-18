<?php
require_once("global.php");
session_start();
//print_r($_SESSION);
//unset($_SESSION['goods_in_cart']);
$order_num = count($_SESSION['goods_in_cart']);

if(!$lfjuid){
    header("Location:".$webdb[www_url]."/do/login.php");
}
// ��dianpu_company���ȡ��������
$uids = array_keys($_SESSION['goods_in_cart']);
if (!empty($uids)) {
    $uids = implode(',', $uids);
}

$order_db = array();

$fidDB=$db->get_one("SELECT A.* FROM {$_pre}sort A WHERE A.fid='$fid'");

if(!$fidDB){
	//showerr("FID����!");
}
if (!uid) {
    showerr("���̱������!");
}
$fidDB[mid] = 1;

$total = 0;
$today = date('Y-m-d');
$cid_str = "";
$dianpu_arr = array();

if (!empty($_SESSION)) {
    foreach($_SESSION['goods_in_cart'] as $key=>$value) {
        $dianpu_total = 0;
        foreach ($value as $cid=>$c_arr) {
            $cid_str .= $cid.',';
            $dianpu_total += $c_arr['price']*$c_arr['quantity'];
        }
        $total += $dianpu_total;
        $dianpu_arr[$key] = $dianpu_total;
    }
    $cid_str = substr($cid_str, 0, -1);
}

/**
 * ������������б�
 */
$query = $db->query("SELECT rid,uid,title,username FROM home_hy_company WHERE uid in ($uids)");

while($rs = $db->fetch_array($query)){
    $order_db[] = $rs;
}

/**
 * ��õ�ǰ���̵Ĳ�Ʒ�б�
 */
$query=$db->query("SELECT B.*,A.*,D.email FROM `{$_pre}content` A LEFT JOIN `{$_pre}content_$fidDB[mid]` B ON A.id=B.id LEFT JOIN `{$pre}memberdata` D ON A.uid=D.uid WHERE A.id in ($cid_str) AND A.uid=$lfjuid");
while($rs = $db->fetch_array($query)) {
    $rs['is_ask'] = $_POST['is_ask'];
    $rs['hownum'] = $_SESSION['goods_in_cart'][$uid][$rs['id']]['quantity'];
    $infodb[] = $rs;
}

$fidDB[mid] = 2;
$contact_db=$db->get_one("SELECT B.* FROM `{$_pre}content_$fidDB[mid]` B LEFT JOIN `{$pre}memberdata` D ON b.uid=D.uid WHERE B.uid='$lfjuid' order by rid desc");

if(!$infodb){
	showerr("���ݲ�����");
}elseif($infodb[0][fid]!=$fid){
	//showerr("FID����!!!");
}

$mid=2;

/**
*ģ����������ļ�
**/
$field_db = $module_DB[$mid][field];


/**�����ύ���·�������**/
if($action=="postnew")
{
    $shopnum = $_POST[shopnum];
	if($shopnum<1){
		showerr("�����Ĳ�Ʒ����С��һ��!");
	}

    $postdb = $_POST['postdb'];

    $totalmoney = $_POST[totalMoney]?$_POST[totalMoney]:0;

	//�Զ����ֶεĺϷ���������ݴ���
	$Module_db->checkpost($field_db,$postdb,'');

//	$rs=$db->get_one("SELECT * FROM `{$pre}purse` WHERE uid='$infodb[0][uid]'");
//	$array=unserialize($rs[config]);
//
//	if($postdb[order_sendtype]==2){			//ƽ��
//		$totalmoney+=floatval($array[slow_send]);
//	}elseif($postdb[order_sendtype]==3){	//���
//		$totalmoney+=floatval($array[norm_send]);
//	}elseif($postdb[order_sendtype]==4){	//EMS
//		$totalmoney+=floatval($array[ems_send]);
//	} else if($postdb[order_sendtype] == 5) {
//        $totalmoney+=floatval($array[transfer_fee1]);
//    } else if($postdb[order_sendtype] == 6) {
//        $totalmoney+=floatval($array[transfer_fee2]);
//    } else if($postdb[order_sendtype] == 7) {
//        $totalmoney+=floatval($array[transfer_fee3]);
//    }

	$totalmoney = number_format($totalmoney,2);

    $deliver_total = $_POST[deliverTotal]?$_POST[deliverTotal]:0;
    $infodb_uid = $infodb[0][uid];

    $sellertext = stripcslashes($postdb[sellertext]);
    $buyertext = stripcslashes($postdb[buyertext]);
	/*������Ϣ���������*/
	$db->query("INSERT INTO `{$_pre}join` ( `mid` , `cid` , `cuid` , `fid` ,  `posttime` ,  `uid` , `username` , `yz` , `ip` , `shopnum` , `totalmoney`,`isagreement`,`sellertext`,`buyertext`,`ismodify`,`send_type`,`deliver_desc`,`deliver_total`)
	VALUES (
	'$mid','$cid','$infodb_uid', '$fid','$timestamp','$lfjdb[uid]','$lfjdb[username]','0','$onlineip','$shopnum','$totalmoney','$postdb[isagreement]',\"$sellertext\",\"$buyertext\",'$postdb[ismodify]','$postdb[send_type]','$postdb[deliver_desc]','$deliver_total')");

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
		send_mail($infodb[0][email],"���пͻ��¶�����","�뾡��鿴<A HREF='$Murl/member/joinshow.php?fid=$fid&id=$id' target='_blank'>$Murl/member/joinshow.php?fid=$fid&id=$id</A>",0);
	}
	if($webdb[order_send_msg]){
		send_msg($infodb[0][uid],"���пͻ��¶�����","�뾡��鿴<A HREF='$Murl/member/joinshow.php?fid=$fid&id=$id' target='_blank'>$Murl/member/joinshow.php?fid=$fid&id=$id</A>");
	}

	if($webdb[order_send_sms]){
		$rs=$db->get_one("SELECT mobphone FROM {$pre}memberdata WHERE uid='$infodb[0][uid]'");
		if($rs[mobphone]){
			$content=get_word("���пͻ��¶�����:$infodb[0][title]",68);
			sms_send($rs[mobphone],$content);
		}
	}

	//����֧��
	if($postdb['order_paytype']==4){
		header("location:olpay.php?id=$id&fid=$fid");
		exit;
	}else{
		refreshto("bencandy.php?city_id=$infodb[0][city_id]&fid=$fid&id=$cid","�����ɹ�,��ȴ�����!");
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

	refreshto("bencandy.php?city_id=$infodb[0][city_id]&fid=$fid&id=$cid","�޸ĳɹ�");
}
else
{
	if(!$web_admin && $infodb[0][uid]==$lfjuid){
		showerr("�㲻�ܶ����Լ������Ĳ�Ʒ!");
	}
	/*ģ������ʱ,��Щ�ֶ���Ĭ��ֵ*/
	foreach( $field_db AS $key=>$rs){
		if($rs[form_value]){
			$rsdb[$key]=$rs[form_value];
		}
	}

	$rs=$db->get_one("SELECT * FROM `{$pre}purse` WHERE uid=".$infodb[0][uid]);
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
    $seller_text = $infodb[0][sellertext];
    $if_changeable = $infodb[0][if_changeable] ? $infodb[0][if_changeable] : 1;

    $conf[default_sendtype] = $rsdb[order_sendtype];
	/*��Ĭ�ϱ���������*/
	$Module_db->formGetVale($field_db,$rsdb);

	$atc="postnew";

	require(ROOT_PATH."inc/head.php");
	require(getTpl("post_$mid"));
	require(ROOT_PATH."inc/foot.php");
}

?>