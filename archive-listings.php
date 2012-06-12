<?php
get_header();
?>
<div id="content-sidebar-wrap">
    <div id="content" class="hfeed">
        <div class="post-2 page type-page status-publish hentry">
    
            <div class="entry-content">
			<?php
    
            $post_type	= 'listings';
            $tax		= 'listing-type';
            $tax_terms	= get_terms( $tax );
            if ($tax_terms) {
                echo '<h1>View all Current Listings</h1>';
                foreach ($tax_terms  as $tax_term) {
                $args = array(
                    'post_type'			=> $post_type,
                    "$tax"				=> $tax_term->slug,
                    'post_status'		=> 'publish',
                    'posts_per_page'	=> -1,
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
            ?>
            </div>
    
        </div>
    </div>
    
    <div id="sidebar" class="sidebar widget-area">
    <?php get_sidebar(); ?>
    </div>

</div>
    
<?php
get_footer();
?>