<?php
/**
 * File: SimpleImage.php
 * Author: Simon Jarvis
 * Copyright: 2006 Simon Jarvis
 * Date: 08/11/06
 * Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
 * 
 * This program is free software; you can redistribute it and/or 
 * modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
 * GNU General Public License for more details: 
 * http://www.gnu.org/licenses/gpl.html
 *
 */
if ( ! class_exists( 'RIW_SimpleImage' ) ) :
class RIW_SimpleImage {
	var $image;
	var $image_type;

	/**
	 * Load an image into memory based on its filename. Requires allow_url_fopen = on.
	 * 
	 * @param string $filename URL of the image to load
	 */
	function load( $filename ) {
		$image_info = getimagesize( $filename );
		$this->image_type = $image_info[2];
		if( $this->image_type == IMAGETYPE_JPEG ) {
			$this->image = imagecreatefromjpeg( $filename );
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
			$this->image = imagecreatefromgif( $filename );
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
			$this->image = imagecreatefrompng( $filename );
		}
	}
	
	/**
	 * Load an image into memory based on a string (i.e. if the image was retrieved through a GET).
	 *
	 * @param string $imageString String that represents the image to be loaded
	 * @param const $outputType Mime type to be output to the browser
	 */
	function loadFromString( $imageString, $outputType = IMAGETYPE_JPEG ) {
		$this->image = imagecreatefromstring( $imageString );
		$this->image_type = $outputType;
	}
	
	/**
	 * Save the loaded image as a file.
	 *
	 * @param string $filename Name of the image to save
	 * @param const $image_type Mime type of the image to be saved
	 * @param int $compression Compression ratio
	 * @param int $permissions CHMOD permissions to set on the newly saved file.
	 */
	function save( $filename, $image_type = IMAGETYPE_JPEG, $compression=75, $permissions = null ) {
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg( $this->image, $filename, $compression );
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif( $this->image, $filename );         
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng( $this->image, $filename );
		}   

		if( $permissions != null) {
			chmod( $filename, $permissions );
		}
	}

	/**
	 * Return the image to the browser.
	 *
	 * @param const $image_type Mime type of the image to be returned
	 */
	function output( $image_type = IMAGETYPE_JPEG ) {
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg( $this->image );
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif( $this->image );         
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng( $this->image );
		}
	}

	/**
	 * Get the width, in pixels, of the loaded image.
	 *
	 * @return int Width of the loaded image in pixels
	 */
	function getWidth() {
		return imagesx( $this->image );
	}

	/**
	 * Get the height, in pixels, of the loaded image.
	 *
	 * @return int Height of the loaded image in pixels
	 */
	function getHeight() {
		return imagesy( $this->image );
	}

	/**
	 * Resize the image based on a desired height.
	 *
	 * @param int $height Desired height of the final image
	 */
	function resizeToHeight( $height ) {
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize( $width, $height );
	}

	/**
	 * Resize the image based on a desired width.
	 *
	 * @param int $width Desired width of the final image
	 */
	function resizeToWidth( $width ) {
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize( $width, $height );
	}

	/**
	 * Scale the image.
	 *
	 * @param int $scale The percentage by which the image is to be scaled (75 = 75%)
	 */
	function scale( $scale ) {
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100; 
		$this->resize( $width, $height );
	}

	/**
	 * Resize the image to a set height and width.
	 *
	 * @param int $width Desired final width
	 * @param int $height Desired final height
	 */
	function resize( $width, $height ) {
		$new_image = imagecreatetruecolor( $width, $height );
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;   
	}
}
endif;
?>