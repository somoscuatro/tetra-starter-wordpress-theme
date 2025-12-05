<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Translation Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

use Somoscuatro\Tetra_Starter_Theme\Attributes\Action;
use Somoscuatro\Tetra_Starter_Theme\Helpers\Filesystem;

/**
 * Translations Management Class.
 */
class Translation {

	use Filesystem;

	/**
	 * Loads the Theme Translation Domain.
	 */
	#[Action( 'after_setup_theme' )]
	public function load_text_domain(): void {
		load_theme_textdomain( 'tetra-starter-wordpress-theme', $this->get_base_path() . '/languages' );
	}
}
