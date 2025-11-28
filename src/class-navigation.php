<?php
/**
 * Contains Somoscuatro\Starter_Theme\Navigation Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme;

use Somoscuatro\Starter_Theme\Attributes\Action;

/**
 * WordPress Custom Navigation Functionality.
 */
class Navigation {

	/**
	 * Register Navigation Menus.
	 */
	#[Action( 'after_setup_theme' )]
	public function register_nav_menus() {
		register_nav_menu( 'site_header_primary', __( 'Site Header Primary', 'tetra-starter-wordpress-theme' ) );
		register_nav_menu( 'site_footer_primary', __( 'Site Footer Primary', 'tetra-starter-wordpress-theme' ) );
		register_nav_menu( 'site_footer_legals', __( 'Site Footer Legals', 'tetra-starter-wordpress-theme' ) );
	}
}
