<?php
/**
 * Example Taxonomy.
 *
 * @package rtCamp\Plugin_Skeleton_D\Modules\Example
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Modules\Example;

use rtCamp\Plugin_Skeleton_D\Framework\Contracts\Abstracts\Abstract_Taxonomy;

/**
 * Class - Example_Taxonomy
 */
final class Example_Taxonomy extends Abstract_Taxonomy {
	/**
	 * {@inheritDoc}
	 */
	public static function get_slug(): string {
		return 'example-tax';
	}

	/**
	 * {@inheritDoc}
	 */
	public static function get_object_types(): array {
		return [ Example_Post_Type::get_slug() ];
	}

	/**
	 * {@inheritDoc}
	 */
	public function register_taxonomy(): void {
		register_taxonomy(
			self::get_slug(),
			self::get_object_types(),
			array_merge(
				$this->default_args(),
				[
					'hierarchical' => true,
					'label'        => __( 'Example Categories', 'plugin-skeleton-d' ),
					'labels'       => [
						'name'              => __( 'Example Categories', 'plugin-skeleton-d' ),
						'singular_name'     => __( 'Example Category', 'plugin-skeleton-d' ),
						'search_items'      => __( 'Search Example Categories', 'plugin-skeleton-d' ),
						'all_items'         => __( 'All Example Categories', 'plugin-skeleton-d' ),
						'parent_item'       => __( 'Parent Example Category', 'plugin-skeleton-d' ),
						'parent_item_colon' => __( 'Parent Example Category:', 'plugin-skeleton-d' ),
						'edit_item'         => __( 'Edit Example Category', 'plugin-skeleton-d' ),
						'update_item'       => __( 'Update Example Category', 'plugin-skeleton-d' ),
						'add_new_item'      => __( 'Add New Example Category', 'plugin-skeleton-d' ),
						'new_item_name'     => __( 'New Example Category Name', 'plugin-skeleton-d' ),
						'menu_name'         => __( 'Example Categories', 'plugin-skeleton-d' ),
					],
				]
			)
		);
	}
}
