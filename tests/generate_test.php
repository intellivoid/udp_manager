<?PHP
    $Source = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    include_once($Source . 'udp' . DIRECTORY_SEPARATOR . 'udp.php');

    $udp = new \udp\udp('/etc/user_pictures');

    try
    {
        $udp->getProfilePictureManager()->generate_avatar('test12');
    }
    catch(Exception $exception)
    {
        var_dump($exception);
    }
    exit();