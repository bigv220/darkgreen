<?php
require(dirname(__FILE__)."/"."global.php");
//var_dump($_POST);
$GuideFid[$fid]=" > ��������";

if($action=="search")
{
    //if(!$webdb[Info_allowGuesSearch]&&!$lfjid)
    //{
    //showerr("���ȵ�¼");
    //}

    $keyword=trim($keyword);
    $keyword=str_replace("%",'\%',$keyword);
    $keyword=str_replace("_",'\_',$keyword);

    if(!$keyword)
    {
        //showerr("�ؼ��ֲ���Ϊ��");
    }

    /*ÿҳ��ʾ50��*/
    $rows=48;
    if(!$page)
    {
        $page=1;
    }
    $min=($page-1)*$rows;

    $_SQL=" WHERE title LIKE '%$keyword%' or uid='$keyword' ";

    $showpage=getpage("home_hy_company A",$_SQL,"?fid=$fid&keyword=$keyword&action=search&type=$type",$rows);

    $query = $db->query("SELECT * FROM home_hy_company A $_SQL ORDER BY A.posttime DESC LIMIT $min,$rows ");
    while($rs = $db->fetch_array($query))
    {
        //var_dump($rs);
        $rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
        $rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);
        $rs[content]=get_word($rs[content],150);
        $rs[url]= "$webdb[www_url]/company.$rs[uid]";
        $listdb[]=$rs;
    }

    $SQL_shop="SELECT * FROM home_shop_content WHERE title LIKE '%$keyword%' or uid='$keyword' LIMIT $min,$rows ";
    $query = $db->query($SQL_shop);

    while($rs = $db->fetch_array($query))
    {
       // var_dump($rs);
        $rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
        $rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);
        $rs[content]=get_word($rs[content],150);
        $rs[url]= "$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]";
        $listdb[]=$rs;
    }


    if(!$listdb)
    {
        //showerr("��Ǹ, û������ѯ������");
    }

    if(!$keyword){
        //����ʾ�κ�����
         $listdb = array();
        $showpage = "";
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