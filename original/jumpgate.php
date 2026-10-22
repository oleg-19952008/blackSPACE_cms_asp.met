<?php
//$image = imagecreatetruecolor (235,290);
function LoadPNG($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefrompng($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a blank image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 1500, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, ' ' . $imgname, $tc);
    }

    return $im;
}

header('Content-Type: image/png');

$img = LoadPNG('Image is not available');

imagepng($img);
imagedestroy($img);

?>