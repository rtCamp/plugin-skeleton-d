/**
 * External dependencies
 */
import '@testing-library/jest-dom';

const mockUseBlockProps: jest.Mock & { save: jest.Mock } = Object.assign(
	jest.fn( ( props = {} ) => ( {
		className: 'wp-block',
		...props,
	} ) ),
	{
		save: jest.fn( ( props = {} ) => ( {
			className: 'wp-block',
			...props,
		} ) ),
	}
);

jest.mock( '@wordpress/block-editor', () => ( {
	useBlockProps: mockUseBlockProps,
} ) );

// Mocking `@wordpress/components` is unnecessary for current tests.
jest.mock( '@wordpress/components', () => ( {} ) );

// No `@wordpress/data` helpers are required by the tests at the moment.
jest.mock( '@wordpress/data', () => ( {} ) );

jest.mock( '@wordpress/i18n', () => ( {
	__: jest.fn( ( text: string ) => text ),
} ) );

jest.mock( '@wordpress/element', () => {
	return jest.requireActual( 'react' );
} );

jest.mock( '@wordpress/blocks', () => ( {
	registerBlockType: jest.fn(),
	unregisterBlockType: jest.fn(),
	getBlockType: jest.fn(),
	getBlockTypes: jest.fn( () => [] ),
	createBlock: jest.fn( ( name, attributes = {} ) => ( {
		name,
		attributes,
		clientId: 'test-client-id',
		innerBlocks: [],
		isValid: true,
		validationIssues: [],
	} ) ),
} ) );

jest.mock( '@wordpress/dom-ready', () => ( {
	__esModule: true,
	default: jest.fn( ( callback: () => void ) => {
		if ( typeof callback === 'function' ) {
			callback();
		}
	} ),
} ) );

beforeEach( () => {
	jest.clearAllMocks();
} );
