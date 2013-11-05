<?php
require("global.php");

    if ($lfjdb) {
        $uid = $lfjdb[uid];
    } else {
        header("Location:../do/login.php");
    }

$orders=array();

$query = $db->query("SELECT * FROM {$_pre}join");
while($rs = $db->fetch_array($query)) {
    $tmp_array = array();
    $tmp_array[sellertext] = $rs[sellertext];
    $tmp_array[buyertext] = $rs[buyertext];

    $orders[$rs[id]] = $tmp_array;
}

require(ROOT_PATH."inc/head_gutai.php");
    require(getTpl("gutai_paper"));
    require(ROOT_PATH."inc/footer_gutai.php");


?>