<?php

namespace WPCCT;

/**
 * Class Ajax
 *
 * @package WPCCT
 * @since 1.0.0
 */
class Ajax {
	/**
	 * Register WordPress actions.
	 *
	 * @throws \Exception Nothing registered.
	 * @since 1.0.0
	 */
	public function register_hooks() {
		add_action( 'wp_ajax_nopriv_wpcct_get_post', array( App::get( 'profile_cpt' ), 'get_profile_post' ) );
		add_action( 'wp_ajax_wpcct_get_post', array( App::get( 'profile_cpt' ), 'get_profile_post' ) );
	}
}