<?php
get_header();
?>
<div id="content-sidebar-wrap">
    <div id="content" class="hfeed">
        <div class="post-2 page type-page status-publish hentry">
    
            <div class="entry-content">
            <?php
			global $post;
			$model	= get_the_terms( $post->ID, 'listing-type');
			$price	= get_post_meta( $post->ID, '_rkv_bmm_price', true);
			$price	= preg_replace('/[^0-9]/Uis', '', $price);
			$link	= get_permalink( $post->ID );
            $date	= get_the_date( 'm/d/Y' );            

				echo '<div class="single_type"><p>';
				echo '<span class="price"><a href="'.$link.'" title="'.$model[0]->name.'">$'.number_format($price, 2, '.', ',').'</a></span><br />';
				echo '<span class="date"><a href="'.$link.'" title="'.$model[0]->name.'">'.$date.'</a></span>';
				echo '<p></div>';

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