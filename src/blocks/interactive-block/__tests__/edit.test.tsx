/**
 * External dependencies
 */
import { render, screen } from '@testing-library/react';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import Edit from '../edit';

jest.mock( '../editor.scss', () => ( {} ) );

const mockedUseBlockProps = useBlockProps as unknown as jest.Mock;

describe( 'Interactive Block Edit Component', () => {
	beforeEach( () => {
		jest.clearAllMocks();
	} );

	it( 'renders the block with translated text', () => {
		render( <Edit /> );

		expect(
			screen.getByText(
				'Interactive Block Example – hello from the editor!'
			)
		).toBeInTheDocument();
	} );

	it( 'calls useBlockProps', () => {
		render( <Edit /> );

		expect( useBlockProps ).toHaveBeenCalledTimes( 1 );
	} );

	it( 'calls the translation function with correct text domain', () => {
		render( <Edit /> );

		expect( __ ).toHaveBeenCalledWith(
			'Interactive Block Example – hello from the editor!',
			'plugin-skeleton-d'
		);
	} );

	it( 'renders a paragraph element', () => {
		const { container } = render( <Edit /> );

		expect( container.querySelector( 'p' ) ).toBeInTheDocument();
	} );

	it( 'spreads block props onto the paragraph element', () => {
		mockedUseBlockProps.mockReturnValueOnce( {
			className: 'wp-block custom-class',
			'data-testid': 'test-block',
		} );

		const { container } = render( <Edit /> );

		expect(
			container.querySelector( '.wp-block.custom-class' )
		).toBeInTheDocument();
	} );
} );
