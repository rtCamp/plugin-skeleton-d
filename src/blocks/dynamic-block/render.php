<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 * @package rtCamp\Plugin_Skeleton_D
 *
 * The following variables are exposed to the file:
 * @var array<string,mixed> $attributes The block attributes.
 * @var string              $content    The block default content.
 * @var \WP_Block           $block      The block instance.
 */

declare( strict_types = 1 );

?>

<p <?php echo esc_attr( get_block_wrapper_attributes() ); ?>>
	<?php esc_html_e( 'Dynamic Block Example – hello from a dynamic block!', 'plugin-skeleton-d' ); ?>
</p>
