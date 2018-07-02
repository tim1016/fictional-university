<?php
function rei_new_features(){
        add_image_size('pageBanner', 1500, 360, true);
}
add_action( 'after_setup_theme', 'rei_new_features');
add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );
function custom_image_sizes_choose( $sizes ) {
    $custom_sizes = array(
        'featured-image' => 'Featured Image',
        'professorLandscape' => 'Professor Landscape',
    );
    return array_merge( $sizes, $custom_sizes );
}



function pageBanner($args = NULL){
    if(!$args['title']){
        $args['title'] = get_the_title(); 
    }

    if(!$args['subtitle']){
        $args['subtitle'] = get_field('page_banner_subtitle'); 
    }


    if(!$args['photo']){
        if(get_field('page_banner_image')){
           $args['photo'] = get_field('page_banner_image') ['sizes']['pageBanner'];
        }else{
            $fallbackBanner = get_template_directory_uri() . '/img/posts_banner.jpg';
            $args['photo'] = $fallbackBanner;
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
        <div class="page-banner__content row">
            <h1 class="heading-2 white moveinleft"><?php echo $args['title']; ?></h1>
        </div>  
    </div>
  <?php
}