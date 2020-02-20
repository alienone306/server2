<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Music Freak
 * @since Music Freak 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'music_freak_pagination', array(
	'title'               => esc_html__('Pagination','music-freak'),
	'description'         => esc_html__( 'Pagination section options.', 'music-freak' ),
	'panel'               => 'music_freak_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'music_freak_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Music_Freak_Switch_Control( $wp_customize, 'music_freak_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'music-freak' ),
	'section'             => 'music_freak_pagination',
	'on_off_label' 		=> music_freak_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'music_freak_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'music_freak_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'music_freak_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'music-freak' ),
	'section'             => 'music_freak_pagination',
	'type'                => 'select',
	'choices'			  => music_freak_pagination_options(),
	'active_callback'	  => 'music_freak_is_pagination_enable',
) );
