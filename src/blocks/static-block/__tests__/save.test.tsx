/**
 * External dependencies
 */
import { render, screen } from '@testing-library/react';

/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import save from '../save';

jest.mock( '../style.scss', () => ( {} ) );

const mockedUseBlockProps = useBlockProps as unknown as jest.Mock & {
	save: jest.Mock;
};

describe( 'Static Block save Component', () => {
	beforeEach( () => {
		jest.clearAllMocks();
	} );

	it( 'renders a paragraph element', () => {
		const { container } = render( save() );

		expect( container.querySelector( 'p' ) ).toBeInTheDocument();
	} );

	it( 'calls useBlockProps.save', () => {
		render( save() );

		expect( useBlockProps.save ).toHaveBeenCalledTimes( 1 );
	} );

	it( 'renders the saved content text', () => {
		render( save() );

		expect(
			screen.getByText(
				'Static Block Example – hello from the saved content!'
			)
		).toBeInTheDocument();
	} );

	it( 'spreads block props onto the paragraph element', () => {
		mockedUseBlockProps.save.mockReturnValueOnce( {
			className: 'wp-block custom-saved-class',
			'data-testid': 'saved-block',
		} );

		const { container } = render( save() );

		expect(
			container.querySelector( '.wp-block.custom-saved-class' )
		).toBeInTheDocument();
	} );
} );
