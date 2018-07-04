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
		1.1 - registers all our custom shortcodes
		1.2 - register custom admin column headers
		1.3 - register custom admin column data
		1.4 - register ajax actions
		1.5 - load external files to public website
		1.6 - Advanced Custom Fields Settings
		1.7 - register our custom menus
		1.8 - load external files in WordPress admin
		1.9 - register plugin options
		1.10 - register activate/deactivate/uninstall functions
		1.11 - trigger reward downloads
		1.12 - admin notices
	
	2. SHORTCODES
		2.1 - slb_register_shortcodes()
		2.2 - slb_form_shortcode()
		2.3 - slb_manage_subscriptions_shortcode()
		2.4 - slb_confirm_subscriptions_shortcode()
		
	3. FILTERS
		3.1 - slb_subscriber_column_headers()
		3.2 - slb_subscriber_column_data()
		3.2.2 - slb_register_custom_admin_titles()
		3.2.3 - slb_custom_admin_titles()
		3.3 - slb_list_column_headers()
		3.4 - slb_list_column_data()
		3.5 - slb_admin_menus()
		
	4. EXTERNAL SCRIPTS
		4.1 - Include ACF
		4.2 - slb_public_scripts()
		
	5. ACTIONS
		5.1 - slb_save_subscription()
		5.2 - slb_save_subscriber()
		5.3 - slb_add_subscription()
		5.4 - slb_unsubscribe()
		5.5 - slb_remove_subscription()
		5.6 - slb_send_subscriber_email()
		5.7 - slb_confirm_subscription()
		5.8 - slb_create_plugin_tables()
		5.9 - slb_activate_plugin()
		5.10 - slb_add_reward_link()
		5.11 - slb_trigger_reward_download()
		5.12 - slb_update_reward_link_download()
		5.13 - slb_trigger_reward_download()
		5.14 - slb_download_subscribers_csv()
		5.15 - slb_parse_import_csv()
		5.16 - slb_import_subscribers()
		5.17 - slb_check_wp_version()
		5.18 - slb_uninstall_plugin()
		5.19 - slb_remove_plugin_tables()
		5.20 - slb_remove_post_data()
		5.21 - slb_remove_options()
		
		
	6. HELPERS
		6.1 - slb_subscriber_has_subscription()
		6.2 - slb_get_subscriber_id()
		6.3 - slb_get_subscritions()
		6.4 - slb_return_json()
		6.5 - slb_get_acf_key()
		6.6 - slb_get_subscriber_data()
		6.7 - slb_get_page_select()
		6.8 - slb_get_default_options()
		6.9 - slb_get_option()
		6.10 - slb_get_current_options()
		6.11 - slb_get_manage_susbcriptions_html()
		6.12 - slb_get_email_template()
		6.13 - slb_validate_list()
		6.14 - slb_validate_subscriber()
		6.15 - slb_get_manage_susbcriptions_link()
		6.16 - slb_get_querystring_start()
		6.17 - slb_get_optin_link()
		6.18 - slb_get_message_html()
		6.19 - slb_get_list_reward()
		6.20 - slb_get_reward_link()
		6.21 - slb_generate_reward_uid()
		6.22 - slb_get_reward()
		6.23 - slb_get_list_subscribers()
		6.24 - slb_get_list_subscribers_count()
		6.25 - slb_get_export_link()
		6.26 - slb_csv_to_array()
		6.27 - slb_get_admin_notice()
		6.28 - slb_get_options_settings()
		
	7. CUSTOM POST TYPES
		7.1 - subscribers
		7.2 - lists
	
	8. ADMIN PAGES
		8.1 - slb_dashboard_admin_page()
		8.2 - slb_import_admin_page()
		8.3 - slb_options_admin_page()
	
	9. SETTINGS
		9.1 - slb_register_options()
		
	10. MISC.

*/  