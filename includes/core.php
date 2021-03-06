<?php
class RIW_Widget extends WP_Widget {
	function RIW_Widget() {
		$widget_ops = array(
			'classname' => 'riw_widget',
			'description' => __( 'A rotating image widget that pulls images from WordPress\' default image gallery.')
		);
		$this->WP_Widget( 'riw_widget', __('Rotating Images'), $widget_ops );
	}
	
	function form( $instance ) {
		$instance = wp_parse_args( 
			(array) $instance, 
			array( 
				'title' => '',
				'count' => '',
				'width' => '',
				'height' => '',
				'post_ids' => ''
			)
		);

		$title = esc_attr( $instance['title'] );
		$count = esc_attr( $instance['count'] );
		$width = esc_attr( $instance['width'] );
		$height = esc_attr( $instance['height'] );
		$post_ids = esc_attr( $instance['post_ids'] );
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of Images to Rotate:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Gallery Width (in pixels):'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Gallery Height (in pixels):'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post_ids'); ?>"><?php _e('Post IDs to Fetch From (optional):'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('post_ids'); ?>" name="<?php echo $this->get_field_name('post_ids'); ?>" type="text" value="<?php echo $post_ids; ?>" />
		</p>
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
		$post_ids = apply_filters('riw_post_ids', empty( $instance['post_ids'] ) ? '' : $instance['post_ids']);
		$order = apply_filters('riw_order', empty( $instance['order'] ) ? 'RAND()' : $instance['order']);
		
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; ?>
		
		<div class="riw-widget" style="height:<?php echo $height; ?>px;width:<?php echo $width; ?>px;">
			<div id="riw_images" style="height:<?php echo $height; ?>px;">
			<?php get_images($height, $width, $count, $order, $post_ids); ?>
			</div>
		</div>	<?php
		
		echo $after_widget;
	}
}

function get_images($height, $width, $count, $order, $post_ids) {
	global $wpdb;		
	
	$query_args = array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'post_status' => 'inherit',
			'fields' => 'ids',
			'posts_per_page' => $count,
			'orderby' => 'rand'
	);

	if( ! empty( $post_ids ) && preg_match_all( '/^[\d,]+$/' , $post_ids, $matches ) ) {
		$post_parents = explode( ',' , $post_ids );
		if( empty( $post_parents[count($post_parents)-1] ) ) array_pop( $post_parents );	

		$query_args['post_parent__in'] = $post_parents;
	}

	$query_args = apply_filters('riw_attachment_query_args', $query_args);
	
	$myimages = new WP_Query( $query_args );
	
	$i=0;
	foreach($myimages->posts as $image_id) {
		$filename = wp_get_attachment_image_src($image_id, 'large');
		($i==0) ? $class=' class="active"' : $class='';
		echo '<div style="width:' . $width . 'px;"' . $class . '><img alt="rotating image" src="' . RIW_INC_URI . '/genImage.php?height=' . $height . '&amp;width=' . $width . '&amp;ctype=image/jpeg&amp;src=' . $filename[0] . '" /></div>';
		$i+=1;
	}
}

// Hooks and such //
add_action('widgets_init', create_function('', 'return register_widget("RIW_Widget");'));

add_action( 'wp_enqueue_scripts', 'riw_enqueue_scripts' );

function riw_enqueue_scripts() {
	wp_enqueue_style( 'riw-override-css', RIW_INC_URI . '/riw.css', '', '1.0', 'screen' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'riw-javascript', RIW_INC_URI . '/riw.js', 'jquery', '1.0', true);	
}
?>