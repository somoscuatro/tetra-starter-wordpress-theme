<?php
/**
 * Contains Somoscuatro\Starter_Theme\Attributes\Hook Class.
 *
 * @package sc-starter-theme
 */

namespace Somoscuatro\Starter_Theme\Attributes;

use DI\Attribute\Inject;
use DI\Container;

use ReflectionAttribute;
use ReflectionClass;

/**
 * Hooks Management Class.
 */
class Hook {

	/**
	 * The PHP DI Container.
	 *
	 * @var Container
	 */
	#[Inject]
	private Container $container;

	/**
	 * Registers Hooks.
	 */
	public function register_hooks(): void {
		$hooked_classes = require __DIR__ . '/hooked-classes.php';
		$instances      = array();

		foreach ( $hooked_classes as $class_name ) {
			$reflection_class = new ReflectionClass( $class_name );

			foreach ( $reflection_class->getMethods() as $method ) {
				$attributes = $method->getAttributes( Filter::class, ReflectionAttribute::IS_INSTANCEOF );

				foreach ( $attributes as $attribute ) {
					// Maybe Instantiate Class.
					if ( ! array_key_exists( $class_name, $instances ) ) {
						$instances[ $class_name ] = $this->container->get( $class_name );
					}

					// Instantiate Hooks.
					$hook_class = $attribute->newInstance();
					$hook_class->register(
						array(
							$instances[ $class_name ],
							$method->getName(),
						)
					);
				}
			}
		}
	}
}
