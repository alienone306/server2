<?php
/**
 * Excerpt options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add excerpt section
$wp_customize->add_section( 'music_freak_single_post_section', array(
	'title'             => esc_html__( 'Single Post','music-freak' ),
	'description'       => esc_html__( 'Options to change the single posts globally.', 'music-freak' ),
	'panel'             => 'music_freak_theme_options_panel',
) );

// Archive date meta setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[single_post_hide_date]', array(
	'default'           => $options['single_post_hide_date'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[single_post_hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'music-freak' ),
	'section'           => 'music_freak_single_post_section',
	'on_off_label' 		=> music_freak_hide_options(),
) ) );

// Archive author meta setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[single_post_hide_author]', array(
	'default'           => $options['single_post_hide_author'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[single_post_hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'music-freak' ),
	'section'           => 'music_freak_single_post_section',
	'on_off_label' 		=> music_freak_hide_options(),
) ) );

// Archive author category setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[single_post_hide_category]', array(
	'default'           => $options['single_post_hide_category'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[single_post_hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'music-freak' ),
	'section'           => 'music_freak_single_post_section',
	'on_off_label' 		=> music_freak_hide_options(),
) ) );

// Archive tag category setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[single_post_hide_tags]', array(
	'default'           => $options['single_post_hide_tags'],
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[single_post_hide_tags]', array(
	'label'             => esc_html__( 'Hide Tag', 'music-freak' ),
	'section'           => 'music_freak_single_post_section',
	'on_off_label' 		=> music_freak_hide_options(),
) ) );
