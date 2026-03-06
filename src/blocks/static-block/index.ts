/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */

/**
 * WordPress dependencies
 */
import { registerBlockType, type BlockConfiguration } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';

/**
 * Lets webpack process the CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing the `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor. All other files
 * get applied to the editor only.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata as BlockConfiguration, {
	/**
	 * @see ./edit.tsx
	 */
	edit: Edit,

	/**
	 * @see ./save.tsx
	 */
	save,
} );
