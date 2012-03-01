<?php
/*
Plugin Name: Rotating Image Widget
Plugin URI: http://www.jumping-duck.com/wordpress/
Description: Create a jQuery-driven rotating image sidebar widget.
Version: 1.1.3
Author: Eric Mann
Author URI: http://www.eamann.com
License: GPLv2+
*/

/*  Copyright 2010-2011  Eric Mann  (email : eric@eamann.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or 
	(at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Define plug-in wide constants for include directories.
 */
if( ! defined( 'RIW_DIRECTORY' )) define( 'RIW_DIRECTORY', dirname(__FILE__) );
if( ! defined( 'RIW_INC_DIRECTORY' )) define( 'RIW_INC_DIRECTORY', RIW_DIRECTORY . '/includes');
if( ! defined( 'RIW_URI' )) define( 'RIW_URI', get_bloginfo('url') . '/wp-content/plugins/rotating-image-widget' );
if( ! defined( 'RIW_INC_URI' )) define( 'RIW_INC_URI', RIW_URI . '/includes');


/**
 * Sets admin warnings regarding required PHP and WordPress versions.
 *
 * @hook action 'admin_notices'
 * @return void
 */
function _riw_php_warning() {

	$data = get_plugin_data(__FILE__);

	echo '<div class="error"><p><strong>' . __('Warning:') . '</strong> '
		. sprintf(__('The active plugin %s is not compatible with your PHP version.') .'</p><p>',
			'&laquo;' . $data['Name'] . ' ' . $data['Version'] . '&raquo;')
		. sprintf(__('%s is required for this plugin.'), 'PHP-5 ')
		. '</p></div>';
}

function _riw_wp_warning() {
	$data = get_plugin_data(__FILE__);

	echo '<div class="error"><p><strong>' . __('Warning:') . '</strong> '
		. sprintf(__('The active plugin %s is not compatible with your WordPress version.') .'</p><p>',
			'&laquo;' . $data['Name'] . ' ' . $data['Version'] . '&raquo;')
		. sprintf(__('%s is required for this plugin.'), 'WordPress 2.8 ')
		. '</p></div>';
}

// == START PROCEDURE ==

// Check required PHP version.
if ( version_compare(PHP_VERSION, '5.0.0', '<') ) {
	add_action('admin_notices', '_riw_php_warning');
// Check required WordPress version.
} elseif ( version_compare(get_bloginfo('version'), '2.8', '<')) {
	add_action('admin_notices', '_riw_wp_warning');
// Check fopen() access in /includes directory.
} else {
	// Run the plugin
	include_once ( RIW_INC_DIRECTORY . '/core.php' );
}