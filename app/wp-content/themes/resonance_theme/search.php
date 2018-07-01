<?php get_header();
pageBanner(
    array(
        'title' => 'Search Results for  &ldquo;' . esc_html(get_search_query()) . '&rdquo;',
        'subtitle' => 'You searched for &ldquo;'. esc_html(get_search_query()) . '&rdquo;',
        'photo' => ''
    )
);

?>


<section class="section section--padding section--blogs">    
    <div class="row">
        <?php
            if(have_posts()){
        
                while(have_posts()){
                    the_post(); 
                    get_template_part('template-parts/content', get_post_type());  
                }
                echo paginate_links(  );
    
            }else{
                echo '<h2 class="headline-2"> No results match that search.</h2>'; 

        
            }
        ?>
        <?php get_template_part('template-parts/form-search');?>
    </div>
    
</section>


<?php get_footer();?>