<?php
/**
 * List of Classes to Be Hooked.
 *
 * @package tetra-starter-wordpress-theme
 */

use Somoscuatro\Starter_Theme\ACF;
use Somoscuatro\Starter_Theme\Asset;
use Somoscuatro\Starter_Theme\Customizer;
use Somoscuatro\Starter_Theme\GTM;
use Somoscuatro\Starter_Theme\Gutenberg;
use Somoscuatro\Starter_Theme\Media;
use Somoscuatro\Starter_Theme\Navigation;
use Somoscuatro\Starter_Theme\Performance;
use Somoscuatro\Starter_Theme\Theme;
use Somoscuatro\Starter_Theme\Timber;
use Somoscuatro\Starter_Theme\Translation;

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
