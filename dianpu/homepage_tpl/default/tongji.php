<?php
@extract($db->get_one("SELECT COUNT(*) AS guestbookNUM  FROM {$_pre}guestbook  WHERE cuid='$uid'" ));
?>
<!--
<?php
print <<<EOT
-->
<div class="cophome_l_tit">
      <div class="cophome_l_tit_tit">ͳ����Ϣ</div>
    </div>
    <div class="cophome_l_cen">
	<li>���ÿ����Թ�:{$guestbookNUM} ��</li>
	<li>��ҳ�������:{$rsdb[hits]} ��</li>
	</div>   
<!--
EOT;
?>
-->