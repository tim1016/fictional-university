<?php get_header();
pageBanner(
    array(
        'title' => get_the_archive_title(),
        'subtitle' => get_the_archive_description(),
        'photo' => ''
    )
);
?>




<section class="section section--blogs">    
    <div class="row">
        <?php 
            while(have_posts()){
                the_post(); 
                get_template_part('template-parts/gallery', get_post_type());  
            }

            echo paginate_links(  );
        ?>
    </div>
</section>


<?php get_footer();?>