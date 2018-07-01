<?php
    require get_theme_file_path('/inc/search-route.php');
    require get_theme_file_path('inc/like-route.php');
    require get_theme_file_path('inc/mailer.php');
    function rei_custom_rest(){
        register_rest_field('post', 'authorName', array(
            'get_callback' => function(){
                return get_the_author();
            }
        ));

        register_rest_field('note', 'userNoteCount', array(
            'get_callback' => function(){
                return count_user_posts(get_current_user_id(), 'note');
            }
        ));
    }
    add_action('rest_api_init', 'rei_custom_rest');

    function rei_theme_stylesheets() {
        wp_register_script( 'jquery', get_template_directory_uri() .'/js/jquery.min.js', NULL, 1.0, true);
        wp_register_script( 'validatejs', get_template_directory_uri() .'/js/jquery.validate.min.js', NULL, 1.0, true);
        wp_register_script( 'rei-scripts-bundled', get_template_directory_uri() .'/js/scripts-bundled.js', NULL, 1.0, true);
        wp_register_script( 'rei-app', get_template_directory_uri() .'/js/app1.js', NULL, 1.0, true);
        wp_register_script( 'rei-parallax', get_template_directory_uri() .'/js/parallax.js', NULL, 1.0, true);
        wp_register_script( 'rei-includeHTML', get_template_directory_uri() .'/js/includeHTML.js', NULL, 1.0, true);
        wp_register_script( 'googleMap',  '//maps.googleapis.com/maps/api/js?key=AIzaSyB_y9j1uxmOH2Y__fMGNwvJ7ZMnjAMz0oM', NULL, 1.0, true);
        wp_register_script( 'g-recaptcha',  '//www.google.com/recaptcha/api.js', NULL, 1.0, true);


        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'validatejs' );
        wp_enqueue_script( 'googleMap' );
        wp_enqueue_script( 'rei-scripts-bundled' );
        wp_enqueue_script( 'rei-app' );
        wp_enqueue_script( 'rei-parallax' );
        wp_enqueue_script( 'rei-includeHTML' );
        

        wp_register_style( 'rei-themesytle',  get_stylesheet_directory_uri() .'/css/style.css', array(), null, 'all' );
        wp_register_style( 'rei-themedetail', get_stylesheet_uri(), '', null, 'all' );

        wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Lato:100,300,400,700,900'); 
        wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style(  'rei-themesytle' );
        wp_enqueue_style( 'rei-themedetail' );


        wp_localize_script('rei-scripts-bundled', 'reiData', array(
            'root_url' => get_site_url(),
            'nonce' => wp_create_nonce( 'wp_rest' )
        ));

    }
    add_action( 'wp_enqueue_scripts', 'rei_theme_stylesheets' );


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



    
    function custom_image_sizes_choose( $sizes ) {
        $custom_sizes = array(
            'featured-image' => 'Featured Image',
            'professorLandscape' => 'Professor Landscape',
        );
        return array_merge( $sizes, $custom_sizes );
    }

    function university_features(){
        //register_nav_menu( 'headerMenuLocation', 'Header Menu Location' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_image_size('professorLandscape', 400, 260, true);
        add_image_size('cropped300', 300, 300, true);
        add_image_size('uncropped300', 300, 300, false);
        add_image_size('featured_preview', 55, 55, true);
        add_image_size('professorPortrait', 480, 650, true);
        add_image_size('pageBanner', 1500, 360, true);
    }
    add_action( 'after_setup_theme', 'university_features');
    add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );

    function university_adjust_queries($query){
        $today = date('Ymd');
        if( !is_admin() and is_post_type_archive('event') and is_main_query())
        {
            $query->set('posts_per_page', -1);
            $query->set('meta_key', 'event_date');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'ASC');
            $query->set('meta_query', array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                )
            ));

        }



        if( !is_admin() and is_post_type_archive('program') and is_main_query())
        {
            $query->set('posts_per_page', -1);
            $query->set('orderby', 'title');
            $query->set('order', 'ASC');

        }

        if( !is_admin() and is_post_type_archive('campus') and is_main_query())
        {
            $query->set('posts_per_page', -1);

        }

        if( !is_admin() and is_post_type_archive('post') and is_main_query())
        {
            $query->set('posts_per_page', 10);

        }

    }

     add_action('pre_get_posts', 'university_adjust_queries');

    function university_map_key($api){
        $api['key'] = 'AIzaSyB_y9j1uxmOH2Y__fMGNwvJ7ZMnjAMz0oM';
        return $api;

    }

    add_filter('acf/fields/google_map/api', 'university_map_key');








    
// Adding featured image to the posts table
// GET FEATURED IMAGE
function ST4_get_featured_image($post_ID) {
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);
    if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
        return $post_thumbnail_img[0];
    }
}
// ADD NEW COLUMN
function ST4_columns_head($defaults) {
    $defaults['featured_image'] = 'Featured Image';
    return $defaults;
}
 
// SHOW THE FEATURED IMAGE
function ST4_columns_content($column_name, $post_ID) {
    if ($column_name == 'featured_image') {
        $post_featured_image = ST4_get_featured_image($post_ID);
        if ($post_featured_image) {
            echo '<img src="' . $post_featured_image . '" />';
        }
    }
}
add_filter('manage_posts_columns', 'ST4_columns_head');
add_action('manage_posts_custom_column', 'ST4_columns_content', 10, 2);


// Redirect subscriber accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}

add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}

//Customize Login Screen
add_filter('login_headerurl', 'reiHeaderUrl' );

function reiHeaderUrl(){
    return esc_url(site_url( '/'));
}

add_action('login_enqueue_scripts', 'reiLoginCSS');

function reiLoginCSS(){
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Lato:100,300,400,700,900'); 
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_register_style( 'rei-themesytle',  get_stylesheet_directory_uri() .'/css/style.css', array(), null, 'all' );
    wp_enqueue_style(  'rei-themesytle' );

}

add_filter('login_headertitle', 'reiLoginTitle');

function reiLoginTitle(){
    return get_bloginfo('name');
}

// Force Note posts to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr){
    if($data['post_type']=='note'){
        if((count_user_posts(get_current_user_id(), 'note')>4) AND (!$postarr['ID']))
        {
           die("Note limit"); 
        }


        $data['post_content'] = sanitize_textarea_field( $data['post_content'] );
        $data['post_title'] = sanitize_text_field( $data['post_title'] );
    }

    if(($data['post_type'] == 'note') AND ($data['post_status'] != 'trash') ){
        $data['post_status'] = 'private';
    }
    
    return $data;
}

