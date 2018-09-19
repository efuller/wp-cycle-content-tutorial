<?php
/**
 * Bootstrap for the plugin.
 *
 * @package WPSP
 * @since 1.0.0
 */

namespace WPCCT;

/**
 * Bootstrap Class
 *
 * @since 1.0.0
 * @package WPCCT
 */
class Bootstrap {

	/**
	 * Current version.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Main plugin file.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $plugin_file = '';

	/**
	 * Constructor. Initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin_file = dirname( __FILE__ );
	}

	/**
	 * Register hooks.
	 *
	 * @since 1.0.0
	 */
	public function register_hooks() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Initialize method.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		App::bind( 'version', self::VERSION );
		App::bind( 'plugin_url', plugin_dir_url( $this->plugin_file ) );
		App::bind( 'plugin_directory', plugin_dir_path( $this->plugin_file ) );
		App::bind( 'basename', basename( dirname( $this->plugin_file ) ) );
		App::bind( 'dependencies', new Dependencies() );
		App::bind( 'profile_cpt', new Profile_CPT() );
		App::bind( 'profile_meta', new Profile_Meta() );
		App::bind( 'profile_ajax', new Ajax() );

		$this->init_dependencies();
	}

	/**
	 * Register hooks for all dependencies.
	 *
	 * @since 1.0.0
	 */
	public function init_dependencies() {
		App::get( 'dependencies' )->register_hooks();
		App::get( 'profile_cpt' )->register_hooks();
		App::get( 'profile_meta' )->register_hooks();
		App::get( 'profile_ajax' )->register_hooks();
	}
}
