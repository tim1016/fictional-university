<?php 
    get_header();
    pageBanner(
        array(
            'title' => '',
            'subtitle' => '',
            'photo' => ''
        )
    );
?>


<?php 
while(have_posts()){
    the_post(); 
    ?>

    <section class="section">
        
        <div class="row generic-text">
            <div class="metabox  metabox--with-home-link">
                <p>
                    <a href="<?php echo get_post_type_archive_link('campus');?>" class="metabox__blog-home-link"><i class="fa fa-home"></i> All campuses</a> 
                    <span class="metabox__main"><?php the_title();?></span>
                </p>
            </div>
            <?php  the_content( );?>



            <div class="acf-map">
                <?php 
                    $mapLocation = get_field('map_location')
                    ?>
                    <div class="marker" data-lat="<?php echo $mapLocation['lat']?>" data-lng="<?php echo $mapLocation['lng']?>">
                        <h3><?php the_title();?></h3>
                        <p><?php echo $mapLocation['address']?></p>
                    </div>
            </div>
            







            <?php 
                $relatedProgram   = new WP_Query(array(
                    'posts_per_page' => -1,
                    'post_type' => 'program',
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key'=> 'related_campus',
                            'compare'=> 'LIKE',
                            'value'=> '"' . get_the_ID() . '"'
                        )
                    )
                ));

                echo '<h2 class="headline-4 u-margin-top-big"> Programs available at this campus</h2>';
                echo '<ul class="link-list min-list">';
                while($relatedProgram->have_posts() ) {
                    $relatedProgram->the_post(); ?>
                    <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
                <?php
                }
                echo '</ul>';

                wp_reset_postdata();

            ?>

        </div>
    </section>

    <?php
}
?>

<?php get_footer();?>
