<?php
@extract($db->get_one("SELECT COUNT(*) AS guestbookNUM  FROM {$_pre}guestbook  WHERE cuid='$uid'" ));
?>
<!--
<?php
print <<<EOT
-->
<div class="ly_shop_left1">
      <div class="ly_shop_left1_tit">ͳ����Ϣ</div>
      <div class="ly_shop_left1_link"> 
	  <li>�ÿ����Թ�:{$guestbookNUM} ��</li>
	<li>ҳ�������:{$rsdb[hits]} ��</li>
</div>  
<!--
EOT;
?>
-->