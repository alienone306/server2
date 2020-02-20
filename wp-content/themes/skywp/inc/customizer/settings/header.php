<?php
/**
* Header Customizer Options
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
* Customizer Header Options
*
* @since 1.0.0
*/
add_action( 'customize_register', 'skywp_customizer_header_options' );
function skywp_customizer_header_options( $wp_customize ) {

	/**
	 * Panel Header
	 */
	$wp_customize->add_panel( 'sky_header_panel', array(
		'title' 			=> esc_html__( 'Header', 'skywp' ),
		'priority' 			=> 22,
	) );

	/**
	 * Section Header General
	 */
	$wp_customize->add_section( 'sky_header_general', array(
		'title'				=> esc_html__( 'General', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_header_panel',
	) );

	/**
	 * Select header layout
	 */
	$wp_customize->add_setting( 'skywp_header_layout', array(
		'default'				=> 'standard',
		'sanitize_callback' 	=> 'skywp_radio_sanitization',
	) );

	$wp_customize->add_control( new SkyWP_Image_Radio_Button_Control( $wp_customize, 'skywp_header_layout', array(
		'label'					=> esc_html__('Select header layout', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'skywp_header_layout',
		'priority'				=> 10,
        'choices' => array(
			'standard' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/standard-menu.png',
				'name' => esc_html__( 'Standard Menu', 'skywp' ),
			),
			'centered' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/centered-menu.png',
				'name' => esc_html__( 'Centered Menu', 'skywp' ),
			),
			'left_aligned' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/left-aligned.png',
				'name' => esc_html__( 'Left Aligned Menu', 'skywp' ),
			),
			'standard_2' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/standard-menu-2.png',
				'name' => esc_html__( 'Standard Menu 2', 'skywp' ),
			),
			'banner' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/banner-menu.png',
				'name' => esc_html__( 'Banner Menu', 'skywp' ),
			),
		)
	) ) );

	/**
	 * Header Border Bottom
	 */
	$wp_customize->add_setting( 'sky_header_border_bottom', array(
		'default'				=> false,
		'sanitize_callback' 	=> 'skywp_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_border_bottom', array(
		'label'					=> esc_html__('Border bottom', 'skywp'),
		'type'					=> 'checkbox',
		'section'				=> 'sky_header_general',
		'settings'				=> 'sky_header_border_bottom',
		'priority'				=> 10,
	) ) );

	/**
	 * Sticky Header
	 */
	$wp_customize->add_setting( 'sky_header_sticky', array(
		'default'				=> false,
		'sanitize_callback' 	=> 'skywp_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_sticky', array(
		'label'					=> esc_html__('Sticky Header', 'skywp'),
		'type'					=> 'checkbox',
		'section'				=> 'sky_header_general',
		'settings'				=> 'sky_header_sticky',
		'priority'				=> 10,
	) ) );

	/**
	* Position
	*/
	$wp_customize->add_setting( 'skywp_header_position', array(
		'default'			=> 'relative',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_header_position', array(
		'label'				=> esc_html__( 'Position', 'skywp' ),
		'type'				=> 'select',
		'section'			=> 'sky_header_general',
		'settings'			=> 'skywp_header_position',
		'priority'			=> 10,
		'choices'			=> array(
			'relative'		=> esc_html__( 'Relative', 'skywp' ),
			'absolute'		=> esc_html__( 'Absolute', 'skywp' ),
		),
	) ) );

	/**
	 * Width
	 */
	$wp_customize->add_setting( 'header_width', array(
		'default'				=> '1200',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_width', array(
		'label'					=> esc_html__('Width (px):', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'header_width',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Offset Top
	 */
	$wp_customize->add_setting( 'sky_header_offset_top', array(
		'default'				=> '0',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_offset_top', array(
		'label'					=> esc_html__('Offset Top (Desktop):', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'sky_header_offset_top',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Offset Top Width 768 - 425
	 */
	$wp_customize->add_setting( 'skywp_header_offset_top_tablet', array(
		'default'				=> '0',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_header_offset_top_tablet', array(
		'label'					=> esc_html__('Offset Top (Tablet 768 - 425px):', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'skywp_header_offset_top_tablet',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Offset Top Width < 425
	 */
	$wp_customize->add_setting( 'skywp_header_offset_top_mobile', array(
		'default'				=> '0',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_header_offset_top_mobile', array(
		'label'					=> esc_html__('Offset Top (Mobile < 425px):', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'skywp_header_offset_top_mobile',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Links Color
	 */
	$wp_customize->add_setting( 'sky_header_text_color', array(
		'default' => '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_header_text_color', array(
		'label'				=> esc_html__( 'Links Color', 'skywp' ),
		'section'			=> 'sky_header_general',
		'settings'			=> 'sky_header_text_color',
		'priority'			=> 10,
	) ) );

	/**
	 * Backgtoung
	 */
	$wp_customize->add_setting( 'skywp_bg_header', array(
		'default'     => '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
		'transport' 			=> 'postMessage',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_bg_header', array(
		'label'     => __( 'Backgroung', 'skywp' ),
		'section'   => 'sky_header_general',
		'settings'  => 'skywp_bg_header',
		'priority'			=> 10,
	) ) );

	/**
	 * Backgtoung Sticky Header
	 */
	$wp_customize->add_setting( 'skywp_bg_sticky_header', array(
		'default'     => '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
		'transport' 			=> 'postMessage',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_bg_sticky_header', array(
		'label'     => __( 'Backgroung Sticky', 'skywp' ),
		'section'   => 'sky_header_general',
		'settings'  => 'skywp_bg_sticky_header',
		'priority'			=> 10,
		'active_callback'   => function(){
       		return get_theme_mod( 'sky_header_sticky', true );
   		},
	) ) );

	/**
	 * Links Effect
	 */
	$wp_customize->add_setting( 'skywp_header_links_effect', array(
		'default'				=> 'standard',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_header_links_effect', array(
		'label'					=> esc_html__('Links Effect', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'skywp_header_links_effect',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'standard'   => esc_html__( 'Color', 'skywp' ),
            'style-second'   => esc_html__( 'Border Bottom', 'skywp' ),
        )
	) ) );

	/**
	 * Font Size
	 */
	$wp_customize->add_setting( 'sky_header_font_size', array(
		'default'				=> '14',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_font_size', array(
		'label'					=> esc_html__('Font Size (px):', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'sky_header_font_size',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Font Weight
	 */
	$wp_customize->add_setting( 'sky_header_font_weight', array(
		'default'				=> '700',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_font_weight', array(
		'label'					=> esc_html__('Font Weight:', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'sky_header_font_weight',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            '400'   => __( '400', 'skywp' ),
            '500'  => __( '500', 'skywp' ),
            '600'  => __( '600', 'skywp' ),
            '700'  => __( '700', 'skywp' ),
            '800'  => __( '800', 'skywp' ),
            '900'  => __( '900', 'skywp' ),
        )
	) ) );

	/**
	 * Text Transform
	 */
	$wp_customize->add_setting( 'sky_header_text_transform', array(
		'default'				=> 'uppercase',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_text_transform', array(
		'label'					=> esc_html__('Text Transform:', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'sky_header_text_transform',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'uppercase'   => __( 'Uppercase', 'skywp' ),
            'lowercase'  => __( 'Lowercase', 'skywp' ),
            'capitalize'  => __( 'Capitalize', 'skywp' ),
            'none'  => __( 'None', 'skywp' ),
        )
	) ) );

	/**
	 * Letter Spacing
	 */
	$wp_customize->add_setting( 'sky_header_letter_spacing', array(
		'default'				=> '1',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_letter_spacing', array(
		'label'					=> esc_html__('Letter Spacing (px):', 'skywp'),
		'section'				=> 'sky_header_general',
		'settings'				=> 'sky_header_letter_spacing',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );





	/**
	 * Section Mobile Menu
	 */
	$wp_customize->add_section( 'sky_header_mobile_menu', array(
		'title'				=> esc_html__( 'Mobile Menu', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_header_panel',
	) );

	/**
	 * Position
	 */
	$wp_customize->add_setting( 'sky_header_position_mobile_menu', array(
		'default'				=> 'left',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_position_mobile_menu', array(
		'label'					=> esc_html__('Position', 'skywp'),
		'section'				=> 'sky_header_mobile_menu',
		'settings'				=> 'sky_header_position_mobile_menu',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'left'   => __( 'Left', 'skywp' ),
            'right'  => __( 'Right', 'skywp' ),
            'top'  => __( 'Top', 'skywp' ),
            'bottom'  => __( 'Bottom', 'skywp' ),
        )
	) ) );

	/**
	 * Effect opening submenus
	 */
	$wp_customize->add_setting( 'sky_header_opening_mobile_menu', array(
		'default'				=> 'overlap',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_header_opening_mobile_menu', array(
		'label'					=> esc_html__('Effect opening submenus', 'skywp'),
		'section'				=> 'sky_header_mobile_menu',
		'settings'				=> 'sky_header_opening_mobile_menu',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'overlap'   => __( 'Overlap levels', 'skywp' ),
            'expand'  => __( 'Expand levels', 'skywp' ),
            'none'  => __( 'Unfolded levels', 'skywp' ),
        )
	) ) );

	/**
	* Button Menu
	*/
	$wp_customize->add_setting( 'sky_header_button_color', array(
		'default'			=> '#212121',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_header_button_color', array(
		'label'				=> esc_html__( 'Button Menu', 'skywp' ),
		'section'			=> 'sky_header_mobile_menu',
		'settings'			=> 'sky_header_button_color',
		'priority'			=> 10,
	) ) );

	/**
	* Background
	*/
	$wp_customize->add_setting( 'sky_header_background_mobile', array(
		'default'			=> '#212121',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_header_background_mobile', array(
		'label'				=> esc_html__( 'Background', 'skywp' ),
		'section'			=> 'sky_header_mobile_menu',
		'settings'			=> 'sky_header_background_mobile',
		'priority'			=> 10,
	) ) );

	/**
	* Background :Hover
	*/
	$wp_customize->add_setting( 'sky_header_background_hover', array(
		'default'			=> '#484848',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_header_background_hover', array(
		'label'				=> esc_html__( 'Background :Hover', 'skywp' ),
		'section'			=> 'sky_header_mobile_menu',
		'settings'			=> 'sky_header_background_hover',
		'priority'			=> 10,
	) ) );

	/**
	* Border Color
	*/
	$wp_customize->add_setting( 'sky_header_border_mobile_color', array(
		'default'			=> '#484848',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_header_border_mobile_color', array(
		'label'				=> esc_html__( 'Border Color', 'skywp' ),
		'section'			=> 'sky_header_mobile_menu',
		'settings'			=> 'sky_header_border_mobile_color',
		'priority'			=> 10,
	) ) );

	/**
	* Color
	*/
	$wp_customize->add_setting( 'sky_header_mobile_color', array(
		'default'			=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_header_mobile_color', array(
		'label'				=> esc_html__( 'Color', 'skywp' ),
		'section'			=> 'sky_header_mobile_menu',
		'settings'			=> 'sky_header_mobile_color',
		'priority'			=> 10,
	) ) );

	/**
	* Color :Hover
	*/
	$wp_customize->add_setting( 'sky_header_color_hover', array(
		'default'			=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_header_color_hover', array(
		'label'				=> esc_html__( 'Color :Hover', 'skywp' ),
		'section'			=> 'sky_header_mobile_menu',
		'settings'			=> 'sky_header_color_hover',
		'priority'			=> 10,
	) ) );





	/**
	 * Section Search
	 */
	$wp_customize->add_section( 'skywp_header_search_menu', array(
		'title'				=> esc_html__( 'Search', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_header_panel',
	) );

	/**
	 * Show Search
	 */
	$wp_customize->add_setting( 'skywp_header_show_search', array(
		'default'				=> true,
		'sanitize_callback' 	=> 'skywp_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_header_show_search', array(
		'label'					=> esc_html__('Show Search', 'skywp'),
		'type'					=> 'checkbox',
		'section'				=> 'skywp_header_search_menu',
		'settings'				=> 'skywp_header_show_search',
		'priority'				=> 10,
	) ) );

	/**
	 * Search Style
	 */
	$wp_customize->add_setting( 'skywp_header_search_menu_style', array(
		'default'				=> 'dropdown',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_header_search_menu_style', array(
		'label'					=> esc_html__('Search Style', 'skywp'),
		'section'				=> 'skywp_header_search_menu',
		'settings'				=> 'skywp_header_search_menu_style',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'dropdown'   => __( 'Dropdown', 'skywp' ),
        ),
        'active_callback'   => function(){
        	return get_theme_mod( 'skywp_header_show_search', true );
    	},
	) ) );














}