<?php

namespace WPCCT;

class Ajax {
	public function register_hooks() {
		add_action( 'wp_ajax_nopriv_wpcct_get_post', array( App::get( 'profile_cpt' ), 'get_profile_post' ) );
		add_action( 'wp_ajax_wpcct_get_post', array( App::get( 'profile_cpt' ), 'get_profile_post' ) );
	}
}