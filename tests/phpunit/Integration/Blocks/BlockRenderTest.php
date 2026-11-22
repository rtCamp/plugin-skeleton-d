<?php
/**
 * Integration tests for the server-rendered example blocks.
 *
 * @package rtCamp\Plugin_Skeleton_D\Tests\Integration\Blocks
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Tests\Integration\Blocks;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use WP_HTML_Tag_Processor;
use rtCamp\Plugin_Skeleton_D\Tests\TestCase;

/**
 * Class - BlockRenderTest
 */
#[CoversNothing]
class BlockRenderTest extends TestCase {
	/**
	 * The wrapper attributes must reach the markup as real attributes, not escaped text.
	 *
	 * @param string $block_name  The block to render.
	 * @param string $wrapper_tag The block's wrapper element.
	 * @param string $block_class The class core generates for the block.
	 */
	#[DataProvider( 'dynamic_blocks' )]
	public function test_wrapper_attributes_are_rendered( string $block_name, string $wrapper_tag, string $block_class ): void {
		$html = render_block(
			[
				'blockName'    => $block_name,
				'attrs'        => [ 'className' => 'custom-class' ],
				'innerBlocks'  => [],
				'innerHTML'    => '',
				'innerContent' => [],
			]
		);

		$this->assertStringNotContainsString( '&quot;', $html );

		$processor = new WP_HTML_Tag_Processor( $html );

		$this->assertTrue( $processor->next_tag( $wrapper_tag ) );
		$this->assertTrue( $processor->has_class( $block_class ) );
		$this->assertTrue( $processor->has_class( 'custom-class' ) );
	}

	/**
	 * The blocks that render through a `render.php` file.
	 *
	 * @return array<string, array{string, string, string}>
	 */
	public static function dynamic_blocks(): array {
		return [
			'dynamic block'     => [ 'plugin-skeleton-d/dynamic-block', 'p', 'wp-block-plugin-skeleton-d-dynamic-block' ],
			'interactive block' => [ 'plugin-skeleton-d/interactive-block', 'div', 'wp-block-plugin-skeleton-d-interactive-block' ],
		];
	}
}
