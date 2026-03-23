<?php
/**
 * The main plugin file.
 *
 * @package rtCamp\Plugin_Skeleton_D
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D;

use rtCamp\Plugin_Skeleton_D\Framework\Contracts\Traits\Singleton;

/**
 * Class - Main
 */
final class Main {
	use Singleton;

	/**
	 * Registrable classes are entrypoints that "hook" into WordPress.
	 * They should implement the Registrable interface.
	 *
	 * @var class-string<\rtCamp\Plugin_Skeleton_D\Framework\Contracts\Interfaces\Registrable>[]
	 */
	private const REGISTRABLE_CLASSES = [
		Core\Assets::class,
		Modules\CLI::class,
		Modules\Example::class,
		Modules\Settings\Admin_Screen::class,
		Modules\Settings\Settings::class,
	];

	/**
	 * {@inheritDoc}
	 */
	public static function get_instance(): self {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->setup();
		}

		return self::$instance;
	}

	/**
	 * Setup the plugin.
	 */
	private function setup(): void {
		// Load the plugin classes.
		$this->load();

		// Register activation and deactivation hooks.
		register_activation_hook( PLUGIN_SKELETON_D_FILE, [ self::class, 'activate' ] );
		register_deactivation_hook( PLUGIN_SKELETON_D_FILE, [ self::class, 'deactivate' ] );

		// Do other stuff here like dep-checking, telemetry, etc.
	}

	/**
	 * Load the plugin classes.
	 */
	private function load(): void {
		foreach ( self::REGISTRABLE_CLASSES as $class_name ) {
			$instance = new $class_name();

			$instance->register_hooks();
		}

		// Do other generalizable stuff here.
	}

	/**
	 * Runs on successful plugin activation.
	 *
	 * @internal description
	 */
	public static function activate(): void {
		// For complicated stuff, you might want to use a Core\Activation class.

		// For simple stuff, you can do it here.
		update_option( 'plugin_skeleton_d_version', PLUGIN_SKELETON_D_VERSION );
	}

	/**
	 * Runs on successful plugin deactivation.
	 *
	 * @internal description
	 */
	public static function deactivate(): void {
		// For complicated stuff, you might want to use Core\Deactivation class.

		// For uninstall stuff, use the root `uninstall.php` file instead.
	}
}
