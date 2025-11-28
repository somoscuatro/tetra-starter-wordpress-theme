<?php
/**
 * Contains Somoscuatro\Starter_Theme\ACF Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme;

use Somoscuatro\Starter_Theme\Attributes\Action;
use Somoscuatro\Starter_Theme\Helpers\Filesystem;

/**
 * ACF Custom Functionality.
 */
class ACF {

	use Filesystem;

	/**
	 * The ACF Color Palette.
	 *
	 * @var array
	 */
	private $acf_color_palette = array();

	/**
	 * The Allowed Colors Palette for ACF Block Background.
	 *
	 * @var array
	 */
	private $acf_bg_color_palette = array();

	/**
	 * ACF Custom Functionality.
	 */
	#[Action( 'init' )]
	public function setup_color_palette(): void {
		$this->acf_color_palette    = $this->get_color_palette();
		$this->acf_bg_color_palette = $this->get_bg_safe_color_palette( $this->acf_color_palette, $this->get_safe_bg_colors_names()['colors'] );
	}

	/**
	 * Gets Color Palette from a JSON File.
	 *
	 * @return array The Color Palette File Content.
	 */
	private function get_color_palette(): array {
		if ( ! file_exists( $this->get_base_path() . '/tailwind.colors.json' ) ) {
			return array();
		}

		$tailwind_colors = wp_json_file_decode(
			$this->get_base_path() . '/tailwind.colors.json',
			array( 'associative' => true )
		);

		$colors_palette = array();
		foreach ( $tailwind_colors as $color_name => $color_shades ) {
			foreach ( $color_shades as $color_shade => $hex ) {
				$colors_palette[ $color_name . '-' . $color_shade ] = $hex;
			}
		}

		return $colors_palette;
	}

	/**
	 * Gets the Safe Background Colors Name from Tailwind Config JSON File.
	 *
	 * @return array The Safe Background Colors Name.
	 */
	private function get_safe_bg_colors_names(): array {
		if ( ! file_exists( $this->get_base_path() . '/tailwind.bg-colors-safelist.json' ) ) {
			return array();
		}

		$safe_bg_colors = wp_json_file_decode(
			$this->get_base_path() . '/tailwind.bg-colors-safelist.json',
			array( 'associative' => true )
		);

		if ( ! isset( $safe_bg_colors ) ) {
			return array();
		}

		return $safe_bg_colors;
	}

	/**
	 * Reduces a Given Color Palette to the Background Safe Colors.
	 *
	 * @param array $color_palette The Tailwind Color Palette.
	 * @param array $safe_bg_colors The Safe Background Colors Name.
	 *
	 * @return array The Background Safe Color Palette.
	 */
	private function get_bg_safe_color_palette( array $color_palette, array $safe_bg_colors ): array {
		return array_filter(
			$color_palette,
			function ( $color ) use ( $safe_bg_colors ) {
				return in_array( 'bg-' . $color, $safe_bg_colors, true );
			},
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * Restricts the ACF Color Picker Palette.
	 */
	#[Action( 'acf/input/admin_footer' )]
	public function restrict_color_picker_palette(): void {
		$palette = implode( "','", array_values( $this->acf_bg_color_palette ) );
		?>
		<script type="text/javascript">
			(function() {
				acf.add_filter('color_picker_args', function( args, $field ){
					args.palettes = ['<?php echo $palette; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>']
					return args;
				});
			})(jQuery);
			</script>
		<?php
	}
}
