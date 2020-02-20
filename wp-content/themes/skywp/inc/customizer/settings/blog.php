<?php
/**
* Blog Customizer Options
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
add_action( 'customize_register', 'skywp_customizer_blog_settings' );
function skywp_customizer_blog_settings( $wp_customize ) {

	/**
	 * Panel Blog Settings
	 */
	$wp_customize->add_panel( 'sky_blog_settings_panel', array(
		'title' 			=> esc_html__( 'Blog', 'skywp' ),
		'priority' 			=> 24,
	) );




	/**
	 * Section Blog Settings
	 */
	$wp_customize->add_section( 'sky_post_style_page_category', array(
		'title'				=> esc_html__( 'Post output page', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_blog_settings_panel',
	) );

	/**
	 * Header
	 */
	$wp_customize->add_setting( 'skywp_blog_heading_1', array(
		'sanitize_callback' 	=> 'wp_kses',
	) );

	$wp_customize->add_control( new SkyWP_Customizer_Heading_Control( $wp_customize, 'skywp_blog_heading_1', array(
		'label'    				=> esc_html__( 'Post Display Style', 'skywp' ),
		'section'  				=> 'sky_post_style_page_category',
		'settings'				=> 'skywp_blog_heading_1',
		'priority' 				=> 10,
	) ) );

	/**
	 * Post Style
	 */
	$wp_customize->add_setting( 'skywp_post_style', array(
		'default'				=> 'default',
		'sanitize_callback' 	=> 'skywp_radio_sanitization',
	) );

	$wp_customize->add_control( new SkyWP_Image_Radio_Button_Control( $wp_customize, 'skywp_post_style', array(
		'label'					=> esc_html__('Post Style', 'skywp'),
		'section'				=> 'sky_post_style_page_category',
		'settings'				=> 'skywp_post_style',
		'priority'				=> 10,
        'choices' => array(
			'default' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/blog-default.png',
				'name' => esc_html__( 'Default', 'skywp' ),
			),
			'masonry' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/blog-masonry.png',
				'name' => esc_html__( 'Masonry', 'skywp' ),
			),
		)
	) ) );

	/**
	 * Number Of Columns
	 */
	$wp_customize->add_setting( 'skywp_post_number_columns', array(
		'default'				=> 'one',
		'sanitize_callback' 	=> 'skywp_radio_sanitization',
	) );

	$wp_customize->add_control( new SkyWP_Image_Radio_Button_Control( $wp_customize, 'skywp_post_number_columns', array(
		'label'					=> esc_html__('Number Of Columns', 'skywp'),
		'section'				=> 'sky_post_style_page_category',
		'settings'				=> 'skywp_post_number_columns',
		'priority'				=> 10,
        'choices' => array(
			'one' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/one-column.png',
				'name' => esc_html__( 'One', 'skywp' ),
			),
			'two' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/two-column.png',
				'name' => esc_html__( 'Two', 'skywp' ),
			),
			'three' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/three-column.png',
				'name' => esc_html__( 'Three', 'skywp' ),
			),
		)
	) ) );

	/**
	 * Background prev / next
	 */
	$wp_customize->add_setting( 'skywp_article_page_bg_prev_next', array(
		'default'				=> '#fafafa',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'skywp_article_page_bg_prev_next', array(
		'label'					=> esc_html__('Background prev / next posts', 'skywp'),
		'section'				=> 'sky_post_style_page_category',
		'settings'				=> 'skywp_article_page_bg_prev_next',
		'priority'				=> 10,
	) ) );



	/**
	 * Header
	 */
	$wp_customize->add_setting( 'skywp_blog_heading_2', array(
		'sanitize_callback' 	=> 'wp_kses',
	) );

	$wp_customize->add_control( new SkyWP_Customizer_Heading_Control( $wp_customize, 'skywp_blog_heading_2', array(
		'label'    				=> esc_html__( 'These settings apply to the blog page', 'skywp' ),
		'section'  				=> 'sky_post_style_page_category',
		'settings'				=> 'skywp_blog_heading_2',
		'priority' 				=> 10,
	) ) );

	/**
	 * Background
	 */
	$wp_customize->add_setting( 'sky_post_bg', array(
		'default'				=> '#fafafa',
		'transport'				=> 'postMessage',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_post_bg', array(
		'label'					=> esc_html__('Background', 'skywp'),
		'section'				=> 'sky_post_style_page_category',
		'settings'				=> 'sky_post_bg',
		'priority'				=> 10,
	) ) );

	/**
	 * Title Color
	 */
	$wp_customize->add_setting( 'sky_post_title_color', array(
		'default'				=> '#333333',
		'transport'				=> 'postMessage',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_post_title_color', array(
		'label'					=> esc_html__('Title Color', 'skywp'),
		'section'				=> 'sky_post_style_page_category',
		'settings'				=> 'sky_post_title_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Meta Color
	 */
	$wp_customize->add_setting( 'sky_post_meta_color', array(
		'default'				=> '#555555',
		'transport'				=> 'postMessage',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_post_meta_color', array(
		'label'					=> esc_html__('Meta Color', 'skywp'),
		'section'				=> 'sky_post_style_page_category',
		'settings'				=> 'sky_post_meta_color',
		'priority'				=> 10,
	) ) );



	/**
	 * Header
	 */
	$wp_customize->add_setting( 'skywp_blog_heading_3', array(
		'sanitize_callback' 	=> 'wp_kses',
	) );

	$wp_customize->add_control( new SkyWP_Customizer_Heading_Control( $wp_customize, 'skywp_blog_heading_3', array(
		'label'    				=> esc_html__( 'Article page', 'skywp' ),
		'section'  				=> 'sky_post_style_page_category',
		'settings'				=> 'skywp_blog_heading_3',
		'priority' 				=> 10,
	) ) );

	/**
	 * Meta color
	 */
	$wp_customize->add_setting( 'sky_article_page', array(
		'default'				=> '#333333',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_article_page', array(
		'label'					=> esc_html__('Meta Color', 'skywp'),
		'section'				=> 'sky_post_style_page_category',
		'settings'				=> 'sky_article_page',
		'priority'				=> 10,
	) ) );

	





	/**
	 * Section Pagination
	 */
	$wp_customize->add_section( 'sky_pagination', array(
		'title'				=> esc_html__( 'Pagination', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_blog_settings_panel',
	) );

	/**
	 * Align
	 */
	$wp_customize->add_setting( 'sky_pagination_align', array(
		'default'				=> 'center',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_pagination_align', array(
		'label'					=> esc_html__('Align:', 'skywp'),
		'section'				=> 'sky_pagination',
		'settings'				=> 'sky_pagination_align',
		'priority'				=> 10,
		'type'           => 'select',
        'choices'        => array(
            'center'   => esc_html__( 'Center', 'skywp' ),
            'left'  => esc_html__( 'Left', 'skywp' ),
            'right'  => esc_html__( 'Right', 'skywp' ),
        )
	) ) );

	/**
	 * Border Color
	 */
	$wp_customize->add_setting( 'sky_pagination_border_color', array(
		'default'				=> '#9a9393',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_pagination_border_color', array(
		'label'					=> esc_html__('Border Color', 'skywp'),
		'section'				=> 'sky_pagination',
		'settings'				=> 'sky_pagination_border_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Color
	 */
	$wp_customize->add_setting( 'sky_pagination_color', array(
		'default'				=> '#9a9393',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_pagination_color', array(
		'label'					=> esc_html__('Color', 'skywp'),
		'section'				=> 'sky_pagination',
		'settings'				=> 'sky_pagination_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Border Radius
	 */
	$wp_customize->add_setting( 'sky_pagination_border_radius', array(
		'default'				=> '3',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sky_pagination_border_radius', array(
		'label'					=> esc_html__('Border Radius (px):', 'skywp'),
		'section'				=> 'sky_pagination',
		'settings'				=> 'sky_pagination_border_radius',
		'priority'				=> 10,
		'type'           => 'text',
	) ) );

	

	





	






}