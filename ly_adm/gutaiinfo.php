<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sophia
 * Date: 13-12-1
 * Time: 下午4:43
 * To change this template use File | Settings | File Templates.
 */
require_once("global.php");

$uid = $_GET['uid'];
$rs = $db->get_one("SELECT * FROM `{$pre}gutai_bank` WHERE uid='$uid'");
$gutai_conf = unserialize($rs[config]);

require(dirname(__FILE__)."/"."template/gutaiinfo.htm");
?>
