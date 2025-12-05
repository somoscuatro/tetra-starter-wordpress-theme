<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Custom_Taxonomies\Custom_Taxonomy Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme\Custom_Taxonomies;

/**
 * Custom Taxonomy Related Functionality.
 */
class Custom_Taxonomy {

	/**
	 * Taxonomy Singular Name.
	 *
	 * @var string
	 */
	protected string $singular_name = '';

	/**
	 * Taxonomy Plural Name.
	 *
	 * @var string
	 */
	protected string $plural_name = '';

	/**
	 * Custom Post Types Using This Taxonomy.
	 *
	 * @var array
	 */
	protected array $post_types = array();

	/**
	 * Custom Taxonomy Default Arguments.
	 *
	 * @var array
	 */
	protected array $args = array();

	/**
	 * Class Constructor.
	 */
	public function __construct() {
		$this->args = array(
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
		);
	}

	/**
	 * Registers a Custom Taxonomy.
	 *
	 * See https://developer.wordpress.org/reference/functions/register_taxonomy/.
	 */
	public function init(): void {
		// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment
		$labels = array(
			'name'              => $this->plural_name,
			'singular_name'     => $this->singular_name,
			'search_items'      => sprintf( __( 'Search %s', 'tetra-starter-wordpress-theme' ), $this->plural_name ),
			'all_items'         => sprintf( __( 'All %s', 'tetra-starter-wordpress-theme' ), $this->plural_name ),
			'parent_item'       => sprintf( __( 'Parent %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'parent_item_colon' => sprintf( __( 'Parent %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'edit_item'         => sprintf( __( 'Edit %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'update_item'       => sprintf( __( 'Update %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'add_new_item'      => sprintf( __( 'Add New %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'new_item_name'     => sprintf( __( 'New %s', 'tetra-starter-wordpress-theme' ), $this->singular_name ),
			'menu_name'         => $this->plural_name,
		);
		// phpcs:enable WordPress.WP.I18n.MissingTranslatorsComment

		$this->args['labels'] = $labels;

		register_taxonomy(
			str_replace( '-', '_', sanitize_title( $this->singular_name ) ),
			$this->post_types,
			$this->args
		);
	}
}
