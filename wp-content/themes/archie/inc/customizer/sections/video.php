<?php
/**
 * Video Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add Video section
$wp_customize->add_section( 'archie_video_section', array(
	'title'             => esc_html__( 'Video','archie' ),
	'description'       => esc_html__( 'Video Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// Video content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[video_section_enable]', array(
	'default'			=> 	$options['video_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[video_section_enable]', array(
	'label'             => esc_html__( 'Video Section Enable', 'archie' ),
	'section'           => 'archie_video_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// video title setting and control
$wp_customize->add_setting( 'archie_theme_options[video_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['video_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'archie_theme_options[video_title]', array(
	'label'           	=> esc_html__( 'Title', 'archie' ),
	'section'        	=> 'archie_video_section',
	'active_callback' 	=> 'archie_is_video_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'archie_theme_options[video_title]', array(
		'selector'            => '#latest-video .wrapper .section-header h2.section-title',
		'settings'            => 'archie_theme_options[video_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'archie_video_title_partial',
    ) );
}

// video image setting and control.
$wp_customize->add_setting( 'archie_theme_options[video_image]', array(
	'sanitize_callback' => 'archie_sanitize_image',
	'default' 			=> $options['video_image'],
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'archie_theme_options[video_image]',
		array(
		'label'       		=> esc_html__( 'Background Image', 'archie' ),
		'description' 		=> sprintf( esc_html__( 'Recommended size: %1$dpx x %2$dpx ', 'archie' ), 1920, 1000 ),
		'section'     		=> 'archie_video_section',
		'active_callback'	=> 'archie_is_video_section_enable',
) ) );

// video url setting and control
$wp_customize->add_setting( 'archie_theme_options[video_section_url]', array(
	'sanitize_callback' => 'esc_url_raw',
	'default' 			=> $options['video_section_url'],
) );

$wp_customize->add_control( 'archie_theme_options[video_section_url]', array(
	'label'           	=> esc_html__( 'Featured Video URL', 'archie' ),
	'description'       => esc_html__( 'Note: Input video url from youtube or media library.', 'archie' ),
	'section'        	=> 'archie_video_section',
	'active_callback' 	=> 'archie_is_video_section_enable',
	'type'				=> 'url',
) );