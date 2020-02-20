<?php
/**
* TopBar Customizer Options
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
* Customizer options
*
* @since 1.0.0
*/
add_action( 'customize_register', 'skywp_customizer_options' );
function skywp_customizer_options( $wp_customize ) {

	/**
	 * Panel
	 */
	$wp_customize->add_panel( 'sky_topbar_panel', array(
		'title' 			=> esc_html__( 'TopBar', 'skywp' ),
		'priority' 			=> 21,
	) );





	/**
	 * Section
	 */
	$wp_customize->add_section( 'sky_topbar_general', array(
		'title'				=> esc_html__( 'General', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_topbar_panel',
	) );

	/**
	 * Top Bar
	 */
	$wp_customize->add_setting( 'sky_topbar', array(
		'default'				=> false,
		'sanitize_callback' 	=> 'skywp_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar', array(
		'label'					=> esc_html__('Show TopBar', 'skywp'),
		'type'					=> 'checkbox',
		'section'				=> 'sky_topbar_general',
		'settings'				=> 'sky_topbar',
		'priority'				=> 10,
	) ) );

	/**
	* TopBar Visibility
	*/
	$wp_customize->add_setting( 'sky_topbar_visibility', array(
		'default'		=> 'all-devices',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_visibility', array(
		'label'			=> esc_html__('Visibility', 'skywp'),
		'type'			=> 'select',
		'section'		=> 'sky_topbar_general',
		'settings'		=> 'sky_topbar_visibility',
		'priority'		=> 10,
		'choices'		=> array(
			'all-devices'			=> esc_html__('Show On All Devices', 'skywp'),
			'hide-tablet'			=> esc_html__('Hide On Tablet', 'skywp'),
			'hide-mobile'			=> esc_html__('Hide On Mobile', 'skywp'),
			'hide-tablet-mobile'	=> esc_html__('Hide On Tablet and Mobile', 'skywp'),
		),
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar', true );
    	},
	) ) );

	/**
	 * Width
	 */
	$wp_customize->add_setting( 'topbar_width', array(
		'default'				=> '1200',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'topbar_width', array(
		'label'					=> esc_html__('Width (px):', 'skywp'),
		'section'				=> 'sky_topbar_general',
		'settings'				=> 'topbar_width',
		'priority'				=> 10,
		'type'           => 'number',
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar', true );
    	},
	) ) );

	/**
	 * Padding
	 */
	$wp_customize->add_setting( 'sky_topbar_padding', array(
		'default'				=> '0px 0px 0px 0px',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_padding', array(
		'label'					=> esc_html__('Padding (px):', 'skywp'),
		'description'			=> esc_html__( 'top right bottom left: 10px 0px 10px 0px', 'skywp' ),
		'section'				=> 'sky_topbar_general',
		'settings'				=> 'sky_topbar_padding',
		'priority'				=> 10,
		'type'           => 'text',
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar', true );
    	},
	) ) );

	/**
	* TopBar Style
	*/
	$wp_customize->add_setting( 'sky_topbar_style_', array(
		'default'			=> 'space-between',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_style_', array(
		'label'				=> esc_html__( 'Style', 'skywp' ),
		'type'				=> 'select',
		'section'			=> 'sky_topbar_general',
		'settings'			=> 'sky_topbar_style_',
		'priority'			=> 10,
		'choices'			=> array(
			'space-between'		=> esc_html__( 'Spece Between', 'skywp' ),
			'space-around'		=> esc_html__( 'Space Around', 'skywp' ),
			'center'		=> esc_html__( 'Center', 'skywp' ),
			'flex-start'		=> esc_html__( 'Flex Start', 'skywp' ),
			'flex-end'		=> esc_html__( 'Flex End', 'skywp' ),
		),
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar', true );
    	},
	) ) );

	/**
	* Position
	*/
	$wp_customize->add_setting( 'sky_topbar_position', array(
		'default'			=> 'relative',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_position', array(
		'label'				=> esc_html__( 'Position', 'skywp' ),
		'type'				=> 'select',
		'section'			=> 'sky_topbar_general',
		'settings'			=> 'sky_topbar_position',
		'priority'			=> 10,
		'choices'			=> array(
			'relative'		=> esc_html__( 'Relative', 'skywp' ),
			'absolute'		=> esc_html__( 'Absolute', 'skywp' ),
		),
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar', true );
    	},
	) ) );

	/**
	 * Backgtoung
	 */
	$wp_customize->add_setting( 'skywp_bg_topbar', array(
		'default'     => '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
		'transport' 			=> 'postMessage',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_bg_topbar', array(
		'label'     => __( 'Backgroung', 'skywp' ),
		'section'   => 'sky_topbar_general',
		'settings'  => 'skywp_bg_topbar',
		'priority'			=> 10,
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar', true );
    	},
	) ) );

	/**
	 * Social links color
	 */
	$wp_customize->add_setting( 'skywp_social_links_color_topbar', array(
		'default'     => '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
		'transport' 			=> 'postMessage',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_social_links_color_topbar', array(
		'label'     => __( 'Social links color', 'skywp' ),
		'section'   => 'sky_topbar_general',
		'settings'  => 'skywp_social_links_color_topbar',
		'priority'			=> 10,
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar', true );
    	},
	) ) );





	/**
	* Section Content
	*/
	$wp_customize->add_section( 'sky_topbar_content', array(
		'title'			=> esc_html__( 'Content', 'skywp' ),
		'priority'		=> 10,
		'panel'			=> 'sky_topbar_panel',
	) );

	/**
	* Top Bar First Content Area
	*/
	$wp_customize->add_setting( 'sky_topbar_content_one', array(
		'default'		=> true,
		'sanitize_callback' 	=> 'skywp_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_content_one', array(
		'label'			=> esc_html__( 'Show First Content Area', 'skywp' ),
		'type'			=> 'checkbox',
		'section'		=> 'sky_topbar_content',
		'settings'		=> 'sky_topbar_content_one',
		'priority'		=> 10,
	) ) );

	/**
	* Top Bar Second Content Area
	*/
	$wp_customize->add_setting( 'sky_topbar_content_two', array(
		'default'		=> true,
		'sanitize_callback' 	=> 'skywp_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_content_two', array(
		'label'			=> esc_html__( 'Show Second Content Area', 'skywp' ),
		'type'			=> 'checkbox',
		'section'		=> 'sky_topbar_content',
		'settings'		=> 'sky_topbar_content_two',
		'priority'		=> 10,
	) ) );

	/**
	 * Font Size
	 */
	$wp_customize->add_setting( 'sky_topbar_font_size', array(
		'default'				=> '15',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_font_size', array(
		'label'					=> esc_html__('Font Size (px):', 'skywp'),
		'section'				=> 'sky_topbar_content',
		'settings'				=> 'sky_topbar_font_size',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	* Top Bar Text Color
	*/
	$wp_customize->add_setting( 'sky_topbar_text_color', array(
		'default'			=> '#c7c7c7',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_topbar_text_color', array(
		'label'				=> esc_html__( 'Text Color', 'skywp' ),
		'section'			=> 'sky_topbar_content',
		'settings'			=> 'sky_topbar_text_color',
		'priority'			=> 10,
	) ) );

	/**
	* Top Bar First Content textatea
	*/
	$wp_customize->add_setting( 'sky_topbar_content_textarea_one', array(
		'default'			=> esc_html__( 'Place your content here', 'skywp' ),
		'transport'			=> 'postMessage',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );
			
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_content_textarea_one', array(
		'label'			=> esc_html__( 'First Content Area', 'skywp' ),
		'type'			=> 'textarea',
		'section'		=> 'sky_topbar_content',
		'settings'		=> 'sky_topbar_content_textarea_one',
		'priority'		=> 10,
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar_content_one', true );
    	},
	) ) );

	/**
	* Top Bar Second Content textatea
	*/
	$wp_customize->add_setting( 'sky_topbar_content_textarea_two', array(
		'default'			=> esc_html__( 'Place your content here', 'skywp' ),
		'transport'			=> 'postMessage',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_topbar_content_textarea_two', array(
		'label'			=> esc_html__( 'Second Content Area', 'skywp' ),
		'type'			=> 'textarea',
		'section'		=> 'sky_topbar_content',
		'settings'		=> 'sky_topbar_content_textarea_two',
		'priority'		=> 10,
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_topbar_content_two', true );
    	},
	) ) );










}



