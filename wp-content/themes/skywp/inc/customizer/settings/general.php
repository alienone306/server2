<?php
/**
* General Customizer Options
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
add_action( 'customize_register', 'skywp_customizer_general_settings' );
function skywp_customizer_general_settings( $wp_customize ) {

	/**
	 * Panel General Settings
	 */
	$wp_customize->add_panel( 'sky_general_settings_panel', array(
		'title' 			=> esc_html__( 'General Settings', 'skywp' ),
		'priority' 			=> 23,
	) );

	/**
	 * Section General Styling
	 */
	$wp_customize->add_section( 'sky_general_settings_styling', array(
		'title'				=> esc_html__( 'General Styling', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_general_settings_panel',
	) );

	/**
	 * Width
	 */
	$wp_customize->add_setting( 'general_width', array(
		'default'				=> '1200',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'general_width', array(
		'label'					=> esc_html__('Width (px)', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'general_width',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Base color scheme
	 */
	$wp_customize->add_setting( 'skywp_color_scheme', array(
		'default'				=> 'scheme-light',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_color_scheme', array(
		'label'					=> esc_html__('Base Color Scheme', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_color_scheme',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'scheme-light'   => __( 'Light', 'skywp' ),
            'scheme-dark'  => __( 'Dark', 'skywp' ),
        )
	) ) );

	/**
	 * Outer background
	 */
	$wp_customize->add_setting( 'skywp_outer_bg', array(
		'default'				=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
		'transport' 			=> 'postMessage',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_outer_bg', array(
		'label'					=> esc_html__('Outer Background', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_outer_bg',
		'priority'				=> 10,
	) ) );

	/**
	 * Inner background
	 */
	$wp_customize->add_setting( 'skywp_inner_bg', array(
		'default'				=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
		'transport' 			=> 'postMessage',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_inner_bg', array(
		'label'					=> esc_html__('Inner Background', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_inner_bg',
		'priority'				=> 10,
	) ) );

	/**
	 * Default Color
	 */
	$wp_customize->add_setting( 'sky_default_color', array(
		'default'				=> '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_default_color', array(
		'label'					=> esc_html__('Default Color', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'sky_default_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Accent Color
	 */
	$wp_customize->add_setting( 'skywp_accent_color', array(
		'default'				=> '#00b4ff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'skywp_accent_color', array(
		'label'					=> esc_html__( 'Accent Color', 'skywp' ),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_accent_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Links color
	 */
	$wp_customize->add_setting( 'skywp_links_color', array(
		'default'				=> '#00b4ff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_links_color', array(
		'label'					=> esc_html__('Links Color', 'skywp'),
		'description'					=> esc_html__('This controller is responsible for the color of links in the body of the site, except for links in articles.', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_links_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Links Color: Hover
	 */
	$wp_customize->add_setting( 'sky_links_color_hover', array(
		'default'				=> '#0ba6e6',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_links_color_hover', array(
		'label'					=> esc_html__('Links Color: Hover', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'sky_links_color_hover',
		'priority'				=> 10,
	) ) );

	/**
	 * The color of the header on all pages
	 */
	$wp_customize->add_setting( 'skywp_color_header_all_pages', array(
		'default'				=> '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_color_header_all_pages', array(
		'label'					=> esc_html__('The color of the header on all pages', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_color_header_all_pages',
		'priority'				=> 10,
	) ) );



	/**
	 * Heading Input / Textarea
	 */
	$wp_customize->add_setting( 'skywp_input_heading', array(
		'sanitize_callback' 	=> 'wp_kses',
	) );

	$wp_customize->add_control( new SkyWP_Customizer_Heading_Control( $wp_customize, 'skywp_input_heading', array(
		'label'    				=> esc_html__( 'Input / Textarea', 'skywp' ),
		'section'  				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_input_heading',
		'priority' 				=> 10,
	) ) );

	/**
	 * Label color
	 */
	$wp_customize->add_setting( 'skywp_form_label_color', array(
		'default'				=> '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_form_label_color', array(
		'label'					=> esc_html__('Label Color', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_form_label_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Input, textarea color
	 */
	$wp_customize->add_setting( 'skywp_form_color', array(
		'default'				=> '#c7c7c7',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_form_color', array(
		'label'					=> esc_html__('Text Color', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_form_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Form Border color
	 */
	$wp_customize->add_setting( 'skywp_form_border_color', array(
		'default'				=> '#c7c7c7',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_form_border_color', array(
		'label'					=> esc_html__('Border Color', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_form_border_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Border Color: Focus
	 */
	$wp_customize->add_setting( 'sky_forms_border_color_focus', array(
		'default'				=> '#00b4ff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_forms_border_color_focus', array(
		'label'					=> esc_html__('Border Color: Focus', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'sky_forms_border_color_focus',
		'priority'				=> 10,
	) ) );

	/**
	 * Placeholder Color
	 */
	$wp_customize->add_setting( 'sky_forms_placeholder_color', array(
		'default'				=> '#c7c7c7',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_forms_placeholder_color', array(
		'label'					=> esc_html__('Placeholder Color', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'sky_forms_placeholder_color',
		'priority'				=> 10,
	) ) );



	/**
	 * Widgets
	 */
	$wp_customize->add_setting( 'skywp_widgets_heading', array(
		'sanitize_callback' 	=> 'wp_kses',
	) );

	$wp_customize->add_control( new SkyWP_Customizer_Heading_Control( $wp_customize, 'skywp_widgets_heading', array(
		'label'    				=> esc_html__( 'Widgets', 'skywp' ),
		'description'    				=> esc_html__( 'Widget settings in the right and left sidebars of the site.', 'skywp' ),
		'section'  				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_widgets_heading',
		'priority' 				=> 10,
	) ) );

	/**
	 * Title color
	 */
	$wp_customize->add_setting( 'skywp_widget_title_color', array(
		'default'				=> '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_widget_title_color', array(
		'label'					=> esc_html__('Title Color', 'skywp'),
		'section'				=> 'sky_general_settings_styling',
		'settings'				=> 'skywp_widget_title_color',
		'priority'				=> 10,
	) ) );





	/**
	 * Section Setting Button Scroll Top
	 */
	$wp_customize->add_section( 'sky_setting_scroll_top', array(
		'title'				=> esc_html__( 'Scroll To Top', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_general_settings_panel',
	) );

	/**
	 * Scroll Up Button
	 */
	$wp_customize->add_setting( 'sky_scroll_up_button', array(
		'default'				=> true,
		'sanitize_callback' 	=> 'skywp_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_scroll_up_button', array(
		'label'					=> esc_html__('Scroll Up Button', 'skywp'),
		'type'					=> 'checkbox',
		'section'				=> 'sky_setting_scroll_top',
		'settings'				=> 'sky_scroll_up_button',
		'priority'				=> 10,
	) ) );

	/**
	 * Backgtoung
	 */
	$wp_customize->add_setting( 'skywp_scroll_top_bg', array(
		'default'     => '#212121',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_scroll_top_bg', array(
		'label'     => __( 'Backgroung', 'skywp' ),
		'section'   => 'sky_setting_scroll_top',
		'settings'  => 'skywp_scroll_top_bg',
		'priority'			=> 10,
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_scroll_up_button', true );
    	},
	) ) );

	/**
	* Color
	*/
	$wp_customize->add_setting( 'sky_scroll_up_button_color', array(
		'default'			=> '#fff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_scroll_up_button_color', array(
		'label'				=> esc_html__( 'Color', 'skywp' ),
		'section'			=> 'sky_setting_scroll_top',
		'settings'			=> 'sky_scroll_up_button_color',
		'priority'			=> 10,
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_scroll_up_button', true );
    	},
	) ) );

	/**
	* Color :hover
	*/
	$wp_customize->add_setting( 'sky_scroll_up_button_color_hover', array(
		'default'			=> '#fff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_scroll_up_button_color_hover', array(
		'label'				=> esc_html__( 'Color :hover', 'skywp' ),
		'section'			=> 'sky_setting_scroll_top',
		'settings'			=> 'sky_scroll_up_button_color_hover',
		'priority'			=> 10,
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_scroll_up_button', true );
    	},
	) ) );

	/**
	 * Border Radius
	 */
	$wp_customize->add_setting( 'skywp_scroll_top_border_radius', array(
		'default'				=> '3',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_scroll_top_border_radius', array(
		'label'					=> esc_html__('Border Radius', 'skywp'),
		'section'				=> 'sky_setting_scroll_top',
		'settings'				=> 'skywp_scroll_top_border_radius',
		'priority'				=> 10,
		'type'           => 'number',
		'active_callback'   => function(){
        	return get_theme_mod( 'sky_scroll_up_button', true );
    	},
	) ) );





	/**
	 * Section Widget Tags Cloud
	 */
	$wp_customize->add_section( 'sky_widget_tags_cloud', array(
		'title'				=> esc_html__( 'Widget Tags Cloud', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_general_settings_panel',
	) );

	/**
	 * Letter Spacing
	 */
	$wp_customize->add_setting( 'sky_tag_letter_spacing', array(
		'default'				=> '1',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_tag_letter_spacing', array(
		'label'					=> esc_html__('Letter Spacing (px):', 'skywp'),
		'section'				=> 'sky_widget_tags_cloud',
		'settings'				=> 'sky_tag_letter_spacing',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Text Transform
	 */
	$wp_customize->add_setting( 'sky_tag_text_transform', array(
		'default'				=> 'capitalize',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_tag_text_transform', array(
		'label'					=> esc_html__('Text Transform:', 'skywp'),
		'section'				=> 'sky_widget_tags_cloud',
		'settings'				=> 'sky_tag_text_transform',
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
	 * Font Size
	 */
	$wp_customize->add_setting( 'sky_tag_font_size', array(
		'default'				=> '13',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_tag_font_size', array(
		'label'					=> esc_html__('Font Size (px):', 'skywp'),
		'section'				=> 'sky_widget_tags_cloud',
		'settings'				=> 'sky_tag_font_size',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Font Weight
	 */
	$wp_customize->add_setting( 'sky_tag_font_weight', array(
		'default'				=> '400',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_tag_font_weight', array(
		'label'					=> esc_html__('Font Weight:', 'skywp'),
		'section'				=> 'sky_widget_tags_cloud',
		'settings'				=> 'sky_tag_font_weight',
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
	 * Link Color
	 */
	$wp_customize->add_setting( 'sky_tag_link_color', array(
		'default'				=> '#919191',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_tag_link_color', array(
		'label'					=> esc_html__('Link Color', 'skywp'),
		'section'				=> 'sky_widget_tags_cloud',
		'settings'				=> 'sky_tag_link_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Link Color :Hover
	 */
	$wp_customize->add_setting( 'sky_tag_link_color_hover', array(
		'default'				=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_tag_link_color_hover', array(
		'label'					=> esc_html__('Link Color: Hover', 'skywp'),
		'section'				=> 'sky_widget_tags_cloud',
		'settings'				=> 'sky_tag_link_color_hover',
		'priority'				=> 10,
	) ) );

	/**
	 * Backgtoung
	 */
	$wp_customize->add_setting( 'sky_tag_bg_color', array(
		'default'     => 'rgba(255,255,255, 0)',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_tag_bg_color', array(
		'label'     => __( 'Backgroung', 'skywp' ),
		'section'   => 'sky_widget_tags_cloud',
		'settings'  => 'sky_tag_bg_color',
		'priority'			=> 10,
	) ) );

	/**
	 * Border Color
	 */
	$wp_customize->add_setting( 'sky_tag_border_color', array(
		'default'				=> '#c7c7c7',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_tag_border_color', array(
		'label'					=> esc_html__('Border Color', 'skywp'),
		'section'				=> 'sky_widget_tags_cloud',
		'settings'				=> 'sky_tag_border_color',
		'priority'				=> 10,
	) ) );





	/**
	 * Section Theme Buttons
	 */
	$wp_customize->add_section( 'sky_theme_buttons', array(
		'title'				=> esc_html__( 'Theme Buttons', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_general_settings_panel',
	) );

	/**
	 * Font Size
	 */
	$wp_customize->add_setting( 'sky_buttons_font_size', array(
		'default'				=> '14',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_buttons_font_size', array(
		'label'					=> esc_html__('Font Size (px):', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_font_size',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Font Weight
	 */
	$wp_customize->add_setting( 'sky_buttons_font_weight', array(
		'default'				=> '400',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_buttons_font_weight', array(
		'label'					=> esc_html__('Font Weight:', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_font_weight',
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
	$wp_customize->add_setting( 'sky_buttons_text_transform', array(
		'default'				=> 'uppercase',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_buttons_text_transform', array(
		'label'					=> esc_html__('Text Transform:', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_text_transform',
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
	 * Padding
	 */
	$wp_customize->add_setting( 'sky_theme_buttons_padding', array(
		'default'				=> '10px 25px 10px 25px',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_theme_buttons_padding', array(
		'label'					=> esc_html__('Padding (px):', 'skywp'),
		'description'			=> esc_html__( 'top right bottom left: 15px 25px 15px 25px', 'skywp' ),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_theme_buttons_padding',
		'priority'				=> 10,
		'type'           => 'text',
	) ) );

	/**
	 * Link Color
	 */
	$wp_customize->add_setting( 'sky_buttons_link_color', array(
		'default'				=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_buttons_link_color', array(
		'label'					=> esc_html__('Link Color', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_link_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Link Color :Hover
	 */
	$wp_customize->add_setting( 'sky_buttons_link_color_hover', array(
		'default'				=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_buttons_link_color_hover', array(
		'label'					=> esc_html__('Link Color: Hover', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_link_color_hover',
		'priority'				=> 10,
	) ) );

	/**
	 * Background Color
	 */
	$wp_customize->add_setting( 'sky_buttons_bg_color', array(
		'default'				=> '#00b4ff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_buttons_bg_color', array(
		'label'					=> esc_html__('Background Color', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_bg_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Background Color :Hover
	 */
	$wp_customize->add_setting( 'sky_buttons_bg_color_hover', array(
		'default'				=> '#0ba6e6',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_buttons_bg_color_hover', array(
		'label'					=> esc_html__('Background Color: Hover', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_bg_color_hover',
		'priority'				=> 10,
	) ) );

	/**
	 * Border Buttons
	 */
	$wp_customize->add_setting( 'sky_border_buttons', array(
		'default'				=> '0',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_border_buttons', array(
		'label'					=> esc_html__('Border (px):', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_border_buttons',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Border Color
	 */
	$wp_customize->add_setting( 'sky_border_buttons_color', array(
		'default'				=> '#00b4ff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_border_buttons_color', array(
		'label'					=> esc_html__('Border Color', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_border_buttons_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Border Color :Hover
	 */
	$wp_customize->add_setting( 'sky_border_buttons_color_hover', array(
		'default'				=> '#00b4ff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_border_buttons_color_hover', array(
		'label'					=> esc_html__('Border Color: Hover', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_border_buttons_color_hover',
		'priority'				=> 10,
	) ) );

	/**
	 * Border Radius 
	 */
	$wp_customize->add_setting( 'sky_border_buttons_radius', array(
		'default'				=> '0',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_border_buttons_radius', array(
		'label'					=> esc_html__('Border Radius (px):', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_border_buttons_radius',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Letter spacing
	 */
	$wp_customize->add_setting( 'sky_buttons_letter_spacing', array(
		'default'				=> '0.5',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_buttons_letter_spacing', array(
		'label'					=> esc_html__('Letter Spacing (px):', 'skywp'),
		'section'				=> 'sky_theme_buttons',
		'settings'				=> 'sky_buttons_letter_spacing',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );





	/**
	 * Section Subheader
	 */
	$wp_customize->add_section( 'sky_subheader_page', array(
		'title'				=> esc_html__( 'Subheader', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_general_settings_panel',
	) );

	/**
	 * Background Color
	 */
	$wp_customize->add_setting( 'sky_subheader_bg_color', array(
		'default'				=> '#fafafa',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_subheader_bg_color', array(
		'label'					=> esc_html__('Background', 'skywp'),
		'section'				=> 'sky_subheader_page',
		'settings'				=> 'sky_subheader_bg_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Padding
	 */
	$wp_customize->add_setting( 'sky_subheader_padding', array(
		'default'				=> '30px 0px 30px 0px',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_subheader_padding', array(
		'label'					=> esc_html__('Padding (px):', 'skywp'),
		'description'			=> esc_html__( 'top right bottom left: 30px 0px 30px 0px', 'skywp' ),
		'section'				=> 'sky_subheader_page',
		'settings'				=> 'sky_subheader_padding',
		'priority'				=> 10,
		'type'           => 'text',
	) ) );

	/**
	 * Color
	 */
	$wp_customize->add_setting( 'sky_subheader_color', array(
		'default'				=> '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_subheader_color', array(
		'label'					=> esc_html__('Color', 'skywp'),
		'section'				=> 'sky_subheader_page',
		'settings'				=> 'sky_subheader_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Font Weight
	 */
	$wp_customize->add_setting( 'sky_subheader_font_weight', array(
		'default'				=> '400',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_subheader_font_weight', array(
		'label'					=> esc_html__('Font Weight:', 'skywp'),
		'section'				=> 'sky_subheader_page',
		'settings'				=> 'sky_subheader_font_weight',
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
	$wp_customize->add_setting( 'sky_subheader_text_transform', array(
		'default'				=> 'capitalize',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_subheader_text_transform', array(
		'label'					=> esc_html__('Text Transform:', 'skywp'),
		'section'				=> 'sky_subheader_page',
		'settings'				=> 'sky_subheader_text_transform',
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
	 * Letter spacing
	 */
	$wp_customize->add_setting( 'sky_subheader_letter_spacing', array(
		'default'				=> '0',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_subheader_letter_spacing', array(
		'label'					=> esc_html__('Letter Spacing (px):', 'skywp'),
		'section'				=> 'sky_subheader_page',
		'settings'				=> 'sky_subheader_letter_spacing',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );




	






}