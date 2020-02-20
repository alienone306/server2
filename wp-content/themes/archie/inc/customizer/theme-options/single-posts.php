<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'archie_single_post_section', array(
	'title'             => esc_html__( 'Single Post','archie' ),
	'description'       => esc_html__( 'Options to change the single posts globally.', 'archie' ),
	'panel'             => 'archie_theme_options_panel',
) );

// Archieve date meta setting and control.
$wp_customize->add_setting( 'archie_theme_options[single_post_hide_date]', array(
	'default'           => $options['single_post_hide_date'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[single_post_hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'archie' ),
	'section'           => 'archie_single_post_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );

// Archieve author meta setting and control.
$wp_customize->add_setting( 'archie_theme_options[single_post_hide_author]', array(
	'default'           => $options['single_post_hide_author'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[single_post_hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'archie' ),
	'section'           => 'archie_single_post_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );

// Archieve author category setting and control.
$wp_customize->add_setting( 'archie_theme_options[single_post_hide_category]', array(
	'default'           => $options['single_post_hide_category'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[single_post_hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'archie' ),
	'section'           => 'archie_single_post_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );

// Archieve tag category setting and control.
$wp_customize->add_setting( 'archie_theme_options[single_post_hide_tags]', array(
	'default'           => $options['single_post_hide_tags'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[single_post_hide_tags]', array(
	'label'             => esc_html__( 'Hide Tag', 'archie' ),
	'section'           => 'archie_single_post_section',
	'on_off_label' 		=> archie_hide_options(),
) ) );
