<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 *
 * The following variables are exposed to the file:
 * @param array<string,mixed> $attributes The block attributes.
 * @param string              $content    The block default content.
 * @param \WP_Block           $block      The block instance.
 *
 * @package rtCamp\Plugin_Skeleton_D
 */

declare(strict_types = 1);

// Generates a unique id for aria-controls.
$unique_id = wp_unique_id( 'p-' );

// Adds the global state.
wp_interactivity_state(
	'plugin-skeleton-d',
	[
		'isDark'    => false,
		'darkText'  => esc_html__( 'Switch to Light', 'plugin-skeleton-d' ),
		'lightText' => esc_html__( 'Switch to Dark', 'plugin-skeleton-d' ),
		'themeText' => esc_html__( 'Switch to Dark', 'plugin-skeleton-d' ),
	]
);
?>

<div
	<?php echo esc_attr( get_block_wrapper_attributes() ); ?>
	data-wp-interactive="plugin-skeleton-d"
	<?php echo wp_interactivity_data_wp_context( [ 'isOpen' => false ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	data-wp-watch="callbacks.logIsOpen"
	data-wp-class--dark-theme="state.isDark"
>
	<button
		data-wp-on--click="actions.toggleTheme"
		data-wp-text="state.themeText"
	></button>

	<button
		data-wp-on--click="actions.toggleOpen"
		data-wp-bind--aria-expanded="context.isOpen"
		aria-controls="<?php echo esc_attr( $unique_id ); ?>"
	>
		<?php esc_html_e( 'Toggle', 'plugin-skeleton-d' ); ?>
	</button>

	<p
		id="<?php echo esc_attr( $unique_id ); ?>"
		data-wp-bind--hidden="!context.isOpen"
	>
		<?php
			esc_html_e( 'Interactive Block Example - hello from an interactive block!', 'plugin-skeleton-d' );
		?>
	</p>
</div>
