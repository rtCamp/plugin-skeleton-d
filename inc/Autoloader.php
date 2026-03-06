<?php
/**
 * Autoloader for PHP classes inside a WordPress plugin.
 *
 * Wraps the Composer autoloader to provide graceful failure if it is missing.
 *
 * @package rtCamp\Plugin_Skeleton_D;
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D;

if ( ! class_exists( 'rtCamp\Plugin_Skeleton_D\Framework\AutoloaderTrait' ) ) {
	require_once PLUGIN_SKELETON_D_PATH . 'framework/AutoloaderTrait.php';
}

/**
 * Class - Autoloader
 */
final class Autoloader {
	use Framework\AutoloaderTrait;

	/**
	 * Attempts to autoload the Composer dependencies.
	 *
	 * If the autoloader is missing, it will display an admin notice and log an error.
	 */
	public static function autoload(): bool {
		// If we're not *supposed* to autoload anything, then return true.
		if ( defined( 'PLUGIN_SKELETON_D_AUTOLOAD' ) && false === PLUGIN_SKELETON_D_AUTOLOAD ) {
			return true;
		}

		$autoloader = PLUGIN_SKELETON_D_PATH . 'vendor/autoload.php';

		return self::require_autoloader( $autoloader );
	}

	/**
	 * The error message to display when the autoloader is missing.
	 */
	private static function get_autoloader_error_message(): string {
		return sprintf(
			/* translators: %s: The plugin name. */
			__( '%s: The Composer autoloader was not found. If you installed the plugin from the GitHub source code, make sure to run `composer install`.', 'plugin-skeleton-d' ),
			esc_html( 'Plugin Skeleton D' )
		);
	}
}
