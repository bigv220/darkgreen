<?php

require(dirname(__FILE__)."/member/global.php");
if($lfjid){

?>
Redirecting...
<form action='http://gogo.darkgreen.cn/chat.php' method='post' name='frm'>
    <input type='hidden' name='username' value='<?php echo $lfjid; ?>' />
    <input type='hidden' name='passmd5' value='<?php echo $lfjdb['password']; ?>' />
    <input type='hidden' name='chatto' value='<?php echo $_GET['to']; ?>' />

</form>
<script language="JavaScript">
    document.frm.submit();
</script>

<?php

}
else{
    //http://localhost/do/login.php
    header("Location: $webdb[www_url]/do/login.php");
    eixt;
}

?>