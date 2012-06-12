<?php
get_header();
?>
<div id="content-sidebar-wrap">
    <div id="content" class="hfeed">
        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
            <?php
            global $post;
			$type		= wp_get_post_terms( $post->ID, 'listing-type' );
            $ssize		= get_post_meta($post->ID, '_rkv_bmm_ssize', true);
            $display	= get_post_meta($post->ID, '_rkv_bmm_display', true);
            
            $fname		= get_post_meta($post->ID, '_rkv_bmm_fname', true);
            $lname		= get_post_meta($post->ID, '_rkv_bmm_lname', true);
            $email		= get_post_meta($post->ID, '_rkv_bmm_email', true);
            $phone		= get_post_meta($post->ID, '_rkv_bmm_phone', true);
            $pterms		= get_post_meta($post->ID, '_rkv_bmm_pterms', true);

            $image_1	= get_post_meta($post->ID, '_rkv_bmm_image_1', true);
            $image_2	= get_post_meta($post->ID, '_rkv_bmm_image_2', true);
            $image_3	= get_post_meta($post->ID, '_rkv_bmm_image_3', true);
            $image_4	= get_post_meta($post->ID, '_rkv_bmm_image_4', true);

			// text cleanup for condition
            $condition	= get_post_meta($post->ID, '_rkv_bmm_cond', true);
			$condition	= str_replace('-', ' ', $condition);
			$condition	= ucwords($condition);

			// specific formatting for price
            $price		= get_post_meta($post->ID, '_rkv_bmm_price', true);
			$price		= preg_replace('/[^0-9]/Uis', '', $price);
			

            ?>
			
            <h1 class="entry-title">
            <?php echo $type[0]->name; ?>
            </h1>

            <div class="listing_details listing_block">
            <h3>Details</h3>
            <ul>
            <?php

			if (!empty($price))
				echo '<li class="price">Price: $'.number_format($price, 2, '.', ',').'</li>';

			if (!empty($ssize))
				echo '<li class="size">Screen Size: '.$ssize.'</li>';

			if (!empty($display))
				echo '<li class="display">Display: '.$display.'</li>';

			if (!empty($condition))
				echo '<li class="condition">Condition: '.$condition.'</li>';

			?>
            </ul>
            </div>
            
            <div class="contact_info listing_block">
            <h3>Seller Contact Info</h3>
            <ul>            
            <?php

			if (!empty($fname) && !empty($lname))
				echo '<li class="name">Name: '.$fname.' '.$lname.'</li>';

			if (!empty($email))
				echo '<li class="email">Email: <a href="mailto:'.antispambot($email).'" target="_blank">'.antispambot($email).'</a></li>';

			if (!empty($phone))
				echo '<li class="phone">Phone: <a href="tel:'.$phone.'" target="_blank">'.$phone.'</a></li>';

			?>
            </ul>
            </div>
    
    
            <div class="entry-content listing_block">
            <h3>Product Description</h3>
            <?php the_content(); ?>
            </div>

            <?php

			// check for first image before creating gallery block
   			if (!empty($image_1) ) {
				echo '<div class="listing_images listing_block"><h3>Images</h3>';
				echo rkv_listing_gallery();
				echo '</div>';
			}

			?>

    
        </div>
    </div>

    <div id="sidebar" class="sidebar widget-area">
    <?php get_sidebar(); ?>
    </div>

</div>
    
<?php
get_footer();
?>