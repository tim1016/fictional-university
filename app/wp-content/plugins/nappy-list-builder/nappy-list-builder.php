<?php
/**
 * Plugin Name
 *
 * @package     Nappy List Builder
 * @author      Inkant Awasthi
 * @copyright   2018 Resonance Realty Management Inc.   
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: nappy list builder
 * Plugin URI:  https://reisavvy.com
 * Description: Builds lists for address book
 * Version:     1.0.0
 * Author:      Inkant Awasthi
 * Author URI:  https://reisavvy.com
 * Text Domain: nappy-list-builder
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


 /* !0. TABLE OF CONTENTS */

/*
    
    1. HOOKS
        1.1 registers all our shortcodes upon init    
        1.2 register custom admin column header
        1.3 register custom admin column data
            
	2. SHORTCODES
        2.1 slb_register_shortcodes()
        2.1 slb_form_shortcode()		

    3. FILTERS
        3.1 slb_subscriber_column_headers()
        3.2 slb_subscriber_column_data()
            3.2.2 slb_register_custom_admin_titles()
            3.2.3 slb_custom_admin_titles()
        3.3  slb_list_column_headers()
        3.4  slb_list_column_data()


		
	4. EXTERNAL SCRIPTS
		
	5. ACTIONS		    
		
	6. HELPERS
		
	7. CUSTOM POST TYPES
	
	8. ADMIN PAGES
	
	9. SETTINGS
		
	10. MISC.

*/  


// 1. HOOKS
// 1.1 registers all short codes upon init event    
add_action( 'init', 'slb_register_shortcodes');
// 1.2 registers custom admin column headers
add_filter('manage_edit-slb_subscriber_columns', 'slb_subscriber_column_headers');
add_filter('manage_edit-slb_list_columns', 'slb_list_column_headers');
//1.3 register custom admin column data
add_filter('manage_slb_subscriber_posts_custom_column', 'slb_subscriber_column_data',1,2);
add_filter('manage_slb_list_posts_custom_column', 'slb_list_column_data',1,2);
add_action('admin_head-edit.php', 'slb_register_custom_admin_titles');

//1.4 
//Register AJAX actions
add_action('wp_ajax_nopriv_slb_save_subscription', 'slb_save_subscription'); //regular web visitor
add_action('wp_ajax_slb_save_subscription', 'slb_save_subscription'); // Admin user
//1.5 Load external scripts
add_action( 'wp_enqueue_scripts', 'slb_public_scripts');
//1.6 Advanced custom fields settings
add_filter( 'acf/settings/path', 'slb_acf_settings_path');
add_filter( 'acf/settings/dir', 'slb_acf_settings_dir');
add_filter( 'acf/settings/show_admin', 'slb_acf_show_admin');
if(!defined('ACF_LITE')) define('ACF_LITE',true);

//1.7  Register admin menus
add_action('admin_menu', 'slb_admin_menus');

// 1.8
add_action( 'admin_enqueue_scripts', 'slb_admin_scripts');

//1.9
add_action('admin_init', 'slb_register_options');
	
// 2. SHORTCODES
// 2.1 slb_register_shortcodes()
//regsiters our custom shortcodes
function slb_register_shortcodes(){
    add_shortcode( 'slb_form', 'slb_form_shortcode' );
}

// 2.2 slb_form_shortcode()
// returns HTML string for an email capture form
function slb_form_shortcode($args, $content=""){
    //get the list id
    $list_id=0;
    if(isset($args['id'])) $list_id = (int) $args['id'];
    $title='';
    if(isset($args['title'])) $title = (string) $args['title'];


    // content will be the content which the shortcode is wrapped around
    $output = '     
    <div class="slb">
        <form action="/wp-admin/admin-ajax.php?action=slb_save_subscription" 
        method="POST" id="slb_form" class="slb-form">

            <input type="hidden" name="slb_list" value="'. $list_id .'">';

            if(strlen($title)){
                $output .= '<h3 class="slb-title">' . $title . '</h3>';
            }

            $output .=
            '<p class="slb-input-container">
                <label for="">Your Name</label> <br>
                <input type="text" name="slb_fname" id="" placeholder="First Name">
                <input type="text" name="slb_lname" id="" placeholder="Last Name">
            </p>


            <p class="slb-input-container">
                <label for="">Email</label> <br>
                <input type="email" name="slb_email" id="" placeholder="you@email.com">
            </p>
            <p class="slb-input-container">
                <label for="">Phone</label> <br>
                <input type="text" name="slb_addphone" id="" placeholder="1233333333">
            </p>
            
            ';

            if(strlen($content)){
                $output .=  '<div class="slb-content">' .   wpautop($content) . '</div>';
            }

            $output .= '

            <p class="slb-input-container">
                <label for="">Address</label> <br> 
                <input type="text" name="slb_addline1" id="" placeholder="Line 1">
                <input type="text" name="slb_addline2" id="" placeholder="Line 2">
            </p>


            <p class="slb-input-container">
                <label for="">City</label> 
                <input type="text" name="slb_addcity" id="" placeholder="City">
            
                <label for="">State</label>
                <input type="text" name="slb_addstate" id="" placeholder="State">

                <label for="">Zip</label> 
                <input type="text" name="slb_addzip" id="" placeholder="Zipcode">
            </p>
            ';

            
            $output .= '<p class="slb-input-container">
                <input type="submit" name="slb_submit" value="Sign me up">
            </p>
        </form>
    </div>
    ';
    return $output;
}
		
// 3. FILTERS
//3.1
 function slb_subscriber_column_headers(){
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Subscriber Name'),
        'email' => __('Email Address'),
        'address' => __('Address'),
        'phone' => __('Phone')
    );
    return $columns;
}
// 3.2
/*
function slb_subscriber_column_data( $column, $post_id ) {
	
	// setup our return text
	$output = '';
	
	switch( $column ) {
		
		case 'name':
			// get the custom name data
			$fname = get_field('slb_fname', $post_id );
			$lname = get_field('slb_lname', $post_id );
			$output .= $fname .' '. $lname;
			break;
		case 'email':
			// get the custom email data
			$email = get_field('slb_email', $post_id );
			$output .= $email;
			break;
		
	}
	
	// echo the output
	echo $output;
	
}
*/

function slb_subscriber_column_data($column, $post_id){

    $output='';
    $address='';
    switch($column){
        case 'title':
            $fname = get_field('slb_fname', $post_id);
            $lname = get_field('slb_lname', $post_id);
            $output .= $fname . ' ' . $lname;
            break;
        case 'email':
            $email = get_field('slb_email', $post_id);
            $output .= $email;
            break;
        case 'address':
            $address .= get_field('slb_addline1', $post_id);
            $address .= ', ';
            $address .= get_field('slb_addline2', $post_id);
            $address .= ', ';
            $address .= get_field('slb_addcity', $post_id);
            $address .= ' ';
            $address .= get_field('slb_addstate', $post_id);
            $address .= ' ';
            $address .= get_field('slb_addzip', $post_id);
            $output .= $address;
            break;
        case 'phone':
            $output .= get_field('slb_addphone', $post_id);
            break;
    }
    echo $output;
}
function slb_admin_menus() {
	
	/* main menu */
	
		$top_menu_item = 'slb_dashboard_admin_page';
	    
	    add_menu_page( '', 'List Builder', 'manage_options', 'slb_dashboard_admin_page', 'slb_dashboard_admin_page', 'dashicons-email-alt' );
    
    /* submenu items */
    
	    // dashboard
	    add_submenu_page( $top_menu_item, '', 'Dashboard', 'manage_options', $top_menu_item, $top_menu_item );
	    
	    // email lists
	    add_submenu_page( $top_menu_item, '', 'Email Lists', 'manage_options', 'edit.php?post_type=slb_list' );
	    
	    // subscribers
	    add_submenu_page( $top_menu_item, '', 'Subscribers', 'manage_options', 'edit.php?post_type=slb_subscriber' );
	    
	    // import subscribers
	    add_submenu_page( $top_menu_item, '', 'Import Subscribers', 'manage_options', 'slb_import_admin_page', 'slb_import_admin_page' );
	    
	    // plugin options
	    add_submenu_page( $top_menu_item, '', 'Plugin Options', 'manage_options', 'slb_options_admin_page', 'slb_options_admin_page' );

}
//3.2.2
function slb_register_custom_admin_titles(){
    add_filter(
        'the_title',
        'slb_custom_admin_titles',
        99,
        2
    );
}
//3.2.3
function slb_custom_admin_titles($title, $post_id){
    global $post;

    $output=$title;
    if (isset($post->post_type)):
        switch($post->post_type){
            case 'slb_subscriber':
            $fname = get_field('slb_fname', $post_id);
            $lname = get_field('slb_lname', $post_id);
            $output = $fname . ' ' . $lname;
            break;
        }
    endif;
    return $output;
}

//3.3
function slb_list_column_headers($columns){
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('List Name'),
        'shortcode' => __('Shortcode'),
    );
    return $columns;
}

// 3.4
function slb_list_column_data($column, $post_id){

    $output='';
    switch($column){
        case 'shortcode':
        $output .= '[slb_form id="' . $post_id . '"]';
        break;
/*        case 'email':
        $email = get_field('slb_email', $post_id);
        $output .= $email;
        break;
*/        
    }
    echo $output;
}
		
// 4. EXTERNAL SCRIPTS
// 4.1 Include ACF
include_once( plugin_dir_path( __FILE__ ) . 'lib/advanced-custom-fields/acf.php');

//4.2 Include styles and scripts
function slb_public_scripts(){
    wp_register_script( 'nappy-list-builder-js-public', plugins_url('/js/public/nappy-list-builder.js', __FILE__), array('jquery'), '', true);

    wp_register_style( 'nappy-list-builder-css-public', plugins_url('/css/public/nappy-list-builder.css', __FILE__));
    wp_enqueue_script('nappy-list-builder-js-public');
    wp_enqueue_style('nappy-list-builder-css-public');
}   

//4.3 Admin scripts to fix the menu closing problem with the wordpress dashboard
function slb_admin_scripts(){
    wp_register_script( 'nappy-list-builder-js-private', plugins_url( '/js/private/nappy-list-builder.js', __FILE__ ), array('jquery'), '', true);
    wp_enqueue_script( 'nappy-list-builder-js-private');
}
		
// 5. ACTIONS




// 5.1 Saves subscription data to an existing or a new subscriber
function slb_save_subscription() {
	
	// setup default result data
	$result = array(
		'status' => 0,
		'message' => 'Subscription was not saved. ',
		'error'=>'',
		'errors'=>array()
	);
	
	try {
		
		// get list_id
		$list_id = (int)$_POST['slb_list'];
	
		// prepare subscriber data
		$subscriber_data = array(
			'fname'=> esc_attr( $_POST['slb_fname'] ),
			'lname'=> esc_attr( $_POST['slb_lname'] ),
            'email'=> esc_attr( $_POST['slb_email'] ),
            'slb_addline1'=> esc_attr( $_POST['slb_addline1'] ),
            'slb_addline2'=> esc_attr( $_POST['slb_addline2'] ),
            'slb_addcity'=> esc_attr( $_POST['slb_addcity'] ),
            'slb_addstate'=> esc_attr( $_POST['slb_addstate'] ),
            'slb_addzip'=> esc_attr( $_POST['slb_addzip'] ),
            'slb_addphone'=> esc_attr( $_POST['slb_addphone'] ),
		);
		
		// setup our errors array
		$errors = array();
		
		// form validation
		if( !strlen( $subscriber_data['fname'] ) ) $errors['fname'] = 'First name is required.';
		if( !strlen( $subscriber_data['email'] ) ) $errors['email'] = 'Email address is required.';
		if( strlen( $subscriber_data['email'] ) && !is_email( $subscriber_data['email'] ) ) $errors['email'] = 'Email address must be valid.';
		
		// IF there are errors
		if( count($errors) ):
		
			// append errors to result structure for later use
			$result['error'] = 'Some fields are still required. ';
			$result['errors'] = $errors;
		
		else: 
		// IF there are no errors, proceed...
		
			// attempt to create/save subscriber
			$subscriber_id = slb_save_subscriber( $subscriber_data );
			
			// IF subscriber was saved successfully $subscriber_id will be greater than 0
			if( $subscriber_id ):
			
				// IF subscriber already has this subscription
				if( slb_subscriber_has_subscription( $subscriber_id, $list_id ) ):
				
					// get list object
					$list = get_post( $list_id );
					
					// return detailed error
					$result['error'] = esc_attr( $subscriber_data['email'] .' is already subscribed to '. $list->post_title .'.');
					
				else: 
				
					// save new subscription
					$subscription_saved = slb_add_subscription( $subscriber_id, $list_id );
			
					// IF subscription was saved successfully
					if( $subscription_saved ):
					
						// subscription saved!
						$result['status']=1;
						$result['message']='Subscription saved';
						
					else: 
					
						// return detailed error
						$result['error'] = 'Unable to save subscription.';
					
					
					endif;
				
				endif;
			
			endif;
		
		endif;
		
	} catch ( Exception $e ) {
		
	}
	
	// return result as json
	slb_return_json($result);
	
}



//5.2 
function slb_save_subscriber($subscriber_data){
    $subscriber_id = 0;
    try{
        $subscriber_id=slb_get_subscriber_id( $subscriber_data['email']);

        if(!$subscriber_id):
            $subscriber_id=wp_insert_post( array(
                'post_type' => 'slb_subscriber',
                'post_title' => $subscriber_data['fname'] . ' ' . $subscriber_data['lname'],
                'post_status' => 'publish'
            ), true );
        endif;

        update_field(slb_get_acf_key('slb_fname'), $subscriber_data['fname'], $subscriber_id);
        update_field(slb_get_acf_key('slb_lname'), $subscriber_data['lname'], $subscriber_id);
        update_field(slb_get_acf_key('slb_email'), $subscriber_data['email'], $subscriber_id);
        update_field(slb_get_acf_key('slb_addline1'), $subscriber_data['slb_addline1'], $subscriber_id);
        update_field(slb_get_acf_key('slb_addline2'), $subscriber_data['slb_addline2'], $subscriber_id);
        update_field(slb_get_acf_key('slb_addcity'), $subscriber_data['slb_addcity'], $subscriber_id);
        update_field(slb_get_acf_key('slb_addstate'), $subscriber_data['slb_addstate'], $subscriber_id);
        update_field(slb_get_acf_key('slb_addzip'), $subscriber_data['slb_addzip'], $subscriber_id);
        update_field(slb_get_acf_key('slb_addphone'), $subscriber_data['slb_addphone'], $subscriber_id);

    }
    catch( Exception $e){
        echo $e;
    }
    wp_reset_query();
    return $subscriber_id;
}


//5.3  Add subscription
function slb_add_subscription($subscriber_id, $list_id){
    $subscription_saved=false;

    if(!slb_subscriber_has_subscription($subscriber_id, $list_id)):
        $subscriptions = slb_get_subscriptions($subscriber_id);
        array_push($subscriptions, $list_id);
        update_field(slb_get_acf_key('slb_subscriptions'), $subscriptions, $subscriber_id);
        $subscription_saved=true;
    endif;
    return $subscription_saved;
}






// 6. HELPERS
// 6.1 check is the subscriber already has a subscriptiom
function slb_subscriber_has_subscription($subscriber_id, $list_id){

    $has_subscription = false;
    $subscriber = get_post($subscriber_id);
    $subscriptions = slb_get_subscriptions ($subscriber_id);

    if(in_array($list_id,$subscriptions)):
        $has_subscription = true;
    endif;
    
    return $has_subscription;
}
//6.2
function slb_get_subscriber_id($email){

    $subscriber_id  = 0;

    try{
        $subscriber_query = new WP_query(
            array(
                'post_type' => 'slb_subscriber',
                'posts_per_page' => 1,
                'meta_key' => 'slb_email',
                'meta_query' => array(
                    array(
                    'key' => 'slb_email',
                    'value' => $email,
                    'compare' => '='
                    ),                    
                ),
            )
        );
        if($subscriber_query->have_posts()):
            $subscriber_query->the_post();
            $subscriber_id = get_the_ID();
        endif;
    }
    catch( Exception $e){

    }
    wp_reset_query();

    return (int)$subscriber_id;

}
//6.3 Get subscriptions for a particular subscriber
function slb_get_subscriptions( $subscriber_id ){
    $subscriptions = array();
    $lists = get_field( slb_get_acf_key('slb_subscriptions'), $subscriber_id);
    if($lists):
        if(is_array($lists) && count($lists)):
            foreach ($lists as &$list):
                $subscriptions[] = (int)$list->ID;
            endforeach;
        elseif( is_numeric($lists)):
            $subscriptions[]=$lists;
        endif;
    endif;
    return (array)$subscriptions;
}
 

//6.4 Return JSON
function slb_return_json( $php_array){
    $json_result = json_encode($php_array);

    die($json_result);

    exit;
}


//6.5 Get the unique ACF Field key 

function slb_get_acf_key($field_name){
	
	$field_key = $field_name;
	
	switch( $field_name ) {
		
		case 'slb_fname':
			$field_key = 'field_5b3f9583f9452';
			break;
		case 'slb_lname':
			$field_key = 'field_5b3f95d7f9454';
			break;
		case 'slb_email':
			$field_key = 'field_5b3f997f5f438';
			break;
		case 'slb_subscriptions':
			$field_key = 'field_5b3f9acef74b6';
            break;
        case 'slb_addline1':
			$field_key = 'field_5b3ff88cd7313';
            break;      
        case 'slb_addline2':
			$field_key = 'field_5b3ff8bcd7314';
            break; 
        case 'slb_addcity':
			$field_key = 'field_5b3ff8c6d7315';
			break;                                 
        case 'slb_addstate':
			$field_key = 'field_5b3ff8bcd7316';
            break;                                 
        case 'slb_addzip':
			$field_key = 'field_5b3ff8bcd7317';
            break;                                 
        case 'slb_addphone':
			$field_key = 'field_5b40014b4fa9b';
			break;                                 
	}
	
	return $field_key;
}

//6.6 Get subscriber data
function get_subscriber_data($subscriber_id){

    $subscriber_data=array();
    $subscriber=get_post($subscriber_id);

    if(isset($subscriber->post_type) && $subscriber->post_type == 'slb_subscriber'):
        $subscriber_data=array(
            'name'=> get_field(slb_get_acf_key('slb_fname'), $subscriber_id) .' '. get_field(slb_get_acf_key('slb_lname'), $subscriber_id),
            'fname'=>get_field(slb_get_acf_key('slb_fname'), $subscriber_id),
            'lname'=>get_field(slb_get_acf_key('slb_lname'), $subscriber_id),
            'email'=>get_field(slb_get_acf_key('slb_email'), $subscriber_id),
            'slb_subscriptions'=>slb_get_subscriptions($subscriber_id),
            'addline1'=>get_field(slb_get_acf_key('slb_addline1'), $subscriber_id),
            'addline2'=>get_field(slb_get_acf_key('slb_addline2'), $subscriber_id),
            'addcity'=>get_field(slb_get_acf_key('slb_addcity'), $subscriber_id),
            'addstate'=>get_field(slb_get_acf_key('slb_addstate'), $subscriber_id),
            'addzip'=>get_field(slb_get_acf_key('slb_addzip'), $subscriber_id),
            'addphone'=>get_field(slb_get_acf_key('slb_addphone'), $subscriber_id),
        );
    endif;

    return $subscriber_data;
}
// 6.7
function slb_get_page_select( $input_name="slb_apge", $input_id="", $parent=-1, $value_field="id", $selected_value=""){
    $pages = get_pages(
        array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'post_type' => 'page',
            'parent' => $parent,
            'status' => array('draft', 'publish')
        )
    );

    $select = '<select name="' . $input_name . '" ';
    if(strlen($input_id)){
        $select .= 'id="' . $input_id . '" ';
    }
    $select .= '><option value="">--Select One--</option>';

    foreach ($pages as &$page){
        $value = $page->ID;
        switch( $value_field ){
            case 'slug':
            $value = $page->post_name;
            break;

            case 'url':
            $value = get_page_link( $page->ID );
            break;

            default:
            $value = $page->ID;
        }

        $selected='';
        if($selected_value==$value)  $selected = ' selected="selected"';

        $option = '<option value="' . $value . '" ' . $selected .'>';
        $option .= $page->post_title;
        $option .= '</option>';

        $select .= $option;
    }

    $select .= '</select>';
    return $select;
}

// 6.8
// hint: returns default option values as an associative array
function slb_get_default_options() {
	
	$defaults = array();
	
	try {
		
		// get front page id
		$front_page_id = get_option('page_on_front');
	
		// setup default email footer
		$default_email_footer = '
			<p>
				Sincerely, <br /><br />
				The '. get_bloginfo('name') .' Team<br />
				<a href="'. get_bloginfo('url') .'">'. get_bloginfo('url') .'</a>
			</p>
		';
		
		// setup defaults array
		$defaults = array(
			'slb_manage_subscription_page_id'=>$front_page_id,
			'slb_confirmation_page_id'=>$front_page_id,
			'slb_reward_page_id'=>$front_page_id,
			'slb_default_email_footer'=>$default_email_footer,
			'slb_download_limit'=>3,
		);
	
	} catch( Exception $e) {
		
		// php error
		
	}	
	// return defaults
	return $defaults;	
}



//6.9
function slb_get_option($option_name){
    $option_value='';

    try{
        $defaults=slb_get_default_options();

        switch ($option_name){
            
            case 'slb_manage_subscription_page_id':
            //subscription page id
            $option_value = (get_option('slb_manage_subscription_page_id')) ? get_option('slb_manage_subscription_page_id') : $defaults['slb_manage_subscription_page_id'];
            break;

            
            case 'slb_confirmation_page_id':
            //confirmation page id
            $option_value = (get_option('slb_confirmation_page_id')) ? get_option('slb_confirmation_page_id') : $defaults['slb_confirmation_page_id'];
            break;

            
            case 'slb_reward_page_id':
            //reward page id
            $option_value = (get_option('slb_reward_page_id')) ? get_option('slb_reward_page_id') : $defaults['slb_reward_page_id'];
            break;

            case 'slb_default_email_footer':
            //default email footer
            $option_value = (get_option('slb_default_email_footer')) ? get_option('slb_default_email_footer') : $defaults['slb_default_email_footer'];
            break;

            case 'slb_download_limit':
            //download limit
            $option_value = (get_option('slb_download_limit')) ? (int) get_option('slb_download_limit') : $defaults['slb_download_limit'];
            break;
        }
    }
    catch(Exception $e){

    }
    return $option_value;
}


//6.10
function slb_get_current_options(){
    $current_options = array();

    try{
        $current_options = array(
            'slb_manage_subscription_page_id' => slb_get_option('slb_manage_subscription_page_id'),
            'slb_confirmation_page_id' => slb_get_option('slb_confirmation_page_id'),
            'slb_reward_page_id' => slb_get_option('slb_reward_page_id'),
            'slb_default_email_footer' => slb_get_option('slb_default_email_footer'),
            'slb_download_limit' => slb_get_option('slb_download_limit')
        );
    }
    catch(Exception $e){

    }
    return $current_options;
}


		
// 7. CUSTOM POST TYPES
//7,1 subscribers
include_once( plugin_dir_path( __FILE__ ) . '/cpt/slb_subscriber.php');
include_once( plugin_dir_path( __FILE__ ) . '/cpt/slb_list.php');
	
// 8. ADMIN PAGES
function slb_dashboard_admin_page(){
    $output = '
    <div class="wrap">
        <?php screen_icon();?>
        <h2>Nappy List Builder   </h2>
        <p>The ultimate list building plugin for Wordpress. Capture new subscribers. Reward subscribers with a custom download opt-in. Build unlimited lists. Import and Export subscribers with CSV files.</p>
    </div>
    ';
    echo $output;
}

function slb_import_admin_page(){
    $output = '
    <div class="wrap">
        <h2>Import Subscribers</h2>
        <p>Page description ...</p>
    </div>
    ';
    echo $output;
}



function slb_options_admin_page() {
	
	// get the default values for our options
	$options = slb_get_current_options();
	
	echo('<div class="wrap">
		
		<h2>Snappy List Builder Options</h2>
		
        <form action="options.php" method="post">');

			// outputs a unique nounce for our plugin options
			settings_fields('slb_plugin_options');
			// generates a unique hidden field with our form handling url
			@do_settings_fields('slb_plugin_options', '');

            echo('<table class="form-table">
			
				<tbody>
			
					<tr>
						<th scope="row"><label for="slb_manage_subscription_page_id">Manage Subscriptions Page</label></th>
						<td>
							'. slb_get_page_select( 'slb_manage_subscription_page_id', 'slb_manage_subscription_page_id', 0, 'id', $options['slb_manage_subscription_page_id'] ) .'
							<p class="description" id="slb_manage_subscription_page_id-description">This is the page where Snappy List Builder will send subscribers to manage their subscriptions. <br />
								IMPORTANT: In order to work, the page you select must contain the shortcode: <strong>[slb_manage_subscriptions]</strong>.</p>
						</td>
					</tr>
					
			
					<tr>
						<th scope="row"><label for="slb_confirmation_page_id">Opt-In Page</label></th>
						<td>
							'. slb_get_page_select( 'slb_confirmation_page_id', 'slb_confirmation_page_id', 0, 'id', $options['slb_confirmation_page_id'] ) .'
							<p class="description" id="slb_confirmation_page_id-description">This is the page where Snappy List Builder will send subscribers to confirm their subscriptions. <br />
								IMPORTANT: In order to work, the page you select must contain the shortcode: <strong>[slb_confirm_subscription]</strong>.</p>
						</td>
					</tr>
					
			
					<tr>
						<th scope="row"><label for="slb_reward_page_id">Download Reward Page</label></th>
						<td>
							'. slb_get_page_select( 'slb_reward_page_id', 'slb_reward_page_id', 0, 'id', $options['slb_reward_page_id'] ) .'
							<p class="description" id="slb_reward_page_id-description">This is the page where Snappy List Builder will send subscribers to retrieve their reward downloads. <br />
								IMPORTANT: In order to work, the page you select must contain the shortcode: <strong>[slb_download_reward]</strong>.</p>
						</td>
					</tr>
			
					<tr>
						<th scope="row"><label for="slb_default_email_footer">Email Footer</label></th>
						<td>');
						
							
							// wp_editor will act funny if it's stored in a string so we run it like this...
							wp_editor( $options['slb_default_email_footer'], 'slb_default_email_footer', array( 'textarea_rows'=>8 ) );
							
							
							echo('<p class="description" id="slb_default_email_footer-description">The default text that appears at the end of emails generated by this plugin.</p>
						</td>
					</tr>
			
					<tr>
						<th scope="row"><label for="slb_download_limit">Reward Download Limit</label></th>
						<td>
							<input type="number" name="slb_download_limit" value="'. $options['slb_download_limit'] .'" class="" />
							<p class="description" id="slb_download_limit-description">The amount of downloads a reward link will allow before expiring.</p>
						</td>
					</tr>
			
				</tbody>
				
			</table>');
		
			// outputs the WP submit button html
			@submit_button();
		
		
		echo('</form>
	
	</div>');
	
}

	
// 9. SETTINGS
function slb_register_options(){
    register_setting('slb_plugin_options', 'slb_manage_subscription_page_id');
    register_setting('slb_plugin_options', 'slb_confirmation_page_id');
    register_setting('slb_plugin_options', 'slb_reward_page_id');
    register_setting('slb_plugin_options', 'slb_default_email_footer');
    register_setting('slb_plugin_options', 'slb_download_limit');
}
// 10. MISC.