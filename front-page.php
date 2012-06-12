<?php
get_header();
?>

<div id="content" class="hfeed">
	<div class="post-2 page type-page status-publish hentry">

        <div class="entry-content">
        <?php the_content(); ?>
        </div>

		<div class="recent_listings">
        <?php echo rkv_listing_block(); ?>
        </div>

	</div>
</div>

<div id="sidebar" class="sidebar widget-area">
<?php get_sidebar(); ?>
</div>
    
<?php
get_footer();
?>