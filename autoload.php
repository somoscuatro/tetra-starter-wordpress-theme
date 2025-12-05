<?php
/**
 * Setup PHP Class Autoload.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

// Autoload Composer's Dependencies.
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Registers Theme Autoloader.
 *
 * @see https://www.php-fig.org/psr/psr-4/
 *
 * @param string $class The Class Name.
 */
spl_autoload_register(
	function ( $class_name ) {
		// Only Autoload Classes from This Namespace.
		if ( ! str_contains( $class_name, __NAMESPACE__ ) ) {
			return;
		}

		// Remove Namespace from Class Name.
		$class_file = str_replace( __NAMESPACE__ . '\\', '', $class_name );

		// Convert Class Name Format to File Name Format.
		$class_file = strtolower( $class_file );
		$class_file = str_replace( '_', '-', $class_file );

		// Convert Sub-Namespaces into Directories.
		$class_path = explode( '\\', $class_file );
		$class_file = array_pop( $class_path );
		$class_path = implode( '/', $class_path );

		$file = realpath( __DIR__ . '/src' . ( $class_path ? "/$class_path" : '' ) . '/class-' . $class_file . '.php' );

		// If the File Exists, Require It.
		if ( file_exists( $file ) ) {
			require_once $file;
		} else {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( sprintf( 'File not found: %s', $file ) );
		}
	}
);
