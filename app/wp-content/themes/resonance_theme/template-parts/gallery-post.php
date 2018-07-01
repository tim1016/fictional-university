<?php
    $url= get_template_directory_uri() . '/img/blogdefault1.jpg';
    if(has_post_thumbnail()){
        $url = get_the_post_thumbnail_url(NULL, $size = 'cropped300' );
    }

?>
<div class="col-1-of-3">
    <div class="card u-margin-bottom-medium  generic-text generic-text--justified-content dark-shadow-long ">

        <div class="card__picture" style="background-image: url(<?php echo $url ?>);">
            <div class="post-title ">
            <span class="post-title__text rounded boxed"><?php echo get_the_title();?></span>
            </div>
        </div>


        <div class="post-category">
            <?php echo get_the_category_list( )?> 
        </div>
        <span class="author"></span>
        <span class="post-author">By <?php echo the_author_posts_link( );?> on <?php the_time('n.j.y')?></span>
        <div class="post-excerpt">
            <p><?php echo get_the_excerpt();?></p>
        </div>

        <div class="read-more">
            <a class="btn-read-more" href="<?php the_permalink()?>"> Read More &raquo; </a>
        </div>
    </div>
</div>  

