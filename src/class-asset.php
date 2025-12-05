<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Asset Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

use DI\Attribute\Inject;
use Somoscuatro\Tetra_Starter_Theme\Attributes\Action;
use Somoscuatro\Tetra_Starter_Theme\Helpers\Filesystem;

/**
 * Assets Management Class.
 */
class Asset {

	use Filesystem;

	/**
	 * Vite Dev Server URL.
	 *
	 * @var string
	 */
	protected const VITE_DEV_SERVER_URL = 'https://localhost:5173';

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

		// We are disabling phpcs rule here because we are managing versions via Vite's cache busting.
		// @phpcs:disable WordPress.WP.EnqueuedResourceParameters.MissingVersion
		// @phpcs:disable WordPress.WP.EnqueuedResourceParameters.NoExplicitVersion

		// Custom Fonts.
		wp_enqueue_style( $theme_prefix . '-fonts-preload', $this->vite( 'assets/styles/fonts.css' ), false );

		// Theme Styles.
		wp_enqueue_style( $theme_prefix . '-main-styles', $this->vite( 'assets/styles/main.css' ), array( $theme_prefix . '-fonts-preload' ) );

		// Theme Script.
		wp_enqueue_script( $theme_prefix, $this->vite( 'assets/scripts/main.ts' ), array(), false, true );

		// @phpcs:enable
	}

		/**
		 * Get the Vite Processed File URL.
		 *
		 * @param string $file The File Path.
		 *
		 * @return string The File URL.
		 */
	private function vite( string $file ): string {
		if ( ! $this->is_vite_dev() ) {
			$manifest_path    = $this->get_base_path() . '/dist/.vite/manifest.json';
			$manifest_content = json_decode( $this->get_file_content( $manifest_path ), true );

			return $this->get_base_url() . '/dist/' . $manifest_content[ $file ]['file'];
		}

		if ( 'assets/styles/fonts.css' === $file ) {
			return $this->get_base_url() . '/assets/styles/fonts.css';
		}

		if ( str_ends_with( $file, '.css' ) ) {
			return self::VITE_DEV_SERVER_URL . ltrim( $file, '/' );
		}

		return self::VITE_DEV_SERVER_URL . ltrim( $file, '/' ) . '?import';
	}

	/**
	 * Checks if Vite Dev Server is Running.
	 */
	private function is_vite_dev(): bool {
		return ! is_wp_error(
			wp_remote_get( self::VITE_DEV_SERVER_URL, array( 'sslverify' => false ) )
		);
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
