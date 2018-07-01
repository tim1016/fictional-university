<?php 
get_header();
pageBanner(
    array(
        'title' => 'Past Events!',
        'subtitle' => 'A recap of our past events',
        'photo' => ''
    )
);
?>




<section class="section section--blogs">    
    <div class="row">
    <?php 
        $today = date('Ymd');
        $pastEvents = new WP_Query(array(
            'paged' => get_query_var('paged', 1),
            'posts_per_page' => 1,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '<',
                    'value' => $today,
                    'type' => 'numeric'
                )
            )
        ));

        while($pastEvents->have_posts() ) {
            $pastEvents->the_post(); 
            get_template_part('template_parts/content', 'event');
        }
        echo paginate_links(array(
            'total' => $pastEvents->max_num_pages
        ));
    ?>
    </div>
</section>


<?php get_footer();?>