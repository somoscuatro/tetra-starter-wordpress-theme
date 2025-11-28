<?php
/**
 * Initialize Theme.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

use Somoscuatro\Starter_Theme\CLI\CLI;
use Somoscuatro\Starter_Theme\Attributes\Hook;

use DI\ContainerBuilder;

if ( ! defined( 'ABSPATH' ) ) {
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
	exit;
}

// Setup Autoload.
require_once __DIR__ . '/autoload.php';

// Setup Dependencies.
$builder = new ContainerBuilder();
$builder->useAttributes( true );
$container = $builder->build();

// Register WordPress Hooks.
( new Hook( $container ) )->register_hooks();

// Register CLI Commands.
( new CLI( $container ) )->register_commands();
