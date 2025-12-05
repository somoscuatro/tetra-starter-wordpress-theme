<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Helpers\Filesystem Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme\Helpers;

/**
 * Filesystem Helpers Class.
 */
trait Filesystem {

	/**
	 * Base for asset URLs.
	 *
	 * @var string
	 */
	protected static string $base_url = '';

	/**
	 * Returns the Base URL of This Theme.
	 *
	 * @return string Return Theme URI.
	 */
	protected function get_base_url(): string {
		if ( ! self::$base_url ) {
			self::$base_url = get_stylesheet_directory_uri();
		}
		return self::$base_url;
	}

	/**
	 * The Absolute Filesystem Base Path of This Theme.
	 *
	 * @return string Return Base Path Uri.
	 */
	protected function get_base_path(): string {
		return dirname( __DIR__, 2 );
	}

	/**
	 * Returns File Last Modified Time.
	 *
	 * @param string $file_path The File Path Relative to Dist Folder.
	 *
	 * @return int File Last Modified Time.
	 */
	protected function get_filemtime( string $file_path = '' ): int {
		$version = $file_path
			? filemtime( $this->get_base_path() . '/dist/' . trim( $file_path, '/' ) )
			: filemtime( $this->get_base_path() . '/dist/' );

		return (int) $version;
	}

	/**
	 * Returns the Content of a File.
	 *
	 * @param string $file_path The File Path.
	 *
	 * @return string File Content.
	 */
	protected function get_file_content( string $file_path = '' ): string {
		global $wp_filesystem;

		if ( ! $file_path ) {
			return '';
		}

		if ( ! $wp_filesystem ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		return $wp_filesystem->get_contents( $file_path );
	}
}
