<?php
function biz_url_ck( $BIZ_URLDB )
{
global $db;
global $_SERVER;
global $HTTP_SERVER_VARS;
global $PHP_SELF_TEMP;
if ( !$GLOBALS['IIIIIIIIII1l']( $BIZ_URLDB ) )
{
exit( '保证系统运行更稳定');
}
else
{
$BIZ_URLDB[] = '127.0.0.1';
$BIZ_URLDB[] = '192.168.';
$BIZ_URLDB[] = 'localhost';
$PHP_SELF_TEMP = $_SERVER['PHP_SELF'] ?$_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$PHP_SELF = $_SERVER['REQUEST_URI'] ?$_SERVER['REQUEST_URI'] : $PHP_SELF_TEMP;
$HTTP_HOST = $_SERVER['HTTP_HOST'] ?$_SERVER['HTTP_HOST'] : $HTTP_SERVER_VARS['HTTP_HOST'];
$WEBURL = $HTTP_HOST.$PHP_SELF;
if ( !$WEBURL )
{
$allowuse = 1;
}
else
{
foreach ( $BIZ_URLDB as $key =>$value )
{
if ( $GLOBALS['IIIIIIIIIlI1']( "^[-a-z0-9_\\.]*{$value}",$WEBURL ) )
{
$allowuse = 1;
}
}
}
if ( !$allowuse )
{
exit( '非法用户禁止使用');
}
return 1;
}
}
function info_ck( )
{
}
function module_ck( $type )
{
global $pre;
global $BIZ_MODULEDB;
if ( !$GLOBALS['IIIIIIIIII1l']( $BIZ_MODULEDB ) )
{
exit( '保证系统运行更稳定');
}
else
{
if ( !$GLOBALS['IIIIIIIIIl11']( $type,$BIZ_MODULEDB ) )
{
exit( '此模块未经使用');
}
return 1;
}
}
if ( !function_exists( 'AvoidGather') )
{
exit( 'Ff');
}
unset( $BIZ_URLDB );
$BIZ_URLDB[] = "{$key}";
if ( $BIZID &&$BIZ_URLDB )
{
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">";
echo '你的ID是:<br>';
echo md5( "{$BIZ_URLDB['0']}");
exit( );
}
$life_more = 1;
$BIZ_MODULEDB[] = 'dianping';
$BIZ_MODULEDB[] = 'fenlei';
$BIZ_MODULEDB[] = 'coupon';
$BIZ_MODULEDB[] = 'gift';
$BIZ_MODULEDB[] = 'hr';
$BIZ_MODULEDB[] = 'shop';
$BIZ_MODULEDB[] = 'tg';
$IS_BIZPhp168 = 1;
$IS_BIZ = 1;
?>