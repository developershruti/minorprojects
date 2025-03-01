<?
$c = $_GET['c'];
$im = ImageCreate(120, 30);
$colorallocate = ImageColorAllocate($im, 87,84,83);
ImageFilledRectangle($im, 0, 0, 100, 100, $colorallocate);
$string ="123sfdfs";
$orange		= ImageColorAllocate($im, 0, 0, 0);
ImageString($im,5,20,7,$c,$orange);
header('Content-Type: image/png');
ImagePNG($im);
?>