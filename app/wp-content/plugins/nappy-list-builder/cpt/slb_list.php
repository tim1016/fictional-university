<?php

function slb_register_slb_list() {

	/**
	 * Post Type: Lists.
	 */

	$labels = array(
		"name" => __( "Lists", "resonance" ),
		"singular_name" => __( "List", "resonance" ),
		"menu_name" => __( "Lists", "resonance" ),
	);

	$args = array(
		"label" => __( "Lists", "resonance" ),
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
		"rewrite" => array( "slug" => "slb_list", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title" ),
	);

	register_post_type( "slb_list", $args );
}

add_action( 'init', 'slb_register_slb_list' );
