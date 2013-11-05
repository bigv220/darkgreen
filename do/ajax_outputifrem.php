<?php
require(dirname(__FILE__)."/global.php");
?>
<META HTTP-EQUIV="pragma" CONTENT="no-cache"> 
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate"> 
<META HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT"> 
<script type="text/javascript" src="/images/default/index.js"></script>
<link rel="stylesheet" type="text/css" href="/images/default/common.css">
<div class="ly_main_right_list">
    <div id="ly_main_right_list_box_cen">
    <div id="ly_main_right_list_box">

        <div id="scrollbox">
            <div id="scrollcon">
                <div id="scrollpic">
                <?php

$q = $_GET[id];
$querypro = $db->query("SELECT * FROM home_shop_content WHERE fid in (select fid from home_shop_sort where fup='$q')  AND city_id=$city_id AND yz=1  LIMIT 50 "); //AND level=1

while($key = $db->fetch_array($querypro)){
	echo "<a href=/shop/bencandy-htm-fid-$key[fid]-id-$key[id].html title=$key[title] target=_top><img src='http://www.darkgreen.cn/upload_files/$key[picurl]' width=190 height=127 alt=$key[title] title=$key[title] border=0 /></a><br>";
}

//二级分类
$querypro = $db->query("SELECT * FROM home_shop_content WHERE fid in (select fid from home_shop_sort where fup in (select fid from home_shop_sort where fup='$q' and class=2) )  AND city_id=$city_id AND yz=1  LIMIT 50"); //AND level=1

while($key = $db->fetch_array($querypro)){
    echo "<a href=/shop/bencandy-htm-fid-$key[fid]-id-$key[id].html title=$key[title] target=_top><img src='http://www.darkgreen.cn/upload_files/$key[picurl]' width=190 height=150 alt=$key[title] title=$key[title] border=0 /></a><br>";
}

?>
                </div>
                <div id="scrollpic-copy"></div>
            </div>
        </div>
        <div id="rightDir"></div>
        <!--<script type="text/javascript" src="/images/default/indeximg1.js?number="Math.random() defer="defer"></script>-->
     </div>
      
      
      <div id="ly_main_right_list_box2" style="display:none">
        <div id="leftDir2"></div>
        <div id="scrollbox2">
            <div id="scrollcon2">
                <div id="scrollpic2">
                 <?php

$q = $_GET[id];
$querypro = $db->query("SELECT * FROM home_shop_content WHERE fid='$q' AND city_id=$city_id AND yz=1 AND levels=1 LIMIT 50");
while($key = $db->fetch_array($querypro)){
	echo "<li><a href=/shop/bencandy-htm-fid-$q-id-$key[id].html title=$key[title] target=_top>$key[title]</a></li>";
}
?>
                </div>
                <div id="scrollpic-copy2"></div>
            </div>
        </div>
        <div id="rightDir2"></div>
        <script type="text/javascript" src="/images/default/indeximg2.js?number="Math.random() defer="defer"></script>
</div>
</div>
