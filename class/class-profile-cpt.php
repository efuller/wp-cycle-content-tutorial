<?php

namespace WPCCT;

/**
 * Class Profile_CPT.
 *
 * @package WPCCT
 * @since 1.0.0
 */
class Profile_CPT {

	/**
	 * Register CPT.
	 */
	public function setup_cpt() {
		$labels = [
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
		];

		$args = [
			'labels'             => $labels,
			'description'        => __( 'Description.', 'wpcct' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'profile' ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail' ],
		];

		register_post_type( 'profile', $args );
	}

	/**
	 * Register custom WordPress hooks.
	 */
	public function register_hooks() {
		add_action( 'init', [ $this, 'setup_cpt' ] );
	}

	public function get_profile_post() {
		$post_id = intval( $_POST['id'] );

		if ( empty( $post_id ) ) {
			wp_die( 0 );
		}

		global $post;

		$old_post = $post;

		$post          = get_post( $post_id );
		$next_post     = get_next_post();
		$previous_post = get_previous_post();

		$data = [
			'title'            => $post->post_title,
			'content'          => $post->post_content,
			'next_article'     => ! empty( $next_post ) ? get_the_permalink( $next_post->ID ) : false,
			'previous_article' => ! empty( $previous_post ) ? get_the_permalink( $previous_post->ID ) : false,
			'next_id'          => ! empty( $next_post ) ? $next_post->ID : 0,
			'previous_id'      => ! empty( $previous_post ) ? $previous_post->ID : 0,
		];

		$post = $old_post;

		wp_send_json( $data );
	}
}
