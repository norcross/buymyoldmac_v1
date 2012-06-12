<?php

class rkv_listing_Widget extends WP_Widget {
	function rkv_listing_Widget() {
		$widget_ops = array( 'classname' => 'widget_listings', 'description' => 'Displays recent listings' );
		$this->WP_Widget( 'widget_listings', 'Listings', $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		echo $before_widget;
		// display title formatted
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };		
		echo '<ul>';

		// first, perform query
		$listings = new WP_Query( array (
			'post_type'			=> 'listings',
			'posts_per_page'	=> 5,
		));
		// check for tips
		if ($listings->have_posts()) :
			// now process loop
			while ($listings->have_posts()) : $listings->the_post();
				global $post;
				$model	= get_the_terms( $post->ID, 'listing-type');
				$price	= get_post_meta( $post->ID, '_rkv_bmm_price', true);
				$price	= preg_replace('/[^0-9]/Uis', '', $price);
				$link	= get_permalink( $post->ID );
				$date	= get_the_date( 'm/d/Y' );

						
				echo '<li class="single_listing">';
				echo '<span class="model"><a href="'.$link.'" title="'.$model[0]->name.'">'.$model[0]->name.'</a></span>';
				echo '<span class="date">Listed: '.$date.'</span>';
				echo '<span class="price">$'.number_format($price, 2, '.', ',').'</span>';
				echo '</li>';			

            endwhile;
			echo '<li class="listings_link"><a href="'.get_bloginfo('url').'/listings/" title="See All Listings">See All Listings</a></li>';
			else:
			echo '<p>No listings yet.</p>';
			echo '<li class="listings_link"><a href="'.get_bloginfo('url').'/list/" title="See All Listings">Be The First!</a></li>';
		endif;
		wp_reset_query();
		echo '</ul>';		
		echo $after_widget;
		?>
        
        <?php }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title']	= strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $instance = wp_parse_args( (array) $instance, array( 
			'title'	=> 'Recent Listings',
			));
		$title	= strip_tags($instance['title']);
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php }

} // class 


// register widget

add_action( 'widgets_init', create_function( '', "register_widget('rkv_listing_Widget');" ) );