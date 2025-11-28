<?php
/**
 * Contains Somoscuatro\Starter_Theme\Attributes\Filter Class.
 *
 * @package tetra-starter-wordpress-theme
 */

namespace Somoscuatro\Starter_Theme\Attributes;

use Attribute;

/**
 * WordPress Filters Management Class.
 */
#[Attribute( Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE )]
class Filter {

	/**
	 * Class Constructor.
	 *
	 * @param string  $hook_name The Hook Name.
	 * @param integer $priority The Hook Priority.
	 * @param integer $accepted_args The Number of Arguments Accepted.
	 */
	public function __construct(
		public string $hook_name,
		public int $priority = 10,
		public int $accepted_args = 1,
	) { }

	/**
	 * Register the Filter Handler.
	 *
	 * @param callable|array $method The Filter Handler.
	 */
	public function register( callable|array $method ): void {
		add_filter(
			$this->hook_name,
			$method,
			$this->priority,
			$this->accepted_args
		);
	}
}
