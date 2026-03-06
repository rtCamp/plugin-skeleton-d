<?php
/**
 * Healthcheck CLI command for Plugin Skeleton D.
 *
 * @package rtCamp\Plugin_Skeleton_D\Modules\CLI
 * @since 0.0.1
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Modules\CLI;

use rtCamp\Plugin_Skeleton_D\Framework\Contracts\Interfaces\CLI_Command;

/**
 * Class - Healthcheck
 *
 * Implements the `plugin-skeleton-d health-check` WP-CLI command.
 */
final class Healthcheck implements CLI_Command {
	/**
	 * Get the command name.
	 *
	 * @return lowercase-string&non-empty-string
	 */
	public static function get_name(): string {
		return 'health-check';
	}

	/**
	 * Get the command description.
	 */
	public static function get_description(): string {
		return 'Run a health check on the plugin.';
	}

	/**
	 * Run the health check.
	 *
	 * @param array<int, mixed>    $args       Positional arguments.
	 * @param array<string, mixed> $assoc_args Associative arguments.
	 */
	public static function run( $args = [], $assoc_args = [] ): void { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed, SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
		$checks = [];

		$checks['plugin_active']     = class_exists( 'rtCamp\Plugin_Skeleton_D\Main' );
		$checks['constants']         = defined( 'PLUGIN_SKELETON_D_PATH' ) && defined( 'PLUGIN_SKELETON_D_URL' );
		$checks['composer_autoload'] = class_exists( 'Composer\Autoload\ClassLoader' );

		\WP_CLI::log( 'Plugin Skeleton D Health Check' );
		\WP_CLI::log( '==============================' );

		$all_passed = true;
		foreach ( $checks as $check_name => $passed ) {
			$status = $passed ? '✓ PASS' : '✗ FAIL';
			\WP_CLI::log( "  {$check_name}: {$status}" );

			if ( ! $passed ) {
				$all_passed = false;
			}
		}

		if ( ! $all_passed ) {
			\WP_CLI::error( 'One or more health checks failed. Please investigate the issues above.' );
		}

		\WP_CLI::success( 'All health checks passed!' );
	}
}
