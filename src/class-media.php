<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Media Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

use Somoscuatro\Tetra_Starter_Theme\Attributes\Action;
use Somoscuatro\Tetra_Starter_Theme\Attributes\Filter;

/**
 * Media Management Class.
 */
class Media {

	/**
	 * Allows SVG Images in Media Uploader.
	 *
	 * @param array $mimes The Supported Mime Types.
	 *
	 * @return array The Modified Mime Types.
	 */
	#[Filter( 'upload_mimes' )]
	public function add_svg_support( array $mimes ): array {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Disables WordPress Default Image Sizes.
	 *
	 * @param array $sizes The WordPress Image Sizes.
	 *
	 * @return array The Modified Sizes.
	 */
	#[Filter( 'intermediate_image_sizes' )]
	public function disable_wp_default_image_sizes( array $sizes ): array {
		$targets = array( 'thumbnail', 'medium', 'medium_large', 'large', '1536x1536', '2048x2048' );

		foreach ( $sizes as $size_index => $size ) {
			if ( in_array( $size, $targets, true ) ) {
				unset( $sizes[ $size_index ] );
			}
		}

		return $sizes;
	}

	/**
	 * Registers Custom Images Sizes.
	 */
	#[Action( 'init' )]
	public function register_image_sizes(): void {
		$sizes = array(
			'xs' => 60,
			'sm' => 240,
			'md' => 420,
			'lg' => 680,
			'xl' => 1024,
		);

		foreach ( $sizes as $key => $value ) {
			add_image_size( $key, $value );
			add_image_size( sprintf( '%s@2x', $key ), $key, $value * 2 );
			add_image_size( sprintf( '%s@3x', $key ), $key, $value * 3 );
		}
	}
}
