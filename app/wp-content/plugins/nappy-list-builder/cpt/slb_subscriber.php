<?php
//Custom post types

function slb_register_slb_subscriber() {

	/**
	 * Post Type: Subscribers.
	 */

	$labels = array(
		"name" => __( "Subscribers", "resonance" ),
		"singular_name" => __( "Subscriber", "resonance" ),
	);

	$args = array(
		"label" => __( "Subscribers", "resonance" ),
		"labels" => $labels,
		"description" => "",
		"public" => false,
		"publicly_queryable" => false,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => false,
		"show_in_nav_menus" => true,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "slb_subscriber", "with_front" => true ),
		"query_var" => true,
		"supports" => false,
	);

	register_post_type( "slb_subscriber", $args );
}

add_action( 'init', 'slb_register_slb_subscriber' );









// ACF Fields
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_contact-details',
		'title' => 'Contact details',
		'fields' => array (
			array (
				'key' => 'field_5b3f9583f9452',
				'label' => 'First Name',
				'name' => 'slb_fname',
				'type' => 'text',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3f95aaf9453',
				'label' => 'Middle Name',
				'name' => 'slb_mname',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3f95d7f9454',
				'label' => 'Last Name',
				'name' => 'slb_lname',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3f997f5f438',
				'label' => 'Email',
				'name' => 'slb_email',
				'type' => 'email',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
			array (
				'key' => 'field_5b3f9acef74b6',
				'label' => 'Subscriptions',
				'name' => 'slb_subscriptions',
				'type' => 'post_object',
				'post_type' => array (
					0 => 'slb_list',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'allow_null' => 1,
				'multiple' => 1,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slb_subscriber',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
				3 => 'discussion',
				4 => 'comments',
				5 => 'revisions',
				6 => 'slug',
				7 => 'format',
				8 => 'categories',
				9 => 'tags',
				10 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_home-address',
		'title' => 'Home Address',
		'fields' => array (
			array (
				'key' => 'field_5b3ff88cd7313',
				'label' => 'Line 1',
				'name' => 'slb_addline1',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3ff8bcd7314',
				'label' => 'Line 2',
				'name' => 'slb_addline2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3ff8c6d7315',
				'label' => 'City',
				'name' => 'slb_addcity',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3ff8ded7316',
				'label' => 'State',
				'name' => 'slb_addstate',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b3ff8e8d7317',
				'label' => 'Zip',
				'name' => 'slb_addzip',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5b40014b4fa9b',
				'label' => 'Home Phone',
				'name' => 'slb_addphone',
				'type' => 'number',
				'default_value' => 1234567890,
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'slb_subscriber',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
