<?php
require_once('../../../../wp-blog-header.php');
include('image-processor.php');

// Retrieve relevant query variables
$type=$_GET['ctype'];
$height=$_GET['height'];
$width=$_GET['width'];
$source=$_GET['src'];

// Retrieve the original image using WordPress' built-in GET routines
$originalImage = wp_remote_get( $source );

// Check the original image's size
$size=$originalImage['headers']['content-length'];

// Only parse the image if it's less than 2MB in size!
if($size > (2*1024*1024) ) {
	$type = 'image/png';
	$originalImage = wp_remote_get( RIW_INC_URI . '/file_broken.png' );
}

// Set the content type of our returned image
$head = 'Content-Type: ' . $type;
header($head);



// Create a new image that will be resized based on the properties of the original
$newImage = new RIW_SimpleImage();
$newImage->loadFromString( $originalImage['body'] );

// Get the original image's size
$origWidth = $newImage->getWidth();
$origHeight = $newImage->getHeight();

// Calculate how much to resize the image by
if($height == 0) $height = $origHeight;
if($width == 0) $width = $origWidth;

$widthrad = $origWidth / $width;
$heightrad = $origHeight / $height;

// Resize the image if necessary
if($heightrad > $widthrad) {
	$newImage->resizeToHeight($height);
} else {
	$newImage->resizeToWidth($width);
}

// Return the new image to the browser.
$newImage->output();