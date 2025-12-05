<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Theme Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

use DI\Attribute\Inject;

use Somoscuatro\Tetra_Starter_Theme\Attributes\Action;
use Somoscuatro\Tetra_Starter_Theme\Attributes\Filter;

use Somoscuatro\Tetra_Starter_Theme\Blocks\Loader as BlocksLoader;
use Somoscuatro\Tetra_Starter_Theme\Custom_Post_Types\Loader as CustomPostTypesLoader;
use Somoscuatro\Tetra_Starter_Theme\Custom_Taxonomies\Loader as CustomTaxonomiesLoader;

/**
 * Main Theme Class.
 */
class Theme {

	/**
	 * The Custom_Post_Types\Loader Instance.
	 *
	 * @var CustomPostTypesLoader
	 */
	#[Inject]
	private CustomPostTypesLoader $custom_post_types_loader;

	/**
	 * The Custom_Taxonomies\Loader Instance.
	 *
	 * @var CustomTaxonomiesLoader
	 */
	#[Inject]
	private CustomTaxonomiesLoader $custom_taxonomies_loader;

	/**
	 * The Blocks\Loader Instance.
	 *
	 * @var BlocksLoader
	 */
	#[Inject]
	private BlocksLoader $blocks_loader;

	/**
	 * Theme Naming Prefix.
	 *
	 * @var string
	 */
	private $prefix = 'tetra_starter_theme';

	/**
	 * Initialization method.
	 */
	#[Action( 'init' )]
	public function init(): void {
		$this->blocks_loader->load();
	}

	/**
	 * Registers Theme Support for Additional Features.
	 */
	#[Action( 'after_setup_theme' )]
	public function theme_support(): void {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		$this->custom_post_types_loader->load();
		$this->custom_taxonomies_loader->load();
	}

	/**
	 * Displays Missing Plugins Warning.
	 */
	#[Action( 'admin_notices' )]
	public function display_missing_plugins_warning(): void {
		if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) && ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) :
			?>
		<div class="error">
			<p>
				<?php
					echo wp_kses_post(
						sprintf(
							/* translators: %s plugin name and link to plugin vendor page. */
							__( '%s plugin is not installed. Please install the plugin to use the TetraStarter WordPress Theme.', 'tetra-starter-wordpress-theme' ),
							'<a href="https://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields (ACF)</a>'
						)
					);
				?>
			</p>
		</div>
			<?php
		endif;
	}

	/**
	 * Adds Page Slug to Body Classes.
	 *
	 * @param array $classes The Body Classes.
	 *
	 * @return array The Modified Body Classes.
	 */
	#[Filter( 'body_class' )]
	public function body_class( array $classes ): array {
		if ( is_single() || ( is_page() && ! is_front_page() ) ) {
			if ( ! in_array( basename( get_permalink() ), $classes, true ) ) {
				$classes[] = basename( get_permalink() );
			}
		}
		if ( is_page() && has_post_parent() ) {
			global $post;
			if ( ! in_array( basename( get_permalink( $post->post_parent ) ), $classes, true ) ) {
				$classes[] = basename( get_permalink( $post->post_parent ) );
			}
		}
		if ( is_404() ) {
			$classes[] = '404';
		}

		return $classes;
	}

	/**
	 * Returns the Theme Prefix.
	 *
	 * @return string The Theme Prefix.
	 */
	public function get_prefix(): string {
		return $this->prefix;
	}
}
