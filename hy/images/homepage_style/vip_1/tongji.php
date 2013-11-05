<?php
@extract($db->get_one("SELECT COUNT(*) AS guestbookNUM  FROM {$_pre}guestbook  WHERE cuid='$uid'" ));
?>
<!--
<?php
print <<<EOT
-->
<div class="ly_shop_left1">
      <div class="ly_shop_left1_tit">统计信息</div>
      <div class="ly_shop_left1_link"> 
	  <li>访客留言共:{$guestbookNUM} 条</li>
	<li>页面浏览量:{$rsdb[hits]} 次</li>
</div>  
<!--
EOT;
?>
-->