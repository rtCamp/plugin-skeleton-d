<?php
/**
 * The main plugin file.
 *
 * @package rtCamp\Plugin_Skeleton_D
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D;

use rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\Contracts\Traits\Loader;
use rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\Contracts\Traits\Singleton;

/**
 * Class - Main
 */
final class Main {
	use Singleton;
	use Loader;

	/**
	 * Classes loaded on startup.
	 *
	 * @var class-string<\rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\Contracts\Interfaces\Registrable|\rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\Contracts\Interfaces\Shareable>[]
	 */
	private const CLASSES = [
		Core\Assets::class,
		Core\Templates::class,
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
		$this->load( self::CLASSES );

		// Register activation and deactivation hooks.
		register_activation_hook( PLUGIN_SKELETON_D_FILE, [ self::class, 'activate' ] );
		register_deactivation_hook( PLUGIN_SKELETON_D_FILE, [ self::class, 'deactivate' ] );

		// Do other stuff here like dep-checking, telemetry, etc.
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
