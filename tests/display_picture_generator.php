<?php

    $Source = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR;
    include_once($Source . 'udp' . DIRECTORY_SEPARATOR . 'udp.php');

    $udp = new \udp\udp();
    $imageDataUri = $udp->getDisplayPictureGenerator()->getImageDataUri('Intellivoid');
?>
<img src="<?php print($imageDataUri); ?>" alt="bar Identicon" />