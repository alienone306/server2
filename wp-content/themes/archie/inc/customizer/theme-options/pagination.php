<?php
/**
 * pagination options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'archie_pagination', array(
	'title'               => esc_html__('Pagination','archie'),
	'description'         => esc_html__( 'Pagination section options.', 'archie' ),
	'panel'               => 'archie_theme_options_panel',
) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'archie_theme_options[pagination_enable]', array(
	'sanitize_callback' => 'archie_sanitize_switch_control',
	'default'             => $options['pagination_enable'],
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[pagination_enable]', array(
	'label'               => esc_html__( 'Pagination Enable', 'archie' ),
	'section'             => 'archie_pagination',
	'on_off_label' 		=> archie_switch_options(),
) ) );

// Site layout setting and control.
$wp_customize->add_setting( 'archie_theme_options[pagination_type]', array(
	'sanitize_callback'   => 'archie_sanitize_select',
	'default'             => $options['pagination_type'],
) );

$wp_customize->add_control( 'archie_theme_options[pagination_type]', array(
	'label'               => esc_html__( 'Pagination Type', 'archie' ),
	'section'             => 'archie_pagination',
	'type'                => 'select',
	'choices'			  => archie_pagination_options(),
	'active_callback'	  => 'archie_is_pagination_enable',
) );
