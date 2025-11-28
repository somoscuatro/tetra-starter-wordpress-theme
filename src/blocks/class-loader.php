<?php
/**
 * Contains Somoscuatro\Starter_Theme\Blocks\Loader Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme\Blocks;

use DI\Attribute\Inject;
use Somoscuatro\Starter_Theme\Timber;

/**
 * Gutenberg Blocks loader.
 */
class Loader {

	/**
	 * The PHP DI Container.
	 *
	 * @var Timber
	 */
	#[Inject]
	private Timber $timber;

	/**
	 * Loads custom Gutenberg blocks.
	 */
	public function load(): void {
		foreach ( glob( __DIR__ . '/*' ) as $block_dir ) {
			if ( ! is_dir( $block_dir ) ) {
				continue;
			}

			$class = implode(
				'_',
				array_map(
					'ucwords',
					explode( '-', basename( $block_dir ) )
				)
			);

			$full_class_path = sprintf( __NAMESPACE__ . '\%s\%s', $class, $class );
			if ( method_exists( $full_class_path, 'init' ) ) {
				( new $full_class_path( $this->timber ) )->init();
			}
		}
	}
}
