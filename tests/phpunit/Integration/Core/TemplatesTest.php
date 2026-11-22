<?php
/**
 * Integration tests for Templates class.
 *
 * @package rtCamp\Plugin_Skeleton_D\Tests\Integration\Core
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Tests\Integration\Core;

use PHPUnit\Framework\Attributes\CoversClass;
use rtCamp\Plugin_Skeleton_D\Core\Templates;
use rtCamp\Plugin_Skeleton_D\Main;
use rtCamp\Plugin_Skeleton_D\Tests\TestCase;

/**
 * Class - TemplatesTest
 */
#[CoversClass( \rtCamp\Plugin_Skeleton_D\Core\Templates::class )]
class TemplatesTest extends TestCase {
	/**
	 * Clean up after each test.
	 */
	protected function tearDown(): void {
		Main::get_instance()->get_shared( Templates::class )->clear_cache();
		remove_all_filters( 'plugin_skeleton_d/template_args' );
		remove_all_filters( 'plugin_skeleton_d/located_template' );
		remove_all_filters( 'plugin_skeleton_d/template_paths' );
		remove_all_actions( 'plugin_skeleton_d/get_template_part_test' );

		parent::tearDown();
	}

	/**
	 * Test that get_template_part outputs nothing for a missing template.
	 */
	public function test_get_template_part_outputs_nothing_when_missing(): void {
		ob_start();
		Templates::get_template_part( 'nonexistent' );

		$this->assertSame( '', ob_get_clean() );
	}

	/**
	 * Test that the plugin's templates directory is searched.
	 */
	public function test_locates_plugin_templates(): void {
		$this->assertSame(
			PLUGIN_SKELETON_D_PATH . 'templates/admin-screen.php',
			Main::get_instance()->get_shared( Templates::class )->locate( 'admin-screen' )
		);
	}

	/**
	 * Test that static get_template_part passes correct arguments.
	 */
	public function test_static_get_template_part_passes_correct_arguments(): void {
		$captured = [];
		add_action(
			'plugin_skeleton_d/get_template_part_test',
			static function ( string $slug, ?string $name, array $args ) use ( &$captured ): void {
				$captured = [
					'slug' => $slug,
					'name' => $name,
					'args' => $args,
				];
			},
			10,
			3
		);

		Templates::get_template_part( 'test', 'variant', [ 'key' => 'value' ] );

		$this->assertSame( 'test', $captured['slug'] );
		$this->assertSame( 'variant', $captured['name'] );
		$this->assertSame( [ 'key' => 'value' ], $captured['args'] );
	}

	/**
	 * Test that get_template_part outputs content correctly.
	 */
	public function test_get_template_part_outputs_content(): void {
		// Create a temporary template file.
		$temp_dir = sys_get_temp_dir() . '/test-templates-' . uniqid();
		mkdir( $temp_dir );
		$template_path = $temp_dir . '/test-template.php';

		file_put_contents( $template_path, '<?php echo $args["message"];' );

		// Add filter to locate our temp template.
		add_filter(
			'plugin_skeleton_d/located_template',
			static function ( $located, $templates ) use ( $template_path ) {
				if ( in_array( 'test-template.php', $templates, true ) ) {
					return $template_path;
				}
				return $located;
			},
			10,
			2
		);

		// Capture the output.
		ob_start();
		Templates::get_template_part( 'test-template', null, [ 'message' => 'Hello, World!' ] );

		$this->assertSame( 'Hello, World!', ob_get_clean() );

		// Try again with new args.
		ob_start();
		Templates::get_template_part( 'test-template', null, [ 'message' => 'Goodbye, World!' ] );
		$this->assertSame( 'Goodbye, World!', ob_get_clean() );

		// Clean up temp file.
		unlink( $template_path );
		rmdir( $temp_dir );
	}
}
