/** @type {import('stylelint').Config} */
export default {
	extends: '@wordpress/stylelint-config/scss',
	ignoreFiles: [
		'**/*.js',
		'**/*.json',
		'**/*.jsx',
		'**/*.php',
		'**/*.svg',
		'**/*.ts',
		'**/*.tsx',
	],
	rules: {},
};
