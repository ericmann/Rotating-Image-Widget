<?php
include('SimpleImage.php');

$type=$_GET['ctype'];
$height=$_GET['height'];
$width=$_GET['width'];
$source=$_GET['src'];

$size=get_size($source);

// Only parse the image if it's less than 2MB in size!
if($size > (2*1024*1024) ) {
	$type = 'image/png';
	$source = 'file_broken.png';
}
$head = 'Content-Type: ' . $type;

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

/* cUrl function for getting the original file's size */
function get_size($remoteFile) {
	$ch = curl_init($remoteFile);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	if ($data === false) {
	  echo 'cURL failed';
	  exit;
	}

	$contentLength = 'unknown';
	$status = 'unknown';
	if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches)) {
	  $status = (int)$matches[1];
	}
	if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
	  $contentLength = (int)$matches[1];
	}
	return $contentLength;
}
	
?>