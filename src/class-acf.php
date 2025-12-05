<?php
/**
 * Contains Somoscuatro\Starter_Theme\ACF Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme;

use Sabberworm\CSS\Parser;
use Sabberworm\CSS\Parsing\SourceException;
use Sabberworm\CSS\RuleSet\RuleSet;
use Sabberworm\CSS\Value\Color;
use Sabberworm\CSS\Value\Size;
use Somoscuatro\Starter_Theme\Attributes\Action;
use Somoscuatro\Starter_Theme\Helpers\Filesystem;

/**
 * ACF Custom Functionality.
 */
class ACF {

	use Filesystem;

	/**
	 * The Cached Parsed CSS Color Rules.
	 *
	 * @var array
	 */
	private static array $cached_color_rules = array();

	/**
	 * The Allowed Colors Palette for ACF Block Background.
	 *
	 * @var array
	 */
	private array $allowed_bg_colors = array();

	/**
	 * Initializes the Allowed Background Color Palette for ACF.
	 *
	 * @throws SourceException If CSS Parsing Fails.
	 */
	#[Action( 'init' )]
	public function setup_color_palette(): void {
		$this->allowed_bg_colors = $this->filter_safe_bg_colors( $this->get_color_palette(), $this->get_safe_bg_colors_names()['colors'] );
	}

	/**
	 * Extracts the Theme's Color Palette from the CSS File.
	 *
	 * @return array Associative Array of Color Name => HEX Value.
	 *
	 * @throws SourceException If CSS Parsing Fails.
	 */
	public function get_color_palette(): array {
		$color_palette = array();

		foreach ( $this->parse_color_css_file() as $rule_name => $rule_value ) {
			if ( ! $rule_value instanceof Color ) {
				continue;
			}

			$rgb_color = array();

			foreach ( $rule_value->getColor() as $color_component ) {
				if ( ! $color_component instanceof Size ) {
					continue;
				}

				$rgb_color[] = (int) $color_component->getSize();
			}

			[$r, $g, $b] = $rgb_color;
			$hex_color   = sprintf( '#%02X%02X%02X', $r, $g, $b );

			if ( str_starts_with( $rule_name, '--color-' ) ) {
				$color_palette[ str_replace( '--color-', '', $rule_name ) ] = $hex_color;
			}
		}

		return $color_palette;
	}

	/**
	 * Gets the List of Safe Background Color Names from the CSS File.
	 *
	 * @return array List of Safe Background Color Names.
	 *
	 * @throws SourceException If CSS Parsing Fails.
	 */
	public function get_safe_bg_colors_names(): array {
		$safe_bg_colors_name = array();

		foreach ( $this->parse_color_css_file() as $rule_name => $rule_value ) {
			if ( str_starts_with( $rule_name, '--safe-color-' ) ) {
				$safe_bg_colors_name['colors'][] = str_replace( '--safe-color-', '', $rule_name );
			}

			if ( str_starts_with( $rule_name, '--safe-dark-color-' ) ) {
				$safe_bg_colors_name['dark'][] = str_replace( '--safe-dark-color-', '', $rule_name );
			}

			if ( str_starts_with( $rule_name, '--safe-light-color-' ) ) {
				$safe_bg_colors_name['light'][] = str_replace( '--safe-light-color-', '', $rule_name );
			}
		}

		return $safe_bg_colors_name;
	}

	/**
	 * Filters the theme color palette to only include safe background colors.
	 *
	 * @param array $palette Associative Array of ColoName => HEX Value.
	 * @param array $safe_names List of Safe Color Names.
	 *
	 * @return array Filtered Palette of Safe Background Colors.
	 */
	private function filter_safe_bg_colors( array $palette, array $safe_names ): array {
		return array_filter(
			$palette,
			function ( $color ) use ( $safe_names ) {
				return in_array( $color, $safe_names, true );
			},
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * Parses the Theme Color CSS File and Returns CSS Variable Rules.
	 *
	 * @return array The Parsed Color CSS Rules.
	 *
	 * @throws SourceException If CSS Parsing Fails.
	 */
	private function parse_color_css_file(): array {
		if ( ! empty( self::$cached_color_rules ) ) {
			return self::$cached_color_rules;
		}

		$theme_color_css        = $this->get_file_content( $this->get_base_path() . '/assets/styles/theme/_colors.css' );
		$parsed_theme_color_css = new Parser( $theme_color_css )->parse();

		foreach ( $parsed_theme_color_css->getContents() as $item ) {
			if ( ! $item instanceof RuleSet ) {
				continue;
			}

			foreach ( $item->getRules() as $rule ) {
				self::$cached_color_rules[ $rule->getRule() ] = $rule->getValue();
			}
		}

		return self::$cached_color_rules;
	}

	/**
	 * Restricts the ACF Color Picker Palette to Allowed Background Colors.
	 */
	#[Action( 'acf/input/admin_footer' )]
	public function restrict_color_picker_palette(): void {
		$palette = implode( "','", array_values( $this->allowed_bg_colors ) );
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
