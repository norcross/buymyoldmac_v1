<?php
get_header();
?>

<div id="content" class="hfeed">
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php
		global $post;
		$title		= get_post_meta($post->ID, '_rkv_bmm_titlefix', true);
		$price		= get_post_meta($post->ID, '_rkv_bmm_price', true);
		$ssize		= get_post_meta($post->ID, '_rkv_bmm_ssize', true);
		$display	= get_post_meta($post->ID, '_rkv_bmm_display', true);
		$condition	= get_post_meta($post->ID, '_rkv_bmm_cond', true);
		
		$fname		= get_post_meta($post->ID, '_rkv_bmm_fname', true);
		$lname		= get_post_meta($post->ID, '_rkv_bmm_lname', true);
		$email		= get_post_meta($post->ID, '_rkv_bmm_email', true);
		$phone		= get_post_meta($post->ID, '_rkv_bmm_phone', true);
		$pterms		= get_post_meta($post->ID, '_rkv_bmm_pterms', true);
		?>
        
		<div class="contact_info">
        
        </div>

		<div class="listing_details">
        
        </div>

        <div class="entry-content">
        <?php the_content(); ?>
        </div>

	</div>
</div>

<div id="sidebar" class="sidebar widget-area">
<?php get_sidebar(); ?>
</div>
    
<?php
get_footer();
?>