/**
 * External dependencies
 */
import {
	isFeaturePluginBuild,
	registerExperimentalBlockType,
} from '@woocommerce/block-settings';
import { BlockConfiguration } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import sharedConfig from './../shared/config';
import attributes from './attributes';
import edit from './edit';
import {
	BLOCK_TITLE as title,
	BLOCK_ICON as icon,
	BLOCK_DESCRIPTION as description,
} from './constants';
import { Save } from './save';

const blockConfig: BlockConfiguration = {
	...sharedConfig,
	apiVersion: 2,
	title,
	description,
	icon: { src: icon },
	attributes,
	supports: {
		...( isFeaturePluginBuild() && {
			color: {
				text: true,
				link: true,
				background: false,
			},
		} ),
		typography: {
			fontSize: true,
		},
	},
	save: Save,
	edit,
};

registerExperimentalBlockType(
	'woocommerce/product-category-list',
	blockConfig
);
