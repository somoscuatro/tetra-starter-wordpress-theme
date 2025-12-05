<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Blocks\Block_Interface Interface.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme\Blocks;

use Somoscuatro\Tetra_Starter_Theme\Timber;

/**
 * Interface for ACF Gutenberg Blocks.
 *
 * We need this interface to prevent child classes to override the constructor
 * with wrong parameters. This is necessary to ensure safe usage of new static()
 * in Block::render_callback().
 *
 * @see https://phpstan.org/blog/solving-phpstan-error-unsafe-usage-of-new-static
 */
interface Block_Interface {

	/**
	 * Class Constructor.
	 *
	 * @param Timber $timber The Timber Class.
	 */
	public function __construct( Timber $timber );
}
