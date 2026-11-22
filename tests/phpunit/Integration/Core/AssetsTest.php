<?php
/**
 * Integration tests for Assets.
 *
 * @package rtCamp\Plugin_Skeleton_D\Tests\Integration\Core
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Tests\Integration\Core;

use PHPUnit\Framework\Attributes\CoversClass;
use rtCamp\Plugin_Skeleton_D\Core\Assets;
use rtCamp\Plugin_Skeleton_D\Tests\TestCase;

/**
 * Class - AssetsTest
 */
#[CoversClass( \rtCamp\Plugin_Skeleton_D\Core\Assets::class )]
class AssetsTest extends TestCase {
	/**
	 * {@inheritDoc}
	 */
	protected function setUp(): void {
		parent::setUp();

		unset( $GLOBALS['wp_scripts'], $GLOBALS['wp_styles'] );
	}

	/**
	 * Ensure no errors are thrown when the Assets class is instantiated.
	 */
	public function test_assets_class_instantiation(): void {
		$assets = new Assets();
		$this->assertInstanceOf( Assets::class, $assets );

		$assets->register_hooks();
		$assets->register_assets();
		$assets->register_admin_assets();
		$assets->register_editor_assets();

		$this->setExpectedIncorrectUsage( 'WP_Block_Type_Registry::register' );
		$assets->register_blocks();

		// If we reach this point without any exceptions, the test passes.
		$this->assertTrue( true );
	}

	/**
	 * Tests the frontend and admin scripts are deferred.
	 */
	public function test_scripts_are_registered_with_defer_strategy(): void {
		$assets = new Assets();
		$assets->register_assets();
		$assets->register_admin_assets();

		foreach ( [ Assets::FRONTEND_HANDLE, Assets::ADMIN_HANDLE ] as $handle ) {
			$this->assertSame( 'defer', wp_scripts()->get_data( $handle, 'strategy' ), $handle );
		}
	}

	/**
	 * Tests every stylesheet is built and registered.
	 */
	public function test_styles_are_registered(): void {
		$assets = new Assets();
		$assets->register_assets();
		$assets->register_admin_assets();

		$styles = [
			Assets::FRONTEND_HANDLE      => 'frontend',
			Assets::ADMIN_HANDLE         => 'admin',
			Assets::GLOBAL_STYLES_HANDLE => 'global-styles',
		];

		foreach ( $styles as $handle => $filename ) {
			$this->assertFileExists( PLUGIN_SKELETON_D_PATH . "build/{$filename}.css" );
			$this->assertTrue( wp_style_is( $handle, 'registered' ), $handle );
		}
	}
}
