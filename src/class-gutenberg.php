<?php
/**
 * Contains Somoscuatro\Starter_Theme\Gutenberg Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme;

use Somoscuatro\Starter_Theme\Attributes\Action;
use Somoscuatro\Starter_Theme\Attributes\Filter;

use WP_Block_Editor_Context;

/**
 * Gutenberg Customization.
 */
class Gutenberg {

	/**
	 * Registers Gutenberg Custom Category.
	 *
	 * @param array[] $block_categories Array of Categories for Block Types.
	 */
	#[Filter( 'block_categories_all' )]
	public function add_custom_block_category( array $block_categories ): array {
		return array_merge(
			$block_categories,
			array(
				array(
					'slug'  => 'somoscuatro',
					'title' => esc_html__( 'Somoscuatro Custom Blocks', 'tetra-starter-wordpress-theme' ),
				),
			)
		);
	}

	/**
	 * Removes Unwanted Default WordPress Gutenberg Block Types.
	 *
	 * @return array The Modified Allowed Block Types.
	 */
	#[Filter( 'allowed_block_types_all', accepted_args: 0 )]
	public function allowed_block_types(): array {
		$block_types = \WP_Block_Type_Registry::get_instance()->get_all_registered();

		// To disable the default WordPress Gutenberg blocks, include their names in
		// the array below.
		$blocks_to_remove = array(
			// phpcs:ignore Squiz.PHP.CommentedOutCode.Found
			// 'core/archives' => null,
		);

		return array_keys( array_diff_key( $block_types, $blocks_to_remove ) );
	}

	/**
	 * Removes Default Gutenberg Blocks Assets.
	 *
	 * Because we are using Tailwind CSS to style blocks (including default
	 * WordPress blocks), we need to remove the default WordPress assets for
	 * blocks.
	 */
	#[Action( 'wp_enqueue_scripts' )]
	public function remove_default_blocks_assets(): void {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_script( 'wp-block-library' );
	}
}
