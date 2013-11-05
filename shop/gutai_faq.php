<?php
require("global.php");

    if ($lfjdb) {
        $uid = $lfjdb[uid];
    } else {
        header("Location:../do/login.php");
    }
require(ROOT_PATH."inc/head_gutai.php");
    require(getTpl("gutai_faq"));
    require(ROOT_PATH."inc/footer_gutai.php");


?>