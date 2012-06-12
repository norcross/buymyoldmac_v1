<?php

// home page recent listings
function rkv_recent_home() {

		$post_type	= 'listings';
		$tax		= 'listing-type';
		$tax_terms	= get_terms( $tax );
		if ($tax_terms) {
			echo '<h2>Recent Listings By Type</h2>';
			foreach ($tax_terms  as $tax_term) {
			$args = array(
				'post_type'			=> $post_type,
				"$tax"				=> $tax_term->slug,
				'post_status'		=> 'publish',
				'posts_per_page'	=> 10,
				'order'				=> 'DESC',
				'orderby'			=> 'date'
			);
		
				$listing_query = null;
				$listing_query = new WP_Query($args);
		
				if( $listing_query->have_posts() ) : ?>
                
				<div class="listing_block">
                <h5 id="<?php echo $tax_term->slug; ?>" class="ls_recent_title"><?php echo $tax_term->name; ?></h5>

					<?php
					echo '<ul class="listing_list">';
                    while ( $listing_query->have_posts() ) : $listing_query->the_post();
					global $post;
					$model	= get_the_terms( $post->ID, 'listing-type');
					$price	= get_post_meta( $post->ID, '_rkv_bmm_price', true);
					$price	= preg_replace('/[^0-9]/Uis', '', $price);
					$link	= get_permalink( $post->ID );
					$date	= get_the_date( 'm/d/Y' );

					// build out listing columns
						echo '<li class="single_listing_home">';
						echo '<span class="price"><a href="'.$link.'" title="'.$model[0]->name.'">$'.number_format($price, 2, '.', ',').'</a></span>';
						echo '<span class="date"><a href="'.$link.'" title="'.$model[0]->name.'">'.$date.'</a></span>';
						echo '</li>';

					endwhile;
					echo '</ul>';
					else : 
					endif; // if have_posts()
				echo '</div>';
				wp_reset_query();
		
			} // end foreach #tax_terms
		}
	
}

// image gallery for single listing

function rkv_listing_gallery() {

	global $post;
	// get attachment images
	$images	= get_children( array(
			'post_parent'		=> $post->ID,
			'post_mime_type'	=> 'image',
			'numberposts'		=> -1
			));

	// set count for image relations
	$count = 0;

	if(!$images)
		return;
	
	if($images) { 
		echo '<div class="listing_images listing_block">';
		echo '<h3>Image Gallery</h3>';

		// output gallery
		foreach ($images as $image) {
			$image_id	= $image->ID;
			$image_name	= $image->post_title;
			$image_desc	= $image->post_content;
			$thumb		= wp_get_attachment_image_src( $image_id, 'bfg_medium_img' );
			$full		= wp_get_attachment_image_src( $image_id, 'large' );
			
			// begin single images
			echo '<div class="image_single">';
			echo '<a href="'.$full[0].'" class="listing_img">';
			echo '<img src="'.$thumb[0].'">';
			echo '</a>';
			echo '</div>';
			// end each image output
		}
	// end output gallery
	echo '</div>';
	}
}


function rkv_listing_return() {
	echo '<p><a href="'.get_bloginfo('url').'/listings/" title="Return To All Listings">&laquo; Return To All Listings</a></p>';
}

// social buttons
function rkv_social_share () {
	global $post;
	$post_link = get_permalink($post->ID);
	$post_name = get_the_title($post->ID);
	$post_text = get_the_excerpt($post->ID);
	?>

			<p class="share_string">
			<span class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo $post_link; ?>" data-text="<?php echo $post_name; ?>" data-count="horizontal" data-via="trumpetinc">Tweet</a></span>
            <span class="gplus"><g:plusone size="medium" href="<?php echo $post_link; ?>"></g:plusone></span>
            <span class="linkedin"><script type="IN/Share" data-url="<?php echo $post_link; ?>" data-counter="right"></script></span>            
			<span class="facebook"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $post_link; ?>&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;colorscheme=light&amp;height=45" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:45px;" allowTransparency="true"></iframe></span>
			</p>
<?php }

//pagination
function rkv_paginate($args = null) {
	$defaults = array(
		'page'		=> null,
		'pages'		=> null, 
		'range'		=> 3,
		'gap'		=> 3,
		'anchor'	=> 1,
		'before'	=> '<div id="post_navigation">',
		'after'		=> '</div>',
		'nextpage'	=> __('&raquo;'), 'previouspage' => __('&laquo'),
		'echo'		=> 1
	);
	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);
	if (!$page && !$pages) {
		global $wp_query;
		$page = get_query_var('paged');
		$page = !empty($page) ? intval($page) : 1;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
	}
	$output = "";
	if ($pages > 1) {	
		$output .= "$before";
		$ellipsis = "<span class='pag_gap'>...</span>";
		if ($page > 1 && !empty($previouspage)) {
			$output .= "<a title='Previous' href='" . get_pagenum_link($page - 1) . "' class='pag_prev'>$previouspage</a>";
		}
		$min_links = $range * 2 + 1;
		$block_min = min($page - $range, $pages - $min_links);
		$block_high = max($page + $range, $min_links);
		$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
		$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;
		if ($left_gap && !$right_gap) {
			$output .= sprintf('%s%s%s', 
				rkv_paginate_loop(1, $anchor), 
				$ellipsis, 
				rkv_paginate_loop($block_min, $pages, $page)
			);
		}
		else if ($left_gap && $right_gap) {
			$output .= sprintf('%s%s%s%s%s', 
				rkv_paginate_loop(1, $anchor), 
				$ellipsis, 
				rkv_paginate_loop($block_min, $block_high, $page), 
				$ellipsis, 
				rkv_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else if ($right_gap && !$left_gap) {
			$output .= sprintf('%s%s%s', 
				rkv_paginate_loop(1, $block_high, $page),
				$ellipsis,
				rkv_paginate_loop(($pages - $anchor + 1), $pages)
			);
		}
		else {
			$output .= rkv_paginate_loop(1, $pages, $page);
		}
		if ($page < $pages && !empty($nextpage)) {
			$output .= "<a title='Next' href='" . get_pagenum_link($page + 1) . "' class='pag_next'>$nextpage</a>";
		}
		$output .= $after;
	}
	if ($echo) {
		echo $output;
	}
	return $output;
}


function rkv_paginate_loop($start, $max, $page = 0) {
	$output = "";
	for ($i = $start; $i <= $max; $i++) {
		$output .= ($page === intval($i)) 
			? "<span class='pag_page pag_current'>$i</span>" 
			: "<a href='" . get_pagenum_link($i) . "' class='pag_page'>$i</a>";
	}
	return $output;
}

// display postmeta for posts
function rkv_listing_details() {
		global $post;
		$author_id = $post -> post_author;
			$author_name	= get_the_author();
			$author_link	= get_author_posts_url($author_id);
			$post_date		= get_the_date( 'F j, Y' );
			$category		= get_the_category();
			$cat_id			= $category[0]->cat_ID;
			$cat_name		= $category[0]->cat_name;
			$cat_link		= get_category_link($cat_id);

	echo '';
}
