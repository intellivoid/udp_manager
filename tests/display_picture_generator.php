<?php

    $Source = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    include_once($Source . 'udp' . DIRECTORY_SEPARATOR . 'udp.php');

    $udp = new \udp\udp('/etc/user_pictures');
    $imageDataUri = $udp->getDisplayPictureGenerator()->getImageDataUri('.');
?>
<img src="<?php print($imageDataUri); ?>" alt="bar Identicon" />