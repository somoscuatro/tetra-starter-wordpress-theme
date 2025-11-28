<?php
/**
 * Contains Somoscuatro\Starter_Theme\Custom_Post_Types\Custom_Post_Type Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme\Custom_Post_Types;

/**
 * Custom Post Related Functionality.
 */
class Custom_Post_Type {

	/**
	 * Custom Post Type Singular Name.
	 *
	 * @var string
	 */
	protected string $singular_name = '';

	/**
	 * Custom Post Type Plural Name.
	 *
	 * @var string
	 */
	protected string $plural_name = '';

	/**
	 * Custom Post Type Default Arguments.
	 *
	 * @var array
	 */
	protected array $args = array();

	/**
	 * Class Constructor.
	 */
	public function __construct() {
		$this->args = array(
			'supports'           => array( 'title', 'editor', 'page-attributes' ),
			'has_archive'        => true,
			'hierarchical'       => true,
			'public'             => true,
			'publicly_queryable' => true,
			'show_in_rest'       => false,
		);
	}

	/**
	 * Registers a Custom Post Type.
	 *
	 * See https://developer.wordpress.org/reference/functions/register_post_type/.
	 */
	public function init(): void {
		// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment
		$labels = array(
			'name'               => $this->plural_name,
			'singular_name'      => $this->singular_name,
			'add_new'            => __( 'Add New', 'tetra-starter-wordpress-theme' ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'edit'               => __( 'Edit', 'tetra-starter-wordpress-theme' ),
			'edit_item'          => sprintf( __( 'Edit %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'new_item'           => sprintf( __( 'New %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'view'               => __( 'View', 'tetra-starter-wordpress-theme' ),
			'view_item'          => sprintf( __( 'View %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'search_items'       => sprintf( __( 'Search %s', 'tetra-starter-wordpress-theme' ), $this->plural_name ),
			'not_found'          => sprintf( __( 'No %s found', 'tetra-starter-wordpress-theme' ), $this->plural_name ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'tetra-starter-wordpress-theme' ), $this->plural_name ),
			'parent'             => sprintf( __( 'Parent %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
		);
		// phpcs:enable WordPress.WP.I18n.MissingTranslatorsComment

		$this->args['labels'] = $labels;

		register_post_type( sanitize_title( $this->singular_name ), $this->args );
	}
}
