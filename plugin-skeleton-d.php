<?php
/**
 * Plugin Skeleton D
 *
 * @package           rtCamp/Plugin_Skeleton_D
 * @author            rtCamp
 * @copyright         2026 rtCamp
 * @license           GPL-2.0-or-later
 *
 * Plugin Name:       Plugin Skeleton D
 * Plugin URI:        https://github.com/rtCamp/plugin-skeleton-d
 * Description:       @todo
 * Version:           0.0.1
 * Author:            rtCamp
 * Author URI:        https://rtcamp.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       plugin-skeleton-d
 * Domain Path:       /languages
 * Requires PHP:      8.2
 * Requires at least: 6.9
 * Tested up to:      6.9
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Define the plugin constants.
 */
function constants(): void {
	/**
	 * File path to the plugin's main file.
	 */
	define( 'PLUGIN_SKELETON_D_FILE', __FILE__ );

	/**
	 * Version of the plugin.
	 */
	define( 'PLUGIN_SKELETON_D_VERSION', '0.0.1' );

	/**
	 * Root path to the plugin directory.
	 */
	define( 'PLUGIN_SKELETON_D_PATH', plugin_dir_path( PLUGIN_SKELETON_D_FILE ) );

	/**
	 * Root URL to the plugin directory.
	 */
	define( 'PLUGIN_SKELETON_D_URL', plugin_dir_url( PLUGIN_SKELETON_D_FILE ) );
}

constants();

// If autoloader fails, we cannot proceed.
require_once __DIR__ . '/inc/Autoloader.php';
if ( ! class_exists( 'rtCamp\Plugin_Skeleton_D\Autoloader' ) || ! \rtCamp\Plugin_Skeleton_D\Autoloader::autoload() ) {
	return;
}

// Load the main plugin class.
if ( class_exists( 'rtCamp\Plugin_Skeleton_D\Main' ) ) {
	\rtCamp\Plugin_Skeleton_D\Main::get_instance();
}
