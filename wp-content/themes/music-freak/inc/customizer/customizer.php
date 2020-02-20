<?php
/**
 * Music Freak Customizer.
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

//load upgrade-to-pro section
require get_template_directory() . '/inc/customizer/upgrade-to-pro/class-customize.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function music_freak_customize_register( $wp_customize ) {
	$options = music_freak_get_theme_options();

	// Load custom control functions.
	require get_template_directory() . '/inc/customizer/custom-controls.php';

	// Load customize active callback functions.
	require get_template_directory() . '/inc/customizer/active-callback.php';

	// Load partial callback functions.
	require get_template_directory() . '/inc/customizer/partial.php';

	// Load validation callback functions.
	require get_template_directory() . '/inc/customizer/validation.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	// Remove the core header textcolor control, as it shares the main text color.
	$wp_customize->remove_control( 'header_textcolor' );

	// Header title color setting and control.
	$wp_customize->add_setting( 'music_freak_theme_options[header_title_color]', array(
		'default'           => $options['header_title_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'music_freak_theme_options[header_title_color]', array(
		'priority'			=> 5,
		'label'             => esc_html__( 'Header Title Color', 'music-freak' ),
		'section'           => 'colors',
	) ) );

	// Header tagline color setting and control.
	$wp_customize->add_setting( 'music_freak_theme_options[header_tagline_color]', array(
		'default'           => $options['header_tagline_color'],
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'			=> 'postMessage'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'music_freak_theme_options[header_tagline_color]', array(
		'priority'			=> 6,
		'label'             => esc_html__( 'Header Tagline Color', 'music-freak' ),
		'section'           => 'colors',
	) ) );

	// Site identity extra options.
	$wp_customize->add_setting( 'music_freak_theme_options[header_txt_logo_extra]', array(
		'default'           => $options['header_txt_logo_extra'],
		'sanitize_callback' => 'music_freak_sanitize_select',
		'transport'			=> 'refresh'
	) );

	$wp_customize->add_control( 'music_freak_theme_options[header_txt_logo_extra]', array(
		'priority'			=> 50,
		'type'				=> 'radio',
		'label'             => esc_html__( 'Site Identity Extra Options', 'music-freak' ),
		'section'           => 'title_tagline',
		'choices'				=> array( 
			'hide-all'     => esc_html__( 'Hide All', 'music-freak' ),
			'show-all'     => esc_html__( 'Show All', 'music-freak' ),
			'title-only'   => esc_html__( 'Title Only', 'music-freak' ),
			'tagline-only' => esc_html__( 'Tagline Only', 'music-freak' ),
			'logo-title'   => esc_html__( 'Logo + Title', 'music-freak' ),
			'logo-tagline' => esc_html__( 'Logo + Tagline', 'music-freak' ),
			)
	) );

	/**
	 * Theme colors.
	 */
	$wp_customize->add_setting( 'music_freak_theme_options[theme_color]', array(
		'default'           => $options['theme_color'],
		'sanitize_callback' => 'music_freak_sanitize_select',
	) );

	$wp_customize->add_control( 'music_freak_theme_options[theme_color]', array(
		'type'    => 'radio',
		'label'    => esc_html__( 'Theme Color', 'music-freak' ),
		'choices'  => array(
            'lite-version'   => esc_html__( 'Lite Version', 'music-freak' ),
            'dark-version'   => esc_html__( 'Dark Version', 'music-freak' ),
		),
		'section'  => 'colors',
	) );

	// Add panel for common theme options
	$wp_customize->add_panel( 'music_freak_theme_options_panel' , array(
	    'title'      => esc_html__( 'Theme Options','music-freak' ),
	    'description'=> esc_html__( 'Music Freak Theme Options.', 'music-freak' ),
	    'priority'   => 150,
	) );

	// breadcrumb
	require get_template_directory() . '/inc/customizer/theme-options/breadcrumb.php';
	
	// load layout
	require get_template_directory() . '/inc/customizer/theme-options/layout.php';

	// load menu
	require get_template_directory() . '/inc/customizer/theme-options/menu.php';

	// load static homepage option
	require get_template_directory() . '/inc/customizer/theme-options/homepage-static.php';

	// load archive option
	require get_template_directory() . '/inc/customizer/theme-options/excerpt.php';

	// load archive option
	require get_template_directory() . '/inc/customizer/theme-options/archive.php';
	
	// load single post option
	require get_template_directory() . '/inc/customizer/theme-options/single-posts.php';

	// load pagination option
	require get_template_directory() . '/inc/customizer/theme-options/pagination.php';

	// load footer option
	require get_template_directory() . '/inc/customizer/theme-options/footer.php';

	// load reset option
	require get_template_directory() . '/inc/customizer/theme-options/reset.php';

	// Add panel for front page theme options.
	$wp_customize->add_panel( 'music_freak_front_page_panel' , array(
	    'title'      => esc_html__( 'Front Page','music-freak' ),
	    'description'=> esc_html__( 'Front Page Theme Options.', 'music-freak' ),
	    'priority'   => 140,
	) );

	// load slider option
	require get_template_directory() . '/inc/customizer/sections/slider.php';

	// load about option
	require get_template_directory() . '/inc/customizer/sections/about.php';

	// load music video option
	require get_template_directory() . '/inc/customizer/sections/music-video.php';

	// load service option
	require get_template_directory() . '/inc/customizer/sections/service.php';

	// load blog option
	require get_template_directory() . '/inc/customizer/sections/blog.php';

	// load call to action option
	require get_template_directory() . '/inc/customizer/sections/cta.php';

}
add_action( 'customize_register', 'music_freak_customize_register' );

/*
 * Load customizer sanitization functions.
 */
require get_template_directory() . '/inc/customizer/sanitize.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function music_freak_customize_preview_js() {
	wp_enqueue_script( 'music-freak-customizer', get_template_directory_uri() . '/assets/js/customizer' . music_freak_min() . '.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'music_freak_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function music_freak_customize_control_js() {
	// fontawesome
	wp_enqueue_style( 'font-awesome-css', get_template_directory_uri() . '/assets/css/font-awesome' . music_freak_min() . '.css' );
	
	// Choose from select jquery.
	wp_enqueue_style( 'chosen-css', get_template_directory_uri() . '/assets/css/chosen' . music_freak_min() . '.css' );
	wp_enqueue_script( 'jquery-chosen', get_template_directory_uri() . '/assets/js/chosen.jquery' . music_freak_min() . '.js', array( 'jquery' ), '1.4.2', true );

	// simple icon picker
	wp_enqueue_style( 'simple-iconpicker-css', get_template_directory_uri() . '/assets/css/simple-iconpicker' . music_freak_min() . '.css' );
	wp_enqueue_script( 'jquery-simple-iconpicker', get_template_directory_uri() . '/assets/js/simple-iconpicker' . music_freak_min() . '.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'music-freak-customize-controls-css', get_template_directory_uri() . '/assets/css/customize-controls' . music_freak_min() . '.css' );
	wp_enqueue_script( 'music-freak-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls' . music_freak_min() . '.js', array(), '1.0', true );
	$music_freak_reset_data = array(
		'reset_message' => esc_html__( 'Refresh the customizer page after saving to view reset effects', 'music-freak' )
	);
	// Send list of color variables as object to custom customizer js
	wp_localize_script( 'music-freak-customize-controls', 'music_freak_reset_data', $music_freak_reset_data );
}
add_action( 'customize_controls_enqueue_scripts', 'music_freak_customize_control_js' );

if ( !function_exists( 'music_freak_reset_options' ) ) :
	/**
	 * Reset all options
	 *
	 * @since Music Freak 1.0.0
	 *
	 * @param bool $checked Whether the reset is checked.
	 * @return bool Whether the reset is checked.
	 */
	function music_freak_reset_options() {
		$options = music_freak_get_theme_options();
		if ( true === $options['reset_options'] ) {
			// Reset custom theme options.
			set_theme_mod( 'music_freak_theme_options', array() );
			// Reset custom header and backgrounds.
			remove_theme_mod( 'header_image' );
			remove_theme_mod( 'header_image_data' );
			remove_theme_mod( 'background_image' );
			remove_theme_mod( 'background_color' );
			remove_theme_mod( 'header_textcolor' );
	    }
	  	else {
		    return false;
	  	}
	}
endif;
add_action( 'customize_save_after', 'music_freak_reset_options' );
