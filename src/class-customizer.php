<?php
/**
 * Contains Somoscuatro\Tetra_Starter_Theme\Customizer Class.
 *
 * @package tetra-starter-wordpress-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Tetra_Starter_Theme;

use Somoscuatro\Tetra_Starter_Theme\Attributes\Action;

/**
 * WordPress Theme Customizer Functionality.
 */
class Customizer {

	/**
	 * Adds Google Tag Manager Controls to the Customizer.
	 *
	 * @param \WP_Customize_Manager $wp_customize WP_customize_manager Instance.
	 */
	#[Action( 'customize_register' )]
	public function add_customizer_gtm_controls( \WP_Customize_Manager $wp_customize ): void {
		// Section.
		$wp_customize->add_section(
			'gtm',
			array(
				'title'      => __( 'Google Tag Manager', 'tetra-starter-wordpress-theme' ),
				'priority'   => 35,
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_setting(
			'gtm_id',
			array(
				'default'    => '',
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'gtm_id',
				array(
					'label'    => __( 'GTM ID', 'tetra-starter-wordpress-theme' ),
					'section'  => 'gtm',
					'settings' => 'gtm_id',
					'type'     => 'text',
				),
			),
		);
	}
}
