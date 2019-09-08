<?PHP
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $Source = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
        include_once($Source . 'udp' . DIRECTORY_SEPARATOR . 'udp.php');

        $udp = new \udp\udp('/etc/user_pictures');
        try
        {
            $file = $udp->getTemporaryFileManager()->accept_upload();
        }
        catch(Exception $exception)
        {
            var_dump($exception);
        }

        try
        {
            $udp->getProfilePictureManager()->apply_avatar($file, 'test');
        }
        catch(Exception $exception)
        {
            var_dump($exception);
        }
        exit();
    }
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input name="user_av_file" type="file" id="image" />
    <input name="submit" type="submit" value="Upload" />
</form>