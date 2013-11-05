<?php
if ($_REQUEST['act'] == 'remove')
{
	$goods_id   = intval($_POST['id']);
	echo $goods_id;
	$shoplisthome=$db->query("SELECT * FROM home_shop_content WHERE fid='$goods_id' LIMIT 50");
    make_json_result(stripslashes($goods_id));

}

require(dirname(__FILE__)."/do/main.php");
?>