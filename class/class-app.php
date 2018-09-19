<?php
/**
 * The plugin App.
 *
 * @package WPSP
 * @since 1.0.0
 */

namespace WPCCT;

/**
 * Main App class.
 *
 * Dependency injection container.
 *
 * @since 1.0.0
 * @package WPCCT
 */
class App {

	/**
	 * Registered dependencies.
	 *
	 * @static
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected static $registry = [];

	/**
	 * Register a new dependency.
	 *
	 * @static
	 *
	 * @since 1.0.0
	 * @param string $key   Name of the dependency.
	 * @param mixed  $value The dependency being registered.
	 */
	public static function bind( $key, $value ) {
		static::$registry[ $key ] = $value;
	}

	/**
	 * Get a dependency.
	 *
	 * @static
	 *
	 * @since 1.0.0
	 * @param string $key Name of registered dependency.
	 * @throws \Exception If no key is provided.
	 * @return mixed
	 */
	public static function get( $key ) {
		if ( ! array_key_exists( $key, static::$registry ) ) {
			throw new \Exception( 'There was no key registered!' );
		}

		return static::$registry[ $key ];
	}

	/**
	 * Helper that returns the registered dependencies.
	 *
	 * @since 1.0.0
	 * @return array $registry Current dependencies.
	 */
	public function get_registry() {
		return static::$registry;
	}
}
