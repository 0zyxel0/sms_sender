
<html>

    <?php require('StyleBundle.php')?>
    <?php require('ScriptBundle.php')?>

<body bgcolor="#7fffd4">
<form id="passId" method="post" action="<?php echo site_url('DataController/ctl_buildSmsNotification'); ?>" autocomplete="off">
<input name="crdScanned" id="crdScanned" value=""/>
<button id="btn_pass">submit</button>
</form>
</body>
</html>
