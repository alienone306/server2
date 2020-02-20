<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

$wp_customize->add_section( 'archie_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','archie' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'archie' ),
	'panel'             => 'archie_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'archie_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'archie_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'archie' ),
	'section'          	=> 'archie_breadcrumb',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'archie_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'archie_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'archie' ),
	'active_callback' 	=> 'archie_is_breadcrumb_enable',
	'section'          	=> 'archie_breadcrumb',
) );
