<?php

/**
 * Dependencies for the plugin.
 *
 * @package WPSP
 * @since 1.0.0
 */

namespace WPCCT;

/**
 * Class Dependencies.
 *
 * @since 1.0.0
 * @package WPCCT
 */
class Dependencies {

	/**
	 * Run hooks.
	 *
	 * @since 1.0.0
	 */
	public function register_hooks() {
		// Enqueue styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		// Inject template.
		add_action( 'wp_footer', array( $this, 'inject_template' ) );
	}

	/**
	 * Inject markup and template onto page.
	 *
	 * @since 1.0.0
	 * @throws \Exception Nothing registered.
	 * @return void
	 */
	public function inject_template() {
		if ( ! is_post_type_archive( 'profile' ) ) {
			return;
		}
		include Helpers::view( 'modal-tmpl' );
		include Helpers::view( 'modal' );
	}

	/**
	 * Enqueue public styles.
	 *
	 * @since 1.0.0
	 * @throws \Exception Nothing registered.
	 * @return void
	 */
	public function enqueue_styles() {
		if ( ! is_post_type_archive( 'profile' ) ) {
			return;
		}

		wp_enqueue_style(
			App::get( 'basename' ) . '-style',
			App::get( 'plugin_url' ) . 'assets/css/main.css',
			[],
			App::get( 'version' )
		);
	}

	/**
	 * Enqueue public scripts.
	 *
	 * @since 1.0.0
	 * @throws \Exception Nothing registered.
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( ! is_post_type_archive( 'profile' ) ) {
			return;
		}

		wp_enqueue_script(
			App::get( 'basename' ) . '-js',
			App::get( 'plugin_url' ) . 'assets/js/main.js',
			[ 'jquery', 'wp-util' ],
			App::get( 'version' )
		);

		$data = array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'wpcct_nonce' ),
		);

		wp_localize_script(
			App::get( 'basename' ) . '-js',
			'WPCCT',
			$data
		);
	}
}
