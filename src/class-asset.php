<?php
/**
 * Contains Somoscuatro\Starter_Theme\Asset Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme;

use DI\Attribute\Inject;
use Somoscuatro\Starter_Theme\Attributes\Action;
use Somoscuatro\Starter_Theme\Helpers\Filesystem;

/**
 * Assets Management Class.
 */
class Asset {

	use Filesystem;

	/**
	 * The Theme Class.
	 *
	 * @var Theme
	 */
	#[Inject]
	protected Theme $theme;

	/**
	 * Enqueues Frontend Theme Styles and Scripts.
	 */
	#[Action( 'wp_enqueue_scripts' )]
	public function enqueue_assets(): void {
		$theme_prefix = $this->theme->get_prefix();

		// Custom Fonts.
		wp_enqueue_style( $theme_prefix . '-fonts-preload', $this->get_base_url() . '/dist/styles/fonts.css', false, $this->get_filemtime( 'styles/fonts.css' ) );

		// Theme Styles.
		wp_enqueue_style( $theme_prefix . '-main-styles', $this->get_base_url() . '/dist/styles/main.css', array( $theme_prefix . '-fonts-preload' ), $this->get_filemtime( 'styles/main.css' ) );

		// Theme Script.
		wp_enqueue_script( $theme_prefix, $this->get_base_url() . '/dist/scripts/main.js', array(), $this->get_filemtime( 'scripts/main.js' ), true );
	}

	/**
	 * Enqueues Editor Theme Styles and Scripts.
	 */
	#[Action( 'admin_enqueue_scripts' )]
	public function enqueue_admin_assets(): void {
	}

	/**
	 * Enqueues wp-login Theme Styles and Scripts.
	 */
	#[Action( 'login_enqueue_scripts' )]
	public function enqueue_login_assets(): void {
	}
}
