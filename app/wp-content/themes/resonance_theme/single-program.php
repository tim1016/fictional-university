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
                    <a href="<?php echo get_post_type_archive_link('program');?>" class="metabox__blog-home-link"><i class="fa fa-home"></i> All Progams</a> 
                    <span class="metabox__main"><?php the_title();?></span>
                </p>
            </div>
            <?php  the_content( );?>



            <?php 




                $relatedProfessors = new WP_Query(array(
                    'posts_per_page' => -1,
                    'post_type' => 'professor',
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key'=> 'related_programs',
                            'compare'=> 'LIKE',
                            'value'=> '"' . get_the_ID() . '"'
                        )
                    )
                ));

                echo '<ul class="person-cards">';
                while($relatedProfessors->have_posts()) {
                  $relatedProfessors->the_post(); ?>
                  <li class="person-card__list-item">
                    <a class="person-card" href="<?php the_permalink(); ?>">
                      <img class="person-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>">
                      <span class="person-card__name"><?php the_title(); ?></span>
                    </a>
                  </li>
                <?php }
                echo '</ul>';
                

                wp_reset_postdata();




                $today = date('Ymd');
                $homepageEvents = new WP_Query(array(
                    'posts_per_page' => -1,
                    'post_type' => 'event',
                    'meta_key' => 'event_date',
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_query' => array(
                        array(
                            'key' => 'event_date',
                            'compare' => '>=',
                            'value' => $today,
                            'type' => 'numeric'
                        ),
                        array(
                            'key'=> 'related_programs',
                            'compare'=> 'LIKE',
                            'value'=> '"' . get_the_ID() . '"'
                        )
                    )
                ));

                echo '<h2 class="headline-4 u-margin-top-big"> Upcoming ' .  get_the_title() .' events </h2>';

                while($homepageEvents->have_posts() ) {
                    $homepageEvents->the_post(); 
                    get_template_part('template_parts/content', 'event');
                }

                wp_reset_postdata();

                $relatedCampuses = get_field('related_campus');

                if($relatedCampuses){

                    echo '<h2 class="headline-4 u-margin-top-big">' . get_the_title() . ' is available at: </h2>';
                    echo '<ul class="link-list min-list">';
                    foreach($relatedCampuses as $campus){
                        ?>
                        <li><a href="<?php echo get_the_permalink($campus);?>"> <?php echo get_the_title($campus);?></a></li>
                        <?php
                    }
                    echo '</ul>';
                }
            ?>

        </div>
    </section>

    <?php
}
?>

<?php get_footer();?>
