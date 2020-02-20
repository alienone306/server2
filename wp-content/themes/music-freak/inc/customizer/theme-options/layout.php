<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'music_freak_layout', array(
	'title'               => esc_html__('Layout','music-freak'),
	'description'         => esc_html__( 'Layout section options.', 'music-freak' ),
	'panel'               => 'music_freak_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[site_layout]', array(
	'sanitize_callback'   => 'music_freak_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new Music_Freak_Custom_Radio_Image_Control ( $wp_customize, 'music_freak_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'music-freak' ),
	'section'             => 'music_freak_layout',
	'choices'			  => music_freak_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'music_freak_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Music_Freak_Custom_Radio_Image_Control ( $wp_customize, 'music_freak_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'music-freak' ),
	'section'             => 'music_freak_layout',
	'choices'			  => music_freak_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'music_freak_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Music_Freak_Custom_Radio_Image_Control ( $wp_customize, 'music_freak_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'music-freak' ),
	'section'             => 'music_freak_layout',
	'choices'			  => music_freak_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'music_freak_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Music_Freak_Custom_Radio_Image_Control( $wp_customize, 'music_freak_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'music-freak' ),
	'section'             => 'music_freak_layout',
	'choices'			  => music_freak_sidebar_position(),
) ) );