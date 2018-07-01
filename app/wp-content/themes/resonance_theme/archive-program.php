<?php get_header();
pageBanner(
    array(
        'title' => get_the_archive_title(),
        'subtitle' => 'There is something for everyone. Have a look around',
        'photo' => ''
    )
);
?>




<section class="section section--blogs">    
    <div class="row">
        <ul class="link-list min-list">
        <?php 
            while(have_posts()){
                the_post(); ?>

                <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
        
            <?php } ?>
        </ul>
            
        <?php echo paginate_links(  ); ?>
    </div>
</section>


<?php get_footer();?>