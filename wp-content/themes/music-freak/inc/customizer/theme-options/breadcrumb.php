<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

$wp_customize->add_section( 'music_freak_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','music-freak' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'music-freak' ),
	'panel'             => 'music_freak_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'music-freak' ),
	'section'          	=> 'music_freak_breadcrumb',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'music_freak_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'music-freak' ),
	'active_callback' 	=> 'music_freak_is_breadcrumb_enable',
	'section'          	=> 'music_freak_breadcrumb',
) );
