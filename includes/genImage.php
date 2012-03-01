<?php
include('SimpleImage.php');

$type=$_GET['ctype'];
$height=$_GET['height'];
$width=$_GET['width'];
$source=$_GET['src'];

$head = 'Content-Type: ' . $ctype;

header($head);
$newimage = new SimpleImage();
$newimage->load($source);

$origwidth = $newimage->getWidth();
$origheight = $newimage->getHeight();

if($height == 0) $height = $origheight;
if($width == 0) $width = $origwidth;

$widthrad = $origwidth / $width;
$heightrad = $origheight / $height;

if($heightrad > $widthrad) {
	$newimage->resizeToHeight($height);
} else {
	$newimage->resizeToWidth($width);
}
$newimage->output();

?>