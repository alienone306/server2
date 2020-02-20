<?php
/**
 * Archieve options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'archie_archive_section', array(
	'title'             => esc_html__( 'Blog/Archieve','archie' ),
	'description'       => esc_html__( 'Archieve section options.', 'archie' ),
	'panel'             => 'archie_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'archie_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'archie_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'archie' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'archie' ),
	'section'           => 'archie_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'archie_is_latest_posts'
) );

// Archieve date meta setting and control.
$wp_customize->add_setting( 'archie_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'archie' ),
	'section'           => 'archie_archive_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );

// Archieve category setting and control.
$wp_customize->add_setting( 'archie_theme_options[hide_category]', array(
	'default'           => $options['hide_category'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'archie' ),
	'section'           => 'archie_archive_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );

// Archieve author setting and control.
$wp_customize->add_setting( 'archie_theme_options[hide_author]', array(
	'default'           => $options['hide_author'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'archie' ),
	'section'           => 'archie_archive_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );

// Archieve comment setting and control.
$wp_customize->add_setting( 'archie_theme_options[hide_comment]', array(
	'default'           => $options['hide_comment'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[hide_comment]', array(
	'label'             => esc_html__( 'Hide Comment', 'archie' ),
	'section'           => 'archie_archive_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );
