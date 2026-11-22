<?php
/**
 * Example Module.
 *
 * Initializes all classes for the Example module.
 *
 * @package rtCamp\Plugin_Skeleton_D\Modules
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Modules;

use rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\Contracts\Abstracts\AbstractModule;

/**
 * Class - Example
 */
final class Example extends AbstractModule {
	/**
	 * {@inheritDoc}
	 */
	protected function get_classes(): array {
		return [
			Example\Example_Post_Type::class,
			Example\Example_Taxonomy::class,
			Example\Example_Post_Type_Meta::class,
			Example\Example_REST_Controller::class,
		];
	}
}
