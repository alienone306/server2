<?php
/**
* Footer Customizer Options
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
add_action( 'customize_register', 'skywp_customizer_footer_settings' );
function skywp_customizer_footer_settings( $wp_customize ) {

	/**
	 * Panel Footer
	 */
	$wp_customize->add_panel( 'sky_footer_panel', array(
		'title' 			=> esc_html__( 'Footer', 'skywp' ),
		'priority' 			=> 25,
	) );





	/**
	 * Footer Buttom Setting
	 */
	$wp_customize->add_section( 'sky_footer_bottom', array(
		'title'				=> esc_html__( 'Footer Bottom', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_footer_panel',
	) );

	/**
	 * Layout
	 */
	$wp_customize->add_setting( 'sky_footer_layout', array(
		'default'				=> '4_25',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );

	$wp_customize->add_control( new SkyWP_Image_Radio_Button_Control( $wp_customize, 'sky_footer_layout', array(
		'label'					=> esc_html__('Footer layout', 'skywp'),
		'section'				=> 'sky_footer_bottom',
		'settings'				=> 'sky_footer_layout',
		'priority'				=> 10,
        'choices' => array(
			'4_25' => array(
				'image' => SKYWP_THEME_URI . '/inc/customizer/assets/image/footer-standard.png',
				'name' => esc_html__( 'Standard Footer', 'skywp' ),
			),
		)
	) ) );

	/**
	 * Width
	 */
	$wp_customize->add_setting( 'footer_width', array(
		'default'				=> '1200',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_width', array(
		'label'					=> esc_html__('Width (px):', 'skywp'),
		'section'				=> 'sky_footer_bottom',
		'settings'				=> 'footer_width',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Padding
	 */
	$wp_customize->add_setting( 'skywp_footer_padding', array(
		'default'				=> '85px 0px 85px 0px',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_footer_padding', array(
		'label'					=> esc_html__('Padding (px):', 'skywp'),
		'section'				=> 'sky_footer_bottom',
		'settings'				=> 'skywp_footer_padding',
		'priority'				=> 10,
		'type'           => 'text',
	) ) );

	/**
	 * Background
	 */
	$wp_customize->add_setting( 'sky_footer_bg', array(
		'default'				=> '#212121',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new SkyWP_Customize_Color_Control( $wp_customize, 'sky_footer_bg', array(
		'label'					=> esc_html__('Background', 'skywp'),
		'section'				=> 'sky_footer_bottom',
		'settings'				=> 'sky_footer_bg',
		'priority'				=> 10,
	) ) );

	/**
	 * Title Color
	 */
	$wp_customize->add_setting( 'sky_footer_title_color', array(
		'default'				=> '#ffffff',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_footer_title_color', array(
		'label'					=> esc_html__('Title Color', 'skywp'),
		'section'				=> 'sky_footer_bottom',
		'settings'				=> 'sky_footer_title_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Border Color
	 */
	$wp_customize->add_setting( 'sky_footer_border_color', array(
		'default'				=> '#c7c7c7',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_footer_border_color', array(
		'label'					=> esc_html__('Border Color', 'skywp'),
		'section'				=> 'sky_footer_bottom',
		'settings'				=> 'sky_footer_border_color',
		'priority'				=> 10,
	) ) );

	/**
	 * Text Color
	 */
	$wp_customize->add_setting( 'sky_footer_text_color', array(
		'default'				=> '#c7c7c7',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_footer_text_color', array(
		'label'					=> esc_html__('Text Color', 'skywp'),
		'section'				=> 'sky_footer_bottom',
		'settings'				=> 'sky_footer_text_color',
		'priority'				=> 10,
	) ) );




	/**
	 * Section Copyright
	 */
	$wp_customize->add_section( 'sky_footer_copyright', array(
		'title'				=> esc_html__( 'Copyright', 'skywp' ),
		'priority'			=> 10,
		'panel'				=> 'sky_footer_panel',
	) );

	/**
	* Alignment
	*/
	$wp_customize->add_setting( 'skywp_copyright_alignment', array(
		'default'			=> 'center',
		'sanitize_callback' 	=> 'skywp_sanitize_select',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_copyright_alignment', array(
		'label'				=> esc_html__( 'Alignment', 'skywp' ),
		'type'				=> 'select',
		'section'			=> 'sky_footer_copyright',
		'settings'			=> 'skywp_copyright_alignment',
		'priority'			=> 10,
		'choices'			=> array(
			'center'		=> esc_html__( 'Center', 'skywp' ),
			'flex-start'		=> esc_html__( 'Left', 'skywp' ),
			'flex-end'		=> esc_html__( 'Right', 'skywp' ),
			'space-between'		=> esc_html__( 'Space Between', 'skywp' ),
			'space-around'		=> esc_html__( 'Space Around', 'skywp' ),
			'space-evenly'		=> esc_html__( 'Space Evenly', 'skywp' ),
		),
	) ) );

	/**
	 * Width
	 */
	$wp_customize->add_setting( 'footer_copyright_width', array(
		'default'				=> '1200',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_copyright_width', array(
		'label'					=> esc_html__('Width (px):', 'skywp'),
		'section'				=> 'sky_footer_copyright',
		'settings'				=> 'footer_copyright_width',
		'priority'				=> 10,
		'type'           => 'number',
	) ) );

	/**
	 * Padding
	 */
	$wp_customize->add_setting( 'skywp_footer_padding_copyright', array(
		'default'				=> '25px 0px 25px 0px',
		'sanitize_callback' 	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'skywp_footer_padding_copyright', array(
		'label'					=> esc_html__('Padding (px):', 'skywp'),
		'section'				=> 'sky_footer_copyright',
		'settings'				=> 'skywp_footer_padding_copyright',
		'priority'				=> 10,
		'type'           => 'text',
	) ) );

	/**
	 * Background
	 */
	$wp_customize->add_setting( 'sky_copyright_bg', array(
		'default'				=> '#191c1e',
		'sanitize_callback' 	=> 'skywp_sanitize_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sky_copyright_bg', array(
		'label'					=> esc_html__('Background', 'skywp'),
		'section'				=> 'sky_footer_copyright',
		'settings'				=> 'sky_copyright_bg',
		'priority'				=> 10,
	) ) );

	


}