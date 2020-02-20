<?php
/**
 * Client Section options
 *
 * @package Theme Palace
 * @subpackage Archie
 * @since Archie 1.0.0
 */

// Add Client section
$wp_customize->add_section( 'archie_client_section', array(
	'title'             => esc_html__( 'Client','archie' ),
	'description'       => esc_html__( 'Client Section options.', 'archie' ),
	'panel'             => 'archie_front_page_panel',
) );

// Client content enable control and setting
$wp_customize->add_setting( 'archie_theme_options[client_section_enable]', array(
	'default'			=> 	$options['client_section_enable'],
	'sanitize_callback' => 'archie_sanitize_switch_control',
) );

$wp_customize->add_control( new Archie_Pro_Switch_Control( $wp_customize, 'archie_theme_options[client_section_enable]', array(
	'label'             => esc_html__( 'Client Section Enable', 'archie' ),
	'section'           => 'archie_client_section',
	'on_off_label' 		=> archie_switch_options(),
) ) );

for ( $i = 1; $i <= 4; $i++ ) :
	// client pages drop down chooser control and setting
	$wp_customize->add_setting( 'archie_theme_options[client_content_page_' . $i . ']', array(
		'sanitize_callback' => 'archie_sanitize_page',
	) );

	$wp_customize->add_control( new Archie_Pro_Dropdown_Chooser( $wp_customize, 'archie_theme_options[client_content_page_' . $i . ']', array(
		'label'             => sprintf( esc_html__( 'Select Page %d', 'archie' ), $i ),
		'section'           => 'archie_client_section',
		'choices'			=> archie_page_choices(),
		'active_callback'	=> 'archie_is_client_section_enable',
	) ) );
endfor;

