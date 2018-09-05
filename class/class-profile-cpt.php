<?php

namespace WPCCT;

/**
 * Class Profile_CPT.
 *
 * @package WPSP
 * @since 1.0.0
 */
class Profile_CPT {

	/**
	 * Register CPT.
	 */
	public function setup_cpt() {
		$labels = array(
			'name'               => _x( 'Profiles', 'post type general name', 'wpcct' ),
			'singular_name'      => _x( 'Profile', 'post type singular name', 'wpcct' ),
			'menu_name'          => _x( 'Profiles', 'admin menu', 'wpcct' ),
			'name_admin_bar'     => _x( 'Profile', 'add new on admin bar', 'wpcct' ),
			'add_new'            => _x( 'Add New', 'book', 'wpcct' ),
			'add_new_item'       => __( 'Add New Profile', 'wpcct' ),
			'new_item'           => __( 'New Profile', 'wpcct' ),
			'edit_item'          => __( 'Edit Profile', 'wpcct' ),
			'view_item'          => __( 'View Profile', 'wpcct' ),
			'all_items'          => __( 'All Profiles', 'wpcct' ),
			'search_items'       => __( 'Search Profiles', 'wpcct' ),
			'parent_item_colon'  => __( 'Parent Profiles:', 'wpcct' ),
			'not_found'          => __( 'No books found.', 'wpcct' ),
			'not_found_in_trash' => __( 'No books found in Trash.', 'wpcct' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'wpcct' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'profile' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
		);

		register_post_type( 'profile', $args );
	}

	/**
	 * Register custom WordPress hooks.
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'setup_cpt' ) );
	}
}
