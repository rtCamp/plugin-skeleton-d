<?php
/**
 * Unit tests for Encryptor class.
 *
 * @package rtCamp\Plugin_Skeleton_D\Tests
 */

declare( strict_types = 1 );

namespace rtCamp\Plugin_Skeleton_D\Tests\Framework;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use rtCamp\Plugin_Skeleton_D\Framework\Encryptor;
use rtCamp\Plugin_Skeleton_D\Tests\TestCase;

/**
 * Class - EncryptorTest
 */
#[CoversClass( \rtCamp\Plugin_Skeleton_D\Framework\Encryptor::class )]
class EncryptorTest extends TestCase {
	/**
	 * Test that encrypting and then decrypting returns the original value.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_encrypt_and_decrypt(): void {
		$raw       = 'Sensitive data: ' . uniqid();
		$encrypted = Encryptor::encrypt( $raw );
		$this->assertIsString( $encrypted );
		$this->assertNotEquals( $raw, $encrypted, 'Encrypted value should differ from raw' );

		$decrypted = Encryptor::decrypt( $encrypted );
		$this->assertSame( $raw, $decrypted, 'Decrypted value should match original' );
	}

	/**
	 * Test that decrypting invalid base64 data returns false.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_decrypt_returns_false_on_invalid_base64(): void {
		$this->setExpectedIncorrectUsage( Encryptor::class . '::decrypt' );
		$invalid_base64 = '!!!not-valid-base64!!!';
		$this->assertFalse( Encryptor::decrypt( $invalid_base64 ) );
	}

	/**
	 * Test that GCM authentication fails when data is tampered.
	 *
	 * @param string $tamper_type Which component to tamper with.
	 */
	#[DataProvider( 'tamper_data_provider' )]
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_decrypt_returns_false_on_tampered_data( string $tamper_type ): void {
		$raw       = 'test data';
		$encrypted = Encryptor::encrypt( $raw );

		$decoded    = base64_decode( $encrypted, true );
		$iv_length  = 12; // GCM IV length.
		$tag_length = 16; // GCM tag length.

		$iv         = substr( $decoded, 0, $iv_length );
		$tag        = substr( $decoded, $iv_length, $tag_length );
		$ciphertext = substr( $decoded, $iv_length + $tag_length );

		// Apply tampering based on type.
		switch ( $tamper_type ) {
			case 'ciphertext':
				$ciphertext = $ciphertext ^ str_repeat( "\xff", strlen( $ciphertext ) );
				break;
			case 'iv':
				$iv = $iv ^ str_repeat( "\xaa", strlen( $iv ) );
				break;
			case 'tag':
				$tag = $tag ^ str_repeat( "\x01", strlen( $tag ) );
				break;
		}

		$tampered = base64_encode( $iv . $tag . $ciphertext );

		$this->assertFalse( Encryptor::decrypt( $tampered ) );
	}

	/**
	 * Data provider for tampering tests.
	 *
	 * @return array<array{string}>
	 */
	public static function tamper_data_provider(): array {
		return [
			'ciphertext' => [ 'ciphertext' ],
			'iv'         => [ 'iv' ],
			'tag'        => [ 'tag' ],
		];
	}

	/**
	 * Test that custom key is used for encryption and decryption.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_encrypt_and_decrypt_with_custom_key(): void {
		if ( ! defined( 'PLUGIN_SKELETON_D_ENCRYPTION_KEY' ) ) {
			define( 'PLUGIN_SKELETON_D_ENCRYPTION_KEY', 'custom-key-123' );
		}

		$raw       = 'custom key test';
		$encrypted = Encryptor::encrypt( $raw );
		$decrypted = Encryptor::decrypt( $encrypted );
		$this->assertSame( $raw, $decrypted );
	}

	/**
	 * Test encryption with LOGGED_IN_KEY fallback (no custom key defined).
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_encrypt_and_decrypt_with_logged_in_key_fallback(): void {
		if ( ! defined( 'LOGGED_IN_KEY' ) ) {
			define( 'LOGGED_IN_KEY', 'fallback-logged-in-key-789' );
		}

		$raw       = 'fallback key test';
		$encrypted = Encryptor::encrypt( $raw );
		$decrypted = Encryptor::decrypt( $encrypted );
		$this->assertSame( $raw, $decrypted );
	}

	/**
	 * Test encryption of unicode/multibyte string.
	 */
	#[RunInSeparateProcess]
	#[PreserveGlobalState( false )]
	public function test_encrypt_and_decrypt_unicode(): void {
		$raw       = '日本語テスト 🎉 émoji and àccënts';
		$encrypted = Encryptor::encrypt( $raw );
		$this->assertIsString( $encrypted );
		$decrypted = Encryptor::decrypt( $encrypted );
		$this->assertSame( $raw, $decrypted );
	}
}
