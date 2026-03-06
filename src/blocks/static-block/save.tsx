/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {React.JSX.Element} Element to render.
 */
export default function save(): React.JSX.Element {
	return (
		<p { ...useBlockProps.save() }>
			Static Block Example – hello from the saved content!
		</p>
	);
}
