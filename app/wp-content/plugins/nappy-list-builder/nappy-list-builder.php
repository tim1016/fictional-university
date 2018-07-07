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

//1.4 Register AJAX actions
add_action('wp_ajax_nopriv_slb_save_subscription', 'slb_save_subscription'); //regular web visitor
add_action('wp_ajax_slb_save_subscription', 'slb_save_subscription'); // Admin user

	
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


    // content will be the content which the shortcode is wrapped around
    $output = '     
    <div class="slb">
        <form action="/wp-admin/admin-ajax.php?action=slb_save_subscription" 
        method="POST" id="slb_form" class="slb-form">

            <input type="hidden" name="slb_list" value="'. $list_id .'">
            <p class="slb-input-container">
                <label for="">Your Name</label> <br>
                <input type="text" name="slb_fname" id="" placeholder="First Name">
                <input type="text" name="slb_lname" id="" placeholder="Last Name">
            </p>


            <p class="slb-input-container">
                <label for="">Email</label> <br>
                <input type="email" name="slb_email" id="" placeholder="you@email.com">
            </p>';

            if(strlen($content)){
                $output .=  '<div class="slb-content">' .   wpautop($content) . '</div>';
            }

            $output .= '

            <p class="slb-input-container">
                <label for="">Address</label> <br> 
                <input type="text" name="addline1" id="" placeholder="Line 1">
                <input type="text" name="addline2" id="" placeholder="Line 2">
            </p>


            <p class="slb-input-container">
                <label for="">City</label> 
                <input type="text" name="addcity" id="" placeholder="City">
            
                <label for="">State</label>
                <input type="text" name="addstate" id="" placeholder="State">

                <label for="">Zip</label> 
                <input type="text" name="addzip" id="" placeholder="Zipcode">
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
            $address .= get_field('addline_1', $post_id);
            $address .= ', ';
            $address .= get_field('addline_2', $post_id);
            $address .= ', ';
            $address .= get_field('addcity', $post_id);
            $address .= ' ';
            $address .= get_field('addstate', $post_id);
            $address .= ' ';
            $address .= get_field('addzip', $post_id);
            $output .= $address;
            break;
        case 'phone':
            $output .= get_field('addphone', $post_id);
            break;
    }
    echo $output;
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
		
// 5. ACTIONS




// 5.1 Saves subscription data to an existing or a new subscriber
function slb_save_subscription(){
    $result = array(
        'status' => 0,
        'message' => 'Subscription was not saved'
    );

    $errors=array();

    try{
        $list_id = (int) $_POST['slb_list'];

        // Prepare subscriber data
        $subscriber_data = array(
            'fname' => esc_attr( $_POST['slb_fname'] ),
            'lname' => esc_attr( $_POST['slb_lname'] ),
            'email' => esc_attr( $_POST['slb_email'] ),
            'addline1' => esc_attr( $_POST['addline1'] ),
            'addline2' => esc_attr( $_POST['addline2'] ),
            'addcity' => esc_attr( $_POST['addcity'] ),
            'addstate' => esc_attr( $_POST['addstate'] ),
            'addzip' => esc_attr( $_POST['addzip'] )
        );

        $subscriber_id = slb_save_subscriber($subscriber_data);

        if($subscriber_id):
            if(slb_subscriber_has_subscription($subscriber_id, $list_id)):
                $list = get_post($list_id);
                $result['message'] .= esc_attr( $subscriber_data['email'] . ' is already subscribed to ' .                 $list->post_title . '.' );
            else:
                $subscription_saved = slb_add_subscription($subscriber_id, $list_id);

                if($subscription_saved):                     
                    $result['status'] =1;
                    $result['message'] = 'Subscriber information was saved successfully';
                endif;
            endif;
        endif;
    } 
    catch(Exception $e){
        $result['message'] = 'Caught exception: ' . $e->getMessage();
    }

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
    }
    catch( Exception $e){
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
    
    $field = get_field_object($field_name);
    $key = $field['key'];
    return $key;


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
            'subscriptions'=>slb_get_subscriptions($subscriber_id)
        );
    endif;

    return $subscriber_data;
}

		
// 7. CUSTOM POST TYPES
	
// 8. ADMIN PAGES
	
// 9. SETTINGS
		
// 10. MISC.