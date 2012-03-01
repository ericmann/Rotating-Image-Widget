<?php
/*
Plugin Name: Rotating Image Widget
Plugin URI: http://www.jumping-duck.com/wordpress/
Description: Create a jQuery-driven rotating image sidebar widget.
Version: 1.0.1
Author: Eric Mann
Author URI: http://www.eamann.com
License: GPLv2+
*/

/*  Copyright 2010  Eric Mann  (email : eric@eamann.com)

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
if( ! defined( 'RIW_URL' ))
	define( 'RIW_URL', get_option('siteurl') . '/wp-content/plugins/rotating-image-widget/' );

class RIW_Widget extends WP_Widget {
	function RIW_Widget() {
		$widget_ops = array('classname' => 'riw_widget', 'description' => __( 'A rotating image widget that pulls images from WordPress\' default image gallery.') );
		$this->WP_Widget('riw_widget', __('Rotating Images'), $widget_ops);
	}
	
	function form($instance) {
		$title = esc_attr($instance['title']);
		$count = esc_attr($instance['count']);
		$width = esc_attr($instance['width']);
		$height = esc_attr($instance['height']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Images to Rotate:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Gallery Width (in pixels):'); ?> <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" /></label></p>
		<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Gallery Height (in pixels):'); ?> <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" /></label></p>		
		<?php 
	}
	
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	
	function widget($args, $instance) {
		extract( $args );

        $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Images' ) : $instance['title']);
		$count = apply_filters('riw_image_count', empty( $instance['count'] ) ? __( '5' ) : $instance['count']);
		$width = apply_filters('riw_width', empty( $instance['width'] ) ? __( '150' ) : $instance['width']);
		$height = apply_filters('riw_height', empty( $instance['height'] ) ? __( '150' ) : $instance['height']);
		$order = apply_filters('riw_order', empty( $instance['order'] ) ? 'RAND()' : $instance['order']);
		
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; ?>
		
		<div class="riw-widget" style="height:<?php echo $height; ?>px;width:<?php echo $width; ?>px;">
			<div id="riw_images" style="height:<?php echo $height; ?>px;">
			<?php get_images($height, $width, $count, $order); ?>
			</div>
		</div>	<?php
		
		echo $after_widget;
	}
}

function get_images($height, $width, $count, $order) {
	global $wpdb;		
	
	$query = "SELECT ID FROM $wpdb->posts WHERE post_type='attachment' AND post_mime_type LIKE 'image%' GROUP BY post_parent ORDER BY " . $order . " LIMIT " . $count;
	
	$myimages = $wpdb->get_results( $query );
	$i=0;
	foreach($myimages as $image) {
		($i==0) ? $class=' class="active"' : $class='';
		echo '<div style="width:' . $width . 'px;"' . $class . '><img alt="rotating image" src="' . RIW_URL . 'includes/genImage.php?height=' . $height . '&amp;width=' . $width . '&amp;ctype=image/jpeg&amp;src=' . wp_get_attachment_url($image->ID) . '" /></div>';
		$i+=1;
	}
}

// Hooks and such //
add_action('widgets_init', create_function('', 'return register_widget("RIW_Widget");'));
wp_enqueue_style( 'riw-override-css', RIW_URL . 'includes/riw.css', '', '1.0', 'all' );
wp_enqueue_script( 'riw-javascript', RIW_URL . 'includes/riw.js', 'jquery', '1.0', true);