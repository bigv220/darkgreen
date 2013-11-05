<?php
@extract($db->get_one("SELECT COUNT(*) AS guestbookNUM  FROM {$_pre}guestbook  WHERE cuid='$uid'" ));
?>
<!--
<?php
print <<<EOT
-->
<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">统计信息</div>
    </div>
    <div class="cophome_l_cen">
	<li>·访客留言共:{$guestbookNUM} 条</li>
	<li>·页面浏览量:{$rsdb[hits]} 次</li>
	</div>   
<!--
EOT;
?>
-->