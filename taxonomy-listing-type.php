<?php
get_header();
?>
<div id="content-sidebar-wrap">
    <div id="content" class="hfeed">
        <div class="post-2 page type-page status-publish hentry">
    
            <div class="entry-content">
            <?php the_excerpt(); ?>
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