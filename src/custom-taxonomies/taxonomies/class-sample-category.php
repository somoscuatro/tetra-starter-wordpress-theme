<?php
/**
 * Contains Somoscuatro\Starter_Theme\Custom_Taxonomies\Taxonomies\Sample_Category Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Starter_Theme\Custom_Taxonomies\Taxonomies;

use Somoscuatro\Starter_Theme\Custom_Taxonomies\Custom_Taxonomy;

/**
 * Sample Category Custom Taxonomy.
 */
class Sample_Category extends Custom_Taxonomy {

	/**
	 * Taxonomy Singular Name.
	 *
	 * @var string
	 */
	protected string $singular_name = 'Sample Category';

	/**
	 * Taxonomy Plural Name.
	 *
	 * @var string
	 */
	protected string $plural_name = 'Sample Categories';

	/**
	 * Custom Post Types Using This Taxonomy.
	 *
	 * @var array
	 */
	protected array $post_types = array( 'sample' );
}
