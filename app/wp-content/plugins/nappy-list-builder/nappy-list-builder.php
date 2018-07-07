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


	
// 2. SHORTCODES
// 2.1 slb_register_shortcodes()
//regsiters our custom shortcodes
function slb_register_shortcodes(){
    add_shortcode( 'slb_form', 'slb_form_shortcode' );
}

// 2.2 slb_form_shortcode()
// returns HTML string for an email capture form
function slb_form_shortcode($args, $content=""){
    // content will be the content which the shortcode is wrapped around
    $output = '     
    <div class="slb">
        <form action="" method="POST" id="slb_form" class="slb-form">
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
function slb_list_column_headers(){
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('List Name')
    );
    return $columns;
}

// 3.4
function slb_list_column_data($column, $post_id){

    $output='';
    switch($column){
/*        case 'title':
        $fname = get_field('slb_fname', $post_id);
        $lname = get_field('slb_lname', $post_id);
        $output .= $fname . ' ' . $lname;
        break;
        case 'email':
        $email = get_field('slb_email', $post_id);
        $output .= $email;
        break;
*/        
    }
    echo $output;
}
		
// 4. EXTERNAL SCRIPTS
		
// 5. ACTIONS		
		
// 6. HELPERS
		
// 7. CUSTOM POST TYPES
	
// 8. ADMIN PAGES
	
// 9. SETTINGS
		
// 10. MISC.