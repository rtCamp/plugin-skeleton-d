/**
 * External dependencies
 */
import { defineConfig, type PlaywrightTestConfig } from '@playwright/test';
import path from 'path';

const artifactsPath = path.join( process.cwd(), 'tests/_output/e2e' );

// Ensure WP artifacts (and storage-state) are written into tests/_output/e2e
process.env[ 'WP_ARTIFACTS_PATH' ] = artifactsPath;
// Ensure STORAGE_STATE_PATH points into tests/_output/e2e as well
process.env[ 'STORAGE_STATE_PATH' ] = path.join(
	artifactsPath,
	'storage-states',
	'admin.json'
);

const baseConfig =
	require( '@wordpress/scripts/config/playwright.config.js' ) as PlaywrightTestConfig; // eslint-disable-line @typescript-eslint/no-var-requires

const config = defineConfig( {
	...baseConfig,
	testDir: './tests/e2e',
	outputDir: './tests/_output/e2e',

	// Disable Playwright's automatic webServer orchestration to prevent port
	// conflicts, as the CI workflow/local scripts manually manage the wp-env lifecycle.
	webServer: undefined,
} );

export default config;
