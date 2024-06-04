<?php
/**
 * Contains Somoscuatro\Starter_Theme\CLI\CLI Class.
 *
 * @package sc-starter-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme\CLI;

use DI\Attribute\Inject;
use DI\Container;

/**
 * CLI Management Class.
 */
class CLI {

	/**
	 * The PHP DI Container.
	 *
	 * @var Container
	 */
	#[Inject]
	private Container $container;

	/**
	 * Registers CLI Commands.
	 */
	public function register_commands(): void {
		foreach ( glob( __DIR__ . '/commands/*.php' ) as $command_file ) {
			if ( ! is_file( $command_file ) ) {
				continue;
			}

			$command_name = str_replace( 'class-', '', basename( $command_file, '.php' ) );

			$class = implode(
				'_',
				array_map(
					'ucwords',
					explode( '-', $command_name )
				)
			);

			$full_class_path = sprintf( __NAMESPACE__ . '\Commands\%s', $class );

			// phpcs:ignore Generic.Commenting.DocComment.MissingShort
			/** @disregard P1011 */
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				\WP_CLI::add_command( $command_name, $this->container->get( $full_class_path ) );
			}
		}
	}
}
