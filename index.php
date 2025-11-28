<?php
/**
 * The Index Template File.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

TimberLibrary::render( 'index.twig', $context );
