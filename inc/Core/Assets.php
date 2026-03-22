<?php
/**
 * Enqueue plugin assets, like styles, scripts, and blocks.
 *
 * @package rtCamp\Plugin_Skeleton_D\Core
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Core;

use rtCamp\Plugin_Skeleton_D\Framework\AssetLoaderTrait;
use rtCamp\Plugin_Skeleton_D\Framework\Contracts\Interfaces\Registrable;

/**
 * Class Assets
 */
final class Assets implements Registrable {
	use AssetLoaderTrait;

	/**
	 * Prefix for all asset handles.
	 */
	private const PREFIX = 'plugin-skeleton-d-';

	/**
	 * Asset handles
	 */
	public const ADMIN_HANDLE         = self::PREFIX . 'admin';
	public const EDITOR_HANDLE        = self::PREFIX . 'editor';
	public const FRONTEND_HANDLE      = self::PREFIX . 'frontend';
	public const GLOBAL_STYLES_HANDLE = self::PREFIX . 'global-styles';

	/**
	 * Assets to defer for better performance.
	 */
	private const DEFERRED_ASSETS = [
		self::FRONTEND_HANDLE,
		self::EDITOR_HANDLE,
		self::ADMIN_HANDLE,
		// Add other handles as needed.
	];

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->plugin_dir = (string) PLUGIN_SKELETON_D_PATH;
		$this->plugin_url = (string) PLUGIN_SKELETON_D_URL;
		$this->assets_dir = 'build';
	}

	/**
	 * {@inheritDoc}
	 */
	public function register_hooks(): void {
		add_action( 'init', [ $this, 'register_blocks' ] );

		add_action( 'enqueue_scripts', [ $this, 'register_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_assets' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'register_editor_assets' ] );

		// Add defer attribute to certain plugin bundles to improve admin load performance.
		add_filter( 'script_loader_tag', [ $this, 'defer_scripts' ], 10, 2 );
	}

	/**
	 * Register assets for frontend.
	 *
	 * Assets are registered once centrally, and enqueued in the modules that need them.
	 */
	public function register_assets(): void {
		// Example: register a frontend script and style.
		$this->register_script( self::FRONTEND_HANDLE, 'frontend' );
		$this->register_style( self::FRONTEND_HANDLE, 'frontend' );

		$this->register_style( self::GLOBAL_STYLES_HANDLE, 'global-styles' );
	}

	/**
	 * Register assets for admin.
	 *
	 * Assets are registered once centrally, and enqueued in the modules that need them.
	 */
	public function register_admin_assets(): void {
		// Register admin script and style.
		$this->register_script( self::ADMIN_HANDLE, 'admin' );
		$this->register_style( self::ADMIN_HANDLE, 'admin' );
	}

	/**
	 * Register assets for editor.
	 *
	 * Assets are registered once centrally, and enqueued in the modules that need them.
	 */
	public function register_editor_assets(): void {
		// Register editor script and style.
		$this->register_script( self::EDITOR_HANDLE, 'editor' );
		$this->register_style( self::EDITOR_HANDLE, 'editor' );
	}

	/**
	 * Register block assets.
	 */
	public function register_blocks(): void {
		$this->register_block_manifest( $this->assets_dir . '/blocks', $this->assets_dir . '/blocks-manifest.php' );
	}

	/**
	 * Add defer attribute to certain plugin bundle scripts to improve loading performance.
	 *
	 * @param string $tag    The script tag.
	 * @param string $handle The script handle.
	 *
	 * @return string Modified script tag.
	 */
	public function defer_scripts( string $tag, string $handle ): string {
		// Bail if we don't need to defer.
		if ( ! in_array( $handle, self::DEFERRED_ASSETS, true ) || false !== strpos( $tag, ' defer' ) ) {
			return $tag;
		}

		return str_replace( ' src', ' defer src', $tag );
	}
}
