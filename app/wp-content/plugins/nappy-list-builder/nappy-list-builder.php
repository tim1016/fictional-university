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
	
	2. SHORTCODES
		
	3. FILTERS
		
	4. EXTERNAL SCRIPTS
		
	5. ACTIONS		
		
	6. HELPERS
		
	7. CUSTOM POST TYPES
	
	8. ADMIN PAGES
	
	9. SETTINGS
		
	10. MISC.

*/  


// 1. HOOKS
	
// 2. SHORTCODES

function slb_form($args, $content=""){
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

            

            $output .= '<p class="slb-input-container">
                <input type="submit" name="slb_submit" value="Sign me up">
            </p>
        </form>
    </div>
    ';
    return $output;
}
		
// 3. FILTERS
		
// 4. EXTERNAL SCRIPTS
		
// 5. ACTIONS		
		
// 6. HELPERS
		
// 7. CUSTOM POST TYPES
	
// 8. ADMIN PAGES
	
// 9. SETTINGS
		
// 10. MISC.