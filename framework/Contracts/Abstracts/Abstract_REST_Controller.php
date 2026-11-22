<?php
/**
 * Abstract REST controller class.
 *
 * Class to be extended by all REST controllers in the plugin. It keeps the plugin's route namespace on top of wp-primitives' AbstractRESTController.
 *
 * @package rtCamp\Plugin_Skeleton_D\Framework\Contracts\Abstracts
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Framework\Contracts\Abstracts;

use rtCamp\Plugin_Skeleton_D\Vendor\rtCamp\WPPrimitives\Contracts\Abstracts\AbstractRESTController;

/**
 * Class - Abstract_REST_Controller
 */
abstract class Abstract_REST_Controller extends AbstractRESTController {
	/**
	 * Route namespace for the REST API routes.
	 *
	 * Usually at /wp-json/{namespace}/{route}
	 *
	 * @var non-falsy-string
	 */
	protected $namespace = 'plugin-skeleton-d/v';
}
