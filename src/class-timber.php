<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Timber Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

use Sabberworm\CSS\Parsing\SourceException;
use Somoscuatro\Tetra_Starter_Theme\ACF;
use Somoscuatro\Tetra_Starter_Theme\Attributes\Action;
use Somoscuatro\Tetra_Starter_Theme\Attributes\Filter;

use Symfony\Component\VarDumper\VarDumper;
use Timber\Timber as TimberLibrary;
use Twig\TwigFunction;
use Twig\Environment as TwigEnvironment;

/**
 * Timber Management Class.
 */
class Timber {

	/**
	 * The ACF Class.
	 *
	 * @var ACF
	 */
	private $acf;

	/**
	 * Class Constructor.
	 *
	 * @param ACF $acf The ACF Class.
	 */
	public function __construct( ACF $acf ) {
		$this->acf = $acf;
	}

	/**
	 * Timber Initialization.
	 *
	 * @throws \Exception If Timber Class Does Not Exist.
	 */
	#[Action( 'after_setup_theme', 9 )]
	public function init(): void {
		TimberLibrary::init();

		if ( ! class_exists( 'Timber' ) ) {
			throw new \Exception( 'Timber not found.' );
		}

		TimberLibrary::$dirname = array(
			'templates',
			'templates/components',
			'templates/parts',
		);
	}

	/**
	 * Adds Additional Variables to Global Context.
	 *
	 * @param array $context Timber Context.
	 *
	 * @return array Global Context Data.
	 */
	#[Filter( 'timber/context' )]
	public function add_to_global_context( array $context ): array {
		$context['homepage_url'] = get_home_url();

		$context = $this->get_menus( $context );

		$context['wp_footer_exists'] = function_exists( 'wp_footer' );

		$context['copyright_text'] = sprintf(
			'&copy;%s %s %s',
			gmdate( 'Y' ),
			__( 'Starter Theme by', 'tetra-starter-wordpress-theme' ),
			'<a class="underline" href="https://somoscuatro.es">somoscuatro</a>'
		);

		return $context;
	}

	/**
	 * Returns Timber Context.
	 *
	 * @return array
	 */
	public function context(): array {
		return TimberLibrary::context();
	}

	/**
	 * Renders a Given Template.
	 *
	 * @param string $template Template Path.
	 * @param array  $context  Context Data.
	 */
	public function render(
		string $template,
		array $context = array(),
	): void {
		TimberLibrary::render( $template, $context );
	}

	/**
	 * Adds Registered Menus to Timber Global Context.
	 *
	 * As documented in
	 * https://timber.github.io/docs/v2/guides/menus/#set-up-all-menus-globally
	 * Timber allows to add the registered menu to the global context. For unknown
	 * reasons, this is not fully working for us since the current menu item is
	 * not set (always false) and WordPress current item classes (e.g.
	 * current-menu-item) are not added.
	 *
	 * @param array $context The Timber Global Context.
	 *
	 * @return array The Updated Timber Global Context.
	 */
	public function get_menus( array $context ): array {
		foreach ( array_keys( get_registered_nav_menus() ) as $location ) {
			if ( ! has_nav_menu( $location ) ) {
				continue;
			}

			$context[ $location ] = TimberLibrary::get_menu( $location );
		}

		return $context;
	}

	/**
	 * Adds Custom Functions to Twig.
	 *
	 * @param TwigEnvironment $twig The Twig Environment.
	 *
	 * @return TwigEnvironment The Modified Twig Environment.
	 */
	#[Filter( 'timber/twig' )]
	public function extend_timber_functions( TwigEnvironment $twig ): TwigEnvironment {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			$twig->addFunction(
				new TwigFunction( 'dump', array( $this, 'dump' ) )
			);

			$twig->addFunction(
				new TwigFunction( 'dd', array( $this, 'dd' ) )
			);
		}

		$twig->addFunction(
			new TwigFunction( 'enqueue_script', array( $this, 'enqueue_script' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_static_asset', array( $this, 'get_static_asset' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_image_srcset', array( $this, 'get_image_srcset' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_color_name', array( $this, 'get_color_name' ) )
		);

		$twig->addFunction(
			new TwigFunction( 'get_foreground_color_name', array( $this, 'get_foreground_color_name' ) )
		);

		return $twig;
	}

	/**
	 * Dumps a list of variables.
	 *
	 * @param mixed ...$vars Variables to dump.
	 */
	public function dump( mixed ...$vars ): void {
		foreach ( $vars as $var ) {
			VarDumper::dump( $var );
		}
	}

	/**
	 * Dumps a list of variables and dies.
	 *
	 * @param mixed ...$vars Variables to dump.
	 */
	public function dd( ...$vars ) {
		foreach ( $vars as $var ) {
			dd( $var );
		}
	}

	/**
	 * Enqueue Block Scripts.
	 *
	 * @param string $handle The Script Handle.
	 */
	public function enqueue_script( string $handle ): void {
		wp_enqueue_script( $handle );
	}

	/**
	 * Get Static Asset URL.
	 *
	 * @param string $rel_file_path The Asset File Path Relative to the Theme Dir.
	 *
	 * @return string The Asset URL.
	 */
	public function get_static_asset( string $rel_file_path ): string {
		return esc_url( get_stylesheet_directory_uri() ) . "/$rel_file_path";
	}

	/**
	 * Gets Images Source Sets.
	 *
	 * @param array        $sizes The WordPress Image Sizes.
	 * @param array|string $allowed_sizes The Image Sizes to Generate for This Particular Image.
	 *
	 * @return array The Image Source Set.
	 */
	public function get_image_srcset( array $sizes, array|string $allowed_sizes = array( 'xs', 'sm', 'md', 'lg', 'xl' ) ): array {
		$srcset = array();

		$min_widths = array(
			'xl' => '1440px',
			'lg' => '1280px',
			'md' => '1024px',
			'sm' => '768px',
			'xs' => '',
		);

		foreach ( $min_widths as $image_size => $min_width ) {
			if ( isset( $sizes[ $image_size ] ) && in_array( $image_size, $allowed_sizes, true ) ) {
				$srcset[] = array(
					'srcset'    => $sizes[ $image_size ],
					'srcset@2x' => $sizes[ $image_size . '@2x' ],
					'srcset@3x' => $sizes[ $image_size . '@3x' ],
					'media'     => '(min-width: ' . $min_width . ')',
					'width'     => $sizes[ $image_size . '-width' ],
					'height'    => $sizes[ $image_size . '-height' ],
				);
			}
		}

		return $srcset;
	}

	/**
	 * Gets a Color Name Given Its HEX Value.
	 *
	 * @param string $color_hex The Color HEX Value.
	 *
	 * @return string|int|false The Color Name If Found.
	 */
	public function get_color_name( string $color_hex ): string|int|false {
		return array_search( strtoupper( $color_hex ), $this->acf->get_color_palette(), true );
	}

	/**
	 * Gets the Foreground Color Name Given a Background Color Name.
	 *
	 * @param  string $background_color_name  The Background Color Name.
	 *
	 * @return string The Foreground Color Name.
	 *
	 * @throws SourceException If CSS Parsing Fails.
	 */
	public function get_foreground_color_name( string $background_color_name ): string {
		$dark_colors = $this->acf->get_safe_bg_colors_names()['dark'];

		return in_array( $background_color_name, $dark_colors, true ) ? 'anti-flash-white-100' : 'anti-flash-white-900';
	}
}
