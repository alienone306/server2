<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'archie_layout', array(
	'title'               => esc_html__('Layout','archie'),
	'description'         => esc_html__( 'Layout section options.', 'archie' ),
	'panel'               => 'archie_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'archie_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'archie_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Archie_Pro_Custom_Radio_Image_Control ( $wp_customize, 'archie_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'archie' ),
	'section'             => 'archie_layout',
	'choices'			  => archie_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'archie_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'archie_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Archie_Pro_Custom_Radio_Image_Control ( $wp_customize, 'archie_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'archie' ),
	'section'             => 'archie_layout',
	'choices'			  => archie_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'archie_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'archie_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Archie_Pro_Custom_Radio_Image_Control( $wp_customize, 'archie_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'archie' ),
	'section'             => 'archie_layout',
	'choices'			  => archie_sidebar_position(),
) ) );