<?php
/**
 * List of Classes to Be Hooked.
 *
 * @package tetra-starter-wordpress-theme
 */

use Somoscuatro\Tetra_Starter_Theme\ACF;
use Somoscuatro\Tetra_Starter_Theme\Asset;
use Somoscuatro\Tetra_Starter_Theme\Customizer;
use Somoscuatro\Tetra_Starter_Theme\GTM;
use Somoscuatro\Tetra_Starter_Theme\Gutenberg;
use Somoscuatro\Tetra_Starter_Theme\Media;
use Somoscuatro\Tetra_Starter_Theme\Navigation;
use Somoscuatro\Tetra_Starter_Theme\Performance;
use Somoscuatro\Tetra_Starter_Theme\Theme;
use Somoscuatro\Tetra_Starter_Theme\Timber;
use Somoscuatro\Tetra_Starter_Theme\Translation;

/**
 * List of Classes with Hooks
 */
return array(
	Theme::class,

	ACF::class,
	Asset::class,
	Customizer::class,
	GTM::class,
	Gutenberg::class,
	Media::class,
	Navigation::class,
	Performance::class,
	Timber::class,
	Translation::class,
);
