<?php
get_header();
?>
<div id="content-sidebar-wrap">
    <div id="content" class="hfeed">
        <div class="post-2 page type-page status-publish hentry">
    
            <div class="entry-content">
            <?php the_content(); ?>
            </div>
    
        </div>
    </div>
    
    <div id="sidebar" class="sidebar widget-area">
    <?php get_sidebar(); ?>
    </div>
</div>

<div id="recent_listings">
	<?php echo rkv_recent_home(); ?>
</div>
    
<?php
get_footer();
?>