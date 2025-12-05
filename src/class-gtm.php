<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\GTM Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

use Somoscuatro\Tetra_Starter_Theme\Attributes\Action;

/**
 * Google Tag Manager Custom Functionality.
 */
class GTM {

	/**
	 * Adds Google Tag Manager Head Script.
	 */
	#[Action( 'wp_head' )]
	public function google_tag_manager_head(): void {
		?>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_attr( get_theme_mod( 'gtm_id' ) ); ?>');</script>
		<?php
	}

	/**
	 * Adds Google Tag Manager Body Script.
	 */
	#[Action( 'wp_body_open' )]
	public function google_tag_manager_body(): void {
		?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( get_theme_mod( 'gtm_id' ) ); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<?php
	}
}
