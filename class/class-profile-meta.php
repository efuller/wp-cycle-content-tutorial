<?php

namespace WPCCT;

/**
 * Class Profile_Meta.
 *
 * @package WPCCT
 * @since 1.0.0
 */
class Profile_Meta {

	/**
	 * Add metabox.
	 *
	 * @since 1.0.0
	 */
	public function add_metabox() {
		add_meta_box(
			'wpcct_job_title',
			'Job Title',
			[ $this, 'metabox_markup' ],
			'profile'
		);
	}

	/**
	 * Display the metabox.
	 *
	 * @since 1.0.0
	 * @param object $post The post.
	 */
	public function metabox_markup( $post ) {
		wp_nonce_field( '_wp_profile_action', 'profile_meta_box_nonce' );
		$value = get_post_meta( $post->ID, '_wpcct_meta_key', true );
		?>
		<label for="wpcct_job_title">Job Title</label>
		<input type="text" id="wpcct_job_title" name="wpcct_job_title" value="<?php echo esc_html( $value ); ?>">
		<?php
	}

	/**
	 * Save the post meta.
	 *
	 * @since 1.0.0
	 * @param int $post_id The post id.
	 * @return void
	 */
	public function save( $post_id ) {
		if ( ! isset( $_POST['profile_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['profile_meta_box_nonce'], '_wp_profile_action' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( array_key_exists( 'wpcct_job_title', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_wpcct_meta_key',
				sanitize_text_field( $_POST['wpcct_job_title'] )
			);
		}
	}

	/**
	 * Register custom hooks.
	 *
	 * @since 1.0.0
	 */
	public function register_hooks() {
		add_action( 'add_meta_boxes_profile', [ $this, 'add_metabox' ] );
		add_action( 'save_post_profile', [ $this, 'save' ] );
	}
}
