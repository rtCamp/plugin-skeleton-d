<?php
/**
 * Unit tests for Main.
 *
 * @package rtCamp\Plugin_Skeleton_D\Tests
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use rtCamp\Plugin_Skeleton_D\Main;
use rtCamp\Plugin_Skeleton_D\Tests\TestCase;

/**
 * Class - MainTest
 */
#[CoversClass( \rtCamp\Plugin_Skeleton_D\Main::class )]
class MainTest extends TestCase {
	/**
	 * Reset the Main singleton instance.
	 */
	private function reset_main_instance(): void {
		$ref  = new \ReflectionClass( Main::class );
		$prop = $ref->getProperty( 'instance' );
		$prop->setAccessible( true );
		$prop->setValue( null, null );
	}

	/**
	 * Clean up after each test.
	 */
	protected function tearDown(): void {
		remove_all_actions( 'init' );
		remove_all_actions( 'admin_enqueue_scripts' );
		remove_all_filters( 'script_loader_tag' );
		delete_option( 'plugin_skeleton_d_version' );

		parent::tearDown();
	}

	/**
	 * Test that get_instance returns the same singleton instance.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_get_instance_returns_singleton(): void {
		$this->reset_main_instance();
		$a = Main::get_instance();
		$b = Main::get_instance();
		$this->assertSame( $a, $b );
	}

	/**
	 * Test that activate() sets the version option.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_activate_sets_version_option(): void {
		$this->reset_main_instance();

		Main::activate();

		$this->assertEquals( PLUGIN_SKELETON_D_VERSION, get_option( 'plugin_skeleton_d_version' ) );
	}

	/**
	 * Test that deactivate() runs without errors.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_deactivate_runs_without_errors(): void {
		$this->reset_main_instance();

		Main::deactivate();

		// Deactivate is currently a no-op, just verify it doesn't throw.
		$this->assertTrue( true );
	}

	/**
	 * Test that setup() registers activation and deactivation hooks.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_setup_registers_activation_deactivation_hooks(): void {
		$this->reset_main_instance();

		Main::get_instance();

		$this->assertNotFalse( has_action( 'activate_' . plugin_basename( PLUGIN_SKELETON_D_FILE ) ) );
		$this->assertNotFalse( has_action( 'deactivate_' . plugin_basename( PLUGIN_SKELETON_D_FILE ) ) );
	}
}
