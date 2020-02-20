<?php
/**
* Typography Customizer Options
*
* @package Urchenko Technologies
* @subpackage SkyWP WordPress theme
* @since SkyWP 1.0.0
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Customizer Typography Options
*
* @since 1.0.0
*/
add_action( 'customize_register', 'skywp_customizer_typography_options' );
function skywp_customizer_typography_options( $wp_customize ) {

	/**
	 * Section typography
	 */
	$wp_customize->add_section( 'sky_typography_body', array(
		'title'				=> esc_html__( 'Typography', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_general_settings_panel',
	) );

	/**
	 * Heading Body
	 */
	$wp_customize->add_setting( 'skywp_typography_body_heading', array(
		'sanitize_callback' 	=> 'wp_kses',
	) );

	$wp_customize->add_control( new SkyWP_Customizer_Heading_Control( $wp_customize, 'skywp_typography_body_heading', array(
		'label'    				=> esc_html__( 'Body', 'skywp' ),
		'section'  				=> 'sky_typography_body',
		'settings'				=> 'skywp_typography_body_heading',
		'priority' 				=> 10,
	) ) );

	/**
	 * Font Family
	 */
	$wp_customize->add_setting( 'sky_typography_font_family', array(
		'default'				=> 'roboto',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_typography_font_family', array(
		'label'					=> esc_html__('Font Family', 'skywp'),
		'section'				=> 'sky_typography_body',
		'settings'				=> 'sky_typography_font_family',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'roboto'   => esc_html( 'Roboto', 'skywp' ),
            'open-sans'   => esc_html( 'Open Sans', 'skywp' ),
            'montserrat'   => esc_html( 'Montserrat', 'skywp' ),
        )
	) ) );

	













}