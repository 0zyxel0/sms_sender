<html>
<head>
    </head>
<body>
<?php echo $error;?>
<?php echo form_open_multipart('PageController/UploadPhotoUsers');?>
<input type="file" name="userfile"/>
<input type="submit" name="submit" value="Upload">
</form>
</body>
</html>
