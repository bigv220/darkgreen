<?php
require(dirname(__FILE__)."/"."global.php");
//var_dump($_POST);
$lmid = empty($_POST[lmid])? $_GET[lmid] : $_POST[lmid];
$fid =  empty($_POST[fid])? $_GET[fid] : $_POST[fid];
//echo $lmid;

$GuideFid[$fid]=" > ��������";

if($action=="search")
{
	//if(!$lfjid)
	//{
		//showerr("���ȵ�¼");
	//}
	
	$keyword=trim($keyword);
	$keyword=str_replace("%",'\%',$keyword);
	$keyword=str_replace("_",'\_',$keyword);

	if(!$keyword)
	{
		showerr("�ؼ��ֲ���Ϊ��");
	}
	
	/*ÿҳ��ʾ500��*/
	$rows=500;
	if(!$page)
	{
		$page=1;
	}
	$min=($page-1)*$rows;

	/*ûָ��ģ���ģ�鸨��Ϣ������ʱ,������������Ϣ*/
	if(!$mid||!is_table("{$_pre}content_$mid"))
	{
		if($type=="username")
		{
			$field="username";
		}
		else
		{
			$field="title";
		}

		/*��ҳ*/
		$showpage=getpage("{$_pre}content","WHERE $field LIKE '%$keyword%'","?mid=$mid&keyword=$keyword&action=search&type=$type",$rows);

		$SQL="SELECT * FROM {$_pre}content WHERE $field LIKE '%$keyword%' LIMIT $min,$rows ";
	}
	else
	{
		if($type=="username"||$type=="title")
		{
			$field="A.$type";
		}
		elseif(table_field("{$_pre}content_$mid",$type))
		{
			$field="B.$type";
		}
		else
		{
			showerr("�ؼ���ָ�������Ͳ�����");
		}

		$_sql='';
		foreach( $postdb AS $key=>$value)
		{
			if( $value && table_field("{$_pre}content_$mid",$key) )
			{
				$_sql.=" AND B.`$key`='$value' ";
				$rsdb[$key][$value]=" selected ";
			}
		}
		
		//��ҳ����
		//$showpage=getpage("{$_pre}content A LEFT JOIN {$_pre}content_$mid B ON A.id=B.id","WHERE A.mid='$mid' AND $field LIKE '%$keyword%' $_sql","?mid=$mid&keyword=$keyword&action=search&type=$type",$rows);

		$SQL="SELECT A.*,B.* FROM {$_pre}content A LEFT JOIN {$_pre}content_$mid B ON A.id=B.id WHERE A.mid='$mid' AND $field LIKE '%$keyword%' $_sql LIMIT $min,$rows ";
	}

	$query = $db->query("$SQL");
	while($rs = $db->fetch_array($query))
	{
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
        //var_dump($rs);
        if(empty($lmid) || $lmid <=0 || $rs[lmid] == $lmid) //ָ����lmid(��ҳ��������, ��Ӧ��ť)
        {
            if(empty($fid) || $fid <=0 || $rs[fid] == $fid) //fid(��ҳ��������, ��Ӧ��ť)
            {
                $listdb[]=$rs;
            }
        }

	}

	if(!$listdb)
	{
		//showerr("��Ǹ, û������ѯ������");
	}
	$typedb[$type]=" checked ";
}

else
{
	$typedb[title]=" checked ";
}

$mid=intval($mid);

$colordb[$mid]="red;";
if($mid){
	require(getTpl("search_$mid"));
}else{
	require(getTpl("search"));
}
?>