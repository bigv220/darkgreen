<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--<?php
$sitetitle = "搜索－".$webdb[Info_webname]."－".$webdb['webname'];
$useractword = $lfjid ? "<a href=\"$webdb[www_url]/member/\" target=\"_blank\">管理</a> | <a href=\"$webdb[www_url]/do/login.php?action=quit\" class='b'>退出</a>" : "<a href=\"$webdb[www_url]/do/reg.php\">注册</a> | <a href=\"$webdb[www_url]/do/login.php\" class='b'>登录</a>" ;
$type = $type ? $type : "title";
$keywords = $keyword ? $keyword : "请输入您要查找的内容";
$typedb[$type] = "checked";
$showinfo = "";
print <<<EOT
-->
<head>
    <title>$sitetitle</title>
    <link rel="stylesheet" type="text/css" href="$webdb[www_url]/images/default/s/s.css">
    <link rel=stylesheet id="themecss" type="text/css" rev="stylesheet" href="$webdb[www_url]/images/default/s/s1.css">

    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <meta name="keywords" content="$titleDB[keywords]">
    <meta name="description" content="$titleDB[description]">
    <script src="$webdb[www_url]/hy/images/default/jquery.js" type="text/javascript"></script>
</head>
<body ondblclick="$bodyondblclick">
<div class="TopContainer">
    $useractword
</div>
<div class="Hearder">
    <div class="logo"><a href="$webdb[www_url]/news/s.php"><img src="$webdb[www_url]/images/default/s/logo.jpg"/></a></div>
    <div class="searchcont">
        <ul class="module">
            <li class="begin"><span><a href="$webdb[www_url]/hy/s.php?action=$action&keyword=$keyword&type=$type">行业.企业</a></span></li>
            <li><span><a href="$webdb[www_url]/f/s.php?action=$action&keyword=$keyword&type=$type">产品.物资</a></span></li>
            <li ><span><a href="$webdb[www_url]/news/s.php?action=$action&keyword=$keyword&type=$type">商贸资讯</a></span></li>
            <li ><span><a href="$webdb[www_url]/dianpu/s.php?action=$action&keyword=$keyword&type=$type">商铺</a></span></li>
            <li class="ck"><span><a href="$webdb[www_url]/shop/s.php?action=$action&keyword=$keyword&type=$type">绿页城市</a></span></li>
            <li><span><a href="$webdb[www_url]/f/s.php?action=$action&keyword=$keyword&type=$type">分类.信息</a></span></li>
            <li><span><a href="$webdb[www_url]/gift/s.php?action=$action&keyword=$keyword&type=$type">礼品</a></span></li>
        </ul>
        <form name="form" method="post" action="?" onsubmit="return checkpost();">
            <div class="keyword">
                <input name="keyword" type="text" value="$keywords" onClick="changeInputStatus(this)" onblur="backInputStatus(this)"/>
            </div>
            <div class="type">
                <span class="input"><input name="type" type="radio" value="title" $typedb[title] /></span>
                <span>标题</span>
                <span class="input"><input type="radio" name="type" value="username" $typedb[username] /></span>
                <span>发布者</span>
            </div>
            <div class="submit"><input name="Submit" type="image" src="$webdb[www_url]/images/default/s/sub.gif" /></div>
            <input type="hidden" name="action" value="search">
        </form>
        <div class="showinfo">$showinfo</div>
    </div>
</div>
<div class="Container">
    <div class="Mhead">
        <ul id="themelist">
            <li class="current" id="theme1"><a href="javascript:;">显示侧边栏</a></li>
            <li id="theme2"><a href="javascript:;">隐藏侧边栏</a></li>
        </ul>
    </div>
    <div class="Mcont">
        <div class="sideL">
            <dl class="showsort">
                <dt style="font-size:15px;color:#000;font-weight: bold;">行业.企业版</dt>
                <dd>
                    <!--
                    EOT;
                    foreach($Fid_db[0] AS $key=>$value){
                    $boldcss=$fid==$key?" style=\"font-weight:bold;\"":"";
                    print <<<EOT
                    -->
                    <div><a href="s.php?action=$action&keyword=$keyword&type=$type&fid=$key"{$boldcss}>{$Fid_db[name][$key]}</a></div>
                    <!--
                    EOT;
                    }
                    print <<<EOT
                    -->
                </dd>
            </dl>
        </div>
        <div class="cophome_l_pro">


            <!--
            EOT;
            foreach($pdb AS $key=>$rs){
            $rs[title]=str_replace($keyword,"<span>".$keyword."</span>",$rs[title]);
            print <<<EOT
            -->

            <li><a href="$rs[url]"><img src="$webdb[www_url]/upload_files/$rs[picurl]" onerror="this.src='$webdb[www_url]/images/default/nopic.jpg'" width="146" height="125" border="0" /></a>
                <div style="padding:3px 0 2px 0;font-weight:bold;"><a href="$rs[url]">$rs[title]</a></div>
                浏览(<span>{$rs[hits]}</span>)次<br/><span>{$rs[posttime]}</span>发布
            </li>
            <!--
            EOT;
            }print <<<EOT
            -->

            <div class="page">$showpage</div>
        </div>
        <div class="MainC">
            <!--
            EOT;
            foreach($listdb AS $key=>$rs){
            $rs[title]=str_replace($keyword,"<span>".$keyword."</span>",$rs[title]);
            print <<<EOT
            -->
            <ul>
                <li class="t"><a href="$webdb[www_url]/home/?uid=$rs[uid]" target="_blank">$rs[title]</a></li>
                <li class="c">{$content}</li>
                <li class="m">
                    浏览(<span>{$rs[hits]}</span>)次
                    <span>{$rs[posttime]}</span>发布
                </li>
            </ul>
            <!--
            EOT;
            }print <<<EOT
            -->
            <div class="page">$showpage</div>
        </div>
        <div class="sideR">
            <dl class="hotsearch">
                <dt>热门搜索</dt>
                <dd>
                    <div><a href="?action=search&keyword=教程&type=title">教程</a></div>
                    <div><a href="?action=search&keyword=伪静态&type=title">伪静态</a></div>
                    <div><a href="?action=search&keyword=出租&type=title">出租</a></div>
                    <div><a href="?action=search&keyword=便宜&type=title">便宜</a></div>
                </dd>
            </dl>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<div class="FootCont"></div>
<SCRIPT LANGUAGE="JavaScript">
    <!--
    function changeInputStatus(this1) {
        if(this1.value.indexOf('请输入您要查找的')!=-1)this1.value='';
        $('input[name=keyword]').css('background-color','#FFF');
    }
    function backInputStatus(this1) {

    }
    var Theme = {
        cookieName: "themeIndexTom",
        themeList: null,
        init: function(){
            Theme.themeList = document.getElementById('themelist');
            var list = Theme.themeList.getElementsByTagName('a');
            oThis = this;
            for( var i = 0; i < list.length; i++ ){
                (function(){
                    var index = i + 1;
                    list[index - 1].onclick = function(){
                        oThis.setCss(index);
                        oThis.setCurrent(index);
                        oThis.setCookie(Theme.cookieName, index);
                        return false;
                    };
                })();
            }

            var cookieIndex = this.getCookie(this.cookieName);
            if(cookieIndex == null){
                this.setCookie(this.cookieName, 1);
                Theme.setCss(1);
            }else{
                Theme.setCss(cookieIndex);
                Theme.setCurrent(cookieIndex);
            }
        },
        setCurrent: function(index){
            var list = Theme.themeList.getElementsByTagName('li');
            for( var i = 0; i < list.length; i++ ){
                if(index == i + 1)
                    list[i].className = 'current';
                else
                    list[i].className = '';
            }
        },

        setCss: function(index){
            document.getElementById('themecss').href = "$webdb[www_url]/images/default/s/s" + index + ".css";
        },
        getCookie: function(name){
            var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
            if(arr != null) return unescape(arr[2]); return null;
        },
        setCookie: function	(name,value){
            var Days = 30; //此 cookie 将被保存 30 天
            var exp  = new Date();    //new Date("December 31, 9998");
            exp.setTime(exp.getTime() + Days*24*60*60*1000);
            document.cookie = name + "="+ escape(value) +";expires="+ exp.toGMTString()+";path=/" ;
        }
    }
    Theme.init();
    //-->
</SCRIPT>
</body>
</html>
<!--
EOT;
?>
-->

