<?php
require_once(dirname(__FILE__).'/../inc/function.inc.php');
require_once(dirname(__FILE__)."/../".'inc/common.inc.php');

$db=new MYSQL_DB;
$rs=$db->get_one("SELECT * FROM `{$pre}upfile` WHERE uid='$lfjuid' and url='documents'");
$rs[filename] = str_replace('tmp-', '',$rs[filename]);
echo $rs[filename];


