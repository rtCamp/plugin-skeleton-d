<?php
/**
 * Handles efficient plugin template loading (and overloading).
 *
 * @package rtCamp\Plugin_Skeleton_D
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Core;

use rtCamp\Plugin_Skeleton_D\Main;
use rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\Contracts\Interfaces\Shareable;
use rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\TemplateLoader;

/**
 * Class Templates
 */
final class Templates extends TemplateLoader implements Shareable {
	/**
	 * The hook prefix for all filters and actions in this class.
	 */
	private const HOOK_PREFIX = 'plugin_skeleton_d';

	/**
	 * The relative template dir.
	 */
	private const TEMPLATE_DIR = 'templates';

	/**
	 * The theme dir for template overrides
	 */
	private const TEMPLATE_THEME_DIR = 'plugin-skeleton-d';

	/**
	 * Configure the loader with the plugin's template paths.
	 */
	public function __construct() {
		parent::__construct(
			self::HOOK_PREFIX,
			PLUGIN_SKELETON_D_PATH . self::TEMPLATE_DIR,
			self::TEMPLATE_THEME_DIR
		);
	}

	/**
	 * Retrieve or output a template part.
	 *
	 * Wrapper around the trait method to provide a static interface across the plugin.
	 *
	 * @see TemplateLoader::render() for details and usage.
	 *
	 * @param string               $slug The slug name for the generic template.
	 * @param string|null          $name The name of the specialized template.
	 * @param array<string, mixed> $args Optional. Arguments to pass to the template.
	 */
	public static function get_template_part( string $slug, ?string $name = null, array $args = [] ): void {
		Main::get_instance()->get_shared( self::class )->render( $slug, $name, $args );
	}
}
