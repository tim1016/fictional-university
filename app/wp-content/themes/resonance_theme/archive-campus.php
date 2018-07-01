<?php get_header();
pageBanner(
    array(
        'title' => 'Our Campuses',
        'subtitle' => 'Choose your favorite location',
        'photo' => ''
    )
);
?>



<section class="section section--blogs">    
    <div class="row">
        <div class="acf-map">
            <?php 
            while(have_posts()){
                the_post(); 
                $mapLocation = get_field('map_location')
                ?>
                <div class="marker" data-lat="<?php echo $mapLocation['lat']?>" data-lng="<?php echo $mapLocation['lng']?>">
                    <a href="<?php the_permalink();?>"><h3><?php the_title();?></h3></a>
                    
                    <p><?php echo $mapLocation['address']?></p>
                </div>
        
            <?php }?>
        </div>

    </div>
</section>


<?php get_footer();?>