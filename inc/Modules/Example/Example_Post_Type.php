<?php
/**
 * Example Post Type.
 *
 * @package rtCamp\Plugin_Skeleton_D\Modules\Example
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Modules\Example;

use rtCamp\Plugin_Skeleton_D\Framework\Contracts\Abstracts\Abstract_Post_Type;

/**
 * Class - Example_Post_Type
 */
final class Example_Post_Type extends Abstract_Post_Type {
	/**
	 * {@inheritDoc}
	 */
	public static function get_slug(): string {
		return 'example';
	}

	/**
	 * {@inheritDoc}
	 */
	public function register_post_type(): void {
		register_post_type( // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral -- Defined above.
			self::get_slug(),
			array_merge(
				$this->default_args(),
				[
					'label'      => __( 'Examples', 'plugin-skeleton-d' ),
					'labels'     => [
						'name'               => __( 'Examples', 'plugin-skeleton-d' ),
						'singular_name'      => __( 'Example', 'plugin-skeleton-d' ),
						'add_new'            => __( 'Add New Example', 'plugin-skeleton-d' ),
						'add_new_item'       => __( 'Add New Example', 'plugin-skeleton-d' ),
						'edit_item'          => __( 'Edit Example', 'plugin-skeleton-d' ),
						'new_item'           => __( 'New Example', 'plugin-skeleton-d' ),
						'view_item'          => __( 'View Example', 'plugin-skeleton-d' ),
						'search_items'       => __( 'Search Examples', 'plugin-skeleton-d' ),
						'not_found'          => __( 'No examples found.', 'plugin-skeleton-d' ),
						'not_found_in_trash' => __( 'No examples found in Trash.', 'plugin-skeleton-d' ),
					],
					'supports'   => array_merge( $this->default_args()['supports'], [ 'custom-fields' ] ),
					'taxonomies' => [ Example_Taxonomy::get_slug() ],
				]
			)
		);
	}
}
