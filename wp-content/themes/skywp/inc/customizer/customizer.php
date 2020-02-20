<?php
/**
 * SkyWP Theme Customizer
 *
 * @package Urchenko
 * @subpackage SkyWP WordPress theme
 * @since SkyWP 1.0.0
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default settings
 *
 * @since 1.0.0
 */
add_action( 'customize_register', 'skywp_customize_register' );
function skywp_customize_register( $wp_customize ) {

	// Settings name and description default
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// This setting should be set to Refresh otherwise there are problems with displaying the title and description
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'refresh';

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title',
			'render_callback' => 'skywp_customize_partial_blogname',
		) );
		
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'skywp_customize_partial_blogdescription',
		) );

	}

}

/**
 * Change default settings customizer
 * 
 * @since 1.0.0
 */
add_action( 'customize_register', 'skywp_remove_control', 20 );
function skywp_remove_control( $wp_customize ) {

	$wp_customize->remove_control( 'header_textcolor' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );

}


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function skywp_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function skywp_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Load styles and scripts for customizer
 * 
 * @since 1.0.0
 */
add_action( 'customize_controls_enqueue_scripts', 'skywp_custom_customize' );
function skywp_custom_customize() {

	wp_enqueue_style( 'skywp-customizer', SKYWP_INC_DIR_URI .'customizer/assets/css/customizer.css', [], SKYWP_THEME_VERSIONE );
	wp_enqueue_style( 'alpha_color-picker', SKYWP_INC_DIR_URI .'customizer/assets/alpha-color-picker/alpha-color-picker.css', ['wp-color-picker'], SKYWP_THEME_VERSIONE );
	wp_enqueue_script( 'alpha-color-picker', SKYWP_INC_DIR_URI .'customizer/assets/alpha-color-picker/alpha-color-picker.js', array( 'jquery', 'wp-color-picker' ), SKYWP_THEME_VERSIONE, true );

}

/**
 * Load scripts for customizer
 * 
 * @since 1.0.0
 */
add_action( 'customize_preview_init', 'skywp_customize_preview' );
function skywp_customize_preview() {

	wp_enqueue_script( 'skywp-customizer', SKYWP_INC_DIR_URI . 'customizer/assets/js/customizer.js', array( 'jquery', 'customize-preview' ), SKYWP_THEME_VERSIONE, true );
	

}

/**
 * Get the value to customize and send this value in main.js 
 * 
 * @since 1.0.0
 */
add_action( 'wp_enqueue_scripts', 'skywp_get_value_customize_', 99 );
function skywp_get_value_customize_() {

  wp_localize_script( 'skywp-main-script', 'sky_header_sticky_value', array( 
    'sky_header_sticky' => get_theme_mod( 'sky_header_sticky', false ), 
  ) );

  wp_localize_script( 'skywp-main-script', 'sky_header_position_mobile_menu', array( 
    'sky_header_position_mobile_menu' => get_theme_mod( 'sky_header_position_mobile_menu', 'left' ), 
  ) );

  wp_localize_script( 'skywp-main-script', 'sky_header_opening_mobile_menu', array( 
    'sky_header_opening_mobile_menu' => get_theme_mod( 'sky_header_opening_mobile_menu', 'overlap' ), 
  ) );

  wp_localize_script( 'skywp-main-script', 'skywp_post_style', array( 
    'skywp_post_style' => get_theme_mod( 'skywp_post_style', 'default' ), 
  ) );

}




